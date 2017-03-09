<?php

use Carbon\Carbon;


class dinerController extends \BaseController {

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
		return View::make('cmis/agriculture/diner/index',array('dist_options'=>$dist_options))->with('dist',$dist)->with('adminRole',$admin_role);
	}


	//code for market
	public function market()
	{
		$my_dist=Auth::user()->dist_id;
		$admin_role=Auth::user()->is_admin;
		$input=Input::all();
		return DB::table('diner_markets')
		
		->where('rec_id_ta','=',$input['id'])
		
		->Select('rec_id','market_name')
		->get();
	}

	//code for epa's
	public function epa()
	{
		//$my_dist=Auth::user()->dist_id;
		//$admin_role=Auth::user()->is_admin;
		$input=Input::all();
		$dbRes=DB::table('ubale_epa')
		->where('rec_id_district','=',$input['id'])
		->Select('rec_id','epa_name','epa_code','rec_id_district')
		->get();
		return Response::json($dbRes)->setCallback(Input::get('callback'));;
	}

	public function section()
	{
		//$my_dist=Auth::user()->dist_id;
		//$admin_role=Auth::user()->is_admin;
		$input=Input::all();
		$dbRes=DB::table('ubale_section')
		->Select('rec_id','Section_name','section_code','Rec_Id_EPA','district')
		->get();
		return Response::json($dbRes)->setCallback(Input::get('callback'));;
	}

	public function saveDinerBen(){
		$input=Input::only('District','TA','GVH','Village','HH_Number','HH_Member_Number','market','epa','date_registration');

		$date= Carbon::createFromFormat('d/m/Y',$input['date_registration']);
		$input['date_registration']=$date->format('Y-m-d');
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
		$chkHH=DB::table('ubale_diner')
		->where('district','=',$input['District'])
		->where('ta','=',$input['TA'])
		->where('gvh','=',$input['GVH'])
		->where('village','=',$input['Village'])
		->where('hh_number','=',$input['HH_Number'])
		->where(function($query) use ($year){
			$query->where('year','=',$year)
			->orWhere('year','>',$year);
		})
		->get();

		if(count($chkHH)>0){
			return json_encode(array('errorMsg'=>'HouseHold already Exist in Diner Fairs - Check the Details'));

		}else{

			if($input['market']<1){
				return json_encode(array('errorMsg'=>'No Market Selected'));
			
			}else{
				$query=DB::table('ubale_diner')->insert($input);

				$query2=DB::table('tbl_beneficiary_registration')
				->where('district','=',$input['District'])
				->where('ta','=',$input['TA'])
				->where('gvh','=',$input['GVH'])
				->where('village','=',$input['Village'])
				->where('hh_number','=',$input['HH_Number'])
				->where('hh_member_number','=',$input['HH_Member_Number'])				
				->update(array('diner'=>'1'));
			
			}

		}
		if($query){
			return json_encode(array('successMsg'=>'Successfully added saveBeneficiary to DiNer Fairs'));
		}
		
	}else{
		
		return json_encode(array('errorMsg'=>'Error Occured | Moved out or Deceased | Beneficiary Not Added to Diners Fairs'));
		//return json_encode($chkMain);
		
	}

		
	}

	public function diner_reg(){
		$input=Input::all();
	if($input['code_dist']!='' && $input['code_ta']!='' && $input['code_gvh'] !=''){
		$tb_Ubale_Join= DB::table('ubale_diner as diner_ben')
		->join('tbl_beneficiary_registration as ben_reg',function($join)
			{
				$join->on('diner_ben.TA','=','ben_reg.TA');
				$join->on('diner_ben.District','=','ben_reg.District');
				$join->on('diner_ben.GVH','=','ben_reg.GVH');
				$join->on('diner_ben.Village','=','ben_reg.Village');
				$join->on('diner_ben.HH_Number','=','ben_reg.HH_Number');
				$join->on('diner_ben.HH_Member_Number','=','ben_reg.HH_Member_Number');

	})
		->join('code_village as vil',function($join){
			$join->on('vil.rec_id','=','diner_ben.village');
		})
		->join('diner_markets as diner_market',function($join){
			$join->on('diner_ben.market','=','diner_market.rec_id');
		})
		->Select('ben_reg.district','ben_reg.ta','ben_reg.gvh','diner_ben.epa as epa_number','diner_market.market_name','vil.village_name','ben_reg.Village','ben_reg.HH_Number','ben_reg.HH_Member_Number','ben_reg.Name_of_HH_Member','ben_reg.Sex','ben_reg.Age','ben_reg.dob','diner_ben.market','diner_ben.epa')
		->where('diner_ben.gvh','=',$input['code_gvh'])
		->where('diner_ben.market','=',$input['market'])

	
		->get();

		
	
	}
	if($tb_Ubale_Join){
     	return json_encode($tb_Ubale_Join);
     }
     else{
     	return "Some error Occured";
     }
	}

	public function codesEpa(){
		$input=Input::all();

		$query=DB::table('ubale_epa')->insert($input);

		If($query){
			return json_encode(array('successMsg'=>'Successfully added EPA to DiNer Fairs'));
		}else{
			return json_encode(array('errorMsg'=>'Failed to added EPA to DiNer Fairs'));
		}

	}

	public function codesMarket(){
		$input=Input::all();

		$query=DB::table('diner_markets')->insert($input);

		If($query){
			return json_encode(array('successMsg'=>'Successfully added Market to DiNer Fairs'));
		}else{
			return json_encode(array('errorMsg'=>'Failed to added Market to DiNer Fairs'));
		}

	}



	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function demoplot()
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
				 
		 
	
		return View::make('cmis/agriculture/demoplots/index')->with('dist',$dist)->with('adminRole',$admin_role);
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
