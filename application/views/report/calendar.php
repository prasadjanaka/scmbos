
   <style>
   .fc-day-grid-event .fc-time{display:none};
   
   </style>


<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper"> 
<div class="content-wrapper">
        <section class="content">
        
   <div class="row">
            <div class="col-md-3">
              <div class="box box-solid">
                <div class="box-header with-border">
                  <h4 class="box-title">Calendar Event</h4>
                </div>
                <div class="box-body">
               
                  <!-- the events -->
                  <div id="external-events">
                  <?php  foreach($event as $events){ ?>
                    <div onMouseOver="get_event_id(this.id)" onDblClick="delete_event(this.id)" id="<?php echo $events->calendar_event_id; ?>" class="external-event" style="background-color:<?php echo $events->color; ?>"><span class="external-event" style="background-color:<?php echo $events->color; ?>">
                      <?php echo $events->event_name; ?>
                    </span></div>
                    <?php } ?>
                    <div class="checkbox" style="display:none">
                      <label for="drop-remove">
                        <input type="checkbox" id="drop-remove">
                        remove after drop
                      </label>
                      
                     
					   ?>
                    </div>
                  </div>
                </div><!-- /.box-body -->
              </div><!-- /. box -->
              <div class="box box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title">Create Event</h3>
                </div>
                <div class="box-body">
                  <div class="btn-group" style="width: 100%; margin-bottom: 10px;">
                    <!--<button type="button" id="color-chooser-btn" class="btn btn-info btn-block dropdown-toggle" data-toggle="dropdown">Color <span class="caret"></span></button>-->
                    <ul class="fc-color-picker" id="color-chooser">
                      <li><a class="text-aqua" href="#"><i class="fa fa-square"></i></a></li>
                      <li><a class="text-blue" href="#"><i class="fa fa-square"></i></a></li>
                      <li><a class="text-light-blue" href="#"><i class="fa fa-square"></i></a></li>
                      <li><a class="text-teal" href="#"><i class="fa fa-square"></i></a></li>
                      <li><a class="text-yellow" href="#"><i class="fa fa-square"></i></a></li>
                      <li><a class="text-orange" href="#"><i class="fa fa-square"></i></a></li>
                      <li><a class="text-green" href="#"><i class="fa fa-square"></i></a></li>
                      <li><a class="text-lime" href="#"><i class="fa fa-square"></i></a></li>
                      <li><a class="text-red" href="#"><i class="fa fa-square"></i></a></li>
                      <li><a class="text-purple" href="#"><i class="fa fa-square"></i></a></li>
                      <li><a class="text-fuchsia" href="#"><i class="fa fa-square"></i></a></li>
                      <li><a class="text-muted" href="#"><i class="fa fa-square"></i></a></li>
                      <li><a class="text-navy" href="#"><i class="fa fa-square"></i></a></li>
                    </ul>
                  </div><!-- /btn-group -->
                  <div class="input-group">
                    <input id="new-event" type="text" class="form-control" placeholder="Event Title">
                    <div class="input-group-btn">
                      <button id="add-new-event" type="button" class="btn btn-primary btn-flat">Add</button>
                    </div><!-- /btn-group -->
                  </div><!-- /input-group -->
                  </br>
                  <p style="font-size:14px">If you want to remove event please double click on the event.</p>
                  
                </div>
              </div>
            </div><!-- /.col -->
            <div class="col-md-9">
              <div class="box box-primary">
                <div class="box-body no-padding">
                  <div id="calendar"></div>
                </div><!-- /.box-body -->
              </div><!-- /. box -->
            </div><!-- /.col -->
          </div><!-- /.row -->

		</section>
        
        </div>
        </div>
        </body>
          
        <script>
	function delete_event(id){
		
	var r = confirm("Are you sure delete this event...");
	if (r == true) {
		
		$.ajax({
            url: '<?php echo base_url() ?>index.php/report/dashboard/remove_event',
            method: 'POST',
            data: {event_id:id},
            success: function(data) {
                if (data != "") {
                 //  alert(data);
				 window.location="<?php echo base_url()?>index.php/report/dashboard/view_calendar";
				 
                }
            },
            error: function(err, message, xx) {

            }
		});	
		
	
	} else {
	
	}

	}
	
	function evt_idf(event_id){


	var r = confirm("Are you sure delete this event...");
	if (r == true) {
		$.ajax({
            url: '<?php echo base_url() ?>index.php/report/dashboard/remove_event_schedule',
            method: 'POST',
            data: {id:event_id.id},
            success: function(data) {
                if (data != "") {
                 if(data=="OK")
				   
				window.location="<?php echo base_url()?>index.php/report/dashboard/view_calendar";
                }
            },
            error: function(err, message, xx) {

            }
		});		
				
		
		
	
	} else {
	
	}

	
	}

	var event_id="";
	function get_event_id(data){
	event_id="";
	event_id=data;
	}

	function showCoords(event) {
    var x = event.clientX;
    var y = event.clientY;
    var coords = "X coords: " + x + ", Y coords: " + y;
    document.getElementById("demo").innerHTML = coords;
	}
	
	</script>
    
    
    <script>


      $(function () {

        /* initialize the external events
         -----------------------------------------------------------------*/
        function ini_events(ele) {
          ele.each(function () {
		
            // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
            // it doesn't need to have a start or end
            var eventObject = {
              title: $.trim($(this).text()) // use the element's text as the event title
             
			}; 
		
            // store the Event Object in the DOM element so we can get to it later
            $(this).data('eventObject', eventObject);
			
            // make the event draggable using jQuery UI
            $(this).draggable({
              zIndex: 1070,
              revert: true, // will cause the event to go back to its
              revertDuration: 0  //  original position after the drag
			
            });
			
          });
        }
        ini_events($('#external-events div.external-event'));

        /* initialize the calendar
         -----------------------------------------------------------------*/
        //Date for the calendar events (dummy data)
        var date = new Date();
        var d = date.getDate(),
                m = date.getMonth(),
                y = date.getFullYear();
        $('#calendar').fullCalendar({
          header: {
           
         //   center: 'title'
          
          },
         
          //Random default events
		
		 eventDrop: function(event) {
			 
				var event_id=event.time;
				var dd=event.start;
   				var d = new Date(dd);
				var dd=d.getDate();
              	var m = d.getMonth()+1;
                var y = d.getFullYear();
				var new_date=y+"-"+m+"-"+dd;
				//alert(event_id);
				
				$.ajax({
            url: '<?php echo base_url() ?>index.php/report/dashboard/update_schedule',
            method: 'POST',
            data: {id:event_id,date:new_date},
            success: function(data) {
                if (data != "") {
                   // alert(data);
			window.location="<?php echo base_url()?>index.php/report/dashboard/view_calendar";
				 
                }
            },
          
		});
			 
			 }, 
			 
          events: [
            <?php  foreach($event_schedule as $event_schedules){ ?>
			
				<?php $date_event=explode("-",$event_schedules->schedule_date); ?>
		
			
			{
				
			 
             
              title: '<?php echo $event_schedules->event_name; ?>',
              start: new Date(<?php echo $date_event[0] ?>,<?php echo $date_event[1]-1 ?>,<?php echo $date_event[2] ?>),
              backgroundColor: "<?php echo $event_schedules->color; ?>", //red
              borderColor: "<?php echo $event_schedules->color; ?>", //red
			  time:"<?php echo $event_schedules->calendar_event_schedule_id; ?>",
			},
	
			<?php   }?>
 
          ],
		
	
          editable: true,
          droppable: true,

		   // this allows things to be dropped onto the calendar !!!
          drop: function (date, allDay) { // this function is called when something is dropped
	

            // retrieve the dropped element's stored Event Object
            var originalEventObject = $(this).data('eventObject');

            // we need to copy it, so that multiple events don't have a reference to the same object
            var copiedEventObject = $.extend({}, originalEventObject);

            // assign it the date that was reported
            copiedEventObject.start = date;
            copiedEventObject.allDay = allDay;
            copiedEventObject.backgroundColor = $(this).css("background-color");
            copiedEventObject.borderColor = $(this).css("border-color");
			
			var d = new Date(date);
			//$date_new = date('Y-m-d H:i:s ', strtotime(str_replace('-', '-', $data['value'])));
				var dd=d.getDate();
               var m = d.getMonth()+1;
                var y = d.getFullYear();
				var new_date=y+"-"+m+"-"+dd;
	
				if(event_id!=""){
			
				
				$.ajax({
            url: '<?php echo base_url() ?>index.php/report/dashboard/add_new_schedule',
            method: 'POST',
            data: {schedule_date:new_date,schedule_event_id:event_id},
            success: function(data) {
                if (data != "") {
					window.location="<?php echo base_url()?>index.php/report/dashboard/view_calendar";
              
				   
				 
                }
            },
            error: function(err, message, xx) {

            }
		});		
				
					
					}
			
            $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);
		
          }
        });
		
		
		
		
        /* ADDING EVENTS */
        var currColor = "#3c8dbc"; //Red by default
        //Color chooser button
        var colorChooser = $("#color-chooser-btn");
        $("#color-chooser > li > a").click(function (e) {
          e.preventDefault();
          //Save color
          currColor = $(this).css("color");
	
          //Add color effect to button
          $('#add-new-event').css({"background-color": currColor, "border-color": currColor});
        });
        $("#add-new-event").click(function (e) {
		//alert("aasa");	
			
          e.preventDefault();
          //Get value and make sure it is not null
          var val = $("#new-event").val();
			if(val==""){
			  $('#new-event').focus();
			}else{
				
				$.ajax({
				url: '<?php echo base_url() ?>index.php/report/dashboard/add_event',
				method: 'POST',
				data: {new_event_name:$('#new-event').val(),event_color:currColor},
				success: function(data) {
				if (data != "") {
				
				
					var event = $("<div />");
					event.css({"background-color": currColor, "border-color": currColor, "color": "#fff"}).addClass("external-event");
					event.html(val);
					$('#external-events').prepend(event);
					
					ini_events(event); 
					window.location="<?php echo base_url()?>index.php/report/dashboard/view_calendar";
				}
			},
			error: function(err, message, xx) {
			
			}
		});	
			  
	  }
        
          $("#new-event").val("");
        });
      });
	 
		
    </script>