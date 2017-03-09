@extends('masterTrain')



@section('content')


    
    <div id="content" region="center" title="Contents" style="padding:5px;">
    	<div id="p" style="padding:10px;">
   			      <table id="dgSub" style="width:100%;height:96%" 
        data-options="url:'sub_dist_train',fitColumns:true,singleSelect:true,rownumbers:true" 
         toolbar="#toolbar" idField="project_number">
    <thead>
        <tr>
            

            
        </tr>
    </thead>
</table>
<div id="toolbar"style="padding:5px;height:auto">
<div style="margin-bottom:5px">
     Sector:
     <input name="sector" id="cc1" class="easyui-combobox" data-options="
        valueField: 'rec_id',
        textField: 'sector_name',
        url:'sector',
        onSelect: function(rec){         
            var url = 'workshop?id='+rec.rec_id;
            $('#cc2').combobox('reload', url);
        }" style="width:220px;">
        
      Training/Workshop Title:
        <input name="title" id="cc2" class="easyui-combobox" data-options="
        valueField:'rec_id',
        textField:'title',
        url:'title',
        onSelect: function(rec){          
            var url = 'code_Gv?id='+rec.rec_id;
            $('#cc3').combobox('reload', url);
        }"style="width:200px;">


         Training Number:
        <input name="training_num" id="cc6" class="easyui-textbox" data-options="
              onChange:function(){
               var url = 'institution?id='+0;
                $('#institution').combobox('reload', url);
             
        }" style="width:100px;">

         
 
        
   <div>  
    Venue:
            <input name="venue" id="venue" class="easyui-textbox" style="width:220px;" >

             
        Date:
            <input name="date" id="date" class="easyui-datebox">
     
        <a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="trainingNum()">Assign Training Number</a>
                
     </div>
      
         <a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="trainingParticipants()">Add Participants</a>
         
         

</div>

    
   
<div id="dlgEdit" class="easyui-dialog" style="width:840px;height:400px;padding:1px 32px" toolbar="#tb" closed="true" buttons="#dlgEdit-buttons" data-options="resizable:true,modal:true">
    <div class="ftitle">Training Participants Registration</div>

      <table id="tt" style="width:780px;height:200px" pagination="false">
              
      </table>
      <div id="tb" style="height:auto">

        TA: 
        <input name="cc7" id="cc7" class="easyui-combobox" data-options="
             valueField:'rec_id',
             textField:'ta_name',
             url:'institutionTA'" style="width:120px;">

        Structure: 
        <input name="cc8" id="cc8" class="easyui-combobox" data-options="
             valueField:'rec_id',
             textField:'struct_name',
             data:[{
                struct_name:'ACPC',
                rec_id:1},
                {struct_name:'VDC',
                rec_id:2},
                {struct_name:'VCPC',
                rec_id:3},
                {struct_name:'VNRMC',
                rec_id:4},         
                {struct_name:'Youth Club',
                rec_id:5},

                {struct_name:'ADC',
                rec_id:6}
             ],
             onSelect:function(rec){
               var url = 'institution?id='+rec.rec_id+'&ta='+$('#cc7').combobox('getValue');
                $('#institution').combobox('reload', url);
                }" style="width:120px;">

        Institution:
        <input name="institution" id="institution" class="easyui-combobox" data-options="
             valueField:'rec_id',
             textField:'institution_name',
             onSelect: function(rec){
                   $('#tt').datagrid('load',{'id':$('#institution').combobox('getValue'),'struct':+$('#cc8').combobox('getValue')});
              }

             " style="width:120px;">
        <span>Designation:</span>
        <input id="designation" class="easyui-textbox" style="line-height:26px;border:1px solid #ccc">
        <a href="#" class="easyui-linkbutton" plain="true" onclick="doSearch()" iconCls="icon-search">Search</a>
    

        <a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="addInstMember()">New Member</a>
        
    </div>
    </div>
        
    </div>
<div id="dlgEdit-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveBen()" style="width:90px">Add </a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlgEdit').dialog('close')" style="width:90px">Cancel</a>
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
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlgInst').dialog('close');$('#tt').datagrid('reload');" style="width:90px">Cancel</a>
</div> 
    </div>

@stop