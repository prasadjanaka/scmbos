<?php require_once('loader.php');
$asn = $asn->row();
?>

<div class="content-wrapper">
  <section class="content ">
    <div class="box-body compact">
      <section class="invoice">    
        <div class="row"> 
          <!-- accepted payments column -->
		  <div align="center" style="width:100%;height:100% "class="col-xs-12">
		
            <table style="width:100%;text-align:center"  border="0">
  <tr>
    <td style="text-align:center;width:auto;background-color:#CCCCCC;padding:0px;font-size: 13px;" colspan="" ><strong>ASN NUMBER </strong><div><?php  echo $asn->asn_number  ?></div></td>
    
    <td style="text-align:center;width:auto;background-color:#CCCCCC;padding:0px;font-size: 13px" colspan=""><strong>CONTAINER SIZE </strong><div><?php  echo $asn->container_size  ?></div></td>
    
    <td style="text-align:center;width:auto;background-color:#CCCCCC;padding:0px;font-size: 13px" colspan="" ><strong style="text-align:center">CONTAINER NUMBER </strong><div><?php  echo $asn->container_number  ?></div></td>
  </tr>
</table>   
            <table align="right" style="width:100%;height:auto;border:solid 1px #666666">
           
              <tr>
                       <td  style="background-color:#999999;padding:10px;font-size: 10px" colspan="4" align="left"><strong>Stacking Summary</strong></td>
                       
              </tr>
                 <tr style="background-color:#CCC">
                   
                    <td style="width: auto;text-align:left;padding:5px;font-size: 10px"><strong>Type</strong></td>
                
                    <td style="width: auto;text-align:center;padding:5px;font-size: 10px"><strong><span style="text-align:center">Full</span></strong></td>
                    <td style="width: auto;text-align:center;padding:5px;font-size: 10px"><strong><span style="text-align:center">Part</span></strong></td>
                    <td style="width: auto;text-align:center;padding:5px;font-size: 10px"><strong><span >Total</span></strong></td>
                  </tr>
                 
                  <tbody>
                  <?php foreach($asn_barcodes_summary->result() as $asn_barcodes_summary_line){?>
                  <tr>
                   
                   
                  
                    <td style="text-align:left;font-size:10px;"><?php echo $asn_barcodes_summary_line->product_stack_type?></td>
                    
                    <td style="text-align:center;font-size:10px"><?php echo ($asn_barcodes_summary_line->full_stack==0?"":$asn_barcodes_summary_line->full_stack)?></td>
                    <td style="text-align:center;font-size:10px"><?php echo $asn_barcodes_summary_line->part_stack?></td>
                    <td style="text-align:center;font-size:10px"><?php echo $asn_barcodes_summary_line->full_stack + $asn_barcodes_summary_line->part_stack?></td>                    
                    
                  </tr>
                  <?php } ?>
                  
                  </tbody>
                  </table>
                  
                  
                  <table style="width:100%;height:100%; " class="table table-striped">
                      <thead style="display: table-header-group;">

                      <tr>
                    <th style="background-color:#CCC;width:150px;height:40px;font-size:12px" align="left">Product ID</th>
                    <th style="background-color:#CCC;width:auto;padding-left:5px;font-size:12px" align="left">Description</th>
                    <th style="background-color:#CCC;width:auto;text-align:center;font-size:12px" >Zone</th>
                    <th style="background-color:#CCC;width:auto;text-align:center;font-size:12px" >Quantity</th>
                    <th style="background-color:#CCC;width:auto;font-size:12px" align="left">Type</th>
                    <th style="background-color:#CCC;width:auto;text-align:center;font-size:12px" >PPS</th>
                    <th style="background-color:#CCC;width:auto;text-align:center;font-size:12px" >Full</th>
                    <th style="background-color:#CCC;width:auto;text-align:center;font-size:12px" >Part</th>
                    <th style="background-color:#CCC;width:auto;text-align:center;font-size:12px" >Part Qty</th>
                  </tr>
                  </thead> 
                   <tbody>
                  <?php 
				  $total_quantity = 0;
				  $total_full_stack = 0;
				  $total_part_stack = 0;				  
				  $total_part_stack_quantity = 0;
				  $qty_totel=0;  				  
				  foreach($asn_barcodes->result() as $asn_barcode){
//					  $total_quantity += $asn_barcode->quantity;
//					  $total_full_stack += $asn_barcode->full_stack;
//					  $total_part_stack += $asn_barcode->part_stack;				  
//					  $total_part_stack_quantity += $asn_barcode->part_stack_quantity;		
					$qty_totel=$qty_totel+$asn_barcode->quantity;			  
				  ?>
                
                  <tr>
                    <td style="padding-top:10px;font-size:10px" align="left"><?php echo $asn_barcode->product_id?></td>
                    <td style="padding-top:10px;font-size:10px" align="left"><?php echo $asn_barcode->description?></td>
                    <td style="padding-top:10px;font-size:10px;text-align:center" align="" ><?php echo $asn_barcode->zone?></td>
                    <td style="padding-top:10px;font-size:10px;text-align:center" align="" ><?php echo $asn_barcode->quantity?></td>
                    <td style="padding-top:10px;font-size:10px" align="left"><?php echo $asn_barcode->product_stack_type?></td>
                    <td style="text-align:center;padding-top:10px;font-size:10px"><?php echo $asn_barcode->pps?></td>
                    <td style="text-align:center;padding-top:10px;font-size:10px"><?php echo ($asn_barcode->full_stack==0?"":$asn_barcode->full_stack)?></td>
                    <td style="text-align:center;padding-top:10px;font-size:10px"><?php echo $asn_barcode->part_stack?></td>
                    <td style="text-align:center;padding-top:10px;font-size:10px"><?php echo $asn_barcode->part_stack_quantity?></td>
                  </tr>
                  <?php } ?>
                  <tr style="border:1px solid #000">
                    <td style="padding-top:10px;font-size:10px" align="left"></td>
                    <td style="padding-top:10px;font-size:10px" align="left"></td>
                    <td style="padding-top:10px;font-size:12px;text-align:center" align="" ><strong>Total</strong></td>
                    <td style="padding-top:10px;font-size:15px;text-align:center" align="" ><?php echo $qty_totel?></td>
                    <td style="padding-top:10px;font-size:10px" align="left"></td>
                    <td style="text-align:center;padding-top:10px;font-size:10px"></td>
                    <td style="text-align:center;padding-top:10px;font-size:10px"></td>
                    <td style="text-align:center;padding-top:10px;font-size:10px"></td>
                    <td style="text-align:center;padding-top:10px;font-size:10px"></td>
                  </tr>
             
                </tbody>
              </table>
              </div>
            </div>
          </div>          
  
      </section>
    </div>
</div>
