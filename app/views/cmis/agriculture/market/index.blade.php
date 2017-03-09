@extends('masterDiner')
@section('content')
<div class="easyui-layout" fit="true">
  <div id="content" region="center">
<table id="dgMarketing" fit="true"  
        data-options="url:'market_reg',fitColumns:true,singleSelect:true,rownumbers:true" 
         toolbar="#toolbar" idField="HH_Number" 
        >
    <thead>
        <tr>
            
            <th data-options="field:'village_name'"> Village</th>
            <th data-options="field:'HH_Number'">HH ID</th>
            
            <th data-options="field:'Name_of_HH_Member'">Name of Club Member</th>

            <th data-options="field:'Sex'">Sex</th>
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
            <th field='action' formatter="optRowMarketing">Action</th>
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
            var url3='code_market?id='+rec.rec_id;
            var url4='code_MaCluster?id='+rec.rec_id;
            $('#cc3').combobox('reload', url);
            $('#cc4').combobox('reload', url3);
            $('#cc9').combobox('reload', url4);


        }"style="width:100px;">
        
         GVH
             <input name="gvh" id="cc3" class="easyui-combobox" data-options="
             valueField:'rec_id',
             textField:'gvh',
             onSelect: function(rec){
          
            var url = 'app_prop?id='+rec.rec_id;
            var url2='code_vil?id='+rec.rec_id;
            var url1='market_group?id='+rec.rec_id;
            var url3='market_psp?id='+rec.rec_id;            
            $('#cc4').combobox('reload', url1);
            $('#cc6').combobox('reload', url2);
            $('#cc5').combobox('reload', url3);
           

        }"style="width:100px;">
        Marketing Club:
        <input name="project" id="cc4" class="easyui-combobox" data-options="
             valueField:'rec_id',
             textField:'group_name',
             onSelect: function(rec){
            $('#dgMarketing').datagrid('load',{
                    editHH:$('#HH_Number').textbox('getText'),
                    code_dist:$('#cc1').combobox('getValue'),
                    code_ta: $('#cc2').combobox('getValue'),
                    code_gvh:$('#cc3').combobox('getValue'),
                    code_village:$('#cc6').combobox('getValue'),
                    market_club:$('#cc4').combobox('getValue')

             });
            var url = 'app_prop?id='+rec.rec_id;

            
        }" style="width:110px;">
      
      Market Cluster
      <input name="mcluster" id="cc9" class="easyui-combobox" data-options="
             valueField:'Rec_Id',
             textField:'cl_name',
             onSelect: function(rec){
           
        }" style="width:110px;">
      </div>
      <div>
        
       PSP/MA:
        <input name="gvh" id="cc5" class="easyui-combobox" data-options="
             valueField:'rec_id',
             textField:'psp_name',
             onSelect: function(rec){
           
        }" style="width:110px;">
        
        
        SS Field Supervisor:
        <input name="SSFS" id="cc8" class="easyui-combobox" data-options="
             valueField:'rec_id',
             textField:'ss_supervisor',
             onSelect: function(rec){
           
        }" style="width:110px;">
        
               
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

        </div>
        
       
        <div>

        <a href="#" class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="addMarketClub()">Add Marketing Club</a> 
        <a href="#" class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="addMarketCluster()">Add Cluster</a> 

    <a href="#" class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="addMA()">Add PSP/MA</a> 
    <a href="#" class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="assignMaCl()">Assign Cluster</a> 
    

       
    </div>

    

</div>

    
   
<div id="dlgEdit" class="easyui-dialog" style="width:840px;height:400px;padding:1px 32px" toolbar="#tb" closed="true" buttons="#dlgEdit-buttons" data-options="resizable:true,modal:true">
    <div class="ftitle">Marketing Club Beneficiary Registration</div>

      <table id="tt" style="width:780px;height:200px" pagination="false">
              
      </table>
      <div id="tb" style="height:auto">
        <a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="insert()">New Member</a>
        
    </div>
    </div>
    <div id="dlgEdit-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveMarketBen()" style="width:90px">Add </a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlgEdit').dialog('close')" style="width:90px">Cancel</a>
