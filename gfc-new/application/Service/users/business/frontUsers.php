<?php
/**
 * Created by PhpStorm.
 * User: Jim FAN
 * Date: 2017/6/30
 * Time: 16:19
 */

namespace app\Service\users\business;

use think\Db;
use think\image\Exception;
use app\Service\users\model\Users as model_users;
use  app\Service\users\business\base;
use think\Log;

class frontUsers extends base
{
    public static $error_code = [
        '12000011' => '账号已被冻结，请联系管理员',
        '12000012' => '上级账号已被冻结，请联系管理员',
        '12000013' => '用户出错！',
        '12000014' => '用户出错,请重新再试！',
        '12000015' => '有重名用户，访问失败！',
    ];
    /**
     * 会员层级
     * @var array
     */
    public static $level = [
        0 => '会员',
        1 => '代理',
        2 => '总代',
        3 => '股东',
        4 => '分公司',
        5 => '总公司'
    ];
    /**
     * 会员状态
     * @var array
     */
    public static $statue = [
        0 => '已删除',
        8 => '正常'
    ];
    /**
     *会员类型
     * @var array
     */
    public static $is_test = [
        1 => '正式账号',
        2 => '测试账号'
    ];
    public $model = null;

    public function __construct()
    {
        parent::__construct();
        $this->model = new model_users();
    }

    /**
     * 前台下注获取
     * 获取用户信息
     */
    public function getUseInfo($data = []){
        $list = $this->model->where('u_username','eq',$data['username'])->find();
        return  put_encode($list,'','');
    }
    /**
     * 获取用户信息
     * @param array $data
     */
    public function getUserByUsername($data = [])
    {
        $data = $this->model->where('u_username', 'eq', $data['username'])->where('u_status', 'eq', '8')->find();
        return put_encode($data, '', '');
    }

