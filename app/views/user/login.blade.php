@extends('master')
@section('content')

   <div class="row">
        <div class="col-md-offset-20 col-md-4">
            <div class="form-login">
            		<h4>Welcome back.</h4>

            		{{Form::open()}}
		{{$errors->first("password")}}<br/>
		
		
		{{ Form::input('username', 'username', null, ['class' => 'form-control input-sm chat-input', 'placeholder' => 'UserName']) }}
		
		{{ Form::input('password', 'password', null, ['class' => 'form-control input-sm chat-input', 'placeholder' => 'Password']) }}
		            
		            </br>
		            <div class="wrapper">
			            <span class="group-btn">     
			               <button type="submit" class="btn btn-sm btn-primary ">Login<i class="fa fa-sign-in"></i></button> 
			               <a href="{{URL::to('/user/reset')}}" class="btn btn-sm btn-default forgot">Forgot your password?</a>
			            </span>
	            	</div>
	         {{Form::close()}}
            </div>
        
        </div>


       		 <div id="slides">
		      <img src="{{asset('img/Image1.jpg" alt="Photo by: CRS Wala Project ')}}">
		      <img src="{{asset('img/Image2.jpg" alt="Photo by: CRS Wala Project ')}}">
		      <img src="{{asset('img/Image3.jpg" alt="Photo by: CRS Wala Project ')}}">
		      <img src="{{asset('img/Image4.jpg" alt="Photo by: CRS Wala Project ')}}">
		      <img src="{{asset('img/Image5.jpg" alt="Photo by: CRS Wala Project ')}}">
    		</div>
   			The United in Building and Advancing Life Expectations (UBALE) program is a five year development assistance program in Southern Malawi	 led by </div><div> Catholic Relief Services (CRS) and funded by USAID-FFP.  The UBALE program is implemented in three districts namely Blantyre rural by Save the Children, Chikwawa by Chikwawa Diocese and Nsanje by CARE Malawi. The goal of UBALE program is to reduce chronic malnutrition and food insecurity and build resilience among vulnerable populations in the aforementioned districts of Malawi.

      </div>


@stop
