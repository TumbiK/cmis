

function  loadQuarter(){

		quarter=[{"id":1,
		 "quarter":"Quarter 1"},
		{"id":2,
		 "quarter":"Quarter 2"},{"id":3,
		 "quarter":"Quarter 3"},{"id":4,
		 "quarter":"Quarter 4"} ];


$('#quarter').combobox({
	valueField:'id',
	textField:'quarter',
	data:quarter
	
});


}

function loadPurpose(){
	$('#purpose').combobox({
		url:'get_purpose',
    valueField:'id',
    textField:'purpose_description'
	});

}

function load_ind(){
		var mypurpose=$('#purpose').combobox('getValue');
		$('#dgReport').datagrid({url:'itt_report?purpose='+mypurpose});
}

function ITTReport(){
	var url='/update_indicator';  
    var rows=$('#dgReport').datagrid('getSelections');
    $.each(rows,function(i,row){
    	row["District"]=$('#cc1').combobox('getValue');
    	row["year"]=$('#fy').combobox('getValue');
    	row["quater"]=$('#quarter').combobox('getValue');
    	
    	$.ajax({
    		url:url,
    		type:'Get',
    		dataType:'json',
    		data:row
    	});
    });

}
function itt_calcReport(){

var url='/itt_calcReport';  
	var myArr =[];
    var rows=$('#dgReport').datagrid('getSelections');
    
    /*$.each(rows,function(i,row){
    	row["District"]=$('#cc1').combobox('getValue');
    	row["year"]=$('#fy').combobox('getValue');
    	row["quater"]=$('#quarter').combobox('getValue');
    	myARr.push(row[i])
    });*/
	for(var i=0;i<rows.length;i++){
		//myArr.push(rows[i].indicator_num,$('#fy').combobox('getValue'),$('#quarter').combobox('getValue'));
    myArr.push(rows[i].indicator_num);
	}
	//console.log(myArr);

var form = $('<form action="' + url + '" method="post">' +
  '<input type="text" name="indicator_num" value="' + myArr[0] + '" />' +
  '<input type="text" name="year" value="' + myArr[4] + '" />' +
  '<input type="text" name="quarter" value="' + myArr[2] + '" />' +
  '<input type="text" name="quarterJoin" value="' + myArr + '" />' +
  '</form>');
$('body').append(form);
form.submit();

}

function ITTgenReport(){
	
   var url='/itt_genreport';  
	var myArr =[];
    var rows=$('#dgReport').datagrid('getSelections');
    
    $.each(rows,function(i,row){
    	row["District"]=$('#cc1').combobox('getValue');
    	row["year"]=$('#fy').combobox('getValue');
    	row["quater"]=$('#quarter').combobox('getValue');
    	myArr.push(row[i])
    });
	for(var i=0;i<rows.length;i++){
		myArr.push(rows[i].indicator_num,$('#fy').combobox('getValue'),$('#quarter').combobox('getValue'));
	}
	//console.log(myArr);

var form = $('<form action="' + url + '" method="post">' +
  '<input type="text" name="indicator_num" value="' + myArr[0] + '" />' +
  '<input type="text" name="year" value="' + myArr[4] + '" />' +
  '<input type="text" name="quarter" value="' + myArr[2] + '" />' +
  '<input type="text" name="quarterJoin" value="' + myArr + '" />' +
  '</form>');
$('body').append(form);
form.submit();

}



$(document).ready(function($){
			$('#dgReport').datagrid();
	});


