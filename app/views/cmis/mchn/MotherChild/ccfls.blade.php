@extends('masterExt')
@section('content')
<div class="easyui-layout" fit="true">
  <div id="content" region="center">
<table id="dgCCFLS" fit="true" data-options="url:'ccfls_registration',singleSelect:true"
         toolbar="#toolbar" idField="HH_Number" style="width:400px;height:50px">
    <thead>
        <tr>
            
            <th data-options="field:'village_name'"> Village</th>
            <th data-options="field:'HH_Number'">HH ID</th>
            
            <th data-options="field:'Name_of_HH_member'">Childs Name</th>

            <th data-options="field:'Sex'">Sex</th>
            <th data-options="field:'dob'">Date of Birth</th>
            <th data-options="field:'Age'">Age(Months)</th>

            
            <th data-options="field:'dayCCFLS'">#days in CCFLS</th>

            <th data-options="field:'d1MUAC'">D1 MUAC(cm)</th>
            <th data-options="field:'d1weight'">D1 Weight(kg)</th>
            <th data-options="field:'d1Height'">D1 Height(cm)</th>

            <th data-options="field:'d6weight'">D6 Weight(kg)</th>

            <th data-options="field:'d12MUAC'">D12 MUAC(cm)</th>
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
           
            $('#CG_Number').textbox('setValue',$('#cc4').combobox('getValue'));

            
        }" style="width:110px;">
      
             
        CG Promoter:
        <input name="SSFS" id="cc8" class="easyui-combobox" data-options="
             valueField:'rec_id',
             textField:'promoter_name',
             onSelect: function(rec){
              var url3='code_cgl?id='+rec.rec_id; 
              $('#cc5').combobox('reload', url3);
           
        }" style="width:110px;">
        
        CG Leader:
        <input name="gvh" id="cc5" class="easyui-combobox" data-options="
             valueField:'rec_id',
             textField:'cgl_name',
             onSelect: function(rec){
           
        }" style="width:110px;">
        
  
         CCFLS#
        <input name="CG_Number" id="CCFLS_Number" class="easyui-textbox" style="width:80px;"                
                     iconCls="icon-add" data-options="
              onChange:function(){
                $('#dgCCFLS').datagrid('load',{ccfls_session:$('#CCFLS_Number').textbox('getValue')});

            }">       
        
        </div>
        <div> 
         
       Village:
        <input name="gvh_name" id="cc6" class="easyui-combobox" data-options="
             valueField:'rec_id',
             textField:'village_name'" style="width:100px;">


        HH Number:
        <input name="HH_Number" id="HH_Number" class="easyui-textbox" style="width:80px;" iconCls="icon-add" data-options="
        onClickIcon:function(rec){
           

        }">
        
       
          
           <a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="addCCFLSchild()">Add CCFLS SESIION</a>   

       
    </div>

    

</div>

    
   
<div id="dlgEdit" class="easyui-dialog" style="width:840px;height:400px;padding:1px 32px" toolbar="#tb" closed="true" buttons="#dlgEdit-buttons" data-options="resizable:true,modal:true">
    <div class="ftitle">MCHN Child CCFLS Registration</div>

      <table id="tt" style="width:780px;height:200px" pagination="false">
              
      </table>
      <div id="tb" style="height:auto">
           <a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="insert()">New Member</a>
           <a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="followUp()">1st Month</a> 
           <a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="followUpnd()">2nd Month</a> 
           <a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="followUprd()">3rd Month</a> 
           <a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="followUpth()">6th Month</a> 
        
    </div>
    </div>
    <div id="dlgEdit-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveCCFLSBen()" style="width:90px">Add </a>
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

