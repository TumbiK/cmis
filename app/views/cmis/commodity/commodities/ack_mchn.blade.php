
@extends('masterAck')
@section('content')

<h5 style="color:#0099FF;">  MCHN Food Acknowledgements Acknowledgements Management</h5>

<script type="text/javascript">
var lastIndex;

$(function(){

    var dg= $('#datGrid').datagrid({filterBtnIconCls:'icon-filter'});
     dg.datagrid('enableFilter');
    dg.datagrid('enableFilter',[
        {field:'HH_Number',type:'numberbox',options:{precsion:2},op:['equal','notequal','less','greater']},
        {field:'Name_of_HH_Member',type:'textbox',
        options:{
            onChange:function(value){
                if (value == ''){
                            dg.datagrid('removeFilterRule', 'Name_of_HH_Member');
                        } else {
                            dg.datagrid('addFilterRule', {
                                field: 'Name_of_HH_Member',
                                op: 'contains',
                                value: value
                            });
                        }
                        dg.datagrid('doFilter');


            }
        }
    },

    {field:'VillageName',type:'textbox',
        options:{
            onChange:function(value){
                if (value == ''){
                            dg.datagrid('removeFilterRule', 'VillageName');
                        } else {
                            dg.datagrid('addFilterRule', {
                                field: 'VillageName',
                                op: 'contains',
                                value: value
                            });
                        }
                        dg.datagrid('doFilter');


            }
        }
    }

    ]);

});
     

    $('#datGrid').datagrid({
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
    
   
function updateActions(index){
    $('#datGrid').datagrid('updateRow',{
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
    $('#datGrid').datagrid('endEdit',getRowIndex(target));
    $('#datGrid').datagrid('selectRow',rwId);
    var RowData= $('#datGrid').datagrid('getSelected');
   RowData['period']=$('#period').val();
   RowData['frm_id']=$('#frm_id').val();

    $.ajax({
        url:'update_MchnAck',
        type:'Get',
        dataType:'json',
        data:RowData

      });

      $('#datGrid').datagrid('reload');

}

function cancelrow(target){
    $('#datGrid').datagrid('cancelEdit', getRowIndex(target));
}

 function editrow(target){
      $('#datGrid').datagrid('beginEdit', getRowIndex(target));
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


 <table id="datGrid" style="width:840px;height:500px" 
        data-options="url:'ben_reg_ackMchn?district='+{{{$district}}}+'&period='+{{{$period}}}+'&gvh='+{{{$gvh}}}+'&FDP_Number='+{{{$FDP_Number}}}+'&frm_id='+{{{$frm_id}}}+'&AckYear='+{{{$AckYear}}},fitColumns:true,singleSelect:true,rownumbers:true" >
    <thead>
        <tr>
            
            <th data-options="field:'VillageName'"> Village</th>
            <th data-options="field:'HH_Number'">HH ID</th>
            
            <th data-options="field:'Name_of_HH_Member'">Name of Beneficiary</th>
            <th data-options="field:'Sex'">Gender</th>
            <th data-options="field:'Age'">Age</th>
                   
            <th data-options="field:'FDP_Number'">FDP #</th>
            
            <th data-options="field:'ack'" editor="{type:'combobox',
            options:{
                        valueField:'ack_id',
                        textField:'ack',
                        data:[{ack_id_id:0,ack:'Not Received'},{ack_id:1,ack:'Received'}],
                        required:true
                    }}">Ackowledge</th>
            <th field='action' formatter="optRow">Action</th>


            
        </tr>
    </thead>
</table>


@stop