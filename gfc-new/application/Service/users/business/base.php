<?php
/**
 * Created by PhpStorm.
 * User: Jim FAN
 * Date: 2017/6/30
 * Time: 19:54
 */

namespace app\Service\users\business;

use crate\crateDB;
use Nocache\mcache;
class base
{
    public  $memcache = null;

    /**
     * 密码加密
     * @param $value
     * @return string
     */
    public function setPassword($value){
        return md5($value);
    }
    /**
     * 连接crateDb
     */
    public  function connectCrate()
    {
        if(empty($this->conn)){
            $this->dns = config('crate_conf');


        }
    }
    public function __construct()
    {
        $this->memcache = new mcache();
    }
}