<?php
/**
 * Created by PhpStorm.
 * User: Jim FAN
 * Date: 2017/6/19
 * Time: 17:22
 */

namespace app\Service\DS\business;
use think\image\Exception;
use think\Log;

class issue
{
    public static $error_code = [

    ];
    public function __construct()
    {
    }

    /**
     * 获取奖期列表
     * @param array $data
     */
    public function getIssueList($data = []){
        try{
            $list = $this->issueRemote($data,config('issue_address'));
        }catch (Exception $e){
            halt($e->getMessage());
        }
    }

    /**
     * 更改奖期
     * 回滚操作
     */
    public function updateIssueList($data = []){

    }

    /**
     *远程连接
     */
    public function issueRemote($data = [],$url=''){
            $cur = curl_init();
            curl_setopt($cur,CURLOPT_URL,$url);
            curl_setopt($cur,CURLOPT_TIMEOUT,7);
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
                Log::record("奖期接口错误信息：".$error."\n http状态码：".$status,'issue_error'."\n链接：".$url);
               return false;
            }
    }
}