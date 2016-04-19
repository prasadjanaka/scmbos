<?php require_once('loader.php');
date_default_timezone_set("Asia/Colombo");
?>


<div class="content-wrapper">
  <section class="content ">
    <div class="box-body compact">
    <div class="row">
    <div class="col-md-6">
    <div style="position:fixed;background-color:#E5E5E5;padding:10px">
    <table class="table">
    	<tr>
    	  <td colspan="4" style="width:100px"><strong>Count Release</strong></td>
    	  </tr>
    	<tr>
    	  <td style="width:100px"><strong>Date :</strong></td>
    	  <td style="width:100px"><?php echo $date?></td>
    	  <td style="width:100px"><input type="hidden" name="date" id="date" value="<?php echo $date?>" /></td>
    	  <td style="width:100px">&nbsp;</td>
  	    </tr>
    	<tr>
        	<td style="width:100px"><strong>
        	  <label>Reference</label>
        	</strong></td>
            <td colspan="3" style="width:100px">
            	<input type="<?php echo ($reference==""?"text":"hidden")?>" name="reference_number" id="reference_number" value="<?php echo $reference?>" />
                <input type="text" name="reference_number_change" id="reference_number_change" value="<?php echo $reference?>"/>
	            <div id="reference_number_display" <?php echo ($reference==""?'"style="display:none"':"")?>><?php echo ($reference<>""?$reference:"")?></div>
            
            </td>
            </tr>
        <tr>
        	<td><strong>
        	  <label>Scanner</label>
        	</strong></td>
            <td colspan="3">
            <select name="scanner_id" class="form-control" id="scanner_id" style="width:250px">
            	<option value="0"></option>
				<?php foreach($scanning_clearks->result() as $sc){?>
                <option value="<?php echo $sc->user_id  ?>" <?php echo ($sc->user_id==$scanner_id? 'selected':"")?> ><?php echo $sc->epf_number  ?> - <?php echo $sc->name  ?></option>
            	<?php }?>                
            </select>
            </td>
       	  </tr>
        <tr>
          <td colspan="4"><strong>Drag and Drop Sub Zones / Locations for this reference from list</strong></td>
          </tr>
    
    </table>
    
   <div id="droper" class="droper" style="width:600px;height:200px;box-shadow:1px 1px 3px 1px;background-color:#FFF;padding:10px;" ondrop="drop(event)" ondragover="allowDrop(event)" onmouseover="change()">
  	<?php foreach($reference_sub_zones->result() as $ref_sz){ ?>
        <div id="<?php  echo $ref_sz->count_id ?>"  zone="<?php  echo $ref_sz->zone_id."?".$ref_sz->zone_id ?>" sub_zone="<?php  echo $ref_sz->sub_zone ?>" style="cursor:move;width:100px;height:20px;float:left;margin-right:5px;background-color:<?php if($ref_sz->count_number>1){ ?>#00c0ef <?php }else{ ?> #f39c12<?php } ?>;color:#FFF;border-radius:5px;margin-bottom:5px" draggable="true" ondragstart="drag(event)" >
        <div style="padding-top:0px;font-size:14px;font-weight:bold;text-align:center"><?php  echo $ref_sz->sub_zone ?> </div>
        </div>

	<?php } ?>   
   </div>
<br />
<table width="100%">
	<tr>
    	<td><input name="cmd_empty" type="button" class="pull-right btn  btn-facebook" id="cmd_empty" style="width:145px" value="Clear Selection"/></td>
       <td><input name="cmd_back" type="button" class="pull-right btn  btn-facebook" id="cmd_back" style="width:145px" value="Reference Manager"/></td>
       <td><input name="cmd_refresh" type="button" class="pull-right btn  btn-facebook" id="cmd_refresh" style="width:145px" value="Refresh"/></td>
        <td><input name="cmd_release" type="button" class="pull-right btn  btn-facebook" id="cmd_release" style="width:145px" value="Release"/></td>
    </tr>

</table>
	
</div>

</div>


<!-- end of head -->
 <div class="col-md-6" style="border:0px solid #F00">
<?php 

$pre_zone_id = 0;
$is_begin = 1;

