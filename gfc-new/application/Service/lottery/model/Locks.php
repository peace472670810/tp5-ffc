<?php
/**
 * Created by PhpStorm.
 * User: Jim FAN
 * Date: 2017/8/4
 * Time: 21:08
 */

namespace app\Service\lottery\model;
use think\Model;

class Locks extends Model
{
    protected  $connection = [
        // 数据库类型
        'type'        => 'mysql',
        // 数据库连接DSN配置
        'dsn'         => '',
        // 服务器地址
        'hostname'    => '10.10.197.6',
        // 数据库名
        'database'    => 'ds_ffc_flocks',
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

    /**
     * 获取封锁值
     * @param array $data
     */
    public function  getLocks($data =[]){
        $mcodes = $data['mcodes'];
//        foreach ($mcodes as )
    }

    /**
     * 封锁值添加
     * @param array $data
     */
    public function addLocks($data = []){

    }
}