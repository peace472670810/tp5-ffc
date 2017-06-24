<?php
/**
 * Created by PhpStorm.
 * User: Jim FAN
 * Date: 2017/5/19
 * Time: 17:04
 */

namespace app\Service\users\business;
use think\Db;
use think\image\Exception;
use app\Service\users\model\Users as model_users;

class users 
{
    public static  $error_code = [
        '2000000'=>'格式错误！',
        '2000001'=>'无此用户名',
        '2000002'=>'层级参数错误！',
        '2000003'=>'验证码不能为空！',
        '2000004'=>'验证码错误！',
        '2000005' => '过滤参数有误！',
        '2000006' => '不能添加上一级用户',
        '2000007' => '对应用户表参数有误！',
        '2000108' => '总占成不能超过100%',
        '2000109' => '总占参数有误！',
        '2000110' => '过滤参数有误！',
        '2000112' => '添加失败！',
        '2000113' => '密码不能为空！',
        '2000114' => '密码不能少于8位！',
        '2000115' => '用户名已经存在！',
        '2000116' => '用户id有误！',
        '2000117' => '修改失败！',
        '2000118' => '用户名不能空！',
        '2000120' => '占成参数有误！',
        '2000121' => '占成参数有误！',
        '2000122' => '占成参数有误！',
        '2000123' => '占成参数有误！',
        '2000124' => '总占和值超过最大占成',
        '2000125' => '请刷新页面重新提交！',
        '2000126' => '非法修改账户名！',
        '2000127' => '提交数据有错误！',
    ];
    /**
     * 会员层级
     * @var array
     */
    public static  $level = [
        0=>'会员',
        1=>'代理',
        2=>'总代',
        3=>'股东',
        4=>'分公司',
        5=>'总公司'
    ];
    /**
     * 会员状态
     * @var array
     */
   public static $statue = [
        0=>'已删除',
        8=>'正常'
       ];
    /**
     *会员类型
     * @var array
     */
   public  static  $is_test = [
        1=>'正式账号',
        2 =>'测试账号'
   ];
    public $model = null;
    public function __construct()
    {
        $this->model = new model_users();
    }


    /**
     * 用户登录
     * @param $data
     */
    public function login($data){
        $data = data_decode($data);
        //会员登录
        return $this->user_login($data);
    }



    /**会员登陆
     * @param $data
     * @return string
     */
    public function user_login($data){
        return put_encode(true,'','登陆成功');
    }


    /**
     * 数据过滤
     * 内部用
     * op
     *  4用户列表
     * @param array $arr
     */
    protected function userFilter($arr = [],$op=1){
        $data = [];
        $res = [];
        $where = '';
        $res['sql'] = 'select  *  from  `ffc_users` where 1 ';
        $res['count'] = ' select  count(*)  from  `ffc_users` where 1  ';
        $data['u_level'] = $arr['u_level'];
        $data['u_is_test'] = $arr['u_is_test'];
        $data['u_status'] = $arr['u_status'];

        if(!empty($arr['u_is_test'])){
            $where .= " and  u_is_test = '{$data['u_is_test']}' ";
        }
        if(!empty($arr['u_status'])){
            $where .= " and u_status='{$data['u_status']}' ";
        }
        $page = empty($arr['page'])?0:$arr['page'];
        if(!is_numeric($data['u_level'])&&!is_numeric($data['u_is_test'])&&!is_numeric($data['u_status'])){
            throw new Exception(self::$error_code['2000005'],'2000005');
        }
        if(in_array('u_top_5',array_keys($arr))&&!empty($arr['u_top_5'])){
                $res['sql'] .= " and  u_top_5='{$arr['u_top_5']}'  ";
                $res['count'] .= " and  u_top_5='{$arr['u_top_5']}'  ";
        }else  if(in_array('u_top_4',array_keys($arr))&&!empty($arr['u_top_4'])){
                $res['sql'] .= " and  u_top_4='{$arr['u_top_4']}'  ";
                $res['count'] .= " and  u_top_4='{$arr['u_top_4']}'  ";
        }else  if(in_array('u_top_3',array_keys($arr))&&!empty($arr['u_top_3'])){
                $res['sql'] .= " and  u_top_3='{$arr['u_top_3']}'  ";
                $res['count'] .= " and  u_top_3='{$arr['u_top_3']}'  ";
        }else  if(in_array('u_top_2',array_keys($arr))&&!empty($arr['u_top_2'])){
                $res['sql'] .= " and  u_top_2='{$arr['u_top_2']}'  ";
                $res['count'] .= " and  u_top_2='{$arr['u_top_2']}'  ";
        }else  if(in_array('u_top_1',array_keys($arr))&&!empty($arr['u_top_1'])){
                $res['sql'] .= " and  u_top_1='{$arr['u_top_1']}'  ";
                $res['count'] .= " and  u_top_1='{$arr['u_top_1']}'  ";
        }
        switch ($op){
            case 0:
                if(!empty($arr['u_username'])){
                    $res['sql'] .= " and  u_top_1='{$arr['u_username']}'  ";
                    $res['count'] .= " and  u_top_1='{$arr['u_username']}'  ";
                }
                $res['sql'] .= "  and u_level =0 ".$where." limit  ".$page*DEFAULT_PER_PAGE.",".DEFAULT_PER_PAGE;
                $res['count'] .= "  and u_level =0  ".$where;
                break;
            case 1:
                if(!empty($arr['u_username'])){
                    $res['sql'] .= " and  u_top_2='{$arr['u_username']}'  ";
                    $res['count'] .= " and  u_top_2='{$arr['u_username']}'  ";
                }
                $res['sql'] .= "  and u_level =1 ".$where." limit  ".$page*DEFAULT_PER_PAGE.",".DEFAULT_PER_PAGE;
                $res['count'] .= "  and u_level =1  ".$where;
                break;
            case 2:
                if(!empty($arr['u_username'])){
                    $res['sql'] .= " and  u_top_3='{$arr['u_username']}'  ";
                    $res['count'] .= " and  u_top_3='{$arr['u_username']}'  ";
                }
                $res['sql'] .= "  and u_level =2 ".$where." limit  ".$page*DEFAULT_PER_PAGE.",".DEFAULT_PER_PAGE;
                $res['count'] .= "  and u_level =2  ".$where;
                break;
            case 3:
                if(!empty($arr['u_username'])){
                    $res['sql'] .= " and  u_top_4='{$arr['u_username']}'  ";
                    $res['count'] .= " and  u_top_4='{$arr['u_username']}'  ";
                }
                $res['sql'] .= "  and u_level =3 ".$where." limit  ".$page*DEFAULT_PER_PAGE.",".DEFAULT_PER_PAGE;
                $res['count'] .= "  and u_level =3  ".$where;
                break;
            case 4:
                if(!empty($arr['u_username'])){
                    $res['sql'] .= " and  u_top_5='{$arr['u_username']}'  ";
                    $res['count'] .= " and  u_top_5='{$arr['u_username']}'  ";
                }

                $res['sql'] .= "  and u_level = 4 ".$where." limit  ".$page*DEFAULT_PER_PAGE.",".DEFAULT_PER_PAGE;
                $res['count'] .= "  and u_level = 4 ".$where;
                break;
            case 5:break;
        }
        $res['pre'] = ($page-1)<=0?0:($page -1);
        $res['next'] = $page+1;
        $res['start'] = DEFAULT_PER_PAGE*$page+1;
        $res['end'] = DEFAULT_PER_PAGE*($page+1);

        return $res;
    }
    /**
     * 用户列表
     * level  层级
     * u_username  用户名
     * u_is_test 类型   1不是 2测试帐号
     * u_status  状态 0已删除  8正常
     * page 当前页数
     * @param array $arr
     * @return string
     */
    public function  Userlist($arr=[]){
        $data = [];
        try{
            $filter =  $this->userFilter($arr,$arr['op']);           
            $data['list'] = $this->model->query($filter['sql']);
            $count = $this->model->query($filter['count']);
            $data['page']['count'] =  $count[0]['count(*)'];
            $data['page']['pre'] = $filter['pre'];
            $data['page']['next'] = $filter['next'];
            $data['page']['total'] = ceil($data['page']['count']/DEFAULT_PER_PAGE);
            $data['page']['start'] = $filter['start'];
            $data['page']['end'] = $filter['end'];
            return put_encode($data,'','');
        }catch (Exception $e){
            return  put_encode(false,$e->getCode(),$e->getMessage());
        }
     }

