$(document).ready(function(){

})


function justCall(){
    alert('just call');
}

  function addAcpcMember(){

         $('#dlgGroupEdit').dialog('open');

		 function updateActions(index){
              $('#acpctt').datagrid('updateRow',{
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


$('#acpctt').datagrid({
         rowNumbers:"false",
     fitcolumns:"true",
      singleSelect:"true",
       url:"/hhdetails?editHH="+$("#HH_Number").textbox('getText')+"&code_dist="+$('#cc1').combobox('getValue')+"&code_ta="+$('#cc2').combobox('getValue')+"&code_gvh="+$('#cc3').combobox('getValue')+"&code_village="+$('#cc7').combobox('getValue'),
       
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
                        var s = '<a href="#" onclick="saveGroup(this)">Save</a> ';
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
                var editors=$('#acpctt').datagrid('getEditors',index);
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

//vdc Member Details
function addVdcMember(){
          
         $('#dlgVdcEdit').dialog('open');

         function updateActions(index){
              $('#vdctt').datagrid('updateRow',{
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


$('#vdctt').datagrid({
         rowNumbers:"false",
     fitcolumns:"true",
      singleSelect:"true",
       url:"/hhdetails?editHH="+$("#HH_Number").textbox('getText')+"&code_dist="+$('#cc1').combobox('getValue')+"&code_ta="+$('#cc2').combobox('getValue')+"&code_gvh="+$('#cc3').combobox('getValue')+"&code_village="+$('#cc7').combobox('getValue'),
       
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
                        var s = '<a href="#" onclick="saveGroup(this)">Save</a> ';
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
                var editors=$('#vdctt').datagrid('getEditors',index);
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


//YouthGroup Member Details
function addYcMember(){
          
         $('#dlgYcEdit').dialog('open');

         function updateActions(index){
              $('#yctt').datagrid('updateRow',{
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


$('#yctt').datagrid({
         rowNumbers:"false",
     fitcolumns:"true",
      singleSelect:"true",
       url:"/hhdetails?editHH="+$("#HH_Number").textbox('getText')+"&code_dist="+$('#cc1').combobox('getValue')+"&code_ta="+$('#cc2').combobox('getValue')+"&code_gvh="+$('#cc3').combobox('getValue')+"&code_village="+$('#cc7').combobox('getValue'),
       
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
                        var s = '<a href="#" onclick="saveGroupYc(this)">Save</a> ';
                        var c = '<a href="#" onclick="cancelYc(this)">Cancel</a>';
                        return s+c;
                    } else {
                        var e = '<a href="#" onclick="editYc(this)">Edit</a> ';
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
                var editors=$('#yctt').datagrid('getEditors',index);
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
//add ACP Member 

function addAdcMember(){
          
         $('#dlgAdcEdit').dialog('open');

         function updateActions(index){
              $('#adctt').datagrid('updateRow',{
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


$('#adctt').datagrid({
         rowNumbers:"false",
     fitcolumns:"true",
      singleSelect:"true",
       url:"/hhdetails?editHH="+$("#HH_Number").textbox('getText')+"&code_dist="+$('#cc1').combobox('getValue')+"&code_ta="+$('#cc2').combobox('getValue')+"&code_gvh="+$('#cc3').combobox('getValue')+"&code_village="+$('#cc7').combobox('getValue'),
       
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
                        var s = '<a href="#" onclick="saveGroup(this)">Save</a> ';
                        var c = '<a href="#" onclick="cancelAdc(this)">Cancel</a>';
                        return s+c;
                    } else {
                        var e = '<a href="#" onclick="editAdc(this)">Edit</a> ';
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
                var editors=$('#yctt').datagrid('getEditors',index);
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
//add VCPC Member
function addVcpcMember(){
            
         $('#dlgVcpcEdit').dialog('open');

         function updateActions(index){
              $('#vcpctt').datagrid('updateRow',{
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


$('#vcpctt').datagrid({
         rowNumbers:"false",
     fitcolumns:"true",
      singleSelect:"true",
       url:"/hhdetails?editHH="+$("#HH_Number").textbox('getText')+"&code_dist="+$('#cc1').combobox('getValue')+"&code_ta="+$('#cc2').combobox('getValue')+"&code_gvh="+$('#cc3').combobox('getValue')+"&code_village="+$('#cc7').combobox('getValue'),
       
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
                        var s = '<a href="#" onclick="saveGroup(this)">Save</a> ';
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
                var editors=$('#vcpctt').datagrid('getEditors',index);
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

function addVnrmcMember(){
            
         $('#dlgVnrmcEdit').dialog('open');

         function updateActions(index){
              $('#vcpctt').datagrid('updateRow',{
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


$('#vnrmctt').datagrid({
         rowNumbers:"false",
     fitcolumns:"true",
      singleSelect:"true",
       url:"/hhdetails?editHH="+$("#HH_Number").textbox('getText')+"&code_dist="+$('#cc1').combobox('getValue')+"&code_ta="+$('#cc2').combobox('getValue')+"&code_gvh="+$('#cc3').combobox('getValue')+"&code_village="+$('#cc7').combobox('getValue'),
       
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
                        var s = '<a href="#" onclick="saveGroup(this)">Save</a> ';
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
                var editors=$('#vcpctt').datagrid('getEditors',index);
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


function insert(){
            var row = $('#acpctt,#vdctt,#vcpctt,#vnrmctt,#yctt,#adctt').datagrid('getSelected');
            //get the total number of Row in T=tt datagrid
            var lastRow=($('#acpctt,#vdctt,#vcpctt,#vnrmctt,#yctt,#adctt').datagrid('getData').total);


            if (row){
                var index = $('#acpctt,#vdctt,#vcpctt,#vnrmctt,#yctt,#adctt').datagrid('getRowIndex', row);
            } else {
                index = 0;
            }
           
            
            $('#acpctt,#vdctt,#vcpctt,#vnrmctt,#yctt,#adctt').datagrid('selectRow',0);

             var myRow=$('#acpctt,#vdctt,#vcpctt,#vnrmctt,#yctt,#adctt').datagrid('getSelected');
            $('#acpctt,#vdctt,#vcpctt,#vnrmctt,#yctt,#adctt').datagrid('insertRow', {
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
            $('#acpctt,#vdctt,#vcpctt,#yctt,#adctt').datagrid('selectRow',index);
            $('#acpctt,#vdctt,#vcpctt,#yctt,#adctt').datagrid('beginEdit',index);
        }
function editMember(target){
      var rowIndex= getRowIndex(target);
     $('#acpctt,#vdctt,#vcpctt,#vnrmctt,#yctt,#adctt').datagrid('beginEdit', rowIndex);
}
function cancel(target){
    $('#acpctt,#vdctt,#vcpctt,#vnrmctt,#yctt,#adctt').datagrid('cancelEdit', getRowIndex(target));
}

function saveGroup(target){
    $('#acpctt,#vdctt,#vcpctt,#vnrmctt,#yctt,#adctt').datagrid('endEdit', getRowIndex(target));
    var rows=$('#acpctt,#vdctt,#vcpctt,#vnrmctt,#yctt,#adctt').datagrid('getRows');


    $.each(rows,function(i,row){
        var url='/update_household';
        row["District"]=$('#cc1').combobox('getValue');
     row["TA"]=$('#cc2').combobox('getValue');
     row["GVH"]=$('#cc3').combobox('getValue');

     //be care with this value
     row["Village"]=$('#cc7').combobox('getValue');
     row["Ben_Reg_date"]=$('#cc4').datebox('getValue');

        $.ajax({
            url:url,
            type:'Get',
            dataType:'json',
            data:row

        });

        $('#dg').datagrid('reload');


    });
}

function saveGroupYc(target){
    $('#yctt').datagrid('endEdit', getRowIndex(target));
    var rows=$('#yctt').datagrid('getRows');


    $.each(rows,function(i,row){
        var url='/update_household';
        row["District"]=$('#cc1').combobox('getValue');
     row["TA"]=$('#cc2').combobox('getValue');
     row["GVH"]=$('#cc3').combobox('getValue');

     //be care with this value
     row["Village"]=$('#cc7').combobox('getValue');
     row["Ben_Reg_date"]=$('#cc4').datebox('getValue');

        $.ajax({
            url:url,
            type:'Get',
            dataType:'json',
            data:row

        });



    });
}

//save ACPC Beneficiary
function saveAcpcBen(){

    
    var row=$('#acpctt').datagrid('getSelected');
    row["acpc_number"]=$('#cc6').combobox('getValue');
    row["village"]=$('#cc7').combobox('getValue');
    row["date_join"]=$('#cc4').combobox('getValue');
    row["date_leaving"]=$('#cc8').combobox('getValue');
   // console.log(row); //for debugguing purposes

   $.messager.prompt('prompt','Please Add Member Position',function(r){
    if(r){
        if(r=''){
            r=5
         }
        row["Position"]=r;
        if(row){
        $.ajax({
                type:'get',
                url:'saveAcpBeneficiary',
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
                             $('#dlgGroupEdit').dialog('close');
                             $('#dg').datagrid('reload');
                }
            }
        });
    }

    }
   });
   
}

//save VDC Member
function saveVdcBen(){

    
    var row=$('#vdctt').datagrid('getSelected');
    row["vdc_number"]=$('#cc6').combobox('getValue');
    row["village"]=$('#cc7').combobox('getValue');
    row["date_join"]=$('#cc4').combobox('getValue');
    row["date_leaving"]=$('#cc8').combobox('getValue');
   // console.log(row); //for debugguing purposes
   $.messager.prompt('prompt','Please Add Member Position 1 to 5',function(r){
    
        if(r==''){
            row['Position']=5;
        }else{
            row['Position']=r;    
        }
        
        if(row){
        $.ajax({
                type:'get',
                url:'saveVdcBeneficiary',
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
                             $('#dlgVdcEdit').dialog('close');
                             $('#dg').datagrid('reload');
                }
            }
    });
    }

    
   });
   
}

//save VCPC Member
function saveVcpcBen(){

    
    var row=$('#vcpctt').datagrid('getSelected');
    row["vcpc_number"]=$('#cc6').combobox('getValue');
    row["village"]=$('#cc7').combobox('getValue');
    row["date_join"]=$('#cc4').combobox('getValue');
    row["date_leaving"]=$('#cc8').combobox('getValue');
   // console.log(row); //for debugguing purposes
   $.messager.prompt('prompt','Please Indicate Position 1 to 5',function(r){
    if(r){

        row["Position"]=r;
         if(row){
        $.ajax({
                type:'get',
                url:'saveVcpcBeneficiary',
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
                             $('#dlgVcpcEdit').dialog('close');
                             $('#dg').datagrid('reload');
                }
            }
    });
}
    }

   });
  
}




//Save VNRMC Ben
function saveYcBen(){ 
    var row=$('#yctt').datagrid('getSelected');
    row["youthclub_number"]=$('#cc6').combobox('getValue');
    row["village"]=$('#cc7').combobox('getValue');

    row["date_join"]=$('#cc4').combobox('getValue');
    row["date_leaving"]=$('#cc8').combobox('getValue');
   // console.log(row); //for debugguing purposes
   $.messager.prompt('prompt','Please Indicate Position in the Committee',function(r){
    if(r==''){
        row["Position"]=7;
    }else{
        row["Position"]=r;
    }
        
         if(row){
        $.ajax({
                type:'get',
                url:'saveYcBeneficiary',
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
                            $('#dgYc').datagrid('reload');
        $('#dlgYcEdit').dialog('close');
                }
            }
    });
}
   

   });
  

}

//Save ADC Ben
function saveAdcBen(){ 
    var row=$('#adctt').datagrid('getSelected');
    row["adc_number"]=$('#cc6').combobox('getValue');
    row["village"]=$('#cc7').combobox('getValue');
    row["date_join"]=$('#cc4').combobox('getValue');
    row["date_leaving"]=$('#cc8').combobox('getValue');
   // console.log(row); //for debugguing purposes
   $.messager.prompt('prompt','Please Indicate Position in the Committee',function(r){
    if(r){

        row["Position"]=r;
         if(row){
        $.ajax({
                type:'get',
                url:'saveAdcBeneficiary',
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
                             $('#dlgVnrmcEdit').dialog('close');
                             //$('#dg').datagrid('reload',{});
                }
            }
    });
}
    }

   });
  
}

//save Youth Club Ben
function saveVnrmcBen(){ 
    var row=$('#vnrmctt').datagrid('getSelected');
    row["vnrmc_number"]=$('#cc6').combobox('getValue');
    row["village"]=$('#cc7').combobox('getValue');
    row["date_join"]=$('#cc4').combobox('getValue');
    row["date_leaving"]=$('#cc8').combobox('getValue');
   // console.log(row); //for debugguing purposes
   $.messager.prompt('prompt','Please Indicate Position in the Committee',function(r){
    if(r){

        row["Position"]=r;
         if(row){
        $.ajax({
                type:'get',
                url:'saveVrnmcBeneficiary',
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
                             $('#dlgVnrmcEdit').dialog('close');
                             //$('#dg').datagrid('reload',{});
                }
            }
    });
}
    }

   });
  
}

//Create New Group 
function newAcpcGroup(){
      $('#dlgAcpc').dialog('open').dialog('setTitle','Create New ACPC');
     $('#fm').form('clear');
     $('#acpc_name').textbox('clear').textbox('textbox').focus();
     url='save_acpc';
}
function newVdcGroup(){
      $('#dlgVdc').dialog('open').dialog('setTitle','Create New VDC');
     $('#fm').form('clear');
     $('#vdc_name').textbox('clear').textbox('textbox').focus();
     url='save_vdc';
}
function newVnrmcGroup(){
      $('#dlgVnrmc').dialog('open').dialog('setTitle','Create New VNRMC');
     $('#fm').form('clear');
     $('#vnrmc_name').textbox('clear').textbox('textbox').focus();
     url='save_vnrmc';
}
function newVcpcGroup(){
      $('#dlgVcpc').dialog('open').dialog('setTitle','Create New VCPC');
     $('#fm').form('clear');
     $('#vcpc_name').textbox('clear').textbox('textbox').focus();
     url='save_vcpc';
}
function newYcGroup(){
      $('#dlgYc').dialog('open').dialog('setTitle','Create New Youth Group');
     $('#fmYc').form('clear');
     $('#youthclub_name').textbox('clear').textbox('textbox').focus();
     url='save_youthclub';
}

function newAdcGroup(){
      $('#dlgAdc').dialog('open').dialog('setTitle','Create New ADC');
     $('#fmAdc').form('clear');
     $('#adc_name').textbox('clear').textbox('textbox').focus();
     url='save_adc';
}

function saveAcpc(){
    $('#fm,#fmYc,#fmAdc').form('submit',{
         url: url,
        onSubmit: function(param){
            param.district=$('#cc1').combobox('getValue');
            param.ta=$('#cc2').combobox('getValue');
            param.gvh=$('#cc3').combobox('getValue');
            
            param.rfo_number=$('#cc5').combobox('getValue');
            

            return $(this).form('validate');
        },
        success:function(result){
             var result = eval('('+result+')');
            if (result.errorMsg){
                $.messager.show({
                    title: 'Error',
                    msg: result.errorMsg
                });
                $('#dg,#dlgYc,#dlgAdc,#dlgAcpc,#dgVnrmc').datagrid('reload');    // reload the user data
                $('#fm,#fmYc,#fmAdc,#dlgAcpc').form('clear');
                if  (url=='save_youthclub'){
                    var url3='youthclubSel?id='+$('#cc3').combobox('getValue');
                    $('#fmYc').form('clear');
                }
                else if (url=='save_vdc'){
                    var url3='vdcSel?id='+$('#cc3').combobox('getValue');
                }
                else if (url=='save_vnrmc'){
                    var url3='vdcSel?id='+$('#cc3').combobox('getValue');   
                }
                
                 
            
            $('#cc6').combobox('reload', url3);
            } else{
              $('#dlgVnrmc').dialog('close');        // close the dialog
                
           
                
            }
        }
    });

}
