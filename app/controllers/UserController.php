<?php

use Khill\Lavacharts\Laravel\LavachartsFacade as Lava;

class UserController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function login()
	{
		$data=[];
		if($this->isPostRequest()){
			$validator=$this->getLoginValidator();
			if($validator->passes()){
				$credentials=$this->getLoginCredentials();
				if(Auth::attempt($credentials))
					{
						return Redirect::route('user/dashboard');
					}
				return Redirect::back()->withErrors(["password"=>["Credentials Invalid"]]);
			}else{
				return Redirect::back()->withInput()->withErrors($validator);
			}
		}
		return View::make("user/login",$data);
	}

	protected function isPostRequest(){
		return Input::server("REQUEST_METHOD")=="POST";
	}
	protected function getLoginValidator(){
		return Validator::make(Input::all(),["username"=>"required","password"=>"required"]);
	}	
	protected function getLoginCredentials()
	{
		return [
			"username"=>Input::get("username"),
			"password"=>Input::get("password")];
	}
	public function index()
	{
		//
		$users=User::all();
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function dashboard(){
		$userName = Auth::user()->username;
		$adminRole=Auth::user()->is_admin;
		$adminDist=Auth::user()->dist_id;
		
		//dataTables
		$hhTaCount=Lava::DataTable();
		$votes  = Lava::DataTable();
		$mchnStat=Lava::DataTable();
 
	$votes->addStringColumn('Food Poll')
      ->addNumberColumn('Pregnant Women')
      ->addRow(['Sept',  rand(1000,5000)])
      ->addRow(['Oct',  rand(1000,5000)])
      ->addRow(['Nov',  rand(1000,5000)])
      ->addRow(['Dec', rand(1000,5000)])
      ->addRow(['Jan',   rand(1000,5000)]);
      	
		$myQuery=DB::select(DB::raw("Select * from (select t.ta_name,ta,count(hh_number) totalHH from tbl_beneficiary_registration join code_ta t on(t.rec_id=ta) where head_h=1 and district='$adminDist' and active=1 group by ta) as Total inner join (select ta,count(hh_number) totalFemale from tbl_beneficiary_registration where head_h=1 and district='$adminDist' and sex=2 and active=1 group by ta) as TotalF on Total.ta=TotalF.ta"));
		$mchnQuery=DB::select(DB::raw("SELECT cp.fdp_number,counT(*) totalHH FROM ubale_mchn_child_ben cp join tbl_beneficiary_registration tb on(tb.Village=cp.village and tb.HH_Number=cp.hh_number and tb.HH_Member_Number=cp.hh_member_number) WHERE tb.dob > '2015-1-1' GROUP by cp.fdp_number"));
		$hhTaCount->addStringColumn('TA Name')
			->addNumberColumn('Total HH');

		$mchnStat->addStringColumn('Child Receipts')
			->addNumberColumn('Total Members');

			//->addNumberColumn('Female HH Count');
		foreach ($myQuery as $totals) {
			$hhTaCount->addRow([$totals->ta_name,$totals->totalHH]);
		}
		foreach ($mchnQuery as $mcptotals) {
			$mchnStat->addRow([$mcptotals->fdp_number,$mcptotals->totalHH]);
		}


		
		      //$hhTaCount
		$mchnStatChart=Lava::DonutChart('myDash3',$mchnStat,['title'=>'']);
		
		$dataChart=Lava::ColumnChart('Total', $hhTaCount,['title' => '',
    'titleTextStyle' => [
        'color'    => '#eb6b2c',
        'fontSize' => 14
    ]]);
		$nextChart=Lava::LineChart('Votes',$votes,['title'=>'Food Polls']);


			//filters
		 $filter=Lava::NumberRangeFilter(1,['minValue'=>1,'maxValue'=>50000]);
		  $filterVotes=Lava::NumberRangeFilter(1,['minValue'=>1,'maxValue'=>10000]);
		 	//controlWrappers
		 $control=Lava::ControlWrapper($filter,'control');
		 $controlVotes=Lava::ControlWrapper($filterVotes,'control-votes');
		 //chartWrappers
		 $chart=Lava::ChartWrapper($dataChart,'chart');
		 $chartVotes=Lava::ChartWrapper($nextChart,'chart2');
		


		 $myDash=Lava::Dashboard('myDash')->bind($control,$chart);
		 $myDash2=Lava::Dashboard('NextDash')->bind($controlVotes,$chartVotes);
		 



		return View::make('cmis/dashboard')->with('userName',$userName)->with('adminRole',$adminRole)->with('myDash',$myDash)
		->with('myDash3',$mchnStatChart)
		->with('NextDash',$myDash2);
		//return json_encode($myQuery);
	}

	
	

	public function logout(){
		Auth::logout();
		return Redirect::to('login');
	}
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
		$query=Input::all();
		if(Input::server("REQUEST_METHOD")=="POST"){
			$validator=Validator::make($query,[
				"username"=>"required|min:8",

				"password"=>"required|alpha_num|min:8",
				"re_password"=>"same:password"]);

			if($validator->passes()){
				$secret=$query['password'];
				$query['password']=Hash::make($secret);
				$userquery=User::create($query);
				if($userquery){
					 	$token = JWTAuth::fromUser($userquery);

   						return Response::json(compact('token'));
						
				}else{
						return json_encode($userquery);

				}
				

			}
			
		}
		
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
