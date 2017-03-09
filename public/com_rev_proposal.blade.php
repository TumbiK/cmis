
<script type="text/javascript">
    $('#dgCom').datagrid({
        onDblClickRow:function(index){
            appCommProp();
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
            width:320px;
        }
        .fitemDate{
            margin-bottom:5px;
        }
       
         .fitemDate input{
            width:100px;
        }
    </style>




<table id="dgCom" style="width:750px;height:480px"
        data-options="url:'ffa_prop',fitColumns:true,singleSelect:true,rownumbers:true" 
         toolbar="#toolbar" idField="project_number"
        >
    <thead>
        <tr>
            <th data-options="field:'district'"> District </th>
            <th data-options="field:'ta'"> TA </th>
            <th data-options="field:'gvh'"> GVH </th>
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

    <a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="appCommProp()">Commodity Review Proposal </a>
    

</div>

<div id="dlgCommRev" class="easyui-dialog" style="width:700px;height:480px;padding:10px 20px"
        closed="true" buttons="#dlg-buttons" modal="true">



    <div class="ftitle">Commodity Proposal Review Information</div>
   


    

     
      <form id="fm" method="post" novalidate>
       <div class="fitemDate">
       District:
      <input name="district" id="cc2" class="easyui-textbox" readonly="true" style="width:90px;">
      
        TA:
        <input name="ta" id="cc2" class="easyui-textbox" disabled="disabled" style="width:90px;">
      
         GVH:
             <input name="gvh" id="cc3" class="easyui-textbox" disabled="disabled"  style="width:90px;">
        </div>
    
<hr/>

        <div class="fitemDate">
            Start Date:
            <input name="date_from" class="easyui-textbox" disabled="disabled" style="width:90px;">
        
            Completion:
            <input name="date_to" class="easyui-textbox" disabled="disabled" style="width:90px;">
       
            HandOver:
            <input name="date_to" class="easyui-textbox" disabled="disabled" style="width:90px;">
        </div>
       
<hr/>
       
            
        <div class="fitem">
            <label>Project Number:</label>
            <input name="project_number" class="easyui-textbox" required="true" readonly="true">
        </div>
        <div class="fitem">
            <label>Project Name:</label>
            <input name="project_type" class="easyui-textbox" required="true" disabled="disabled">
        </div>

        
        
        <div class="fitem">
            <label>Commodity Proposal Review:</label>
            <input name="commodity_review" class="easyui-textbox" required="true" data-options="multiline:true" style="height:120px;">
        </div>
         <div class="fitem">
        <label>Approval Status</label>
        <input name="commodity_approval" class="easyui-combobox" required="true" data-options="valueField: 'commodity_approval',
        textField: 'AppStatus',
        data: [{
            commodity_approval: '1',
            AppStatus: 'Approved'
        },{
            commodity_approval: '2',
            AppStatus: 'Returned For Review Not Approved'
        },{
           commodity_approval: '3',
            AppStatus: 'Not Approved'
        }]">
    </div>
        
    </form>
    </div>
<div id="dlg-buttons">    
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveProp()" style="width:90px">Submit</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlgCommRev').dialog('close')" style="width:90px">Cancel</a>
</div>