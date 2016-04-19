<br />
<br />
<?php foreach($asn_detail->result() as $asn_details){ ?>

<table width="96%" border="0">
<tr>
<td width="30%" style="background-color:#E4E4E4;height:20px;font-size:14px;font-weight:bold">ASN Unique No</td>
<td style="background-color:#E4E4E4;height:20px;font-size:14px;font-weight:bold"><?php echo $asn_details->asn_number; ?></td>
</tr>

<tr>
<td></td>
</tr>
<tr>
<td style="background-color:#E4E4E4;height:20px;font-size:14px;font-weight:bold">Barcorde</td>
<td><img src="<?php echo $path; ?>" style='width:200px;height:30px'></td>
</tr>
<tr>
<td></td>
</tr>
<tr>
<td style="background-color:#E4E4E4;height:20px;font-size:14px;font-weight:bold">Container No</td>
<td style="background-color:#E4E4E4;height:20px;font-size:14px;font-weight:bold"><?php echo $asn_details->container_number; ?></td>
</tr>
<tr>
<td></td>
</tr>
<tr>
<td style="background-color:#E4E4E4;height:20px;font-size:14px;font-weight:bold">Container Size</td>
<td style="background-color:#E4E4E4;height:20px;font-size:14px;font-weight:bold"><?php echo $asn_details->container_size;  ?></td>
</tr>
<tr>
<td></td>
</tr>
<tr>
<td style="background-color:#E4E4E4;height:20px;font-size:14px;font-weight:bold">Vehicle Number</td>
<td style="background-color:#E4E4E4;height:20px;font-size:14px;font-weight:bold"><?php echo $asn_details->vehicle_number; ?></td>
</tr>
<tr>
<td></td>
</tr>
<tr>
<td style="background-color:#E4E4E4;height:20px;font-size:14px;font-weight:bold">Contact Person</td>
<td style="background-color:#E4E4E4;height:20px;font-size:14px;font-weight:bold"><?php echo $asn_details->contact_person; ?></td>
</tr>
<tr>
<td></td>
</tr>
<tr>
<td style="background-color:#E4E4E4;height:20px;font-size:14px;font-weight:bold">Phone</td>
<td style="background-color:#E4E4E4;height:20px;font-size:14px;font-weight:bold"><?php echo $asn_details->phone; ?></td>
</tr>
</table>
<?php  } ?>