foreach($sub_zones_to_count->result() as $sub_zone){
	if($pre_zone_id != $sub_zone->zone_id) {
		if($is_begin==0) echo '</div>';
		?>
			<div style="padding-left:0px;float:left"><strong><?php echo $sub_zone->zone?></strong></div><br/>
            <div class="col-md-12" id="<?php  echo $sub_zone->zone_id."?".$sub_zone->zone ?>" style="border:0px solid #000;"  draggable="false" ondrop="drop(event)" ondragover="allowDrop(event)">		
		<?php
	}

	?>
<div id="<?php  echo $sub_zone->count_id ?>"  zone="<?php  echo $sub_zone->zone_id."?".$sub_zone->zone ?>" sub_zone="<?php  echo $sub_zone->sub_zone ?>" style="cursor:move;width:100px;height:20px;float:left;margin-right:5px;background-color:<?php if($sub_zone->count_number>1){ ?>#00c0ef <?php }else{ ?> #f39c12<?php } ?>;color:#FFF;border-radius:5px;margin-bottom:5px" draggable="true" ondragstart="drag(event)" >
	<div style="padding-top:0px;font-size:14px;font-weight:bold;text-align:center"><?php  echo $sub_zone->sub_zone ?> </div>
</div>	
	
	<?php





	if($pre_zone_id != $sub_zone->zone_id ) {
		$pre_zone_id = $sub_zone->zone_id;	
	}
$is_begin = 0;

	
}

?>
</div>

 
 

  </div>    
    </div>
    
  </section>
</div>

<script>
var val="";
function allowDrop(ev) {
document.getElementById('droper').style.border = "3px solid #000"; 
    ev.preventDefault();
}

function drag(ev) {
    ev.dataTransfer.setData("text", ev.target.id);
	ev.target.style.border = "4px solid purple";
}

function drop(ev) {
		if($.trim($('#reference_number').val())==''){
			$('#reference_number').focus();
			$('#reference_number').val('');		
			$('#scanner_id').val(0);	
			alert("Please enter a valid reference number");
			return(false);				
		}
		
		if($.trim($('#scanner_id').val())==0){
			$('#scanner_id').focus();
			$('#scanner_id').val('');		
			alert("Please select a scanner");
			return(false);				
		}		
	
	
    ev.preventDefault();

    var data = ev.dataTransfer.getData("text");
	var count_id = data ;
	var zone = $('#'+data).attr('zone');
	var sub_zone = $('#'+data).attr('sub_zone');





	document.getElementById('droper').style.border = "1px solid #000"; 
	 var doc = document.getElementById(data).innerHTML;
	 	 $('#'+data).attr("style","cursor:move;width:100px;height:30px;float:left;margin-right:5px;background-color:#f39c12;color:#FFF;border-radius:5px;margin-bottom:5px")

		 val="";
		 $.ajax({
				url: '<?php echo base_url() ?>index.php/inventory/Count_ref_manager/check_count_reference',
				method: 'POST',
				data: {reference:$('#reference_number').val(),count_id:count_id},
				success: function(data1) {
					if(data1 !=''){
						alert(data1);	
						$('#'+data).attr("style","cursor:move;width:100px;height:30px;float:left;margin-right:5px;background-color:#f39c12;color:#FFF;border-radius:5px;margin-bottom:5px")	
					}else{
						  if (ev.target.id == 'droper' ) {
							   var doc = document.getElementById(data).innerHTML;
							   $('#'+data).attr("style","cursor:move;width:100px;height:20px;float:left;margin-right:5px;background-color:#f39c12;color:#FFF;border-radius:5px;margin-bottom:5px")		
							   ev.target.appendChild(document.getElementById(data));  
							   
							 $.ajax({
									url: '<?php echo base_url() ?>index.php/inventory/Count_ref_manager/set_count_reference',
									method: 'POST',
									data: {reference:$('#reference_number').val(),count_id:count_id},
									success: function(data) {
										if(data!=''){
											alert(data);	
										}
									},
									error: function(err, message, xx) {
										alert(err);	
									}
								});							   
							   
							   
							   
						 } 						 

 
					 }
				},
				error: function(err, message, xx) {
	
				}
			});

    return false;
}

