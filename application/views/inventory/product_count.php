<?php require_once('loader.php');
date_default_timezone_set("Asia/Colombo");
 $today = date("Y-m-d");
?>
<div class="content-wrapper">
  <section class="content">
 
   <div id="content"  class="box-body compact">
  <table align="right"><tr><td><a href="<?php echo base_url()?>index.php/inventory/dashboard/target_set_scanning_cleark?date=<?php if($date!=""){echo $date; }else{ echo $today; }?>" >Set count order</a></td></tr></table>
   <h4 style="font-weight:bold">Product Count</h4>
    <table id="example" class="table">
    	<thead>
   			<th>Delete</th>    
        	<th>PID</th>    
    		<th>Zone</th>    
            <th>Sub Zone Group</th>    
    		<th>Sub Zone</th>    
      <?php for($i=1;10>=$i;$i++){ ?>
    		<th style=";text-align:center"><?php  echo $i ?> </th>
   
   		<?php } ?>
        	<th style="text-align:center;width:100px" align="right">Count All Locations..?</th>    
        </thead>
	
    	<tbody>
        	<?php if(sizeof($product_count_list)>0){ 
						foreach($product_count_list->result() as $pcl){ ?>
							
        	<tr>
            	<td><input id="<?php echo  $pcl->count_id  ?>" onclick="child(this)" type="checkbox" name="child_disable" /></td>
            	<td><?php  echo $pcl->product_id  ?></td>
                <td><a id="<?php echo "zone_id"."?".$pcl->zone_id  ?>" onclick="detail_popup(this.id)" href="#"><?php  echo $pcl->zone  ?></a></td>
                <td><a id="<?php echo "sub_zone_group_id"."?".$pcl->sub_zone_group_id  ?>" onclick="detail_popup(this.id)" href="#"><?php  echo $pcl->sub_zone_group  ?></a></td>
                <td><a id="<?php echo "sub_zone_id"."?".$pcl->sub_zone_id ?>" onclick="detail_popup(this.id)" href="#"><?php  echo $pcl->sub_zone  ?> </a></td>
                <?php for($i=1;10>=$i;$i++){ ?>
                <?php // if($pcl->count_number == $i){ ?>
                <td res=""  pid="<?php echo $pcl->product_id?>" sub_zone_id="<?php echo $pcl->sub_zone_id?>" count="<?php  echo $i ?>" name="<?php echo "tc_".$pcl->sub_zone_id.$i.$pcl->count_number  ?>" unic="<?php echo $pcl->sub_zone_id.$i.$pcl->count_id ?>" style="border:1px solid #000;background-color:<?php // echo $pcl->color_code ?>" ></td>
                
				<?php // }else{ ?>
            
				<?php  } //}?>
               <td count="<?php  echo $i ?>"  name="<?php echo "tc_" ?>" unic="<?php echo $pcl->sub_zone_id."10".$pcl->count_id."chack"?>"  align="center"><input  name="<?php echo  $pcl->count_id."/".$pcl->date."/".$pcl->sub_zone_id,"/".$pcl->product_id ?>"  id="<?php echo $pcl->sub_zone_id."10".$pcl->count_id."chack"?>" <?php //if($pcl->count_all_location==1){ ?>  <?php //} ?>onclick="count_all_location(this)" type="checkbox"  /></td> 
            </tr>
        	<?php  }}else{?> <br /> <div style="" class="alert alert-danger alert-dismissable">
      <h4><i class="icon fa fa-ban"></i> Alert!</h4>
      <?php echo "No Results found Product ID :".$pid ?></div><?php  } ?> 
        </tbody>	
    </table>
   <br />
   <form method="post" action="<?php echo base_url() ?>index.php/inventory/dashboard/product_count">
	<table class="">
    	<tr>
        	<td >Date :</td>
            <td style="padding-left:10px"><input class="form-control" type="text" id="ds" name="ds" value="<?php echo $date; ?>" /></td>
            <td style="padding-left:50px">&nbsp;</td>
          
            <td>PID :</td>
            <td style="padding-left:10px"><input class="form-control" type="text" id="pid" name="pid" value="<?php  echo $pid; ?>" onblur="pid_validate(this.value)"/></td>
            <td style="padding-left:50px">&nbsp;</td>
            
            <td></td>
            <td><input class="btn btn-primary" type="submit" id="list" style="width:150px" value="List"  /></td>
            <td>&nbsp;</td>
          <td></td>
            <td style="padding-left:30px"><input class="btn btn-primary" type="button" id="export_excel" style="width:150px" value="Export to Excel"  /></td>
        </tr>
    
    </table>

