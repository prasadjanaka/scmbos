<?php require_once('loader.php');
date_default_timezone_set("Asia/Colombo");
?>
<div class="content-wrapper">
  <section class="content ">
    <div class="box-body compact"> 
    
	<table id="example">
    	<thead>
            <tr>
                <td>Job Number</td>
                <td>Date Time</td>
                <td>User</td>
                <td>Priority</td>
                <td>Status</td>
                <td>Jon Type</td>
                <td>Reference</td>
                
            </tr>
        
    </thead>
    <tbody>
    <?php foreach($job_list->result() as $jlist ){ ?>
    	<tr>
        	<td><a href="<?php echo base_url()?>index.php/inventory/Dashboard/job_details?job_id=<?php echo $jlist->job_id ;?>"><?php echo $jlist->job_id ?></a></td>
            <td><a href="<?php echo base_url()?>index.php/inventory/Dashboard/job_details?job_id=<?php echo $jlist->job_id ;?>"><?php echo $jlist->datetime ?></a></td>
            <td><?php echo $jlist->epf_number ?></td>
            <td><?php echo $jlist->priority ?></td>
            <td><?php echo $jlist->status ?></td>
            <td><?php echo $jlist->job_type ?></td>
         	<td><?php echo $jlist->reference_type."/".$jlist->reference_number ?></td>
        </tr>
    <?php } ?>
    </tbody>
    </table>
	
   
    </div>
 </section>
</div>

<script>
	$('#example').dataTable( {
	"scrollY":        "350px",
	"scrollCollapse": true,
	"paging":         false
	});

</script>