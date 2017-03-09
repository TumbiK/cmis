@extends('masterExt')
@section('content')
<div class="easyui-layout" fit="true">
  <div id="content" region="center">
<table id="dgCCFLS" fit="true" data-options="url:'cg_reg',singleSelect:true"
         toolbar="#toolbar" idField="HH_Number" style="width:400px;height:50px">
    <thead>
        <tr>
            
            <th data-options="field:'village_name'"> Village</th>
            <th data-options="field:'HH_Number'">HH ID</th>
            
            <th data-options="field:'Name_of_HH_Member'">Childs Name</th>

            <th data-options="field:'Sex'">Sex</th>
            <th data-options="field:'dob'">Date of Birth</th>
            <th data-options="field:'Age'">Age(Months)</th>

            
            <th data-options="field:'date_joining'">#days in CCFLS</th>

            <th data-options="field:'d1muac'">D1 MUAC(cm)</th>
            <th data-options="field:'d1weight'">D1 Weight(kg)</th>
            <th data-options="field:'d1height'">D1 Height(cm)</th>

            <th data-options="field:'d6weight'">D6 Weight(kg)</th>

            <th data-options="field:'d12muac'">D12 MUAC(cm)</th>
            <th data-options="field:'d12weight'"> Weight(kg)</th>

           


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
             var url2='cg_promoter?id='+rec.rec_id;
            $('#cc2').combobox('reload', url);
             $('#cc8').combobox('reload', url2);
        }" style="width:100px;">
        
     TA:
        <input name="ta" id="cc2" class="easyui-combobox" data-options="
        valueField:'rec_id',
        textField:'ta',
        onSelect: function(rec){          
            var url = 'code_Gv?id='+rec.rec_id;
            
            var url1='cggroup?id='+rec.rec_id;
            $('#cc3').combobox('reload', url);
            $('#cc4').combobox('reload', url1);


        }"style="width:100px;">
        
         GVH
             <input name="gvh" id="cc3" class="easyui-combobox" data-options="
             valueField:'rec_id',
             textField:'gvh',
             onSelect: function(rec){
          
       
            var url2='code_vil?id='+rec.rec_id;
            
                   
          
            $('#cc6').combobox('reload', url2);
            
           

        }"style="width:100px;">
        CGroup:
        <input name="project" id="cc4" class="easyui-combobox" data-options="
             valueField:'cg_number',
             textField:'group_name',
             onSelect: function(rec){
            $('#dgCCFLS').datagrid('load',{
                    editHH:$('#HH_Number').textbox('getText'),
                    code_dist:$('#cc1').combobox('getValue'),
                    code_ta: $('#cc2').combobox('getValue'),
                    code_gvh:$('#cc3').combobox('getValue'),
                    code_village:$('#cc6').combobox('getValue'),
                    cg_number:$('#cc4').combobox('getValue')

             });
            $('#CG_Number').textbox('setValue',$('#cc4').combobox('getValue'));

            
        }" style="width:110px;">
      
       CG Leader:
        <input name="gvh" id="cc5" class="easyui-combobox" data-options="
             valueField:'rec_id',
             textField:'cgl_name',
             onSelect: function(rec){
           
        }" style="width:110px;">
        
        
        CG Promoter:
        <input name="SSFS" id="cc8" class="easyui-combobox" data-options="
             valueField:'rec_id',
             textField:'promoter_name',
             onSelect: function(rec){
              var url3='code_cgl?id='+rec.rec_id; 
              $('#cc5').combobox('reload', url3);
           
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
        onClickIcon:function(rec){
           

        }">
        
        CCFLS#
        <input name="CG_Number" id="CG_Number" class="easyui-textbox" style="width:80px;" iconCls="icon-add" data-options="">
          
           <a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="addCCFLSchild()">Add CCFLS SESIION</a> 
        

       
    </div>

    

</div>

    
   
<div id="dlgEdit" class="easyui-dialog" style="width:840px;height:400px;padding:1px 32px" toolbar="#tb" closed="true" buttons="#dlgEdit-buttons" data-options="resizable:true,modal:true">
    <div class="ftitle">CG Cluster Leader Registration</div>

      <table id="tt" style="width:780px;height:200px" pagination="false">
              
      </table>
      <div id="tb" style="height:auto">
        <a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="insert()">New Member</a>
        
    </div>
    </div>
    <div id="dlgEdit-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveCGBen()" style="width:90px">Add </a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlgEdit').dialog('close')" style="width:90px">Cancel</a>
</div>

<div id="dlgEditLeader" class="easyui-dialog" style="width:840px;height:400px;padding:1px 32px" toolbar="#tb" closed="true" buttons="#dlgEdit-buttons" data-options="resizable:true,modal:true">
    <div class="ftitle">Care Group Leader Registration</div>

      <table id="ttLeader" style="width:780px;height:200px" pagination="false">
              
      </table>
      <div id="tb" style="height:auto">
        <a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="insertLeader()">New Member</a>
        
    </div>
    </div>
    <div id="dlgEdit-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveCGLeader()" style="width:90px">Add </a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlgEditLeader').dialog('close')" style="width:90px">Cancel</a>
</div>

<div id="dlgCareGroup" title="Care Group- Dialog" class="easyui-dialog" style="width:430px;height:240px;padding:20px 5px"
        closed="true" buttons="#dlgMark-buttons">
    <div class="ftitle">ADD CARE GROUP</div>
    <form id="fmCareGroup" method="get" novalidate>

        <div class="fitem">
          <input name="Rec_id_dist" id="Rec_id_dist" class="easyui-textbox" required="true" readonly="true">  
        </div>    
        <div class="fitem">
            <input name="Rec_TA_id" id="Rec_TA_id" class="easyui-textbox" required="true" readonly="true">
        </div>
        <div class="fitem">
          <input name="Rec_gvh" id="Rec_gvh" class="easyui-textbox" required="true" readonly="true">  
        </div>
        <div class="fitem">
            <label>CG Promoter Number</label>
            <input name="cg_promo_id" id="cg_promo_id" class="easyui-textbox" required="true" readonly="true">            
        </div>
        <div class="fitem">
            <label>Care Group Name</label>
            <input name="group_name" id="group_name" class="easyui-textbox" required="true">            
        </div>
        
         <div class="fitem">
            <label>Care Group Formation</label>
            <input name="date_format" id="date_formation" class="easyui-datebox" required="true">            
        </div>
        <div class="fitem">
            <label>Care Group Registration</label>
            <input name="date_registra" id="date_registration" class="easyui-datebox" required="true">            
        </div>

        
    </form>
</div>
<div id="dlgMark-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="savePromo()" style="width:90px">Save</a>
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



<div id="dlgPromo" title="Caregroup Promoter - Dialog " class="easyui-dialog" style="width:430px;height:240px;padding:20px 5px"
        closed="true" buttons="#dlgPromo-buttons">
    <div class="ftitle">Add CareGroup Promoter </div>
    <form id="fmCGPromo" method="get" novalidate>
          <div class="fitem">
             <input name="Rec_id_dist" id="Rec_id_district" class="easyui-textbox" required="true" readonly="true">  
        </div>    
        <div class="fitem">
            <input name="Rec_TA_id" id="Rec_id_TA" class="easyui-textbox" required="true" readonly="true">
        </div>
        <div class="fitem">
             <label>CareGroup Promoter Name:</label>
            <input name="Promoter_Name" id="Promoter_Name" class="easyui-textbox" required="true" >
        </div>
        <div class="fitem">
         <label>CG Promoter Sex(1-M 2-F):</label>
            <input name="sex" id="sex" class="easyui-textbox" required="true" >
        </div>
        <div class="fitem">
                <label>Date Registration:</label>
            <input name="date_registration" id="date_registration" class="easyui-datebox" required="true" >
        </div>
        
    </form>
</div>

<div id="dlgPromo-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="savePromo()" style="width:90px">Save</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlgCareGroup,#dlgPromo').dialog('close')" style="width:90px">Cancel</a>
</div>


@stop