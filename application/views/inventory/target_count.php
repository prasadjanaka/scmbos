<?php require_once('loader.php');
date_default_timezone_set("Asia/Colombo");
 $today = date("Y-m-d");
?>
<div class="content-wrapper">
  <section class="content">
   <div id="content"  class="box-body compact">
 <table align="right"><tr>
  <td style="font-weight:bold">Shortcuts  &rArr; &nbsp;&nbsp;&nbsp;</td> <td><a href="<?php echo base_url()?>index.php/inventory/dashboard/target_set_scanning_cleark?date=<?php if($ds!=""){echo $ds; }else{ echo $today; }?>" >Set count order</a></td>
 <td style="padding-left:20px"><a href="<?php echo base_url()?>index.php/inventory/location_manager/confirmed_result?ds=<?php echo $ds  ?>" >Confirmed Results</a></td>
 <td style="padding-left:20px"><a href="<?php echo base_url()?>index.php/inventory/location_manager/Result?ds=<?php echo $ds  ?>" >Counting Results</a></td>
  <td style="padding-left:20px"><a href="<?php echo base_url()?>index.php/inventory/Dashboard/ex_summary?ds=<?php echo $ds  ?>" >Executive Summary</a></td> 
 </tr></table>
   <h4 style="font-weight:bold">Location Count : <?php if($ds!=""){echo $ds; }else{ echo $today; }?></h4>
 	<table  class="display  dataTable" cellspacing="0" width="80%" id="example" >
    <thead>
  
      <th align="right" style="text-align:center;width:80px" id="disable_count_column">
			<input onclick="master()" type="checkbox" name="master_disable" id="master_disable" /> Disable <br/>Count
      </th>
 
    <th align="left" style="text-align:left;width:160px">Zone - Location</th>
    <?php for($i=1;$count>=$i;$i++){ ?>
    <th width="50px" align="center" style="font-size:16px;text-align:center">
    <?php  echo $i ?>
    </th>
   
    <?php } ?>
    </tr>
      
    </thead>
    
    <tbody>
	<?php  foreach($sub_zone_list->result() as $sub_zone){ ?>
    <?php    ?>
    <tr>
    
    	
      <td   align="center" style="text-align:center"><input zub_zone_id="<?php echo $sub_zone->sub_zone_id?>" <?php foreach($disabled_master as $disabled_masters){ if($sub_zone->sub_zone_id==$disabled_masters->sub_zone_id){ ?> checked="checked" <?php }} ?>onclick="child(this)" type="checkbox" name="child_disable" id="<?php echo $sub_zone->sub_zone_id?>" />
        <label for="checkbox"></label></td>
  	
    
     <td   align="left"><a onclick="des_pop(this.id)" id="<?php echo $sub_zone->zone_id.'/0'.'/0'.'/'.$sub_zone->zone ?>"  href="#"><?php echo $sub_zone->zone?> </a>|&nbsp;<a onclick="des_pop(this.id)" id="<?php echo $sub_zone->zone_id."/".$sub_zone->sub_zone_group_id.'/0'.'/'.$sub_zone->zone  ?>"  href="#"><?php echo $sub_zone->sub_zone_group?> </a>|&nbsp;<a onclick="des_pop(this.id)" id="<?php echo $sub_zone->zone_id. "/".$sub_zone->sub_zone_group_id."/".$sub_zone->sub_zone_id.'/'.$sub_zone->zone  ?>"  href="#"><?php echo $sub_zone->sub_zone?> </a> <span style="text-align:center;font-size:10px">(<?php echo $sub_zone->location_count?>)</span></td> 
 
    <?php for($i=1;$count>=$i;$i++){ ?>
    <td target_location="<?php echo $sub_zone->sub_zone ?>" status_id="1"  name="<?php echo "tc_".$sub_zone->sub_zone_id.$i  ?>" unic="<?php echo $sub_zone->sub_zone_id."?".$i  ?>" count_id = "0" sub_zone="<?php echo $sub_zone->sub_zone_id ?>" tc="<?php echo $sub_zone->sub_zone_id  ?>" number_count="<?php echo $i ?>"   id="trigger" style="border:1px solid #000;">
  
    </td>
    <?php  }} ?>
    </tr> 
    </tbody>
    </table>  
   
  <table>
  <tr>
  <?php  foreach( $count_status_list->result() as $csl){ ?>
  
  <td style="background-color:<?php echo $csl->color_code   ?>"> <?php  echo $csl->count_status ?></td>
	<td>&nbsp;&nbsp;</td>
	<td>&nbsp;&nbsp;</td>
  <?php  } ?>
   <td hidden="">|</td>
   	<td>&nbsp;&nbsp;</td>
	<td>&nbsp;&nbsp;</td>
	<td><input hidden="" id="full_details" name="full_details" type="checkbox" value="Enable Summery" /></td>
	<td>&nbsp;&nbsp;</td>
	<td hidden="">Enable_Summary</td>
 

