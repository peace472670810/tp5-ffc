<?php
/**
 * Created by PhpStorm.
 * User: Jim FAN
 * Date: 2017/7/6
 * Time: 11:33
 */

namespace app\Service\order\model;
use think\Db;
use think\Model;
use think\Exception;
use think\Log;
class betOrder extends  Model
{
    protected  $connection = [
        // 数据库类型
        'type'        => 'mysql',
        // 数据库连接DSN配置
        'dsn'         => '',
        // 服务器地址
        'hostname'    => '10.10.197.6',
        // 数据库名
        'database'    => 'ds_ffc_order',
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
     * 订单插入
     * 分三步走： 1.先插入注单  状态为未支付
     *            2.去钱包扣钱 该情况下有三种状况
     *              a.若成功  去注单表修改注单未 o_is_take 1  已扣款
     *              b.若失败  直接回滚注单 下注失败
     *              c.报500（防止已经扣钱但连接超时 ）将注单放入注单遗漏表 有开启的定时任务去处理判断是否已经扣钱
     *            3.改变注单状态
     */
    public function orderInsert($data = [],$now,$site_id,$username,$u_id,$lid){
        //插入注单表及临时注单表
        $tmpTable = 'ffc_order_'.$data['lotteryId'].'_temp';
        $orders = $data['orders'];
        $sendData['time'] = $now;
        $sendData['orders'] = $orders;
        $sendData['siteId'] = $site_id;
        $sendData['username'] = $username;
        $sendData['u_id'] = $u_id;
        $sendData['lid'] = $lid;
        $insertorder = $data['insertorder'];
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
//                $this->table('ffc_missing_order')->insert($missOrder);
                $missOrder = $orders;
                foreach ($orders as $k=>$v){
                    $missOrder[$k]['o_username'] = $username;
                    $missOrder[$k]['o_transId'] = $res['error_code'];
                    $missOrder[$k]['o_siteId'] = $site_id;
                }
                $this->table('ffc_order_missing')->insertAll($missOrder);
                Log::record('更改注单扣钱状态异常,扣钱状态：:'.$res['data'].json_encode($missOrder),'error');
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
                    Log::record('插入到注单遗漏表数据：:'.json_encode($missOrder),'error');
//                    $this->table('ffc_missing_order')->insert($missOrder);
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
     * 追号订单插入
     */
    public function traceOrderInsert($data= [],$now,$site_id,$username,$u_id,$lid){
        $trace = $data['trace'];
        $orders = $data['orders'];
        $insertOrders = $data['insertOrders'];
        $sendData['time'] = $now;
        $sendData['siteId'] = $site_id;
        $sendData['username'] = $username;
        $sendData['u_id'] = $u_id;
        $sendData['lid'] = $lid;
        $tableTemp = 'ffc_order_'.$data['lotteryId'].'_temp';
        //第一步：
        //开始事务
        try{
            $this->startTrans();
            //插入到注单表
            foreach ($insertOrders as $v){
                $this->table($v['table'])->insertAll($v['orders']);
            }
            $this->commit();
        }catch (Exception $e){
            $this->rollback();
            Log::record('追号插入注单异常:'.json_encode($orders),'error');
            return false;
        }
        //第二步：
        $sendData['orders'] = $orders;
        $res = json_decode(forwarding('lotteryForwarding', '\app\Service\DS\business\wallet', 'sendOrder', $sendData),true);//发送订单到平台
        //第三步：
        if($res['data'] == 0 || $res['data'] == 1){
//            $missOrder = ['o_username'=>$username,'o_transId'=>$res['error_code'],'o_siteId'=>$site_id];
            $missOrder = $orders;
            foreach ($orders as $k=>$v){
                $missOrder[$k]['o_username'] = $username;
                $missOrder[$k]['o_transId'] = $res['error_code'];
                $missOrder[$k]['o_siteId'] = $site_id;
            }
            $this->table('ffc_order_missing')->insertAll($missOrder);
            Log::record('更改注单扣钱状态异常,扣钱状态：:'.$res['data'].json_encode($missOrder),'error');
//            $this->table('ffc_missing_order')->insert($missOrder);
            return false;
        }else if($res['data'] == 2){
            return $res;
        }else if($res['data'] == 3){
            try{
                $this->startTrans();
                //插入到追号表
                $traceNums = $this->table('ffc_traces')->insertGetId($trace);
                foreach($orders as $v){
                    $table = 'ffc_order_'.$data['lotteryId'].'_'.$v['o_mg_id'].'_'.mode10Issues($v['o_issue']);
                    $this->query(" update {$table} set o_is_take=1 where o_id={$v['o_id']}");
                }
                $this->table($tableTemp)->insertAll($orders);//扣钱成功才写入到临时表
                $this->commit();
                return $traceNums;
            }catch (Exception $e){
                Log::record('更改注单扣钱状态异常,插入到注单遗漏表：:'.json_encode($res),'error');
//                $missOrder = ['o_username'=>$username,'o_transId'=>$res['error_code'],'o_siteId'=>$site_id];
                $missOrder = $orders;
                foreach ($orders as $k=>$v){
                    $missOrder[$k]['o_username'] = $username;
                    $missOrder[$k]['o_transId'] = $res['error_code'];
                    $missOrder[$k]['o_siteId'] = $site_id;
                }
                $this->table('ffc_order_missing')->insertAll($missOrder);
                Log::record('插入到注单遗漏表数据：:'.json_encode($missOrder),'error');
//                $this->table('ffc_missing_order')->insert($missOrder);
                Log::record('订单插入异常：:'.$e->getMessage(),'error');
                return false;
            }
        }
    }
    /**
     * 获取追号记录
     */
    public function traceRecord($data = []){
        $msql = "select t_id,t_lid,t_detail,t_mg_id,t_username,t_finish_times,t_trace_times,t_status,t_total_amount,t_start_issue,t_start_issue,t_add_time from  `ffc_traces` where t_lid={$data['lid']} and t_username='{$data['username']}'  order by t_add_time DESC  limit {$data['limit']}";
        return $this->query($msql);
    }

    /**
     * 获取投注记录
     */
    public function getBuyRecord($data = []){
        $temptable = 'ffc_order_'.$data['lid'].'_temp';
        $msql = "select o_username,o_id,o_code,o_multiple,o_amount,o_issue,o_lid,o_mg_id,o_is_cancel,o_is_jiesuan,o_wins,o_add_time from  $temptable where  o_username='{$data['username']}' and o_trace_id=0 and o_deleteflag=0  order by o_add_time DESC  limit 10";
        $curlist = $this->query($msql);
        return $curlist;
    }
    /**
     * 手机端获取投注记录 未结算注单
     */
    public function mobileBuyRecord($data = []){
        $temptable = 'ffc_order_'.$data['lid'].'_temp';
        $start = 10*$data['curPage'];
        $msql = "select o_username,o_id,o_code,o_multiple,o_amount,o_issue,o_lid,o_trace_id,o_mg_id,o_is_cancel,o_is_jiesuan,o_wins,o_add_time,o_modes from  $temptable where o_username='{$data['username']}'  and o_deleteflag=0  order by o_add_time DESC  limit $start,10";
        $curlist = $this->query($msql);
        return $curlist;
    }
    /**
     * 订单详情
     *
     */
    public function orderDetail($data = []){
        $table = 'ffc_order_'.$data['lid'].'_'.$data['mg_id'].'_'.mode10Issues($data['issue']);
        $res = $this->table($table)->field('o_amount,o_is_cancel,o_is_jiesuan,o_code,o_draw_time,o_hit_detail,o_id,o_issue,o_lid,o_mg_id,o_modes,o_multiple,o_odd,o_single_num,o_trace_id,o_wins,o_username,o_add_time')->where('o_id','eq',$data['o_id'])->find();
        return $res;
    }

    /**
     * 获取追号详情
     */
    public function traceDetail($data = []){
        $table = "ffc_traces";
        $res = $this->table($table)->where('t_id','eq',$data['t_id'])->find();
        return $res;
    }

    /**
     * 追号详情注单列表
     */
    public function traceDetailOrderList($data = []){
        $table = "ffc_order_{$data['lid']}_temp";
        if(empty($data['issue'])){
            $res = $this->table($table)->field('o_id,o_amount,o_is_cancel,o_is_jiesuan,o_code,o_draw_time,o_hit_detail,o_id,o_issue,o_lid,o_mg_id,o_modes,o_multiple,o_odd,o_single_num,o_trace_id,o_wins,o_username,o_add_time')->where('o_trace_id','eq',$data['t_id'])->select();
        }else{
            $res = $this->table($table)->field('o_id,o_amount,o_is_cancel,o_is_jiesuan,o_code,o_draw_time,o_hit_detail,o_id,o_issue,o_lid,o_mg_id,o_modes,o_multiple,o_odd,o_single_num,o_trace_id,o_wins,o_username,o_add_time')->where('o_trace_id','eq',$data['t_id'])->where('o_issue','eq',$data['issue'])->select();
        }
        return $res;
    }
    /**
     * 一期追号详情注单列表
     */
    public function traceDetailByIusseList($data = []){
        $mgs = explode(',',$data['mg_ids']);
        $lid = $data['lid'];
        $issue = $data['issue'];
        $list = [];
        foreach ($mgs as $v){
            $table = 'ffc_order_'.$lid.'_'.$v.'_'.mode10Issues($issue);
            $res = $this->table($table)->field('o_id,o_amount,o_is_cancel,o_is_jiesuan,o_code,o_draw_time,o_hit_detail,o_id,o_issue,o_lid,o_mg_id,o_modes,o_multiple,o_odd,o_single_num,o_trace_id,o_wins,o_username,o_add_time')->where('o_trace_id','eq',$data['t_id'])->where('o_issue','eq',$data['issue'])->find();
            $list[] = $res;
        }
        return  $list;
    }
    /**
     * 订单列表
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
                $res = $this->query("select * from $table where o_lid={$data['lid']}  AND  o_username='{$data['username']}' $where order by o_add_time DESC limit $start,10");
                $count = $this->query("select count(*) from $table where o_lid={$data['lid']} AND  o_username='{$data['username']}' $where  order by o_add_time DESC limit 1");
            }else{//基本不用了
                $res = $this->query("select * from `ffc_orders_temp` where 1  AND  o_username='{$data['username']}' $where  order by o_add_time DESC limit $start,10");
                $count = $this->query("select count(*) from `ffc_orders_temp` where 1 AND  o_username='{$data['username']}' $where  limit 1");
            }
            $arr['count'] = $count[0]['count(*)'];
        }else{
            if(!empty($data['lid'])){
                $table = 'ffc_order_'.$data['lid'].'_temp';
                $res = $this->query("select * from $table where o_lid={$data['lid']}  AND  o_id={$data['o_id']}   AND  o_username='{$data['username']}'  $where limit 1");
            }else{//基本不用了
                $res = $this->query("select * from `ffc_orders_temp` where o_lid={$data['lid']}  AND  o_id={$data['o_id']}   AND  o_username='{$data['username']}'  $where limit 1");
            }
            $arr['count'] = 1;
        }
        $arr['list'] = $res;
        return $arr;
    }

    /**
     * 事务追号撤单
     * 更新临时注单表和注单表
     * 根据彩种lid mg_id 期数找到表 进行更新操作  trace表 取消期数
     * 注单表里面的 o_is_cancel=2（追中撤单）  o_cancel_time
     */
    public function cancelTrace($data = [],$site_id,$username,$u_id){
        try{
            $now = date('Y-m-d H:i:s');
            $issues = $data['issue'];
            $cancel_time = count($issues);
            $lid = $data['lid'];
            $trace_id = $data['trace_id'];
            $mg_ids = explode(',',$data['mg_ids']);
            $this->startTrans();
            $orders = [];
            //注单表里面的 o_is_cancel=2（追中撤单）  o_cancel_time
            foreach ($issues as $v){
                $table_temp = 'ffc_order_'.$lid.'_temp';
                $sqltemp = "update $table_temp set o_is_cancel=1,o_cancel_time='{$now}' where o_trace_id={$trace_id} and o_issue={$v}";
                $orderSql = "select * from $table_temp where o_trace_id={$trace_id} and o_issue={$v}";
                $issueOrder = $this->query($orderSql);
                $orders = array_merge($orders,$issueOrder);
                $this->query($sqltemp);
                foreach ($mg_ids as $val){
                    $table = 'ffc_order_'.$lid.'_'.$val.'_'.mode10Issues($v);
                    $sql = "update $table set o_is_cancel=1,o_cancel_time='{$now}' where o_trace_id={$trace_id} and o_issue={$v}";
                    $this->query($sql);
                }
            }
            //根据彩种lid mg_id 期数找到表 进行更新操作  trace表 取消期数
            $sql_trace = "update ffc_traces set t_cancel_times=$cancel_time where t_id={$trace_id}";
            $this->query($sql_trace);
            $sendData['time'] = $now;
            $sendData['siteId'] = $site_id;
            $sendData['username'] = $username;
            $sendData['u_id'] = $u_id;
            $sendData['lid'] = $lid;
            $sendData['orders'] = $orders;
            $res = json_decode(forwarding('lotteryForwarding', '\app\Service\DS\business\wallet', 'cancelOrder', $sendData),true);//发送订单到平台
            if(!$res['data']){
                $this->rollback();
                return  false;
            }
            $this->commit();
            return true;
        }catch (Exception $e){
            Log::record('追号撤单错误：'.$e->getMessage(),'error');
            $this->rollback();
            return false;
        }
    }

    /**
     * 追号注单里面的注单详情
     * @param array $data
     */
    public function TraceOrderDetail($data = []){
        $mg_ids = $data['mg_id'];
        $lid = $data['lid'];
        $trace_id = $data['trace_id'];
        $issue = $data['issue'];
        $list = [];
        foreach ($mg_ids as $k => $v){
            $table = 'ffc_order_'.$lid.'_'.$v.'_'.mode10Issues($issue);
            $list[] = $this->table($table)->where('o_trace_id','eq',$trace_id)->where('o_issue','eq',$issue)->find();
        }
        return $list;
    }

    /**
     * 更多追号记录
     * @param array $data
     */
    public function moreTraceRecord($data = []){
        $start = $data['page']*10;
        $where = '';
        if(!empty($data['start_time']) && !empty($data['end_time'])){
            $data['end_time'] = date('Y-m-d H:i:s',strtotime($data['end_time'])+60*60*24);
            $where .=" and t_add_time>'{$data['start_time']}' and t_add_time<'{$data['end_time']}'";
        }
        if(!empty($data['t_id'])){
            $where .=" and t_id=".$data['t_id'];
        }
        $sql = "select * from  ffc_traces where t_lid={$data['lid']} AND t_username='{$data['username']}' $where order by t_add_time DESC limit $start,10";
        $list = $this->query($sql);
        $countsql = "select count(*) from  ffc_traces  where t_lid={$data['lid']} AND t_username='{$data['username']}' $where limit 1";
        $count = $this->query($countsql);
        $res['list'] = $list;
        $res['count'] = $count[0]['count(*)'];
        return $res;
    }
}