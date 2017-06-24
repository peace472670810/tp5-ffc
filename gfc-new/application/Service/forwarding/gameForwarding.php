<?php
/**
 * Created by PhpStorm.
 * User: Jim FAN
 * Date: 2017/5/19
 * Time: 15:41
 */

namespace app\Service\Forwarding;


class gameForwarding extends  Forwarding
{
    public function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
    }

    /**重写父类方法  这样写增强转发层的灵活性
     *  为了保持严谨与好维护和更好的封装性 各个模块传参都统一从方法传入，而不采用实例化的时候传入
     *  而且json 传入 json传出
     * @return string
     */
    public  function put_data(){
        try{
            $users = (Object)$this->medel;
            $method = $this->method;
            if(!method_exists($users,$method)){
                throw new Exception($this->modelName.self::$error_code['1000001'],'1000002');
            }
            return $users->$method($this->input_data);
        }catch (Exception $e){
            Log::record($e->getMessage(),'error');
            return $this->data = json_encode([
                'error_code' =>$e->getCode(),
                'data' => false,
                'message'=>$e->getMessage()
            ]);
        }
    }
}