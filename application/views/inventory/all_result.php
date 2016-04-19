<?php require_once('loader.php');
date_default_timezone_set("Asia/Colombo");
?>


<div class="content-wrapper">
  <section class="content ">
    <div class="box-body compact"> 
            <table align="right"><tr>
             <td style="font-weight:bold">Shortcuts  &rArr; &nbsp;&nbsp;&nbsp;</td>
              <td><a href="<?php echo base_url()?>index.php/inventory/location_manager/confirmed_result?ds=<?php echo $ds  ?>" >Confirmed Results</a></td>
              <td style="padding-left:20px"><a href="<?php echo base_url()?>index.php/inventory/dashboard/target_set_scanning_cleark?date=<?php if($ds!=""){echo $ds; }?>" >Set count order</a></td>
<td style="padding-left:20px"><a href="<?php echo base_url()?>index.php/inventory/dashboard/target_count?ds=<?php if($ds!=""){echo $ds; }?>" >Location Count</a></td> 
 <td style="padding-left:20px"><a href="<?php echo base_url()?>index.php/inventory/Dashboard/ex_summary?ds=<?php echo $ds  ?>" >Executive Summary</a></td> 
              
              </tr></table>
 <br />
      <div class="col-md-6">

        <h4>Counting results for <?php  echo $ds  ?>
      </h4></div>  
     
      <div class="md-6" style="text-align:right">
      <input name="confirmation_valide" id="confirmation_valide" type="checkbox" value="">
      <label style="padding-left:20px">Confirm & Recount without confirmation alert</label>  
      </div>
      
      <table class="example" id="example">
      	<thead>
        	<tr>
           	  	<th style="display:none">confirm_all</th>
            	<th>Zone</th>
                <th>Sub Zone</th>
                <th>Location</th>
                <th style="width:100px">Product ID</th>
                <th style="width:350px">Description</th>
                <th style="width:85px;text-align:center">WMS</th>
             <?php  for($i=1;$x=6>$i;$i++){ ?>
                <th style="width:50px;text-align:center"><?php echo $i; ?></th>
              <?php   } ?>
              <th style="width:70px;text-align:center">Qty to <br />Confirm</th>
              <th style="width:30px;text-align:center"></th>
              <th style="width:30px;text-align:center"></th>
            </tr>
        
        </thead>
        <tbody>
        	<?php foreach($results->result() as $rows){  ?>
            		
               <?php 
			   $crl="";
			    $inventory_qty =  (int)$rows->inventory_quantity;
				$count_result = array();  
			   		if($rows->count_1!=""){
						array_push($count_result,$rows->count_1);
					}
					
					if($rows->count_2!=""){
						array_push($count_result,$rows->count_2);
					}
					if($rows->count_3!=""){
						array_push($count_result,$rows->count_3);
					}
					if($rows->count_4!=""){
						array_push($count_result,$rows->count_4);
					}
					if($rows->count_5!=""){
						array_push($count_result,$rows->count_5);
					}
			   
			   		if(sizeof($count_result)==1){
						if($count_result[0]==$inventory_qty){
							
							$crl = "style='color:green;font-weight:bold'";
						}else{
							$crl ="style='color:red'";
						}
					}else{
						$result =	array_count_values($count_result);
							if(sizeof($result)==1){
								$crl = "style='color:green;font-weight:bold'";
							}else{
								$crl ="style='color:Orange'";;
							}	
						
					}
			   ?>	
                    
        		<tr <?php echo $crl ?> id="row_<?php echo $rows->location_id  ?>">
              	<td style="display:none"><?php echo $rows->location_id."?".$rows->sub_zone_id."?".$rows->product_id."?".$ds  ?></td>
            	<td><?php echo $rows->zone  ?></td>
                 <td><?php echo $rows->sub_zone  ?></td>
                <td name="<?php echo "tc_".$rows->location_id."-".$rows->count_detail_id  ?>" pid="<?php echo $rows->location  ?>" ><?php echo $rows->location  ?></td>
                <td name="<?php echo "tc_".$rows->location_id."-".$rows->count_detail_id  ?>" pid="<?php echo $rows->product_id  ?>"><?php echo $rows->product_id  ?></td>
                <td><?php echo $rows->description  ?><span style="display:none">
                  <?php  if($crl=="style='color:green;font-weight:bold'"){ echo "Match";}else{ echo "Non-done"; } ?>
                </span></td>
                <td style="text-align:center"><?php if($rows->inventory_quantity==""){ echo  '0';}else{ echo $rows->inventory_quantity ; }?></td>
                <td style="text-align:center"><?php echo $rows->count_1  ?></td>
                <td style="text-align:center"><?php echo $rows->count_2  ?></td>
                <td style="text-align:center"><?php echo $rows->count_3  ?></td>
                <td style="text-align:center"><?php echo $rows->count_4  ?></td>
                <td style="text-align:center"><?php echo $rows->count_5  ?></td>
                <?php 
					$qty_to_confirm = 0 ;
						if($rows->count_1 > 0) $qty_to_confirm = $rows->count_1 ;
						if($rows->count_2 > 0) $qty_to_confirm = $rows->count_2 ;
						if($rows->count_3 > 0) $qty_to_confirm = $rows->count_3 ;
						if($rows->count_4 > 0) $qty_to_confirm = $rows->count_4 ;
						if($rows->count_5 > 0) $qty_to_confirm = $rows->count_5 ;
				
				?>                
                <?php if($rows->status_id == ""){ ?>
                	<td style="text-align:center" on_edit="no" id="con_qty_<?php echo $rows->location_id?>_<?php echo $rows->product_id?>" pid = "<?php echo $rows->product_id?>" location_id = "<?php echo $rows->location_id?>" ><?php echo $qty_to_confirm; ?></td>
				<?php  }else{?>
					<td style="text-align:center" >&nbsp;</td>
				<?php  }?>
				
				<?php if($rows->status_id == ""){ ?>
             	<td style="text-align:center" title="Confirm" id="con_<?php echo $rows->count_id."?".$rows->location_id."?".$rows->sub_zone_id."?".$rows->count_detail_id?>"><a  disable_td="<?php echo $rows->location_id."-".$rows->count_detail_id?>" id="<?php echo $rows->location_id."-".$rows->count_detail_id?>" location="<?php echo $rows->location_id  ?>" pid="<?php echo $rows->product_id  ?>" count_id="<?php echo $rows->count_id  ?>" sub_zone_id="<?php echo $rows->sub_zone_id  ?>" onClick="confirm_count(this)"><i class="fa fa-fw fa-check"></i></a></td>
            	
                <td style="text-align:center" title="Re-Count"  id="re_<?php echo $rows->count_id."?".$rows->location_id."?".$rows->sub_zone_id."?".$rows->count_detail_id?>"><a   disable_td="<?php echo $rows->location_id."-".$rows->count_detail_id?>" id="<?php echo $rows->count_id."?".$rows->location_id."?".$rows->sub_zone_id."?".$rows->count_detail_id  ?>" onClick="recount(this.id)"><i class="fa fa-fw fa-repeat"></i></a></td>
                <?php  }else{?>
                	<td></td>
                    <td title="Counting..." style="padding:2px"><div style="background-color:#FF3;color:#000;font-weight:bold; text-align:center"><i class="fa fa-fw fa-caret-right"></i></div></td>
                <?php  }?>
            </tr>
        <?php }  ?>
        </tbody>
      
      </table>
      <br>
       <div class="col-md-12" >
     <table>
     
      <form method="GET">
      	<tr>
        	<td> <label>Date</label></td>
            <td style="padding-left:10px"><input value="<?php  echo $ds  ?>" type="text" id="ds" name="ds" class="form-control datemask"/></td>
            <td style="padding-left:10px"><input  type="submit" value="List" style="width:100px" class="btn  btn-facebook"/></td>
            
            <td style="padding-left:10px">Zone</td>
            <td style="padding-left:10px"> <select class="form-control" style="width:200px" id="zones" name="zones">
                	<option selected="selected" value=""></option>	    
                    <?php foreach($zone_list->result() as $zls){ ?> 
                    	<?php $selected = "";if($zone_id == $zls->zone_id){$selected = "selected";}  ?>                                  
                    	<option <?php echo $selected ?> value="<?php echo $zls->zone_id ?>"> <?php  echo $zls->zone ?> </option>
                    	
                    <?php  } ?>
                </select></td>
                 <td style="padding-left:10px">Filter</td>
            <td style="padding-left:10px"> <select class="form-control" style="width:200px" id="filter" name="zones">
                	<option selected="selected" value=""></option>	    
                    <option  value="Match">Match</option>	  
                    <option  value="Non-done">Non-match</option>	  
                </select></td>
                
                 <td style="padding-left:10px"><input type="button" id="confirm_all" class="btn  btn-facebook" style="width:150px;display:none" value="Confirm All"/></td>
                 
                 <td>
                  <input type="button" value="Export to Excel" id="write_to_excel"  class="btn  btn-facebook"/>
                 </td>
           
        </tr>
      </form>
      </table>
      <input type="text" id="valide_confirm1"  hidden=""/>
      </div> 
      
       <br />
     </div>
  </section>
