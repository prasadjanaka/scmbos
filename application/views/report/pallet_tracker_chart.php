	<?php require_once('loader.php');?>

    <div class="content-wrapper"> 
 
    <section class="content">

    <div class="box-body compact">
     
    <?php   $to =  date('Y-m-d', strtotime('+7 days')); ?>
    <h3>Pallet Movement Summary</h3>

  <br>
  
  
  <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto;background-color:transparent">
  <div style="font-size:72px;color:#666;text-align:center;padding-top:65px" >Line Chart</div>
  </div>
  <table style="">
  
  	<tr>
      <td>Enter EPF Numbers</td>
     
  </tr>
  	<tr>
     
      <td><!--<input class="form-control" type="text" id="epf_number"/>-->
      		<textarea cols="40" rows="3" class="form-control" id="epf_number"></textarea>
      </td>
  </tr>
   <tr>
 
  <td >&nbsp;</td>
  
  </tr>
  <tr>
 
  <td align="right"><input class="btn btn-info btn-flat" type="button" style="width:150px" id="epf_btn" value="Submit" onclick="line_chart()"/></td>
  
  </tr>
 
  </table>
  <br /><br /><br />
  <hr style="background-color:#999;height:1px">
    <form method="post" action="<?php echo base_url()?>index.php/report/dashboard/pallet_track_chart_data_load">
  <table>
  <tr>
  <td><label>From Date</label></td>
  <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
  <td>
  <input type="text" value="<?php echo  date('Y-m-d')  ?>" class="form-control" name="from" id="from" placeholder="YYYY-MM-DD"/>
  </td>
  <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
  <td><label>To Date</label></td>
  <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
  <td>
   <input type="text" value="<?php  echo $to ?>" name="to" class="form-control" id="to" placeholder="YYYY-MM-DD"/>
  </td>
  <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
  <td>
  <input type="button" id="datefilter" class="btn btn-info btn-flat" value="Go!" style="height:30px;text-align:center"/>
  </td>
  </tr>
  </table>
  </form>
  <br />		
            
            <table style="width:100%">
            	<tr>
                	<td style="width:50%;text-align:center;font-weight:bold;font-size:16px">By Date</td>
                    <td style="width:50%;text-align:center;font-weight:bold;font-size:16px">By Epf Number</td>
                </tr>
            </table>
        	 <div id="chartdiv" style="width: 50%; height: 400px;float:left"></div>
          	<div id="chartdiv1" style="width: 50%; height: 400px;"></div>
 

 
    </div>
    </section>
    </div>

<script type="text/javascript">
 line_chart(con=1);
   var chart;
   var chart1;
	


function line_chart(con=0){
  if($('#epf_number').val()!="" || con==1){
		 categories= [];
		 series= [];
		 data=[];
		 var ss;
			 
		var targetDate = new Date();
		targetDate.setDate(targetDate.getDate() - 7);
		var dd = targetDate.getDate();
		var mm = targetDate.getMonth() + 1; // 0 is January, so we must add 1
		var yyyy = targetDate.getFullYear();
		
		var dateString = yyyy +"-" + mm + "-" +dd ;
		
		var i=8;
		var targetDate1 = new Date(dateString);
				for(var x=1;i>x;x++){
				
						targetDate1.setDate(targetDate1.getDate() + 1);
						var ddd = targetDate1.getDate();
						var mmm = targetDate1.getMonth() + 1; // 0 is January, so we must add 1
						var yyyyy = targetDate1.getFullYear();
						
						var dateString1 = yyyyy+"-"+mmm+"-"+ddd ;
						categories.push(dateString1);
				
				}
		
			$.ajax({
					url: '<?php echo base_url() ?>index.php/report/dashboard/print_chart',
					method: 'POST',
					data: {user_id:$('#epf_number').val()},
					success: function(print_data) {
			
						
							var step=print_data.split('?')
							for(var a=0;step.length>a;a++){
			
									if(step[a]!=""){
									
										var step1=step[a].split('/')
										var user_id=step1[1];
						
										var res=step1[0].split('_');
							
											data=[];
											for(var i=1;res.length>i;i++){
												data.push(parseInt(res[i]));
											}
						
												ss={
												name:user_id,
												data
											    }
										series.push(ss);
									 }
							}
		
						},      
				}); 
		
		line_chart_fill(series,categories);
  }else{
		alert("Enter EPF Number");
  }
}