<td>Select count Number</td>
	<td style="padding-right:10px">
    <select style="width:200px" id="count_number_select" name="count_number_select">
<option value="">All</option>
<?php  for($x=1;$x<21;$x++){  
  $selected = ($count_number==$x? " selected " : "");?>
<option <?php  echo $selected ?>><?php   echo "count".$x ?></option>
<?php   }?>
	</select>

</tr>


  </table> 
<br />
 <table>  
 	<tr>
    	<td><label>Zone</label></td>
        <td style="padding-left:10px">
        <select class="form-control" style="width:200px" id="zones" name="zones">
                	<option selected="selected" value="0"></option>	    
                    <?php foreach($zone_list->result() as $zls){ ?> 
                    	<?php $selected=""; if($zone_id_selected == $zls->zone_id){ $selected="selected"; } ?>                                  
                    	<option <?php  echo $selected ?> value="<?php echo $zls->zone_id ?>"> <?php  echo $zls->zone ?> </option>
                    	
                    <?php  } ?>
                </select>
        </td>
        
        <td style="padding-left:10px"><label>Sub Zone Group</label></td>
        <td style="padding-left:10px"><select class="form-control" style="width:200px" id="zone_group" name="zone_group">
               	<option selected="selected" value=""></option>	  
                    <?php foreach($sub_zone_group_list->result() as $szgl){ ?> 
                   
                    <?php $selected=""; if($sub_zone_group_id_selected == $szgl->sub_zone_group_id){ $selected="selected"; } ?>                                
                    	<option <?php  echo $selected ?> value="<?php echo $szgl->sub_zone_group_id ?>"> <?php  echo $szgl->sub_zone_group ?> </option>
                    	
                    <?php  } ?>
                </select></td>
        
        <td style="padding-left:10px"><label>Sub Zone</label></td>
        <td style="padding-left:10px"><select class="form-control" style="width:200px" id="sub_zone" name="sub_zone">
                	<option selected="selected" value=""></option>	    
                    <?php if(sizeof($sub_zone_list_location)>0){ foreach($sub_zone_list_location->result() as $szl){ ?>                         <?php $selected=""; if($sub_zone_id_selected == $szl->sub_zone_id){ $selected="selected"; } ?>             
                    	<option <?php  echo $selected ?> value="<?php echo $szl->sub_zone_id ?>"> <?php  echo $szl->sub_zone ?> </option>
                    	
                    <?php  } }?>
                </select></td>
                
                <td style="padding-right:20px"><input type="button" id="filter" value="Filter" class="btn btn-primary" style="width:100px"/></td>  
               	</td>