</div>


<style>

.example tr:hover {
          background-color: #ffff99;
		  font-size:14px;
		  cursor:pointer
        }
</style>
<script>
	$('td[id^="con_qty_"]').dblclick(function(){
		if($(this).attr('on_edit')=='yes'){
			return false;
		}
		
		var cell = $(this);
		var pre_val = cell.html();
		var on_edit = 'yes';
		var product_id = $(this).attr('pid');
		var location_id = $(this).attr('location_id');
		var date = '<?php echo $ds?>';
		
		$(this).html('<input name="qty_confirmed" type="text" id="qty_confirmed" size="5" style="height:20px" value="'+ $(this).html() +'" />');
		$('#qty_confirmed').focus();
		$('#qty_confirmed').select();
		$("#qty_confirmed").bind( "change focusout", function() {
			var entered_val = $("#qty_confirmed").val();
			cell.html('');
			cell.html(entered_val);
			cell.attr('on_edit','no');
			if(pre_val!=cell.html()){
				cell.css("background-color", "#C0C");
				cell.css("color", "#FFF");
			}
		});
		
		$("#qty_confirmed").bind( "dblclick", function() {
			return false;
		});		
	});	
	



	$("#write_to_excel").click(function () {
		window.location ="<?php echo base_url() ?>index.php/inventory/Location_manager/count_result?ds="+$("#ds").val()+"";
	
		 }); 

