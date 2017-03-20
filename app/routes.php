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
//handle app logout and login
Route::get('code_ta',["uses"=>"ffaController@ta_codes"]);
Route::any('code_Gvh',["uses"=>"ffaController@gvh_codes"]);
Route::any('code_Gv',["uses"=>"ffaController@gvh_codes"]);
Route::any('code_vil',["uses"=>"ffaController@code_vil"]);
Route::any('code_partner',["uses"=>"ffaController@code_partner"]);


Route::any('mobhhdetails',["uses"=>"ffaController@mobhhdetails"]);
Route::any('mobsamplemcp',["uses"=>"ffaController@mobsamplemcp"]);
Route::group(["before"=>"guest"], function(){
Route::get('/restricted', [
   'before' => 'jwt-auth',
		   function () {
		       $token = JWTAuth::getToken();
		       $user = JWTAuth::toUser($token);

		       return Response::json([
		           'data' => [
		               'email' => $user->email,
		               'registered_at' => $user->created_at->toDateTimeString()
		           ]
		       ]);
		   }
	]);


Route::filter('authMobile',function($route,$request)
{
	try{
		$token=JWTAuth::getToken();
		$user=JWTAuth::toUser($token);
		$tokenStr=JWTAuth::getToken()->__toString();
		if($user->loginToken != $tokenStr){
			throw new Exception("Login Token dont Match");
			
		}
		Session::put('user',$user->id);
	}
	catch(Exception $e){
		return Response::json(array('error'=>true,'message'=>'Invalid Session'));
	}
});

Route::any("login",["as"=>"user/login","uses"=>"UserController@login"]);
Route::any("/",["as"=>"user/login","uses"=>"UserController@login"]);
	Route::post('/signin', function () {
			   $credentials = Input::only('username', 'password');

			   if ( ! $token = JWTAuth::attempt($credentials)) {
			       return Response::json(false, HttpResponse::HTTP_UNAUTHORIZED);
			   }

			   return Response::json(compact('token'));
			});
	
});




Route::any('logout',["as"=>"user/logout","uses"=>"UserController@logout"]);

/*Route::filter('auth', function()
{
    if (Auth::guest()) {
        return Redirect::route('login');
    }
});*/
//routes

//Diner Fairs
Route::any("/diner",["uses"=>"dinerController@index"]);
Route::any("/code_market",["uses"=>"dinerController@market"]);
Route::any("/code_epa",["uses"=>"dinerController@epa"]);
Route::any("/code_section",["uses"=>"dinerController@section"]);
Route::any("/saveDinerBen",["uses"=>"dinerController@saveDinerBen"]);
Route::any("/diner_reg",["uses"=>"dinerController@diner_reg"]);
Route::any("/codesEpa",["uses"=>"dinerController@codesEpa"]);
Route::any("/codesMarket",["uses"=>"dinerController@codesMarket"]);

//Demo Plots
Route::any("/demoplot",["uses"=>"dinerController@demoplot"]);

//farmer learning center





