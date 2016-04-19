<?php require_once('loader.php');

?>
<div class="content-wrapper">
  <section class="content">
  <?php if($continue==0){?>
    <div class="alert alert-danger">
     
      <h4><i class="icon fa fa-warning"></i> Please Synchronize Inventory with WMS before proceed</h4> 
      Last update of WMS inventory import is : <strong><?php echo $last_inventory_import?></strong>
		<h6><strong>please <a href="#" id="import_inventory">click here</a> to update inventory. This operation might take few miniutes</strong> </h6>
		<h6>Or <a id="link_continue" href="#">click here</a> to continue to Assign Scanning Clearks</h6>
		<form method="post" id="form1" action="<?php echo base_url()?>index.php/inventory/dashboard/pid_set_scanning_clearks">
        <input name="date"  id="date" value="<?php echo $date?>" type="hidden" />
      <input name="continue"  id="continue" value="0" type="hidden" /> </form>
</div>
   <?php }else{?> 
       <section class="content-header">
      <h1> Set Scanning Clearks for Cycle Count on <?php echo $date?></h1>
    </section>
    <table id="example" class="display dataTable" cellspacing="0" width="95%">
      <thead>
          <tr>
        <th>Zone</th>
        <th>Sub Zone Group</th>
        <th>Sub Zone</th>
        <th>PID</th>
        <th>Scanner</th>
      </tr>
      </thead>
      <tbody>
      <?php foreach($sub_zones->result() as $sub_zone){?>
      <tr>
        <td><?php echo $sub_zone->zone?></td>
        <td><?php echo $sub_zone->sub_zone_group?></td>
        <td><?php echo $sub_zone->sub_zone?></td>
        <td><?php echo $sub_zone->product_id?></td>
        <?php if($sub_zone->status_id<=2){?>
        <td><select name="user_assigned" id="user_assigned" count_id="<?php echo $sub_zone->count_id?>" >
          <option value="0"></option>
          <?php foreach($scanners->result() as $scanner){?>
          <option value="<?php echo $scanner->user_id?>" <?php echo ($scanner->user_id==$sub_zone->user_assigned?" selected ":"")?>><?php echo $scanner->epf_number.' - '.$scanner->name?></option>
	      <?php }?>
        </select>
        </td>
        <?php }else{?>
        <td><?php echo $sub_zone->count_status?></td>
        <?php }?>        
      </tr>
      <?php }?>
      </tbody>
    </table>
   <?php }?> 
  </section>
</div>
<script type="text/javascript">
$(document).ready(function () {
	$("#date").inputmask("yyyy-mm-dd", {"placeholder": "yyyy-mm-dd"});
	
	$('select[id^="user_assigned"]').change(function(){
		seleted_box = $(this);
		count_id = $(this).attr('count_id');
		user_id = $(this).val();

		$.post( "<?php echo base_url()?>index.php/inventory/dashboard/set_scanning_clearks", { count_id: count_id,user_id: user_id})
		.done(function( data ) {

			jd = $.parseJSON(data);
			if(jd.message!="") {
				alert(jd.message);
				seleted_box.val(jd.user_id);
				seleted_box.attr('selectedIndex',jd.user_id);	
				seleted_box.prop('selectedIndex', jd.user_id);
			}
		});		
	});		
	
	$("#link_continue").click(function() {
		if(confirm("Are you sure you want to continue assigning with current inventory?\n*** NOTE: This operation is not reversable")){
			$("#continue").val(1);
			$("#form1").submit();				
		}
		
	});	

	$("#import_inventory").click(function() {

		if(confirm("Are you sure you want to import the inventory from WMS?\nThis operation will take few miniutes")){
			window.location = '<?php echo base_url()?>index.php/interfaces/wms/import_inventory_from_wms';			
		}
		
	});	

$('#example').dataTable( {
	"scrollY":        "350px",
	"scrollCollapse": true,
	"paging":         false
} );

	
});
</script>