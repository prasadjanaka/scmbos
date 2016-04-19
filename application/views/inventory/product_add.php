<?php require_once('loader.php');
date_default_timezone_set("Asia/Colombo");
?>
<div class="content-wrapper">
  <section class="content ">
    <div class="box-body compact"> 
    <div class="col-md-6">
	<table class="table">
    	<tr>
        	<td style="width:200px;font-weight:bold">Product ID</td>
           
           
            <td  style="width:260px;"><input type="text" id="product_id" class="form-control"/></td>
           
           
            <td><input type="button" style="width:150px" id="pro_search" class="btn btn-facebook" value="Search"/></td>
        </tr>
    
    </table>	
    <div align="center" style="display:none;font-size:16px;color:red" id="msg" >Product ID Could not be found.Fill the Form and Press save to add new Product</div>
    <table class="table">
    	<tr>
        	<td>Description</td>
            <td><textarea disabled="disabled" id="discription_val" class="form-control"  ></textarea></td>
        </tr>
        <tr>
        	<td>Weight Net</td>
            <td><input disabled="disabled" type="text" class="form-control"  id="net_val"/> </td>
        </tr>
        <tr>
        	<td>Height</td>
            <td><input disabled="disabled" type="text" class="form-control"  id="height_val"/></td>
        </tr>
        <tr>
        	<td>Volume</td>
            <td><input disabled="disabled" type="text" class="form-control"  id="volume_val"/></td>
        </tr>

         <tr>
        	<td></td>
            <td>
            <input disabled="disabled" type="button" style="width:150px" id="save" class="btn btn-facebook" value="Save"/>
            
            <input disabled="disabled" type="button" style="width:150px;display:none" id="update" class="btn btn-facebook" value="Update"/>
            
            </td>
        </tr>
    </table>
    </div>    
            
    
    
    </div>
  </section>
</div>

<script>
	$('#product_id').keyup(function(e) {
		
       if($('#product_id').val() == ""){
			$('#discription_val').attr('disabled','disabled');
			$('#net_val').attr('disabled','disabled');
			$('#height_val').attr('disabled','disabled');
			$('#volume_val').attr('disabled','disabled');
			$('#save').attr('disabled','disabled');
			$('#update').attr('disabled','disabled');  
			
			$('#discription_val').val("");
			$('#net_val').val("");
			$('#height_val').val("");
			$('#volume_val').val(""); 
			
			document.getElementById('save').style='width:150px;display:block';
			document.getElementById('update').style='width:150px;display:none';
		} 
    });


	$('#pro_search').click(function(e) {
       
		var product_id = $('#product_id').val();
			$('#discription_val').val("");
			$('#net_val').val("");
			$('#height_val').val("");
			$('#volume_val').val("");
	
			
				
		if(product_id!=""){
			$('#discription_val').removeAttr('disabled');
			$('#net_val').removeAttr('disabled');
			$('#height_val').removeAttr('disabled');
			$('#volume_val').removeAttr('disabled');
			$('#save').removeAttr('disabled');
			$('#update').removeAttr('disabled');
			$.ajax({
				url: '<?php echo base_url() ?>index.php/inventory/Product_manager/get_product_details',
				method: 'POST',
				data: {product_id:product_id},
				success: function(data) {
				
					if(data!='0'){
						document.getElementById('msg').style='display:none;font-size:16px;color:red';
						document.getElementById('save').style='width:150px;display:none';
						document.getElementById('update').style='width:150px;display:block';
					
						 var splite_value = data.split("??"); 
								$('#discription_val').val(splite_value[0]);
								$('#net_val').val(splite_value[1]);
								$('#height_val').val(splite_value[2]);
								$('#volume_val').val(splite_value[3]);
		
					}else{
						
						document.getElementById('save').style='width:150px;display:block';
						document.getElementById('update').style='width:150px;display:none';
						document.getElementById('msg').style='display:block;font-size:16px;color:red';
					}
					
				},
				error: function(err, message, xx) {	}
		   });
		
		}else{
			$('#product_id').focus();	
		}
		
    });
	
	$('#update').click(function(e) {
       var product_id = 	$('#product_id').val();
      	var discription = 	$('#discription_val').val();
		var net_val 	=	$('#net_val').val();
		var height_val	=	$('#height_val').val();
		var volume_val 	=	$('#volume_val').val();
	
		if(product_id == ""){
			$('#product_id').focus();
		}else{
			$.ajax({
				url: '<?php echo base_url() ?>index.php/inventory/Product_manager/update_product',
				method: 'POST',
				data: {product_id:product_id,discription:discription,net_val:net_val,height_val:height_val,volume_val:volume_val},
				success: function(data) {
					if(data=='1'){
						alert("Update Successfully Done");
					}else if(data=='0'){
						alert("Sorry you are not authorized to this action");
					}
					
				},
				error: function(err, message, xx) {	}
			});
		
				
		}
		
    });
	
	
	$('#save').click(function(e) {
		var product_id = 	$('#product_id').val();
      	var discription = 	$('#discription_val').val();
		var net_val 	=	$('#net_val').val();
		var height_val	=	$('#height_val').val();
		var volume_val 	=	$('#volume_val').val();


	if(product_id == ""){
			$('#product_id').focus();
		}else if(discription == ""){
			$('#discription_val').focus();
		}else if(net_val == ""){
			$('#net_val').focus();
		}else if(height_val == ""){
			$('#height_val').focus();
		}else if(volume_val == ""){
			$('#volume_val').focus();

		}else{
		
			$.ajax({
				url: '<?php echo base_url() ?>index.php/inventory/Product_manager/add_product',
				method: 'POST',
				data: {product_id:product_id,discription:discription,net_val:net_val,height_val:height_val,volume_val:volume_val},
				success: function(data) {
				
					if(data=='1'){
						alert("Save Successfully Done");
						}else if(data=='0'){
						alert("Sorry you are not authorized to this action");
					}
					
				},
				error: function(err, message, xx) {	}
			});
			
		}
		
    });

</script>