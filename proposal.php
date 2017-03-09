
<style type="text/css">
        #fm{
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
            width:100px;
        }
    </style>




<table class="easyui-datagrid" style="width:550px;height:350px"
        data-options="url:'datagrid_data.json',fitColumns:true,singleSelect:true,rownumbers:true" 
         toolbar="#toolbar"
        >
    <thead>
        <tr>
            <th data-options="field:'code'"> Project #</th>
            <th data-options="field:'name'">Name</th>
            <th data-options="field:'name'">location</th>
            <th data-options="field:'name'">Date Created</th>
            <th data-options="field:'name'">Date Commencement</th>
            <th data-options="field:'name'">Date Completion</th>

            
        </tr>
    </thead>
</table>
<div id="toolbar">
    <div>
                {{Form::open(array('id'=>'frm_household','method'=>'get'))}}
                District
                {{Form::select('district',$dist_options,null,array('id'=>'district'))}}
                            
                TA

                {{Form::select('taSel',array(null=>'Select'),null,array('id'=>'taSel'))}}

                GVH
                {{Form::select('gvhSel',array(null=>' Select'),null,array('id'=>'gvhSel'))}}

                
                Village
                {{Form::select('vilSel',array(null=>' Select'),null,array('id'=>'vilSel'))}}

                Registration Date
        <input id="reg_dat" name="reg_dat" style="width:90px" class="easyui-datebox" >
                {{Form::close()}}
        </div>
    <a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newProp()">New Proposal </a>
    <a href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editProp()">Edit Proposal</a>

</div>

<div id="dlg" class="easyui-dialog" style="width:700px;height:480px;padding:10px 20px"
        closed="true" buttons="#dlg-buttons" modal="true">

    <div class="ftitle">Proposal Information</div>
<form id="fm" method="post" novalidate>
        <div class="fitem">
            <label>Project Number:</label>
            <input name="firstname" class="easyui-textbox" required="true">
        </div>
        <div class="fitem">
            <label>Project Name:</label>
            <input name="lastname" class="easyui-textbox" required="true">
        </div>
        <div class="fitem">
            <label> (Commencement/Completion/Handover):</label>
            <input name="phone" class="easyui-datebox">
            <input name="phone" class="easyui-datebox">
            <input name="phone" class="easyui-datebox">
        </div>
        
        
        <div class="fitem">
            <label>Brief Description of Assest and Activity:</label>
            <input name="email" class="easyui-textbox" validType="email">
        </div>
        <div class="fitem">
            <label>Description of Implemenation and Supervision:</label>
            <input name="email" class="easyui-textbox" validType="email">
        </div>
        <div class="fitem">
            <label>Description of Sustainability::</label>
            <input name="email" class="easyui-textbox" validType="email">
        </div>
    </form>
    </div>
<div id="dlg-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveProp()" style="width:90px">Save</a>
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="submitProp()" style="width:90px">Submit</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancel</a>
</div>