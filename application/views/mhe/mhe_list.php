    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Untitled Document</title>
    </head>
	<body>
 <div class="content-wrapper">
  <section class="content">
 
    <div  class="box-body compact">
  
    <div class="box-header">
    <h2 class="box-title">Material Handling Equipment Infromation</h2>
    </div>
   
     <br />    
     
    
   <table id="mhe_list" class="" >
   <thead>
    <th>Image</th>
    <th>Category</th>
    <th>Brand</th>
    <th>Model</th>
    <th>Fuel Type</th>
    <th>Capacity</th>
    <th>Mast</th>
    <th>Rotation</th>
    <th>Tilt Angle</th>
    <th>Supplier</th>
    <th>Supplier Contact Number</th>
  
    </thead>
     <tbody>
     <?php
	 foreach ($mhe_list as $mhe_lists){
	  ?>
     
     <tr><td>
     <?php 
	 $file_path="application/uploads/MHE/images/".$mhe_lists->master_id.".jpg";
	 if(file_exists($file_path)){ 
	 $file_path="application/uploads/MHE/images/".$mhe_lists->master_id.".jpg";
	 }else{
		 $file_path="application/uploads/MHE/images/default.jpg";

		 
	 }	 
	 ?>
     
       
 		
     
	<img src="<?php echo base_url()?><?php echo $file_path ?>" width="50" height="40"/>
     </td>
     <td><a href="<?php echo base_url()?>index.php/mhe/dashboard/mhe?mhe_number=<?php echo $mhe_lists->master_id ?>"><?php echo 		$mhe_lists->category_name."  ".$mhe_lists->mhe_number ?></a></td>
     <td><?php echo $mhe_lists->brand_name  ?></td>
     <td><?php echo $mhe_lists->model_name  ?></td>
     <td><?php echo $mhe_lists->fuel_type_name  ?></td>
     <td>
	 <?php echo $mhe_lists->capacity ; 
	 foreach( $unit_list as $unit_lists ){ 
	 if($mhe_lists->capacity_unit_id==$unit_lists->unit_id){ 
	 echo  "   ".$unit_lists->unit_name;	 }} ?> </td>
     <td><?php echo $mhe_lists->mast ; 
	 foreach( $unit_list as $unit_lists ){ 
	 if($mhe_lists->mast_unit_id==$unit_lists->unit_id){ 
	 echo  "   ".$unit_lists->unit_name;	 }} ?> 
	 
	 
	 </td>
     <td><?php echo $mhe_lists->rotation;
	
	 foreach( $unit_list as $unit_lists ){ 
	 if($mhe_lists->rotation_unit_id==$unit_lists->unit_id){ 
	 echo  "   ".$unit_lists->unit_name;	 }} ?>

   
     
     
     </td>
     <td><?php echo $mhe_lists->tilt_angle;
	 foreach($unit_list as $unit_lists){
		if($mhe_lists->tilt_angle_unit_id==$unit_lists->unit_id){
		echo "   ".$unit_lists->unit_name;	
		}
		 
	 }
	 
	 ?>
	 </td>
     <td><?php echo $mhe_lists->supplier ?></td>
     <td><?php echo $mhe_lists->contact_number  ?></td>
     
     <?php   }  ?>
     </tbody>
     </table>
     <br /><a style="width:200px"  class="btn btn-block btn-primary btn-sm"href="<?php echo base_url()?>index.php/mhe/dashboard/mhe" >Add New MHE</a>
     
     
       </div>
     
   
    
        </section>
        </div>
      
          
          
   </body>
   </html>

 <script>
     $('#mhe_list').dataTable( {
        "scrollY":        "300px",
        "scrollCollapse": true,
        "paging":         true,
		"iDisplayLength": 100
    } );
    
    </script>