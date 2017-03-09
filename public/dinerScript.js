$(function(){
   $('#dgDiner,#dgDemo').datagrid();

   

})
   
  
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

function optRow(value,row)
            {
                 if (row.editing){
                        var s = '<a href="#" onclick="saveDiner(this)">Save</a> ';
                        var c = '<a href="#" onclick="cancelDiner(this)">Cancel</a>';
                        return s+c;
                    } else {
                        var e = '<a href="#" onclick="editDiner(this)">Edit</a> ';
                        var d = '<a href="#" onclick="deleterow(this)">Delete</a>';
                        return e+d;
                    }
            }


function optRowSilc(value,row)
            {
                 if (row.editing){
                        var s = '<a href="#" onclick="saveSilc(this)">Save</a> ';
                        var c = '<a href="#" onclick="cancelSilc(this)">Cancel</a>';
                        return s+c;
                    } else {
                        var e = '<a href="#" onclick="editSilc(this)">Edit</a> ';
                        var d = '<a href="#" onclick="deleterow(this)">Delete</a>';
                        return e+d;
                    }
            }

function optRowMarketing(value,row)
            {
                 if (row.editing){
                        var s = '<a href="#" onclick="saveMarketing(this)">Save</a> ';
                        var c = '<a href="#" onclick="cancelMarketing(this)">Cancel</a>';
                        return s+c;
                    } else {
                        var e = '<a href="#" onclick="editMarketing(this)">Edit</a> ';
                        var d = '<a href="#" onclick="deleterow(this)">Delete</a>';
                        return e+d;
                    }
            }

function editSilc(target){
      var rowIndex= getRowIndex(target);
     $('#dgSilc').datagrid('beginEdit', rowIndex);
}
function cancelSilc(target){
    $('#dgSilc').datagrid('cancelEdit', getRowIndex(target));

}

//editing Marketing
function editMarketing(target){
      var rowIndex= getRowIndex(target);
     $('#dgMarketing').datagrid('beginEdit', rowIndex);
}
function cancelMarketing(target){
    $('#dgMarketing').datagrid('cancelEdit', getRowIndex(target));

}

//Save Marketing After Editing

function saveMarketing(target){
    $('#dgMarketing').datagrid('endEdit', getRowIndex(target));
    var rows=$('#dgMarketing').datagrid('getRows');


    $.each(rows,function(i,row){
        var url='/update_marketing';
        row["District"]=$('#cc1').combobox('getValue');
     row["TA"]=$('#cc2').combobox('getValue');
     row["GVH"]=$('#cc3').combobox('getValue');
     

        $.ajax({
            url:url,
            type:'Get',
            dataType:'json',
            data:row

        });

        $('#dgMarketing').datagrid('reload');


    });
}

function saveSilc(target){
    $('#dgSilc').datagrid('endEdit', getRowIndex(target));
    var rows=$('#dgSilc').datagrid('getRows');


    $.each(rows,function(i,row){
        var url='/update_silc';
        row["District"]=$('#cc1').combobox('getValue');
     row["TA"]=$('#cc2').combobox('getValue');
     row["GVH"]=$('#cc3').combobox('getValue');
     

        $.ajax({
            url:url,
            type:'Get',
            dataType:'json',
            data:row

        });

        $('#dgSilc').datagrid('reload');


    });
}




                            
//$('#dgSilc').datagrid();

var statusid=  [{statid: '1', status: 'Deceased'},{statid: '2', status: 'Moved Out'}];
var sexCom=[{sexid:'1',sex:'Male'},{sexid:'2',sex:'Female'}];

function addCgL()
   {

    function upateAct(index){
  $('#ttLeader').datagrid('updateRow',{
        index: index,
        row:{}
      });
    }

    $('#dlgEditLeader').dialog('open');
    $('#ttLeader').datagrid({
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
                        var s = '<a href="#" onclick="saverows(this)">Save</a> ';
                        var c = '<a href="#" onclick="cancelrows(this)">Cancel</a>';
                        return s+c;
                    } else {
                        var e = '<a href="#" onclick="editrows(this)">Edit</a> ';
                        var d = '<a href="#" onclick="deleterow(this)">Delete</a>';
                        return e+d;
                    }
                }
            }
      
      ]],
      onBeforeEdit:function(index,row){
          row.editing = true;
          upateAct(index);
        },
      onBeginEdit:function(index,row){
        var editors=$('#ttLeader').datagrid('getEditors',index);
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
         upateAct(index);
        },
        onCancelEdit:function(index,row){
          row.editing = false;
          upateAct(index);
        }
      


    

});



}


    


 
 
    












