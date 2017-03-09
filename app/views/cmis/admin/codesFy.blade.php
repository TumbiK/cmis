@extends('masterCodes')
@section('content')

<div id="cc" class="easyui-layout" style="width:900px;height:486px;">
    
        <table id="dgInst"  style="width:600px;height:450px" fit="true"
		 toolbar="#instbar" method="get" rownumbers="true" fitcolumns="true" singleSelect="true" url="/trainDetails" pagination="false" idField="HH_Number">
		 <thead>
		<tr>
			<th field="year">Year</th>
			<th field="open_date" >Start Date</th>
			<th field="end_date" >Close Date</th>
			<th field="designation">Description</th>
			
			
			
						
		</tr>
		</thead>
        	
        </table>
        <div id="instbar" style="padding:5px;height:auto">
		<div>
				 Institution: 

        <input name="institution" id="institution" class="easyui-combobox" data-options="
             valueField:'rec_id',
             textField:'institution_name',
             url:'institution?id='+0,
             onSelect:function(rec){
             	$('#dgInst').datagrid('load',{id:rec.rec_id})

         		}" style="width:200px;">

		</div>

		<div style="margin-bottom:5px">
		<a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="addInstMember()">Add Institution Member</a>		
		<a href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="EditInstMember()">Edit Institution Member</a>

		</div> 
    
	</div>

	
    	</div>
	<div id="dlgFY" class="easyui-dialog" style="width:520px;height:420px;padding:20px 5px"
        closed="true" buttons="#dlg_inst">
    <div class="ftitle">Institution Member Information</div>
    <form id="fmInst" method="get" novalidate>
    	<div class="fitem">
            <label>Institution Number:</label>
            <input name="institution" id="inst" class="easyui-textbox" required="true" readonly="false" >
        </div>
        <div class="fitem">
            <label>Member Name:</label>
            <input name="name_of_participant" id="name_of_participant" class="easyui-textbox" required="true" >
        </div>
        <div class="fitem">
            <label>Sex:</label>
            <input name="Sex" id="Sex" class="easyui-textbox" required="true">
        </div>
        <div class="fitem">
            <label>Age</label>
            <input name="age" class="easyui-textbox">
        </div>
        <div class="fitem">
            <label>Designation</label>
            <input name="designation" class="easyui-textbox">
        </div>
        <div class="fitem">
            <label>Contact</label>
            <input name="contact" class="easyui-textbox">
        </div>
        <div class="fitem">
            <label>Registration Date</label>
            <input name="reg_date" class="easyui-datebox">
        </div>  
    </form>
</div>
  <div id="dlg_inst">
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveFY()" >Save Member</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlgInst').dialog('close')" style="width:90px">Cancel</a>
</div>
	
	


@stop