$(document).ready(function () {
	var pre_scanner_id;
	var pre_reference;
	pre_scanner_id = $('#scanner_id').val();	
	
	$('#reference_number').focus();
	$('#reference_number_change').hide();
	
	$('#reference_number_display').dblclick(function(){
		if($(this).html()!=''){
			pre_reference = $(this).html();
			$(this).hide();
			$('#reference_number_change').show();
			$('#reference_number_change').val($(this).html());
			$('#reference_number_change').focus();
			$('#reference_number_change').select();		
		}
	});	

	$('#reference_number_change').change(function(){
		var reference = $(this).val();
		$.ajax({
			url: '<?php echo base_url() ?>index.php/inventory/Count_ref_manager/change_reference_number',
			method: 'POST',
			data: {reference:reference,pre_reference:pre_reference},
			success: function(data) {
				if(data !=''){
					alert(data);	
					$('#reference_number_change').hide();
					$('#reference_number_display').show();
					$('#scanner_id').focus();	
				}else{
					window.location = '<?php echo base_url()?>index.php/inventory/Count_ref_manager/index?ds=<?php echo $date?>&reference='+reference;
				}
				
			},
			error: function(err, message, xx) {
				alert(message+ ' ' + xx);
			}
		});
	});	
		
	
	$('#reference_number').change(function(){
		if($.trim($('#reference_number').val())==''){
			$('#reference_number').focus();
			$('#reference_number').val('');		
			$('#scanner_id').val(0);	
			alert("Please enter a valid reference number");
			return(false);				
		}		
		$.ajax({
			url: '<?php echo base_url() ?>index.php/inventory/Count_ref_manager/check_reference_number',
			method: 'POST',
			data: {reference:$('#reference_number').val(),date:$('#date').val()},
			success: function(data) {
				if(data !=''){
					alert(data);	
					$('#reference_number').focus();
					$('#reference_number').val('');
				}else{
					$('#reference_number').hide();
					$('#reference_number_display').show();
					$('#reference_number_display').text($('#reference_number').val());
					$('#scanner_id').focus();	
				}
				
			},
			error: function(err, message, xx) {
				alert(err);
			}
		});


		
	});		
	
	$('#scanner_id').change(function(){
		if($.trim($('#reference_number').val())==''){
			$('#reference_number').focus();
			$('#reference_number').val('');		
			$('#scanner_id').val(0);	
			alert("Please enter a valid reference number");
			return(false);				
		}
		$.ajax({
			url: '<?php echo base_url() ?>index.php/inventory/Count_ref_manager/update_scanner_id',
			method: 'POST',
			data: {reference:$('#reference_number').val(),scanner_id:$('#scanner_id').val()},
			success: function(data) {
				if(data!=''){
					alert(data);
					$('#scanner_id').val(pre_scanner_id);
				}else{
					window.location = '<?php echo base_url()?>index.php/inventory/Count_ref_manager/index?ds=<?php echo $date?>&reference='+$('#reference_number').val();
				}
			},
			error: function(err, message, xx) {
				alert(err);
			}
		});


		
	});	
	
	
	$('#cmd_release').click(function(){
		if($.trim($('#reference_number').val())==''){
			$('#reference_number').focus();
			$('#reference_number').val('');		
			$('#scanner_id').val(0);	
			alert("Please enter a valid reference number");
			return(false);				
		}
		
		if($.trim($('#scanner_id').val())==0){
			$('#scanner_id').focus();
			$('#scanner_id').val('');		
			alert("Please select a scanner");
			return(false);				
		}		
		
		if(confirm("Are you sure that you need to release this count?")){
			$.ajax({
				url: '<?php echo base_url() ?>index.php/inventory/Count_ref_manager/release',
				method: 'POST',
				data: {reference:$('#reference_number').val(),scanner_id:$('#scanner_id').val()},
				success: function(data) {
					if(data!=''){
						alert(data);
						$('#scanner_id').val(pre_scanner_id);
					}else{
						window.location = '<?php echo base_url()?>index.php/inventory/Count_ref_manager/index?ds=<?php echo $date?>&reference=';
					}
				},
				error: function(err, message, xx) {
					alert(err);
				}
			});
			
		}
		


		
	});		

	$('#cmd_empty').click(function(){
		
		if(confirm("Are you sure that you need to clear selected locations?")){
			$.ajax({
				url: '<?php echo base_url() ?>index.php/inventory/Count_ref_manager/clear_counts',
				method: 'POST',
				data: {reference:$('#reference_number').val()},
				success: function(data) {
					if(data!=''){
						alert(data);
					}else{
						window.location = '<?php echo base_url()?>index.php/inventory/Count_ref_manager/index?ds=<?php echo $date?>&reference=<?php echo $reference?>';
					}
				},
				error: function(err, message, xx) {
					alert(err);
				}
			});
			
		}
		


		
	});	



	$('#cmd_back').click(function(){
		window.location = '<?php echo base_url()?>index.php/inventory/count_ref_manager/count_ref_list?ds=<?php echo $date ?>';		
	});	
	$('#cmd_refresh').click(function(){
		window.location = '<?php echo base_url()?>index.php/inventory/count_ref_manager/index?ds=<?php echo $date?>&reference=<?php echo $reference?>';	
	});		
	
});
</script>