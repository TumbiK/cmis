<?php
use Carbon\Carbon;	
class FfaController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /ffa
	 *
	 * @return Response
	 */


	public function code_partner(){

		$dbRes= DB::table('code_partner')
		//->where('district','=',$cod_dist)
		//->where('ta','=',$cod_ta)
		
		//->Where('hh_member_number','=','01')
		
		->Select('Rec_Id','Partner_Code','Partner_Name','Rec_id_district')		
		->get();

		return Response::json($dbRes)->setCallback(Input::get('callback'));

	}

	public function mobsamplemcp()
	{
		$input=Input::all();
	//	$dbRes=statement(DB::Raw(''));
//$results = DB::select('SELECT mcp.fdp_number,t.ta_name,g.gvh_name,v.village_name,mcp.village,tb.HH_Number,tb.HH_Member_Number,tb.Name_of_HH_member,tb.sex,tb.age,tb.dob FROM `ubale_mchn_child_ben` mcp join code_village v on(mcp.village= v.Rec_id) join code_gvh g on(g.rec_id=mcp.gvh) join code_ta t on(t.rec_id=mcp.ta) join tbl_beneficiary_registration tb on(mcp.village=tb.Village and mcp.hh_number=tb.HH_Number and tb.HH_Member_Number=mcp.hh_member_number)WHERE year=2016 GROUP by mcp.fdp_number ORDER BY RAND() limit 30');
    $results = DB::select('SELECT mcp.fdp_number,t.ta_name,g.gvh_name,v.village_name,mcp.village,tb.HH_Number,tb.HH_Member_Number,tb.Name_of_HH_member,tb.sex,tb.age,tb.dob FROM `ubale_mchn_child_ben` mcp join code_village v on(mcp.village= v.Rec_id) join code_gvh g on(g.rec_id=mcp.gvh) join code_ta t on(t.rec_id=mcp.ta) join tbl_beneficiary_registration tb on(mcp.village=tb.Village and mcp.hh_number=tb.HH_Number and tb.HH_Member_Number=mcp.hh_member_number)WHERE year=2016 and p12ack=1 and mcp.ta=58 ORDER BY RAND()');
	return Response::json($results)->setCallback(Input::get('callback'));

	}
	public function mobhhdetails()
{
	$cod_vil=Input::get('code_village');
		$cod_gvh=Input::get('code_gvh');
		$cod_ta=Input::get('code_ta');
		$cod_dist=Input::get('code_dist');
		$search_id=Input::get('hh_number');
		$editHH=Input::get('editHH');
		$editTa=Input::get('taEdit');
		$gvhEdit=Input::get('gvhEdit');
		$vilEdit=Input::get('vilEdit');


		if($search_id=='' && $editHH=='' ) {
    	
    	 $dbRes= DB::table('tbl_beneficiary_registration')
		//->where('district','=',$cod_dist)
		//->where('ta','=',$cod_ta)
		->where('gvh','=',$cod_gvh)
		->where('village','=',$cod_vil)
		//->Where('hh_member_number','=','01')
		->where('active','=','1')
		->Select('WALA_ID','UBALE_ID','Partner','District','TA','GVH','Village','HH_Number','HH_Member_Number','Name_of_HH_member','Age','Sex','Ben_Reg_date','head_h','status','dob','hh_size','comments','active')		
		->get();
		$rows=array();
	
	return Response::json($dbRes)->setCallback(Input::get('callback'));

    }elseif ($search_id!='' && $editHH==''){
    	return DB::table('tbl_beneficiary_registration')
		//->where('district','=',$cod_dist)
		//->where('ta','=',$cod_ta)
		->where('gvh','=',$cod_gvh)
		//->where('village','=',$cod_vil)
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
		return View::make('cmis/drrcc/ffa/index',array('dist_options'=>$dist_options))->with('dist',$dist)->with('adminRole',$admin_role);
	}

	public function ffaproposals()
	{
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
		return View::make('cmis/drrcc/ffa/appProp',array('dist_options'=>$dist_options))->with('dist',$dist)->with('adminRole',$admin_role);

	}
	
	public function ffaparticipants()
	{
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
		return View::make('cmis/drrcc/ffa/ffaparticipants',array('dist_options'=>$dist_options))->with('dist',$dist)->with('adminRole',$admin_role);

	}
	public function ffaverifications()
	{
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
		return View::make('cmis/drrcc/ffa/ffaVerif',array('dist_options'=>$dist_options))->with('dist',$dist)->with('adminRole',$admin_role);

	}


	
	public function dist_code(){
			$my_dist=Auth::user()->dist_id;
		$admin_role=Auth::user()->is_admin;
		//check to see if the user role is admin and for the PMU with district=0 and load equivalent values
		if($admin_role==1 && $my_dist==0 ){
			$dist=DB::table('code_district')->Select('district_name as district','rec_id')->get();
		}else{
			$dist=DB::table('code_district')->where('rec_id','=',$my_dist)->Select('district_name as district','rec_id')->get();
		}
				 
		 

		
	return json_encode($dist);


	}


	public function ta_codes(){
		$input=Input::get('id');  //household input
		

		$DispTA=DB::table('code_ta')->where('rec_id_district','=',$input)->Select('ta_name as ta','rec_id')->orderBy('ta_name','asc')->get();

		
		 return Response::json($DispTA)->setCallback(Input::get('callback'));
		}

		public function gvh_codes(){
			$input=Input::get('id');  //normal code selections
			

			$DispGVH=DB::table('code_gvh')
			->where('rec_id_ta','=',$input)
			
			-> Select('gvh_name as gvh','rec_id')->orderBy('gvh_name','asc')->get();

		
		return Response::json($DispGVH)->setCallback(Input::get('callback'));
	}

	public function code_vil(){
		$input=Input::get('id');  //normal code selections
			

			$DispVil=DB::table('code_village')
			->where('rec_id_gvh','=',$input)
			
			-> Select('village_name','rec_id')->orderBy('village_name','asc')->get();

		
		return Response::json($DispVil)->setCallback(Input::get('callback'));

	}


	public function ffaProp(){
		return DB::table('ubale_ffa_project')
		->where('commodity_approval','<>','1')
		->orWhere('ffa_approval','<>','1')
		->join('code_district','ubale_ffa_project.district','=','code_district.rec_id')
		->join('code_ta','ubale_ffa_project.ta','=','code_ta.rec_id')
		->join('code_gvh','ubale_ffa_project.gvh','=','code_gvh.rec_id')

		->Select('district_name as district','ta_name as ta','gvh_name as gvh','project_number','project_type','date_from','date_to','Asset_description','Imp_description','Sustain_description')
			->get();
	}

	public function ffaPropApp(){
		return DB::table('ubale_ffa_project')->where('commodity_approval','=','1')
		->where('ffa_approval','=','1')
		->join('code_district','ubale_ffa_project.district','=','code_district.rec_id')
		->join('code_ta','ubale_ffa_project.ta','=','code_ta.rec_id')
		->join('code_gvh','ubale_ffa_project.gvh','=','code_gvh.rec_id')


		->Select('district_name as district','ta_name as ta','gvh_name as gvh','project_number','project_type','date_from','date_to','Asset_description','Imp_description','Sustain_description')
			->get();
	}


	public function saveBeneficiary(){
		$input=Input::only('District','TA','GVH','Village','HH_Number','HH_Member_Number','Project_Number','FDP_Number','Date_of_Registration');
		$input['date_of_register']=date("y-m-d");

		$created = Carbon::createFromFormat('d/m/Y', $input['Date_of_Registration']);
		$input['Date_of_Registration']=$created;
		
		$chkMain=DB::table('tbl_beneficiary_registration')
		->where('district','=',$input['District'])
		->where('ta','=',$input['TA'])
		->where('gvh','=',$input['GVH'])
		->where('village','=',$input['Village'])
		->where('hh_number','=',$input['HH_Number'])
		->where('HH_Member_Number','=',$input['HH_Member_Number'])
		->where('status','>',0)
		->get();
if (count($chkMain)<1){
	$chkHH=DB::table('ubale_ffa_beneficiary_register')
		->where('district','=',$input['District'])
		->where('ta','=',$input['TA'])
		->where('gvh','=',$input['GVH'])
		->where('village','=',$input['Village'])
		->where('hh_number','=',$input['HH_Number'])
		->where('Project_Number','=',$input['Project_Number'])
		->get();

		if(count($chkHH)>0){
			return json_encode(array('errorMsg'=>'HouseHold already Exist'));

		}else{

			if($input['Project_Number']<1){
				return json_encode(array('errorMsg'=>'No Project Selected'));
			
			}else{
				$input['user']=Auth::user()->username;
		//timestamp
				$input['created_at']= \Carbon\Carbon::now()->toDateTimeString();
				$input['updated_at']= \Carbon\Carbon::now()->toDateTimeString();
				$query=DB::table('ubale_ffa_beneficiary_register')->insert($input);				
			}

		}
		if($query){
			return json_encode(array('successMsg'=>'Successfully added saveBeneficiary'));
		}
		
	}else{
		
			//return json_encode(array('errorMsg'=>'Some Error Occured saveBeneficiary Not Added to Project'));
		return json_encode($chkMain);
		
	}

}

	/**
	 * Show the form for creating a new resource.
	 * GET /ffa/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
		$input=Input::all();
		
		$conDat=str_replace('/', '-', $input['date_from']);
		$input['date_from']=date('y-m-d',strtotime($conDat));

		$conDat=str_replace('/', '-', $input['date_to']);
		$input['date_to']=date('y-m-d',strtotime($conDat));

		$conDat=str_replace('/', '-', $input['handover']);
		$input['handover']=date('y-m-d',strtotime($conDat));

		 $query=DB::table('ubale_ffa_project')->insert($input);
		 if($query){
			return json_encode(array('successMsg'=>'Successfully Created Project'));
		}else{
			return json_encode(array('errorMsg'=>'Failed to Create Project Please Check Details'));

		}
	
	}

	public function update_prop(){
		$input=Input::all();

		$conDat=str_replace('/', '-', $input['date_from']);
		$input['date_from']=date('y-m-d',strtotime($conDat));

		$conDat=str_replace('/', '-', $input['date_to']);
		$input['date_to']=date('y-m-d',strtotime($conDat));

		$conDat=str_replace('/', '-', $input['handover']);
		$input['handover']=date('y-m-d',strtotime($conDat));

		$query=DB::table('ubale_ffa_project')->where('district','=',$input['district'])
			->where('project_number','=',$input['project_number'])
			->update($input);

		if($query){
			return json_encode(array('successMsg'=>'Successfully Updated Project'));
		}else{
			return json_encode(array('errorMsg'=>'Failed to Updatee Project Please Check Details'));

		}

	}
	public function update_propFFA(){
		$input=Input::all();
			$querDist=DB::table('code_district')->where('District_Name','=',$input['district'])->get();
			
			foreach ($querDist as $quer) {
				$dist_search=$quer->Rec_Id;
				
			}
		
			$query=DB::table('ubale_ffa_project')->where('district','=',$dist_search)
			->where('project_number','=',$input['project_number'])
			->update(array('commodity_review'=>$input['commodity_review'],'commodity_approval'=>$input['ffa_approval'],'ffa_review'=>$input['ffa_review'],'ffa_approval'=>$input['ffa_approval']));
			
			if($query){
				return json_encode(array('successMsg'=>'Successfully Submited FFA Approval'));
			}else{
				return json_encode(array('errorMsg'=>'Some Error Occured'));
			}
		}

	public function update_propCom(){
			$input=Input::all();
			//$dist_search=7;
			$querDist=DB::table('code_district')->where('District_Name','=',$input['district'])->get();
			
			foreach ($querDist as $quer) {
				$dist_search=$quer->Rec_Id;
				
			}
			$query=DB::table('ubale_ffa_project')->where('district','=',$dist_search)
			->where('project_number','=',$input['project_number'])
			->update(array('commodity_review'=>$input['commodity_review'],'commodity_approval'=>$input['commodity_approval']));

			if($query){
			return json_encode(array('successMsg'=>'Successfully added saveBeneficiary'));
			
			}else{
				return json_encode(array('errorMsg'=>'Some Error Occured'));
				
			
			}

	}

	public function app_prop(){
		$input=Input::all();
		return DB::table('ubale_ffa_project')
		->where('commodity_approval','=','1')
		->where('ffa_approval','=','1')
		->where('GVH','=',$input)
		->Select('project_number')
		->get();
	}

	public function update_ffaAck(){
		$input=Input::except('Name_of_HH_Member','Sex','Age','dob','editing','period','ack');
		$edit=Input::get('editing');
		$ack=Input::get('ack');
		$period=Input::get('period');
		if($ack==0 || $ack==1){
			for($i=1;$i<=14;$i++){
				if($period=$i){
					$input['p'.$i.'ack']=$ack;
					
						
					
				}
			}
		}
		if($edit){
			$query=DB::table('ubale_ffa_beneficiary_register')
		->where('district','=',$input['district'])
		->where('ta','=',$input['ta'])
		->where('gvh','=',$input['gvh'])
		->where('village','=',$input['Village'])
		->where('HH_Number','=',$input['HH_Number'])
		
		
			->update($input);
		}
	}
	public function update_ffaBen(){
		$input=Input::except('Name_of_HH_Member','Sex','Age','dob','editing');
		$edit=Input::get('editing');
		if($edit){
		$query=DB::table('ubale_ffa_beneficiary_register')
		->where('district','=',$input['district'])
		->where('ta','=',$input['ta'])
		->where('gvh','=',$input['gvh'])
		->where('village','=',$input['Village'])
		->where('HH_Number','=',$input['HH_Number'])
		
		
			->update($input);

			if ($input['Number_days_work']=='20' && $input['FDP_Number']!='') {
				$updMain=DB::table('tbl_beneficiary_registration')
		->where('district','=',$input['district'])
		->where('ta','=',$input['ta'])
		->where('gvh','=',$input['gvh'])
		->where('village','=',$input['Village'])
		->where('HH_Number','=',$input['HH_Number'])
		->where('HH_Member_Number','=',$input['HH_Member_Number'])
		->update(array('FFA'=>'1'));
			}

			if($input['status']>'2'){
				$input['date_of_exit']=date("y-m-d");
			}

			if($query){
				return json_encode(array('successMsg'=>'Successfully Edited Participants Details'));
			}
			else{
				return json_encode(array('errorMsg'=>'Some Error Occured'));
			}
			}
			
	}
	public function ffa_ben_reg(){
		$input=Input::all();

		$pages=Input::get('page');
		$rowsRes=Input::get('rows');
		$page=isset($pages)?intval($pages):1;
		$rows=isset($rowsRes)?intval($rowsRes):10;
		$offset=($page-1)*$rows;

	if($input['code_dist']!='' && $input['code_ta']!='' && $input['code_gvh'] !=''){

		$counts=$dbRes= DB::table('ubale_ffa_beneficiary_register')
		->where('district','=',$input['code_dist'])
		->where('ta','=',$input['code_ta'])
		->where('gvh','=',$input['code_gvh'])
		
		->where('project_number','=',$input['project'])
		->Where('hh_number','<>','')
		->count();

		$result['total']=$counts;

		$tb_Ubale_Join= DB::table('ubale_ffa_beneficiary_register as uffa_ben')
		->join('tbl_beneficiary_registration as ben_reg',function($join)
			{
				$join->on('uffa_ben.TA','=','ben_reg.TA');
				$join->on('uffa_ben.District','=','ben_reg.District');
				$join->on('uffa_ben.GVH','=','ben_reg.GVH');
				$join->on('uffa_ben.Village','=','ben_reg.Village');
				$join->on('uffa_ben.HH_Number','=','ben_reg.HH_Number');
				$join->on('uffa_ben.HH_Member_Number','=','ben_reg.HH_Member_Number');

	})
		->Select('ben_reg.district','ben_reg.ta','ben_reg.gvh','ben_reg.Village','ben_reg.HH_Number','ben_reg.HH_Member_Number','ben_reg.Name_of_HH_Member','ben_reg.Sex','ben_reg.Age','ben_reg.dob','uffa_ben.status','uffa_ben.Number_days_work','uffa_ben.FDP_Number','uffa_ben.Project_Number')
		->where('uffa_ben.gvh','=',$input['code_gvh'])
		->where('uffa_ben.project_number','=',$input['project'])
		->take($rows)
		->skip($offset)		
		->get();

		$row=array();
		foreach ( $tb_Ubale_Join as $dbRe ) {			
				array_push($row,$dbRe);
		}
		$result["rows"]=$row;
		
	
	}
	if($tb_Ubale_Join){
     	return json_encode($result);
     }
     else{
     	return "Some error Occured";
     }
	}

	public function ben_reg_ackFFA(){
		$input=Input::all();
		if ($input['cont']=='0'){
			//repeat for six time to return the values for acknowledgements
 for ($i=1;$i<=6;$i++){
	if($input['district']!='' && $input['period']==$i && $input['FDP_Number'] !='' && $input['project']!=''){
		$tb_Ubale_Join= DB::table('ubale_ffa_beneficiary_register as uffa_ben')
		->join('tbl_beneficiary_registration as ben_reg',function($join)
			{
				$join->on('uffa_ben.TA','=','ben_reg.TA');
				$join->on('uffa_ben.District','=','ben_reg.District');
				$join->on('uffa_ben.GVH','=','ben_reg.GVH');
				$join->on('uffa_ben.Village','=','ben_reg.Village');
				$join->on('uffa_ben.HH_Number','=','ben_reg.HH_Number');
				$join->on('uffa_ben.HH_Member_Number','=','ben_reg.HH_Member_Number');

	})
		->Select('ben_reg.district','ben_reg.ta','ben_reg.gvh','ben_reg.Village','ben_reg.HH_Number','ben_reg.HH_Member_Number','ben_reg.Name_of_HH_Member','ben_reg.Sex','ben_reg.Age',"uffa_ben.p".$i."days AS Number_days_work",'uffa_ben.p'.$i.'ack AS ack','uffa_ben.FDP_Number','uffa_ben.Project_Number')
		->where('uffa_ben.district','=',$input['district'])
		->where('uffa_ben.project_number','=',$input['project'])
		->where('uffa_ben.FDP_Number','=',$input['FDP_Number'])

	
		->get();
			}
	}
	 if($tb_Ubale_Join){
     	return json_encode($tb_Ubale_Join);
     }
     else{
     	return "Some error Occured";
     }


}
    
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /ffa
	 *
	 * @return Response
	 */
	public function ff_faf(){
		$district=Input::get('district');
		$project	=Input::get('project');
		$fdp	=Input::get('FDP_Number');

		
		//if($district!='' && $project!='' && $percentage!=''){
		//$report=public_path() .'/report/cmisHousehold1.jasper';
		$report=public_path() .'/report/faf.jasper';
		
		//}
        $database = \Config::get('database.connections.mysql');
       // $output = public_path() . '/report/'.date("Y.m.d").'_codelution';
         $output = public_path() . '/report/'.date("Y.m.d").'_cmisFFAVerification';
        
        $ext = "pdf";
       
       \JasperPHP::process(
           $report,
            $output,
            array($ext),
            array("district"=>$district,"project"=>$project,"fdp"=>$fdp),
          $database,
            false,
            false
        )->execute();
 		
 		header('Content-Description: File Transfer');
		header('Content-Type:application/octet-stream');
		header('Content-Disposition:attachement;filename='.date("Y.m.d").'_FFA_Verification.'.$ext);

		header('Content-Transfer-Encoding:binary');
		header('Expires:0');
		header('Cache-Control:must-revalidate,post-check=0,precheck=0');
		header('Pragma:public');
		header('Content-Length:'.filesize($output.'.'.$ext));
		flush();
		readfile($output.'.'.$ext);
		unlink($output.'.'.$ext);

	}
	public function ff_verification(){
		$district=Input::get('district');
		$project	=Input::get('project');
		$percentage	=Input::get('percentage');

		
		//if($district!='' && $project!='' && $percentage!=''){
		//$report=public_path() .'/report/cmisHousehold1.jasper';
		$report=public_path() .'/report/report2.jasper';
		
		//}
        $database = \Config::get('database.connections.mysql');
        $output = public_path() . '/report/'.date("Y.m.d").'_codelution';
        
        $ext = "pdf";
       
       \JasperPHP::process(
           $report,
            $output,
            array($ext),
            array("district"=>$district,"project"=>$project,"percent"=>$percentage),
          $database,
            false,
            false
        )->execute();
 		
 		header('Content-Description: File Transfer');
		header('Content-Type:application/octet-stream');
		header('Content-Disposition:attachement;filename='.date("Y.m.d").'_FFA_Verification.'.$ext);
		header('Content-Transfer-Encoding:binary');
		header('Expires:0');
		header('Cache-Control:must-revalidate,post-check=0,precheck=0');
		header('Pragma:public');
		header('Content-Length:'.filesize($output.'.'.$ext));
		flush();
		readfile($output.'.'.$ext);
		unlink($output.'.'.$ext);

		//return Redirect::to('/hhreport');
	}

	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /ffa/{id}
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
	 * GET /ffa/{id}/edit
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
	 * PUT /ffa/{id}
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
	 * DELETE /ffa/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}