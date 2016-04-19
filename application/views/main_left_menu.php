<?php 
/*  <?php echo base_url()?>index.php/inventory/dashboard/stacking_norms  */
?>
<!-- Left side column. contains the sidebar -->

<aside class="main-sidebar"> 
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar"> 
    <!-- Sidebar user panel --><!-- search form --><!-- /.search form --> 
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu">
      <li class="header">MAIN NAVIGATION</li>
      <li class="treeview"> <a href="#"> <i class="fa fa-dashboard"></i> <span>Inventory</span> <i class="fa fa-angle-left pull-right"></i> </a>
        <ul class="treeview-menu">
                  <li><a href="<?php echo base_url()?>index.php/inventory/Product_manager/add_new_product"><i class="fa fa-circle-o"></i> Product Manager</a></li>
          <li><a href="<?php echo base_url()?>index.php/inventory/dashboard/stacking_norms"><i class="fa fa-circle-o"></i> Stacking Norms</a></li>
          <li><a href="<?php echo base_url()?>index.php/inventory/dashboard/stacking_norms_adherence"><i class="fa fa-circle-o"></i> Stacking Norm Adherence </a></li>
           <li><a href="<?php echo base_url()?>index.php/inventory/Product_manager/list_pick_face"><i class="fa fa-circle-o"></i> Pick Face </a></li>
          <li><a href="<?php echo base_url()?>index.php/inventory/dashboard/current_inventory"><i class="fa fa-circle-o"></i> Current Inventory</a></li>

      <li><a href="<?php echo base_url()?>index.php/inventory/dashboard/print_barcode"><i class="fa fa-circle-o"></i> Print Barcodes</a></li>
          
          <li><a href="<?php echo base_url()?>index.php/inventory/Product_manager/client_inventory"><i class="fa fa-circle-o"></i> Client's Inventory</a></li>
 
        
          <li class="treeview"> <a href="#"> <i class="fa fa-edit"></i> <span>Location Manager</span> <i class="fa fa-angle-left pull-right"></i> </a><ul class="treeview-menu">
              <li><a href="<?php echo base_url()?>index.php/inventory/location_manager/zone_list"><i class="fa fa-circle-o"></i>Zone</a></li>
              <li><a href="<?php echo base_url()?>index.php/inventory/location_manager/sz_group_zone_load"><i class="fa fa-circle-o"></i>Sub Zone Group</a></li>
              <li><a href="<?php echo base_url()?>index.php/inventory/location_manager/sub_zone_load?zone_id=0"><i class="fa fa-circle-o"></i> Sub Zone</a></li>
              <li><a href="<?php echo base_url()?>index.php/inventory/location_manager/location_load"><i class="fa fa-circle-o"></i> Location</a></li>
            </ul>
          </li>
       
        <li class="treeview"> <a href="#"> <i class="fa fa-edit"></i> <span>Inventory Count</span> <i class="fa fa-angle-left pull-right"></i> </a>
            <ul class="treeview-menu">
           <li><a href="<?php echo base_url()?>index.php/inventory/dashboard/target_count"><i class="fa fa-circle-o"></i> Set Location Count</a></li>
          <li><a href="<?php echo base_url()?>index.php/inventory/dashboard/target_set_scanning_cleark"><i class="fa fa-circle-o"></i> Set Scanners</a></li>
          <li><a href="<?php  echo base_url()?>index.php/inventory/Location_manager/Result"><i class="fa fa-circle-o"></i>Counting Results</a></li>
          <li><a href="<?php echo base_url()?>index.php/inventory/location_manager/confirmed_result"><i class="fa fa-circle-o"></i>Confirmed Results</a></li>
           <li><a href="<?php echo base_url()?>index.php/inventory/Dashboard/ex_summary"><i class="fa fa-circle-o"></i>Executive Summary</a></li>
          <li><a href="<?php echo base_url()?>index.php/inventory/dashboard/location_assign"><i class="fa fa-circle-o"></i>Single Location Assign</a></li>
          <li><a href="<?php echo base_url()?>index.php/inventory/dashboard/product_count"><i class="fa fa-circle-o"></i>PID Count</a></li>
            </ul>
          </li>
       
          
          <li class="treeview"> <a href="#"> <i class="fa fa-edit"></i> <span>Replenishments</span> <i class="fa fa-angle-left pull-right"></i> </a>
            <ul class="treeview-menu">
              <li><a href="<?php echo base_url()?>index.php/inventory/dashboard/replenishment_list?rep_status=pending"><i class="fa fa-circle-o"></i> Pendings</a></li>
              <li><a href="<?php echo base_url()?>index.php/inventory/dashboard/replenishment_list?rep_status=completed"><i class="fa fa-circle-o"></i> Completed</a></li>
              <li><a href="<?php echo base_url()?>index.php/inventory/dashboard/replenishment_list"><i class="fa fa-circle-o"></i> All</a></li>
              
              
            </ul>
          </li>
          
           <li class="treeview"> <a href="#"> <i class="fa fa-edit"></i> <span>Pallet Tracker</span> <i class="fa fa-angle-left pull-right"></i> </a>
            <ul class="treeview-menu">
           <li><a href="<?php echo base_url()?>index.php/report/dashboard/pallet_tracker"><i class="fa fa-th-large"></i><span>Tracker</span> <i class="fa fa-angle-left pull-right"></i> </a>
          <li><a href="<?php echo base_url()?>index.php/report/dashboard/pallet_track_chart"><i class="fa fa-th-large"></i><span>Pallet Movement Summary</span> <i class="fa fa-angle-left pull-right"></i> </a>	  
            </ul>
          </li>
          
             <li class="treeview"> <a href="#"> <i class="fa fa-edit"></i> <span>Pick Manager</span> <i class="fa fa-angle-left pull-right"></i> </a>
            <ul class="treeview-menu">
              <li><a href="<?php echo base_url()?>index.php/inventory/dashboard/pick_list"><i class="fa fa-circle-o"></i> Pick List</a></li>
              
              
            </ul>
          </li>
          
          
          
        </ul>
      </li>
  
      <li class="treeview"> <a href="#"> <i class="fa fa-dashboard"></i> <span> ASN Manager</span> <i class="fa fa-angle-left pull-right"></i> </a>
        <ul class="treeview-menu">
          <li><a href="<?php echo base_url()?>index.php/asn/dashboard/asn_list?top=1000&type=1"><i class="fa fa-circle-o"></i> Recent ASNs</a></li>          
          <li><a href="<?php echo base_url()?>index.php/asn/dashboard/asn_list?type=1"><i class="fa fa-circle-o"></i> Full ASN List</a></li>
          <li><a href="<?php echo base_url()?>index.php/asn/dashboard/asn_list?top=1000&type=2"><i class="fa fa-circle-o"></i> Recent ASNs - Shuttles</a></li>
          <li><a href="<?php echo base_url()?>index.php/asn/dashboard/asn_list?type=2"><i class="fa fa-circle-o"></i> Full ASN List - Shuttles</a></li>
        </ul>        
      </li>
      
       <li class="treeview"> <a href="#"> <i class="fa fa-dashboard"></i> <span>Shuttles</span> <i class="fa fa-angle-left pull-right"></i> </a>
        <ul class="treeview-menu">
          
          <li><a href="<?php echo base_url()?>index.php/asn/dashboard/asn_list?top=1000&type=2"><i class="fa fa-circle-o"></i> Recent IN</a></li>
          <li><a href="<?php echo base_url()?>index.php/asn/dashboard/asn_list?type=2"><i class="fa fa-circle-o"></i> Full IN</a></li>
          
          <li><a href="<?php echo base_url()?>index.php/asn/dashboard/list_shuttles?top=1000"><i class="fa fa-circle-o"></i> Recent OUT</a></li>          
          <li><a href="<?php echo base_url()?>index.php/asn/dashboard/list_shuttles"><i class="fa fa-circle-o"></i> Full OUT</a></li>
        </ul>        
      </li>
      
      
       <li class="treeview"> <a href="#"> <i class="fa fa-dashboard"></i> <span> LP Manager</span> <i class="fa fa-angle-left pull-right"></i> </a>
        <ul class="treeview-menu">
          <li><a href="<?php echo base_url()?>index.php/lp/Lp/lp_list"><i class="fa fa-circle-o"></i>Available LPs</a></li>          
          <li><a href="<?php echo base_url()?>index.php/lp/Lp/lp_schedule"><i class="fa fa-circle-o"></i>Schedule LPs</a></li>   
           <li><a href="<?php echo base_url()?>index.php/lp/Lp/lp_loading"><i class="fa fa-circle-o"></i>Loading Set</a></li> 
          <li><a href="<?php echo base_url()?>index.php/lp/Lp/pick_loading_lps"><i class="fa fa-circle-o"></i>Pick & Loading</a></li> 
          <li><a href="<?php echo base_url()?>index.php/lp/Lp/released_lp_list"><i class="fa fa-circle-o"></i>Released LPs</a></li> 
         <!-- <li><a href="<?php //echo base_url()?>index.php/lp/Lp/pick_list"><i class="fa fa-circle-o"></i>Pick List</a></li> -->      
        </ul>        
      </li>
      
          <li class="treeview"> <a href="#"> <i class="fa fa-book"></i> <span>Jobs</span> <i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
           <li><a href="<?php echo base_url()?>index.php/inventory/Dashboard/job_list"><i class="fa fa-circle-o"></i>Job List</a></li>
      
            </ul>
          </li>
      
      
      <li class="treeview"> <a href="#"> <i class="fa fa-edit"></i> <span>Transport</span> <i class="fa fa-angle-left pull-right"></i> </a>
            <ul class="treeview-menu">
           <li><a href="#"><i class="fa fa-circle-o"></i> Container Request</a></li>
        
            </ul>
          </li>
      
      
		<li class="treeview"> <a href="#"> <i class="fa fa-desktop"></i> <span> System</span> <i class="fa fa-angle-left pull-right"></i> </a>
			<ul class="treeview-menu">
				<li><a href="<?php echo base_url()?>index.php/system/user_group_list"><i class="fa fa-circle-o"></i> User Groups</a></li>
                <li><a href="<?php echo base_url()?>index.php/system/user_list"><i class="fa fa-circle-o"></i> Users</a></li>
                <li><a href="<?php echo base_url()?>index.php/system/dashboard_date"><i class="fa fa-circle-o"></i> Dashboard</a></li>
			</ul>
		</li>          
        <li class="treeview"> <a href="#"><i class="fa fa-fw fa-shopping-cart"></i> <span> MHE</span> <i class="fa fa-angle-left pull-right"></i> </a>
			<ul class="treeview-menu">
				<li><a href="<?php  echo base_url()?>index.php/mhe/dashboard/mhe_list"><i class="fa fa-circle-o"></i>List MHE</a></li>
                	<li><a href="<?php  echo base_url()?>index.php/mhe/Dashboard/mhe_ava_list"><i class="fa fa-circle-o"></i>MHE Availability </a></li>
                    <li><a href="<?php  echo base_url()?>index.php/mhe/Dashboard/mhe_runing_chart"><i class="fa fa-circle-o"></i>MHE Runing Chart </a></li>

			</ul>    
		</li> 
         <li class="treeview"> <a href="#"><i class="fa fa-list"></i> <span>Report</span> <i class="fa fa-angle-left pull-right"></i> </a>
			<ul class="treeview-menu">
				<li><a href="<?php  echo base_url()?>index.php/report/dashboard/product_vs_lp"><i class="fa fa-circle-o"></i>Inventory vs LP</a></li>
                <li><a href="<?php  echo base_url()?>index.php/report/dashboard/view_calendar"><i class="fa fa-circle-o"></i>Calendar</a></li>	
                

			</ul>    
		</li>    
        <li class="treeview" style="display:none"> <a href="#"><i class="fa fa-usd"></i> <span>Finance</span> <i class="fa fa-angle-left pull-right"></i> </a>
			<ul class="treeview-menu">
			<li><a href="<?php  echo base_url()?>index.php/finance/dashboard/supplier"><i class="fa fa-circle-o"></i>Supplier</a></li>
			</ul>    
		</li>  
              
    </ul>
  </section>
  <!-- /.sidebar --> 
</aside>

<!-- =============================================== --> 
