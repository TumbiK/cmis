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
    equals: {
        validator: function(value,param){
            return value == $(param[0]).val();
        },
        message: 'Confirm Password do not match.'
    }
});
$(document).ready(function(){


var lastIndex;
    
    $('#datGrid').datagrid({
         onDblClickRow:function(rowIndex){
          if(lastIndex != rowIndex){
            $(this).datagrid('endEdit',lastIndex);
            $(this).datagrid('beginEdit',rowIndex);
          }
          lastIndex=rowIndex;

        },
         onBeforeEdit:function(rowIndex,row){
            row.editing = true;
            updateActions(rowIndex);

        },
        onAfterEdit:function(rowIndex,row){
            row.editing = false;
           updateActions(rowIndex);
        },
        onCancelEdit:function(rowIndex,row){
            row.editing = false;
            updateActions(rowIndex);
        }    


    });

    
//hide or show textbox
    $.extend($.fn.textbox.methods, {
    show: function(jq){
        return jq.each(function(){
            $(this).next().show();
        })
    },
    hide: function(jq){
        return jq.each(function(){
            $(this).next().hide();
        })
    }
})

 $('#split').click(function(){ //when clicking the link
        $('#spliLoc ').toggle();  //toggles visibility
    });
   
//Implementing the chained Remote Selects in the application
$('#taSelect').remoteChained({
    parents:"#dist",
    url:"/taSelect"
});

$('#taNSel').remoteChained({
    parents:"#distNgv",
    url:"/taSelect"
});

//TA Transfer Select Remote chained
$('#taTrans').remoteChained({
    parents:"#disTrans",
    url:"/taSelect"
});

$("#gvhSelVil").remoteChained({
    parents :"#taNSel",
    url : "/gvhSelect"  

});


$("#gvhSelx").remoteChained({
    parents :"#taSelect",
    url : "/gvhSelect"  

});

//GVH Transfer Select
$("#gvhSelTrans,#gvhSelTransTo").remoteChained({
    parents :"#taTrans",
    url : "/gvhSelect"  

});


//individual HouseHold Transfer RemoteChained

$('#taTransInd,#taTransIndTo').remoteChained({
    parents:"#disTransInd",
    url:"/taSelect"
});


$("#gvhSelTransToInd").remoteChained({
    parents :"#taTransIndTo",
    url : "/gvhSelect"  

});
$("#gvhSelTransInd").remoteChained({
    parents :"#taTransInd",
    url : "/gvhSelect"  

});


$("#vilSelTrans").remoteChained({
    parents :"#gvhSelTransInd",
    url : "/vilSelect"  
});

$("#vilSelTransTo").remoteChained({
    parents :"#gvhSelTransToInd",
    url : "/vilSelect"  

});


//individual Member Transfer RemoteChained

$('#taTransImem,#taTransImemTo').remoteChained({
    parents:"#disTransImem",
    url:"/taSelect"
});

$("#gvhSelTransTomem").remoteChained({
    parents :"#taTransImemTo",
    url : "/gvhSelect"  

});
$("#gvhSelTransImem").remoteChained({
    parents :"#taTransImem",
    url : "/gvhSelect"  

});


$("#vilSelTransImem").remoteChained({
    parents :"#gvhSelTransImem",
    url : "/vilSelect"  
});

$("#vilSelTransTomem").remoteChained({
    parents :"#gvhSelTransTomem",
    url : "/vilSelect"  

});



//add Institution Member


//create the datagrid on codes 
$('#dgTa,#dgGvh,#dgVil,#dgTransG,#dgTransInd,#dgTransImem,#dgInst').datagrid();  

//take effect on change of the Select and post information to load the datagrid

/*$('#gvhSelVil').on('change',function(){
    $('#dgVil').datagrid('load',function(){
           code_dist: $('#dist').val(),
    code_ta: $('#taSelect').val(),
    code_gvh:$('#gvhSelx').val(),
        gvhEdit:'1'
          
    });
  alert('this changed');
});*/



//handle remote chained selects on change to load data in datagrid

$("#gvhSelTrans").on('change',function(){
     $('#dgTransG').datagrid('load',{
    code_dist: $('#disTrans').val(),
    code_ta: $('#taTrans').val(),
    code_gvh:$('#gvhSelTrans').val(),
        vilEdit:'1'

});
 });

//load the indivual tranfer data grid
$("#vilSelTrans").on('change',function(){
     $('#dgTransInd').datagrid('load',{
    code_dist: $('#disTransInd').val(),
    code_ta: $('#taTransInd').val(),
    code_gvh:$('#gvhSelTransInd').val(),
    code_village:$('#vilSelTrans').val(),
        IndTrans:'1'

});
 });


$('#gvhSelVil').on('change',function(){
   
   $('#dgVil').datagrid('load',{
    code_dist: $('#distNgv').val(),
    code_ta: $('#taNSel').val(),
    code_gvh:$('#gvhSelVil').val(),
        vilEdit:'1'
   });

});


$('#taSelect').on('change',function(){
   
   $('#dgGvh').datagrid('load',{
    code_dist: $('#dist').val(),
    code_ta: $('#taSelect').val(),
    code_gvh:$('#gvhSelx').val(),
        gvhEdit:'1'
   });

});

$('#district').on('change',function(){



$('#dgTa').datagrid('load',{
    code_dist: $('#district').val(),
        taEdit:'1'
});


});

});


