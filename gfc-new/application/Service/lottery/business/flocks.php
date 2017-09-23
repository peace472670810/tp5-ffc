<?php
/**
 * Created by PhpStorm.
 * User: Jim FAN
 * Date: 2017/8/4
 * 封锁值 下注时采用
 * Time: 21:05
 */

namespace app\Service\lottery\business;
use app\Service\lottery\model\Locks;
use app\Service\lottery\business\methods;
use think\image\Exception;
use think\Log;

class flocks
{
    public  static  $error_code = [
        '5000000001' => '下注玩法参数有误！',
    ];
    public $model = null;
    public  $methods_model = null;
    public function __construct()
    {
        $this->model = new Locks();
        $this->methods_model = new methods();
    }

    /**
     * 获取玩法下的封锁值
     * 获取玩法所有奖金
     *  list f_lid f_issue  f_mid f_code   f_amount(最大中奖金额)
     *  mids  玩法id
     *  lid
     * issue
     */
    public function checkLocks($arr = []){
        try{
            $list = $arr['list'];
            $lid = $arr['lid'];
            $issue = $arr['issue'];
            $mids = $arr['mids'];
            if(is_array($arr)){
                //1.去封锁表里面读取封锁值 封锁值为0 的直接不进行验证
                $flcoks = $this->methods_model->getLockmethodsPrize(['mids'=>$mids]);
                //过滤掉封锁值为0的 并赋值封锁值和该注下注内容给$noList
                $noList = [];
                $noList1 = [];
                foreach ($flcoks as $k=>$val){
                    foreach ($list as $value){
                        if(($val['m_id'] == $value['f_mid'])){
                            $noList1[$k] = $value;
                            if($value['f_amount']>$val['m_flock'] && $val['m_flock'] >0){
                                return  put_encode(false,'5000000002','尊敬的客户：以下投注号码在本期已经达到购买上限，请剔除这些号码！<br/>'.$value['f_code']);
                            }
                            $noList[$k] = array_merge($value,['flock'=>$val['m_flock']]);
                        }
                    }
                }
                //2.获取当期对应玩法的已下注最大中奖金额 + 该注下注最大中奖金额 > 封锁值  则提示下注不能成功  并返回超过封锁值的下注号码
                //  获取当前下注内容最大获奖金额就超过封锁值   则提示下注不能成功  并返回超过封锁值的下注号码
                $table = 'ffc_locks_'.$lid;
                $maxPrizes = $this->model->query(" select f_mid,sum(f_amount) as amount  from $table where f_mid in ({$mids}) and f_issue={$issue}  group BY  f_mid ");
                if(!empty($maxPrizes)){
                    foreach ($maxPrizes as $v){
                        foreach ($noList as $value){
                            if($v['f_mid'] == $value['f_mid']){
                                $amount = $v['amount'] + $value['f_amount'];
                                if( $value['f_amount'] > $value['flock']){
                                    return  put_encode(false,'5000000002','尊敬的客户：以下投注号码在本期已经达到购买上限，请剔除这些号码！<br/>'.$value['f_code']);
                                }
                                if($amount > $value['flock']){
                                    return  put_encode(false,'5000000002','尊敬的客户：以下投注号码在本期已经达到购买上限，请剔除这些号码！<br/>'.$value['f_code']);
                                }
                            }
                        }
                    }
                }
            }else{
                return  put_encode(false,'5000000001',self::$error_code['5000000001']);
            }
            //4.没超过封锁值就新增进封锁表里面
            if (!empty($noList1)){
                $this->model->table($table)->insertAll($noList1);
            }
            return put_encode(true,'','');
        }catch (Exception $e){
            return put_encode(false,$e->getCode(),$e->getMessage());
        }
    }

    /**
     * 封锁值添加
     *  f_issue  f_mid f_lid  ffc_code  ffc_amount
     */
    public function addLocks($data = []){

    }

}