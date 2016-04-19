<?php require_once('loader.php');
$i=0;
?>
<div class="content-wrapper">
  <section class="content">
    <div class="box-body compact">
    <?php
		$container_sizes = ($this->mcommon->get_data_array("container_size_id","container_size","container_size"));
	?>
   			 <div align="right">
           	   <a style="padding-right:20px" href="<?php echo base_url()?>index.php/lp/Lp/lp_list" >Available LPs</a>
               <a style="padding-right:20px" href="<?php echo base_url()?>index.php/lp/Lp/lp_schedule">Scheduled LPs</a>
            <a href="<?php echo base_url()?>index.php/lp/Lp/lp_loading" >Loading Set</a>
            </div>
            <br />
      <table id="example" class="display table-striped dataTable" cellspacing="0" width="100%">
        <thead>
          <tr>
            <th colspan="8" align="left" >Pick And Loading <span style="width:auto">Schedule</span> </th>
            
             </th>
          </tr>
          <tr>
            <th colspan="4" align="left" >&nbsp;</th>
            <th colspan="2" align="left" ><div align="center">Pick</div></th>
            <th colspan="2" align="left" ><div align="center">Loading</div></th>
          </tr>
          <tr>
            <th >LP #</th>
            <th align="left">Destination</th>
            <th style="width:auto" align="left">Scheduled Date Time</th>          
            <th style="width:100px" align="left">Bay</th>
            <th align="left"><div align="center">Start</div></th>
            <th align="left"><div align="center">End</div></th>
            <th width="150" align="left"><div align="center">Start</div></th>
            <th width="150" align="left"><div align="center">End</div></th>
          </tr>
        </thead>
        <tfoot>
        </tfoot>
        <tbody>
          <?php 
		  foreach($schedule_lp_list->result() as $schedule_lp_lists){
			  	$lp_no = $schedule_lp_lists->lp_number;
				$url = base_url()."index.php/lp/lp/lp_detail_view?lp_number=".$lp_no;
		  ?>
          <tr >
            <td align="left" width="150" id="<?php echo $lp_no?>" name="<?php echo $lp_no?>" fld="lp"><a href="<?php echo $url?>"><?php echo $lp_no?></a></td>
            <td align="left"width="250"> <a href="<?php echo $url?>"><?php echo $schedule_lp_lists->tmp_destination?></a></td>
            
            <td style="width:299px" ><?php echo $schedule_lp_lists->datetime_scheduled ?></td>
           
		
             <td style="" align="left" id="row_<?php echo $lp_no?>" lp_number="<?php echo $lp_no?>" col="bay_list" field="bay_id" val="<?php echo $schedule_lp_lists->bay_id?>"><?php echo $schedule_lp_lists->location?></td>
             
             <td style="padding:5px" align="left"><input style="height:30px" class="form-control datemask" value="<?php if($schedule_lp_lists->pick_start!='0000-00-00 00:00:00'){echo $schedule_lp_lists->pick_start;} ?>" type="text" onblur="data_pack(this.id)" text="Pick Start" lp="<?php echo $lp_no?>" field="pick_start" id="<?php echo "PS_".$lp_no?>"/></td>
             
             <td style="padding:5px" align="left"><input style="height:30px" class="form-control datemask" value="<?php if($schedule_lp_lists->pick_end!='0000-00-00 00:00:00'){echo $schedule_lp_lists->pick_end;} ?>" onblur="data_pack(this.id)" type="text" text="Pick End" lp="<?php echo $lp_no?>" field="pick_end"  id="<?php echo "PE_".$lp_no?>"/></td>
             
             <td  style="padding:5px" align="left"><?php if($schedule_lp_lists->loading_start!='0000-00-00 00:00:00'){echo $schedule_lp_lists->loading_start;} ?></td>
             
             <td style="padding:5px" align="left"><?php if($schedule_lp_lists->loading_end!='0000-00-00 00:00:00'){echo $schedule_lp_lists->loading_end;} ?></td>
          </tr>
          <?php }?>
        </tbody>
      </table>
    </div>		
    
   
  </section>
</div>
<div style="display:none" id="txt">

</div>
<script type="text/javascript">
	var bay_list = '<select  name="a" id="a"><option value="0">&nbsp;</option><?php foreach($bay_list->result() as $bay){?><option value="<?php echo $bay->location_id?>"><?php echo $bay->location?></option><?php }?></select>';
	
	
	function display_action(data){
		document.getElementById(data+'AC').style='Display:block';
	}
	
	function hidden_action(data){
		document.getElementById(data+'AC').style='Display:none';
	}
	function data_pack(data){
		
		var lp_number=$('#'+data).attr('lp');
		var field=$('#'+data).attr('field');
		var value=$('#'+data).val();
		var text=$('#'+data).attr('text');
		
			if(value!=""){
				$.ajax({
					url: '<?php echo base_url() ?>index.php/lp/lp/pick_and_loading_update',
					method: 'POST',
					data: {lp_number:lp_number,field:field,value:value,text:text},
					success: function(data) {
						if(data!=""){
							alert(data);
							}
						
						//window.location.reload();
					},
					error: function(err, message, xx) {}
				});
			}
	}

	function date_time_shedual(lp_number){
		var shedual_date=document.getElementById(""+lp_number+"").value;
			if(shedual_date!=""){
				 $.ajax({
					url: '<?php echo base_url() ?>index.php/lp/lp/lp_scheduled_update',
					method: 'POST',
					data: {lp_number:lp_number,shedual_date:shedual_date},
					success: function(data) {
						
					},
					error: function(err, message, xx) {}
				});
			}
	}


	$('.datemask').inputmask("9999-99-99 99:99");
	
$(document).ready(function () {
   $('#example').dataTable( {
        "scrollY":        "300px",
        "scrollCollapse": true,
        "paging":         false
    } );


});

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
		
	
		 
			$.post( "<?php echo base_url()?>index.php/lp/lp/pick_and_loading_update",{lp_number: lp_number,field: field,value: value,text:text})
			.done(function( data ) {
				$('#loading-indicator').hide();
				col.attr('val',value);
					jd = $.parseJSON(data)
					if(jd.message!=""){
						col.text(pre_text);
						alert(jd.message);	
						 $('#loading-indicator').hide();
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

</script>