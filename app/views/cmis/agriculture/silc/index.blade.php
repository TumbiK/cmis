@extends('masterDiner')
@section('content')
<div class="easyui-layout" fit="true">
  <div id="content" region="center">
<table id="dgSilc" fit="true"  
        data-options="url:'silc_reg',fitColumns:true,singleSelect:true,rownumbers:true" 
         toolbar="#toolbar" idField="HH_Number" 
        >
    <thead>
        <tr>
            
            <th data-options="field:'village_name'"> Village</th>
            <th data-options="field:'HH_Number'">HH ID</th>
            
            <th data-options="field:'Name_of_HH_Member'">Name of SILC Member</th>

            <th data-options="field:'Sex'">Gender</th>
            <th data-options="field:'dob'">Date of Birth</th>
            <th data-options="field:'Age'">Age</th>

            <th data-options="field:'position'" editor="{type:'combobox',
            options:{
                        valueField:'rec_id',
                        textField:'position',
                        data:[{rec_id_id:1,position:'Chairman'},{rec_id:2,position:'Secretary'},{rec_id:3,position:'Treasure'},{rec_id:4,position:'Member'}],
                        required:true
                    }}">Position</th>
            <th data-options="field:'date_joining'">Date of Joining</th>
            <th data-options="field:'date_leaving'" editor="{type:'datebox',
            options:{require:true}}">Date of leaving</th>
            
            
        
            <th field='action' formatter="optRowSilc">Action</th>
            

  
            
        </tr>
    </thead>
</table>
</div>
</div>

<div id="toolbar"style="padding:5px;height:auto">
<div style="margin-bottom:5px">
     District:
     <input name="district" id="cc1" class="easyui-combobox" data-options="
        valueField: 'rec_id',
        textField: 'district',
        url:'code_dist',
        onSelect: function(rec){         
            var url = 'code_ta?id='+rec.rec_id;
             var url2='code_ss?id='+rec.rec_id;
            $('#cc2').combobox('reload', url);
             $('#cc8').combobox('reload', url2);
        }" style="width:100px;">
        
     TA:
        <input name="ta" id="cc2" class="easyui-combobox" data-options="
        valueField:'rec_id',
        textField:'ta',
        onSelect: function(rec){          
            var url = 'code_Gv?id='+rec.rec_id;
            var url3='silc_psp?id='+rec.rec_id;
            $('#cc3').combobox('reload', url);
            $('#cc4').combobox('reload', url3);
            $('#cc5').combobox('reload', url3);

        }"style="width:100px;">
        
         GVH
             <input name="gvh" id="cc3" class="easyui-combobox" data-options="
             valueField:'rec_id',
             textField:'gvh',
             onSelect: function(rec){
          
            var url = 'app_prop?id='+rec.rec_id;
            var url2='code_vil?id='+rec.rec_id;
            var url1='silc_group?id='+rec.rec_id;
                        
            $('#cc4').combobox('reload', url1);
            $('#cc6').combobox('reload', url2);
            
           

        }"style="width:100px;">
        Silc Group:
        <input name="project" id="cc4" class="easyui-combobox" data-options="
             valueField:'rec_id',
             textField:'group_name',
             onSelect: function(rec){
            $('#dgSilc').datagrid('load',{
                    editHH:$('#HH_Number').textbox('getText'),
                    code_dist:$('#cc1').combobox('getValue'),
                    code_ta: $('#cc2').combobox('getValue'),
                    code_gvh:$('#cc3').combobox('getValue'),
                    code_village:$('#cc6').combobox('getValue'),
                    Silc_group:$('#cc4').combobox('getValue')

             });
            var url = 'app_prop?id='+rec.rec_id;

            
        }" style="width:110px;">
      
       PSP/FA:
        <input name="gvh" id="cc5" class="easyui-combobox" data-options="
             valueField:'rec_id',
             textField:'psp_name',
             onSelect: function(rec){
           
        }" style="width:110px;">
        
        
        Field Supervisor:
        <input name="SSFS" id="cc8" class="easyui-combobox" data-options="
             valueField:'rec_id',
             textField:'ss_supervisor',
             onSelect: function(rec){
           
        }" style="width:110px;">
        
       

        </div>
        
       
        <div>        
        
        Village:
        <input name="gvh_name" id="cc6" class="easyui-combobox" data-options="
             valueField:'rec_id',
             textField:'village_name'" style="width:100px;">
        Date Joinining
        <input name="date_registration" id="cc7" class="easyui-datebox" style="width:100px;">

        HH Number:
        <input name="HH_Number" id="HH_Number" class="easyui-textbox" style="width:80px;" iconCls="icon-add" data-options="
        onChange:function(rec){
            addBeneficiary();

        }">

        <a href="#" class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="addSilcGroup()">Add SILC Group</a> 
    <a href="#" class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="addPSP()">Add PSP</a> 
    

       
    </div>

    

