<?php require_once('loader.php');

?>

<div class="content-wrapper">

  <section class="content">
   <table align="right"><tr>
    <td style="font-weight:bold">Shortcuts  &rArr; &nbsp;&nbsp;&nbsp;</td> 
   <td><a href="<?php echo base_url()?>index.php/inventory/dashboard/product_count?ds=<?php if($date!=""){echo $date; }?>" >PID Count</a></td><td style="padding-left:20px"><a href="<?php echo base_url()?>index.php/inventory/dashboard/target_count?ds=<?php if($date!=""){echo $date; }?>" >Location Count</a></td>
    <td style="padding-left:20px"><a href="<?php echo base_url()?>index.php/inventory/location_manager/confirmed_result?ds=<?php echo $date  ?>" >Confirmed Results</a></td>
 <td style="padding-left:20px"><a href="<?php echo base_url()?>index.php/inventory/location_manager/Result?ds=<?php echo $date  ?>" >Counting Results</a></td>
  <td style="padding-left:20px"><a href="<?php echo base_url()?>index.php/inventory/Dashboard/ex_summary?ds=<?php echo $date  ?>" >Executive Summary</a></td> 
   <td style="padding-left:20px"><a href="<?php echo base_url()?>index.php/inventory/Dashboard/scanner_allocation?ds=<?php echo $date  ?>" >Team Distribution</a></td> 
   </tr></table>
 <br />
  <?php if($continue!=0){?>
    <div class="alert alert-danger">
     
      <h4><i class="icon fa fa-warning"></i> Please Synchronize Inventory with WMS before proceed</h4> 
      Last update of WMS inventory import is : <strong><?php echo $last_inventory_import?></strong>
		<h6><strong>please <a href="#" id="import_inventory">click here</a> to update inventory. This operation might take few miniutes</strong> </h6>
		<h6>Or <a id="link_continue" href="#">click here</a> to continue to Assign Scanning Clearks</h6>
		<form method="post" id="form1" action="<?php echo base_url()?>index.php/inventory/dashboard/target_set_scanning_cleark">
        <input name="date"  id="date" value="<?php echo $date?>" type="hidden" />
      <input name="continue"  id="continue" value="0" type="hidden" /> </form>
</div>
   <?php }else{?> 
   <table style="width:auto;" align="left">
   <tr>
  
   <td style="font-size:20px">  Set Scanning Clearks for count on </td>
   <td></td>
  <td>
  <form method="GET">
 
  <div style="float:left;padding-right:10px"><input value="<?php echo $date; ?>" id="date" name="date" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="" type="text"></div>
  <input type="submit" value="List" style="width:100px" class="btn  btn-facebook" />
  
  </form>
  </td>
   </tr>
   </table>

    <table border="0" id="example" class="display dataTable" cellspacing="0" width="95%">
      <thead>
          <tr>
        <th>Zone</th>
        <th>Sub Zone Group</th>
        <th>Sub Zone</th> 
        <th align="center" style="text-align:center">Reference</th>
        <th>Scanner</th>
        
        <th align="center" style="text-align:center">Level Sort Order</th>
         <th align="center" style="text-align:center">Location Sort Order</th>

        <th>Counting Type</th>
      </tr>
      </thead>
      <tbody>
      <?php foreach($sub_zones->result() as $sub_zone){?>
      	<?php
		  $clr="";
		  if($sub_zone->count_number>1){ 
		    $clr="rgb(243, 241, 36)";
		  }else{
			$clr="" ;
		}
		  ?>
      <tr style="background-color:<?php echo $clr; ?>" >
        <td><?php echo $sub_zone->zone?></td>
        <td><?php echo $sub_zone->sub_zone_group?></td>
        <td><?php echo $sub_zone->sub_zone?></td>
        <td style="text-align:center"><?php echo $sub_zone->reference ?></td>
        <?php if($sub_zone->status_id<=2){?>
      
        <td style="width:300px" >
        
     
	<?php foreach($scanners->result() as $scanner){?>	
		<?php 
			if($scanner->user_id==$sub_zone->user_assigned){
				echo $scanner->epf_number.' - '.$scanner->name.' - '.$sub_zone->count_status;
				break;
			}
		}
		?>
		
        </td>
          
        <td align="center"><input onblur="save_sort_order(this.id)" type="text" style="width:50px;text-align:center" value="<?php echo $sub_zone->sort_order ?>" id="<?php echo $sub_zone->count_id ?>"/></td>
          <td align="center">
          <select name="location_sort"  onchange="location_sort(this.id)" count_id="<?php echo $sub_zone->count_id ?>" id="<?php echo "lo_sort_".$sub_zone->count_id ?>" >
          	<?php if($sub_zone->location_sort_order == "ASC"){ ?>
          <option selected="selected" value="ASC">ASC</option>
           <option value="DSC">DSC</option>
          	<?php  }else{?>
            <option value="ASC">ASC</option>

          <option  selected="selected"  value="DSC">DSC</option>
          <?php  } ?>
          </select>
          </td>
        	
        <td>
        <?php  if($sub_zone->inventory_count_type_id==2){?>
          <?php echo $sub_zone->inventory_count_type ?>  
     <?php  echo "-".$sub_zone->product_id; 
	 		}else if($sub_zone->inventory_count_type_id==3){
			if($clr!=""){
			 echo $sub_zone->inventory_count_type."- R" ;
				}else{
			 echo $sub_zone->inventory_count_type;	
				}
			}?></td>
        <?php }else{?>
      
        <td>
		<?php foreach($scanners->result() as $scanner){?>	
		<?php 
			if($scanner->user_id==$sub_zone->user_assigned){
				echo $scanner->epf_number.' - '.$scanner->name.' - '.$sub_zone->count_status;
				break;
			}
		}
		?>
        
        
        </td>
        
        <td align="center"><?php echo $sub_zone->sort_order ?></td>
         <td align="center"><?php echo $sub_zone->location_sort_order ?></td>
        <!-- <td><?php //echo $sub_zone->reference ?></td> -->
        <td>
     <?php  if($sub_zone->inventory_count_type_id==2){?>
          <?php echo $sub_zone->inventory_count_type ?>  
     <?php  echo "-".$sub_zone->product_id; 
	 		}else if($sub_zone->inventory_count_type_id==3){
				if($clr!=""){
			 echo $sub_zone->inventory_count_type."- R" ;
				}else{
			 echo $sub_zone->inventory_count_type;	
				}
			}?></td>
       
        <?php }?>        
      </tr>
      
      <?php }?>
      </tbody>
    </table>
   <?php }?> 
 <table><tr><td style="background-color:rgb(243, 241, 36);border:1px solid black;width:50px"></td><td>&nbsp;&nbsp;&nbsp;</td>
 <td style="font-weight:bold">Recounting Locations</td></tr></table>
   <br />
   
   <table>
   		<tr>
         <td style="padding-left:10px;font-weight:bold">Zone</td>
            <td style="padding-left:10px"> <select class="form-control" style="width:200px" id="zones" name="zones">
                	<option selected="selected" value=""></option>	    
                    <?php foreach($zone_list->result() as $zls){ ?> 
                    	                                  
                    	<option value="<?php echo $zls->zone ?>"> <?php  echo $zls->zone ?> </option>
                    	
                    <?php  } ?>
                </select></td>
                
                <td>
                <div class="md-6" style="text-align:right;padding-left:20px">
      <input name="confirmation_valide"  id="confirmation_valide" type="checkbox" value="">
      <label style="padding-left:15px">Show only open records</label>  
      </div></td>
      <td style="width:50px"></td>
         <td>
                <div class="md-6" style="text-align:right;padding-left:20px;display:none">
      <input name="previous_scanners" checked="checked" id="previous_scanners" type="checkbox" value="">
      <label style="padding-left:15px">exclude previous scanners   </label>  
      </div></td>
       <td>
                <div class="md-6" style="text-align:right;padding-left:20px">
      <input name="only_recount" id="only_recount" type="checkbox" value="">
      <label style="padding-left:15px">Show only recount records</label>  
      </div></td>
         
        </tr>
   
   </table>
  
  </section>
