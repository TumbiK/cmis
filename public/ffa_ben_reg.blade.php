
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
      $('#dg').datagrid('selectRow',getRowIndex(target));
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
      RowData['FDP_Number']=$('#cc5').combobox('getValue');
      RowData['Number_days_work']=$('#Number_days_work').numberbox('getValue');

    $.ajax({
        url:'update_ffaBen',
        type:'Get',
        dataType:'json',
        data:RowData

      });

      $('#dg').datagrid('reload');

}

function cancelrow(target){
    $('#dg').datagrid('cancelEdit', getRowIndex(target));
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
        data-options="url:'ffa_ben_reg',fitColumns:true,singleSelect:true,rownumbers:true" 
         toolbar="#toolbar" fit="true" idField="project_number"  >
    <thead>
        <tr>
            
            <th data-options="field:'Village'"> Village</th>
            <th data-options="field:'HH_Number'">HH ID</th>
            
            <th data-options="field:'Name_of_HH_Member'">Name of Beneficiary</th>
            <th data-options="field:'Sex'">Gender</th>
            <th data-options="field:'dob'">Date of Birth</th>
            <th data-options="field:'Age'">Age</th>
            <th data-options="field:'status'" editor="{type:'combobox',
            options:{
                        valueField:'Status_id',
                        textField:'status',
                        data:[{Status_id:1,status:'Working'},{Status_id:2,status:'Enrolled'},{Status_id:3,status:'Deceased'},{Status_id:4,status:'Exit'}],
                        required:true
                    }}">Status</th>
            <th data-options="field:'Number_days_work'"># of Days Worked</th>
            <th data-options="field:'FDP_Number'">FDP #</th>
            <th data-options="field:'Project_Number'">Project #</th>
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
            var url = 'code_Gv?id='+rec.rec_id;
            $('#cc3').combobox('reload', url);
        }"style="width:100px;">
        
         GVH
             <input name="gvh" id="cc3" class="easyui-combobox" data-options="
             valueField:'rec_id',
             textField:'gvh',
             onSelect: function(rec){
          
            var url = 'app_prop?id='+rec.rec_id;
            var url1='code_vil?id='+rec.rec_id;
            var url2='commFdpSel?id='+rec.rec_id;
            $('#cc4').combobox('reload', url);
            $('#cc6').combobox('reload', url1);
            $('#cc5').combobox('reload', url2);


        }"style="width:100px;">
         FDP:
        <input name="gvh" id="cc5" class="easyui-combobox" data-options="
             valueField:'FDP_ID',
             textField:'FDP_name',
             onSelect: function(rec){
           
        }" style="width:110px;">
         Project #
        <input name="project" id="cc4" class="easyui-combobox" data-options="
             valueField:'project_number',
             textField:'project_number',
             onSelect: function(rec){
            $('#dg').datagrid('load',{
             editHH:$('#HH_Number').textbox('getText'),
        code_dist:$('#cc1').combobox('getValue'),
        code_ta: $('#cc2').combobox('getValue'),
        code_gvh:$('#cc3').combobox('getValue'),
        code_village:$('#cc6').combobox('getValue'),
             project:$('#cc4').combobox('getValue')

             });
            var url = 'app_prop?id='+rec.rec_id;

            
        }" style="width:60px;">
       

        </div>
        
       
        <div>        
        
        Village:
        <input name="gvh_name" id="cc6" class="easyui-combobox" data-options="
             valueField:'rec_id',
             textField:'village_name'" style="width:100px;">

        Date Registration
         <input name="Date_of_Registration" id="Date_of_Registration" class="easyui-datebox" style="width:100px;">
         
        HH Number:
        <input name="HH_Number" id="HH_Number" class="easyui-textbox" style="width:80px;" iconCls="icon-add" data-options="
        onChange:function(rec){
            addBeneficiary();

        }">
       
        # Days Worked
         <input name="HH_Number" id="Number_days_work" class="easyui-numberbox" style="width:80px;">

    </div>
    

</div>

    
   
<div id="dlgEdit" class="easyui-dialog" style="width:840px;height:400px;padding:1px 32px" toolbar="#tb" closed="true" buttons="#dlgEdit-buttons" data-options="resizable:true,modal:true">
    <div class="ftitle">FFA Beneficiary Registration</div>

      <table id="tt" style="width:780px;height:200px" pagination="false">
              
      </table>
      <div id="tb" style="height:auto">
        <a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="insert()">New</a>
        
    </div>
    </div>
    

    

     
    
    </div>
<div id="dlgEdit-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveBen()" style="width:90px">Add </a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlgEdit').dialog('close')" style="width:90px">Cancel</a>
</div>