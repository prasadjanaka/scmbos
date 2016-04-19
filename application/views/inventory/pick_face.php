<?php require_once('loader.php'); ?>

<div class="content-wrapper">
    <section class="content">
        <div class="box-body compact">
            <table id="table_id" class="display table-hover"   >
                <thead>
                    <tr>
						<th>Delete</th>                       
                        <th>Product ID</th>                                         
                        <th>Description</th>                         
                        <th>Location</th>
                        <th>Priority</th>
                        <th>Pallet Count</th>
                        <th>Reorder Level</th>    
                        <th>Enable</th>                      
                    </tr>
                 
                </thead>
                
                <tbody>
                <?php foreach($pick_list as $pick_lists){ ?>
                   <tr>
                   <td style="text-align:center">
                   <input type="checkbox" id="<?php echo $pick_lists->product_id; ?>" name="check" value="<?php echo $pick_lists->product_id; ?>" onclick="deleted(this)"/>
                    
                   </td>
                   
                   <td>
                 <?php echo $pick_lists->product_id; ?>
                   </td>
                   
                    <td>
                   
           
                  <?php echo $pick_lists->description ?>
                   </td>
                   <td>
                   <div style="display:none"><?php echo $pick_lists->location; ?></div>
                   <input type="text" name="location" style="width:100px" id="<?php echo "location_id-".$pick_lists->product_id; ?>" value="<?php echo $pick_lists->location; ?>" onBlur="update_data(this)"/>
                   
                  
                   </td>
                   
                    <td>
                    <input type="text" style="width:100px" name="priority" id="<?php echo "priority-".$pick_lists->product_id; ?>" value="<?php echo $pick_lists->priority; ?>" onBlur="update_data(this)" />
                 
                   </td>
                   <td>
                    <input type="text" style="width:100px" name="pallet_count" id="<?php echo "pallet_count-".$pick_lists->product_id; ?>" value="<?php echo $pick_lists->pallet_count; ?>" onBlur="update_data(this)"/>
                   
                   </td>
                   <td>
                   <input style="width:100px" type="text" name="min_reorder_level" id="<?php echo "min_reorder_level-".$pick_lists->product_id; ?>" value="<?php echo $pick_lists->min_reorder_level; ?>" onBlur="update_data(this)"/>
                   
                   </td>
                    <td style="text-align:center">
               
                    <?php 
					
					
					if($pick_lists->is_enable == 1){					
					?>
                    
                   <input type="checkbox" checked="checked" name="status" id="<?php echo $pick_lists->product_id; ?>" value="<?php echo "status-".$pick_lists->is_enable;  ?>" onclick="set_status(this)" />
                   <?php }else{ ?>
                   
                   <input type="checkbox" name="status" id="<?php echo $pick_lists->product_id; ?>" 
                   value="<?php echo $pick_lists->is_enable;  ?>" onclick="set_status(this)" />
                   <?php } ?>
                   </td>
                   </tr>
                   <?php } ?>
                </tbody>
                </table>
<div style="font-size:24px">Add New Pick Face</div>
                  

        
    
            <table class="table">
            <thead>
            
            <tr>
            <th>Client Code</th> 
            <th>Product Id</th>                        
            <th>Location</th>
            <th>Priority</th>
            <th>Pallet Count</th>
            <th>Minimum Reorder Level</th>   
            <th></th>                      
            </tr>
            </thead>  
            <tr>
            
            <td>
            <input type="text" name="client_code" id="client_code"/>
            </td>
           
            <td>
            <input type="text" name="pid" id="pid" />
            </td>
           
            <td>
            <input type="text" name="lid" id="lid"/>
            </td>
           
            <td>
            <input type="text" name="priority" id="priority"/>
            </td>
           
            <td>
            <input type="text" name="count" id="count"/>
            </td>
          
            <td>
            <input type="text" name="level" id="level"/>
            </td>
            <td>
            <input type="submit" name="btn" id="btn" value="Save" class="btn btn-block btn-primary"/>
            </td>
            </tr>
            </table>
            </div>
    </section>
</div>

