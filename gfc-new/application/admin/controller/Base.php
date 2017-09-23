<?php
/**
 * Created by PhpStorm.
 * User: Jim FAN
 * Date: 2017/5/15
 * Time: 19:20
 */

namespace app\admin\controller;
use think\Controller;
use think\Cookie;
use think\image\Exception;
use Nocache\mcache;
use think\Log;

/**
 * 后台公共控制器
 * @package app\admin\controller
 */
class Base extends Controller{
    public $u_client_ip = null;//用户登录ip
    public $u_action = null;//用户登方法
    public $u_control = null;//用户登录控制器
    public $memcache = null;
    public $user = null;
    public $SESSION_KEY = null;
    /**
     * RSA私钥
     * 不能换换
     * @var string
     */
    public $private_key =  '-----BEGIN RSA PRIVATE KEY-----
MIICXAIBAAKBgQDDpaYdyhR3ctXyjIA8WIOY9fCFcbtb6Ivd7XKd3BAso+uJVJ+w
PBj2IJrvTef0JeL8mwdcQmhM+g8n4LrUD4TF6OKlqMKniORpD3R4i5Z4aJgiwF1m
eeXUAPN8NCkaJKw9+QSZX57fFa/cj466Pv9RioBRrDxzfMtvST5ZLK0FGwIDAQAB
AoGAPIqt9Nnrq2rlucCwjfv1/Qdd/m1LRQ2Y+nvX0/GdL7Mp171QDQEL2F4Ok67P
8EUpEHIIvQvvqqJWvkhUh/qlYu402cCB+pG2g6xwRBQNebbxhf8rItxCk+7Q2K43
nlkCOxGvpXIBKskiZsyctcx0TMGrFSrgY4GROK0HiRMaaEECQQDma1oGYkcoeH1w
ZC9DwE/8QCToCWe2FQ9UAbmrQl8PSbpFB8L/lF3Z2dJR2QDxqX/gWvg9CeIK2r52
+pFM6L6/AkEA2V4MpvmIn6AP8GikhIJ38c58rMnr41sEE8n6SnzwzN6TNJwahR7X
86qd5TOfiTGMt3pk+Pk6eKWHVo3T267spQJACrPJxqoh6/tMuD+vAlKYZHsGO9DU
BF0ODTTXTuESUT93a2Vk5UIa6dd4MV0G8jKRQfZ3uT4QRbjLR/NzdEMLOQJBAMo0
6YQzQdtspSc50UHLtRTmx6hdtuirdKGMFSBSFhgfPcWFKk6IINB1+aiMW27e/053
t5K9Fp3BLqNgEKOemFkCQChAhgc7j/bLYsMxtaxZBH8/AJ+8tMcAlJrBKirgfeV6
aDqcpCiu5rzCFhEc3f05TAOuy+JzZZzRdj0KukVF4v8=
-----END RSA PRIVATE KEY-----';
    /**
     * RSA公钥
     * @var string
     */
    public $public_key ='-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDDpaYdyhR3ctXyjIA8WIOY9fCF
cbtb6Ivd7XKd3BAso+uJVJ+wPBj2IJrvTef0JeL8mwdcQmhM+g8n4LrUD4TF6OKl
qMKniORpD3R4i5Z4aJgiwF1meeXUAPN8NCkaJKw9+QSZX57fFa/cj466Pv9RioBR
rDxzfMtvST5ZLK0FGwIDAQAB
-----END PUBLIC KEY-----';

    /**
     * 获取公钥返回资源id
     */
    public function getRSA_pubId(){
        $pu_key = openssl_pkey_get_public($this->public_key);//这个函数可用来判断公钥是否是可用的
        return $pu_key;
    }
    /**
     * 获取私钥返回资源id
     */
    public function getRSA_priId(){
        $pi_key = openssl_pkey_get_private($this->private_key);//这个函数可用来判断私钥是否是可用的，可用返回资源id Resource id
        return $pi_key;
    }
    /**
     * 公钥加密
     * @param $data
     * @param $pu_key
     * @return string
     */
    public function public_encrypt($data){
        $pu_key = $this->getRSA_pubId();
        openssl_public_encrypt($data,$encrypted,$pu_key);//公钥加密
        $encrypted = base64_encode($encrypted);
        return  $encrypted;
    }