    /**
     * 密码加密
     * @param $value
     * @return string
     */
    public function setPassword($value){
        return md5($value);
    }

    /**
     * 添加公司或用户数据过滤
     * @param array $data
     * @param int $op
     * @return array
     */
    public function addFilter($data = [],$op=0){
        $arr = [];
        switch ($op){
            case 0: 
               if(empty($data['u_pwd'])){
                    throw new Exception(self::$error_code['2000113'],'2000113');
                }
                if(strlen($data['u_pwd'])<8){
                    throw new Exception(self::$error_code['2000114'],'2000114');
                }
                $test['u_id']=$data['u_id'];
                $test['u_username']=$data['u_top_1'];
                $dataes=json_decode($this->model->where($test)->find(),true);
                if(empty($dataes)){
                     throw new Exception(self::$error_code['2000125'],'2000125');
                }
                $arr['users']['u_username'] = $data['u_username'];
                $arr['users']['u_own_level']=$dataes['u_own_level'];
                $arr['users']['u_level'] = 0;
                $arr['users']['u_top_5'] = $dataes['u_top_5'];
                $arr['users']['u_top_4'] = $dataes['u_top_4'];
                $arr['users']['u_top_3'] = $dataes['u_top_3'];
                $arr['users']['u_top_2'] = $dataes['u_top_2'];
                $arr['users']['u_top_1'] = $dataes['u_top_1'];
                $arr['users']['u_proportion_5'] = $dataes['u_proportion_5'];
                $arr['users']['u_proportion_4'] = $dataes['u_proportion_4'];
                $arr['users']['u_proportion_3'] = $dataes['u_proportion_3'];
                $arr['users']['u_proportion_2'] = $dataes['u_proportion_2'];
                $arr['users']['u_proportion_1'] = $dataes['u_proportion_1'];
                $arr['users']['u_pwd'] = $data['u_pwd'];
                $arr['users']['u_nick_name'] = $data['u_nick_name'];
                $arr['users']['u_reg_time'] = date('Y-m-d H:i:s');
                $arr['users']['u_status'] = $data['u_status'];
                $arr['users']['u_is_test'] = $data['u_is_test'];            
                $arr['users']['u_pwd'] = $this->setPassword($arr['users']['u_pwd']);
                $arr['users']['u_is_test'] = empty($data['u_is_test'])?1:$data['u_is_test'];
                break;
            case 1:
                if($data['u_proportion_1']<0||$data['u_proportion_1']>100){
                    throw new Exception(self::$error_code['2000123'],'2000123');
                }
                if($data['u_proportion_2']<0||$data['u_proportion_2']>100){
                    throw new Exception(self::$error_code['2000122'],'2000122');
                }
                
                if(empty($data['u_pwd'])){
                    throw new Exception(self::$error_code['2000113'],'2000113');
                }
                if(strlen($data['u_pwd'])<8){
                    throw new Exception(self::$error_code['2000114'],'2000114');
                }
                $test['u_id']=$data['u_id'];
                $test['u_username']=$data['u_top_2'];
                $dataes=json_decode($this->model->where($test)->find(),true);
                if(empty($dataes)){
                     throw new Exception(self::$error_code['2000125'],'2000125');
                }
                if(($data['u_proportion_2']+$data['u_proportion_1'])>$dataes['u_proportion_2']){
                    throw new Exception(self::$error_code['2000124'],'2000124');
                }
                $arr['users']['u_username'] = $data['u_username'];
                $arr['users']['u_own_level']=$dataes['u_own_level'];
                $arr['users']['u_level'] = 1;
                $arr['users']['u_top_5'] = $dataes['u_top_5'];
                $arr['users']['u_top_4'] = $dataes['u_top_4'];
                $arr['users']['u_top_3'] = $dataes['u_top_3'];
                $arr['users']['u_top_2'] = $dataes['u_username'];
                $arr['users']['u_proportion_5'] = $dataes['u_proportion_5'];
                $arr['users']['u_proportion_4'] = $dataes['u_proportion_4'];
                $arr['users']['u_proportion_3'] = $dataes['u_proportion_3'];
                $arr['users']['u_proportion_2'] = empty($data['u_proportion_2'])?0:$data['u_proportion_2'];
                $arr['users']['u_proportion_1'] = empty($data['u_proportion_1'])?0:$data['u_proportion_1'];
                $arr['users']['u_pwd'] = $data['u_pwd'];
                $arr['users']['u_nick_name'] = $data['u_nick_name'];
                $arr['users']['u_reg_time'] = date('Y-m-d H:i:s');
                $arr['users']['u_status'] = $data['u_status'];                    
                $arr['users']['u_pwd'] = $this->setPassword($arr['users']['u_pwd']);
                $arr['users']['u_is_test'] = empty($data['u_is_test'])?1:$data['u_is_test'];
                $arr['p_id'] = $data['u_id'];
                break;
            case 2:
                if($data['u_proportion_3']<0||$data['u_proportion_3']>100){
                    throw new Exception(self::$error_code['2000120'],'2000120');
                }
                if($data['u_proportion_2']<0||$data['u_proportion_2']>100){
                    throw new Exception(self::$error_code['2000122'],'2000122');
                }
                
                if(empty($data['u_pwd'])){
                    throw new Exception(self::$error_code['2000113'],'2000113');
                }
                if(strlen($data['u_pwd'])<8){
                    throw new Exception(self::$error_code['2000114'],'2000114');
                }
                $test['u_id']=$data['u_id'];
                $test['u_username']=$data['u_top_3'];
                $dataes=json_decode($this->model->where($test)->find(),true);
                if(empty($dataes)){
                     throw new Exception(self::$error_code['2000125'],'2000125');
                }
                
                if(($data['u_proportion_3']+$data['u_proportion_2'])>$dataes['u_proportion_3']){
                    throw new Exception(self::$error_code['2000124'],'2000124');
                }
                $arr['users']['u_own_level']=$dataes['u_own_level'];
                $arr['users']['u_username'] = $data['u_username'];
                $arr['users']['u_level'] = 2;
                $arr['users']['u_top_5'] = $dataes['u_top_5'];
                $arr['users']['u_top_4'] = $dataes['u_top_4'];
                $arr['users']['u_top_3'] = $dataes['u_username'];
                $arr['users']['u_proportion_5'] =$dataes['u_proportion_5'];
                $arr['users']['u_proportion_4'] =$dataes['u_proportion_4'];
                $arr['users']['u_proportion_3'] = empty($data['u_proportion_3'])?0:$data['u_proportion_3'];
                $arr['users']['u_proportion_2'] = empty($data['u_proportion_2'])?0:$data['u_proportion_2'];
                $arr['users']['u_pwd'] = $data['u_pwd'];
                $arr['users']['u_nick_name'] = $data['u_nick_name'];
                $arr['users']['u_reg_time'] = date('Y-m-d H:i:s');
                $arr['users']['u_status'] = $data['u_status'];
                $arr['users']['u_pwd'] = $this->setPassword($arr['users']['u_pwd']);
                $arr['users']['u_is_test'] = empty($data['u_is_test'])?1:$data['u_is_test'];
                $arr['p_id'] = $data['u_id'];
                break;
            case 3:                 
                if($data['u_proportion_4']<0||$data['u_proportion_4']>100){
                    throw new Exception(self::$error_code['2000108'],'2000108');
                }
                if($data['u_proportion_3']<0||$data['u_proportion_3']>100){
                    throw new Exception(self::$error_code['2000120'],'2000120');
                }

                if(empty($data['u_pwd'])){
                    throw new Exception(self::$error_code['2000113'],'2000113');
                }
                if(strlen($data['u_pwd'])<8){
                    throw new Exception(self::$error_code['2000114'],'2000114');
                }
 
                $test['u_id']=$data['u_id'];
                $test['u_username']=$data['u_top_4'];
                $dataes=json_decode($this->model->where($test)->find(),true);
                if(empty($dataes)){
                     throw new Exception(self::$error_code['2000125'],'2000125');
                }
                
                if(($data['u_proportion_4']+$data['u_proportion_3'])>$dataes['u_proportion_4']){
                    throw new Exception(self::$error_code['2000124'],'2000124');
                }
                $arr['users']['u_own_level']=$dataes['u_own_level'];
                $arr['users']['u_top_5']=$dataes['u_top_5'];
                $arr['users']['u_top_4']=$dataes['u_username'];
                $arr['users']['u_proportion_5']=$dataes['u_proportion_5'];
                $arr['users']['u_username'] = $data['u_username'];
                $arr['users']['u_level'] = 3;
                $arr['users']['u_proportion_4'] = empty($data['u_proportion_4'])?0:$data['u_proportion_4'];
                $arr['users']['u_proportion_3'] = empty($data['u_proportion_3'])?0:$data['u_proportion_3'];
                $arr['users']['u_pwd'] = $data['u_pwd'];
                $arr['users']['u_nick_name'] = $data['u_nick_name'];
                $arr['users']['u_reg_time'] = date('Y-m-d H:i:s');
                $arr['users']['u_status'] = $data['u_status'];
                $arr['users']['u_pwd'] = $this->setPassword($arr['users']['u_pwd']);
                $arr['users']['u_is_test'] = empty($data['u_is_test'])?1:$data['u_is_test'];
                $arr['p_id'] = $data['u_id'];
                break;
            case 4:
                $arr['users']['u_username'] = $data['u_username'];
                $arr['users']['u_own_level']=$data['u_own_level'];
                $arr['users']['u_level'] = 4;
                $arr['users']['u_top_5'] = $data['u_top_5'];
                $arr['users']['u_proportion_5'] = empty($data['u_proportion_5'])?0:$data['u_proportion_5'];
                $arr['users']['u_proportion_4'] = empty($data['u_proportion_4'])?0:$data['u_proportion_4'];
                $arr['users']['u_pwd'] = $data['u_pwd'];
                $arr['users']['u_nick_name'] = $data['u_nick_name'];
                $arr['users']['u_reg_time'] = date('Y-m-d H:i:s');
                $arr['users']['u_status'] = $data['u_status'];
                if($arr['users']['u_proportion_4']<0||$arr['users']['u_proportion_4']>100){
                    throw new Exception(self::$error_code['2000109'],'2000109');
                }
                if($arr['users']['u_proportion_5']<0||$arr['users']['u_proportion_5']>100){
                    throw new Exception(self::$error_code['2000109'],'2000109');
                }
                if(($arr['users']['u_proportion_4']+$arr['users']['u_proportion_5'])>100){
                    throw new Exception(self::$error_code['2000108'],'2000108');
                }
                if(empty($arr['users']['u_pwd'])){
                    throw new Exception(self::$error_code['2000113'],'2000113');
                }
                if(strlen($arr['users']['u_pwd'])<8){
                    throw new Exception(self::$error_code['2000114'],'2000114');
                }
                $arr['users']['u_pwd'] = $this->setPassword($arr['users']['u_pwd']);
                $arr['users']['u_is_test'] = empty($data['u_is_test'])?1:$data['u_is_test'];
                $arr['p_id'] = $data['u_id'];
                break;
        }
        return $arr;
    }
    /**
     * 添加代理
     */