<td>   <input id="excel_export" style="width:150px;" class="btn btn-primary" type="button" value="Raw Data to Excel" /></td>
                
    </tr> 
  </table> 
    
  <div > 
  <form id="count_form" method="GET" action="">
   <table >

    <tr>
    <td colspan="4"><strong>Change date range</strong></td>
    </tr>
    <tr>
    <td><strong>From</strong></td>
    <td><strong>up to</strong></td>
    <td>&nbsp;</td>
        
    </tr>
    <tr>
        <td><div class="input-group">
            <div class="input-group-addon">
            <i class="fa fa-calendar"></i>
            </div>
            <input style="z-index: 0;" value="<?php if($ds!=""){echo $ds; }else{ echo $today; }?>" id="ds" name="ds" class="form-control datemask" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="" type="text">
            </div></td>
            <td><label for="textfield"></label>
            <label for="sc"></label>
            <select name="dc" id="dc">
            <option value="20">20</option>
            </select></td>
           <td><input class="btn btn-default " type="submit" name="button" id="button" value="List" />
           </td>
    
    </tr>
   </table>
   </form>
   </div>
  
   <div class= "box-body compact" id="pop-up" style="background-color:#FFF;  display: none;position: absolute; width: auto;  padding: 10px;    font-size: 90%;">
      <h3 id="dis_location"></h3>
     <table border="1" id="my_table" style=" background-color:#FFF;" class="">
    <thead >
    <th >
    PID
    </th>
    <th>
    Description
    </th>
    <th>
    AQ
    </th>
    <th>
    Booked
    </th>
    <th>
    Counted
    </th>
    </thead>
    <tbody id="tablebody">
  
    </tbody>
     </table>
     
     
     
    </div>
   <div id="pop_up_count" >
 <br />
   <div style="  position:absolute;
       left:3%;
       top:10%;
       bottom:3%;
       right:5%;
	   height:87.5%;
	   width:95%;
      
	   background-color:#FFF;
	   border-radius:10px;
	   padding-bottom:30px;
         padding-top:10px;
       padding-left:25px;">
       <h3><div style="float:left;width:92%;text-align:center;" id="count_head"></div></h3>
       <a style="position:fixed" class="pull-left" href="#"onclick="div_hide()"><i class="fa fa-fw fa-times-circle"></i>Close</a>
       <div style="display:none"><label><input id="r_confirm" type="checkbox" name="checkbox" value="value">&nbsp;&nbsp;Recount without Confirmation</label></div>
       <table border="0" id="example12" style="width:1150px%" class="table datatable dispaly ">
    <thead style="position:fixed" >
    <th style="width:175px" >
    Zone - Location
    </th>
    
     <th style="width:160px;text-align:center" >
    Product ID
    </th>
    <th style="width:440px" >
    Description
    </th>
    <th style="text-align:center;width:165px">
    Inventory Qty
    </th>
    <th style="width:55px;text-align:center" >
      1
    </th>
    <th style="width:48px;text-align:center">
      2
    </th>
    <th style="width:50px;text-align:center">
      3
    </th>
    <th style="width:52px;text-align:center">
      4
    </th>
    <th style="width:49px;text-align:center">
      5
    </th>
    </thead>
    </table>
       
       </div> <br /><br />
   <div id="popupContact">
    
   
    <table border="0" id="example12" style="width:1150px%" class="table datatable dispaly ">
    <thead style="" >
    <th style="width:150px" >
  
    </th>
    
     <th  style="width:150px">
   
    </th>
    <th  style="width:380px">
  
    </th>
    <th style="text-align:center;width:150px">
 
    </th>
    <th  style="text-align:center;width:50px">
    
    </th>
    <th style="text-align:center;width:50px">
  
    </th>
    <th style="text-align:center;width:50px">
   
    </th>
    <th style="text-align:center;width:50px">
  
    </th>
    <th style="text-align:center;width:50px">
    
    </th>
    </thead>
    <tbody   id="tablebody1">
  
    </tbody>
     </table>
     
     
   </div>
  
   </div>

   </div>
 </section>
</div>

<script>

$('.datemask').inputmask("9999-99-99");	
	$('#filter').click(function(e) {
        
		if($('#zones').val()!=""){
			window.location = '<?php echo base_url() ?>index.php/inventory/dashboard/target_count?zone_id='+$('#zones').val()+'&ds='+$('#ds').val()+'';
		}
		if($('#zones').val()!="" && $('#zone_group').val()!=""){
			window.location = '<?php echo base_url() ?>index.php/inventory/dashboard/target_count?zones_group_id='+$('#zone_group').val()+'&zone_id='+$('#zones').val()+'&ds='+$('#ds').val()+'';
		}
		if($('#zones').val()!="" && $('#zone_group').val()!="" && $('#zone_group').val()!=""){
		window.location = '<?php echo base_url() ?>index.php/inventory/dashboard/target_count?zones_group_id='+$('#zone_group').val()+'&zone_id='+$('#zones').val()+'&sub_zone_id='+$('#sub_zone').val()+'&ds='+$('#ds').val()+'';
		}
		
    });

	$('#zones').change(function(e) {
        
		window.location = '<?php echo base_url() ?>index.php/inventory/dashboard/target_count?zone_id='+$('#zones').val()+'&ds='+$('#ds').val()+'';
    });

	$('#zone_group').change(function(e) {
        
		window.location = '<?php echo base_url() ?>index.php/inventory/dashboard/target_count?zones_group_id='+$('#zone_group').val()+'&zone_id='+$('#zones').val()+'&ds='+$('#ds').val()+'';
    });


	$('#sub_zone').change(function(e) {
        
		window.location = '<?php echo base_url() ?>index.php/inventory/dashboard/target_count?zones_group_id='+$('#zone_group').val()+'&zone_id='+$('#zones').val()+'&sub_zone_id='+$('#sub_zone').val()+'&ds='+$('#ds').val()+'';
    });
	var pop_up_edit_confirm=false;
	


	function child(data){
		var condition='';
			if($('#'+data.id).prop('checked')) {
				condition=1;		
			
			}else{
				condition=0;	
			}

					$.ajax({
					url: '<?php echo base_url() ?>index.php/inventory/dashboard/disable_child_count',
					method: 'POST',
					data: {condition:condition,date:$('#ds').val(),sub_zone_id:data.id},
					success: function(data) {
					
					},
					error: function(err, message, xx) {
					}
				});	

	}

	function master(){
		var condition="";
			if($('#master_disable').prop('checked')) {
				$('input[name=child_disable]').prop('checked', true);
				condition=1;
			} else {
	
				$('input[name=child_disable]').prop('checked', false);
				condition=0;
			}
					
					$.ajax({
						url: '<?php echo base_url() ?>index.php/inventory/dashboard/disable_master_count',
						method: 'POST',
						data: {condition:condition,date:$('#ds').val()},
						success: function(data) {
					
						},
						error: function(err, message, xx) {
						}
					});	

			
	}
	
	
	
	
	//function re_count(data){
