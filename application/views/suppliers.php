<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <section class="content">
            <div class="row">
                <div class="col-xs-12">

                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Supplier Information</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">

<a href="<?php echo base_url(); ?>/index.php/suppliers/new_supplier?edit=0">
	<button class="btn btn-block btn-primary" style="width:200px; margin:-10px 0 5px 0">New Supplier</button>
</a>

                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Type</th>
                                        <th>Supplier</th>
                                        <th>Contact Number</th>
                                        <th>Contact Person</th>
                                        <th>Address</th>
                                        <th>Email</th>
                                        <th>Fax</th>
                                        <th>Credit Period</th>
                                        <th>Payment Term</th>
                                    </tr>
                                </thead>
                                <tbody>
<?php foreach ($query->result() as $row) { ?>
                                    <tr>
                                    	<td><?php echo $row->supplier_type; ?></td>
                                        <td><a href="<?php echo base_url(); ?>/index.php/suppliers/new_supplier?edit=<?php echo $row->supplier_id; ?>"><?php echo $row->supplier; ?></a></td>
                                        <td><?php echo $row->contact_number; ?></td>
                                        <td><?php echo $row->contact_person; ?></td>
                                        <td><?php echo $row->address; ?></td>
                                        <td><?php echo $row->email; ?></td>
                                        <td><?php echo $row->fax_number; ?></td>
                                        <td><?php echo $row->credit_period; ?></td>
                                        <td><?php echo $row->payment_term; ?></td>
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


</body>
</html>