</div>


<script type="text/javascript">
	var privious_scanner_id="";
	
	
	function ref(id){
	
		var ref_val = $('#'+id).val();
		var count_id = $('#'+id).attr('count_id');
	
			if(ref_val != ""){
				$.ajax({
					url: '<?php echo base_url() ?>index.php/inventory/Dashboard/save_ref',
					method: 'POST',
					data: {count_id:count_id,ref_val:ref_val},
					success: function(data) {
					
					},
					error: function(err, message, xx) {	}
					});	
			}
	}
	
	$('select[id^="user_assigned"]').click(function(){
		
		
		
		var without_confirm = document.getElementById("previous_scanners").checked;
      	seleted_box = $(this);
	    //var  user_id_already_assigned = $('option:selected', $(this)).val();
		var  user_id_already_assigned = $('option:selected', $(this)).text();
		privious_scanner_id = user_id_already_assigned;
		
		var user_assine_id = $(this).attr('user_assine_id') ;
	  	var date = $('#date').val();
		var sub_zone_id = $(this).attr('sub_zone_id') ;
		var count_id = $(this).attr('count_id');
		if(without_confirm==true){
			$.ajax({
				url: '<?php echo base_url() ?>index.php/inventory/Dashboard/load_scanner',
				method: 'POST',
				data: {sub_zone_id:sub_zone_id,date:date,user_assine_id:user_assine_id},
				success: function(data) {
					//alert(data);
						if(data!=""){
					
							document.getElementById('td_'+count_id).innerHTML=data;
						}
			
				},
				error: function(err, message, xx) {	}
				});
		}
    });
	
	function location_sort(count_id){
		
		var location_sort_val = $("#"+count_id).val();
	
		var count_id = $("#"+count_id).attr('count_id');
		$.ajax({
				url: '<?php echo base_url() ?>index.php/inventory/Dashboard/set_scanner_location_sort_order',
				method: 'POST',
				data: {location_sort_val:location_sort_val,count_id:count_id},
				success: function(data) {
					
				},
				error: function(err, message, xx) {	}
		});
	}


