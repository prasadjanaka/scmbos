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
            <h2 class="page-header"> LP Details: <?php echo $lp_number?> (<?php echo $lp->tmp_destination?>) at <?php echo $lp->location?> - <a href="#" class="product-title"><?php echo $lp->status?></a>
              <div class="pull-right">
                <div class="btn-group">
                  <button type="button" class="btn btn-default btn-flat">Action</button>
                  <button aria-expanded="false" type="button" class="btn btn-default btn-flat dropdown-toggle" data-toggle="dropdown"> <span class="caret"></span> <span class="sr-only">Toggle Dropdown</span> </button>
                  <ul class="dropdown-menu" role="menu">
                  <?php if($lp->current_status_id==0 or $lp->current_status_id==LP_STOPED_LOADING or $lp->current_status_id==LP_RE_OPEN_CONTAINER){?>
                    <li><a href="#" id="release_to_load" name="release_to_load">Release to Load</a></li>
                  <?php }?> 
                  <?php if( $lp->current_status_id==LP_RELEASED_FOR_LOADING or $lp->current_status_id==LP_RE_OPEN_CONTAINER or $lp->current_status_id==LP_PARK_OUT_BAY){?>
                    <li><a href="#" id="stop_loading" name="stop_loading">Stop Loading</a></li>
                    <li><a href="#" id="close_container" name="close_container">Close Container</a></li>                    
                  	<li class="divider"></li>
	                <li><a href="#" id="park_out_bay" name="park_out_bay">Park Out-Bay</a></li>
                   
                  <?php }?> 
                  <?php if( $lp->current_status_id==LP_CLOSE_CONTAINER){?>
                    <li><a href="#" id="release_container" name="release_container">Release Container</a></li>
                    <li><a href="#" id="re_open_container" name="re_open_container">Re-Open Container</a></li>
                  <?php }?> 
                  
                  <li><a href="<?php echo base_url()?>index.php/lp/lp/lp_list">LP List</a></li>
                
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
            <table class="table table-striped">
              <thead>
                <tr>
                  <th colspan="3" align="left"><p class="lead"><strong>LP Details</strong></p></th>
                  <th colspan="3" align="center">Quantity</th>
                  <th align="center">&nbsp;</th>
                </tr>
                <tr>
                  <th>Product ID</th>
                  <th>Description</th>
                 
                  <th>Loaded</th>
                  <th>LP</th>
                  <th>Removed</th>
                 
                </tr>
              </thead>
              <tbody>
                <?php foreach($lp_lines->result() as $lp_line){?>
                <tr <?php echo($lp_line->direction=="OUT"?'style="color: #FF0000;"':"")?>>
                  <td><?php echo $lp_line->product_id?></td>
                  <td><?php echo $lp_line->description?></td>
                  
                  <td><?php echo ($lp_line->direction=="OUT"?"":$lp_line->quantity)?></td>
                  <td><?php echo ($lp_line->direction=="OUT"?"":$lp_line->lp_qty)?></td>
                  <td><?php echo ($lp_line->direction=="OUT"?$lp_line->quantity:"")?></td>
                  
                </tr>
                <?php }?>
                <?php foreach($to_be_loaded->result() as $line){?>
                <tr>
                  <td><?php echo $line->UPC?></td>
                  <td>&nbsp;</td>
                  <td align="left">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td><?php echo $line->OrderQuantity?></td>
                 
                 
                </tr>
                <?php }?>
              </tbody>
            </table>
          </div>
          <!-- /.col --> 
        </div>
        <!-- /.row -->
        
       
     
<script type="text/javascript">

$(document).ready(function () {

	$("#park_out_bay").click(function() {
		if(confirm("Are you sure that you need to PARK THE CONTAINER OUT-BAY?")){
		var me = $(this);
		var lp_number = "<?php echo $lp_number?>";
		$.post( "<?php echo base_url()?>index.php/lp/lp/park_out_bay", { lp_number: lp_number})
		.done(function( data ) {
			jd = $.parseJSON(data);
			if(jd.message=="") {
				var url = '<?php echo base_url()?>index.php/lp/lp/lp_detail?lp_number=<?php echo $lp_number?>';
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
				var url = '<?php echo base_url()?>index.php/lp/lp/lp_detail?lp_number=<?php echo $lp_number?>';
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
				var url = '<?php echo base_url()?>index.php/lp/lp/lp_detail?lp_number=<?php echo $lp_number?>';
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
				var url = '<?php echo base_url()?>index.php/lp/lp/lp_detail?lp_number=<?php echo $lp_number?>';
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
				var url = '<?php echo base_url()?>index.php/lp/lp/lp_detail?lp_number=<?php echo $lp_number?>';
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
				var url = '<?php echo base_url()?>index.php/lp/lp/lp_detail?lp_number=<?php echo $lp_number?>';
				window.location = url;
			}else{
				alert(jd.message);
			}			
		});	
		}
	});	

});
</script>