</form>
<br />
<hr style="border:solid 1px #CCCCCC" />
   <table class="table">
   
   		<tr>
        	<td><label>Zone</label></td>
            <td>
                <select class="form-control" style="width:200px" id="zones">
                	<option selected="selected" value=""></option>	    
                    <?php foreach($zone_list->result() as $zls){ ?>                                   
                    	<option value="<?php echo $zls->zone_id ?>"> <?php  echo $zls->zone ?> </option>
                    	
                    <?php  } ?>
                </select>
            </td>
           
           <td><label>Sub Zone Group</label></td>
            <td>
            	<select class="form-control" style="width:200px" id="szg">
                	                                       
                    
                </select>
            
            </td>
            
            <td><label> Sub Zone</label></td>
            <td>
            	<select class="form-control" style="width:200px" id="sub_zones">
                	                                       
                    
                </select>
            </td>
            
       
            <td><input class="btn btn-primary" type="button" id="add_location" value="Add" style="width:150px" /></td>
        
        </tr>
   
   </table>
   
   
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
       <a style="position:fixed" class="pull-right" href="#"onclick="div_hide()"><i class="fa fa-fw fa-times-circle"></i>Close</a>
       <br />
       <table border="0" id="example12" style="width:1150px%" class="table datatable dispaly ">
    <thead style="position:fixed" >
    <th style="width:150px" >
    Zone - Location
    </th>
    
     <th style="width:210px;text-align:center" >
    Product ID
    </th>
    <th style="width:430px" >
    Description
    </th>
    <th style="text-align:center;width:170px">
    Inventory Qty
    </th>
    <th style="width:55px;text-align:center" >
      1
    </th>
    <th style="width:56px;text-align:center">
      2
    </th>
    <th style="width:57px;text-align:center">
      3
    </th>
    <th style="width:58px;text-align:center">
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

 $('#export_excel').click(function(e) {
    
	 window.location="<?php echo base_url() ?>index.php/inventory/dashboard/download_Excel_pid?s_date="+$('#ds').val()+"";

});

 function div_hide() {
	document.getElementById('pop_up_count').style.display = "none";
	
 }
 
	function detail_popup(data){
		
		var res=data.split("?");
	
		$.ajax({
			url: '<?php echo base_url() ?>index.php/inventory/dashboard/pid_popup_detail',
			method: 'POST',
			data: {field:res[0],value:res[1],ds:$('#ds').val()},
				success: function(data) {
							
					document.getElementById('pop_up_count').style.display = "block";
			  		document.getElementById('tablebody1').innerHTML=data;
				},
				error: function(err, message, xx) {
				}
			});	
		
	}

	function pid_validate(pid){
	    if(pid!=""){
			$.ajax({
			url: '<?php echo base_url() ?>index.php/inventory/dashboard/pid_validate',
			method: 'POST',
			data: {pid:pid},
				success: function(data) {
					if(data==0){
						alert("Invalid Product Id"+" "+"("+pid+")");
						$('#pid').val("");
					}
				
				
				},
				error: function(err, message, xx) {
				}
			});	
		}
	}	


	function count_all_location(data){

		var condition='';
			if($('#'+data.id).prop('checked')) {
				condition=1;		
			
			}else{
				condition=0;	
			}
		
					$.ajax({
						url: '<?php echo base_url() ?>index.php/inventory/dashboard/count_all_location',
						method: 'POST',
						data: {count_id:data.alt,condition:condition,ds:$('#ds').val()},
							success: function(data) {
								window.location.href="<?php echo base_url() ?>index.php/inventory/dashboard/product_count";
							
							},
							error: function(err, message, xx) {
							}
						});	
					
	}


	function child(data){
		var condition='';
			if($('#'+data.id).prop('checked')) {
				condition=1;		
			
			}else{
				condition=0;	
			}
			var r = confirm("You want to Remove this Record");

					if(r == true){
						$.ajax({
						url: '<?php echo base_url() ?>index.php/inventory/dashboard/delete_product_count_row',
						method: 'POST',
						data: {condition:condition,ds:$('#ds').val(),count_id:data.id},
							success: function(data) {
								window.location.href="<?php echo base_url() ?>index.php/inventory/dashboard/product_count";
							},
							error: function(err, message, xx) {
							}
						});	
					}else{
						document.getElementById(data.id).checked = false;
					}
	}


			$.ajax({
            url: '<?php echo base_url() ?>index.php/inventory/dashboard/load_product_count_result',
            method: 'POST',
            data: {ds:$('#ds').val() },
          	success: function(data) {
			   if (data!="") {
				   var vs="";
				 var co="";
				 var count_location=""
				 res=data.split("/");
			
					  $('td[name^="tc_"]').show(function(){
						  	
							var colour_set=$(this)
							var id = $(this).attr('unic');
							vs=id;
							var sub_zone_id = $(this).attr('sub_zone_id');
							var count = $(this).attr('count');
							var pid = $(this).attr('pid');
						
							for(var i=1;res.length>i;i++){
								var last_res=res[i].split("_");
								//alert(last_res);
									for(var x=0;last_res.length>x;x++){			
									
											if(sub_zone_id==last_res[2] && count==last_res[3] && pid==last_res[4]){
											
												colour_set.attr('bgcolor',last_res[0]);
												$(this).attr('all_location',last_res[6]);
												$(this).attr('col',last_res[5]);
											
												co=last_res[5] ;
												count_location=last_res[6];
												
											}
			
									}	
																
								$('#'+id+"chack").attr("alt",co);
								$('#'+id+"chack").attr("class",co+"abc");
							}
		
							if(count_location!=0 && count==11){
								$('#'+id).attr("checked","checked");
							}
		

					  });
            }
			
			},
            error: function(err, message, xx) {

            }
			
        });	


	
	

	$('#example').dataTable( {
		"scrollY":        "350px",
		"scrollCollapse": true,
		"paging":         false,
		"order": [[ 2, "desc" ]],
		"bSortable": false
	});
	