<div id="dlgSessions" title="Add CCFLS- Dialog" class="easyui-dialog" style="width:430px;height:240px;padding:20px 5px"
        closed="true" buttons="#dlgMark-buttons">
    <div class="ftitle">ADD CCFLS SESSION</div>
    <form id="fmCCFLSession" enctype='application/json' method="get" novalidate>

        <div class="fitem">
          <label>District</label>
          <input name="District" id="Rec_id_dist" class="easyui-textbox" required="true" readonly="true">  
        </div>    
        <div class="fitem">
          <label>TA</label>
            <input name="TA" id="Rec_TA_id" class="easyui-textbox" required="true" readonly="true">
        </div>
        <div class="fitem">
          <label>GVH</label>
          <input name="GVH" id="Rec_gvh" class="easyui-textbox" required="true" readonly="true">  
        </div>
        
        <div class="fitem">
            <label>Care Group Name</label>
            <input name="CG_Number" id="group_name" class="easyui-textbox" required="true">            
        </div>
        <div class="fitem">
            <label>CG Promoter Number</label>
            <input name="CG_Promoter" id="cg_promo_id" class="easyui-textbox" required="true" readonly="true">            
        </div>
        <div class="fitem">
            <label>Care Group Leader</label>
            <input name="CG_Leader" id="group_leader" class="easyui-textbox" required="true">            
        </div>
        
         <div class="fitem">
            <label>First CCFLS Date</label>
            <input name="first_date" id="date_formation" class="easyui-datebox" required="true">            
        </div>
        <div class="fitem">
            <label>Last Date CCFLS</label>
            <input name="last_date" id="date_registration" class="easyui-datebox" required="true">            
        </div>

        
    </form>
</div>
<div id="dlgMark-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveSession()" style="width:90px">Save</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlgSilcGroup,#dlgPSPFA').dialog('close')" style="width:90px">Cancel</a>
</div>

<div id="dlgfollowup" title="First Month Follow UP " class="easyui-dialog" style="width:430px;height:240px;padding:20px 5px"
        closed="true" buttons="#dlgVil-buttons">
    <div class="ftitle">First Month Follow Up </div>
    <form id="fmPSPFA" method="get" novalidate>
         
       <div class="fitem">
            <label>Date of Visit:</label>
            <input name="date_visit" id="f1date" class="easyui-datebox" required="true" >
        </div>

        <div class="fitem">
            <label>Weight(Kg):</label>
            <input name="weight" id="f1weight" class="easyui-textbox" required="true" >
        </div>
        <div class="fitem">
            <label>MUAC(cm):</label>
            <input name="MUAC" id="f1MUAC" class="easyui-textbox" required="true" >
        </div>
        
        
    </form>
</div>

<div id="dlgVil-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveFollowUp()" style="width:90px">Save</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlgSilcGroup,#dlgPSPFA').dialog('close')" style="width:90px">Cancel</a>
</div>



<div id="dlgfollowupnd" title="Second Month Follow Up - Dialog " class="easyui-dialog" style="width:430px;height:240px;padding:20px 5px"
        closed="true" buttons="#dlgPromo-buttons">
    <div class="ftitle">Second Month Follow Up </div>
    <form id="fmCGPromo" method="get" novalidate>
         
         <div class="fitem">
            <label>Date of Visit:</label>
            <input name="f2date" id="f2date" class="easyui-datebox" required="true" >
        </div>

        <div class="fitem">
            <label>Weight(Kg):</label>
            <input name="f2weight" id="f2weight" class="easyui-textbox" required="true" >
        </div>
        <div class="fitem">
            <label>MUAC(cm):</label>
            <input name="f2MUAC" id="f2MUAC" class="easyui-textbox" required="true" >
        </div>
    </form>
</div>

<div id="dlgPromo-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveFollowUp()" style="width:90px">Save</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlgCareGroup,#dlgPromo').dialog('close')" style="width:90px">Cancel</a>
</div>

<div id="dlgfollowuprd" title="Third Month Follow Up - Dialog " class="easyui-dialog" style="width:530px;height:340px;padding:20px 5px"
        closed="true" buttons="#dlgPromo-buttons">
    <div class="ftitle">Third Month Follow Up </div>
    <form id="fmCGPromo" method="get" novalidate>
             <div class="fitem">
            <label>Date of Visit:</label>
            <input name="f3date" id="f3date" class="easyui-datebox" required="true" >
        </div>

        <div class="fitem">
            <label>Weight(Kg):</label>
            <input name="f3weight" id="f3weight" class="easyui-textbox" required="true" >
        </div>
        <div class="fitem">
            <label>MUAC(cm):</label>
            <input name="f3MUAC" id="f3MUAC" class="easyui-textbox" required="true" >
        </div>
        <div class="fitem">
            <label>Height(cm):</label>
            <input name="f3height" id="f3height" class="easyui-textbox" required="true" >
        </div>
    </form>
