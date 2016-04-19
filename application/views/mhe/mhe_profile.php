<?php require_once('loader.php');?>
<div class="content-wrapper">
  <section class="content">
    <div align="center" class="box-body compact">
    <div style="font-size:20px;font-weight:bold">MHE PROFILE</div>
   <?php foreach($mhe_list as $mhe_lists){   ?> 
   
    <table style="width:30%;background-color:#FFF" class="table display  dataTable">
  <tr><td><img style="width:150px;height:100px" src="/application/uploads/MHE/images/<?php echo $mhe_lists->master_id ?>.jpg" alt="No Image"></td></tr>
  
    <tr>
    <td style="width:150px;font-weight:bold;font-size:16px">MHE ID</td>
    <td style="font-weight:bold;font-size:16px">:</td>
    <td ><?php  echo $mhe_lists->mhe_number ?></td>
    </tr>
    
    <tr>
    <td style="width:150px;font-weight:bold;font-size:16px">MHE CATEGORY</td>
     <td style="font-weight:bold;font-size:16px">:</td>
    <td><?php  echo $mhe_lists->category_name ?></td>
    </tr>
    
    <tr>
    <td style="width:150px;font-weight:bold;font-size:16px">MHE BRAND</td>
     <td style="font-weight:bold;font-size:16px">:</td>
    <td><?php  echo $mhe_lists->brand_name?></td>
    </tr>
    
     <tr>
    <td style="width:150px;font-weight:bold;font-size:16px">MHE MODEL</td>
     <td style="font-weight:bold;font-size:16px">:</td>
    <td><?php  echo $mhe_lists->model_name ?></td>
    </tr>
    
      <tr>
   <td style="width:150px;font-weight:bold;font-size:16px">FUEL TYPE</td>
    <td style="font-weight:bold;font-size:16px">:</td>
   <td ><?php  echo $mhe_lists->fuel_type_name ?></td>
   </tr>
   
   <tr>
   <td style="width:150px;font-weight:bold;font-size:16px">SUPPLIER</td>
    <td style="font-weight:bold;font-size:16px">:</td>
   <td><?php  echo $mhe_lists->supplier ?></td>
   </tr>
   
   <tr>
   <td style="width:150px;font-weight:bold;font-size:16px">PAYMENT TERM</td>
    <td style="font-weight:bold;font-size:16px">:</td>
   <td><?php  echo $mhe_lists->payment_term_type?></td>
   </tr>
   
    <tr>
    <?php  ?>
   <td style="width:150px;font-weight:bold;font-size:16px">CAPACITY</td>
    <td style="font-weight:bold;font-size:16px">:</td>
   <td align="left" ><?php  echo $mhe_lists->capacity ?> </td>
   <td><?php  foreach($unit as $units){   if($mhe_lists->capacity_unit_id==$units->unit_id){ echo $units->unit_name;} }?></td>
   
   </tr>
	<tr>
	 <td style="width:150px;font-weight:bold;font-size:16px">MAST</td>
      <td style="font-weight:bold;font-size:16px">:</td>
   <td><?php  echo $mhe_lists->mast ?></td>
   <td><?php foreach($unit as $units){ if($mhe_lists->mast_unit_id==$units->unit_id){ echo $units->unit_name;}}  ?></td>
	</tr>
	<tr>
    <td style="width:150px;font-weight:bold;font-size:16px">ROTATION</td>
    
     <td style="font-weight:bold;font-size:16px">:</td>
   <td><?php  echo $mhe_lists->rotation ?></td>
<td><?php   foreach($unit as $units){   if($mhe_lists->rotation_unit_id==$units->unit_id){ echo $units->unit_name;} } ?></td>
	</tr>
    <tr>
     <td style="width:150px;font-weight:bold;font-size:16px">TILT ANGEL</td>
      <td style="font-weight:bold;font-size:16px">:</td>
   <td><?php  echo $mhe_lists->tilt_angle ?></td>
    <td><?php  foreach($unit as $units){   if($mhe_lists->tilt_angle_unit_id==$units->unit_id){ echo $units->unit_name;} } ?></td>
   <?php  }?>
    </tr>
   
   
   <tr><td><input class="btn btn-primary " style="width:150px"  id="edit"type="button" value="Edit Mhe" onClick=""></td>
   
   </tr>
    </table>

    <?php // }?>
    
 
    </div>
    </section>
    </div>
    <script>
	$("#edit").click(function () {
window.location.pathname ="index.php/mhe/Dashboard/mhe?mhe_number=<?php echo $mhe_lists->master_id ?>";

	 });   
	
	</script>