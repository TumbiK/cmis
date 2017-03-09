<?php

class groupController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	

	public function acpc()
	{
		$my_dist=Auth::user()->dist_id;
		$admin_role=Auth::user()->is_admin;
		//check to see if the user role is admin and for the PMU with district=0 and load equivalent values
		
		return View::make('cmis/groupReg/acpc')->with('adminRole',$admin_role);

	}

	public function acpcSel(){
		$input=Input::all();

		$my_dist=Auth::user()->dist_id;
		$query=DB::table('ubale_acpc')
		->where('ta','=',$input['id'])
		
		->get();

		return json_encode($query);
	}

	public function adcSel(){
		$input=Input::all();

		$my_dist=Auth::user()->dist_id;
		$query=DB::table('ubale_adc')
		->where('ta','=',$input['id'])
		
		->get();

		return json_encode($query);
	}

	public function vdcSel(){
		$input=Input::all();

		$my_dist=Auth::user()->dist_id;
		$query=DB::table('ubale_vdc')
		->where('gvh','=',$input['id'])
		
		->get();

		return json_encode($query);
	}



	public function vcpcSel(){
		$input=Input::all();

		$my_dist=Auth::user()->dist_id;
		$query=DB::table('ubale_vcpc')
		->where('gvh','=',$input['id'])
		
		->get();

		return json_encode($query);
	}

	public function vnrmcSel(){
		$input=Input::all();

		$my_dist=Auth::user()->dist_id;
		$query=DB::table('ubale_vnrmc')
		->where('gvh','=',$input['id'])
		
		->get();

		return json_encode($query);
	}

	public function youthclubSel(){
	$input=Input::all();

		$my_dist=Auth::user()->dist_id;
		$query=DB::table('ubale_youthclub')
		->where('gvh','=',$input['id'])
		->get();

		return json_encode($query);

	}

	public function vnrmc(){
		$my_dist=Auth::user()->dist_id;
		$admin_role=Auth::user()->is_admin;
		//check to see if the user role is admin and for the PMU with district=0 and load equivalent values
		
		return View::make('cmis/groupReg/vnrmc')->with('adminRole',$admin_role);
	}
	public function adc(){
		$my_dist=Auth::user()->dist_id;
		$admin_role=Auth::user()->is_admin;
		//check to see if the user role is admin and for the PMU with district=0 and load equivalent values
		
		return View::make('cmis/groupReg/adc')->with('adminRole',$admin_role);
	}

	public function youthClub(){
		$my_dist=Auth::user()->dist_id;
		$admin_role=Auth::user()->is_admin;
		//check to see if the user role is admin and for the PMU with district=0 and load equivalent values
		
		return View::make('cmis/groupReg/youthClub')->with('adminRole',$admin_role);

	}

	public function acpc_reg(){
		$input=Input::all();
		

		$query=DB::table('ubale_acpc as acpc')
		->join('ubale_acpc_register as acpcReg',function($join)
			{
				$join->on('acpc.acpc_number','=','acpcReg.acpc_number');
				
	   })
		->join('tbl_beneficiary_registration as benReg',function($join)
			{
				$join->on('acpc.district','=','benReg.district');
				$join->on('acpc.ta','=','benReg.ta');
				
				$join->on('acpcReg.village','=','benReg.village');
				$join->on('acpcReg.hh_number','=','benReg.hh_number');
				$join->on('acpcReg.hh_member_number','=','benReg.hh_member_number');
				
	   })
		->join('code_gvh as cgvh',function($join)
		{
			$join->on('benReg.gvh','=','cgvh.rec_id');
		})
		->join('code_village as cvil',function($join)
		{
			$join->on('benReg.village','=','cvil.rec_id');
		})
		->select('cvil.village_name','cgvh.gvh_name','benReg.hh_number','benReg.Name_of_HH_Member','benReg.hh_number','benReg.hh_member_number','benReg.sex','benReg.dob','benReg.Age','acpcReg.date_join','acpcReg.position','acpcReg.date_leaving')
		->where('acpc.ta','=',$input['code_ta'])
		->where('acpc.district','=',$input['code_dist'])
		->get();

		return json_encode($query);


	}

	public function vdc_reg(){
		$input=Input::all();
		//$input['date_join']=date('Y-m-d', strtotime($input['date_join']));

		$query=DB::table('ubale_vdc as vdc')
		->join('ubale_vdc_register as vdcReg',function($join)
			{
				$join->on('vdc.vdc_number','=','vdcReg.vdc_number');
				
	   })
		->join('tbl_beneficiary_registration as benReg',function($join)
			{
				$join->on('vdc.district','=','benReg.district');
				$join->on('vdc.ta','=','benReg.ta');
				$join->on('vdc.gvh','=','benReg.gvh');
				$join->on('vdcReg.village','=','benReg.village');
				$join->on('vdcReg.hh_number','=','benReg.hh_number');
				$join->on('vdcReg.hh_member_number','=','benReg.hh_member_number');
				
	   })
		->join('code_gvh as cgvh',function($join)
		{
			$join->on('benReg.gvh','=','cgvh.rec_id');
		})
		->join('code_village as cvil',function($join)
		{
			$join->on('benReg.village','=','cvil.rec_id');
		})
		->select('cvil.village_name','cgvh.gvh_name','benReg.hh_number','benReg.Name_of_HH_Member','benReg.sex','benReg.dob','benReg.hh_number','benReg.hh_member_number','benReg.Age','vdcReg.date_join','vdcReg.position','vdcReg.date_leaving')
		->where('vdc.ta','=',$input['code_ta'])
		->where('vdc.district','=',$input['code_dist'])
		->where('vdcReg.vdc_number','=',$input['code_village'])
		->get();

		return json_encode($query);


	}

	public function vcpc_reg(){
		$input=Input::all();
   

		$query=DB::table('ubale_vcpc as vcpc')
		->join('ubale_vcpc_register as vcpcReg',function($join)
			{
				$join->on('vcpc.vcpc_number','=','vcpcReg.vcpc_number');
				
	   })
		->join('tbl_beneficiary_registration as benReg',function($join)
			{
				$join->on('vcpcReg.village','=','benReg.village');
				$join->on('vcpcReg.hh_number','=','benReg.hh_number');
				$join->on('vcpcReg.hh_member_number','=','benReg.hh_member_number');
				
	   })
		->join('code_gvh as cgvh',function($join)
		{
			$join->on('benReg.gvh','=','cgvh.rec_id');
		})
		->join('code_village as cvil',function($join)
		{
			$join->on('benReg.village','=','cvil.rec_id');
		})
		->select('cvil.village_name','cgvh.gvh_name','benReg.hh_number','benReg.Name_of_HH_Member','benReg.sex','benReg.dob','benReg.Age','benReg.hh_number','benReg.hh_member_number','vcpcReg.date_join','vcpcReg.position','vcpcReg.date_leaving')
		->where('vcpc.ta','=',$input['code_ta'])
		->where('vcpc.district','=',$input['code_dist'])
		->where('vcpcReg.vcpc_number','=',$input['code_village'])
		->get();


		return json_encode($query);


	}


	public function vnrmc_reg(){
		$input=Input::all();


		$query=DB::table('ubale_vnrmc as vnrmc')
		->join('ubale_vnrmc_register as vnrmcReg',function($join)
			{
				$join->on('vnrmc.vnrmc_number','=','vnrmcReg.vnrmc_number');
				
	   })
		->join('tbl_beneficiary_registration as benReg',function($join)
			{
				$join->on('vnrmc.district','=','benReg.district');
				$join->on('vnrmc.ta','=','benReg.ta');
				$join->on('vnrmc.gvh','=','benReg.gvh');
				$join->on('vnrmcReg.village','=','benReg.village');
				$join->on('vnrmcReg.hh_number','=','benReg.hh_number');
				$join->on('vnrmcReg.hh_member_number','=','benReg.hh_member_number');
				
	   })
		->join('code_gvh as cgvh',function($join)
		{
			$join->on('benReg.gvh','=','cgvh.rec_id');
		})
		->join('code_village as cvil',function($join)
		{
			$join->on('benReg.village','=','cvil.rec_id');
		})
		->select('cvil.village_name','cgvh.gvh_name','benReg.hh_number','benReg.Name_of_HH_Member','benReg.sex','benReg.dob','benReg.Age','benReg.hh_number','benReg.hh_member_number','vnrmcReg.date_join','vnrmcReg.position','vnrmcReg.date_leaving')
		->where('vnrmc.ta','=',$input['code_ta'])
		->where('vnrmc.gvh','=',$input['code_gvh'])
		->where('vnrmc.district','=',$input['code_dist'])
		->get();

		return json_encode($query);


	}

	//ubale youthclub reg
