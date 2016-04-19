<?php require_once('loader.php'); ?>
<div class="content-wrapper">
    <section class="content">
        <section class="content-header">
             <h1><strong> <?php echo "Location" ?></strong></h1>
        </section>
        <div class="box-body compact">
            <div class="col-xs-12" style="text-align:left" >

        <table style="width:auto">

         <tr>
        <td style="width:100px;text-align: right;padding-right: 20px">
        <strong>Select Zone</strong>   
        </td>
        <td style="padding-left: 5px">
        <select style="width:400px" id="zone_select" name="zone_select" class="form-control" onchange="select_zone(this.value)">
       <option></option>

        <?php
        foreach ($zone_list as $zone_lists) {
        $selected = ($zone_lists->zone_id == $select_zone ? " selected " : "");
         
        ?>
         <option <?php echo $selected ?> value="<?php echo $zone_lists->zone_id; ?>"><?php echo $zone_lists->zone; ?></option>
        <?php } ?>
        </select>  
        </td>
        </tr>
        <tr>
        <td>&nbsp;</td>
         </tr>
       <tr>
        <td style="width:200px;text-align: right;padding-right: 20px">
        <strong>Select Sub Zone </strong>   
        </td>

         <td style="padding-left: 5px">
        <select style="width:400px" id="sub_zone_group" name="sub_zone_group" class="form-control" onchange="sub_zone_group(this.value)">
        <option></option>

         <?php
        foreach ($sub_zone as $sub_zones) {
        $selected = ($sub_zones->sub_zone_id == $sub_zone_id ? " selected " : "");
        ?>
        <option <?php echo $selected ?> value="<?php echo $sub_zones->sub_zone_id; ?>"><?php echo $sub_zones->sub_zone; ?></option>
        <?php } ?>
         </select>
         </td>  
       </tr>
        </table>

         <br>

        <table align="center" style="width:auto"  id="zone"  class="table display table-hover">
        <thead >

        <tr>  <td width="20" style="text-align:center;font-size:15px;width:5px" ><strong>Delete</strong></td>
        <td width="" style="text-align:left;font-size:15px;width:0px" ><strong>Location Name</strong></td>
        <td width="" style="text-align:left;font-size:15px;width:0px" ><strong>Location Type</strong></td>
