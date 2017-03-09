
$(document).ready(function($){
$('#dgDiner,#dgDemo').datagrid();
	$('#checkbox1').change(function(){
		if(this.checked)
			{
				alert("Clicked");
				 $('#mycheck').fadeIn('slow');
			}else{
				$('#mycheck').fadeOut('slow');
		}
	});

$('#HH_Number').textbox('textbox').bind('keydown', function(e) {
               if(e.keyCode==13 || e.keyCode==9){
              addBeneficiary();
               } 
            });

		$("ul.nav-tabs a").click(function (e) {
  e.preventDefault();  
  
$(this).tab('show');

});



//Implementing the chained Remote Selects in the application
$('#taSel').remoteChained({
	parents:"#district",
	url:"/taSelect"
});

$("#gvhSel").remoteChained({
    parents :"#taSel",
    url : "/gvhSelect"  

});

$('#vilSel').remoteChained({
	parents:"#gvhSel",
	url:"/vilSelect"
});





	
$('#dobMain').datebox({
	onSelect:function(date){
		//calculate the age for the individual
		var dbAge=(new Date).getFullYear()-date.getFullYear()
		//alert(dbAge);
		$('#Age').textbox('setValue',dbAge);
		$('#Age').textbox('readonly',true);
		$('#hh_size').textbox('textbox').focus();

	}
});

$('#dobMain').datebox('textbox').bind('keydown',function(e){
	if(e.which==9 && ($('#dobMain').datebox("getValue") !='' )){
		var date=new Date($('#dobMain').datebox("getValue"));
			//alert(date.getFullYear());
		var dbAge=(new Date).getFullYear()-date.getFullYear();//(new Date).getFullYear()-date.getFullYear()
		//alert(dbAge);
		$('#Age').textbox('setValue',dbAge);
		$('#Age').textbox('readonly',true);
	//	$('#hh_size').textbox('textbox').focus();

	}

	if(e.which==9 && ($('#dobMain').datebox("getValue") =='' )){
		
		$('#Age').textbox('readonly',false);
		

	}
	
});



$('#addHH').textbox({
	icons:[{
		iconCls:'icon-add',
		handler: function(e){
			checkuser();
		}
	}],
	onChange:function(value){
		checkuser();	 
	}
	
	
});

	


});

function checkuser(){
		var newhhId_len=$('#addHH').val().length;  //capture the length of the textbox
		var newhhid=$('#addHH').val();

		if  (($('#vilSel').val()=="")||($('#vilSel').val()=='Select') || ($('#vilSel').val()=="0")){
			$.messager.alert('Warning','Please Select the TA, GVH or Village To Add New HouseHold ');
		}else if(!$.isNumeric(newhhid) || (newhhId_len != 4)){
			$.messager.alert('Warning','Please Input the correct HouseHold Number, Should have four numbers Only!!');
		}else{
			$.ajax({
				type:'get',
				url:'chkhh',
				//data:"newhhid="+newhhid,
				data:{newhhid:newhhid,gvhSel:$('#gvhSel').val(),vilSel:$('#vilSel').val()},
				success:function(data){
					 var result = eval('('+data+')');
					//console.log('server_response:'+data);
					if(result.data=='0'){
						newUser();
					}else{
						
						$.messager.confirm('Confirm','The Hold Hold ID Already Exists Do You Want to edit?',function(r){
							if(r){
		//						alert(newhhid);
								$('#dg').datagrid('selectRecord',newhhid);

								editItem();
							}
						});
					}
				}
			})
			
		}
}

function newUser(){
	

	 $('#dlg').dialog('open').dialog('setTitle','New HouseHold');
	 $('#fm').form('clear');
	 $('#HH_Number').textbox({value:$('#addHH').val()});
		var v = $('#reg_dat').datebox('getValue');
	
	$('#Ben_Reg_date').datebox('setValue',v);
	

	 $('#Name_of_HH_member').textbox('clear').textbox('textbox').focus();

	
	  url='save_household';
	  


}

function editItem(){
	var row=$('#dg').datagrid('getSelected');
	if(row){
			
		$('#dlgEdit').dialog('open').dialog('setTitle','Edit User');

			$('#tt').datagrid('load',{
		editHH:row.HH_Number,
		code_dist: $('#district').val(),
		code_ta: $('#taSel').val(),
		code_gvh:$('#gvhSel').val(),
		code_village:$('#vilSel').val()
	});
     
     
        
	
		//url='update_household?id='+row.id;
     }
		

	}


