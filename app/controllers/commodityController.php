<?php

use Carbon\Carbon;

class commodityController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
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
		return View::make('cmis/commodity/commodities/index',array('dist_options'=>$dist_options))->with('dist',$dist)->with('adminRole',$admin_role);
	}


	

	public function mchn_acknowledgements(){

		$my_dist=Auth::user()->dist_id;
		$admin_role=Auth::user()->is_admin;
		//check to see if the user role is admin and for the PMU with district=0 and load equivalent values
		if($admin_role==1 && $my_dist==0 ){
			$dist=DB::table('code_district');
		}else{
			$dist=DB::table('code_district')->where('rec_id','=',$my_dist);
		}	 
		 
		$input=Input::all();
		//controls whether the acknowledgement is already done 0 means not done
		$contCount=1;
		//get the current date
		$myDat=Carbon::today();
		$dateYear=$myDat->year;
		$myDate='30/05/'.$dateYear;

				
		$date1= Carbon::createFromFormat('d/m/Y',$myDate);
		$date2=Carbon::createFromFormat('d/m/Y',$input['period']);

		$diff=date_diff($date1,$date2);

		if($diff->format("%R%a")<='0'){
			$datYear=$dateYear-1;
		}else{
			$datYear=$dateYear;
		}
		
		

		$conDat=str_replace('/','-',$input['period']);
		$input['period']=date("Y-m-d",strtotime($conDat));

		$curDate=$input['period'];

		//compare the start date of the project and get the period
					
					$DateFrom=date($datYear.'-1-1');
					$d1=new DateTime($DateFrom);
					$d2=new DateTime(str_replace('/','-',$input['period']));

					$Months=($d1->diff($d2)->m + ($d1->diff($d2)->y*12));

					$datDiff=($d1->diff($d2)->m + ($d1->diff($d2)->y*12))+1;


	


			return View::make('cmis/commodity/commodities/ack_mchn')
			->with('dist',$dist)
			->with('adminRole',$admin_role)
			->with('period',$datDiff)
			->with('district',$input['district'])
			->with('gvh',$input['gvh'])
			->with('FDP_Number',$input['FDP_Number'])
			->with('frm_id',$input['frm_id'])
			->with('AckYear',$datYear);


			



		
	}




	public function ff_acknowledgements(){

		$my_dist=Auth::user()->dist_id;
		$admin_role=Auth::user()->is_admin;
		//check to see if the user role is admin and for the PMU with district=0 and load equivalent values
		if($admin_role==1 && $my_dist==0 ){
			$dist=DB::table('code_district');
		}else{
			$dist=DB::table('code_district')->where('rec_id','=',$my_dist);
		}	 
		 
		$input=Input::all();
		//controls whether the acknowledgement is already done 0 means not done
		$contCount=1;
		//get the current date
		

		$conDat=str_replace('/','-',$input['period']);
		$input['period']=date("Y-m-d",strtotime($conDat));

		$curDate=$input['period'];

//compare the start date of the project and get the period
		$chkProject=DB::table('ubale_ffa_project')->where('district','=',$input['district'])
		->where('Project_Number','=',$input['project'])->get();
		foreach ($chkProject as $myProject) {
			$d1 = new DateTime($myProject->Date_From);
			$d2 = new DateTime($myProject->Date_To);

			//the conversion for the current date to point a period
			$d3= new DateTime($input['period']);

			$Months=($d1->diff($d2)->m + ($d1->diff($d2)->y*12));

			$datDiff=($d1->diff($d3)->m + ($d1->diff($d3)->y*12))+1;

		}

		

		// repeat and check the period are equal for updation
		if ($datDiff>$Months){
			$message='The Months Exceed the Project Approved Months';
		} else{
		for ($i=$datDiff;$i<=($Months+$datDiff);$i++){
		if($datDiff==$i && $input['FDP_Number'] <> '' and $input['project']<>''){
		$query=DB::table('ubale_ffa_beneficiary_register')
		->where('District','=',$input['district'])
		->where('Project_Number','=',$input['project'])
		->where('FDP_Number','=',$input['FDP_Number'])
		//->where('Number_days_work','<>','0')
		->where('p'.$i.'days','=','0')
		->get();

		$count=0;

		if(count($query)>0){
			foreach ($query as $myQuery) {
				//$hh_num=$myQuery->HH_Number;
				$updatequery=DB::table('ubale_ffa_beneficiary_register')
				->where('District','=',$myQuery->District)
				->where('Project_Number','=',$myQuery->Project_Number)
				->where('FDP_Number','=',$myQuery->FDP_Number)
				//->where('Number_days_work','<>','0')
				->where('hh_number','=',$myQuery->HH_Number)
				->update(array('p'.$i.'days'=>$myQuery->Number_days_work,'p'.$i.'ack'=>1,'p'.$i.'fdp'=>$myQuery->FDP_Number,'p'.$i.'date'=>$curDate));
						
				
			if($updatequery){
				$message='successfully assigned days';
				$contCount=0;
				}else{
					$message='Some Error Occured';
				}

		}
		
		
	}
		else{
		$message='The period is already acknowledged';
		}

	}
}
}


	return View::make('cmis/commodity/commodities/ack_ffa')
	->with('dist',$dist)
	->with('adminRole',$admin_role)
	->with('period',$datDiff)
	->with('district',$input['district'])
	->with('FDP_Number',$input['FDP_Number'])
	->with('project',$input['project'])
	->with('contCount',$contCount)		

	->with('message',$message);



		
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

    public function saveFDP(){
    	$input=Input::all();
    	$query=DB::table('ubale_fdp')->insert($input);
    }
    public function update_fdp(){
    	$input=Input::all();
    	$query=DB::table('ubale_fdp')
    	->where('ta','=',$input['TA'])
        ->where('gvh','=',$input['GVH'])
        ->where('FDP_ID','=',$input['FDP_ID'])
        ->where('FDP_Role','=',$input['FDP_Role'])
        ->update($input);
        if(!$query){
			return json_encode(array('errorMsg'=>'Failed to Update Some Error Occured'));
		}else{
			return json_encode(array('successMsg'=>'Successfully Update FDP'));
		}



    }

    public function commFdp(){
    	$dist=Auth::user()->dist_id;
    		$my_dist=Auth::user()->dist_id;
		$admin_role=Auth::user()->is_admin;
		//check to see if the user role is admin and for the PMU with district=0 and load equivalent values
		if($admin_role==1 && $my_dist==0 ){
    		return DB::table('ubale_fdp')
    		->join('code_district','ubale_fdp.district','=','code_district.rec_id')
			->join('code_ta','ubale_fdp.ta','=','code_ta.rec_id')
			->join('code_gvh','ubale_fdp.gvh','=','code_gvh.rec_id')
    		->get();
    	}
    	else{
    	return DB::table('ubale_fdp')
    	->where('district','=',$dist)
    	->join('code_district','ubale_fdp.district','=','code_district.rec_id')
		->join('code_ta','ubale_fdp.ta','=','code_ta.rec_id')
		->join('code_gvh','ubale_fdp.gvh','=','code_gvh.rec_id')
		->select('district_name','District','ta_name','TA','gvh_name','GVH','FDP_ID','FDP_Role','FDP_Name')
    	->get();
    	}

    }

    public function commFdpSel(){

    	//ffa commodity FDP select
    	$input=Input::all('id');
    	$DispFdp=DB::table('ubale_fdp')->where('gvh','=',$input)
    	->where('fdp_role','=','1')
    	->Select('FDP_name','FDP_ID')->get();
    	return $DispFdp;		
	}

	public function commFdpHSel(){

    	//ffa commodity FDP select
    	$input=Input::all('id');
    	$DispFdp=DB::table('ubale_fdp')->where('ta','=',$input)
    	->where('fdp_role','>','1')
    	->Select('FDP_name','FDP_ID')->get();
    	return $DispFdp;		
	}


	


}
