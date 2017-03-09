
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
            width:330px;
        }
        .fitemDate{
            margin-bottom:5px;
        }
       
         .fitemDate input{
            width:120px;
        }
    </style>




<table id="dg" style="width:760px;height:480px"
        data-options="url:'ffa_prop',fitColumns:true,singleSelect:true,rownumbers:true" 
         toolbar="#toolbar" idField="project_number" fit="true"
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

    <a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newProp()">New Proposal </a>
    <a href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editProp()">Edit Proposal</a>
    <a href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="comReview()">Approve Proposal</a>
</div>

<div id="dlg" class="easyui-dialog" style="width:700px;height:510px;padding:10px 20px"
        closed="true" buttons="#dlg-buttons" modal="true">



    <div class="ftitle">Proposal Information</div>
   


    
    <form id="fmProp" method="get" novalidate>
     <div class="fitemDate">
   District:
     <input name="district" id="cc1" class="easyui-combobox" data-options="
        valueField: 'rec_id',
        textField: 'district',
        url:'code_dist',
        onSelect: function(rec){
         
            var url = 'code_ta?id='+rec.rec_id;
            $('#cc2').combobox('reload', url);
        }" style="width:100px">
        
     TA:
        <input name="ta" id="cc2" class="easyui-combobox" data-options="valueField:'rec_id',textField:'ta',
        onSelect: function(rec){
        
            var url = 'code_Gv?id='+rec.rec_id;
            $('#cc3').combobox('reload', url);
        }" style="width:100px">
        
         GVH
             <input name="gvh" id="cc3" class="easyui-combobox" data-options="valueField:'rec_id',textField:'gvh'" style="width:120px">
        </div>
    
    
        

        <div class="fitemDate">
            Start Date:
            <input name="date_from" class="easyui-datebox" style="width:100px">
        
            Completion:
            <input name="date_to" class="easyui-datebox" style="width:100px">
       
            HandOver:
            <input name="handover" class="easyui-datebox" style="width:100px">
        </div>
       

       
            
        <div class="fitem">
            <label>Project Number:</label>
            <input name="project_number" class="easyui-numberbox" required="true">
        </div>
        <div class="fitem">
            <label>Project Name:</label>
            <input name="project_type" class="easyui-textbox" required="true">
        </div>

        
        
        <div class="fitem">
            <label>Brief Description of Assest and Activity:</label>
            <input name="Asset_description" class="easyui-textbox" required="true" data-options="multiline:true" style="height:80px;">
        </div>
        <div class="fitem">
            <label>Description of Implemenation and Supervision:</label>
            <input name="Imp_description" class="easyui-textbox" required="true" data-options="multiline:true" style="height:80px;" >
        </div>
        <div class="fitem">
            <label>Description of Sustainability::</label>
            <input name="Sustain_description" class="easyui-textbox" required="true" data-options="multiline:true" style="height:80px;">
        </div>
    </form>

    <div class="vertical-line" style="height: 45px;" />
    </div>
<div id="dlg-buttons">
    
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveAppProp()" style="width:90px">Submit</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancel</a>
</div>


<div id="dlgApp" class="easyui-dialog" style="width:700px;height:510px;padding:10px 20px"
        closed="true" buttons="#dlg-buttons" modal="true">

    <div class="ftitle">Proposal Approval Information</div>
     <form id="fmAppProp" method="get" novalidate>
     <div class="fitemDate">
       District:
         <input name="district" id="dist" class="easyui-combobox" data-options="
            valueField: 'rec_id',
            textField: 'district',
            url:'code_dist',
            onSelect: function(rec){
             
                var url = 'code_ta?id='+rec.rec_id;
                $('#cc2').combobox('reload', url);
            }" style="width:100px">
            
         TA:
            <input name="ta" id="ta" class="easyui-combobox" data-options="valueField:'rec_id',textField:'ta',
            onSelect: function(rec){
            
                var url = 'code_Gv?id='+rec.rec_id;
                $('#cc3').combobox('reload', url);
            }" style="width:100px">
            
         GVH
             <input name="gvh" id="gvh" class="easyui-combobox" data-options="valueField:'rec_id',textField:'gvh'" style="width:120px">
            </div>       

            <div class="fitemDate">
                Start Date:
                <input name="date_from" id="datefrom" class="easyui-datebox" style="width:100px">
            
                Completion:
                <input name="date_to" id="dateto" class="easyui-datebox" style="width:100px">
           
                HandOver:
                <input name="handover" id="handdate" class="easyui-datebox" style="width:100px">
            </div>  
            
            <div class="fitem">
                <label>Project Number:</label>
                <input name="project_number" id="projectNumber" class="easyui-numberbox" required="true">
            </div>
            <div class="fitem">
                <label>Project Name:</label>
                <input name="project_type" id="projectType" class="easyui-textbox" required="true">
            </div>     
        
            <div class="fitem">
                 <label>FFA Technical Proposal Review:</label>
                <input name="ffa_review" class="easyui-textbox" required="true" data-options="multiline:true" style="height:80px;">
            </div>
            <div class="fitem">
                <label>Commodity Proposal Review:</label>
                <input name="commodity_review" class="easyui-textbox" required="true" data-options="multiline:true" style="height:80px;" >
            </div>
            
        <div class="fitem">
        <label>Approval Status</label>
        <input name="ffa_approval" class="easyui-combobox" required="true" data-options="valueField: 'ffa_approval',
        textField: 'AppStatus',
        data: [{
            ffa_approval: '1',
            AppStatus: 'Approved'
        },{
            ffa_approval: '2',
            AppStatus: 'Returned For Review Not Approved'
        },{
            ffa_approval: '3',
            AppStatus: 'Not Approved'
        }]">
    </div>
        </form>
    </div>
<div id="dlg-buttons">
    
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveAppProp()" style="width:90px">Submit</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlgApp').dialog('close')" style="width:90px">Cancel</a>
</div>