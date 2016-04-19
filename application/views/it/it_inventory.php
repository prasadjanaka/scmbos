<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style>
  
    #popup {
        width:100%;
        height:100%;
        opacity:.95;
        top:0;
        left:0;
        display:none;
        position:fixed;
        background-color: transparent;//#9d9d9d;
        overflow:auto;
    }
 #popup_details {
        width:100%;
        height:100%;
        opacity:.95;
        top:0;
        left:0;
        display:none;
        position:fixed;
        background-color: transparent;//#9d9d9d;
        overflow:auto;
    }
    div#popupContact {
        position:absolute;
        left:40%;
        top:17%;



    }
    #form{
        max-width:400px;
        min-width:250px;
        padding:10px 50px;
        border:2px solid gray;
        border-radius:10px;
        font-family:raleway;
        background-color:#fff;
    }



</style>
</head>

<body>
 <div class="content-wrapper">
  <section class="content">
 <div class="row">
            <div class="col-xs-12">
    <div  class="box box-solid box-success" style="">
  
    <div class="box-header with-border">
    <h2 class="box-title">Device Information </h2>
    </div>

  							

  <table id="example1" class="table table-bordered table-hover" >
        <thead style="background-color:#3C8DBC;color:white">
       
              
                      <tr>
                        	<th style="display:none">aa</th>
                            <th style="width:350px">Device name</th>
                            <th>Model</th>
                            <th>Serial Number</th>
                            <th>Location</th>
                            <th>Current User</th>
                            <th>Status</th>
                      </tr>
                    </thead>
                    <tbody >
						<?php 
                        foreach($device_list as $device_lists){
                        
                        
                        ?>
                        <tr>
                        
                        <td style="display:none">
                        <?php echo $device_lists->device_category; ?>
                        </td>
                        <td style="font-size:17px">
                        
                        <a data-toggle="modal" data-target="#myModal" onclick="edit(<?php echo $device_lists->device_details_id; ?>)" href="#"><?php echo $device_lists->device_name; ?></a>
                        
                        
                        </td>
                        <td>
                        <?php echo $device_lists->model; ?>
                        </td>
                        <td>
                        <?php echo $device_lists->serial_number; ?>
                        </td>
                        <td>
                        <?php echo $device_lists->location; ?>
                        </td>
                        <td>
                        <?php echo $device_lists->current_user; ?>
                        
                        </td>
                        <td>
                        <?php echo $device_lists->status; ?>
                        
                        </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                   
                  </table>
                <table>
   <tr>
   <td>&nbsp;</td>
   <td>
   <input type="button" id="add" value="Add New Device" class="btn btn-block btn-primary" data-toggle="modal" data-target="#add_new" href="#"/>
   </td>
   <td>&nbsp;</td>
     <td>
   <input type="button" id="exporttoexcel" value="Export to Excel Sheet" class="btn btn-block btn-primary" />
   </td>
   <td>&nbsp;</td>
   <td>
        <select id="category_search" class="form-control" style="border: 2px solid #367FA9;">
        <option value="">All</option>
        <option value="Computer">Computer</option>
        <option value="Other Device">Other Device</option>
        <option value="Scanner">Scanner</option>
        
        </select>
   </td>
   </tr>
  
   </table>
   </br>
       </div>
  
   </div>
   </div>
    
        </section>
        </div>
        
        
        <div class="modal fade" id="add_new" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    
      <div style="height:550px" class="modal-body">
       	<div class="box">
                <div style="text-align:center" class="box-header">
                  <h1 style="color:#367FA9">ADD NEW DEVICE</h1>
                </div><!-- /.box-header -->
                <div class="box-body no-padding" style="width:600px">
            
             <table align="center">
             			<tr>
                      <td>
                      <label style="font-size:20px;font-weight:500">Device Category &nbsp;&nbsp;</label></td>              
                      <td>
                       <div class="input-group">
                    <div class="input-group-addon" style="width:40px">
                    <i class="fa fa-sitemap"></i>
                    </div>
                      <select id="category" style="width:300px" class="form-control">
                      <option></option>
                      <option>Computer</option>
					  <option>Scanner</option>
                      <option>Other Devices</option>
                      </select>
                     </div>
                      </td>
                    </tr>
                      <tr>
                      <td>
                      <label style="font-size:20px;font-weight:500">Device name &nbsp;&nbsp;</label></td>              
                      <td>
                       <div class="input-group">
                <div class="input-group-addon" style="width:40px">
                <i class="fa  fa-desktop"></i>
                </div>
                      <input type="text" id="name" value="" class="form-control" style="width:300px"/>
                     </div>
                      </td>
                    </tr>
                      <tr>
                      <td>
                      <label style="font-size:20px;font-weight:500">Model &nbsp;&nbsp;</label>
                      </td>         
                      <td>
                       <div class="input-group">
                <div class="input-group-addon" style="width:40px">
                <i class="fa  fa-hand-o-left "></i>
                </div>
                      <input type="text" id="model" value="" class="form-control" style="width:300px"/>
                     </div>
                      </td>
                      </tr>
                       <tr>
                      <td>
                      <label style="font-size:20px;font-weight:500">Serial Number &nbsp;&nbsp;</label>
                      </td>         
                      <td>
                       <div class="input-group">
                <div class="input-group-addon" style="width:40px">
                <i class="fa fa-barcode"></i>
                </div>
                      <input type="text" id="serial" value="" class="form-control" style="width:300px"/>
                    </div>
                      </td>
                      </tr>
                       <tr>
                      <td>
                       
                      <label style="font-size:20px;font-weight:500">Purchace Date &nbsp;&nbsp;</label>
                      </td>         
                      <td>
                <div class="input-group">
                <div class="input-group-addon" style="width:40px">
                <i class="fa fa-calendar"></i>
                </div>
                
                <input value="" id="date" name="date" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="" type="text" style="width:300px">      
                
                </div>
                      </td>
                      </tr>
                        <tr>
                      <td>
                      <label style="font-size:20px;font-weight:500">Current User &nbsp;&nbsp;</label>
                      </td>         
                      <td>
                       <div class="input-group">
                <div class="input-group-addon" style="width:40px">
                <i class="fa fa-users"></i>
                </div>
                      <input type="text" id="user" value="" class="form-control" style="width:300px"/>
                     </div>
                      </td>
                      </tr>
                      <tr>
                      <td>
                      <label style="font-size:20px;font-weight:500">Department &nbsp;&nbsp;</label>
                      </td>         
                      <td>
                       <div class="input-group">
                <div class="input-group-addon" style="width:40px">
                <i class="fa fa-location-arrow"></i>
                </div>
                  
                   <select id="department" class="form-control" style="width:300px">
                    <option></option>
                   <?php foreach($department_list as $department_lists){ ?>
                  <option id="<?php echo $department_lists->department_id; ?>"><?php echo $department_lists->department_name; ?></option>
                   
                   <?php } ?>
                   </select>
                   
                    </div>
                      </td>
                      </tr>
                      
                        <tr>
                      <td>
                      <label style="font-size:20px;font-weight:500">User Name &nbsp;&nbsp;</label>
                      </td>         
                      <td>
                       <div class="input-group">
                <div class="input-group-addon" style="width:40px">
                <i class="fa fa-smile-o"></i>
                </div>
                      <input type="text" id="user_name" value="" class="form-control" style="width:300px"/>
                    </div>
                      </td>
                      </tr>
                       <tr>
                      <td>
                      <label style="font-size:20px;font-weight:500">Password &nbsp;&nbsp;</label>
                      </td>         
                      <td>
                       <div class="input-group">
                <div class="input-group-addon" style="width:40px">
                <i class="fa fa-keyboard-o"></i>
                </div>
                      <input type="text" id="password" value="" class="form-control" style="width:300px"/>
                     </div>
                      </td>
                      </tr>
                       <tr>
                      <td>
                      <label style="font-size:20px;font-weight:500">Vender &nbsp;&nbsp;</label>
                      </td>         
                      <td>
                       <div class="input-group">
                <div class="input-group-addon" style="width:40px">
                <i class="fa fa-bank"></i>
                </div>
                      <input type="text" id="vender" value="" class="form-control" style="width:300px"/>
                     </div>
                      </td>
                      </tr>
                      <tr>
                      <td>
                      <label style="font-size:20px;font-weight:500">Status &nbsp;&nbsp;</label>
                      </td>         
                      <td>
                       <div class="input-group">
                <div class="input-group-addon" style="width:40px">
                <i class="fa fa-check-circle"></i>
                </div>
                	 <select id="status" class="form-control" style="width:300px">
                     <option></option>
                     <option>Active</option>
                     <option>Inactive</option>
                     </select>
                     </div>
                      </td>
                      
                      </tr>
                         <tr>
                      <td>
                      <label style="font-size:20px;font-weight:500">Other Details &nbsp;&nbsp;</label>
                      </td>         
                      <td>
                 
                      <textarea style="resize:none;width:340px" class="form-control" id="other"></textarea>
                  
                      </td>
                      </tr>
                      </table> 
            
            
                </div><!-- /.box-body -->
              </div>
       
       
      </div>
           
        <div class="modal-footer">
            <button style="width:100px" type="button" class="btn btn-default pull-left" data-dismiss="modal" id="">Close</button>
            <button style="width:100px" type="button" class="btn btn-primary" id="add_device">Save</button>
         </div>
    </div>
  </div>
</div>
        
        
        
 





<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div style="height:550px;" class="modal-body">
       	<div class="box">
                <div style="text-align:center" class="box-header">
                  <h1 style="color:#367FA9">EDIT DETAILS</h1>
                </div><!-- /.box-header -->
                <div class="box-body no-padding" style="width:600px">
             <table align="center">
             		<tr>
                      <td>
                      <label style="font-size:20px;font-weight:500">Device Category &nbsp;&nbsp;</label></td>              
                      <td>
                       <div class="input-group">
                    <div class="input-group-addon" style="width:40px">
                    <i class="fa fa-sitemap"></i>
                    </div>
                      <select id="edit_category" style="width:300px" class="form-control">
                      <option></option>
                      <option>Computer</option>
					  <option>Scanner</option>
                      <option>Other Devices</option>
                      </select>
                     </div>
                      </td>
                    </tr>
             
                      <tr>
                      <td>
                      <label style="font-size:20px;font-weight:500">Device name &nbsp;&nbsp;</label></td>              
                      <td>
                       <div class="input-group">
                <div class="input-group-addon" style="width:40px">
                <i class="fa  fa-desktop"></i>
                </div>
                      <input type="text" id="edit_name" value="" class="form-control" style="width:300px"/>
                      <input type="hidden"  id="edit_id" value="" class="form-control"/>
                     </div>
                      </td>
                      </tr>
                      <tr>
                      <td>
                      <label style="font-size:20px;font-weight:500">Model &nbsp;&nbsp;</label>
                      </td>         
                      <td>
                       <div class="input-group">
                <div class="input-group-addon" style="width:40px">
                <i class="fa  fa-hand-o-left "></i>
                </div>
                      <input type="text" id="edit_model" value="" class="form-control" style="width:300px"/>
                     </div>
                      </td>
                      </tr>
                       <tr>
                      <td>
                      <label style="font-size:20px;font-weight:500">Serial Number &nbsp;&nbsp;</label>
                      </td>         
                      <td>
                        <div class="input-group">
                <div class="input-group-addon" style="width:40px">
                <i class="fa fa-barcode"></i>
                </div>
                      <input type="text" id="edit_serial" value="" class="form-control" style="width:300px"/>
                     </div>
                      </td>
                      </tr>
                       <tr>
                      <td>
                       
                      <label style="font-size:20px;font-weight:500">Purchace Date &nbsp;&nbsp;</label>
                      </td>         
                      <td>
               <div class="input-group">
                <div class="input-group-addon" style="width:40px">
                <i class="fa fa-calendar"></i>
                </div>
                
                
                <input value="" id="edit_date" name="" class="form-control" data-inputmask="'alias': 'yyyy/mm/dd'" data-mask=""  style="width:300px">      
                
                </div>
                      </td>
                      </tr>
                         
                      
                        <tr>
                      <td>
                      <label style="font-size:20px;font-weight:500">Current User &nbsp;&nbsp;</label>
                      </td>         
                      <td>
                         <div class="input-group">
                <div class="input-group-addon" style="width:40px">
                <i class="fa fa-users"></i>
                </div>
                      <input type="text" id="edit_user" value="" class="form-control" style="width:300px"/>
                     </div>
                      </td>
                      </tr>
                      <tr>
                      <td>
                      <label style="font-size:20px;font-weight:500">Department &nbsp;&nbsp;</label>
                      </td>         
                      <td>
                       <div class="input-group">
                <div class="input-group-addon" style="width:40px">
                <i class="fa fa-location-arrow"></i>
                </div>
                         <select id="edit_department" class="form-control" style="width:300px">
                    <option></option>
                   <?php foreach($department_list as $department_lists){ ?>
                  <option id="<?php echo $department_lists->department_id; ?>"><?php echo $department_lists->department_name; ?></option>
                   
                   <?php } ?>
                   </select>
                      
                      
                    </div>
                      </td>
                      </tr>
                        <tr>
                      <td>
                      <label style="font-size:20px;font-weight:500">User Name &nbsp;&nbsp;</label>
                      </td>         
                      <td>
                         <div class="input-group">
                <div class="input-group-addon" style="width:40px">
                <i class="fa fa-smile-o"></i>
                </div>
                      <input type="text" id="edit_user_name" value="" class="form-control" style="width:300px"/>
                     </div>
                      </td>
                      </tr>
                       <tr>
                      <td>
                      <label style="font-size:20px;font-weight:500">Password &nbsp;&nbsp;</label>
                      </td>         
                      <td>
                       <div class="input-group">
                <div class="input-group-addon" style="width:40px">
                <i class="fa fa-keyboard-o"></i>
                </div>
                      <input type="text" id="edit_password" value="" class="form-control" style="width:300px"/>
                     </div>
                      </td>
                      </tr>
                       <tr>
                      <td>
                      <label style="font-size:20px;font-weight:500">Vender &nbsp;&nbsp;</label>
                      </td>         
                      <td>
                        <div class="input-group">
                <div class="input-group-addon" style="width:40px">
                <i class="fa fa-bank"></i>
                </div>
                      <input type="text" id="edit_vender" value="" class="form-control" style="width:300px"/>
                    </div>
                      </td>
                      </tr>
                         <tr>
                      <td>
                      <label style="font-size:20px;font-weight:500">Status &nbsp;&nbsp;</label>
                      </td>         
                      <td>
                       <div class="input-group">
                <div class="input-group-addon" style="width:40px">
                <i class="fa fa-check-circle"></i>
                </div>
                	 <select id="edit_status" class="form-control" style="width:300px">
                     <option></option>
                     <option>Active</option>
                     <option>Inactive</option>
                     </select>
                     </div>
                      </td>
                      
                      </tr>
                         <tr>
                      <td>
                      <label style="font-size:20px;font-weight:500">Other Details &nbsp;&nbsp;</label>
                      </td>         
                      <td>
                      <textarea style="resize:none;width:340px" class="form-control" id="edit_other" ></textarea>
                      </td>
                      </tr>
                      </table> 
            
            
            
                </div><!-- /.box-body -->
              </div>
       
       
      </div>
           
        <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
            <button id="edit" type="button" class="btn btn-primary">Edit</button>
         </div>
    </div>
  </div>
</div>
				<!-- model end -->  
     


</body>

<script>
	

	$('#category_search').change(function(e) {
		//alert($("#category_search option:selected").val()); 
		
	 	var table = $('#example1').DataTable();
		table.search($("#category_search option:selected").val()).draw();
    });


	$("#exporttoexcel").click(function () {
window.location="<?php echo base_url() ?>index.php/it/dashboard/download_Excel";

	 }); 


  function edit(edit_id){
	$.ajax({
            url: '<?php echo base_url() ?>index.php/it/dashboard/edit_device_details',
            method: 'POST',
            data: {id:edit_id},
            success: function(data) {
                if (data != "") {
                    
				  var arr=data;
				  var arr1=arr.split('//');
				
			document.getElementById('edit_name').value=arr1[1];	
			document.getElementById('edit_model').value=arr1[2];
			document.getElementById('edit_serial').value=arr1[3];
			document.getElementById('edit_date').value=arr1[4];
			document.getElementById('edit_user').value=arr1[5];
			document.getElementById('edit_user_name').value=arr1[6];
			document.getElementById('edit_password').value=arr1[7];
			document.getElementById('edit_vender').value=arr1[8];
			document.getElementById('edit_other').value=arr1[9];
			document.getElementById('edit_id').value=arr1[10];	
			document.getElementById('edit_department').value=arr1[11];
			document.getElementById('edit_category').value=arr1[12];
			document.getElementById('edit_status').value=arr1[13];
			
                }else{
				  
				}
            },
            error: function(err, message, xx) {

            }
		});	
  }
 		$('#example1').DataTable({
          "paging": true,
          "lengthChange": false,
          "ordering": true,
		
          "info": true,
          "autoWidth": false
        });
    
	
	$('#add_device').click(function (){
		
		
	var name=document.getElementById('name').value;
	var category=document.getElementById('category').value;
	var department=document.getElementById('department').value;
	var status=document.getElementById('status').value;
	
	if(category==""){
	$('#category').focus();
	}else if(name==""){
	$('#name').focus();
	
	}else if(department==""){
	$('#department').focus();
	}else if(status==""){
	$('#status').focus();
	}else{
	
		$.ajax({
            url: '<?php echo base_url() ?>index.php/it/dashboard/add_device_details',
            method: 'POST',
            data: {category:$('#category').val(),name:$('#name').val(),model:$('#model').val(),serial:$('#serial').val(),purchace:$('#date').val(),
			user:$('#user').val(),user_name:$('#user_name').val(),password:$('#password').val(),vender:$('#vender').val(),
			status:$('#status').val(),other:$('#other').val(),location:$('#department').val()},
		
            success: function(data) {
				//alert(data);
                if (data != "") {
                   if(data=="OK"){
					   window.location="<?php echo base_url() ?>index.php/Dashboard/it_inventory";
				   }else{

					  window.location="<?php echo base_url() ?>index.php/it/Dashboard/add_device_details";
					
				   }
				   
				 
                }
            },
            error: function(err, message, xx) {

            }
		});		
	}
		
	});
	
	$('#edit').click(function (){
		
		
	$.ajax({
            url: '<?php echo base_url() ?>index.php/it/dashboard/edit_details',
            method: 'POST',
            data: {edit_category:$('#edit_category').val(),edit_name:$('#edit_name').val(),edit_model:$('#edit_model').val(),edit_serial:$('#edit_serial').val(),
			edit_date:$('#edit_date').val(),edit_user_name:$('#edit_user_name').val(),edit_user:$('#edit_user').val(),edit_password:$('#edit_password').val(),
			edit_vender:$('#edit_vender').val(),edit_other:$('#edit_other').val(),edit_id:$('#edit_id').val(),edit_department:$('#edit_department').val(),edit_status:$('#edit_status').val()},
            success: function(data) {
                if (data != "") {
                 
				   if(data=="OK"){
					 window.location="<?php echo base_url() ?>index.php/Dashboard/it_inventory";   
				   }else{

					  window.location="<?php echo base_url() ?>index.php/it/Dashboard/edit_details";
					
				   }
				   
				 
                }else{
				  
				}
            },
            error: function(err, message, xx) {

            }
		});	
	});
	
	
	
</script>

    
</html>