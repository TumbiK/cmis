<?php


use Carbon\Carbon;

class mchnController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//

	}

	public function mobsamplemcp()
	{
		
	}

	public function ben_reg_ackMCHN(){
		$input=Input::all();
			//repeat for six time to return the values for acknowledgements
			
 for ($i=1;$i<=14;$i++){


	if($input['district']!='' && $input['period']==$i && $input['FDP_Number'] !='' && $input['gvh']!=''){

	if($input['frm_id']==1){

		$tb_Ubale_Join= DB::table('ubale_mchn_pregnant_mothers as uffa_ben')
		->join('tbl_beneficiary_registration as ben_reg',function($join)
			{
				$join->on('uffa_ben.TA','=','ben_reg.TA');
				$join->on('uffa_ben.District','=','ben_reg.District');
				$join->on('uffa_ben.GVH','=','ben_reg.GVH');
				$join->on('uffa_ben.Village','=','ben_reg.Village');
				$join->on('uffa_ben.HH_Number','=','ben_reg.HH_Number');
				$join->on('uffa_ben.HH_Member_Number','=','ben_reg.HH_Member_Number');

	})->join('code_village as cv', function($join){
		$join->on('cv.rec_id','=','uffa_ben.village');
	})
		->Select('uffa_ben.district','ben_reg.ta','ben_reg.gvh','ben_reg.Village','cv.Village_name as VillageName','ben_reg.HH_Number','ben_reg.HH_Member_Number','ben_reg.Name_of_HH_Member','ben_reg.Sex','ben_reg.Age','uffa_ben.p'.$i.'ack AS ack','uffa_ben.FDP_Number')
		->where('uffa_ben.district','=',$input['district'])
		->where('uffa_ben.gvh','=',$input['gvh'])
		->where('uffa_ben.FDP_Number','=',$input['FDP_Number'])

		->where('uffa_ben.date_registration','<>','0000-00-00')
		->where('uffa_ben.year','=',$input['AckYear'])

	
		->get();
		 
			}elseif ($input['frm_id']==2){

				$tb_Ubale_Join= DB::table('ubale_mchn_child_ben as uffa_ben')
		->join('tbl_beneficiary_registration as ben_reg',function($join)
			{
				$join->on('uffa_ben.TA','=','ben_reg.TA');
				$join->on('uffa_ben.District','=','ben_reg.District');
				$join->on('uffa_ben.GVH','=','ben_reg.GVH');
				$join->on('uffa_ben.Village','=','ben_reg.Village');
				$join->on('uffa_ben.HH_Number','=','ben_reg.HH_Number');
				$join->on('uffa_ben.HH_Member_Number','=','ben_reg.HH_Member_Number');

	})->join('code_village as cv', function($join){
		$join->on('cv.rec_id','=','uffa_ben.village');
	})
		->Select('uffa_ben.district','ben_reg.ta','ben_reg.gvh','ben_reg.Village','cv.Village_name as VillageName','ben_reg.HH_Number','ben_reg.HH_Member_Number','ben_reg.Name_of_HH_Member','ben_reg.Sex','ben_reg.Age','uffa_ben.p'.$i.'ack AS ack','uffa_ben.FDP_Number')
		->where('uffa_ben.district','=',$input['district'])
		
		->where('uffa_ben.gvh','=',$input['gvh'])

		->where('uffa_ben.date_registration','<>','0000-00-00')
		->where('uffa_ben.FDP_Number','=',$input['FDP_Number'])
		->where('uffa_ben.year','=',$input['AckYear'])

	
		->get();				
		
		
			}
			return json_encode($tb_Ubale_Join);
		}


	}

			




	
	

 }

 public function update_MchnAck(){
		$input=Input::except('Name_of_HH_Member','Sex','Age','dob','editing','period','ack','VillageName','frm_id');
		$edit=Input::get('editing');
		$ack=Input::get('ack');
		$frm_id=Input::get('frm_id');
		$period=Input::get('period');
		if($frm_id==1){
		if($ack==0 || $ack==1){
			for($i=1;$i<=14;$i++){
				if($period=$i){
					$input['p'.$i.'ack']=$ack;
						
					
				}
			}
		}
		if($edit){
			$query=DB::table('ubale_mchn_pregnant_mothers')
		->where('district','=',$input['district'])
		->where('ta','=',$input['ta'])
		->where('gvh','=',$input['gvh'])
		->where('village','=',$input['Village'])
		->where('HH_Number','=',$input['HH_Number'])
		
		
			->update($input);
		}
	}elseif($frm_id==2){
		if($ack==0 || $ack==1){
			for($i=1;$i<=14;$i++){
				if($period=$i){
					$input['p'.$i.'ack']=$ack;
					
					
				}
			}
		}
		if($edit){
			$query=DB::table('ubale_mchn_child_ben')
		->where('district','=',$input['district'])
		->where('ta','=',$input['ta'])
		->where('gvh','=',$input['gvh'])
		->where('village','=',$input['Village'])
		->where('HH_Number','=',$input['HH_Number'])
		->where('HH_Member_Number','=',$input['HH_Member_Number'])
		
		
			->update($input);

	}
	}
}

