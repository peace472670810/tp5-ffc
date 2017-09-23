<?php 
namespace app\Service\DS\business;
use think\image\Exception;
use think\Log;

class adminWallet
{
public function transfer($data = [],$url='',$type=[]){
           if(empty($type)){
               $type= array("Content-Type: application/json; charset=utf-8");
            }
            $cur = curl_init();
            curl_setopt($cur, CURLOPT_HTTPHEADER, $type);
            curl_setopt($cur,CURLOPT_URL,$url);
            curl_setopt($cur,CURLOPT_TIMEOUT,30);
            curl_setopt($cur,CURLOPT_CONNECTTIMEOUT,3);
            curl_setopt($cur,CURLOPT_MAXREDIRS,1);
            curl_setopt($cur,CURLOPT_RETURNTRANSFER,true);
            curl_setopt($cur,CURLOPT_FOLLOWLOCATION,true);
            curl_setopt($cur,CURLOPT_POST,true);
            curl_setopt($cur,CURLOPT_POSTFIELDS,$data);
            $res = curl_exec($cur);
            $status = curl_getinfo($cur,CURLINFO_HTTP_CODE);
            $error = curl_error($cur);
            curl_close($cur);
            if($res){
                return $res;
            }else{
                Log::record("转账错误信息：请求参数：".$data."\n".$error."\n http状态码：".$status,'issue_error'."\n链接：".$url);
               return false;
            }
    }

 }