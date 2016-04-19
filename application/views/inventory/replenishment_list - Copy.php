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
            <th align="left">&nbsp;</th>
            <th colspan="3" align="left" bgcolor="#CCCCCC">Replenish To:</th>
            <th align="left">&nbsp;</th>
            <th align="left">&nbsp;</th>
            <th align="left">Required</th>
            <th align="left">&nbsp;</th>
            <th colspan="2" align="left" bgcolor="#CCCCCC">Replenished</th>
            <th align="left">&nbsp;</th>
            <th align="left">Moved</th>
          </tr>
          <tr>
            <th align="left"></th>
            
            <th align="left">DateTime</th>
            <th align="left">Zone</th>
            <th align="left">Sub Zone</th>
            <th align="left">Location</th>
            <th align="left">Product ID</th>
            <th align="left">Description</th>
            <th align="left">Qty</th>
            <th align="left">PPQ</th>
            <th align="left">Zone</th>
            <th align="left">Location</th>
            <th align="left">Qty</th>
            <th align="left">Status</th>
            <th align="left">By</th>
            <th align="left">Change Order</th>
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
            <td align="left"><?php echo $ci->quantity_required?></td>
            <td align="left"><?php echo $ci->ppq?></td>
            <td align="left"><?php echo $ci->replenished_from_zone?></td>
            <td align="left"><?php echo $ci->replenished_from_location?></td>
            <td align="left"><?php echo $ci->quantity_replenished?></td>
            <td align="left"><?php echo $ci->rep_status?></td>
            <td align="left"><?php echo $ci->user_name_replenished?></td> 
            <td align="left" valign="middle">
			<?php if($ci->rep_status=="PENDING"){?>
			<?php if($loop>1){?><a href="#" name="<?php echo $ci->replenishment_id?>" id="move_top" zone_id="<?php echo $ci->zone_id?>" title="Move to Top"><?php }?><i class="fa fa-fw fa-toggle-up"></i><?php if($loop>1){?></a><?php }?>
            <?php if($loop>1){?><a href="#" name="<?php echo $ci->replenishment_id?>" id="move_up" zone_id="<?php echo $ci->zone_id?>" title="Move Up"><?php }?><i class="fa fa-fw fa-level-up"></i><?php if($loop>1){?></a><?php }?>
            <?php if($loop<$replenishments->num_rows()){?><a href="#" name="<?php echo $ci->replenishment_id?>" id="move_down" zone_id="<?php echo $ci->zone_id?>" title="Move Down"><?php }?><i class="fa fa-fw fa-level-down"></i><?php if($loop<$replenishments->num_rows()){?></a><?php }?>
	        <?php if($loop<$replenishments->num_rows()){?><a href="#" name="<?php echo $ci->replenishment_id?>" id="move_bottom" zone_id="<?php echo $ci->zone_id?>" title="Move to Bottom"><?php }?><i class="fa fa-fw fa-toggle-down"></i><?php if($loop<$replenishments->num_rows()){?></a><?php }?>
				<?php }?>
                </td>           
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