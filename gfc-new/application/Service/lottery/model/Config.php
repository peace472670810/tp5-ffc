<?php
/**
 * Created by PhpStorm.
 * User: Jim FAN
 * Date: 2017/7/4
 * Time: 10:36
 * 系统配置信息
 */

namespace app\Service\lottery\model;
use think\Model;

class Config extends Model
{
    protected  $connection = [
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

    /**
     * 获取彩种配置信息
     */
    public function getLotConf($value){
        $lotconf = $this->where('ds_key','eq',$value)->find();
        return $lotconf->data;
    }

    /**
     * 获取彩种配置信息列表
     */
    public function getLotConfList(){
        $list = $this->query("select * from  ds_config where ds_key like 'G_%'");
        return $list;
    }

}