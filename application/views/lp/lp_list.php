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
    		  <a style="padding-right:20px" href="<?php echo base_url()?>index.php/lp/Lp/lp_schedule" >Scheduled LPs</a>
              <a style="padding-right:20px" href="<?php echo base_url()?>index.php/lp/Lp/pick_loading_lps" >Pick & Loading</a> 
              <a href="<?php echo base_url()?>index.php/lp/Lp/lp_loading" >Loading Set</a> </th>
    		 </div><br />
      <table id="example" class="display table-striped dataTable" cellspacing="0" width="100%">
        <thead>
           <tr>
            <th colspan="6" align="left" >
            
            
            </th>
            
          </tr>
         
           <tr>
            <th colspan="2" align="left" >Available Loading Proposals</th>
            <th style="text-align:right"  align="right" >&nbsp;</th>
            <th style="text-align:right"  align="right" >&nbsp;</th>
            <th colspan="2"  align="right" style="text-align:right" >
            
          </tr>
         
          <tr>
            <th >LP #</th>
            <th align="left">Destination</th>
            <th align="left"><span style="text-align:right">Delivery Block</span> Removed</th>
            <th align="left">Vessel Closing</th>
            <th align="left">Cargo Ready</th>          
            <th align="left"><div align="left">Schedule</div></th>
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
          <tr >
            <td align="left" width="150" id="<?php echo $lp_no?>" name="<?php echo $lp_no?>" fld="lp"><a href="<?php echo $url?>"><?php echo $lp_no?></a></td>
            <td align="left"width="250"> <?php echo $lp->tmp_destination?></td>
            <td style="padding:5px" align="left"><?php echo ($lp->delivery_block_removed_date==""?"":date("d-M-Y",strtotime($lp->delivery_block_removed_date)))?></td>
            <td style="padding:5px" align="left"><?php echo ($lp->vessel_closing_date==""?"":date("d-M-Y",strtotime($lp->vessel_closing_date)))?></td>
            <td style="padding:5px" align="left"><?php echo ($lp->cargo_ready_date==""?"":date("d-M-Y",strtotime($lp->cargo_ready_date)))?></td>
           
             <td style="padding:5px" align="left"><?php if($lp->delivery_block_removed_date!=""){ ?><input style="height:30px" class="form-control datemask" value="<?PHP  ?>" onblur="date_time_shedual(this.id)" type="text"  text="Datetime Scheduled" lp="<?php echo $lp_no?>" field="datetime_scheduled" id="<?php echo  "DS_".$lp_no?>"/><?php } ?></td>
            
          </tr>
          <?php }?>
        </tbody>
      </table>
    </div>		
    
    <input type="file" name="new_lp" id="new_lp" style="display:none" />
    <button type="button" class="btn btn-default btn-flat" id="new_lp_link">Upload new LPs</button>
  </section>
</div>
<div style="display:none" id="txt">

</div>
<script type="text/javascript">
	var bay_list = '<select  name="a" id="a"><option value="0">&nbsp;</option><?php foreach($bay_list->result() as $bay){?><option value="<?php echo $bay->location_id?>"><?php echo $bay->location?></option><?php }?></select>';
	
	function date_time_shedual(data){
		
		var lp_number=$('#'+data).attr('lp');
		var field=$('#'+data).attr('field');
		var value=$('#'+data).val();
		var text=$('#'+data).attr('text');
	   		
			
		
			
			if(value!=""){
				var splite=value.split(" ");
		
				var now = new Date();
				var month = now.getMonth() + 1;
				var day = now.getDate();
				var year = now.getFullYear();
				var currentdate = year + "-" + month + "-" + day;
			
			    var target = splite[0];
					var conditon=isPastDate(target);
					if(conditon){
						$.ajax({
							url: '<?php echo base_url() ?>index.php/lp/lp/lp_scheduled_update',
							method: 'POST',
							data: {lp_number:lp_number,field:field,value:value,text:text},
							success: function(data) {
								if(data!=""){
									alert(data);
								}
								
							},
							error: function(err, message, xx) {}
						});
					}else{
						alert("Please Enter Current Date or Future Date");	
					}
			}
	}

	function isPastDate(value) {
		var now = new Date;
		var target = new Date(value);
	
		if (target.getFullYear() > now.getFullYear()) {
			return true;
		} else if (target.getFullYear() === now.getFullYear())
			if (target.getMonth() > now.getMonth()) {
				return true;
			} else if (target.getMonth() === now.getMonth()) {
				if (target.getDate() > now.getDate() || target.getDate() === now.getDate()) {
					return true;
				}
			}
			return false;
	}


$('.datemask').inputmask("9999-99-99 99:99");

$(document).ready(function () {
   $('#example').dataTable( {
        "scrollY":        "300px",
        "scrollCollapse": true,
        "paging":         false,
		"order": [[ 2, "desc" ]]
    } );
	
	$("#new_lp_link").click(function() {
		$("#new_lp").click();
	});	
			
	$("#new_lp").change(function (){
		
		var myFormData = new FormData();
		myFormData.append('new_lp', this.files[0]);
		$.ajax({
		  url: '<?php echo base_url()?>index.php/lp/lp/lp_upload',
		  type: 'POST',
		  processData: false, // important
		  contentType: false, // important
		  enctype: 'multipart/form-data',
          encoding: 'multipart/form-data',
		  data: myFormData,
		  success: function(data){
			alert(data);
			window.location = '<?php echo base_url()?>index.php/lp/lp/lp_list';
		  },
		  error:function(err,message,xx) {
			  alert(xx);
		  }
		});	
			
			});

});



</script>