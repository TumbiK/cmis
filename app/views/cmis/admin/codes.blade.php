@extends('masterCodes')
@section('content')

<div id="cc" class="easyui-layout" style="width:900px;height:486px;">
<div data-options="region:'west',title:'Code Details',split:true" style="width:258px;">
<div class="easyui-accordion" style="width:250px;height:340px;">
	<div title="Codes Information" data-options="icoCls:'icon-ok'" style="overflow:auto;padding:10px">
		<h4 style="color:#0099FF">Codes Details </h4>
		<ul>
			<p><a href="#" class="easyui-linkbutton"  plain="true" onclick="javascript:$('#pTA').panel('open');$('#pGVH').panel('close');$('#pVil').panel('close')">Add TA Codes</a></p>
			<p><a href="#" class="easyui-linkbutton"  plain="true" onclick="javascript:$('#pGVH').panel('open');$('#pTA').panel('close');$('#pVil').panel('close')">Add GVH Codes</a></p>
			<p><a href="#" class="easyui-linkbutton"  plain="true" onclick="javascript:$('#pVil').panel('open');$('#pGVH').panel('close');$('#pTA').panel('close')">Add Village Codes</a></p>
			
		</ul>


	</div>
	<div title="Transfers"  style="padding:10px">
		<h4 style="color:#0099FF">Transfer Details </h4>		
		<ul>
			<li><a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:$('#pTransGroup').panel('open');$('#pTransInd').panel('close');$('#pVil').panel('close');$('#pGVH').panel('close');$('#pTA').panel('close')">Village Transfer</a></li>
			<li><a href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="javascript:$('#pTransInd').panel('open');$('#pTransGroup').panel('close');$('#pVil').panel('close');$('#pGVH').panel('close');$('#pTA').panel('close')">HouseHold Transfer</a></li>
			<li><a href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="javascript:$('#pTransIndMem').panel('open');$('#pTransInd').panel('close');$('#pTransGroup').panel('close');$('#pVil').panel('close');$('#pGVH').panel('close');$('#pTA').panel('close')">Individual Member Transfer</a></li>

			
		</ul>
	</div>
	<div title="Institutions"  style="padding:10px">
		<h4 style="color:#0099FF">Institution Details </h4>		
		<ul>
			<li><a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:$('#pInstitutions').panel('open');">Add New Institution</a></li>

			
		</ul>
	</div>

	<div title="Localisation"  style="padding:10px">
		<h4 style="color:#0099FF">Localisation Details </h4>		
		<ul>
			<li><a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="location.href = '{{URL::to('ubale_fy')}}'">Add Financial Year</a></li>
			<li><a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="location.href = '{{URL::to('ubale_cutoff')}}'">Add Cut OFF Dates</a></li>

			
		</ul>
	</div>
	
