<?php require_once('loader.php');
$date_start_original = $date_start;
$today = date("Y-m-d");
?>
<div class="content-wrapper">
  <section class="content">
  <?php if($product_list->num_rows()>0){?>
    <div class="box-body compact">
      <table id="example" class="display dataTable" cellspacing="0" width="95%">
        <thead>
          <tr>
            <th align="left" bgcolor="#339933" >Product ID</th>
            <th align="left">Description</th>
			<?php while (strtotime($date_start) <= strtotime($date_end)) {?>
            <th align="center" <?php if(strtotime($date_start)==strtotime($today)) {?>style="text-align:center;font-size:9px;background-color:#099" <?php }else{?>style="text-align:center;font-size:9px" <?php }?>>
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
		 
		  foreach($product_list->result() as $product) {
			   
			  ?>	
          <tr>
            <td align="left" ><?php echo $product->product_id?></td>
            <td align="left"><?php echo $product->description?></td>
			<?php 
			$date_start = $date_start_original ;
			while (strtotime($date_start) <= strtotime($date_end)) {
			$id = 	"pid_".str_replace(".","_",$product->product_id)."d_".str_replace("-","_",$date_start);

				?>
				<td  align="center" style="border:solid thin  #000; cursor:alias;" status_id="0"  product_id="<?php echo $product->product_id?>" date="<?php echo $date_start?>" id="<?php echo $id?>" count_id = "0"></span></td>
			<?php 
			$date_start = date('Y-m-d', strtotime("+1 days",strtotime($date_start)));
			}?> 

           
          </tr>
		 <?php }?>	
          <tr>
            <td align="left" ></td>
            <td align="left"></td>
			<?php 
			$date_start = $date_start_original ;
			while (strtotime($date_start) <= strtotime($date_end)) {?>
			<td style="text-align:center;font-size:9px"><a onclick="export_excel(this)"  id="<?php echo $date_start;  ?>" name="" href="#">Result</a></td>
			<?php 
			$date_start = date('Y-m-d', strtotime("+1 days",strtotime($date_start)));
			}?> 
          </tr>         
        </tbody>
      </table>
    </div>
  <?php }?>
    <form action="" method="post">
    <table cellpadding="5" cellspacing="2">
      <tr>
        <td colspan="3"><strong>Enter Prodct IDs you want to plan or search</strong></td>
        <td align="right">
        <?php if($product_list->num_rows()>0){?>
        <table border="0" cellspacing="2" cellpadding="5">
          <tr>
            <?php foreach($count_status_list->result() as $result){?>
            <td>&nbsp;</td>
            <td bgcolor="<?php echo $result->color_code?>">&nbsp;<?php echo $result->count_status?>&nbsp;</td>
            <?php }?>
          </tr>
        </table>
        <?php }?>
        </td>
      </tr>
      <tr>
        <td colspan="4"><textarea name="product_ids" id="product_ids" cols="80" rows="5"><?php echo $product_id_list?></textarea></td>
      </tr>
      <tr>
        <td colspan="4">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4"><strong>Change date range</strong></td>
      </tr>
      <tr>
        <td><strong>From</strong></td>
        <td><strong>up to</strong></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
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
            <option value="30" <?php echo ($day_count==30?"selected":"")?>>30 Days</option>
        </select></td>
        <td><input type="submit" name="button" id="button" value="List" /></td>
        <td>&nbsp;</td>
      </tr>
    </table>
    </form>
  </section>
</div>

<script type="text/javascript">
	function export_excel(data){
		 window.location.pathname ="index.php/inventory/dashboard/pid_count_to_Excel?pid_count_date="+data.id+"";
	
	}
$(document).ready(function () {
	$.post( "<?php echo base_url()?>index.php/inventory/dashboard/get_pid_count_list", { date_start: '<?php echo $date_start_original?>',date_end: '<?php echo $date_end?>'})
	.done(function( data ) {
		get_pid_count_list = data ;
		get_pid_count_list = eval(get_pid_count_list);
		$('td[id^="pid_"]').show(function(){
			var id = $(this).attr('id');
			var date = $(this).attr('date');
			var product_id = $(this).attr('product_id');
	
			if(get_pid_count_list.indexOf(product_id+date)>-1){
				
				$.post( "<?php echo base_url()?>index.php/inventory/dashboard/get_pid_count_quick_info", { date: date,product_id: product_id})
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


	$('td[id^="pid_"]').dblclick(function(){
		var count_id = ($(this).attr('count_id'));
		var id = ($(this).attr('id'));
		var product_id = ($(this).attr('product_id'));
		var date = ($(this).attr('date'));	
		var status_id = ($(this).attr('status_id'));
		if(status_id < 2){	
		$('#loading-indicator').show();
		$.post( "<?php echo base_url()?>index.php/inventory/dashboard/pid_count_set_to_date", { count_id: count_id,product_id: product_id, date: date, status_id:status_id })
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
