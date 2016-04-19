<body>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <section class="content">
        
			<div class="row">
				<!-- left column -->
				<div class="col-md-6">
                
<?php if ($date_added) { ?>
                <div class="alert alert-success alert-dismissable">
                    <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
                    <h4>
                        <i class="icon fa fa-check"></i>Date successfully added
                    </h4>
                </div>
<?php } ?>

					<!-- general form elements -->
					<div class="box">
						<div class="box-header">
							<h3 class="box-title">System Dashboard</h3>
						</div><!-- /.box-header -->
						<form action="<?php echo base_url(); ?>/index.php/system/dashboard" method="POST" role="form">
							<div class="box-body">
								<div class="form-group">

                                    <label>Enter date:</label>
                                    <div class="input-group">
                                      <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                      </div>
                                      <input name="dsh_date" type="date" class="form-control" placeholder="yyyy-mm-dd" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask />
                                    </div><!-- /.input group -->

								</div>

								<button class="btn btn-block btn-success" type="submit" >Submit</button>
							</div>
						</form>
                        
					</div>
				</div>
			</div><!-- /.row -->
        

		</section>
	</section>
</div>

</body>