
<script type="text/javascript">
 var lastIndex;
    $('#dg').datagrid({
         onDblClickRow:function(rowIndex){
          if(lastIndex != rowIndex){
            $(this).datagrid('endEdit',lastIndex);
            $(this).datagrid('beginEdit',rowIndex);
          }
          lastIndex=rowIndex;

        },
         onBeforeEdit:function(rowIndex,row){
            row.editing = true;
            updateActions(rowIndex);

        },
        onAfterEdit:function(rowIndex,row){
            row.editing = false;
           updateActions(rowIndex);
        },
        onCancelEdit:function(rowIndex,row){
            row.editing = false;
            updateActions(rowIndex);
        }    


    });

    function editrow(target){
      $('#dg').datagrid('beginEdit', getRowIndex(target));
    }

function updateActions(index){
    $('#dg').datagrid('updateRow',{
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
    $('#dg').datagrid('endEdit',getRowIndex(target));
    $('#dg').datagrid('selectRow',rwId);
    var RowData= $('#dg').datagrid('getSelected');

    $.ajax({
        url:'update_mchn_Ben',
        type:'Get',
        dataType:'json',
        data:RowData

      });

      $('#dg').datagrid('reload');

}



function cancelrow(target){
    $('#dg').datagrid('cancelEdit', getRowIndex(target));
}

function deleterow(target){
    $.messager.confirm('Confirm','Are you sure?',function(r){
        if (r){
            var RowData= $('#dg').datagrid('getSelected');
             $.ajax({
                    url:'delete_mchnPregBen',
                    type:'Get',
                    dataType:'json',
                    data:RowData
                });

           // $('#dg').datagrid('deleteRow', getRowIndex(target));
            $('#dg').datagrid('reload');

        }
    });
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




<table id="dg" style="width:760px;height:480px" pagination="true"
        data-options="url:'preg_ben_reg',fitColumns:true,singleSelect:true,rownumbers:true,fit:true" 
         toolbar="#toolbar" idField="project_number" 
        >
    <thead>
        <tr>
            
            
            <th data-options="field:'HH_Number'">HH ID</th>
            <th data-options="field:'Name_of_HH_Member'">Name of Pregnat Woman</th>
            <th data-options="field:'dob'">Date of Birth</th>
            <th data-options="field:'Age'">Age (Years)</th>
            <th data-options="field:'FDP_Number'">FDP</th>
            <th data-options="field:'caregroup'">CG_Number</th>
            <th data-options="field:'status'" editor="{type:'combobox',
            options:{
                        valueField:'Status_id',
                        textField:'status',
                        data:[{Status_id:1,status:'Enrolled'},{Status_id:2,status:'Deceased'},{Status_id:3,status:'Exit'},{Status_id:9,status:'Delete'}],
                        required:true
                    }}">Status</th>
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
             var url2='commFdpHSel?id='+rec.rec_id;
            $('#cc3').combobox('reload', url);
             $('#cc5').combobox('reload', url2);
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
         FDP:
        <input name="gvh" id="cc5" class="easyui-combobox" data-options="
             valueField:'FDP_ID',
             textField:'FDP_name',
             onSelect: function(rec){
           
        }" style="width:110px;">
       
       

            
        
        Village:
        <input name="gvh_name" id="cc6" class="easyui-combobox" data-options="
             valueField:'rec_id',
             textField:'village_name'
        " style="width:100px;">
 </div>
        
       
        <div>   
              CG Promoter:
        <input name="SSFS" id="cc8" class="easyui-combobox" data-options="
             valueField:'rec_id',
             textField:'promoter_name',
             onSelect: function(rec){
              var url3='code_cg?id='+rec.rec_id; 
              $('#cc9').combobox('reload', url3);
           
        }" style="width:110px;">

        CGroup:
        <input name="project" id="cc9" class="easyui-combobox" data-options="
             valueField:'cg_number',
             textField:'group_name',
             onSelect: function(rec){
               $('#dgSilc').datagrid('load',{
             });
            
        }" style="width:110px;">
        

             Date of Registration: 
              <input name="date_registration" id="cc4" class="easyui-datebox" style="width:100px;" 
              data-options="
             onSelect: function(rec){
               $('#dg').datagrid('load',{
               editHH:$('#HH_Number').textbox('getText'),
               code_dist:$('#cc1').combobox('getValue'),
               code_ta: $('#cc2').combobox('getValue'),
               code_gvh:$('#cc3').combobox('getValue'),
               code_village:$('#cc6').combobox('getValue'),
               date_registration:$('#cc4').datebox('getValue')
             });
             } " >  


        HH Number:
        <input name="HH_Number" id="HH_Number" class="easyui-textbox" style="width:80px;" iconCls="icon-add" data-options="
        onChange:function(rec){
            addBeneficiaryPreg();
        }">


      <a href="#" class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="assignGroupFdp()">Village Assign FDP </a> 

    </div>
    

</div>

    
   
<div id="dlgPregEdit" class="easyui-dialog" style="width:840px;height:400px;padding:1px 32px" toolbar="#tb" closed="true" buttons="#dlgEdit-buttons" data-options="resizable:true,modal:true">
    <div class="ftitle">MCHN Prenant Mothers Registration</div>

      <table id="mchnPregtt" style="width:780px;height:200px" pagination="false">
      
        
      </table>
      <div id="tb" style="height:auto">
        <a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="insert()">New</a>
        
    </div>
    </div>
    

    

     
    
    </div>
<div id="dlgEdit-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="savePregBen()" style="width:90px">Add </a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlgPregEdit').dialog('close');$('#dg').datagrid('reload');" style="width:90px">Cancel</a>
</div>