function saveDinerBen(){
		url='saveDinerBen';
		//alert('Save Diner Ben'); //for debuging
		var row=$('#tt').datagrid('getSelected');
		row["market"]=$('#cc4').combobox('getValue');
        row["epa"]=$('#cc5').combobox('getValue');
        row["market"]=$('#cc4').combobox('getValue');
        row["date_registration"]=$('#cc7').datebox('getValue');

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



function saveCGLeader(){
        url='saveCGlead';
        //alert('Save Diner Ben'); //for debuging
        var row=$('#ttLeader').datagrid('getSelected');
        row["cg_promo_id"]=$('#cc8').combobox('getValue');
        row["District"]=$('#cc1').combobox('getValue');
        row["TA"]=$('#cc2').combobox('getValue');
        row["GVH"]=$('#cc2').combobox('getValue');
        row["Village"]=$('#cc6').combobox('getValue');
        row["date_registration"]=$('#cc7').datebox('getValue');

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
                             $('#dlgEditLeader').dialog('close');
                             $('#dgSilc').datagrid('reload');

                             var url2='code_cgl?id='+$('#cc8').combobox('getValue');
                                $('#cc5').combobox('reload', url2);

                }
            }
    });
}
    }
//SILC Group Addition
    function saveSilcBen() {
        // body...
        url="saveSilcBen";
        var row=$('#tt').datagrid('getSelected');
        row["Silc_group"]=$('#cc4').combobox('getValue');
        row["psp_fa"]=$('#cc5').combobox('getValue');
        row["SS_Supervisor"]=$('#cc8').combobox('getValue');
        row["date_joining"]=$('#cc7').datebox('getValue');
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
                             $('#dgSilc').datagrid('reload');
                }
            }
    });
}


    }



function saveCGBen() {
        // body...
        url="saveCGBen";
        var row=$('#tt').datagrid('getSelected');
        row["cg_group"]=$('#cc4').combobox('getValue');
        row["cg_promo_id"]=$('#cc8').combobox('getValue');
        row["date_joining"]=$('#cc7').datebox('getValue');
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
                             $('#dgSilc').datagrid('reload');
                }
            }
    });
}


    }
    //Save Marketing Club Beneficiary Registration
function saveMarketBen() {
        // body...
        url="saveMarketBen";
        var row=$('#tt').datagrid('getSelected');
        row["market_club"]=$('#cc4').combobox('getValue');
        row["psp_fa"]=$('#cc5').combobox('getValue');
        row["SS_Supervisor"]=$('#cc8').combobox('getValue');
        row["date_joining"]=$('#cc7').datebox('getValue');
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
                             $('#dgMarketing').datagrid('reload');
                }
            }
    });
}


    }






    //diner Fairs Market
	function addMarket(){

		 $('#dlgMarket').dialog('open');

		$('#Rec_id_TA').textbox('setValue',$('#cc2').combobox('getValue'));
		$('#Rec_id_TA').textbox('hide');
	    //$('#Village_ID').textbox('setValue');
 		url='codesMarket';

	}


    function addSilcGroup(){
        $('#dlgSilcGroup').dialog('open');
        $('#Rec_id_district').textbox('setValue',$('#cc1').combobox('getValue'));
        $('#Rec_id_TA').textbox('setValue',$('#cc2').combobox('getValue'));
        $('#Rec_id_gvh').textbox('setValue',$('#cc3').combobox('getValue'));
        $('#psp_id').textbox('setValue',$('#cc5').combobox('getValue'));

      //  $('#Rec_id_TA').textbox('hide');
        //$('#Village_ID').textbox('setValue');
        url='codesSilc';

    }

    //Add Market Club
    function addMarketClub(){
        $('#dlgSilcGroup').dialog('open');
        $('#Rec_id_district').textbox('setValue',$('#cc1').combobox('getValue'));
        $('#Rec_id_TA').textbox('setValue',$('#cc2').combobox('getValue'));
        $('#Rec_id_gvh').textbox('setValue',$('#cc3').combobox('getValue'));
        $('#psp_id').textbox('setValue',$('#cc5').combobox('getValue'));

      //  $('#Rec_id_TA').textbox('hide');
        //$('#Village_ID').textbox('setValue');
        url='codesMarketClub';

    }


    function addPSP(){
        $('#dlgPSPFA').dialog('open');

        //alert('This is giving a headache'+$('#cc1').combobox('getValue'));
        $('#Rec_district').textbox('setValue',$('#cc1').combobox('getValue'));
        $('#Rec_TA').textbox('setValue',$('#cc2').combobox('getValue'));
        $('#Rec_gvh').textbox('setValue',$('#cc3').combobox('getValue'));
        $('#ss_supervisor').textbox('setValue',$('#cc8').combobox('getValue'));
        //$('#Rec_id_district').textbox('hide');
       // $('#Village_ID').textbox('setValue');
        url='codesPSP';

    }
    //Add Market Assistant
    function addMA(){
        $('#dlgPSPMA').dialog('open');

        //alert('This is giving a headache'+$('#cc1').combobox('getValue'));
        $('#Rec_district').textbox('setValue',$('#cc1').combobox('getValue'));
        $('#Rec_TA').textbox('setValue',$('#cc2').combobox('getValue'));
        $('#Rec_gvh').textbox('setValue',$('#cc3').combobox('getValue'));
        $('#ss_supervisor').textbox('setValue',$('#cc8').combobox('getValue'));
        //$('#Rec_id_district').textbox('hide');
       // $('#Village_ID').textbox('setValue');
        url='codesMA';

    }

    function assignMaCl(){
        
        //alert('This is giving a headache'+$('#cc1').combobox('getValue'));
        var dist=$('#cc1').combobox('getValue');
        var ta=$('#cc2').combobox('getValue');
        var club_num=$('#cc4').combobox('getValue');
        var cl_num=$('#cc9').combobox('getValue');

        url='updateMaCl';

         $.ajax({
        url:url,
        type:'POST',
        dataType:'json',
        data:{district:dist,club:club_num,cl_number:cl_num},


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

   function addMarketCluster(){
       $('#dlgMaCluster').dialog('open');

       //alert('This is giving a headache'+$('#cc1').combobox('getValue'));
        $('#district').textbox('setValue',$('#cc1').combobox('getValue'));
        $('#TA').textbox('setValue',$('#cc2').combobox('getValue'));
        $('#gvh').textbox('setValue',$('#cc3').combobox('getValue'));
        $('#cl_supervisor').textbox('setValue',$('#cc8').combobox('getValue'));
        //$('#Rec_id_district').textbox('hide');
       // $('#Village_ID').textbox('setValue');
        url='codesMaCl';
    }
	function addEpa(){
		 $('#dlgEpa').dialog('open');
		$('#Rec_id_district').textbox('setValue',$('#cc1').combobox('getValue'));
		$('#Rec_id_district').textbox('hide');
	   // $('#Village_ID').textbox('setValue');
 		url='codesEpa';

	}

	function saveDinLocation(){
		 $('#fmMarket,#fmEpa').form('submit',{
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
                 	//reload combo with new values
                 	var url2='code_epa?id='+$('#Rec_id_district').textbox().val();
                 	$('#cc5').combobox('reload', url2);

                 	var url3='code_market?id='+$('#Rec_id_TA').textbox().val();
                 	 $('#cc4').combobox('reload', url3);



                     $('#dgDiner').datagrid('reload'); 
                     
                     ;
                   $('#fmMarket,#fmEpa').form('clear');
                    $('#dlgMarket,#dlgEpa').dialog('close');
                    
                         
           }
        }

    });

	}


    function saveSILC(){
         $('#fmPSPFA,#fmSilcGroup').form('submit',{
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
                    //reload combo with new values
                    var url2='silc_group?id='+$('#cc3').textbox().val();
                    $('#cc4').combobox('reload', url2);

                    var url3='silc_psp?id='+$('#cc2').combobox('getValue');
                     $('#cc5').combobox('reload', url3);



                     $('#dgDiner').datagrid('reload'); 
                     
                     ;
                   $('#fmPSPFA,#fmSilcGroup').form('clear');
                    $('#dlgPSPFA,#dlgSilcGroup').dialog('close');
                    
                         
           }
        }

    });

    }


    //Add Marketing Participant

