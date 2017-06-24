<?php
/**
 * Created by PhpStorm.
 * User: Jim FAN
 * Date: 2017/5/15
 * Time: 19:20
 */

namespace app\admin\controller;
use think\Controller;
/**
 * 后台公共控制器
 * @package app\admin\controller
 */
class Base extends Controller{
    protected $menu = array(
        array(
            'name'=> '彩种管理',
            'child'=>array('childname'=>'彩种设置', 'url' => '', 'logo'=>'')
        ),
        array(
            'name'=> '彩种管理',
            'child'=>array('childname'=>'彩种设置', 'url' => '', 'logo'=>'')
        ),
        array(
            'name'=> '彩种管理',
            'child'=>array('childname'=>'彩种设置', 'url' => '', 'logo'=>'')
        ),
        array(
            'name'=> '彩种管理',
            'child'=>array('childname'=>'彩种设置', 'url' => '', 'logo'=>'')
        ),
        array(
            'name'=> '彩种管理',
            'child'=>array('childname'=>'彩种设置', 'url' => '', 'logo'=>'')
        ),
    );
    protected function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
    }

    /**
     * 检测是否登录
     */
    public function isLogin(){
        if(empty(session('admin_auth_id'))){
            $this->error('请先登录',url('index/login'),'',3);
        }
    }

    /**
     * 分页
     * 当前页  $currentpage
     * 总数量  $countpage
     * 每页数量
     * 链接  $url
     */
    public function getPage($url,$currentpage,$total,$start,$end,$countpage=DEFAULT_PER_PAGE){
        $totalpage = ceil($total/$countpage);
        $res = [
            'start' => $start,
            'end' => $end,
            'total' =>$total,
            'pagecounts' =>$totalpage,
            'pre_url' => '',
            'next_url'=>'',
            'middle' =>'',
        ];
        if($total<$countpage){//只有一页
            $res['pre_url'] = 'javascript:;';
            $res['next_url'] = 'javascript:;';
        }else if($total<=$countpage*5){//小于等于5页
            if($currentpage <=1){
                $res['pre_url'] = "javascript:;";
            }else{
                $pre = ($currentpage-2)<=0?0:($currentpage-2);
                $res['pre_url'] = $url."&page=".$pre;
            }
            for($i=0;$i<$total;$i=$i+$countpage){
                $j = ceil($i/$countpage)+1;
                if($j == $currentpage){
                    $res['middle'] .= "<a class='current' href='".$url."&page=".($j-1)."'>".$j."</a>";
                }else{
                    $res['middle'] .= "<a  href='".$url."&page=".($j-1)."'>".$j."</a>";
                }
            }
            if($currentpage >=$totalpage){
                $res['next_url'] = "javascript:;";
            }else{
                $res['next_url'] = $url."&page=".($currentpage + 1);
            }
            if($currentpage >=$totalpage){
                $res['next_url'] = "javascript:;";
            }else{
                $res['next_url'] = $url."&page=".$currentpage;
            }
        }else{//大于5页
            if($currentpage <=1){
                $res['pre_url'] = "javascript:;";
            }else{
                $pre = ($currentpage-2)<=0?0:($currentpage-2);
                $res['pre_url'] = $url."&page=".$pre;
            }
            //总区间段
            $total_interval = ceil($total/(5*$countpage));
            //取当前页属于哪个区间段
            $f = ceil($currentpage/5);
            //首页
            $res['middle'] ="<a  href='".$url."&page=0'>首页</a>";
            //按区间循环
            if($f<$total_interval){
                $j = ($f-1)*5+1;
                for($i=($f-1)*5*$countpage+1;$i<$f*5*$countpage;$i=$i+$countpage){
                    if($j == $currentpage){
                        $res['middle'] .= "<a class='current' href='".$url."&page=".($j-1)."'>".$j."</a>";
                    }else{
                        $res['middle'] .= "<a  href='".$url."&page=".($j-1)."'>".$j."</a>";
                    }
                    $j++;
                }
            }else{//到了最后一个区间段
                $j = ($f-1)*5+1;
                for($i=($f-1)*5*$countpage+1;$i<=$total;$i=$i+$countpage){
                    if($j == $currentpage){
                        $res['middle'] .= "<a class='current' href='".$url."&page=".($j-1)."'>".$j."</a>";
                    }else{
                        $res['middle'] .= "<a  href='".$url."&page=".($j-1)."'>".$j."</a>";
                    }
                    $j++;
                }
            }
            //尾页
            $res['middle'] .="<a  href='".$url."&page=".($totalpage-1)."'>尾页</a>";
            if($currentpage >=$totalpage){
                $res['next_url'] = "javascript:;";
            }else{
                $res['next_url'] = $url."&page=".$currentpage;
            }
        }
        return  $res;
    }
}