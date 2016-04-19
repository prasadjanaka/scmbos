<?php require_once('loader.php');
date_default_timezone_set("Asia/Colombo");
?>

<div class="content-wrapper">
  <section class="content ">
    <div class="box-body compact">
      <h4>Pick List</h4>
      	<table id="example" class="table">
        	<thead>
        	<tr>
            	<th>Pick Number</th>
                <th>Creat Date Time</th>
                <th>User</th>
                <th>Status</th>
                <th>Priority</th>
                <th>Reference</th>
            </tr>
        	</thead>
            <tbody>
            <?php  foreach($pick_list->result() as $row ){ ?>
                <tr>
                    <td><a href="<?php echo base_url()?>index.php/inventory/dashboard/pick_details?pick_number=<?php echo $row->pick_number  ?>" ><?php echo $row->pick_number  ?></a></td>
                    <td><a href="<?php echo base_url()?>index.php/inventory/dashboard/pick_details?pick_number=<?php echo $row->pick_number  ?>" ><?php echo $row->date_time  ?></a></td>
                    <td><?php echo $row->epf_number  ?></td>
                    <td><?php echo $row->status  ?></td>
                    <td><?php echo $row->priority  ?></td>
                     <td><?php echo $row->reference_type  ?></td>
                     
            <?php  } ?>         
                </tr>
            </tbody>
        </table>
      
      <br>
   
     </div>
   </section>
</div>

<script>
	
	
  $('#example').dataTable( {
        "scrollY":"300px",
        "scrollCollapse": true,
        "paging":false
		
    });

</script>          