</div>
</div>
<div data-options="region:'center'" style="padding:5px;">
	<div id="pTA" class="easyui-panel" title="Add or Modify TA Details" style="width:630px;height:450px;padding:10px;" closed="true">
        <table id="dgTa"  style="width:600px;height:450px"
		 toolbar="#toolbar" method="get" rownumbers="false" fitcolumns="true" singleSelect="true" url="/hhdetails" pagination="false" idField="HH_Number">
		 <thead>
		<tr>
			<th field="Rec_Id_District" width="30">District</th>
			<th field="Rec_ID" width="30">TA No.</th>
			<th field="TA_ID" width="30">TA ID</th>
			<th field="TA_Name" width="80">TA Name</th>
			
			
						
		</tr>
		</thead>
        	
        </table>
        <div id="toolbar" style="padding:5px;height:auto">
		<div>
				{{Form::open(array('id'=>'frm_household'))}}
				District
				{{Form::select('district',$dist_options,null,array('id'=>'district'))}}
							
				{{Form::close()}}
		</div>

		<div style="margin-bottom:5px">
		<a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="addTA()">Add TA</a>		
		<a href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editTA()">Edit TA</a>

		</div> 
    </div>
	</div>

	<div id="pInstitutions" class="easyui-panel" title="Add or Modify Institution Members Details" style="width:630px;height:450px;padding:10px;" closed="true">
        <table id="dgInst"  style="width:600px;height:450px"
		 toolbar="#instbar" method="get" rownumbers="true" fitcolumns="true" singleSelect="true" url="/trainDetails" pagination="false" idField="HH_Number">
		 <thead>
		<tr>
			<th field="name_of_participant">Name of Member</th>
			<th field="Sex" >Sex</th>
			<th field="age" >Age</th>
			<th field="designation">Desigination</th>
			<th field="contact">Conatct/Email</th>
			<th field="reg_date">Registration</th>	
			
			
						
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

	<div id="dlgInst" class="easyui-dialog" style="width:520px;height:420px;padding:20px 5px"
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
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveTA()" >Save Member</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlgInst').dialog('close')" style="width:90px">Cancel</a>
</div>

	<div id="pGVH" class="easyui-panel" title="Add or Modify GVH Details" style="width:730px;height:450px;padding:10px;" closed="true">
        <table id="dgGvh"  style="width:600px;height:450px"
		 toolbar="#tolbar" method="get" rownumbers="false" fitcolumns="true" singleSelect="true" url="/hhdetails" pagination="false" idField="HH_Number">
		 <thead>
		<tr>
			<th field="Rec_id">GVH No.</th>
			<th field="GVH_ID" width="80">GVH ID</th>
			<th field="GVH_Name" width="80">GVH Name</th>						
		</tr>
		</thead>
        	
        </table>
        <div id="tolbar" style="padding:5px;height:auto">
		<div>
		   <a id="split" class="easyui-linkbutton" href="#frm_splitGvh">Split GVH</a>
		   <hr>
				{{Form::open(array('id'=>'frm_splitGvh'))}}
				District
				{{Form::select('dist',$dist_options,null,array('id'=>'dist'))}}
				TA
		
				{{Form::select('taSelect',array(null=>'Select'),null,array('id'=>'taSelect'))}}

					<hr>
				<p id="spliLoc">

				GVH

				{{Form::select('gvhSelx',array(null=>' Select'),null,array('id'=>'gvhSelx'))}}
				</p>
				{{Form::close()}}
		

		</div>

		<div style="margin-bottom:5px">
		<a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="addGVH()">Add GVH</a>		
		<a href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editGVH()">Edit GVH</a>

		</div> 
    </div>
	</div>
	<div id="pTransInd" class="easyui-panel" title="Transfer Villages and HouseHolds" style="width:630px;height:450px;padding:10px;" closed="true">
        <table id="dgTransInd"  style="width:600px;height:450px"
		 toolbar="#TransIBar" method="get" rownumbers="false" fitcolumns="true" url="/hhdetails" pagination="false">
		 <thead>
		<tr>
			<th field="ck" checkbox="true"></th>	
			<th field="HH_Number" width="30">HH Number</th>
			<th field="HH_Member_Number" width="30">HH_Member_Number</th>
			<th field="Name_of_HH_member" width="30">Name_of_HH_member</th>
			<th field="Age" width="80">Age</th>
			<th field="Sex" width="80">Sex</th>
			<th field="dob" width="80">Date Of Birth</th>


			
			
						
		</tr>
		</thead>
        	
        </table>
        <div id="TransIBar" style="padding:5px;height:auto">
		<div>
				{{Form::open(array('id'=>'frm_household'))}}
				District
				{{Form::select('disTransInd',$dist_options,null,array('id'=>'disTransInd'))}}

				TA

				{{Form::select('taTransInd',array(null=>'Select'),null,array('id'=>'taTransInd'))}}

				GVH
				{{Form::select('gvhSelTransInd',array(null=>' Select'),null,array('id'=>'gvhSelTransInd'))}}
				Village
				{{Form::select('vilSelTrans',array(null=>' Select'),null,array('id'=>'vilSelTrans'))}}

				
				<hr>
				<div>
				Transfer
				TA

				{{Form::select('taTransIndTo',array(null=>'Select'),null,array('id'=>'taTransIndTo'))}}

				 GVH
				{{Form::select('gvhSelTransToInd',array(null=>' Select'),null,array('id'=>'gvhSelTransToInd'))}}

				Village
				{{Form::select('vilSelTransTo',array(null=>' Select'),null,array('id'=>'vilSelTransTo'))}}

				<a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="transferInd()">Tranfer</a>

				</div>

				{{Form::close()}}
		</div>		
    </div>
	</div>
	
	<div id="pTransIndMem" class="easyui-panel" title="Transfer Villages and HouseHolds" style="width:630px;height:450px;padding:10px;" closed="true">
        <table id="dgTransImem"  style="width:600px;height:450px"
		 toolbar="#TransMemBar" method="get" rownumbers="false" fitcolumns="true" url="/hhdetails" pagination="false">
		 <thead>
		<tr>
			<th field="ck" checkbox="true"></th>	
			
			<th field="HH_Member_Number" width="30">HH_Member_Number</th>
			<th field="Name_of_HH_member" width="30">Name_of_HH_member</th>
			<th field="Age" width="80">Age</th>
			<th field="Sex" width="80">Sex</th>
			<th field="dob" width="80">Date Of Birth</th>


			
			
						
		</tr>
		</thead>
        	
        </table>
        <div id="TransMemBar" style="padding:5px;height:auto">
		<div>
				{{Form::open(array('id'=>'frm_household'))}}
				District
				{{Form::select('disTransImem',$dist_options,null,array('id'=>'disTransImem'))}}

				TA

				{{Form::select('taTransImem',array(null=>'Select'),null,array('id'=>'taTransImem'))}}

				GVH
				{{Form::select('gvhSelTransImem',array(null=>' Select'),null,array('id'=>'gvhSelTransImem'))}}
				Village
				{{Form::select('vilSelTransImem',array(null=>' Select'),null,array('id'=>'vilSelTransImem'))}}
					HH Number 
				<input id="hh_number" name="hh_number" style="width:80px" class="easyui-textbox" data-option="required:true">	
				<a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="checkHH()">Check HouseHold</a>
				<hr>
				<div>
				Transfer Member
				TA

				{{Form::select('taTransImemTo',array(null=>'Select'),null,array('id'=>'taTransImemTo'))}}

				 GVH
				{{Form::select('gvhSelTransTomem',array(null=>' Select'),null,array('id'=>'gvhSelTransTomem'))}}

				Village
				{{Form::select('vilSelTransTomem',array(null=>' Select'),null,array('id'=>'vilSelTransTomem'))}}

				<a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="transferImem()">Tranfer</a>

				</div>

				{{Form::close()}}
		</div>		
    </div>
	</div>
	<div id="pTransGroup" class="easyui-panel" title="Transfer Villages and HouseHolds" style="width:630px;height:450px;padding:10px;" closed="true">
        <table id="dgTransG"  style="width:600px;height:450px"
		 toolbar="#TransBar" method="get" rownumbers="false" fitcolumns="true" url="/hhdetails" pagination="false" singleSelect="true">
		 <thead>
		<tr>
			<th field="ck" checkbox="true"></th>	
			<th field="Rec_id_GVH" width="30">GVH</th>
			<th field="Rec_id" width="30">Village Id.</th>
			<th field="Village_ID" width="30">Village Number</th>
			<th field="Village_Name" width="80">Village Name</th>
			
			
						
		</tr>
		</thead>
        	
        </table>
        <div id="TransBar" style="padding:5px;height:auto">
		<div>
				{{Form::open(array('id'=>'frm_household'))}}
				District
				{{Form::select('disTrans',$dist_options,null,array('id'=>'disTrans'))}}

				TA

				{{Form::select('taTrans',array(null=>'Select'),null,array('id'=>'taTrans'))}}

				GVH
				{{Form::select('gvhSelTrans',array(null=>' Select'),null,array('id'=>'gvhSelTrans'))}}

				<hr>

				<div>
				
				Transfer To GVH
				{{Form::select('gvhSelTransTo',array(null=>' Select'),null,array('id'=>'gvhSelTransTo'))}}
				<a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="transfer()">Tranfer Group</a>

				</div>

				{{Form::close()}}
		</div>		
    </div>
	</div>
	<div id="pVil" class="easyui-panel" title="Add or Modify Village Details" style="width:630px;height:450px;padding:10px;" closed="true">
        <table id="dgVil"  style="width:600px;height:450px"
		 toolbar="#tlbar" method="get" rownumbers="false" fitcolumns="true" singleSelect="true" url="/hhdetails" pagination="false" idField="HH_Number">
		 <thead>
		<tr>
			<th field="Rec_id" width="30">Village Id.</th>
			<th field="Village_ID" width="30">Village Number</th>
			<th field="Village_Name" width="80">Village Name</th>			
		</tr>
		</thead>
        	
        </table>
        <div id="tlbar" style="padding:5px;height:auto">
		<div>
				{{Form::open(array('id'=>'frm_household'))}}
				District
				{{Form::select('distNgv',$dist_options,null,array('id'=>'distNgv'))}}

				TA

				{{Form::select('taNSel',array(null=>'Select'),null,array('id'=>'taNSel'))}}

				GVH
				{{Form::select('gvhSelVil',array(null=>' Select'),null,array('id'=>'gvhSelVil'))}}

				{{Form::close()}}
		</div>

		<div style="margin-bottom:5px">
		<a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="addVillage()">Add Village</a>		
		<a href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editVillage()">Edit Village</a>
		</div> 
    </div>
	</div>
	<div id="dlg" class="easyui-dialog" style="width:450px;height:280px;padding:20px 5px"
        closed="true" buttons="#dlg-ta">
    <div class="ftitle">Village Information</div>
    <form id="fm" method="get" novalidate>
        <div class="fitem">
            <label>District:</label>
            <input name="Rec_Id_District" id="Rec_Id_District" class="easyui-textbox" required="true" readonly="false">
        </div>
        <div class="fitem">
            <label>TA ID:</label>
            <input name="TA_ID" id="TA_ID" class="easyui-textbox" required="true" readonly="false">
        </div>
        <div class="fitem">
            <label>TA Name</label>
            <input name="TA_Name" class="easyui-textbox">
        </div>
    </form>
