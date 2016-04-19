<?php require_once('loader.php');
date_default_timezone_set("Asia/Colombo");
?>

<div class="content-wrapper ">
  <section class="content">
    <div class="box-body compact  invoice ">       
      <div class="row">
          <div class="col-xs-12 table-responsive">
           <p class="lead"   data-toggle="collapse" data-target="#vehicle_info" style="cursor:pointer"><strong></strong></p>
              <div id="vehicle_info" class="collapse in">
              
              
              <table id="example" class="table">
        	
            <tbody>
            <?php  foreach($pick_list->result() as $row ){ ?>
                <tr>
                	<td style="font-size:16px;font-weight:bold">Pick Number</td>
                    <td style="font-size:14px;"><?php echo $row->pick_number?></td>
                     <td style="width:100px">&nbsp;</td>
                    <td style="font-size:16px;font-weight:bold">Create Date Time</td>
                    <td style="font-size:14px;"><?php echo $row->date_time?></td>
                   
                </tr>
                <tr>  
                	<td style="font-size:16px;font-weight:bold">Create By </td>
                    <td style="font-size:14px;"><?php echo $row->epf_number  ?></td>
                     <td style="width:100px">&nbsp;</td>
                     <td style="font-size:16px;font-weight:bold">Status</td>
                    <td style="font-size:14px;"><?php echo $row->status  ?></td>
                   </tr>
 
                    <tr>  
                   
                    <td style="font-size:16px;font-weight:bold">Priority</td>
                    <td style="font-size:14px;"><?php echo $row->priority  ?></td>
                     <td style="width:100px">&nbsp;</td>
                    <td style="font-size:16px;font-weight:bold">Reference</td>
                     <td style="font-size:14px;"><?php echo $row->reference_type  ?></td>
                     </tr>    
                   
                     
            <?php  } ?>         
                </tr>
            </tbody>
        </table>
      
              
              </div>
            </div>
          </div>     
      
         <div class="row">
          <div class="col-xs-12 table-responsive">
           <p class="lead"  data-toggle="collapse" data-target="#pick_details" style="cursor:pointer"><strong>Details (To be Picked)</strong></p>
              <div id="pick_details" class="collapse in">
              
              <div id="tabs">
              <table id="example" style="cursor:pointer" class="table table-striped">
              	<thead>
              		<tr>
                   		 <th>Zone</th>
                    	<th>Location</th>
                        <th>Product ID</th>
                        <th>Pallete Code</th>
                        <th style="text-align:center" align="center">Qty to Pick</th>
                        <th style="text-align:center" align="center">Qty Picked</th>
                        <th style="text-align:center" align="center">Status</th>
                        <th style="text-align:center" align="center">Sort Order</th>
                    </tr>  
                </thead>
              
              <tbody id="tb">
              <?php   foreach ($pick_details->result() as $details_row ){ ?>
              		<tr>
                    	<td><?php echo $details_row->zone ?></td>
                    	<td><?php echo $details_row->location ?></td>
                        <td><?php echo $details_row->pid ?></td>
                        <td><?php echo $details_row->pallect_code ?></td>
                        <td align="center"><?php echo $details_row->qty_pick ?></td>
                       
                        <td align="center"><?php echo $qty_picked=10?></td>
                        <?php $tot =  $qty_picked / $details_row->qty_pick * 100  ?>
                        <td align="center"><?php echo number_format($tot, 0, '.', ',')."%" ?></td>
                        <td align="center"> <input id="<?php echo $details_row->pick_detail_id ?>"  onBlur="set_sort_order(this.id)"style="width:50px;text-align:center"  class="form-control" type="text" value="<?php echo $details_row->sort_order ?>"/></td>
                    
                    </tr>
                    <?php  } ?>
              </tbody>
              </table>
              </div>
       
             <div class="col-md-3">                
                <select style="width:250px" id="zone_list" class="form-control">
                <option value="0"></option>
                <option value="full">Full Report</option>
                <?php  foreach($zone_list->result() as $zl){ ?>
                <option value="<?php  echo $zl->zone_id;  ?>"><?php echo $zl->zone;  ?></option>
               <?php   }  ?>
              </select>
              </div>
              <div class="col-md-3">
            <input style="width:100px" type="button" id="prin_pdf" class="btn  btn-facebook" value="Print"/>
             </div>
             
              </div>
            </div>
         </div>
      
   
      </div>
    </section>
  </div> 
  
  <script>
  
  	$('#prin_pdf').click(function(e) {
        
		var zone_id = $('#zone_list').val();
		var zone = $("#zone_list option:selected").text();;
		
		 if(zone_id>0 || zone_id=="full"){
				
				var location = "<?php echo base_url()?>index.php/inventory/dashboard/print_pick_tickets?zone="+zone+"&zone_id="+zone_id+"&pick_number=<?php echo $pick_number ?>";
						window.open(location, '_blank');
					 
			}else{
				$('#zone_list').focus();	
			}
    });
  
  
  	function set_sort_order(id){
		var pick_detail_id = id;
		var sort_val = $('#'+id).val();
		
		$.ajax({
			  url: '<?php echo base_url()?>index.php/inventory/dashboard/set_sort_order',
			  method: 'POST',
			  data: {pick_detail_id:pick_detail_id,sort_val:sort_val},
			  success: function(data){
			
			  },
			  error:function(err,message,xx) {
				  alert(xx);
			  }	  
			});	
	}
  $("#tabs").tabs();

$("tbody").sortable({
   // items: "> tr:not(:first)",
    appendTo: "parent",
    helper: "clone"
}).disableSelection();

$("#tabs ul li a").droppable({
    hoverClass: "drophover",
    tolerance: "pointer",
    drop: function(e, ui) {
        var tabdiv = $(this).attr("href");
        $(tabdiv + " table tr:last").after("<tr>" + ui.draggable.html() + "</tr>");
        ui.draggable.remove();
    }
});
  </script>   