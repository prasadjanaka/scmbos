<?php require_once('loader.php');
date_default_timezone_set("Asia/Colombo");
?>

<div class="content-wrapper">
  <section class="content ">
    <div class="box-body compact">
      <section class="invoice"> 
        <!-- title row -->
        <div class="row">
          
          <div class="col-xs-12">
         <!-- <div align="right">	
          		<a style="padding-right:20px" href="<?php echo base_url()?>index.php/lp/Lp/lp_list" >Available LPs</a>
                <a style="padding-right:20px" href="<?php echo base_url()?>index.php/lp/Lp/lp_schedule">Scheduled LPs</a>
                <a  style="padding-right:20px" href="<?php echo base_url()?>index.php/lp/Lp/pick_loading_lps" >Pick & Loading</a>
                <a href="<?php echo base_url()?>index.php/lp/Lp/lp_loading" >Loading Set</a> 
  		
        </div>-->
            <?php  foreach($shuttle_details->result() as $shuttles){ ?>
           <h3><?php  echo "Shuttle-Number:-".$shuttles->shuttle_number  ?></h3>
           <br /> 
           <h4><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Header Information</b></h4>
            <div class="col-xs-6">
             <table class="table">
            	<tr>
                <td ><b>Shuttle # :</b></td>
                <td style="font-size:16px"><?php  echo $shuttles->shuttle_number  ?></td>
                </tr>
                <tr>
                <td ><b>Country :</b></td>
                <td style="font-size:16px"><?php  //echo $lp_viwes->country  ?></td>
                </tr>
                <tr>
                <td ><b>Destination :</b></td>
                <td style="font-size:16px"><?php  echo $shuttles->destination  ?></td>
                </tr>
            </table>
            </div>
            
            <div class="col-xs-6">
             <table class="table">
                <tr>
                  <td><b>Container Number :</b></td>
                  <td style="font-size:16px"><?php echo $shuttles->container_number;  ?></td>
                </tr>
                <tr>
                <td><b>Vehicle Number :</b></td>
                <td style="font-size:16px"><?php  echo $shuttles->vehicle_number;   ?></td>
                </tr>
                <tr>
                <td><b>Date Scheduled :</b></td>
                <td style="font-size:16px"s><?php echo $shuttles->schedule_date?></td>
                </tr>
            </table>
            <?php } ?>
            </div>
           <h4><b>&nbsp;&nbsp;More Details</b></h4>
            <table class="table">
            	<thead>
                	<tr>
                    	<th>Product ID</th>
                        <th>Description</th>
                        <th>Qty</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
            
            	<tbody>
                	<?php $total_qty=0; 
						  $total_pids=0;
						 foreach($shuttle_product_details->result() as $shuttle_products){
						  	$total_qty=$total_qty+$shuttle_products->qty;	
							$total_pids++;
						?>
                	<tr>
                    	<td><?php echo $shuttle_products->product_id ?></td>
                        <td><?php echo $shuttle_products->description ?> </td>
                        <td><?php echo $shuttle_products->qty ?></td>
                    
                    </tr>
                    <?php } ?>
                    <tr>
                    	<td colspan="2"><div align="right"><span style="text-align:left"> Total Qty</span></div></td>
                        <td colspan="">
                        	
                           <div style="text-align:left"> <label style="font-size:16px"><?php  echo	$total_qty ?></label>
                           </div>
                           
                             </td> 
                       
                          <td colspan=""> 
                           <div style="text-align:left">(<label style="font-size:16px">
                             <?php  echo	$total_pids?></label>
                            PIDS)</div>
                        </td>
                     
                    </tr>
                </tbody>
            </table>
                 
          <div class="col-xs-12">
            <p class="lead"  data-toggle="collapse" data-target="#action_history" style="cursor:pointer"><strong>Action 

History</strong><span class="lead" style="cursor:pointer"></span></p>
                 <div class="table-responsive collapse" id="action_history">
                  <table class="table table-striped">
                    <tbody>
                      <tr>
                        <th>Date Time</th>
                        <th>Action</th>
                        <th>Changed to</th>
                        <th>By</th>
                      </tr>
                      <?php foreach($shuttle_history->result() as $hist){?>
                      <tr>
                        <td><?php echo $hist->datetime?></td>
                        <td><?php echo $hist->status?></td>
                        <td><?php echo $hist->text?></td>
                        <td><?php echo $hist->username?></td>
                      </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
           </div>
          <!-- /.col --> 
  
		 </div>
	   </div>
	 </section>
    </div>
 </section>
</div>