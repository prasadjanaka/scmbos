<?php require_once('loader.php');?>

<div class="content-wrapper">
  <section class="content">
  <?php if($location_list->num_rows()>0){?>
    <div class="box-body compact">
      <table width="95%" border="0" cellspacing="0" class="display dataTable" id="example">
        <thead>
          <tr>
            <th colspan="2" align="left" style="width:150px">Locations to count</th>
            <th colspan="<?php echo $count_end?>" style="text-align:center">Count Number</th>
          </tr>
          <tr>
            <th align="left" style="width:150px">&nbsp;</th>
            <th align="left" style="width:150px">&nbsp;</th>
            <th colspan="<?php echo $count_end?>" align="left"><input type="checkbox" name="select_all" id="select_all" />&nbsp;Select All</th>
          </tr>
          <tr>
            <th align="left" style="width:150px">Sub Zone</th>            
            <th align="left" style="width:150px">Location</th>            
			<?php for($loop=$count_start ; $loop<=$count_end ;$loop++ ) {?>
            <th style="border:solid thin  #000; cursor:alias;width:70px;text-align:center"><label for="select_all"></label>              <?php echo $loop?></th>
			<?php }?>        
          </tr>
        </thead>

        <tbody>
		  <?php 
		 
		  foreach($location_list->result() as $location) {
			   
			  ?>	
          <tr>
            <td align="left" ><?php echo $location->sub_zone?></td>
            <td align="left" ><?php echo $location->location?></td>                        
			<?php for($loop=$count_start ; $loop<=$count_end ;$loop++ ) {?>
            
            <td align="center" style="border:solid thin  #000; cursor:alias;"></td>
			<?php }?>     

           
          </tr>
		 <?php }?>	
          <tr>
            <td align="left"></td>
            <td align="left"></td>                        
			<?php for($loop=$count_start ; $loop<=$count_end ;$loop++ ) {?>
            <td></td>
			<?php }?> 
          </tr>         
        </tbody>
      </table>
    </div>
  <?php }?>
    <form action="" method="post">
    <table cellpadding="5" cellspacing="2">
      <tr>
        <td><strong>Select Date,Zone and Sub Zone Group you want to count</strong></td>
        <td align="right">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2"><strong>Date</strong></td>
      </tr>
      <tr>
        <td colspan="2"><div class="input-group">
              <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input value="<?php echo date("Y-m-d")?>" id="ds" name="ds" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="" type="text">
                    </div></td>
      </tr>
      <tr>
        <td colspan="2"><input type="submit" name="button" id="button" value="List" /></td>
      </tr>
    </table>
    </form>
  </section>
</div>

<script type="text/javascript">

$(document).ready(function () {
	$.post( "<?php echo base_url()?>index.php/inventory/dashboard/get_pid_count_list")
	.done(function( data ) {
		get_pid_count_list = data ;
		get_pid_count_list = eval(get_pid_count_list);
		$('td[id^="pid_"]').show(function(){
			var id = $(this).attr('id');
			var date = $(this).attr('date');
			var product_id = $(this).attr('product_id');
	
			if(get_pid_count_list.indexOf(product_id+date)>-1){
				
				$.post( "<?php echo base_url()?>index.php/inventory/dashboard/get_pid_count_quick_info")
				.done(function( data ) {
					jd = $.parseJSON(data)
						
					$('#'+id).attr('bgcolor',jd.color_code);
					$('#'+id).attr('status_id',jd.status_id);
					$('#'+id).attr('count_id',jd.count_id);		
					$('#'+id).attr('title',jd.cell_title);	
				});
			}
			
		});
	});		

$("#ds").inputmask("yyyy-mm-dd", {"placeholder": "yyyy-mm-dd"});

$('#example').dataTable( {
	"scrollY":        "400px",
	"scrollCollapse": true,
	"paging":         false
} );


	$('td[id^="pid_"]').dblclick(function(){
		var count_id = ($(this).attr('count_id'));
		var id = ($(this).attr('id'));
		var product_id = ($(this).attr('product_id'));
		var date = ($(this).attr('date'));	
		var status_id = ($(this).attr('status_id'));
		if(status_id < 2){	
		$('#loading-indicator').show();
		$.post( "<?php echo base_url()?>index.php/inventory/dashboard/pid_count_set_to_date")
		.done(function( data ) {
			jd = $.parseJSON(data)
			if(jd.message==""){
				status_id = jd.status_id;
				count_id = jd.count_id;
				color_code = jd.color_code; 
				scanner_name = jd.scanner_name; 
				$('#'+id).attr('bgcolor',color_code);
				$('#'+id).attr('status_id',status_id);
				$('#'+id).attr('count_id',count_id);
			}else{
				alert(jd.message);	
			}
			$('#loading-indicator').hide();
			
		});
		}
	 });



});
</script>
