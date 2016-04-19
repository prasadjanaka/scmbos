<?php require_once('loader.php');

?>
<div class="content-wrapper">
  <section class="content">
  <?php if($continue!=0){?>
    <div class="alert alert-danger">
     
      <h4><i class="icon fa fa-warning"></i> Please Synchronize Inventory with WMS before proceed</h4> 
      Last update of WMS inventory import is : <strong><?php echo $last_inventory_import?></strong>
		<h6><strong>please <a href="#" id="import_inventory">click here</a> to update inventory. This operation might take few miniutes</strong> </h6>
		<h6>Or <a id="link_continue" href="#">click here</a> to continue to Assign Scanning Clearks</h6>
		<form method="post" id="form1" action="<?php echo base_url()?>index.php/inventory/dashboard/target_set_scanning_cleark">
        <input name="date"  id="date" value="<?php echo $date?>" type="hidden" />
      <input name="continue"  id="continue" value="0" type="hidden" /> </form>
</div>
   <?php }else{?> 
   <table style="width:auto;" align="left">
   <tr>
  
   <td style="font-size:20px">  Set Scanning Clearks for Cycle Count on </td>
   <td>&nbsp;&nbsp;&nbsp;</td>
  <td>
  <form method="post">
  <input value="<?php echo $date; ?>" id="date" name="date" class="" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="" type="text"></form>
  </td>
   </tr>
   </table>
      
   
     
     
     
    <table id="example" class="display dataTable" cellspacing="0" width="95%">
      <thead>
          <tr>
        <th >Zone</th>
        <th width="200">Sub Zone Group</th>
        <th width="200" align="left">Scanner</th>
        <th align="left">&nbsp;</th>
       
      </tr>
      </thead>
      <tbody>
      <?php foreach($sub_zones->result() as $sub_zone){?>
      <tr>
        <td><?php echo $sub_zone->zone?></td>
        <td><?php echo $sub_zone->sub_zone_group?></td>
        <td ><select style="float:left;" name="user_assigned" id="user_assigned" sub_zone_group_id="<?php echo $sub_zone->sub_zone_group_id?>">
          <option value="0"></option>
          <?php foreach($scanners->result() as $scanner){?>
          <option value="<?php echo $scanner->user_id?>" <?php  echo ($sub_zone->user_assigned==$scanner->user_id?" selected ":"")?>><?php echo $scanner->epf_number.' - '.$scanner->name?></option>
          <?php }?>
        </select></td>
        <td >  <a href="<?php echo base_url()?>index.php/inventory/dashboard/target_set_scanning_cleark?sub_zone_group=<?php echo  $sub_zone->sub_zone_group  ?>"><div style="padding-left:100px;font-size:16px" id="<?php echo $sub_zone->sub_zone_group_id?>"></div></a></td>
       
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
		sub_zone_group_id = $(this).attr('sub_zone_group_id');
		user_id = $(this).val();
	
		$.post( "<?php echo base_url()?>index.php/inventory/dashboard/target_set_scanning_clearks_group", 
		{ sub_zone_group_id: sub_zone_group_id,user_id: user_id})
		
		.done(function( data ) {
		
			if(data!=""){
				if(data!=0){
					document.getElementById(sub_zone_group_id).innerHTML=data+" "+"sub zones updated"; 
			}	}
		
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