<?php
/**
 * Created by PhpStorm.
 * User: Jim FAN
 * Date: 2017/8/30
 * Time: 11:47
 * 结算校验
 */

namespace app\home\command;
use think\console\Command;
use think\console\Input;
use think\console\Output;
use think\Db;
use crate\crateDB;
use think\Log;
class validation extends Command
{
    protected  $dns = null;
    protected  $crate = null;
    protected  $conn = null;
    protected function configure()
    {
        parent::configure(); // TODO: Change the autogenerated stub
//        $this->setName('doOrder')->setDescription('处理遗漏注单');
        $this->setName('doValidation')->setDescription('结算校验');
    }
    /**
     * 连接crateDb
     */
    public  function connectCrate()
    {
        if(empty($this->conn)){
            $this->dns = config('crate_conf');
            $this->crate = new crateDB(['dns' => $this->dns]);
            $this->conn = $this->crate->getCrateConnection();
        }
    }

    /**
     *执行
     * @param Input $input
     * @param Output $output
     */
    protected function execute(Input $input, Output $output)
    {
        //连接crateDb
//        echo $o_add_time;
        $this->connectCrate();
        //三分钟之内的
//        $sql = "select * from  ffc_order where o_lid = 2  and o_add_time>$o_add_time  order by o_add_time DESC limit 1000 ";
        // lid = 2
        //20170901023  20170901037  ok
        //20170901038  20170901050  ok
        //20170901051  20170901070
        //20170901071  20170901090
        //20170901091  20170901120
        // $sql = "select * from  ffc_order where o_lid=28 and  o_issue>=20170901051  and o_issue<=20170901070 ";
        // lid = 28 福彩3D
        //2017233
        //2017234
        //2017235
        //2017236 ok
        //2017237

        //lid=29 排列三五
        //2017236
        //2017235
        //lid=30湖北快三
        //20170901001   20170901020
        //20170901021   20170901040
        //20170901041   20170901060
        //20170901061   20170901078

        //lid=14 天津时时彩
        //lid =30 湖北快三
        $t1 = time();
//        $sql = "select * from  ffc_order where o_lid=30 and  o_issue>=20170904148  and o_issue<=20170904166  ";
        $sql = "select * from  ffc_order where o_is_take=1 and  o_id=179851107  ORDER  by o_add_time DESC limit 1 ";
//        $sql = "select * from  ffc_order where o_id=80726490 ";
        $res = $this->conn->query($sql);
        $list = $res->fetchAll();
//        $sqlcount = "select count(*) from  ffc_order where o_lid=30 and  o_issue>=20170904148  and o_issue<=20170904166 limit 1";
//        $rescount =$this->conn->query($sqlcount);
//        $count = $rescount->fetchAll();
        /**
        $mid = $data['mid'];
        $lid = $data['lid'];
        $code = $data['code'];
        $issue = $data['issue'];
        $amount = $data['amount'];
         */
        foreach ($list as $k=>$v){
            $codeList = json_decode($v['o_code'],true);
            $data['lid'] = $v['o_lid'];
            $data['issue'] = $v['o_issue'];
            $jiesuan = $v['o_wins']/1000000;
            $str0 = '主单号：'.$v['o_id']."中奖金额".($jiesuan);
            echo $str0;
            $o_odd = json_decode($v['o_odd'],true);
//            $o_hit_detail = json_decode($v['o_hit_detail']);
            Log::record($str0,'jiaoyan');
            $o_wins = 0;
            foreach ($codeList as $key=> $val){
                $data['mid'] = $val['mid'];
                $data['code'] = $val['number'];
                $data['amount'] = $v['o_amount'];
                $data['order'] = $v;
                $res = json_decode(forwarding('lotteryForwarding', '\app\Service\lottery\business\methods', 'getCodePrizes', $data), true);
                $level = $res['data']['level'];
                $prize_code = $res['data']['prize_code'];
                $str1 = '下注号码：'. $val['number']."\n";
                $str2 = '开奖号码：'.$prize_code;
                $str3 = '中奖等级：';
                $str4 = '玩法名：'.$res['data']['cname'];
                foreach ($o_odd as $o){
                    if($o['mid'] == $val['mid']){
                        $odd = $o['odd'];
                    }
                }
//                $hit_detail = $o_hit_detail[$val['mid']];
                //核对中奖金额
                // ["o_odd"] => string(52) "[{"mid":"3","odd":[{"level":1,"jiner":"283.3333"}]}]"
                if(is_array($level)){//连选类
                    foreach ($level as $vl){
                        foreach ($odd as $value){
                            if($vl == $value['level']){
                                $o_wins += $value['jiner']*$v['o_modes']*$v['o_multiple'];
                            }
                        }
                        $str3 .= $vl.'等奖；';
                    }
                }else{
                    foreach ($odd as $value){
                        if($level == $value['level']){
                            $o_wins += $value['jiner']*$v['o_modes']*$v['o_multiple'];
                        }
                    }
                    $str3 .= $level.'等奖；';
                }
                echo $str1.$str2.$str3.$str4;
                Log::record($str1.$str2.$str3.$str4,'jiaoyan');
            }
            echo "校验中奖金额：".$o_wins."\n";
            $jiaoyan = "注单单号：".$v['o_id']."结算金额：$jiesuan 校验金额:$o_wins\n"."倍数：".$v['o_multiple']."\n模式：".$v['o_modes']."\n"."玩法ID：".$val['mid']."\n";
            echo $jiaoyan;
            if(round($o_wins,4) != round($jiesuan,4)){
                Log::record($jiaoyan."----".$str4,'jiaoyanerror');
                Log::record('开奖号码：'."\n".$prize_code,'jiaoyanerror');
                Log::record('下注号码：'."\n".$val['number'],'jiaoyanerror');
            }
            Log::record($jiaoyan,'jiaoyan');
            Log::record("\n\n",'jiaoyan');
            echo '耗时：'.(time()-$t1);
//            sleep(0.5);
        }
        echo "注单数：";
//        dump($count);
    }
}