<?php require_once('loader.php'); ?>
<!--<form action="<?php echo base_url() ?>index.php/inventory/dashboard/stacking_norms" method="post" enctype="multipart/form-data" id="form1"> -->
<div class="content-wrapper">
    <section class="content">
        <div class="box-body compact">
            <table id="example" class="display  table-hover " cellspacing="0" width="100%">
                <thead>
                    <tr>

                        <th align="left">Product ID</th>
                        <th align="left">Description</th>
                        <th align="left">Stacking Type</th>
                        <th align="left" title="Total Pieces per stack" alt="sfdsfds">PPS</th>
                        <th align="left" title="Layer per stack">lps</th>
                        <th align="left" title="Pieces per layer">ppl</th>
                        <th align="left">Zone</th>
                        <th title="Handling Quantity" align="left">HQ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
					$result;
					 if($error_record==""){
						$result=$stacking_norms->result() ;
						}else{ 
						$result=$error_record;
						}
						foreach($result as $stacking_norm ){
						
						?>
                        <tr>

                         <td <?php  if($error_record!=""){ ?> style="color:red"  <?php }  ?> align="left"><?php echo $stacking_norm->product_id ?><input name="product_ids[]" id="product_ids[]" type="hidden" value="<?php  echo $stacking_norm->product_id ?>" /></td>
                         <td align="left"><?php echo $stacking_norm->description ?></td>
                         <td align="left"><div style="display:none"><?php echo $stacking_norm->product_stack_type_id ?></div>
                         <select onchange="facous(this)" id="product_stack_type_id/<?php echo $stacking_norm->product_id ?>" name="product_stack_type_id_<?php echo $stacking_norm->product_id ?>">
                         <option></option>
                         <?php
                         foreach ($product_stack_types->result() as $product_stack_type) {

                        $selected = ($stacking_norm->product_stack_type_id == $product_stack_type->product_stack_type_id ? " selected " : "");
                        ?>
                         <option  onchange="facous(this)" <?php echo $selected ?> value="<?php echo $product_stack_type->product_stack_type_id ?>">
                        <?php echo $product_stack_type->product_stack_type ?></option>  <?php } ?>
                         </select>
                         </td>
                        <td align="left"><input name="pps_<?php echo $stacking_norm->product_id ?>" type="text" id="pps/<?php echo $stacking_norm->product_id ?>" onblur="facous(this)" value="<?php echo $stacking_norm->pps ?>" size="5"  /></td>
                        <td align="left"><input name="lps_<?php echo $stacking_norm->product_id ?>" type="text" id="lps/<?php echo $stacking_norm->product_id ?>" onblur="facous(this)" value="<?php echo $stacking_norm->lps ?>" size="5" /></td>
                        <td align="left"><input name="ppl_<?php echo $stacking_norm->product_id ?>" type="text" id="ppl/<?php echo $stacking_norm->product_id ?>" onblur="facous(this)" value="<?php echo $stacking_norm->ppl ?>" size="5" /></td> 


                         <td align="left">
                        <select id="zone_id/<?php echo $stacking_norm->product_id ?>"  onchange="facous(this)">
                        <option></option>
                        <?php foreach ($get_zone->result() as $get_zones) {
                        $selected = ($get_zones->zone_id == $stacking_norm->zone_id ? " selected " : "");
                        ?>
                        <option id="zone_id_<?php echo $stacking_norm->product_id ?>"  onchange="facous(this)" <?php echo $selected ?> value="<?php echo $get_zones->zone_id ?>"><?php echo $get_zones->zone ?></option>
                        <?php } ?>
                        </select>
                        </td>
                        <td align="left"><input name="handling_quantity/<?php echo $stacking_norm->product_id ?>" type="text" id= "handling_quantity/<?php echo $stacking_norm->product_id ?>" onblur="facous(this)" value="<?php echo $stacking_norm->handling_quantity ?>" size="5"  /></td>
                        </tr>
                        <?php } ?>

                         </tbody>
                         </table>

           
                    
               
                    <label style="color:red"><h4>There is  <?php echo $error_record_count ?>    Error Records</h4></label>  
                   
                    <input <?php  if($error_record!=""){  ?> disabled="disabled" <?php } ?>id="List_Error_Records" style="width:150px" class="btn btn-block btn-danger"type="button" value="List Error Records"/>
                    
                 
                  
                    <table >
                    <tr>
                       <td>
   
    <form id="data_sub" action="<?php echo base_url()?>index.php/inventory/dashboard/stacking_norms" method="post">
                            <table class="" style="float:right;" cellpadding="" cellspacing="2">
                             <tr><td> <p aria-expanded="false" class="lead collapsed" data-toggle="collapse" data-target="#sto_summary" style="cursor:pointer"><strong>Search</strong></p></td>
         			                
                             
                             </tr>
                             <tr>
                             <td width="493" colspan="4">
                             <strong style="font-size: 16px" >Product id's</strong>
      
                             <textarea class="form-control " cols="80" rows="5"name="product_ids" id="product_ids"><?php if ($product_id_list != ""){echo $product_id_list;} ?></textarea>
                            
                              </td>
                              </tr> 
                              
                              <tr>

                               <td colspan="4">
                              <strong style="font-size: 16px">Zone</strong><br>
                              <select class="form-control " id="zone" name="zone" style="width: 500px;height: 30" >
                               <option ></option>
                               <?php
                               foreach ($get_zone->result() as $get_zones) {
                               $selected = ($get_zones->zone_id == $stacking_norm->zone_id ? " selected " : "");
                               ?>
                               <option id="zone"  <?php if ($zone > 0) {
                               echo $selected;} ?>  value="<?php echo $get_zones->zone_id ?>"><?php echo $get_zones->zone  ?>
                               </option>
                                <?php } ?>
                                </select>
                                </td> </tr> 
                                <tr>
                                <td colspan="4">
                                <strong style="font-size: 16px">Stack Type</strong><br>
                                <select class="form-control " id="sto" name="sto" style="width: 500px;height: 30" >
                                <option></option>
                    <?php
                    foreach ($product_stack_types->result() as $product_stack_type) {
                    $selected = ($stacking_norm->product_stack_type_id == $product_stack_type->product_stack_type_id ? " selected " : "");
                    ?>
                    <option  <?php if ($st > 0) { echo $selected;} ?>value="<?php echo $product_stack_type->product_stack_type_id ?>"><?php echo $product_stack_type->product_stack_type ?></option>
                    <?php } ?>
                     </select>
                    </td>
                     </tr> 
                    <tr><td>&nbsp;</td></tr>  
                    <tr>
                    <td  align="left"><input  class="btn btn-facebook" style="width: 100px" type="button" name="button" id="list_data"  value="List" /></td>
                    </tr>   
                    </table>
                    </form>    
                    </td>
                    
                  
                       
                    </tr>


                    </table>



        </div>
    </section>
