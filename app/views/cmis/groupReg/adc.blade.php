

@extends('masterTrain')


@section('content')
<script type="text/javascript">
 var lastIndex;
   

    function editrow(target){
      $('#dgAdc').datagrid('beginEdit', getRowIndex(target));
    }

function updateActions(index){
    $('#dgAdc').datagrid('updateRow',{
        index: index,
        row:{}
    });
}
function getRowIndex(target){
    var tr = $(target).closest('tr.datagrid-row');
    return parseInt(tr.attr('datagrid-row-index'));
}

function saverow(target)
{
    var rwId=getRowIndex(target);
    $('#dgAdc').datagrid('endEdit',getRowIndex(target));
    $('#dgAdc').datagrid('selectRow',rwId);
    var RowData= $('#dgAdc').datagrid('getSelected');
    RowData['district']=$('#cc1').datagrid('getValue');
    RowData['ta']=$('#cc2').datagrid('getValue');

    $.ajax({
        url:'update_Adc_Ben',
        type:'Get',
        dataType:'json',
        data:RowData

      });

      $('#dgAdc').datagrid('reload');

}

function cancelrow(target){
    $('#dgAdc').datagrid('cancelEdit', getRowIndex(target));
}






function optRow(value,row)
            {
                 if (row.editing){
                        var s = '<a href="#" onclick="saverow(this)">Save</a> ';
                        var c = '<a href="#" onclick="cancelrow(this)">Cancel</a>';
                        return s+c;
                    } else {
                        var e = '<a href="#" onclick="editrow(this)">Edit</a> ';
                        var d = '<a href="#" onclick="deleterow(this)">Delete</a>';
                        return e+d;
                    }
            }

</script>

<style type="text/css">
        #fm{
            margin:0;
            padding:10px 30px;
        }
        #fmSelect{
            margin:0;
            padding:10px 30px;
        }
        .ftitle{
            font-size:14px;
            font-weight:bold;
            padding:5px 0;
            margin-bottom:10px;
            border-bottom:1px solid #ccc;
        }
        .fitem{
            margin-bottom:5px;
        }
        .fitem label{
            display:inline-block;
            width:220px;
        }
        .fitem input{
            width:330px;
        }
        .fitemDate{
            margin-bottom:5px;
        }
       
         .fitemDate input{
            width:100px;
        }
        
    </style>



<table id="dgAdc" style="width:920px;height:400px" 
        data-options="url:'adc_reg',fitColumns:true,singleSelect:true,rownumbers:true" 
         toolbar="#toolbar" idField="project_number" 
        >
    <thead>
        <tr>
            <th field='gvh_name'>GVH</th>
            <th field='village_name'>Village</th>
            <th field='hh_number'>HH ID</th>
            <th field='Name_of_HH_Member'>Name Youth Club Member</th>
            <th  field='sex'>Sex</th>
            <th  field='dob'>Date of Birth</th>
            <th  field='Age'>Age (Years)</th>
            <th  field='position'>Position</th>
            <th  field='date_join'>Date Elected</th>
            <th  field='date_leaving' editor="{type:'datebox'}">Date Leaving</th>
            <th field='action' formatter="optRow">Action</th>   
        </tr>
    </thead>
</table>
<div id="toolbar"style="padding:5px;height:auto">
<div style="margin-bottom:5px">
     District:
     <input name="district" id="cc1" class="easyui-combobox" data-options="
        valueField: 'rec_id',
        textField: 'district',
        url:'code_dist',
        onSelect: function(rec){         
            var url = 'code_ta?id='+rec.rec_id;
            $('#cc2').combobox('reload', url);
        }" style="width:100px;">
        
     TA:
        <input name="ta" id="cc2" class="easyui-combobox" data-options="
        valueField:'rec_id',
        textField:'ta',
        onSelect: function(rec){          
            var url = 'code_Gvh?id='+rec.rec_id;
            var url2='rfoSel?id='+rec.rec_id;
               var url3='adcSel?id='+rec.rec_id;
            

            $('#cc3').combobox('reload', url);
             $('#cc5').combobox('reload', url2);
              $('#cc6').combobox('reload', url3);
             
             

        }"style="width:100px;">
      GVH
             <input name="gvh" id="cc3" class="easyui-combobox" data-options="
             valueField:'rec_id',
             textField:'gvh',
             onSelect: function(rec){
          
            var url = 'app_prop?id='+rec.rec_id;
            var url1='code_vil?id='+rec.rec_id;
             
            
           
            $('#cc7').combobox('reload', url1);
            
           

        }"style="width:100px;">
        
        
         GSFO
        <input name="gvh" id="cc5" class="easyui-combobox" data-options="
             valueField:'rec_id',
             textField:'rfo_name',
             onSelect: function(rec){
           
        }" style="width:110px;">
       
       

            
        
       ADC:
        <input name="adc" id="cc6" class="easyui-combobox" data-options="
             valueField:'adc_number',
             textField:'adc_name',
             onSelect: function(rec){
            $('#dgAdc').datagrid('load',{
               editHH:$('#HH_Number').textbox('getText'),
              code_dist:$('#cc1').combobox('getValue'),
              code_ta: $('#cc2').combobox('getValue'),
              code_gvh:$('#cc3').combobox('getValue'),
              code_village:$('#cc6').combobox('getValue')

             });
        }" style="width:100px;">


 Village:
        <input name="gvh_name" id="cc7" class="easyui-combobox" data-options="
             valueField:'rec_id',
             textField:'village_name',
             onSelect: function(rec){
           
        }" style="width:100px;">

 </div>
        
       
        <div>   
       
             Date of Registration: 
              <input name="date_registration" id="cc4" class="easyui-datebox" style="width:100px;">  
            Date of exit: 
              <input name="date_leaving" id="cc8" class="easyui-datebox" style="width:100px;">  



        HH Number:
        <input name="HH_Number" id="HH_Number" class="easyui-textbox" style="width:80px;" iconCls="icon-add" data-options="
        onChange:function(rec){
            addAdcMember();
        }">
  
    
      <a href="#" class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="newAdcGroup()">Add Group </a> 

    </div>
    

</div>
<div id="dlgAdc" class="easyui-dialog" style="width:360px;height:280px;padding:1px 32px" closed="true" buttons="#dlg-buttons" data-options="resizable:true,modal:true">
  <div class="ftitle">Add Youth Club Member Details</div>
  <form id="fmAdc" method="GET" novalidate>
    
    <div class="fitem">
      
    <div class="fitem">
      <label>ADC Name:</label>
      <input name="adc_name" id="adc_name" class="easyui-textbox" type="text" required="true">     
    </div>
    <div class="fitem">
      <label>Date of Registration:</label>
      <input id="date_reg" name="date_reg" class="easyui-datebox">
    </div> 
  </form>   
  </div>
  <div id="dlg-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveAcpc()" style="width:90px">Submit</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlgAdc').dialog('close')" style="width:90px">Cancel</a>
</div>
    
   
<div id="dlgAdcEdit" class="easyui-dialog" style="width:840px;height:400px;padding:1px 32px" toolbar="#tb" closed="true" buttons="#dlgEdit-buttons" data-options="resizable:true,modal:true">
    <div class="ftitle">Youth Club Member Registration</div>

      <table id="adctt" style="width:780px;height:200px" pagination="false">
      
        
      </table>
      <div id="tb" style="height:auto">
        <a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="insert()">New</a>
        
    </div>
    </div>
    

    

     
    
    </div>
<div id="dlgEdit-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveAdcBen()" style="width:90px">Add </a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlgAdcEdit').dialog('close')" style="width:90px">Cancel</a>
</div>

@stop