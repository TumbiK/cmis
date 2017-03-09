
<script type="text/javascript">
    $('#dg').datagrid({
      
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




<table id="dg" style="width:780px;height:450px"
        data-options="url:'ffa_propApp',fitColumns:true,singleSelect:true,rownumbers:true" 
         toolbar="#toolbar" fit="true" idField="project_number">
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


