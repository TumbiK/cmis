<?php

use Carbon\Carbon;

class silcController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		$userName = Auth::user()->username;
		$adminRole=Auth::user()->is_admin;
		$adminDist=Auth::user()->dist_id;

		return  View::make('cmis/agriculture/silc/index')->with('userName',$userName)->with('adminRole',$adminRole);
	}





	public function codesSilc(){
		$input=Input::all();

		
		$created = Carbon::createFromFormat('d/m/Y', $input['date_registration']);
		$input['date_registration']=$created;
		
		
		$createdAt = Carbon::createFromFormat('d/m/Y', $input['date_formation']);
		$input['date_registration']=$createdAt;
		
		

		$query=DB::table('silc_group')->insert($input);

		If($query){
			return json_encode(array('successMsg'=>'Successfully added SILC Group'));
		}else{
			return json_encode(array('errorMsg'=>'Failed to add SILC Group'));
		}

	}

	public function codesMarketClub(){
		$input=Input::all();

		$createdAt = Carbon::createFromFormat('d/m/Y',$input['date_registration']);
		$input['date_registration']=$createdAt;

		$query=DB::table('ubale_marketing_club')->insert($input);

		If($query){
			return json_encode(array('successMsg'=>'Successfully added Marketing Club'));
		}else{
			return json_encode(array('errorMsg'=>'Failed to add Marketing Club'));
		}

	}

	public function codesMaCl(){
		$input=Input::all();

		$createdAt = Carbon::createFromFormat('d/m/Y',$input['date_registration']);
		$input['date_registration']=$createdAt;

		$query=DB::table('ubale_marketing_cluster')->insert($input);

		If($query){
			return json_encode(array('successMsg'=>'Successfully added Marketing Cluster'));
		}else{
			return json_encode(array('errorMsg'=>'Failed to add Marketing Cluster'));
		}

	}


	public function codesPSP(){
		$input=Input::all();
		if($input['date_registration']!=''){
			$createdAt = Carbon::createFromFormat('d/m/Y',$input['date_registration']);
			$input['date_registration']=$createdAt;

		}
		
		$query=DB::table('pspfa')->insert($input);


		If($query){
			return json_encode(array('successMsg'=>'Successfully added SILC PSP'));
		}else{
			return json_encode(array('errorMsg'=>'Failed to add SILC PSP'));
		}

	}

	public function codesMA(){
		$input=Input::all();
		if($input['date_registration']!=''){
			$createdAt = Carbon::createFromFormat('d/m/Y',$input['date_registration']);
			$input['date_registration']=$createdAt;

		}
		$input['psp_role']='2';
				
		$query=DB::table('pspfa')->insert($input);

		If($query){
			return json_encode(array('successMsg'=>'Successfully added Marketing MA'));
		}else{
			return json_encode(array('errorMsg'=>'Failed to add Marketing MA'));
		}

	}
	public function silc_group(){
		$input=Input::all();

		$query=DB::table('silc_group')->where('Rec_id_gvh','=',$input['id'])->select('group_number as rec_id','group_name')->get();

		return json_encode($query);
	}

	public function market_group(){
		$input=Input::all();

		$query=DB::table('ubale_marketing_club')->where('Rec_id_gvh','=',$input['id'])->select('group_number as rec_id','group_name')->get();

		return json_encode($query);
	}


	public function pspfa(){
		$input=Input::all();

		$query=DB::table('pspfa')->where('Rec_TA','=',$input['id'])->select('rec_id','psp_name')->get();

		return json_encode($query);
	}

	public function market_psp(){
		$input=Input::all();


		$query=DB::table('pspfa')->where('Rec_gvh','=',$input['id'])
		->where('psp_role','=','2')
		->select('rec_id','psp_name')->get();

		return json_encode($query);
	}

	public function code_ss(){
		$input=Input::all();

		$query=DB::table('pmupvo_staff')->where('district','=',$input['id'])->where('role','=','8')->select('rec_id','name_of_participant as ss_supervisor')->get();

		return json_encode($query);

	}

	public function code_MaCluster(){
		$input=Input::all();

		$query=DB::table('ubale_marketing_cluster')->where('TA','=',$input['id'])->select('Rec_Id','cl_name')->get();

		return json_encode($query);

	}

	public function updateMaCl()
	{
		$input=Input::all();
		if ($input['district']!=''&& $input['club']!='' && $input['cl_number'])
		{
			$query=DB::table('ubale_marketing_club')->where('Rec_id_district','=',$input['district'])
			->where('group_number','=',$input['club'])->update(array('cl_number'=>$input['cl_number']));
			if($query){
				return array("successMsg"=>"Successfully Assigned Group to Cluster");
			}else{
				return array("errorMsg"=>"Failed to Assign Group to Cluster");
			}
		}

	}



	public function saveSilcBen(){
		$input=Input::only('District','TA','GVH','Village','HH_Number','HH_Member_Number','Silc_group','psp_fa','SS_Supervisor','date_joining');

		$date= Carbon::createFromFormat('d/m/Y',$input['date_joining']);
		$input['date_joining']=$date->format('Y-m-d');
		$input['year']=$date->year;
		//check beneficiary status and active
		$chkMain=DB::table('tbl_beneficiary_registration')
		->where('district','=',$input['District'])
		->where('ta','=',$input['TA'])
		->where('gvh','=',$input['GVH'])
		->where('village','=',$input['Village'])
		->where('hh_number','=',$input['HH_Number'])
		->where('HH_Member_Number','=',$input['HH_Member_Number'])
		->where('status','>',0)
		->get();
 $year=$input['year'];

	if (count($chkMain)<1){
		$chkHH=DB::table('ubale_silc_registration')
		->where('district','=',$input['District'])
		->where('ta','=',$input['TA'])
		->where('gvh','=',$input['GVH'])
		->where('village','=',$input['Village'])
		->where('hh_number','=',$input['HH_Number'])
		->where('HH_Member_Number','=',$input['HH_Member_Number'])
		->where(function($query) use ($year){
			$query->where('year','=',$year)
			->orWhere('year','>',$year);
		})
		->get();

		if(count($chkHH)>0){
			return json_encode(array('errorMsg'=>'HouseHold already Exist in SILC Group - Check the Details'));

		}else{

			if($input['Silc_group']<1){
				return json_encode(array('errorMsg'=>'No SILC Group Selected'));
			
			}else{
				$query=DB::table('ubale_silc_registration')->insert($input);

				$query2=DB::table('tbl_beneficiary_registration')
				->where('district','=',$input['District'])
				->where('ta','=',$input['TA'])
				->where('gvh','=',$input['GVH'])
				->where('village','=',$input['Village'])
				->where('hh_number','=',$input['HH_Number'])
				->where('hh_member_number','=',$input['HH_Member_Number'])				
				->update(array('SG_Member'=>'1'));
			
			}

		}
		if($query){
			return json_encode(array('successMsg'=>'Successfully added saveBeneficiary to Silc Group'));
		}
		
	}else{
		
		return json_encode(array('errorMsg'=>'Error Occured | Moved out or Deceased | Beneficiary Not Added to Silc Group')); 	
		//return json_encode($chkMain);
		
	}

}
	public function saveMarketBen(){
		$input=Input::only('District','TA','GVH','Village','HH_Number','HH_Member_Number','market_club','psp_fa','SS_Supervisor','date_joining');

		$date= Carbon::createFromFormat('d/m/Y',$input['date_joining']);
		$input['date_joining']=$date->format('Y-m-d');
		$input['year']=$date->year;
		//check beneficiary status and active
		$chkMain=DB::table('tbl_beneficiary_registration')
		->where('district','=',$input['District'])
		->where('ta','=',$input['TA'])
		->where('gvh','=',$input['GVH'])
		->where('village','=',$input['Village'])
		->where('hh_number','=',$input['HH_Number'])
		->where('HH_Member_Number','=',$input['HH_Member_Number'])
		->where('status','>',0)
		->get();
 $year=$input['year'];

	if (count($chkMain)<1){
		$chkHH=DB::table('ubale_marketing_registration')
		->where('district','=',$input['District'])
		->where('ta','=',$input['TA'])
		->where('gvh','=',$input['GVH'])
		->where('village','=',$input['Village'])
		->where('hh_number','=',$input['HH_Number'])
		->where('HH_Member_Number','=',$input['HH_Member_Number'])
		->where(function($query) use ($year){
			$query->where('year','=',$year)
			->orWhere('year','>',$year);
		})
		->get();

		if(count($chkHH)>0){
			return json_encode(array('errorMsg'=>'HouseHold already Exist in Market - Check the Details'));

		}else{

			if($input['market_club']<1){
				return json_encode(array('errorMsg'=>'No market club Selected'));
			
			}else{
				$query=DB::table('ubale_marketing_registration')->insert($input);

				$query2=DB::table('tbl_beneficiary_registration')
				->where('district','=',$input['District'])
				->where('ta','=',$input['TA'])
				->where('gvh','=',$input['GVH'])
				->where('village','=',$input['Village'])
				->where('hh_number','=',$input['HH_Number'])
				->where('hh_member_number','=',$input['HH_Member_Number'])				
				->update(array('SG_Member'=>'1'));
			
			}

		}
		if($query){
			return json_encode(array('successMsg'=>'Successfully added saveBeneficiary to Market Club'));
		}
		
	}else{
		
		return json_encode(array('errorMsg'=>'Error Occured | Moved out or Deceased | Beneficiary Not Added to marketclub')); 	
		//return json_encode($chkMain);
		
	}

		
	}

	public function update_silc(){
		$input=Input::only('district','ta','gvh','Village','HH_Number','HH_Member_Number','position','date_leaving');
		$editing=Input::get('editing');
		if ($input['date_leaving']!=''){
				$date= Carbon::createFromFormat('d/m/Y',$input['date_leaving']);
				$input['date_leaving']=$date->format('Y-m-d');
			}

		if($editing){
			$query=DB::table('ubale_silc_registration')->where('district','=',$input['district'])
			->where('ta','=',$input['ta'])
			->where('gvh','=',$input['gvh'])
			->where('village','=',$input['Village'])
			->where('hh_number','=',$input['HH_Number'])
			->where('hh_member_number','=',$input['HH_Member_Number'])
			->update(array("position"=>$input['position'],"date_leaving"=>$input['date_leaving']));
			
			if($query){
				return "Successfully Updated";
			}else
			{
				return "Error Updating";
			}

		}
			

	}

	public function update_marketing(){
		$input=Input::only('district','ta','gvh','Village','HH_Number','HH_Member_Number','position','date_leaving');
		$editing=Input::get('editing');
		if ($input['date_leaving']!=''){
				$date= Carbon::createFromFormat('d/m/Y',$input['date_leaving']);
				$input['date_leaving']=$date->format('Y-m-d');
			}

		if($editing){
			$query=DB::table('ubale_marketing_registration')->where('district','=',$input['district'])
			->where('ta','=',$input['ta'])
			->where('gvh','=',$input['gvh'])
			->where('village','=',$input['Village'])
			->where('hh_number','=',$input['HH_Number'])
			->where('hh_member_number','=',$input['HH_Member_Number'])
			->update(array("position"=>$input['position'],"date_leaving"=>$input['date_leaving']));
			
			if($query){
				return "Successfully Updated";
			}else
			{
				return "Error Updating";
			}

		}
			

	}
	public function silc_reg()
	{
		$input=Input::all();
	if($input['code_dist']!='' && $input['code_ta']!='' && $input['code_gvh'] !=''){
		$tb_Ubale_Join= DB::table('ubale_silc_registration as usr')
		->join('tbl_beneficiary_registration as ben_reg',function($join)
			{
				$join->on('usr.TA','=','ben_reg.TA');
				$join->on('usr.District','=','ben_reg.District');
				$join->on('usr.GVH','=','ben_reg.GVH');
				$join->on('usr.Village','=','ben_reg.Village');
				$join->on('usr.HH_Number','=','ben_reg.HH_Number');
				$join->on('usr.HH_Member_Number','=','ben_reg.HH_Member_Number');

	})
		->join('code_village as vil',function($join){
			$join->on('vil.rec_id','=','usr.village');
		})
		
		->Select('ben_reg.district','ben_reg.ta','ben_reg.gvh','vil.village_name','ben_reg.Village','ben_reg.HH_Number','ben_reg.HH_Member_Number','ben_reg.Name_of_HH_Member','ben_reg.Sex','ben_reg.dob','ben_reg.Age','usr.position','usr.date_joining','usr.date_leaving')
		->where('usr.gvh','=',$input['code_gvh'])
		->where('usr.Silc_group','=',$input['Silc_group'])

	
		->get();

		$arr=array();

		foreach ($tb_Ubale_Join as $memQuery) {
			if ($memQuery->date_leaving=='0000-00-00') {
			 	$strDob='';			 	
			 }
			 $memQuery->date_leaving=str_replace('-','/',$strDob);

		array_push($arr,$memQuery);
		}



		return json_encode($arr);
	}
}

