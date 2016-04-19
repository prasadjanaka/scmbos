    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Untitled Document</title>
    </head>
    
    <body>
    <div class="content-wrapper"> 
      <!-- Content Header (Page header) -->
    <section class="content-header">
    <section class="content">
    <div class="row">
    <div class="col-xs-12">
    <div class="box">
    <div class="box-header">
    <h5 class="box-title">Employee Infromation</h5>
    </div>
       
     <a style="width:200px"  class="btn btn-block btn-primary btn-sm"href="<?php echo base_url()?>index.php/hr/Dashboard/addnew_employee" >Add New Employee</a>  
     <br />           
    <table id="emp_list" class="table" >
   <thead>
   <th>Print</th>
    <th>Image</th>
    <th>EPF Number</th>
    <th>Name</th>
    <th>Address</th>
    <th>Gender</th>
    <th>Email</th>
    <th>Date Joined</th>
    <th>Contact Number</th>
    <th>Job Category</th>
    <th>Section</th>
    <th>Designation</th>
    </thead>
     <tbody>
    <?php foreach($posts as $post){?>
   <tr>
   <td>
   <a href="<?php echo base_url()?>index.php/hr/Dashboard/view_profile?epf_number=<?php echo $post->epf_number ?>" target="_blank" ><img width="20px;" src="../../../skin/images/printer.png"/></a>
   </td>
    <td> <img class="direct-chat-img" src="<?php echo base_url().$post->photo_path  ?>" alt="message user image"></img></td>
    <td><a href="addnew_employee?epf_number=<?php  echo$post->epf_number   ?>"><?php echo $post->epf_number; ?></a></td>
    <td><?php echo $post->name; ?></td>
    <td><?php echo $post->address; ?></td>
   
    <td><?php echo $post->gender; ?></td>
  
    <td><?php echo $post->email; ?></td>
    <td><?php echo $post->date_joined; ?></td>
    <td><?php echo $post->contact_number; ?></td>
    <td><?php echo $post->job_category; ?></td>
    <td><?php echo $post->section_name; ?></td>
    <td><?php echo $post->designation; ?></td>
    
    
    </tr>
    <?php
    }
    ?></tbody>
    </table>
    </div>
    </div>
    </div>
    </section>
    </section>
    </div>
    </body>
    </html>
    <script>
     $('#emp_list').dataTable( {
        "scrollY":        "300px",
        "scrollCollapse": true,
        "paging":         true
    } );
    
    </script>