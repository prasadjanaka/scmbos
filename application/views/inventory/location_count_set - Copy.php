<?php require_once('loader.php');
$date_start_original = $date_start;
?>
<div class="content-wrapper">
  <section class="content">
    <div class="box-body compact">
      <table id="example" class="display dataTable" cellspacing="0" width="95%">
        <thead>
          <tr>
            <th align="left">Zone</th>
            <th align="left">Sub Zone</th>
			<?php while (strtotime($date_start) <= strtotime($date_end)) {?>
            <th align="center" style="text-align:center;font-size:9px">
				<?php echo date("Y",strtotime($date_start))?><br />
				<?php echo date("M",strtotime($date_start))?><br />
                <?php echo date("d",strtotime($date_start))?> (<?php echo date("D",strtotime($date_start))?>)
            </th>
			<?php 
			$date_start = date('Y-m-d', strtotime("+1 days",strtotime($date_start)));
			}?>        
          </tr>
        </thead>

        <tbody>
		  <?php 
		 
		  foreach($sub_zone_list->result() as $sub_zone) {
			   
			  ?>	
          <tr>
            <td align="left" ><?php echo $sub_zone->zone?></td>
            <td align="left"><?php echo $sub_zone->sub_zone?> <span style="text-align:center;font-size:10px">(<?php echo $sub_zone->location_count?>)</span></td>
			<?php 
			$date_start = $date_start_original ;
			while (strtotime($date_start) <= strtotime($date_end)) {
			$id = 	"sz_".$sub_zone->sub_zone_id."d_".str_replace("-","_",$date_start);

				?>
				<td  align="center" style="border:solid thin #000; cursor:alias;" status_id="0"  sub_zone_id="<?php echo $sub_zone->sub_zone_id?>" date="<?php echo $date_start?>" id="<?php echo $id?>" count_id = "0"></span></td>
			<?php 
			$date_start = date('Y-m-d', strtotime("+1 days",strtotime($date_start)));
			}?> 

           
          </tr>
		 <?php }?>	
        </tbody>
      </table>
    </div>
    <form action="" method="get">
    <table cellpadding="5" cellspacing="2">
      <tr>
        <td colspan="4"><strong>Change date range</strong></td>
      </tr>
      <tr>
        <td><strong>From</strong></td>
        <td><strong>up to</strong></td>
        <td>&nbsp;</td>
        <td><table border="0" cellspacing="2" cellpadding="5">
          <tr>
          <?php foreach($count_status_list->result() as $result){?>
            <td>&nbsp;</td>
            <td bgcolor="<?php echo $result->color_code?>">&nbsp;<?php echo $result->count_status?>&nbsp;</td>
          <?php }?>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><div class="input-group">
              <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input value="<?php echo $date_start_original?>" id="ds" name="ds" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="" type="text">
                    </div></td>
        <td><label for="textfield"></label>
          <label for="sc"></label>
          <select name="dc" id="dc">
            <option value="14" <?php echo ($day_count==14?"selected":"")?>>14 Days</option>
            <option value="21" <?php echo ($day_count==21?"selected":"")?>>21 Days</option>
            <option value="28" <?php echo ($day_count==28?"selected":"")?>>28 Days</option>
            <option value="35" <?php echo ($day_count==35?"selected":"")?>>35 Days</option>
        </select></td>
        <td><input type="submit" name="button" id="button" value="List" /></td>
        <td>&nbsp;</td>
      </tr>
    </table>
    </form>
  </section>
</div>

<script type="text/javascript">

$(document).ready(function () {
		$.post( "<?php echo base_url()?>index.php/inventory/dashboard/get_location_count_list", { date_start: '<?php echo $date_start_original?>',date_end: '<?php echo $date_end?>'})
		.done(function( data ) {
			
			get_location_count_list = data ;
			get_location_count_list = eval(get_location_count_list);
			$('td[id^="sz_"]').show(function(){
				var id = $(this).attr('id');
				var date = $(this).attr('date');
				var sub_zone_id = $(this).attr('sub_zone_id');

				if(get_location_count_list.indexOf(sub_zone_id+date)>-1){
					
					$.post( "<?php echo base_url()?>index.php/inventory/dashboard/get_location_count_quick_info", { date: date,sub_zone_id: sub_zone_id})
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
        "scrollY":        "350px",
        "scrollCollapse": true,
        "paging":         false
    } );


	
		
	$('td[id^="sz_"]').dblclick(function(){
		var count_id = ($(this).attr('count_id'));
		var id = ($(this).attr('id'));
		var sub_zone_id = ($(this).attr('sub_zone_id'));
		var date = ($(this).attr('date'));	
		var status_id = ($(this).attr('status_id'));
		if(status_id < 2){	
		$('#loading-indicator').show();
		$.post( "<?php echo base_url()?>index.php/inventory/dashboard/location_count_set_to_zone", { count_id: count_id,sub_zone_id: sub_zone_id, date: date, status_id:status_id })
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
