
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <section class="content">
            <div class="row">
                <div class="col-xs-6">

<?php	if ($group_added) { ?>
                <div class="alert alert-success alert-dismissable">
                    <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
                    <h4>
                        <i class="icon fa fa-check"></i>User group successfully saved!
                    </h4>
                </div>
<?php	}
/*		if($bool) { ?>
                <div class="alert alert-danger alert-dismissable">
                    <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
                    <h4>
                        <i class="icon fa fa-ban"></i>User group name already exists!
                    </h4>
                </div>
<?php	}*/ ?>

                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">User Groups</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                        	<a href="<?php echo base_url(); ?>index.php/system/user_group?edit=0">
								<button class="btn btn-block btn-primary" style="width:200px; margin:0 0 10px 0">New User Group</button>
                            </a>
                        	
							<table id="example1" class="table table-bordered table-striped">
								<thead>
									<tr>
										<th>User Group</th>
                                        <th>Users</th>
                                    </tr>
                                </thead>
                                <tbody>
<?php foreach ($query->result() as $row) { ?>
                                    <tr>
                                        <td><a href="<?php echo base_url(); ?>index.php/system/user_group?edit=<?php echo $row->user_group_id; ?>"><?php echo $row->user_group; ?></a></td>
                                        <td><?php echo $row->user_count; ?></td>
                                    </tr>
<?php } ?>
                                </tbody>
                            </table>
					
				</div>
			</div>
		</section>
	</section>
</div>