public function update_mchn_Ben(){
		$input=Input::except('Name_of_HH_Member','Sex','Age','dob','editing');
		$edit=Input::get('editing');

		if($input['status']>'1'){
				$input['date_of_exit']=date("y-m-d");
			}

		if($edit){
		$query=DB::table('ubale_mchn_pregnant_mothers')
		->where('district','=',$input['district'])
		->where('ta','=',$input['ta'])
		->where('gvh','=',$input['gvh'])
		->where('village','=',$input['Village'])
		->where('HH_Number','=',$input['HH_Number'])
		->where('HH_Member_Number','=',$input['HH_Member_Number'])
		->where('caregroup','=',$input['caregroup'])
		
			->update($input);

		if($query){
				return json_encode(array('successMsg'=>'Successfully Edited Participants Details'));
			}
			else{
				return json_encode(array('errorMsg'=>'Some Error Occured'));
			}
			}
			
	}

	public function update_mchnChildBen(){
		$input=Input::except('Name_of_HH_Member','Sex','age','dob','cg','editing');
		$edit=Input::get('editing');
		$cg=input::get('cg');

		$input['caregiver']=$cg;

		if($input['status']>'1'){
				$input['date_of_exit']=date("y-m-d");
			}

		if($edit){
			if($input['mc']=='M' || $input['mc']=='C'){
		$query=DB::table('ubale_mchn_child_ben')
		->where('district','=',$input['district'])
		->where('ta','=',$input['ta'])
		->where('gvh','=',$input['gvh'])
		->where('village','=',$input['Village'])
		->where('HH_Number','=',$input['HH_Number'])
		->where('HH_Member_Number','=',$input['hh_member_number'])
		->where('caregroup','=',$input['caregroup'])
		
		
			->update($input);
		}

		if($query){
				return json_encode(array('successMsg'=>'Successfully Edited Beneficiary Details'));
			}
			else{
				return json_encode(array('errorMsg'=>'Some Error Occured'));
			}
			}
			
	}

	public function motherChild()
	{
		//
			$my_dist=Auth::user()->dist_id;
		$admin_role=Auth::user()->is_admin;
		//check to see if the user role is admin and for the PMU with district=0 and load equivalent values
		if($admin_role==1 && $my_dist==0 ){
			$dist=DB::table('code_district');
		}else{
			$dist=DB::table('code_district')->where('rec_id','=',$my_dist);
		}
				 
		 

		 $firstItem=array('0'=>'Select');
		 if(!empty($dist)){
		 	$firstItem=array('0'=>'Select');
		 		$dist_options=$dist->lists('district_name','rec_id');
		 		$dist_options=$firstItem+$dist_options;

		}else{
			$dist_options=array('Select'=>'Please Select');
		}
		return View::make('cmis/mchn/MotherChild/index',array('dist_options'=>$dist_options))->with('dist',$dist)->with('adminRole',$admin_role);
	}

	public function motherPreg()
	{
		//
			$my_dist=Auth::user()->dist_id;
		$admin_role=Auth::user()->is_admin;
		//check to see if the user role is admin and for the PMU with district=0 and load equivalent values
		if($admin_role==1 && $my_dist==0 ){
			$dist=DB::table('code_district');
		}else{
			$dist=DB::table('code_district')->where('rec_id','=',$my_dist);
		}
				 
		 

		 $firstItem=array('0'=>'Select');
		 if(!empty($dist)){
		 	$firstItem=array('0'=>'Select');
		 		$dist_options=$dist->lists('district_name','rec_id');
		 		$dist_options=$firstItem+$dist_options;

		}else{
			$dist_options=array('Select'=>'Please Select');
		}
		return View::make('cmis/mchn/MotherChild/pregnant',array('dist_options'=>$dist_options))->with('dist',$dist)->with('adminRole',$admin_role);
	}


	public function mother_verification()
	{
			$my_dist=Auth::user()->dist_id;
		$admin_role=Auth::user()->is_admin;
		//check to see if the user role is admin and for the PMU with district=0 and load equivalent values
		if($admin_role==1 && $my_dist==0 ){
			$dist=DB::table('code_district');
		}else{
			$dist=DB::table('code_district')->where('rec_id','=',$my_dist);
		}
				 
		 

		 $firstItem=array('0'=>'Select');
		 if(!empty($dist)){
		 	$firstItem=array('0'=>'Select');
		 		$dist_options=$dist->lists('district_name','rec_id');
		 		$dist_options=$firstItem+$dist_options;

		}else{
			$dist_options=array('Select'=>'Please Select');
		}
		return View::make('cmis/mchn/MotherChild/verification',array('dist_options'=>$dist_options))->with('dist',$dist)->with('adminRole',$admin_role);
	}

	public function savePregnantBeneficiary(){
		$input=Input::only('District','TA','GVH','Village','HH_Number','HH_Member_Number','FDP_Number','date_registration','caregroup');
		$sex=input::get('Sex');
		$input['user']=Auth::user()->username;
		//timestamp
		$input['created_at']= \Carbon\Carbon::now()->toDateTimeString();
		$input['updated_at']= \Carbon\Carbon::now()->toDateTimeString();


		//date progress on MCHN
		$myDat=Carbon::today();
		$dateYear=$myDat->year;
		$myDate='30/05/'.$dateYear;

		$date1= Carbon::createFromFormat('d/m/Y',$myDate);
		$date2=Carbon::createFromFormat('d/m/Y',$input['date_registration']);
		$diff=date_diff($date1,$date2);

		if($diff->format("%R%a")<='0'){
			$input['year']=$dateYear-1;
		}else{
			$input['year']=$dateYear;
		}
		if ($input['year']>='2016' and $input['caregroup']==''){
			return json_encode(array('errorMsg'=>'Caregroup Not Selected'));
		}
		
		$date= Carbon::createFromFormat('d/m/Y',$input['date_registration']);
		$input['date_registration']=$date->format('Y-m-d');

		$chkMain=DB::table('tbl_beneficiary_registration')
		->where('district','=',$input['District'])
		->where('ta','=',$input['TA'])
		->where('gvh','=',$input['GVH'])
		->where('village','=',$input['Village'])
		->where('hh_number','=',$input['HH_Number'])
		->where('HH_Member_Number','=',$input['HH_Member_Number'])
		->where('status','>',0)
		->get();
if (count($chkMain)<1){
	$chkHH=DB::table('ubale_mchn_pregnant_mothers')
		->where('district','=',$input['District'])
		->where('ta','=',$input['TA'])
		->where('gvh','=',$input['GVH'])
		->where('village','=',$input['Village'])
		->where('hh_number','=',$input['HH_Number'])
		->where('hh_member_number','=',$input['HH_Member_Number'])
		->where('year','=',$input['year'])
		->get();

		if(count($chkHH)>0){
			return json_encode(array('errorMsg'=>'HouseHold already Exist'));

		}else{

			if($sex=='Male' or $sex=='1'){
				return json_encode(array('errorMsg'=>'Only Pregnant Mothers are Eligible'));
			}else{
				$query=DB::table('ubale_mchn_pregnant_mothers')->insert($input);
			}

		}
		if($query){
			return json_encode(array('successMsg'=>'Successfully added saveBeneficiary'));
		}
		
	}else{
		return json_encode(array('errorMsg'=>'HouseHold Moved or Deceased'));

	}


	
}

	public function ccflsChilddetail(){
		$input=Input::all();
		$query=DB::table('ubale_ccfls_child')
		->where('village','=',$input['Village'])
		->where('HH_Number','=',$input['hhid'])
		->where('HH_Member_Number','=',$input['HH_Member_Number'])
		->where('ccfls_session','=',$input['ccfls'])
		->get();

		return json_encode($query);


	}

	public function updateCCFLS(){
		$input=Input::all();

		$date= Carbon::createFromFormat('d/m/Y',$input['f1date']);
		$input['f1date']=$date->format('Y-m-d');
		if($input['follow']==1){
		$query=DB::table('ubale_ccfls_child')
		->where('village','=',$input['Village'])
		->where('HH_Number','=',$input['HH_Number'])
		->where('HH_Member_Number','=',$input['HH_Member_Number'])
		->where('ccfls_session','=',$input['ccfls_session'])
		->update(array('f1date'=>$input['f1date'],'f1weight'=>$input['f1weight'],'f1MUAC'=>$input['f1MUAC']));

		if($query){
			return json_encode(array('successMsg'=>'Successfully Update First Month Follow Up Details'));
		}else{
			return json_encode(array('errorMsg'=>'Failed to Update First Month Follow Up Details'));
		}
	  }
	}

	public function saveChildBeneficiary(){
		$input=Input::only('District','TA','GVH','Village','HH_Number','caregiver','mc','HH_Member_Number','FDP_Number','level','date_registration','caregroup');
		$dob=input::get('dob');

		//cut_off date


				$input['user']=Auth::user()->username;
		//timestamp
		$input['created_at']= \Carbon\Carbon::now()->toDateTimeString();
		$input['updated_at']= \Carbon\Carbon::now()->toDateTimeString();

				//date progress on MCHN
				$myDat=Carbon::today();
				$dateYear=$myDat->year;
				$myDate='30/05/'.$dateYear;

				$date1= Carbon::createFromFormat('d/m/Y',$myDate);
				$date2=Carbon::createFromFormat('d/m/Y',$input['date_registration']);
				$diff=date_diff($date1,$date2);

				if($diff->format("%R%a")<='0'){
					$input['year']=$dateYear-1;
				}else{
					$input['year']=$dateYear;
				}
				if ($input['year']>='2016' and $input['caregroup']==''){
					return json_encode(array('errorMsg'=>'Caregroup Not Selected'));
				}

				$queryReg=DB::table('ubale_cutoff')
				->where('fy','=',$input['year'])
				->get();

				if(count($queryReg)){
					foreach ($queryReg as $key => $RegCut) {
						$cut_dob=DateTime::createFromFormat('d/m/Y',$dob);
						$initReg=DateTime::createFromFormat('Y-m-d',$RegCut->initReg_date);
						$chkDiff=date_diff($initReg,$cut_dob);

						$cutVal= $chkDiff->format('%r%a');

						if($cutVal<0){
							return json_encode(array('errorMsg'=>'The Child Registration Date is Below the Cut-Off Date of 1 Oct'));
						}
					}
				}
		//set current date
				$to_day=date('m/d/Y');

				//date functions 
				$dob=str_replace('/','-',$dob);
				$input['date_registration']=str_replace('/','-',$input['date_registration']);
				$ts1 = strtotime($dob);
				$ts2 = strtotime($input['date_registration']);
				$year1 = date('Y', $ts1);
				$year2 = date('Y', $ts2);

				$month1 = date('m', $ts1);
				$month2 = date('m', $ts2);
				$diff = (($year2 - $year1) * 12) + ($month2 - $month1);
				
				//Convert the date registration for Mysql

				$date= Carbon::createFromFormat('d-m-Y',$input['date_registration']);
				$input['date_registration']=$date->format('Y-m-d');
		//$conDat=str_replace('/','-',$input['date_registration']);		
		//$input['date_registration']=date("Y-m-d",strtotime($conDat));

		



		$chkMain=DB::table('tbl_beneficiary_registration')
		->where('district','=',$input['District'])
		->where('ta','=',$input['TA'])
		->where('gvh','=',$input['GVH'])
		->where('village','=',$input['Village'])
		->where('hh_number','=',$input['HH_Number'])
		->where('HH_Member_Number','=',$input['HH_Member_Number'])
		->where('status','>',0)
		->get();
if (count($chkMain)<1){
	$chkHH_Mem=DB::table('ubale_mchn_child_ben')
		->where('district','=',$input['District'])
		->where('ta','=',$input['TA'])
		->where('gvh','=',$input['GVH'])
		->where('village','=',$input['Village'])
		->where('hh_number','=',$input['HH_Number'])
		->where('hh_member_number','=',$input['HH_Member_Number'])
		->where('year','=',$input['year'])
		->get();

		
  		if(count($chkHH_Mem)<1)
  			{
  				$chkHH=DB::table('tbl_beneficiary_registration')
  				->where('district','=',$input['District'])
  				->where('ta','=',$input['TA'])
				->where('gvh','=',$input['GVH'])
				->where('village','=',$input['Village'])
				->where('hh_number','=',$input['HH_Number'])
  				->where('head_h','=','1')
  				->get();

  				
  				foreach ($chkHH as $hh_head) {
  					$head=$hh_head->HH_Member_Number;
  					if($diff>24 || $head == $input['HH_Member_Number'] || $input['HH_Member_Number'] == $input['caregiver']){
							return json_encode(array('errorMsg'=>'0 to 23 Months Eligible, Some Error - Information Entered Is InCorrect'));
								}else{
									$query=DB::table('ubale_mchn_child_ben')->insert($input);
									//return $input['date_registration'];
									 return json_encode(array('successMsg'=>'Successfully added Child Beneficiary'));
								}
  				}
					

			}else{
				return json_encode(array('errorMsg'=>'Child Already Exists'));
			}
					
							
						

		
	}else{
		return json_encode(array('errorMsg'=>'HouseHold Moved or Deceased'));

	}




}


