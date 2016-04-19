<?php require_once('loader.php');
date_default_timezone_set("Asia/Colombo");
?>

<div class="content-wrapper">
  <section class="content ">
    <div class="box-body compact">
    <table align="right"><tr>
     <td style="font-weight:bold">Shortcuts  &rArr; &nbsp;&nbsp;</td> 
      <td style="padding-left:20px;"><a href="<?php echo base_url()?>index.php/inventory/location_manager/Result?ds=<?php echo $ds  ?>" >Counting Results</a></td>
     <td style="padding-left:20px"><a href="<?php echo base_url()?>index.php/inventory/dashboard/target_set_scanning_cleark?date=<?php if($ds!=""){echo $ds; }?>" >Set count order</a></td>
<td style="padding-left:20px"><a href="<?php echo base_url()?>index.php/inventory/dashboard/target_count?ds=<?php if($ds!=""){echo $ds; }?>" >Location Count</a></td> 
 <td style="padding-left:20px"><a href="<?php echo base_url()?>index.php/inventory/Dashboard/ex_summary?ds=<?php echo $ds  ?>" >Executive Summary</a></td> 
      </tr></table>
 <br />
      <div class="col-md-6">
               
      <h4>Confirmed results for <?php  echo $ds  ?>	</h4></div>  
     
      <div class="md-6" style="text-align:right">
      <input name="confirmation_valide" id="confirmation_valide" type="checkbox" value="">
      <label style="padding-left:20px">Undo-Confirmation without confirmation alert</label>  
      </div>
      
      <table class="example"  id="example">
      	<thead >
        	<tr>
           	  
            	<th>Zone</th>
                 <th style="display:none"></th>
                <th>S Z G</th>
                <th>Sub Zone</th>
                <th>Location</th>
                <th style="width:100px">Product ID</th>
                <th style="width:350px">Description</th>
                <th style="width:100px;text-align:center">Quantity Confirmed</th>
                
                <th style="width:85px;text-align:center">Inventory Qty</th>
             <?php  for($i=1;$x=6>$i;$i++){ ?>
                <th style="width:50px;text-align:center"><?php echo $i; ?></th>
              <?php   } ?>

               <th style="width:25px;text-align:center"></th> 

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
              
            	<td><?php echo $rows->zone  ?></td>
                 <td style="display:none"> <?php  if($crl=="style='color:green;font-weight:bold'"){ echo "OK";}else{ echo "NO"; } ?>     </td>
                <td><?php echo $rows->sub_zone_group  ?></td>
                <td><?php echo $rows->sub_zone  ?></td>
                <td><?php echo $rows->location  ?></td>
                <td><?php echo $rows->product_id  ?></td>
                <td><?php echo $rows->description  ?></td>
                <td style="text-align:center"><?php echo $rows->quantity_confirmed  ?></td>
                <td style="text-align:center"><?php if($rows->inventory_quantity==""){ echo  '0';}else{ echo $rows->inventory_quantity ; } ?></td>
                <td style="text-align:center"><?php echo $rows->count_1  ?></td>
                <td style="text-align:center"><?php echo $rows->count_2  ?></td>
                <td style="text-align:center"><?php echo $rows->count_3  ?></td>
                <td style="text-align:center"><?php echo $rows->count_4  ?></td>
                <td style="text-align:center"><?php echo $rows->count_5  ?></td>

                 <td style="text-align:center"><a title="Undo Confirmation" href="#" id="<?php echo $rows->location_id."?".$rows->product_id."?".$rows->sub_zone_id  ?>"  count_id="<?php echo $rows->count_id  ?>"  onClick="undo_confirmation(this)"><i class="fa fa-fw fa-rotate-left"></i></a></td> 

            </tr>
        <?php }  ?>
        </tbody>
      
      </table>
      <br>
       <div class="col-md-8" >
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
                <td>&nbsp;&nbsp;&nbsp;</td>
                <td>
                <input type="button" value="Export to Excel" id="write_to_excel"  class="btn  btn-facebook"/>
                </td>
                 <td>&nbsp;&nbsp;&nbsp;</td>
                 <td>
                <input type="button" value="Export to Excel (PID)" id="write_to_excel_pid"  class="btn  btn-facebook"/>
                </td>
        </tr>
      </form>
      </table>
      </div> 
      <br /> 
      
     </div>
  </section>
</div>

<script>
	$('.datemask').inputmask("9999-99-99");	


	$("#write_to_excel").click(function () {
window.location ="<?php echo base_url() ?>index.php/inventory/Location_manager/download_Excel_result?ds="+$("#ds").val()+"";

	 });   
	 
	 $("#write_to_excel_pid").click(function () {
window.location ="<?php echo base_url() ?>index.php/inventory/Location_manager/download_Excel_result_pid?ds="+$("#ds").val()+"";

	 });   

$('#example').dataTable( {
	"scrollY":        "350px",
	"scrollCollapse": true,
	"paging":         false
});

	function undo_confirmation(data_packge){

		
		var without_confirm = document.getElementById("confirmation_valide").checked;
			
			if(without_confirm==true){
				
				//undo_confirmation_process(data_packge.id);
				var values = data_packge.id;
						var res_split =  values.split('?');
		
		var location_id = res_split[0];
		var product_id = res_split[1];
		var sub_zone_id = res_split[2];
		var date = $('#ds').val();		
	
			$.ajax({
				url: '<?php echo base_url() ?>index.php/inventory/Location_manager/undo_recount_result',
				method: 'POST',
				data: {location_id:location_id,product_id:product_id,sub_zone_id:sub_zone_id,date:date},
				success: function(data) {
						if(data!=""){
							alert(data);
						}else{
						while((data_packge.nodeName.toLowerCase())!='tr')
						data_packge = data_packge.parentNode;
						
						data_packge.parentNode.removeChild(data_packge);
				
						}
				},
				error: function(err, message, xx) {	}
			});
	
			}else{
				var r = confirm("Do You Really Want to undo confirmed record");
					if (r == true) {
						//undo_confirmation_process(data_packge.id);
						
						var values = data_packge.id;
						var res_split =  values.split('?');
		
		var location_id = res_split[0];
		var product_id = res_split[1];
		var sub_zone_id = res_split[2];
		var date = $('#ds').val();		
	
			$.ajax({
				url: '<?php echo base_url() ?>index.php/inventory/Location_manager/undo_recount_result',
				method: 'POST',
				data: {location_id:location_id,product_id:product_id,sub_zone_id:sub_zone_id,date:date},
				success: function(data) {
						if(data!=""){
							alert(data);
						}else{
						while((data_packge.nodeName.toLowerCase())!='tr')
						data_packge = data_packge.parentNode;
						
						data_packge.parentNode.removeChild(data_packge);
				
						}
				},
				error: function(err, message, xx) {	}
			});
				
					} 
			}		
	}
	
	
	$('#zones').change(function(e) {
	 	if($('#zones').val()>0){	
			window.location = '<?php echo base_url() ?>index.php/inventory/Location_manager/confirmed_result?zone_id='+$('#zones').val()+'&ds='+$('#ds').val()+'';
		}
    });
</script>
  <style>
.example tr:hover {
          background-color: #ffff99;
		  font-size:14px;
		  cursor:pointer
        }
</style>  