function addInstMember() {
    
    $('#Inst').textbox('setValue',$('#institution').combobox('getValue'));
    var institute=$('#institution').combobox('getValue');

    $('#dlgInst').dialog('open');
    $('#inst').textbox('setValue',$('#institution').combobox('getValue'));

    url='save_inst_member';
    
}
function addTA(){
    
    var lastRow=($('#dgTa').datagrid('getData').total);
    $('#Rec_Id_District').textbox('setValue',$('#district').val());
    $('#TA_ID').textbox('setValue',lastRow+1);
   
    $('#dlg').dialog('open');



    url='codesta';
}

function addGVH(){

var lastRow=($('#dgGvh').datagrid('getData').total);
$('#dlgGvh').dialog('open');

$('#Wala_id').textbox('setValue',$('#gvhSelx').val()).textbox('hide');

$('#Rec_id_TA').textbox('setValue',$('#taSelect').val());
$('#GVH_ID').textbox('setValue',lastRow+1);
 url='codesGVH';
}

function addVillage(){
    var lastRow=($('#dgVil').datagrid('getData').total);
    $('#dlgVil').dialog('open');
    $('#Rec_id_GVH').textbox('setValue',$('#gvhSelVil').val());
    $('#Village_ID').textbox('setValue',lastRow+1);
 url='codesVillage';
}

function saveTA(){
    $('#fm,#fmGvh,#fmVil,#fmInst').form('submit',{
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
            } else if(result.successMsg) {
                 $.messager.show({
                   title: 'success',
                   msg: result.successMsg
                });

                    
                    $('#fmInst').form('clear');
                    $('#dlgInst').dialog('close');
                    $('#tt,#ttPmu').datagrid('reload');
                  
                     $('#dgTa').datagrid('reload'); 
                     $('#dgGvh').datagrid('reload');
                     $('#dgVil').datagrid('reload');
                     $('#dgInst').datagrid('reload');
                     var gvhTa=$('#Rec_id_TA').textbox('getValue');
                     var vilGvh=$('#Rec_id_GVH').textbox('getValue');
                   $('#fm,#fmGvh,#fmVil,#fmInst').form('clear');
                    var lastRow=($('#dgTa').datagrid('getData').total);
                    var lstRow=($('#dgGvh').datagrid('getData').total);
                    var vlstRow=($('#dgVil').datagrid('getData').total);
                    

                    $('#Rec_Id_District').textbox('setValue',$('#district').val());
                         $('#TA_ID').textbox('setValue',lastRow+2);
                         $('#GVH_ID').textbox('setValue',lstRow+2);
                         $('#Village_ID').textbox('setValue',vlstRow+2);
                         $('#Rec_id_TA').textbox('setValue',gvhTa);
                         $('#Rec_id_GVH').textbox('setValue',vilGvh);
                         
           }
        }

    });

}

function checkHH(){
    $('#dgTransImem').datagrid('load',{
        editHH:$('#hh_number').val(),
        code_dist: $('#disTransImem').val(),
        code_ta: $('#taTransImem').val(),
        code_gvh:$('#gvhSelTransImem').val(),
        code_village:$('#vilSelTransImem').val()
    });
}

