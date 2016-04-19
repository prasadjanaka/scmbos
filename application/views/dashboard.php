<!-- Content Wrapper. Contains page content -->
 <style>
     .grid-block-container {
    	float: left;
    	width: 990px;
    	margin: 20px 0 0 -30px;
    }
    .grid-block {
    	position: relative;
    	
    	width: 150px;
    	height: 150px;
    	margin: 0 0 0px 60px;
    }
    .grid-block h4 {
    	font-size: .9em;
    	color: #333;
    	background: #3366FF;
    	margin: 0;
    	padding: 10px;
    	border: 1px solid #ddd;
    }
     
    .caption {
    	display: none;
    	position: absolute;
    	top: 0;
    	left: 0;
    	background: url(<?php echo base_url() ?>skin/images/icon/trans-black-50.png);
    	width: 100%;
    	height: auto;
		border-radius:5px;
    }
    .caption h3, .caption p {
    	color: #fff;
    	margin: 20px;
    }
    .caption h3 {
    	margin: 1px 1px 10px;
    }
    .caption p {
    	font-size: .75em;
    	line-height: 1.5em;
    	margin: 0 10px 15px;
    }
    .caption a.learn-more {
    	padding: 5px 10px;
    	background: #08c;
    	color: #fff;
    	border-radius: 2px;
    	-moz-border-radius: 2px;
    	font-weight: bold;
    	text-decoration: none;
    }
    .caption a.learn-more:hover {
    	background: #fff;
    	color: #08c;
    }
 
 </style>
 
 <script type="text/javascript">
