<?php
/**
 * Created by PhpStorm.
 * User: Jim FAN
 * Date: 2017/5/20
 * Time: 15:40
 */

namespace app\Service\notices\model;
use think\Model;
class Notices extends Model
{
 
    /**
     * 获取公告列表
     * @param array $data
     * @return array|false|\PDOStatement|string|Model
     */
   public  function getList($data=[]){
       $start = $data['page']*$data['count'];
       $count = $data['count'];
       $arr['list'] =  $this->query("select * from  ffc_notices where n_status=1  limit $start,$count");
       $total = $this->query("select count(*) from  ffc_notices where n_status=1  limit 1");
       $arr['total'] = $total[0]['count(*)'];
       $arr['start'] = $start;
       $arr['end'] = $start + $count;
        return  $arr;
    }

    /**
     * 数据更新
     * @param array $data
     * @return false|int
     */
   public  function editNotice($data = [],$id=[],$op=0){
       if($op == 0){
           $notice = $this->where($id)->find();
           return  $notice->data;
       }else{
           return $this->save($data,$id);
       }

   }

    /**
     * 添加
     * @param array $data
     */
   public function addNotice($data=[]){

        return $this->save($data);
   }

    /**
     * 删除
     */
   public function delNotice($data=[]){
        $status=array('n_status'=>'0');
        return $this->save($status,$data);
   }

}