@extends('masterReport')
@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div class="panel panel-default">
					<div class="panel-heading"><b>Generate Report </b><br/>
					{{Form::open(array('id'=>'frm_household'))}}
						District
						{{Form::select('district',$dist_options,null,array('id'=>'district'))}}
							
						TA

						{{Form::select('taSel',array(null=>'Select'),null,array('id'=>'taSel'))}}

						GVH
						{{Form::select('gvhSel',array(null=>' Select'),null,array('id'=>'gvhSel'))}}

				
						Village
						{{Form::select('vilSel',array(null=>' Select'),null,array('id'=>'vilSel'))}}

						<input name="HH_Number" id="HH_Number" class="easyui-textbox" type="text" readonly="true" disabled="true" style="width:0px;">
						
					</div>
					<div class="panel-body">
					
					 	
	
						<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                    			<div class="form-group">
                      				  <div class="col-sm-offset-3 col-sm-5">
                           					 <button type="submit" class="btn btn-primary">Generate</button>
                      				  </div>
                   				 </div>
                
                 {{Form::close()}}
				</div>

					
				</div>
				
			</div>
		</div>
	</div>


@stop