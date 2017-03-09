<?php

use Carbon\Carbon;

class Household extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /household
	 *
	 * @return Response
	 */
	public function chkhh(){
		$input=Input::get('newhhid');
		$cod_vil=Input::get('vilSel');
		$cod_gvh=Input::get('gvhSel');
		$chkFound=DB::table('tbl_beneficiary_registration')->where('hh_number','=',$input)
		->where('GVH','=',$cod_gvh)
		->where('village','=',$cod_vil)		
		->get();
		if(count($chkFound)>0){
			return json_encode(array('data'=>'1'));
		}else{
			return json_encode( array('data'=>'0'));
		}
		
	}
	public function hhdetails(){
		$cod_vil=Input::get('code_village');
		$cod_gvh=Input::get('code_gvh');
		$cod_ta=Input::get('code_ta');
		$cod_dist=Input::get('code_dist');
		$search_id=Input::get('hh_number');
		$editHH=Input::get('editHH');
		$editTa=Input::get('taEdit');
		$gvhEdit=Input::get('gvhEdit');
		$vilEdit=Input::get('vilEdit');

		
		$pages=Input::get('page');
		$rowsRes=Input::get('rows');
		$page=isset($pages)?intval($pages):1;
		$rows=isset($rowsRes)?intval($rowsRes):10;
		$offset=($page-1)*$rows;



	if($editTa==1 && $cod_dist!='') {
		return DB::table('code_ta')
		->where('Rec_Id_District','=',$cod_dist)
		->get();
	}
	if ($gvhEdit==1) {
		return DB::table('code_gvh')
		->where('Rec_Id_TA','=',$cod_ta)
		->get();
	}
	if ($vilEdit==1) {
		return DB::table('code_village')
		->where('Rec_id_GVH','=',$cod_gvh)
		->get();
	}

    if($search_id=='' && $editHH=='' ) {
    	$counts=$dbRes= DB::table('tbl_beneficiary_registration')
		->where('district','=',$cod_dist)
		->where('ta','=',$cod_ta)
		->where('gvh','=',$cod_gvh)
		->where('village','=',$cod_vil)
		->Where('hh_member_number','=','01')
		->where('active','=','1')->count();

		//$limit=$counts-$offset;
		$result['total']=$counts;


    	 $dbRes= DB::table('tbl_beneficiary_registration')
		->where('district','=',$cod_dist)
		->where('ta','=',$cod_ta)
		->where('gvh','=',$cod_gvh)
		->where('village','=',$cod_vil)
		->Where('hh_member_number','=','01')
		->where('active','=','1')
		->Select('WALA_ID','UBALE_ID','Partner','District','TA','GVH','Village','HH_Number','HH_Member_Number','Name_of_HH_member','Age','Sex','Ben_Reg_date','head_h','status','dob','hh_size','comments','active')
		->take($rows)
		->skip($offset)		
		->get();
		
		$rows=array();
		foreach ( $dbRes as $dbRe ) {

			
				array_push($rows,$dbRe);

		}
		$result["rows"]=$rows;
	
	return json_encode($result);

    }elseif ($search_id!='' && $editHH==''){
    	return DB::table('tbl_beneficiary_registration')
		->where('district','=',$cod_dist)
		->where('ta','=',$cod_ta)
		->where('gvh','=',$cod_gvh)
		->where('village','=',$cod_vil)
		->where('hh_number','=',$search_id)
		->where('hh_member_number','=','01')
		->where('active','=','1')
		->orWhere('head_h','=','01')
		->get();
	}elseif ($editHH!='') {
		
		$mQuery=DB::table('tbl_beneficiary_registration')
		->where('ta','=',$cod_ta)
		->where('gvh','=',$cod_gvh)
		->where('village','=',$cod_vil)
		->where('hh_number','=',$editHH)
		->where('active','=','1')
		->Select('WALA_ID','UBALE_ID','Partner','District','TA','GVH','Village','HH_Number','HH_Member_Number','Name_of_HH_member','Age','Sex','Ben_Reg_date','head_h','status','dob','hh_size','comments','active')
		->get();
		$arr=array();

		foreach ($mQuery as $memQuery) {
			if($memQuery->dob!='0000-00-00'){
				$strDob=date("d-m-Y",strtotime($memQuery->dob));
			 }elseif ($memQuery->dob=='0000-00-00') {
			 	$strDob='';
			 	
			 }
			 $memQuery->dob=str_replace('-','/',$strDob);
			$memQuery->Ben_Reg_date= str_replace('-', '/', date("d-m-Y",strtotime($memQuery->Ben_Reg_date)));

		array_push($arr,$memQuery);
		}

		return json_encode($arr);

	}


	
	
}




