<?php

class ReportController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /report
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
		return View::make('cmis/household/reports',array('dist_options'=>$dist_options))->with('dist',$dist)->with('adminRole',$admin_role);
	}

	
	public function post(){
		$gvh=Input::get('gvhSel');
		$vil=Input::get('vilSel');
		if(isset($gvh) &&  $vil==0){
			$report=public_path() .'/report/cmisHousehold.jasper';
		}elseif(isset($gvh) && ($vil!=0)){
			$report=public_path() .'/report/cmisHousehold1.jasper';
		}

		
        $database = \Config::get('database.connections.mysql');
        $output = public_path() . '/report/'.time().'_codelution';
        
        $ext = "pdf";
       
       JasperPHP::process(
            $report,
            $output,
            array($ext),
            array("gvhSel"=>$gvh,"vilSel"=>$vil),
            $database,
            false,
            false
        )->execute();
 
		header('Content-Description: File Transfer');
		header('Content-Type:application/octet-stream');
		header('Content-Disposition:attachement;filename='.time().'_cmishh.'.$ext);
		header('Content-Transfer-Encoding:binary');
		header('Expires:0');
		header('Cache-Control:must-revalidate,post-check=0,precheck=0');
		header('Pragma:public');
		header('Content-Length:'.filesize($output.'.'.$ext));
		flush();
		readfile($output.'.'.$ext);
		unlink($output.'.'.$ext);

		return Redirect::to('/hhreport');
	}

	public function itt(){
		$userName = Auth::user()->username;
		$adminRole=Auth::user()->is_admin;
		$adminDist=Auth::user()->dist_id;
		return  View::make('cmis/reports/index')->with('userName',$userName)->with('adminRole',$adminRole);
	
	}
	public function participation(){
		
		
	}
	public function get_purpose(){
		$query=DB::table('projec_purpose')->get();

		return json_encode($query);
	}
	public function get_fy()
	{
		//
		$query=DB::table('ubale_fy')->get();
		return json_encode($query);
	}

	public function itt_report()
	{
		$input=Input::all();

		$query=DB::table('indicator_list')
		->where('rec_id_purpose','=',$input['purpose'])->get();
		return json_encode($query);

	}

	public function update_indicator()
	{
		$ind_num=Input::get("indicator_num");
		$year=Input::get("year");
		$query=DB::table('indicator_detail')->where('indicator_num','=',$ind_num)->where('year','=',$year)->get();
		return json_encode($query);

	}

