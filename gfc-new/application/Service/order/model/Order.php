<?php 
namespace app\Service\order\model;
use crate\crateDB;
use think\Db;
use think\image\Exception;

class Order
{
        private  $crate = null;
        private  $dns = null;
        private  $conn = null;
        /**
         * 初始化连接crateDB
         * orderReport constructor.
         * @param array $arr
         */
        public function __construct($arr = [])
        {
            $this->dns = config('crate_conf');
            $this->crate = new crateDB(['dns'=>$this->dns]);
            $this->conn = $this->crate->getCrateConnection();
        }

        public function getOrder($sql,$status){
        	 if($status==='1'){
                $test=$this->conn->query($sql);
                halt($sql);
        	 }elseif($status==='2'){
        	 	halt($sql);
                $test=Db::query($sql);
                halt($test);
        	 }else{
        	 	return false;
        	 }
        }

}
