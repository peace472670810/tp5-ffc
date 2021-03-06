<?php
namespace app\admin\controller;
use app\admin\controller\Base;
use think\Request;
class Instant  extends  Base{
    public  function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
        $this->isLogin();
    }
    //即时订单列表
    public function getInstant(){
        $data['lid']=$this->request->Get('id','2');
        $lottery=json_decode(forwarding('UserForwarding','\app\Service\lottery\business\lottery','getAdmin',$data),true);
        $list=json_decode(forwarding('UserForwarding','\app\Service\lottery\business\issues','getCurrentIssue',$data),true);
        $arr['lid']=$data['lid'];
        $arr['issue']=$list['data']['issueInfo']['issue'];
        //$arr['o_top_'.session('level')]=session('u_name');
        $arr['level']=session('level');
        $arr['u_name']=session('u_name');
        $text=json_decode(forwarding('UserForwarding','\app\Service\instant\business\instant','getInstant',$arr),true);
        if(empty($list['data'])){
            return $this->fetch();
        }
        $list['data']['issueInfo']['fenpan_time']=strtotime($list['data']['issueInfo']['end_time']);
        $list['data']['issueInfo']['instant_time']=time();
        $huizon=forwarding('UserForwarding','\app\Service\order\business\order','countInstant',$arr);
        $this->assign('huizon',$huizon);
        $this->assign('text',$text['data']);
        $this->assign('list',$list['data']);
        $this->assign('id',$data['lid']);
        $this->assign('lottery',$lottery['data']);
        return $this->fetch('instant/getInstant');
    }
    public function groupInstant(){
        $data['lid']=$this->request->get('lid');
        $data['mg_id']=$this->request->get('mg_id');
        $data['mg_name']=$this->request->get('mg_name');
        $data['o_issue']=$this->request->get('o_issue');
        $data['level']=session('level');
        $data['u_name']=session('u_name');
        $text=json_decode(forwarding('UserForwarding','\app\Service\order\business\order','groupInstant',$data),true);
        if($text['data']){
            $lottery=forwarding('UserForwarding','\app\Service\lottery\business\lottery','getAdmin',$data);
            $this->assign('lottery',$lottery);
            $this->assign('data',$data);
            $this->assign('list',$text['message']);
            return $this->fetch('instant/groupInstant');
        }
        return $this->error("{$text['Message']}");
    }
    public function ajaxInstant(){
        $data['lid']=$this->request->Get('id','2');
        $arr['issue']=$this->request->Get('issue');
        $arr['level']=session('level');
        $arr['u_name']=session('u_name');
        $list=json_decode(forwarding('UserForwarding','app\Service\lottery\business\issues','getCurrentIssue',$data),true);
        $arr['lid']=$data['lid'];
        $text=json_decode(forwarding('UserForwarding','app\Service\instant\business\instant','getInstant',$arr),true);
        if(empty($list['data'])){
            return $this->fetch();
        }
        $huizon=forwarding('UserForwarding','app\Service\order\business\order','countInstant',$arr);
        $this->assign('huizon',$huizon);
        $this->assign('text',$text['data']);
        $this->assign('id',$data['lid']);
        return $this->fetch('instant/ajaxInstant');
    }
    public function lastIssueInfo(){
        $data['lid']=$this->request->Get('id','2');
        $list=json_decode(forwarding('UserForwarding','app\Service\lottery\business\issues','lastIssueInfo',$data),true);
        return json_encode($list['data']);
        return $list['data'];
    }
}
?>