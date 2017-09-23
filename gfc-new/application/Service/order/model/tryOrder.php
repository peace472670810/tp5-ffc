<?php
/**
 * Created by PhpStorm.
 * User: Jim FAN
 * Date: 2017/7/12
 * Time: 14:30
 */

namespace app\Service\order\model;


use think\image\Exception;
use think\Model;
use think\Log;
class tryOrder extends Model
{
    protected  $connection = [
        // 数据库类型
        'type'        => 'mysql',
        // 数据库连接DSN配置
        'dsn'         => '',
        // 服务器地址
        'hostname'    => '10.10.197.6',
        // 数据库名
        'database'    => 'ds_ffc_orderTest',
        // 数据库用户名
        'username'    => 'ffc_new',
        // 数据库密码
        'password'    => 'qweqweqwe123',
        // 数据库连接端口
        'hostport'    => '3306',
        // 数据库连接参数
        'params'      => [],
        // 数据库编码默认采用utf8
        'charset'     => 'utf8',
        // 数据库表前缀
        'prefix'      => 'ffc_',
    ];

    /**
     * 试玩订单插入
     */
    public function orderInsert($data = [],$now,$site_id,$username,$u_id,$lid){
        //插入注单表及临时注单表
        $orders = $data['orders'];
        $sendData['time'] = $now;
        $sendData['orders'] = $orders;
        $sendData['siteId'] = $site_id;
        $sendData['username'] = $username;
        $sendData['u_id'] = $u_id;
        $sendData['lid'] = $lid;
        $insertorder = $data['insertorder'];
        //插入注单表及临时注单表
        $tmpTable = 'ffc_order_'.$data['lotteryId'].'_temp';
        try{
            //第一步
            try{
                $this->startTrans();
                $j = 0;
                foreach ($insertorder as $k=>$v){
                    //选择插入的表
                    $inseterId = $this->table($v['table'])->insertGetId($insertorder[$k]['orders']);
                    $j ++;
                }
                $this->commit();
            }catch (Exception $e){
                Log::record('订单插入异常：:'.$e->getMessage(),'error');
                $this->rollback();
                return  false;
            }
            //第二步 扣钱
            /**
             * data 0 访问钱包接口出现异常 异常注单处理
             * data 1 钱包中心报错 无返回 作为异常注单处理
             * data 2 连接成功但没返回正确码 下注失败处理
             * data 3 扣钱成功 下注成功处理
             */
            $res = json_decode(forwarding('lotteryForwarding', '\app\Service\DS\business\wallet', 'sendOrder', $sendData),true);//发送订单到平台
            //第三步 改变o_is_take
            if($res['data'] == 0||$res['data'] == 1){
//                $missOrder = ['o_username'=>$username,'o_transId'=>$res['error_code'],'o_siteId'=>$site_id];
                $missOrder = $orders;
                foreach ($orders as $k=>$v){
                    $missOrder[$k]['o_username'] = $username;
                    $missOrder[$k]['o_transId'] = $res['error_code'];
                    $missOrder[$k]['o_siteId'] = $site_id;
                }
                $this->table('ffc_order_missing')->insertAll($missOrder);
                Log::record('更改注单扣钱状态异常,插入到注单遗漏表数据：:'.json_encode($missOrder),'error');
//                $this->table('ffc_missing_order')->insertAll($missOrder);
                return false;
            }else if($res['data'] == 2){
                return $res;
            }else if($res['data'] == 3){
                try {
                    $this->startTrans();
                    foreach ($insertorder as $v) {
                        $sql2 = " update {$v['table']} set o_is_take=1 where o_id={$v['orders']['o_id']}";
                        $this->query($sql2);
                    }
                    $this->table($tmpTable)->insertAll($orders);//扣钱成功才写入到临时表
                    $this->commit();
                    return $j;
                }catch (Exception $e){
                    $this->rollback();
                    Log::record('更改注单扣钱状态异常,插入到注单遗漏表：:'.json_encode($res),'error');
//                    $missOrder = ['o_username'=>$username,'o_transId'=>$res['error_code'],'o_siteId'=>$site_id];
                    $missOrder = $orders;
                    foreach ($orders as $k=>$v){
                        $missOrder[$k]['o_username'] = $username;
                        $missOrder[$k]['o_transId'] = $res['error_code'];
                        $missOrder[$k]['o_siteId'] = $site_id;
                    }
                    $this->table('ffc_order_missing')->insertAll($missOrder);
                    Log::record('更改注单扣钱状态异常,插入到注单遗漏表数据：:'.json_encode($missOrder),'error');
//                    $this->table('ffc_missing_order')->insertAll($missOrder);
                    Log::record('订单插入异常：:'.$e->getMessage(),'error');
                    return  false;
                }
            }
        }catch (Exception $e){
            Log::record('订单插入异常:'.$e->getMessage(),'mysql_error');
            Log::record('异常注单:'.json_encode($insertorder),'mysql_error');
            return  false;
        }
    }
    /**
     * 试玩订单详情
     */
    public function orderDetail($data = []){
        $table = 'ffc_order_'.$data['lid'].'_'.$data['mg_id'].'_'.mode10Issues($data['issue']);
        $res = $this->table($table)->field('o_amount,o_is_cancel,o_is_jiesuan,o_code,o_draw_time,o_hit_detail,o_id,o_issue,o_lid,o_mg_id,o_modes,o_multiple,o_odd,o_single_num,o_trace_id,o_wins,o_username,o_add_time')->where('o_id','eq',$data['o_id'])->find();
        return $res;
    }
    /**
     * 手机端获取投注记录
     */
    public function mobileBuyRecord($data = []){
        $temptable = 'ffc_order_'.$data['lid'].'_temp';
        $start = 10*$data['curPage'];
        $msql = "select o_username,o_id,o_code,o_multiple,o_amount,o_issue,o_lid,o_trace_id,o_mg_id,o_is_cancel,o_is_jiesuan,o_wins,o_add_time,o_modes from  $temptable where  o_username='{$data['username']}' and o_add_time>'{$data['time']}' and o_deleteflag=0  order by o_add_time DESC  limit $start,10";
        $curlist = $this->query($msql);
        return $curlist;
    }
    /**pc端
     * 获取投注记录
     */
    public function getBuyRecord($data = []){
        $temptable = 'ffc_order_'.$data['lid'].'_temp';
        $msql = "select o_username,o_id,o_code,o_multiple,o_amount,o_issue,o_lid,o_mg_id,o_is_cancel,o_is_jiesuan,o_wins,o_add_time from  $temptable where o_username='{$data['username']}' and o_trace_id=0 and o_deleteflag=0  order by o_add_time DESC  limit 10";
        $curlist = $this->query($msql);
        return $curlist;
    }
    /**
     * 试玩订单列表
     */
    public function orderList($data = []){
        $page = empty($data['page'])?0:$data['page'];
        $start = 10*$page;
        $arr = [];
        $where = ' and o_deleteflag=0 ';
        if(!empty($data['start_time']) && !empty($data['end_time'])){
            $data['end_time'] = date('Y-m-d H:i:s',strtotime($data['end_time'])+60*60*24);
            $where .=" and o_add_time>'{$data['start_time']}' and o_add_time<'{$data['end_time']}'";
        }
        if(empty($data['o_id'])){
            if(!empty($data['lid'])){
                $table = 'ffc_order_'.$data['lid'].'_temp';
                $res = $this->query("select * from $table where o_lid={$data['lid']} AND  o_username='{$data['username']}'  $where order by o_add_time DESC limit $start,10");
                $count = $this->query("select count(*) from $table where o_lid={$data['lid']}  AND  o_username='{$data['username']}' and o_is_take=1 $where  order by o_add_time DESC limit 1");
            }else{
                $res = $this->query("select * from `ffc_orders_temp` where 1 AND  o_username='{$data['username']}' $where and o_is_take=1 order by o_add_time DESC limit $start,10");
                $count = $this->query("select count(*) from `ffc_orders_temp` where 1 AND  o_username='{$data['username']}' $where  and o_is_take=1 limit 1");
            }
            $arr['count'] = $count[0]['count(*)'];
        }else{
            $res = $this->query("select * from `ffc_orders_temp` where o_lid={$data['lid']} AND  o_id={$data['o_id']}  and o_is_take=1  AND  o_username='{$data['username']}'  $where limit 1");
            $arr['count'] = 1;
        }
        $arr['list'] = $res;
        return $arr;
    }
}