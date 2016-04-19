<?php require_once('loader.php');?>
<div class="content-wrapper">
  <section class="content">
    <section class="content-header">
      <h1> <?php echo $title?></h1>
    </section>
    <div class="box-body compact">
      <table id="example" class="display table-hover" cellspacing="0" width="100%">
        <thead>
          <tr>
            <th align="left">&nbsp;</th>
            <th align="left">Zone&nbsp;<select name="cmb_zone" id="cmb_zone">
            	<option value="0">All</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>                                                                
              </select>&nbsp;<a href="#" id="in_excel">
           In Excel</a></th>
            <th colspan="3" align="left" bgcolor="#CCCCCC">Replenish To:</th>
            <th align="left">&nbsp;</th>
            <th align="left">&nbsp;</th>
            <th align="left">&nbsp;</th>
            <th align="left">&nbsp;</th>
            <th align="left">Location</th>
            <th align="left">Available</th>
            <th align="left">Required</th>
            <th colspan="3" align="left" bgcolor="#CCCCCC">Moved from</th>
            <th align="left">&nbsp;</th>
          </tr>
          <tr>
            <th align="left"></th>
            
            <th align="left">DateTime</th>
            <th align="left">Zone</th>
            <th align="left">Sub Zone</th>
            <th align="left">Location</th>
            <th align="left">Product ID</th>
            <th align="left">Description</th>
            <th align="left">ROL</th>
            <th align="left">PPQ</th>
            <th align="left">Inv</th>
			<th align="left">Inv</th>
            <th align="left">Qty</th>
            <th align="left">Zone</th>
            <th align="left">Location</th>
            <th align="left">Qty</th>
            <th align="left">By</th>
			<th align="left">Date</th>            
          </tr>
        </thead>
        <tbody>
          <?php 
		  $loop = 1;
		  foreach($replenishments->result() as $ci){?>
          <tr <?php if($ci->rep_status=="PENDING"){?>style="color:#F00" <?php } ?>>
            <td align="left"><?php echo $ci->sort_order?></td>
            
            <td align="left"><?php echo $ci->datetime_created?></td>
            <td align="left"><?php echo $ci->zone?></td>
            <td align="left"><?php echo $ci->sub_zone?></td>
            <td align="left"><?php echo $ci->location?></td>
            <td align="left"><?php echo $ci->product_id?></td>
            <td align="left"><?php echo $ci->description?></td>
            <td align="left"><?php echo $ci->min_reorder_level?></td>
            <td align="left"><?php echo $ci->ppq?></td>
            <td align="left"><?php echo $ci->current_inventory_in_location?></td>
            <td align="left"><?php echo $ci->current_inventory?></td>	
            <td align="left"><?php echo $ci->quantity_required?></td>
            <td align="left"><?php echo $ci->replenished_from_zone?></td>
            <td align="left"><?php echo $ci->replenished_from_location?></td>
            <td align="left"><?php echo $ci->quantity_replenished?></td>
            <td align="left"><?php echo $ci->user_name_replenished?></td> 
            <?php if($ci->rep_status=="COMPLETED"){?>
            <td align="left"><?php echo $ci->datetime_replenished?></td>
            <?php }else{?>
            <td align="left"></td>            
            <?php }?>            
          </tr>
          <?php 
		  $loop++;
		  }
		  
		  ?>
        </tbody>
      </table>
    </div>
  </section>
</div>
<script type="text/javascript">

$(document).ready(function () {
   $('#example').dataTable( {
        "scrollY":        "300px",
        "scrollCollapse": true,
        "paging":         false,        
		"order": [[ 2, "asc" ],[ 3, "asc" ],[ 4, "asc" ]],
        "columnDefs": [
            {
                "targets": [ 0 ],
                "visible": false
            }
        ]	
    } );

	$("#in_excel").click(function() {
		var url = 'replenishment_list_excel?rep_status=<?php echo $rep_status ?>&zone_id='+$("#cmb_zone").val();
		window.location = url;
	});
	$("#btn_update_changes").click(function() {
		$(this).attr('class','btn btn-block btn-default disabled');
		$(this).val('Please wait... Saving Changes...');
		$("#form1").submit();
	});	

	$('a[id^="move_"]').click(function() {
		var replenishment_id = $(this).attr('name');
		var action = $(this).attr('id');
		var zone_id = $(this).attr('zone_id');
		$.post( "<?php echo base_url()?>index.php/inventory/dashboard/change_replenishment_order", { replenishment_id: replenishment_id, action:action,zone_id:zone_id})
		.done(function( data ) {
			window.location = '<?php echo base_url() ?>index.php/inventory/dashboard/replenishment_list?rep_status=<?php echo $rep_status?>';
		});		
	});	
	
});
</script>