</div>
<div id="dlg-ta">
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveTA()" style="width:90px">Save</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancel</a>
</div>


<div id="dlgGvh" class="easyui-dialog" style="width:450px;height:280px;padding:20px 5px"
        closed="true" buttons="#dlgGvh-buttons">
    <div class="ftitle">GVH Information</div>
    <form id="fmGvh" method="get" novalidate>
       
        <div class="fitem">
            <label>TA:</label>
            <input name="Rec_id_TA" id="Rec_id_TA" class="easyui-textbox" required="true" readonly="true">
        </div>
        <div class="fitem">
            <label>GVH ID:</label>
            <input name="GVH_ID" id="GVH_ID" class="easyui-textbox" required="true" readonly="true" >
        </div>
        <div class="fitem">
            <label>GVH Name</label>
            <input name="GVH_Name" id="GVH_Name" class="easyui-textbox">
        </div>
        <div class="fitem">
         
            <input name="Wala_id" id="Wala_id" class="easyui-textbox">
        </div>
    </form>
</div>
<div id="dlgGvh-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveTA()" style="width:90px">Save</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlgGvh').dialog('close')" style="width:90px">Cancel</a>
</div>

<div id="dlgVil" class="easyui-dialog" style="width:450px;height:280px;padding:20px 5px"
        closed="true" buttons="#dlgVil-buttons">
    <div class="ftitle">TA Information</div>
    <form id="fmVil" method="get" novalidate>
        <div class="fitem">
            <label>GVH ID:</label>
            <input name="Rec_id_GVH" id="Rec_id_GVH" class="easyui-textbox" required="true" readonly="true">
        </div>
        <div class="fitem">
            <label>Village ID:</label>
            <input name="Village_ID" id="Village_ID" class="easyui-textbox" required="true" readonly="true">
        </div>
        <div class="fitem">
            <label>Village Name</label>
            <input name="Village_Name" class="easyui-textbox">
        </div>
    </form>
</div>
<div id="dlgVil-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveTA()" style="width:90px">Save</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlgVil').dialog('close')" style="width:90px">Cancel</a>
</div>

<div id="dlgTransGroup" class="easyui-dialog" style="width:450px;height:280px;padding:20px 5px"
        closed="true" buttons="#dlg-buttons" modal="true">
    <div class="ftitle">Village Information</div>
    {{Form::open(array('id'=>'frm_trFinal'))}}
				
				GVH
				{{Form::select('gvhSelTrans',array(null=>' Select'),null,array('id'=>'gvhSelTrans'))}}

				<a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="transfer()">Tranfer Group</a>

				{{Form::close()}}
</div>
</div>
</div>
</div>
@stop