function transfer(){
     
      var row = $('#dgTransG').datagrid('getSelections'); // get multiple selection s for transfers
     url='gpTransfer';
    var refTa=$('#taTrans').val();
    var oldGvh=$('#gvhSelTrans').val();
    var transGvh=$('#gvhSelTransTo').val();
    //alert(row.length);
    if(oldGvh !=0 && transGvh!=0){
     for (var i=0;i<row.length;i++){
    
     $.ajax({
        url,
        type:'GET',
        dataType:'json',
        data:{refTa:refTa,GVH:oldGvh,transGvh:transGvh,Village:row[i].Rec_id},


            success:function(result){
                // console.log(eval('('+data+')'));
                   // var result = eval('('+result+')');
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
                             
                }
            }
          
     });

   }
   }else{
    $.messager.alert('warning','Please ensure you have Selected the GVH and Village from Transfer');
   }
}

function transferImem(){
    var row = $('#dgTransImem').datagrid('getSelections'); // get multiple selection s for transfers

//capture transfer details
     url='ImemTransfer';
    var oldTa=$('#taTransImem').val();
    var oldGvh=$('#gvhSelTransImem').val();
    var transTA=$('#taTransImemTo').val();
    var transGvh=$('#gvhSelTransTomem').val();
    var transVil=$('#vilSelTransTomem').val();
    var oldVil=$('#vilSelTransImem').val();
    var hh_number=$('#hh_number').val();

    if((row.length==0)){
        alert(transVil);
        $.messager.alert('warning','No HouseHold for Transfer Selected');
    }
    else
    {

    $.messager.prompt('New HouseHold ','Please Enter the New HouseHold Number',function(r){ 
        response=r;
        if(!isNaN(response) && (response.length<=4)){
            // alert('We are on top of things');
             // if( transVil !=oldVil){
                     for (var i=0;i<row.length;i++){
                        // alert(row[i].HH_Number)
    
                     $.ajax({
                             url,
                             type:'GET',
                             dataType:'json',
                             data:{Ta:oldTa, GVH:oldGvh , transTA:transTA, transGvh:transGvh, transVil:transVil,oldVil:oldVil,hh_number:hh_number,hh_member_number:row[i].HH_Member_Number,newHH:response},
                            success:function(result){
                                    }
                            });

   }
   //}else{
   // $.messager.alert('warning','Please ensure you have Selected the GVH and Village from Transfer');
   //}


        }else{
            $.messager.alert('warning','The HouseHold Number Entered is Invalid');
        }
    });

   
}

}

 

function transferInd(){
    var response=0;
    var i=0;
      var row = $('#dgTransInd').datagrid('getSelections'); // get multiple selection s for transfers
     url='indTransfer';
    var oldTa=$('#taTransInd').val();
    var oldGvh=$('#gvhSelTransInd').val();
    var transTA=$('#taTransIndTo').val();
    var transGvh=$('#gvhSelTransToInd').val();
    var transVil=$('#vilSelTransTo').val();
    var oldVil=$('#vilSelTrans').val();
    if(row.length==0){
        $.messager.alert('warning','No HouseHold for Transfer Selected');
    }
    else
    {
   for (i=0;i<row.length;i++)
   {
         
        response=prompt('Input HH Number For '+row[i].HH_Number+' Name: '+row[i].Name_of_HH_member);

          if(!isNaN(response) && (response.length<=4)){
                 if( transVil !=oldVil){
                      //console.log(row[i].HH_Number);//for debugging purpose
                      $.ajax({
                             url,
                             type:'GET',
                             dataType:'json',
                             data:{Ta:oldTa, GVH:oldGvh , transTA:transTA, transGvh:transGvh, transVil:transVil,oldVil:oldVil,hh_number:row[i].HH_Number,newHH:response},
                            success:function(result){
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
                             
                }
                                    }
                            });
                  }else{
                      $.messager.alert('warning','Please ensure you have Selected the Correct GVH and Village from Transfer');
                 }

           }else{
            $.messager.alert('warning','The HouseHold Number Entered is Invalid');
            }


   }
   

  /*  $.messager.prompt('New HouseHold ','Please Enter the New HouseHold Number',function(r){ 
        response=r;
       
            // alert('We are on top of things');
             
                     
                       
    
                     
              
                


       
    });*/

 


   
}
}



function addUser(){
	 $('#dlg').dialog('open').dialog('setTitle','Add New User');
	  $('#fm').form('clear');
	 url='adduser';
//	 alert(url);
}

function editUser(){
	 $('#dlg').dialog('open').dialog('setTitle','New User');
	  $('#fm').form('clear');
	 url='edituser';
}

function saveUser(){

	$('#ff').form('submit',{
		 url: url,
        onSubmit: function(param){
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
                $('#dlg').dialog('close');        // close the dialog
              //  $('#dg').datagrid('reload');    // reload the user data
               // $('#fm').form('clear');
            }
        }
    });

 		       	 
}



