<?php
/**
 * Created by PhpStorm.
 * User: Jim FAN
 * Date: 2017/6/19
 * Time: 17:20
 * 钱包地址访问接口
 */

namespace app\Service\DS\business;
use think\Db;
use think\image\Exception;
use think\Log;

class wallet
{
    public  static  $error_code = [
        '100000' => 'OK',
        '110001' => '钱包中心系统错误',
        '110002' => '钱包中心账号异常',
        '110009' => '钱包中心参数错误',
        '110010' => '钱包中心用户未找到',
        '110011' => '钱包中心用户已退出',
        '110012' => '钱包中心用户余额不足',
        '110013' => '钱包中心鉴权失败，md5加密解密不对',
        '110014' => '钱包中心没有权限',
        '110015' => '钱包中心重复提交请求',
        '110018' => '钱包中心注单不存在',
        'money is not enough' => '钱包中心余额不足',
        '100001' => '钱包中心余额不足',
        '110006' => '钱包中心user is not start ,this account is not use',
//        '110002' => '钱包中心this account is unusual( 发生情况数据库被手动修改用户金额)',
        '112007' => '用户名不能为空！',
        '10011033' =>'平台用户名参数不对',
        '10011034' =>'平台用户名参数不对',
    ];
    const DS_ACTION_BUY = 1;
    const DS_ACTION_CANCEL = 4;
    const DS_ACTION_CANCEL_WIN = 5;
    const DS_ACTION_LOSE = 3;
    const DS_ACTION_WIN = 2;
    const DS_TRANSID = "DS";
    const DS_LOTTO_TYPE = 2;
    const DS_USER_PASS = 'ds123456';
    const DS_TOPTREE_USER = 'mysiteadmin';
    const DS_TOKEN_LIVE = 600;

    /**
     * 获取钱包
     * @param array $data
     */
    public function getBalance($data = []){
        $post = [];
        try{
            if(empty($data['username'])){
                throw new Exception(self::$error_code['112007'],'112007');
            }
            $url = config('wallet_address');
            $user = Db::table('ffc_users')->where('u_username','eq',"{$data['usernmae']}")->find();
            $post['user'] = $data['username'];
            $post['siteId'] = $user['siteId'];
            $post['fromLotto'] = self::DS_LOTTO_TYPE;
            return  put_encode($this->walletRomate($post,$url),'100000',self::$error_code['100000']);
        }catch (Exception $e){
            return put_encode(false,$e->getCode(),$e->getMessage());
        }
    }

    /**
     * 订单生成
     * @param array $data
     */
    public function createOrder($data = []){

    }

    /**
     * 改变订单状态接口
     * @param array $data
     */
    public function editOrder($data = []){

    }
    /**
     *远程连接
     * @param $data
     * @param $url
     */
    public function walletRomate($data,$url){

        $post = json_encode($data);
        $s = curl_init();
        curl_setopt($s, CURLOPT_URL, $url);
        curl_setopt($s, CURLOPT_TIMEOUT, 7);
        curl_setopt($s, CURLOPT_CONNECTTIMEOUT, 3);
        curl_setopt($s, CURLOPT_MAXREDIRS, 1);
        curl_setopt($s, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($s, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($s, CURLOPT_POST, true);
        curl_setopt($s, CURLOPT_POSTFIELDS, $post);
        $res = curl_exec($s);
        $status = curl_getinfo($s, CURLINFO_HTTP_CODE);
        $curlError = curl_error($s);
        curl_close($s);
        if(!$res){
            Log::record("平台接口错误信息：".$curlError."\n http状态码：".$status,'java_error'."\n链接：".$url);
            return false;
        }
        return $res;
    }

    /**
     *
     * @param $username 平台用户名
     * @return string 外接网站的用户名
     */
    public function unwrapUsername($username)
    {
        if (!preg_match("/^c\d+s\d+_/", $username, $matches)) {
            throw new Exception(self::$error_code['10011034'], 10011034);
        }

        return substr($username, strlen($matches[0]));
    }

    /**
     * 生成平台用户名
     * @param type $username
     * @param type $siteId
     * @return type 平台用户名
     */
    public function wrapUsername($username, $customerId, $siteId, $onlyWarper = false)
    {
        if (!is_numeric($customerId) || !is_numeric($siteId)) {
            throw new Exception(self::$error_code['10011033'], 10011033);
        }
        return 'c'.$customerId.'s'.$siteId.($onlyWarper ? '' : '_' . $username);
    }

}