</div>

    
   
<div id="dlgEdit" class="easyui-dialog" style="width:840px;height:400px;padding:1px 32px" toolbar="#tb" closed="true" buttons="#dlgEdit-buttons" data-options="resizable:true,modal:true">
    <div class="ftitle">SILC Beneficiary Beneficiary Registration</div>

      <table id="tt" style="width:780px;height:200px" pagination="false">
              
      </table>
      <div id="tb" style="height:auto">
        <a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="insert()">New Member</a>
        
    </div>
    </div>
    <div id="dlgEdit-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveSilcBen()" style="width:90px">Add </a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlgEdit').dialog('close')" style="width:90px">Cancel</a>
</div>

<div id="dlgSilcGroup" title="SILC Group- Dialog" class="easyui-dialog" style="width:430px;height:240px;padding:20px 5px"
        closed="true" buttons="#dlgMark-buttons">
    <div class="ftitle">ADD SILC GROUP</div>
    <form id="fmSilcGroup" method="get" novalidate>

        <div class="fitem">
          <input name="Rec_id_district" id="Rec_id_district" class="easyui-textbox" required="true" readonly="true">  
        </div>    
        <div class="fitem">
            <input name="Rec_id_TA" id="Rec_id_TA" class="easyui-textbox" required="true" readonly="true">
        </div>
        <div class="fitem">
          <input name="Rec_id_gvh" id="Rec_id_gvh" class="easyui-textbox" required="true" readonly="true">  
        </div>
        <div class="fitem">
          <input name="psp_id" id="psp_id" class="easyui-textbox" required="true" readonly="true">  
        </div>
        <div class="fitem">
            <label>SILC Group Name</label>
            <input name="group_name" id="group_name" class="easyui-textbox" required="true">            
        </div>
        <div class="fitem">
            <label>SAVIX Group Number</label>
            <input name="savix_number" id="savix_number" class="easyui-textbox" required="true">            
        </div>
         <div class="fitem">
            <label>SILC Date Formation</label>
            <input name="date_formation" id="date_formation" class="easyui-datebox" required="true">            
        </div>
        <div class="fitem">
            <label>SILC Date Registration</label>
            <input name="date_registration" id="date_registration" class="easyui-datebox" required="true">            
        </div>

        
    </form>
</div>
<div id="dlgMark-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveSILC()" style="width:90px">Save</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlgSilcGroup,#dlgPSPFA').dialog('close')" style="width:90px">Cancel</a>
</div>

<div id="dlgPSPFA" title="PSP/ FA - Dialog " class="easyui-dialog" style="width:430px;height:240px;padding:20px 5px"
        closed="true" buttons="#dlgVil-buttons">
    <div class="ftitle">Add PSP /FA </div>
    <form id="fmPSPFA" method="get" novalidate>
         <div class="fitem">
          <input name="Rec_district" id="Rec_district" class="easyui-textbox" required="true" readonly="true">  
        </div>    
        <div class="fitem">
            <input name="Rec_TA" id="Rec_TA" class="easyui-textbox" required="true" readonly="true">
        </div>
        <div class="fitem">
          <input name="Rec_gvh" id="Rec_gvh" class="easyui-textbox" required="true" readonly="true">  
        </div>
        <div class="fitem">
          <input name="ss_supervisor" id="ss_supervisor" class="easyui-textbox" required="true" readonly="true">  
        </div>
        <div class="fitem">

            <label>PSP/FA Name:</label>
            <input name="psp_name" id="psp_name" class="easyui-textbox" required="true" >
        </div>
        <div class="fitem">
         <label>PSP/FA Sex(1-M 2-F):</label>
            <input name="psp_sex" id="psp_sex" class="easyui-textbox" required="true" >
        </div>
        <div class="fitem">
                <label>Date Registration:</label>
            <input name="date_registration" id="date_registration" class="easyui-datebox" required="true" >
        </div>
        
    </form>
</div>

<div id="dlgVil-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveSILC()" style="width:90px">Save</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlgSilcGroup,#dlgPSPFA').dialog('close')" style="width:90px">Cancel</a>
</div>


@stop