<?php
/**
 * Created by PhpStorm.
 * User: Jim FAN
 * Date: 2017/6/15
 * Time: 20:00
 */

namespace app\Service\lottery\business;
use app\Service\lottery\model\Prizes as prize_model;

class prizes
{
    public static $error_code = [
        '123000001'=>'参数不合法'
    ];
    public  $prize_model = null;
    public function __construct()
    {
        $this->prize_model = new prize_model();
    }
    public function getPrizeList($data){

        if((!is_numeric($data['m_id'])||empty($data['m_id']))){
            return  put_encode(false,'123000001',self::$error_code['123000001']);
        }
        $list = $this->prize_model->getPrizeByMethod($data);
        return  put_encode($list,'','');
    }

    public function getPrizeByLid($data){

        if((!is_numeric($data['lid'])||empty($data['lid']))){
            return  put_encode(false,'123000001',self::$error_code['123000001']);
        }

        $list = $this->prize_model->getPrizeByLid($data);
        return  put_encode($list,'','');
    }
}