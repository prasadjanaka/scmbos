<?php require_once('loader.php');
date_default_timezone_set("Asia/Colombo");
?>

<div class="content-wrapper ">
  <section class="content">
    <div class="box-body compact  invoice ">       
      <div class="row">
          <div class="col-xs-12 table-responsive">
           <p class="lead"   data-toggle="collapse" data-target="#vehicle_info" style="cursor:pointer"><strong></strong></p>
              <div id="vehicle_info" class="collapse in">
              
              
              <table id="example" class="table">
        	
            <tbody>
            <?php  foreach($job_list->result() as $row ){ ?>
                <tr>
                	<td style="font-size:16px;font-weight:bold">Job Number :</td>
                    <td style="font-size:14px;"><?php echo $row->job_id?></td>
                     <td style="width:100px">&nbsp;</td>
                    <td style="font-size:16px;font-weight:bold">Create Date Time :</td>
                    <td style="font-size:14px;"><?php echo $row->datetime?></td>
                   
                </tr>
                <tr>  
                	<td style="font-size:16px;font-weight:bold">Create By :</td>
                    <td style="font-size:14px;"><?php echo $row->epf_number  ?></td>
                     <td style="width:100px">&nbsp;</td>
                     <td style="font-size:16px;font-weight:bold">Status :</td>
                    <td style="font-size:14px;"><?php echo $row->status  ?></td>
                   </tr>
 
                    <tr>  
                   
                    <td style="font-size:16px;font-weight:bold">Priority :</td>
                    <td style="font-size:14px;"><?php echo $row->priority  ?></td>
                     <td style="width:100px">&nbsp;</td>
                    <td style="font-size:16px;font-weight:bold">Reference :</td>
                     <td style="font-size:14px;"><?php echo $row->reference_type?>&nbsp; / &nbsp;<?php echo $row->reference_number?></td>
                     </tr>    
                     
                     <tr>  
                   
                    <td style="font-size:16px;font-weight:bold">Job Type :</td>
                    <td style="font-size:14px;"><?php echo $row->job_type  ?></td>
                    
                     </tr>    
                   
                     
            <?php  } ?>         
                </tr>
            </tbody>
        </table>
      
              
              </div>
            </div>
          </div>     
      <hr />
         <div class="row">
          <div class="col-xs-12 table-responsive">
           <p class="lead"  data-toggle="" data-target="" style="cursor:pointer"><strong> Job Details</strong></p>
              <div id="pick_details" class="">
              
              <table style="width:100%" border="0"  class="table">
              		
                  <tr>
                  	<th>Product ID</th>
                     <td style="width:5px"></td> 
                    <th>Description</th>
                     <td style="width:5px"></td> 
                    <th>Qty</th>
                  
                  </tr>
                  <?php $count=0;  foreach($assembly_job->result() as $ass_job){ $count ++;?>
                  
                    <tr>
                    
                        
                         	<td style="background-color:#CCC;text-align:center" colspan=""><div style="background-color:#CCC;font-weight:bold;font-size:12px;float:left" class="col-md-3"><?php echo $ass_job->product_id ?></div></td>
                       <td style="width:5px"></td>     
                            <td style="background-color:#CCC" colspan=""><div style="background-color:#CCC;font-size:11px" class="col-md-6"><strong style="font-size:12px"></strong><?php echo $ass_job->description ?></div></td>
                           <td style="width:5px"></td> 
                           <td style="background-color:#CCC;text-align:center" colspan=""><div style="background-color:#CCC;font-weight:bold;font-size:12px" class="col-md-2"><?php echo $ass_job->qty ?></div></td>  
                    </tr> 
                                <tr>
                                            
                                    <td  style="text-align:center;padding-left:5px">
                                        <div  style="font-weight:bold;font-size:12px" class="col-md-2">BOM PID</div>
                                        
                                    
                                    </td>
                                      <td></td>
                                    <td  style="text-align:padding-left:5px"> <div style="font-weight:bold;font-size:12px" class="col-md-2"></div></td>    
                                     <td></td>                                 
                                     <td  style="text-align:padding-left:5px">
                                      <div style="font-weight:bold;font-size:12px" class="col-md-2">BOM Qty</div>
                                      </td>            
                                  </tr>
                                	
                               <?php  foreach($assembly_job_details->result() as $ass_job_detail ){ ?> 
                       
                              	<?php  if($ass_job_detail->assembly_job_id == $ass_job->assembly_job_id){  ?>
                                             <tr>
                                             <td  style="text-align:center;padding-left:5px">
                                                <div style="font-size:12px"  class="col-md-2"><?php echo $ass_job_detail->bom_product_id ?></div>
                        						
                                             
                                                </td>
                                                <td></td>
                                                 <td  style="text-align:left;padding-left:0px;font-size:11px"><?php echo $ass_job_detail->bom_description  ?></td>  
                                                 <td></td>
                                            	<td  style="padding-left:5px;font-size:12px">&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $ass_job_detail->bom_qty ?></td>
                                            </tr>
                        
                                        <?php   }?>
                    		 <?php   } ?>
                               		

              <?php   } ?>
              </table>
             
              
              
              </div>
            </div>
         </div>
      
   
      </div>
    </section>
  </div> 
  
  <script>
  
  </script>   