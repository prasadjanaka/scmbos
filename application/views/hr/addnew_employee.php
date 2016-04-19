    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Untitled Document</title>
    </head>
	<body>
    <div class="content-wrapper">
    <section class="content">
    <div class="box-body compact">
    <div class="box-header" align="center">
    
    <?php if($epf==""){  ?>
     <h5 class="box-title" style="margin-left:130px;font-weight:600;font-size:x-large">Add New Employee</h5>
    
    <?php }else{?>
    
    <h5 class="box-title" style="margin-left:130px;font-weight:600;font-size:x-large">Edit Employee</h5>
   
    <?php }?>
    </div>
   
    <?php  
	if($epf==""){
	?>
     <form action="<?php echo base_url()?>index.php/hr/Dashboard/addnew_employee" method="post" enctype="multipart/form-data">   
    <?php
	}else{
	?>
      
    <?php	
		
	}
	?>
    
                 
    <table style="width:600px" align="center" class="table table-bordered" >
    
    
    
      <tbody>
       <tr>
       <td><strong>Select Photo</strong></td>
       <td>
       
       <?php
       if($photo==""){
		?>
       <img src="../../../skin/images/default_photo.jpeg" width="132px" height="170px" />
       <?php
		}else{
		?>  
        <img name="pp" src="<?php echo "/".$photo ?>" width="132px" height="170px">
        <?php
		}
		?>
       
       <input type="file" name="photo" id="pid" onchange="previewFile()">
       </td>
        </tr>
        <tr>
          <td><strong>EPF Number</strong></td>
          
          <td><input id="epf" <?php  if($epf!=""){?> readonly <?php }   ?> type="text" name="epf_number" class="form-control" value="<?php echo $epf   ?>" placeholder="EPF number" required="required"/></td>
        </tr>
        <tr >
          <td><strong>Name</strong></td>
          <td><input type="text" id="name" name="name" class="form-control" placeholder="name" value="<?php  echo $name?>" required="required"/></td>
        </tr>
        <tr >
          <td><strong>Address</strong></td>
          <td><input type="text" id="address" name="address" class="form-control" value="<?php echo $address ?>" placeholder="address" required="required"/></td>
        </tr>
        <tr>
          <td><strong>Date Joined</strong></td>
          <td><div class="input-group">
          <div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
        <input class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="" type="text" name="date_joined" 			required="required" id="date_joined" value="<?php echo $date_joined ?>">
            </div></td>
        </tr>
        <tr >
        <td><strong>Gender</strong></td>
        
        
         <td><select class="form-control" name="gender" required="required" id="gender">
 
        <option></option>
        <?php foreach($genders_load as $genders1){ ?> 
        <?php $select=($genders1->gender==$gender?"selected":"")?>
       
	    <option <?php echo $select ?> value="<?php echo $genders1->gender_id ?>"><?php echo $genders1->gender ?></option >
        <?php } ?>
      
        </select></td>
        </tr>
        <tr>
        <td><strong>Email</strong></td>
        <td><input type="text" id="email" name="email" class="form-control" value="<?php echo $email?>" placeholder="email" required="required"/></td>
        </tr>
        <tr>
        <td><strong>Contact Number</strong></td>
        <td><input type="text" name="contact" id="contact" class="form-control" placeholder="phone number" required="required" value="<?php echo $contact?>"/></td>
        </tr>
        <tr>
         <td><strong>Section</strong></td>
         <td>
         <select class="form-control" name="section" required="required" id="section">
         <option></option>
       
         <?php foreach($section_load as $sections){ ?>
         <?php $select=($sections->section_name==$all_section?"selected":"")?>
         <option <?php echo $select?> value="<?php echo $sections->section_id ?>"><?php echo $sections->section_name ?></option>
         <?php }?>
        </select>
        </td>
        </tr>
        <tr>
          <td><strong>Job Category</strong></td>
          <td><select class="form-control" id="category" name="category" required="required">
          <option></option>
             
         <?php foreach($category_load as $categorys){ ?>
         <?php $select=($categorys->job_category==$jobcategory ?"selected":"")?>
         <option <?php echo $select ?> value="<?php echo $categorys->job_category_id ?>"><?php echo $categorys->job_category ?></option>
              <?php }?>
            </select></td>
        </tr>
        <tr>
          <td><strong>Designation</strong></td>
          <td><select id="designation" name="designation" class="form-control"  required="required">
          <option ></option>
              <?php foreach($designation_load as $designations){ ?>
              <?php $select=($designations->designation==$designation ?"selected":"")?>
              
              <option <?php   echo $select ?> value="<?php echo $designations->designation_id ?>"><?php echo $designations->designation ?></option>
              
              <?php } ?>
              
            </select></td>
       
       </tr>
       <tr>
      <td></td>
      <?php  
	if($epf==""){
	?>
      <td ><input type="submit"  value="Save" class=" btn btn-block btn-primary"/></td>
    <?php
	}else{
	?>
      <td ><input type="submit" id="sub" value="Save" class=" btn btn-block btn-primary"/></td>
    <?php	
		
	}
	?>
      
      <td ><input type="submit" id="list" value="List Employee" class=" btn btn-block btn-primary"/></td>
      </tr>
      </tbody>
     
    </table>
      </form>
 
     
    <script type="text/javascript">
	
	$(document).ready(function(e) {
		$('#list').click(function(){
		 window.location = '<?php echo base_url() ?>index.php/hr/dashboard/list_employee';	
			
		});
		
		
        $('#sub').click(function (){
	
	
		
	var myFormData=new FormData();
	var file = document.getElementById("pid").files[0]; 
	//alert(file);
	var condition="";
	if(file!=null){
		condition="abc";}
		else{
			condition="";
			}
	myFormData.append('photo', file );
	
	myFormData.append('epf_number',$('#epf').val());
	myFormData.append('name',$('#name').val());
	myFormData.append('address',$('#address').val());
	myFormData.append('date_joined',$('#date_joined').val());
	myFormData.append('email',$('#email').val());
	myFormData.append('contact',$('#contact').val());
	myFormData.append('gender',$('#gender').find(":selected").val());	
	myFormData.append('section',$('#section').find(":selected").val());
	myFormData.append('category',$('#category').find(":selected").val());
	myFormData.append('designation',$('#designation').find(":selected").val());		
	myFormData.append('con',condition);
	$.ajax({
		url: '<?php echo base_url() ?>index.php/hr/dashboard/edit_employee_ajax',
		type: 'POST',
		processData: false, // important
		contentType: false, // important
		enctype: 'multipart/form-data',
		encoding: 'multipart/form-data',
		data: myFormData,
		success: function(data,ok){
		alert(ok);
		//window.location = 'http://localhost/index.php/asn/dashboard/asn?asn_number=201509240002';
		},
		error:function(err,message,xx) {
		alert(xx);
		}	
		});
		
			});
		
    });
	
	   
	
	$("#epf").focusout(function(e) {
       $.ajax({
				  url: '<?php echo base_url()?>index.php/hr/Dashboard/epf_ex',
				  method: 'POST',
				data: {epf:$("#epf").val()},
                             
				  success: function(data){
					  if(data>0){
						alert("EPF No Already Exist");
					
					  }
					
					
				  },
				  error:function(err,message,xx) {
					 
				  }	  
				});
		
		
		
    });
	
	
	
	
          $(function () {
            //Datemask dd/mm/yyyy
            $("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
            
            $("[data-mask]").inputmask();
    
            //Date range picker
          });
        </script>'' 
        <script>
       function previewFile(){
           var preview = document.querySelector('img'); //selects the query named img
           var file    = document.querySelector('input[type=file]').files[0]; //sames as here
           var reader  = new FileReader();
    
           reader.onloadend = function () {
               preview.src = reader.result;
           }
    
           if (file) {
               reader.readAsDataURL(file); //reads the data as a URL
           } else {
               //preview.src = "";
           }
      }
    
      //previewFile();  //calls the function named previewFile()
      </script> 
  
    </body>