public function market_reg()
	{
		$input=Input::all();
	if($input['code_dist']!='' && $input['code_ta']!='' && $input['code_gvh'] !=''){
		$tb_Ubale_Join= DB::table('ubale_marketing_registration as usr')
		->join('tbl_beneficiary_registration as ben_reg',function($join)
			{
				$join->on('usr.TA','=','ben_reg.TA');
				$join->on('usr.District','=','ben_reg.District');
				$join->on('usr.GVH','=','ben_reg.GVH');
				$join->on('usr.Village','=','ben_reg.Village');
				$join->on('usr.HH_Number','=','ben_reg.HH_Number');
				$join->on('usr.HH_Member_Number','=','ben_reg.HH_Member_Number');

	})
		->join('code_village as vil',function($join){
			$join->on('vil.rec_id','=','usr.village');
		})
		
		->Select('ben_reg.district','ben_reg.ta','ben_reg.gvh','vil.village_name','ben_reg.Village','ben_reg.HH_Number','ben_reg.HH_Member_Number','ben_reg.Name_of_HH_Member','ben_reg.Sex','ben_reg.dob','ben_reg.Age','usr.position','usr.date_joining')
		->where('usr.gvh','=',$input['code_gvh'])
		->where('usr.market_club','=',$input['market_club'])

	
		->get();

		return json_encode($tb_Ubale_Join);
	}
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


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
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
