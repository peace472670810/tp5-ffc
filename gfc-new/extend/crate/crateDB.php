<?php
/**
 * Created by PhpStorm.
 * User: Jim FAN
 * Date: 2017/6/14
 * Time: 13:30
 */

namespace crate;
require_once __DIR__ .'/autoload.php';
use Crate\PDO\PDO as PDO;
class crateDB
{
    private  $dns = null;
    private $con = null;
    public function __construct($arr = [])
    {
        if(empty($arr['dns'])){
            $this->dns = false;
        }else{
            $this->dns = $arr['dns'];
        }
        if(!empty( $arr['dns'])){
            $this->con = new PDO($this->dns,null,null,null);
        }else{
           $this->con = false;
        }
    }

    /**
     * 获取crate连接
     * @return PDO|null
     */
    public function getCrateConnection(){
        return $this->con;
    }

    /**
     * 获取配置连接信息
     * @return mixed|null
     */
    public function getConf(){
        return $this->dns;
    }
}