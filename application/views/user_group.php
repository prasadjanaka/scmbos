<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <section class="content">
	        <div class="row">
                <div class="col-xs-6">

                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title"><?php if ($edit != 0) {echo 'Edit';} else {echo 'New';} ?> User Group</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">
<form action="<?php echo base_url().'index.php/system/save_user_group'; ?>" method="POST" >
<div class="form-group">
	<label>User Group Name</label>
	<input name="user_group_name" placeholder="Enter User Group Name" type="text" class="form-control" required="required" value=
	"<?php
		if ($edit != 0) {
	    	$name = $user_group_name->row();
			echo $name->user_group;
		} else {
			echo "";
		}
	?>"
/>
</div>

<?php if ($edit != 0) { ?>
      <div class="box-group" id="accordion">
        <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
        
<?php	foreach ($query_parent->result() as $row_parent) { ?>
        
        <div class="panel box-default"><!-- <div class="panel >>>>>>box<<<<<< box-default"> -->
          <div class="box-header">
            <h4 class="box-title">
              <a aria-expanded="false" class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#<?php echo $row_parent->module_id; ?>">
                <?php echo $row_parent->module; ?>
              </a>
            </h4>
          </div>
          <div aria-expanded="false" id="<?php echo $row_parent->module_id; ?>" class="panel-collapse collapse">
            <div class="box-body">
                
<?php		foreach ($query_module->result() as $row_module) {
				if ($row_module->parent_module_id == $row_parent->module_id) { ?>
                
                <div class="checkbox">
                    <label>
                    <input name="<?php echo $row_module->module_id; ?>" type="checkbox" <?php
						foreach ($query_check->result() as $row_check) {
							if ($row_module->module_id == $row_check->module_id) {
								echo 'checked="checked"';
							}
						}
					?> />
                        <?php echo $row_module->module; ?>
                    </label>
                </div>
<?php			}
			} ?>

            </div>
          </div>
        </div>

<?php	}
}?>
		<input type="hidden" name="edit" value="<?php echo $edit; ?>" />
        <input type="hidden" name="prev_group_name"
value="<?php
		if ($edit != 0) {
	    	$name = $user_group_name->row();
			echo $name->user_group;
		} else {
			echo "";
		}
?>"/>
    	<button class="btn btn-block btn-success" type="submit" >Save</button>

	</form>
</div>
