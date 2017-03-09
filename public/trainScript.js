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


  function doSearch(){
    $('#ttPmu,#tt').datagrid('load',{
      id:$('#institution').combobox('getValue'),
      participantid:$('#participantid').val(),
      designation:$('#designation').val()
    });
  }
$(document).ready(function(){
  




var trUrl="/trainDetails";
     $('#ttPmu').datagrid({
         rownumbers:"true",
     fitColumns:"true",
      singleSelect:"true",
       url:trUrl,
       
        
        title:"Edit HouseHold Members",
         iconCls:'icon-edit',

         columns:[[
            {field:"name_of_participant", title:'Name'},
            {field:"Sex", title:'Sex'},            
              {field:"institution",title:'Institution'},            
            {field:"designation",title:'Designation'},           
            {field:"contact",title:'contact'}
            ]]
        

    });

    
 
  

})
/*function updateActions(index){
              $('#dgSub,#dgPmu,#dgCommunity').datagrid('updateRow',{
                        index: index,
                        row:{}
                    });
                }*/
  function getRowIndex(target){
                var tr = $(target).closest('tr.datagrid-row');
                return parseInt(tr.attr('datagrid-row-index'));
            }

function editTrainMember(target){
      var rowIndex= getRowIndex(target);
     $('#dgSub').datagrid('beginEdit', rowIndex);
}
function editPmuMember(target){
      var rowIndex= getRowIndex(target);
     $('#dgPmu').datagrid('beginEdit', rowIndex);
}

function cancelPmu(target){
    $('#dgPmu').datagrid('cancelEdit', getRowIndex(target));
}


function editComMember(target){
      var rowIndex= getRowIndex(target);
     $('#dgCommunity').datagrid('beginEdit', rowIndex);
}

function cancelCom(target){
    $('#dgCommunity').datagrid('cancelEdit', getRowIndex(target));
}

function cancelTrain(target){
    $('#dgSub').datagrid('cancelEdit', getRowIndex(target));
}

function saveTrain(target){
    $('#dgSub').datagrid('endEdit', getRowIndex(target));
    var rows=$('#dgSub').datagrid('getRows');


    $.each(rows,function(i,row){
        var url='/updateTrain';
      row["date"]=$('#date').datebox('getValue');
   
        $.ajax({
            url:url,
            type:'Get',
            dataType:'json',
            data:row

        });

        $('#dgSub').datagrid('reload');


    });
}

//save editor for PMU
function savePmu(target){
    $('#dgPmu').datagrid('endEdit', getRowIndex(target));
    var rows=$('#dgPmu').datagrid('getRows');


    $.each(rows,function(i,row){
        var url='/updatePmu';
      row["date"]=$('#date').datebox('getValue');
   
        $.ajax({
            url:url,
            type:'Get',
            dataType:'json',
            data:row

        });

        $('#dgPmu').datagrid('reload');


    });
}

//save editor for Community
function saveCom(target){
    $('#dgCommunity').datagrid('endEdit', getRowIndex(target));
    var rows=$('#dgCommunity').datagrid('getRows');


    $.each(rows,function(i,row){
        var url='/updateCom';
      row["date"]=$('#date').datebox('getValue');
   
        $.ajax({
            url:url,
            type:'Get',
            dataType:'json',
            data:row

        });

        $('#dgCommunity').datagrid('reload');


    });
}

function padLeft(nr, n, str){
    return Array(n-String(nr).length+1).join(str||'0')+nr;
}

