<?php
namespace app\index\controller;
use think\Controller;
use think\Url;

class Index extends Controller
{
    public function index()
    {

        $server = $this->request->server();
        $url = $server['SERVER_NAME'];
        $forward = '';
        switch ($url){
            case 'admin.newgfc.com':
                $forward = 'admin/index/login';
                break;
            case 'pc.newgfc.com':
                $forward = 'pc/game/play';
                break;
            case 'm.newgfc.com':
                $forward = 'mobile/game/play';
                break;
            default :
                halt("不是合法的域名，禁止访问！");
        }
        return  $this->redirect($forward);
    }
    public function test(){
        echo 'test';
    }
}
