@extends('masterMain')
@section('content')
<style type="text/css">
		#fm{
			margin:0;
			padding:10px 30px;
		}
		.ftitle{
			font-size:14px;
			font-weight:bold;
			padding:5px 0;
			margin-bottom:10px;
			border-bottom:1px solid #ccc;
		}
		.fitem{
			margin-bottom:5px;
		}
		.fitem label{
			display:inline-block;
			width:220px;
		}
		.fitem input{
			width:200px;
		}
	</style>



<table id="dg" title="HouseHold Listing Details" style="width:950px;height:500px"
		 toolbar="#toolbar" method="GET" rownumbers="false" fitcolumns="true" singleSelect="true" url="/hhdetails" pagination="true" idField="HH_Number">
		<thead>
		<tr>

			<th field="HH_Number" width="80">HH Number</th>
			<th field="Name_of_HH_member" width="80">HH Name</th>
			<th field="Sex" width="80">HH Sex</th>
			<th field="dob" width="80">HH Date of Birth</th>
			<th field="Age" width="80">HH Head Age</th>
			<th field="hh_size" width="80">HH Size</th>
			<th field="comments" width="80">Remarks</th>
			<th field="Ben_Reg_date" width="80">Registration Date</th>
			
			
			

			
		</tr>
		</thead>
	</table>
	<div id="toolbar" style="padding:5px;height:auto">
		<div>
				
				{{Form::open(array('id'=>'frm_household','method'=>'get'))}}
				District
				{{Form::select('district',$dist_options,null,array('id'=>'district'))}}
							
				TA

				{{Form::select('taSel',array(null=>'Select'),null,array('id'=>'taSel'))}}

				GVH
				{{Form::select('gvhSel',array(null=>' Select'),null,array('id'=>'gvhSel'))}}

				
				Village
				{{Form::select('vilSel',array(null=>' Select'),null,array('id'=>'vilSel'))}}

				Registration Date
		<input id="reg_dat" name="reg_dat" style="width:90px" class="easyui-datebox" >
				{{Form::close()}}
		</div>
		<div style="margin-bottom:5px">
		<input id="addHH" name="addNew" style="width:80px" class="easyui-validatebox" data-option="required:true">	

		
		
		<a href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editItem()">Edit HouseHold</a>
		</div>


	</div>
<div id="dlg" class="easyui-dialog" style="width:660px;height:400px;padding:1px 32px" closed="true" buttons="#dlg-buttons" data-options="resizable:true,modal:true">
	<div class="ftitle">Household Details</div>
	<form id="fm" method="GET" novalidate>		
		<div class="fitem">
			<label>HouseHold Number  :</label>
			<input name="HH_Number" id="HH_Number" class="easyui-textbox" type="text" required="true" >
		</div>

		<div class="fitem">
			<label>HH Head Name:</label>
			<input name="Name_of_HH_member" id="Name_of_HH_member" class="easyui-textbox" type="text" required="true">
		</div>

		<div class="fitem">
			<label>HH Head sex (1- Male or 2- Female):</label>
			<input name="Sex" id="Sex" class="easyui-numberbox" type="text" required="true" validType="sizeRange[1,2]" width="1">			
		</div>
		<div class="fitem">
			<label>Date of Birth:(DD/MM/YYYY)</label>
			<input id="dobMain" name="dob" class="easyui-datebox">
		</div>
		<div class="fitem">
			<label>HH age:</label>
			<input id="Age" name="Age" class="easyui-numberbox"  validType="ageRange[8,100]" required="true">
		</div>
		<div class="fitem">
			<label>HH size:</label>
			<input id="hh_size" name="hh_size" class="easyui-numberbox" validType="sizeRange[1,15]" required="true" placeholder="Remarks">
		</div>
		<div class="fitem">	
			<label>Remarks:</label>
			<input name="comments" class="easyui-textbox" type="text" data-options="multiline:true" style="height:60px;" >
		</div>
	
		<div class="fitem">
			<label>Registration Date:</label>
			<input id="Ben_Reg_date" name="Ben_Reg_date" class="easyui-datebox" required="true">
		</div>
		
	</form>		
	</div>
	<div id="dlg-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveHH()" style="width:90px">Submit</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancel</a>
</div>
	
<div id="dlgEdit" class="easyui-dialog" style="width:840px;height:400px;padding:1px 32px" toolbar="#tb" closed="true" buttons="#dlgEdit-buttons" data-options="resizable:true,modal:true">
	<div class="ftitle">Edit Household Member Details</div>

	  <table id="tt" style="width:780px;height:200px" pagination="false">
	  
	  	
	  </table>
	  <div id="tb" style="height:auto">
		<a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="insert()">New</a>
		
	</div>
	</div>
	<div id="dlgEdit-buttons">
    
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlgEdit').dialog('close')" style="width:90px">Cancel</a>
</div>

		
		
@stop
