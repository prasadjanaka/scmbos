<?php require_once('loader.php');?>
<div class="content-wrapper">
  <section class="content">
  	
    <div class="alert alert-warning alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
      <h4><i class="icon fa fa-warning"></i> Alert!</h4>
      Last update of WMS inventory import is : <?php echo $last_inventory_import?>, please <a href="<?php echo base_url()?>index.php/interfaces/wms/import_inventory_from_wms">click here</a> to update inventory. This operation might take few miniutes</div>


    <div class="box-body compact">

      <table id="example" class="display table-hover" cellspacing="0" width="100%">
        <thead>
          <tr>
            <th height="25" colspan="7" align="left" bgcolor="#CCCC66"> &nbsp;WMS Inventory</th>
            <th height="25" colspan="2" align="left" bgcolor="#CCCCFF">&nbsp;Stacking</th>
            <th height="25" align="left" bgcolor="#99FFFF">&nbsp;</th>
          </tr>
          <tr>
            <th align="left" bgcolor="#CCCC66">Product ID</th>
            <th align="left" bgcolor="#CCCC66">Description</th>
            <th align="left" bgcolor="#CCCC66">Zone</th>
            <th align="left" bgcolor="#CCCC66">Sub Zone Group</th>
            <th align="left" bgcolor="#CCCC66">Sub Zone</th>
            <th align="left" bgcolor="#CCCC66">Location Type</th>
            <th align="left" bgcolor="#CCCC66">Location</th>
            <th align="left" bgcolor="#CCCC66">Quantity</th>
            <th align="left" bgcolor="#CCCCFF"> Type</th>
            <th align="left" bgcolor="#CCCCFF"> Qty</th>
			<th align="left" bgcolor="#99FFFF">&nbsp;Diff</th>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <th colspan="7" style="text-align:right">Total:&nbsp;</th>
            <th colspan="2" style="text-align:right">&nbsp;</th>
          </tr>
        </tfoot>
        <tbody>
          <?php foreach($stacking_norm_adherences->result() as $ci){?>
          <?php 
		  
		  $pps = ($ci->pps==""?0:$ci->pps);
		  $quantity = ($ci->quantity==""?0:$ci->quantity);
		  $diff = $pps - $quantity;
		  ?>
          <tr>
            <td align="left"><?php echo $ci->product_id?></td>
            <td align="left"><?php echo $ci->description?></td>
            <td align="left"><?php echo $ci->zone?></td>
            <td align="left"><?php echo $ci->sub_zone_group?></td>
            <td align="left"><?php echo $ci->sub_zone?></td>
            <td align="left"><?php echo $ci->location_type?></td>
            <td align="left"><?php echo $ci->location?></td>
            <td align="left"><?php echo $ci->quantity?></td>                        
            <td align="left"><?php echo $ci->product_stack_type?></td>
            <td align="left"><?php echo $ci->pps?></td>
            <td align="left"><?php echo $diff?></td>
          </tr>
          <?php }?>
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
		"footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            // Total over all pages
            total = api
                .column( 7 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                } );
 
            // Total over this page
            pageTotal = api
                .column( 7, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 7 ).footer() ).html(
                pageTotal +' ('+ total +' total)'
            );

        }
    } );


	$("#btn_update_changes").click(function() {
		$(this).attr('class','btn btn-block btn-default disabled');
		$(this).val('Please wait... Saving Changes...');
		$("#form1").submit();
	});	
});
</script>