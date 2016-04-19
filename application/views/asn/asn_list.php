<?php require_once('loader.php');
$i=0;
?>
<div class="content-wrapper">
  <section class="content">
<section class="content-header">
      <h1><?php echo $count_title?>&nbsp;<?php echo $asn_type?></h1>
    </section>

    <div class="box-body compact">
      <table id="example" class="display table-striped dataTable" cellspacing="0" width="100%">
        <thead>
          <tr>
            <th align="left">ASN #</th>
            <th align="left">Date Created</th>
            <th align="left">STO Numbers</th>
            <th align="left">STO Count</th>
            <th align="left">Scanner</th>
            <th align="left">Status</th>
          </tr>
        </thead>
        <tfoot>
        </tfoot>
        <tbody>
          <?php 
		  foreach($asns->result() as $asn){
			  	$asn_number = $asn->asn_number;
				$url = base_url()."index.php/asn/dashboard/asn?asn_number=".$asn_number;
		  ?>
          <tr>
            <td align="left"><a href="<?php echo $url?>"><?php echo $asn_number?></a></td>
            <td align="left"><?php echo $asn->datetime_created?></td>
            <td align="left"><?php echo $asn->sto_numbers?></td>
            <td align="left"><?php echo $asn->sto_count?></td>
            <td align="left">&nbsp;</td>
            <td align="left"><?php echo $asn->status?><span style="display:none"><?php echo $asn->name?></span></td>            
          </tr>
          <?php }?>
        </tbody>
      </table>
    </div>
      <table border="0" cellspacing="0" cellpadding="0" style="border:none">
        <tr>
          <td>Add a new </td>
          <td>&nbsp;&nbsp;</td>
          <td><select name="asn_type_id" id="asn_type_id">
            <option value="1">General ASN</option>
            <option value="2">Shuttle ASN</option>
          </select></td>
          <td>&nbsp;</td>
          <td><input type="button" name="btn_add" id="btn_add" value="Add" class="btn btn-block btn-default" /> </td>
        </tr>
      </table>       
  </section>
</div>
<div style="display:none" id="txt">

</div>
<script type="text/javascript">

$(document).ready(function () {
   $('#example').dataTable( {
        "scrollY":        "300px",
        "scrollCollapse": true,
        "paging":         false,        
		"order": [[ 0, "desc" ]]
    } );

	$("#btn_add").click(function() {
		if(confirm("Are you sure you need to add an ASN?")){		
			$(this).attr('class','btn btn-block btn-default disabled');
			$(this).val('Please wait... Adding a new ASN...');
			var asn_type_id = $("#asn_type_id").val();

			$.post( "<?php echo base_url()?>index.php/asn/dashboard/add_asn", { asn_type_id: asn_type_id})
			.done(function( data ) {
				jd = $.parseJSON(data);
				if(jd.message!="") {
					alert(jd.message);
					$("#btn_add").attr('class','btn btn-block btn-default');
					$("#btn_add").val('Add');
				}else{
					window.location = '<?php echo base_url()?>index.php/asn/dashboard/asn_list?type='+asn_type_id+'&top=1000';	
				}
			});	
		}

	});
});
</script>