//primary user interface Routes
Route::group(array('before'=>'auth'),function(){

Route::any("/dashboard",["as"=>"user/dashboard","uses"=>"UserController@dashboard"]);
Route::any("/household",["as"=>"user/household","uses"=>"household@household"]);

Route::get("hhreport",["uses"=>"reportController@index"]);
Route::post("hhreport",["uses"=>"reportController@post"]);

//ffa report Verification and FAF

Route::any("/ff_verification",["as"=>"user/household","uses"=>"ffaController@ff_verification"]);
Route::any("/ff_faf",["as"=>"user/household","uses"=>"ffaController@ff_faf"]);

//MCHN report Verification and FAF
Route::any("/mchn_verification",["as"=>"user/household","uses"=>"mchnController@mchn_verification"]);
Route::any("/mchn_faf",["uses"=>"mchnController@mchn_faf"]);

Route::any("delete_mchnChildBen",["uses"=>"mchnController@delete_mchnChildBen"]);
Route::any("delete_mchnPregBen",["uses"=>"mchnController@delete_mchnPregBen"]);


//handling codes
Route::any("taSelect",["as"=>"taSelect","uses"=>"codes@taSel"]);
Route::any("gvhSelect",["as"=>"gvhSelect","uses"=>"codes@gvhSel"]);
Route::any("vilSelect",["as"=>"vilSelect","uses"=>"codes@vilSel"]);

Route::any("codesta",["uses"=>"codes@codesta"]);
Route::any("codesGVH",["uses"=>"codes@codesGVH"]);
Route::any("codesVillage",["uses"=>"codes@codesVillage"]);


//transfers handler in codes controller
Route::any("gpTransfer",["uses"=>"codes@gptransfer"]);
Route::any("indTransfer",["uses"=>"codes@indtransfer"]);
Route::any("ImemTransfer",["uses"=>"codes@Imemtransfer"]);



//create transfer export file 

Route::get('/export_csv',["uses"=>"household@export"]);

//training controller
Route::any("pmu_training",["uses"=>"trainingController@pmu_training"]);
Route::any("sub_district",["uses"=>"trainingController@sub_district"]);
Route::any("community",["uses"=>"trainingController@community"]);

Route::any("training_num",["uses"=>"trainingController@training_num"]);
Route::any("rfoSel",["uses"=>"trainingController@rfoSel"]);

//ccfls routes

Route::any("saveCCFLSession",["uses"=>"mchnController@saveCCFLSession"]);
Route::any("saveCCFLSChildBen",["uses"=>"mchnController@saveCCFLSChildBen"]);
Route::any("ccfls_registration",["uses"=>"mchnController@ccfls_registration"]);

Route::any("ccflsChilddetail",["uses"=>"mchnController@ccflsChilddetail"]);
Route::any("updateCCFLS",["uses"=>"mchnController@updateCCFLS"]);


Route::any("sector",["uses"=>"trainingController@sector"]);
Route::any("workshop",["uses"=>"trainingController@workshop"]);
Route::any("title",["uses"=>"trainingController@title"]);

Route::any("institution",["uses"=>"trainingController@institution"]);
Route::any("institutionTA",["uses"=>"trainingController@institutionTA"]);
Route::any("institution_reg",["uses"=>"trainingController@institution_reg"]);
Route::any("save_inst_member",["uses"=>"trainingController@save_inst_member"]);

Route::any("updateTrain",["uses"=>"trainingController@updateTrain"]);
Route::any("updatePmu",["uses"=>"trainingController@updatePmu"]);
Route::any("updateCom",["uses"=>"trainingController@updateCom"]);

//handling households
Route::any("chkhh",["as"=>"chkhh","uses"=>"household@chkhh"]);
Route::any('hhdetails',["as"=>"hhdetails","uses"=>"household@hhdetails"]);
Route::get('save_household',["as"=>"save_household","uses"=>"household@saveHH"]);
Route::get('update_household',["as"=>"update_household","uses"=>"household@updateHH"]);

//Group Registration (VCPC/VDc/ACPC)
Route::any('acpc',["uses"=>"groupController@acpc"]);
Route::any('acpcSel',["uses"=>"groupController@acpcSel"]);
Route::any('acpc_reg',["uses"=>"groupController@acpc_reg"]);
Route::any('saveAcpBeneficiary',["uses"=>"groupController@saveAcpBeneficiary"]);

//VDC
Route::any('vdc',["uses"=>"groupController@vdc"]);
Route::any('vdc_reg',["uses"=>"groupController@vdc_reg"]);
Route::any('saveVdcBeneficiary',["uses"=>"groupController@saveVdcBeneficiary"]);
Route::any('vdcSel',["uses"=>"groupController@vdcSel"]);
//vcpc
Route::any('vcpc',["uses"=>"groupController@vcpc"]);
Route::any('vcpcSel',["uses"=>"groupController@vcpcSel"]);
Route::any('vcpc_reg',["uses"=>"groupController@vcpc_reg"]);
Route::any('saveVcpcBeneficiary',["uses"=>"groupController@saveVcpcBeneficiary"]);
//vnrmc
Route::any('vnrmc',["uses"=>"groupController@vnrmc"]);
Route::any('vnrmcSel',["uses"=>"groupController@vnrmcSel"]);
Route::any('vnrmc_reg',["uses"=>"groupController@vnrmc_reg"]);
Route::any('saveVrnmcBeneficiary',["uses"=>"groupController@saveVnrmcBeneficiary"]);
//YouthClub
Route::any('youthClub',["uses"=>"groupController@youthClub"]);
Route::any('youthclubSel',["uses"=>"groupController@youthclubSel"]);
Route::any('youthclub_reg',["uses"=>"groupController@youthclub_reg"]);
Route::any('saveAdcBeneficiary',["uses"=>"groupController@saveAdcBeneficiary"]);

//ADC
Route::any('adc',["uses"=>"groupController@adc"]);
Route::any('adcSel',["uses"=>"groupController@adcSel"]);
Route::any('adc_reg',["uses"=>"groupController@adc_reg"]);
Route::any('saveYcBeneficiary',["uses"=>"groupController@saveYcBeneficiary"]);
Route::any('update_Adc_Ben',["uses"=>"groupController@update_Adc_Ben"]);


//create Structure
Route::any('save_vcpc',["uses"=>"groupController@save_vcpc"]);
Route::any('save_vdc',["uses"=>"groupController@save_vdc"]);
Route::any('save_adc',["uses"=>"groupController@save_adc"]);
Route::any('save_acpc',["uses"=>"groupController@save_acpc"]);
Route::any('save_vnrmc',["uses"=>"groupController@save_vnrmc"]);
Route::any('save_youthclub',["uses"=>"groupController@save_youthclub"]);




//handle admin issues
Route::any("admin",["as"=>"admin","uses"=>"adminController@index"]);
Route::any("codes",["as"=>"admin","uses"=>"adminController@codes"]);

Route::post("adduser",["uses"=>"UserController@store"]);



//Routes for DRR and Cross Cutting 

Route::any("drr",["uses"=>"drrController@index"]);

Route::any("ffa",["uses"=>"ffaController@index"]);
Route::any("ffaproposals",["uses"=>"ffaController@ffaproposals"]);
Route::any("ffaparticipants",["uses"=>"ffaController@ffaparticipants"]);
Route::any("ffaverifications",["uses"=>"ffaController@ffaverifications"]);



Route::any('code_dist',["uses"=>"ffaController@dist_code"]);
Route::any('code_ta',["uses"=>"ffaController@ta_codes"]);
Route::any('code_Gvh',["uses"=>"ffaController@gvh_codes"]);
Route::any('code_Gv',["uses"=>"ffaController@gvh_codes"]);
Route::any('code_vil',["uses"=>"ffaController@code_vil"]);


//ffa proposals

Route::any("ffa_prop",["uses"=>"ffaController@ffaProp"]);
Route::any("ffa_propApp",["uses"=>"ffaController@ffaPropApp"]);

Route::any("save_prop",["uses"=>"ffaController@create"]);
Route::any("update_prop",["uses"=>"ffaController@update_prop"]);

Route::any("update_propFFA",["uses"=>"ffaController@update_propFFA"]);
Route::any("update_propCom",["uses"=>"ffaController@update_propCom"]);


Route::any("app_prop",["uses"=>"ffaController@app_prop"]);

Route::any("ff_acknowledgements",["uses"=>"commodityController@ff_acknowledgements"]);
Route::any("mchn_acknowledgements",["uses"=>"commodityController@mchn_acknowledgements"]);

//ffa Beneficiary Registration

Route::any("ffa_ben_reg",["uses"=>"ffaController@ffa_ben_reg"]);
Route::any("ben_reg_ackFFA",["uses"=>"ffaController@ben_reg_ackFFA"]);
Route::any("ben_reg_ackMchn",["uses"=>"mchnController@ben_reg_ackMchn"]);


Route::any("saveBeneficiary",["uses"=>"ffaController@saveBeneficiary"]);
Route::any("update_ffaBen",["uses"=>"ffaController@update_ffaBen"]);
Route::any("update_ffaAck",["uses"=>"ffaController@update_ffaAck"]);
Route::any("update_MchnAck",["uses"=>"mchnController@update_MchnAck"]);


//FDP Routes
Route::any("save_Fdp",["uses"=>"commodityController@saveFDP"]);
Route::any("update_fdp",["uses"=>"commodityController@update_fdp"]);
Route::any("commFdp",["uses"=>"commodityController@commFdp"]);
Route::any("commFdpSel",["uses"=>"commodityController@commFdpSel"]);
//MCHN FDP select
Route::any("commFdpHSel",["uses"=>"commodityController@commFdpHSel"]);


//mchn
Route::any("mother_child",["uses"=>"mchnController@motherChild"]);
Route::any("mother_preg",["uses"=>"mchnController@motherPreg"]);
Route::any("mother_verification",["uses"=>"mchnController@mother_verification"]);


Route::any("savePregnantBeneficiary",["uses"=>"mchnController@savePregnantBeneficiary"]); 
Route::any("saveGroupBen",["uses"=>"mchnController@saveGroupBen"]);
Route::any("saveChildGroupBen",["uses"=>"mchnController@saveChildGroupBen"]);

Route::any("preg_ben_reg",["uses"=>"mchnController@preg_ben_reg"]);
Route::any("child_ben_reg",["uses"=>"mchnController@child_ben_reg"]);
Route::any("saveChildBeneficiary",["uses"=>"mchnController@saveChildBeneficiary"]);



Route::any("update_mchn_Ben",["uses"=>"mchnController@update_mchn_Ben"]);
Route::any("update_mchnChildBen",["uses"=>"mchnController@update_mchnChildBen"]);


//MCHN Care Group CCFLS 
Route::any("mother_childCCFLS",["uses"=>"mchnController@mother_childCCFLS"]);
Route::any("mother_childCCFLSpreg",["uses"=>"mchnController@mother_childCCFLSpreg"]);
//Cluster
//MCHN CCFLS commodities
Route::any("mother_childCluster",["uses"=>"mchnController@mother_childCluster"]);

Route::any("commodityHome",["uses"=>"commodityController@index"]);

//Trainings 
Route::any("newTraining",["uses"=>"trainingController@newTraining"]);
Route::any("trainDetails",["uses"=>"trainingController@trainDetails"]);

Route::any("saveTrainBen",["uses"=>"trainingController@saveTrainBen"]);
Route::any("savePmuBen",["uses"=>"trainingController@savePmuBen"]);
Route::any("saveComBen",["uses"=>"trainingController@saveComBen"]);

Route::any("sub_dist_train",["uses"=>"trainingController@sub_dist_train"]);
Route::any("pmupvo_training",["uses"=>"trainingController@pmupvo_training"]);
Route::any("community_training",["uses"=>"trainingController@community_training"]);
Route::any("traintt",["uses"=>"trainingController@traintt"]);


//SILC and Marketing Club landing Home
Route::any("silc",["uses"=>"silcController@index"]);
Route::any("marketclub",["uses"=>"marketController@index"]);

Route::get("user/reset",["uses"=>"PasswordController@remind","as"=>"user.remind"]);

Route::post('password/reset', array(
  'uses' => 'PasswordController@request',
  'as' => 'password.request'
));

Route::get('password/reset/{token}', array(
  'uses' => 'PasswordController@reset',
  'as' => 'password.reset'
));


Route::post('password/reset/{token}', array(
  'uses' => 'PasswordController@update',
  'as' => 'password.update'
));

//SILC Routes
Route::any('silc_reg',["uses"=>"silcController@silc_reg"]);
Route::any('silc_group',["uses"=>"silcController@silc_reg"]);
Route::any('silc_psp',["uses"=>"silcController@pspfa"]);


Route::get('codesSilc',["uses"=>"silcController@codesSilc"]);
Route::get('codesPSP',["uses"=>"silcController@codesPSP"]);


Route::any('saveSilcBen',["uses"=>"silcController@saveSilcBen"]);
Route::any('silc_group',["uses"=>"silcController@silc_group"]);
Route::any('code_ss',["uses"=>"silcController@code_ss"]);
Route::any('update_silc',["uses"=>"silcController@update_silc"]);

Route::get('ubale_fy',["uses"=>"adminController@ubale_fy"]);
Route::get('ubale_cutoff',["uses"=>"adminController@ubale_cutoff"]);

//caregroup routes
Route::any('cg_promoter',["uses"=>"caregroupController@cg_promoter"]);
Route::any('savePromo',["uses"=>"caregroupController@savePromo"]);
Route::any('saveCGlead',["uses"=>"caregroupController@saveCGlead"]);
Route::any('code_cgl',["uses"=>"caregroupController@code_cgl"]);
Route::any('code_cg',["uses"=>"caregroupController@code_cg"]);
Route::any('saveCG',["uses"=>"caregroupController@saveCG"]);
Route::any('saveCGBen',["uses"=>"caregroupController@saveCGBen"]);
Route::any('cggroup',["uses"=>"caregroupController@cggroup"]);
Route::any('cg_reg',["uses"=>"caregroupController@cg_reg"]);


// Marketing Routes
Route::get('codesMA',["uses"=>"silcController@codesMA"]);
Route::any('market_group',["uses"=>"silcController@market_group"]);
Route::any('codesMarketClub',["uses"=>"silcController@codesMarketClub"]);
Route::any('codesMaCl',["uses"=>"silcController@codesMaCl"]);
Route::any('code_MaCluster',["uses"=>"silcController@code_MaCluster"]);
Route::any('updateMaCl',["uses"=>"silcController@updateMaCl"]);

Route::any('saveMarketBen',["uses"=>"silcController@saveMarketBen"]);
Route::any('market_psp',["uses"=>"silcController@market_psp"]);
Route::any('market_reg',["uses"=>"silcController@market_reg"]);
Route::any('update_marketing',["uses"=>"silcController@update_marketing"]);


//Reporting Functions

Route::get('ITT',["uses"=>"reportController@itt"]);
Route::any('itt_calcReport',["uses"=>"reportController@itt_calcReport"]);

Route::get('partication',["uses"=>"reportController@partication"]);
Route::post('get_purpose',["uses"=>"reportController@get_purpose"]);


Route::post('get_fy',["uses"=>"reportController@get_fy"]);
Route::post('itt_report',["uses"=>"reportController@itt_report"]);
Route::post('itt_genreport',["uses"=>"reportController@itt_genreport"]);
Route::any('update_indicator',["uses"=>"reportController@update_indicator"]);

//BigDump
Route::any('content',["uses"=>"adminController@content"]);
Route::any('purp1',["uses"=>"adminController@purp1"]);
Route::any('purp2',["uses"=>"adminController@purp2"]);
Route::any('purp3',["uses"=>"adminController@purp3"]);

Route::any('bigdump',["uses"=>"adminController@bigdump"]);
});


//

// Confide routes
Route::get('users/create', 'UsersController@create');
Route::post('users', 'UsersController@store');
Route::get('users/login', 'UsersController@login');
Route::post('users/login', 'UsersController@doLogin');
Route::get('users/confirm/{code}', 'UsersController@confirm');
Route::get('users/forgot_password', 'UsersController@forgotPassword');
Route::post('users/forgot_password', 'UsersController@doForgotPassword');
Route::get('users/reset_password/{token}', 'UsersController@resetPassword');
Route::post('users/reset_password', 'UsersController@doResetPassword');
Route::get('users/logout', 'UsersController@logout');
