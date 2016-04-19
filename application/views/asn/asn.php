<?php require_once('loader.php');
$asn = $asn->row();
?>

<div class="content-wrapper">
  <section class="content ">
    <div class="box-body compact">
      <section class="invoice"> 
        <!-- title row -->
        <div class="row">
          <div class="col-xs-12">
            <h2 class="page-header"> ASN: <?php echo $asn->asn_number . " (". $asn->status?>) - <?php echo ($asn->asn_type_id==1?"GENERAL":"SHUTTLE")?>
              <div class="pull-right">
                <div class="btn-group">
                  <button type="button" class="btn btn-default btn-flat">Action</button>
                  <button aria-expanded="false" type="button" class="btn btn-default btn-flat dropdown-toggle" data-toggle="dropdown"> <span class="caret"></span> <span class="sr-only">Toggle Dropdown</span> </button>
                  <ul class="dropdown-menu" role="menu">
                  <?php if($asn->status_id == ASN_NEW){?>
                    <li><a href="#" id="btnDelete" name="btnDelete">Delete Selected STO</a></li>
                  
                    <li><a href="#" id="new_sto_link" name="new_sto_link">Upload STO</a></li>
                    <li><a href="#" id="generate_labels" name="generate_labels">Generate barcodes</a></li>                    
                  	<li class="divider"></li>
                  <?php }?>
                  <?php if($asn->status_id == ASN_UNLOADING_COMPLETED){?>
					<li><a href="#" id="relase_to_change">Release for Adjustments</a></li>                  	
                    <li><a href="#" id="mark_as_completed">Mark As Completed</a></li>                  	
                    <li class="divider"></li>
                  <?php }?> 
                  <?php //if($asn->status_id == ASN_NEW){?>
					<li><a href="print_asn_pallet_lables?asn_number=<?php echo $asn->asn_number?>" target="_blank">Print barcodes</a></li>                  	
                    <li class="divider"></li>
                    <li><a href="<?php echo base_url()?>index.php/inventory/dashboard/print_barcode?asn_number=<?php echo $asn->asn_number?>" target="_blank">Advance Print</a></li>                  	
                    <li class="divider"></li>
                  <?php //}?>
                
	                <li><a href="<?php echo base_url()?>index.php/asn/dashboard/print_asn?asn_number=<?php echo $asn->asn_number?>" target="_blank">Print Unloading Sheet</a></li>
                    
                       <li class="divider"></li>
                 
                
	                <li><a href="<?php echo base_url()?>index.php/asn/dashboard/print_asn_refdoc?asn_number=<?php echo $asn->asn_number?>" target="_blank">Print Asn Ref Doc</a></li>
                    <li><a href="<?php echo base_url()?>index.php/inventory/Product_manager/add_new_product">Product Manager</a></li>
                    
                  </ul>
                </div>
              </div>
            </h2>
          </div>
          <!-- /.col --> 
        </div>
        <!-- info row --><!-- /.row --> 
        
        <!-- Table row -->
        <div class="row">
          <div class="col-xs-12 table-responsive">
           <p class="lead"  data-toggle="collapse" data-target="#vehicle_info" style="cursor:pointer"><strong>Header  Information</strong></p>
              <div id="vehicle_info" class="collapse">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th align="left" style="text-align:center">Vehicle Number</th>
                  <th align="left">Contact Person</th>
                  <th align="left">Phone</th>
                  <th align="left">Container Number</th>
                  <th align="left">Container Size</th>
                  <th>&nbsp;</th>
                  </tr>
              </thead>
              <tbody>
                <tr>
                  <td align="left" style="text-align:center"><input name="vehicle_number" type="text" id="vehicle_number" value="<?php echo $asn->vehicle_number?>" /></td>
                  <td align="left"><span style="text-align:center">
                    <input name="contact_person" type="text" id="contact_person" size="35"  value="<?php echo $asn->contact_person?>" />
                  </span></td>
                  <td align="left"><span style="text-align:center">
                    <input type="text" name="phone_number" id="phone_number"  value="<?php echo $asn->phone?>"/>
                  </span></td>
                  <td align="left"><span style="text-align:center">
                       
                          <input  type="text" name="container_number" id="container_number"  value="<?php echo $asn->container_number?>" />
                
                      </span></td>
                  <td align="left"><select name="container_size" id="container_size" required>
                          <option value=""></option>
                      <?php 
                      foreach ($container_info as $row) { ?>
                      <option <?php echo ($row->container_size_id==$asn->container_size_id?" selected ":"")?> value="<?php echo $row->container_size_id;?>"><?php echo $row->container_size;?></option>    
                    
                    
                      <?php  }  ?>
                  </select></td>
                  <td><input type="submit" name="btnSave"  id="btnSave" value="Save" /></td>
                  </tr>
              </tbody>
            </table>
            </div>
          </div>
          <!-- /.col --> 
        </div>
        <div class="row">
          <div class="col-xs-12 table-responsive">
           <p class="lead"  data-toggle="collapse" data-target="#sto_summary" style="cursor:pointer"><strong>STO Summary</strong><span class="lead" style="cursor:pointer">&nbsp;(<?php echo $stos->num_rows()?>)</span></p>
              <div id="sto_summary" class="collapse in">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th style="text-align:center"><?php if($asn->status_id == ASN_NEW){?>Delete<?php }?></th>
                  <th>STO Number</th>
                  <th>Plant Code</th>
                  <th>Posted Date Time</th>
                  <th style="text-align:center">PID Count</th>
                  <th style="text-align:center">Quantity</th>
                </tr>
              </thead>
              <tbody>
                <?php 
				$product_id_count = 0;
				$quantity_sum = 0;
				foreach($stos->result() as $sto){
					 $product_id_count += $sto->product_id_count;
					 $quantity_sum += $sto->quantity_sum;
				?>
                <tr>
                  <td style="text-align:center"><?php if($asn->status_id == ASN_NEW and $sto->xml_file==""){?><input type="radio" name="rdoDelete" id="rdoDelete" value="<?php echo $sto->sto_number?>" /><?php }?></td>
                  <td><?php echo $sto->sto_number?></td>
                  <td><?php echo $sto->plant_code?></td>
                  <td><?php echo $sto->datetime_post?></td>
                  <td style="text-align:center"><?php echo $sto->product_id_count?></td>
                  <td style="text-align:center"><?php echo $sto->quantity_sum?></td>
                </tr>
                <?php }?>
                <tr>
                  <td colspan="3" align="left"><input type="file" name="new_sto" id="new_sto" style="display:none" /></td>
                  <td align="right"><strong>Total</strong></td>
                  <td style="text-align:center"><strong><?php echo $product_id_count?></strong></td>
                  <td style="text-align:center"><strong><?php echo $quantity_sum?></strong></td>
                </tr>
              </tbody>
            </table>
            </div>
          </div>
          <!-- /.col --> 
        </div>
        <!-- /.row -->
        
        <div class="row"> 
          <!-- accepted payments column -->
          
		  <div class="col-xs-12">
		    <div class="table-responsive">
              <p class="lead"  data-toggle="collapse" data-target="#unloading_detail" style="cursor:pointer"><strong>Unloading Sheet</strong>&nbsp;(<?php echo $asn_barcodes->num_rows()?>)</p>
              <div id="unloading_detail" class="collapse">
              <table class="table table-striped">
                <tbody>
                  <tr>
                    <th align="left">Product ID</th>
                    <th align="left">Description</th>
                    <th style="text-align:center">Zone</th>
                    <th style="text-align:center">ASN Quantity</th>
                     <th style="text-align:center">Unloaded Quantity</th>
                    <th align="left">Type</th>
                    <th style="text-align:center">PPS</th>
                    <th style="text-align:center">Full</th>
                    <th style="text-align:center">Part</th>
                    <th style="text-align:center">Part Qty</th>
                  </tr>
                  <?php 
				  $total_quantity = 0;
				  $total_full_stack = 0;
				  $total_part_stack = 0;				  
				  $total_part_stack_quantity = 0;
				  $total_asn_quantity=0;
				  $total_unloaded_quantity=0;
				  				  
				  foreach($asn_barcodes->result() as $asn_barcode){
					   $total_asn_quantity= $total_asn_quantity+$asn_barcode->quantity;
					   $total_unloaded_quantity=  $total_unloaded_quantity+$asn_barcode->unloaded_quantity;
//					  $total_quantity += $asn_barcode->quantity;
//					  $total_full_stack += $asn_barcode->full_stack;
//					  $total_part_stack += $asn_barcode->part_stack;				  
//					  $total_part_stack_quantity += $asn_barcode->part_stack_quantity;		
					  $hq_style	= ($asn_barcode->handling_quantity==0?'style="background:#C00;color:#FFF"':"");
				  ?>
                  <tr <?php echo $hq_style?>>

                    <td align="left"><?php echo $asn_barcode->product_id?></td>
                    <td align="left"><?php echo $asn_barcode->description?></td>
                    <td align="left" style="text-align:center"><?php echo $asn_barcode->zone?></td>
                    <td align="left" style="text-align:center"><?php echo $asn_barcode->quantity?></td>
                    <td align="left" style="text-align:center"><?php echo $asn_barcode->unloaded_quantity?></td>
                    <td align="left"><?php echo $asn_barcode->product_stack_type?></td>
                    <td style="text-align:center"><?php echo $asn_barcode->handling_quantity?></td>
                    <td style="text-align:center"><?php echo ($asn_barcode->full_stack==0?"":$asn_barcode->full_stack)?></td>
                    <td style="text-align:center"><?php echo $asn_barcode->part_stack?></td>
                    <td style="text-align:center"><?php echo $asn_barcode->part_stack_quantity?></td>
                  </tr>
                  <?php } ?>
               
                  <tr>
                    <td align="right">&nbsp;</td>
                    <td align="right">&nbsp;</td>
                    <td align="right"><strong>Total</strong></td>
                    <td style="text-align:center"><strong><?php  echo $total_asn_quantity  ?></strong></td>
                    <td style="text-align:center"><strong><?php  echo $total_unloaded_quantity  ?></strong></td>
                    <td align="right">&nbsp;</td>
                    <td align="right">&nbsp;</td>
                    <td align="right">&nbsp;</td>
                    <td style="text-align:center">&nbsp;</td>
                    <td style="text-align:center">&nbsp;</td>
                  
                   
                  </tr>
      
               
                  <tr>
                    <td colspan="6" align="right"><strong>Stacking Summary</strong></td>
                    <td style="text-align:left"><strong>Type</strong></td>
                    <td style="text-align:center"><strong>Full</strong></td>
                    <td style="text-align:center"><strong>Part</strong></td>
                    <td style="text-align:center"><strong>Total</strong></td>
                   
                  </tr>
                  <?php foreach($asn_barcodes_summary->result() as $asn_barcodes_summary_line){?>
                  <tr>
                    <td colspan="6" align="left">&nbsp;</td>
                    <td style="text-align:left"><?php echo $asn_barcodes_summary_line->product_stack_type?></td>
                    <td style="text-align:center"><?php echo ($asn_barcodes_summary_line->full_stack==0?"":$asn_barcodes_summary_line->full_stack)?></td>
					<td style="text-align:center"><?php echo $asn_barcodes_summary_line->part_stack?></td>
                    <td style="text-align:center"><?php echo $asn_barcodes_summary_line->full_stack + $asn_barcodes_summary_line->part_stack?></td>
                                     
                    
                  </tr>
                  <?php } ?>
                  
             
                </tbody>
              </table>
              </div>
            </div>
          </div>          
          
          <div class="col-xs-12">
		    <div class="table-responsive">
              <p class="lead"  data-toggle="collapse" data-target="#unloading_exceptions" style="cursor:pointer"><strong>Unloading Exceptions</strong>&nbsp;(<?php echo $exceptions->num_rows() ?>)</p>
              <div id="unloading_exceptions" class="collapse">
              <table class="table table-striped">
                <tbody>
                  <tr>
                    <th align="left">Product ID</th>
                    <th align="left">Description</th>
                    <th style="text-align:center">Quantity</th>
                  </tr>
                  <?php 
				  foreach($exceptions->result() as $exception){
				  ?>
                  <tr>

                    <td align="left"><?php echo $exception->product_id?></td>
                    <td align="left"><?php echo $exception->description?></td>
                    <td style="text-align:center"><?php echo $exception->quantity?></td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
              </div>
            </div>
          </div>
          
          <div class="col-xs-12">
              <p class="lead"  data-toggle="collapse" data-target="#more_detail" style="cursor:pointer"><strong>More Detail</strong>&nbsp;(<?php echo $sto_details->num_rows()?>)</p>
              <div id="more_detail" class="collapse">
            
                <div class="table-responsive">
                  <table class="table table-striped">
                    <tbody>
                      <tr>
                        <th align="left">STO Number</th>
                        <th align="left">Product ID</th>
                        <th align="left">Description</th>
                        <th align="left" style="text-align:center">ASN Quantity</th>
                        <th align="left"style="text-align:center"> Unloaded Quantity</th>
                        <th align="left">PO Number</th>
                      </tr>
                      <?php  
					  $more_total_asn_quantity=0;
				  	  $more_total_unloaded_quantity=0; ?>
                      <?php foreach($sto_details->result() as $sto_detail){
                       $more_total_asn_quantity= $more_total_asn_quantity+$sto_detail->quantity;
					   $more_total_unloaded_quantity=  $more_total_unloaded_quantity+$sto_detail->unloaded_quantity;?>
                     
                      <tr>
                        <td align="left"><?php echo $sto_detail->sto_number?></td>
                        <td align="left"><?php echo $sto_detail->product_id?></td>
                        <td align="left"><?php echo $sto_detail->description?></td>
                        <td align="left" style="text-align:center"><?php echo $sto_detail->quantity?></td>
                        <td align="left" style="text-align:center"><?php echo ($sto_detail->unloaded_quantity==0?"":$sto_detail->unloaded_quantity)?></td>
                        <td align="left"><?php echo $sto_detail->po_number?></td>
                      </tr>
                      <?php } ?>
                      <tr>
                        <td colspan="3" align="right"><strong>Total</strong></td>
                        <td align="center"><strong><?php echo $more_total_asn_quantity  ?></strong></td>
                        <td align="center"><strong><?php echo $more_total_unloaded_quantity  ?></strong></td>
                        <td align="left">&nbsp;</td>
                      </tr>               
                    </tbody>
                  </table>
                </div>
            </div>
          </div>
          
          
          
          
          
          <!-- /.col -->
          <div class="col-xs-12">
            <p class="lead"  data-toggle="collapse" data-target="#action_history" style="cursor:pointer"><strong>Action History</strong><span class="lead" style="cursor:pointer"></span></p>
                 <div class="table-responsive collapse" id="action_history">
                  <table class="table table-striped">
                    <tbody>
                      <tr>
                        <th>Date Time</th>
                        <th>Action</th>
                        <th>Changed to</th>
                        <th>By</th>
                      </tr>
                      <?php foreach($history_list as $hist){?>
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
        <!-- /.row --> 

      </section>
    </div>
  </section>
</div>
<script type="text/javascript">

$(document).ready(function () {
	var has_no_hqs = false;

	$("#new_sto_link").click(function() {
		$("#new_sto").click();
	});		
	$("#new_sto").change(function() {
		var myFormData = new FormData();
		myFormData.append('new_sto', this.files[0]);
		myFormData.append('asn_number', '<?php echo $asn->asn_number?>');
		$.ajax({
		  url: '<?php echo base_url()?>index.php/asn/dashboard/sto_upload',
		  type: 'POST',
		  processData: false, // important
		  contentType: false, // important
		  enctype: 'multipart/form-data',
          encoding: 'multipart/form-data',
		  data: myFormData,
		  success: function(data){
			alert(data);
			window.location = '<?php echo base_url()?>index.php/asn/dashboard/asn?asn_number=<?php echo $asn->asn_number?>';
		  },
		  error:function(err,message,xx) {
			  alert(xx);
		  }
		});		
		//$(this).val("");
	});	
	
	$("#mark_as_completed").click(function() {
		if(confirm("Are you sure that you need to mark this ASN as completed?")){
			$.ajax({
			  url: '<?php echo base_url()?>index.php/asn/dashboard/mark_as_completed',
			  method: 'POST',
			  data: {asn_number: '<?php echo $asn->asn_number?>'},
			  success: function(data){
				  if(data!=""){
					  alert(data);
				  }
				
				window.location = '<?php echo base_url()?>index.php/asn/dashboard/asn?asn_number=<?php echo $asn->asn_number?>';
			  },
			  error:function(err,message,xx) {
				  alert(xx);
			  }	  
			});	
								
		}
	});	
		
	$("#relase_to_change").click(function() {
		if(confirm("Are you sure that you need to release this ASN for changes?")){
			$.ajax({
			  url: '<?php echo base_url()?>index.php/asn/dashboard/asn_release_for_adjustments',
			  method: 'POST',
			  data: {asn_number: '<?php echo $asn->asn_number?>'},
			  success: function(data){
				  if(data!=""){
					  alert(data);
				  }
				
				window.location = '<?php echo base_url()?>index.php/asn/dashboard/asn?asn_number=<?php echo $asn->asn_number?>';
			  },
			  error:function(err,message,xx) {
				  alert(xx);
			  }	  
			});	
								
		}
	});	
		

	$("#generate_labels").click(function() {
		if(confirm("Are you sure that you need to generate BARCODE labels?")){
			$.ajax({
			  url: '<?php echo base_url()?>index.php/asn/dashboard/generate_asn_barcodes',
			  method: 'POST',
			  data: {asn_number: '<?php echo $asn->asn_number?>'},
			  success: function(data){
				  if(data!=""){
					  alert(data);
				  }
				
				window.location = '<?php echo base_url()?>index.php/asn/dashboard/asn?asn_number=<?php echo $asn->asn_number?>';
			  },
			  error:function(err,message,xx) {
				  alert(xx);
			  }	  
			});	
								
		}
	});	
			
	$("#btnDelete").click(function() {
		if(!$('input[name=rdoDelete]:radio:checked').val()){
			alert('Please select a STO to delete');	
		}else{
			if(confirm("Are you sure that you need to delete this STO?")){
				var sto_number = $('input[name=rdoDelete]:radio:checked').val();		
				$.ajax({
				  url: '<?php echo base_url()?>index.php/asn/dashboard/sto_delete',
				  method: 'POST',
				  data: {sto_number: sto_number,asn_number: '<?php echo $asn->asn_number?>'},
				  success: function(data){
					  if(data!=""){
						  alert(data);
					  }
					
					window.location = '<?php echo base_url()?>index.php/asn/dashboard/asn?asn_number=<?php echo $asn->asn_number?>';
				  },
				  error:function(err,message,xx) {
					  alert(xx);
				  }	  
				});	
									
			}
		}
		
	});	

});

	$("#btnSave").click(function() {
			var vehicle_number=document.getElementById('vehicle_number').value;
                        var contact_person=document.getElementById('contact_person').value;
                        var phone_number=document.getElementById('phone_number').value;
                        var container_number=document.getElementById('container_number').value;
                        var container_size=document.getElementById('container_size').value;
                        $.ajax({
			  url: '<?php echo base_url()?>index.php/asn/dashboard/vehicle_information_update',
			  method: 'POST',
			  data: {asn_number:"<?php echo $asn->asn_number?>",vehicle_number: vehicle_number,contact_person:contact_person,phone_number: phone_number,container_number:container_number,container_size:container_size},
			  success: function(data){
				  if(data!=""){
					  alert(data);
				  }
			  },
			  error:function(err,message,xx) {
				  alert(xx);
			  }	  
			});	
	});
        

</script>