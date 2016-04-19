<div class="content-wrapper">
  <section class="content ">
    <div class="box-body compact"> 
     <table align="right"><tr>
  <td style="font-weight:bold">Shortcuts  &rArr; &nbsp;&nbsp;&nbsp;</td> 
<td style="padding-right:20px"><a href="<?php echo base_url()?>index.php/inventory/dashboard/target_count?ds=<?php if($ds!=""){echo $ds; }?>" >Location Count</a></td>
  <td><a href="<?php echo base_url()?>index.php/inventory/dashboard/target_set_scanning_cleark?date=<?php if($ds!=""){echo $ds; }else{ echo $today; }?>" >Set Count order</a></td>
 <td style="padding-left:20px"><a href="<?php echo base_url()?>index.php/inventory/location_manager/confirmed_result?ds=<?php echo $ds  ?>" >Confirmed Results</a></td>
 <td style="padding-left:20px"><a href="<?php echo base_url()?>index.php/inventory/location_manager/Result?ds=<?php echo $ds  ?>" >Counting Results</a></td>
  <td style="padding-left:20px"><a href="<?php echo base_url()?>index.php/inventory/Dashboard/ex_summary?ds=<?php echo $ds  ?>" >Executive Summary</a></td> 
 </tr></table>
    <h3>Inventory Count Reference List</h3>
    <table class="example" id="example">
    	<thead>
        	<tr>
           	    <th style="width:150px">Reference</th>
                <th style="width:300px">Scanner</th>
               
              
                <th align="center" style="width:100px;text-align:center">Count #</th>
                 <th style="width:150px">Status</th>
                  
            </tr>
        </thead>
       
        <tbody>
        <?php  foreach($ref_list->result() as $rows ){ ?>
       	<tr>
        	<td ><?php  if($rows->is_released == 0){?><a href="#" id="<?php echo  $rows->reference_number ?>" onclick="ref_details(this.id)" ><?php echo  $rows->reference_number ?></a><?php }else{ ?><a onclick="modify_ref(this)" href="#"><?php echo  $rows->reference_number ?></a> <?php  }?></td>
            <td><?php echo  $rows->epf_number."-".$rows->name?></td>
           
            <td style="text-align:center"><?php echo  $rows->count_number ?></td>
              <td><?php if($rows->is_released==1){echo "Released";}else{ echo "Open Record"; } ?></td>
              
        </tr>
        <?php }?>
        </tbody>	
    
    </table>
    
	 <table>
     <br>
      <form method="GET">
      	<tr>
        	<td> <label>Date</label></td>
            <td style="padding-left:10px"><input value="<?php echo $ds ?>" type="text" id="ds" name="ds" class="form-control datemask"/></td>
            <td style="padding-left:10px"><input  type="submit" value="List" style="width:100px" class="btn  btn-facebook"/></td> 
              <td style="padding-left:25px"> <input type="button" value="New Count Release" id="new_ref"  style="width:150px" class="btn  btn-facebook"/></td>
            <td style="padding-left:25px"> <input type="button" value="Export to Excel" id="write_to_excel"  class="btn  btn-facebook"/></td>
        </tr>
      </form>
      </table>    
    
    
     
    
    </div>
    
  </section>
</div>
<style>

.example tr:hover {
          background-color: #ffff99;
		  font-size:14px;
		
        }
		
.example tr span:hover	{
	 cursor:pointer;
}
</style>
<script>

function modify_ref(elm){
	
	var ref_val = $(elm).closest("tr").find("td:eq(0)").text();
	//var scanner_name = $(elm).closest("tr").find("td:eq(1)").text();
	//var date = $('#ds').val();

 window.location = '<?php echo base_url() ?>index.php/inventory/Count_ref_manager/modify_ref?ref_val='+ref_val+'';
	
}

$('#new_ref').click(function(e) {
    window.location = '<?php echo base_url() ?>index.php/inventory/Count_ref_manager/index?ds='+$('#ds').val()+'&reference=';
});

function ref_details(ref_number){
 window.location = '<?php echo base_url() ?>index.php/inventory/Count_ref_manager/index?ds='+$('#ds').val()+'&reference='+ref_number+'';
	
}

function remove_me(ref_number){

	alert(ref_number);
}

$('.datemask').inputmask("9999-99-99");	
	
$('#example').dataTable( {
	"scrollY":        "350px",
	"scrollCollapse": true,
	"paging":         false
});

</script>