<?php require_once('loader.php');?>
<div class="content-wrapper">
  <section class="content">
    <div class="box-body compact">
    <div style="width:97%" class="row">
    
     <h2> Client Inventory<div class="pull-right">
        <div class="btn-group">
        <button type="button" class="btn btn-default btn-flat">Action</button>
        <button aria-expanded="false" type="button" class="btn btn-default btn-flat dropdown-toggle" data-toggle="dropdown"> <span class="caret"></span> <span class="sr-only">Toggle Dropdown</span> </button>
        <ul class="dropdown-menu" role="menu">
        <li><a href="#" id="new_inventory_link" name="new_inventory_link">Upload New Inventory</a></li>
         <li><a href="#" id="c_cat_link" name="c_cat_link">Upload New C-cat</a></li>
        </ul>
        </div>
        </div>
        </h2>
      </div>    
                
      <table id="example" class="display dataTable" cellspacing="0" width="95%">
      <thead>
      <th>Product Id</th>
      <th>Description</th>
      <th>Quantity</th>
      </thead>
      
      <tbody>
      <?php  foreach($client as $clients){  ?>
      <tr>
      <td> <?php  echo $clients->product_id ?></td>
      <td><?php  echo $clients->description ?></td>
      <td><?php  echo $clients->quantity ?></td>
      </tr>
      <?php  } ?>
      </tbody>
      
      
      </table>
      <br />
      <input type="file" name="new_inventory" id="new_inventory" style="display:none" />
 <input type="file" name="c_cat" id="c_cat" style="display:none" />
 <input id="excel_export" style="width:150px;" class="btn btn-primary" type="button" value="Export to Excel" />
     </div>
  </section
></div>
<script>
$(document).ready(function () {
	
	$('#excel_export').click(function(e) {
       	 window.location ="<?php  echo base_url() ?>index.php/inventory/product_manager/client_inventory_to_excel";
    });


	$("#new_inventory_link").click(function() {
		$("#new_inventory").click();
	});	
	$("#c_cat_link").click(function() {
		$("#c_cat").click();
	});	
		
	$("#new_inventory").change(function() {
		
		var myFormData = new FormData();
		myFormData.append('new_inventory', this.files[0]);
		
		$.ajax({
		  url: '<?php echo base_url()?>index.php/inventory/product_manager/general_client_inventory_upload',
	  	  type: 'POST',
		  processData: false, // important
		  contentType: false, // important
		  enctype: 'multipart/form-data',
          encoding: 'multipart/form-data',
		  data: myFormData,
		  success: function(data){
			alert(data);
			window.location = '<?php echo base_url()?>index.php/inventory/product_manager/client_inventory';
		  },
		 error:function(err,message,xx) {
			 alert(xx);
		 }
		});
	});	

	$("#c_cat").change(function() {
	
		var myFormData = new FormData();
		myFormData.append('c_cat', this.files[0]);
		
		$.ajax({
		  url: '<?php echo base_url()?>index.php/inventory/product_manager/general_c_cat_upload',
	  	  type: 'POST',
		  processData: false, // important
		  contentType: false, // important
		  enctype: 'multipart/form-data',
          encoding: 'multipart/form-data',
		  data: myFormData,
		  success: function(data){
		alert(data);
		  },
		 error:function(err,message,xx) {
			 alert(xx);
		 }
		});		
	});		
	
});
	
    $('#example').dataTable({
        "scrollY":        "350px",
        "scrollCollapse": true,
        "paging":         false
    });

</script>