    /**私钥解密
     * @param $encrypted
     * @param $pi_key
     * @return mixed
     */
    public function private_decrypt($encrypted){
        $pi_key = $this->getRSA_priId();
        openssl_private_decrypt(base64_decode($encrypted),$decrypted,$pi_key);//私钥解密
        return $decrypted;
    }

    protected function _initialize()
    {
        parent::_initialize();
        $this->memcache = new mcache();
        header('P3P: CP=CAO PSA OUR');
        try{
            //用户登录跳转进来 记录登录session  及mmemcache里面数据
            if($this->memcache){//如果缓存可用的话
                $server = $this->request->server();
                $userInfo = session('userInfo');
                if($userInfo){//保证只是登陆进来的时候执行
                    $admin = session('admin_auth');
                    $session['s_username'] = $admin['u_username'];
                    $session['s_level'] = $userInfo['u_level'];
                    $session['s_top4'] = $userInfo['u_top_4'];
                    $session['s_top3'] = $userInfo['u_top_3'];
                    $session['s_top2'] = $userInfo['u_top_2'];
                    $session['s_top1'] = $userInfo['u_top_1'];
                    $session['s_login_time'] = date("Y-m-d H:i:s");
                    $session['s_update_time'] = date("Y-m-d H:i:s");
                    $session['s_client_ip'] = $server['REMOTE_ADDR'];
                    $session['s_server_ip'] = $server['SERVER_ADDR'];
                    $session_status = json_decode(forwarding('UserForwarding', '\app\Service\users\business\sessions', 'addAdminSession',$session),true);
                    //memcahce 里面保存三分钟
                    $session['s_id'] = $session_status['data'];
                    $this->memcache->set('session',$session['s_username'],$session,DS_ONLINE_TIME);
                    $adminInfo = [
                        'u' =>  $session['s_username'],
                        'ip' => $server['REMOTE_ADDR'],
                        'lt' => strtotime($session['s_login_time']),
                        'ut' => strtotime($session['s_update_time']),
                    ];
                    //存储session 里面的信息  session丢失再去缓存里面寻找赋值
                    $sessionInfo = [
                        'u_name' =>session('u_name'),
                        'is_child' =>session('is_child'),
                        'admin_auth_id' =>session('admin_auth_id'),
                        'admin_auth_name' =>session('admin_auth_name'),
                        'u_id' =>session('u_id'),
                        'level' =>session('level'),
                        'admin_auth' =>session('admin_auth'),
                    ];
                    $this->memcache->set('sessionInfo',$session['s_username'],$sessionInfo,DS_ONLINE_TIME);
                    $this->SESSION_KEY = urlencode($this->public_encrypt(json_encode($adminInfo)));
                    Cookie::set('sessionPrivateKey', $this->SESSION_KEY,DS_ONLINE_TIME);
                    session('userInfo',0);
                }else{//登陆进来之后 每次请求获取 session_key 解密 然后验证登陆 到了时间更新session 表 用户信息
                    $session_key  =  Cookie::get('sessionPrivateKey');
                    $adminInfo = json_decode($this->private_decrypt(urldecode($session_key)),true);//用户解密出来的信息
                    if(empty($adminInfo['u'])){//这种情况是由于cookie 过期session没过期导致的 办法是session 清空重新登录
                        session(null);
                        return  false;
                    }
                    $now = time();
                    if($now - $adminInfo['ut'] >DS_ONLINE_UPDATE_TIME){
                        //获取缓存session信息 更新时间及ip
                        $session = $this->memcache->get('session',$adminInfo['u']);
                        $session['s_update_time'] = date("Y-m-d H:i:s");
//                        $session['s_client_ip'] = $server['REMOTE_ADDR']; //在这不更新 影响互踢
                        $session['s_server_ip'] = $server['SERVER_ADDR'];
                        $this->memcache->set('session',$adminInfo['u'],$session,DS_ONLINE_TIME);
                        //更新数据库session信息
                        json_decode(forwarding('UserForwarding', '\app\Service\users\business\sessions', 'updateFrontSession',$session),true);
                        $sessionInfo = $this->memcache->get('sessionInfo',$adminInfo['u']);
                        if(empty(session('admin_auth'))){//如果session 记录信息为空了 去缓存获取更新 集群中最可能出现这样情况
                            session('u_name',$sessionInfo['u_name']);
                            session('is_child',$sessionInfo['is_child']);
                            session('admin_auth_id',$sessionInfo['admin_auth_id']);
                            session('admin_auth_name',$sessionInfo['admin_auth_name']);
                            session('u_id',$sessionInfo['u_id']);
                            session('level',$sessionInfo['level']);
                            session('admin_auth',$sessionInfo['admin_auth']);
                        }
                        $this->memcache->set('sessionInfo',$adminInfo['u'],$sessionInfo,DS_ONLINE_TIME);//给缓存存储session 加时间
                        $adminInfo['ip'] =  $server['REMOTE_ADDR'];
                        $adminInfo['ut'] = date("Y-m-d H:i:s");
                        $this->SESSION_KEY = urlencode($this->public_encrypt(json_encode($adminInfo)));
                        Cookie::set('sessionPrivateKey', $this->SESSION_KEY,DS_ONLINE_TIME);
                    }
                }
            }

            $this->u_control = $this->request->controller();
            $this->u_action = $this->request->action();
            $this->u_client_ip = $this->request->ip();
            $u_group_id=session('admin_auth')['u_group_id'];
            $list = \think\Config::get('auth');
            $data['control'] = strtolower($this->u_control);
            $data['action'] = strtolower($this->u_action);
            $text=$this->authGet($u_group_id,$list,$data);
            $menu=$this->authList($u_group_id,$list);
            $this->assign('menu',$menu);
            $this->assign('session_key',$this->SESSION_KEY);
            if(empty($text)){
                return  $this->error('没有权限访问！！','index/welcome');
            }
        }catch (Exception $e){
            if(empty($text)){
                return  $this->error('访问异常！！'.$e->getMessage(),'index/welcome');
            }
        }
    }
    /**
     * 检测是否登录
     */
    public function isLogin(){
        if(empty(session('admin_auth_id'))){
            echo  "<script> window.parent.frames.location.href='".url('index/login','','',true)."';</script>";
            exit;
        }
    }
    /**
     * 退出登录
     */
    public function signOut(){
        $this->u_control = $this->request->controller();
        $this->u_action = $this->request->action();
        $this->u_client_ip = $this->request->ip();
        $this->adminAddLogs('退出登录',1);
        Cookie::clear('sessionPrivateKey');
        session(null);
        return $this->redirect('admin/index/login');
    }