public function youthclub_reg(){
		$input=Input::all();


		$query=DB::table('ubale_youthclub as youthclub')
		->join('ubale_youthclub_register as ycReg',function($join)
			{
				$join->on('youthclub.youthclub_number','=','ycReg.youthclub_number');
				
	   })
		->join('tbl_beneficiary_registration as benReg',function($join)
			{
				$join->on('youthclub.district','=','benReg.district');
				$join->on('youthclub.ta','=','benReg.ta');
				$join->on('youthclub.gvh','=','benReg.gvh');
				$join->on('ycReg.village','=','benReg.village');
				$join->on('ycReg.hh_number','=','benReg.hh_number');
				$join->on('ycReg.hh_member_number','=','benReg.hh_member_number');
				
	   })
		->join('code_gvh as cgvh',function($join)
		{
			$join->on('benReg.gvh','=','cgvh.rec_id');
		})
		->join('code_village as cvil',function($join)
		{
			$join->on('benReg.village','=','cvil.rec_id');
		})
		->select('cvil.village_name','cgvh.gvh_name','benReg.hh_number','benReg.Name_of_HH_Member','benReg.sex','benReg.dob','benReg.Age','benReg.hh_number','benReg.hh_member_number','ycReg.date_join','ycReg.position','ycReg.date_leaving')
		->where('youthclub.ta','=',$input['code_ta'])
		->where('youthclub.gvh','=',$input['code_gvh'])
		->where('youthclub.district','=',$input['code_dist'])
		->get();

		return json_encode($query);


	}



	//ubale adc reg