</div>

<div id="dlgPromo-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveFollowUp()" style="width:90px">Save</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlgCareGroup,#dlgPromo').dialog('close')" style="width:90px">Cancel</a>
</div>

<div id="dlgfollowupth" title="Sixth Month Follow Up - Dialog " class="easyui-dialog" style="width:430px;height:240px;padding:20px 5px"
        closed="true" buttons="#dlgPromo-buttons">
    <div class="ftitle">Sixth Month Follow Up </div>
    <form id="fmCGPromo" method="get" novalidate>
             <div class="fitem">
            <label>Date of Visit:</label>
            <input name="f6date" id="f6date" class="easyui-datebox" required="true" >
        </div>

        <div class="fitem">
            <label>Weight(Kg):</label>
            <input name="f6weight" id="f6weight" class="easyui-textbox" required="true" >
        </div>
        <div class="fitem">
            <label>MUAC(cm):</label>
            <input name="f6MUAC" id="f6MUAC" class="easyui-textbox" required="true" >
        </div>
        <div class="fitem">
            <label>Height(cm):</label>
            <input name="f6height" id="f6height" class="easyui-textbox" required="true" >
        </div>
    </form>
</div>

<div id="dlgPromo-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveFollowUp()" style="width:90px">Save</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlgCareGroup,#dlgPromo').dialog('close')" style="width:90px">Cancel</a>
</div>

<div id="dlgDetails" title="CCFLS Child Add Detals - Dialog " class="easyui-dialog" style="width:530px;height:340px;padding:20px 5px"
        closed="true" buttons="#dlgDetails-buttons" data-options="resizable:true,modal:true">
    <div class="ftitle">CCFLS Child Details  </div>
    <form id="fmDetails" method="get" novalidate>
        <div class="fitem">            
            <input name="ccfls_session" id="cc11" class="easyui-textbox" required="true" >
        </div>
        <div class="fitem">            
            <input name="Village" id="cc12" class="easyui-textbox" required="true" >
        </div>
        <div class="fitem">            
            <input name="HH_Number" id="cc13" class="easyui-textbox" required="true" >
        </div>
        <div class="fitem">            
            <input name="HH_Member_Number" id="cc14" class="easyui-textbox" required="true" >
        </div>
        <div class="fitem">
            <label>No of Day in CCFLS:</label>
            <input name="dayCCFLS" id="dayCCFLS" class="easyui-textbox" required="true" >
        </div>
         <div class="fitem">
            <label>Day1 MUAC(cm):</label>
            <input name="d1MUAC" id="d1MUAC" class="easyui-textbox" required="true" >
        </div>
        <div class="fitem">
            <label>Day 1 Weight(Kg):</label>
            <input name="d1weight" id="d1weight" class="easyui-textbox" required="true" >
        </div>
        <div class="fitem">
            <label>Day 1 Height(Kg):</label>
            <input name="d1Height" id="d1Height" class="easyui-textbox" required="true" >
        </div>

        <div class="fitem">
            <label>Day 6 Weight(Kg):</label>
            <input name="d6weight" id="d6weight" class="easyui-textbox" required="true" >
        </div>
        <div class="fitem">
            <label>Day 12 MUAC(cm):</label>
            <input name="d12MUAC" id="d12MUAC" class="easyui-textbox" required="true" >
        </div>
        <div class="fitem">
            <label>Day 12 Weight(Kg):</label>
            <input name="d12weight" id="d12weight" class="easyui-textbox" required="true" >
        </div>
    </form>
</div>

<div id="dlgDetails-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveCCFLSChild()" style="width:90px">Save</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlgCareGroup,#dlgPromo').dialog('close')" style="width:90px">Cancel</a>
</div>


@stop