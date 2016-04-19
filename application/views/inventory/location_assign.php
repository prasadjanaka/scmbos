<?php require_once('loader.php');
date_default_timezone_set("Asia/Colombo");
?>

<div class="content-wrapper">
  <section class="content ">
    <div class="box-body compact">
      <h4>Location Assigner</h4>
            <table id="example">
      <thead>
        	<tr>
            	<th>Sub Zone</th>
                <th>Location</th>  
                <th>Product ID</th>
                <th>Date</th>
                <th style="text-align:center">Count #</th>
                <th>Counting Type</th>
            </tr>
        
       </thead>
         	<tbody>
        <?php  foreach($assign_list->result() as $list){ ?>
        	<tr>
            	<td><?php  echo $list->sub_zone ?></td>
                <td><?php  echo $list->location ?></td>
                <td><?php  echo $list->product_id ?></td>
                <td><?php  echo $list->date ?></td>
                <td style="text-align:center"><?php  echo $list->count_number ?></td>
                <td><?php  echo $list->inventory_count_type ?></td>
            
            </tr>
          <?php  } ?>  
        </tbody>
      </table>
      <br>
      <table>
      <form method="POST">
      	<tr>
        	<td> <label>Date</label></td>
            <td style="padding-left:10px"><input value="<?php  echo $ds  ?>" type="text" id="ds" name="ds" class="form-control"/></td>
            <td style="padding-left:10px"><input  type="submit" value="List" style="width:100px" class="btn"/></td>
        </tr>
      </form>
      </table>
      	<table style="width:1000px" class="table">
        	<tr>
            	<th>Location</th>
                <th>Reference</th>
                <th>PID</th>
                <th></th>
            
            </tr>
            <tr>
            	<td><input onBlur="check_count(this.value)" type="text" id="location_val" class="form-control" /></td>
                <td><select class="form-control"  style="" name="user_assigned" id="user_assigned" >
          <option value="0"></option>
          <?php foreach($open_reference->result() as $reference){?>
          <option value="<?php echo $reference->reference_number ?>"><?php echo $reference->reference_number ?></option>
	      <?php }?>
        </select></td>
                <td><input type="text" onblur="pid_valide(this.value)" id="pid_val" class="form-control" /></td>
                <td><input type="button" id="add_count" class="btn  btn-facebook" value="Add" style="width:150px" ></td>
            </tr>
        
        </table>
      

      
      
      </div>
    </section>
 </div>
 <script>
 	
	$('#user_assigned').change(function(e) {
     var ref_val =    $( "#user_assigned option:selected" ).val();
		
		$.ajax({
			url: '<?php echo base_url() ?>index.php/inventory/dashboard/reference_valide',
			method: 'POST',
			data: {ref_val:ref_val},
			success: function(data) {
				if(data!=""){
					alert(data);
				
				}
				
			},
			error: function(err, message, xx) {	}
		});
	
    });
	
	function pid_valide(pid){
	
		$.ajax({
			url: '<?php echo base_url() ?>index.php/inventory/dashboard/pid_validate',
			method: 'POST',
			data: {pid:pid},
			success: function(data) {
			
				if(data!=1){
					alert("Invalide Product ID");
					$('#pid_val').val("");
				}
			},
			error: function(err, message, xx) {	}
		});
		
	}
	
	$('#add_count').click(function(e) {
 
			if($('#location_val').val()==""){
				
				$('#location_val').focus();
			
			}else if($('#user_assigned').val()==0){
				
				$('#user_assigned').focus();
			
			}else{
				var ref_val =    $( "#user_assigned option:selected" ).val();
				var sub_zone_id =  $('#location_val').attr('sub_zone_id');
				var pid = $('#pid_val').val();
				var scanner = $('#user_assigned').val();	
				var location_id =  $('#location_val').attr('location_id');
				var date = $('#ds').val();
					//alert(ref_val);
					//return
					$.ajax({
						url: '<?php echo base_url() ?>index.php/inventory/dashboard/new_location_assign',
						method: 'POST',
						data: {sub_zone_id:sub_zone_id,pid:pid,ref_val:ref_val,location_id:location_id,date:date},
						success: function(data) {
							alert(data);
							if(data==1){
								window.location='<?php echo base_url() ?>index.php/inventory/dashboard/location_assign';
							}else{
								alert(data);
							}
						},
						error: function(err, message, xx) {	}
					});
				
			
			
			}
		
    });
	
	
	function check_count(location){

			$.ajax({
				url: '<?php echo base_url() ?>index.php/inventory/dashboard/check_count_info',
				method: 'POST',
				data: {location:location},
				success: function(data) {
					
					if(data=="1?1"){
						
						alert("Invalid Location");
						$('#location_val').val("");
						$('#location_val').removeAttr('sub_zone_id');
						$('#location_val').removeAttr('location_id');
					}else{
						var res = data.split('?');
						$('#location_val').attr('sub_zone_id',res[0]);
						$('#location_val').attr('location_id',res[1]);
					}
					
				},
				error: function(err, message, xx) {	}
			});
	}
 	
 
 $('#example').dataTable( {
	"scrollY":        "350px",
	"scrollCollapse": true,
	"paging":         false
} );
 
 </script>  