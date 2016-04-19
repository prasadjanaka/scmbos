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
    <div class="box-body compact">
    <div class="box-header" align="center">
   
  
   
    <?php if(empty($mhe_num)){ 	?>
	<h5 class="box-title" style="font-weight:600;font-size:x-large">Add New Material Handling Equipment</h5>
	
 
  
    
`   
	<?php  }else{?>
	 <h5 class="box-title" style="font-weight:600;font-size:x-large">Edit Material Handling Equipment</h5>

	 <?php  }?>

     <table style="width:600px" align="center" class="table table-bordered" >
     <tr>
     <td width="158px"><strong>Select Photo</strong></td>
     <td>
     <?php 
	 $file_path="application/uploads/MHE/images/".$mhe_num.".jpg";
	 if(file_exists($file_path)){ 
	 $file_path="application/uploads/MHE/images/".$mhe_num.".jpg";
	 }else{
		 $file_path="application/uploads/MHE/images/default.jpg";

		 
		 }
	 
	 
	 ?>
     <img src="<?php  echo base_url()?><?php echo $file_path ?>" width="275" height="183"></img>
       <input type="file" id="pid" name="photo" onchange="previewFile()"></input>
     </td>
     </tr>
      <tr>
     <td><strong>MHE Number</strong> </td>
     <td>
     <input type="text" value="<?php echo $number; ?>" name="mhe_number" id="mhe_number" class="form-control"/>
     </td>
     </tr>
     <tr>
     <td><strong>MHE Category</strong> </td>
     <td>
    
     <select id="mhe_category"  class="form-control" name="category"  required="required">
     <option value="0"></option>
    
     <?php foreach($category as $categorys){ ?>
     <?php $selected=($categorys->category_name==$category_name ?"selected":"")?>
     <option <?php echo $selected  ?>  value="<?php echo $categorys->category_id ?>"><?php echo $categorys->category_name ?></option>
    
     <?php } ?>
     </select>
     </td>
     </tr>
      <tr>
     <td><strong>MHE Brand</strong> </td>
     <td>
     <select onchange="selectModel()" id="mhe_brand" class="form-control" name="brand"  required="required">
     <option></option>
     <?php foreach($brand as $brands){ ?>
     <?php $select=($brands->brand_name==$brand_n ?"selected":"")?>
     <option <?php echo $select ?> value="<?php echo $brands->brand_id ?>"><?php echo $brands->brand_name ?></option>
     <?php } ?>
     </select>
     </td>
   
     </tr>
       <tr>
     <td><strong>MHE Model</strong> </td>
     <td>
     <select class="form-control" name="model" id="mhe_model"  required="required"> 
     <option></option>
     <?php foreach($model as $models){ ?>
     <?php $select=($models->model_name==$model_name ?"selected":"")?>
     <option <?php echo $select ?> value="<?php echo $models->model_id ?>"><?php  echo $models->model_name ?></option>
     <?php } ?>
     </select>
     </td>
       <td>
       <a href="#" onclick="show()" ><img src=<?php echo base_url()."/"?>application/uploads/MHE/images/addmodel.png width="40" height="30" /></a>
   
     </td>
     </tr>
       <tr>
     <td><strong>Fuel Type</strong> </td>
     <td>
     <select class="form-control" name="fuel" id="mhe_fuel" required="required">
     <option></option>
     <?php foreach($fuel as $fuels){ ?>
     <?php $select=($fuels->fuel_type_name==$fuel_type ?"selected":"")?>
     <option <?php echo $select ?> value="<?php echo $fuels->fuel_type_id ?>"><?php echo $fuels->fuel_type_name ?></option>
     <?php } ?>
     </select>
     </td>
     </tr>
     <tr>
     <td><strong>Supplier</strong> </td>
     <td>
     <select class="form-control" name="supplier" id="mhe_supplier" required="required">
     <option></option>
     <?php foreach($supplier as $suppliers){ ?>
      <?php $select=( $suppliers->supplier==$supplier_name ?"selected":"")?>
     <option <?php echo $select ?> value="<?php echo $suppliers->supplier_id ?>"><?php echo $suppliers->supplier ?></option>
     <?php } ?>
     </select>
     </td>
     </tr>
     
     
     <tr>
    <td><strong>Payment Term</strong> </td>
     <td>
     <select class="form-control" name="payment" id="mhe_payment" required="required">
     <option></option>
     <?php foreach($payment as $payments){ ?>
     <?php $select=($payments->payment_term_type==$payment_term ?"selected":"")?>
    <option <?php echo $select ?> value="<?php echo $payments->payment_term_id ?>"><?php echo $payments->payment_term_type ?></option>
     <?php } ?>
     </select>
     </td>
     </tr>
      <tr>
    <td><strong>Status</strong> </td>
     <td>
     <select class="form-control" name="status" id="mhe_status" required="required">
     <option></option>
     <?php foreach($status as $all_status){ ?>
     <?php $select=($all_status->status==$status_type ?"selected":"")?>
     <option <?php echo $select ?> value="<?php echo $all_status->status_id ?>"><?php echo $all_status->status ?></option>
     <?php } ?>
     </select>
     </td>
     </tr>
     </table>
     
     
     
     
     <table  style="width:600px" align="center" class="table table-bordered">
     <tr >
     <td style="width:158px"><strong>Capacity</strong></td>
    
     <td >
     <input type="text" id="capacity" name="capacity" value="<?php echo $capacity_count; ?>" class="form-control" />
     </td>
     <td style="text-align:center;"><strong>Unit</strong></td>
     <td>
     <select  class="form-control" name="unit" id="mhe_capacity" required="required">
     <option></option>
     <?php foreach($unit as $units){ ?>
     <?php $select=($units->unit_id ==$capacity_unit ?"selected":"")?>
     <option <?php echo $select ?> value="<?php echo $units->unit_id ?>"><?php echo $units->unit_name ?></option>
     <?php } ?>
     </select>
     
     </td>
 	<td></td>
    <td></td>
    <td></td>
    <td></td>
     </tr>
     <tr>
     <td style="width:158px"><strong>Mast</strong></td>
       <td>
     <input type="text" id="mast" name="mast" value="<?php echo $mast ?>" class="form-control" />
     </td>
     <td style="text-align:center;"><strong>Unit</strong></td>
     <td>
     <select class="form-control" name="mhe_mast" id="mhe_mast" required="required">
     <option></option>
     <?php foreach($unit as $units){ ?>
     <?php $select=($units->unit_id==$mast_unit ?"selected":"")?>
     <option <?php echo $select ?> value="<?php echo $units->unit_id ?>"><?php echo $units->unit_name ?></option>
     <?php } ?>
     </select>
     
     </td>
   
     </tr>
     <tr>
     <td style="width:158px"><strong>Rotation</strong></td>
       <td>
     <input type="text" id="rotation" value="<?php echo $rotation ?>" class="form-control" />
     </td>
     <td style="text-align:center;"><strong>Unit</strong></td>
     <td>
     <select class="form-control" name="unit" id="mhe_rotation" required="required">
     <option></option>
     <?php foreach($unit as $units){ ?>
     <?php $select=($units->unit_id==$rotation_unit ?"selected":"")?>
     <option <?php echo $select ?> value="<?php echo $units->unit_id ?>"><?php echo $units->unit_name ?></option>
     <?php } ?>
     </select>
     
     </td>
   
     </tr>
     <tr>
     <td style="width:158px"><strong>Tilt Angel</strong></td>
     <td>
     <input type="text" id="tilt"  value="<?php echo $tilt ?>" class="form-control" />
     </td>
     <td style="text-align:center;"><strong>Unit</strong></td>
     <td>
     <select class="form-control" name="unit" id="mhe_tilt" required="required">
     <option></option>
     <?php foreach($unit as $units){ ?>
     <?php $select=($units->unit_id==$tilt_unit ?"selected":"")?>
     <option <?php echo $select ?> value="<?php echo $units->unit_id ?>"><?php echo $units->unit_name ?></option>
     <?php } ?>
     </select>
     
     </td>
   
     </tr>
 
    <tr>
    <td></td>
    <?php if(empty($mhe_num)){ ?>
    <td><input type="button"  id="save" name="save" value="Save" class=" btn btn-block btn-primary"/></td>
   
    <?php }else{ ?>
    <td>
    <input type="button"  id="edit" name="edit" value="Save" class=" btn btn-block btn-primary"/>
    </td>
   <!-- </FORM>  -->
   
    <?php } ?>
   
    <td></td>
    <td>
    <form action="<?php echo base_url()?>index.php/mhe/dashboard/mhe_list" method="post" enctype="multipart/form-data">
   <input type="submit" id="list" name="list" value="MHE List" class=" btn btn-block btn-primary"/>
   </form>
   </td>
   </tr>
    </table>
 

  
    </div>
    </section>
    
    </div>


   <div id="popup">
                <!-- Popup Div Starts Here -->
                <div id="popupContact">
                    <!-- Contact Us Form -->
                    <form action="#" id="form" method="post" name="form">
 
				
                    <a class="pull-right" style="cursor:pointer" onclick="hide()"><i class="fa fa-fw fa-times-circle" id="id"></i></a>
                        <h2>Add New Model</h2>
                        <hr>

                        <div class="form-group">
                            <label class="form-control" for="exampleInputPassword1">Select Brand</label>
                           <select class="form-control" name="select_brand"  required="required" id="brand_id">
     						<option></option>
   						  <?php foreach($brand as $brands){ ?>
  						   
   					  <option value="<?php echo $brands->brand_id ?>"><?php echo $brands->brand_name ?></option>
   					  <?php } ?>
   					  </select>
                            <br />
							<label class="form-control" for="exampleInputPassword1">Add New Model</label>
                            <input class="form-control" id="new_model"  name="new_model" value=""  type="text">

                        </div>
                        
						<input type="button" value="Save" id="add_model" class=" btn btn-block btn-primary"/>

                        

                    </form>
                </div>
                <!-- Popup Div Ends Here -->
            </div>


    </body>


   <script type="text/javascript">
   

   
   function show(){
	document.getElementById('popup').style.display = "block";   
   }
   
    function hide(){
		
	document.getElementById('popup').style.display = "none"; 
	document.getElementById('brand_id').value="";  
	document.getElementById('new_model').value="";
   }
   
   

 		$("#mhe_number").focusout(function(e) {
       $.ajax({
				  url: '<?php echo base_url()?>index.php/mhe/dashboard/mhe_ex',
				  method: 'POST',
				data: {mhe_num:$("#mhe_number").val()},
                             
				  success: function(data){
					  if(data>0){
						alert("MHE No Already Exist");
					
					  }
					
					
				  },
				  error:function(err,message,xx) {
					 
				  }	  
				});
		
		
		
    });
	
	
 
 
 
   function selectModel(){
	
	$.ajax({

            type: "POST",

            url: '<?php echo base_url() ?>index.php/mhe/dashboard/select_model',

            data: ({brand_id: $('#mhe_brand').find(":selected").val()}),
 
            success: function(data) {
				 $('#mhe_model').empty();
				 var myString = data;
				var arr2 = myString.split('/');
				//var arr = myString.split(',');
				for(var i=1;arr2.length>i;i++){
					var arr=arr2[i].split(',');
					//for(var a=0;arr[i].length>a;a++){
						 var newOption = $('<option value='+arr[0]+' >'+arr[1] +'</option>');	
				
				  $('#mhe_model').append(newOption);
						//}
					
					}
				
				//$("option['mhe_model']").remove();	
			
				
				
				for(var a=0;arr.length>a;a++){
					 
				
					}
			
	

            }

        });
   }
 
 
  $(document).ready(function(e) {
	 
	
	 
	  
	  $('#add_model').click(function (){
		 
		 if($("#brand_id option:selected").text() =="" || $("#new_model").val() ==""){	
	alert("Please Insert Details");	
	}else{
		
	
		
		//alert();
		  $.ajax({
            url: '<?php echo base_url() ?>index.php/mhe/dashboard/add_new_model',
            method: 'POST',
            data: {newbrand_id: $('#brand_id').find(":selected").val(),new_model:$('#new_model').val()},
            success: function(data) {
               
                   // alert(ok);
					if (data ==1) {
                    alert("Add New Record");
					 
					document.getElementById('popup').style.display = "none";	
					document.getElementById('brand_id').value="";  
					document.getElementById('new_model').value="";
					 
					 
                }else{ 
				 window.location = '<?php echo base_url() ?>index.php/mhe/dashboard/add_new_model';
				//window.location.pathname ="index.php/mhe/dashboard/add_new_model"
				}
					
					
               
            },
            error: function(err, message, xx) {

            }
        });
		} 
	  });
	  

   $('#save').click(function () {
	var tt=$("#mhe_number").val();			
	if($("#mhe_category option:selected") && $("#mhe_brand option:selected") && $("#mhe_model option:selected") && 
	$("#mhe_fuel option:selected") && $("#mhe_supplier option:selected") && $("#mhe_payment option:selected") && 
	$("#mhe_status option:selected") && $("#mhe_capacity option:selected")  && $("#mhe_mast option:selected") && 
	$("#mhe_rotation option:selected") && $("#mhe_tilt option:selected").text() ==""){	
	alert("Please Insert Details");	
	}else if(tt == ""){
	alert("Please Insert Details");
	
	}else{
	var myFormData = new FormData();
	
	//this.files[0]
	 var file = document.getElementById("pid").files[0]; 
	// alert(file);
	 var condition="";
	if(file!=null){
		condition="abc";}
		else{
			condition="";
			}
	myFormData.append('photo', file );
	myFormData.append('mhe_client_number', $('#mhe_number').val());
	myFormData.append('category_id', $('#mhe_category').find(":selected").val());
	myFormData.append('brand_id', $('#mhe_brand').find(":selected").val());
	myFormData.append('model_id',  $('#mhe_model').find(":selected").val());
	myFormData.append('fuel_id', $('#mhe_fuel').find(":selected").val());
	myFormData.append('payment_id', $('#mhe_payment').find(":selected").val());
	myFormData.append('status_id', $('#mhe_status').find(":selected").val());
	myFormData.append('capacity', $('#capacity').val());
	myFormData.append('capacity_id', $('#mhe_capacity').find(":selected").val());
	myFormData.append('mast', $('#mast').val());
	myFormData.append('mast_id',$('#mhe_mast').find(":selected").val());
	myFormData.append('rotation', $('#rotation').val());
	myFormData.append('rotation_id', $('#mhe_rotation').find(":selected").val());
	myFormData.append('tilt', $('#tilt').val());
	myFormData.append('tilt_id', $('#mhe_tilt').find(":selected").val());
	myFormData.append('supplier_id', $('#mhe_supplier').find(":selected").val());
	myFormData.append('condition',condition );		
		//alert($('#mhe_number').text());
	$.ajax({
		url: '<?php echo base_url() ?>index.php/mhe/dashboard/mhe',
		type: 'POST',
		processData: false, // important
		contentType: false, // important
		enctype: 'multipart/form-data',
		encoding: 'multipart/form-data',
		data: myFormData,
		success: function(data,ok){
		alert(ok);
	
		
	 window.location = '<?php echo base_url() ?>index.php/mhe/dashboard/mhe';
	
		},
		error:function(err,message,xx) {
		alert(xx);
		}
		}); 
        }                
  }); 
   
  
    $('#edit').click(function () {
	//boolean b=true;
	var b=new Boolean(false);
	var pid=document.getElementById('pid');
	var mhe_number=document.getElementById('mhe_number');
	var mhe_category=document.getElementById('mhe_category');
	var mhe_brand=document.getElementById('mhe_brand');
	var mhe_model=document.getElementById('mhe_model');
	var mhe_fuel=document.getElementById('mhe_fuel');
	var mhe_supplier=document.getElementById('mhe_supplier');
	var mhe_payment=document.getElementById('mhe_payment');
	var mhe_status=document.getElementById('mhe_status');
	var capacity=document.getElementById('capacity');
	var mhe_capacity=document.getElementById('mhe_capacity');
	var mast=document.getElementById('mast');
	var mhe_mast=document.getElementById('mhe_mast');
	var rotation=document.getElementById('rotation');
	var tilt=document.getElementById('tilt');
	var mhe_tilt=document.getElementById('mhe_tilt');
	//if (!job.options[job.selectedIndex].defaultSelected) alert("#job has changed");
 if(mhe_number.value!=mhe_number.defaultValue){ 
	b=true;
	
	}else if(pid.value!=pid.defaultValue){ 
	b=true;	
	
	
	}else if(!mhe_category.options[mhe_category.selectedIndex].defaultSelected){ 
	b=true;	
	
	}else if(!mhe_brand.options[mhe_brand.selectedIndex].defaultSelected){ 
	b=true;	
	
	}else if(!mhe_model.options[mhe_model.selectedIndex].defaultSelected){ 
	b=true;	

	}else if(!mhe_fuel.options[mhe_fuel.selectedIndex].defaultSelected){ 
	b=true;	

	}else if(!mhe_supplier.options[mhe_supplier.selectedIndex].defaultSelected){ 
	b=true;	
	}else if(!mhe_payment.options[mhe_payment.selectedIndex].defaultSelected){ 
	b=true;	
	}else if(!mhe_status.options[mhe_status.selectedIndex].defaultSelected){ 
	b=true;	
	}else if(mast.value!=mast.defaultValue){ 
	b=true;	
	}else if(capacity.value!=capacity.defaultValue){ 
	b=true;	
	}else if(rotation.value!=rotation.defaultValue){ 
	b=true;	
	}else if(tilt.value!=tilt.defaultValue){ 
	b=true;	
	}else if(!mhe_capacity.options[mhe_capacity.selectedIndex].defaultSelected){ 
	b=true;	
	}else if(!mhe_mast.options[mhe_mast.selectedIndex].defaultSelected){ 
	b=true;	
	}else if(!mhe_rotation.options[mhe_rotation.selectedIndex].defaultSelected){ 
	b=true;	
	}else if(!mhe_tilt.options[mhe_tilt.selectedIndex].defaultSelected){ 
	b=true;	
	}
	
	if(b==false){
	//b=true;
		alert(" No Update Found");
	}else{
		
	var myFormData = new FormData();
	
	
	 var file = document.getElementById("pid").files[0]; 
	
	 var condition="";
	if(file!=null){
		condition="abc";}
		else{
			condition="";
			}
	myFormData.append('photo', file );
	
	myFormData.append('mhe_client_number', $('#mhe_number').val());
	myFormData.append('category_id', $('#mhe_category').find(":selected").val());
	myFormData.append('brand_id', $('#mhe_brand').find(":selected").val());
	myFormData.append('model_id',  $('#mhe_model').find(":selected").val());
	myFormData.append('fuel_id', $('#mhe_fuel').find(":selected").val());
	myFormData.append('payment_id', $('#mhe_payment').find(":selected").val());
	myFormData.append('status_id', $('#mhe_status').find(":selected").val());
	myFormData.append('capacity', $('#capacity').val());
	myFormData.append('capacity_id', $('#mhe_capacity').find(":selected").val());
	myFormData.append('mast', $('#mast').val());
	myFormData.append('mast_id',$('#mhe_mast').find(":selected").val());
	myFormData.append('rotation', $('#rotation').val());
	myFormData.append('rotation_id', $('#mhe_rotation').find(":selected").val());
	myFormData.append('tilt', $('#tilt').val());
	myFormData.append('tilt_id', $('#mhe_tilt').find(":selected").val());
	myFormData.append('supplier_id', $('#mhe_supplier').find(":selected").val());
	myFormData.append('mhe_number', <?php if(!empty($mhe_num)){ echo $mhe_num;}else{ echo "0";}   ?>);
	myFormData.append('condition',condition );



	
		$.ajax({
		url: '<?php echo base_url() ?>index.php/mhe/dashboard/mhe',
		type: 'POST',
		processData: false, // important
		contentType: false, // important
		enctype: 'multipart/form-data',
		encoding: 'multipart/form-data',
		data: myFormData,
		success: function(data,ok){
		alert(ok);
		location.reload();
		
		//window.location = 'http://localhost/index.php/asn/dashboard/asn?asn_number=201509240002';
		},
		error:function(err,message,xx) {
		alert(xx);
		}
		});
		
	} 
		 }); 
		//alert(data3);	
   });
   </script>


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
  
 </html>
