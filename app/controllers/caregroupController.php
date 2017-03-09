<?php
use Carbon\Carbon;

class caregroupController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function cg_promoter()
	{
		
		$input=Input::all();

	

		$query=DB::table('cg_promoter')->where('Rec_id_dist','=',$input['id'])->select('rec_id','promoter_name')->get();

		return json_encode($query);
	}

	public function saveCGlead()
	{
		$input=Input::only('District','TA','GVH','Village','HH_Number','HH_Member_Number','Name_of_HH_member','Sex','cg_promo_id');
		$query=DB::table('cg_leader')->insert($input);
		if($query){
			return json_encode(array('successMsg'=>'Successfully added CG Leader'));
	
			}else{		
			return json_encode(array('errorMsg'=>'Error Occured | Failed to Add CG Leader')); 		
			}

	}

	public function cggroup()
	{
		$input=Input::all();
		$query=DB::table('ubale_caregroup')->where('Rec_TA_id','=',$input['id'])->select('cg_number','group_name')->get();
		return json_encode($query);
	}
	public function saveCG()
	{
		$input=Input::all();

		$created = Carbon::createFromFormat('d/m/Y', $input['date_format']);
		$input['date_format']=$created;

		$creatAt = Carbon::createFromFormat('d/m/Y', $input['date_registra']);
		$input['date_registra']=$creatAt;


		
		
		if ($input['date_format']!=''){

			$count=DB::table('ubale_caregroup')->count();
			$input['cg_number']=$input['Rec_id_dist']."".$count;
			$query=DB::table('ubale_caregroup')->insert($input);
			if($query){
			return json_encode(array('successMsg'=>'Successfully added Care Group'));
	
			}else{		
			return json_encode(array('errorMsg'=>'Error Occured | Failed to Add Care Group')); 		
			}
		}

	}
	public function cg_reg()
	{
			$input=Input::all();
	if($input['code_dist']!='' && $input['code_ta']!='' && $input['code_gvh'] !=''){
		$tb_Ubale_Join= DB::table('cg_registration as usr')
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
		
		->Select('ben_reg.district','ben_reg.ta','ben_reg.gvh','vil.village_name','ben_reg.Village','ben_reg.HH_Number','ben_reg.HH_Member_Number','ben_reg.Name_of_HH_Member','ben_reg.Sex','ben_reg.dob','ben_reg.Age','usr.date_joining','usr.date_leaving')
		->where('usr.gvh','=',$input['code_gvh'])
		->where('usr.cg_group','=',$input['cg_number'])

	
		->get();

		return json_encode($tb_Ubale_Join);
	}
}

	public function saveCGBen(){
		$input=Input::only('District','TA','GVH','Village','HH_Number','HH_Member_Number','cg_promo_id','date_joining','cg_group');
		if($input['cg_group'] !='' && $input['cg_promo_id'] !='')
		{


			$created = Carbon::createFromFormat('d/m/Y', $input['date_joining']);
			$input['date_joining']=$created;

			$query=DB::table('cg_registration')->insert($input);
			if($query){
			return json_encode(array('successMsg'=>'Successfully added CG Promoter'));
			}else{		
			return json_encode(array('errorMsg'=>'Error Occured | Failed to add CG Promoter')); 		
			}
		}else{
				return json_encode(array('errorMsg'=>'Error Occured | Some Details missing')); 
			}

		}
	
	public function code_cgl()
	{
		$input=Input::all();
		$query=DB::table('cg_leader')->where('cg_promo_id','=',$input['id'])->select('rec_id','Name_of_HH_member as cgl_name')->get();
		return json_encode($query);
	}

	public function code_cg()
	{
		$input=Input::all();
		$query=DB::table('ubale_caregroup')->where('cg_promo_id','=',$input['id'])->select('cg_number','group_name')->get();
		return json_encode($query);
	} 

	public function savePromo()
	{
		$input=Input::all();
		
		$createdAt = Carbon::createFromFormat('d/m/Y',$input['date_registration']);
		$input['date_registration']=$createdAt;

		$query=DB::table('cg_promoter')->insert($input);
		if($query){
			return json_encode(array('successMsg'=>'Successfully added CG Promoter'));
			}else{		
			return json_encode(array('errorMsg'=>'Error Occured | Failed to add CG Promoter')); 		
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
