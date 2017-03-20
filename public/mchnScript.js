
	function addCCFLSchild(){
		var url="saveCCFLSession";
		$('#dlgSessions').dialog('open');
		var dist=$('#cc1').combobox('getValue');
		var ta=$('#cc2').combobox('getValue');
		var GVH=$('#cc3').combobox('getValue');
		var cg=$('#cc4').combobox('getValue');
		var cgpromo=$('#cc8').combobox('getValue');
		var cgleader=$('#cc5').combobox('getValue');
		$('#Rec_id_dist').textbox('setValue',dist);
		$('#Rec_TA_id').textbox('setValue',ta);
		$('#Rec_gvh').textbox('setValue',GVH);
		$('#group_name').textbox('setValue',cg);
		$('#cg_promo_id').textbox('setValue',cgpromo);
		$('#group_leader').textbox('setValue',cgleader);
		
}

 function saveSession(){
         //save the initial CCFLS Session 
         var url="saveCCFLSession";
         $('#fmCCFLSession').form('submit',{
        url:url,
        onSubmit:function(){
            return $(this).form('validate');
        },
        success: function(result){
            var result = eval('('+result+')');
           
            var ccfls_Num=result.District+''+result.ccfls_number;
            if (result.errorMsg){
                $.messager.show({
                   title: 'Error',
                   msg: result.errorMsg
                });
            }



            	if(result.ccfls_number) {
            	  $('#CCFLS_Number').textbox('setValue',ccfls_Num);
	                 $.messager.show({
	                   title: 'CCFLS Success',
	                   msg: 'CCFLS Session Successfully Created'
	                });
                           
                     
                    $('#fmCCFLSession').form('clear');
                    $('#dlgSessions').dialog('close');
                    
                         
           }
        }

    });

    
     	 



         }

function saveCCFLSBen()
{
	var url="saveCCFLSChildBen";
	var row=$('#tt').datagrid('getSelected');
		row["caregroup"]=$('#cc4').combobox('getValue');
		row["ccfls_session"]=$('#CCFLS_Number').textbox('getValue');
        row["cgleader"]=$('#cc5').combobox('getValue');
        row["cg_promo"]=$('#cc8').combobox('getValue');
        row["caregroup"]=$('#cc4').combobox('getValue');
		
		childDetails(row);
}

function saveCCFLSChild()
{
	var url="saveCCFLSChildBen";

	 $('#fmDetails').form('submit',{
        url:url,
        onSubmit:function(){
            return $(this).form('validate');
        },
        success: function(result){
            var result = eval('('+result+')');
           
            if (result.errorMsg){
                $.messager.show({
                   title: 'Error',
                   msg: result.errorMsg
                });
            }
            if(result.successMsg) {
           
	             $.messager.show({
	                   title: 'CCFLS Child Success',
	                   msg: 'CCFLS Child Successfully Added'
	                });
                           
                     
                    $('#fmDetails').form('clear');
                    $('#dlgDetails').dialog('close');
                    $('#dgCCFLS').datagrid('load',$('#CCFLS_Number').textbox('getValue'));
                    
                         
           }
        }

    });

}


function childDetails(child){
	$('#cc11').textbox('setValue',child.ccfls_session);
	$('#cc12').textbox('setValue',child.Village);
	$('#cc13').textbox('setValue',child.HH_Number);
	$('#cc14').textbox('setValue',child.HH_Member_Number);
    if(child.Age>2){
    	$.messager.show({
        title: 'success',
        msg: 'Household Member is over aged for Child CCFLS'
         });
    }else{
    	$('#dlgDetails').dialog('open');
    }
	
}

function followUp()
{
	
	var row=$('#tt').datagrid('getSelected');
	$('#dlgEdit').dialog('close');
	$('#dlgfollowup').dialog('open');
	    row["caregroup"]=$('#cc4').combobox('getValue');
        row["cgleader"]=$('#cc5').combobox('getValue');
        row["follow"]=1;


       
}

function saveFollowUp()
{
	var url="updateCCFLS";
	 

	var row=$('#tt').datagrid('getSelected');
	 row["ccfls_session"]=$('#CCFLS_Number').textbox('getValue');
	if(row['follow']==1){
		row["f1date"]=$('#f1date').datebox('getValue');
		row["f1weight"]=$('#f1weight').textbox('getValue');
		row["f1MUAC"]=$('#f1MUAC').textbox('getValue');
	}else if(row['follow']==2){
		row["f2date"]=$('#f2date').datebox('getValue');
		row["f2weight"]=$('#f2weight').textbox('getValue');
		row["f2MUAC"]=$('#f2MUAC').textbox('getValue');
	}
       
        

	 	

		if(row){
        $.ajax({
                type:'get',
                url:url,
                data:row,
                success:function(result){
                    var result = eval('('+result+')');
                    if (result.errorMsg){
                                 $.messager.show({
                                 title: 'Error',
                                 msg: result.errorMsg
                              });
                     } 
                     if(result.successMsg){
                            $.messager.show({
                            title: 'success',
                            msg: result.successMsg
                             });
                             $('#dlgEdit').dialog('close');
                             $('#dgDiner').datagrid('reload');
                }
            }
    });
}
}

function followUpnd()
{
	alert("Second Month Follow up");
	var row=$('#tt').datagrid('getSelected');
	$('#dlgEdit').dialog('close');
	$('#dlgfollowupnd').dialog('open');
	    row["caregroup"]=$('#cc4').combobox('getValue');
        row["cgleader"]=$('#cc5').combobox('getValue');
        row["follow"]=2;
        
}

function saveFollowUpNd()
{

	var url="updateCCFLSnd";

	var row=$('#tt').datagrid('getSelected');
		if(row){
        $.ajax({
                type:'get',
                url:url,
                data:row,
                success:function(result){
                    var result = eval('('+result+')');
                    if (result.errorMsg){
                                 $.messager.show({
                                 title: 'Error',
                                 msg: result.errorMsg
                              });
                     } 
                     if(result.successMsg){
                            $.messager.show({
                            title: 'success',
                            msg: result.successMsg
                             });
                             $('#dlgEdit').dialog('close');
                             $('#dgDiner').datagrid('reload');
                }
            }
    });
}
}

function followUprd()
{
	alert("Third Month Follow up");
	var row=$('#tt').datagrid('getSelected');
	$('#dlgEdit').dialog('close');
	$('#dlgfollowuprd').dialog('open');
	    row["caregroup"]=$('#cc4').combobox('getValue');
        row["cgleader"]=$('#cc5').combobox('getValue');
        row["follow"]=1;
        row["date_registration"]=$('#cc7').datebox('getValue');
}

function saveFollowUprd()
{

	var url="updateCCFLSrd";

	var row=$('#tt').datagrid('getSelected');
		if(row){
        $.ajax({
                type:'get',
                url:url,
                data:row,
                success:function(result){
                    var result = eval('('+result+')');
                    if (result.errorMsg){
                                 $.messager.show({
                                 title: 'Error',
                                 msg: result.errorMsg
                              });
                     } 
                     if(result.successMsg){
                            $.messager.show({
                            title: 'success',
                            msg: result.successMsg
                             });
                             $('#dlgEdit').dialog('close');
                             $('#dgDiner').datagrid('reload');
                }
            }
    });
}
}
