<?php require_once('loader.php');
$i=0;
?>
<div class="content-wrapper"> 

  <section class="content">
  

  <div align="left" style="font-size:16px;font-weight:bold">  
    Avalable Shuttles		 
	</div><br />

  
  
  <table id="example" class="display table-striped dataTable" cellspacing="0" width="100%">
  <thead>
  <th>Shuttle Number</th>
  <th>Destination</th>
  <th>Container Number</th>
  <th>Vehicle Number</th>
  <th>Schedule date</th>
  </thead>
  <tbody>
  <?php foreach($list_detail as $list_details){ ?>
  <tr>
  <td>
  <input type="hidden" value="<?php echo $list_details->shuttle_number; ?>" id="shuttle_number"/>
  <a href="<?php echo base_url()?>index.php/asn/dashboard/shuttle_detail?shuttle_number=<?php echo $list_details->shuttle_number; ?>"><?php echo $list_details->shuttle_number; ?></a></td>
  <td><?php echo $list_details->destination; ?></td>
  <td><?php echo $list_details->container_number; ?></td>
  <td><?php echo $list_details->vehicle_number; ?></td>
  <td>
 <input class="datemask" style="height:30px;width:90px" onblur="date_time_shedual()" id="schedule_date" type="text"/>
  </td>
  </tr>
  
  <?php } ?>
  </tbody>
  </table>
   <input type="file" name="new_lp" id="new_lp" style="display:none" />
    <button type="button" class="btn btn-default btn-flat" id="new_lp_link">Upload new LPs</button>
  </section>

  </div>
  <script>
  function date_time_shedual(){
	
	 
	  $.ajax({
            url: '<?php echo base_url() ?>index.php/asn/dashboard/shuttle_date_scheduled',
            method: 'POST',
            data: {date:$('#schedule_date').val(),shuttle_number:$('#shuttle_number').val()},
            success: function(data) {
                if (data != "") {
                   alert(data);
				   
				 
                }
            },
            error: function(err, message, xx) {

            }
		});
  }
  
  $('.datemask').inputmask("9999-99-99");
	 $('#example').dataTable( {
        "scrollY":"300px",
        "scrollCollapse": true,
        "paging":false
		
    } );
	
	
	$("#new_lp_link").click(function() {
		$("#new_lp").click();
	});	
			
	$("#new_lp").change(function (){
		
		var myFormData = new FormData();
		myFormData.append('new_shuttle', this.files[0]);
		$.ajax({
		  url: '<?php echo base_url()?>index.php/asn/dashboard/shuttle_upload',
		  type: 'POST',
		  processData: false, // important
		  contentType: false, // important
		  enctype: 'multipart/form-data',
          encoding: 'multipart/form-data',
		  data: myFormData,
		  success: function(data){
			alert(data);
			//window.location = '<?php echo base_url()?>index.php/asn/dashboard/shuttle_detail?top=1000';
		  },
		  error:function(err,message,xx) {
			  alert(xx);
		  }
		});	
			
			});
  </script>