public function itt_calcReport()
	{

		$input=Input::all();
		$adminDist=Auth::user()->dist_id;

		$allValueInd=$input['quarterJoin'];

		$ubaleStartDate=date('Y-m-01',strtotime('2014-12-01'));
		$fy16Start=date('Y-m-01',strtotime('2015-10-01'));

		//get start date and end date for quarter
		$q1_Start=date('Y-m-01',strtotime('2016-7-01'));
		$q1_End=date('Y-m-t',strtotime('2016-7-04'));
		//q2
		$q2_Start=date('Y-m-01',strtotime('2016-8-04'));
		$q2_End=date('Y-m-t',strtotime('2016-8-04'));
		//q3
		$q3_Start=date('Y-m-01',strtotime('2016-9-04'));
		$q3_End=date('Y-m-t',strtotime('2016-9-02'));
		//q4
		$q4_Start=date('Y-m-01',strtotime('2016-07-04'));
		$q4_End=date('Y-m-t',strtotime('2016-09-05'));

		//$myInd=unserialize($allValueInd[0]);
		$myArray = explode(',', $allValueInd);
		for ($i=0; $i < count($myArray) ; $i++) { 
				if($myArray[$i]=='1.3'){
				//calculate indicator //1.3 agricultor purpose
				$indQuery=DB::table('indicator_detail')
				->where('indicator_num','=','1.3')
				->get();
				if(count($indQuery)>0){
					$countTotal=0;
					$silc_group=DB::table('silc_group')
					
					->where('date_registration','>=',$q1_Start)
					->where('date_registration','<=',$q1_End)->count();

					$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','20')
					->update(['q1'=>$silc_group]);
					$countTotal+=$silc_group;

					$silc_group=DB::table('silc_group')
				
					->where('date_registration','>=',$q2_Start)
					->where('date_registration','<=',$q2_End)->count();
					$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','20')
					->update(['q2'=>$silc_group]);
					$countTotal+=$silc_group;

					$silc_group=DB::table('silc_group')				
					->where('date_registration','>=',$q3_Start)
					->where('date_registration','<=',$q3_End)->count();
					$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','20')
					->update(['q3'=>$silc_group]);
					$countTotal+=$silc_group;
					
					$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','20')
					->update(['q4'=>$countTotal]);


					//continuing
						$silc_group=DB::table('silc_group')
					->where('date_registration','<',$fy16Start)
					->count();
					

					$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','21')
					->update(['q1'=>$silc_group,'fy_achievement'=>$silc_group]);

					//FY Achievement
					$silc_group=DB::table('silc_group')
					->where('date_registration','>=',$fy16Start)
					->where('date_registration','<=',$q2_End)->count();

					$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','20')
					->update(['fy_achievement'=>$silc_group]);

					
				
					//calcIndicator($i);
				echo  "Calculating indicator 1.3";
			}

		}

			//indicator 1.8
	if($myArray[$i]=='1.8'){
				//calculate indicator //1.3 agricultor purpose
				$indQuery=DB::table('indicator_detail')
				->where('indicator_num','=','1.8')
				->get();
		if(count($indQuery)>0){
			//quarter 1
			$queryResMale=DB::select(DB::raw("select count(ud.hh_number) q2m from ubale_diner ud join tbl_beneficiary_registration tb on(ud.village=tb.Village and ud.hh_number=tb.HH_Number and ud.hh_member_number=tb.HH_Member_Number) where sex=1 and ud.date_registration BETWEEN '$q1_Start' and '$q1_End'"));//    "));
			$queryResFeMale=DB::select(DB::raw("select count(ud.hh_number) q2f from ubale_diner ud join tbl_beneficiary_registration tb on(ud.village=tb.Village and ud.hh_number=tb.HH_Number and ud.hh_member_number=tb.HH_Member_Number) where sex=2 and ud.date_registration BETWEEN '$q1_Start' and '$q1_End'"));
			foreach ($queryResMale as $dinMale) {
							$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','34')
							->update(['q1'=>$dinMale->q2m]);
			}
			foreach ($queryResFeMale as $dinFem) {
				$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','35')
				->update(['q1'=>$dinFem->q2f]);					
			}
			//quarter 2
			$queryResMale=DB::select(DB::raw("select count(ud.hh_number) q2m from ubale_diner ud join tbl_beneficiary_registration tb on(ud.village=tb.Village and ud.hh_number=tb.HH_Number and ud.hh_member_number=tb.HH_Member_Number) where sex=1 and ud.date_registration BETWEEN '$q2_Start' and '$q2_End'"));//    "));
			$queryResFeMale=DB::select(DB::raw("select count(ud.hh_number) q2f from ubale_diner ud join tbl_beneficiary_registration tb on(ud.village=tb.Village and ud.hh_number=tb.HH_Number and ud.hh_member_number=tb.HH_Member_Number) where sex=2 and ud.date_registration BETWEEN '$q2_Start' and '$q2_End'"));
			foreach ($queryResMale as $dinMale) {
							$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','34')
							->update(['q2'=>$dinMale->q2m]);
			}
			foreach ($queryResFeMale as $dinFem) {
				$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','35')
				->update(['q2'=>$dinFem->q2f]);					
			}

			//quarter 3
			$queryResMale=DB::select(DB::raw("select count(ud.hh_number) q2m from ubale_diner ud join tbl_beneficiary_registration tb on(ud.village=tb.Village and ud.hh_number=tb.HH_Number and ud.hh_member_number=tb.HH_Member_Number) where sex=1 and ud.date_registration BETWEEN '$q3_Start' and '$q3_End'"));//    "));
			$queryResFeMale=DB::select(DB::raw("select count(ud.hh_number) q2f from ubale_diner ud join tbl_beneficiary_registration tb on(ud.village=tb.Village and ud.hh_number=tb.HH_Number and ud.hh_member_number=tb.HH_Member_Number) where sex=2 and ud.date_registration BETWEEN '$q3_Start' and '$q3_End'"));
			foreach ($queryResMale as $dinMale) {
							$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','34')
							->update(['q3'=>$dinMale->q2m]);
			}
			foreach ($queryResFeMale as $dinFem) {
				$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','35')
				->update(['q3'=>$dinFem->q2f]);					
			}
			//quarter 4
			$queryResMale=DB::select(DB::raw("select count(ud.hh_number) q2m from ubale_diner ud join tbl_beneficiary_registration tb on(ud.village=tb.Village and ud.hh_number=tb.HH_Number and ud.hh_member_number=tb.HH_Member_Number) where sex=1 and ud.date_registration BETWEEN '$q4_Start' and '$q4_End'"));//    "));
			$queryResFeMale=DB::select(DB::raw("select count(ud.hh_number) q2f from ubale_diner ud join tbl_beneficiary_registration tb on(ud.village=tb.Village and ud.hh_number=tb.HH_Number and ud.hh_member_number=tb.HH_Member_Number) where sex=2 and ud.date_registration BETWEEN '$q4_Start' and '$q4_End'"));
			foreach ($queryResMale as $dinMale) {
							$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','34')
							->update(['q4'=>$dinMale->q2m]);
			}
			foreach ($queryResFeMale as $dinFem) {
				$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','35')
				->update(['q4'=>$dinFem->q2f]);					
			}

		}
	}
		//Number of DiNer Fairs Held
	if($myArray[$i]=='1.1'){
				//calculate indicator //1.3 agricultor purpose
				$indQuery=DB::table('indicator_detail')
				->where('indicator_num','=','1.1')
				->get();
				if(count($indQuery)>0){
			//quarter 1
			$query=DB::select(DB::raw("select count(*) total FROM `ubale_diner` WHERE date_registration BETWEEN '$q1_Start' and '$q1_End' GROUP by date_registration having total > 200"));
			//Month 1
			foreach ($query as $din) {
				if ($din->total > 500){
							$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','36')
							->update(['q1'=>'1']);
							}
			}
			
			$query=DB::select(DB::raw("select count(*) total FROM `ubale_diner` WHERE date_registration BETWEEN '$q2_Start' and '$q2_End' GROUP by date_registration having total > 200"));
			//Month 1
			foreach ($query as $din) {
				if ($din->total > 500){
							$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','36')
							->update(['q2'=>'1']);
							}
			}
			$query=DB::select(DB::raw("select count(*) total FROM `ubale_diner` WHERE date_registration BETWEEN '$q3_Start' and '$q3_End' GROUP by date_registration having total > 200"));
			//Month 1
			foreach ($query as $din) {
				if ($din->total > 500){
							$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','36')
							->update(['q1'=>'1']);
							}
			}
			
		}
		
	

	}

	//indicator 1.17N

	if($myArray[$i]=='1.17N'){
				//calculate indicator //1.3 agricultor purpose
				$indQuery=DB::table('indicator_detail')
				->where('indicator_num','=','1.17N')
				->get();

				$totalFem=0;
				$totalMale=0;
				if(count($indQuery)>0){
			//Month 1
			$queryResMale=DB::select(DB::raw("select count(ud.hh_number) q2m from ubale_marketing_registration ud join tbl_beneficiary_registration tb on(ud.village=tb.Village and ud.hh_number=tb.HH_Number and ud.hh_member_number=tb.HH_Member_Number) where sex=1 and ud.date_joining BETWEEN '$q1_Start' and '$q1_End'"));//    "));
			$queryResFeMale=DB::select(DB::raw("select count(ud.hh_number) q2f from ubale_marketing_registration ud join tbl_beneficiary_registration tb on(ud.village=tb.Village and ud.hh_number=tb.HH_Number and ud.hh_member_number=tb.HH_Member_Number) where sex=2 and ud.date_joining BETWEEN '$q1_Start' and '$q1_End'"));
			foreach ($queryResMale as $dinMale) {
							$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','65')
							->update(['q1'=>$dinMale->q2m]);
							$totalMale+=$dinMale->q2m;
			}
			foreach ($queryResFeMale as $dinFem) {
							$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','66')
							->update(['q1'=>$dinFem->q2f]);
							$totalFem+=$dinFem->q2f;
			}
			//Month 2
			$queryResMale=DB::select(DB::raw("select count(ud.hh_number) q2m from ubale_marketing_registration ud join tbl_beneficiary_registration tb on(ud.village=tb.Village and ud.hh_number=tb.HH_Number and ud.hh_member_number=tb.HH_Member_Number) where sex=1 and ud.date_joining BETWEEN '$q2_Start' and '$q2_End'"));//    "));
			$queryResFeMale=DB::select(DB::raw("select count(ud.hh_number) q2f from ubale_marketing_registration ud join tbl_beneficiary_registration tb on(ud.village=tb.Village and ud.hh_number=tb.HH_Number and ud.hh_member_number=tb.HH_Member_Number) where sex=2 and ud.date_joining BETWEEN '$q2_Start' and '$q2_End'"));
			foreach ($queryResMale as $dinMale) {
							$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','65')
							->update(['q2'=>$dinMale->q2m]);
							$totalMale+=$dinMale->q2m;
			}
			foreach ($queryResFeMale as $dinFem) {
							$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','66')
							->update(['q2'=>$dinFem->q2f]);
							$totalFem+=$dinFem->q2f;
			}
			//Month 3
			$queryResMale=DB::select(DB::raw("select count(ud.hh_number) q2m from ubale_marketing_registration ud join tbl_beneficiary_registration tb on(ud.village=tb.Village and ud.hh_number=tb.HH_Number and ud.hh_member_number=tb.HH_Member_Number) where sex=1 and ud.date_joining BETWEEN '$q3_Start' and '$q3_End'"));//    "));
			$queryResFeMale=DB::select(DB::raw("select count(ud.hh_number) q2f from ubale_marketing_registration ud join tbl_beneficiary_registration tb on(ud.village=tb.Village and ud.hh_number=tb.HH_Number and ud.hh_member_number=tb.HH_Member_Number) where sex=2 and ud.date_joining BETWEEN '$q3_Start' and '$q3_End'"));
			foreach ($queryResMale as $dinMale) {
							$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','65')
							->update(['q3'=>$dinMale->q2m]);
							$totalMale+=$dinMale->q2m;
							$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','65')
							->update(['q4'=>$totalMale]);
			}
			foreach ($queryResFeMale as $dinFem) {
							$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','66')
							->update(['q3'=>$dinFem->q2f]);
							$totalFem+=$dinFem->q2f;
							$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','66')
							->update(['q4'=>$totalFem]);
			}


			//total and achivement


					//FY Achievement
			$queryResMale=DB::select(DB::raw("select count(ud.hh_number) q2m from ubale_marketing_registration ud join tbl_beneficiary_registration tb on(ud.village=tb.Village and ud.hh_number=tb.HH_Number and ud.hh_member_number=tb.HH_Member_Number) where sex=1 and ud.date_joining BETWEEN '$fy16Start' and '$q3_End'"));//    "));
			$queryResFeMale=DB::select(DB::raw("select count(ud.hh_number) q2f from ubale_marketing_registration ud join tbl_beneficiary_registration tb on(ud.village=tb.Village and ud.hh_number=tb.HH_Number and ud.hh_member_number=tb.HH_Member_Number) where sex=2 and ud.date_joining BETWEEN '$fy16Start' and '$q3_End'"));
				foreach ($queryResMale as $dinMale) {
					$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','65')
					->update(['fy_achievement'=>$dinMale->q2m]);
				}
				foreach ($queryResFeMale as $dinFem) {
					$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','65')
					->update(['fy_achievement'=>$dinFem->q2f]);
				}
					
		}
	}

		//indicator 1.19

	if($myArray[$i]=='1.19'){
				//calculate indicator //1.3 agricultor purpose
				$indQuery=DB::table('indicator_detail')
				->where('indicator_num','=','1.19')
				->get();
				if(count($indQuery)>0){

					$countTotal=0;
					$mclub=DB::table('ubale_marketing_club')
					->where('date_registration','>=',$q1_Start)
					->where('date_registration','<=',$q1_End)->count();

					$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','68')
					->update(['q1'=>$mclub]);
					$countTotal+=$mclub;

					$mclub=DB::table('ubale_marketing_club')
					->where('date_registration','>=',$q2_Start)
					->where('date_registration','<=',$q2_End)->count();
					$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','68')
					->update(['q2'=>$mclub]);
					$countTotal+=$mclub;

					$mclub=DB::table('ubale_marketing_club')			
					->where('date_registration','>=',$q3_Start)
					->where('date_registration','<=',$q3_End)->count();
					$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','68')
					->update(['q3'=>$mclub]);
					$countTotal+=$mclub;
					
					$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','68')
					->update(['q4'=>$countTotal]);


					//continuing
						$mclub=DB::table('ubale_marketing_club')
					->where('date_registration','<',$fy16Start)
					->count();
					

					$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','69')
					->update(['q1'=>$mclub,'fy_achievement'=>$mclub]);

					//FY Achievement
					$mclub=DB::table('ubale_marketing_club')
					->where('date_registration','>=',$fy16Start)
					->where('date_registration','<=',$q2_End)->count();

					$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','68')
					->update(['fy_achievement'=>$mclub]);

			
		}
	}

	//mchn Indicators 

	//indicator 57
		if($myArray[$i]=='57'){
				//calculate indicator //1.3 agricultor purpose
				$indQuery=DB::table('indicator_detail')
				->where('indicator_num','=','57')
				->get();

			$m1=0;$m2=0;$m3=0;
			$m1f=0;$m2f=0;$m3f=0;
				if(count($indQuery)>0){
			//Month 1
			$queryResMale=DB::select(DB::raw("select count(ud.hh_number) q2m from ubale_mchn_child_ben ud join tbl_beneficiary_registration tb on(ud.village=tb.Village and ud.hh_number=tb.HH_Number and ud.hh_member_number=tb.HH_Member_Number) where sex=1 and ud.date_registration BETWEEN '$q1_Start' and '$q1_End'"));//    "));
			$queryResFeMale=DB::select(DB::raw("select count(ud.hh_number) q2f from ubale_mchn_child_ben ud join tbl_beneficiary_registration tb on(ud.village=tb.Village and ud.hh_number=tb.HH_Number and ud.hh_member_number=tb.HH_Member_Number) where sex=2 and ud.date_registration BETWEEN '$q1_Start' and '$q1_End'"));
			foreach ($queryResMale as $dinMale) {
							$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','113')
							->update(['q1'=>$dinMale->q2m]);
							$m1=$dinMale->q2m;
			}
			foreach ($queryResFeMale as $dinFem) {
							$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','114')
							->update(['q1'=>$dinFem->q2f]);
							$m1f=$dinFem->q2f;
			}
			//Month 2
			$queryResMale=DB::select(DB::raw("select count(ud.hh_number) q2m from ubale_mchn_child_ben ud join tbl_beneficiary_registration tb on(ud.village=tb.Village and ud.hh_number=tb.HH_Number and ud.hh_member_number=tb.HH_Member_Number) where sex=1 and ud.date_registration BETWEEN '$q2_Start' and '$q2_End'"));//    "));
			$queryResFeMale=DB::select(DB::raw("select count(ud.hh_number) q2f from ubale_mchn_child_ben ud join tbl_beneficiary_registration tb on(ud.village=tb.Village and ud.hh_number=tb.HH_Number and ud.hh_member_number=tb.HH_Member_Number) where sex=2 and ud.date_registration BETWEEN '$q2_Start' and '$q2_End'"));
			foreach ($queryResMale as $dinMale) {
							$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','113')
							->update(['q2'=>$dinMale->q2m]);
							$m2=$dinMale->q2m;
			}
			foreach ($queryResFeMale as $dinFem) {
							$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','114')
							->update(['q2'=>$dinFem->q2f]);
							$m2f=$dinMale->q2m;
			}
			//Month 3
			$queryResMale=DB::select(DB::raw("select count(ud.hh_number) q2m from ubale_mchn_child_ben ud join tbl_beneficiary_registration tb on(ud.village=tb.Village and ud.hh_number=tb.HH_Number and ud.hh_member_number=tb.HH_Member_Number) where sex=1 and ud.date_registration BETWEEN '$q3_Start' and '$q3_End'"));//    "));
			$queryResFeMale=DB::select(DB::raw("select count(ud.hh_number) q2f from ubale_mchn_child_ben ud join tbl_beneficiary_registration tb on(ud.village=tb.Village and ud.hh_number=tb.HH_Number and ud.hh_member_number=tb.HH_Member_Number) where sex=2 and ud.date_registration BETWEEN '$q3_Start' and '$q3_End'"));
			foreach ($queryResMale as $dinMale) {
							$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','113')
							->update(['q3'=>$dinMale->q2m]);
							$m3=$dinMale->q2m;
			}
			foreach ($queryResFeMale as $dinFem) {
							$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','114')
							->update(['q3'=>$dinFem->q2f]);
							$m3f=$dinMale->q2m;
			}

			if ($m1 > $m2){
				if($m1>$m3){
					$totalMale=$m1;
				}else{
					$totalMale=$m3;
				}
			}else{
				if ($m1>$m3){
				$totalMale=$m1;
				}else{
					$totalMale=$m2;
				}
			}

			//for femalea
			if ($m1f > $m2f){
				if($m1f>$m3f){
					$totalFem=$m1f;
				}else{
					$totalFem=$m3f;
				}
			}else{
				if ($m1f>$m3f){
				$totalFem=$m1f;
				}else{
					$totalFem=$m2f;
				}
			}

			$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','114')
							->update(['q4'=>$totalMale]);
			$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','114')
							->update(['q4'=>$totalFem]);

			$queryResMale=DB::select(DB::raw("select count(ud.hh_number) q2m from ubale_mchn_child_ben ud join tbl_beneficiary_registration tb on(ud.village=tb.Village and ud.hh_number=tb.HH_Number and ud.hh_member_number=tb.HH_Member_Number) where sex=1 and ud.date_registration BETWEEN '$fy16Start' and '$q3_End'"));//    "));
			$queryResFeMale=DB::select(DB::raw("select count(ud.hh_number) q2f from ubale_mchn_child_ben ud join tbl_beneficiary_registration tb on(ud.village=tb.Village and ud.hh_number=tb.HH_Number and ud.hh_member_number=tb.HH_Member_Number) where sex=2 and ud.date_registration BETWEEN '$fy16Start' and '$q3_End'"));
			foreach ($queryResMale as $dinMale) {
				$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','114')
							->update(['fy_achievement'=>$dinMale->q2m]);
			}
			foreach ($queryResFeMale as $dinFem) {
			$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','114')
							->update(['fy_achievement'=>$dinFem->q2f]);

			}	
		}
	}

	//indicator 57
		if($myArray[$i]=='57N'){
				//calculate indicator //1.3 agricultor purpose
				$indQuery=DB::table('indicator_detail')
				->where('indicator_num','=','57N')
				->get();
			$m1=0;$m2=0;$m3=0;
			$m1f=0;$m2f=0;$m3f=0;
				if(count($indQuery)>0){
			//Month 1
			$queryResMale=DB::select(DB::raw("select count(ud.hh_number) q2m from ubale_mchn_child_ben ud join tbl_beneficiary_registration tb on(ud.village=tb.Village and ud.hh_number=tb.HH_Number and ud.hh_member_number=tb.HH_Member_Number) where sex=1 and ud.date_registration BETWEEN '$q1_Start' and '$q1_End'"));//    "));
			$queryResFeMale=DB::select(DB::raw("select count(ud.hh_number) q2f from ubale_mchn_child_ben ud join tbl_beneficiary_registration tb on(ud.village=tb.Village and ud.hh_number=tb.HH_Number and ud.hh_member_number=tb.HH_Member_Number) where sex=2 and ud.date_registration BETWEEN '$q1_Start' and '$q1_End'"));
			foreach ($queryResMale as $dinMale) {
							$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','115')
							->update(['q1'=>$dinMale->q2m]);
							$m1=$dinMale->q2m;
			}
			foreach ($queryResFeMale as $dinFem) {
							$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','116')
							->update(['q1'=>$dinFem->q2f]);
							$m1f=$dinFem->q2f;
			}
			//Month 2
			$queryResMale=DB::select(DB::raw("select count(ud.hh_number) q2m from ubale_mchn_child_ben ud join tbl_beneficiary_registration tb on(ud.village=tb.Village and ud.hh_number=tb.HH_Number and ud.hh_member_number=tb.HH_Member_Number) where sex=1 and ud.date_registration BETWEEN '$q2_Start' and '$q2_End'"));//    "));
			$queryResFeMale=DB::select(DB::raw("select count(ud.hh_number) q2f from ubale_mchn_child_ben ud join tbl_beneficiary_registration tb on(ud.village=tb.Village and ud.hh_number=tb.HH_Number and ud.hh_member_number=tb.HH_Member_Number) where sex=2 and ud.date_registration BETWEEN '$q2_Start' and '$q2_End'"));
			foreach ($queryResMale as $dinMale) {
							$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','115')
							->update(['q2'=>$dinMale->q2m]);
							$m2=$dinMale->q2m;
			}
			}
			foreach ($queryResFeMale as $dinFem) {
							$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','116')
							->update(['q2'=>$dinFem->q2f]);
							$m2f=$dinFem->q2f;
			}
			//Month 3
			$queryResMale=DB::select(DB::raw("select count(ud.hh_number) q2m from ubale_mchn_child_ben ud join tbl_beneficiary_registration tb on(ud.village=tb.Village and ud.hh_number=tb.HH_Number and ud.hh_member_number=tb.HH_Member_Number) where sex=1 and ud.date_registration BETWEEN '$q3_Start' and '$q3_End'"));//    "));
			$queryResFeMale=DB::select(DB::raw("select count(ud.hh_number) q2f from ubale_mchn_child_ben ud join tbl_beneficiary_registration tb on(ud.village=tb.Village and ud.hh_number=tb.HH_Number and ud.hh_member_number=tb.HH_Member_Number) where sex=2 and ud.date_registration BETWEEN '$q3_Start' and '$q3_End'"));
			foreach ($queryResMale as $dinMale) {
							$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','115')
							->update(['q3'=>$dinMale->q2m]);
							$m3=$dinMale->q2m;
			}
			foreach ($queryResFeMale as $dinFem) {
							$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','116')
							->update(['q3'=>$dinFem->q2f]);
							$m3f=$dinFem->q2f;
			}
		if ($m1 > $m2){
				if($m1>$m3){
					$totalMale=$m1;
				}else{
					$totalMale=$m3;
				}
			}else{
				if ($m1>$m3){
				$totalMale=$m1;
				}else{
					$totalMale=$m2;
				}
			}

			//for femalea
			if ($m1f > $m2f){
				if($m1f>$m3f){
					$totalFem=$m1f;
				}else{
					$totalFem=$m3f;
				}
			}else{
				if ($m1f>$m3f){
				$totalFem=$m1f;
				}else{
					$totalFem=$m2f;
				}
			}
			$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','115')
							->update(['q4'=>$totalMale]);
			$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','116')
							->update(['q4'=>$totalFem]);

			$queryResMale=DB::select(DB::raw("select count(ud.hh_number) q2m from ubale_mchn_child_ben ud join tbl_beneficiary_registration tb on(ud.village=tb.Village and ud.hh_number=tb.HH_Number and ud.hh_member_number=tb.HH_Member_Number) where sex=1 and ud.date_registration BETWEEN '$fy16Start' and '$q3_End'"));//    "));
			$queryResFeMale=DB::select(DB::raw("select count(ud.hh_number) q2f from ubale_mchn_child_ben ud join tbl_beneficiary_registration tb on(ud.village=tb.Village and ud.hh_number=tb.HH_Number and ud.hh_member_number=tb.HH_Member_Number) where sex=2 and ud.date_registration BETWEEN '$fy16Start' and '$q3_End'"));
			foreach ($queryResMale as $dinMale) {
				$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','115')
							->update(['fy_achievement'=>$dinMale->q2m]);
			}
			foreach ($queryResFeMale as $dinFem) {
			$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','116')
							->update(['fy_achievement'=>$dinFem->q2f]);


		}
	}

	//indicator 2.16
		if($myArray[$i]=='2.16'){
				//calculate indicator //1.3 agricultor purpose
				$indQuery=DB::table('indicator_detail')
				->where('indicator_num','=','2.16')
				->get();
				$m1=0;$m2=0;$m3=0;
			$m1f=0;$m2f=0;$m3f=0;
			$m1p=0;$m2p=0;$m3p=0;

				if(count($indQuery)>0){
			//Month 1
			//preg
			$queryPreg=DB::select(DB::raw("select count(ud.hh_number) q2m from ubale_mchn_pregnant_mothers ud join tbl_beneficiary_registration tb on(ud.village=tb.Village and ud.hh_number=tb.HH_Number and ud.hh_member_number=tb.HH_Member_Number) where ud.date_registration BETWEEN '$q1_Start' and '$q1_End'"));
			//0-5
			$queryResMale=DB::select(DB::raw("select count(ud.hh_number) q2m from ubale_mchn_child_ben ud join tbl_beneficiary_registration tb on(ud.village=tb.Village and ud.hh_number=tb.HH_Number and ud.hh_member_number=tb.HH_Member_Number) where  ud.date_registration BETWEEN '$q1_Start' and '$q1_End'  and TIMESTAMPDIFF(Month,tb.dob,ud.date_registration) < 6"));//    "));
			
			//6-23
			$queryResMale1=DB::select(DB::raw("select count(ud.hh_number) q2m from ubale_mchn_child_ben ud join tbl_beneficiary_registration tb on(ud.village=tb.Village and ud.hh_number=tb.HH_Number and ud.hh_member_number=tb.HH_Member_Number) where ud.date_registration BETWEEN '$q1_Start' and '$q1_End'  and TIMESTAMPDIFF(Month,tb.dob,ud.date_registration) > 5"));//    "));
			
			foreach ($queryPreg as $mcpPreg) {
							$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','144')
							->update(['q1'=>$mcpPreg->q2m]);
							$m1p=$mcpPreg->q2m;
			}
			foreach ($queryResMale as $dinMale) {
							$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','145')
							->update(['q1'=>$dinMale->q2m]);
							$m1=$dinMale->q2m;
			}
			
			foreach ($queryResMale1 as $dinMale1) {
							$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','146')
							->update(['q1'=>$dinMale1->q2m]);
							$m1f=$dinMale1->q2m;
			}
			
			//Month 2
			//preg
			$queryPreg=DB::select(DB::raw("select count(ud.hh_number) q2m from ubale_mchn_pregnant_mothers ud join tbl_beneficiary_registration tb on(ud.village=tb.Village and ud.hh_number=tb.HH_Number and ud.hh_member_number=tb.HH_Member_Number) where  ud.date_registration BETWEEN '$q2_Start' and '$q2_End'"));
			//0-5
			$queryResMale=DB::select(DB::raw("select count(ud.hh_number) q2m from ubale_mchn_child_ben ud join tbl_beneficiary_registration tb on(ud.village=tb.Village and ud.hh_number=tb.HH_Number and ud.hh_member_number=tb.HH_Member_Number) where ud.date_registration BETWEEN '$q2_Start' and '$q2_End'  and TIMESTAMPDIFF(Month,tb.dob,ud.date_registration) < 6"));//    "));
			
			//6-23
			$queryResMale1=DB::select(DB::raw("select count(ud.hh_number) q2m from ubale_mchn_child_ben ud join tbl_beneficiary_registration tb on(ud.village=tb.Village and ud.hh_number=tb.HH_Number and ud.hh_member_number=tb.HH_Member_Number) where  ud.date_registration BETWEEN '$q2_Start' and '$q2_End'  and TIMESTAMPDIFF(Month,tb.dob,ud.date_registration) > 5"));//    "));
			
			foreach ($queryPreg as $mcpPreg) {
							$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','144')
							->update(['q2'=>$mcpPreg->q2m]);
							$m2p=$mcpPreg->q2m;
			}
			foreach ($queryResMale as $dinMale) {
							$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','145')
							->update(['q2'=>$dinMale->q2m]);
							$m2=$dinMale->q2m;
			}
			
			foreach ($queryResMale1 as $dinMale1) {
							$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','146')
							->update(['q2'=>$dinMale1->q2m]);
							$m2f=$dinMale1->q2m;
			}
			}
			
			//Month 3
			//preg
			$queryPreg=DB::select(DB::raw("select count(ud.hh_number) q2m from ubale_mchn_pregnant_mothers ud join tbl_beneficiary_registration tb on(ud.village=tb.Village and ud.hh_number=tb.HH_Number and ud.hh_member_number=tb.HH_Member_Number) where  ud.date_registration BETWEEN '$q3_Start' and '$q3_End'"));
			//0-5
			$queryResMale=DB::select(DB::raw("select count(ud.hh_number) q2m from ubale_mchn_child_ben ud join tbl_beneficiary_registration tb on(ud.village=tb.Village and ud.hh_number=tb.HH_Number and ud.hh_member_number=tb.HH_Member_Number) where ud.date_registration BETWEEN '$q3_Start' and '$q3_End'  and TIMESTAMPDIFF(Month,tb.dob,ud.date_registration) < 6"));//    "));
			
			//6-23
			$queryResMale1=DB::select(DB::raw("select count(ud.hh_number) q2m from ubale_mchn_child_ben ud join tbl_beneficiary_registration tb on(ud.village=tb.Village and ud.hh_number=tb.HH_Number and ud.hh_member_number=tb.HH_Member_Number) where ud.date_registration BETWEEN '$q3_Start' and '$q3_End'  and TIMESTAMPDIFF(Month,tb.dob,ud.date_registration) > 5"));//    "));
			
			foreach ($queryPreg as $mcpPreg) {
							$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','144')
							->update(['q3'=>$mcpPreg->q2m]);
							$m3p=$mcpPreg->q2m;

			}
			foreach ($queryResMale as $dinMale) {
							$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','145')
							->update(['q3'=>$dinMale->q2m]);
							$m3=$dinMale->q2m;
			}
			
			foreach ($queryResMale1 as $dinMale1) {
							$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','146')
							->update(['q3'=>$dinMale1->q2m]);
							$m3f=$dinMale1->q2m;
			}

			if ($m1 > $m2){
				if($m1>$m3){
					$totalMale=$m1;
				}else{
					$totalMale=$m3;
				}
			}else{
				if ($m1>$m3){
				$totalMale=$m1;
				}else{
					$totalMale=$m2;
				}
			}

			//for femalea
			if ($m1f > $m2f){
				if($m1f>$m3f){
					$totalFem=$m1f;
				}else{
					$totalFem=$m3f;
				}
			}else{
				if ($m1f>$m3f){
				$totalFem=$m1f;
				}else{
					$totalFe=$m2f;
				}
			}

			//pregnant 
			if ($m1p > $m2p){
				if($m1p>$m3p){
					$totalPreg=$m1p;
				}else{
					$totalPreg=$m3p;
				}
			}else{
				if ($m1p>$m3p){
				$totalPreg=$m1p;
				}else{
					$totalPreg=$m2p;
				}
			}
			$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','145')
							->update(['q4'=>$totalMale]);
			$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','146')
							->update(['q4'=>$totalFem]);
			$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','144')
							->update(['q4'=>$totalPreg]);

			$queryPreg=DB::select(DB::raw("select count(ud.hh_number) q2m from ubale_mchn_pregnant_mothers ud join tbl_beneficiary_registration tb on(ud.village=tb.Village and ud.hh_number=tb.HH_Number and ud.hh_member_number=tb.HH_Member_Number) where  ud.date_registration BETWEEN '$fy16Start' and '$q3_End'"));
			//0-5
			$queryResMale=DB::select(DB::raw("select count(ud.hh_number) q2m from ubale_mchn_child_ben ud join tbl_beneficiary_registration tb on(ud.village=tb.Village and ud.hh_number=tb.HH_Number and ud.hh_member_number=tb.HH_Member_Number) where ud.date_registration BETWEEN '$fy16Start' and '$q3_End'  and TIMESTAMPDIFF(Month,tb.dob,ud.date_registration) < 6"));//    "));
			
			//6-23
			$queryResMale1=DB::select(DB::raw("select count(ud.hh_number) q2m from ubale_mchn_child_ben ud join tbl_beneficiary_registration tb on(ud.village=tb.Village and ud.hh_number=tb.HH_Number and ud.hh_member_number=tb.HH_Member_Number) where ud.date_registration BETWEEN '$fy16Start' and '$q3_End'  and TIMESTAMPDIFF(Month,tb.dob,ud.date_registration) > 5"));//    "));
			foreach ($queryResMale as $dinMale) {
				$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','145')
							->update(['fy_achievement'=>$dinMale->q2m]);
			}
			foreach ($queryResMale1 as $dinFem) {
			$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','146')
							->update(['fy_achievement'=>$dinFem->q2m]);
			}
			foreach ($queryPreg as $dinFem) {
			$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','144')
							->update(['fy_achievement'=>$dinFem->q2m]);
			}




		
	}

//indicator 2.7
	if($myArray[$i]=='2.7'){
				//calculate indicator //1.3 agricultor purpose
				$indQuery=DB::table('indicator_detail')
				->where('indicator_num','=','2.7')
				->get();
				$m1=0;$m2=0;$m3=0;
				if(count($indQuery)>0){
			//Month 1
			$queryResMale=DB::select(DB::raw("select count(ud.cg_number) q2m from ubale_caregroup ud where ud.date_registra BETWEEN '$q1_Start' and '$q1_End'"));//    "));
			
			foreach ($queryResMale as $dinMale) {
							$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','130')
							->update(['q1'=>$dinMale->q2m]);
							$m1=$dinMale->q2m;
			}
			
			//Month 2
			$queryResMale=DB::select(DB::raw("select count(ud.cg_number) q2m from ubale_caregroup ud where ud.date_registra BETWEEN '$q2_Start' and '$q2_End'"));//    "));
			
			foreach ($queryResMale as $dinMale) {
							$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','130')
							->update(['q2'=>$dinMale->q2m]);
							$m2=$dinMale->q2m;
			}
			
			//Month 3
			$queryResMale=DB::select(DB::raw("select count(ud.cg_number) q2m from ubale_caregroup ud where ud.date_registra BETWEEN '$q3_Start' and '$q3_End'"));//    "));
			
			foreach ($queryResMale as $dinMale) {
							$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','130')
							->update(['q3'=>$dinMale->q2m]);
							$m3=$dinMale->q2m;
			}
			$queryResMale=DB::select(DB::raw("select count(ud.cg_number) q2m from ubale_caregroup ud where ud.date_registra BETWEEN '$fy16Start' and '$q3_End'"));//    "));
			foreach ($queryResMale as $dinMale) {
				$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','130')
							->update(['fy_achievement'=>$dinMale->q2m]);
			}


			if ($m1 > $m2){
				if($m1>$m3){
					$totalMale=$m1;
				}else{
					$totalMale=$m3;
				}
			}else{
				if ($m1>$m3){
				$totalMale=$m1;
				}else{
					$totalMale=$m2;
				}
			}
			$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','145')
							->update(['q4'=>$totalMale]);



		}
	}



//indicator 3.11
	if($myArray[$i]=='3.11'){
				//calculate indicator //1.3 agricultor purpose
				$indQuery=DB::table('indicator_detail')
				->where('indicator_num','=','3.11')
				->get();
				if(count($indQuery)>0){
			//Month 1
			$queryResMale=DB::select(DB::raw("select count(*) FROM `ubale_ffa_project` fp join ubale_ffa_beneficiary_register ufa on(fp.project_number=ufa.Project_Number) group by ufa.GVH"));//    "));
			
			foreach ($queryResMale as $dinMale) {
							$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','239')
							->update(['q1'=>count($queryResMale)]);
				}
			}
			}		
		//indicator 33
	if($myArray[$i]=='33'){
				//calculate indicator //1.3 agricultor purpose
				$indQuery=DB::table('indicator_detail')
				->where('indicator_num','=','33')
				->get();
				if(count($indQuery)>0){
			//Month 1
					$countMale=0;
					$countFemale=0;
					$countMaleMonth2=0;
					$countFemaleMonth2=1;
					$countMaleMonth3=0;
					$countFemaleMonth3=1;


			$queryProjects=DB::select(DB::raw("select * FROM `ubale_ffa_beneficiary_register` ufa join ubale_ffa_project fp on(fp.Project_number=ufa.project_number) WHERE fp.Date_From >'2016-3-1' group by fp.project_number"));
			
			foreach ($queryProjects as $projects) {
					
					$d1=new DateTime($projects->Date_From);
					$d2=new DateTime('2016-7-31');
					$interval=$d2->diff($d1);
					$proSpan1=($interval->format('%m'));
					$proSpan=($interval->format('%m')+1);

					
					if ($proSpan=='5'){
						$queryFFARecipt=DB::select(DB::raw("select count(*) FROM `ubale_ffa_beneficiary_register` ufa join tbl_beneficiary_registration tb on(tb.village=ufa.village and tb.hh_number=ufa.hh_number) WHERE ufa.project_number='$projects->Project_Number' and p5ack and tb.sex='1'"));	
						$queryFFAReciptFem=DB::select(DB::raw("select count(*) FROM `ubale_ffa_beneficiary_register` ufa join tbl_beneficiary_registration tb on(tb.village=ufa.village and tb.hh_number=ufa.hh_number) WHERE ufa.project_number='$projects->Project_Number' and p5ack and tb.sex='2'"));	
						$countMale+=count($queryFFARecipt);
						$countFemale+=count($queryFFAReciptFem);

					}

					if ($proSpan=='4'){
						$queryFFARecipt=DB::select(DB::raw("select count(*) FROM `ubale_ffa_beneficiary_register` ufa join tbl_beneficiary_registration tb on(tb.village=ufa.village and tb.hh_number=ufa.hh_number) WHERE ufa.project_number='$projects->Project_Number' and p4ack='1' and tb.sex='1'"));	
						$queryFFAReciptFem=DB::select(DB::raw("select count(*) FROM `ubale_ffa_beneficiary_register` ufa join tbl_beneficiary_registration tb on(tb.village=ufa.village and tb.hh_number=ufa.hh_number) WHERE ufa.project_number='$projects->Project_Number' and p4ack='1' and tb.sex='2'"));	
						$countMale+=count($queryFFARecipt);
						$countFemale+=count($queryFFAReciptFem);

						$queryFFARecipt=DB::select(DB::raw("select count(*) FROM `ubale_ffa_beneficiary_register` ufa join tbl_beneficiary_registration tb on(tb.village=ufa.village and tb.hh_number=ufa.hh_number) WHERE ufa.project_number='$projects->Project_Number' and ufa.p5ack='1' and tb.sex='1'"));	
						$queryFFAReciptFem=DB::select(DB::raw("select count(*) FROM `ubale_ffa_beneficiary_register` ufa join tbl_beneficiary_registration tb on(tb.village=ufa.village and tb.hh_number=ufa.hh_number) WHERE ufa.project_number='$projects->Project_Number' and ufa.p5ack='1' and tb.sex='2'"));	
						$countMaleMonth2+=count($queryFFARecipt);
						$countFemaleMonth2+=count($queryFFAReciptFem);
					}
					if ($proSpan=='3'){
						$queryFFARecipt=DB::select(DB::raw("select count(*) FROM `ubale_ffa_beneficiary_register` ufa join tbl_beneficiary_registration tb on(tb.village=ufa.village and tb.hh_number=ufa.hh_number) WHERE ufa.project_number='$projects->Project_Number' and ufa.p3ack='1' and tb.sex='1'"));	
						$queryFFAReciptFem=DB::select(DB::raw("select count(*) FROM `ubale_ffa_beneficiary_register` ufa join tbl_beneficiary_registration tb on(tb.village=ufa.village and tb.hh_number=ufa.hh_number) WHERE ufa.project_number='$projects->Project_Number' and ufa.p3ack='1' and tb.sex='2'"));	
						$countMale+=count($queryFFARecipt);
						$countFemale+=count($queryFFAReciptFem);

						$queryFFARecipt=DB::select(DB::raw("select count(*) FROM `ubale_ffa_beneficiary_register` ufa join tbl_beneficiary_registration tb on(tb.village=ufa.village and tb.hh_number=ufa.hh_number) WHERE ufa.project_number='$projects->Project_Number' and ufa.p4ack='1' and tb.sex='1'"));	
						$queryFFAReciptFem=DB::select(DB::raw("select count(*) FROM `ubale_ffa_beneficiary_register` ufa join tbl_beneficiary_registration tb on(tb.village=ufa.village and tb.hh_number=ufa.hh_number) WHERE ufa.project_number='$projects->Project_Number' and ufa.p4ack='1' and tb.sex='2'"));	
						$countMaleMonth2+=count($queryFFARecipt);
						$countFemaleMonth2+=count($queryFFAReciptFem);

						$queryFFARecipt=DB::select(DB::raw("select count(*) FROM `ubale_ffa_beneficiary_register` ufa join tbl_beneficiary_registration tb on(tb.village=ufa.village and tb.hh_number=ufa.hh_number) WHERE ufa.project_number='$projects->Project_Number' and ufa.p5ack='1' and tb.sex='1'"));	
						$queryFFAReciptFem=DB::select(DB::raw("select count(*) FROM `ubale_ffa_beneficiary_register` ufa join tbl_beneficiary_registration tb on(tb.village=ufa.village and tb.hh_number=ufa.hh_number) WHERE ufa.project_number='$projects->Project_Number' and ufa.p5ack='1' and tb.sex='2'"));	
						$countMaleMonth3+=count($queryFFARecipt);
						$countFemaleMonth3+=count($queryFFAReciptFem);
					}
					if ($proSpan=='2'){
						$queryFFARecipt=DB::select(DB::raw("select count(*) FROM `ubale_ffa_beneficiary_register` ufa join tbl_beneficiary_registration tb on(tb.village=ufa.village and tb.hh_number=ufa.hh_number) WHERE ufa.project_number='$projects->Project_Number' and ufa.p2ack='1' and tb.sex='1'"));	
						$queryFFAReciptFem=DB::select(DB::raw("select count(*) FROM `ubale_ffa_beneficiary_register` ufa join tbl_beneficiary_registration tb on(tb.village=ufa.village and tb.hh_number=ufa.hh_number) WHERE ufa.project_number='$projects->Project_Number' and ufa.p2ack='1' and tb.sex='2'"));	
						$countMale+=count($queryFFARecipt);
						$countFemale+=count($queryFFAReciptFem);

						$queryFFARecipt=DB::select(DB::raw("select count(*) FROM `ubale_ffa_beneficiary_register` ufa join tbl_beneficiary_registration tb on(tb.village=ufa.village and tb.hh_number=ufa.hh_number) WHERE ufa.project_number='$projects->Project_Number' and ufa.p3ack='1' and tb.sex='1'"));	
						$queryFFAReciptFem=DB::select(DB::raw("select count(*) FROM `ubale_ffa_beneficiary_register` ufa join tbl_beneficiary_registration tb on(tb.village=ufa.village and tb.hh_number=ufa.hh_number) WHERE ufa.project_number='$projects->Project_Number' and ufa.p3ack='1' and tb.sex='2'"));	
						$countMaleMonth2+=count($queryFFARecipt);
						$countFemaleMonth2+=count($queryFFAReciptFem);

						$queryFFARecipt=DB::select(DB::raw("select count(*) FROM `ubale_ffa_beneficiary_register` ufa join tbl_beneficiary_registration tb on(tb.village=ufa.village and tb.hh_number=ufa.hh_number) WHERE ufa.project_number='$projects->Project_Number' and ufa.p4ack='1' and tb.sex='1'"));	
						$queryFFAReciptFem=DB::select(DB::raw("select count(*) FROM `ubale_ffa_beneficiary_register` ufa join tbl_beneficiary_registration tb on(tb.village=ufa.village and tb.hh_number=ufa.hh_number) WHERE ufa.project_number='$projects->Project_Number' and ufa.p4ack='1' and tb.sex='2'"));	
						$countMaleMonth3+=count($queryFFARecipt);
						$countFemaleMonth3+=count($queryFFAReciptFem);
					}

					if ($proSpan=='1'){
						$queryFFARecipt=DB::select(DB::raw("select count(*) FROM `ubale_ffa_beneficiary_register` ufa join tbl_beneficiary_registration tb on(tb.village=ufa.village and tb.hh_number=ufa.hh_number) WHERE ufa.project_number='$projects->Project_Number' and ufa.p1ack='1' and tb.sex='1'"));	
						$queryFFAReciptFem=DB::select(DB::raw("select count(*) FROM `ubale_ffa_beneficiary_register` ufa join tbl_beneficiary_registration tb on(tb.village=ufa.village and tb.hh_number=ufa.hh_number) WHERE ufa.project_number='$projects->Project_Number' and ufa.p1ack='1' and tb.sex='2'"));	
						$countMale+=count($queryFFARecipt);
						$countFemale+=count($queryFFAReciptFem);

						$queryFFARecipt=DB::select(DB::raw("select count(*) FROM `ubale_ffa_beneficiary_register` ufa join tbl_beneficiary_registration tb on(tb.village=ufa.village and tb.hh_number=ufa.hh_number) WHERE ufa.project_number='$projects->Project_Number' and ufa.p2ack='1' and tb.sex='1'"));	
						$queryFFAReciptFem=DB::select(DB::raw("select count(*) FROM `ubale_ffa_beneficiary_register` ufa join tbl_beneficiary_registration tb on(tb.village=ufa.village and tb.hh_number=ufa.hh_number) WHERE ufa.project_number='$projects->Project_Number' and ufa.p2ack='1' and tb.sex='2'"));	
						$countMaleMonth2+=count($queryFFARecipt);
						$countFemaleMonth2+=count($queryFFAReciptFem);

						$queryFFARecipt=DB::select(DB::raw("select count(*) FROM `ubale_ffa_beneficiary_register` ufa join tbl_beneficiary_registration tb on(tb.village=ufa.village and tb.hh_number=ufa.hh_number) WHERE ufa.project_number='$projects->Project_Number' and ufa.p3ack='1' and tb.sex='1'"));	
						$queryFFAReciptFem=DB::select(DB::raw("select count(*) FROM `ubale_ffa_beneficiary_register` ufa join tbl_beneficiary_registration tb on(tb.village=ufa.village and tb.hh_number=ufa.hh_number) WHERE ufa.project_number='$projects->Project_Number' and ufa.p3ack='1' and tb.sex='2'"));	
						$countMaleMonth3+=count($queryFFARecipt);
						$countFemaleMonth3+=count($queryFFAReciptFem);
					}
					$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','240')
							->update(['q1'=>$countMale]);
					$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','242')
							->update(['q1'=>$countFemale]);

					$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','240')
							->update(['q2'=>$countMaleMonth2]);
					$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','242')
							->update(['q2'=>$countFemaleMonth2]);
					$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','240')
							->update(['q2'=>$countMaleMonth2]);
					$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','242')
							->update(['q2'=>$countFemaleMonth2]);

							return "calc ind 33";
				
			}
			
		}
	}


	//indicator56

	if($myArray[$i]=='56'){
			$countTrainMale=0;
			$countTrainFeMale=0;

				//calculate indicator //1.3 agricultor purpose
				$indQuery=DB::table('indicator_detail')
				->where('indicator_num','=','56')
				->get();
		if(count($indQuery)>0){
			//Month 1
			$queryResMale=DB::select(DB::raw("select * FROM `pmupvo_training` cm join tb_training tt on (tt.rec_id=substring(cm.training_num,4)) join pmupvo_staff ps on(ps.rec_id= cm.participant_id) WHERE tt.sector=2 and ps.Sex=1 and cm.date BETWEEN '$q1_Start' and '$q1_End'"));//    "));
			$queryResFeMale=DB::select(DB::raw("select * FROM `pmupvo_training` cm join tb_training tt on (tt.rec_id=substring(cm.training_num,4)) join pmupvo_staff ps on(ps.rec_id= cm.participant_id) WHERE tt.sector=2 and ps.Sex=1 and cm.date BETWEEN '$q1_Start' and '$q1_End'"));
			$countTrainMale+=count($queryResMale);
			 $countTrainFeMale+=count($queryResFeMale);

			//sub TA
			$queryResMale=DB::select(DB::raw("select * FROM sub_training cm join tb_training tt on (tt.rec_id=substring(cm.training_num,4)) WHERE tt.sector=2 and cm.Sex=1 and cm.date BETWEEN '$q1_Start' and '$q1_End'"));//    "));
			$queryResFeMale=DB::select(DB::raw("select * FROM sub_training cm join tb_training tt on (tt.rec_id=substring(cm.training_num,4)) WHERE tt.sector=2 and cm.Sex=2 and cm.date BETWEEN '$q1_Start' and '$q1_End'"));
			$countTrainMale+=count($queryResMale);
			 $countTrainFeMale+=count($queryResFeMale);
			//Community Level 
			
			$queryResMale=DB::select(DB::raw("select * FROM community_training cm join tb_training tt on (tt.rec_id=substring(cm.training_num,4))  WHERE tt.sector=2 and cm.Sex=1 and cm.date BETWEEN '$q1_Start' and '$q1_End'"));//    "));
			$queryResFeMale=DB::select(DB::raw("select * FROM community_training cm join tb_training tt on (tt.rec_id=substring(cm.training_num,4))  WHERE tt.sector=2 and cm.Sex=1 and cm.date BETWEEN '$q1_Start' and '$q1_End'"));
			$countTrainMale+=count($queryResMale);
			 $countTrainFeMale+=count($queryResFeMale);
			
			$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','111')
			->update(['q1'=>$countTrainMale]);
			$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','112')
			->update(['q1'=>$countTrainFeMale]);


			//Month 2 calculation
			//PMU PVO
			$queryResMale=DB::select(DB::raw("select * FROM `pmupvo_training` cm join tb_training tt on (tt.rec_id=substring(cm.training_num,4)) join pmupvo_staff ps on(ps.rec_id= cm.participant_id) WHERE tt.sector=2 and ps.Sex=1 and cm.date BETWEEN '$q2_Start' and '$q2_End'"));//    "));
			$queryResFeMale=DB::select(DB::raw("select * FROM `pmupvo_training` cm join tb_training tt on (tt.rec_id=substring(cm.training_num,4)) join pmupvo_staff ps on(ps.rec_id= cm.participant_id) WHERE tt.sector=2 and ps.Sex=1 and cm.date BETWEEN '$q2_Start' and '$q2_End'"));
			$countTrainMale+=count($queryResMale);
			 $countTrainFeMale+=count($queryResFeMale);

			//sub TA
			$queryResMale=DB::select(DB::raw("select * FROM sub_training cm join tb_training tt on (tt.rec_id=substring(cm.training_num,4)) WHERE tt.sector=2 and cm.Sex=1 and cm.date BETWEEN '$q2_Start' and '$q2_End'"));//    "));
			$queryResFeMale=DB::select(DB::raw("select * FROM sub_training cm join tb_training tt on (tt.rec_id=substring(cm.training_num,4)) WHERE tt.sector=2 and cm.Sex=2 and cm.date BETWEEN '$q2_Start' and '$q2_End'"));
			$countTrainMale+=count($queryResMale);
			 $countTrainFeMale+=count($queryResFeMale);
			//Community Level 
			
			$queryResMale=DB::select(DB::raw("select * FROM community_training cm join tb_training tt on (tt.rec_id=substring(cm.training_num,4))  WHERE tt.sector=2 and cm.Sex=1 and cm.date BETWEEN '$q2_Start' and '$q2_End'"));//    "));
			$queryResFeMale=DB::select(DB::raw("select * FROM community_training cm join tb_training tt on (tt.rec_id=substring(cm.training_num,4))  WHERE tt.sector=2 and cm.Sex=1 and cm.date BETWEEN '$q2_Start' and '$q2_End'"));
			$countTrainMale+=count($queryResMale);
			 $countTrainFeMale+=count($queryResFeMale);
			
			//update Month1 
			$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','111')
			->update(['q2'=>$countTrainMale]);
			$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','112')
			->update(['q2'=>$countTrainFeMale]);

			//Month 3 calculation
			//PMU PVO
			$queryResMale=DB::select(DB::raw("select * FROM `pmupvo_training` cm join tb_training tt on (tt.rec_id=substring(cm.training_num,4)) join pmupvo_staff ps on(ps.rec_id= cm.participant_id) WHERE tt.sector=2 and ps.Sex=1 and cm.date BETWEEN '$q3_Start' and '$q3_End'"));//    "));
			$queryResFeMale=DB::select(DB::raw("select * FROM `pmupvo_training` cm join tb_training tt on (tt.rec_id=substring(cm.training_num,4)) join pmupvo_staff ps on(ps.rec_id= cm.participant_id) WHERE tt.sector=2 and ps.Sex=1 and cm.date BETWEEN '$q3_Start' and '$q3_End'"));
			$countTrainMale+=count($queryResMale);
			 $countTrainFeMale+=count($queryResFeMale);

			//sub TA
			$queryResMale=DB::select(DB::raw("select * FROM sub_training cm join tb_training tt on (tt.rec_id=substring(cm.training_num,4)) WHERE tt.sector=2 and cm.Sex=1 and cm.date BETWEEN '$q3_Start' and '$q3_End'"));//    "));
			$queryResFeMale=DB::select(DB::raw("select * FROM sub_training cm join tb_training tt on (tt.rec_id=substring(cm.training_num,4)) WHERE tt.sector=2 and cm.Sex=2 and cm.date BETWEEN '$q3_Start' and '$q3_End'"));
			$countTrainMale+=count($queryResMale);
			 $countTrainFeMale+=count($queryResFeMale);
			//Community Level 
			
			$queryResMale=DB::select(DB::raw("select * FROM community_training cm join tb_training tt on (tt.rec_id=substring(cm.training_num,4))  WHERE tt.sector=2 and cm.Sex=1 and cm.date BETWEEN '$q3_Start' and '$q3_End'"));//    "));
			$queryResFeMale=DB::select(DB::raw("select * FROM community_training cm join tb_training tt on (tt.rec_id=substring(cm.training_num,4))  WHERE tt.sector=2 and cm.Sex=1 and cm.date BETWEEN '$q3_Start' and '$q3_End'"));
			$countTrainMale+=count($queryResMale);
			 $countTrainFeMale+=count($queryResFeMale);
			//update Month1 
			$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','111')
			->update(['q3'=>$countTrainMale]);
			$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','112')
			->update(['q3'=>$countTrainFeMale]);
			
		
		}
	}
	


		//indicator56

	if($myArray[$i]=='11'){
			$countTrainMale=0;
			$countTrainFeMale=0;

				//calculate indicator //1.3 agricultor purpose
				$indQuery=DB::table('indicator_detail')
				->where('indicator_num','=','11')
				->get();
		if(count($indQuery)>0){
			//Month 1

			//disagregated by Government Staff
			$queryResMale=DB::select(DB::raw("select * FROM `pmupvo_training` cm join tb_training tt on (tt.rec_id=substring(cm.training_num,4)) join pmupvo_staff ps on(ps.rec_id= cm.participant_id) WHERE tt.sector=1 and ps.institution=7 and ps.Sex=1 and cm.date BETWEEN '$q1_Start' and '$q1_End'"));//    "));
			$queryResFeMale=DB::select(DB::raw("select * FROM `pmupvo_training` cm join tb_training tt on (tt.rec_id=substring(cm.training_num,4)) join pmupvo_staff ps on(ps.rec_id= cm.participant_id) WHERE tt.sector=1 and ps.institution=7 and ps.Sex=1 and cm.date BETWEEN '$q1_Start' and '$q1_End'"));
			$countTrainMale=count($queryResMale);
			 $countTrainFeMale=count($queryResFeMale);
					
			$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','11')
			->update(['q1'=>$countTrainMale]);
			$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','12')
			->update(['q1'=>$countTrainFeMale]);

			//disagregated by Farmer
			$countTrainMale=0;
			$countTrainFeMale=0;
			$queryResMale=DB::select(DB::raw("select * FROM sub_training cm join tb_training tt on (tt.rec_id=substring(cm.training_num,4)) WHERE tt.sector=1 and cm.Sex=1 and cm.date BETWEEN '$q1_Start' and '$q1_End'"));//    "));
			$queryResFeMale=DB::select(DB::raw("select * FROM sub_training cm join tb_training tt on (tt.rec_id=substring(cm.training_num,4)) WHERE tt.sector=1 and cm.Sex=2 and cm.date BETWEEN '$q1_Start' and '$q1_End'"));
			$countTrainMale+=count($queryResMale);
			 $countTrainFeMale+=count($queryResFeMale);
			//Community Level 
			$queryResMale=DB::select(DB::raw("select * FROM community_training cm join tb_training tt on (tt.rec_id=substring(cm.training_num,4))  WHERE tt.sector=1 and cm.Sex=1 and cm.date BETWEEN '$q1_Start' and '$q1_End'"));//    "));
			$queryResFeMale=DB::select(DB::raw("select * FROM community_training cm join tb_training tt on (tt.rec_id=substring(cm.training_num,4))  WHERE tt.sector=1 and cm.Sex=1 and cm.date BETWEEN '$q1_Start' and '$q1_End'"));
			$countTrainMale+=count($queryResMale);
			 $countTrainFeMale+=count($queryResFeMale);
			 //Update Farmers
			 $query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','7')
			->update(['q1'=>$countTrainMale]);
			$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','8')
			->update(['q1'=>$countTrainFeMale]);


			//Month 2
			//disagregated by Government Staff
			$queryResMale=DB::select(DB::raw("select * FROM `pmupvo_training` cm join tb_training tt on (tt.rec_id=substring(cm.training_num,4)) join pmupvo_staff ps on(ps.rec_id= cm.participant_id) WHERE tt.sector=1 and ps.institution=7 and ps.Sex=1 and cm.date BETWEEN '$q2_Start' and '$q2_End'"));//    "));
			$queryResFeMale=DB::select(DB::raw("select * FROM `pmupvo_training` cm join tb_training tt on (tt.rec_id=substring(cm.training_num,4)) join pmupvo_staff ps on(ps.rec_id= cm.participant_id) WHERE tt.sector=1 and ps.institution=7 and ps.Sex=1 and cm.date BETWEEN '$q2_Start' and '$q2_End'"));
			$countTrainMale=count($queryResMale);
			 $countTrainFeMale=count($queryResFeMale);
					
			$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','11')
			->update(['q2'=>$countTrainMale]);
			$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','12')
			->update(['q2'=>$countTrainFeMale]);

			//disagregated by Farmer
			$countTrainMale=0;
			$countTrainFeMale=0;
			$queryResMale=DB::select(DB::raw("select * FROM sub_training cm join tb_training tt on (tt.rec_id=substring(cm.training_num,4)) WHERE tt.sector=1 and cm.Sex=1 and cm.date BETWEEN '$q2_Start' and '$q2_End'"));//    "));
			$queryResFeMale=DB::select(DB::raw("select * FROM sub_training cm join tb_training tt on (tt.rec_id=substring(cm.training_num,4)) WHERE tt.sector=1 and cm.Sex=2 and cm.date BETWEEN '$q2_Start' and '$q2_End'"));
			$countTrainMale+=count($queryResMale);
			 $countTrainFeMale+=count($queryResFeMale);
			//Community Level 
			$queryResMale=DB::select(DB::raw("select * FROM community_training cm join tb_training tt on (tt.rec_id=substring(cm.training_num,4))  WHERE tt.sector=1 and cm.Sex=1 and cm.date BETWEEN '$q2_Start' and '$q2_End'"));//    "));
			$queryResFeMale=DB::select(DB::raw("select * FROM community_training cm join tb_training tt on (tt.rec_id=substring(cm.training_num,4))  WHERE tt.sector=1 and cm.Sex=1 and cm.date BETWEEN '$q2_Start' and '$q2_End'"));
			$countTrainMale+=count($queryResMale);
			 $countTrainFeMale+=count($queryResFeMale);
			 //Update Farmers
			 $query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','7')
			->update(['q2'=>$countTrainMale]);
			$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','8')
			->update(['q2'=>$countTrainFeMale]);

			//Month 3
			//disagregated by Government Staff
			$queryResMale=DB::select(DB::raw("select * FROM `pmupvo_training` cm join tb_training tt on (tt.rec_id=substring(cm.training_num,4)) join pmupvo_staff ps on(ps.rec_id= cm.participant_id) WHERE tt.sector=1 and ps.institution=7 and ps.Sex=1 and cm.date BETWEEN '$q3_Start' and '$q3_End'"));//    "));
			$queryResFeMale=DB::select(DB::raw("select * FROM `pmupvo_training` cm join tb_training tt on (tt.rec_id=substring(cm.training_num,4)) join pmupvo_staff ps on(ps.rec_id= cm.participant_id) WHERE tt.sector=1 and ps.institution=7 and ps.Sex=1 and cm.date BETWEEN '$q3_Start' and '$q3_End'"));
			$countTrainMale=count($queryResMale);
			 $countTrainFeMale=count($queryResFeMale);
					
			$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','11')
			->update(['q3'=>$countTrainMale]);
			$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','12')
			->update(['q3'=>$countTrainFeMale]);

			//disagregated by Farmer
			$countTrainMale=0;
			$countTrainFeMale=0;
			$queryResMale=DB::select(DB::raw("select * FROM sub_training cm join tb_training tt on (tt.rec_id=substring(cm.training_num,4)) WHERE tt.sector=1 and cm.Sex=1 and cm.date BETWEEN '$q3_Start' and '$q3_End'"));//    "));
			$queryResFeMale=DB::select(DB::raw("select * FROM sub_training cm join tb_training tt on (tt.rec_id=substring(cm.training_num,4)) WHERE tt.sector=1 and cm.Sex=2 and cm.date BETWEEN '$q3_Start' and '$q3_End'"));
			$countTrainMale+=count($queryResMale);
			 $countTrainFeMale+=count($queryResFeMale);
			//Community Level 
			$queryResMale=DB::select(DB::raw("select * FROM community_training cm join tb_training tt on (tt.rec_id=substring(cm.training_num,4))  WHERE tt.sector=1 and cm.Sex=1 and cm.date BETWEEN '$q3_Start' and '$q3_End'"));//    "));
			$queryResFeMale=DB::select(DB::raw("select * FROM community_training cm join tb_training tt on (tt.rec_id=substring(cm.training_num,4))  WHERE tt.sector=1 and cm.Sex=1 and cm.date BETWEEN '$q3_Start' and '$q3_End'"));
			$countTrainMale+=count($queryResMale);
			 $countTrainFeMale+=count($queryResFeMale);
			 //Update Farmers
			 $query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','7')
			->update(['q3'=>$countTrainMale]);
			$query=DB::table('indicator_detail')->where('indicator_num','=',$myArray[$i])->where('rec_id','=','8')
			->update(['q3'=>$countTrainFeMale]);
			
		
		}
	}
				
		}//roop Control for array of Indicator
	} //closing calc

	//return Redirect::to('/ITT');




	/*function calcIndicator(cha){

	}*/
public function itt_genreport()
	{
		$input=Input::all();
		$adminDist=Auth::user()->dist_id;

		
		$report=public_path() .'/report/ITT_Rport.jasper';

		$database = \Config::get('database.connections.mysql');
        $output = public_path() . '/report/'.time().'_ITTReport';
        
        $ext = "pdf";
       
       \JasperPHP::process(
            $report,
            $output,
            array($ext),
            array("indicatorNum"=>'2',"partner"=>$adminDist),
            $database,
            false,
            false
        )->execute();
 
		header('Content-Description: File Transfer');
		header('Content-Type:application/octet-stream');
		header('Content-Disposition:attachement;filename='.time().'_ITTReport.'.$ext);
		header('Content-Transfer-Encoding:binary');
		header('Expires:0');
		header('Cache-Control:must-revalidate,post-check=0,precheck=0');
		header('Pragma:public');
		header('Content-Length:'.filesize($output.'.'.$ext));
		flush();
		readfile($output.'.'.$ext);
		unlink($output.'.'.$ext);

		return Redirect::to('/ITT');
	
		

	}

}