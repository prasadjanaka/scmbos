<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<section class="content">
			<div class="row">
				<div class="col-xs-6">
                					
					<div class="box">
						<div class="box-header">
							<h3 class="box-title"><?php if ($user_id != 0) {echo "Edit";} else {echo "New";} ?> User</h3>
						</div><!-- /.box-header -->
						<div class="box-body">

						<form action="<?php echo base_url().'index.php/system/save_user'; ?>" method="POST" >
                            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>" />
                            <input type="hidden" name="status_id" value="<?php echo $status_id; ?>" />
                            <input type="hidden" name="customer_id" value="<?php echo $customer_id; ?>" />
                            
<!--	USERNAME			-->
                            <div class="form-group">
								<label>Username</label>
								<input name="username" placeholder="Enter Username" type="text" value="<?php echo $username; ?>" class="form-control" />
							</div>

<!--	EPF NUMBER			-->
                            <div class="form-group">
								<label>EPF Number</label>
								<input name="epf_number" placeholder="Enter EPF Number" type="text" value="<?php echo $epf_number; ?>" class="form-control" />
							</div>

<!--	NAME				-->
                            <div class="form-group">
								<label>Name</label>
								<input name="name" placeholder="Enter Name" type="text" value="<?php echo $name; ?>" class="form-control" />
							</div>

<!--	PASSWORD			-->
<?php
if ($user_id == 0) { ?>
							<!-- Password -->
							<div class="form-group">
								<label>Create Password</label>
								<input name="password" placeholder="New Password" type="password" class="form-control" />
							</div>
                            
                            <!-- Password confirm -->
                            <div class="form-group">
								<label>Confirm Password</label>
								<input name="password_confirm" placeholder="Enter Password Again" type="password" class="form-control" />
							</div>

<?php } ?>

<!--	USER GROUP			-->
                            <div class="form-group">
								<label>User Group</label>
								<select name="user_group_id" class="form-control" >
                                   	<option value="0"></option>
<?php
foreach ($user_group_query->result() as $user_group_row) {
?>
									<option value="<?php echo $user_group_row->user_group_id; ?>"
									<?php
                                    if ($user_group_row->user_group_id == $user_group_id) {echo 'selected="selected"';}
									?>
                                    >
                                    	<?php echo $user_group_row->user_group_id." - ".$user_group_row->user_group; ?>
                                    </option>
<?php } ?>
								</select>
							</div>

<!--	ZONE				-->
                            <div class="form-group">
								<label>Zone</label>
								<select name="zone_id" class="form-control" >
                                   	<option value="0"></option>
<?php
foreach ($zone_query->result() as $zone_row) {
?>
									<option value="<?php echo $zone_row->zone_id; ?>"
									<?php
                                    if ($zone_row->zone_id == $zone_id) {echo 'selected="selected"';}
									?>
                                    >
										<?php echo $zone_row->zone_id." - ".$zone_row->zone; ?>
                                    </option>
<?php } ?>
								</select>
							</div>

<!--	ENEABLE USER		--
							<div class="form-group">
								<label>
								<input name="user_status" type="checkbox" class="minimal-red" />
									<span style="color:#FF0000"><span style="color:#FFFFFF">-</span>Disable User Login</span>
								</label>
							</div>

<!--	SAVE 				-->
                            <button class="btn btn-block btn-success" type="submit" >Save</button>

						</div>
					</div>
                    
				</div>
			</div>
		</section>
	</section>
    
</div>