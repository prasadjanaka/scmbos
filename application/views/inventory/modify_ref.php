<?php require_once('loader.php');
date_default_timezone_set("Asia/Colombo");
?>


<div class="content-wrapper">
  <section class="content ">
    <div class="box-body compact"> 
    	<table  class="table">
        	<tr>
            	<td style="width:100px;font-weight:bold">Reference :</td>
                <td style="width:150px"><?php echo $ref_val; ?></td>
               <td style="width:100px;font-weight:bold">Scanner :</td>
                <td><?php echo $scanner_name; ?></td>
            </tr>
            <tr>
                 <td style="width:100px;font-weight:bold">Date :</td>
                <td><?php echo $date; ?></td>
            </tr>
        </table>
    	
        <table class="table" id="example">
        <thead>
        	<tr>
            	<th align="left" style="width:60px;text-align:center" >Remove</th>
                <th align="left" style="width:150px">Sub Zones</th>
                <th align="left" style="width:250px">Target Reference</th>
                <th align="left" style="width:150px">&nbsp;</th>
                <th align="left">Status</th>
            </tr>
        </thead>
        
        <tbody>
        <?php  foreach($ref_list->result() as $ref){ ?>
        	
        	<?php 
				$condition =false; 
				if($ref->status_id < 3 and  $ref->count_number < 2)$condition =true;
			?>
        	<tr>
            	<td align="left" style="text-align:center"><?php  if($condition){ ?> <a href="#" ><span id="remove_count[]" count_id = "<?php echo $ref->count_id ?>" class="glyphicon glyphicon-remove"></span> </a> <?php } ?></td>
                <td align="left"><?php  echo $ref->sub_zone ?></td>
              <td align="left"><?php  if($condition){ ?> <input name="target_reference[]" type="text" class="form-control" style="height:25px" id="target_reference[]" value="" /> <?php } ?></td>
                <td align="left"><?php  if($condition){ ?> <input count_id = "<?php echo $ref->count_id ?>" name="btn_move[]" type="button" class="btn btn-block btn-default btn-xs" id="btn_move[]" value="Move" /> <?php } ?></td>
                <td align="left"><?php  echo $ref->status; ?></td>
            </tr>
          <?php  } ?>  
        </tbody>
        </table>
    
    </div>
  </section>
</div>

<script>

$('#example').dataTable( {
	"scrollY":        "350px",
	"scrollCollapse": true,
	"paging":         false
});

$('[id^="remove_count"]').click(function(){
	

		if(!confirm("Are you sure that you need to remove this count record?")) return false;
		
		var count_id = $(this).attr('count_id');	
		$.ajax({url: '<?php echo base_url() ?>index.php/inventory/Count_ref_manager/remove_count_reference',
		  method: 'POST',
		  data: {count_id:count_id},
		  success: function(data) {
			if(data!=""){
				alert(data);
				location.reload();
			}else{ location.reload();}
			},
			error: function(err, message, xx) {alert(xx);}
		});	

});	


$('[id^="btn_move"]').click(function(){

	var target_reference = ($('[id^="target_reference"]')[$('[id^="btn_move"]').index(this)].value);
	if($.trim(target_reference)==''){
		alert('Please eneter a valid Target Reference to move this sub zone');
		return false;	
	}else{
		if(!confirm("Are you sure that you need to move this reference?")) return false;
		
		var count_id = $(this).attr('count_id');	
		$.ajax({url: '<?php echo base_url() ?>index.php/inventory/Count_ref_manager/move_reference',
		  method: 'POST',
		  data: {count_id:count_id,target_reference:target_reference},
		  success: function(data) {
			if(data!=""){
				alert(data);
				location.reload();
			}else{ location.reload();}
			},
			error: function(err, message, xx) {alert(xx);}
		});	
	}
});		
</script>