function saveHH(){
	$('#fm').form('submit',{
		 url: url,
        onSubmit: function(param){
        	param.district=$('#district').val();
        	param.ta=$('#taSel').val();
        	param.gvh=$('#gvhSel').val();
        	param.village=$('#vilSel').val();
        	param.head_h='01';
        	param.HH_Member_Number='01';

            return $(this).form('validate');
        },
		success:function(result){
			 var result = eval('('+result+')');
            if (result.errorMsg){
                $.messager.show({
                    title: 'Error',
                    msg: result.errorMsg
                });
            } else{
               // $('#dlg').dialog('close');        // close the dialog
                $('#dg').datagrid('reload');    // reload the user data
                $('#fm').form('clear');
                var v = $('#reg_dat').datebox('getValue');
				$('#Ben_Reg_date').datebox('setValue',v);
            }
		}
	});

}



function updateActions(index){
			$('#tt').datagrid('updateRow',{
				index: index,
				row:{}
			});
		}

function upateAct(index){
	$('#ttLeader').datagrid('updateRow',{
				index: index,
				row:{}
			});

}

		
		

function getRowIndex(target){
    var tr = $(target).closest('tr.datagrid-row');
    return parseInt(tr.attr('datagrid-row-index'));
}

function editrow(target){
	  var rowIndex= getRowIndex(target);
	 $('#tt').datagrid('beginEdit', rowIndex);   
  
}

function editrows(target){
	  var rowIndex= getRowIndex(target);
	 $('#ttLeader').datagrid('beginEdit', rowIndex);   
  
}

function saverow(target){
    $('#tt').datagrid('endEdit', getRowIndex(target));
    var rows=$('#tt').datagrid('getRows');
    $.each(rows,function(i,row){
    	var url='/update_household';
    	

    	$.ajax({
    		url:url,
    		type:'Get',
    		dataType:'json',
    		data:row

    	});

    	$('#dg').datagrid('reload');


    });
}
function cancelrow(target){
    $('#tt').datagrid('cancelEdit', getRowIndex(target));
}

function saverows(target){
    $('#ttLeader').datagrid('endEdit', getRowIndex(target));
    var rows=$('#ttLeader').datagrid('getRows');
    if (rows){
    	rows['District']=$('#cc1').combobox('getValue');
    }
    $.each(rows,function(i,row){
    	var url='/update_household?District='+$('#cc1').combobox('getValue')+"&TA="+$('#cc2').combobox('getValue')+"&GVH="+$('#cc3').combobox('getValue')+"&Village="+$('#cc6').combobox('getValue');  	

    	$.ajax({
    		url:url,
    		type:'get',
    		dataType:'json',
    		data:row

    	});

    	$('#dg').datagrid('reload');


    });
}
function cancelrows(target){
    $('#ttLeader').datagrid('cancelEdit', getRowIndex(target));
}	

function insert(){
			var row = $('#tt').datagrid('getSelected');
			//get the total number of Row in T=tt datagrid
			var lastRow=($('#tt').datagrid('getData').total);


			if (row){
				var index = $('#tt').datagrid('getRowIndex', row);
			} else {
				index = 0;
			}
			var myRow=$('#dg,#tt').datagrid('getSelected');
			alert(lastRow);
			//var selRows=$('#tt').datagrid('selectRow',lastRow);
			$('#tt').datagrid('insertRow', {
				index: index,
				row:{
					status:'',
					District:$('#district').val(),
					TA:$('#taSel').val(),
					GVH:$('#gvhSel').val(),
					Village:$('#vilSel').val(),
					HH_Number:myRow.HH_Number,
					HH_Member_Number:lastRow+1


				}
			});
			//var selRows=$('#tt').datagrid('selectRow',lastRow+1);
			$('#tt').datagrid('selectRow',index);
			$('#tt').datagrid('beginEdit',index);
		}

		function deleterow(target){
    $.messager.confirm('Confirm','Are you sure?',function(r){
        if (r){
            $('#tt').datagrid('deleteRow', getRowIndex(target));
        }
    });
}


//override the formatter method so that they change format of date
$.fn.datebox.defaults.formatter = function(date){
		var y = date.getFullYear();
		var m = date.getMonth()+1;
		var d = date.getDate();
		return (d<10?('0'+d):d)+'/'+(m<10?('0'+m):m)+'/'+y; //e.g. 12-03-1966 (= 12 March 1966)
	};
	$.fn.datebox.defaults.parser = function(s){
		if (!s) return new Date();
		var ss = s.split('/');
		var d = parseInt(ss[0],10);
		var m = parseInt(ss[1],10);
		var y = parseInt(ss[2],10);
		if (!isNaN(y) && !isNaN(m) && !isNaN(d)){
			return new Date(y,m-1,d);
		} else {
			return new Date();
		}
	};	


$.extend($.fn.validatebox.defaults.rules, {
   ageRange: {
      validator: function(value, param){
         return (value >= param[0] && value <= param[1]);
      },
      message: 'Age must be in the range of 15 and 100'
   },
   
  sizeRange: {
      validator: function(value, param){
      	 return (value >= param[0] && value <= param[1]);
      },
        message: 'Size Must be in the Range of 1 to 15.'
   }
});