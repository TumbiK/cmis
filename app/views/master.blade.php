<!DOCTYPE html>
<html>
<head>
	<title>CRS CMIS Ver 2 </title>
	<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="{{asset('bootstrap-3.3.2-dist/css/bootstrap.css')}}">
	<link rel="icon" type="image/ico" href="{{asset('favicon-96x96.png')}}">
  <link rel="stylesheet" href="{{asset('font-awesome.min.css')}}">
   <link rel="stylesheet" type="text/css" href="{{asset('slidez.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('style.css')}}">


	<script type="text/javascript" src="{{asset('jquery-easyui-1.4.1/jquery.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('jquery-easyui-1.4.1/jquery.easyui.min.js')}}"></script>
	<script type="text/javascript" src="http://www.jeasyui.com/easyui/datagrid-detailview.js"></script>
	<script src="{{asset('js/jquery.slides.min.js')}}"></script>
	<script src="{{asset('js/slide.js')}}"></script>
	<script type="text/javascript" src="{{asset('datagrid-detailview.js')}}"></script>
</head>
<body>
	@include('header')
	
		<div class="container">
			@yield('content')
		</div>
	<div class="footer">
		@include('footer')
	</div>

</body>
</html>