    /**
     * 添加分公司
     */
    public  function addUser4($data){
        
        return $this->addUser($data,4);
    }
    /**
     * 添加股东
     */

    public function addUser3($data){
        return $this->addUser($data,3);
    }
    /**
     * 添加总代
     */

    public function addUser2($data){
        return $this->addUser($data,2);
    }
    /**
     * 添加代理
     */

    public function addUser1($data){
        return $this->addUser($data,1);
    }

    /**
     *
     * 添加会员
     */
    public function addUser0($data){
        return $this->addUser($data,0);
    }
    /**
     * 判断用户名是否存在
     */
    public function user_isExit($u_username){
        $is_exit = $this->model->where('u_username','eq',$u_username)->find();
        if(empty($is_exit)){
            return false;
        }
        return true;
    }
    /**
     * 事务添加操作
     * 步骤：
     * 1.添加用户
     * 2.上级层级+1
     * 3.子账户添加
     */
    public function addUser($data=[],$u_level){
        try{
            $u_data = $this->addFilter($data,$u_level);
            if($this->user_isExit($u_data['users']['u_username'])){
                return  put_encode(false,'2000115',self::$error_code['2000115']);
            }
            Db::startTrans();
            $inset_u_id = Db::table('ffc_users')->insertGetId($u_data['users']);
            switch ($u_level){
                case 0:
                    Db::query("update `ffc_users` set u_count_0=u_count_0+1 where u_username='{$u_data['users']['u_top_5']}'");
                    Db::query("update `ffc_users` set u_count_0=u_count_0+1 where u_username='{$u_data['users']['u_top_4']}'");
                    Db::query("update `ffc_users` set u_count_0=u_count_0+1 where u_username='{$u_data['users']['u_top_3']}'");
                    Db::query( "update `ffc_users` set u_count_0=u_count_0+1 where u_username='{$u_data['users']['u_top_2']}'");
                    Db::query( "update `ffc_users` set u_count_0=u_count_0+1 where u_username='{$u_data['users']['u_top_1']}'");
                    break;
                case 1:
                    Db::query("update `ffc_users` set u_count_1=u_count_1+1 where u_username='{$u_data['users']['u_top_5']}'");
                    Db::query("update `ffc_users` set u_count_1=u_count_1+1 where u_username='{$u_data['users']['u_top_4']}'");
                    Db::query("update `ffc_users` set u_count_1=u_count_1+1 where u_username='{$u_data['users']['u_top_3']}'");
                    Db::query("update `ffc_users` set u_count_1=u_count_1+1 where u_username='{$u_data['users']['u_top_2']}'");
                    break;
                case 2:
                    Db::query("update `ffc_users` set u_count_2=u_count_2+1 where u_username='{$u_data['users']['u_top_5']}'");
                    Db::query( "update `ffc_users` set u_count_2=u_count_2+1 where u_username='{$u_data['users']['u_top_4']}'");
                    Db::query("update `ffc_users` set u_count_2=u_count_2+1 where u_username='{$u_data['users']['u_top_3']}'");
                    break;
                case 3:
                    Db::query( "update `ffc_users` set u_count_3=u_count_3+1 where u_username='{$u_data['users']['u_top_5']}'");
                    Db::query( "update `ffc_users` set u_count_3=u_count_3+1  where u_username='{$u_data['users']['u_top_4']}'");
                    break;
                case 4:
                    Db::query( "update `ffc_users` set u_count_4=u_count_4+1  where u_username='{$u_data['users']['u_top_5']}'");
                    break;
            }
            if($u_level != 0){
                $ad_data['u_id'] = $inset_u_id;
                $ad_data['u_name'] = $u_data['users']['u_username'];
                $ad_data['u_username'] = $u_data['users']['u_username'];
                $ad_data['u_reg_time'] = $u_data['users']['u_reg_time'];
                $ad_data['u_update_time'] = date('Y-m-d H:i:s');
                $ad_data['u_pwd'] = $u_data['users']['u_pwd'];
                $ad_data['u_level'] = $u_data['users']['u_level'];
                Db::table('ffc_admins')->insertGetId($ad_data);
            }
            Db::commit();
        }catch (Exception $e){
            Db::rollback();
            return put_encode(false,$e->getCode(),$e->getMessage());
        }
        return put_encode(true,'','添加成功！');
    }

