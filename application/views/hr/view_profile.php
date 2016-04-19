<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Employee Details</title>
</head>

<body>

<table align="center">
<tr>
<?php foreach($result as $results){
	

	
?>
<td width="133">
<img src="<?php echo "/".$results->photo_path ?>" width="132" height="170"/>
</td>

</tr>
</table>
<table width="450px" align="center">
<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr>
<td width="81">EPF Number</td>
<td width="20" align="center" style="width:20px">:-</td>
<td width="81">

<label style="width:20px"><?php echo $results->epf_number

 ?></label>
</td>
</tr>
<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr>
<td>Name</td>
<td align=center style="width:20px">:-</td>
<td>
<label style="width:100px" ><?php echo $results->name ?></label>
</td>
</tr>
<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr>
<td>Designation</td>
<td align="center" style="width:20px">:-</td>
<td>
<label style="width:100px"><?php echo $results->designation ?></label>
</td>
</tr>
<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>

<tr>
<td width="111">Address</td>
<td align="center" style="width:20px">:-</td>
<td>
<label style="width:100px"><?php echo $results->address ?></label>
</td>
</tr>
<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr>
<td width="111">Gender</td><td width="10" style="text-align:right">:-
</td>
<td><?php echo $results->gender ?></td>
</tr>
<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr>
<td width="109">Date Joined</td><td width="11" style="text-align:right">:-</td>

<td><?php echo $results->date_joined ?></td>
</tr>
<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr>
<td width="109">Section</td>
<td width="11" style="text-align:right">:-</td>
<td><?php echo $results->section_name ?></td>

</tr>
<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr>
<td width="109">Job Category</td><td width="11" style="text-align:right">:-</td>
<td><?php echo $results->job_category ?></td>
</tr>
<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr>
<td width="109">Contact Number</td><td width="11" style="text-align:right">:</td>
<td><?php echo $results->contact_number ?></td>

</tr>
<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr>
<td width="109">Email</td><td width="11" style="text-align:right">:-</td>
<td><?php echo $results->email ?></td>

</tr>
<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
<?php } ?>
</table>
</body>
</html>