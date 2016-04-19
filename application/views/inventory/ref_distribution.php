<div class="content-wrapper">
  <section class="content ">
    <div class="box-body compact"> 
     <table align="right"><tr>
  <td style="font-weight:bold">Shortcuts  &rArr; &nbsp;&nbsp;&nbsp;</td> 
<td style="padding-right:20px"><a href="<?php echo base_url()?>index.php/inventory/dashboard/target_count?ds=<?php if($ds!=""){echo $ds; }?>" >Location Count</a></td>
  <td><a href="<?php echo base_url()?>index.php/inventory/dashboard/target_set_scanning_cleark?date=<?php if($ds!=""){echo $ds; }else{ echo $today; }?>" >Set count order</a></td>
 <td style="padding-left:20px"><a href="<?php echo base_url()?>index.php/inventory/location_manager/confirmed_result?ds=<?php echo $ds  ?>" >Confirmed Results</a></td>
 <td style="padding-left:20px"><a href="<?php echo base_url()?>index.php/inventory/location_manager/Result?ds=<?php echo $ds  ?>" >Counting Results</a></td>
  <td style="padding-left:20px"><a href="<?php echo base_url()?>index.php/inventory/Dashboard/ex_summary?ds=<?php echo $ds  ?>" >Executive Summary</a></td> 
 </tr></table>
    <h3>Reference Distribution</h3>
    <table class="example" id="example">
    	<thead>
        	<tr>
            	<th style="width:150px">Ref</th>
                <th style="width:100px">Scanner</th>
               
                <th align="center" style="width:150px;text-align:center">Location to Count</th>
                <th align="center" style="width:150px;text-align:center">Counted location</th>
                <th align="center" style="width:150px;text-align:center">Progress</th>
                <th align="center" style="width:100px;text-align:center">Count #</th>
                <th align="center" style="width:100px;text-align:center">PID</th>
                <th>Total Qty</th>
                
            </tr>
        </thead>
       
        <tbody>
        <?php  foreach($ref->result() as $row){ ?>
        	<tr> 
			<?php  $pre = number_format( ($row->counted_locations /$row->locations_to_count ) *100,0, '.', '' ) ?>
            	
                <td><a onclick="ref_details(this.id)" pid_tot="<?php echo $row->pid_counted ?>" tot_qty="<?php echo $row->qty_counted ?>" href="#"  id="<?php echo $row->reference."&".$row->epf_number."&".$row->pid_counted."&".$row->qty_counted."&".$row->counted_locations."&".$row->locations_to_count ?>" ><?php echo $row->reference ?></a></td>
                
                <td><a onclick="ref_details(this.id)" href="#" id="<?php echo $row->reference."&".$row->epf_number."&".$row->pid_counted."&".$row->qty_counted."&".$row->counted_locations."&".$row->locations_to_count ?>" ><?php echo $row->epf_number ?></a></td>
                
               
                <td style="width:150px;text-align:center"><?php echo $row->locations_to_count ?></td>
                <td style="width:150px;text-align:center"><?php echo $row->counted_locations ?></td>
                
                <td style="width:150px;text-align:center"><?php 
					  if($pre == 100){ ?>
						<span class="badge bg-green" ><?php  echo $pre." %"?></span>
				<?php }else if($pre < 100 && $pre > 0){ ?>
                		<span class="badge bg-yellow" ><?php  echo $pre." %"?></span>
                <?php }else{ ?>
                
                		<span class="badge bg-red" ><?php  echo $pre." %"?></span>
                <?php  } ?>
				
				</td>
               
                <td style="width:150px;text-align:center"><?php echo $row->count_number ?></td>
                <td style="width:150px;text-align:center"><?php echo $row->pid_counted ?></td>
                <td><?php echo $row->qty_counted ?></td>
            </tr> 
            
            <?php  } ?>
        </tbody>	
    
    </table>
    
	 <table>
     <br>
      <form method="GET">
      	<tr>
        	<td> <label>Date</label></td>
            <td style="padding-left:10px"><input value="<?php  echo $ds  ?>" type="text" id="ds" name="ds" class="form-control datemask"/></td>
            <td style="padding-left:10px"><input  type="submit" value="List" style="width:100px" class="btn  btn-facebook"/></td> 
            
            <td style="padding-left:25px"> <input type="button" value="Export to Excel" id="write_to_excel"  class="btn  btn-facebook"/></td>
        </tr>
      </form>
      </table>    
    
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

function ref_details(count_id){
	
	var res = count_id.split("&");
	
	var ref = res[0];
	var epf_number = res[1];
	

	var location = "<?php echo base_url() ?>index.php/inventory/dashboard/ref_details?ref="+ref+"&ds="+$("#ds").val()+"&epf_number="+epf_number+"";
	window.open(location,'_self');
}
$("#write_to_excel").click(function () {
window.location ="<?php echo base_url() ?>index.php/inventory/dashboard/ref_distribution_Excel?ds=<?php echo $ds  ?>";

	 });   


$('.datemask').inputmask("9999-99-99");	
	
$('#example').dataTable( {
	"scrollY":        "350px",
	"scrollCollapse": true,
	"paging":         false
});

</script>