<?php require_once('loader.php');
date_default_timezone_set("Asia/Colombo");
?>


<div class="content-wrapper">
  <section class="content ">
    <div class="box-body compact"> 
    <input type="button" value="Stop Auto Reload" id="auto_reload"/>
    <table align="right"><tr>
  <td style="font-weight:bold">Shortcuts  &rArr; &nbsp;&nbsp;&nbsp;</td> <td><a href="<?php echo base_url()?>index.php/inventory/dashboard/target_set_scanning_cleark?date=<?php if($ds!=""){echo $ds; }else{ echo $today; }?>" >Set count order</a></td>
  <td style="padding-left:20px"><a href="<?php echo base_url()?>index.php/inventory/dashboard/target_count?ds=<?php if($ds!=""){echo $ds; }?>" >Location Count</a></td>
 <td style="padding-left:20px"><a href="<?php echo base_url()?>index.php/inventory/location_manager/confirmed_result?ds=<?php echo $ds  ?>" >Confirmed Results</a></td>
 <td style="padding-left:20px"><a href="<?php echo base_url()?>index.php/inventory/location_manager/Result?ds=<?php echo $ds  ?>" >Counting Results</a></td>
 </tr></table>
    		<h3>Executive summary for <?php  echo $zone_name ?> on <?php  echo $ds ?></h3>
            <div style="padding-bottom:20px" class="col-md-12">
             
             
             		<?php $confirm_location_count=0; $finished_location_count=0;$total_location_count=$location_list->num_rows(); $location_set_count=0; ?>
                  
             
                    <?php  foreach($location_list->result() as $rows ){  
							$titel=$rows->sub_zone." - ".$rows->location;
							$clr="";
					?>
                    				<?php if($rows -> is_counted == '2' && $rows -> user_id_confirmed >0){ $confirm_location_count++;$location_set_count++;?>
                               <?php  $clr="#006600" ?>		
                               
                    			<?php }else if($rows -> is_counted == '2'){ $finished_location_count++;$location_set_count++;?>
                               <?php  $clr="#00F" ?>		

                    			<?php }else if($rows -> is_counted == '1'){ $location_set_count++;?>
                                 <?php  $clr="#CC66CC" ?>		
 
                    <?php }else if($rows -> is_counted == '0'){ ?>
                            	  <?php if($rows -> status_id == '1'){ $location_set_count++;?>
                                   <?php  $clr="#FFCC00" ?>		  

                    				 <?php  }else if($rows -> status_id == '2'){$location_set_count++; ?> 
                                      <?php  $clr="#666633" ?>	

                     				<?php  }else if($rows -> status_id == '3'){ $location_set_count++;?> 
                                     <?php  $clr="#CC66CC" ?>	

                     				<?php  }else if($rows -> status_id == '4'){ $location_set_count++;$finished_location_count++;?>
                                     <?php  $clr="#0066FF" ?>	 

                     				<?php  }else if($rows -> status_id == '5'){ $location_set_count++;$finished_location_count++;?> 
                                    <?php  $clr="#006600" ?>	 

                     				<?php  } ?>  
                                    
                    
                    			<?php  }else if($rows -> is_counted == "" && $rows -> status_id=='4'){ $location_set_count++;?>
                                 <?php  $clr="red" ?>	
                                 	 <?php	}else{ ?>
                                 <?php  $clr="" ?>	
                      
                                 <?php  } ?> 
                                <div style="background-color:<?php echo $clr ?>;width:15px;height:15px;border:1px solid #000;padding-left:10px;float:left"  title="<?php echo $titel ?>"></div>  
                   <?php  } ?> 
                  
        	
    		</div>
        <div>
<br />
        
        <table>
            <tr>
                <td style=""><strong>Total locations </strong></td>
                 <td style="width:10px"><strong>:</strong></td>
                <td style=""><strong><?php  echo $total_location_count; ?></strong></td>
         		 <td style="width:30px"></td>
                  <td style=""><strong>Selected location for count</strong></td>
                 <td style="width:10px"><strong>:</strong></td>
                <td style=""><strong><?php  echo $location_set_count ;?></strong></td>
         		 <td style="width:30px"></td>
                <td style=""><strong>Counted Locations</strong></td>
                 <td style="width:10px"><strong>:</strong></td>
                <td style=""><strong><?php  echo $finished_location_count; ?></strong></td>
                 <td style="width:30px"></td>
                   <td style=""><strong>Confirm results count</strong></td>
                 <td style="width:10px"><strong>:</strong></td>
                <td style=""><strong><?php  echo $confirm_location_count; ?></strong></td>
                 <td style="width:30px"></td>
                 <td style=""><strong>Progress</strong></td>
                  <td style="width:10px"><strong>:</strong></td>
                  <?php $tot =  $location_set_count ;
				  		if($tot==0){
							$tot=1;;
						}
				  ?>
                <td style=""><strong><?php  echo number_format(($confirm_location_count + $finished_location_count) * 100 / ($tot) , 2, '.', ''); ?>%</strong></td>
            </tr>
        </table>
        
        </div>
        <br />
          <div  class="md-8" >
          
          <table>
     	<tr>
        	
            <td style="background-color:#FFCC00">Assigned to Zone 	</td>
            <td style="width:10px"></td>
            <td style="background-color:#666633">Scanner Assigned</td>
            <td style="width:10px"></td>
            <td style="background-color:#CC66CC">Counting Started</td>
            <td style="width:10px"></td>
            <td style="background-color:#00F">Counting finished</td>
            <td style="width:10px"></td>
            <td style="background-color:#006600">Result Recieved</td>
             <td style="width:10px"></td>
            <td style="background-color:red">Empty Location</td>
        </tr>
     </table>
     </div>
     <br />
        <div class="md-8" >
     <table>
       <form id="form_submit" method="GET">
      	<tr>
        	<td> <label>Date</label></td>
            <td style="padding-left:10px"><input value="<?php  echo $ds  ?>" type="text" id="ds" name="ds" class="form-control datemask"/></td>
           
            
            <td style="padding-left:10px">Zone</td>
            <td style="padding-left:10px"> <select class="form-control" style="width:200px" id="zones" name="zones">
                	<option selected="selected" value=""></option>	    
                    <?php foreach($zone_list->result() as $zls){ ?> 
                    	<?php $selected = "";if($zone_id == $zls->zone_id){$selected = "selected";}  ?>                                  
                    	<option <?php echo $selected ?> value="<?php echo $zls->zone_id ?>"> <?php  echo $zls->zone ?> </option>
                    	
                    <?php  } ?>
                </select></td>
                 <td style="padding-left:10px"><input id="sub" type="button" value="List" style="width:100px" class="btn  btn-facebook"/>
                 	<input type="text" id="zone_name" name="zone_name" hidden=""/>
                 </td>
        </tr>
      </form>
      </table>
      </div>	
    </div>
  </section>
</div>

<script>
 var timer;
  timer = setTimeout(func, 30000);  

  function func() {
		 location.reload(1); 
	  }
	$('#auto_reload').click(function(e) {
		clearInterval(timer)
		
    });
	

	$('#zones').change(function(e) {
       var zone_text = $('#zones option:selected').text();
	   $('#zone_name').val(zone_text);
    });
	$('#sub').click(function(e) {
       var zone_text = $('#zones option:selected').text();
	   $('#zone_name').val(zone_text);
	   $('#form_submit').submit();
	   
    });	
$('.datemask').inputmask("9999-99-99");	
</script>