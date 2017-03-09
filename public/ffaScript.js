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



var fdpVal;
//ffa datagrid actions





function comReview(){

    
      var row=$('#dg').datagrid('getSelected');

         if(row){
             $('#dlgApp').dialog('open').dialog('setTitle','Approve Proposal');
              $('#fmAppProp').form('load',row); 

         }else{
            alert('Please Select a Project to Approve');
         }
     url='update_propFFA?id='+row.id;
}


function ffaReview(){
    var p = $('#contents').layout('panel','center');
            p.panel({href:'ff_rev_proposal.blade.php'});


}
    
	function destroy(){
		$('#p').panel('destroy');
		location.reload();
	}


//New Proposal Dialog Box

    function newProp(){
        $('#dlg').dialog('open').dialog('setTitle','New Proposal');
        $('#fmProp').form('clear');
         url='save_prop';
    }

    function editProp(){
        
        var row=$('#dg').datagrid('getSelected');
      //  console.log(row);
        //alert(row.Asset_description);
        
           if(row){
             $('#dlg').dialog('open').dialog('setTitle','Edit Proposal');
              $('#fmProp').form('load',row); 

         }
     url='update_prop?id='+row.id;
    }










function saveAppProp(){
    $('#fmProp,#fmAppProp,#fm').form('submit',{
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

                $.messager.show({
                    title: 'Success',
                    msg: result.successMsg
                });
               // $('#dlg').dialog('close');        // close the dialog
                $('#dg').datagrid('reload');    // reload the user data
                $('#fmProp').form('clear');
                var v = $('#reg_dat').datebox('getValue');
                $('#Ben_Reg_date').datebox('setValue',v);
            }
        }
    });

} 



//ffa FAF
function ffaFaf(){
    var p = $('#contents').layout('panel','center');
            p.panel({href:'ffa_FAck_form.blade.php'});

}
 

function ffaAck(){
    var p = $('#contents').layout('panel','center');
            p.panel({href:'ffa_AckFood_form.blade.php'});

}
//MCHN Ben Registration

function mchnBen_reg(){

    var p = $('#contents').layout('panel','center');
           
            p.panel({href:'mchn_Ben_reg.blade.php'});

}

function  mchnChildBen_reg(){
   
    var p = $('#contents').layout('panel','center');

            p.panel({href:'mchn_ChildBen_reg.blade.php'});

}

function mchnBen_verification(){
    var p = $('#contents').layout('panel','center');
            p.panel({href:'mchn_ben_verification.blade.php'});

}

function mchnFaf(){
   var p = $('#contents').layout('panel','center');
            p.panel({href:'mchn_ben_faf.blade.php'});

}

