<?php

class Codes extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /codes
	 *
	 * @return Response
	 */
	public function taSel(){
		$input=Input::get('district');  //household input
		$GTans=Input::get('dist');
		$SptInp=Input::get('distNgv');
		$TrInput=Input::get('disTrans');
		$TrInputInd=Input::get('disTransInd');
		$TrInputImem=Input::get('disTransImem');
		$TrInputImemTo=Input::get('disTransImemTo');

		$DispTA=DB::table('code_ta')->where('rec_id_district','=',$input)
		->orWhere('rec_id_district','=',$GTans)
		->orWhere('rec_id_district','=',$SptInp)
		->orWhere('rec_id_district','=',$TrInput)
		->orWhere('rec_id_district','=',$TrInputInd)
		->orWhere('rec_id_district','=',$TrInputImem)
		->orWhere('rec_id_district','=',$TrInputImemTo)
		->orderBy('ta_name','asc')
		->lists('ta_name','rec_id');

		$firstItem=array('0'=>'Select');
		 if(count($DispTA)>0){
		 	$DispTA=$firstItem+$DispTA;
		 }else{
		 	$DispTA=array('Select'=>'Select');
		 }
		 return Response::json($DispTA);
	}
	public function gvhSel(){
			$input=Input::get('taSel');  //normal code selections
			$GVinput=Input::get('taSelect');
			$CodVilGv=Input::get('taNSel');
			$gvhTrans=Input::get('taTrans');
			$gvhTransInd=Input::get('taTransInd');
			$gvhTransIndTo=Input::get('taTransIndTo');
			$gvhTransImem=Input::get('taTransImem');
			$gvhTransImemTo=Input::get('taTransImemTo');

			$DispGVH=DB::table('code_gvh')
			->where('rec_id_ta','=',$input)
			->orWhere('rec_id_ta','=',$GVinput)
			->orWhere('rec_id_ta','=',$CodVilGv)
			->orWhere('rec_id_ta','=',$gvhTrans)
			->orWhere('rec_id_ta','=',$gvhTransInd)
			->orWhere('rec_id_ta','=',$gvhTransIndTo)
			->orWhere('rec_id_ta','=',$gvhTransImem)
			->orWhere('rec_id_ta','=',$gvhTransImemTo)
			->orderBy('gvh_name','asc')
			-> lists('gvh_name','rec_id');

			$firstItem=array('0'=>'Select');
			if(count($DispGVH)>0){
			$DispGVH= $firstItem+$DispGVH;
			}else{
				$DispGVH= array('Select'=>'Select');
			}
		return Response::json($DispGVH);
	}

	public function vilSel(){

		//Capture  input
			$input=Input::get('gvhSel');
			$inputInd=Input::get('gvhSelTransInd');
			$inputIndTo=Input::get('gvhSelTransToInd');
			$inputImem=Input::get('gvhSelTransImem');
			$inputITomem=Input::get('gvhSelTransTomem');

			$DispVG=DB::table('code_village')->where('rec_id_gvh','=',$input)
			->orWhere('rec_id_gvh','=',$inputInd)
			->orWhere('rec_id_gvh','=',$inputIndTo)
			->orWhere('rec_id_gvh','=',$inputImem)
			->orWhere('rec_id_gvh','=',$inputITomem)

			->lists('village_name','rec_id');
			$firstItem=array('0'=>'Select');
			if(count($DispVG)>0){
			$DispVG= $firstItem+$DispVG;
		}else{
			$DispVG=array('Select'=>'Select');
		}
		return Response::json($DispVG);
	}



	public function codesta(){
		$input=Input::all();

		$query=DB::table('code_ta')
		->where('Rec_Id_District','=',$input['Rec_Id_District'])
		->where('TA_ID','=',$input['TA_ID'])->get();
		if(count($query)<=0){
			$query=DB::table('code_ta')->insert($input);
			if($query){
				return json_encode(array('successMsg'=>'TA Successfully Created'));
			}else{
				return json_encode(array('errorMsg'=>'Some error Occured.'));
			}
		}else{
			return json_encode(array('errorMsg'=>'TA Already Exists.'));
		}
			}
	public function codesGVH(){
			$input=Input::all();

		$query=DB::table('code_GVH')
		->where('Rec_id_TA','=',$input['Rec_id_TA'])
		->where('GVH_ID','=',$input['GVH_ID'])->get();
		if(count($query)<=0){
			$query=DB::table('code_GVH')->insert($input);
			if($query){
				return json_encode(array('successMsg'=>'GVH Successfully Created'));
			}else{
				return json_encode(array('errorMsg'=>'Some error Occured.'));
			}
		}else{
			return json_encode(array('errorMsg'=>'GVH Already Exists.'));
		}
			}
	public function codesVillage(){
		$input=Input::all();

		$query=DB::table('code_village')
		->where('Rec_id_GVH','=',$input['Rec_id_GVH'])
		->where('Village_ID','=',$input['Village_ID'])->get();
		if(count($query)<=0){
			$query=DB::table('code_village')->insert($input);
			if($query){
				return json_encode(array('successMsg'=>'Village Successfully Created'));
			}else{
				return json_encode(array('errorMsg'=>'Some error Occured.'));
			}
		}else{
			return json_encode(array('errorMsg'=>'Village Already Exists.'));
		}
		
	}
