
<script type="text/javascript">
    $('#dg').datagrid({
        onDblClickRow:function(index){
            editProp();
        }

    });
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
            width:120px;
        }
        .fitem input{
            width:120px;
        }
        .fitemDate{
            margin-bottom:5px;
        }
       
         .fitemDate input{
            width:120px;
        }
    </style>




<table id="dg" fit="true"
        data-options="url:'commFdp',fitColumns:true,singleSelect:true,rownumbers:true" 
         toolbar="#toolbar" idField="project_number"
        >
    <thead>
        <tr>
            <th data-options="field:'district_name'"> District </th>
             <th data-options="field:'District'"># </th>
            <th data-options="field:'ta_name'"> TA </th>
            <th data-options="field:'TA'"># </th>
            <th data-options="field:'gvh_name'"> GVH </th>
             <th data-options="field:'GVH'"># </th>
            <th data-options="field:'FDP_ID'"> FDP_ID</th>
            <th data-options="field:'FDP_Role'">Role</th>
            <th data-options="field:'FDP_Name'">FDP Name</th>
            
                        
        </tr>
    </thead>
</table>
<div id="toolbar">

    <a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newFdp()">New FDP </a>
    <a href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editFdp()">Edit FDP</a>

</div>

<div id="dlgFdp" class="easyui-dialog" style="width:400px;height:380px;padding:10px 20px"
        closed="true" buttons="#dlg-buttons" modal="true">



    <div class="ftitle">Create Commodity FDP </div>
   
 <form id="fmFDP" method="get" novalidate>

     <div class="fitem">
         <label> District:</label>
         <input name="District" id="cc1" class="easyui-combobox" data-options="
        valueField: 'rec_id',
        textField: 'district',
        url:'code_dist',
        onSelect: function(rec){
         
            var url = 'code_ta?id='+rec.rec_id;
            $('#cc2').combobox('reload', url);
        }" style="width:120px;" required="true">
    </div>
    <div class="fitem">
    <label>TA:</label>
     
        <input name="TA" id="cc2" class="easyui-combobox" data-options="valueField:'rec_id',textField:'ta',
        onSelect: function(rec){
          
            var url = 'code_Gv?id='+rec.rec_id;
            $('#cc3').combobox('reload', url);
        }" style="width:120px;" required="true">
        </div>
        <div class="fitem">
        <label>GVH:</label> 
             <input name="GVH" id="cc3" class="easyui-combobox" data-options="valueField:'rec_id',textField:'gvh'" style="width:120px;" required="true">
        </div>       
        <div class="fitem">
            <label>FDP Number:</label>
            <input name="FDP_ID" class="easyui-numberbox" required="true">
        </div>
   
        
        <div class="fitem">
            <label>FDP Role</label>
            <input name="FDP_Role" class="easyui-combobox" required="true" style="width:120px;" data-options="valueField: 'value',
        textField: 'label',data: [{
            label: 'FFA',
            value: '1'
        },{
            label: 'MCHN',
            value: '2'
        },
        {
            label: 'Other',
            value: '3'
        }]">
        </div>
        <div class="fitem">
            <label>FDP Name:</label>
            <input name="FDP_Name" class="easyui-textbox" required="true">
        </div>
        <div class="fitem">
            <label>Remarks:</label>
            <input name="remarks" class="easyui-textbox" required="true">
        </div>
        
    </form>
    </div>
<div id="dlg-buttons">
    
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveFdp()" style="width:90px">Update</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlgFdp').dialog('close')" style="width:90px">Cancel</a>
</div>