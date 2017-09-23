<?php
/**
 * Created by PhpStorm.
 * User: Jim FAN
 * Date: 2017/8/21
 * Time: 20:54
 *加密
 */

namespace app\Service\DS\business;
use app\Service\DS\model\Xencrypt;

class encrypt
{
    public $xencrypt = null;
    public function __construct()
    {
        $this->xencrypt = new  Xencrypt();
    }

    /**
     * xencrypt 加密
     */
   public function Xencrypt($data = []){
        $str = $this->xencrypt->encrypt($data['key']);
        return  put_encode($str,'','');
   }

    /**
     * xdecrypt解密
     */
   public function Xdecrypt($data = []){
       $str = $this->xencrypt->decrypt($data['key']);
       return  put_encode($str,'','');
   }
}