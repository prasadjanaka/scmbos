<?php require_once('loader.php');

 date_default_timezone_set("Asia/Colombo");


 $today=date("Y-m-d");

 $date_start_original = $date_start;

?>
<div  class="content-wrapper">
  <section class="content">

    <div   class="box-body compact">
    <h4>MHE Runing Chart</h4>
      <table id="example" class="display  dataTable" cellspacing="0" width="95%" >
        <thead align="center">
        
          <tr>
            <th style="width:200px;" align="left" bgcolor="#339933">MHE Name</th>
           
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

        <tbody style="">
		  <?php 
		 
		  foreach($mhe_list as $mhes) {
			   
			  ?>	
          <tr>
            <td style="" align="left" ><a name="<?php echo $mhes->master_id ?>" id="trigger" href="#"><?php echo $mhes->category_name."-".$mhes->mhe_number ?></a></td>
           <?php 
		  
			$date_start = $date_start_original ;
			
			while (strtotime($date_start) <= strtotime($date_end)) {

				?>
              
		<td   class="trigger" name=""  id="row_<?php  echo $mhes->master_id."_".$date_start ?>" onclick="status_edit(this.id)"  date="<?php echo $date_start ?>" mhe_id="<?php echo $mhes->master_id ?>" style="border:1px solid #000;font-size:10px;font-weight:bold;text-align:left" current_date="<?php   echo $today ?>"   sub_zone_id="<?php echo $mhes->master_id?>" col="status_list" field="zone" val=""></td>

			<?php 
		$date_start = date('Y-m-d', strtotime("+1 days",strtotime($date_start)));
		  }?>  
          </tr>
		 <?php }?>	 
        
        </tbody>
      </table>

   <form method="GET" action="">
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
                      <input  value="<?php echo $date_start_original?>" id="ds" name="ds" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="" type="text">
                    </div></td>
        <td><label for="textfield"></label>
          <label for="sc"></label>
          <select name="dc" id="dc">
            <option value="7" <?php echo ($day_count==7?"selected":"")?>>7 Days</option>
           
        </select></td>
        <td><input class="btn btn-default " type="submit" name="button" id="button" value="List" /></td>
     <td>&nbsp;&nbsp;</td>
      <td><input class="btn btn-primary" type="button" value="Export to Excel Sheet" id="exporttoexcel_runing_chart"/></td>
     
 
   
    </tr >
   </table>
   </form>


  <div class= "box-body compact" id="pop-up" style="background-color:#FFF;display:none;position:absolute;width:auto;padding:10px;font-size:90%;">
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

<!--     test  -->
<div id="divId" style="display:none;width:auto ;height:auto;border-radius:5px;background-color:#FFF;padding:15px">

<input onkeypress="return isNumberKey(event)" style="float:left;width:100px;" placeholder="Start Meter" class="form-control" type="text" name="s_meter" id="s_meter"/>
<label style="float:left;padding-left:20px;padding-right:20px">to</label>
<input onkeypress="return isNumberKey(event)" style="float:left;width:100px" placeholder="End Meter"  class="form-control"  type="text" name="e_meter" id="e_meter" />
<label style="float:left;padding-left:20px;padding-right:20px"></label>
<input onkeypress="return isNumberKey(event)" style="float:left;width:100px" placeholder="EPF Number"  class="form-control"  type="text" name="epf_number" id="epf_number"/>
<input type="text" hidden="" id="mhe_id_text"/>
<input type="text" hidden="" id="select_date"/>
<label style="float:left;padding-left:20px;padding-right:10px"></label>
<input style="float:left;width:100px" type="button" class="form-control btn btn-default" value="Sumbit" id="meter_sumbit"/>
</div>
<!-- end test -->
 <script>	
function status_delete(id){
	$.ajax({
            url: '<?php echo base_url() ?>index.php/mhe/dashboard/delete_status_data',
            method: 'POST',
            data: {status_id:id},
            success: function(data) {
                if (data != "") {
                  if(data="OK"){
					 window.location="<?php echo base_url()?>index.php/mhe/Dashboard/mhe_runing_chart?ds="+$('#ds').val();
				  }
				   
				 
                }
            },
            error: function(err, message, xx) {

            }
		});	
}
 