<script>

		 $('#table_id').dataTable({
            "scrollY": "300px",
            "scrollCollapse": true,
            "paging": true
        });
		
		$("#lid").focusout(function(e) {
      
		 $.ajax({
            url: '<?php echo base_url() ?>index.php/inventory/Product_manager/check_location',
            method: 'POST',
            data: {location:$('#lid').val()},
			
            success: function(data) {
		var ddd=document.getElementById('lid').value;
		if(ddd == ""){
			
		}else{
			if(data == "Location Already Exist"){
			alert("Location Already Exist");
			document.getElementById('lid').value="";
			$('#lid').focus();
			}
			if(data == "Invalied Location"){
			alert("Invalied Location");
			document.getElementById('lid').value="";
			$('#lid').focus();
			}
			else{
			//alert("sdbhdgshj");  
			}
		}
			
            },
            error: function(err, message, xx) {

            }
			});
		
		
    });
		
		
		
		$("#pid").focusout(function(e) {
      
		 $.ajax({
            url: '<?php echo base_url() ?>index.php/inventory/Product_manager/check_pid',
            method: 'POST',
            data: {pro_id:$('#pid').val()},
			
            success: function(data) {
		//alert(data);
			if(data == "Invalied PID"){
			
			var dd=document.getElementById('pid').value;
			if(dd==""){
				
			}else{
				alert("Invalied PID");
				document.getElementById('pid').value="";
			    $('#pid').focus();
			}
			
			}
			if(data == "PID Allready Exsist"){
			alert("PID Allready Exist");
			document.getElementById('pid').value="";
			$('#pid').focus();
			}
					  
			 else{
						//alert("sdbhdgshj");  
		    }		 
            },
            error: function(err, message, xx) {

            }
			});
		
		
    });
	
	    function set_focus(location_id){
	
		var abc="location_id-"+location_id;
	
		document.getElementById(abc).focus();
		
		
		}
		
		function set_status(st){
		
			var x;
			if (confirm("Are You Sure Change Status !") == true) {
			
			 $.ajax({
            url: '<?php echo base_url() ?>index.php/inventory/Product_manager/status_pick_face',
            method: 'POST',
            data: {product_id:st.id,status:st.value},
			
            success: function(data) {
		//alert(data);
   		if(data == "OK"){
		window.location="<?php echo base_url()?>index.php/inventory/Product_manager/list_pick_face";
		}
            },
            error: function(err, message, xx) {

            }
			});
			 
			} else {
				//$('input[name="locationthemes"]:checked');
			var ss=$('input:checkbox:checked').val();  
			//alert(ss);
			//	$('input[name=status]').attr('checked', false);	
			//document.getElementById(<?php echo $pick_lists->product_id; ?>).checked = true;
			}
		}
		
		function deleted(id_product){
			
		var x;
			if (confirm("Are You Sure Delete this!") == true) {
			
			 $.ajax({
            url: '<?php echo base_url() ?>index.php/inventory/Product_manager/delete_pick_face',
            method: 'POST',
            data: {product_id:id_product.value},
			
            success: function(data) {
			if(data == "Deleted"){
				window.location="<?php echo base_url()?>index.php/inventory/Product_manager/list_pick_face";
			}
         

            },
            error: function(err, message, xx) {

            }
			});
			 
			} else {
				$('input[name=check]').attr('checked', false);
			
			}
			
		}
		
		function update_data(update_data){
			
		
			
			loca=update_data.id.split("-");
			//alert(loca);
			 $.ajax({
            url: '<?php echo base_url() ?>index.php/inventory/Product_manager/update_pick_face',
            method: 'POST',
            data: {update_col_name:loca[0],update_id: loca[1], update_value: update_data.value},
            success: function(data) {
			
				if(data == "Location Already Exist"){
					
				alert("Location Already Exist");
			// set_focus(loca[1]);
			
			}else if(data == "Invalied Location"){
			alert("Invalied Location");
	
		    set_focus(loca[1]);
			
			}else{
			//alert("sdbhdgshj");  
			}
         

            },
            error: function(err, message, xx) {

            }
        });
		}
		
	
		
		
		$('#btn').click(function (){
			$code=$("#client_code").val();
			$pid=$("#pid").val();
			$lid=$("#lid").val();
			$priority=$("#priority").val();
			$count=$("#count").val();
			$level=$("#level").val();
			if($code == "" || $pid == "" || $lid == "" || $priority == "" || $count == "" || $level == "" ){
			alert("Please Insert Data");
			}else{
			
			 $.ajax({
            url: '<?php echo base_url() ?>index.php/inventory/Product_manager/add_pick_face',
            method: 'POST',
            data: {client_code:$("#client_code").val(),product_id:$("#pid").val(),lid:$("#lid").val(),
			priority:$("#priority").val(),count:$("#count").val(),level:$("#level").val()},
			
            success: function(data) {
	
				if(data == "ok"){
				alert("Success");		
				window.location="<?php echo base_url()?>index.php/inventory/Product_manager/list_pick_face";
				
				}
			
         

            },
            error: function(err, message, xx) {

            }
			 });
			 
			 
			}
		});
	
		$('#location_id-12.577.17189').click(function() {
            alert("");
        });	
</script>