$('#add_location').click(function(e) {
    var date=$('#ds').val();
	var pid=$('#pid').val();;
	var field_name;
	var value;
		
		if($('#pid').val()!=""){
		
		
			 if($('#zones').val()!=""){
				field_name="lm_zone.zone_id";
				value=$('#zones').val();
		
			 }
			
			 if($('#szg').val()!=null && $('#szg').val()!=""){
				 
				field_name="lm_sub_zone_group.sub_zone_group_id";
				value=$('#szg').val();
			
			 }
			 
			  if($('#sub_zones').val()!=null && $('#sub_zones').val()!=""){
				field_name="lm_sub_zone.sub_zone_id";
				value=$('#sub_zones').val();
			 }
	
				if(value!=null){
					$.ajax({
						url: '<?php echo base_url() ?>index.php/inventory/dashboard/add_count_location',
						method: 'POST',
						data: {date:date,pid: pid,value:value,field_name:field_name},
						
						success: function(data) {
							
							window.location.href="<?php echo base_url() ?>index.php/inventory/dashboard/product_count";
						},
						error: function(err, message, xx) {
			
						}
					});
				}else{
				
					alert("Please Select Direction");
				}
			 
		
		}else{
			alert("Please Enter PID");
		}
	
 
	
	
	
	
});

$('#zones').change(function(e) {
  	if($('#zones').val()!=""){
		  $.ajax({
            url: '<?php echo base_url() ?>index.php/inventory/dashboard/load_sub_zone_group',
            method: 'POST',
            data: {zones_id:$('#zones').val()},
            success: function(data) {
			
 			 	document.getElementById('szg').innerHTML=data;
			 
            },
            error: function(err, message, xx) {

            }
        });
	
	}
 
});
$('#szg').change(function(e) {
	
  	if($('#szg').val()!=""){
		  $.ajax({
            url: '<?php echo base_url() ?>index.php/inventory/dashboard/load_sub_zone',
            method: 'POST',
            data: {zones_group_id:$('#szg').val()},
            success: function(data) {
 			 	document.getElementById('sub_zones').innerHTML=data;
			 
            },
            error: function(err, message, xx) {

            }
        });
	
	}
 
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
       background-color:#CCC;
       overflow:auto;
    }

    div#popupContact {
       position:absolute;
       left:5%;
       top:23%;
       bottom:5%;
       right:10%;
	
	   width:92%;
       overflow:scroll;
	   background-color:#FFF;
	   border-radius:10px;
	   
	   

    }
	
	

</style>