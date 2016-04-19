<?php
date_default_timezone_set("Asia/Colombo");
?>

<div class="content-wrapper ">
  <section class="content">
    <div class="box-body compact  invoice ">
      <?php  foreach($pick_list->result() as $row ){ ?>
     <div style="background-color:#999999;font-size:16px;font-weight:bold;padding-top:5px;padding-bottom:5px">Pick Number :<?php echo $row->pick_number?></div>
 
      <table id="example" class="table">
        	
            <tbody>
          
                <tr style="padding-bottom:5px">
                    <td style="font-weight:bold">Create By :</td>
                    <td style="padding-left:15px"><?php echo $row->epf_number  ?></td>              
                    <td style="width:50px">&nbsp;</td>
                    <td style="font-weight:bold">Create Date Time :</td>
                    
                    <td style="padding-left:15px"><?php echo $row->date_time?></td>
                    <td style="padding-left:15px;font-weight:bold;font-size:34px" rowspan="3"><?php if($zone!='Full Report'){ echo $zone; } ?></td>
                </tr>
                <tr  style="padding-bottom:5px">  
                	 <td style="font-weight:bold;">Priority :</td>
                    <td style="padding-left:15px"><?php echo $row->priority  ?></td>
                     <td style="width:50px">&nbsp;</td>
                     <td style="font-weight:bold">Status :</td>
                    <td style="padding-left:15px"><?php echo $row->status  ?></td>
               	   </tr>
 
                    <tr  style="padding-bottom:5px">   
                   <td style="font-weight:bold">Reference :</td>
                     <td style="padding-left:15px"><?php echo $row->reference_type  ?></td> 
                   
                     <td style="width:50px">&nbsp;</td>
                    
                     </tr>    
                   
                     
            <?php  } ?>         
                </tr>
            </tbody>
        </table>
         <hr>
    <br>
    <div style="background-color:#999999;font-size:16px;font-weight:bold;padding-top:5px;padding-bottom:5px">Pick Details</div>
    
     <table id="example" class="table table-striped">
           	   <thead>
              		<tr>
                   		
                    	<th style="text-align:center;background-color:#CCC;width:150px;height:40px;font-size:14px" align="center">Location</th>
                        <th style="text-align:center;background-color:#CCC;width:150px;height:40px;font-size:14px" align="left">Product ID</th>
                        <th style="text-align:center;background-color:#CCC;width:150px;height:40px;font-size:14px" align="left">Pallete Code</th>
                        <th style="text-align:center;background-color:#CCC;width:100px;height:40px;font-size:14px" align="center">Qty to Pick</th>
                        <th style="text-align:center;background-color:#CCC;width:100px;height:40px;font-size:14px" align="center">Qty Picked</th>
                        <th style="text-align:center;background-color:#CCC;width:100px;height:40px;font-size:14px" align="center">Status</th>
                        <th style="text-align:center;background-color:#CCC;width:50px;height:40px;font-size:14px" align="center">Sort Order</th>
                    </tr>  
        </thead>
              
              <tbody>
              <?php   foreach ($pick_details->result() as $details_row ){ ?>
              		<tr>
                    	
                    	<td align="center"><?php echo $details_row->location ?></td>
                        <td ><?php echo $details_row->pid ?></td>
                        <td ><?php echo $details_row->pallect_code ?></td>
                        <td align="center"><?php echo $details_row->qty_pick ?></td>
                        <td align="center"><?php $qty_picked=0;if($qty_picked!=0){ echo $qty_picked;  }?></td>
                         <?php $tot =  $qty_picked / $details_row->qty_pick * 100  ?>
                       
                        <td align="center"><?php if($tot!=0){ echo number_format($tot, 0, '.', ',')."%";}?></td>
                       
                        <td align="center"> <?php echo $details_row->sort_order ?></td>
                    
                    </tr>
                    <?php  } ?>
              </tbody>
      </table>
    
    
    
    
    </div>
  </section>
</div>

