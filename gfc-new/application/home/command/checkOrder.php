<?php
/**
 * Created by PhpStorm.
 * User: Jim FAN
 * Date: 2017/8/29
 * Time: 17:27
 * 正式库注单验证
 * 不去模块读取  降低耦合 涉及到的功能不多 因此就在此文件中处理
 */

namespace app\home\command;

use think\console\Command;
use think\console\Input;
use think\console\Output;
use think\Db;
use think\image\Exception;
use think\Log;

class checkOrder extends Command
{
    protected function configure()
    {
        parent::configure(); // TODO: Change the autogenerated stub
        $this->setName('doOrder')->setDescription('处理遗漏注单');
    }

    /**
     * 覆盖父类
     * @param Input $input
     * @param Output $output
     */
    protected function  execute(Input $input, Output $output)
  {
      //1.去注单遗漏表 查询是否有需要验证的注单
      //2.获取注单去钱包中心验证  如果有 则去注单表改变状态 如果没有的话就不做处理
      //3.软删掉2处理的遗漏注单
      $mysql = [
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
          'hostport'    => '',
          // 数据库连接参数
          'params'      => [],
          // 数据库编码默认采用utf8
          'charset'     => 'utf8',
          // 数据库表前缀
          'prefix'      => 'ffc_',
      ];
        $db = Db::connect($mysql);
        $t1 = time();
        while(1){
            if(time()- $t1 > 60){
               break;
            }
            $list = $db->query("select * from ffc_order_missing where o_is_deal=0 order by o_add_time desc limit 1000");//一次处理一千条
            echo "注单处理开始\n";
            if(empty($list)){
                echo "暂无需要处理的遗漏注单\n";
                break;
            }
            foreach ($list as $k=>$v){
                $arr = [
                    'user'=> $v['o_username'],
                    'siteId'=> $v['o_siteId'],
                    'transId' => $v['o_transId']
                ];
                $tmptable = 'ffc_order_'.$v['o_lid'].'_temp';
                $table = "ffc_order_".$v['o_lid'];
                $res = $this->remodeOrder($arr);
                $lockname = 'orderMissing'.$v['o_did'].'lock';
                $fp = fopen($lockname,'w');
                // CLI 独占锁 保证唯一执行
                if(!$fp1 = flock($fp,LOCK_EX|LOCK_NB)){
                    echo "o_did：{$v['o_did']}已经在执行跳过修改！\n";
                    continue;
                }
                if($res == 1){
                    try{
                        //1.取消撤销注单
                        $sendData['time'] = date("Y-m-d H:i:s");
                        $sendData['siteId'] = $v['o_siteId'];
                        $sendData['u_id'] = $v['o_u_id'];
                        $sendData['lid'] = $v['o_lid'];
                        $sendData['username'] = $v['o_username'];
                        $sendData['orders'] = [$v];
                        $res = json_decode(forwarding('lotteryForwarding', '\app\Service\DS\business\wallet', 'cancelOrder', $sendData),true);//发送订单到平台
                        if($res['data']){
                            $db->startTrans();
                            Log::record('接口信息返回：'.json_encode($res),'yilou');
                           $str =  "遗漏的注单编号：{$v['o_id']}撤单成功\n注单遗漏详情：";
                           echo $str;
                           Log::record($str,'yilou');
                           Log::record($v,'yilou');
                            $db->query("update {$tmptable} set o_deleteflag =1 where o_id={$v['o_id']}");
                            $db->query("update ffc_order_missing set o_is_deal=1 where  o_did={$v['o_did']}");
                            $db->commit();
                        }else{
                            $str =  "遗漏的注单编号：{$v['o_id']}撤单失败\n 原因：".json_encode($res);
                            $db->query("update ffc_order_missing set o_is_deal=2 where  o_did={$v['o_did']}");
                            Log::record($str,'yilou');
                        }
                        //2.改变临时表以及注单遗漏表状态
                    }catch (Exception $e){
                        $db->rollback();
                        echo "修改注单出现异常，修改失败！\n";
                    }
                }else{
                    echo "钱包中心注单错误！";
                    $str =  "遗漏的注单编号：{$v['o_id']}撤单失败\n 原因：".json_encode($res);
                    $db->query("update ffc_order_missing set o_is_deal=2 where  o_did={$v['o_did']}");
                    Log::record($str,'yilou');
                }
                fclose($fp);
                @unlink($lockname);
            }
        }
        echo "注单处理完成！\n";
  }

    /**
     * 远程验证注单
     */
  public function remodeOrder($data){
      $post = json_encode($data);
      $s = curl_init();
      $url = config('wallte_checkorder_address');
      curl_setopt($s, CURLOPT_URL, $url);
      curl_setopt($s, CURLOPT_TIMEOUT, 7);
      curl_setopt($s, CURLOPT_CONNECTTIMEOUT, 3);
      curl_setopt($s, CURLOPT_MAXREDIRS, 1);
      curl_setopt($s, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($s, CURLOPT_FOLLOWLOCATION, true);
      curl_setopt($s, CURLOPT_POST, true);
      curl_setopt($s, CURLOPT_POSTFIELDS, $post);
      $res = curl_exec($s);
      echo "去钱包检验注单状态:".$res;
      $status = curl_getinfo($s, CURLINFO_HTTP_CODE);
      $curlError = curl_error($s);
      echo "状态码：".$curlError."\n";
      echo "错误信息：".json_encode($curlError)."\n";
     if($status === 200){//正确
        $result = json_decode($res,true);
        if($result['data']['status'] == "true"){
           return  1;
        }else{
            echo "钱包中心注单验证失败！";
           return  0;
        }
     }else{
         echo "钱包中心连接异常！";
         return 0;
     }
  }
}