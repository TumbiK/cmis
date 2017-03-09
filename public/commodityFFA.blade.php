
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
            width:220px;
        }
        .fitem input{
            width:220px;
        }
        .fitemDate{
            margin-bottom:5px;
        }
       
         .fitemDate input{
            width:120px;
        }
    </style>




<table id="dg" style="width:550px;height:350px"
        data-options="url:'ffa_prop',fitColumns:true,singleSelect:true,rownumbers:true" 
         toolbar="#toolbar" idField="project_number"
        >
    <thead>
        <tr>
            <th data-options="field:'district_name'"> District </th>
            <th data-options="field:'ta_name'"> TA </th>
            <th data-options="field:'gvh_name'"> GVH </th>
            <th data-options="field:'project_number'"> Project #</th>
            <th data-options="field:'project_type'">Name</th>
            
            <th data-options="field:'date_from'">Date From</th>
            <th data-options="field:'date_to'">Date Completion</th>
            <th data-options="field:'Asset_description'">Asset description</th>
            <th data-options="field:'Imp_description'">Implementation</th>
            <th data-options="field:'Sustain_description'">Sustainability</th>

            
        </tr>
    </thead>
</table>
<div id="toolbar">

    <a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newProp()">New Proposal </a>
    <a href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editProp()">Edit Proposal</a>

</div>

<div id="dlg" class="easyui-dialog" style="width:700px;height:480px;padding:10px 20px"
        closed="true" buttons="#dlg-buttons" modal="true">



    <div class="ftitle">Proposal Information</div>
   


     <div class="fitemDate">
   District:
    <form id="fm" method="get" novalidate>
     <input name="district_name" id="cc1" class="easyui-combobox" data-options="
        valueField: 'rec_id',
        textField: 'district_name',
        url:'code_dist',
        onSelect: function(rec){
         
            var url = 'code_ta?id='+rec.rec_id;
            $('#cc2').combobox('reload', url);
        }">
        
     TA:
        <input name="ta_name" id="cc2" class="easyui-combobox" data-options="valueField:'rec_id',textField:'ta_name',
        onSelect: function(rec){
          alert(rec.rec_id);
            var url = 'code_Gv?id='+rec.rec_id;
            $('#cc3').combobox('reload', url);
        }">
        
         GVH
             <input name="gvh_name" id="cc3" class="easyui-combobox" data-options="valueField:'rec_id',textField:'gvh_name'">
        </div>
    
    
        

        <div class="fitemDate">
            Start Date:
            <input name="date_from" class="easyui-datebox">
        
            Completion:
            <input name="date_to" class="easyui-datebox">
       
            HandOver:
            <input name="date_to" class="easyui-datebox">
        </div>
       

       
            
        <div class="fitem">
            <label>Project Number:</label>
            <input name="project_number" class="easyui-textbox" required="true">
        </div>
        <div class="fitem">
            <label>Project Name:</label>
            <input name="project_type" class="easyui-textbox" required="true">
        </div>

        
        
        <div class="fitem">
            <label>Brief Description of Assest and Activity:</label>
            <input name="Asset_description" class="easyui-textbox" required="true" data-options="multiline:true" style="height:60px;">
        </div>
        <div class="fitem">
            <label>Description of Implemenation and Supervision:</label>
            <input name="Imp_description" class="easyui-textbox" required="true" data-options="multiline:true" style="height:60px;">
        </div>
        <div class="fitem">
            <label>Description of Sustainability::</label>
            <input name="Sustain_description" class="easyui-textbox" required="true" data-options="multiline:true" style="height:60px;">
        </div>
    </form>
    </div>
<div id="dlg-buttons">
    
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveProp()" style="width:90px">Submit</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancel</a>
</div>