$('#confirm_all').click(function(e) {
	  var r = confirm("Are you sure that you want to confirm all results");
        if (r == true) {
		   var TableData = new Array();
		
		$('#example tr').each(function(row, tr){
			
			
		TableData[row]={
			"confirm_all" : $(tr).find('td:eq(0)').text(),
			"con_value" : $(tr).find('td:eq(12)').text()      
		}
	}); 
	
		TableData.shift(); 

			  $.ajax({
				url: '<?php echo base_url() ?>index.php/inventory/Location_manager/confirm_all',
				method: 'POST',
				data: {tabledata:TableData},
				success: function(data) {
					//alert(data);
					location.reload(); 
				},
				error: function(err, message, xx) {
	
				}
			});
		}
 });	

$('.datemask').inputmask("9999-99-99");	
	
$('#example').dataTable( {
	"scrollY":        "350px",
	"scrollCollapse": true,
	"paging":         false
});

	function recount(row){
	
		var without_confirm = document.getElementById("confirmation_valide").checked;

		if(without_confirm==true){
				
					recount_process(row);
					document.getElementById('con_'+row).innerHTML="";
					document.getElementById('re_'+row).style='padding:2px';
					document.getElementById('re_'+row).innerHTML='<div style="background-color:#FF3;color:#000;font-weight:bold;"><i class="fa fa-fw fa-caret-right"></i></div>';
					
			

		}else{
			var r = confirm("Do You Really Want to Re-Count for this Location");
				if (r == true) {
					recount_process(row);
					document.getElementById('re_'+row).style='padding:2px';
					document.getElementById('re_'+row).innerHTML='<div style="background-color:#FF3;color:#000;font-weight:bold;"><i class="fa fa-fw fa-caret-right"></i></div>';				
					document.getElementById('con_'+row).innerHTML="";
				
					
				} 
		}
	
	}
  function recount_process(row_data){

		var res_split =  row_data.split('?');
		
		var count_id = res_split[0];
		var location_id = res_split[1];
		var sub_zone_id = res_split[2];
		var date = $('#ds').val();	
	
			$.ajax({
				url: '<?php echo base_url() ?>index.php/inventory/Location_manager/recount_result',
				method: 'POST',
				data: {location_id:location_id,count_id:count_id,sub_zone_id:sub_zone_id,date:date},
				success: function(data) {
					
					if(data=='msg'){
						alert("This location is already being counted");
					}else if(data=="0"){
						alert("Sorry you are not allowed to access this area of the system");	
					}
				},
				error: function(err, message, xx) {	}
			});

	}
	
	
	function confirm_count1(remtr){
		var without_confirm = document.getElementById("confirmation_valide").checked;
		
		if(without_confirm==true){
			
			confirmed_count(remtr);
				//alert($('#valide_confirm1').val());
			//return
			if($('#valide_confirm').val()!="false"){
				while((remtr.nodeName.toLowerCase())!='tr')
				remtr = remtr.parentNode;
				
				remtr.parentNode.removeChild(remtr);
			}
			
			
			
		}else{
			var r = confirm("Do You Really Want to Confirm This Count");
				if (r == true) {
				confirmed_count(remtr);
				
					if($('#valide_confirm').val()!="false"){
						while((remtr.nodeName.toLowerCase())!='tr')
						remtr = remtr.parentNode;
						
						remtr.parentNode.removeChild(remtr);
					}
				} 
		}		
	}

	function confirm_count(remtr){

	
		var without_confirm = document.getElementById("confirmation_valide").checked;
		
		var pid = $('#'+remtr.id).attr('pid');
		var location_id = $('#'+remtr.id).attr('location');	
		var count_id = 	$('#'+remtr.id).attr('count_id');
		var sub_zone_id = $('#'+remtr.id).attr('sub_zone_id');
		var date = $('#ds').val();	
		$('#valide_confirm').val("");
		var con_val = $(remtr).closest("tr").find("td:eq(12)").text();


			if(without_confirm==true){
			$.ajax({
				url: '<?php echo base_url() ?>index.php/inventory/Location_manager/result_confirmed',
				method: 'POST',
				data: {con_val:con_val,sub_zone_id:sub_zone_id,pid:pid,location_id:location_id,count_id:count_id,date:date},
				success: function(data) {
				
					if(data=="msg"){
						
						alert("Recount ongoing");
							
					}else if(data=='0'){
						alert("Sorry you are not allowed to access this area of the system");	
					}else{	
				
						while((remtr.nodeName.toLowerCase())!='tr')
							remtr = remtr.parentNode;
							remtr.parentNode.removeChild(remtr);	

					}
					
				},
				error: function(err, message, xx) {	}
			});	
				
			}else{
			var r = confirm("Do You Really Want to Confirm This Count");
				if (r == true) {
	
					$.ajax({
				url: '<?php echo base_url() ?>index.php/inventory/Location_manager/result_confirmed',
				method: 'POST',
				data: {con_val:con_val,sub_zone_id:sub_zone_id,pid:pid,location_id:location_id,count_id:count_id,date:date},
				success: function(data) {
				
					if(data=="msg"){
						
						alert("Recount ongoing");
							
					}else if(data=='0'){
						alert("Sorry you are not allowed to access this area of the system");	
					}else{	
				
						while((remtr.nodeName.toLowerCase())!='tr')
							remtr = remtr.parentNode;
							remtr.parentNode.removeChild(remtr);	

					}
					
				},
				error: function(err, message, xx) {	}
			});	
				
				} 
			}
	
				
	}
	
	
	$('#zones').change(function(e) {
	
		if($('#zones').val()>0){	
			window.location = '<?php echo base_url() ?>index.php/inventory/Location_manager/result?zone_id='+$('#zones').val()+'&ds='+$('#ds').val()+'';
		}
		
    });
	
	$('#filter').change(function(e) {
		
	 	var zone = $("#zones option:selected").text();
		var filter =$('#filter').val();
		var table = $('#example').DataTable();
		
		if(filter == 'Match'){
			$('#confirm_all').attr('style','display:block,width:150px');
		}else{
			
			$('#confirm_all').attr('style','width:150px;display:none');
		}
		
		
		if(zone!=""){
				table.search(zone+" "+filter).draw();	
			}else{
				table.search(filter).draw();
			}
			
		
    });
	$('td[name^="tc_"]').dblclick(function(){
	
		var pid = $(this).attr('pid');
		var location = $(this).attr('location');
		
		var table = $('#example').DataTable();
		if(pid!=""){
			
			table.search(pid).draw();
		}else{
		table.search(location).draw();
		}
		
	});


</script>
     