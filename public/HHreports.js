$(document).ready(function(){

	$('#frm_household').submit(function(e){
		var tasel=$('#taSel').val();
		var gvhsel=$('#gvhSel').val();
		var vilsel=$('#vilSel').val();
		
		 if(tasel=="0"){
		 	 $.messager.alert('Warning',"Please Select TA and GVH to Generate Household List")	;
		 }else if((gvhsel=="0") ||(gvhsel=="Select")){
		 	 $.messager.alert('Warning',"Please Select GVH OR Village Level to Generate Household List")	;

		 }else if((vilsel=="0")||(vilsel=="Select")){
		 	return true;
		 	
		 }else{
		 		 	
		 	return true;	 	
		}
		
		return false;

	});


});