@extends('masterDiner')
@section('content')
			<?php 
			$engine = App::make("getReporticoEngine");
		    $engine->initial_execute_mode = "MENU";
		    $engine->access_mode = "ONEPROJECT";
		    $engine->initial_project = "UBALE Purpose 2 Summary Reports";
		    $engine->clear_reportico_session = true;
	     	$engine->execute();
	     	?>
@stop