<?php
/**
 * Created by PhpStorm.
 * User: Jim FAN
 * Date: 2017/5/30
 * Time: 19:20
 *  使用数据库里面的方法详情
 */

namespace app\Service\lottery\model;

use think\Model;

class Methods extends Model
{
    /**
     * 根据玩法组获取玩法列表
     */
    public function getMothodList($mg_id = 1)
    {
        $arr = $this->query("select * from  ffc_methods where m_mg_id=$mg_id");
        return  $arr;
    }
    /**
     * 根据玩法组获取玩法列表
     */
    public function getMethodBylid($lid = 1,$byId=false)
    {
        $list = $this->query("select * from  ffc_methods where m_lid=$lid ");
        $arr = [];
        if($byId){
            foreach ($list  as $k=>$v){
                $arr[$v['m_id']] = $v;
            }
            return  $arr;
        }else{
            return $list;
        }
    }

    /**
     * 获取玩法详情
     * @param $m_id
     */
    public function getMothodDetail($m_id)
    {
        $list = $this->query("select * from  ffc_methods where m_id=$m_id ");
        return $list[0];
    }
}