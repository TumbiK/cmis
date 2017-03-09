@extends('masterDiner')
@section('content')
<div class="easyui-layout" fit="true">
  <div id="content" region="center">
<table id="dgDemo" fit="true"  
        data-options="url:'demo_reg',fitColumns:true,singleSelect:true,rownumbers:true" 
         toolbar="#toolbar" idField="HH_Number" 
        >
    <thead>
        <tr>
            
            <th data-options="field:'village_name'"> Village</th>
            <th data-options="field:'HH_Number'">HH ID</th>
            
            <th data-options="field:'Name_of_HH_Member'">Name of HHH</th>
            <th data-options="field:'Name_of_HH_Member'">Name of Lead Farmer</th>
            <th data-options="field:'Sex'">Sex</th>
            
            <th data-options="field:'Age'">Major Crop</th>
            <th data-options="field:'Age'">Technology</th>
            <th data-options="field:'Age'">Area in Acreas</th>
            <th data-options="field:'status'" editor="{type:'combobox',
            options:{
                        valueField:'Status_id',
                        textField:'status',
                        data:[{Status_id:0,status:'Enrolled'},{Status_id:1,status:'Exit'}],
                        required:true
                    }}">Status</th>
            <th data-options="field:'epa_number'">EPA</th>
            <th field='action' formatter="optRow">Action</th>
            


            
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
             var url2='code_epa?id='+rec.rec_id;
            $('#cc2').combobox('reload', url);
             $('#cc5').combobox('reload', url2);
        }" style="width:100px;">
        
     TA:
        <input name="ta" id="cc2" class="easyui-combobox" data-options="
        valueField:'rec_id',
        textField:'ta',
        onSelect: function(rec){          
            var url = 'code_Gv?id='+rec.rec_id;
            var url3='code_market?id='+rec.rec_id;
            $('#cc3').combobox('reload', url);
            $('#cc4').combobox('reload', url3);

        }"style="width:100px;">
        
         GVH
             <input name="gvh" id="cc3" class="easyui-combobox" data-options="
             valueField:'rec_id',
             textField:'gvh',
             onSelect: function(rec){
          
            var url = 'app_prop?id='+rec.rec_id;
            var url1='code_vil?id='+rec.rec_id;            
            $('#cc6').combobox('reload', url1);
           

        }"style="width:100px;">
         EPA:
        <input name="epa" id="cc5" class="easyui-combobox" data-options="
             valueField:'rec_id',
             textField:'epa_name',
             onSelect: function(rec){
                    var url1='epa_sections?id='+rec.rec_id;            
                    $('#cc4').combobox('reload', url1);
           
        }" style="width:110px;">
         Section:
         <input name="section" id="cc4" class="easyui-combobox" data-options="
             valueField:'rec_id',
             textField:'market_name',
             onSelect: function(rec){
            $('#dgDiner').datagrid('load',{
                    editHH:$('#HH_Number').textbox('getText'),
                    code_dist:$('#cc1').combobox('getValue'),
                    code_ta: $('#cc2').combobox('getValue'),
                    code_gvh:$('#cc3').combobox('getValue'),
                    code_village:$('#cc6').combobox('getValue'),
                    market:$('#cc4').combobox('getValue')

             });
            var url = 'app_prop?id='+rec.rec_id;

            
        }" style="width:110px;">

        AEDO:
        <input name="aedo" id="cc11" class="easyui-combobox" data-options="
             valueField:'rec_id',
             textField:'epa_name',
             onSelect: function(rec){
           
        }" style="width:110px;">

       

        </div>
        
       
        <div>        
        
         CSAS:
        <input name="csas" id="cc7" class="easyui-combobox" style="width:100px;">

        Village:
        <input name="gvh_name" id="cc6" class="easyui-combobox" data-options="
             valueField:'rec_id',
             textField:'village_name'" style="width:100px;">
       
        HH Number:
        <input name="HH_Number" id="HH_Number" class="easyui-textbox" style="width:80px;" iconCls="icon-add" data-options="
        onChange:function(rec){
            addBeneficiary();

        }">

        <a href="#" class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="addEpa()">Add EPA</a> 
    <a href="#" class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="addMarket()">Add Market</a> 
    

       
    </div>

    

</div>

    
   
<div id="dlgEdit" class="easyui-dialog" style="width:840px;height:400px;padding:1px 32px" toolbar="#tb" closed="true" buttons="#dlgEdit-buttons" data-options="resizable:true,modal:true">
    <div class="ftitle">Diner Fair Beneficiary Registration</div>

      <table id="tt" style="width:780px;height:200px" pagination="false">
              
      </table>
      <div id="tb" style="height:auto">
        <a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="insert()">New</a>
        
    </div>
    </div>
    <div id="dlgEdit-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveDinerBen()" style="width:90px">Add </a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlgEdit').dialog('close')" style="width:90px">Cancel</a>
</div>

<div id="dlgMarket" class="easyui-dialog" style="width:430px;height:240px;padding:20px 5px"
        closed="true" buttons="#dlgMark-buttons">
    <div class="ftitle">Add DiNer Fairs Markets </div>
    <form id="fmMarket" method="get" novalidate>
        <div class="fitem">
            
            <input name="Rec_id_TA" id="Rec_id_TA" class="easyui-textbox" required="true" readonly="true">
        </div>
        <div class="fitem">
            <label>Market Name</label>
            <input name="market_name" id="market_name" class="easyui-textbox" required="true">
        </div>
        
    </form>
</div>
<div id="dlgMark-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveDinLocation()" style="width:90px">Save</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlgEpa,#dlgMarket').dialog('close')" style="width:90px">Cancel</a>
</div>

<div id="dlgEpa" class="easyui-dialog" style="width:430px;height:240px;padding:20px 5px"
        closed="true" buttons="#dlgVil-buttons">
    <div class="ftitle">Add DiNer Fairs EPA</div>
    <form id="fmEpa" method="get" novalidate>
        <div class="fitem">
           
            <input name="Rec_id_district" id="Rec_id_district" class="easyui-textbox" required="true" readonly="true">
        </div>
        <div class="fitem">
            <label>EPA Name:</label>
            <input name="epa_name" id="epa_name" class="easyui-textbox" required="true" >
        </div>
        
    </form>
</div>

<div id="dlgVil-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveDinLocation()" style="width:90px">Save</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlgEpa,#dlgMarket').dialog('close')" style="width:90px">Cancel</a>
</div>


@stop