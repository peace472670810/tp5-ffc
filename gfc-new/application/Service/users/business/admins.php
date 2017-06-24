<?php
/**
 * Created by PhpStorm.
 * User: Jim FAN
 * Date: 2017/5/20
 * Time: 15:36
 */

namespace app\Service\users\business;
use  app\Service\users\model\Admins as model_admins;
use think\image\Exception;
class admins
{
    public static  $error_code = [
        '2000010'=>'格式错误！',
        '2000011'=>'无此用户名',
        '2000012'=>'不能添加该上级用户',
        '2000013'=>'验证码不能为空！',
        '2000014'=>'验证码错误！',
        '2000015'=>'子账户用户名有误！',
        '2000016'=>'用户名不能为空',
        '2000017'=>'密码不能为空',
        '2000018'=>'是否启用参数有误！',
        '2000019'=>'添加sql异常，请重新添加！',
        '2000020'=>'上级用户id有误！',
        '2000021'=>'上级用户名有误！',
        '2000022'=>'层级有误！',
        '2000023'=>'管理员id有误！',
        '2000024'=>'用户密码至少要8位！',
        '2000025'=>'改用户名已经存在！',
        '2000026'=>'昵称不能为空',

    ];
    public $admin_model = null;
    public function __construct()
    {
        $this->admin_model = new model_admins();
    }

    /**
     * 获取子账户列表
     *
     */
    public function admin_list($data = []){
       $data = data_decode($data);
        if(empty($data['u_parent_id'])&&!is_numeric($data['u_parent_id'])){
            return  put_encode(false,'2000015',self::$error_code['2000015']);
        }
        $list = $this->admin_model->query("select * from `ffc_admins` where u_parent_id='{$data['u_parent_id']}'");
        return put_encode($list,'','');
    }

    /**
     * 添加子账户列表
     */
    public function admin_add($data = []){
        $data = data_decode($data);
        $arr['u_username'] = $data['u_username'];
        $arr['u_nickname'] = $data['u_nickname'];
        $arr['u_is_enabled'] = $data['u_is_enabled'];
        $arr['u_reg_time'] = $data['u_reg_time'];
        $arr['u_parent_name'] = $data['u_parent_name'];
        $arr['u_level'] = $data['u_level'];
        $arr['u_parent_id'] = $data['u_parent_id'];
        $arr['u_pwd'] = $data['u_pwd'];
        if(empty($arr['u_username'])){
            return  put_encode(false,'2000016',self::$error_code['2000016']);
        }
        if(empty($arr['u_nickname'])){
            return  put_encode(false,'2000026',self::$error_code['2000026']);
        }
        $is_exit = json_decode($this->admin_model->where(['u_username'=>$arr['u_username']])->find(),true);
        if(is_array($is_exit)){
            return  put_encode(false,'2000025',self::$error_code['2000025']);
        }
        if(empty($arr['u_pwd'])){
            return  put_encode(false,'2000017',self::$error_code['2000017']);
        }else if(!empty($arr['u_pwd'])&&strlen($arr['u_pwd'])<8){
            return  put_encode(false,'2000024',self::$error_code['2000024']);
        }
        $arr['u_pwd'] = $this->admin_model->setPassword($arr['u_pwd']);
        if(empty($arr['u_parent_id'])){
            return  put_encode(false,'2000020',self::$error_code['2000020']);
        }
        if(empty($arr['u_level'])){
            return  put_encode(false,'2000021',self::$error_code['2000021']);
        }
        $res = $this->admin_model->save($arr);
        if($res){
            return put_encode(true,'','添加成功！');
        }
        return  put_encode(false,'2000019',self::$error_code['2000019']);
    }

    /**
     * 修改子账户列表
     * op = 0 获取  1 修改
     */
    public function admin_edit($data = []){
        $data = data_decode($data);
        if(empty($data['u_admin_id'])){
            return  put_encode(false,'2000023',self::$error_code['2000023']);
        }
        if($data['op']){
            $arr['u_username'] = $data['u_username'];
            $arr['u_is_enabled'] = $data['u_is_enabled'];
            $arr['u_reg_time'] = $data['u_reg_time'];
            $arr['u_parent_id'] = $data['u_parent_id'];
            $arr['u_parent_name'] = $data['u_parent_name'];
            $arr['u_level'] = $data['u_level'];
            $arr['u_nickname'] = $data['u_nickname'];

            if(empty($arr['u_username'])){
                return  put_encode(false,'2000016',self::$error_code['2000016']);
            }
            $is_exit = json_decode($this->admin_model->where(['u_username'=>$arr['u_username']])->where('u_admin_id','neq',$data['u_admin_id'])->find(),true);
            if(is_array($is_exit)){
                return  put_encode(false,'2000025',self::$error_code['2000025']);
            }
            if(empty($arr['u_nickname'])){
            return  put_encode(false,'2000026',self::$error_code['2000026']);
            }
            if(empty($data['u_pwd'])){
               unset($data['u_pwd']);
            }else if(!empty($data['u_pwd'])&&strlen($data['u_pwd'])<8){
                return  put_encode(false,'2000024',self::$error_code['2000024']);
            }
            if(!empty($data['u_pwd'])&&strlen($data['u_pwd'])>8){
              $arr['u_pwd'] = $this->admin_model->setPassword($data['u_pwd']);
            }        
            if(empty($arr['u_parent_id'])){
                return  put_encode(false,'2000020',self::$error_code['2000020']);
            }
            if(empty($arr['u_level'])){
                return  put_encode(false,'2000021',self::$error_code['2000021']);
            }
            $res = $this->admin_model->save($arr,['u_admin_id'=>$data['u_admin_id']]);
            if($res){
                return put_encode(true,'','修改成功！');
            }
            return  put_encode(false,'2000019',self::$error_code['2000019']);
        }else{

            return put_encode($this->admin_model->find(['u_admin_id'=>$data['u_admin_id']]),'','');
        }
    }
    /**
     * 管理员登陆
     * @param $data
     * @return string
     */
    public function admin_login($data){
        $data = data_decode($data);
        if(config('captcha')){
            $captcha = $data['verifyCode'];
            if(!$captcha){
                return put_encode(false,'2000013','验证码不能为空！');
            }
            if(!captcha_check($captcha,'',config('captcha'))){
                return  put_encode(false,'2000014','验证码错误！');
            }
        }
        try{
            $admin =  $this->admin_model->login($data['username'],$data['pwd']);
        }catch (Exception $e){
            return put_encode(false,$e->getCode(),$e->getMessage());
        }
        return put_encode($admin,'','登陆成功');
    }

    /**管理员登出
     * @return string
     */
    public function logout(){
        $admin =  $this->admin_model->logout();
        return put_encode($admin,'','退出成功！');
    }

}