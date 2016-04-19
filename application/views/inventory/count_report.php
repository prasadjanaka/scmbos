<?php require_once('loader.php');
date_default_timezone_set("Asia/Colombo");
?>

<div class="content-wrapper">
  <section class="content ">
    <div class="box-body compact">
     <table align="right"><tr>
             <td style="font-weight:bold">Shortcuts  &rArr; &nbsp;&nbsp;&nbsp;</td>
             <td style="padding-left:20px"><a href="<?php echo base_url()?>index.php/inventory/dashboard/target_count?ds=<?php if($ds!=""){echo $ds; }?>" >Location Count</a></td> 
               <td style="padding-left:20px"><a href="<?php echo base_url()?>index.php/inventory/dashboard/target_set_scanning_cleark?date=<?php if($ds!=""){echo $ds; }?>" >Set Scanner</a></td>
              <td style="padding-left:20px"><a href="<?php echo base_url()?>index.php/inventory/location_manager/confirmed_result?ds=<?php echo $ds  ?>" >Confirmed Results</a></td>
               <td style="padding-left:20px;"><a href="<?php echo base_url()?>index.php/inventory/location_manager/Result?ds=<?php echo $ds  ?>" >Counting Results</a></td>
            

 <td style="padding-left:20px"><a href="<?php echo base_url()?>index.php/inventory/Dashboard/ex_summary?ds=<?php echo $ds  ?>" >Executive Summary</a></td> 
              
              </tr></table>
    <h4>Count vs WMS vs SAP</h4>
    <div  style="width:100%; height:440px; overflow:auto;display:inline-block">
    <table  class="table">
    	<thead>
        	<tr style="background-color:#999">
            	<th>Product ID</th>
                <th style="width:350px">Description</th>
                <th>Zone</th>
                <th>Sub Zone</th>
                <th>Location</th>
                <th>Count1</th>
                <th>Count2</th>
                <th>Count3</th>
                <th>Count4</th>
                <th>Count5</th>
                <th>WMS</th>
               <!--  <th>SAP</th> -->
            </tr>
        </thead>
        
    <tbody>
    <?php if($result->num_rows()>0){
		$count1=0;$count2=0;$count3=0;$count4=0;$count5=0;$totwms=0;
		$sap_inventory=0;
		$pid="";
		$i=0;
		foreach($result->result() as $rows ){
		$i++;
	
		 if($rows->product_id == $pid){  ?>
    	<tr>
        	<td></td>
            <td></td>
            <td><?php echo $rows->zone ?></td>
            <td><?php echo $rows->sub_zone ?></td>
            <td><?php echo $rows->location ?></td>
            <td style="text-align:center"><?php echo $rows->count_1 ?></td>
            <td style="text-align:center"><?php echo $rows->count_2 ?></td>
            <td style="text-align:center"><?php echo $rows->count_3 ?></td>
            <td style="text-align:center"><?php echo $rows->count_4 ?></td>
            <td style="text-align:center"><?php echo $rows->count_5 ?></td>
            <td style="text-align:center"><?php echo $rows->inventory_quantity ?></td>
            <td></td>
        </tr>
        <?php  
			$count1=$count1 + $rows->count_1;
			$count2=$count2 + $rows->count_2;
			$count3=$count3 + $rows->count_3;
			$count4=$count4 + $rows->count_4;
			$count5=$count5 + $rows->count_5;
			$totwms = $totwms + $rows->inventory_quantity;  ?>
    <?php }else{ ?>
    
    <?php  	if($pid!=""){?>
			
			 <tr >
             <td  colspan="2"></td>
        	<td style="text-align:right;font-weight:bold;font-size:16px;background-color:#CCC" colspan="3">Total</td>
        
            <td style="text-align:center;font-weight:bold;font-size:16px;background-color:#CCC"><?php echo $count1 ?></td>
            <td style="text-align:center;font-weight:bold;font-size:16px;background-color:#CCC"><?php echo $count2 ?></td>
            <td style="text-align:center;font-weight:bold;font-size:16px;background-color:#CCC"><?php echo $count3 ?></td>
            <td style="text-align:center;font-weight:bold;font-size:16px;background-color:#CCC"><?php echo$count4 ?></td>
            <td style="text-align:center;font-weight:bold;font-size:16px;background-color:#CCC"><?php echo $count5 ?></td>
            <td style="text-align:center;font-weight:bold;font-size:16px;background-color:#CCC"><?php echo $totwms ?></td>
           <!-- <td style="text-align:center;font-weight:bold;font-size:16px;background-color:#CCC"><?php  //echo $sap_inventory ?></td> -->
        </tr>
	<?php if($rows->sap_qty==""){
				$sap_inventory =0;
			}else{
				$sap_inventory = $rows->sap_qty;
			}
				}  
   				$count1=0;
				$count2=0;
				$count3=0;
				$count4=0;
				$count5=0;
				$totwms=0;
				$count1=$count1 + $rows->count_1;
				$count2=$count2 + $rows->count_2;
				$count3=$count3 + $rows->count_3;
				$count4=$count4 + $rows->count_4;
				$count5=$count5 + $rows->count_5;
				$totwms = $totwms + $rows->inventory_quantity;
				?>
				
                
   	 <tr>
        	<td><?php echo $rows->product_id ?></td>
            <td><?php echo $rows->description ?></td>
            <td><?php echo $rows->zone ?></td>
            <td><?php echo $rows->sub_zone ?></td>
            <td><?php echo $rows->location ?></td>
            <td style="text-align:center"><?php echo $rows->count_1 ?></td>
            <td style="text-align:center"><?php echo $rows->count_2 ?></td>
            <td style="text-align:center"><?php echo $rows->count_3 ?></td>
            <td style="text-align:center"><?php echo $rows->count_4 ?></td>
            <td style="text-align:center"><?php echo $rows->count_5 ?></td>
            <td style="text-align:center"><?php echo $rows->inventory_quantity ?></td>
           <!--  <td></td> -->
        </tr>
    
    
     <?php } ?>
     	  <?php $pid = 	$rows->product_id;?>
      <?php } ?>
      <?php if($result->num_rows()==$i){ ?>
 <tr >
             <td  colspan="2"></td>
        	<td style="text-align:right;font-weight:bold;font-size:16px;background-color:#CCC" colspan="3">Total</td>
        
            <td style="text-align:center;font-weight:bold;font-size:16px;background-color:#CCC"><?php echo $count1 ?></td>
            <td style="text-align:center;font-weight:bold;font-size:16px;background-color:#CCC"><?php echo $count2 ?></td>
            <td style="text-align:center;font-weight:bold;font-size:16px;background-color:#CCC"><?php echo $count3 ?></td>
            <td style="text-align:center;font-weight:bold;font-size:16px;background-color:#CCC"><?php echo$count4 ?></td>
            <td style="text-align:center;font-weight:bold;font-size:16px;background-color:#CCC"><?php echo $count5 ?></td>
            <td style="text-align:center;font-weight:bold;font-size:16px;background-color:#CCC"><?php echo $totwms ?></td>
          <!--  <td style="text-align:center;font-weight:bold;font-size:16px;background-color:#CCC"><?php  //echo $sap_inventory ?></td> -->
        </tr>
			 <?php	}?>
       <?php } ?>
    </tbody>
 
    </table>
     </div> 
    <br>
    <hr>
     <table>
      <form method="GET">
      	<tr>
        	<td> <label>Date</label></td>
            <td style="padding-left:10px"><input value="<?php  echo $ds  ?>" type="text" id="ds" name="ds" class="form-control datemask"/></td>
            <td style="padding-left:10px"><input  type="submit" value="List" style="width:100px" class="btn  btn-facebook"/></td>
            
            
                <td>&nbsp;&nbsp;&nbsp;</td>
                <td>
                <input type="button" value="Export to Excel" id="write_to_excel"  class="btn  btn-facebook"/>
                </td>
               
        </tr>
      </form>
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

$('#write_to_excel').click(function(e) {
   window.location ="<?php echo base_url() ?>index.php/inventory/dashboard/count_report_to_excel?ds="+$("#ds").val()+"";
});
</script>