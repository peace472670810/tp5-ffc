<?php 
namespace app\pc\controller;
use app\pc\controller\Base;
use think\Log;
class Api extends Base{
	public $lotteryTypes = array(
        '1' => '时时彩',
        '2' => '11选5',
        '4' => '福彩3D',
        '6' => '快3',
        '7' => '快乐扑克',
        '8' => 'PK10',
        '9' => '海南七星彩',
        '10' => '香港六合彩',
        '11' => '快乐十分',
    );
	public function chart() {
        $user = $this->user;
        //判断站点运营状态
        $is_run = $this->is_run();
        if($is_run['status']){
            $this->assign('message',$is_run['message'] );
            return $this->fetch('./message');
        }
        if (empty($user)) {
            $this->assign('url', '');
            $this->assign('message', "用户已经退出，请进入平台重新登录！");
            return $this->fetch('./message');
        }
        $lotteryId = $this->request->get('lottery_id', '1');
        $issueNum = $this->request->post('issueNum', '50');
        //取得 奖期信息
        $lottery = json_decode(forwarding('lotteryForwarding', '\app\Service\lottery\business\lottery', 'getLottery', $lotteryId), true);
        if (empty($lottery['data'])) {
        	$this->assign('url','');
        	$this->assign('message',$lottery['message'] );
            return $this->fetch('./message');
        }
        //动态更新加载
        $this->assign('v',time());
        //列出近几期 数据
        $data['lid']=$lotteryId;
        $data['issueNum']=$issueNum;
        $data['lottery_type']=$lottery['data']['lottery_type'];
        $issues = json_decode(forwarding('lotteryForwarding', '\app\Service\lottery\business\issues', 'getChart', $data), true);
        if (empty($issues['data'])) {
        	$this->assign('url','');
        	$this->assign('message',$issues['message'] );
            return $this->fetch('./message');
        } 
        $groups = array("万位", "千位", "百位", "十位", "个位");
        $vaildnum = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9'); //游戏有效号码
        switch ($lottery['data']['lottery_type']) {
            case 2:
                $vaildnum = array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11');
                break;
            case 8:
                $groups = array("第1名", "第2名", "第3名", "第4名", "第5名", "第6名", "第7名", "第8名", "第9名", "第10名");
                $vaildnum = array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10');
                break;
            case 4://福彩3D
                $groups = array("百位", "十位", "个位");
                break;
            case 6:
                $vaildnum = array('1', '2', '3', '4', '5', '6');
                $groups = array("奇偶数", "大小数");
                $sumnum = array('3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18');
                $oddeven = $bigsmall = array('0', '1', '2', '3');
                break;
            case 9:
                $groups = array("第一星", "第二星", "第三星", "第四星", "第五星", "第六星", "第七星");
            default:
                break;
        }
        $codeGroup = array();
        $totalGroup = count($groups);
        for ($i = 0; $i < $totalGroup; $i++) {
            $codeGroup[] = array("name" => $groups[$i],
                'wei' => $i,
                'ballstytle' => $i % 2 + 1,
                'normalstytle' => $i % 2 + 3
            );
        }
        $this->assign('lottery', $lottery['data']);
        $this->assign('codeGroup', $codeGroup);
        $this->assign('vaildnum', $vaildnum);
        $this->assign('totalNum', count($vaildnum));
        $this->assign('totalGroup', $totalGroup);
        $this->assign('codes', $issues['data']);
        switch ($lottery['data']['lottery_type']) {
            case 6:
                $scodeGroup = array(
                    "name" => '和值走势',
                    'wei' => 0,
                    'ballstytle' => 1,
                    'normalstytle' => 3
                );
                $this->assign('scodeGroup', $scodeGroup);
                $this->assign('sumnum', $sumnum);
                $this->assign('oddeven', $oddeven);
                return   $this->fetch("./game_k3_chart");
                break;
            default:
               return   $this->fetch("./game_chart");
        }
    }
}