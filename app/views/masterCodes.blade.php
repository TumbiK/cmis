<!DOCTYPE html>
<html>
<head>
	<title>CRS CMIS Ver 2 </title>
	<link rel="icon" type="image/ico" href="{{asset('favicon-96x96.png')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('bootstrap-3.3.2-dist/css/bootstrap.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('style.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('jquery-easyui-1.4.1/themes/icon.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('jquery-easyui-1.4.1/themes/default/easyui.css')}}">
	
	<script type="text/javascript" src="{{asset('jquery-easyui-1.4.1/jquery.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('customUIscript.js')}}"></script>

	
	<script type="text/javascript" src="{{asset('bootstrap-3.3.2-dist/js/bootstrap.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('jquery-easyui-1.4.1/jquery.easyui.min.js')}}"></script>
	
	<script type="text/javascript" src="{{asset('AdminScript.js')}}"></script>
	
	<script type="text/javascript" src="{{asset('jquery.chained.remote.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('datagrid-detailview.js')}}"></script>

	
	

	
	
	

	<!-- DataTables CSS -->

</head>
<body>
	
	@include('headerM')
	
	
		<div class="container">
			@yield('content')
		</div>
	<div class="footer">
		@include('footer')
	</div>

</body>
</html>