public function saveHH(){
	$input=Input::all();
	$cod_vil=Input::get('code_village');
		$cod_gvh=Input::get('code_gvh');
		$cod_ta=Input::get('code_ta');
		$cod_dist=Input::get('code_dist');
		$partner=Auth::user()->dist_id;
		$search_id=Input::get('hh_number');

	//capture the date and convert for Mysql to store
	if($input['Ben_Reg_date']!=''){
		$date= Carbon::createFromFormat('d/m/Y',$input['Ben_Reg_date']);
		$input['Ben_Reg_date']=$date->format('Y-m-d');
	}
	if($input['dob']!=''){
			$date= Carbon::createFromFormat('d/m/Y',$input['dob']);
			$input['dob']=$date->format('Y-m-d');

	}
	$addhh=DB::table('tbl_beneficiary_registration')
		->where('district','=',$cod_dist)
		->where('ta','=',$cod_ta)
		->where('gvh','=',$cod_gvh)
		->where('village','=',$cod_vil)
		->where('hh_number','=',$search_id)
		->get();
     if(count($addhh)<=0){
     	//add partner code
     	$input["partner"]=$partner;
     	if(strlen($input["HH_Number"]<4)){
     		$input["HH_Number"]=str_pad($input["HH_Number"], 4,'0',STR_PAD_LEFT);
     	}

     	$input["UBALE_ID"]=$input["district"].$input["ta"].$input["gvh"].$input["village"].$input["HH_Number"];

       $query=DB::table('tbl_beneficiary_registration')->insert($input);

     	  //return ($input);
		if ($query){
			return json_encode(array(
				'hh_number'=>$query['hh_Number'],
				'hhh_Name'=>$query['hhh_name'],
				'hh_size'=>$query['hh_size'],
				'hh_sex'=>$query['hh_sex'],
				'hhh_age'=>$query['hhh_age']
			));
		} else {
			return json_encode(array('errorMsg'=>'Some errors occured.'));
		}
	}else{
		return json_encode(array('errorMsg'=>'HouseHold Member Already Exists.'));
	}
	

}	

public function updateHH(){
	$input=Input::except('editing','partner');
	$hh_editing=input::get('editing');
	$partner=Auth::user()->dist_id;
	//capture the date and convert for Mysql to store
	$conDat=str_replace('/', '-', $input['Ben_Reg_date']);
	$input['Ben_Reg_date']= date("Y-m-d",strtotime($conDat));
	
	if($input['dob']!=''){

		$date= Carbon::createFromFormat('d/m/Y',$input['dob']);
			$input['dob']=$date->format('Y-m-d');
	}else{
		$input['dob']="1900-1-1";
	}	


$addQuery=DB::table('tbl_beneficiary_registration')
	->where('District','=',$input['District'])
	->where('TA','=',$input['TA'])
	->where('GVH','=',$input['GVH'])
	->where('Village','=',$input['Village'])
	->where('HH_Number','=',$input['HH_Number'])
	->where('HH_Member_Number','=',$input['HH_Member_Number'])->get();

	if(count($addQuery)>0){
		
	if($input['HH_Member_Number']!='' && $hh_editing){
		$query1=DB::table('tbl_beneficiary_registration')
		->where('District','=',$input['District'])
		->where('TA','=',$input['TA'])
		->where('GVH','=',$input['GVH'])
		->where('Village','=',$input['Village'])
		->where('HH_Number','=',$input['HH_Number'])
		->where('head_h','=',1)->get();
		
		if(count($query1)>0){
			foreach ($query1 as $UpQuer) 
			{

				if ($UpQuer->head_h==$input['head_h']){
					$input['head_h']=1;
				}else{
					$input['head_h']=0;
				}
			}
		}
			
		

   	$query=DB::table('tbl_beneficiary_registration')
		->where('District','=',$input['District'])
		->where('TA','=',$input['TA'])
		->where('GVH','=',$input['GVH'])
		->where('Village','=',$input['Village'])
		->where('HH_Number','=',$input['HH_Number'])
		->where('HH_Member_Number','=',$input['HH_Member_Number'])
		->update($input);
		if ($query){
			return json_encode(array('errorMsg'=>'Successfully updated'));
		} else {
			return json_encode(array('errorMsg'=>'Some errors occured.'));
		}
		
	
	}
}
	else{
		$input["partner"]=$partner;
     	if(strlen($input["HH_Number"]<4)){
     		$input["HH_Number"]=str_pad($input["HH_Number"], 4,'0',STR_PAD_LEFT);
     	}

     	$input["UBALE_ID"]=$input["District"].$input["TA"].$input["GVH"].$input["Village"].$input["HH_Number"];
		
		$query=DB::table('tbl_beneficiary_registration')
		->where('District','=',$input['District'])
		->where('TA','=',$input['TA'])
		->where('GVH','=',$input['GVH'])
		->where('Village','=',$input['Village'])
		->where('HH_Number','=',$input['HH_Number'])
		->insert($input);
		if ($query){
			return json_encode(array(
				'HH_Number'=>$query['HH_Number'],
				'HH_Member_Name'=>$query['HH_Member_Name'],
				'hh_size'=>$query['hh_size'],
				'hh_sex'=>$query['hh_sex'],
				'hhh_age'=>$query['hhh_age'],
				'hh_reg_date'=>$query['hh_reg_date']
			));
		}
		//return $input['head_h'];



	
	}

}



public function household(){
		$my_dist=Auth::user()->dist_id;
		$userName = Auth::user()->username;
		$admin_role=Auth::user()->is_admin;
		$adminRole=Auth::user()->is_admin;
		
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

		return View::make('cmis/household/index',array('dist_options'=>$dist_options))->with('dist',$dist)->with('userName',$userName)->with('adminRole',$adminRole);
		
	}

	public function export(){
		 $households = DB::table('ubale_hh_trans_details_insert');
		 $households_update=DB::table('ubale_hh_trans_details_insert')->get();
          $headers = [
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0'
        ,   'Content-type'        => 'text/csv'
        ,   'Content-Disposition' => 'attachment; filename=galleries.csv'
        ,   'Expires'             => '0'
        ,   'Pragma'              => 'public'
    ];

  foreach ($households as $key => $househ) {
  	$arr=$househ;
  }

   /*array_unshift($arr, array_keys($arr[0]));
    $file = fopen('file.csv', 'w');
    foreach ($arr as $row) {
        fputcsv($file, $row->toArray()); 
    }
    fclose($file);
    return Redirect::to('consolidated');
    */
    return $households;
	}


	public function index(){

	}


	public function destroy()
	{
		$input=Input::get('id');
		return json_encode($input);
		//DB::table('users')->where('votes', '<', 100)->delete();


	}




}