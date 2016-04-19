<?php require_once('loader.php'); ?>
<div class="content-wrapper">
    <section class="content">
        <section class="content-header">
            <h1><strong> <?php echo "Sub Zone Group" ?></strong></h1>
        </section>
        <div class="box-body compact">
            <div class="col-xs-12" style="text-align:left" >

                    <table style="width:500px">

                    <tr>
                    <td style="text-align: right;padding-right: 20px">
                    <strong>Select Zone</strong>   
                    </td>
                    <td style="padding-left: 5px"> 
                    <select style="width:200px" id="zone_select" name="zone_select" class="form-control" onchange="select_zone(this.value)">
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
                    </table>

                <br>

                    <table align="center" style="width:auto"  id="zone"  class="table display table-hover">
                    <thead >

                     <tr>  <td width="" style="text-align:center;font-size:15px;width:5px" ><strong>Delete</strong></td>
                    <td width="" style="text-align:left;font-size:15px;width:auto" ><strong>Sub Zone Group Name</strong></td>
                    <td width="" style="text-align:left;font-size:15px;width:auto" ><strong>Zone Name</strong></td>

                    </tr>
                    </thead>
                    <tbody>


                    <?php if (!empty($sub_zone_group)) {
                    foreach ($sub_zone_group as $sub_zone_groups) { ?>
                    <tr> 
                    <td style="width:auto;text-align: center"> <div class="checkbox">
                    <label>
                    <input onClick="delete_conform(this)" id="<?php echo $sub_zone_groups->sub_zone_group_id ?>" value="<?php echo $sub_zone_groups->sub_zone_group_id ?>"  type="checkbox">
                    </label>
                    </div>  </td>
                    <td style="width: 100px" onclick="zone_edit(this.id)" align="left" id="row_<?php echo $sub_zone_groups->sub_zone_group_id ?>" zone_id="<?php echo $zone_lists->zone_id?>" col="bay_list" field="zone" val="<?php echo $sub_zone_groups->sub_zone_group ?>"><?php echo $sub_zone_groups->sub_zone_group ?></td>
                  
 		<?php  foreach ($zone_list as $zone_lists) { 
		if($sub_zone_groups->zone_id==$zone_lists->zone_id){
		?>
                   
                    <td style="width: 100px" onclick="zone_edit(this.id)" align="left" id="row_<?php echo  $zone_lists->zone ?>" zone_id="<?php echo $sub_zone_groups->sub_zone_group_id ?>" col="zone" field="zone" name="<?php echo $zone_lists->zone_id ?>"   val="<?php echo $zone_lists->zone ?>"><?php echo $zone_lists->zone ?></td>
                      <?php }} ?>
                     </tr>
                   <?php }}?>
                    </tbody>
                </table>

            </div>  




        </div>
        <div class="row">
        <div class="col-xs-12 table-responsive">
        <p class="lead"  data-toggle="collapse" data-target="#add_zone" style="cursor:pointer"><strong>Add Sub Zone Group</strong></p>
        <div id="add_zone" class="collapse">
        <div class="col-xs-12">
        <input  type="text" class="form-control" id="new_sub_zone_group" name="new_sub_zone_group" required="required"><br>
        <div style="" align="left"> <input onclick="new_zone()"  type="button" class="btn  btn-facebook" value="Change & Update"/> </div>
        </div>
        </div>
        </div>
            <!-- /.col --> 
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

  res=a.split("_");
  var bay_list = '<input type="text" id="a" name="a"/>';


  var zone = '<select style="width:100%;font-size:12px" name="a" id="a"><option>'+res[1]+'</option><?php foreach ($zone_list as $zone_lists) { ?><option  value="<?php echo $zone_lists->zone_id ?>"><?php  echo $zone_lists->zone ?></option><?php  } ?></select>';

 var text=null;
 var change_value=null;
        $('td[id^="row_"]').dblclick(function(event) {
            col = $(this);

            col_width = col.width() - 10;
			var col_name = col.attr('col');
            var pre_val = $(this).attr('val');
			//$pre_val=$( "#a option:selected").val();
			//alert(pre_val);
            var pre_text = pre_val//$(this).html();
            var col_name = col.attr('col');
		//	alert(col_name);
			$col_name=$( "#a option:selected").val();
		//	document.getElementById();
            if (col_name != '') {
                sub_zone_group_id = col.attr('zone_id');//zone_Id;

                field = col.attr('field');//zone
				
                data = col.attr('val');

              
			    $(this).html(eval(col_name));
                $("#a").focus();
				//
				//$( "#a option:selected").val();
                $("#a").val(pre_val);
                $("#a").width(col_width);
                $("#a").bind("change", function() {
                value =$('#a').find(":selected").val();// $("#a").val();
					//col.text(text);
					//change_value=value;
					//alert(value);
                    if ($("#a").is('input')) {
                        text = $("#a").val();
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
                                    window.location = "<?php echo base_url(); ?>index.php/inventory/location_manager/sub_zone_group?zone_id=" + document.getElementById("zone_select").value + ""

                                }

                            }
                        }

						if(text!=null){
                        a.open("GET", "<?php echo base_url() ?>index.php/inventory/location_manager/sub_zone_group_edit?zone_id=" + sub_zone_group_id + "&name=" + text + "", true)
						}else if(value!=null){
							//alert(sub_zone_group_id+"  "+value);
						  a.open("GET", "<?php echo base_url() ?>index.php/inventory/location_manager/sub_zone_group_zone_edit?zone_id=" + sub_zone_group_id + "&name=" + value + "", true)
						}
                        a.send(null);

                    }
                });
//
                $("#a").bind("focusout", function() {
                    //alert(pre_val);
                    col.text(pre_text);
                    $("#a").remove();
                    pre_text = "";
                });

                $("#a").bind("dblclick", function() {
                    return false;
                });

            }
        });


    }

    function delete_conform(sub_zone_group_id) { /* perform action here */

        var txt;
        var r = confirm("Delete Sub Zone Group...?");
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
                            window.location = "<?php echo base_url(); ?>index.php/inventory/location_manager/sub_zone_group?zone_id=" + document.getElementById('zone_select').value;

                        }else{
							alert("Sorry you are not allowed to access this area of the system");	
						}

                    }
                }

                a.open("GET", "<?php echo base_url() ?>index.php/inventory/location_manager/sub_zone_group_delete?sub_zone_group_id=" + sub_zone_group_id.value + "", true)

                a.send(null);

            }

        } else {

        }


    }


    function new_zone() {
        var boo = false;
        var sub_zone_group = document.getElementById('new_sub_zone_group').value;
        var zone = document.getElementById('zone_select').value;

        if (zone == "") {

            document.getElementById("zone_select").style.border = " solid red";
        } else if (sub_zone_group == "") {

            document.getElementById("new_sub_zone_group").style.border = " solid red";
        } else if (zone != "" && sub_zone_group != "") {


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
                            window.location = "<?php echo base_url(); ?>index.php/inventory/location_manager/sub_zone_group?zone_id=" + document.getElementById('zone_select').value;

                        }

                    }
                }

                a.open("GET", "<?php echo base_url() ?>index.php/inventory/location_manager/sub_zone_group_add?zone_id=" + zone + "&sub_value=" + sub_zone_group + "", true)

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
                    window.location = "<?php echo base_url(); ?>index.php/inventory/location_manager/sub_zone_group?zone_id=" + zone_id;
                }
            }

            a.open("GET", "<?php echo base_url() ?>index.php/inventory/location_manager/sub_zone_group?zone_id=" + zone_id, true)

            a.send(null);

        }

    }

</script>