$(document).ready(function() {

	$('.slide').hover(
		function(){
			$(this).find('.caption').slideDown(250);
			//$(this).find('.caption').slideUp(250);
			//$('#ima01').t
			// $(this).find('.img').animate({  width: "+=20", height: "+=20" }, 600);
			//$(this).animate({  width: "+=20", height: "+=20" }, 500);
			
			// this is where the popping out effect happens
   

		},
		function(){
			$(this).find('.caption').slideUp(250);
			//$(this).find('.caption').slideToggle(250);
			// $(this).find('.img').animate({  width: "-=20", height: "-=20" }, 600);
			// $(this).animate({  width: "-=20", height: "-=20" }, 500);
		}
	);
});
</script>
<div class="content-wrapper"> 
  <!-- Content Header (Page header) --> 

  <section class="content">
        <table>
      <tr style="padding-bottom:150px">
             <td>   <a href="<?php echo base_url()?>index.php/inventory/dashboard/stacking_norms"> <div style="border:2px solid #999;border-radius:10px;box-shadow:#CCC 2px 2px 2px 2px"   class="grid-block slide">
    	 <div  class="caption">
            <h3 style="font-size:18px;text-align:center;font-weight:bold">Stacking Norms</h3>
        </div>
    	<img class="img" id="img" style="width:150px;height:150px" src="<?php  echo base_url() ?>skin/images/icon/stack.png" />
    </div></a>
    </td>
      <td>  <a href="<?php echo base_url()?>index.php/inventory/dashboard/target_count"> <div style="border:2px solid #999;border-radius:10px;box-shadow:#CCC 2px 2px 2px 2px"   class="grid-block slide">
    	 <div  class="caption">
            <h3 style="font-size:18px;text-align:center;font-weight:bold">Inventory Count Planner</h3>
        </div>
    	 <img class="img" id="img" style="width:150px;height:150px" src="<?php  echo base_url() ?>skin/images/icon/inventory_count.png" />
    </div></a></td>
      <td>   <a href="<?php echo base_url()?>index.php/inventory/dashboard/target_set_scanning_cleark"> <div style="border:2px solid #999;border-radius:10px;box-shadow:#CCC 2px 2px 2px 2px"   class="grid-block slide">
    	 <div  class="caption">
            <h3 style="font-size:18px;text-align:center;font-weight:bold">Set Scanner to Inventory Count</h3>
        </div>
    	<img class="img" id="img" style="width:150px;height:150px" src="<?php  echo base_url() ?>skin/images/icon/set_scanner.png" />
    </div></a></td>
      <td>   <a href="<?php echo base_url()?>index.php/inventory/Product_manager/list_pick_face"> <div style="border:2px solid #999;border-radius:10px;box-shadow:#CCC 2px 2px 2px 2px"   class="grid-block slide">
    	 <div  class="caption">
            <h3 style="font-size:18px;text-align:center;font-weight:bold">Pick Face</h3>
        </div>
    	<img class="img" id="img" style="width:150px;height:150px" src="<?php  echo base_url() ?>skin/images/icon/pick_face.png" />
    </div></a></td>
      <td>   <a href="<?php echo base_url()?>index.php/inventory/location_manager/location_load"> <div style="border:2px solid #999;border-radius:10px;box-shadow:#CCC 2px 2px 2px 2px"   class="grid-block slide">
    	 <div  class="caption">
            <h3 style="font-size:18px;text-align:center;font-weight:bold">Location</h3>
        </div>
    	<img class="img" id="img" style="width:150px;height:150px" src="<?php  echo base_url() ?>skin/images/icon/icon-location.png" />
    </div></a></td>
      <td>   <a href="<?php echo base_url()?>index.php/inventory/dashboard/print_barcode"> <div style="border:2px solid #999;border-radius:10px;box-shadow:#CCC 2px 2px 2px 2px"   class="grid-block slide">
    	 <div  class="caption">
            <h3 style="font-size:18px;text-align:center;font-weight:bold">Print Barcode</h3>
        </div>
    	<img class="img" id="img" style="width:150px;height:150px" src="<?php  echo base_url() ?>skin/images/icon/barcode printer.png" />
    </div></a></td> 
    
  
      </tr>
  
      </table>

     <br /><br />
     <table>
     <tr>
        <td>   <a href="<?php echo base_url()?>index.php/lp/Lp/lp_list"> <div style="border:2px solid #999;border-radius:10px;box-shadow:#CCC 2px 2px 2px 2px"   class="grid-block slide">
    	 <div  class="caption">
            <h3 style="font-size:18px;text-align:center;font-weight:bold">Available LPs</h3>
        </div>
    	<img class="img" id="img" style="width:150px;height:150px" src="<?php  echo base_url() ?>skin/images/icon/avalable_lp.png" />
    </div></a>
    </td>
    
      <td>   <a href="<?php echo base_url()?>index.php/lp/Lp/lp_schedule"> <div style="border:2px solid #999;border-radius:10px;box-shadow:#CCC 2px 2px 2px 2px"   class="grid-block slide">
    	 <div  class="caption">
            <h3 style="font-size:18px;text-align:center;font-weight:bold">Scheduled LPs</h3>
        </div>
    	<img class="img" id="img" style="width:150px;height:150px" src="<?php  echo base_url() ?>skin/images/icon/lp scheduale.png" />
    </div></a>
    </td> 
        
        <td>   <a href="<?php echo base_url()?>index.php/lp/Lp/lp_loading"> <div style="border:2px solid #999;border-radius:10px;box-shadow:#CCC 2px 2px 2px 2px"   class="grid-block slide">
    	 <div  class="caption">
            <h3 style="font-size:18px;text-align:center;font-weight:bold">Loading Set</h3>
        </div>
    	<img class="img" id="img" style="width:150px;height:150px" src="<?php  echo base_url() ?>skin/images/icon/loading set.png" />
    </div></a>
    </td>
       <td>   <a href="<?php echo base_url()?>index.php/lp/Lp/pick_loading_lps"> <div style="border:2px solid #999;border-radius:10px;box-shadow:#CCC 2px 2px 2px 2px"   class="grid-block slide">
    	 <div  class="caption">
            <h3 style="font-size:18px;text-align:center;font-weight:bold">Pick And Loading</h3>
        </div>
    	<img class="img" id="img" style="width:150px;height:150px" src="<?php  echo base_url() ?>skin/images/icon/pick and load oraginal.png" />
    </div></a></td>
  

 
    
         <td>   <a href="<?php echo base_url()?>index.php/asn/dashboard/asn_list?top=1000&type=1"> <div style="border:2px solid #999;border-radius:10px;box-shadow:#CCC 2px 2px 2px 2px"   class="grid-block slide">
    	 <div  class="caption">
            <h3 style="font-size:18px;text-align:center;font-weight:bold">Recent ASN</h3>
        </div>
    	<img class="img" id="img" style="width:150px;height:150px" src="<?php  echo base_url() ?>skin/images/icon/Recent ASN.png" />
    </div></a>
    </td>
             <td>   <a href="<?php  echo base_url()?>index.php/mhe/dashboard/mhe_list"> <div style="border:2px solid #999;border-radius:10px;box-shadow:#CCC 2px 2px 2px 2px"   class="grid-block slide">
    	 <div  class="caption">
            <h3 style="font-size:18px;text-align:center;font-weight:bold">MHE List</h3>
        </div>
    	<img class="img" id="img" style="width:150px;height:150px" src="<?php  echo base_url() ?>skin/images/icon/mhe list.png" />
    </div></a>
    </td>

     </tr>
     </table>
<br/><br/>

<table>
<tr>

    <td>   <a href="<?php  echo base_url()?>index.php/mhe/Dashboard/mhe_ava_list"> <div style="border:2px solid #999;border-radius:10px;box-shadow:#CCC 2px 2px 2px 2px"   class="grid-block slide">
    	 <div  class="caption">
            <h3 style="font-size:18px;text-align:center;font-weight:bold">MHE Availability</h3>
        </div>
    	<img class="img" id="img" style="width:150px;height:150px" src="<?php  echo base_url() ?>skin/images/icon/mhe ava.png" />
    </div></a>
    </td>
    
    <td>   <a href="<?php  echo base_url()?>index.php/mhe/Dashboard/mhe_runing_chart"> <div style="border:2px solid #999;border-radius:10px;box-shadow:#CCC 2px 2px 2px 2px"   class="grid-block slide">
    	 <div  class="caption">
            <h3 style="font-size:18px;text-align:center;font-weight:bold">MHE Runing Chart</h3>
        </div>
    	<img class="img" id="img" style="width:150px;height:150px" src="<?php  echo base_url() ?>skin/images/icon/runing.png" />
    </div></a>
    </td>
</tr>
</table>
    <?php //print_r($_SESSION); ?>
</section>
  <!-- /.content --> 
</div>
<!-- /.content-wrapper --> 
	
