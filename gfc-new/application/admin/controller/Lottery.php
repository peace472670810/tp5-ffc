<?php
namespace app\admin\controller;

use app\admin\controller\Base;
use think\Request;

class Lottery extends Base
{
    /**
     *  彩种列表
     */
    public function getLottery()
    {
        $list = json_decode(forwarding('lotteryForwarding', '\app\Service\lottery\business\lottery', 'getList', ''), true);
        $this->assign('list', $list['data']);
        return $this->fetch('lottery/getLottery');
    }

    /**
     * 玩法组列表
     */
    public function method_groups()
    {
        $data['lid'] = $this->request->get('lid');
        $list = json_decode(forwarding('lotteryForwarding', '\app\Service\lottery\business\method_groups', 'getMethodGroupList', $data), true);
        $lottery = $this->request->get('lottery');
        $this->assign('lottery',empty($lottery)?'':$lottery);
        $this->assign('list',$list['data']);
        return $this->fetch('lottery/method_groups');
    }

    /**
     *玩法列表
     */
    public function methods()
    {
        $data['mg_id'] = $this->request->get('mg_id');
        $list = json_decode(forwarding('lotteryForwarding', '\app\Service\lottery\business\methods', 'getMethodList', $data), true);
        $this->assign('list',$list['data']);
        $method_group = $this->request->get('method_group');
        $this->assign('method_group',empty($method_group)?'':$method_group);
        return $this->fetch('lottery/methods');
    }

    /**
     *玩法奖金详情列表
     */
    public function prizes()
    {
        $data['m_id'] = $this->request->get('m_id');
        $list = json_decode(forwarding('lotteryForwarding', '\app\Service\lottery\business\prizes', 'getPrizeList', $data), true);
        $this->assign('list',$list['data']);
        $method = $this->request->get('method');
        $this->assign('method',empty($method)?'':$method);
        return $this->fetch('lottery/prizes');
    }

    /**
     * 封锁列表
     */
    public function getLocks()
    {
        $list = json_decode(forwarding('lotteryForwarding', '\app\Service\lottery\business\lottery', 'getList', ''), true);
        $this->assign('list', $list);
        return $this->fetch('lottery/getLocks');
    }

    public function addLocks()
    {
        $this->request->isGET();

        return json_encode(array('true'));
    }
}