function trainingNum(){
	//create data row
	var row={};
		row["sector"]=$('#cc1').combobox('getValue');
		row["title"]=$('#cc2').combobox('getValue');
		row["venue"]=$('#venue').textbox('getValue');
	row["date"]=$('#date').combobox('getValue');
  row["train_Num"]=$('#cc6').textbox('getValue');


		if(row['date']!='')
		{
			$.ajax({
				type:'get',
                url:'newTraining',
                data:row,
                success:function(result){
                    var result = eval('('+result+')');
                    //console.log(result);
                    
                     var train_Num=padLeft(result.partner,2)+''+padLeft(result.rec_id,4);
                    if(result.rec_id){
                      $('#cc6').textbox('setValue',train_Num);
                      $('#cc1').combobox('setValue',result.sector);
                      $('#cc2').combobox('setValue',result.title);
                      $('#venue').textbox('setValue',result.venue);
                      $('#dgSub').datagrid('load',{training_num:train_Num,date:$('#date').datebox('getValue'),train:'1'});
                      $('#dgPmu').datagrid('load',{training_num:train_Num,date:$('#date').datebox('getValue'),train:'2'});
                    	$.messager.show({
                                 title: 'Training Number',
                                 msg: padLeft(result.partner,2)+''+padLeft(result.rec_id,4)                             
                              });
                    	
                      //alert(result.venue);


                    }
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
			})
		}else{
            alert('Please Enter the 6 Digit Training Number and The Date to Proceed');
        }
	}

//community Training Number Generation

function trainingNumCom(){
    //create data row
    var row={};
        row["sector"]=$('#cc1').combobox('getValue');
        row["title"]=$('#cc2').combobox('getValue');
        row["venue"]=$('#cc7').combobox('getText');
    row["date"]=$('#date').combobox('getValue');
  row["train_Num"]=$('#cc6').textbox('getValue');


        if(row['date']!='')
        {
            $.ajax({
                type:'get',
                url:'newTraining',
                data:row,
                success:function(result){
                    var result = eval('('+result+')');
                    //console.log(result);
                                
                    alert(result.rec_id);
                     
                    if(result.rec_id){
                        var train_Num=padLeft(result.partner,2)+''+padLeft(result.rec_id,4);
                      $('#cc6').textbox('setValue',train_Num);
                      $('#cc1').combobox('setValue',result.sector);
                      $('#cc2').combobox('setValue',result.title);
                      $('#venue').textbox('setValue',result.venue);
                      $('#dgCommunity').datagrid('load',{training_num:train_Num,date:$('#date').datebox('getValue'),train:'3'});
                      
                        $.messager.show({
                                 title: 'Training Number',
                                 msg: padLeft(result.partner,2)+''+padLeft(result.rec_id,4)                             
                              });
                        
                      //alert(result.venue);


                    }
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
            })
        }else{
            alert('Please Enter the 6 Digit Training Number and The Date to Proceed');
        }
    }


  function PmutrainingParticipants()
  {
     var SaveUrl="savePmuBen";
    $('#dlgEdit').dialog('open').dialog('setTitle','PMU/PVO Training Registration ');
       
       

  }

   function   CommunityParticipants()
  {
    $('#dlgEdit').dialog('open').dialog('setTitle','Community Level Training Registration ');

     var statusid=  [{statid: '1', status: 'Deceased'},{statid: '2', status: 'Moved Out'}];
     var sexCom=[{sexid:'1',sex:'Male'},{sexid:'2',sex:'Female'}];
        $('#ttCommunity').datagrid({
     rowNumbers:"false",
     fitcolumns:"true",
      singleSelect:"true",
       url:"/hhdetails?editHH="+$('#hh_number').textbox('getValue')+'&code_village='+$('#cc8').combobox('getValue')+'&code_gvh='+$('#cc3').combobox('getValue')+'&code_ta='+$('#cc7').combobox('getValue'),
       
        idField:"HH_Number",
        title:"Edit HouseHold Members",
         iconCls:'icon-edit',

         columns:[[
            

            {field:'HH_Number',width:'50', title:'HH No.'},
            {field:"Name_of_HH_member", width:"120",editor:{type:'validatebox',options:{required:true}}, title:'Name'},
            {field:"HH_Member_Number", width:"40",title:' No.'},
            {field:"Sex", width:"50", title:'Sex',
                formatter:function(value){
                    for(var i=0;i<sexCom.length;i++){
                        if(sexCom[i].sexid==value) return sexCom[i].sex;
                    }
                    return value;
                },
                editor:{
                    type:'combobox',
                    options:{
                        editable:false,
                        valueField:'sexid',
                        textField:'sex',
                        data:sexCom,
                        panelHeight: 'auto'
                    }
                }},
            {field:"dob", width:"80", editor:'textbox',title:'Date of Birth'},
            {field:"Age",width:"40",editor:{type:'numberbox',options:{required:true,validType:"ageRange[8,100]"}},title:' Age'},
            
            {field:"hh_size", width:"40", editor:{type:'validatebox',options:{required:false}},title:'Size'},
            {field:"head_h",width:"40", editor:{type:'checkbox',options:{required:true,on: '1',off: '0'}},title:'Head'},
            {field:"comments" ,width:"80",editor:{type:'validatebox',options:{required:false}},title:'Remarks'},
            {field:"Ben_Reg_date", width:"80",editor:{type:'datebox',options:{required:true}},title:'Registration Date'},
            {field:'status',title:'Status',width:"80",align:'center',
                    formatter:function(value){
                    for(var i=0;i<statusid.length;i++){
                        if(statusid[i].statid==value) return statusid[i].status;
                    }
                    return value;
                },
                editor:{
                    type:'combobox',
                    options:{
                        editable:false,
                        valueField:'statid',
                        textField:'status',
                        data:statusid,
                        panelHeight: 'auto'
                    }
            }},
            {field:'action',title:'Action',width:50,align:'center', 
                formatter:function(value,row,index){
                    if (row.editing){
                        var s = '<a href="#" onclick="saverow(this)">Save</a> ';
                        var c = '<a href="#" onclick="deleterow(this)">Cancel</a>';
                        return s+c;
                    } else {
                        var e = '<a href="#" onclick="editrow(this)">Edit</a> ';
                        var d = '<a href="#" onclick="deleterow(this)">Delete</a>';
                        return e+d;
                    }
                }
            }
            
            ]],
            onBeforeEdit:function(index,row){
                    row.editing = true;
                    updateActions(index);
                },
            onBeginEdit:function(index,row){
                var editors=$('#ttCommunity').datagrid('getEditors',index);
                var dat1=$(editors[2].target);
                var dat2=$(editors[3].target);

                    dat1.datebox({
                        onSelect:function(date){    
                        //calculate the age for the individual
                        var dbAge=(new Date).getFullYear()-date.getFullYear();
                        //alert(dbAge);
                        dat2.numberbox('setValue',dbAge);
                        }
                    });
                

            },
                onAfterEdit:function(index,row){
                    row.editing = false;
                    updateActions(index);
                },
                onCancelEdit:function(index,row){
                    row.editing = false;
                    updateActions(index);
                }
        


      

});
       

  }

function trainingParticipants(){
		var SaveUrl="saveTrainBen";
        $('#dlgEdit').dialog('open').dialog('setTitle','TA/Sub District Training Registration ');

		var statusid=  [{statid: '1', status: 'Deceased'},{statid: '2', status: 'Moved Out'}];
     var sexCom=[{sexid:'1',sex:'Male'},{sexid:'2',sex:'Female'}];
     var trUrl="/trainDetails?id="+$('#institution').combobox('getValue')+"&struct="+$('#cc8').combobox('getValue');

$('#tt').datagrid({
         rowNumbers:"true",
     fitColumns:"true",
      singleSelect:"true",
       url:trUrl,
       
        idField:"rec_id",
        title:"Edit HouseHold Members",
         iconCls:'icon-edit',

         columns:[[
            {field:"name_of_participant", title:'Name'},
            {field:"Sex", title:'Sex',
                formatter:function(value){
                    for(var i=0;i<sexCom.length;i++){
                        if(sexCom[i].sexid==value) return sexCom[i].sex;
                    }
                    return value;
                },
                editor:{
                    type:'combobox',
                    options:{
                        editable:false,
                        valueField:'sexid',
                        textField:'sex',
                        data:sexCom,
                        panelHeight: 'auto'
                    }
                }},
            
              {field:"institution",title:'Institution'},            
            {field:"designation",title:'Designation'}            
            ]],
            onBeforeEdit:function(index,row){
                    row.editing = true;
                    updActions(index);
                },
            onBeginEdit:function(index,row){
                var editors=$('#tt').datagrid('getEditors',index);
                var dat1=$(editors[2].target);
                var dat2=$(editors[3].target);

                    dat1.datebox({
                        onSelect:function(date){    
                        //calculate the age for the individual
                        var dbAge=(new Date).getFullYear()-date.getFullYear();
                        //alert(dbAge);
                        dat2.numberbox('setValue',dbAge);
                        }
                    });
                

            },
                onAfterEdit:function(index,row){
                    row.editing = false;
                    updActions(index);
                },
                onCancelEdit:function(index,row){
                    row.editing = false;
                    updActions(index);
                }
        

    });

    //datagrid for PMU PVO
   }





function updActions(index){
            $('#tt').datagrid('updateRow',{
                index: index,
                row:{}
            });
        }

function gtRowIndex(target){
    var tr = $(target).closest('tr.datagrid-row');
    return parseInt(tr.attr('datagrid-row-index'));
}


function save(target){
    $('#tt').datagrid('endEdit', gtRowIndex(target));
    var rows=$('#tt').datagrid('getRows');


    $.each(rows,function(i,row){
        var url='/updhold';
        row["District"]=$('#cc1').combobox('getValue');
     row["TA"]=$('#cc2').combobox('getValue');
     row["GVH"]=$('#cc3').combobox('getValue');
     row["Village"]=$('#cc6').combobox('getValue');
        $.ajax({
            url:url,
            type:'Get',
            dataType:'json',
            data:row

        });

        $('#dg').datagrid('reload');


    });
}
function cancel(target){
    $('#tt').datagrid('cancelEdit', gtRowIndex(target));
}
    function editMember(target){
      var rowIndex= gtRowIndex(target);
     $('#tt').datagrid('beginEdit', rowIndex);
}

  



// Save Training Participants
function saveBen(){

    
    var row=$('#tt,#ttPmu').datagrid('getSelected');
    row["training_num"]=$('#cc6').textbox('getValue');
    row["date"]=$('#date').datebox('getValue');
    //inst is used to check whether its PMU/PVO or Sub District
   
     row["inst"]=$('#cc8').combobox('getValue');
  
 
    var SaveUrl='saveTrainBen';
  
   // console.log(row); //for debugguing purposes
   if(row){
        $.ajax({
                type:'get',
                url:SaveUrl,
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
                             //$('#dlgEdit').dialog('close');
                             $('#dgSub').datagrid('reload');
                }
            }
    });
}



}

//save PMU Ben
function savePmuBen(){
    var row=$('#tt,#ttPmu').datagrid('getSelected');
    row["training_num"]=$('#cc6').textbox('getValue');
    row["date"]=$('#date').datebox('getValue');
    //inst is used to check whether its PMU/PVO or Sub District
   var SaveUrl="savePmuBen";
  
   // console.log(row); //for debugguing purposes
   if(row){
        $.ajax({
                type:'get',
                url:SaveUrl,
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
                             
                             $('#dgPmu').datagrid('reload');
                }
            }
    });
}



}

function saveComBen(){
    var row=$('#ttCommunity').datagrid('getSelected');
    row["training_num"]=$('#cc6').textbox('getValue');
    row["date"]=$('#date').datebox('getValue');
    //inst is used to check whether its PMU/PVO or Sub District
   var SaveUrl="saveComBen";
  
   // console.log(row); //for debugguing purposes
   if(row){
        $.ajax({
                type:'get',
                url:SaveUrl,
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
                             $('#dgCommunity').datagrid('reload');
                }
            }
    });
}



}