function line_chart_fill(series,categories,con){

alert();

 $(function () {
   $('#container').highcharts({
        title: {
            text: '',
            x: -20 //center
        },
        subtitle: {
            text: '',
            x: -20
        },
        xAxis: {    categories   },
        yAxis: {
            title: {
                text: 'Number of Pallets'
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            valueSuffix: ''
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 1
        },
	
		series
       
    
	});
});

};
	

  $('#datefilter').click(function(e) {
      var from= $('#from').val();
	  var to= $('#to').val();
	  
	   $.ajax({
            url: '<?php echo base_url() ?>index.php/report/dashboard/pallet_track_chart_data_load',
            method: 'POST',
            data: {from:from,to:to},
            success: function(data) {
               if (data!="") {
			
				var chartData = [	];
				var res=data.split('_');
		
			  	for(var x=1;res.length>x;x++){
				var res_chart=res[x].split('/'); 
					var chartData1 =      	
					{   "country":res_chart[0],
						"visits":res_chart[1],
						"color": "#FF6600"
					}
			    
            
					
					chartData.push(chartData1)
				}
				
			chart_by_date(chartData);  
			 
			date_range();
				}


            },
      
        });
	  
    });
 
 	function date_range(){
	
	  var from= $('#from').val();
	  var to= $('#to').val();
	
		$.ajax({
            url: '<?php echo base_url() ?>index.php/report/dashboard/pallet_track_chart_data_load_users',
            method: 'POST',
            data: {from:from,to:to},
            success: function(data) {
             
			   if (data!="") {
			
				  var chartData = [	];
				var res=data.split('_');
		
			  	for(var x=1;res.length>x;x++){
				var res_chart=res[x].split('/'); 
			
            var chartData1 =      	
				{   "country":res_chart[0],
                    "visits":res_chart[1],
                    "color": "#FF9E01"
				}

				chartData.push(chartData1)
				}

				chart_by_user(chartData);  

				}

            },
      
        });
	 }
 

	$.ajax({
            url: '<?php echo base_url() ?>index.php/report/dashboard/pallet_track_chart_data_load',
            method: 'POST',
            data: {},
            success: function(data) {
               if (data!="") {
			
					var chartData = [	];
					var res=data.split('_');
			
					for(var x=1;res.length>x;x++){
					var res_chart=res[x].split('/'); 
				
					var chartData1 =      	
					{   
						"country":res_chart[0],
						"visits":res_chart[1],
						"color": "#FF6600"
					
					}
		
					chartData.push(chartData1)
					}
					
					chart_by_date(chartData);  
			
				}
            },
      
        });

 function chart_by_date(chartData){
		  chart = new AmCharts.AmSerialChart();
                chart.dataProvider = chartData;
                chart.categoryField = "country";
				
                // the following two lines makes chart 3D
                chart.depth3D = 25;
                chart.angle = 20;

                // AXES
                // category
                var categoryAxis = chart.categoryAxis;
                categoryAxis.labelRotation = 90;
                categoryAxis.dashLength = 5;
                categoryAxis.gridPosition = "start";

                // value
                var valueAxis = new AmCharts.ValueAxis();
                valueAxis.title = "Number of Pallets";
                valueAxis.dashLength = 5;
                chart.addValueAxis(valueAxis);

                // GRAPH
                var graph = new AmCharts.AmGraph();
                graph.valueField = "visits";
                graph.colorField = "color";
                //graph.balloonText = "<span style='font-size:14px'>[[category]]: <b>[[value]]</b></span>";
                graph.labelText="[[value]]";
				graph.type = "column";
                graph.lineAlpha = 0;
                graph.fillAlphas = 1;
                graph.lineColor = "#C72C95";
                graph.balloonText = "<b><span style='color:#C72C95'>[[title]]</b></span><br><span style='font-size:14px'>[[category]]: <b>[[value]]</b></span>";
                graph.labelPosition = "middle";
                chart.addGraph(graph);
				

                // CURSOR
                var chartCursor = new AmCharts.ChartCursor();
                chartCursor.cursorAlpha = 0;
                chartCursor.zoomable = true;
                chartCursor.categoryBalloonEnabled = true;
                chart.addChartCursor(chartCursor);

                chart.creditsPosition = "top-right";


                // WRITE
                chart.write("chartdiv");
            //});
			
		user();
		}	
 
 
    function user(){
	
  $.ajax({
            url: '<?php echo base_url() ?>index.php/report/dashboard/pallet_track_chart_data_load_users',
            method: 'POST',
            data: {condition:1},
            success: function(data) {
    
			   if (data!="") {
				
					var chartData = [	];
					var res=data.split('_');
			
					for(var x=1;res.length>x;x++){
					var res_chart=res[x].split('/'); 
				
					var chartData1 =      	
					{  
					 "country":res_chart[0],
					 "visits":res_chart[1],
					 "color": "#FF9E01",
					
					}
	
					chartData.push(chartData1)
					}
					
				    chart_by_user(chartData);  
				}


            },
      
        });
		
 }
    function chart_by_user(chartData){
		
		  		chart1 = new AmCharts.AmSerialChart();
                chart1.dataProvider = chartData;
                chart1.categoryField = "country";
                // the following two lines makes chart 3D
                chart1.depth3D = 25;
                chart1.angle = 20;

                // AXES
                // category
                var categoryAxis = chart1.categoryAxis;
                categoryAxis.labelRotation = 0;
                categoryAxis.dashLength = 5;
                categoryAxis.gridPosition = "start";

                // value
                var valueAxis = new AmCharts.ValueAxis();
                valueAxis.title = "Number of Pallets";
                valueAxis.dashLength = 5;
                chart1.addValueAxis(valueAxis);

                // GRAPH
                var graph = new AmCharts.AmGraph();
                graph.valueField = "visits";
                graph.colorField = "color";
                graph.balloonText = "<span style='font-size:14px'>[[category]]: <b>[[value]]</b></span>";
				graph.labelText="[[value]]";
                graph.type = "column";
                graph.lineAlpha = 0;
                graph.fillAlphas = 1;
                chart1.addGraph(graph);

                // CURSOR
                var chartCursor = new AmCharts.ChartCursor();
                chartCursor.cursorAlpha = 0;
                chartCursor.zoomable = true;
                chartCursor.categoryBalloonEnabled = true;
                chart1.addChartCursor(chartCursor);

                chart1.creditsPosition = "top-right";

                chart1.write("chartdiv1");
  
		}	

  </script>
  