$(document).ready(function () {


	$.post( "<?php echo base_url()?>index.php/mhe/dashboard/set_schedule_runing_chart", 
	{ date_start: $('#ds').val(),date_count: $("#dc option:selected").val()})
	.done(function( data ) {
	
	      var res = data.split("_");	 

         		$('td[id^="row_"]').show(function(){
				var id = $(this).attr('id');
				var date1 = $(this).attr('date');
				var mhe_id = $(this).attr('mhe_id');
					for(var i=1;res.length>i;i++){
						var res_data = res[i].split("/");
                        if(mhe_id==res_data[0] && date1==res_data[1]){
							var record_start=res_data[2];
							var record_end=res_data[3];
							var epf=res_data[4];
					
var a='<table><tr><td style="font-size:14px">'+record_start+'</td><td style="padding-left:4px;padding-right:4px;font-size:14px">to</td><td style="font-size:14px">'+record_end+'</td><td style="padding-left:4px;padding-right:4px;font-size:14px">=</td><td style="color:red;font-size:16px">'+(record_end-record_start).toFixed(1)+'</td></tr></table><div style="font-size:14px">EPF - '+epf+"&nbsp;&nbsp;"+'<a id="'+res_data[5]+'" onclick="status_delete(this.id)" style="cursor:pointer">X</a></i></div>';
						 	$('#'+id).html(a);
							
                        }	
					}
				});
                
			
	  //  }
	
});


	 $("#divId").hide();	
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
   
   
  		},function() {
   			 $('div#pop-up').hide();
  		});

 		$('a#trigger').mousemove(function(e) {
    	$("div#pop-up").css('top', e.pageY + moveDown).css('left', e.pageX + moveLeft);

		});
	
	});	
	
	
	
});

	$('#example').dataTable( {
	"scrollY":        '330px',
	"scrollCollapse": false,
	"paging":         false
	});

	$("td").dblclick(function(event) {

   		$("#divId").show();
	 		var mhe_id=$(this).attr('mhe_id')
			var select_date=$(this).attr('date')
			var oraginal_date=$(this).attr('current_date')
		
		//	if(select_date==oraginal_date){
				document.getElementById('mhe_id_text').value=mhe_id;
				document.getElementById('select_date').value=select_date;
				document.getElementById('s_meter').value="";
				document.getElementById('e_meter').value="";
				$("#divId").css( {position:"absolute", top:event.pageY, left: event.pageX}
				);
			//}else{
				//alert("Not Enable");
				//$("#divId").hide();
			//}
	});

	$( "td").click( function(event) {
		$("#divId").hide();	
	});

	$('#meter_sumbit').click(function(e) {
		
    	var s_meter=$('#s_meter').val(); 
	 	var e_meter=$('#e_meter').val(); 
	 	var mhe_id=$('#mhe_id_text').val(); 
		//var epf_number=$('#epf_number').val(); 
		
	    if(s_meter==""){
			$('#s_meter').focus();
		}else if(e_meter==""){
			$('#e_meter').focus();
		}else{
			if(parseInt(s_meter)< parseInt(e_meter) || parseInt(s_meter)==parseInt(e_meter)){
				$.post( "<?php echo base_url()?>index.php/mhe/dashboard/runing_chart_save", 
				{ master_id:mhe_id,date:$('#select_date').val(),r_start:s_meter,r_end:e_meter,epf_number:$('#epf_number').val()})
				.done(function( data ) {
					if(data==1){
						//alert(data);
						$("#divId").hide();
				
				 window.location="<?php echo base_url()?>index.php/mhe/Dashboard/mhe_runing_chart?ds="+$('#select_date').val();
					//location.reload();
					
					}else{
						//alert(data);
					}
				
				});	
			
			}else{
				$("#divId").hide();
				alert("Please Check Records");
			}
			
		}
    });
	
	//function isNumberKey(evt){
//    var charCode = (evt.which) ? evt.which : event.keyCode
//    if (charCode > 31)
//        return false;
//    return true;
//	}
	
	$("#exporttoexcel_runing_chart").click(function () {
	 window.location="<?php echo base_url() ?>index.php/mhe/Dashboard/download_Excel_runing_chart?date="+$('#ds').val()+"";	
		//window.location.pathname ="index.php/mhe/Dashboard/download_Excel_runing_chart?date="+$('#ds').val()+"";

	 }); 
	
 </script> 
  
  