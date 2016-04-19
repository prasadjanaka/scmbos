<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <section class="content">
			<div class="row">
                <div class="col-xs-12">

<?php
if ($banner != "") {
	switch ($banner) {
		case "edit": ?>
            <div class="alert alert-success alert-dismissable">
                <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
                <h4>
                    <i class="icon fa fa-check"></i><!--
--><?php	echo "Changes to user are saved.";
			break;
			
		case "add": ?>
            <div class="alert alert-success alert-dismissable">
                <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
                <h4>
                    <i class="icon fa fa-check"></i><!--
--><?php	echo "User is added";
			break;
			
		case "no_match": ?>
            <div class="alert alert-danger alert-dismissable">
                <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
                <h4>
                    <i class="icon fa fa-ban"></i><!--
--><?php	echo "The confirmed password did not match";
			break;
			
		case "exist": ?>
            <div class="alert alert-danger alert-dismissable">
                <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
                <h4>
                    <i class="icon fa fa-ban"></i><!--
--><?php	echo "User already exists. No changes were made.";
			break;
	}
?>
                </h4>
            </div>
<?php
} ?>

                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Users</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                        	<a href="<?php echo base_url(); ?>index.php/system/user?user_id=0">
								<button class="btn btn-block btn-primary" style="width:200px; margin:0 0 10px 0">New User</button>
                            </a>

							<table id="example1" class="table table-bordered table-hover">
								<thead>
									<tr>
                                        <th>Username</th>
                                        <th>EPF Number</th>
                                        <th>Name</th>
                                        <th>User Group</th>
                                        <th>Zone ID</th>
                                    </tr>
                                </thead>
                                <tbody>
<?php foreach ($list_query->result() as $row) { ?>
                                    <tr>
                                        <td><a href="<?php echo base_url(); ?>index.php/system/user?user_id=<?php echo $row->user_id; ?>"><?php echo $row->username; ?></a></td>
                                        <td><?php echo $row->epf_number; ?></td>
                                        <td><?php echo $row->name; ?></td>
                                        <td><?php echo $row->user_group; ?></td>
                                        <td><?php echo $row->zone_id; ?></td>
                                    </tr>
<?php } ?>
                                </tbody>
                            </table>

						</div>
					</div>
                    
				</div>
			</div>
		</section>
	</section>
</div>