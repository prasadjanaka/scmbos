<?php require_once('loader.php');
$i=0;
?>
<div class="content-wrapper">
  <section class="content">


    <div class="box-body compact">
      <table id="example" class="display table-striped dataTable" cellspacing="0" width="100%">
        <thead>
          <tr>
            <th >LP #</th>
            <th align="left">Destination</th>
            <th align="left">Bay</th>
            <th align="left">Scanner</th>
            <th align="left">Supervisor</th>
            <th align="left">Tally</th>
            <th align="left">M.P. Team</th>
            <th align="left">Receipt #</th>
            <th align="left">Status</th>
          </tr>
        </thead>
        <tfoot>
        </tfoot>
        <tbody>
          <?php 
		  foreach($lps->result() as $lp){
			  	$lp_no = $lp->lp_number;
				$url = base_url()."index.php/lp/lp/lp_detail?lp_number=".$lp_no;
		  ?>
          <tr>
            <td align="left" width="150" id="<?php echo $lp_no?>" name="<?php echo $lp_no?>" fld="lp"><a href="<?php echo $url?>"><?php echo $lp_no?></a></td>
            <td align="left"width="250"> <a href="<?php echo $url?>"><?php echo $lp->tmp_destination?></a></td>
            <td align="left" id="row_<?php echo $lp_no?>" lp_number="<?php echo $lp_no?>" col="bay_list" field="bay_id" val="<?php echo $lp->bay_id?>"><?php echo $lp->location?></td>
            <td align="left" id="row_<?php echo $lp_no?>" lp_number="<?php echo $lp_no?>" col="scanner_list" field="user_id_load" val="<?php echo $lp->user_id_load?>"><?php echo $lp->epf_number?> - <?php echo $lp->username?></td>
            <td align="left" id="row_<?php echo $lp_no?>" lp_number="<?php echo $lp_no?>" col="supervisors" field="supervisor_id" val="<?php echo $lp->supervisor_id?>"><?php echo $lp->supervisor_epf_number?> - <?php echo $lp->supervisor_username?></td>            
            <td align="left" id="row_<?php echo $lp_no?>" lp_number="<?php echo $lp_no?>" col="tallys" field="tally_id" val="<?php echo $lp->tally_id?>"><?php echo $lp->tally_epf_number?> - <?php echo $lp->tally_username?></td>
			<td align="left" id="row_<?php echo $lp_no?>" lp_number="<?php echo $lp_no?>" col="manpowers" field="manpower_team_id" val="<?php echo $lp->manpower_team_id?>"><?php echo $lp->supplier?></td>
            <td align="left" id="row_<?php echo $lp_no?>" lp_number="<?php echo $lp_no?>" col="reciept_number" field="reciept_number" val="<?php echo $lp->reciept_number?>"><?php echo $lp->reciept_number?></td>
			<td align="left"><?php echo $lp->status?></td>            
          </tr>
          <?php }?>
        </tbody>
      </table>
    </div>
      <table border="0" cellspacing="0" cellpadding="0" style="border:none">
        <tr>
          <td>Add a New Loading Proposal</td>
          <td>&nbsp;</td>
          <td><input id="new_lp_number" name="new_lp_number" class="form-control" placeholder="Enter ..." type="text"></td>
          <td>&nbsp;</td>
          <td><input type="button" name="btn_add" id="btn_add" value="Add LP" class="btn btn-block btn-default" /> </td>
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
        "paging":         false
    } );

	var bay_list = '<select  name="a" id="a"><option value="0">&nbsp;</option><?php foreach($bay_list->result() as $bay){?><option value="<?php echo $bay->location_id?>"><?php echo $bay->location?></option><?php }?></select>';

	var scanner_list = '<select  name="a" id="a"><option value="0">&nbsp;</option><?php foreach($scanners->result() as $scanner){?><option value="<?php echo $scanner->user_id?>"><?php echo $scanner->epf_number?> - <?php echo $scanner->name?></option><?php }?></select>';

	var supervisors = '<select  name="a" id="a"><option value="0">&nbsp;</option><?php foreach($supervisors->result() as $supervisor){?><option value="<?php echo $supervisor->user_id?>"><?php echo $supervisor->epf_number?> - <?php echo $supervisor->name?></option><?php }?></select>';


	var tallys = '<select  name="a" id="a"><option value="0">&nbsp;</option><?php foreach($tallys->result() as $tally){?><option value="<?php echo $tally->user_id?>"><?php echo $tally->epf_number?> - <?php echo $tally->name?></option><?php }?></select>';

	var manpowers = '<select  name="a" id="a"><option value="0">&nbsp;</option><?php foreach($manpowers->result() as $manpower){?><option value="<?php echo $manpower->supplier_id?>"><?php echo $manpower->supplier?></option><?php }?></select>';
				   				   
	var reciept_number = '<input style="height:20px;" name="a" id="a" type="text" />';	
	
	$('td[id^="row_"]').dblclick(function( event){
		col = $(this);

		col_width = col.width()-10;
		var pre_val = $(this).attr('val');
		var pre_text = $(this).html();
		var col_name = col.attr('col');
		
		if(col_name!=''){
			lp_number =  col.attr('lp_number');
			field =  col.attr('field');
			$(this).html(eval(col_name));	
			$("#a").focus();

			$("#a").val(pre_val);	
			$("#a").width(col_width);				
			$("#a").bind( "change", function() {
			var value = $("#a").val();
			if($("#a").is('select')) {
				var text = $("#a option:selected").text();
				col.text(text);
			}
			if($("#a").is('input')) {
				var text = $("#a").val();
				col.text(text);
			}
			
			$.post( "<?php echo base_url()?>index.php/lp/lp/update_lp",{lp_number: lp_number,field: field,value: value,text:text})
			.done(function( data ) {
				col.attr('val',value);
					jd = $.parseJSON(data)
					if(jd.message!=""){
						col.text(pre_text);
						alert(jd.message);	
					}	
			})
			.fail(function(XMLHttpRequest, textStatus, errorThrown)  {
				col.text(pre_text);
				alert('Could not save data');
			});
				col.html($("#a").val());
				$("#new_lp_number").focus();		
			});

			$("#a").bind( "focusout", function() {
				//alert(pre_val);
				col.text(pre_text);
				$("#a").remove();
			});

			$("#a").bind( "dblclick", function() {
				return false;
			});	

		}
	} );

	$("#btn_add").click(function() {
		$(this).attr('class','btn btn-block btn-default disabled');
		$(this).val('Please wait... Saving Changes...');
		var lp_number = $("#new_lp_number").val();
			if(lp_number==''){
				$("#btn_add").attr('class','btn btn-block btn-default');
				$("#btn_add").val('Add LP');
				return false;	
			}
		
		
		$.post( "<?php echo base_url()?>index.php/lp/lp/add_lp", { lp_number: lp_number})
		.done(function( data ) {
			jd = $.parseJSON(data);
			if(jd.message!="") {
				alert(jd.message);
				$("#btn_add").attr('class','btn btn-block btn-default');
				$("#btn_add").val('Add LP');
			}else{
				window.location = '<?php echo base_url()?>index.php/lp/lp/lp_list';	
			}
		});	


		
	});	
});
</script>