    /**
     * 判断用户是否在线
     * @param array $data
     */
    public function isOnline($data = []){
        $session = $this->memcache->get('session',$data['username']);
        if($session){
            return  put_encode($session,'','');
        }else{
            return put_encode(false,'','');
        }
    }
    /**
     * 获取在线用户
     * 某代理下的在线用户统计
     */
    public function getUserOnline($data = []){
        $level = $data['level'];
        $u_name = $data['u_name'];
        $where = '';
        $swhere = '';
        switch ($level){
            case 1:
                $where = " u_top_1 = '{$u_name}'";
                $swhere = " s_top1 = '{$u_name}'";
                // 代理管理员总数    //加个缓存 5s
                $countTotal = $this->memcache->get('userCount','adminCount'.$u_name);
                if(empty($countTotal)){
                    $sql1 = "select count(*) from  ffc_users where u_level>0 and  ".$where;
                    $Total = $this->model->query($sql1);
                    $countTotal = empty($Total)?0:$Total[0]['count(*)'] + 1;
                    $this->memcache->set('userCount','adminCount'.$u_name,$countTotal,5);
                }
                break;
            case 2:
                $where = "u_top_2 = '{$u_name}'";
                $swhere = "s_top2 = '{$u_name}'";
                // 总代管理员总数    //加个缓存 5s
                $countTotal = $this->memcache->get('userCount','adminCount'.$u_name);
                if(empty($countTotal)){
                    $sql2 = "select count(*) from  ffc_users where u_level>0 and  ".$where;
                    $Total = $this->model->query($sql2);
                    $countTotal = empty($Total)?0:$Total[0]['count(*)'] + 1;
                    $this->memcache->set('userCount','adminCount'.$u_name,$countTotal,5);
                }
                break;
            case 3:
                $where = "u_top_3 = '{$u_name}'";
                $swhere = "s_top3 = '{$u_name}'";
                // 股东管理员总数
                $countTotal = $this->memcache->get('userCount','adminCount'.$u_name);
                if(empty($countTotal)){
                    $sql3 = "select count(*) from  ffc_users where u_level>0 and  ".$where;
                    $Total = $this->model->query($sql3);
                    $countTotal = empty($Total)?0:$Total[0]['count(*)'] + 1;
                    $this->memcache->set('userCount','adminCount'.$u_name,$countTotal,5);
                }
                break;
            case 4:
                $where = "u_top_4 = '{$u_name}'";
                $swhere = "s_top4 = '{$u_name}'";
                // 分公司管理员总数    //加个缓存 5s
                $countTotal = $this->memcache->get('userCount','adminCount'.$u_name);
                if(empty($countTotal)){
                    $sql40 = "select count(*) from ffc_admins where u_parent_name in (select u_username from  ffc_users where u_level>0 and u_username='{$u_name}' )";
                    $sql41 = " select count(*) from  ffc_users where u_level>0 and u_top_4='{$u_name}';";
                    $Total0 = $this->model->query($sql40);
                    $Total1 = $this->model->query($sql41);
                    $countTotal = (empty($Total0)?0:$Total0[0]['count(*)'] )+ (empty($Total1)?0:$Total1[0]['count(*)'] )+1;
                    $this->memcache->set('userCount','adminCount'.$u_name,$countTotal,5);
                }
                break;
            case 5:
                $where = " 1 ";
                $swhere = " 1 ";
                //总公司管理员总数    //加个缓存 5s
                $countTotal = $this->memcache->get('userCount','adminCount'.$u_name);
                if(empty($countTotal)){
                    $sql50 = "select count(*) from  ffc_users where u_level>0 ";
                    $sql51 = "select count(*) from  ffc_admins where u_parent_name in (select u_username from  ffc_users where u_level>0)";
                    $Total0 = $this->model->query($sql50);
                    $Total1 = $this->model->query($sql51);
                    $countTotal = (empty($Total0)?0:$Total0[0]['count(*)'] )+ (empty($Total1)?0:$Total1[0]['count(*)'] );
                    $this->memcache->set('userCount','adminCount'.$u_name,$countTotal,5);
                }
                break;
        }
        $time = date("Y-m-d H:i:s",time() - DS_ONLINE_TIME);//更新时间在DS_ONLINE_TIME 秒之内的
        //总在线用户数
        $sql = "select s_username from ffc_sessions  where s_level=0 and  s_update_time>'{$time}' and  ".$swhere."  group by s_username ";
        $onlineCounts = count($this->model->query($sql));
        //总用户数 加个缓存 5s
        $count = $this->memcache->get('userCount','count'.$u_name);
        if(empty($count)){
            $totalsql = "select count(*) from ffc_users where u_status='8' and u_level = 0  and ".$where;
            $count = $this->model->query($totalsql);
            $this->memcache->set('userCount','count'.$u_name,$count,5);
        }
        $arr['online'] = $onlineCounts;
        $arr['total'] = $count[0]['count(*)'];
        //管理员统计
        $sql = "select s_username from ffc_sessions  where s_level>0  and  s_update_time>'{$time}' and  ".$swhere."  group by s_username ";
        $adminOnlineCounts = count($this->model->query($sql));
        $arr['adminOnline'] = $adminOnlineCounts+1;
        $arr['adminTotal'] = $countTotal;
        return  put_encode($arr,'','');
    }
    /**
     *统计在线人数
     * session
     * 返回同一用户在是否在不同地方登录的用户信息
     * 时间在DS_ONLINE_TIME 秒内的
     */
    public function tongjizaixian($data = []){
        $time = date("Y-m-d H:i:s",time()-DS_ONLINE_TIME);
        $sql = "select s_client_ip from ffc_sessions  where s_username='{$data['username']}' and s_update_time >'{$time}' order by s_update_time DESC limit 1 ";
        $info = $this->model->query($sql);
//                Log::record($info,'error');
        if(empty($info)){
            return put_encode(false,'','');
        }else{
            if($info[0]['s_client_ip'] != $data['ip']){
                return put_encode($info[0],'','');
            }else{
                return put_encode(false,'','');
            }
        }
    }
    /**
     *前端用户连接登录
     * 股东 总代理  代理
     *  如果没分公司 股东  总代 代理 则自动创建  密码就是qwe123  +  创建的用户名
     *  分公司用户名用总公司
     *  股东用户名用
     *  总代用户名
     *  代理用户名
     *  用户名  ffc+代理id+_+会员用户名
     *  如果用户名已经存在 则使用该用户名
     *  如果用户名不存在
     *      a.先判断分公司存不存在
     *          存在分公司
     *            判断股东是否存在 不存在逐级递减创建
     *            判断总代是否存在 不存在逐级递减创建
     *            判断代理是否存在 不存在逐级递减创建
     *          不存在则逐级递减 创建股东  总代  代理   会员
     *
     *  返回的是用户信息 记录到session和memcache
     * 创建了一个存储过程
     * create procedure update_count(IN level INT,IN u_top_1 VARCHAR(200),IN u_top_2 VARCHAR(200),IN u_top_3 VARCHAR(200),IN u_top_4 VARCHAR(200),IN u_top_5 VARCHAR(200))
     * BEGIN
     * IF(level = 1) THEN
     * -- 新增一个用户统计上级层级下的用户数量
     * update `ffc_users` set u_count_0=u_count_0+1 where u_username = u_top_1; -- 代理数量 +1
     * update `ffc_users` set u_count_0=u_count_0+1 where u_username = u_top_2; -- 总代理数量+1
     * update `ffc_users` set u_count_0=u_count_0+1 where u_username = u_top_3; -- 股东数量 +1
     * update `ffc_users` set u_count_0=u_count_0+1 where u_username = u_top_4; -- 分公司数量+1
     * update `ffc_users` set u_count_0=u_count_0+1 where u_username = u_top_5; -- 总公司数量+1
     * END IF;
     * IF(level = 2) THEN
     * -- 新增一个代理 及用户 统计数量
     * update `ffc_users` set u_count_0=u_count_0+1,u_count_1=u_count_1+1 where u_username = u_top_2; -- 总代理数量+1
     * update `ffc_users` set u_count_0=u_count_0+1,u_count_1=u_count_1+1 where u_username = u_top_3; -- 股东数量 +1
     * update `ffc_users` set u_count_0=u_count_0+1,u_count_1=u_count_1+1 where u_username = u_top_4; -- 分公司数量+1
     * update `ffc_users` set u_count_0=u_count_0+1,u_count_1=u_count_1+1 where u_username = u_top_5; -- 总公司数量+1
     * END IF;
     * IF(level = 3) THEN
     * -- 新增一个总代 代理  及用户 统计数量
     * update `ffc_users` set u_count_0=u_count_0+1,u_count_1=u_count_1+1,u_count_2=u_count_2+1 where u_username = u_top_3; -- 股东数量 +1
     * update `ffc_users` set u_count_0=u_count_0+1,u_count_1=u_count_1+1,u_count_2=u_count_2+1 where u_username = u_top_4; -- 分公司数量+1
     * update `ffc_users` set u_count_0=u_count_0+1,u_count_1=u_count_1+1,u_count_2=u_count_2+1 where u_username = u_top_5; -- 总公司数量+1
     * END IF;
     * IF(level = 4) THEN
     * -- 新增一个 股东  总代 代理  及用户 统计数量
     * update `ffc_users` set u_count_0=u_count_0+1,u_count_1=u_count_1+1,u_count_2=u_count_2+1,u_count_3=u_count_3+1 where u_username = u_top_4; -- 分公司数量+1
     * update `ffc_users` set u_count_0=u_count_0+1,u_count_1=u_count_1+1,u_count_2=u_count_2+1,u_count_3=u_count_3+1 where u_username = u_top_5; -- 总公司数量+1
     * END IF;
     * IF(level = 5) THEN
     * -- 新增一个 分公司 股东  总代 代理  及用户 统计数量
     * update `ffc_users` set u_count_0=u_count_0+1,u_count_1=u_count_1+1,u_count_2=u_count_2+1,u_count_3=u_count_3+1,u_count_4=u_count_4+1 where u_username = u_top_5; -- 总公司数量+1
     * END IF;
     * END;
     *
     *
     * top4   ffc+总公司id+_s+总公司名+网站id
     * $gudong  ffc+网站id+_s+总公司id+股东名
     * $zongdai ffc+网站id+_s+股东名+总代名
     * $daili ffc+网站id+_s+总代名+代理名
     * $username ffc+网站id+_s+代理名字+用户名
     */
    public function frontAccessUser($data = [])
    {
        $tops = explode(',', $data['dcUserTree']);
        $top5 = $data['dcCustomerId'];
        $top4 = $data['dcSiteId'];
        $gudong = wrapUsername( $data['dcSiteId'],$tops[0]);
        $zongdai = wrapUsername($data['dcSiteId'],$tops[1]);
        $daili = wrapUsername($data['dcSiteId'],$tops[2]);
        $username = wrapUsername($data['dcSiteId'],$data['dcUsername']);
        //用户名拼接中出现相同的对接失败
        $arr = [$top4,$gudong,$zongdai,$daili,$username];
        if(count(array_unique($arr)) <5){
            return  put_encode(false,'12000015',self::$error_code['12000015']);
        }
        $top_sql = "select * from ffc_users where (u_username ='{$gudong}' and u_level=3) or (u_username = '{$zongdai}' and u_level=2) or (u_username='{$daili}' and  u_level=1) or (u_username ='{$username}' and u_level=0) or (u_username='{$top4}' and u_level=4) order by u_level desc  ";
        $users = $this->model->query($top_sql);
        $total = count($users);
        //这种方式大大减少了sql查询
        //还需要判断层级是不是一样 依次对应
        $u_level = 4;
        $pwdsalt = time();//密码加盐随机
        foreach ($users as $k=>$v){
            if($users[$k]['u_level'] != $u_level){
                return  put_encode(false,'12000115','上级'.$users[$k]['u_username'].'层级有误');
            }
            $u_level--;
        }
        try {
            switch ($total) {
                case 5://有全部用户层级
                    if ($users[4]['u_status'] == 8) {
                        $time = date("Y-m-d H:i:s");
                        $this->model->query("update ffc_users set u_last_ip='{$data['ip']}',u_last_time='{$time}' where u_username = '{$username}'");
                        session('user', $users[4]);
                        return put_encode($users[4], '', '');
                    } else {//账号已被冻结，请联系管理员
                        return put_encode(false, '12000011', self::$error_code['12000011']);
                    }
                    break;
                case 4://缺少用户 4 3 2 1
                    if ($users[3]['u_status'] == 8) {
                        $u_proportion = $users[3]['u_proportion_5'] + $users[3]['u_proportion_4'] + $users[3]['u_proportion_3'] + $users[3]['u_proportion_2'] + $users[3]['u_proportion_1'];
                        $u_proportion5 = $users[3]['u_proportion_5'];
                        $u_proportion4 = $users[3]['u_proportion_4'];
                        if ($u_proportion < 100) {//根据占余归分配占城
                            if ($users[3]['u_own_level'] > 4) {//占成分配给总公司
                                $u_proportion5 += 100 - $u_proportion;
                            } else {//分给总公司
                                $u_proportion4 += 100 - $u_proportion;
                            }
                        }
                        try {
                            Db::startTrans();
                            $insertdata = [
                                'u_username' => $username,
                                'u_nick_name' => $username,
                                'u_level' => 0,
                                'u_top_4' => $users[3]['u_top_4'],
                                'u_top_3' => $users[3]['u_top_3'],
                                'u_top_2' => $users[3]['u_top_2'],
                                'u_top_1' => $users[3]['u_username'],
                                'u_pwd' => $this->setPassword($username.$pwdsalt),
                                'u_proportion_5' => $u_proportion5,
                                'u_proportion_4' => $u_proportion4,
                                'u_proportion_3' => $users[3]['u_proportion_3'],
                                'u_proportion_2' => $users[3]['u_proportion_2'],
                                'u_proportion_1' => $users[3]['u_proportion_1'],
                                'u_count_0' => 0,
                                'u_count_1' => 0,
                                'u_count_2' => 0,
                                'u_count_3' => 0,
                                'u_count_4' => 0,
                                'u_own_level' => $users[3]['u_own_level'],
                                'u_reg_time' => date("Y-m-d H:i:s", time()),
                                'u_is_test' => $data['dcUserType'] == 2 ? '1' : '2',
                                'u_status' => '8',
                                'u_site_id' => $data['dcSiteId'],
                                'u_last_ip' => $data['ip']
                            ];
                            $user_id = Db::table('ffc_users')->insertGetId($insertdata);
                            $sql_update = "call update_count(1,'{$users[3]['u_username']}','{$users[3]['u_top_2']}','{$users[3]['u_top_3']}','{$users[3]['u_top_4']}','admin')";
                            Db::query($sql_update);
                            Db::commit();
                            session('user', $insertdata);
                            return put_encode($insertdata, '', '');
                        } catch (Exception $e) {
                            Db::rollback();
                            throw  new Exception(self::$error_code['12000014'],'12000014');
                        }
                    } else {
                        return put_encode(false, '12000012', self::$error_code['12000012']);
                    }
                    break;
                case 3://缺少 代理  用户
                    if ($users[2]['u_status'] == 8) {
                        $u_proportion = $users[2]['u_proportion_5'] + $users[2]['u_proportion_4'] + $users[2]['u_proportion_3'] + $users[2]['u_proportion_2'] + $users[2]['u_proportion_1'];
                        $u_proportion5 = $users[2]['u_proportion_5'];
                        $u_proportion4 = $users[2]['u_proportion_4'];
                        if ($u_proportion < 100) {//根据占余归分配占城
                            if ($users[2]['u_own_level'] > 4) {//占成分配给总公司
                                $u_proportion5 += 100 - $u_proportion;
                            } else {//分给总公司
                                $u_proportion4 += 100 - $u_proportion;
                            }
                        }
                        $insertdata = [
                            [
                                'u_username' => $daili,
                                'u_nick_name' => $daili,
                                'u_level' => 1,
                                'u_top_4' => $users[2]['u_top_4'],
                                'u_top_3' => $users[2]['u_top_3'],
                                'u_top_2' => $users[2]['u_username'],
                                'u_top_1' => '',
                                'u_pwd' => $this->setPassword($daili.$pwdsalt),
                                'u_proportion_5' => $users[2]['u_proportion_5'],
                                'u_proportion_4' => $users[2]['u_proportion_4'],
                                'u_proportion_3' => $users[2]['u_proportion_3'],
                                'u_proportion_2' => $users[2]['u_proportion_2'],
                                'u_proportion_1' => 0,
                                'u_count_0' => 1,
                                'u_count_1' => 0,
                                'u_count_2' => 0,
                                'u_count_3' => 0,
                                'u_count_4' => 0,
                                'u_own_level' => $users[2]['u_own_level'],
                                'u_reg_time' => date("Y-m-d H:i:s", time()),
                                'u_is_test' => $data['dcUserType'] == 2 ? '1' : '2',
                                'u_status' => '8',
                                'u_site_id' => $data['dcSiteId'],
                                'u_last_ip' => $data['ip']
                            ],
                            [
                                'u_username' => $username,
                                'u_nick_name' => $username,
                                'u_level' => 0,
                                'u_top_4' => $users[2]['u_top_4'],
                                'u_top_3' => $users[2]['u_top_3'],
                                'u_top_2' => $users[2]['u_username'],
                                'u_top_1' => $daili,
                                'u_pwd' => $this->setPassword($username.$pwdsalt),
                                'u_proportion_5' => $u_proportion5,
                                'u_proportion_4' => $u_proportion4,
                                'u_proportion_3' => $users[2]['u_proportion_3'],
                                'u_proportion_2' => $users[2]['u_proportion_2'],
                                'u_proportion_1' => 0,
                                'u_count_0' => 0,
                                'u_count_1' => 0,
                                'u_count_2' => 0,
                                'u_count_3' => 0,
                                'u_count_4' => 0,
                                'u_own_level' => $users[2]['u_own_level'],
                                'u_reg_time' => date("Y-m-d H:i:s", time()),
                                'u_is_test' => $data['dcUserType'] == 2 ? '1' : '2',
                                'u_status' => '8',
                                'u_site_id' => $data['dcSiteId'],
                                'u_last_ip' => $data['ip']
                            ]
                        ];
                        try{
                            Db::startTrans();
                            Db::table('ffc_users')->insertAll($insertdata);
                            //调用存储过程处理
                            $sql_update = "call update_count(2,'','{$users[2]['u_username']}','{$users[2]['u_top_3']}','{$users[2]['u_top_4']}','admin')";
                            Db::query($sql_update);
                            Db::commit();
                            //返回存储及返回用户数据
                            session('user', $insertdata[1]);
                        } catch (Exception $e) {
                            Db::rollback();
                            throw  new Exception(self::$error_code['12000014'],'12000014');
                        }
                        return put_encode($insertdata[1], '', '');
                    } else {
                        return put_encode(false, '12000012', self::$error_code['12000012']);
                    }
                    break;
                case 2://缺少 总代  代理 用户
                    if ($users[1]['u_status'] == 8) {
                        $u_proportion = $users[1]['u_proportion_5'] + $users[1]['u_proportion_4'] + $users[1]['u_proportion_3'] + $users[1]['u_proportion_2'] + $users[1]['u_proportion_1'];
                        $u_proportion5 = $users[1]['u_proportion_5'];
                        $u_proportion4 = $users[1]['u_proportion_4'];
                        if ($u_proportion < 100) {//根据占余归分配占城
                            if ($users[1]['u_own_level'] > 4) {//占成分配给总公司
                                $u_proportion5 += 100 - $u_proportion;
                            } else {//分给总公司
                                $u_proportion4 += 100 - $u_proportion;
                            }
                        }
                        $insertdata = [
                            [
                                'u_username' => $zongdai,
                                'u_nick_name' => $zongdai,
                                'u_level' => 2,
                                'u_top_4' => $users[1]['u_top_4'],
                                'u_top_3' => $users[1]['u_username'],
                                'u_top_2' => '',
                                'u_top_1' => '',
                                'u_pwd' => $this->setPassword($zongdai.$pwdsalt),
                                'u_proportion_5' => $users[1]['u_proportion_5'],
                                'u_proportion_4' => $users[1]['u_proportion_4'],
                                'u_proportion_3' => $users[1]['u_proportion_3'],
                                'u_proportion_2' => 0,
                                'u_proportion_1' => 0,
                                'u_count_0' => 1,
                                'u_count_1' => 1,
                                'u_count_2' => 0,
                                'u_count_3' => 0,
                                'u_count_4' => 0,
                                'u_own_level' => $users[1]['u_own_level'],
                                'u_reg_time' => date("Y-m-d H:i:s", time()),
                                'u_is_test' => $data['dcUserType'] == 2 ? '1' : '2',
                                'u_status' => '8',
                                'u_site_id' => $data['dcSiteId'],
                                'u_last_ip' => $data['ip']
                            ],
                            [
                                'u_username' => $daili,
                                'u_nick_name' => $daili,
                                'u_level' => 1,
                                'u_top_4' => $users[1]['u_top_4'],
                                'u_top_3' => $users[1]['u_username'],
                                'u_top_2' => $zongdai,
                                'u_top_1' => '',
                                'u_pwd' => $this->setPassword($daili.$pwdsalt),
                                'u_proportion_5' => $users[1]['u_proportion_5'],
                                'u_proportion_4' => $users[1]['u_proportion_4'],
                                'u_proportion_3' => $users[1]['u_proportion_3'],
                                'u_proportion_2' => 0,
                                'u_proportion_1' => 0,
                                'u_count_0' => 1,
                                'u_count_1' => 0,
                                'u_count_2' => 0,
                                'u_count_3' => 0,
                                'u_count_4' => 0,
                                'u_own_level' => $users[1]['u_own_level'],
                                'u_reg_time' => date("Y-m-d H:i:s", time()),
                                'u_is_test' => $data['dcUserType'] == 2 ? '1' : '2',
                                'u_status' => '8',
                                'u_site_id' => $data['dcSiteId'],
                                'u_last_ip' => $data['ip']
                            ],
                            [
                                'u_username' => $username,
                                'u_nick_name' => $username,
                                'u_level' => 0,
                                'u_top_4' => $users[1]['u_top_4'],
                                'u_top_3' => $users[1]['u_username'],
                                'u_top_2' => $zongdai,
                                'u_top_1' => $daili,
                                'u_pwd' => $this->setPassword($username.$pwdsalt),
                                'u_proportion_5' => $u_proportion5,
                                'u_proportion_4' => $u_proportion4,
                                'u_proportion_3' => $users[1]['u_proportion_3'],
                                'u_proportion_2' => 0,
                                'u_proportion_1' => 0,
                                'u_count_0' => 0,
                                'u_count_1' => 0,
                                'u_count_2' => 0,
                                'u_count_3' => 0,
                                'u_count_4' => 0,
                                'u_own_level' => $users[1]['u_own_level'],
                                'u_reg_time' => date("Y-m-d H:i:s", time()),
                                'u_is_test' => $data['dcUserType'] == 2 ? '1' : '2',
                                'u_status' => '8',
                                'u_site_id' => $data['dcSiteId'],
                                'u_last_ip' => $data['ip']
                            ]
                        ];
                        try{
                            Db::startTrans();
                            Db::table('ffc_users')->insertAll($insertdata);
                            //调用存储过程处理
                            $sql_update = "call update_count(3,'','','{$users[1]['u_top_3']}','{$users[1]['u_top_4']}','admin')";
                            Db::query($sql_update);
                            Db::commit();
                            //返回存储及返回用户数据
                            session('user', $insertdata[2]);
                            return put_encode($insertdata[2], '', '');
                        } catch (Exception $e) {
                            Db::rollback();
                            throw  new Exception(self::$error_code['12000014'],'12000014');
                        }
                    } else {
                        return put_encode(false, '12000012', self::$error_code['12000012']);
                    }
                    break;
                case 1://缺少  股东  总代  代理 用户
                    if ($users[0]['u_status'] == 8) {
                        $u_proportion = $users[0]['u_proportion_5'] + $users[0]['u_proportion_4'] + $users[0]['u_proportion_3'] + $users[0]['u_proportion_2'] + $users[0]['u_proportion_1'];
                        $u_proportion5 = $users[0]['u_proportion_5'];
                        $u_proportion4 = $users[0]['u_proportion_4'];
                        if ($u_proportion < 100) {//根据占余归分配占城
                            if ($users[0]['u_own_level'] > 4) {//占成分配给总公司
                                $u_proportion5 += 100 - $u_proportion;
                            } else {//分给总公司
                                $u_proportion4 += 100 - $u_proportion;
                            }
                        }
                        $insertdata = [
                            [
                                'u_username' => $gudong,
                                'u_nick_name' => $gudong,
                                'u_level' => 3,
                                'u_top_4' => $users[0]['u_username'],
                                'u_top_3' => '',
                                'u_top_2' => '',
                                'u_top_1' => '',
                                'u_pwd' => $this->setPassword($gudong.$pwdsalt),
                                'u_proportion_5' => $users[0]['u_proportion_5'],
                                'u_proportion_4' => $users[0]['u_proportion_4'],
                                'u_proportion_3' => 0,
                                'u_proportion_2' => 0,
                                'u_proportion_1' => 0,
                                'u_count_0' => 1,
                                'u_count_1' => 1,
                                'u_count_2' => 1,
                                'u_count_3' => 0,
                                'u_count_4' => 0,
                                'u_own_level' => $users[0]['u_own_level'],
                                'u_reg_time' => date("Y-m-d H:i:s", time()),
                                'u_is_test' => $data['dcUserType'] == 2 ? '1' : '2',
                                'u_status' => '8',
                                'u_site_id' => $data['dcSiteId'],
                                'u_last_ip' => $data['ip']
                            ],
                            [
                                'u_username' => $zongdai,
                                'u_nick_name' => $zongdai,
                                'u_level' => 2,
                                'u_top_4' => $users[0]['u_username'],
                                'u_top_3' => $gudong,
                                'u_top_2' => '',
                                'u_top_1' => '',
                                'u_pwd' => $this->setPassword($zongdai.$pwdsalt),
                                'u_proportion_5' => $users[0]['u_proportion_5'],
                                'u_proportion_4' => $users[0]['u_proportion_4'],
                                'u_proportion_3' => 0,
                                'u_proportion_2' => 0,
                                'u_proportion_1' => 0,
                                'u_count_0' => 1,
                                'u_count_1' => 1,
                                'u_count_2' => 0,
                                'u_count_3' => 0,
                                'u_count_4' => 0,
                                'u_own_level' => $users[0]['u_own_level'],
                                'u_reg_time' => date("Y-m-d H:i:s", time()),
                                'u_is_test' => $data['dcUserType'] == 2 ? '1' : '2',
                                'u_status' => '8',
                                'u_site_id' => $data['dcSiteId'],
                                'u_last_ip' => $data['ip']
                            ],
                            [
                                'u_username' => $daili,
                                'u_nick_name' => $daili,
                                'u_level' => 1,
                                'u_top_4' => $users[0]['u_username'],
                                'u_top_3' => $gudong,
                                'u_top_2' => $zongdai,
                                'u_top_1' => '',
                                'u_pwd' => $this->setPassword($daili.$pwdsalt),
                                'u_proportion_5' => $users[0]['u_proportion_5'],
                                'u_proportion_4' => $users[0]['u_proportion_4'],
                                'u_proportion_3' => 0,
                                'u_proportion_2' => 0,
                                'u_proportion_1' => 0,
                                'u_count_0' => 1,
                                'u_count_1' => 0,
                                'u_count_2' => 0,
                                'u_count_3' => 0,
                                'u_count_4' => 0,
                                'u_own_level' => $users[0]['u_own_level'],
                                'u_reg_time' => date("Y-m-d H:i:s", time()),
                                'u_is_test' => $data['dcUserType'] == 2 ? '1' : '2',
                                'u_status' => '8',
                                'u_site_id' => $data['dcSiteId'],
                                'u_last_ip' => $data['ip']
                            ],
                            [
                                'u_username' => $username,
                                'u_nick_name' => $username,
                                'u_level' => 0,
                                'u_top_4' => $users[0]['u_username'],
                                'u_top_3' => $gudong,
                                'u_top_2' => $zongdai,
                                'u_top_1' => $daili,
                                'u_pwd' => $this->setPassword($username.$pwdsalt),
                                'u_proportion_5' => $u_proportion5,
                                'u_proportion_4' => $u_proportion4,
                                'u_proportion_3' => 0,
                                'u_proportion_2' => 0,
                                'u_proportion_1' => 0,
                                'u_count_0' => 0,
                                'u_count_1' => 0,
                                'u_count_2' => 0,
                                'u_count_3' => 0,
                                'u_count_4' => 0,
                                'u_own_level' => $users[0]['u_own_level'],
                                'u_reg_time' => date("Y-m-d H:i:s", time()),
                                'u_is_test' => $data['dcUserType'] == 2 ? '1' : '2',
                                'u_status' => '8',
                                'u_site_id' => $data['dcSiteId'],
                                'u_last_ip' => $data['ip']
                            ]
                        ];
                        try{
                            Db::startTrans();
                            Db::table('ffc_users')->insertAll($insertdata);
                            //调用存储过程处理
                            $sql_update = "call update_count(3,'','','','{$users[0]['u_top_4']}','admin')";
                            Db::query($sql_update);
                            Db::commit();
                            //返回存储及返回用户数据
                            session('user', $insertdata[3]);
                            return put_encode($insertdata[3], '', '');
                        } catch (Exception $e) {
                            Db::rollback();
                            throw  new Exception(self::$error_code['12000014'],'12000014');
                        }
                    } else {
                        return put_encode(false, '12000012', self::$error_code['12000012']);
                    }
                    break;
                case 0://缺少 分公司  股东  总代  代理 用户
                    $insertdata = [
                        [
                            'u_username' => $top4,
                            'u_nick_name' => $top4,
                            'u_level' => 4,
                            'u_top_4' => '',
                            'u_top_3' => '',
                            'u_top_2' => '',
                            'u_top_1' => '',
                            'u_pwd' => $this->setPassword($top4.$pwdsalt),
                            'u_proportion_5' => 100,
                            'u_proportion_4' => 0,
                            'u_proportion_3' => 0,
                            'u_proportion_2' => 0,
                            'u_proportion_1' => 0,
                            'u_count_0' => 1,
                            'u_count_1' => 1,
                            'u_count_2' => 1,
                            'u_count_3' => 1,
                            'u_count_4' => 0,
                            'u_own_level' => 5,
                            'u_reg_time' => date("Y-m-d H:i:s", time()),
                            'u_is_test' => $data['dcUserType'] == 2 ? '1' : '2',
                            'u_status' => '8',
                            'u_site_id' => $data['dcSiteId'],
                            'u_last_ip' => $data['ip']
                        ],
                        [
                            'u_username' => $gudong,
                            'u_nick_name' => $gudong,
                            'u_level' => 3,
                            'u_top_4' => $top4,
                            'u_top_3' => '',
                            'u_top_2' => '',
                            'u_top_1' => '',
                            'u_pwd' => $this->setPassword($gudong.$pwdsalt),
                            'u_proportion_5' => 100,
                            'u_proportion_4' => 0,
                            'u_proportion_3' => 0,
                            'u_proportion_2' => 0,
                            'u_proportion_1' => 0,
                            'u_count_0' => 1,
                            'u_count_1' => 1,
                            'u_count_2' => 1,
                            'u_count_3' => 0,
                            'u_count_4' => 0,
                            'u_own_level' => 5,
                            'u_reg_time' => date("Y-m-d H:i:s", time()),
                            'u_is_test' => $data['dcUserType'] == 2 ? '1' : '2',
                            'u_status' => '8',
                            'u_site_id' => $data['dcSiteId'],
                            'u_last_ip' => $data['ip']
                        ],
                        [
                            'u_username' => $zongdai,
                            'u_nick_name' => $zongdai,
                            'u_level' => 2,
                            'u_top_4' => $top4,
                            'u_top_3' => $gudong,
                            'u_top_2' => '',
                            'u_top_1' => '',
                            'u_pwd' => $this->setPassword($zongdai.$pwdsalt),
                            'u_proportion_5' => 100,
                            'u_proportion_4' => 0,
                            'u_proportion_3' => 0,
                            'u_proportion_2' => 0,
                            'u_proportion_1' => 0,
                            'u_count_0' => 1,
                            'u_count_1' => 1,
                            'u_count_2' => 0,
                            'u_count_3' => 0,
                            'u_count_4' => 0,
                            'u_own_level' => 5,
                            'u_reg_time' => date("Y-m-d H:i:s", time()),
                            'u_is_test' => $data['dcUserType'] == 2 ? '1' : '2',
                            'u_status' => '8',
                            'u_site_id' => $data['dcSiteId'],
                            'u_last_ip' => $data['ip']
                        ],
                        [
                            'u_username' => $daili,
                            'u_nick_name' => $daili,
                            'u_level' => 1,
                            'u_top_4' => $top4,
                            'u_top_3' => $gudong,
                            'u_top_2' => $zongdai,
                            'u_top_1' => '',
                            'u_pwd' => $this->setPassword($daili.$pwdsalt),
                            'u_proportion_5' => 100,
                            'u_proportion_4' => 0,
                            'u_proportion_3' => 0,
                            'u_proportion_2' => 0,
                            'u_proportion_1' => 0,
                            'u_count_0' => 1,
                            'u_count_1' => 0,
                            'u_count_2' => 0,
                            'u_count_3' => 0,
                            'u_count_4' => 0,
                            'u_own_level' => 5,
                            'u_reg_time' => date("Y-m-d H:i:s", time()),
                            'u_is_test' => $data['dcUserType'] == 2 ? '1' : '2',
                            'u_status' => '8',
                            'u_site_id' => $data['dcSiteId'],
                            'u_last_ip' => $data['ip']
                        ],
                        [
                            'u_username' => $username,
                            'u_nick_name' => $username,
                            'u_level' => 0,
                            'u_top_4' => $top4,
                            'u_top_3' => $gudong,
                            'u_top_2' => $zongdai,
                            'u_top_1' => $daili,
                            'u_pwd' => $this->setPassword($username.$pwdsalt),
                            'u_proportion_5' => 100,
                            'u_proportion_4' => 0,
                            'u_proportion_3' => 0,
                            'u_proportion_2' => 0,
                            'u_proportion_1' => 0,
                            'u_count_0' => 0,
                            'u_count_1' => 0,
                            'u_count_2' => 0,
                            'u_count_3' => 0,
                            'u_count_4' => 0,
                            'u_own_level' => 5,
                            'u_reg_time' => date("Y-m-d H:i:s", time()),
                            'u_is_test' => $data['dcUserType'] == 2 ? '1' : '2',
                            'u_status' => '8',
                            'u_site_id' => $data['dcSiteId'],
                            'u_last_ip' => $data['ip']
                        ]
                    ];
                    try{
                        Db::startTrans();
                        $res = Db::table('ffc_users')->insertAll($insertdata);
                        //调用存储过程处理
                        $sql_update = "call update_count(3,'','','','','admin')";
                        Db::query($sql_update);
                        Db::commit();
                        //返回用户数据
                        return put_encode($insertdata[4], '', '');
                    } catch (Exception $e) {
                        Db::rollback();
                        throw  new Exception(self::$error_code['12000014'],'12000014');
                    }
                    break;
                default:
                    return put_encode(false, '12000013', self::$error_code['12000013']);
                    break;
            }
        } catch (Exception $e) {
            return put_encode(false, $e->getCode(), $e->getMessage());
        }
    }
}