<?php $row = $row_query->row(); ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <section class="content">
        
			<div class="row">
				<!-- left column -->
				<div class="col-md-6">
					<!-- general form elements -->
					<div class="box">
						<div class="box-header">
							<h3 class="box-title">Edit Dashboard for <b><?php echo $row->system_date; ?></b></h3>
						</div><!-- /.box-header -->
						<!-- form start -->
						<form action="<?php echo base_url(); ?>/index.php/system/save_dashboard" method="POST" role="form">
							<div class="box-body">

								<div class="form-group">
									<label>Blocked stock quantity</label>
									<input value="<?php echo $row->block_stock; ?>" name="block_stock" placeholder="Blocked Stock" type="text" class="form-control" >
								</div>
                                
								<div class="form-group">
									<label>In-transit stock quantity</label>
									<input value="<?php echo $row->stock_in_transit; ?>" name="stock_in_transit" placeholder="Stock In-Transit" type="text" class="form-control" >
								</div>

								<div class="form-group">
									<label>WMS and SAP discrepant quantity</label>
									<input value="<?php echo $row->wms_sap_quantity; ?>" name="wms_sap_quantity" placeholder="Discrepant Quantity" type="text" class="form-control" >
								</div>

								<div class="form-group">
									<label>WMS and SAP discrepant PIDs</label>
									<input value="<?php echo $row->wms_sap_pids; ?>" name="wms_sap_pids" placeholder="Discrepant PID Quantity" type="text" class="form-control" >
								</div>

								<div class="form-group">
									<label>LPs amended due to GSL reasons</label>
									<input value="<?php echo $row->lps_amend_gsl; ?>" name="lps_amend_gsl" placeholder="LPs Amended Due to GSL" type="text" class="form-control" >
								</div>
                                
								<div class="form-group">
									<label>LPs amended due to LoadStar reasons</label>
									<input value="<?php echo $row->lps_amend_ls; ?>" name="lps_amend_ls" placeholder="LPs Amended Due to LS" type="text" class="form-control" >
								</div>
                                
								<div class="form-group">
									<label>Number of containers requested</label>
									<input value="<?php echo $row->containers_requested; ?>" name="containers_requested" placeholder="Containers Requested" type="text" class="form-control" >
								</div>
                                
								<div class="form-group">
									<label>Number of containers arrived</label>
									<input value="<?php echo $row->containers_arrived; ?>" name="containers_arrived" placeholder="Containers Arrived" type="text" class="form-control" >
								</div>
                                
								<div class="form-group">
									<label>LPs exceeded 3 days</label>
									<input value="<?php echo $row->lps_three_days; ?>" name="lps_three_days" placeholder="LPs Rxceeded 3 Days" type="text" class="form-control" >
								</div>
								
                                <input name="dsh_date" value="<?php echo $row->system_date; ?>" type="hidden" >
								<button class="btn btn-block btn-success" type="submit" >Save</button>
							</div>
						</form>
                        
					</div>
				</div>
			</div><!-- /.row -->
        

		</section>
	</section>
</div>