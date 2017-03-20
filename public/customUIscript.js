

$(document).ready(function(){
   function updateActions(index){
    $('#dgVnrmc,#dgYc,#dgAdc,#dgSub,#dgPmu,#dgCommunity,#tt').datagrid('updateRow',{
        index: index,
        row:{}
    });
}
function getRowIndex(target){
    var tr = $(target).closest('tr.datagrid-row');
    return parseInt(tr.attr('datagrid-row-index'));
}
    $('#dgVnrmc').datagrid({
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

   
  $('#dgAdc').datagrid({
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
   $('#dgYc').datagrid({
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
$('#dgCCFLS').datagrid({
    view:detailview,
    detailFormatter:function(index,row){
      return '<div style="padding:2px"><table class="ddv"></table></div>';
    },
    onExpandRow:function(index,row){
      var ddv = $(this).datagrid('getRowDetail',index).find('table.ddv');
      ddv.datagrid({
        url:'ccflsChilddetail?hhid='+row.HH_Number+'&HH_Member_Number='+row.HH_Member_Number+'&Village='+row.Village+'&ccfls='+row.ccfls_session,
            fitColumns:true,
            singleSelect:true,
            rownumbers:true,
            loadMsg:'',
            height:'auto',
            columns:[[
                {field:'f1date',title:'1M Date Visit',width:100},
                {field:'f1MUAC',title:'1M MUAC(cm)',width:100},
                {field:'f1weight',title:'1M Weight(kg)',width:100},
                {field:'fmDateVisit',title:'2M Date Visit',width:100},
                {field:'fmMuac',title:'2M MUAC(cm)',width:100},
                {field:'unitprice',title:'2M Weight(kg)',width:100},
                {field:'fmDateVisit',title:'3M Date Visit',width:100},
                {field:'fmMuac',title:'3M MUAC(cm)',width:100},
                {field:'unitprice',title:'3M Weight(kg)',width:100},
                {field:'unitprice',title:'3M Height(cm)',width:100},
                {field:'fmDateVisit',title:'6M Date Visit',width:100},
                {field:'fmMuac',title:'6M MUAC(cm)',width:100},
                {field:'unitprice',title:'6M Weight(kg)',width:100},
                {field:'unitprice',title:'6M Height(cm)',width:100}]],
      onResize:function(){
          $('#dg').datagrid('fixDetailRowHeight',index);
                },
      onLoadSuccess:function(){
                setTimeout(function(){
                    $('#dg').datagrid('fixDetailRowHeight',index);
                },0);
            }

      });
      $('#dg').datagrid('fixDetailRowHeight',index);
    }
   });
  $('#dgSilc').datagrid({
        onBeforeEdit:function(index,row){
            row.editing = true;
            $(this).datagrid('refreshRow', index);
        },
        onAfterEdit:function(index,row){
                    row.editing = false;
                    $(this).datagrid('refreshRow', index);
                },
                onCancelEdit:function(index,row){
                    row.editing = false;
                    $(this).datagrid('refreshRow', index);
                }

              });

   $('#dgMarketing').datagrid({
        onBeforeEdit:function(index,row){
            row.editing = true;
            $(this).datagrid('refreshRow', index);
        },
        onAfterEdit:function(index,row){
                    row.editing = false;
                    $(this).datagrid('refreshRow', index);
                },
                onCancelEdit:function(index,row){
                    row.editing = false;
                    $(this).datagrid('refreshRow', index);
                }

              });
  





	 $('#dgSub').datagrid({
         rowNumbers:"true",
     fitcolumns:"true",
      singleSelect:"true",
       url:"/sub_dist_train",
       
        idField:"HH_Number",
        title:"TA/Sub District Level Training Registration",
         iconCls:'icon-edit',

         columns:[[
             {field:'participant_id',title:'Participant_id'},
            {field:'name_of_participant',title:'Name of Participant'},
            {field:'age',title:'Age'},
            {field:'Sex',title:'Sex'},
            {field:'Institution',title:'Institution'},
            {field:'designation',title:'Designation'},
            {field:"contact",title:"Contact Number/email",editor:{
              type:'textbox',
              required:true
            }
          },
                        
            
            {field:'Attendance',title:'Attendance', editor:{type:'checkbox',
                       options:{
                        on: '1',
                        off: '2'
                    }
                        
                    }
                  },       
            {field:'action',title:'Action',align:'center', 
                formatter:function(value,row,index){
                    if (row.editing){
                        var s = '<a href="#" onclick="saveTrain(this)">Save</a> ';
                        var c = '<a href="#" onclick="cancel(this)">Cancel</a>';
                        return s+c;
                    } else {
                        var e = '<a href="#" onclick="editTrainMember(this)">Edit</a> ';
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
                var editors=$('#dgSub').datagrid('getEditors',index);
                //var dat1=$(editors[2].target);
                //var dat2=$(editors[3].target);

                   // dat1.datebox({
                       // onSelect:function(date){    
                        //calculate the age for the individual
                       // var dbAge=(new Date).getFullYear()-date.getFullYear();
                        //alert(dbAge);
                      //  dat2.numberbox('setValue',dbAge);
                      //  }
                    //});
                

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
   

   //datagrid for PMU Training
   $('#dgPmu').datagrid({
         rowNumbers:"true",
     fitcolumns:"true",
      singleSelect:"true",
       url:"/pmupvo_training",
       
        idField:"HH_Number",
        title:"PMU/PVO Level Training Registration",
         iconCls:'icon-edit',

         columns:[[
            {field:'participant_id',title:'Participant ID'},
            {field:'name_of_participant',title:'Name of Participant'},
            {field:'age',title:'Age'},
            {field:'Sex',title:'Sex'},
            {field:'Institution',title:'Institution'},
            {field:'designation',title:'Designation'},
            {field:"contact",title:"Contact Number/email",editor:{
              type:'textbox',
              required:true
            }
          },
                        
            
            {field:'Attendance',title:'Attendance', editor:{type:'checkbox',
                       options:{
                        on: '1',
                        off: '2'
                    }
                        
                    }
                  },       
            {field:'action',title:'Action',align:'center', 
                formatter:function(value,row,index){
                    if (row.editing){
                        var s = '<a href="#" onclick="savePmu(this)">Save</a> ';
                        var c = '<a href="#" onclick="cancelPmu(this)">Cancel</a>';
                        return s+c;
                    } else {
                        var e = '<a href="#" onclick="editPmuMember(this)">Edit</a> ';
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
                var editors=$('#dgPmu').datagrid('getEditors',index);
                //var dat1=$(editors[2].target);
                //var dat2=$(editors[3].target);

                  //  dat1.datebox({
                        //onSelect:function(date){    
                        //calculate the age for the individual
                       // var dbAge=(new Date).getFullYear()-date.getFullYear();
                        //alert(dbAge);
                      //  dat2.numberbox('setValue',dbAge);
                       // }
                    //});
                

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

//Datagrid for the Community
   $('#dgCommunity').datagrid({
         rowNumbers:"true",
     fitcolumns:"true",
      singleSelect:"true",
       url:"/community_training",
       
        idField:"HH_Number",
        title:"Community Level Training Registration ",
         iconCls:'icon-edit',

         columns:[[
            {field:'village',title:'Village'},
            {field:'hh_number',title:'HH ID'},
            {field:'name_of_participant',title:'Name of Participant'},
            {field:'age',title:'Age'},
            {field:'Sex',title:'Sex'},                 
            {field:'Attendance',title:'Attendance', editor:{type:'checkbox',
                       options:{
                        on: '1',
                        off: '2'
                    }
                        
                    }
                  },       
            {field:'action',title:'Action',align:'center', 
                formatter:function(value,row,index){
                    if (row.editing){
                        var s = '<a href="#" onclick="saveCom(this)">Save</a> ';
                        var c = '<a href="#" onclick="cancelCom(this)">Cancel</a>';
                        return s+c;
                    } else {
                        var e = '<a href="#" onclick="editComMember(this)">Edit</a> ';
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
                var editors=$('#dgCommunity').datagrid('getEditors',index);
                //var dat1=$(editors[2].target);
                //var dat2=$(editors[3].target);

                  //  dat1.datebox({
                        //onSelect:function(date){    
                        //calculate the age for the individual
                       // var dbAge=(new Date).getFullYear()-date.getFullYear();
                        //alert(dbAge);
                      //  dat2.numberbox('setValue',dbAge);
                       // }
                    //});
                

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



	$('#vilSel').on('change',function(){
	//	alert(this.value);

	 var statusid=  [{statid: '0', status: 'Available'},{statid: '1', status: 'Deceased'},{statid: '2', status: 'Moved Out'}];
	 var sexCom=[{sexid:'1',sex:'Male'},{sexid:'2',sex:'Female'}];

$('#tt').datagrid({
	 rowNumbers:"false",
	 fitcolumns:"true",
	  singleSelect:"true",
	   url:"/hhdetails",
	   
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




	$('#dg').datagrid('load',{
		code_dist: $('#district').val(),
		code_ta: $('#taSel').val(),
		code_gvh:$('#gvhSel').val(),
		code_village:$('#vilSel').val()

		});
	});

	$('#dg').datagrid({
		onDblClickRow:function(index){
			editItem();
		}
		
    //onBeforeLoad:function(param){
       // param.number="002";        // add the parameter code and addr
        //param.addr = 'my address';
   // }

});
});