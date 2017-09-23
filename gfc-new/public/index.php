<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// [ 应用入口文件 ]
define('DEFAULT_PER_PAGE', 50);     // 每页显示记录数 全局常量
define('REBATE_PRECISION', 4);      //返点小数点精度
define('PRIZE_PRECISION', 4);       //奖金小数点精度
define('DS_TOKEN_LIVE',10);         //密钥有效时间
define('DS_ONLINE_TIME',180);
define('DS_ONLINE_UPDATE_TIME',150);
define('DS_PRIZE_LIMIT',2000000000); //倍投金额限制
// 定义应用目录
define('APP_PATH', __DIR__ . '/../application/');
// 加载框架引导文件
require __DIR__ . '/../thinkphp/start.php';