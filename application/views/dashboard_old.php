
 <link href="<?php echo base_url()?>resources/gtl/css/ionicons.min.css" rel="stylesheet" type="text/css" /> 

<div class="content-wrapper" >
  <section class="content">
  <br /><br />  <br /><br />
  <div class="row">
  
   <div class="col-lg-3 col-xs-3" style="left:10%; position:relative; margin:0 auto"> 
  <div class="small-box bg-blue">
          <div class="inner">
            <h3>Assigning</h3>
            <p>Assign Sub Zones / Products for counting
              &nbsp;&nbsp; &nbsp;&nbsp;
             <br />
              <br /><br />

          </div>
          <div class="icon"> <i class="ion ion-person-add"></i> </div>
          <a href="<?php echo base_url()?>index.php/inventory/dashboard/target_count" class="small-box-footer"> Set Locations to Count <i class="fa fa-arrow-circle-right"></i> </a> 
          <a href="<?php echo base_url()?>index.php/inventory/dashboard/product_count" class="small-box-footer"> Assign Products to Count <i class="fa fa-arrow-circle-right"></i> </a> 
          </div>
  </div>   
     
      <div class="col-lg-3 col-xs-3" style="left:10%; position:relative; margin:0 auto"> 
        <!-- small box -->
        <div class="small-box bg-green">
          <div class="inner">
            <h3>References</h3>
            <p>Assign scanners to count
              locations &nbsp; &nbsp;</p><br /><br />

          </div>
          <div class="icon"> <i class="ion ion-bag"></i> </div>
          <a href="<?php echo base_url()?>index.php/inventory/count_ref_manager/count_ref_list" class="small-box-footer"> Count Reference Manager <i class="fa fa-arrow-circle-right"></i> </a>
          <a href="<?php echo base_url()?>index.php/inventory/dashboard/target_set_scanning_cleark" class="small-box-footer"> Set Counting Order <i class="fa fa-arrow-circle-right"></i> </a>
                
          </div>
      </div>
      
      <div class="col-lg-3 col-xs-3" style="left:10%; position:relative; margin:0 auto"> 
        <!-- small box -->
        <div class="small-box bg-maroon">
          <div class="inner">
            <h3>Counting Results</h3>
            <p>Confirm or Set Recounts here<br />
             &nbsp; &nbsp; </p>
              <br />
          </div>
          <div class="icon"> <i class="ion ion-ios7-pricetag-outline"></i> </div>
          <a href="<?php  echo base_url()?>index.php/inventory/Location_manager/Result" class="small-box-footer"> Counting Results <i class="fa fa-arrow-circle-right"></i> </a>
          <a href="<?php echo base_url()?>index.php/inventory/location_manager/confirmed_result" class="small-box-footer"> Confirmed Results <i class="fa fa-arrow-circle-right"></i> </a>
         
      </div>
      
      </div>
      
      </div>
    <div class="row"> 
      
      <!-- RECIEVING MODULE -->
      <div class="col-lg-3 col-xs-3" style="left:10%; position:relative; margin:0 auto"> 
        <!-- small box -->
        <div class="small-box bg-orange">
          <div style="" class="inner">
             <h3>Ex-Summary</h3>
            <p><a href="<?php echo base_url()?>index.php/inventory/count_ref_manager/icmdb_load?ds=<?php echo date("Y-m-d")?>" style="color:#FFF">Monitor Progress of your count</a></p>
             &nbsp;&nbsp; &nbsp;&nbsp; </p>
              
          </div>
          
          <div class="icon"> <i class="ion ion-pie-graph"></i> </div>
           <a href="<?php echo base_url()?>index.php/inventory/Dashboard/ex_summary" class="small-box-footer"> Executive Summary <i class="fa fa-arrow-circle-right"></i> </a> 
            <a href="<?php echo base_url()?>index.php/inventory/Dashboard/ex_summary_sub_zone" class="small-box-footer"> Counting Map <i class="fa fa-arrow-circle-right"></i> </a>
          
          
          </div>
      
      </div>
      
      <!-- ./col --> 
      
      <!-- REPORTING MODULE -->
      <div class="col-lg-3 col-xs-3" style="left:10%; position:relative; margin:0 auto"> 
        <!-- small box -->
        <div class="small-box bg-red">
          <div style="" class="inner">
          <h3>Reports</h3>
           <p>Count vs WMS vs SAP 
           &nbsp;&nbsp; &nbsp;&nbsp; </p>
                <br />
           </p>
          
          </div>
          <div class="icon"> <i class="ion ion-stats-bars"></i> </div>
           <a href="<?php echo base_url()?>index.php/inventory/Dashboard/count_report" target="_blank" class="small-box-footer"> Final Altogether <i class="fa fa-arrow-circle-right"></i> </a>
             <a href="<?php echo base_url()?>index.php/inventory/dashboard/ref_distribution"  class="small-box-footer">Reference Distribution<i class="fa fa-arrow-circle-right"></i> </a> 
           <!--  <a href="<?php //echo base_url()?>index.php/inventory/Dashboard/scanner_allocation" class="small-box-footer"> Team Distribution <i class="fa fa-arrow-circle-right"></i> </a> -->
          </div>
          
      </div>
      
<div class="col-lg-3 col-xs-3" style="left:10%; position:relative; margin:0 auto"> 
        <!-- small box -->
        <div class="small-box bg-aqua">
          <div  class="inner">
            <h3>Master Data</h3>
           <p>Browse master data used for this count</p>
           &nbsp;&nbsp; &nbsp;&nbsp; </p>
             
          </div>
          <div class="icon"> <i class="ion ion-ios7-briefcase-outline"></i> </div>
        
          
          <a href="<?php echo base_url()?>index.php/inventory/Product_manager/client_inventory" target="_blank" class="small-box-footer"> Client's Inventory <i class="fa fa-arrow-circle-right"></i> </a>
          
          <table class="small-box-footer" align="center" >
          	<tr>
            	<td style="padding-left:20px;padding-right:5px">WMS</td>
                <td>   <a style="color:rgba(255,255,255,0.8)" href="<?php echo base_url()?>index.php/inventory/dashboard/current_inventory" target="_blank" class="small-box-footer"> Location Inventory </a></td>
                <td style="padding-left:5px;padding-right:5px">|</td>
                <td>   <a style="color:rgba(255,255,255,0.8)" href="<?php echo base_url()?>index.php/inventory/dashboard/current_inventory_pid" target="_blank" class="small-box-footer"> PID Inventory <i class="fa fa-arrow-circle-right"></i> </a></td>
            </tr>
          </table>
         
         
         
           </div>
      </div>      
      <!-- ./col --> 
      
    </div>
     
  </section>
</div>
