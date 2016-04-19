<?php require_once('loader.php');?>
<div class="content-wrapper">
  <section class="content">
    <div class="alert alert-warning alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
      <h4><i class="icon fa fa-warning"></i> Alert!</h4>
      Last update of WMS inventory import is : <?php echo $last_inventory_import?>, please <a href="<?php echo base_url()?>index.php/interfaces/wms/import_inventory_from_wms">click here</a> to update inventory. This operation might take few miniutes</div>
    <section class="content-header">
      <h1> Current Inventory as <?php echo $last_inventory_import?></h1>
    </section>
    <div class="box-body compact">
      <table id="example" class="display table-hover" cellspacing="0" width="100%">
        <thead>
          <tr>
            <th align="left">Product ID</th>
            <th style="width:400px" align="left">Description</th>
            <th align="left">Zone</th>
            <th align="left">Sub Zone Group</th>
            <th align="left">Sub Zone</th>
            <th align="left">Type</th>
            <th align="left">Location</th>
            <th align="left">Quantity</th>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <th colspan="6" style="text-align:right">Total:&nbsp;</th>
            <th colspan="2" style="text-align:right">&nbsp;</th>
          </tr>
        </tfoot>
        <tbody>
          <?php foreach($current_inventory->result() as $ci){?>
          <tr>
            <td align="left"><?php echo $ci->product_id?></td>
            <td align="left"><?php echo $ci->description?></td>
            <td align="left"><?php echo $ci->zone?></td>
            <td align="left"><?php echo $ci->sub_zone_group?></td>
            <td align="left"><?php echo $ci->sub_zone?></td>
            <td align="left"><?php echo $ci->location_type?></td>
            <td align="left"><?php echo $ci->location?></td>
            <td align="left"><?php echo $ci->quantity?></td>
          </tr>
          <?php }?>
        </tbody>
      </table>
      <input id="excel_export" style="width:150px;" class="btn btn-primary" type="button" value="Export to Excel" />
    </div>
  </section>
</div>
<script type="text/javascript">

$(document).ready(function () {
	
	$('#excel_export').click(function(e) {
       	 window.location ="<?php  echo base_url() ?>index.php/inventory/dashboard/current_inventory_to_excel";
    });
	
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