public function adc_reg(){
		$input=Input::all();


		$query=DB::table('ubale_adc as adc')
		->join('ubale_adc_register as adcReg',function($join)
			{
				$join->on('adc.adc_number','=','adcReg.adc_number');
				
	   })
		->join('tbl_beneficiary_registration as benReg',function($join)
			{
				$join->on('adc.district','=','benReg.district');
				$join->on('adc.ta','=','benReg.ta');
				
				$join->on('adcReg.village','=','benReg.village');
				$join->on('adcReg.hh_number','=','benReg.hh_number');
				$join->on('adcReg.hh_member_number','=','benReg.hh_member_number');
				
	   })
		->join('code_gvh as cgvh',function($join)
		{
			$join->on('benReg.gvh','=','cgvh.rec_id');
		})
		->join('code_village as cvil',function($join)
		{
			$join->on('benReg.village','=','cvil.rec_id');
		})
		->select('cvil.village_name','cgvh.gvh_name','benReg.hh_number','benReg.Name_of_HH_Member','benReg.sex','benReg.dob','benReg.Age','benReg.hh_number','benReg.hh_member_number','adcReg.date_join','adcReg.position','adcReg.date_leaving')
		->where('adc.ta','=',$input['code_ta'])
		->where('adc.district','=',$input['code_dist'])
		->get();

		return json_encode($query);


	}
//Save ACPC Members
	public function saveAcpBeneficiary()
	{
		$input=Input::only('HH_Number','HH_Member_Number','village','acpc_number','Position','date_join','date_leaving');
		$input['date_join']=date('Y-m-d', strtotime($input['date_join']));

		$query=DB::table('ubale_acpc_register')->insert($input);
		if($query){
				return json_encode(array('successMsg'=>'Successfully Added ACPC Details'));
			}
			else{
				return json_encode(array('errorMsg'=>'Some Error Occured'));
			}
	}
//Save VDC Members
	public function saveVdcBeneficiary()
	{
		$input=Input::only('HH_Number','HH_Member_Number','village','vdc_number','Position','date_join','date_leaving');
		$conDat=str_replace('/', '-', $input['date_join']);
		$input['date_join']=date('Y-m-d', strtotime($conDat));

		$query=DB::table('ubale_vdc_register')->insert($input);
		if($query){
				return json_encode(array('successMsg'=>'Successfully Added VDC Details'));
			}
			else{
				return json_encode(array('errorMsg'=>'Some Error Occured'));
			}
	}