public function gptransfer(){
	$refTa=Input::get('refTa');
	$oldGvh=Input::get('GVH');
	$transGvh=Input::get('transGvh');

	$vill=Input::get('Village');

	$query1=DB::table('code_gvh')->where('Rec_id_TA','=',$refTa)->where('Rec_id','=',$transGvh)->get();
	if(count($query1)>0){
		
		$query2=DB::table('code_village')->where('Rec_id_GVH','=',$oldGvh)->where('Rec_id','=',$vill)->get();
		$query3=DB::table('code_village')->where('Rec_id_GVH','=',$transGvh)->orderBy('Village_ID','desc')->first();
		//add the next village id to the transfer
		$vill_num=1;
		//check if transfer has village to add to the end
		if(count($query3)>0){
			$vill_num=$vill_num+$query3->Village_ID;
		}
		foreach($query2 as $query){
			$query->Village_ID=$vill_num;			
		}

		$queryUp=DB::table('code_village')->where('Rec_id_GVH','=',$oldGvh)->where('Rec_id','=',$vill)->update(array("Rec_id_GVH"=>$transGvh,"Village_ID"=>$query->Village_ID));
		
		/*if($query2){
			return "Record Updated";
		}*/
		$arr=array();

	$queryBen=DB::table('tbl_beneficiary_registration')->where('gvh','=',$oldGvh)->where('Village','=',$vill)->get();
	$queryBenUp=DB::table('tbl_beneficiary_registration')->where('gvh','=',$oldGvh)->where('Village','=',$vill)->get();
	$chkBen=DB::table('tbl_beneficiary_registration')->where('gvh','=',$transGvh)->where('Village','=',$vill)->get();
	if(count($chkBen)<=	0){
	foreach ($queryBenUp as $BenUpdate) {
		$BenUpdate->GVH=$transGvh;
		array_push($arr,$BenUpdate);
		
			DB::table('tbl_beneficiary_registration')->insert((array)$BenUpdate);
		}

	foreach ($queryBen as $queryUp) {
		
		DB::table('tbl_beneficiary_registration')->where('gvh','=',$oldGvh)->where('Village','=',$vill)->update(array("active"=>"0"));
	}

		return json_encode(array('successMsg'=>'Successfully Transfered Village'));
	}else
	{
		return json_encode(array('errorMsg'=>'Village already Exist'));
	}
	}
		
}

public function indtransfer(){
	$oldTa=Input::get('Ta');
	$oldGvh=Input::get('GVH');
	$transTA=Input::get('transTA');
	$transGvh=Input::get('transGvh');
	$oldVil=Input::get('oldVil');
	$transVil=Input::get('transVil');
	$hh_number=Input::get('hh_number');
	$newHH=input::get('newHH');



	
	$queryBen=DB::table('tbl_beneficiary_registration')->where('ta','=',$oldTa)->where('gvh','=',$oldGvh)->where('Village','=',$oldVil)->where('hh_number','=',$hh_number)->get();
	$query2=DB::table('tbl_beneficiary_registration')->where('ta','=',$transTA)->where('gvh','=',$transGvh)->where('Village','=',$transVil)->where('HH_Number','=',$newHH)->get();

  if (count($query2)>0){
  	 return json_encode(array('errorMsg'=>'HouseHold Number Already Exists Please Check')) ;
  	}else{

  	if (count($queryBen)>0){
		foreach ($queryBen as $query) {
			$query->TA=$transTA;
			$query->GVH=$transGvh;
			$query->Village=$transVil;
			$query->HH_Number=$newHH;
			DB::table('tbl_beneficiary_registration')->insert((array)$query);

		}

		foreach ($queryBen as $quer2) {
			DB::table('tbl_beneficiary_registration')->where('gvh','=',$oldGvh)->where('Village','=',$oldVil)->where('hh_number','=',$hh_number)->update(array("active"=>"0"));
		}
	}
  }
	return json_encode(array('successMsg'=>'Successfully Transfered Individual'));
		
}

public function Imemtransfer(){
	$oldTa=Input::get('Ta');
	$oldGvh=Input::get('GVH');
	$transTA=Input::get('transTA');
	$transGvh=Input::get('transGvh');
	$oldVil=Input::get('oldVil');
	$transVil=Input::get('transVil');
	$hh_number=Input::get('hh_number');
	$newHH=input::get('newHH');
	$mem_num=input::get('hh_member_number');



	
	$queryBen=DB::table('tbl_beneficiary_registration')->where('ta','=',$oldTa)->where('gvh','=',$oldGvh)->where('Village','=',$oldVil)->where('hh_number','=',$hh_number)->where('hh_member_number','=',$mem_num)->get();
	$query2=DB::table('tbl_beneficiary_registration')->where('ta','=',$transTA)->where('gvh','=',$transGvh)->where('Village','=',$transVil)->where('HH_Number','=',$newHH)->get();
	$query3=DB::table('tbl_beneficiary_registration')->where('ta','=',$transTA)->where('gvh','=',$transGvh)->where('Village','=',$transVil)->where('HH_Number','=',$newHH)->orderBy('HH_Member_Number','desc')->first();

	$member_num=0;
 	if (count($query2)<=0){
  	 $member_num=1;
  	}else{
  		foreach ($queryBen as $queryHHmem) {
  			$member_num=$queryHHmem->HH_Member_Number+1;
  		}
  		
  	
  }
  if (count($queryBen)>0){
		foreach ($queryBen as $query) {
			$query->TA=$transTA;
			$query->GVH=$transGvh;
			$query->Village=$transVil;
			$query->HH_Number=$newHH;
			$query->HH_Member_Number=$member_num;
			DB::table('tbl_beneficiary_registration')->insert((array)$query);

		}

		foreach ($queryBen as $quer2) {
			DB::table('tbl_beneficiary_registration')->where('gvh','=',$oldGvh)->where('Village','=',$oldVil)->where('hh_number','=',$hh_number)->where('hh_member_number','=',$mem_num)->update(array("active"=>"0"));
		}
	}
	return $queryBen;
		
}

}

