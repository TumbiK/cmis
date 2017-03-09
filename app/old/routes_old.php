<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::any("login",["as"=>"user/login","uses"=>"UserController@login"]);

Route::any("/",["as"=>"user/login","uses"=>"UserController@login"]);
Route::any("/dashboard",["as"=>"user/dashboard","uses"=>"UserController@dashboard"]);
Route::any("/household",["as"=>"user/household","uses"=>"UserController@household"]);
Route::any("report",["as"=>"user/report","uses"=>"reportController@report"]);
Route::any("api/report",["as"=>"api.report","uses"=>"reportController@Datareport"]);

//handling codes
Route::get("gvhSelect",["as"=>"gvhSelect","uses"=>"codes@gvhSel"]);
Route::get("vilSelect",["as"=>"vilSelect","uses"=>"codes@vilSel"]);




Route::get('gvh',function(){
	//$input=Input::get('ta');
		$input=Input::get('id');
	$DispGVH=DB::table('gvh')->where('taid','=',$input)->lists('name','id');
	return Response::json($DispGVH);
});


/*Route::get('gvhSelect',function(){
	
		$input=Input::get('taSel');
	$DispGVH=DB::table('code_gvh')->where('rec_id_ta','=',$input)->lists('gvh_name','rec_id');
	return Response::json($DispGVH);
});

Route::get('vilSelect',function(){
	
		$input=Input::get('gvhSel');
	$DispGVH=DB::table('code_village')->where('rec_id_gvh','=',$input)->lists('village_name','rec_id');
	return Response::json($DispGVH);
});*/

Route::get('chkhh',function(){
	$input=Input::get('newhhid');
	$chkFound=DB::table('tbl_hh_details')->where('HH_Number','=',$input)->get();
	if(count($chkFound)>1){
		return json_encode(array('data'=>'1'));
	}else{
		return json_encode( array('data'=>'0'));
	}
});

Route::get('hhdetails',function(){
	$cod_vil=Input::get('code_village');
	$cod_gvh=Input::get('code_gvh');
	$cod_ta=Input::get('code_ta');
	$cod_dist=Input::get('code_dist');
	$search_id=Input::get('hh_number');
    if($search_id=='') {
    	return DB::table('tbl_hh_details')
	->where('district','=',$cod_dist)
	->where('TA','=',$cod_ta)
	->where('gvh','=',$cod_gvh)
	->where('village','=',$cod_vil)
	
	->get();
    }else{return DB::table('tbl_hh_details')
	->where('district','=',$cod_dist)
	->where('TA','=',$cod_ta)
	->where('gvh','=',$cod_gvh)
	->where('village','=',$cod_vil)
	->where('hh_number','=',$search_id)
	->get();}
	
	
});


Route::get('save_household',function(){
	$input=Input::all();
	$query=DB::table('tb_ubale_hh_details')->insert($input);
		if ($query){
			return json_encode(array(
				'HH_Number'=>$query['HH_Number'],
				'HHH_Name'=>$query['HHH_Name'],
				'HH_size'=>$query['HH_size'],
				'HH_sex'=>$query['HH_sex'],
				'HHH_age'=>$query['HHH_age']
			));
		} else {
			return json_encode(array('errorMsg'=>'Some errors occured.'));
		}
	





});
Route::get('update_household',function(){

});

Route::get('village',function(){
	$gvhVal=Input::get('Vil');
	$TAVal=Input::get('ta');
	$DistVal=Input::get('dist');

	//$DispVil=DB::table('village')->where('distid','=',$DistVal)->where('taid','=',$TAVal)->where('gid','=',$gvhVal)->lists('name','id');

	$DispVil=DB::table('village')->where('gid','=',$TAVal)->where('taid','=',$TAVal)->where('distid','=',$DistVal)->lists('name','id');

	return Response::json($DispVil);

});

Route::get('reportData',function(){
	$input=Input::get('group');
	$rep=DB::table('household')->where('size','=',$input)->get();
	return Response::json($rep);
	//return $rep;

});


Route::any('logout',["as"=>"user/logout","uses"=>"UserController@logout"]);