//Save ADC Members
	public function saveAdcBeneficiary()
	{
		$input=Input::only('HH_Number','HH_Member_Number','village','adc_number','Position','date_join','date_leaving');
		$input['date_join']=date('Y-m-d', strtotime($input['date_join']));

		$query=DB::table('ubale_adc_register')->insert($input);
		if($query){
				return json_encode(array('successMsg'=>'Successfully Added VDC Details'));
			}
			else{
				return json_encode(array('errorMsg'=>'Some Error Occured'));
			}
	}

//Save VCPC Members
   public function saveVcpcBeneficiary()
   {
   		$input=Input::only('HH_Number','HH_Member_Number','village','vcpc_number','Position','date_join','date_leaving');
   		$input['date_join']=date('Y-m-d', strtotime($input['date_join']));

		$query=DB::table('ubale_vcpc_register')->insert($input);
		if($query){
				return json_encode(array('successMsg'=>'Successfully Added VCPC Details'));
			}
			else{
				return json_encode(array('errorMsg'=>'Some Error Occured'));
			}

   }

   //Save VCPC Members
   public function saveVnrmcBeneficiary()
   {
   		$input=Input::only('HH_Number','HH_Member_Number','village','vnrmc_number','Position','date_join','date_leaving');
   		$input['date_join']=date('Y-m-d', strtotime($input['date_join']));

		$query=DB::table('ubale_vnrmc_register')->insert($input);
		if($query){
				return json_encode(array('successMsg'=>'Successfully Added VNRMC Details'));
			}
			else{
				return json_encode(array('errorMsg'=>'Some Error Occured'));
			}

   }