function saveMarket(){
         $('#fmPSPMA,#fmMarketClub,#fmMACl').form('submit',{
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
                    //reload combo with new values
                     var url1='market_group?id='+$('#cc3').combobox('getValue');
                    var url3='market_psp?id='+$('#cc3').combobox('getValue');
                 
                    $('#cc4').combobox('reload', url1);

                    
                     $('#cc5').combobox('reload', url3);



                     $('#dgDiner').datagrid('reload'); 
                     
                     ;
                   $('#fmPSPMA,#fmMarketClub').form('clear');
                    $('#dlgPSMA,#dlgSilcGroup').dialog('close');
                    
                         
           }
        }

    });

    }


    //Caregroup Script Below
    function addCgP(){
        $('#dlgPromo').dialog('open');
        $('#Rec_id_district').textbox('setValue',$('#cc1').combobox('getValue'));
        $('#Rec_id_TA').textbox('setValue',$('#cc2').combobox('getValue'));
        
    



      //  $('#Rec_id_TA').textbox('hide');
        //$('#Village_ID').textbox('setValue');
        url='savePromo';

    }

    function addCareGroup()
    {
        $('#dlgCareGroup').dialog('open');
         $('#Rec_id_dist').textbox('setValue',$('#cc1').combobox('getValue'));

        $('#Rec_TA_id').textbox('setValue',$('#cc2').combobox('getValue'));
        $('#Rec_gvh').textbox('setValue',$('#cc3').combobox('getValue'));
           $('#cg_promo_id').textbox('setValue',$('#cc8').combobox('getValue'));
        url='saveCG';
    }



    function savePromo(){
         $('#fmCGPromo,#fmCareGroup').form('submit',{
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
                    //reload combo with new values
                    var url2='cggroup?id='+$('#cc3').combobox('getValue');
                    $('#cc4').combobox('reload', url2);

                    var url2='cg_promoter?id='+$('#cc1').combobox('getValue');
                      $('#cc8').combobox('reload', url2);


                    
                         $('#CG_Number').textbox
                   
                   $('#fmCGPromo,#fmCareGroup').form('clear');
                    $('#dlgCareGroup,#dlgPromo').dialog('close');
                    
                         
           }
        }

    });

    }
    