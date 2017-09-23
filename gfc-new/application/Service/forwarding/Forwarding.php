<?php
/**
 * Created by PhpStorm.
 * User: Jim FAN
 * Date: 2017/5/19
 * Time: 13:23
 */

namespace app\Service\forwarding;

use think\Loader;
use think\Log;
class  Forwarding
{
    protected  static  $error_code = [
        '1000001'=>'该类不存在！',
        '1000002'=>'类方法不存在！',
    ];
    protected  $modelName = '';
    protected  $method = '';
    protected  $model = null;
    protected  $input_data = '';
    protected  $output_data = '';

    /**
     * 初始化 工厂模式
     * @param $modelName
     * @param $method
     * @param $data
     */
    public function __construct($modelName='',$method='',$data='')
    {
        $this->modelName = $modelName;
        $this->method = $method;
        $this->input_data = $data;
        if(!class_exists($modelName)){
            halt($modelName);
            Log::record(str_replace('\\','\\\\',$modelName).self::$error_code['1000001'],'error');
            $this->utput_data = json_encode([
                'error_code' =>'1000001',
                'data' => '',
                'message'=>self::$error_code['1000001']
            ]);
        }else{
            $this->medel   = new $modelName();
        }
       $this-> _initialize();
    }

    public function  _initialize(){

    }

    /**
     *  子类需要重写
     */
    public  function put_data(){

    }
}