//function to assign FDP to group

	public function delete_mchnChildBen(){
		$input=Input::all();
		$query=DB::table('ubale_mchn_child_ben')
		->where('district','=',$input['district'])
		->where('village','=',$input['Village'])
		->where('hh_number','=',$input['HH_Number'])
		->where('hh_member_number','=',$input['hh_member_number'])
		->where('f_receipt','=','1')
		->get();

		if(count($query)<1){
				$delQuery=DB::table('ubale_mchn_child_ben')
				->where('district','=',$input['district'])
				->where('village','=',$input['Village'])
				->where('hh_number','=',$input['HH_Number'])
				->where('hh_member_number','=',$input['hh_member_number'])
				->delete();
			if($delQuery){
				return json_encode(array('successMsg'=>'Successfully Deleted Beneficiary'));
		
				}else{
					return json_encode(array('errorMsg'=>'Some Error Occured'));

				}
			}
	
	}

	public function delete_mchnPregBen(){
		$input=Input::all();
		$query=DB::table('ubale_mchn_pregnant_mothers')
		->where('district','=',$input['district'])
		->where('village','=',$input['Village'])
		->where('hh_number','=',$input['HH_Number'])
		->where('hh_member_number','=',$input['HH_Member_Number'])
		->where('f_receipt','=','1')
		->get();

		if(count($query)<1){
				$delQuery=DB::table('ubale_mchn_pregnant_mothers')
				->where('district','=',$input['district'])
				->where('village','=',$input['Village'])
				->where('hh_number','=',$input['HH_Number'])
				->where('hh_member_number','=',$input['HH_Member_Number'])
				->delete();
			if($delQuery){
				return json_encode(array('successMsg'=>'Successfully Deleted Beneficiary'));
		
				}else{
					return json_encode(array('errorMsg'=>'Some Error Occured'));

				}
			}
	
	}


		public function saveGroupBen(){
		$input=Input::only('district','ta','gvh','village','FDP_Number'); 

        $query= DB::table('ubale_mchn_pregnant_mothers')->where('district','=',$input['district'])
        ->where('ta','=',$input['ta'])
        ->where('gvh','=',$input['gvh'])
        ->where('village','=',$input['village'])
        ->update(array('FDP_Number'=>$input['FDP_Number']));

		if($query){
			return json_encode(array('successMsg'=>'Successfully FDP to Beneficiary'));
		
	}else{
		return json_encode(array('errorMsg'=>'Some Error Occured'));

	}

}

	public function saveChildGroupBen(){
		$input=Input::only('district','ta','gvh','village','FDP_Number'); 

        $query= DB::table('ubale_mchn_child_ben')->where('district','=',$input['district'])
        ->where('ta','=',$input['ta'])
        ->where('gvh','=',$input['gvh'])
        ->where('village','=',$input['village'])
        ->update(array('FDP_Number'=>$input['FDP_Number']));

		if($query){
			return json_encode(array('successMsg'=>'Successfully FDP to Beneficiary'));
		
	}else{
		return json_encode(array('errorMsg'=>'Some Error Occured'));

	}

}

	public function preg_ben_reg(){
		$input=Input::all();

		//paginations
		$pages=Input::get('page');
		$rowsRes=Input::get('rows');
		$page=isset($pages)?intval($pages):1;
		$rows=isset($rowsRes)?intval($rowsRes):10;
		$offset=($page-1)*$rows;
		//date progress on MCHN
		$myDat=Carbon::today();
		$dateYear=$myDat->year;
		$myDate='30/05/'.$dateYear;

		$date1= Carbon::createFromFormat('d/m/Y',$myDate);
		$date2=Carbon::createFromFormat('d/m/Y',$input['date_registration']);
		$diff=date_diff($date1,$date2);

		if($diff->format("%R%a")<='0'){
			$datYear=$dateYear-1;
		}else{
			$datYear=$dateYear;
		}
			
	

	if($input['code_dist']!='' && $input['code_ta']!='' && $input['code_gvh'] !=''){
		$counts=$dbRes= DB::table('ubale_mchn_child_ben')
		->where('district','=',$input['code_dist'])
		->where('ta','=',$input['code_ta'])
		->where('gvh','=',$input['code_gvh'])
		->where('village','=',$input['code_village'])
		->Where('hh_number','<>','')
		->count();

		$result['total']=$counts;

		$tb_Ubale_Join= DB::table('ubale_mchn_pregnant_mothers as uffa_ben')
		->join('tbl_beneficiary_registration as ben_reg',function($join)
			{
				$join->on('uffa_ben.TA','=','ben_reg.TA');
				$join->on('uffa_ben.District','=','ben_reg.District');
				$join->on('uffa_ben.GVH','=','ben_reg.GVH');
				$join->on('uffa_ben.Village','=','ben_reg.Village');
				$join->on('uffa_ben.HH_Number','=','ben_reg.HH_Number');
				$join->on('uffa_ben.HH_Member_Number','=','ben_reg.HH_Member_Number');

	})
		->Select('ben_reg.district','ben_reg.ta','ben_reg.gvh','ben_reg.Village','ben_reg.HH_Number','ben_reg.HH_Member_Number','ben_reg.Name_of_HH_Member','ben_reg.Sex','ben_reg.Age','ben_reg.dob','uffa_ben.FDP_Number','uffa_ben.caregroup','uffa_ben.status')
		->where('uffa_ben.village','=',$input['code_village'])
		->where('year','=',$datYear)
		->take($rows)
		->skip($offset)	
		->get();

		$row=array();
		foreach ( $tb_Ubale_Join as $dbRe ) {			
				array_push($row,$dbRe);
		}
		$result["rows"]=$row;
		
	
	}
     if($tb_Ubale_Join){
     	return json_encode($result);
     }
     else{
     	return "Some error Occured";
     }
	}


	public function child_ben_reg(){
		$input=Input::all();
		$dist=$input['code_dist'];
		$ta=$input['code_ta'];
		$gvh=$input['code_gvh'];
		$village=$input['code_village'];
		//Pagination
		
		$pages=Input::get('page');
		$rowsRes=Input::get('rows');
		$page=isset($pages)?intval($pages):1;
		$rows=isset($rowsRes)?intval($rowsRes):10;
		$offset=($page-1)*$rows;

		$myDat=Carbon::today();
		$dateYear=$myDat->year;
		$myDate='30/05/'.$dateYear;

		

		
		$date1= Carbon::createFromFormat('d/m/Y',$myDate);
		$date2=Carbon::createFromFormat('d/m/Y',$input['date_registration']);
		$diff=date_diff($date1,$date2);

		if($diff->format("%R%a")<='0'){
			$datYear=$dateYear-1;
		}else{
			$datYear=$dateYear;
		}

	if($input['code_dist']!='' && $input['code_ta']!='' && $input['code_gvh'] !=''){
		$counts=$dbRes= DB::table('ubale_mchn_child_ben')
		->where('district','=',$dist)
		->where('ta','=',$ta)
		->where('gvh','=',$gvh)
		->where('village','=',$village)
		->Where('hh_number','<>','')
		->count();

		$result['total']=$counts;


		$tb_Ubale_Join= DB::select("select cb.district,cb.ta,cb.gvh,cb.Village,cb.hh_member_number,tb.HH_Number,(select tbc.Name_of_HH_Member from tbl_beneficiary_registration tbc where District = $dist and ta=$ta and gvh = $gvh and village=$village and tbc.active=1 and tbc.hh_number=cb.hh_number and tbc.hh_member_number=cb.caregiver) as caregiver,tb.Sex,tb.Name_of_HH_Member,tb.dob,tb.age,cb.mc,cb.caregiver as cg, cb.status, cb.FDP_Number,cb.caregroup from ubale_mchn_child_ben cb join tbl_beneficiary_registration tb on(cb.village=tb.village and cb.hh_number=tb.hh_number and cb.HH_Member_Number=tb.HH_Member_Number)  where cb.District = $dist and cb.ta=$ta and cb.gvh = $gvh and cb.village=$village and tb.active=1 and year=".$datYear." Limit 10 offset ".$offset);
		

		$row=array();
		foreach ( $tb_Ubale_Join as $dbRe ) {
			
				array_push($row,$dbRe);

		}
		$result["rows"]=$row;
		/*$tb_Ubale_Join= DB::table('ubale_mchn_child_ben as uffa_ben')
		->join('tbl_beneficiary_registration as ben_reg',function($join)
			{
				$join->on('uffa_ben.TA','=','ben_reg.TA');
				$join->on('uffa_ben.District','=','ben_reg.District');
				$join->on('uffa_ben.GVH','=','ben_reg.GVH');
				$join->on('uffa_ben.Village','=','ben_reg.Village');
				$join->on('uffa_ben.HH_Number','=','ben_reg.HH_Number');
				$join->on('uffa_ben.HH_Member_Number','=','ben_reg.HH_Member_Number');

	})

		->Select(DB::select("Select HH_number from tbl_beneficiary_registration "))
		->where('uffa_ben.village','=',$input['code_village'])
	
		->get();*/

		
	
	}
     if($tb_Ubale_Join){
     	return json_encode($result);
     }
     else{
     	return "Some error Occured";
     }
	}


  
   public function mchn_faf(){
  	$input=Input::all();
  	$district=Input::get('district');
  	$fdp=Input::get('FDP');

  		$myDat=Carbon::today();
		$dateYear=$myDat->year;
		$myDate='30/05/'.$dateYear;

				
		$date1= Carbon::createFromFormat('d/m/Y',$myDate);
		$date2=Carbon::createFromFormat('d/m/Y',$input['DateDistribution']);

		$diff=date_diff($date1,$date2);

		if($diff->format("%R%a")<='0'){
			$datYear=$dateYear-1;
		}else{
			$datYear=$dateYear;
		}



  	if($input['district']!='' || $input['FDP'] !=='')
		{
					
					$DateFrom=date($datYear.'-1-1');
					$d1=new DateTime($DateFrom);
					$d2=new DateTime(str_replace('/','-',$input['DateDistribution']));

					$Months=($d1->diff($d2)->m + ($d1->diff($d2)->y*12));

					$datDiff=($d1->diff($d2)->m + ($d1->diff($d2)->y*12))+1;

			$fdpQuery=DB::table('ubale_fdp')
			->where('district','=',$input['district'])
			->where('FDP_ID','=',$input['FDP'])
			->where('FDP_Role','=','2')
			->get();
			if(count($fdpQuery)<=0){
					//	return json_encode("$errorMsg"=>"FDP Selected For MCHN does not EXIST ");
				}


			if ($input['frm_id']==1){
					$report=public_path() .'/report/mchn_faf1d.jasper';
					$query=DB::table('ubale_mchn_pregnant_mothers')
					->where('district','=',$district)
					//->where('ta','=',$input['ta'])
					//->where('gvh','=',$input['gvh'])
					->where('FDP_Number','=',$fdp)
					->where('year','=',$datYear)
					->get();

					

					
					if(count($query)>0){
						if($datDiff<=14){

							$updatequery=DB::table('ubale_mchn_pregnant_mothers')
							->where('District','=',$input['district'])
							->where('ta','=',$input['ta'])
							
							->where('FDP_Number','=',$input['FDP'])
							->where('year','=',$datYear)
							
							->update(array('p'.$datDiff.'ack'=>'1','p'.$datDiff.'fdp'=>$fdp,'p'.$datDiff.'date'=>$date2,'f_receipt'=>'1'));
							
							}


					}else{
						return json_encode(array('$errorMsg'=>'Data For The Selection Does Not Exit'));
					}


			  	}elseif ($input['frm_id']==2) {
			  		$report=public_path() .'/report/mchn_faf2d.jasper';

			  		$query=DB::table('ubale_mchn_child_ben')
			  		->where('district','=',$district)
					//->where('ta','=',$input['ta'])
					//->where('gvh','=',$input['gvh'])
					->where('FDP_Number','=',$fdp)
					->where('year','=',$datYear)
					//->where('date_registration','<>','0000-00-00')
					//->where('date_registration','<>','1970-01-01')
					->get();

			
					if(count($query)>0){

						if($datDiff<=14){

							$updatequery=DB::table('ubale_mchn_child_ben')
							->where('District','=',$input['district'])
							->where('ta','=',$input['ta'])
							->where('gvh','=',$input['gvh'])
							->where('FDP_Number','=',$input['FDP'])
							->where('year','=',$datYear)
							
							->update(array('p'.$datDiff.'ack'=>'1','p'.$datDiff.'fdp'=>$fdp,'p'.$datDiff.'date'=>$date2,'f_receipt'=>'1'));
							
							}

					}else{
						return json_encode(array('$errorMsg'=>'Data For The Selection Does Not Exit'));
					}




			  	}
			  	else{
			  		return json_encode(array('$errorMsg'=>'Form ID Not Selected'));
			  	}

			
			//return $district."".$fdp."".$datYear;

  			$database = \Config::get('database.connections.mysql');
        	$output = public_path() . '/report/cmisMchnFoodAckForm';
        
        	$ext = "pdf";

        	 \JasperPHP::process(
           	$report,
            $output,
            array($ext),
            array("district"=>$district,"fdp"=>$fdp,"year"=>$datYear),
	          $database,
	            false,
	            false
	        )->execute();
	 		
	 		header('Content-Description: File Transfer');
			header('Content-Type:application/octet-stream');
			header('Content-Disposition:attachement;filename='.date("Y.m.d H:i:s").'_MCHN_Food_Acknowledge.'.$ext);
			header('Content-Transfer-Encoding:binary');
			header('Expires:0');
			header('Cache-Control:must-revalidate,post-check=0,precheck=0');
			header('Pragma:public');
			header('Content-Length:'.filesize($output.'.'.$ext));
			flush();
			readfile($output.'.'.$ext);
			unlink($output.'.'.$ext);

		}else{
			return json_encode(array($errorMsg=>'Please Select District or FDP'));
		}



  }
  public function mchn_verification(){
  	$input=Input::all();
  	$district=Input::get('district');
		$village	=Input::get('village');
		$percentage	=Input::get('percentage');

  	if ($input['frm_id']==1){
  		$report=public_path() .'/report/mchn_verif2.jasper';

  	}elseif ($input['frm_id']==2) {
  		$report=public_path() .'/report/mchn_verif3.jasper';
  	}

  	$database = \Config::get('database.connections.mysql');
        $output = public_path() . '/report/'.date("Y.m.d").'_cmisMchnVerification';
        
        $ext = "pdf";

         \JasperPHP::process(
           $report,
            $output,
            array($ext),
            array("district"=>$district,"village"=>$village,"percent"=>$percentage),
          $database,
            false,
            false
        )->execute();
 		
 		header('Content-Description: File Transfer');
		header('Content-Type:application/octet-stream');
		header('Content-Disposition:attachement;filename='.date("Y.m.d").'_MCHN_Verification.'.$ext);
		header('Content-Transfer-Encoding:binary');
		header('Expires:0');
		header('Cache-Control:must-revalidate,post-check=0,precheck=0');
		header('Pragma:public');
		header('Content-Length:'.filesize($output.'.'.$ext));
		flush();
		readfile($output.'.'.$ext);
		unlink($output.'.'.$ext);



  }
	
	public function mother_childCCFLS(){

		$dist=Auth::user()->dist_id;
		$admin_role=Auth::user()->is_admin;
			return View::make('cmis/mchn/MotherChild/ccfls')->with('dist',$dist)->with('adminRole',$admin_role);		

	}

	public function mother_childCCFLSpreg(){
		$dist=Auth::user()->dist_id;
		$admin_role=Auth::user()->is_admin;
			return View::make('cmis/mchn/MotherChild/ccflspreg')->with('dist',$dist)->with('adminRole',$admin_role);		

	}

	public function saveCCFLSession(){
		$input=Input::all();

		//convert the dates to mysql format
		
		$date= Carbon::createFromFormat('d/m/Y',$input['first_date']);
		$date2=Carbon::createFromFormat("d/m/Y",$input['last_date']);
		$input['first_date']=$date->format('Y-m-d');
		$input['last_date']=$date2->format('Y-m-d');

		$query=DB::table('ubale_ccflsessions')->insert($input);

		$myquery=DB::table('ubale_ccflsessions')->orderby('ccfls_number','desc')->limit(1)->first();
		
		return json_encode($myquery);
	}

	public function ccfls_registration()
	{
		$input=Input::all();
		$query=DB::table('ubale_ccfls_child as cc')
		->join('tbl_beneficiary_registration as ben_reg',function($join)
			{
				$join->on('cc.Village','=','ben_reg.Village');
				$join->on('cc.HH_Number','=','ben_reg.HH_Number');
				$join->on('cc.HH_Member_Number','=','ben_reg.HH_Member_Number');
			})->where('ccfls_session','=',$input['ccfls_session'])->get();
		return json_encode($query);

	}
	public function saveCCFLSChildBen()
	{
		$input=Input::all();
		$query=DB::table('ubale_ccfls_child')->insert($input);
		if($query){
				return json_encode(array('successMsg'=>'Successfully Added CCFLS Child'));
			}
			else{
				return json_encode(array('errorMsg'=>'Some Error Occured'));
			}
	}


	public function mother_childCluster(){
		$dist=Auth::user()->dist_id;
		$admin_role=Auth::user()->is_admin;
			return View::make('cmis/mchn/MotherChild/cgCluster')->with('dist',$dist)->with('adminRole',$admin_role);		
	}


}