function save_sort_order(row_id){
	
	var sort_value = $('#'+row_id).val();
	$.ajax({
				url: '<?php echo base_url() ?>index.php/inventory/Dashboard/set_scanner_sort_order',
				method: 'POST',
				data: {sort_value:sort_value,count_id:row_id},
				success: function(data) {
					
				},
				error: function(err, message, xx) {	}
			});

}



$(document).ready(function () {
	
	$('#example').dataTable( {
	"scrollY":        "350px",
	"scrollCollapse": true,
	"paging":         false
});
	
		//$('#count_number_select').change(function(e) {
	 	
    //});
	
	$("#date").inputmask("yyyy-mm-dd", {"placeholder": "yyyy-mm-dd"});
	
	$('select[id^="user_assigned"]').change(function(){
		var without_confirm = document.getElementById("previous_scanners").checked;
		seleted_box = $(this);
		count_id = $(this).attr('count_id');
		user_id = $(this).val();
		
		 $(this).attr('user_assine_id',user_id) ;
		var  user_text = $('option:selected', $(this)).text();
			var res =user_text.split('-');
		var past_scanner = document.getElementById('td_'+count_id).innerHTML;
			
		if(without_confirm==true){
			
			var condition = past_scanner.indexOf(res[0]) > -1;
		
		if(condition){
	
			if(user_id=='0'){
			$.post( "<?php echo base_url()?>index.php/inventory/dashboard/target_set_scanning_clearks", { count_id: count_id,user_id: user_id})
			.done(function( data ) {
			$('#loading-indicator').hide();	
			
			jd = $.parseJSON(data);
			
				if(jd.message!="") {
					seleted_box.val(jd.user_id);
					seleted_box.attr('selectedIndex',jd.user_id);	
					seleted_box.prop('selectedIndex', jd.user_id);				
				}
			$('#loading-indicator').hide();	 
			});	
			}else{
				alert("Sorry you can not assigned this scanner");
			
			 var textToSelect = privious_scanner_id;

			  $(".sel_"+count_id+" option").each(function () {
				  if ($(this).html() == textToSelect ){
				  
					$(this).attr("selected", "selected");
				  }
				});
				var li = $(".sel_"+count_id+"").html(); 
				$(".sel_"+count_id+"").html(li);
			}
	
			

		}else{
				
						
			$.post( "<?php echo base_url()?>index.php/inventory/dashboard/target_set_scanning_clearks", { count_id: count_id,user_id: user_id})
			.done(function( data ) {
			$('#loading-indicator').hide();	
			
			jd = $.parseJSON(data);
			
				if(jd.message!="") {
					seleted_box.val(jd.user_id);
					seleted_box.attr('selectedIndex',jd.user_id);	
					seleted_box.prop('selectedIndex', jd.user_id);				
				}
			$('#loading-indicator').hide();	 
			});	

			}
	
	
		
		}else{
			$.post( "<?php echo base_url()?>index.php/inventory/dashboard/target_set_scanning_clearks", { count_id: count_id,user_id: user_id})
		
		.done(function( data ) {
				$('#loading-indicator').hide();	
			
			jd = $.parseJSON(data);
		
			if(jd.message!="") {
				seleted_box.val(jd.user_id);
				seleted_box.attr('selectedIndex',jd.user_id);	
				seleted_box.prop('selectedIndex', jd.user_id);				
			}
			$('#loading-indicator').hide();	 
		});	
		
		}
	});		
	
	$("#link_continue").click(function() {
		if(confirm("Are you sure you want to continue assigning with current inventory?\n*** NOTE: This operation is not reversable")){
			$("#continue").val(1);
			$("#form1").submit();				
		}
		
	});	

	$("#import_inventory").click(function() {

		if(confirm("Are you sure you want to import the inventory from WMS?\nThis operation will take few miniutes")){
			window.location = '<?php echo base_url()?>index.php/interfaces/wms/import_inventory_from_wms';			
		}
		
	});	



	
		//var table = $('#example').DataTable();
		//table.search("open record").draw();
});


	$('#zones').change(function(e) {
		valide_search ();

		
    });
	
	$('#confirmation_valide').change(function(e) {
		valide_search ();

    });
	
	$('#only_recount').change(function(e) {
		valide_search ();

    });
	
	function valide_search (){
	  var only_recount = "";
	  var without_confirm = "";
	  var zone_val = "";
	  
	  if(document.getElementById("only_recount").checked){
			only_recount ='annual count-'; 
	   }
	  if(document.getElementById("confirmation_valide").checked){
		  without_confirm = 'open record';
	   }
		 
	  if($('#zones').val()!=""){
		  zone_val = $('#zones').val();
		}
		var table = $('#example').DataTable();
		table.search(only_recount+" "+without_confirm+" "+zone_val).draw();
	}

</script>