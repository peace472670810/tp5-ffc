<?php
/**
 * Created by PhpStorm.
 * User: Jim FAN
 * Date: 2017/6/15
 * Time: 20:00
 */

namespace app\Service\lottery\business;
use app\Service\lottery\model\Prizes as prize_model;
use think\image\Exception;

class prizes
{
    public static $error_code = [
        '123000001'=>'参数不合法',
        '123000002'=>'操作失败',
        '123000003'=>'不存在改盘口',
    ];
    public  $PANKOU = ['a','b','c','d'];
    public  $prize_model = null;
    public function __construct()
    {
        $this->prize_model = new prize_model();
    }
    public function getPrizeList($data){

        if((!is_numeric($data['m_id'])||empty($data['m_id']))){
            return  put_encode(false,'123000001',self::$error_code['123000001']);
        }
        $list = $this->prize_model->getPrizeByMethod($data);
        return  put_encode($list,'','');
    }

    public function getPrizeByLid($data){

        if((!is_numeric($data['lid'])||empty($data['lid']))){
            return  put_encode(false,'123000001',self::$error_code['123000001']);
        }

        $list = $this->prize_model->getPrizeByLid($data);
        return  put_encode($list,'','');
    }
    /**
     * 前端下注根据玩法 盘口获取盘口赔率
     */
    public function getPrizeByOdd($data = []){
        $arr['p_m_id'] = $data['m_id'];
        $arr['odd'] = $data['odd'];
        if(!in_array($arr['odd'],$this->PANKOU)){
            return  put_encode(false,'123000003',self::$error_code['123000003']);
        }
        $res = $this->prize_model->getPrizesByOdd($arr);
        $list =  [];
        foreach ($res as $k=>$v){
            $list[$k]['level'] = $v['p_level'];
            $list[$k]['jiner'] = $v[$arr['odd']];
        }
        return put_encode($list,'','');
    }
    /**
     *  根据彩种id赔率设定列表
     */
    public function getLotteryRebate($data = []){
        if((!is_numeric($data['lid'])||empty($data['lid']))){
            return  put_encode(false,'123000001',self::$error_code['123000001']);
        }
        $list = $this->prize_model->getPrizeRebateByLid($data);
        return   put_encode($list,'','');
    }
    /**
     * 赔率修改
     */
    public function editLotteryRebate($data = []){

        /**
         * 解析传过来的参数
         */
        //p_id:313|a:1700.0000|b_step:0.0000|c_step:|d_step:
        $list = [];
        $prizes = explode('#',$data['prizeValue']);
        foreach ($prizes as $k=>$v){
            if(!empty($v)){
                $prize = [];
                $arr = explode('|',$v);
                foreach ($arr as $val){
                    $value = explode(':',$val);
                    $value[1] = empty($value[1])?0:$value[1];
                    $prize[$value[0]] = $value[1];
                }
                $list[] = $prize;
            }
        }
        foreach ($list as $k=>$v){
            if((!is_numeric($v['p_id'])||empty($v['p_id']))){
                return  put_encode(false,'123000001',self::$error_code['123000001']);
            }
            if(!is_numeric($v['a'])){
                return  put_encode(false,'123000001',self::$error_code['123000001']);
            }
            if(!is_numeric($v['b_step'])){
                return  put_encode(false,'123000001',self::$error_code['123000001']);
            }
            if(!is_numeric($v['c_step'])){
                return  put_encode(false,'123000001',self::$error_code['123000001']);
            }
            if(!is_numeric($v['d_step'])){
                return  put_encode(false,'123000001',self::$error_code['123000001']);
            }
            $a = round($v['a'],4);
            $b_step = round($v['b_step'],4);
            $c_step = round($v['c_step'],4);
            $d_step = round($v['d_step'],4);
            $sqls[] = "update ffc_prizes set a={$a},b_step={$b_step},b=a+{$b_step},c_step={$c_step},c=a+{$c_step},d_step={$d_step},d=a+{$d_step} where p_id={$v['p_id']} ";
        }
         //批量修改  加事务较好点
        try{
            $this->prize_model->startTrans();
            foreach ($sqls as $v){
                $res = $this->prize_model->editRebate($v);
            }
            $this->prize_model->commit();
            return put_encode(true,'','');
        }catch (Exception $e){
            $this->prize_model->rollback();
            return  put_encode(false,$e->getCode(),$e->getMessage());
        }
    }
}