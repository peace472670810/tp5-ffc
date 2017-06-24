<?php 
namespace app\admin\controller;
class Drawhistory extends Base
{       
	/**
	* 开奖历史
	*/
	 public function getDrawhistory(){
	 	 $lottery_id=input('get.lottery_id');
	 	 $lottery=array(
	 	    array('name' => '福彩3D','id'=>'1' ),
	 	    array('name' => '福彩4D','id'=>'2' ),
	 	    array('name' => '福彩5D','id'=>'3' ),
	 	 	  );
	 	 $drawlist='';
	 	 $this->assign('drawlist',$drawlist);
	 	 $this->assign('lottery',$lottery);
	 	 return $this->fetch('drawhistory/getDrawhistory');
	 }
	 	/**
	* 开奖列表
	*/
   	 public function getIssues(){
	 	 $lottery_id=input('get.lottery_id');
	 	 $lottery=array(
	 	    array('name' => '福彩3D','id'=>'1' ),
	 	    array('name' => '福彩4D','id'=>'2' ),
	 	    array('name' => '福彩5D','id'=>'3' ),
	 	 	  );
	 	 $drawlist='';
	 	 $this->assign('drawlist',$drawlist);
	 	 $this->assign('lottery',$lottery);
	 	 return $this->fetch('drawhistory/getIssues');
      
      }



 }?>