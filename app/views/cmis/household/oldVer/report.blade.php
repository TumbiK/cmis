@extends('masterMain')
@section('content')
	
<div id="controller">
<div id="header">
	<h3>HouseHold Details Report</h3>

<form action="POST" class="form-inline" role="form" id="repSel">
<div class="form-group">
<select id="group" name="group" class="form-control">
  <option value="">Group By</option>
  <option value="District">District</option>
  <option value="2">Partner</option>
</select>
</div>
<div class="form-group">
<select id="ta_id" name="ta_id" class="form-control">
  <option value="">District/Partner</option>
</select>
</div>
<div class="form-group">
<select id="model" name="model" class="form-control">
  <option value="">TA</option>
</select>
</div>
<div class="form-group">

<select id="engine" name="engine" class="form-control">
  <option value="">GVH</option>
</select>
</div>
<div class="form-group">
<button class="btn btn-primary" type="submit">Open Report</button>
</div>
</form>
<br><br>
</div>

<p></p>
<div id="left" style="width:20%;float:left">
<ul id="menu">
	<li class="active"><a href="#">HouseHold</a>
		<ul>
			<li><a href="#">Register </a></li>
			<li><a href="#">Report</a></li>
			<li><a href="#">Comments</a></li>
		</ul>
	</li>
	<li><a href="#">Beneficiary</a>
		<ul>
			<li><a href="#">Add Beneficiries</a></li>
			<li><a href="#">Remove Beneficiaries</a></li>
			<li><a href="#">Edit Beneficiaries</a></li>
		</ul>
	</li>
	<li><a href="#">UBALE</a>
		<ul>
			<li><a href="#">MCHN</a></li>
			<li><a href="#">AGRICULTURE AND NRM</a></li>
			<li><a href="#">VSL AND AGRI BUSINESS</a></li>
			<li><a href="#">COMMODITIES</a></li>
		</ul>
	</li>
</ul>

</div>

	<table id="dg" title="My Users" class="easyui-datagrid" style="width:550px;height:250px"
url="users"
toolbar="#toolbar"
rownumbers="true" fitColumns="true" singleSelect="true">
<thead>
<tr>
<th field="firstname" width="50">First Name</th>
<th field="lastname" width="50">Last Name</th>
<th field="phone" width="50">Phone</th>
<th field="email" width="50">Email</th>
</tr>
</thead>
</table>
 
  
  


  




@stop