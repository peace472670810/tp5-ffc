<?php 
namespace app\Service\drawhistory\model;
use think\Model;
class drawhistory extends Model
{
    protected $connection = [
        // 数据库类型
        'type'        => 'mysql',
        // 数据库连接DSN配置
        'dsn'         => '',
        // 服务器地址
        'hostname'    => '10.10.197.2',
        // 数据库名
        'database'    => 'ds_ffc_periods',
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
        'prefix'      => 'ds_',
    ];
}

 ?>