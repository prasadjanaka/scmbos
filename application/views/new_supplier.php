

<body>

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
							<h3 class="box-title"><?php if ($edit==0) {echo "New";} else{echo "Edit";} ?> Supplier</h3>
						</div><!-- /.box-header -->
						<!-- form start -->
						<form action="<?php echo base_url(); ?>/index.php/suppliers/save_supplier" method="POST" role="form">
							<div class="box-body">
<!-- Supplier Type for drop-down -->
								<div class="form-group">
<!-- EDIT REFERENCE ----------- -->	<input hidden="hidden" name="edit" value="<?php echo $edit; ?>" />
									<label>Supplier Type</label>
									<select name="supplier_type_id" class="form-control" >
                                    	<option value="blank_alpha"></option>
<?php foreach ($query_type->result() as $row) { ?>
										<option
                                        	value="<?php echo $row->supplier_type_id; ?>"
<?php	if($edit!=0) {
			if ($supplier_type == $row->supplier_type) {echo 'selected';} 
		}
?>
										>
                                        	<?php echo $row->supplier_type; ?>
										</option>
<?php } ?>
                                    </select>
								</div>

								<div class="form-group">
									<label>Supplier Name</label>
									<input value="<?php echo $supplier; ?>" name="supplier" placeholder="Supplier" type="text" class="form-control" >
								</div>
								<div class="form-group">
									<label>Contact Number</label>
									<input value="<?php echo $contact_number; ?>" name="contact_number" placeholder="Phone number" type="text" class="form-control" >
								</div>
								<div class="form-group">
									<label>Contact Person</label>
									<input value="<?php echo $contact_person; ?>" name="contact_person" placeholder="Contact person" type="text" class="form-control" >
								</div>
								<div class="form-group">
									<label>Postal Address</label>
									<input value="<?php echo $address; ?>" name="address" placeholder="Address" type="text" class="form-control" >
								</div>
								<div class="form-group">
									<label>Email Address</label>
									<input value="<?php echo $email; ?>" name="email" placeholder="Email" type="email" class="form-control" >
								</div>
								<div class="form-group">
									<label>Fax Number</label>
									<input value="<?php echo $fax_number; ?>" name="fax_number" placeholder="Fax number" type="text" class="form-control" >
								</div>
								<div class="form-group">
									<label>Credit Period</label>
									<input value="<?php echo $credit_period; ?>" name="credit_period" placeholder="Credit Period in days" type="text" class="form-control" >
								</div>

<!-- Payment Term for drop-down -->
								<div class="form-group">
									<label>Payment Term</label>
									<select name="payment_term_id" class="form-control" >
                                    	<option value="blank_bravo"></option>
<?php foreach ($query_term->result() as $row) { ?>
										<option
                                        	value="<?php echo $row->payment_term_id; ?>"
<?php	if ($edit != 0) {
			if ($payment_term == $row->payment_term) {echo 'selected';}
		}
?>
										>
											<?php echo $row->payment_term; ?>
										</option>
<?php } ?>
                                    </select>
								</div>


								<button class="btn btn-block btn-success" type="submit" >Save</button>
							</div>
						</form>
                        
					</div>
				</div>
			</div><!-- /.row -->
        

		</section>
	</section>
</div>