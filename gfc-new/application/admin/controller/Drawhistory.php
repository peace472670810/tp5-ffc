<?php
namespace app\admin\controller;
use app\admin\controller\Base;
use think\Request;

class Drawhistory extends Base{
    public  function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
        $this->isLogin();
    }
    static $lottery=[
        '2'=>'重庆时时彩',
        '8'=>'新疆时时彩',
        '14'=>'天津时时彩',
        '30'=>'湖北快三',
        '9'=>'江苏快三',
        '24'=>'广东11选5',
        '26'=>'山东11选5',
        '27'=>'江西11选5',
        '28'=>'福彩3D',
        '29'=>'排列三/五',
        '6'=>'PK10'
    ];
    static $num=[
        '2'=>[1,2,3,4,5],
        '8'=>[1,2,3,4,5],
        '14'=>[1,2,3,4,5],
        '30'=>[1,2,3],
        '9'=>[1,2,3],
        '24'=>[1,2,3,4,5],
        '26'=>[1,2,3,4,5],
        '27'=>[1,2,3,4,5],
        '28'=>[1,2,3],
        '29'=>[1,2,3,4,5],
        '6'=>[1,2,3,4,5,6,7,8,9,10]
    ];
    /**
     * 开奖历史
     */
    public function getDrawhistory(){
        if($this->request->isGet()){
            $list='';
            $data['id']=$this->request->Get('id',2);
            $data['page']=$this->request->Get('page');
            $list = json_decode(forwarding('UserForwarding','\app\Service\drawhistory\business\drawhistory','historyList',$data),true);
            if($list['data']){
                $url = $this->request->baseUrl().'?id='.$data['id'];
                $this->assign('page',$this->getPage($url,$data['page']+1,$list['data']['page']['count'],$list['data']['page']['start'],$list['data']['page']['end']));
            }
            $this->assign('id',$data['id']);
            $this->assign('list',$list['data']['data']);
            $this->assign('lottery',self::$lottery);
            return $this->fetch('drawhistory/getDrawhistory');

        }
    }
    /**
     * 盘口列表
     */
    public function getIssues($data=[]){
        if($this->request->isGet()){
            $list='';
            $data['id']=$this->request->get('id',2);
            $data['page']=$this->request->get('page');
            $list = json_decode(forwarding('UserForwarding','\app\Service\drawhistory\business\drawhistory','issuesList',$data),true);
            if($list['data']){
                $url = $this->request->baseUrl().'?id='.$data['id'];
                $this->assign('page',$this->getPage($url,$data['page']+1,$list['data']['page']['count'],$list['data']['page']['start'],$list['data']['page']['end']));
            }
            $this->assign('id',$data['id']);
            $this->assign('list',$list['data']['data']);
            $this->assign('lottery',self::$lottery);
            $refresh = $this->request->get('refresh');
            $refresh = empty($refresh)?5:$refresh;
            $url = url()."?id=".$data['id']."&page=".$data['page'];
            $this->assign('url',$url);
            $this->assign('refresh',$refresh);
            return $this->fetch('drawhistory/getIssues');
        }
    }

    public function logs(){
        if($this->request->isGet()){
            $data['ds_lid']=$this->request->get('id');
            $data['ds_qishu']=$this->request->get('qishu');
            $list = json_decode(forwarding('UserForwarding','\app\Service\drawhistory\business\drawhistory','logsList',$data),true);
            $this->assign('list',$list);
            return $this->fetch('drawhistory/getLogs');
        }
    }

    public function kaijiang(){
        if($this->request->isGet()){
            $id=$this->request->get('lid');
            $qishu=$this->request->get('qishu');
            $this->assign('id',$id);
            $this->assign('lid',self::$lottery[$id]);
            $this->assign('num',count(self::$num[$id]));
            $this->assign('list',self::$num[$id]);
            $this->assign('qishu',$qishu);
            return $this->fetch('drawhistory/kaijiang');
        }
        $data=$this->request->post();
        $data['ip']=$this->request->ip();
        $list = json_decode(forwarding('UserForwarding','\app\Service\drawhistory\business\drawhistory','kaijiang',$data),true);
        $this->adminAddLogs('开奖,彩种：'.$data['lid']."期数：".$data['qishu'].'号码：'.json_encode($data['balls']).'返回内容：'.json_encode($list),'1');
        return $list;
    }

    public function jiesuan(){
        $data['lid']=$this->request->get('lid');
        $data['qishu']=$this->request->get('qishu');
        $data['ip']=$this->request->ip();
        $list = json_decode(forwarding('UserForwarding','\app\Service\drawhistory\business\drawhistory','jiesuan',$data),true);
        if($list['Result']){
            $this->adminAddLogs('结算成功,彩种：'.$data['lid']."期数：".$data['qishu'],'1');
            $this->success('结算成功!');
        }else{
            $this->adminAddLogs('结算成功,彩种：'.$data['lid']."期数：".$data['qishu'],'0');
            $this->error("结算失败!...{$list['Message']}");
        }
    }

    public function paijiang(){
        $data['lid']=$this->request->get('lid');
        $data['qishu']=$this->request->get('qishu');
        $data['ip']=$this->request->ip();
        $list = json_decode(forwarding('UserForwarding','\app\Service\drawhistory\business\drawhistory','paijiang',$data),true);
        if($list['Result']){
            $this->adminAddLogs('派奖成功,彩种：'.$data['lid']."期数：".$data['qishu'],'1');
            $this->success('派奖成功!');
        }else{
            $this->adminAddLogs('派奖失败,彩种：'.$data['lid']."期数：".$data['qishu'],'0');
            $this->error("派奖失败!...{$list['Message']}");
        }
    }

    public function kaipan(){
        $data['lid']=$this->request->get('lid');
        $data['qishu']=$this->request->get('qishu');
        $data['ip']=$this->request->ip();
        $data['state']=$this->request->get('state');
        $list = json_decode(forwarding('UserForwarding','\app\Service\drawhistory\business\drawhistory','kaipan',$data),true);
        if($list['Result']){
            $this->adminAddLogs(':开盘成功,彩种：'.$data['lid']."期数：".$data['qishu'].'状态：'. $data['state'],'1');
            $this->success('开盘成功!');
        }else{
            $this->adminAddLogs(':开盘失败,彩种：'.$data['lid']."期数：".$data['qishu'].'状态：'. $data['state'],'0');
            $this->error("开盘失败!...{$list['Message']}");
        }
    }

    public function fenpan(){
        $data['lid']=$this->request->get('lid');
        $data['qishu']=$this->request->get('qishu');
        $data['state']=$this->request->get('state');
        $data['ip']=$this->request->ip();
        $list = json_decode(forwarding('UserForwarding','\app\Service\drawhistory\business\drawhistory','fenpan',$data),true);
        if($list['Result']){
            $this->adminAddLogs(':封盘成功,彩种：'.$data['lid']."期数：".$data['qishu'].'状态：'. $data['state'],'1');
            $this->success('封盘成功!');
        }else{
            $this->adminAddLogs(':封盘失败,彩种：'.$data['lid']."期数：".$data['qishu'].'状态：'. $data['state'],'0');
            $this->error("封盘失败!...{$list['Message']}");
        }
    }

    public function huigun(){
        $data['lid']=$this->request->get('lid');
        $data['qishu']=$this->request->get('qishu');
        $data['ip']=$this->request->ip();
        $list = json_decode(forwarding('UserForwarding','\app\Service\drawhistory\business\drawhistory','huigun',$data),true);
        if($list['Result']){
            $this->adminAddLogs(':回滚成功,彩种：'.$data['lid']."期数：".$data['qishu'],'1');
            $this->success('回滚成功!');
        }else{
            $this->adminAddLogs(':回滚失败,彩种：'.$data['lid']."期数：".$data['qishu'],'0');
            $this->error("回滚失败!...{$list['Message']}");
        }
    }

    public function chexiao(){
        $data['lid']=$this->request->get('lid');
        $data['qishu']=$this->request->get('qishu');
        $data['ip']=$this->request->ip();
        $list = json_decode(forwarding('UserForwarding','\app\Service\drawhistory\business\drawhistory','chexiao',$data),true);
        if($list['Result']){
            $this->adminAddLogs(':撤销成功,彩种：'.$data['lid']."期数：".$data['qishu'],'1');
            $this->success('撤销成功!');
        }else{
            $this->adminAddLogs(':撤销失败,彩种：'.$data['lid']."期数：".$data['qishu'],'0');
            $this->error("撤销失败!...{$list['Message']}");
        }
    }

    public function pankouAdd(){
        $list['message']='';
        $data['lid'] = $this->request->Post('lid');
        if(empty($data['lid'])){
            $data['lid'] = $this->request->Get('id');
        }
        $data['start_time']=$this->request->Post('start_time',date('Y-m-d'));
        $data['zhongzi']=$this->request->Post('zhongzi','');
        if($this->request->isPost()){
            $list = json_decode(forwarding('UserForwarding','\app\Service\drawhistory\business\drawhistory','pankouAdd',$data),true);
            if(empty($list['data'])){
                $this->adminAddLogs('生成盘口:彩种ID'.$data['lid'].$list['message'],'0');
                $this->error("生成盘口失败!...{$list['message']}");
            }
        }
        $this->adminAddLogs('生成盘口:彩种ID'.$data['lid'],'1');
        $this->assign('text',json_encode($list['message']));
        $this->assign('list',$list['message']);
        $this->assign('id',$data['lid']);
        $this->assign('start_time',$data['start_time']);
        $this->assign('zhongzi',$data['zhongzi']);
        $this->assign('lottery',self::$lottery);
        return $this->fetch('drawhistory/pankouAdd');
    }

    public function addJiangqi(){
        $data=$this->request->Post();
        $data['ip']=$this->request->ip();
        $list = json_decode(forwarding('UserForwarding','\app\Service\drawhistory\business\drawhistory','addJiangqi',$data),true);
        if($list['data']){
            $this->adminAddLogs('添加了奖期:彩种ID'.$data['lid'],'1');
            $this->success('写入奖期成功!');
        }else{
            $this->adminAddLogs('添加了奖期:彩种ID'.$data['lid'],'0');
            $this->error("写入奖期失败!...{$list['message']}");
        }

    }
}