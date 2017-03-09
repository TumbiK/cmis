<script type="text/javascript" src="reportScript.js"></script>
<script type="text/javascript">
 var lastIndex;

  $('#dg').datagrid({url:'itt_test?'+purpose})
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




<table id="dg" style="width:760px;height:480px" 
        data-options="fitColumns:true,singleSelect:true,rownumbers:true" 
         toolbar="#toolbar" idField="project_number" 
        >
    <thead>
        <tr>
            
            <th field="ck" checkbox="true"></th>
            <th data-options="field:'indicator_num'">No.</th>
            <th data-options="field:'Name_of_HH_Member'">indicator details</th>
            
            


            
        </tr>
    </thead>
</table>
<div id="toolbar"style="padding:5px;height:auto">
<div style="margin-bottom:5px">
     
        
     


      <a href="#" class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="ITTReport()">Generate Report </a> 

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
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlgPregEdit').dialog('close')" style="width:90px">Cancel</a>
</div>