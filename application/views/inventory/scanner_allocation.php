<?php require_once('loader.php');
date_default_timezone_set("Asia/Colombo");
?>


<div class="content-wrapper">
  <section class="content ">
    <div class="box-body compact"> 
     <table align="right"><tr>
  <td style="font-weight:bold">Shortcuts  &rArr; &nbsp;&nbsp;&nbsp;</td> 
<td style="padding-right:20px"><a href="<?php echo base_url()?>index.php/inventory/dashboard/target_count?ds=<?php if($ds!=""){echo $ds; }?>" >Location Count</a></td>
  <td><a href="<?php echo base_url()?>index.php/inventory/dashboard/target_set_scanning_cleark?date=<?php if($ds!=""){echo $ds; }else{ echo $today; }?>" >Set Scanner</a></td>
 <td style="padding-left:20px"><a href="<?php echo base_url()?>index.php/inventory/location_manager/confirmed_result?ds=<?php echo $ds  ?>" >Confirmed Results</a></td>
 <td style="padding-left:20px"><a href="<?php echo base_url()?>index.php/inventory/location_manager/Result?ds=<?php echo $ds  ?>" >Counting Results</a></td>
  <td style="padding-left:20px"><a href="<?php echo base_url()?>index.php/inventory/Dashboard/ex_summary?ds=<?php echo $ds  ?>" >Executive Summary</a></td> 
 </tr></table>
    <h3>Scanner Distribution</h3>
    
    <table id="example" class="">
    	<thead>
        	<tr>
                <th  style="width:250px;text-align:center">EPF Number</th>
              
                <th  style="width:250px;text-align:center">Total location <br /> allocated to count </th>
                <th  style="width:250px;text-align:center">Total Counted</th>
               <!-- <th  style="width:100px;text-align:center">Total Time<br />( Min )</th>
                <th style="width:100px;text-align:center">Avg Per Location<br />(Min) </th> -->
                <th style="width:auto;text-align:left">Progress</th>
            </tr>
        </thead>
    	
        <tbody>
        	<?php foreach($scanner_allocation->result() as $rows ){?>
        	<tr>
                <td align="center"><?php echo  $rows->epf_number  ?></td>
               
                <td align="center"><?php echo  $rows->allocated_to_count  ?></td>
                <td align="center"><?php echo  $rows->total_counted   ?></td>
              <!--  <td align="center"><?php //echo  $rows->deferent  ?></td> -->
               <?php //$def='0.000'; if(number_format($rows->deferent / 1,3, '.', '') == "0.000"){
//							$def = "0.000";
//						}else{
//						$def  = number_format($rows->deferent / $rows->total_counted,3, '.', '');
//						} 
							
							?>
          		<!-- <td align="center"><?php //echo  $def ?></td> -->
               <?php  $pre = number_format( ($rows->total_counted /$rows->allocated_to_count ) *100,0, '.', '' ) ?>
                <td align="left"><?php 
					  if($pre == 100){ ?>
						<span class="badge bg-green" ><?php  echo $pre." %"?></span>
				<?php }else if($pre < 100 && $pre > 0){ ?>
                		<span class="badge bg-yellow" ><?php  echo $pre." %"?></span>
                <?php }else{ ?>
                
                		<span class="badge bg-red" ><?php  echo $pre." %"?></span>
                <?php  } ?>
				
				</td>
            </tr>
            
            <?php  } ?>
        </tbody>
    </table>
    <br />
       <table>
     
      <form method="GET">
      	<tr>
        	<td> <label>Date</label></td>
            <td style="padding-left:10px"><input value="<?php  echo $ds  ?>" type="text" id="ds" name="ds" class="form-control datemask"/></td>
            <td style="padding-left:10px"><input  type="submit" value="List" style="width:100px" class="btn  btn-facebook"/></td>
    		<td style="padding-left:10px"><input  type="button" id="export_to_excel" value="Export to Excel" style="width:130px" class="btn  btn-facebook"/></td>	
        </tr>
      </form>
      </table>
    </div>
  </section>
</div>

<script>
$('#export_to_excel').click(function(e) {
    window.location ="<?php echo base_url() ?>index.php/inventory/dashboard/download_Excel_team_distribution?ds="+$("#ds").val()+"";
});

$('.datemask').inputmask("9999-99-99");	

$('#example').dataTable( {
	"scrollY":        "350px",
	"scrollCollapse": true,
	"paging":         false
});

</script>