    /**
     * @param $url  链接
     * @param $currentpage  当前页
     * @param $total  总数量
     * @param $start 开始
     * @param $end  结束
     * @param int $countpage  每页数量
     * @return array
     */
    public function getPage($url,$currentpage,$total,$start,$end,$countpage=DEFAULT_PER_PAGE){
        $totalpage = ceil($total/$countpage);
        $res = [
            'start' => $start,
            'end' => $end,
            'total' =>$total,
            'pagecounts' =>$totalpage,
            'pre_url' => '',
            'next_url'=>'',
            'middle' =>'',
        ];
        if($total<$countpage){//只有一页
            $res['pre_url'] = 'javascript:;';
            $res['next_url'] = 'javascript:;';
        }else if($total<=$countpage*5){//小于等于5页
            if($currentpage <=1){
                $res['pre_url'] = "javascript:;";
            }else{
                $pre = ($currentpage-2)<=0?0:($currentpage-2);
                $res['pre_url'] = $url."&page=".$pre;
            }
            for($i=0;$i<$total;$i=$i+$countpage){
                $j = ceil($i/$countpage)+1;
                if($j == $currentpage){
                    $res['middle'] .= "<a class='current' href='".$url."&page=".($j-1)."'>".$j."</a>";
                }else{
                    $res['middle'] .= "<a  href='".$url."&page=".($j-1)."'>".$j."</a>";
                }
            }
            if($currentpage >=$totalpage){
                $res['next_url'] = "javascript:;";
            }else{
                $res['next_url'] = $url."&page=".($currentpage + 1);
            }
            if($currentpage >=$totalpage){
                $res['next_url'] = "javascript:;";
            }else{
                $res['next_url'] = $url."&page=".$currentpage;
            }
        }else{//大于5页
            if($currentpage <=1){
                $res['pre_url'] = "javascript:;";
            }else{
                $pre = ($currentpage-2)<=0?0:($currentpage-2);
                $res['pre_url'] = $url."&page=".$pre;
            }
            //总区间段
            $total_interval = ceil($total/(5*$countpage));
            //取当前页属于哪个区间段
            $f = ceil($currentpage/5);
            //首页
            $res['middle'] ="<a  href='".$url."&page=0'>首页</a>";
            //按区间循环
            if($f<$total_interval){
                $j = ($f-1)*5+1;
                for($i=($f-1)*5*$countpage+1;$i<$f*5*$countpage;$i=$i+$countpage){
                    if($j == $currentpage){
                        $res['middle'] .= "<a class='current' href='".$url."&page=".($j-1)."'>".$j."</a>";
                    }else{
                        $res['middle'] .= "<a  href='".$url."&page=".($j-1)."'>".$j."</a>";
                    }
                    $j++;
                }
            }else{//到了最后一个区间段
                $j = ($f-1)*5+1;
                for($i=($f-1)*5*$countpage+1;$i<=$total;$i=$i+$countpage){
                    if($j == $currentpage){
                        $res['middle'] .= "<a class='current' href='".$url."&page=".($j-1)."'>".$j."</a>";
                    }else{
                        $res['middle'] .= "<a  href='".$url."&page=".($j-1)."'>".$j."</a>";
                    }
                    $j++;
                }
            }
            //尾页
            $res['middle'] .="<a  href='".$url."&page=".($totalpage-1)."'>尾页</a>";
            if($currentpage >=$totalpage){
                $res['next_url'] = "javascript:;";
            }else{
                $res['next_url'] = $url."&page=".$currentpage;
            }
        }
        return  $res;
    }
    /**
     *  添加后台管理员日志
     */
    public function adminAddLogs($u_remark,$u_is_success){
        $arr = [
            'u_client_ip' =>  $this->u_client_ip,
            'u_control' =>  $this->u_control,
            'u_action' =>  $this->u_action,
            'u_remark' =>  $u_remark,
            'u_is_success' =>  $u_is_success,
            'u_username' =>session('admin_auth_name')
        ];
        addLogs($arr,2);
    }
    /**
     * 空操作器
     * @return mixed
     */
    public function _empty(){
        return  $this->fetch('./404');
    }

//导航栏列表的显示
    protected function authList($id,$arr){
        if(empty($id)){
            return '';
        }
        $t  = explode(',', $id);
        $authList = array();
        foreach ($t as $k => $v) {
            if($arr[$v]['is_menu'] == '1' ){
                $authList[$v]=$arr[$v];
                if(empty($arr[$v]['control'])){
                    $authList[$v]['url']='';
                }else{
                    $authList[$v]['url']=$arr[$v]['control'].'/'.$arr[$v]['action'];
                }

            }
        }
        foreach ($authList as $key => $info) {
            $result[$info['parent_id']][] = $info;
        }
        return $result;
    }
//子账显示的权限列表
    protected function authAdmin($id,$arr){
        $t  = explode(',', $id);
        $authList = array();
        foreach ($t as $k => $v) {
            $authList[$v]=$arr[$v];
        }
        foreach ($authList as $key => $info) {
            $result[$info['parent_id']][] = $info;
        }
        return $result;
    }
    //判断是否拥有权限
    protected function authGet($id,$arr,$data){
        //公共权限直接写在代码里
        if($data['control'] == 'index' && $data['action'] == 'login'){
            return true;
        }
        if($data['control'] == 'index' && $data['action'] == 'index'){
            return true;
        }
        if($data['control'] == 'index' && $data['action'] == 'signout'){
            return true;
        }
        if($data['control'] == 'index' && $data['action'] == 'welcome'){
            return true;
        }
        if($data['control'] == 'index' && $data['action'] == 'editmima'){
            return true;
        }
        //自动任务在线人数
        if($data['control'] == 'index' && $data['action'] == 'numberinfo'){
            return true;
        }

        if(empty($id)){
            return '';
        }
        $t  = explode(',', $id);
        foreach ($t as $k => $v) {
            $authList[$v]=$arr[$v];
        }
        foreach ($authList as $key => $value) {
            if($value['action'] == $data['action'] && $value['control'] == $data['control'] ){
                return true;
            }
            //如果有即时订单的权限就会有自动任务的权限
            if($value['control'] == 'instant' && $value['action'] == 'getinstant' ){
                //自动（手动）刷新即时订单
                if($data['control'] == 'instant' && $data['action'] == 'ajaxinstant'){
                    return true;
                }
                //自动刷新奖期
                if($data['control'] == 'instant' && $data['action'] == 'lastissueinfo'){
                    return true;
                }
            }
            //如果有查看订单的权限
            if($value['control'] == 'order' && $value['action'] == 'getorder' ){
                //ajax的玩法搜索
                if($data['control'] == 'order' && $data['action'] == 'ajax'){
                    return true;
                }
            }
        }
        return false;
    }

}