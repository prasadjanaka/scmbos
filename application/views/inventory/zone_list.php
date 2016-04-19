<?php require_once('loader.php'); ?>
<div class="content-wrapper">
    <section class="content">
        <section class="content-header">
             <h1><strong> <?php echo "Zone" ?></strong></h1>
        </section>
        <div class="box-body compact">
            <div class="col-xs-12" style="text-align:left" >
                <table align="center" style="width:300px"  id="zone"  class="table display table-hover">
                <thead >

                <tr>  <td width="20" style="text-align:center;font-size:15px;width:5px" ><strong>Delete</strong></td>
                <td width="100" style="text-align:left;font-size:15px;width:0px" ><strong>Zone Name</strong></td>

                </tr>
                </thead>
                <tbody>


                <?php foreach ($zone_list as $zone_lists) { ?>
                <tr> 
                <td style="width:20px;text-align: center"> <div class="checkbox">
                <label>
                <input onClick="delete_conform(this)" id="<?php echo $zone_lists->zone_id ?>" value="<?php echo $zone_lists->zone_id ?>"  type="checkbox">
                </label>
                </div>  </td>

                <td style="width: 100px" onclick="zone_edit(this.id)" align="left" id="row_<?php echo $zone_lists->zone_id ?>" zone_id="<?php echo $zone_lists->zone_id ?>" col="bay_list" field="zone" val="<?php echo $zone_lists->zone ?>"><?php echo $zone_lists->zone?></td>

                </tr>
                <?php } ?>

                </tbody>
                </table>

                </div>  



            
                </div>
                <div class="row">
                <div class="col-xs-12 table-responsive">
                <p class="lead"  data-toggle="collapse" data-target="#add_zone" style="cursor:pointer"><strong>Add New Zone</strong></p>
                <div id="add_zone" class="collapse">
                <div class="col-xs-12">
                <input  type="text" class="form-control" id="new_zone" name="new_zone"><br>
                <div style="" align="left"> <input onclick="new_zone()"  type="button" class="btn  btn-facebook" value="Change & Update"/> </div>
                </div>
                </div>
                </div>

                </div>
      
    </section>
</div>
<script type="text/javascript">




    $(document).ready(function() {
        $('#zone').dataTable({
          "scrollY": false,
            "scrollCollapse": false,
            "paging": false
        });
    });
///////////////////////////
function zone_edit(a){
var bay_list = '<input type="text" id="a" name="a"/>';

	
	
	$('td[id^="row_"]').dblclick(function( event){
		col = $(this);

		col_width = col.width()-10;
		var pre_val = $(this).attr('val');
		var pre_text = pre_val//$(this).html();
		var col_name = col.attr('col');
		
		if(col_name!=''){
			zone_id =  col.attr('zone_id');//zone_Id;
			field =  col.attr('field');//zone
                      data =  col.attr('val'); 
                    
			$(this).html(eval(col_name));	
			$("#a").focus();

			$("#a").val(pre_val);	
			$("#a").width(col_width);				
			$("#a").bind( "change", function() {
			var value = $("#a").val();
                        
			
			if($("#a").is('input')) {
				var text = $("#a").val(); 
                              col.text(text);
                         
				
			}
			
                        // ajax
                          var a;
                        if (window.XMLHttpRequest) {
                            a = new XMLHttpRequest();
                        } else if (window.ActiveXObject) {
                            a = ActiveXObject("Microsoft.XMLHTTP");
                        } else
                            (
                                    alert("Browser Doesnot Support AJAX")
                                    )
                        if (a != null) {

                        a.onreadystatechange = function() {
                            if (a.readyState === 0) {
                                //initialize
                            } else if (a.readyState === 1) {
                            } else if (a.readyState === 2) {
                            } else if (a.readyState === 3) {
                            } else if (a.readyState === 4) {
                                var res = a.responseText;

                                if (res == "OK") {
                                    alert("Updated");
                                    window.location = "<?php echo base_url(); ?>index.php/inventory/location_manager/zone_list"

                                }

                            }
                        }

                        a.open("GET", "<?php echo base_url() ?>index.php/inventory/location_manager/zone_edit?zone_id=" + zone_id + "&name="+text, true)

                        a.send(null);

            }
		
			});
//
			$("#a").bind( "focusout", function() {
				//alert(pre_val);
				col.text(pre_text);
				$("#a").remove();
                                pre_text="";
			});

			$("#a").bind( "dblclick", function() {
				return false;
			});	

		}
	} );


}
//////////////////////////////////


 
    function delete_conform(zone_id) { /* perform action here */

        var txt;
        var r = confirm("Delete Selected Zone...?");
        if (r == true) {

            var a;
            if (window.XMLHttpRequest) {
                a = new XMLHttpRequest();
            } else if (window.ActiveXObject) {
                a = ActiveXObject("Microsoft.XMLHTTP");
            } else
                (
                        alert("Browser Doesnot Support AJAX")
                        )
            if (a != null) {

                a.onreadystatechange = function() {
                    if (a.readyState === 0) {
                        //initialize
                    } else if (a.readyState === 1) {
                    } else if (a.readyState === 2) {
                    } else if (a.readyState === 3) {
                    } else if (a.readyState === 4) {
                        var res = a.responseText;

                        if (res == "OK") {
                            alert("Deleted");
                            window.location = "<?php echo base_url(); ?>index.php/inventory/location_manager/zone_list"

                                }else{
								alert("Sorry you are not allowed to access this area of the system");	
								}

                            }
                        }

                        a.open("GET", "<?php echo base_url() ?>index.php/inventory/location_manager/zone_delete?zone_id=" + zone_id.value + "", true)

                        a.send(null);

                    }

                } else {

                }


    }


    function new_zone() {
        var zone_isempty=document.getElementById("new_zone").value;
        if(zone_isempty==""){
	  document.getElementById("new_zone").style.border = " solid red"; 
	}else if(zone_isempty!=""){
        var a;
        if (window.XMLHttpRequest) {
            a = new XMLHttpRequest();
        } else if (window.ActiveXObject) {
            a = ActiveXObject("Microsoft.XMLHTTP");
        } else
            (
                    alert("Browser Doesnot Support AJAX")
                    )
        if (a != null) {

            a.onreadystatechange = function() {
                if (a.readyState === 0) {
                    //initialize
                } else if (a.readyState === 1) {
                } else if (a.readyState === 2) {
                } else if (a.readyState === 3) {
                } else if (a.readyState === 4) {
                    var res = a.responseText;

                   if (res == "OK") {
                  alert("Add");
                   window.location = "<?php echo base_url(); ?>index.php/inventory/location_manager/zone_list"

                            }

                        }
                    }

                    a.open("GET", "<?php echo base_url() ?>index.php/inventory/location_manager/new_zone?zone_name=" + document.getElementById('new_zone').value + "", true)

                    a.send(null);

                }
                }
            }


</script>