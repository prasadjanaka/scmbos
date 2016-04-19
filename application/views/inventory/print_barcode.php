<?php require_once('loader.php'); ?>
<div class="content-wrapper">
    <section class="content">
   
        <div class="box-body compact">
            <div class="col-xs-12" style="text-align:left" >
            <table>
            <tr>
            <td align="left" style="width:675px" class="col-xs-8" > <section class="content-header">
            	<h1><strong> <?php echo "Print Transactional Barcodes" ?></strong></h1>
        		</section></td>
        	<td align="left" > <section    class="content-header">
            	<h1><strong> <?php echo "Print Inventory Barcodes" ?></strong></h1>
        		</section>
             </td>
            </tr>
            </table>
            <br />
             <div class="col-xs-6" style="padding-left:20px">
      
        <table>
        <tr>
        	<td style=" width:190px;text-align: right;padding-right:28px"><label>Reference #(ASN Number)</label></td>
            <td></td>
            <td style="width:410px"><input class="form-control"   type="text" name="" id="reference" /></td>

        </tr>
    </table>
    <br />
    <table  align="" style="width:auto">
	    <tr>
        	<td align=right><input type="checkbox" name="CheckboxGroup0" value="full_p" id="full_pallets" /></td>
            <td>&nbsp;&nbsp;&nbsp;</td>
            <td align=right>Full Pallets</td>
             <td style="width:30px">&nbsp;</td>
        	<td align=right><input type="checkbox" name="CheckboxGroup0" value="part_p" id="part_pallets" /></td>
            <td>&nbsp;&nbsp;&nbsp;</td>
            <td align=right>Part Pallets</td>   
    	</tr>
      </table>
      <br />
      <table>
        <tr>
        <?php  foreach($zone_list as $zone_lists){ ?>
        	<td ><input type="checkbox" name="CheckboxGroup1" value="<?php  echo $zone_lists->zone_id ?>" id="<?php  echo $zone_lists->zone_id ?>" /></td>
            <td>&nbsp;&nbsp;&nbsp;</td>
            <td><?php echo $zone_lists->zone  ?></td>
            <td style="width:50px">&nbsp;</td>
        <?php  } ?>
        </tr>
    </table>
    <br />
    <table>
    <tr>
    <td style=" width:220px;text-align: right;padding-right:30px">&nbsp;</td>
    <td style=" width:220px;text-align: right;padding-right:30px">&nbsp;</td>
    <td><input type="submit" id="Print_Advance_Barcode" name="" class="btn  btn-facebook" value="Print Advance Barcode" ></td>
    </tr>
    </table>
    </div>
            
            
            
        <table style="width:auto">
         <tr>
        <td style="padding-left: 5px"><table style="width:auto">
        <tr>
        <td style=" width:100px;text-align: right;padding-right: 20px"><strong>Select Zone</strong></td>
        <td style="padding-left: 5px"><select disabled="disabled"  style="width:400px" id="zone_select" name="zone_select" class="form-control">
        <option></option>
         <?php
        foreach ($zone_list as $zone_lists) {
        $selected = ($zone_lists->zone_id == $zone_id ? " selected " : "");
                                             
        ?>
        <option <?php echo $selected ?> value="<?php echo $zone_lists->zone_id; ?>"><?php echo $zone_lists->zone; ?></option>
        <?php } ?>
        </select></td>
         </tr>
        <tr>
        <td>&nbsp;</td>
        </tr>
        <tr>
        <td style="width:200px;text-align: right;padding-right: 20px"><strong>Select Sub Zone Group</strong></td>
        <td style="padding-left: 5px"><select disabled="disabled" style="width:400px" id="sub_zone_group" name="sub_zone_group" class="form-control" 	onchange="sub_zone_group(this.value)">
        <option></option>
         <?php
        foreach ($sub_zone_group as $sub_zone_groups) {
        $selected = ($sub_zone_groups->sub_zone_group_id == $sub_zone_group_id ? " selected " : "");
        ?>
        <option <?php echo $selected ?> value="<?php echo $sub_zone_groups->sub_zone_group_id; ?>"><?php echo $sub_zone_groups->	sub_zone_group; ?></option>
        <?php } ?>
        </select></td>
        </tr>
        </table>
        </td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
        <td align=right><input disabled="disabled" type="button" id="print_barcode" name="print_barcode" class="btn  btn-facebook" value="Print 	Barcode" ></td>
        </tr>
     <tr>
     
     </tr>
        </table>
        <br><br>
 		<section class="content-header">
            <h1><strong> <?php echo "Print Individual Barcodes" ?></strong></h1>
        </section>
        <br />     
 
      <form method="post" action="<?php echo base_url() ?>index.php/inventory/dashboard/print_pallet_id" target="_blank">
       <table align="" style="width:auto">       
        <tr>
        <td style=" width:210px;text-align: right;padding-right:30px"><strong>Pallet id's</strong></td>
        
        <td>
      <textarea style="resize:none" required="required" class="form-control " cols="55m" rows="3" name="product_ids" id="product_ids"></textarea>	
        </td>
      
        </tr>
         <tr><td>&nbsp;</td></tr>
         
        <tr>
        <td>
           <td align=right><input type="submit" id="" name="" class="btn  btn-facebook" value="Print Barcode" ></td>
        
        </td>
        </tr>
        </table>
     
        </form>

   <br>

        </div>  
       
   
   
   
    
   
        </div>

    </section>
</div>
<script type="text/javascript">

	$(document).ready(function() {
		$("#zone_select").change(function() {
			window.location = "<?php echo base_url(); ?>index.php/inventory/dashboard/print_barcode?zone_id=" + $("#zone_select").val();
		});


		$("#print_barcode").click(function() {
			if($("#sub_zone_group").val()>0){
				var location = "<?php echo base_url(); ?>index.php/interfaces/wms/print_wms_inventory_barcodes?sub_zone_group_id=" + $("#sub_zone_group").val();
				window.open(location, '_blank');
			}else{
				alert("Please select a sub zone group to print barcodes for");	
			}
		});	
		
	$('#Print_Advance_Barcode').click(function(e) {
		
		var option=[]; 
		var zone_ids=[]; 
     
			 $.each($("input[name='CheckboxGroup1']:checked"), function(){           
				 zone_ids.push($(this).val());
			 });
 
        	$.each($("input[name='CheckboxGroup0']:checked"), function(){           
        		 option.push($(this).val());
         	});
				if($('#reference').val()!=''){
					if(option.length>0 || zone_ids.length>0 ){
						var location = "<?php echo base_url(); ?>index.php/inventory/dashboard/print_advance_inventory_barcodes?option=" +option+"&zone_id="+zone_ids+"&asn_number="+$('#reference').val()+"";
						window.open(location, '_blank');
						
					}
				}else{
				alert('Please Enter ASN Number');
				}
		

    });


});


 
</script>