<td width="" style="text-align:left;font-size:15px;width:0px" ><strong>Sub Zone</strong></td>
        </tr>
        </thead>
        <tbody>


        <?php if (!empty($location)) {
        foreach ($location as $locations) { ?>
         <tr> 
        <td style="width:20px;text-align: center"> <div class="checkbox">
        <label>
        <input onClick="delete_conform(this)" id="<?php echo $locations->location_id ?>" value="<?php echo $locations->location_id ?>"  type="checkbox">
        </label>
        </div>  </td>

        <td style="width: 100px" onclick="zone_edit(this.id)" align="left" id="row_<?php echo $locations->location_id ?>" sub_zone_id="<?php echo $locations->location_id ?>" col="bay_list" field="zone" val="<?php echo $locations->location ?>"><?php echo $locations->location ?></td>


        <td style="width: 100px" onclick="zone_edit(this.id)" align="left" id="row_<?php echo $locations->location_type_id ?>" sub_zone_id="<?php echo $locations->location_id ?>" col="location_type" field="zone" val="<?php echo $locations->location_type ?>"><?php echo $locations->location_type ?></td>    
        
        <?php  foreach ($sub_zone as $sub_zones) {
			if($sub_zones->sub_zone_id==$locations->sub_zone_id){	
		 ?>
           <td style="width: 100px" onclick="zone_edit(this.id)" align="left" id="row_<?php echo $sub_zones->sub_zone_id ?>" sub_zone_id="<?php echo $locations->location_id?>" col="sub_zone" field="zone" val="<?php echo $sub_zones->sub_zone_id ?>"><?php echo $sub_zones->sub_zone ?></td>  
        
        <?php }} ?>
        </tr>
        <?php } } ?>

       </tbody>
       </table>

        </div>  
        </div>



        <div class="row">
        <div class="col-xs-7 table-responsive">
        <p class="lead"  data-toggle="collapse" data-target="#add_zone" style="cursor:pointer"><strong>Add Location </strong></p>
        <div id="add_zone" class="collapse">
         <div class="col-xs-10">
        <table width="605">
        <tr>
         <td><strong>Enter Location</strong></td>
        <td>                 <input style="width:400px"  type="text" class="form-control" id="new_sub_zone" name="new_sub_zone" required="required"></td>
        </tr>
        <tr><td>&nbsp;</td></tr>
         <tr>
        <td> <strong>Select Location Type</strong></td>
         <td>  <div style="width:400px">
        <select id="location_type" style="width:400px">
        <option></option>
        <?php if (!empty($location_type)) {
        foreach ($location_type as $location_types) { ?>

        <option value="<?php echo $location_types->location_type_id ?>"><?php echo $location_types->location_type ?></option>

        <?php }
        } ?>

        </select>

        </div></td>
        </tr>

        </table>

         <br /> 

          <div style="" align="left">
        <input onclick="new_zone()"  type="button" class="btn  btn-facebook" value="Change & Update"/>
         </div>
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
    function zone_edit(a) {
        var bay_list = '<input type="text" id="a" name="a"/>';

        var location_type = '<select  name="a" id="a"><option value="0">&nbsp;</option><?php foreach ($location_type as $location_types) { ?><option value="<?php echo "lo_".$location_types->location_type_id ?>"><?php echo $location_types->location_type ?></option><?php } ?></select>';
		
		 var sub_zone = '<select  name="a" id="a"><option value="0">&nbsp;</option><?php foreach ($sub_zone as $sub_zones) { ?><option value="<?php echo "su_".$sub_zones->sub_zone_id ?>"><?php echo $sub_zones->sub_zone ?></option><?php } ?></select>';


        var selection = "";
        var textfild = "";
        $('td[id^="row_"]').dblclick(function(event) {
            col = $(this);

            col_width = col.width() - 10;
            var pre_val = $(this).attr('val');
            var pre_text = pre_val//$(this).html();
            var col_name = col.attr('col');

            if (col_name != '') {
                zone_id = col.attr('sub_zone_id');//zone_Id;
                field = col.attr('field');//zone
                data = col.attr('val');

                $(this).html(eval(col_name));
                $("#a").focus();

                $("#a").val(pre_val);
                $("#a").width(col_width);
                $("#a").bind("change", function() {
                    var value = $("#a").val();
                    if ($("#a").is('select')) {
                        var text = $("#a option:selected").val();
                        col.text(text);
                        selection = text;
					
                    }

                    if ($("#a").is('input')) {
                        var text = $("#a").val();
                        col.text(text);

                        textfild = text;
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
                                    window.location = "<?php echo base_url(); ?>index.php/inventory/location_manager/location_dataload?zone_id=" + document.getElementById('zone_select').value + "&sub_zone_id=" + document.getElementById('sub_zone_group').value;

                                }

                            }
                        }
                        if (selection != "") {
						var res=selection.split("_");
						
						if(res[0]=="lo"){
							alert(res[1]);
                            a.open("GET", "<?php echo base_url() ?>index.php/inventory/location_manager/location_type_edit?location_id=" + zone_id + "&location_type_id=" + res[1], true)
						}else{
						
						 a.open("GET", "<?php echo base_url() ?>index.php/inventory/location_manager/location_type_sub_zone_edit?location_id=" + zone_id + "&subzone_id=" + res[1], true)	
							}
                        } else if (textfild != "") {
                            a.open("GET", "<?php echo base_url() ?>index.php/inventory/location_manager/location_type_edit?location_id=" + zone_id + "&location=" + textfild, true)
                           
                        }
						 a.send(null);
                    }




                });
//
                $("#a").bind("focusout", function() {
                    //alert(pre_val);
                   // col.text(pre_text);
                    $("#a").remove();
                    pre_text = "";
					 window.location = "<?php echo base_url(); ?>index.php/inventory/location_manager/location_dataload?zone_id=" + document.getElementById('zone_select').value + "&sub_zone_id=" + document.getElementById('sub_zone_group').value;
                });

                $("#a").bind("dblclick", function() {
                    return false;
                });

            }
        });


    }

    function delete_conform(location_id) { /* perform action here */


        var r = confirm("Delete Location...?");
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
                            window.location = "<?php echo base_url(); ?>index.php/inventory/location_manager/location_dataload?zone_id=" + document.getElementById('zone_select').value + "&sub_zone_id=" + document.getElementById('sub_zone_group').value;

                        }else{
							alert("Sorry you are not allowed to access this area of the system");	
						}

                    }
                }

                a.open("GET", "<?php echo base_url() ?>index.php/inventory/location_manager/location_delete?location_id=" + location_id.value + "", true)

                a.send(null);

            }

        } else {

        }


    }


    function new_zone() {

        var sub_zone_name = document.getElementById('new_sub_zone').value;
        var zone = document.getElementById('zone_select').value;
        var sub_zone_group = document.getElementById('sub_zone_group').value;
        var location_type = document.getElementById('location_type').value;

        if (zone == "") {

            document.getElementById("zone_select").style.border = " solid red";
        } else if (sub_zone_group == "") {

            document.getElementById("sub_zone_group").style.border = " solid red";

        } else if (sub_zone_name == "") {

            document.getElementById("new_sub_zone").style.border = " solid red";
        } else if (location_type == "") {
            document.getElementById("location_type").style.border = " solid red";
        } else if (zone != "" && sub_zone_name != "" && sub_zone_group != "" && location_type != "") {
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
                            window.location = "<?php echo base_url(); ?>index.php/inventory/location_manager/location_dataload?zone_id=" + document.getElementById('zone_select').value + "&sub_zone_id=" + document.getElementById('sub_zone_group').value;

                        }

                    }
                }


                a.open("GET", "<?php echo base_url() ?>index.php/inventory/location_manager/location_add?sub_zone_id=" + sub_zone_group + "&location_type=" + location_type + "&location=" + sub_zone_name + "", true)

                a.send(null);

            }
        }
    }

    function select_zone(zone_id) {

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

                    window.location = "<?php echo base_url(); ?>index.php/inventory/location_manager/location_load?zone_id=" + zone_id;
                }
            }

            a.open("GET", "<?php echo base_url() ?>index.php/inventory/location_manager/location_load?zone_id=" + zone_id, true);

            a.send(null);

        }

    }


    function sub_zone_group(sub_zone_id) {
	  if(sub_zone_id==""){
		 sub_zone_id=0; 
		  }
	
	    var zone_id = document.getElementById("zone_select").value;

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

                    // if (res == "OK") {

                    window.location = "<?php echo base_url(); ?>index.php/inventory/location_manager/location_dataload?zone_id=" + zone_id + "&sub_zone_id=" + sub_zone_id;
                }
            }

            a.open("GET", "<?php echo base_url() ?>index.php/inventory/location_manager/location_dataload?zone_id=" + zone_id + "&sub_zone_id=" + sub_zone_id, true)

            a.send(null);

        }

    }
</script>