<?php 
namespace app\Service\order\model;
use crate\crateDB;
use think\Db;
use think\image\Exception;
use think\Model;

class Order  extends  Model
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

    /**
     * 注单列表
     * @param $sql
     * @param $status
     * @return array|bool|mixed
     */
        public function getOrder($sql,$sqlcount,$status){
        	 if($status == 1){//已经派彩的
                 $arr= $this->conn->query($sqlcount);
                 if(empty($arr)){
                    return  false;
                 }
                 $count=$arr->fetch();
                 $res['count'] = $count[0];
                 $data = $this->conn->query($sql);
                if(empty($data)){
                    return false;
                }        
                $res['list']=$data ->fetchAll();
                 return $res;
        	 }elseif($status == 2){//未派彩的
                 $count = $this->query($sqlcount);
                 $res['count'] = $count[0]['count(*)'];
                 $res['list'] = $this->query($sql);
               return $res;
        	 }else{
        	 	return false;
        	 }
        }

    /**
     * 获取注单详情
     * @param array $sql
     */
        public function getOrderDetail($sql){
            $res = $this->query($sql);
            return $res;
        }

    /**
     *从crateDb 获取注单列表
     */
    public function getOrderDetailFromCrate($sql){
        $list = $this->conn->query($sql);
        if(empty($list)){
            return false;
        }
        return  $list->fetchAll();
    }
}