    /**
     * 编辑数据过滤
     */
    public function editFilter($data = [],$op){
        $arr = [];
        switch ($op){
            case 0: 
                if((!empty($data['u_pwd']))&&strlen($data['u_pwd'])<8){
                    throw new Exception(self::$error_code['2000114'],'2000114');
                }
                if(empty($data['u_pwd'])){ 
                    unset($data['u_pwd']);
                }
                if(!empty($data['u_pwd'])){
                    $arr['users']['u_pwd']= $this->setPassword($data['u_pwd']);
                }
                  if($data['u_username']!==$data['u_top_0']){       
                       throw new Exception(self::$error_code['2000116'],'2000116');
                  } 
                $arr['users']['u_nick_name'] = $data['u_nick_name'];
                $arr['users']['u_status'] = $data['u_status'];
                $arr['users']['u_is_test'] = $data['u_is_test'];              
                $arr['users']['u_is_test'] = empty($data['u_is_test'])?1:$data['u_is_test'];
                $arr['where'] = ['u_id'=>$data['u_id']];
             break;
            case 1:
                  if($data['u_username']!==$data['u_top_1']){       
                       throw new Exception(self::$error_code['2000116'],'2000116');
                  } 
                  if($data['u_proportion_2']!==$data['u_proportion_hidden2']||$data['u_proportion_1']!==$data['u_proportion_hidden1']){
                        if($data['u_proportion_2']<0||$data['u_proportion_2']>100){
                            throw new Exception(self::$error_code['2000109'],'2000109');
                        }
                        if($data['u_proportion_1']<0||$data['u_proportion_1']>100){
                            throw new Exception(self::$error_code['2000121'],'2000121');
                        }
                         $test=json_decode($this->model->field('u_proportion_2,u_proportion_3,u_proportion_4,u_proportion_5')->where('u_username',$data['u_top_2'])->find(),true);
                        if(empty($test)){
                          throw new Exception(self::$error_code['2000125'],'2000125');
                        }
                        if(($data['u_proportion_2']+$data['u_proportion_1'])>($test['u_proportion_2'])){
                            throw new Exception(self::$error_code['2000124'],'2000124');
                        }
                        if(($test['u_proportion_4']+$test['u_proportion_5']+$test['u_proportion_3']+$data['u_proportion_2']+$data['u_proportion_1'])>100){
                            throw new Exception(self::$error_code['2000108'],'2000108');
                        }
                   $arr['users']['u_proportion_5'] = empty($test['u_proportion_5'])?0:$test['u_proportion_5'];
                   $arr['users']['u_proportion_4'] = empty($test['u_proportion_4'])?0:$test['u_proportion_4'];
                   $arr['users']['u_proportion_3'] = empty($test['u_proportion_3'])?0:$test['u_proportion_3'];
                   $arr['users']['u_proportion_2'] = empty($data['u_proportion_2'])?0:$data['u_proportion_2'];
                   $arr['users']['u_proportion_1'] = empty($data['u_proportion_1'])?0:$data['u_proportion_1'];
                }
                 if($data['u_status']!==$data['status']){
                    if(is_numeric($data['u_status'])){
                        $arr['users']['u_status'] = $data['u_status'];
                    }else{
                        throw new Exception(self::$error_code['2000127'],'2000127');
                    }             
                 }  
                $arr['users']['u_pwd'] = $data['u_pwd'];
                $arr['users']['u_nick_name'] = $data['u_nick_name'];
                if((!empty($arr['users']['u_pwd']))&&strlen($arr['users']['u_pwd'])<8){
                    throw new Exception(self::$error_code['2000114'],'2000114');
                }
                if(empty($arr['users']['u_pwd'])){
                    unset($arr['users']['u_pwd']);
                }
                if(!empty($arr['users']['u_pwd'])){
                    $arr['users']['u_pwd'] = $this->setPassword($arr['users']['u_pwd']);
                }
                $arr['users']['u_is_test'] = empty($data['u_is_test'])?1:$data['u_is_test'];
                $arr['where'] = ['u_id'=>$data['u_id']];
                break;
            case 2:
                  if($data['u_username']!==$data['u_top_2']){
                        throw new Exception(self::$error_code['2000116'],'2000116');
                  }         
                  if($data['u_proportion_2']!==$data['u_proportion_hidden2']||$data['u_proportion_3']!==$data['u_proportion_hidden3']){
                        if($data['u_proportion_3']<0||$data['u_proportion_3']>100){
                            throw new Exception(self::$error_code['2000121'],'2000121');
                        }
                        if($data['u_proportion_2']<0||$data['u_proportion_2']>100){
                            throw new Exception(self::$error_code['2000121'],'2000121');
                        }
                        $test=json_decode($this->model->field('u_proportion_3,u_proportion_4,u_proportion_5')->where('u_username',$data['u_top_3'])->find(),true);
                        if(empty($test)){
                          throw new Exception(self::$error_code['2000125'],'2000125');
                        }
                        if(($data['u_proportion_3']+$data['u_proportion_2'])>($test['u_proportion_3'])){
                             throw new Exception(self::$error_code['2000124'],'2000124');
                         }

                        if(($test['u_proportion_4']+$test['u_proportion_5']+$data['u_proportion_3']+$data['u_proportion_2'])>100){
                            throw new Exception(self::$error_code['2000108'],'2000108');
                        }
                        
                       $arr['users']['u_proportion_5'] = empty($test['u_proportion_5'])?0:$test['u_proportion_5'];
                       $arr['users']['u_proportion_4'] = empty($test['u_proportion_4'])?0:$test['u_proportion_4'];
                       $arr['users']['u_proportion_3'] = empty($data['u_proportion_3'])?0:$data['u_proportion_3'];
                       $arr['users']['u_proportion_2'] = empty($data['u_proportion_2'])?0:$data['u_proportion_2'];
                 }
               
                $arr['users']['u_pwd'] = $data['u_pwd'];
                $arr['users']['u_nick_name'] = $data['u_nick_name'];
                if($data['u_status']!==$data['status']){
                    if(is_numeric($data['u_status'])){
                        $arr['users']['u_status'] = $data['u_status'];
                    }else{
                        throw new Exception(self::$error_code['2000127'],'2000127');
                    }             
                 }  
                if((!empty($arr['users']['u_pwd']))&&strlen($arr['users']['u_pwd'])<8){
                    throw new Exception(self::$error_code['2000114'],'2000114');
                }
                if(empty($arr['users']['u_pwd'])){
                    unset($arr['users']['u_pwd']);
                }
                if(!empty($arr['users']['u_pwd'])){
                    $arr['users']['u_pwd'] = $this->setPassword($arr['users']['u_pwd']);
                }
                $arr['users']['u_is_test'] = empty($data['u_is_test'])?1:$data['u_is_test'];
                $arr['where'] = ['u_id'=>$data['u_id']];
                break;
            case 3:
                 if($data['u_username']!==$data['u_top_3']){
                      throw new Exception(self::$error_code['2000116'],'2000116');
                 }         
                 if($data['u_proportion_4']!==$data['u_proportion_hidden4']||$data['u_proportion_3']!==$data['u_proportion_hidden3']){                                                   
                        if($data['u_proportion_4']<0||$data['u_proportion_4']>100){
                            throw new Exception(self::$error_code['2000109'],'2000109');
                        }               
                        if($data['u_proportion_3']<0||$data['u_proportion_3']>100){
                            throw new Exception(self::$error_code['2000121'],'2000121');
                        }
                                      
                        $test=json_decode($this->model->field('u_proportion_4,u_proportion_5')->where('u_username',$data['u_top_4'])->find(),true);

                        if(empty($test)){
                          throw new Exception(self::$error_code['2000125'],'2000125');
                        }                
                        if(($data['u_proportion_4']+$data['u_proportion_3']) > $test['u_proportion_4']){
                           throw new Exception(self::$error_code['2000124'],'2000124');
                        }
                        if(($data['u_proportion_4']+$test['u_proportion_5']+$data['u_proportion_3'])>100){
                            throw new Exception(self::$error_code['2000108'],'2000108');
                        }
                       $arr['users']['u_proportion_5'] = empty($test['u_proportion_5'])?0:$test['u_proportion_5'];
                       $arr['users']['u_proportion_4'] = empty($data['u_proportion_4'])?0:$data['u_proportion_4'];
                       $arr['users']['u_proportion_3'] = empty($data['u_proportion_3'])?0:$data['u_proportion_3'];

                 }
                if($data['u_status']!==$data['status']){
                    if(is_numeric($data['u_status'])){
                        $arr['users']['u_status'] = $data['u_status'];
                    }else{
                        throw new Exception(self::$error_code['2000127'],'2000127');
                    }             
                 }  
                $arr['users']['u_pwd'] = $data['u_pwd'];
                $arr['users']['u_nick_name'] = $data['u_nick_name'];
                if((!empty($arr['users']['u_pwd']))&&strlen($arr['users']['u_pwd'])<8){
                    throw new Exception(self::$error_code['2000114'],'2000114');
                }
                if(empty($arr['users']['u_pwd'])){
                    unset($arr['users']['u_pwd']);
                }
                if(!empty($arr['users']['u_pwd'])){
                    $arr['users']['u_pwd'] = $this->setPassword($arr['users']['u_pwd']);
                }          
                $arr['where'] = ['u_id'=>$data['u_id']];
                break;
            case 4:
                 if($data['u_username']!==$data['u_top_4']){                                         
                     throw new Exception(self::$error_code['2000116'],'2000116');
                  }    
                  if($data['u_own_level']!=$data['u_own']){
                   $arr['users']['u_own_level']=$data['u_own_level'];    
                  }
                  if($data['u_proportion_4']!==$data['u_proportion_hidden4']||$data['u_proportion_5']!==$data['u_proportion_hidden5']){
                       
                        if($data['u_proportion_4']<0||$data['u_proportion_4']>100){
                           throw new Exception(self::$error_code['2000109'],'2000109');
                         }
                        if($data['u_proportion_5']<0||$data['u_proportion_5']>100){
                           throw new Exception(self::$error_code['2000109'],'2000109');
                         }
                        if(($data['u_proportion_4']+$data['u_proportion_5'])>100){
                           throw new Exception(self::$error_code['2000108'],'2000108');
                         }
                         $arr['users']['u_proportion_5'] = empty($data['u_proportion_5'])?0:$data['u_proportion_5'];
                         $arr['users']['u_proportion_4'] = empty($data['u_proportion_4'])?0:$data['u_proportion_4'];
                 }
                 if($data['u_status']!==$data['status']){
                    if(is_numeric($data['u_status'])){
                        $arr['users']['u_status'] = $data['u_status'];
                    }else{
                        throw new Exception(self::$error_code['2000127'],'2000127');
                    }             
                 }            
                $arr['users']['u_pwd'] = $data['u_pwd'];
                $arr['users']['u_nick_name'] = $data['u_nick_name'];                
                if((!empty($arr['users']['u_pwd']))&&strlen($arr['users']['u_pwd'])<8){
                    throw new Exception(self::$error_code['2000114'],'2000114');
                }
                if(empty($arr['users']['u_pwd'])){
                   unset($arr['users']['u_pwd']);
                }
                if(!empty($arr['users']['u_pwd'])){
                    $arr['users']['u_pwd'] = $this->setPassword($arr['users']['u_pwd']);
                }
                $arr['where'] = ['u_id'=>$data['u_id']];
                break;
        }
        return $arr;
    }
    /**
     * 分公司编辑
     */
    public function editUser4($data = []){
        $arr = [];
        $op = $data['op'];
        if($op){
            try{
                $arr = $this->editFilter($data,4);
                $top='';
                $dataes='';
                $admin='';
               
            //$top根据过滤参数判断是否更新user u_top_4 占成比 和 用户名
            //$dataes根据过滤参数判断是否同时更新 admins用户名和密码
            //$admin根据过滤参数判断是否同时更新 上级用户名
                if(!empty($arr['users']['u_proportion_5'])||!empty($arr['users']['u_proportion_4'])){
                    $top['users']['u_proportion_5']=$arr['users']['u_proportion_5'];
                    $top['users']['u_proportion_4']=$arr['users']['u_proportion_4'];
                    $top['users']['u_proportion_3']='0';
                    $top['users']['u_proportion_2']='0';
                    $top['users']['u_proportion_1']='0';                  
                }           
                // if(!empty($arr['users']['u_username'])){
                //    $top['users']['u_top_4']=$arr['users']['u_username'];
                //    $dataes['admins']['u_username']=$arr['users']['u_username'];
                //    $dataes['admins']['u_name']=$arr['users']['u_username'];
                //    $admin['admins']['u_parent_name']=$arr['users']['u_username'];
                //    $admin['where']['u_parent_name']=$arr['name'];
                // }
                if(!empty($arr['users']['u_status'])){
                    $top['users']['u_status']=$arr['users']['u_status'];
                }
                if(!empty($arr['users']['u_own_level'])){
                    $top['users']['u_own_level']=$arr['users']['u_own_level'];
                }
                if(!empty($arr['users']['u_proportion_5'])||!empty($arr['users']['u_status'])||!empty($arr['users']['u_own_level'])){
                    $top['where']['u_top_4']=$data['u_top_4'];  
                }  
                if(!empty($arr['users']['u_pwd'])){
                    $dataes['admins']['u_pwd']=$arr['users']['u_pwd']; 
                    $dataes['where']['u_id']= $arr['where']['u_id'];
                }
            }catch (Exception $e){
                return put_encode(false,$e->getCode(),$e->getMessage());
            }
                 
            if($res = $this->editUser($arr,$top,$dataes,$admin)){

                return put_encode(true,'','修改成功！');
            }else{
                return put_encode(false,'2000117',self::$error_code['2000117']);
            }
        }else{
            $arr['u_id'] = $data['u_id'];
            if(!is_numeric($arr['u_id'])){
                return put_encode(false,'2000116',self::$error_code['2000116']);
            }
            return put_encode($this->model->find($arr),'','');
        }
    }
    /**
     * 股东编辑
     */
    public function editUser3($data = []){
        $arr = [];
        $op = $data['op'];
        if($op){
            try{
                $arr = $this->editFilter($data,3);
                $top='';
                $dataes='';
                $admin='';
            //$top根据过滤参数判断是否更新占成比 和 用户名
            //$dataes根据过滤参数判断是否同时更新 用户名和密码
                if(!empty($arr['users']['u_proportion_4'])||!empty($arr['users']['u_proportion_3'])){
                    $top['users']['u_proportion_4']=$arr['users']['u_proportion_4'];
                    $top['users']['u_proportion_3']=$arr['users']['u_proportion_3'];
                    $top['users']['u_proportion_2']='0';
                    $top['users']['u_proportion_1']='0';                  
                }   
                if(!empty($arr['users']['u_status'])){
                    $top['users']['u_status']=$arr['users']['u_status'];
                }        
                if(!empty($arr['users']['u_proportion_4'])||!empty($arr['users']['u_status'])){
                    $top['where']['u_top_3']=$data['u_top_3'];  
                }  
                if(!empty($arr['users']['u_pwd'])){
                    $dataes['admins']['u_pwd']=$arr['users']['u_pwd']; 
                     $dataes['where']['u_id']= $arr['where']['u_id']; 
                }

            }catch (Exception $e){
                return put_encode(false,$e->getCode(),$e->getMessage());
            }
            if($res = $this->editUser($arr,$top,$dataes,$admin)){
                return put_encode(true,'','修改成功！');
            }else{
                return put_encode(false,'2000117',self::$error_code['2000117']);
            }
        }else{
            $arr['u_id'] = $data['u_id'];
            if(!is_numeric($arr['u_id'])){
                return put_encode(false,'2000116',self::$error_code['2000116']);
            }
            $dataes=json_decode($this->model->find($arr),true);
           //halt($dataes);
           
            return $dataes;
        }
    }
     /**
     * 总代编辑
     */
    public function editUser2($data = []){
        $arr = [];
        $op = $data['op'];
        if($op){            
            try{
                $arr = $this->editFilter($data,2);
                $top='';
                $dataes='';
                $admin='';
            //$top根据过滤参数判断是否更新占成比 和 用户名
            //$dataes根据过滤参数判断是否同时更新 用户名和密码
                if(!empty($arr['users']['u_proportion_3'])||!empty($arr['users']['u_proportion_2'])){
                    $top['users']['u_proportion_3']=$arr['users']['u_proportion_3'];
                    $top['users']['u_proportion_2']=$arr['users']['u_proportion_2'];

                    $top['users']['u_proportion_1']='0';                 
                }  
                if(!empty($arr['users']['u_status'])){
                    $top['users']['u_status']=$arr['users']['u_status'];
                }          
                if(!empty($arr['users']['u_proportion_3'])||!empty($arr['users']['u_status'])){
                    $top['where']['u_top_2']=$data['u_top_2'];  
                }  
                if(!empty($arr['users']['u_pwd'])){
                    $dataes['admins']['u_pwd']=$arr['users']['u_pwd']; 
                    $dataes['where']['u_id']= $arr['where']['u_id'];
                }      
            }catch (Exception $e){
                return put_encode(false,$e->getCode(),$e->getMessage());
            }
            if($res = $this->editUser($arr,$top,$dataes,$admin)){
                
                return put_encode(true,'','修改成功！');
            }else{
                
                return put_encode(false,'2000117',self::$error_code['2000117']);
            }
        }else{
            $arr['u_id'] = $data['u_id'];
            if(!is_numeric($arr['u_id'])){
                return put_encode(false,'2000116',self::$error_code['2000116']);
            }
            $dataes=json_decode($this->model->find($arr),true);
            return $dataes;
            
        }
    }
     /**
     * 代理编辑
     */
    public function editUser1($data = []){
        $arr = [];
        $op = $data['op'];
        if($op){
            try{
                $arr = $this->editFilter($data,1);

                $top='';
                $dataes='';
                $admin='';
            //$top根据过滤参数判断是否更新占成比 和 用户名
            //$dataes根据过滤参数判断是否同时更新 用户名和密码
                if(!empty($arr['users']['u_proportion_2'])||!empty($arr['users']['u_proportion_1'])){
                    $top['users']['u_proportion_1']=$arr['users']['u_proportion_1'];
                    $top['users']['u_proportion_2']=$arr['users']['u_proportion_2'];               
                }           
                if(!empty($arr['users']['u_status'])){
                    $top['users']['u_status']=$arr['users']['u_status'];
                }  
                if(!empty($arr['users']['u_proportion_2'])||!empty($arr['users']['u_status'])){
                    $top['where']['u_top_1']=$data['u_top_1'];  
                }  
                if(!empty($arr['users']['u_pwd'])){
                    $dataes['admins']['u_pwd']=$arr['users']['u_pwd']; 
                    $dataes['where']['u_id']= $arr['where']['u_id'];
                }  
              
            }catch (Exception $e){
                return put_encode(false,$e->getCode(),$e->getMessage());
            }
            if($res = $this->editUser($arr,$top,$dataes,$admin)){
                return put_encode(true,'','修改成功！');
            }else{
                return put_encode(false,'2000117',self::$error_code['2000117']);
            }
        }else{
            $arr['u_id'] = $data['u_id'];
            if(!is_numeric($arr['u_id'])){
                return put_encode(false,'2000116',self::$error_code['2000116']);
            }
           
            $dataes=json_decode($this->model->find($arr),true);         
            return $dataes;
        }
    }
       /**
     * 会员编辑
     */
    public function editUser0($data = []){
        $arr = [];
        $op = $data['op'];
        if($op){
            try{
                $arr = $this->editFilter($data,0);
                $top='';
                $dataes='';
                $admin='';
             
            }catch (Exception $e){
                return put_encode(false,$e->getCode(),$e->getMessage());
            }
            if($res = $this->editUser($arr,$top,$dataes,$admin)){
                return put_encode(true,'','修改成功！');
            }else{
                return put_encode(false,'2000117',self::$error_code['2000117']);
            }
        }else{
            $arr['u_id'] = $data['u_id'];
            if(!is_numeric($arr['u_id'])){
                return put_encode(false,'2000116',self::$error_code['2000116']);
            }
            return put_encode($this->model->find($arr),'','');
        }
    }
    /**
     * 用户编辑
     * @param $u_id
     * @return string
     * 事务操作
     */
     public function editUser($data=[],$top,$dataes,$admin){

       Db::startTrans();
        try{
            if(!empty($top)){
               Db::table('ffc_users')
                ->where($top['where'])
                ->update($top['users']);
            }
            if(!empty($dataes)){
                Db::table('ffc_admins')
                ->where($dataes['where'])
                ->update($dataes['admins']);
            }
            if(!empty($admin)){
                Db::table('ffc_admins')
                ->where($admin['where'])
                ->update($admin['admins']);
            }
                Db::table('ffc_users')
                ->where($data['where'])
                ->update($data['users']);

                Db::commit();
        } catch (\Exception $e){                 
            Db::rollback();
            return put_encode(false,$e->getCode(),$e->getMessage());
           
        }
           return put_encode(true,'','添加成功！');
    
     }

    /**
     * 获取用户详情by id
     *
     */
    public function getUserById($data){
        $arr = [];
        if(empty($data['u_id'])){
            return  put_encode(false,'2000116',self::$error_code['2000116']);
        }
        if(!is_numeric($data['u_id'])){
            return  put_encode(false,'2000116',self::$error_code['2000116']);
        }
        $arr['u_id'] = $data['u_id'];
        return put_encode($this->model->find($arr),'','');
    }
    /**
     * 用户搜索
     * @param $data
     * @return string
     */
     public function search($data){     
          $dataes['u_level']=$data['u_level'];
          $dataes['u_top_'.$data['top']]=$data['u_top'];
         if(!empty($data['u_username'])){
            $dataes['u_username']=strtolower($data['u_username']);
         }
         if(!empty($data['u_is_test'])){
            $dataes['u_is_test']=$data['u_is_test'];
         }
         if(!empty($data['u_status'])){
            $dataes['u_status']=$data['u_status'];
         }
         $dataes=$this->model->getList($dataes);               
         return  put_encode(true,'',$dataes);
 
         
     }

}