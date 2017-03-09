@extends('master')
@section('content')

	{{Form::open(array('url'=>'','method'=>'post'))}}
		{{$errors->first("password")}}<br/><br/>
		{{Form::label("emai","email")}}
		{{Form::text("email",Input::old("email"))}}
		{{Form::text("username",Input::old("username"))}}
		{{Form::label("password","Password")}}
		{{Form::password("password")}}
		{{Form::submit("login")}}

	{{Form::close()}}
@stop