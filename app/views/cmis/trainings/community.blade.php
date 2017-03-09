@extends('masterTrain')

@section('content')


    
    <div id="content" region="center" title="Contents" style="padding:5px;">
    	<div id="p" style="padding:10px;">
   			      <table id="dgCommunity" style="width:100%;height:96%" 
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
        url:'title'"
        style="width:200px;">


         Training Number:
        <input name="training_num" id="cc6" class="easyui-textbox" data-options="
              onChange:function(){
               var url = 'institution';
                $('#institution').combobox('reload', url);
             
        }" style="width:100px;">

         
 
        
   <div>  
    
     TA/Sub District: 
        <input name="cc7" id="cc7" class="easyui-combobox" data-options="
             valueField:'rec_id',
             textField:'ta_name',
              onSelect: function(rec){          
            var url = 'code_Gvh?id='+rec.rec_id;
            $('#cc3').combobox('reload', url);
          },
             url:'institutionTA'" style="width:200px;">


         GVH: 
        <input name="cc3" id="cc3" class="easyui-combobox" data-options="
             valueField:'rec_id',
             textField:'gvh',
              onSelect:function(rec){
               var url = 'code_vil?id='+rec.rec_id;
                $('#cc8').combobox('reload', url);
                }" style="width:200px;">

             
        Date:
            <input name="date" id="date" class="easyui-datebox">
     
        <a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="trainingNumCom()">Assign Training Number</a>
                
     </div>
    

        Village: 
        <input name="cc8" id="cc8" class="easyui-combobox" data-options="
             valueField:'rec_id',
             textField:'village_name',
             onSelect:function(rec){
               var url = 'rfoSel?id='+rec.rec_id;
                $('#volunteer').combobox('reload', url);
                }" style="width:200px;">

        Volunteer Name: 

        <input name="volunteer" id="volunteer" class="easyui-combobox" data-options="
             valueField:'rec_id',
             textField:'rfo_name'" style="width:200px;">

             HH Number:
        <input name="hh_number" iconCls="icon-add" id="hh_number" class="easyui-textbox" data-options="
              onChange:function(){
               CommunityParticipants();
             
        }" style="width:100px;">

         
         
         

</div>

    
   
<div id="dlgEdit" class="easyui-dialog" style="width:840px;height:400px;padding:1px 32px" toolbar="#tb" closed="true" buttons="#dlgEdit-buttons" data-options="resizable:true,modal:true">
    <div class="ftitle">Training Participants Registration</div>

      <table id="ttCommunity" style="width:780px;height:200px" pagination="false">
              
      </table>
      <div id="tb" style="height:auto">
        <a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="insert()">New</a>
        
    </div>
    </div>
        
    </div>
<div id="dlgEdit-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveComBen()" style="width:90px">Add </a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlgEdit').dialog('close')" style="width:90px">Cancel</a>
</div>
		</div>
    </div>

@stop