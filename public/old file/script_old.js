
$(document).ready(function($){

		$("ul.nav-tabs a").click(function (e) {
  e.preventDefault();  
  
$(this).tab('show');

});






$('#repSel').submit(function(e){
	e.preventDefault();
	$.ajax({
		url:'/reportData',
		type:'GET',
		dataType:'JSON',
		data:$('#repSel').serialize(),
		success:function(data){
			//$('p').html("Successfully acquired data");
			$("p").html(JSON.stringify(response, null, '&nbsp').replace(/\n/g, '<br>'));
		}
	});



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

	
$('#hh_dob').datebox({
	onSelect:function(date){
		//calculate the age for the individual
		var dbAge=(new Date).getFullYear()-date.getFullYear()
		//alert(dbAge);
		$('#hhh_age').textbox('setValue',dbAge);
	}
});

$('#hh_number').textbox({
	iconCls:'icon-add',
	onChange:function(value){

		var hhId_len=$('#hh_number').val().length;  //capture the length of the textbox
		var hhid=$('#hh_number').val();
		
		if  (($('#vilSel').val()=="")||($('#vilSel').val()=='Select') || ($('#vilSel').val()=="0")){
			$.messager.alert('Warning','Please Select the TA, GVH or Village To Add New HouseHold ');
		}else if(!$.isNumeric(hhid) || (hhId_len != 4)){

			$.messager.alert('Warning','Please Input the correct HouseHold Number, Should have four numbers Only!!');
		}else{
			$.ajax({
				type:'get',
				url:'chkhh',
				data:{newhhid:hhid,gvhSel:$('#gvhSel').val(),vilSel:$('#vilSel').val()},
				success:function(data){
					 var result = eval('('+data+')');
					 			console.log('server_response:'+data);
					if(result.data !='0'){		
						$('#dg').datagrid('selectRecord',hhid);
						var row=$('#dg').datagrid('getSelected');
	
		
	
		
	
					//$('#dlg').dialog('close');
						
							$('#fm').form('load',row);
							var d=new Date(row.hh_reg_date);		
							$('#hh_reg_date').datebox('setValue',$.fn.datebox.defaults.formatter(d));
							var hdb=row.dob
		//alert(hdb);
		if(hdb=="0000-00-00"){
			$('#hh_dob').datebox('setValue',"");
		}else{
		var db=new Date(row.hh_dob);	
		$('#hh_dob').datebox('setValue',$.fn.datebox.defaults.formatter(db));	
		
		}
							
						url='update_household?id='+row.id;
						//$('#dlg').dialog('setTitle','Edit HouseHold');

						//$.messager.alert('Warning','The Hold Hold ID Already Exists You can edit!');*/
					
					}else{
						var hh_num = $('#hh_number').val();

						$('#fm').form('clear');
						$('#hh_number').textbox({value:hh_num});
						$('#dlg').dialog('setTitle','New HouseHold');
						url='save_household';

					}
				}
			})
			
		}
	}
});

$('#addHH').textbox({
	iconCls:'icon-add',
	onChange:function(value){

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
					console.log('server_response:'+data);
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
	
});

	


});


function newUser(){
	

	 $('#dlg').dialog('open').dialog('setTitle','New HouseHold');
	 $('#fm').form('clear');
	 $('#hh_number').textbox({value:$('#addHH').val()});
	var v = $('#reg_dat').datebox('getValue');
	
	$('#hh_reg_date').datebox('setValue',v);
	

	 $('#hhh_name').textbox('clear').textbox('textbox').focus();
	
	  url='save_household';

}

function editItem(){
	var row=$('#dg').datagrid('getSelected');
	if(row){
			
		$('#dlg').dialog('open').dialog('setTitle','Edit User');
		$('#fm').form('clear');
			$('#fm').form('load',row);
		
	
		var d=new Date(row.hh_reg_date);		
		$('#hh_reg_date').datebox('setValue',$.fn.datebox.defaults.formatter(d));
		var hdb=row.hh_dob
		//alert(hdb);
		if(hdb=="0000-00-00"){
			$('#hh_dob').datebox('setValue',"");
		}else{
		var db=new Date(row.hh_dob);	
		$('#hh_dob').datebox('setValue',$.fn.datebox.defaults.formatter(db));	
		
		}
		

	
		url='update_household?id='+row.id;
		

	}
}

function saveHH(){
	$('#fm').form('submit',{
		 url: url,
        onSubmit: function(param){
        	param.dist=$('#district').val();
        	param.ta=$('#taSel').val();
        	param.gvh=$('#gvhSel').val();
        	param.village=$('#vilSel').val();

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
	$('#hh_reg_date').datebox('setValue',v);
            }
		}
	});

}

//override the formatter method so that they change format of date
$.fn.datebox.defaults.formatter = function(date){
		var y = date.getFullYear();
		var m = date.getMonth()+1;
		var d = date.getDate();
		return (d<10?('0'+d):d)+'-'+(m<10?('0'+m):m)+'-'+y; //e.g. 12-03-1966 (= 12 March 1966)
	};
	$.fn.datebox.defaults.parser = function(s){
		if (!s) return new Date();
		var ss = s.split('-');
		var d = parseInt(ss[0],10);
		var m = parseInt(ss[1],10);
		var y = parseInt(ss[2],10);
		if (!isNaN(y) && !isNaN(m) && !isNaN(d)){
			return new Date(y,m-1,d);
		} else {
			return new Date();
		}
	};	
//function to change the datebox in the datagrid to take a new format dd-mm-yy


  

function removeItem(){
	var row = $('#dg').datagrid('getSelected');
	
	if(row){
		$.messager.confirm('Confirm','Are you sure you want to Delete this HouseHold?',function(r){
			if(r){

				$.ajax({
					type:'get',
					url:'destroy_hh',
					data:{hh_number:row.hh_number,gvhSel:$('#gvhSel').val(),vilSel:$('#vilSel').val()},
					success:function(result){
					if(result.success){
						$('#dg').datagrid('reload');
					}else{
						$.messager.show({
							title:'Error',
							msg:result.errorMsg
						});
					}
				}
			});
		
	}
});
	}
}