<?php
use Carbon\Carbon;

class trainingController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	
	public function pmu_training()
	{
		//
			$my_dist=Auth::user()->dist_id;
		$admin_role=Auth::user()->is_admin;
		//check to see if the user role is admin and for the PMU with district=0 and load equivalent values
		
		return View::make('cmis/trainings/index')->with('adminRole',$admin_role);
	}
	public function sub_district()
	{
		//
			$my_dist=Auth::user()->dist_id;
		$admin_role=Auth::user()->is_admin;
		//check to see if the user role is admin and for the PMU with district=0 and load equivalent values
		
		return View::make('cmis/trainings/sub_district')->with('adminRole',$admin_role);
	}

	public function community()
	{
		//
		//
			$my_dist=Auth::user()->dist_id;
		$admin_role=Auth::user()->is_admin;
		//check to see if the user role is admin and for the PMU with district=0 and load equivalent values
		
		return View::make('cmis/trainings/community')->with('adminRole',$admin_role);
	}



	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function sector()
	{
		//
		$query=DB::table('ubale_sectors')->get();
		return json_encode($query);

	}
	public function title()
	{
		//
		$query=DB::table('tb_tainingtitle')->get();
		return json_encode($query);

	}
	public function trainDetails()
	{
		//
		$input=Input::all();

		if($input['id']==1){
			$query=DB::table('pmupvo_staff')->where('institution','=','1')->get();
			if (isset($input['participantid'])){
				$query=DB::table('pmupvo_staff')->where('institution','=','1')
				->where('name_of_participant','LIKE','%'.$input['participantid'].'%')->get();
				return json_encode($query);
			}
			if(isset($input['designation'])) {
					$query2=DB::table('pmupvo_staff')->where('institution','=','1')
					->where('designation','LIKE','%'.$input['designation'].'%')->get();			
			}

			return json_encode($query);		
			
		}elseif ($input['id']==2) {
			$query=DB::table('pmupvo_staff')->where('institution','=','2')->get();
			if (isset($input['participantid'])){
				$query=DB::table('pmupvo_staff')->where('institution','=','2')
				->where('name_of_participant','LIKE','%'.$input['participantid'].'%')->get();
			}
			if(isset($input['designation'])) {
					$query=DB::table('pmupvo_staff')->where('institution','=','2')
					->where('designation','LIKE','%'.$input['designation'].'%')->get();				
			}
			return json_encode($query);			
		}elseif ($input['id']==3) {
			$query=DB::table('pmupvo_staff')->where('institution','=','3')->get();
			if (isset($input['participantid'])){
				$query=DB::table('pmupvo_staff')->where('institution','=','3')
				->where('name_of_participant','LIKE','%'.$input['participantid'].'%')->get();
			}
			if(isset($input['designation'])) {
					$query=DB::table('pmupvo_staff')->where('institution','=','3')
					->where('designation','LIKE','%'.$input['designation'].'%')->get();				
			}
			return json_encode($query);			
		}elseif ($input['id']==4) {
			$query=DB::table('pmupvo_staff')->where('institution','=','4')->get();
			if (isset($input['participantid'])){
				$query=DB::table('pmupvo_staff')->where('institution','=','4')
				->where('name_of_participant','LIKE','%'.$input['participantid'].'%')->get();
			}
			if(isset($input['designation'])) {
					$query=DB::table('pmupvo_staff')->where('institution','=','4')
					->where('designation','LIKE','%'.$input['designation'].'%')->get();				
			}
			return json_encode($query);			
		}elseif ($input['id']==5) {
			$query=DB::table('pmupvo_staff')->where('institution','=','5')->get();
			if (isset($input['participantid'])){
				$query=DB::table('pmupvo_staff')->where('institution','=','5')
				->where('name_of_participant','LIKE','%'.$input['participantid'].'%')->get();
			}
			if(isset($input['designation'])) {
					$query=DB::table('pmupvo_staff')->where('institution','=','5')
					->where('designation','LIKE','%'.$input['designation'].'%')->get();				
			}
			return json_encode($query);			
		}elseif ($input['id']==6) {
			$query=DB::table('pmupvo_staff')->where('institution','=','6')->get();
			if (isset($input['participantid'])){
				$query=DB::table('pmupvo_staff')->where('institution','=','6')
				->where('name_of_participant','LIKE','%'.$input['participantid'].'%')->get();
			}
			if(isset($input['designation'])) {
					$query=DB::table('pmupvo_staff')->where('institution','=','1]6')
					->where('designation','LIKE','%'.$input['designation'].'%')->get();				
			}
			return json_encode($query);			
		}elseif ($input['id']==7) {
			$query=DB::table('pmupvo_staff')->where('institution','=','7')->get();
			if (isset($input['participantid'])){
				$query=DB::table('pmupvo_staff')->where('institution','=','7')
				->where('name_of_participant','LIKE','%'.$input['participantid'].'%')->get();
			}
			if(isset($input['designation'])) {
					$query=DB::table('pmupvo_staff')->where('institution','=','7')
					->where('designation','LIKE','%'.$input['designation'].'%')->get();				
			}
			return json_encode($query);			
		}elseif($input['struct']==1){
			$query=DB::table('ubale_acpc_register as acpcReg')->where('acpcReg.acpc_number','=',$input['id'])
			->join('ubale_acpc as acpc',function($join)
			{
				$join->on('acpc.acpc_number','=','acpcReg.acpc_number');
			})
			->join('tbl_beneficiary_registration as benReg',function($join)
			{
				$join->on('acpcReg.village','=','benReg.village');
				$join->on('acpcReg.hh_number','=','benReg.hh_number');
				$join->on('acpcReg.hh_member_number','=','benReg.hh_member_number');
				
	   })->select('acpcReg.rec_id','name_of_hh_member as name_of_participant','Sex','Age','Position as designation','acpc.acpc_number as institution')->get();
			return json_encode($query);
		}elseif($input['struct']==2){
			$query=DB::table('ubale_vdc_register as vdcReg')->where('vdcReg.vdc_number','=',$input['id'])
			->join('ubale_vdc as vdc',function($join)
			{
				$join->on('vdc.vdc_number','=','vdcReg.vdc_number');
			})
			->join('tbl_beneficiary_registration as benReg',function($join)
			{
				$join->on('vdcReg.village','=','benReg.village');
				$join->on('vdcReg.hh_number','=','benReg.hh_number');
				$join->on('vdcReg.hh_member_number','=','benReg.hh_member_number');
				
	   })->select('vdcReg.rec_id','name_of_hh_member as name_of_participant','Sex','Age','Position as designation','vdc.vdc_number as institution')->get();
			return json_encode($query);
		}elseif($input['struct']==3){
			$query=DB::table('ubale_vcpc_register as vcpcReg')->where('vcpcReg.vcpc_number','=',$input['id'])
			->join('ubale_vcpc as vcpc',function($join)
			{
				$join->on('vcpc.vcpc_number','=','vcpcReg.vcpc_number');
			})
			->join('tbl_beneficiary_registration as benReg',function($join)
			{
				$join->on('vcpcReg.village','=','benReg.village');
				$join->on('vcpcReg.hh_number','=','benReg.hh_number');
				$join->on('vcpcReg.hh_member_number','=','benReg.hh_member_number');
				
	   })->select('vcpcReg.rec_id','name_of_hh_member as name_of_participant','Sex','Age','Position as designation','vcpc.vcpc_number as institution')->get();
			return json_encode($query);
		}elseif($input['struct']==4){
			$query=DB::table('ubale_vnrmc_register as vnrmcReg')->where('vnrmcReg.vnrmc_number','=',$input['id'])
			->join('ubale_vnrmc as vnrmc',function($join)
			{
				$join->on('vnrmc.vnrmc_number','=','vnrmcReg.vnrmc_number');
			})
			->join('tbl_beneficiary_registration as benReg',function($join)
			{
				$join->on('vnrmcReg.village','=','benReg.village');
				$join->on('vnrmcReg.hh_number','=','benReg.hh_number');
				$join->on('vnrmcReg.hh_member_number','=','benReg.hh_member_number');
				
	   })->select('vnrmcReg.rec_id','name_of_hh_member as name_of_participant','Sex','Age','Position as designation','vnrmc.vnrmc_number as institution')->get();
			return json_encode($query);
		}elseif($input['struct']==5){
			$query=DB::table('ubale_youthclub_register as youthclubReg')->where('youthclubReg.youthclub_number','=',$input['id'])
			->join('ubale_youthclub as youthclub',function($join)
			{
				$join->on('youthclub.youthclub_number','=','youthclubReg.youthclub_number');
			})
			->join('tbl_beneficiary_registration as benReg',function($join)
			{
				$join->on('youthclubReg.village','=','benReg.village');
				$join->on('youthclubReg.hh_number','=','benReg.hh_number');
				$join->on('youthclubReg.hh_member_number','=','benReg.hh_member_number');
				
	   })->select('youthclubReg.rec_id','name_of_hh_member as name_of_participant','Sex','Age','Position as designation','youthclub.youthclub_number as institution')->get();
			return json_encode($query);
		}elseif($input['struct']==6){
			$query=DB::table('ubale_adc_register as adcReg')->where('adcReg.adc_number','=',$input['id'])
			->join('ubale_adc as adc',function($join)
			{
				$join->on('adc.adc_number','=','adcReg.adc_number');
			})
			->join('tbl_beneficiary_registration as benReg',function($join)
			{
				$join->on('adcReg.village','=','benReg.village');
				$join->on('adcReg.hh_number','=','benReg.hh_number');
				$join->on('adcReg.hh_member_number','=','benReg.hh_member_number');
				
	   })->select('adcReg.rec_id','name_of_hh_member as name_of_participant','Sex','Age','Position as designation','adc.adc_number as institution')->get();
			return json_encode($query);
		}
	}
	public function savePmuBen(){
		$input=Input::only('rec_id','training_num','date');
		$conDat=str_replace('/','-',$input['date']);
		$input['date']=date('Y-m-d', strtotime($conDat));
		//Training Array
		$train=substr($input['training_num'],-4);
		//get the training

		$partner=Auth::user()->partner;
		$query2=DB::table('tb_training')
		->where('rec_id','=',$train)
		->where('partner','=',$partner)
		->get();
		$conDat=str_replace('/','-',$input['date']);
		$mdate=date('Y-m-d', strtotime($conDat));
		

		foreach ($query2 as $trainVal) {
			$reg_date=$trainVal->date;
			$diff =  (strtotime($mdate) - strtotime($reg_date)) / (60 * 60 * 24);
			
		}
			
		//query to add the participant
		if($diff >= 0 && $diff <7){
			//Seven days training mapping with the database in case of 0 same day its the first day in db
			$NewDiff=$diff+1;
			$myday='att'.$NewDiff;
	

		

		$query=DB::table('pmupvo_training')->insert($mydata=array('training_num'=>$input['training_num'],'participant_id'=>$input['rec_id'],'date'=>$input['date'],$myday=>'1'));
		if($query){
			       return json_encode(array('successMsg'=>'Successfully added Beneficiary'));
				}else{
					return json_encode(array('errorMsg'=>'Some Error Occured'));
				}


	}
}