//		pop_up_edit_confirm=true;
//		var res =data.split("-");
//		var currnet_number=res[0];
//		var sub_zone_id=res[1];
//		var location_id=res[2];
//		var product_id=res[3];
//		var action;
//		
//			if(document.getElementById("r_confirm").checked){		
//				action=true;	
//			}else{
//				action = confirm("Do you want to recount this location");
//			}
//   		$.ajax({
//            url: '<?php //echo base_url() ?>index.php/inventory/dashboard/target_recount',
//            method: 'POST',
//            data: {product_id:product_id,location_id:location_id,current_number:currnet_number,sub_zone_id:sub_zone_id,acction:action,select_date:$("#ds").val() },
//            success: function(data) {
//			   if (data!="") { 
//			   		if(data==4){
//					alert("Recount can not be assigned for ongoing counts.Please condude all locations of last count");
//					}
//			   }
//            },
//            error: function(err, message, xx) {
//            }
//        });
//
//	
//	}



	$('#excel_export').click(function(e) {
     	 window.location ="<?php   echo base_url() ?>index.php/inventory/dashboard/download_Excel?c_number=<?php echo $i  ?>&s_date=<?php if($ds!=""){echo $ds; }else{ echo $today; }  ?>";
	});

    function div_hide() {
       
		if(pop_up_edit_confirm==true){
			window.location.pathname ="index.php/inventory/dashboard/target_count?ds="+$("#ds").val()+"";
		}else{
			document.getElementById('pop_up_count').style.display = "none";
		}
		
		
    }
	
	function des_pop(sub_zone_id){
	 
		document.getElementById("r_confirm").checked=false;
		var res=sub_zone_id.split("/");	
	 	var zone_id=res[0];
	 	var sub_zone_group_id=res[1];
	    var sub_zone_id=res[2];

	  $.ajax({
         url: '<?php echo base_url() ?>index.php/inventory/dashboard/counting_finished_popup',
         method: 'POST',
         data: {zone_id:zone_id,sub_zone_group_id:sub_zone_group_id,sub_zone_id:sub_zone_id,date:$('#ds').val()},  
		    success: function(data) {
			   if (data!="") {   
					document.getElementById('pop_up_count').style.display = "block";
			  		document.getElementById('tablebody1').innerHTML=data;
			 		document.getElementById('count_head').innerHTML="Counting  Result For"+" "+res[3];
			   }else{
				   alert("No Counting Data");
			   }
            },
            error: function(err, message, xx) {
            }
        });
	
	
	}
	
	$(document).ready(function () {

 			$.ajax({
            url: '<?php echo base_url() ?>index.php/inventory/dashboard/load_shedual',
            method: 'POST',
            data: {ds:$('#ds').val(),count_number:$('#count_number_select').val() },
          	success: function(data) {
			   if (data!="") {
				 res=data.split("/");
				
			  $('td[name^="tc_"]').show(function(){
				var colour_set=$(this)
				var id = $(this).attr('unic');
	
					for(var i=1;res.length>i;i++){
					var last_res=res[i].split("_");
					
						for(var x=0;last_res.length>x;x++){			
							if(id==last_res[1]){
								
								colour_set.attr('bgcolor',last_res[0]);
								colour_set.attr('count_Id',last_res[2]);
								colour_set.attr('status_id',last_res[3]);
								colour_set.html('<div style="display:none">'+"count"+last_res[4]+'</div>');	
							}
						}
					}
		      });
			
				
            }
			$('#example').dataTable( {
				"scrollY":        "255px",
				"scrollCollapse": true,
				"paging":         false,
				"aoColumnDefs": [
				{"bSortable": false,
				"aTargets": [ 0 ]}],
				"aaSorting": [[ 1, "asc" ]]
			});
			},
            error: function(err, message, xx) {

            }
			
        });	

		

	 $('td[name^="tc_"]').dblclick(function(){
		var id=($(this).attr('name'));
		var colour_set=$(this);
		var status_id=($(this).attr('status_id'));
		var sub_zone_id = ($(this).attr('sub_zone'));
		var select_date=$('#ds').val();
		var count_id=($(this).attr('count_id'));
		var number_count=($(this).attr('number_count'));
		
			if(number_count==1){
				$('#loading-indicator').show();
			if(status_id==1){
				$.post( "<?php echo base_url()?>index.php/inventory/dashboard/target_count_set", { 
				count_id: count_id,sub_zone_id: sub_zone_id, select_date: select_date, number_count:number_count})
				.done(function( data ) {
				
					if(data!=""){
						if(data==1){
							alert("Sorry you are not allowed to access this area of the system");
							return;
							}else if(data==0){
								alert("Sorry you have already assigned scanner to this sub zone");
								return;
							}
						res=data.split("_");
						colour_set.attr('bgcolor',res[0]);
						colour_set.attr('count_Id',res[1]);
					}else{
						colour_set.attr('bgcolor','');
						colour_set.attr('count_Id',0);	
				
					}	
			///}
					$('#loading-indicator').hide();
			
			});
 			}else{
		 		alert("Scanners are Already Set");
				$('#loading-indicator').hide();
			}
			
	 	}

	 });
	

	
  
	
  $(function() {
  return (true);
  var moveLeft = -250;
  var moveDown = 10;

  $('td#trigger').hover(function(e) {
	return (true);
	if($('#full_details').is(":checked")){
				var target_location = $(this).attr('tc');
				var target=$(this).attr('target_location');
				//var number_count=$(this).attr('number_count');
		
		
		   $.ajax({
            url: '<?php echo base_url() ?>index.php/inventory/dashboard/pid_popup_data',
            method: 'POST',
            data: {tc:target_location,date: $('#ds').val()},
            success: function(data) {
 			 
			   if (data!="") {
	           $('#pop-up').show();
		       var b=document.getElementById('tablebody').innerHTML=data;
			   document.getElementById('dis_location').innerHTML='Location'+' '+target;
				
               }else if(data==""){ 
			   document.getElementById('tablebody').innerHTML="No Inventory Data"; 
			    document.getElementById('dis_location').innerHTML='Location'+' '+target;
			   $('#pop-up').show();}
            },
            error: function(err, message, xx) {

            }
        });
	  }
	  },function() {
		  return (true);
	 $('#pop-up').hide();	  
     });

  $('td#trigger').mousemove(function(e) {
	  return (true);
    	$("#pop-up").css('top', e.pageY + moveDown).css('left', e.pageX + moveLeft);

		});
	
	});

	$('div#pop-up').hover(function(e){
		return (true);
 		$('#pop-up').show();
	});
	
	$('#content').click(function(e){
		return (true);
 		$('#pop-up').hide();
	});
   });
   

	$('#example1').dataTable( {
		"scrollY":        "800px",
		"scrollCollapse": true,
		"paging":         false,
		"order": [[ 2, "desc" ]],
		"bSortable": false
	});
	
	
	$('#count_number_select').change(function(e) {
	 	var table = $('#example').DataTable();
		table.search($('#count_number_select').val()).draw();
    });
	
	
	
</script>

<style>
    #pop_up_count {
       width:100%;
       height:100%;
     
       top:0;
       left:0;
       display:none;
       position:fixed;
       background-color:#CCC;//; #9d9d9dtransparent
       overflow:auto;
    }

    div#popupContact {
       position:absolute;
       left:5%;
       top:28%;
       bottom:5%;
       right:10%;
	
	   width:92%;
       overflow:scroll;
	   background-color:#FFF;
	   border-radius:10px;
	   
	   

    }
	
	

</style>