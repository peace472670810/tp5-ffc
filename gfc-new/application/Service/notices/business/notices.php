<?php
/**
 * Created by PhpStorm.
 * User: Jim FAN
 * Date: 2017/5/20
 * Time: 15:49
 */

namespace app\Service\notices\business;
use app\Service\notices\model\Notices as model_notices;
use think\image\Exception;

class notices
{
    /**
     * 错误码
     * @var array
     */
    static  public  $error_code = [
        '50000000'=>'标题和内容不能为空！',
        '50000001'=>'标题和内容不能为空！',
        '50000002'=>'标题id不能为空！',
    ];
    public $model = '';
    public  function  __construct()
    {
        $this->model = new model_notices();
    }

    /**
     * 获取公告
     */
    public function getNotice($data = []){

        $data = $this->model->getList();
        return  $data;
    }

    /**
     * 添加公告
     */
    public function addNotice($data){
        try{
            $data = $this->dataFilter($data,1);
            if($this->model->addNotice($data)){
                return  put_encode(true,'','添加成功');
            }else{
                return  put_encode(false,'','添加失败');
            }
        }catch (Exception $e){
            return put_encode(false,$e->getCode(),$e->getMessage());
        }
    }

    /**
     * 修改公告
     * op=0 获取公告
     * op=1 修改公告
     */
    public  function editNotice($data){
        try{
            if($data['op']){
                $data = $this->dataFilter($data,2);
                if($this->model->editNotice($data[0],$data[1],1)){
                    return put_encode(true,'','修改成功！');
                }else{
                    return put_encode(false,'','修改失败！');
                }
            }else{
                if(empty($data['n_id'])){
                    return put_encode('no_id不能为空！','50000002',self::$error_code['50000002']);
                }
                $id = ['n_id'=>$data['n_id']];
                return put_encode($this->model->editNotice('',$id,0),'','');
            }
        }catch (Exception $e){
            return put_encode(false,$e->getCode(),$e->getMessage());
        }
    }

    /**
     * 删除公告
     */
    public  function delNotice($data){
        try{
            $data = $this->dataFilter($data,3);

            if($this->model->delNotice($data)){
                return put_encode(true,'','删除成功！');
            }else{
                return put_encode(false,'','删除失败！');
            }
        }catch (Exception $e){
            return put_encode(false,$e->getCode(),$e->getMessage());
        }
    }

    /**
     * 数据过滤
     * @param array $data
     * @param int $type 1增  2 修  3删
     */
    public function dataFilter($data=[],$type=0){
        $filter = [];
        switch ($type){
            case 0:
                break;
            case 1:
                $filter['n_title'] =fliter_sql($data['n_title']);
                $filter['n_content'] =empty($data['n_content'])?'':fliter_sql($data['n_content']);
                if(empty($filter['n_title'])||empty($filter['n_content']) ){
                    throw  new Exception(self::$error_code['50000001'],'50000001');
                }
                $filter['n_end_time'] =  $data['n_end_time'];
                $filter['n_start_time'] =  $data['n_start_time'];
                $filter['n_update_time'] =  $data['n_update_time'];
                $filter['n_status'] =  $data['n_status'];
                break;
            case 2:
                $filter[0]['n_title'] =fliter_sql($data['n_title']);
                $filter[0]['n_content'] =fliter_sql($data['n_content']);
                $filter[0]['n_end_time'] =  $data['n_end_time'];
                $filter[0]['n_start_time'] =  $data['n_start_time'];
                $filter[0]['n_update_time'] =  $data['n_update_time'];
                $filter[0]['n_status'] =  $data['n_status'];
                $filter[1]['n_id'] =  $data['n_id'];
                if(empty($filter[1]['n_id'])){
                    throw  new Exception(self::$error_code['50000002'],'50000002');
                }
                break;
            case 3:
                $filter['n_id'] =  $data['n_id'];
                if(empty( $filter['n_id'])){
                    throw  new Exception(self::$error_code['50000002'],'50000002');
                }
                break;
        }

        return $filter;
    }
}