public function rfoSel(){
	$query=DB::table('pmupvo_staff')->where('designation','=','RFO')->orWhere('designation','=','GSFO')
	->select('rec_id','name_of_participant as rfo_name')->get();
	return json_encode($query);
}
public function save_inst_member(){
	$input=Input::all();
	$conDat=str_replace('/','-',$input['reg_date']);
	$input['reg_date']=date('Y-m-d', strtotime($conDat));
	$query=DB::table('pmupvo_staff')->insert($input);

	if($query){
		return json_encode(array('successMsg'=>'Successfully Added Member'));
	}else{
		return json_encode(array('errorMsg'=>'Some Error Occured Failed to Add Member'));
	}
	
}
public function saveComBen(){
		$input=Input::only('HH_Number','training_num','date','TA','GVH','Village','HH_Member_Number','Name_of_HH_member','Sex','Age');
		$conDat=str_replace('/','-',$input['date']);
		$input['date']=date('Y-m-d', strtotime($conDat));
		//Training Array
		$train=substr($input['training_num'],-4);
		//get the training

		$partner=Auth::user()->partner;
		$query2=DB::table('tb_training')
		->where('rec_id','=',$train)
		->where('partner','=',$partner)
		->get();
		$conDat=str_replace('/','-',$input['date']);
		$mdate=date('Y-m-d', strtotime($conDat));
		

		foreach ($query2 as $trainVal) {
			$reg_date=$trainVal->date;
			$diff =  (strtotime($mdate) - strtotime($reg_date)) / (60 * 60 * 24);
			
		}
			
		//query to add the participant
		if($diff >= 0 && $diff <7){
			//Seven days training mapping with the database in case of 0 same day its the first day in db
			$NewDiff=$diff+1;
			$myday='att'.$NewDiff;
	

		

		$query=DB::table('community_training')->insert($mydata=array('training_num'=>$input['training_num'],'hh_number'=>$input['HH_Number'],'hh_member_number'=>$input['HH_Member_Number'],'ta'=>$input['TA'],'gvh'=>$input['GVH'],'Sex'=>$input['Sex'],'village'=>$input['Village'],'age'=>$input['Age'],'name_of_participant'=>$input['Name_of_HH_member'],'date'=>$input['date'],$myday=>'1'));
		if($query){
			       return json_encode(array('successMsg'=>'Successfully added Beneficiary'));
				}else{
					return json_encode(array('errorMsg'=>'Some Error Occured'));
				}


	}
}
	public function saveTrainBen(){
		$input=Input::except('inst');
		$inst=input::get('inst');
		$conDat=str_replace('/','-',$input['date']);
		$input['date']=date('Y-m-d', strtotime($conDat));
		//Training Array
		$train=substr($input['training_num'],-4);
		//get the training

		$partner=Auth::user()->partner;
		$query2=DB::table('tb_training')
		->where('rec_id','=',$train)
		->where('partner','=',$partner)
		->get();
		$conDat=str_replace('/','-',$input['date']);
		$mdate=date('Y-m-d', strtotime($conDat));
		

		foreach ($query2 as $trainVal) {
			$reg_date=$trainVal->date;
			$diff =  (strtotime($mdate) - strtotime($reg_date)) / (60 * 60 * 24);
			
		}
			
		//query to add the participant
		if($diff >= 0 && $diff <7){
			//Seven days training mapping with the database in case of 0 same day its the first day in db
			$NewDiff=$diff+1;
			$myday='att'.$NewDiff;
				if($inst==0){
					$dat=array('participant_id'=>$input['rec_id'],'training_num'=>$input['training_num'],$myday=>'1','name_of_participant'=>$input['name_of_participant'],'institution'=>$input['institution'],'designation'=>$input['designation'],'contact'=>$input['contact'],'date'=>$input['date'],'age'=>$input['age'],'sex'=>$input['Sex']);
				}elseif ($inst>0) {
					$dat=array('participant_id'=>$input['rec_id'],'training_num'=>$input['training_num'],$myday=>'1','name_of_participant'=>$input['name_of_participant'],'institution'=>$input['institution'],'designation'=>$input['designation'],'date'=>$input['date'],'age'=>$input['Age'],'sex'=>$input['Sex']);
				}			
				
				$query=DB::table('sub_training')->insert($dat);	
			

			if($query){
			       return json_encode(array('successMsg'=>'Successfully added Beneficiary'));
				}else{
					return json_encode(array('errorMsg'=>'Some Error Occured'));
				}

			
		}

			
		
		
	return $diff;


	}



	public function workshop(){
		$input=Input::all();

		$query=DB::table('tb_tainingtitle')->where('id_sector','=',$input['id'])->get();
		return json_encode($query);


	}

	public function newTraining(){
		$input=Input::except('train_Num');
		$training_num=input::get('train_Num');
		$input["partner"]=Auth::user()->partner;
		$conDat=str_replace('/','-',$input['date']);
		$input['date']=date('Y-m-d', strtotime($conDat));
		//$query3=DB::table('tb_training')->where('partner','=',$input["partner"]);
		$train=substr($training_num,-4);
		//get the date Difference
		$partner=Auth::user()->partner;
		$query4=DB::table('tb_training')
		->where('rec_id','=',$train)
		->where('partner','=',$partner)
		->get();
		$conDat=str_replace('/','-',$input['date']);
		$mdate=date('Y-m-d', strtotime($conDat));

		

		foreach ($query4 as $trainVal) {
			$reg_date=$trainVal->date;
			$diff =  (strtotime($mdate) - strtotime($reg_date)) / (60 * 60 * 24);
			
		}

		if($training_num==''){
			$query=DB::table('tb_training')->insert($input);
			$query2=DB::table('tb_training')->orderBy('rec_id','desc')->first();
			return json_encode($query2);
		}elseif ($training_num!='') {
				$partner=substr($training_num,0,2);
				$rec_id=substr($training_num,-4);
				$query=DB::table('tb_training')->where('rec_id','=',$rec_id)->where('partner','=',$partner)->first();
				//if we have an instance of the training assign attendance on the date
				if(count($query)>0){
					$NewDiff=$diff+1;
					if($NewDiff<=0){
						return json_encode( array('errorMsg'=>'Ensure Date is Within the Registration Date'));
					}
					$miday="att".$NewDiff;
					$dat=array($miday=>'1');
					$query5=DB::table('sub_training')->where('training_num','=',$training_num)->update($dat);
					$query5=DB::table('pmupvo_training')->where('training_num','=',$training_num)->update($dat);
					$query5=DB::table('community_training')->where('training_num','=',$training_num)->update($dat);
					return json_encode($query);

				}
				

		}
		

		


	}
	public function institution_reg(){
		$input=Input::all();
		if($input['id']==1){
			$query2=DB::table('ubale_acpc')->select('acpc_number as rec_id','acpc_name as institution_name')->where('ta','=',$input['ta'])->get();
		}elseif ($input['id']==2) {
			$query2=DB::table('ubale_vdc')->select('vdc_number as rec_id','vdc_name as institution_name')->where('ta','=',$input['ta'])->get();
		}elseif ($input['id']==3) {
			$query2=DB::table('ubale_vcpc')->select('vcpc_number as rec_id','vcpc_name as institution_name')->where('ta','=',$input['ta'])->get();
		}elseif ($input['id']==4) {
			$query2=DB::table('ubale_vnrmc')->select('vnrmc_number as rec_id','vnrmc_name as institution_name')->where('ta','=',$input['ta'])->get();
		}elseif ($input['id']==5) {
			$query2=DB::table('ubale_youthclub')->select('youthclub_number as rec_id','youthclub_name as institution_name')->where('ta','=',$input['ta'])->get();
		}elseif ($input['id']==6) {
			$query2=DB::table('ubale_adc')->select('adc_number as rec_id','adc_name as institution_name')->where('ta','=',$input['ta'])->get();
		}
		
		
		
		
		if($input['id']!=0){
			
			return json_encode($query2);

		}else{
			$query=DB::table('tb_institution')->select('rec_id','institution_name')->get();
			return json_encode($query);

	}
}

	public function institution(){

		$input=Input::all();
		if($input['id']==1){
			$query2=DB::table('ubale_acpc')->select('acpc_number as rec_id','acpc_name as institution_name')->where('ta','=',$input['ta'])->get();
		}elseif ($input['id']==2) {
			$query2=DB::table('ubale_vdc')->select('vdc_number as rec_id','vdc_name as institution_name')->where('ta','=',$input['ta'])->get();
		}elseif ($input['id']==3) {
			$query2=DB::table('ubale_vcpc')->select('vcpc_number as rec_id','vcpc_name as institution_name')->where('ta','=',$input['ta'])->get();
		}elseif ($input['id']==4) {
			$query2=DB::table('ubale_vnrmc')->select('vnrmc_number as rec_id','vnrmc_name as institution_name')->where('ta','=',$input['ta'])->get();
		}elseif ($input['id']==5) {
			$query2=DB::table('ubale_youthclub')->select('youthclub_number as rec_id','youthclub_name as institution_name')->where('ta','=',$input['ta'])->get();
		}elseif ($input['id']==6) {
			$query2=DB::table('ubale_adc')->select('adc_number as rec_id','adc_name as institution_name')->where('ta','=',$input['ta'])->get();
		}
		
		
		
		
		if($input['id']!=0){
			
			return json_encode($query2);

		}else{
			$query=DB::table('tb_institution')->select('rec_id','institution_name')->get();
			return json_encode($query);

		}
		
		
}


	public function institutionTA()
	{
		
		$my_dist=Auth::user()->dist_id;
		$query=DB::table('code_ta')->select('rec_id','ta_name')->where('rec_id_district','=',$my_dist)->get();

			return json_encode($query);
	

	}

	public function sub_dist_train(){
		$input=Input::all();
		$train=substr($input['training_num'],-4);
		//get the training

		$partner=Auth::user()->partner;
		$query2=DB::table('tb_training')
		->where('rec_id','=',$train)
		->where('partner','=',$partner)
		->get();
		$conDat=str_replace('/','-',$input['date']);
		$mdate=date('Y-m-d', strtotime($conDat));
		

		foreach ($query2 as $trainVal) {
			$reg_date=$trainVal->date;
			$diff =  (strtotime($mdate) - strtotime($reg_date)) / (60 * 60 * 24);
			
		}

		$NewDiff=$diff+1;
		if($NewDiff == 1){
			//Seven days training mapping with the database in case of 0 same day its the first day in db
			
			 $query=DB::table('sub_training')->where('training_num','=',$input['training_num'])->select('training_num','participant_id','name_of_participant','Sex','designation','Institution','age','date','contact','att1 as Attendance')->get();
			 return json_encode($query);
		}elseif ($NewDiff == 2) {
			
			 $query=DB::table('sub_training')->where('training_num','=',$input['training_num'])->select('training_num','participant_id','name_of_participant','Sex','designation','Institution','age','date','contact','att2 as Attendance')->get();
			 return json_encode($query);
		
		}elseif ($NewDiff == 3) {
			
			 $query=DB::table('sub_training')->where('training_num','=',$input['training_num'])->select('training_num','participant_id','name_of_participant','Sex','designation','Institution','age','date','contact','att3 as Attendance')->get();
			 return json_encode($query);
		}elseif ($NewDiff == 4) {
			
			 $query=DB::table('sub_training')->where('training_num','=',$input['training_num'])->select('training_num','participant_id','name_of_participant','Sex','designation','Institution','age','date','contact','att4 as Attendance')->get();
			 return json_encode($query);
		}elseif ($NewDiff == 5) {
			
			 $query=DB::table('sub_training')->where('training_num','=',$input['training_num'])->select('training_num','participant_id','name_of_participant','Sex','designation','Institution','age','date','contact','att5 as Attendance')->get();
			 return json_encode($query);
		}elseif ($NewDiff == 6) {
			
			 $query=DB::table('sub_training')->where('training_num','=',$input['training_num'])->select('training_num','participant_id','name_of_participant','Sex','designation','Institution','age','date','contact','att6 as Attendance')->get();
			 return json_encode($query);
		}elseif ($NewDiff == 7) {
			
			 $query=DB::table('sub_training')->where('training_num','=',$input['training_num'])->select('training_num','participant_id','name_of_participant','Sex','designation','Institution','age','date','contact','att7 as Attendance')->get();
			 return json_encode($query);
		}
	}


