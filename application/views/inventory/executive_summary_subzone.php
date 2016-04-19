<?php require_once('loader.php');
date_default_timezone_set("Asia/Colombo");
?>


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
 
     <table>
       <form id="form_submit" method="GET">
      	<tr>
        	<td> <label>Date</label></td>
            <td style="padding-left:10px"><input value="<?php  echo $ds  ?>" type="text" id="ds" name="ds" class="form-control datemask"/></td>
           
            
            <td style="padding-left:10px"></td>
           
                 <td style="padding-left:10px"><input id="sub" type="submit" value="List" style="width:100px" class="btn  btn-facebook"/>
                 
                 </td>
        </tr>
      </form>
      </table>
    <table>
    
    	<?php  foreach($zone_list->result() as $zones){  ?>
      
    	<tr>
        	
            <td >
            	<h3><?php echo $zones->zone ?></h3>
                
                <?php  foreach($sub_zone_group_list->result() as $szgl){  ?>
                
                	<?php	if($zones->zone_id == $szgl->zone_id){ //$sub_zone_g_id=$szgl->sub_zone_id;?>
                    <div style="padding-left:10px;float:left">
                    <div style="text-align:center"> <?php echo $szgl->sub_zone_group ?></div> 
            	<div style="border:1px solid #000;width:50px;height:auto;" >
                
                		
                        
                		<?php  foreach($sub_zone_list->result() as $szl){  ?>
                       
                       
                         <?php if($szl->zone_id == $szgl->zone_id && $szl->sub_zone_group_id == $szgl->sub_zone_group_id ){ ?>
                        		<?php 
								$titel= $szl->sub_zone ?>
							
								                	<div style="background-color:<?php echo $szl->status_id?>;width:50px;height:25px;border:1px solid #000;padding-left:10px;float:left;color:#FFFFFF"  title="<?php  echo $titel ?>"><?php echo $szl->scanner_epf ?></div> 
                       
                <?php  } ?>
                
                <?php  } ?>
                		
                
                </div>
                </div>
                 <?php  } ?>
            <?php  } ?>
            </td>
        
        </tr>	
      
    <?php  } ?>
    </table>	
    
    
    </div>
  </section>
</div>

<script>

$('.datemask').inputmask("9999-99-99");	

</script>