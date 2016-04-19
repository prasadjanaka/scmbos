<?php require_once('loader.php');?>
<div class="content-wrapper">
  <section class="content">
    <div class="box-body compact">
     
   	  <h3>Request Container</h3>
     
     
     	<table class="table">
        
        	<tr>
            	<td style="width:50px">LP:</td> 
                <td style="width:350px"><?php echo $lp_number  ?> <input type="text" value="<?php echo $lp_number?>" id="lp" hidden=""/></td> 
            </tr>
           <tr>
           		<td style="width:50px">Schedualed Date Time:</td>
                <?php  foreach($lp_details->result() as $lp_detailss){ ?>
                <td style="width:350px"><?php echo $lp_detailss->datetime_scheduled ?></td>
                <?php  } ?>
           </tr>
            <tr>
                <td style="width:50px">Forwarder:</td>
                 <td style="width:350px"><select style="width:350px" id="forward" class="form-control">
                	<?php  foreach($forwarded->result() as $forwardeds){ ?>
                    
                    	<option value="<?php echo $forwardeds->supplier_id ?>"><?php echo $forwardeds->supplier ?></option>
                    <?php  } ?>
                </select></td>
             </tr>
             <tr>   
                <td style="width:50px">Expected Date Time:</td>
                <td style="width:350px"><input style="width:350px" id="ex_datetime"  class="form-control datemask" value="" type="text" /></td>
             </tr>
             <tr>  
                <td style="width:50px">Container Size:</td>
                <td style="width:350px"><select style="width:350px" id="container" class="form-control">
                	<?php  foreach($container_size->result() as $container_sizes){ ?>
                    
                    	<option value="<?php echo $container_sizes->container_size_id ?>"><?php echo $container_sizes->container_size ?></option>
                    <?php  } ?>
                </select></td>
              </tr>
              <tr> 
                <td style="width:50px">Message:</td><td></td>
              </tr>
        	  <tr>
        	    <td colspan="2" style="width:350px"><textarea id="msg" style="resize:none"  name="textarea" cols="88" rows="4"></textarea></td>
      	    </tr>
        	  <tr> 
              	<td style="width:50px">&nbsp;</td>
                <td  style="width:350px;padding-left:205px" align="left" colspan="2">
                  <input class="btn btn-primary" style="width:150px" align="right" type="submit" name="Send" id="Send" value="Submit">
               </td>
              </tr>
        </table>
     </div>
   </section>
 </div>
 
 <script>
$('.datemask').inputmask("9999-99-99 99:99");
 
 
 $('#Send').click(function(e) {
    
	var lp_number=$('#lp').val();
	var container_id=$('#container').val();
	var forward_id=$('#forward').val();
	var forward_name=$("#forward option:selected").html();
	var ex_datetime=$('#ex_datetime').val();
	var msg=$('#msg').val();
		if(ex_datetime!=""){
			 $.ajax({
				url: '<?php echo base_url() ?>index.php/lp/lp/request_container',
				method: 'POST',
				data: {lp_number:lp_number,container_id:container_id,forward_id:forward_id,forward_name:forward_name,ex_datetime:ex_datetime,msg:msg},
				success: function(data) {
					alert("Successful Send Email to Forwarder ");	
					window.location='<?php echo base_url() ?>index.php/lp/Lp/lp_schedule';
				},
				error: function(err, message, xx) {}
			 });
		}else{
			$('#ex_datetime').focus();	
		}
  });
 
 
 </script>