<?php

class AdminController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /admin
	 *
	 * @return Response
	 */

	//function for bigdump
	public function bigdump(){
		return  View::make('cmis/dump/bigdump');

	}

	public function content(){
		$userName = Auth::user()->username;
		$adminRole=Auth::user()->is_admin;
		$adminDist=Auth::user()->dist_id;
		return View::make('cmis/reports/reportMenu')->with('userName',$userName)->with('adminRole',$adminRole);
	}

	public function purp1(){
		$userName = Auth::user()->username;
		$adminRole=Auth::user()->is_admin;
		$adminDist=Auth::user()->dist_id;
		return View::make('cmis/reports/purp1')->with('userName',$userName)->with('adminRole',$adminRole);
	}
	public function purp2(){
		$userName = Auth::user()->username;
		$adminRole=Auth::user()->is_admin;
		$adminDist=Auth::user()->dist_id;
		return View::make('cmis/reports/purp2')->with('userName',$userName)->with('adminRole',$adminRole);
	}
	public function purp3(){
		$userName = Auth::user()->username;
		$adminRole=Auth::user()->is_admin;
		$adminDist=Auth::user()->dist_id;
		return View::make('cmis/reports/purp3')->with('userName',$userName)->with('adminRole',$adminRole);
	}
	public function index()
	{
		//
		$userName = Auth::user()->username;
		$adminRole=Auth::user()->is_admin;
		$adminDist=Auth::user()->dist_id;

		if($adminRole==1 && $adminDist==0 ){
			$dist=DB::table('code_district');
		}else{
			$dist=DB::table('code_district')->where('rec_id','=',$adminDist);
		}
				 $firstItem=array('0'=>'Select');
		 if(!empty($dist)){
		 	$firstItem=array('0'=>'Select');
		 		$dist_options=$dist->lists('district_name','rec_id');
		 		$dist_options=$firstItem+$dist_options;

		}else{
			$dist_options=array('Select'=>'Please Select');
		}
		return  View::make('cmis/admin/index',array('dist_options'=>$dist_options))->with('userName',$userName)->with('adminRole',$adminRole)->with('dist_options',$dist_options);
	}
	public function codes()
	{
		//
		$userName = Auth::user()->username;
		$adminRole=Auth::user()->is_admin;
		$adminDist=Auth::user()->dist_id;

		if($adminRole==1 && $adminDist==0 ){
			$dist=DB::table('code_district');
		}else{
			$dist=DB::table('code_district')->where('rec_id','=',$adminDist);
		}
				 $firstItem=array('0'=>'Select');
		 if(!empty($dist)){
		 	$firstItem=array('0'=>'Select');
		 		$dist_options=$dist->lists('district_name','rec_id');
		 		$dist_options=$firstItem+$dist_options;

		}else{
			$dist_options=array('Select'=>'Please Select');
		}

		
		return View::make('cmis/admin/codes',array('dist_options'=>$dist_options))->with('userName',$userName)->with('adminRole',$adminRole)->with('data-options',$dist_options);
	}



	public function ubale_cutoff()
	{
		$userName = Auth::user()->username;
		$adminRole=Auth::user()->is_admin;
		$adminDist=Auth::user()->dist_id;
		if($adminRole==1 && $adminDist==0 ){
			$dist=DB::table('code_district');
		}else{
			$dist=DB::table('code_district')->where('rec_id','=',$adminDist);
		}
				 $firstItem=array('0'=>'Select');
		 if(!empty($dist)){
		 	$firstItem=array('0'=>'Select');
		 		$dist_options=$dist->lists('district_name','rec_id');
		 		$dist_options=$firstItem+$dist_options;

		}else{
			$dist_options=array('Select'=>'Please Select');
		}

		return View::make('cmis/admin/codesCO',array('dist_options'=>$dist_options))->with('userName',$userName)->with('adminRole',$adminRole);

	}

	public function ubale_fy()
	{

		$userName = Auth::user()->username;
		$adminRole=Auth::user()->is_admin;
		$adminDist=Auth::user()->dist_id;
		if($adminRole==1 && $adminDist==0 ){
			$dist=DB::table('code_district');
		}else{
			$dist=DB::table('code_district')->where('rec_id','=',$adminDist);
		}
				 $firstItem=array('0'=>'Select');
		 if(!empty($dist)){
		 	$firstItem=array('0'=>'Select');
		 		$dist_options=$dist->lists('district_name','rec_id');
		 		$dist_options=$firstItem+$dist_options;

		}else{
			$dist_options=array('Select'=>'Please Select');
		}

		return View::make('cmis/admin/codesfy',array('dist_options'=>$dist_options))->with('userName',$userName)->with('adminRole',$adminRole);


	}

	/**
	 * Show the form for creating a new resource.
	 * GET /admin/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /admin
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /admin/{id}
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
	 * GET /admin/{id}/edit
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
	 * PUT /admin/{id}
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
	 * DELETE /admin/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}