//saveYcBeneficiary
   public function saveYcBeneficiary()
   {
   		$input=Input::only('HH_Number','HH_Member_Number','village','youthclub_number','Position','date_join','date_leaving');
   		$input['date_join']=date('Y-m-d', strtotime($input['date_join']));

		$query=DB::table('ubale_youthclub_register')->insert($input);
		if($query){
				return json_encode(array('successMsg'=>'Successfully Added Youth Club Details'));
			}
			else{
				return json_encode(array('errorMsg'=>'Some Error Occured'));
			}

   }

   //load VCP page
	public function vcpc()
	{
		$my_dist=Auth::user()->dist_id;
		$admin_role=Auth::user()->is_admin;
		//check to see if the user role is admin and for the PMU with district=0 and load equivalent values
		
		return View::make('cmis/groupReg/vcpc')->with('adminRole',$admin_role);
		
	}

	//load VDC Page
	public function vdc()
	{
		$my_dist=Auth::user()->dist_id;
		$admin_role=Auth::user()->is_admin;
		//check to see if the user role is admin and for the PMU with district=0 and load equivalent values
		
		return View::make('cmis/groupReg/vdc')->with('adminRole',$admin_role);
		
	}



	public function save_acpc(){
		$input=Input::all();
		$myPartner=Auth::user()->partner;
		$input['partner']=$myPartner;
		$input['date_reg']=date('Y-m-d', strtotime($input['date_reg']));



		$query=DB::table('ubale_acpc')->insert($input);
		if($query){

			$query2=DB::table('ubale_acpc')->orderby('rec_id','desc')->first();
			$acp_num=str_pad($query2->rec_id, 2, '0', STR_PAD_LEFT).'1'.str_pad($query2->district, 2, '0', STR_PAD_LEFT);
			$query3=DB::table('ubale_acpc')->where('rec_id','=',$query2->rec_id)->update(array("acpc_number"=>$acp_num));
				return json_encode(array('successMsg'=>'Successfully Added ACPC Details'));
			}
			else{
				return json_encode(array('errorMsg'=>'Some Error Occured'));
			}
		}

	
	public function save_adc(){
		$input=Input::all();
		$myPartner=Auth::user()->partner;
		$input['partner']=$myPartner;
		$input['date_reg']=date('Y-m-d', strtotime($input['date_reg']));



		$query=DB::table('ubale_adc')->insert($input);
		if($query){

			$query2=DB::table('ubale_adc')->orderby('rec_id','desc')->first();
			$acp_num=str_pad($query2->rec_id, 2, '0', STR_PAD_LEFT).'6'.str_pad($query2->district, 2, '0', STR_PAD_LEFT);
			$query3=DB::table('ubale_adc')->where('rec_id','=',$query2->rec_id)->update(array("adc_number"=>$acp_num));
				return json_encode(array('successMsg'=>'Successfully Added ADC Details'));
			}
			else{
				return json_encode(array('errorMsg'=>'Some Error Occured'));
			}

	}
	

	public function save_vdc(){
		$input=Input::all();
		$myPartner=Auth::user()->partner;
		$input['partner']=$myPartner;
		$input['date_reg']=date('Y-m-d', strtotime($input['date_reg']));

		$query=DB::table('ubale_vdc')->insert($input);
		if($query){
			$query2=DB::table('ubale_vdc')->orderby('rec_id','desc')->first();
			$acp_num=str_pad($query2->rec_id, 2, '0', STR_PAD_LEFT).'2'.str_pad($query2->district, 2, '0', STR_PAD_LEFT);
			$query3=DB::table('ubale_vdc')->where('rec_id','=',$query2->rec_id)->update(array("vdc_number"=>$acp_num));
				return json_encode(array('successMsg'=>'Successfully Added ACPC Details'));
			}
			else{
				return json_encode(array('errorMsg'=>'Some Error Occured'));
			}

	}

	public function save_vcpc(){
		$input=Input::all();
		$myPartner=Auth::user()->partner;
		$input['partner']=$myPartner;
		$input['date_reg']=date('Y-m-d', strtotime($input['date_reg']));

		$query=DB::table('ubale_vcpc')->insert($input);
		if($query){
				$query2=DB::table('ubale_vcpc')->orderby('rec_id','desc')->first();
				$acp_num=str_pad($query2->rec_id, 2, '0', STR_PAD_LEFT).'3'.str_pad($query2->district, 2, '0', STR_PAD_LEFT);
				$query3=DB::table('ubale_vcpc')->where('rec_id','=',$query2->rec_id)->update(array("vcpc_number"=>$acp_num));
				return json_encode(array('successMsg'=>'Successfully Added VDC Details'));
			}
			else{
				return json_encode(array('errorMsg'=>'Some Error Occured'));
			}

	}


	public function save_vnrmc(){
		$input=Input::all();
		$myPartner=Auth::user()->partner;
		$input['partner']=$myPartner;
		$input['date_reg']=date('Y-m-d', strtotime($input['date_reg']));

		$query=DB::table('ubale_vnrmc')->insert($input);
		if($query){
				$query2=DB::table('ubale_vnrmc')->orderby('rec_id','desc')->first();
				$acp_num=str_pad($query2->rec_id, 2, '0', STR_PAD_LEFT).'4'.str_pad($query2->district, 2, '0', STR_PAD_LEFT);
				$query3=DB::table('ubale_vnrmc')->where('rec_id','=',$query2->rec_id)->update(array("vnrmc_number"=>$acp_num));
				return json_encode(array('successMsg'=>'Successfully Added VNRMC Details'));
			}
			else{
				return json_encode(array('errorMsg'=>'Some Error Occured'));
			}

	}
	
	public function save_youthclub(){
		$input=Input::all();
		$myPartner=Auth::user()->partner;
		$input['partner']=$myPartner;
		$input['date_reg']=date('Y-m-d', strtotime($input['date_reg']));

		$query=DB::table('ubale_youthclub')->insert($input);
		if($query){
				$query2=DB::table('ubale_youthclub')->orderby('rec_id','desc')->first();
				$acp_num=str_pad($query2->rec_id, 2, '0', STR_PAD_LEFT).'5'.str_pad($query2->district, 2, '0', STR_PAD_LEFT);
				$query3=DB::table('ubale_youthclub')->where('rec_id','=',$query2->rec_id)->update(array("youthclub_number"=>$acp_num));
				return json_encode(array('successMsg'=>'Successfully Added Youth Club Details'));
			}
			else{
				return json_encode(array('errorMsg'=>'Some Error Occured'));
			}

	}



}
