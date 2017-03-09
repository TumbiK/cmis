@extends('masterAdmin')
@section('content')

<div id="contents" class="easyui-layout" style="width:1020px;height:520px;">
    <div region="west" split="true" title=" Commodities Function Area" style="width:230px;">
       <div class="easyui-accordion" fit="true" style="width:300px;height:280px;">
    
    <div title="Food Distribution Point (FDP)" data-options="iconCls:'icon-reload'" style="padding:10px;">
       <h3 style="color:#0099FF;">FDP Management</h3>         
                            <a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="CreateFdp()">FDP Details </a>
         
    </div>
    <div title="MCHN Food Acknowledgement" iconCls="icon-ok" data-options="iconCls:'icon-reload',selected:true"  style="padding:10px;">            
                            <a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="mchnFaf()">Food Acknowledgement Forms</a>
                            <a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="mchnAck()">Food Acknowledgements</a>
                                            
                        
        
    </div>

    <div title="FFA Food Acknowledgements" iconCls="icon-reload" style="overflow:auto;padding:10px;">                            
                            <a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="ffaFaf()">Food Acknowledgement Form</a>
                            @if($adminRole==6 || $adminRole==1) 
                            <a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="ffaAck()">Food Acknowledgement</a>
                            @endif
                        </ul>
    </div>
</div>
        


    </div>
    <div id="content" region="center" title="Commodities Food Distribution and Acknowledgements Management" style="padding:5px;">
    	<div id="p" style="padding:10px;">
   			 
		</div>
    </div>
</div>

@stop