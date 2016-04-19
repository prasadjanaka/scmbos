<div class="content-wrapper">
  <section class="content ">
    <div class="box-body compact"> 
    <div class="col-md-06">
    <table class=""  style="width:100%">

    	<?php  
		$ref_val ="";$pid_tot="";$tot_qty="";$epf_number="";$location_to_count="";$counted_location="";
		foreach( $ref->result()  as $row ){ 
        $ref_val =$row->reference;
        $pid_tot=$row->pid_counted ;
		$epf_number=$row->epf_number;
		$location_to_count=$row->locations_to_count;
		$counted_location=$row->counted_locations;
        $tot_qty=$row->qty_counted;
         } ?>
    	<tr>
        	<td style="width:200px;font-weight:bold;padding-bottom:10px">Date :&nbsp;&nbsp; &nbsp;  <?php  echo $ds ?></td>
            <td style="width:200px;font-weight:bold;padding-bottom:10px">Site : &nbsp;&nbsp; &nbsp; <?php  echo "Global Park Logistics (pvt) Ltd" ?></td>
        </tr>
        <tr>
            <td style="width:200px;font-weight:bold;padding-bottom:10px">Count no:&nbsp;&nbsp; &nbsp; <?php  echo $ref_val ?></td>
           	<td style="width:200px;font-weight:bold;padding-bottom:10px">Team Number :&nbsp;&nbsp; &nbsp; <?php  echo $epf_number ?></td>
        </tr>
       
         <tr>
        	<td style="width:200px;font-weight:bold;padding-bottom:10px">Total PIDS :&nbsp;&nbsp; &nbsp; <?php  echo $pid_tot ?></td>
            
            <td style="width:200px;font-weight:bold;padding-bottom:10px">Total Qty :&nbsp;&nbsp; &nbsp; <?php  echo $tot_qty ?></td>
            <td style="width:200px;font-weight:bold;padding-bottom:10px">Counted Location :&nbsp;&nbsp; &nbsp; <?php  echo $counted_location ?></td>
            <td style="width:200px;font-weight:bold;padding-bottom:10px">Location to Count :&nbsp;&nbsp; &nbsp; <?php  echo $location_to_count ?></td>
           
        </tr>
    
    </table >
    
        <table style="" id="example">
        <thead>
        	<tr style="background-color:#FF3">
           		<th style="width:100px;text-align:center">Remove</th>
            	<th style="width:150px">Location</th>
                <th style="width:150px">PID</th>
                <th style="width:400px">Description</th>
                <th style="width:100px;text-align:center">Inventory Qty</th>
                <th style="width:100px;text-align:center">Counted Qty</th>
                <th style="">Remarks</th>
            </tr>
         					
   
        </thead>
   
    <?php  foreach($ref_details->result() as $rows_details){ ?>
    	<tr>
        	<?php if($rows_details->is_counted==2){?>
        	<td style="text-align:center"><a onclick="remove_recode(this.id)" id="<?php echo $rows_details->count_detail_id  ?>" href="#" ><span class="glyphicon glyphicon-remove"></span> </a></td>
            <?php }else{?>
            <td>&nbsp;</td>
			<?php }?>            
            <td><?php  echo $rows_details->location ?></td>
            <td><?php  echo $rows_details->product_id ?></td>
              <td><?php  echo $rows_details->description ?></td>
                <td style="text-align:center"><?php  echo $rows_details->qty_inventory ?></td>
            <td style="text-align:center"><?php  echo $rows_details->qty_counted ?></td>
            <td><?php   ?></td>
           
        </tr>
       
        
        <?php  } ?>
    </table>
    <table>
    	<tr>
        	<td><input type="button" value="Export to Excel" id="write_to_excel"  class="btn  btn-facebook"/></td>
            <td style="width:20px"></td>
            <td><input type="button" value="Reference Distribution Manager" id="ref_distribution_manager"  class="btn  btn-facebook"/></td>
        </tr>
    </table>
   

</div>

    </div>
  </section>
</div>

<script>
http://localhost/scmbos/index.php/inventory/dashboard/ref_distribution

	$('#ref_distribution_manager').click(function(e) {
      	window.location ="<?php echo base_url() ?>index.php/inventory/dashboard/ref_distribution?ds=<?php echo $ds ?>";  
    });

	function remove_recode(count_detail_id){
	 
	   var r = confirm("Are you sure that you want to remvoe this result");
        if (r == true) {
	  $.ajax({
				url: '<?php echo base_url() ?>index.php/inventory/dashboard/remove_recode_count_details',
				method: 'POST',
				data: {count_detail_id:count_detail_id},
				success: function(data) {
					
					if(data!=""){
					alert(data);
					}else{
					location.reload(); 
					}
				},
				error: function(err, message, xx) {
	
				}
			});	
		}
	} 
$('#example').dataTable( {
	"scrollY":        "320px",
	"scrollCollapse": true,
	"paging":         false
});

$("#write_to_excel").click(function () {
	
	
	window.location ="<?php echo base_url() ?>index.php/inventory/dashboard/download_ref_detiails?ds=<?php echo $ds ?>&ref=<?php echo $ref_val ?>&pid_tot=<?php echo $pid_tot ?>&tot_qty=<?php echo $tot_qty ?>&epf_number=<?php echo $epf_number ?>&location_to_count=<?php  echo $location_to_count ?>&counted_location=<?php  echo $counted_location ?>";


	 });   
</script>