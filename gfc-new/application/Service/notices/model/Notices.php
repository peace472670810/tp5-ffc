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
        $result = $this->where('n_status','eq','1')->select();  
        $list = [];
        foreach ($result as $v){
            $list[] =  $v->data;
        }
       
        return  $list;
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