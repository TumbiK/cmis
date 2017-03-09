
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





<div style="margin-bottom:5px">
<form action='ff_faf' method='get'>
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
        code_village:$('#cc6').combobox('getValue')


             });
            var url = 'app_prop?id='+rec.rec_id;

            
        }" style="width:60px;">

         FDP:
        <input name="FDP_Number" id="cc5" class="easyui-combobox" data-options="
             valueField:'FDP_ID',
             textField:'FDP_name',
             onSelect: function(rec){
           
        }" style="width:110px;">

          <button type="submit" class="btn btn-primary">Generate</button>
       
  </form>
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