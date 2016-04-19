<?php require_once('loader.php');
$lp = $lp->row();
?>

<div class="content-wrapper">
  <section class="content ">
    <div class="box-body compact">
      <section class="invoice"> 
        <!-- title row -->
        <div class="row">
          <div class="col-xs-12">
          <div align="right">	<a style="padding-right:20px" href="<?php echo base_url()?>index.php/lp/Lp/lp_list" >Available LPs</a>
                <a style="padding-right:20px" href="<?php echo base_url()?>index.php/lp/Lp/lp_schedule">Scheduled LPs</a>
                <a  style="padding-right:20px" href="<?php echo base_url()?>index.php/lp/Lp/pick_loading_lps" >Pick & Loading</a>
                <a href="<?php echo base_url()?>index.php/lp/Lp/lp_loading" >Loading Set</a> 
  		
        </div>
            <h2 class="page-header"> Loading Proposal: <?php echo $lp_number?>
              <div class="pull-right">
                <div class="btn-group">
                  <button type="button" class="btn btn-default btn-flat">Action</button>
                  <button aria-expanded="false" type="button" class="btn btn-default btn-flat dropdown-toggle" data-toggle="dropdown"> <span class="caret"></span> <span class="sr-only">Toggle Dropdown</span> </button>
                  <ul class="dropdown-menu" role="menu">
                  <?php if($lp->current_status_id==LP_SCHEDULED or 
				  		   $lp->current_status_id==LP_STOPED_LOADING or 
						   $lp->current_status_id==LP_RE_OPEN_CONTAINER){?>
                    <li><a href="#" id="release_to_load" name="release_to_load">Release to Load</a></li>
                  <?php }?> 
				  <?php if($lp->current_status_id==LP_LOADING_FINISHED){?>
                    <li><a href="#" id="release_to_load" name="release_to_load">Release to Load</a></li>
                    <li><a href="#" id="close_container" name="close_container">Close Container</a></li> 
                    <li><a href="#" id="park_out_bay" name="park_out_bay">Park Out-Bay</a></li>
                  <?php }?>                   
                  <?php if( $lp->current_status_id==LP_RELEASED_FOR_LOADING or 
				  			$lp->current_status_id==LP_RE_OPEN_CONTAINER or 
							$lp->current_status_id==LP_PARK_OUT_BAY or 
							$lp->current_status_id==LP_LOADING_STARTED){?>
                    <li><a href="#" id="stop_loading" name="stop_loading">Stop Loading</a></li>
                    <li><a href="#" id="close_container" name="close_container">Close Container</a></li>                    
                  	<li class="divider"></li>
	                <li><a href="#" id="park_out_bay" name="park_out_bay">Park Out-Bay</a></li>
                   
                  <?php }?> 
                  <?php if( $lp->current_status_id==LP_CLOSE_CONTAINER){?>
                    <li><a href="#" id="release_container" name="release_container">Release Container</a></li>
                    <li><a href="#" id="re_open_container" name="re_open_container">Re-Open Container</a></li>
                  <?php }?> 
                  
                  <li><a href="<?php echo base_url()?>index.php/lp/lp/lp_loading">LP List</a></li>
                
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
          
           <?php  foreach($lp_viwe->result() as $lp_viwes){ ?>
           <h4><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Header Information</b></h4>
            <div class="col-xs-6">
             <table class="table">
            	<tr>
                <td ><b>LP # :</b></td>
                <td style="font-size:16px"><?php  echo $lp_viwes->lp_number  ?></td>
                </tr>
                <tr>
                <td ><b>Country :</b></td>
                <td style="font-size:16px"><?php  echo $lp_viwes->country  ?></td>
                </tr>
                <tr>
                <td ><b>Destination :</b></td>
                <td style="font-size:16px"><?php  echo $lp_viwes->tmp_destination  ?></td>
                </tr>
            </table>
            </div>
           <div class="col-xs-6">
             <table class="table">
                <tr>
                  <td><b>Delivery Block Removed Date :</b></td>
                  <td style="font-size:16px"><?php echo $newDate = date("d-M-Y", strtotime($lp_viwes->delivery_block_removed_date));  ?></td>
                </tr>
                <tr>
                <td><b>Vessel Closing Date :</b></td>
                <td style="font-size:16px"><?php  echo $newDate = date("d-M-Y", strtotime($lp_viwes->vessel_closing_date));   ?></td>
                </tr>
                <tr>
                <td><b>Cargo Ready Date :</b></td>
                <td style="font-size:16px"><?php  echo $newDate = date("d-M-Y", strtotime($lp_viwes->cargo_ready_date ))   ?></td>
                </tr>
                <tr>
                <td><b>Datetime Scheduled :</b></td>
                <td style="font-size:16px"s><?php echo $lp_viwes->datetime_scheduled?></td>
                </tr>
            </table>
            <?php } ?>
            </div>
            
            <table class="table table-striped">
              <thead>
                <tr>
                  <th colspan="3" align="left"><p class="lead"><strong>Summary</strong></p></th>
                  <th colspan="2" align="left">Quantity</th>
                  <th align="center">&nbsp;</th>
                </tr>
                <tr>
                  <th>Product ID</th>
                  <th>Description</th>
                  <th style="text-align:center">Sub Customer</th>
                  <th style="text-align:center">LP</th>
                  <th style="text-align:center">Loaded</th>
                  <th style="text-align:center">Status</th>
                </tr>
              </thead>
              <tbody>
                <?php 
					$total_loaded = 0;
					$total_lp = 0;
				foreach($lp_lines->result() as $lp_line){
					$total_lp += $lp_line->quantity ;
					$total_loaded += $lp_line->quantity_loaded ;
					?>
                <tr>
                  <td><?php echo $lp_line->product_id?></td>
                  <td><?php echo $lp_line->description?><?php echo ($lp_line->original_product_id<>""?"<br/>(Original PID: ".$lp_line->original_product_id.")":"") ?></td>
                  <td align="center"><?php echo $lp_line->sub_customer?></td>
                  <td align="center"><?php echo $lp_line->quantity?></td>
                  <td align="center"><?php echo $lp_line->quantity_loaded?></td>
                  <?php if($lp_line->quantity == $lp_line->quantity_loaded){?>
                  <td align="center"><span class="label label-success">Completed</span></td>
                  <?php }?>
                  <?php if($lp_line->quantity > $lp_line->quantity_loaded){?>
                  <td align="center"><span class="label label-warning">In Progress</span></td>
                  <?php }?>  
                  <?php if($lp_line->quantity < $lp_line->quantity_loaded){?>
                  <td align="center"><span class="label label-danger">Excess</span></td>
                  <?php }?>  
                </tr>

                 <?php }?>
                <tr>
                   <td>&nbsp;</td>
                  <td>&nbsp;</td>
                   <td><strong><span style="text-align:center">Total</span></strong></td>
                  <td style="text-align:center"><strong><?php echo $total_lp?></strong></td>
                  <td style="text-align:center"><strong><?php echo $total_loaded?></strong></td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <?php if($lp_excess->num_rows()>0){?>
                <tr>
                  <td colspan="8"><strong>Excess Loadings</strong></td>
                </tr>
                <?php foreach($lp_excess->result() as $row){?>
                <tr>
                  <td style="color:red"><?php echo $row->product_id?></td>
                  <td style="color:red"><?php echo $row->quantity?></td>
                  <td align="center">&nbsp;</td>
                  <td align="center">&nbsp;</td>
                  <td align="center">&nbsp;</td>
                  <td align="center">&nbsp;</td>
                  <td align="center">&nbsp;</td>
                  <td align="center">&nbsp;</td>
                </tr>
                <?php }?>
                <?php }?>

              </tbody>
            </table>
          </div>
          <!-- /.col --> 
        </div>
        <!-- /.row -->
        
        <div class="row"> 
          <!-- accepted payments column -->
          <div class="col-xs-12">
            <p class="lead"><strong>Loading History</strong></p>
           
              <table id="example1" class="table">
               	<thead>
                  <tr>
                    <th align="left">Date Time</th>
                    <th align="left">Pallet</th>
                    <th align="left">Product ID</th>
                    <th align="left">Qty</th>
                    <th align="left">Direction</th>
                    <th align="left">By</th>
                  </tr> 
                  </thead>
                  <tbody>
                  <?php foreach($loadings->result() as $loading){?>
                  <tr>
                    <td align="left"><?php echo $loading->datetime?></td>
                    <td align="left"><?php echo $loading->pallet_code?></td>
                    <td align="left"><?php echo $loading->product_id?></td>
                    <td align="left"><?php echo $loading->quantity?></td>
                    <td align="left"><?php echo $loading->direction?></td>
                    <td align="left"><?php echo $loading->username?></td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
          
          </div>
          <!-- /.col -->
          <div class="col-xs-12">
            <p class="lead"><strong>Action History</strong></p>
            
              <table id="example" class="table">
               	<thead>
                  <tr>
                    <th>Date Time</th>
                    <th>Action</th>
                    <th>Changed to</th>
                    <th>By</th>
                  </tr>
                  </thead> 
                  <tbody>
                  <?php foreach($history->result() as $hist){?>
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
    
          <!-- /.col --> 
        </div>
        <!-- /.row --> 
        
        <!-- this row will not appear when printing -->
        <div class="row no-print">
          <div class="col-xs-12"> <a id="print_pdf" href="#" class="btn btn-default"><i class="fa fa-print"></i></a></div>
        </div>
      </section>
    </div>
  </section>
</div>
<script type="text/javascript">

$(document).ready(function () {

	
	$('#print_pdf').click(function(e) {
        var location = "<?php echo base_url(); ?>index.php/lp/lp/lp_details_export_to_excel?lp_number=<?php echo $lp_number?>";
		window.open(location, '_blank');
    });

	$("#park_out_bay").click(function() {
		if(confirm("Are you sure that you need to PARK THE CONTAINER OUT-BAY?")){
		var me = $(this);
		var lp_number = "<?php echo $lp_number?>";
		$.post( "<?php echo base_url()?>index.php/lp/lp/park_out_bay", { lp_number: lp_number})
		.done(function( data ) {
			jd = $.parseJSON(data);
			if(jd.message=="") {
				var url = '<?php echo base_url()?>index.php/lp/lp/lp_load_detail?lp_number=<?php echo $lp_number?>';
				window.location = url;
			}else{
				alert(jd.message);
			}			
		});	
		}
	});	


	$("#release_container").click(function() {
		if(confirm("Are you sure that you need to RELEASE THE CONTAINER? This action is not reversable")){
		var me = $(this);
		var lp_number = "<?php echo $lp_number?>";
		$.post( "<?php echo base_url()?>index.php/lp/lp/release_container", { lp_number: lp_number})
		.done(function( data ) {
			jd = $.parseJSON(data);
			if(jd.message=="") {
				var url = '<?php echo base_url()?>index.php/lp/lp/lp_load_detail?lp_number=<?php echo $lp_number?>';
				window.location = url;
			}else{
				alert(jd.message);
			}			
		});	
		}
	});	
	
	$("#re_open_container").click(function() {
		if(confirm("Are you sure that you need to RE-OPEN THE CONTAINER?")){
		var me = $(this);
		var lp_number = "<?php echo $lp_number?>";
		$.post( "<?php echo base_url()?>index.php/lp/lp/re_open_container", { lp_number: lp_number})
		.done(function( data ) {
			jd = $.parseJSON(data);
			if(jd.message=="") {
				var url = '<?php echo base_url()?>index.php/lp/lp/lp_load_detail?lp_number=<?php echo $lp_number?>';
				window.location = url;
			}else{
				alert(jd.message);
			}			
		});	
		}
	});		
	

	$("#close_container").click(function() {
		if(confirm("Are you sure that you need to CLOSE THE CONTAINER? Please make sure loading is completed before perform this task")){
		var me = $(this);
		var lp_number = "<?php echo $lp_number?>";
		$.post( "<?php echo base_url()?>index.php/lp/lp/close_container", { lp_number: lp_number})
		.done(function( data ) {
			jd = $.parseJSON(data);
			if(jd.message=="") {
				var url = '<?php echo base_url()?>index.php/lp/lp/lp_load_detail?lp_number=<?php echo $lp_number?>';
				window.location = url;
			}else{
				alert(jd.message);
			}			
		});	
		}
	});	


	$("#release_to_load").click(function() {
		if(confirm("Are you sure that you need to RELEASE LP  FOR LOADING?")){
		var me = $(this);
		var lp_number = "<?php echo $lp_number?>";
		$.post( "<?php echo base_url()?>index.php/lp/lp/release_to_load", { lp_number: lp_number})
		.done(function( data ) {
			jd = $.parseJSON(data);
			if(jd.message=="") {
				var url = '<?php echo base_url()?>index.php/lp/lp/lp_load_detail?lp_number=<?php echo $lp_number?>';
				window.location = url;
			}else{
				alert(jd.message);
			}			
		});	
		}
	});	


	$("#stop_loading").click(function() {
		if(confirm("Are you sure that you need to STOP LOADING?")){
		var me = $(this);
		var lp_number = "<?php echo $lp_number?>";
		$.post( "<?php echo base_url()?>index.php/lp/lp/stop_loading", { lp_number: lp_number})
		.done(function( data ) {
			jd = $.parseJSON(data);
			if(jd.message=="") {
				var url = '<?php echo base_url()?>index.php/lp/lp/lp_load_detail?lp_number=<?php echo $lp_number?>';
				window.location = url;
			}else{
				alert(jd.message);
			}			
		});	
		}
	});	

});
</script>