public function community_training(){
		$input=Input::all();
		$train=substr($input['training_num'],-4);
		//get the training

		$partner=Auth::user()->partner;
		$query2=DB::table('tb_training')
		->where('rec_id','=',$train)
		->where('partner','=',$partner)
		->get();
		$conDat=str_replace('/','-',$input['date']);
		$mdate=date('Y-m-d', strtotime($conDat));
		

		foreach ($query2 as $trainVal) {
			$reg_date=$trainVal->date;
			$diff =  (strtotime($mdate) - strtotime($reg_date)) / (60 * 60 * 24);
			
		}

		$NewDiff=$diff+1;
		if($NewDiff == 1){
			//Seven days training mapping with the database in case of 0 same day its the first day in db
			
			 $query=DB::table('community_training')->where('training_num','=',$input['training_num'])->select('training_num','participant_id','name_of_participant','Sex','village','hh_number','age','date','att1 as Attendance')->get();
			 return json_encode($query);
		}elseif ($NewDiff == 2) {
			
			 $query=DB::table('community_training')->where('training_num','=',$input['training_num'])->select('training_num','participant_id','name_of_participant','Sex','village','hh_number','age','date','att2 as Attendance')->get();
			 return json_encode($query);
		
		}elseif ($NewDiff == 3) {
			
			 $query=DB::table('community_training')->where('training_num','=',$input['training_num'])->select('training_num','participant_id','name_of_participant','Sex','village','hh_number','age','date','att3 as Attendance')->get();
			 return json_encode($query);
		}elseif ($NewDiff == 4) {
			
			 $query=DB::table('community_training')->where('training_num','=',$input['training_num'])->select('training_num','participant_id','name_of_participant','Sex','village','hh_number','age','date','att4 as Attendance')->get();
			 return json_encode($query);
		}elseif ($NewDiff == 5) {
			
			 $query=DB::table('community_training')->where('training_num','=',$input['training_num'])->select('training_num','participant_id','name_of_participant','Sex','village','hh_number','age','date','att5 as Attendance')->get();
			 return json_encode($query);
		}elseif ($NewDiff == 6) {
			
			 $query=DB::table('community_training')->where('training_num','=',$input['training_num'])->select('training_num','participant_id','name_of_participant','Sex','village','hh_number','age','date','att6 as Attendance')->get();
			 return json_encode($query);
		}elseif ($NewDiff == 7) {
			
			 $query=DB::table('community_training')->where('training_num','=',$input['training_num'])->select('training_num','participant_id','name_of_participant','Sex','designation','Institution','age','date','contact','att7 as Attendance')->get();
			 return json_encode($query);
		}
	}




	public function pmupvo_training(){
		$input=Input::all();
		$train=substr($input['training_num'],-4);
		//get the training

		$partner=Auth::user()->partner;
		$query2=DB::table('tb_training')
		->where('rec_id','=',$train)
		->where('partner','=',$partner)
		->get();
		$conDat=str_replace('/','-',$input['date']);
		$mdate=date('Y-m-d', strtotime($conDat));
		

		foreach ($query2 as $trainVal) {
			$reg_date=$trainVal->date;
			$diff =  (strtotime($mdate) - strtotime($reg_date)) / (60 * 60 * 24);
			
		}

		$NewDiff=$diff+1;

		//updates for the attendance


		if($NewDiff == 1){
			//Seven days training mapping with the database in case of 0 same day its the first day in db
			
			 $query=DB::table('pmupvo_training')
			 ->join('pmupvo_staff',function($join)
			{
				$join->on('rec_id','=','participant_id');
			})
			 ->where('training_num','=',$input['training_num'])->select('participant_id','training_num','name_of_participant','Sex','designation','Institution','age','date','contact','att1 as Attendance')->get();
			 return json_encode($query);
		}elseif ($NewDiff == 2) {
			
			 $query=DB::table('pmupvo_training')
			  ->join('pmupvo_staff',function($join)
			{
				$join->on('rec_id','=','participant_id');
			})->where('training_num','=',$input['training_num'])->select('participant_id','training_num','name_of_participant','Sex','designation','Institution','age','date','contact','att2 as Attendance')->get();
			 return json_encode($query);
		
		}elseif ($NewDiff == 3) {
			
			 $query=DB::table('pmupvo_training')
			  ->join('pmupvo_staff',function($join)
			{
				$join->on('rec_id','=','participant_id');
			})->where('training_num','=',$input['training_num'])->select('participant_id','training_num','name_of_participant','Sex','designation','Institution','age','date','contact','att3 as Attendance')->get();
			 return json_encode($query);
		}elseif ($NewDiff == 4) {
			
			 $query=DB::table('pmupvo_training') ->join('pmupvo_staff',function($join)
			{
				$join->on('rec_id','=','participant_id');
			})->where('training_num','=',$input['training_num'])->select('participant_id','training_num','name_of_participant','Sex','designation','Institution','age','date','contact','att4 as Attendance')->get();
			 return json_encode($query);
		}elseif ($NewDiff == 5) {
			
			 $query=DB::table('pmupvo_training')
			  ->join('pmupvo_staff',function($join)
			{
				$join->on('rec_id','=','participant_id');
			})->where('training_num','=',$input['training_num'])->select('participant_id','training_num','name_of_participant','Sex','designation','Institution','age','date','contact','att5 as Attendance')->get();
			 return json_encode($query);
		}elseif ($NewDiff == 6) {
			
			 $query=DB::table('pmupvo_training')
			  ->join('pmupvo_staff',function($join)
			{
				$join->on('rec_id','=','participant_id');
			})->where('training_num','=',$input['training_num'])->select('participant_id','training_num','name_of_participant','Sex','designation','Institution','age','date','contact','att6 as Attendance')->get();
			 return json_encode($query);
		}elseif ($NewDiff == 7) {
			
			 $query=DB::table('pmupvo_training') ->join('pmupvo_staff',function($join)
			{
				$join->on('rec_id','=','participant_id');
			})->where('training_num','=',$input['training_num'])->select('participant_id','training_num','name_of_participant','Sex','designation','Institution','age','date','contact','att7 as Attendance')->get();
			 return json_encode($query);
		}
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */

	Public function updateTrain(){
		$input=Input::except('editing');
		$editing=Input::get('editing');

		$train=substr($input['training_num'],-4);
		//get the training
		$partner=Auth::user()->partner;


		$query2=DB::table('tb_training')
		->where('rec_id','=',$train)
		->where('partner','=',$partner)
		->get();

		$conDat=str_replace('/','-',$input['date']);
		$mdate=date('Y-m-d', strtotime($conDat));
		

		foreach ($query2 as $trainVal) {
			$reg_date=$trainVal->date;
			$diff =  (strtotime($mdate) - strtotime($reg_date)) / (60 * 60 * 24);
			
		}

		$NewDiff=$diff+1;
			$myday='att'.$NewDiff;

		if($editing){
			$query=DB::table('sub_training')->where('name_of_participant','=',$input['name_of_participant'])
			->where('training_num','=',$input['training_num'])->update(array('contact'=>$input['contact'],$myday=>$input['Attendance']));
			if($query){
			       return json_encode(array('successMsg'=>'Successfully added Beneficiary'));
				}else{
					return json_encode(array('errorMsg'=>'Some Error Occured'));
				}
				return $input['date'];
		}

	}
public function updateCom()
{
	$input=Input::except('editing');
		$editing=Input::get('editing');

		$train=substr($input['training_num'],-4);
		//get the training
		$partner=Auth::user()->partner;


		$query2=DB::table('tb_training')
		->where('rec_id','=',$train)
		->where('partner','=',$partner)
		->get();
		$conDat=str_replace('/','-',$input['date']);
		$mdate=date('Y-m-d', strtotime($conDat));

		foreach ($query2 as $trainVal) {
			$reg_date=$trainVal->date;
			$diff =  (strtotime($mdate) - strtotime($reg_date)) / (60 * 60 * 24);
			
		}

		$NewDiff=$diff+1;
			$myday='att'.$NewDiff;

		if($editing){
			$query=DB::table('community_training')->where('hh_number','=',$input['hh_number'])
			->where('training_num','=',$input['training_num'])->update(array($myday=>$input['Attendance']));
			if($query){
			       return json_encode(array('successMsg'=>'Successfully Edited Training Beneficiary'));
				}else{
					return json_encode(array('errorMsg'=>'Some Error Occured'));
				}
				return $input['date'];
		}

}

	Public function updatePmu(){
		$input=Input::except('editing');
		$editing=Input::get('editing');

		$train=substr($input['training_num'],-4);
		//get the training
		$partner=Auth::user()->partner;


		$query2=DB::table('tb_training')
		->where('rec_id','=',$train)
		->where('partner','=',$partner)
		->get();
		$conDat=str_replace('/','-',$input['date']);
		$mdate=date('Y-m-d', strtotime($conDat));
		

		foreach ($query2 as $trainVal) {
			$reg_date=$trainVal->date;
			$diff =  (strtotime($mdate) - strtotime($reg_date)) / (60 * 60 * 24);
			
		}

		$NewDiff=$diff+1;
			$myday='att'.$NewDiff;

		if($editing){
			$query=DB::table('pmupvo_training')->where('participant_id','=',$input['participant_id'])
			->where('training_num','=',$input['training_num'])->update(array($myday=>$input['Attendance']));

			$query=DB::table('pmupvo_staff')->where('rec_id','=',$input['participant_id'])->update(array('contact'=>$input['contact']));
			if($query){
			       return json_encode(array('successMsg'=>'Successfully added Beneficiary'));
				}else{
					return json_encode(array('errorMsg'=>'Some Error Occured'));
				}
				return $input['date'];
		}

	}
	public function store()
	{
		//
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
