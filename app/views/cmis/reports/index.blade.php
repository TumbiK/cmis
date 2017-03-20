@extends('masterAdmin')
@section('content')

<div id="contents" class="easyui-layout" style="width:1020px;height:520px;" fit="true">
    <div region="west" split="true" title="ITT Selection Area" style="width:250px;">
       <div class="easyui-accordion" fit="true" style="width:200px;height:280px;">    
                <div title="Purpose Indicators" data-options="iconCls:'icon-reload',selected:true" style="padding:10px;">
                            <form id="fm">
                                <div class="fitem">
                                        <label>District</label>
                                         <input name="district" id="cc1" class="easyui-combobox" data-options="
                                            valueField: 'rec_id',
                                            textField: 'district',
                                            url:'code_dist',
                                            onSelect: function(rec){         
                                                var url = 'code_ta?id='+rec.rec_id;
                                                $('#cc2').combobox('reload', url);
                                            }" style="width:100px;">
                                </div>
                                <div class="fitem">
                                         <label>Year</label>
                                        <input name="fy" id="fy" class="easyui-combobox" data-options="
                                        onSelect:function(rec){
                                            loadQuarter();
                                            loadPurpose();
                                        },url:'get_fy',valueField:'year',textField:'year'">
                                 </div>   
                                 <div class="fitem">
                                         <label>Quarter</label>
                                        <input name="quarter" id="quarter" class="form-control easyui-combobox" style="width:160px;">
                                </div> 
                                
                                <div class="fitem">                                        
                                        <label >Purpose</label>
                                        <input name="purpose" id="purpose" class="form-control  easyui-combobox" style="width:160px;" data-options="
                                        onSelect:function(rec){
                                            load_ind();
                                            },valueField:'id',textField:'purpose_description'">
                                </div>
                            </form>                           
                                
            </div>
    

    
</div>
        


    </div>
    <div id="content" region="center" title="Indicators for Selection" style="padding:5px;">
    	<div id="p" style="padding:10px;">

        <table id="dgReport" style="width:650px;height:400px" data-options="fitColumns:true,
                   border:true,singleSelect:false,fitColumns:true">
    <thead>
        <tr>
            
            <th field="ck" checkbox="true"></th>
            <th data-options="field:'indicator_num'">No.</th>
            <th data-options="field:'indicator_name'">indicator details</th>            
        </tr>
    </thead>
</table>
<div id="toolbar"style="padding:5px;height:auto">
<div style="margin-bottom:5px">
     
        
     

      <a href="#" class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="itt_calcReport()">Calculate Indicator </a>
      <a href="#" class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="ITTgenReport()">Generate Report </a> 

    </div>
    

</div>
   			 
		</div>
    </div>
    
</div>

@stop