<?php require_once('loader.php');
$i=0;
?>
<div class="content-wrapper">
  <section class="content">


    <div class="box-body compact">
    <div align="right">
    <a style="padding-right:20px" href="<?php echo base_url()?>index.php/lp/Lp/lp_list" >Available LPs</a>
    <a  style="padding-right:20px" href="<?php echo base_url()?>index.php/lp/Lp/pick_loading_lps" >Pick & Loading</a>
    <a href="<?php echo base_url()?>index.php/lp/Lp/lp_loading" >Loading Set</a>
    </div>
    <h4><b></b></h4>
    <br />
      <table id="example" class="display table-striped dataTable" cellspacing="0" width="100%">
        <thead>
         <tr>
            <th colspan="4" align="left" ></th>
           
              <th style="text-align:right"  align="right" >
              	 </th>
              </th>
          </tr>
           <tr>
            <th colspan="2" align="left" >Scheduled LPs</th>
            <th style="text-align:right"  align="right" >&nbsp;</th>
            <th style="text-align:right"  align="right" >&nbsp;</th>
            <th   align="right" style="text-align:right" >
            
          </tr>
          <tr>
           
            <th >LP #</th>
            <th style="width:250px" align="left">Destination</th>
            <th align="left">100% Available </th>
            <th align="left">Scheduled Date Time</th>
            <th align="left">Action</th>
          </tr>
        </thead>
        <tfoot>
        </tfoot>
        <tbody>
          <?php 
		  foreach($lps->result() as $lp){
			  	$lp_no = $lp->lp_number;
				$url = base_url()."index.php/lp/lp/lp_detail_view?lp_number=".$lp_no;
		  ?>
          <tr>
            <td style="padding-bottom:5px" align="left" width="150" id="<?php echo $lp_no?>" name="<?php echo $lp_no?>" fld="lp"><a href="<?php echo $url?>"><?php echo $lp_no?></a></td>
            <td style="padding-bottom:5px" align="left"width="250"><a href="<?php echo $url?>"><?php echo $lp->tmp_destination?></a></td>
            <td style="padding-bottom:5px" align="left"width="250">
              <input type="checkbox" name="hpa_chack_box" <?php if($lp->hundred_percent_available==1){?> checked="checked"<?php } ?> onchange="hundred_precent(this)" id="<?php echo "hpa_".$lp_no?>" />
              <input class="form-control datemask" value="<?php if($lp->hundred_percent_available_datetime!='0000-00-00 00:00:00'){echo $lp->hundred_percent_available_datetime;} ?>" lp_number="<?php echo $lp_no ?>" <?php if($lp->hundred_percent_available==1){}else{?> disabled="disabled" <?php  }?>type="text" name="hpa_datetime" id="<?php echo "hpa_".$lp_no."_datetime"?>" onblur="hundred_precent_save(this.id)" />
           </td>
            <td style="padding-bottom:5px" align="left"width="250">
           <input style="height:30px" class="form-control datemask" value="<?php if($lp->datetime_scheduled!='0000-00-00 00:00:00'){echo $lp->datetime_scheduled;} ?>" onblur="date_time_shedual(this.id)" type="text"  text="Datetime Scheduled" lp="<?php echo $lp_no?>" field="datetime_scheduled" id="<?php echo  "DS_".$lp_no?>"/>
            </td>
           
             <td align="left" style="width:250px;padding-bottom:5px"   id="">
               <?php  $url_request_container = base_url()."index.php/lp/lp/lp_request_container_info?lp_number=".$lp_no;?>
                    <a class="btn btn-primary" href="<?php echo $url_request_container ?>">Request Container</a>
             </td>    
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

$('.datemask').inputmask("9999-99-99 99:99");
	function date_time_shedual(data){
		
		var lp_number=$('#'+data).attr('lp');
		var field=$('#'+data).attr('field');
		var value=$('#'+data).val();
		var text=$('#'+data).attr('text');
		
			if(value!=""){
				$.ajax({
					url: '<?php echo base_url() ?>index.php/lp/lp/lp_scheduled_update',
					method: 'POST',
					data: {lp_number:lp_number,field:field,value:value,text:text},
					success: function(data) {
						
					},
					error: function(err, message, xx) {}
				});
			}
	}
	function display_action(data){
		
		document.getElementById(data+'AC').style='Display:block';
	}
	
	function hidden_action(data){
		document.getElementById(data+'AC').style='Display:none';
	}
	
	function hundred_precent(data){
		
		var condition = document.getElementById(data.id).checked;
			if(condition){
			
				$('#'+data.id+'_datetime').removeAttr('disabled');	
				
			}else{
				
				$('#'+data.id+'_datetime').attr('disabled','disabled');	
				var lp_number=$('#'+data.id+'_datetime').attr('lp_number');
				$('#'+data.id+'_datetime').val('');
				var hp_datetime="";
		
				$.ajax({
					url: '<?php echo base_url() ?>index.php/lp/lp/lp_hundred_precent',
					method: 'POST',
					data: {lp_number:lp_number,hp_datetime:hp_datetime,condition:false},
					success: function(data) {
				
					},
					error: function(err, message, xx) {}
				});	
			}	
	}
	
	function hundred_precent_save(data){
		var hp_datetime=$('#'+data).val();
		var lp_number=$('#'+data).attr('lp_number');

			if(hp_datetime!=""){
				
				$.ajax({
					url: '<?php echo base_url() ?>index.php/lp/lp/lp_hundred_precent',
					method: 'POST',
					data: {lp_number:lp_number,hp_datetime:hp_datetime,condition:true},
					success: function(data) {
			
					},
					error: function(err, message, xx) {}
				});	
			}else{
			
				$('#'+data).focus();
			}
	
	}
$(document).ready(function () {
   $('#example').dataTable( {
        "scrollY":        "500px",
        "scrollCollapse": true,
        "paging":         false
    } );

	


});
</script>