</div>
<!--</form>-->
<script type="text/javascript">


	$('#List_Error_Records').click(function (e){
window.location.pathname ="index.php/inventory/dashboard/stacking_norms?err=1"	
		
	});
	
    function facous(update_value) {

        $.ajax({
            url: '<?php echo base_url() ?>index.php/inventory/dashboard/update_stack_norms',
            method: 'POST',
            data: {update_id: update_value.id, update_value: update_value.value},
            success: function(data) {
               if (isNaN(data)) {
					window.location.pathname ="index.php/inventory/dashboard/update_stack_norms"
                }


            },
            error: function(err, message, xx) {

            }
        });
    }


    $(document).ready(function() {

        $("#add_new").click(function() {

            $.ajax({
                url: '<?php echo base_url() ?>index.php/inventory/dashboard/pid_check',
                method: 'POST',
                data: {pid: $("#add_new_pid").val()},
                success: function(data) {
                    if (data != "") {
                        if (data > 0) {

                            $("#product_ids").val($("#add_new_pid").val());
                            $("#data_sub").submit();
                        } else {
                            //add new record 
                            if ($("#add_new_pid").val() == "") {
                                $("#add_new_pid").css("border", "1px solid red");
                            } else {
                                $("#add_new_pid").css("border", "none");
                            }
                            if ($("#add_new_zone").val() == "") {
                                $("#add_new_zone").css("border", "1px solid red");
                            } else {
                                $("#add_new_zone").css("border", "none");
                            }
                            if ($("#add_new_sto").val() == "") {
                                $("#add_new_sto").css("border", "1px solid red");
                            } else {
                                $("#add_new_sto").css("border", "none");
                            }

                            if ($("#add_new_zone").val() != "" && $("#add_new_sto").val() != "" && $("#add_new_pid").val() != "") {
                               add_recode();
    				// $("#product_ids").val($("#add_new_pid").val());
                	// $("#data_sub").submit();
                            }
                        }
                    }
                },
                error: function(err, message, xx) {

                }
            });
        });

        $('#example').dataTable({
            "scrollY": "300px",
            "scrollCollapse": true,
            "paging": true
        });

        $("#btn_update_changes").click(function() {
            $(this).attr('class', 'btn btn-block btn-default disabled');
            $(this).val('Please wait... Saving Changes...');
            $("#form1").submit();
        });
    });



    $("#list_data").click(function() {
 
        
        $.ajax({
            url: '<?php echo base_url() ?>index.php/inventory/dashboard/stacking_result_count',
            method: 'POST',
            data: {zone: $("#zone").val(), sto: $("#sto").val(), product_ids: $("#product_ids").val()},
            success: function(data) {
               
				if (isNaN(data)) {
					window.location.pathname ="index.php/inventory/dashboard/stacking_result_count"
					
                }else{ 
				if(data>1000){
                    if (confirm('More than' + "  " + "1000" + "  " + 'recodes,you want to load it..?')) {
                        $("#data_sub").submit();

                    }
					}else if(data<1000){
						 $("#data_sub").submit();
						}
				
				}
            },
            error: function(err, message, xx) {

            }
        });

    });

  function  add_recode() {

        $.ajax({
            url: '<?php echo base_url() ?>index.php/inventory/dashboard/add_record',
            method: 'POST',
            data: {pid: $("#add_new_pid").val(), zone_id: $("#add_new_zone").val(), sto_id: $("#add_new_sto").val()},
            success: function(data) {
                alert(data);
				if (data ==1) {
                    alert("Add New Record");
					 $("#product_ids").val($("#add_new_pid").val());
        			 $("#data_sub").submit();
                }else{ window.location.pathname ="index.php/inventory/dashboard/add_record"}
            },
            error: function(err, message, xx) {

            }
        });
    }
</script>