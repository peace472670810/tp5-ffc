<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

return [
    // +----------------------------------------------------------------------
    // | 应用设置
    // +----------------------------------------------------------------------

    // 应用命名空间
    'app_namespace'          => 'app',
    // 应用调试模式
    'app_debug'              => true,
    // 应用Trace
    'app_trace'              => false,
    // 应用模式状态
    'app_status'             => '',
    // 是否支持多模块
    'app_multi_module'       => true,
    // 入口自动绑定模块
    'auto_bind_module'       => false,
    // 注册的根命名空间
    'root_namespace'         => [],
    // 扩展函数文件
    'extra_file_list'        => [THINK_PATH . 'helper' . EXT],
    // 默认输出类型
    'default_return_type'    => 'html',
    // 默认AJAX 数据返回格式,可选json xml ...
    'default_ajax_return'    => 'json',
    // 默认JSONP格式返回的处理方法
    'default_jsonp_handler'  => 'jsonpReturn',
    // 默认JSONP处理方法
    'var_jsonp_handler'      => 'callback',
    // 默认时区
    'default_timezone'       => 'PRC',
    // 是否开启多语言
    'lang_switch_on'         => false,
    // 默认全局过滤方法 用逗号分隔多个
    'default_filter'         => '',
    // 默认语言
    'default_lang'           => 'zh-cn',
    // 应用类库后缀
    'class_suffix'           => false,
    // 控制器类后缀
    'controller_suffix'      => false,
    //************************************************************************//
    //数据库配置文件
    //************************************************************************//
    // +----------------------------------------------------------------------
    //盘口库
    // +----------------------------------------------------------------------
    //注单库
    // +----------------------------------------------------------------------
    //试玩库
    // +----------------------------------------------------------------------
    //封锁值库
    // +----------------------------------------------------------------------
    //注单拉取库
    // +----------------------------------------------------------------------

    // +----------------------------------------------------------------------
    // | crateDB 连接配置
    // +----------------------------------------------------------------------
    'crate_conf'             =>'crate:10.10.195.20:4200',
    // +----------------------------------------------------------------------
    // |钱包接口 连接配置
    'wallet_address'                =>'http://10.10.0.1:9080/kg-fenfen-api/lottoGetMoney',
    'wallte_log_address'            =>'',
    'wallte_order_address'            =>'http://10.10.0.1:9080/kg-fenfen-api/fenfenLotto',
    'wallte_checkorder_address'          =>'http://10.10.0.1:9080/kg-fenfen-api/fenfenCheck',
    //钱包交易记录地址
    'wallet_order_log'      =>'http://10.10.239.138:9027/kg-money-api/memberMoneyLog',


    // +----------------------------------------------------------------------
    // |盘口部分 连接配置
    // 修改彩种的时候调用
    'pankou_url'      => 'http://10.10.2.6:5001/PanKou/SetPanKouStopTimeBySingle',
     //开奖接口
     'SetKaiJiang_url'   => 'http://10.10.2.6:5001/KaiJiang/SetKaiJiang',
     //手动结算
    'SetPanKouFinish_url' => 'http://10.10.2.6:5001/KaiJiang/SetPanKouFinish',
     //手动派奖
     'SetPanKouPay_url' =>  'http://10.10.2.6:5001/KaiJiang/SetPanKouPay',
     //撤销接口
     'SetPanKouCancel_url'  =>    'http://10.10.2.6:5001/KaiJiang/SetPanKouCancel',
     //回滚接口
     'SetPanKouRollback_url'    =>   'http://10.10.2.6:5001/KaiJiang/SetPanKouRollback',
     'SetPanKouStateBySingle_url'   =>  'http://10.10.2.6:5001/PanKou/SetPanKouStateBySingle',
     //盘口生成调用非种子
     'BuildPanKouListByDate_url'    =>  'http://10.10.2.6:5001/Other/BuildPanKouListByDate',
     //盘口生成调用带种子
     'BuildPanKouListByFirstQiShu_url'  =>  'http://10.10.2.6:5001/Other/BuildPanKouListByFirstQiShu',
     //盘口插入期数
     'AddPanKou_url'    =>  'http://10.10.2.6:5001/PanKou/AddPanKou',
    // +----------------------------------------------------------------------
    // +----------------------------------------------------------------------
    // | 奖期接口 连接配置
    // +----------------------------------------------------------------------
    'issue_address'                 =>'',
    // +----------------------------------------------------------------------
    // | 模块设置
    // +----------------------------------------------------------------------

    // 默认模块名
    'default_module'         => 'index',
    // 禁止访问模块
    'deny_module_list'       => ['common'],
    // 默认控制器名
    'default_controller'     => 'Index',
    // 默认操作名
    'default_action'         => 'index',
    // 默认验证器
    'default_validate'       => '',
    // 默认的空控制器名
    'empty_controller'       => 'Error',
    // 操作方法后缀
    'action_suffix'          => '',
    // 自动搜索控制器
    'controller_auto_search' => false,

    // +----------------------------------------------------------------------
    // | URL设置
    // +----------------------------------------------------------------------

    // PATHINFO变量名 用于兼容模式
    'var_pathinfo'           => 's',
    // 兼容PATH_INFO获取
    'pathinfo_fetch'         => ['ORIG_PATH_INFO', 'REDIRECT_PATH_INFO', 'REDIRECT_URL'],
    // pathinfo分隔符
    'pathinfo_depr'          => '/',
    // URL伪静态后缀
    'url_html_suffix'        => 'html',
    // URL普通方式参数 用于自动生成
    'url_common_param'       => false,
    // URL参数方式 0 按名称成对解析 1 按顺序解析
    'url_param_type'         => 0,
    // 是否开启路由
    'url_route_on'           => false,
    // 路由使用完整匹配
    'route_complete_match'   => false,
    // 路由配置文件（支持配置多个）
    'route_config_file'      => ['route'],
    // 是否强制使用路由
    'url_route_must'         => false,
    // 域名部署
    'url_domain_deploy'      => false,
    // 域名根，如thinkphp.cn
    'url_domain_root'        => '',
    // 是否自动转换URL中的控制器和操作名
    'url_convert'            => true,
    // 默认的访问控制器层
    'url_controller_layer'   => 'controller',
    // 表单请求类型伪装变量
    'var_method'             => '_method',
    // 表单ajax伪装变量
    'var_ajax'               => '_ajax',
    // 表单pjax伪装变量
    'var_pjax'               => '_pjax',
    // 是否开启请求缓存 true自动缓存 支持设置请求缓存规则
    'request_cache'          => false,
    // 请求缓存有效期
    'request_cache_expire'   => null,

    // +----------------------------------------------------------------------
    // | 模板设置
    // +----------------------------------------------------------------------

    'template'               => [
        // 模板引擎类型 支持 php think 支持扩展
        'type'         => 'Think',
        // 模板路径
        'view_path'    => '',
        // 模板后缀
        'view_suffix'  => 'html',
        // 模板文件名分隔符
        'view_depr'    => DS,
        // 模板引擎普通标签开始标记
        'tpl_begin'    => '{',
        // 模板引擎普通标签结束标记
        'tpl_end'      => '}',
        // 标签库标签开始标记
        'taglib_begin' => '{',
        // 标签库标签结束标记
        'taglib_end'   => '}',
    ],
    'captcha'  => [
        // 验证码字符集合
        'codeSet'  => '0123456789',
        // 验证码字体大小(px)
        'fontSize' => 16,
        // 是否画混淆曲线
        'useCurve' => false,
        // 验证码图片高度
        'imageH'   => 40,
        // 验证码图片宽度
        'imageW'   => 100,
        // 验证码位数
        'length'   => 3,
        // 验证成功后是否重置
        'reset'    => true,
        // 验证码密钥
        'seKey'    => 'ffc',
    ],

    // 视图输出字符串内容替换
    'view_replace_str'       => [

    ],
    // 默认跳转页面对应的模板文件
    'dispatch_success_tmpl'  => THINK_PATH . 'tpl' . DS . 'dispatch_jump.tpl',
    'dispatch_error_tmpl'    => THINK_PATH . 'tpl' . DS . 'dispatch_jump.tpl',

    // +----------------------------------------------------------------------
    // | 异常及错误设置
    // +----------------------------------------------------------------------

    // 异常页面的模板文件
    'exception_tmpl'         => THINK_PATH . 'tpl' . DS . 'think_exception.tpl',

    // 错误显示信息,非调试模式有效
    'error_message'          => '页面错误！请稍后再试～',
    // 显示错误信息
    'show_error_msg'         => true,
    // 异常处理handle类 留空使用 \think\exception\Handle
    'exception_handle'       => '',

    // +----------------------------------------------------------------------
    // | 日志设置
    // +----------------------------------------------------------------------

//    'log'                    => [
//        // 日志记录方式，内置 file socket 支持扩展
//        'type'  => 'File',
//        // 日志保存目录
//        'path'  => LOG_PATH,
//        // 日志记录级别
//        'level' => [
//            'error',
//            'sql',
//            'java_error',
//            'issue_error',
//            'mysql_error',
//            'tongji',
//            'jiaoyan',
//            'jiaoyanerror',
//            'yilou',
//        ],
//        'apart_level' =>[
//            'error',
//            'sql',
//            'java_error',
//            'issue_error',
//            'mysql_error',
//            'tongji',
//            'jiaoyan',
//            'jiaoyanerror',
//            'yilou',
//        ]
//    ],
    'log'     =>  [
        'type'                  =>  'socket',
        'host'                  =>  'localhost',
        'show_included_files'   =>  true,
        'force_client_ids'      =>  ['Jim1'],
        'allow_client_ids'      =>  ['Jim1'],
    ],

    // +----------------------------------------------------------------------
    // | Trace设置 开启 app_trace 后 有效
    // +----------------------------------------------------------------------
//    'trace'                  => [
//        // 内置Html Console 支持扩展
//        'type' => 'Html',
//        'trace_tabs' =>  [
//            'base'=>'基本',
//            'file'=>'文件',
//            'error|notice'=>'错误',
//            'sql'=>'SQL',
//            'debug|log|info'=>'调试',
//        ]
//    ],
    // +----------------------------------------------------------------------
    // | memcache缓存设置
    // +----------------------------------------------------------------------
    'memcache'=>'http://10.10.197.1:11211',
//    'memcache'=>'http://127.0.0.1:11211',
    // +----------------------------------------------------------------------
    // | 缓存设置
    // +----------------------------------------------------------------------

    'cache'                  => [
        // 驱动方式
        'type'   => 'File',
        // 缓存保存目录
        'path'   => CACHE_PATH,
        // 缓存前缀
        'prefix' => '',
        // 缓存有效期 0表示永久缓存
        'expire' => 1,
    ],

    // +----------------------------------------------------------------------
    // | 会话设置
    // +----------------------------------------------------------------------

    'session'                => [
        'id'             => '',
        // SESSION_ID的提交变量,解决flash上传跨域
        'var_session_id' => '',
        // SESSION 前缀
        'prefix'         => 'think',
        // 驱动方式 支持redis memcache memcached
        'type'           => '',
        // 是否自动开启 SESSION
        'auto_start'     => true,
    ],

    // +----------------------------------------------------------------------
    // | Cookie设置
    // +----------------------------------------------------------------------
    'cookie'                 => [
        // cookie 名称前缀
        'prefix'    => '',
        // cookie 保存时间
        'expire'    => 0,
        // cookie 保存路径
        'path'      => '/',
        // cookie 有效域名
        'domain'    => '',
        //  cookie 启用安全传输
        'secure'    => false,
        // httponly设置
        'httponly'  => '',
        // 是否使用 setcookie
        'setcookie' => true,
    ],

    //分页配置
    'paginate'               => [
        'type'      => 'bootstrap',
        'var_page'  => 'page',
        'list_rows' => 15,
    ],
    //权限control和action 全部使用小写字母
    'auth' => array(
        '1'=>array(
            'menu_id'=>'1',
            'parent_id'=>'1',//上级ID menu_id
            'title'=>'即时注单',//名称
            'control'=>'instant',//控制器
            'action'=>'getinstant',//行为
            'is_menu'=>'1',//是否菜单 1是  0 否
            'operate'=>'1'// 1是查看  2 操作
        ),
        '2'=>array(
            'menu_id'=>'2',
            'parent_id'=>'2',//上级ID
            'title'=>'账户管理',//名称
            'control'=>'',//控制器
            'action'=>'',//行为
            'is_menu'=>'1',//是否菜单 1是  0 否
            'operate'=>'1'// 1是查看  2 操作
        ),
        '3'=>array(
            'menu_id'=>'3',
            'parent_id'=>'2',//上级ID
            'title'=>'分公司列表',//名称
            'control'=>'user',//控制器
            'action'=>'getuser4',//行为
            'is_menu'=>'1',//是否菜单 1是  0 否
            'operate'=>'1'// 1是查看  2 操作
        ),
        '4'=>array(
            'menu_id'=>'4',
            'parent_id'=>'2',//上级ID
            'title'=>'添加分公司',//名称
            'control'=>'user',//控制器
            'action'=>'adduser4',//行为
            'is_menu'=>'0',//是否菜单 1是  0 否
            'operate'=>'2'// 1是查看  2 操作
        ),
        '5'=>array(
            'menu_id'=>'5',
            'parent_id'=>'2',//上级ID
            'title'=>'修改分公司',//名称
            'control'=>'user',//控制器
            'action'=>'edituser4',//行为
            'is_menu'=>'0',//是否菜单 1是  0 否
            'operate'=>'2'// 1是查看  2 操作
        ),
        '6'=>array(
            'menu_id'=>'6',
            'parent_id'=>'2',//上级ID
            'title'=>'股东列表',//名称
            'control'=>'user',//控制器
            'action'=>'getuser3',//行为
            'is_menu'=>'1',//是否菜单 1是  0 否
            'operate'=>'1'// 1是查看  2 操作
        ),
        '7'=>array(
            'menu_id'=>'7',
            'parent_id'=>'2',//上级ID
            'title'=>'添加股东',//名称
            'control'=>'user',//控制器
            'action'=>'adduser3',//行为
            'is_menu'=>'0',//是否菜单 1是  0 否
            'operate'=>'2'// 1是查看  2 操作
        ),
        '8'=>array(
            'menu_id'=>'8',
            'parent_id'=>'2',//上级ID
            'title'=>'修改股东',//名称
            'control'=>'user',//控制器
            'action'=>'edituser3',//行为
            'is_menu'=>'0',//是否菜单 1是  0 否
            'operate'=>'2'// 1是查看  2 操作
        ),
        '9'=>array(
            'menu_id'=>'9',
            'parent_id'=>'2',//上级ID
            'title'=>'总代列表',//名称
            'control'=>'user',//控制器
            'action'=>'getuser2',//行为
            'is_menu'=>'1',//是否菜单 1是  0 否
            'operate'=>'1'// 1是查看  2 操作
        ),
        '10'=>array(
            'menu_id'=>'10',
            'parent_id'=>'2',//上级ID
            'title'=>'添加总代',//名称
            'control'=>'user',//控制器
            'action'=>'adduser2',//行为
            'is_menu'=>'0',//是否菜单 1是  0 否
            'operate'=>'2'// 1是查看  2 操作
        ),
        '11'=>array(
            'menu_id'=>'11',
            'parent_id'=>'2',//上级ID
            'title'=>'修改总代',//名称
            'control'=>'user',//控制器
            'action'=>'edituser2',//行为
            'is_menu'=>'0',//是否菜单 1是  0 否
            'operate'=>'2'// 1是查看  2 操作
        ),
        '12'=>array(
            'menu_id'=>'12',
            'parent_id'=>'2',//上级ID
            'title'=>'代理列表',//名称
            'control'=>'user',//控制器
            'action'=>'getuser1',//行为
            'is_menu'=>'1',//是否菜单 1是  0 否
            'operate'=>'1'// 1是查看  2 操作
        ),
        '13'=>array(
            'menu_id'=>'13',
            'parent_id'=>'2',//上级ID
            'title'=>'添加代理',//名称
            'control'=>'user',//控制器
            'action'=>'adduser1',//行为
            'is_menu'=>'0',//是否菜单 1是  0 否
            'operate'=>'2'// 1是查看  2 操作
        ),
        '14'=>array(
            'menu_id'=>'14',
            'parent_id'=>'2',//上级ID
            'title'=>'修改代理',//名称
            'control'=>'user',//控制器
            'action'=>'edituser1',//行为
            'is_menu'=>'0',//是否菜单 1是  0 否
            'operate'=>'2'// 1是查看  2 操作
        ),
        '15'=>array(
            'menu_id'=>'15',
            'parent_id'=>'2',//上级ID
            'title'=>'会员列表',//名称
            'control'=>'user',//控制器
            'action'=>'getuser0',//行为
            'is_menu'=>'1',//是否菜单 1是  0 否
            'operate'=>'1'// 1是查看  2 操作
        ),
        '16'=>array(
            'menu_id'=>'16',
            'parent_id'=>'2',//上级ID
            'title'=>'添加会员',//名称
            'control'=>'user',//控制器
            'action'=>'adduser0',//行为
            'is_menu'=>'0',//是否菜单 1是  0 否
            'operate'=>'2'// 1是查看  2 操作
        ),
        '17'=>array(
            'menu_id'=>'17',
            'parent_id'=>'2',//上级ID
            'title'=>'修改会员',//名称
            'control'=>'user',//控制器
            'action'=>'edituser0',//行为
            'is_menu'=>'0',//是否菜单 1是  0 否
            'operate'=>'2'// 1是查看  2 操作
        ),
        '18'=>array(
            'menu_id'=>'18',
            'parent_id'=>'2',//上级ID
            'title'=>'子账号列表',//名称
            'control'=>'admin',//控制器
            'action'=>'adminlist',//行为
            'is_menu'=>'1',//是否菜单 1是  0 否
            'operate'=>'1'// 1是查看  2 操作
        ),
        '19'=>array(
            'menu_id'=>'19',
            'parent_id'=>'2',//上级ID
            'title'=>'添加子账号',//名称
            'control'=>'admin',//控制器
            'action'=>'adminadd',//行为
            'is_menu'=>'0',//是否菜单 1是  0 否
            'operate'=>'2'// 1是查看  2 操作
        ),
        '20'=>array(
            'menu_id'=>'20',
            'parent_id'=>'2',//上级ID
            'title'=>'修改子账号',//名称
            'control'=>'admin',//控制器
            'action'=>'adminedit',//行为
            'is_menu'=>'0',//是否菜单 1是  0 否
            'operate'=>'2'// 1是查看  2 操作
        ),
        '21'=>array(
            'menu_id'=>'21',
            'parent_id'=>'21',//上级ID
            'title'=>'开奖管理',//名称
            'control'=>'',//控制器
            'action'=>'',//行为
            'is_menu'=>'1',//是否菜单 1是  0 否
            'operate'=>'1'// 1是查看  2 操作
        ),
        '22'=>array(
            'menu_id'=>'22',
            'parent_id'=>'21',//上级ID
            'title'=>'盘口管理',//名称
            'control'=>'drawhistory',//控制器
            'action'=>'getissues',//行为
            'is_menu'=>'1',//是否菜单 1是  0 否
            'operate'=>'1'// 1是查看  2 操作
        ),
        '23'=>array(
            'menu_id'=>'23',
            'parent_id'=>'21',//上级ID
            'title'=>'新增盘口',//名称
            'control'=>'drawhistory',//控制器
            'action'=>'pankouadd',//行为
            'is_menu'=>'0',//是否菜单 1是  0 否
            'operate'=>'2'// 1是查看  2 操作
        ),
        '24'=>array(
            'menu_id'=>'24',
            'parent_id'=>'21',//上级ID
            'title'=>'盘口奖期写入',//名称
            'control'=>'drawhistory',//控制器
            'action'=>'addjiangqi',//行为
            'is_menu'=>'0',//是否菜单 1是  0 否
            'operate'=>'2'// 1是查看  2 操作
        ),
        '25'=>array(
            'menu_id'=>'25',
            'parent_id'=>'21',//上级ID
            'title'=>'盘口日志',//名称
            'control'=>'drawhistory',//控制器
            'action'=>'logs',//行为
            'is_menu'=>'0',//是否菜单 1是  0 否
            'operate'=>'1'// 1是查看  2 操作
        ),
        '26'=>array(
            'menu_id'=>'26',
            'parent_id'=>'21',//上级ID
            'title'=>'开盘',//名称
            'control'=>'drawhistory',//控制器
            'action'=>'kaipan',//行为
            'is_menu'=>'0',//是否菜单 1是  0 否
            'operate'=>'2'// 1是查看  2 操作
        ),
        '27'=>array(
            'menu_id'=>'27',
            'parent_id'=>'21',//上级ID
            'title'=>'封盘',//名称
            'control'=>'drawhistory',//控制器
            'action'=>'fenpan',//行为
            'is_menu'=>'0',//是否菜单 1是  0 否
            'operate'=>'2'// 1是查看  2 操作
        ),
        '28'=>array(
            'menu_id'=>'28',
            'parent_id'=>'21',//上级ID
            'title'=>'回滚',//名称
            'control'=>'drawhistory',//控制器
            'action'=>'huigun',//行为
            'is_menu'=>'0',//是否菜单 1是  0 否
            'operate'=>'2'// 1是查看  2 操作
        ),
        '29'=>array(
            'menu_id'=>'29',
            'parent_id'=>'21',//上级ID
            'title'=>'开奖',//名称
            'control'=>'drawhistory',//控制器
            'action'=>'kaijiang',//行为
            'is_menu'=>'0',//是否菜单 1是  0 否
            'operate'=>'2'// 1是查看  2 操作
        ),
        '30'=>array(
            'menu_id'=>'30',
            'parent_id'=>'21',//上级ID
            'title'=>'撤销',//名称
            'control'=>'drawhistory',//控制器
            'action'=>'chexiao',//行为
            'is_menu'=>'0',//是否菜单 1是  0 否
            'operate'=>'2'// 1是查看  2 操作
        ),
        '31'=>array(
            'menu_id'=>'31',
            'parent_id'=>'21',//上级ID
            'title'=>'结算',//名称
            'control'=>'drawhistory',//控制器
            'action'=>'jiesuan',//行为
            'is_menu'=>'0',//是否菜单 1是  0 否
            'operate'=>'2'// 1是查看  2 操作
        ),
        '32'=>array(
            'menu_id'=>'32',
            'parent_id'=>'21',//上级ID
            'title'=>'派彩',//名称
            'control'=>'drawhistory',//控制器
            'action'=>'paijiang',//行为
            'is_menu'=>'0',//是否菜单 1是  0 否
            'operate'=>'2'// 1是查看  2 操作
        ),
        '33'=>array(
            'menu_id'=>'33',
            'parent_id'=>'21',//上级ID
            'title'=>'历史开奖',//名称
            'control'=>'drawhistory',//控制器
            'action'=>'getdrawhistory',//行为
            'is_menu'=>'1',//是否菜单 1是  0 否
            'operate'=>'1'// 1是查看  2 操作
        ),
        '34'=>array(
            'menu_id'=>'34',
            'parent_id'=>'34',//上级ID
            'title'=>'报表管理',//名称
            'control'=>'',//控制器
            'action'=>'',//行为
            'is_menu'=>'1',//是否菜单 1是  0 否
            'operate'=>'1'// 1是查看  2 操作
        ),
        '35'=>array(
            'menu_id'=>'35',
            'parent_id'=>'34',//上级ID
            'title'=>'注单搜索',//名称
            'control'=>'order',//控制器
            'action'=>'getorder',//行为
            'is_menu'=>'1',//是否菜单 1是  0 否
            'operate'=>'1'// 1是查看  2 操作
        ),
        '36'=>array(
            'menu_id'=>'36',
            'parent_id'=>'34',//上级ID
            'title'=>'注单详情',//名称
            'control'=>'order',//控制器
            'action'=>'orderdetail',//行为
            'is_menu'=>'0',//是否菜单 1是  0 否
            'operate'=>'1'// 1是查看  2 操作
        ),
        '37'=>array(
            'menu_id'=>'37',
            'parent_id'=>'34',//上级ID
            'title'=>'追号方案',//名称
            'control'=>'order',//控制器
            'action'=>'gettrace',//行为
            'is_menu'=>'1',//是否菜单 1是  0 否
            'operate'=>'1'// 1是查看  2 操作
        ),
        '38'=>array(
            'menu_id'=>'38',
            'parent_id'=>'34',//上级ID
            'title'=>'追号详情',//名称
            'control'=>'order',//控制器
            'action'=>'tracedetail',//行为
            'is_menu'=>'0',//是否菜单 1是  0 否
            'operate'=>'1'// 1是查看  2 操作
        ),
        //不同层级查看的问题在代码里已经解决
        '39'=>array(
            'menu_id'=>'39',
            'parent_id'=>'34',//上级ID
            'title'=>'交付报表',//名称
            'control'=>'report',//控制器
            'action'=>'getreport',//行为
            'is_menu'=>'1',//是否菜单 1是  0 否
            'operate'=>'1'// 1是查看  2 操作
        ),
        '40'=>array(
            'menu_id'=>'40',
            'parent_id'=>'34',//上级ID
            'title'=>'会员订单',//名称
            'control'=>'report',//控制器
            'action'=>'detailreport',//行为
            'is_menu'=>'0',//是否菜单 1是  0 否
            'operate'=>'1'// 1是查看  2 操作
        ),
        '41'=>array(
            'menu_id'=>'41',
            'parent_id'=>'34',//上级ID
            'title'=>'会员报表',//名称
            'control'=>'report',//控制器
            'action'=>'userreport',//行为
            'is_menu'=>'1',//是否菜单 1是  0 否
            'operate'=>'1'// 1是查看  2 操作
        ),
        '42'=>array(
            'menu_id'=>'42',
            'parent_id'=>'42',//上级ID
            'title'=>'公告管理',//名称
            'control'=>'notices',//控制器
            'action'=>'getnotice',//行为
            'is_menu'=>'1',//是否菜单 1是  0 否
            'operate'=>'1'// 1是查看  2 操作
        ),
        '43'=>array(
            'menu_id'=>'43',
            'parent_id'=>'42',//上级ID
            'title'=>'添加公告',//名称
            'control'=>'notices',//控制器
            'action'=>'addnotice',//行为
            'is_menu'=>'0',//是否菜单 1是  0 否
            'operate'=>'2'// 1是查看  2 操作
        ),
        '44'=>array(
            'menu_id'=>'44',
            'parent_id'=>'42',//上级ID
            'title'=>'修改公告',//名称
            'control'=>'notices',//控制器
            'action'=>'editnotice',//行为
            'is_menu'=>'0',//是否菜单 1是  0 否
            'operate'=>'2'// 1是查看  2 操作
        ),
        '45'=>array(
            'menu_id'=>'45',
            'parent_id'=>'42',//上级ID
            'title'=>'删除公告',//名称
            'control'=>'notices',//控制器
            'action'=>'delnotice',//行为
            'is_menu'=>'0',//是否菜单 1是  0 否
            'operate'=>'2'// 1是查看  2 操作
        ),
        '46'=>array(
            'menu_id'=>'46',
            'parent_id'=>'46',//上级ID
            'title'=>'日志管理',//名称
            'control'=>'',//控制器
            'action'=>'',//行为
            'is_menu'=>'1',//是否菜单 1是  0 否
            'operate'=>'1'// 1是查看  2 操作
        ),
        '47'=>array(
            'menu_id'=>'47',
            'parent_id'=>'46',//上级ID
            'title'=>'会员登录日志',//名称
            'control'=>'logs',//控制器
            'action'=>'getuserlogs',//行为
            'is_menu'=>'1',//是否菜单 1是  0 否
            'operate'=>'1'// 1是查看  2 操作
        ),
        '48'=>array(
            'menu_id'=>'48',
            'parent_id'=>'46',//上级ID
            'title'=>'用户操作日志',//名称
            'control'=>'logs',//控制器
            'action'=>'getlogs',//行为
            'is_menu'=>'1',//是否菜单 1是  0 否
            'operate'=>'1'// 1是查看  2 操作
        ),
        '49'=>array(
            'menu_id'=>'49',
            'parent_id'=>'49',//上级ID
            'title'=>'内部管理',//名称
            'control'=>'',//控制器
            'action'=>'',//行为
            'is_menu'=>'1',//是否菜单 1是  0 否
            'operate'=>'1'// 1是查看  2 操作
        ),
        '50'=>array(
            'menu_id'=>'50',
            'parent_id'=>'49',//上级ID
            'title'=>'系统初始化设定',//名称
            'control'=>'system',//控制器
            'action'=>'systeminitial',//行为
            'is_menu'=>'1',//是否菜单 1是  0 否
            'operate'=>'2'// 1是查看  2 操作
        ),
        '51'=>array(
            'menu_id'=>'51',
            'parent_id'=>'49',//上级ID
            'title'=>'彩种设置',//名称
            'control'=>'system',//控制器
            'action'=>'systemlottery',//行为
            'is_menu'=>'1',//是否菜单 1是  0 否
            'operate'=>'2'// 1是查看  2 操作
        ),
        '52'=>array(
            'menu_id'=>'52',
            'parent_id'=>'49',//上级ID
            'title'=>'赔率设定',//名称
            'control'=>'system',//控制器
            'action'=>'systemrebate',//行为
            'is_menu'=>'1',//是否菜单 1是  0 否
            'operate'=>'2'// 1是查看  2 操作
        ),
        '53'=>array(
            'menu_id'=>'53',
            'parent_id'=>'1',//上级ID menu_id
            'title'=>'即时注单（订单列表）',//名称
            'control'=>'instant',//控制器
            'action'=>'groupinstant',//行为
            'is_menu'=>'0',//是否菜单 1是  0 否
            'operate'=>'1'// 1是查看  2 操作
        ),
        '54'=>array(
            'menu_id'=>'54',
            'parent_id'=>'49',//上级ID menu_id
            'title'=>'赔率修改',//名称
            'control'=>'system',//控制器
            'action'=>'editrebate',//行为
            'is_menu'=>'0',//是否菜单 1是  0 否
            'operate'=>'2'// 1是查看  2 操作
        ),
        '55'=>array(
            'menu_id'=>'55',
            'parent_id'=>'49',//上级ID menu_id
            'title'=>'封锁值设定',//名称
            'control'=>'system',//控制器
            'action'=>'systemlocks',//行为
            'is_menu'=>'1',//是否菜单 1是  0 否
            'operate'=>'2'// 1是查看  2 操作
        ),
        '56'=>array(
            'menu_id'=>'56',
            'parent_id'=>'34',//上级ID menu_id
            'title'=>'转账记录',//名称
            'control'=>'order',//控制器
            'action'=>'transferrecord',//行为
            'is_menu'=>'1',//是否菜单 1是  0 否
            'operate'=>'2'// 1是查看  2 操作
        ),
    ),
];