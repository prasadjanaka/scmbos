<?php require_once('loader.php');

 date_default_timezone_set("Asia/Colombo");
 $today = date("Y-m-d");
 $date_start_original = $date_start;

?>
<div class="content-wrapper">
  <section class="content">
  <?php //if($product_list->num_rows()>0){?>
    <div  class="box-body compact">
      <table id="example" class="display  dataTable" cellspacing="0" width="95%" >
        <thead align="center">
        
          <tr>
            <th style="width:100px;padding:10px" align="left" bgcolor="#339933">MHE Name</th>
           
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

        <tbody style="height:100px">
		  <?php 
		 
		  foreach($mhe_list as $mhes) {
			   
			  ?>	
          <tr>
            <td style="" align="left" ><a name="<?php echo $mhes->master_id ?>" id="trigger" href="#"><?php echo $mhes->category_name."-".$mhes->mhe_number ?></a></td>
           <?php 
		  
			$date_start = $date_start_original ;
			
			while (strtotime($date_start) <= strtotime($date_end)) {

				?>
              
		<td onclick="status_edit(this.id)"  date="<?php echo $date_start ?>" mhe_id="<?php echo $mhes->master_id ?>" style="border:1px solid #000;font-size:11px;font-weight:bold;text-align:center"   id="row_<?php  echo $mhes->master_id."_".$date_start ?>" sub_zone_id="<?php echo $mhes->master_id?>" col="status_list" field="zone" val=""></td>

			<?php 
		$date_start = date('Y-m-d', strtotime("+1 days",strtotime($date_start)));
		  }?>  
          </tr>
		 <?php }?>	 
        
        </tbody>
      </table>
   <br />
   <table style="width:95%" >
   <tr>
   <?php  foreach($mhe_status as $status){ ?>
   <td style="width:10px;background-color:<?php echo $status->color_code   ?>"></td>
   <td style="width:100px;padding-left:5px"><?php echo $status->status ?></td>
   
    
    <?php  } ?>
   </tr>
   </table>
   <br />
   <form method="post" action="">
   <table >
   <tr>
        <td colspan="4"><strong>Change date range</strong></td>
   </tr>
   <tr>
        <td><strong>From</strong></td>
        <td><strong>up to</strong></td>
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
            <option value="7" <?php echo ($day_count==7?"selected":"")?>>7 Days</option>
        
            <option value="14" <?php echo ($day_count==14?"selected":"")?>>14 Days</option>
           
        </select></td>
        <td><input class="btn btn-default " type="submit" name="button" id="button" value="List" /></td>
     <td>&nbsp;&nbsp;</td>
      <td>&nbsp;&nbsp;</td>
     <td>   
  <input class="btn btn-primary" type="button" value="Export to Excel Sheet" id="exporttoexcel"/> 
  
</td>  
 
   
    </tr>
   </table>
   </form>


  <div class= "box-body compact" id="pop-up" style="background-color:#FFF;  display: none;position: absolute; width: auto;  padding: 10px;    font-size: 90%;">
      <h3>MHE PROFILE</h3>
     <table style=" background-color:#FFF;" class="table">
     <tr>
     <td>MHE Number</td>
     <td id="mhe_number"></td>
     </tr>
     
     <tr>
     <td>MHE Category</td>
     <td id="mhe_category"></td>
     </tr>
     
    <tr>
     <td>MHE Fuel Type</td>
     <td id="mhe_fuel"> </td>
     </tr>
     
     <tr>
     <td>MHE Supplier</td>
     <td id="mhe_supplier"></td>
     </tr>
     
     <tr>
     <td>Supplier Contact</td>
     <td id="mhe_contact"></td>
     </tr>
     </table>
     
     
     
    </div>

    </div>
  
  
  </section>
</div>
 <script>	

 