function mchnAck(){
    var p = $('#contents').layout('panel','center');
            p.panel({href:'mchn_AckFood_form.blade.php'});

}
//Add FFA Participants
function insert(){
            var row = $('#tt,#mchnChildtt,#mchnPregtt').datagrid('getSelected');
            //get the total number of Row in T=tt datagrid
            var lastRow=($('#tt,#mchnChildtt,#mchnPregtt').datagrid('getData').total);


            if (row){
                var index = $('#tt,#mchnChildtt,#mchnPregtt').datagrid('getRowIndex', row);
            } else {
                index = 0;
            }
           
            
            $('#tt,#mchnChildtt,#mchnPregtt').datagrid('selectRow',0);

             var myRow=$('#tt,#mchnChildtt,#mchnPregtt').datagrid('getSelected');
            $('#tt,#mchnChildtt,#mchnPregtt').datagrid('insertRow', {
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
            $('#tt,#mchnChildtt,#mchnPregtt').datagrid('selectRow',index);
            $('#tt,#mchnChildtt,#mchnPregtt').datagrid('beginEdit',index);
        }


//insert CGLeader
function insertLeader(){
            var row = $('#ttLeader').datagrid('getSelected');
            //get the total number of Row in T=tt datagrid
            var lastRow=($('#ttLeader').datagrid('getData').total);


            if (row){
                var index = $('#ttLeader').datagrid('getRowIndex', row);
            } else {
                index = 0;
            }
           
            
            $('#ttLeader').datagrid('selectRow',0);

             var myRow=$('#ttLeader').datagrid('getSelected');
            $('#ttLeader').datagrid('insertRow', {
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
            $('#ttLeader').datagrid('selectRow',index);
            $('#ttLeader').datagrid('beginEdit',index);
        }


    function insertChild(){
            var row = $('#mchnChildtt').datagrid('getSelected');
            //get the total number of Row in T=tt datagrid
            var lastRow=($('#mchnChildtt').datagrid('getData').total);


            if (row){
                var index = $('#mchnChildtt').datagrid('getRowIndex', row);
            } else {
                index = 0;
            }
           
            
            $('#mchnChildtt').datagrid('selectRow',0);

             var myRow=$('#mchnChildtt').datagrid('getSelected');
            $('#mchnChildtt').datagrid('insertRow', {
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
            $('#mchnChildtt').datagrid('selectRow',index);
            $('#mchnChildtt').datagrid('beginEdit',index);
        }
function editMember(target){
      var rowIndex= getRowIndex(target);
     $('#tt,#mchnChildtt,#mchnPregtt').datagrid('beginEdit', rowIndex);
}
function cancel(target){
    $('#tt,#mchnChildtt,#mchnPregtt').datagrid('cancelEdit', getRowIndex(target));
}

//save for CG and FFA member to household
function save(target){
    $('#tt').datagrid('endEdit', getRowIndex(target));
     var rows=$('#tt').datagrid('getRows');

      $.each(rows,function(i,row){
        var url='/update_household';
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

      //  $('#dg').datagrid('reload');


    });
}

//saving Preg Add Member to Household
function savePreg(target){
    $('#mchnChildtt,#mchnPregtt').datagrid('endEdit', getRowIndex(target));
    var rows=$('#mchnPregtt').datagrid('getRows');
    $.each(rows,function(i,row){
        var url='/update_household';
        row["District"]=$('#cc1').combobox('getValue');
     row["TA"]=$('#cc2').combobox('getValue');
     row["GVH"]=$('#cc3').combobox('getValue');
     row["Village"]=$('#cc6').combobox('getValue');
     row["Ben_Reg_date"]=$('#cc4').datebox('getValue');

        $.ajax({
            url:url,
            type:'Get',
            dataType:'json',
            data:row

        });

      //  $('#dg').datagrid('reload');


    });
}
//saving Child Add Member to Household
function saveChild(target){
    $('#tt,#mchnChildtt,#mchnPregtt').datagrid('endEdit', getRowIndex(target));
    var rows=$('#mchnChildtt').datagrid('getRows');


    $.each(rows,function(i,row){
        var url='/update_household';
        row["District"]=$('#cc1').combobox('getValue');
     row["TA"]=$('#cc2').combobox('getValue');
     row["GVH"]=$('#cc3').combobox('getValue');
     row["Village"]=$('#cc6').combobox('getValue');
     row["Ben_Reg_date"]=$('#cc4').combobox('getValue');

        $.ajax({
            url:url,
            type:'Get',
            dataType:'json',
            data:row

        });

        //$('#dg').datagrid('reload');


    });
}
function addBeneficiary(){
  $('#dlgEdit').dialog('open');

            function updateActions(index){
              $('#tt').datagrid('updateRow',{
                        index: index,
                        row:{}
                    });
                }
            function getRowIndex(target){
                var tr = $(target).closest('tr.datagrid-row');
                return parseInt(tr.attr('datagrid-row-index'));
            }


    var statusid=  [{statid: '1', status: 'Deceased'},{statid: '2', status: 'Moved Out'}];
     var sexCom=[{sexid:'1',sex:'Male'},{sexid:'2',sex:'Female'}];


$('#tt').datagrid({
         rowNumbers:"false",
     fitcolumns:"true",
      singleSelect:"true",
       url:"/hhdetails?editHH="+$("#HH_Number").textbox('getText')+"&code_dist="+$('#cc1').combobox('getValue')+"&code_ta="+$('#cc2').combobox('getValue')+"&code_gvh="+$('#cc3').combobox('getValue')+"&code_village="+$('#cc6').combobox('getValue'),
       
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
                        var s = '<a href="#" onclick="save(this)">Save</a> ';
                        var c = '<a href="#" onclick="cancel(this)">Cancel</a>';
                        return s+c;
                    } else {
                        var e = '<a href="#" onclick="editMember(this)">Edit</a> ';
                        var d = '<a href="#" onclick="cancel(this)">Cancel</a>';
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
                    updateActions(index);
                },
                onCancelEdit:function(index,row){
                    row.editing = false;
                    updateActions(index);
                }
        

    });
}

function addBeneficiaryChild(){
  $('#dlgChildEdit').dialog('open');
     function updateActions(index){
              $('#mchnChildtt').datagrid('updateRow',{
                        index: index,
                        row:{}
                    });
                }
            function getRowIndex(target){
                var tr = $(target).closest('tr.datagrid-row');
                return parseInt(tr.attr('datagrid-row-index'));
            }


    var statusid=  [{statid: '1', status: 'Deceased'},{statid: '2', status: 'Moved Out'}];
     var sexCom=[{sexid:'1',sex:'Male'},{sexid:'2',sex:'Female'}];


$('#mchnChildtt').datagrid({
         rowNumbers:"false",
     fitcolumns:"true",
      singleSelect:"true",
       url:"/hhdetails?editHH="+$("#HH_Number").textbox('getText')+"&code_dist="+$('#cc1').combobox('getValue')+"&code_ta="+$('#cc2').combobox('getValue')+"&code_gvh="+$('#cc3').combobox('getValue')+"&code_village="+$('#cc6').combobox('getValue'),
       
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
                        editable:true,
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
                        var s = '<a href="#" onclick="saveChild(this)">Save</a> ';
                        var c = '<a href="#" onclick="cancel(this)">Cancel</a>';
                        return s+c;
                    } else {
                        var e = '<a href="#" onclick="editMember(this)">Edit</a> ';
                        var d = '<a href="#" onclick="cancel(this)">Cancel</a>';
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
                var editors=$('#mchnChildtt').datagrid('getEditors',index);
                var dat1=$(editors[2].target);
                var dat2=$(editors[3].target);
                var dat5=$(editors[5].target);   

                   dat1.textbox('textbox').bind('keydown',function(e){                        
                   if(e.which==9 &&  dat1.textbox('getValue') =='' ){                          
                  
                        dat1.textbox('setValue','');
                         dat2.numberbox('setValue','98');
                                       
                    }
                    else if (e.which==13){
                       var myDob=dat1.textbox('getValue'); 

                        var parts=myDob.split("/");

                        //alert();
                        var yearDiff=(new Date().getFullYear()-parts[2]);
                       // alert(myDob.getDay());
                       // var dbAge=()+();
                        //alert(dbAge);
                        dat2.numberbox('setValue',yearDiff);
                        dat5.combobox("SetFocus")
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

function addBeneficiaryPreg(){
  $('#dlgPregEdit').dialog('open');
     function updateActions(index){
              $('#mchnPregtt').datagrid('updateRow',{
                        index: index,
                        row:{}
                    });
                }
            function getRowIndex(target){
                var tr = $(target).closest('tr.datagrid-row');
                return parseInt(tr.attr('datagrid-row-index'));
            }


    var statusid=  [{statid: '1', status: 'Deceased'},{statid: '2', status: 'Moved Out'}];
     var sexCom=[{sexid:'1',sex:'Male'},{sexid:'2',sex:'Female'}];


$('#mchnPregtt').datagrid({
         rowNumbers:"false",
     fitcolumns:"true",
      singleSelect:"true",
       url:"/hhdetails?editHH="+$("#HH_Number").textbox('getText')+"&code_dist="+$('#cc1').combobox('getValue')+"&code_ta="+$('#cc2').combobox('getValue')+"&code_gvh="+$('#cc3').combobox('getValue')+"&code_village="+$('#cc6').combobox('getValue'),
       
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
                        var s = '<a href="#" onclick="savePreg(this)">Save</a> ';
                        var c = '<a href="#" onclick="cancel(this)">Cancel</a>';
                        return s+c;
                    } else {
                        var e = '<a href="#" onclick="editMember(this)">Edit</a> ';
                        var d = '<a href="#" onclick="cancel(this)">Cancel</a>';
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
                var editors=$('#mchnPregtt').datagrid('getEditors',index);
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
function saveBen(){

    
    var row=$('#tt').datagrid('getSelected');
    row["Project_Number"]=$('#cc4').combobox('getValue');
    row["FDP_Number"]=$('#cc5').combobox('getValue');
    row['Date_of_Registration']=$('#Date_of_Registration').datebox('getValue');
   // console.log(row); //for debugguing purposes
   if(row){
        $.ajax({
                type:'get',
                url:'saveBeneficiary',
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

                                $.messager.prompt('Prompt','Please Enter Next Household:',function(r){
                               if(r){
                                 $('#dlgEdit').dialog('close');
                                $("#HH_Number").textbox('setValue',r);
                               }else{
                                 $('#dlgEdit').dialog('close');
                                 $('#dg').datagrid('reload');
                               }
                             });

                             
                }
            }
    });
}
}


function assignGroupFdp(){
   var row={};
   // var row=$('#tt').datagrid('getSelected');
    row["FDP_Number"]=$('#cc5').combobox('getValue');
    row["gvh"]=$('#cc3').combobox('getValue');
    row["district"]=$('#cc1').combobox('getValue');
    row["ta"]=$('#cc2').combobox('getValue');
    row["village"]=$('#cc6').combobox('getValue');

   // console.log(row); //for debugguing purposes
   if(row){
        $.ajax({
                type:'get',
                url:'saveGroupBen',
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
                             $('#dg').datagrid('reload');
                }
            }
    });
}
}



function assignChildGroupFdp(){
   var row={};
   // var row=$('#tt').datagrid('getSelected');
    row["FDP_Number"]=$('#cc5').combobox('getValue');
    row["gvh"]=$('#cc3').combobox('getValue');
    row["district"]=$('#cc1').combobox('getValue');
    row["ta"]=$('#cc2').combobox('getValue');
    row["village"]=$('#cc6').combobox('getValue');

   // console.log(row); //for debugguing purposes
   if(row){
        $.ajax({
                type:'get',
                url:'saveChildGroupBen',
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
                            $('#dg').datagrid('reload');
                }
            }
    });
}
}


function savePregBen(){

    
    var row=$('#mchnPregtt').datagrid('getSelected');
    row["date_registration"]=$('#cc4').combobox('getValue');
    row["FDP_Number"]=$('#cc5').combobox('getValue');
     row["caregroup"]=$('#cc9').combobox('getValue');

   // console.log(row); //for debugguing purposes
   if(row){
        $.ajax({
                type:'get',
                url:'savePregnantBeneficiary',
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
                             
                             $.messager.prompt('Prompt','Please Enter Next Household:',function(r){
                               if(r){
                                 $('#dlgPregEdit').dialog('close');
                                $("#HH_Number").textbox('setValue',r);
                               }else{
                                 $('#dlgPregEdit').dialog('close');
                                 $('#dg').datagrid('reload');
                               }
                             })
                            
                }
            }
    });
}
}


function saveChildBen(){

    
    var row=$('#mchnChildtt').datagrid('getSelected');
    row["date_registration"]=$('#cc4').combobox('getValue');
    row["FDP_Number"]=$('#cc5').combobox('getValue');
     row["caregroup"]=$('#cc9').combobox('getValue');
     row["level"]=$('#cc15').combobox('getValue');
    $.messager.prompt('Prompt', 'HH Member Number for Mother or Caregiver:', function(r){
    if (r>0 && r<30){
            row["caregiver"]=r;
        //alert('Your name is:' + r);

        $.messager.prompt('Prompt','Please indicate Whether Its Mother (M) or (C) Caregiver:', function(r1){
    if (r1=='C' || r1=='c'){ 
            row["mc"]=r1;

        }else{
        row["mc"]='M';
    }
        //alert('This is :' + r1);

        if(row){
        $.ajax({
                type:'get',
                url:'saveChildBeneficiary',
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

                             $.messager.prompt('Prompt','Please Enter Next Household:',function(r){
                               if(r){
                                 $('#dlgPregEdit').dialog('close');
                                $("#HH_Number").textbox('setValue',r);
                               }else{
                                 $('#dlgPregEdit').dialog('close');
                                 $('#dg').datagrid('reload');
                               }
                           })

                }
            }
    });
}


    
    
});



    }else{
        $.messager.show({title:'Error Caregiver/Mother Number',msg:'The HH Member for Caregiver/Mother should be between 1 and 30'});
    }

});
 $('.messager-input').focus();
    

   // console.log(row); //for debugguing purposes

   
   


}

//FDP load Center
function CreateFdp(){
     var p = $('#contents').layout('panel','center');
            p.panel({href:'commodityFDP.blade.php'});
}

//FDp Dialogue box
    function newFdp(){
        $('#dlgFdp').dialog('open').dialog('setTitle','New Proposal');
        $('#fmFDP').form('clear');
         url='save_Fdp';

    }
    function editFdp(){       
        var row=$('#dg').datagrid('getSelected');
           if(row){
             $('#dlgFdp').dialog('open').dialog('setTitle','Edit Proposal');

                console.log(row);
              $('#fmFDP').form('load',row);    
         }
         url='update_fdp?id='+row.id;
    }




    function saveFdp(){
        //alert("This is FDP Save Fuction");
        $('#fmFDP').form('submit',{
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
                $('#dlgFdp').dialog('close');
                $('#dg').datagrid('getSelected');
                 $.messager.show({
                    title: 'Success',
                    msg: result.successMsg
                });

        }
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
