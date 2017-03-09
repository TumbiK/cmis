@extends('masterAdmin')
@section('content')
<div class="easyui-accordion" style="width:250px;height:300px;">
	<div title="User Registration" data-options="icoCls:'icon-ok'" style="overflow:auto;padding:10px">
		<h4 style="color:#0099FF">User Details </h4>
		<ul style=" list-style-type: none; ">
			<li><a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="addUser()">Add New Users</a></li>
			<li><a href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editUser()">Modify User Details</a></li>
			<li><a href="#" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="removeUser()">Delete Existing User</a></li>
		</ul>


	</div>
	<div title="Tranfers" data-options="iconCls:'icon-help'" style="padding:10px">
		<h4 style="color:#0099FF">Village Level Transfers </h4>		
		<p>The Accordion allows yo to provide multiple panels and display one or more at a time </p>
	</div>
	
</div>
<div id="dlg" class="easyui-dialog" style="width:500px;height:400px;padding:1px 32px" closed="true" buttons="#dlg-buttons" data-options="resizable:true,modal:true">
<div class="ftitle">User Details</div>

	<form id="ff" method="post" style="padding:10px 20px 10px 40px;">

		<div class="fitem">
			<label>Name</label>
			<input class="easyui-textbox" name="username" data-options="required:true" />
		</div>
		<div class="fitem">
			<label>Password</label>
			<input class="easyui-textbox" id="password" name="password" type="password" data-options="required:true" />
		</div>
		<div class="fitem">
			<label>Re Type Password</label>
			<input class="easyui-textbox" id="re_password" name="re_password" type="password" required="required" validType="equals['#password']" />
		</div>
		<div class="fitem">
			<label>Email</label>
				<input type="text" class="easyui-textbox" name="email" data-options="validType:'email'"/>
			</div>
		<div class="fitem">
			<label>Phone Number</label>
				<input type="text" class="easyui-textbox" name="phone" data-options="required:true"/>
			</div>
		<div class="fitem">
		<label>District</label>
		<input class="easyui-combobox" name="dist_id" data-options="
		valueField: 'value',
		textField: 'label',
		data: [{
			label: 'Blantyre Rural',
			value: '11'
		},{
			label: 'Chikwawa',
			value: '2'
		},
		{
			label: 'All Districts',
			value: '00'
		},
		{
			label: 'Nsanje',
			value: '7'
		}]" />
		
		</div>
		<div class="fitem">
			<label>Admin</label>
			<input class="easyui-combobox" name="is_admin" data-options="
		valueField: 'value',
		textField: 'label',
		data: [{
			label: 'Admin User',
			value: '1'
		},
		{
			label: 'Superuser',
			value: '0'
		},
		{
			label: 'User Entry',
			value: '2'
		}]" />
		</div>
		
	</form>
</div>
	<div id="dlg-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveUser()" style="width:90px">Submit</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancel</a>
</div>

@stop