$(document).ready(function () {

$.post( "<?php echo base_url()?>index.php/mhe/dashboard/set_schedule", 
{ date_start: $('#ds').val(),date_count: $("#dc option:selected").val()})
	.done(function( data ) {
	      var res = data.split("_");	 
	
      // for(var i=1;res.length>i;i++){
          // var res_data = res[i].split("/");

         	$('td[id^="row_"]').show(function(){
			var id = $(this).attr('id');
			var table_date = $(this).attr('date');
			var mhe_id = $(this).attr('mhe_id');
			
  			for(var i=1;res.length>i;i++){
             		   var res_data = res[i].split("/");
                        if(res_data[1]===table_date && res_data[2]===mhe_id){
                         $('#'+id).attr('bgcolor',res_data[0]);   
						document.getElementById(id).innerHTML=res_data[3];
						  
                        }
			}
		});
                
        //}
	
	});	





	 $('#example').hover(function(e) {
			
	    $('div#pop-up').hide();
	 
	 });
  $(function() {
  var moveLeft = 52;
  var moveDown = -120;

  $('a#trigger').hover(function(e) {
	
        $.ajax({
            url: '<?php echo base_url() ?>index.php/mhe/dashboard/mhe_profile',
            method: 'POST',
            data: {mhe_master_id: this.name},
            success: function(data) {
               if (data!="") {
				 
				 res=data.split("_");
				
				 for(var a=0;res.length>a;a++){
					//$('#mhe_number').val(res[0]); 
					document.getElementById('mhe_number').innerHTML=res[0];
					document.getElementById('mhe_category').innerHTML=res[1];
					document.getElementById('mhe_fuel').innerHTML=res[2];
					document.getElementById('mhe_supplier').innerHTML=res[3];
					document.getElementById('mhe_contact').innerHTML=res[4];
					 }
				$('div#pop-up').show();
				
               }


            },
            error: function(err, message, xx) {

            }
        });
   
   
   
   //
    
  
  },function() {
    $('div#pop-up').hide();
  });

  $('a#trigger').mousemove(function(e) {
    $("div#pop-up").css('top', e.pageY + moveDown).css('left', e.pageX + moveLeft);

});
	
});	
	
	
	
	$("#exporttoexcel").click(function () {
window.location ="<?php echo base_url() ?>index.php/mhe/Dashboard/download_Excel?date_start="+$('#ds').val()+"&date_count="+$("#dc option:selected").val()+"";

	 });   
   

});

	$('#example').dataTable( {
	"scrollY":        "auto",
	"scrollCollapse": true,
	"paging":         false
} );

 function change_selection(id){
	var name = $('#a').find(":selected").val();
	//alert(id+"/"+name);
	if(name>0){
 		$('#loading-indicator').show();	 

            $.ajax({
            url: '<?php echo base_url() ?>index.php/mhe/dashboard/mhe_schedule_change',
			
            method: 'POST',
            data: {mhe_data: id, ava: name},
            success: function(data) {
             // alert(data);
                if (data == 1) {
				
					$('#loading-indicator').show();	 
				$.post( "<?php echo base_url()?>index.php/mhe/dashboard/set_schedule", { date_start: $('#ds').val(),date_count: $("#dc option:selected").val()})
	.done(function( data ) {
		
          var res = data.split("_");	     
     
		   
         	$('td[id^="row_"]').show(function(){
			var id = $(this).attr('id');
			var date1 = $(this).attr('date');
			var mhe_id = $(this).attr('mhe_id');

 			 for(var i=1;res.length>i;i++){
          
           			var res_data = res[i].split("/");

                        if(res_data[1]===date1 && res_data[2]===mhe_id){
                         $('#'+id).attr('bgcolor',res_data[0]);   
                        	document.getElementById(id).innerHTML=res_data[3];
						
						 }
 			 }
						 			
		});
                
       // }
	
	});
	}else{
        window.location.pathname ="index.php/mhe/Dashboard/mhe_schedule_change";
    
        }
    
    },
            error: function(err, message, xx) {

			}
        });	
 
 }
 }

function status_edit(a) {
        var status_list = '<select style="width:100%;font-size:12px" onchange="change_selection(this.name)"  name="'+a+'" id="a"><option value=0></option><?php foreach($mhe_status as $mhe_sta ){ ?><option value="<?php echo $mhe_sta->status_id ?>"><?php  echo $mhe_sta->status ?></option><?php  } ?></select>';
	var res = a.split("_"); 
	var dateEntered= res[2];
	 var date = dateEntered.substring(8, 10);var month = dateEntered.substring(5, 7);var year = dateEntered.substring(0, 4);
    var dateToCompare = new Date(year, month - 1,date );
   
	var today = new Date();var dd = today.getDate();var mm = today.getMonth();var yyyy = today.getFullYear();
  	var currentDate = new Date(yyyy,mm,dd);

    if (dateToCompare  >= currentDate ) {
      $('td[id^="row_"]').dblclick(function(event) {
         
	
		    col = $(this);

            col_width = col.width() - 10;
            var pre_val = col.attr('col');
            var col_name = col.attr('col');

            if (col_name != '') {
             
                $(this).html(eval(col_name));
                $("#a").focus();

                $("#a").val(pre_val);
                $("#a").width(col_width);
                $("#a").bind("change", function() {
                    
                    if ($("#a").is('select')) {
                        var text = $("#a option:selected").text();
                        col.text(text);
						$("#a").remove();
                    }  });

                $("#a").bind("focusout", function() {
                 
                    $("#a").remove();
					
                  
                });

                $("#a").bind("dblclick", function() {
                    return false;
                });

            }
        });  
	   
	   
    }
    else {
        alert("Date Selected is Older than Current Date");
    }
		
	
       
    }
 </script> 
  
  