<?php

class PasswordController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	public function remind()
	{
		//
		//$userName = Auth::user()->username;
		$adminRole=0;
		$adminDist=0;

		if($adminRole==1 && $adminDist==0 ){
			$dist=DB::table('code_district');
		}else{
			$dist=DB::table('code_district')->where('rec_id','=',$adminDist);
		}
		 return View::make('user.remind')->with('adminRole',$adminRole);
	}

	public function request()
	{
	  $credentials = array('email' => Input::get('email'), 'password' => Input::get('password'));
	  return Password::remind($credentials);
	  
	}



}
