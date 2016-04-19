<div class="content-wrapper"> 
  

  <section class="content">
  <form method="post" action="<?php echo base_url()?>index.php/report/dashboard/pallet_tracker">
  <table>
  <tr>
  <td><label>From Date</label></td>
  <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
  <td>

  <input type="text" class="form-control" name="from" value="<?php echo $date_from; ?>" id="from" placeholder="YYYY-MM-DD"/>

  </td>
  <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
  <td><label>To Date</label></td>
  <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
  <td>
   <input type="text" name="to" class="form-control" value="<?php echo $date_to; ?>" id="to" placeholder="YYYY-MM-DD"/>
  </td>
  <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
  <td>
  <input type="submit" class="btn btn-info btn-flat" value="Go!" style="height:30px;text-align:center"/>
  </td>
  </tr>
  </table>
  </form>
  <table id="example" class="display table-striped dataTable" cellspacing="0" width="100%">
  <thead>
  <tr>
  <th>Pallet Code</th>
  <th>Product ID</th>
  <th>Qty</th>	
  <th>From</th>
  <th>To</th>
  <th>Date Time</th>  
  <th>Movement Type</th>
  <th>EPF Number-User Name</th>
  <th>IP Address</th>
  <th>Host Name</th>
  <th></th>
  </tr>
  </thead>
  <tbody>
  <?php
  foreach($movement as $movements){
	
  ?>
    
  <tr> 
 
  <td><?php echo $movements->pallet_code; ?></td> 
  <td><?php echo $movements->product_id; ?></td> 
  <td><?php echo $movements->movement_sign.$movements->quantity; ?></td> 
  <td><?php echo $movements->from_location; ?></td>  
  <td><?php echo $movements->to_location; ?></td> 
  <td><?php echo $movements->datetime; ?></td> 
  <td><?php echo $movements->movement_type; ?> </td>
  <td><?php echo $movements->epf_number."-".$movements->username; ?></td>
  <td><?php echo $movements->ip_address; ?></td>
  <td><?php echo $movements->host_name; ?></td>
  <td><?php $user_id=$movements->user_id;
  			if($user_id==0){
	  ?>
	  <span class="label label-warning">In Transit</span>	 
	  <?php  }else{?>
	  <span class="label label-success">Completed</span>	  
  	  <?php   }  ?> 
  </td>
  </tr>
  
  <?php }  ?>
  
  </tbody>
  
  </table>
  <table>
  <tr>
  <td>
  <input type="submit" value="Export to Excel Sheet" class="btn btn-primary" id="exporttoexcel_movement"/>
  </td>
  
  </tr>
  </table>
  
  
  
  </section>
  
  
  </div>
  <script>

//alert("");	 

  var data_table = [];
 $('#example tr').each(function() {
    var tr = [];
    $(this).find('td').each(function(){
       tr.push($(this).html())
    });
    data_table.push(tr); 
	//alert(data_table);
	  //make an array from table data
 });


 

	$("#exporttoexcel_movement").click(function () {
window.location="<?php echo base_url() ?>index.php/report/Dashboard/download_Excel_movement?from="+$('#from').val()+"&to="+$('#to').val()+"";	
		

	 }); 


  $('#example').dataTable( {
        "scrollY":"430px",
        "scrollCollapse": false,
		"order": [[ 5, "desc" ]],
        "paging":         false
    } );
  </script>