</div>

<div id="dlgSilcGroup" title="Marketing Club - Dialog" class="easyui-dialog" style="width:430px;height:240px;padding:20px 5px"
        closed="true" buttons="#dlgMark-buttons">
    <div class="ftitle">ADD Marketing Club </div>
    <form id="fmMarketClub" method="get" novalidate>

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
            <label>Marketing Club Name</label>
            <input name="group_name" id="group_name" class="easyui-textbox" required="true">            
        </div>
        
        <div class="fitem">
            <label>Marketing Club Registration</label>
            <input name="date_registration" id="date_registration" class="easyui-datebox" required="true">            
        </div>

        
    </form>
</div>
<div id="dlgMark-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveMarket()" style="width:90px">Save</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlgSilcGroup,#dlgPSPFA').dialog('close')" style="width:90px">Cancel</a>
</div>

<div id="dlgPSPMA" title="PSP/ MA - Dialog " class="easyui-dialog" style="width:430px;height:240px;padding:20px 5px"
        closed="true" buttons="#dlgVil-buttons">
    <div class="ftitle">Add PSP /MA </div>
    <form id="fmPSPMA" method="get" novalidate>
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

            <label>PSP/MA Name:</label>
            <input name="psp_name" id="psp_name" class="easyui-textbox" required="true" >
        </div>
        <div class="fitem">
         <label>PSP/MA Sex(1-M 2-F):</label>
            <input name="psp_sex" id="psp_sex" class="easyui-textbox" required="true" >
        </div>
        <div class="fitem">
                <label>Date Registration:</label>
            <input name="date_registration" id="date_registration" class="easyui-datebox" required="true" >
        </div>
        
    </form>
</div>

<div id="dlgVil-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveMarket()" style="width:90px">Save</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlgMarketClub,#dlgPSPMA').dialog('close')" style="width:90px">Cancel</a>
</div>

<div id="dlgMaCluster" title="Marketing Cluster - Dialog " class="easyui-dialog" style="width:630px;height:340px;padding:20px 5px"
        closed="true" buttons="#dlgVil-buttons">
    <div class="ftitle">Add Market Cluster </div>
    <form id="fmMACl" method="get" novalidate>
         <div class="fitem">
          <input name="district" id="district" class="easyui-textbox" required="true" readonly="true">  
        </div>    
        <div class="fitem">
            <input name="TA" id="TA" class="easyui-textbox" required="true" readonly="true">
        </div>
        <div class="fitem">
          <input name="gvh" id="gvh" class="easyui-textbox" required="true" readonly="true">  
        </div>
        <div class="fitem">
          <input name="cl_supervisor" id="cl_supervisor" class="easyui-textbox" required="true" readonly="true">  
        </div>
        <div class="fitem">
            <label>Market Cluster Name:</label>
            <input name="cl_name" id="cl_name" class="easyui-textbox" required="true" >
        </div>
        <div class="fitem">
            <label>Main Value Chain Commoditie 1:</label>
            <input name="vc1" id="vc1" class="easyui-textbox" required="true" >
        </div>
        <div class="fitem">
            <label>Main Value Chain Commoditie 2:</label>
            <input name="vc2" id="vc2" class="easyui-textbox" required="true" >
        </div>
        <div class="fitem">
            <label>Main Value Chain Commoditie 3:</label>
            <input name="vc3" id="vc3" class="easyui-textbox" required="true" >
        </div>
        <div class="fitem">
                <label>Date Registration:</label>
            <input name="date_registration" id="date_registration" class="easyui-datebox" required="true" >
        </div>
        
    </form>
</div>

<div id="dlgVil-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveMarket()" style="width:90px">Save</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlgMaCluster,#dlgPSPMA').dialog('close')" style="width:90px">Cancel</a>
</div>


@stop