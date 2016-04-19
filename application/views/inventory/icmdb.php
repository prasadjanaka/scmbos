<?php require_once('loader.php');
date_default_timezone_set("Asia/Colombo");
?>

<div class="content-wrapper">
  <section class="content">
    <div class="box-body compact"> 
    <input type="text" hidden="" id="date_current" value="<?php echo $ds ?>"/>
    <div class="row">
    
    	<div class="col-md-3" >
        
      <?php  $w_tot_location=0;
				   $w_tot_selected_location=0;
				   $w_tot_counted_location=0;
				   $w_tot_progress=0;
				   if($zone_summery->num_rows()>0){
				   foreach($zone_summery->result() as $zs ){
                   	$w_tot_location	= $w_tot_location +	$zs->total_locations;
                    $w_tot_selected_location =  $w_tot_selected_location + $zs->locations_to_count;
					$w_tot_counted_location = $w_tot_counted_location + $zs->counted_locations ;
					
                    } 
					 $w_tot_progress = number_format(($w_tot_counted_location * 100) / $w_tot_location , 2, '.', '');
					}
					
					
					?>
   
      
      
        	<div class="box">
              	
                	<div class="box-body">
                  
                    <table class="table" style="width:100%">
                    
                    <thead>
                    	<tr>
                        	<td style="font-weight:bold;font-size:16px;text-align:center">Zone</td>
                        	<td style="font-weight:bold;font-size:16px;text-align:center">TL</td>
                            <td style="font-weight:bold;font-size:16px;text-align:center">AL</td>
                            <td style="font-weight:bold;font-size:16px;text-align:center">CL</td>
                            <td style="font-weight:bold;font-size:16px;text-align:center">CL / TL</td>
                        </tr>
                    </thead>
                    <tbody> 
					<?php $zone_col =array(); 
					array_push($zone_col,"non");
					foreach($zone_summery->result() as $zs ){ ?>
                    <?php 
    
						if($zs->zone_id==1){$color = "#0189E8";
						}else if($zs->zone_id==2){$color = "#8549E5";
						}else if($zs->zone_id==3){$color = "#f6bc17";
						}else if($zs->zone_id==4){$color = "#24c0b5";
						}else if($zs->zone_id==5){$color = "#cb6dce";
						}else if($zs->zone_id==6){$color = "#dd1e5b";
						}else if($zs->zone_id==7){$color = "#3dcb93";
						}else if($zs->zone_id==8){$color = "#26a868";
						}
					
						array_push($zone_col,$color);
					?>
                    	<tr style="height:35px;background-color:<?php echo $color ?>">
                        	<td style="color:#FFF;font-weight:bold;text-align:center"><?php echo $zs->zone ?></td>
                        	<td style="color:#FFF;font-weight:bold;text-align:center"><?php echo $zs->total_locations ?></td>
                            <td style="color:#FFF;font-weight:bold;text-align:center"><?php echo $zs->locations_to_count ?></td>
                            <td style="color:#FFF;font-weight:bold;text-align:center"><?php echo $zs->counted_locations ?></td>
                            <td style="color:#FFF;font-weight:bold;text-align:center"><?php  echo number_format(($zs->counted_locations) * 100 / ($zs->total_locations) , 2, '.', ''); ?>%</td>
                        </tr>
                      <?php  } ?>
                    </tbody>
        
                    </table>
                <table  class="table no-padding">
                	<tr class="no-padding">
                    <td class="no-padding">TL=></td><td class="no-padding" style="font-size:13px">Total Locations</td>
                   <td class="no-padding">AL=></td><td class="no-padding" style="font-size:13px">Assigned locations</td>
                    </tr>
                    <tr>
                      <td class="no-padding">CL=></td><td class="no-padding" style="font-size:13px">Counted Locations</td>  
                     <!-- <td class="no-padding">PR=></td><td  class="no-padding" style="font-size:13px">Progress</td> -->
                    </tr>
                  
                </table>
                </div>      
            </div>
       
          <div class="info-box bg-yellow">
              
                <div style="margin-left:0px"  class="info-box-content">
                  <span class="info-box-text"><?php echo $ds ?> - Inventory Count</span>
                  <span class="info-box-number">Overall Progress <?php echo $w_tot_progress ?>%</span>
                  <div style="margin-left:1px;height:15px;margin-right:1px;background-color:#9F6" class="progress">
                   <!-- <div class="progress-bar" style="width: %;background-color:#30F"></div>  -->
                   
                    <div class="progress-bar" style="width:100%" val="<?php echo $w_tot_progress ?>" id="progressBar"><div></div></div>
                  </div>
                  <span class="progress-description">
                  
                  </span>
                </div><!-- /.info-box-content -->
     
          </div>
  
  

          <!--and -->
       
       <div>
       </div>
         
     
        <div>
       
       
        </div>
  
        </div>
    
 
    <div class="col-md-9">
 
  <!-- Pre for zones  -->         
      <div class="row">   
      <div class="col-md-12">
         <div class="box box-primary">
          <table class="" style="width:100%;margin-left:10px">
        	<tr>
            <td><b style="font-size:16px">Zone Progress</b></td>
            </tr>
        </table>
                <div class="box-body">
              
      <table style="width:100%" class="table">
                
                <tr>
				<?php $i=0; foreach($zone_summery->result() as $zs ){ $i++; ?>
                
                	<td align="center"><div align="center" style="display:inline;width:90px;height:90px;text-align:center" class="text-center"><input style="width: 49px; height: 30px; position: absolute; vertical-align: middle; margin-top: 30px; margin-left: -69px; border: 0px none; background: transparent none repeat scroll 0% 0%; font: bold 18px Arial; text-align: center; color: rgb(60, 141, 188); padding: 0px;" readonly="readonly" class="knob" value="<?php echo number_format(($zs->counted_locations) * 100 / ($zs->total_locations) , 2, '.', '') ?>" data-skin="tron" data-thickness="0.2" data-width="90" data-height="90" data-fgcolor="<?php  echo $zone_col[$i] ?>" data-readonly="true" type="text"></div><div><?php  echo  $zs->zone ?></div></td>	
					
					<?php  } ?>
                </tr>
                
                </table>
                </div>
          </div>
        </div>
                
        </div>             
       
     <div id="" class="row">
     	 <div class="col-md-6">
         <div class="box box-primary">
             <table class="" style="width:100%;margin-left:10px">
        	<tr>
            <td><b style="font-size:16px">Inventory VS Count</b></td>
            </tr>
        </table>
        
                <div class="box-body">
                
                 <div id="" class="row">
                 
              
                  <div class="col-md-6">
                 <div align="center"><b>Locations</b></div>
                 <div id="chartContainer_rack"  style="height:300px; width: 100%;"></div> 
                 </div>
                 
                 <div class="col-md-6">
                    <div align="center"><b>Product IDs</b></div>
                 <div id="chartContainer_rack1"  style="height:300px; width: 100%;"></div>
                 </div>
                  
        
                 </div>
                 
                
                
               
                </div><!-- /.box-body-->
              
              
              </div>
         
         </div>
         
         <!--   pie chart  -->
           <div class="col-md-6">
          <div class="box box-primary">
       <table class="" style="width:100%;margin-left:10px">
        	<tr>
            <td><b style="font-size:16px">Counting Distribution</b></td>
            </tr>
        </table>
        
                <div class="box-body">
                 <div id="chartdiv_pie_chart"  style="height:320px; width: 100%;"></div>
                
                </div>
                
            </div>    
          </div>
          <!-- end pie chart  -->
          </div>
             
     
     </div>
    
    
    
     </div>
    
    <!-- <div id="chartContainer_rack"  style="height:300px; width: 100%;"></div> -->
<div id="row_hidden" class="row">
     	 <div class="col-md-12">
         <div class="box box-primary">
             <table class="table" style="width:50%;margin-left:10px">
        	<tr>
            <td><b style="font-size:16px;">Team Progress</b></td>
            
            <td style="font-size:18px;font-weight:bold;width:auto">Total Teams</td>
            <td style="font-size:18px;font-weight:bold"><?php echo $total_scanners->total_scanners;  ?></td>
           
            <td>|</td>
            
            <td style="font-size:18px;font-weight:bold">In Action</td>
            <td style="font-size:18px;font-weight:bold"><?php  echo $inaction_ref ?></td>
            
            <td>|</td>
            
            <td style="font-size:18px;font-weight:bold">Idling</td>
                <td style="font-size:18px;font-weight:bold"><?php  echo $total_scanners->total_scanners-$inaction_ref ?></td>
            </tr>
        </table>
        
                <div class="box-body">
                <div id="chartContainer"  style="height:280px; width: 100%;"></div> 
                </div><!-- /.box-body-->
           </div>
         
         </div>
         
         
     
      
 
   <div style="float:left;font-weight:bold"> Powerd by GSL ICT Department (<?php if($acc_inv->num_rows()>0){ foreach($acc_inv->result() as $xx ){echo "L.A - ".$xx->location_accuracy; echo "&nbsp;&nbsp; | &nbsp;&nbsp;"; echo "I.A - ".$xx->inventory_accuracy ;}  } ?>) </div>
   <div style="font-weight:bold" class="pull-right"> <?php  echo date('Y-m-d / h:i:sa') ?></div>
 
 </div>
    </div>
  </section>
</div>


<style>

    #progressBar {
        width: 400px;
        height: 22px;
        border: 1px solid #111;
        background-color: #292929;
    }
    #progressBar div {
        height: 100%;
        color: #fff;
        text-align: right;
        line-height: 22px; /* same as #progressBar height if we want text middle aligned */
        width: 0;
        background-color: #0099ff;
    }
</style>

<script>
    function progress(percent, $element) {
        var progressBarWidth = percent * $element.width() / 100;
        $element.find('div').animate({ width: progressBarWidth }, 1000);
    }
	   
timer = setTimeout(func, 60000);  

  function func() {
		 location.reload(1); 
	  }
	$('#auto_reload').click(function(e) {
		clearInterval(timer)
		
    });
	

  // var chart1;
   //var chart;
   var sdata = [];	
    var sdata_pie = [];	
   var sdata_rack = [];	
   function getRandomColor() {
    var letters = '0123456789ABCDEF'.split('');
    var color = '#';
    for (var i = 0; i < 6; i++ ) {
        color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
}
window.onload = function () {
	var pro_val = $('#progressBar').attr('val');
	
	   progress(pro_val, $('#progressBar'));


	 

	var c_date = $('#date_current').val();

		$.ajax({
				url: '<?php echo base_url() ?>index.php/inventory/Count_ref_manager/icmdb_load_bar_chart',
				method: 'POST',
				data: {ds:c_date},
				success: function(data) {
				
				if(data.length>0){
				var parent = data.split('%');
					for(i=1;parent.length>i;i++){
					var child = parent[i].split('!');
  					var rendom_clor = getRandomColor();
			 var chartData1 =      	
					{  
					 "country":child[0],
					 "visits":child[1],
					 "color": rendom_clor,					
					}
					sdata.push(chartData1)
			
					}
					create_chart(sdata);	
				}else{
					$('#row_hidden').attr("hidden","hidden")
				}
				
				},
				error: function(err, message, xx) {	}
			});
			
			//inventory vs count chat data load
	
	
		$.ajax({
				url: '<?php echo base_url() ?>index.php/inventory/Count_ref_manager/icmdb_load_bar_chart_inv_vs_count',
				method: 'POST',
				data: {ds:c_date},
				success: function(data_row) {
				
				var master_data = data_row.split('!'); 
				
				if(master_data.length > 0){
					for(x=0;master_data.length>x;x++){
					
						if(x==1){
						
						var sdata_rack = [];	
						var chartData=      	
							{  
							 "country":"Inventory",
							 "visits":master_data[x-1],
							 "color": "#FCD202",					
							}
							sdata_rack.push(chartData);
							var chartData1=      	
							{  
							 "country":"Counted",
							 "visits":master_data[x],
							 "color": "#b0f054",					
							}
						
							sdata_rack.push(chartData1);
							//sdata_rack[1]["visits"] =6496;
//							sdata_rack[0]["visits"] =6496;
						create_chart_rack(sdata_rack,div_name="chartContainer_rack");	
						
						}else if(x==3){
							sdata_rack = [];
							var chartData=      	
							{  
							 "country":"Inventory",
							 "visits":master_data[x-1],
							 "color": "#FCD202",					
							}
							sdata_rack.push(chartData)
							var chartData1=      	
							{  
							 "country":"Counted",
							 "visits":master_data[x],
							 "color": "#b0f054",					
							}
						
							sdata_rack.push(chartData1);	
							
						create_chart_rack(sdata_rack,div_name="chartContainer_rack1");	
				
						}		
					}	
				}
		
				},
				error: function(err, message, xx) {	}
			});

	//end
		
//pie chart

//pie_chart();
	$.ajax({
				url: '<?php echo base_url() ?>index.php/inventory/Count_ref_manager/icmdb_load_pie_chart',
				method: 'POST',
				data: {ds:c_date},
				success: function(data) {
					
				if(data.length>0){
				var parent = data.split('%');
					for(i=1;parent.length>i;i++){
					
					var child = parent[i].split('!');
			 var chartData =      	
					{  
					 "country":"Count "+child[0]+"s",
					 "visits":child[1],
									
					}
					sdata_pie.push(chartData)
			
					}
					pie_chart(sdata_pie);	
				}
				
				},
				error: function(err, message, xx) {	}
			});
}


function pie_chart(data){
	
//chartdiv_pie_chart
var chart = AmCharts.makeChart( "chartdiv_pie_chart", {
  "type": "pie",
  "theme": "light",
 
  "dataProvider":data ,
  "valueField": "visits",
  "titleField": "country",
  //"startEffect": "elastic",
  "startDuration": 2,
  "labelRadius": 15,
  "innerRadius": "20%",
  "depth3D": 10,
  "balloonText": "[[title]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>",
  "colors": [
	"#FF0F00",
	"#ffff00",
	"#4B0C25"
	],
 
  "radius": 115,
   "outlineAlpha": 0.4,
  "angle": 15,
  "export": {
    "enabled": true
  }
} );
}
function create_chart(chartData){

var chart = AmCharts.makeChart("chartContainer", {
    "theme": "light",
    "type": "serial",
	"startDuration": 2,
	"fontSize": 8,
    "dataProvider": chartData,
    "graphs": [{
        "balloonText": "[[category]]: <b>[[value]]</b>",
        "colorField": "color",
        "fillAlphas": 0.85,
        "lineAlpha": 0.1,
		"labelText":"  [[value]]%",
        "type": "column",
        "topRadius":1,
        "valueField": "visits"
    }],
    "depth3D": 30,
	"angle": 20,
    "chartCursor": {
        "categoryBalloonEnabled": true,
        "cursorAlpha": 0,
        "zoomable": false
    },    
    "categoryField": "country",
    "categoryAxis": {
        "gridPosition": "start",
        "axisAlpha":0,
        "gridAlpha":0,
         "labelRotation": 60
    },
    "export": {
    	"enabled": true
     }

},0);


}
function create_chart_rack1(chartData1,div_name){

var chart = AmCharts.makeChart(div_name, {
    "theme": "light",
    "type": "serial",
	"startDuration": 1,
    "dataProvider": chartData1,
    "graphs": [{
        "balloonText": "[[category]]: <b>[[value]]</b>",
        "fillColorsField": "color",
        "fillAlphas": 1,
        "lineAlpha": 0.1,
		"labelText":"[[value]]",
		"type": "column",
        "valueField": "visits",
		"autoGridCount": false,
		"gridCount":10
    }],
    "depth3D": 30,
	"angle": 50,
    "chartCursor": {
        "categoryBalloonEnabled": true,
        "cursorAlpha": 0,
        "zoomable": true
    },    
    "categoryField": "country",
    "categoryAxis": {
        "gridPosition": "start",
		"autoGridCount": true,
		"gridCount": "chartData.length",
        "labelRotation": 60
    },
    "export": {
    	"enabled": true
     }

});

}
function create_chart_rack(chartData,div_name){

var chart = AmCharts.makeChart(div_name, {
    "theme": "light",
    "type": "serial",
	"startDuration": 1,
    "dataProvider": chartData,
    "graphs": [{
        "balloonText": "[[category]]: <b>[[value]]</b>",
        "fillColorsField": "color",
        "fillAlphas": 1,
        "lineAlpha": 0.1,
		"labelText":"[[value]]",
		"type": "column",
        "valueField": "visits"
    }],
    "depth3D": 30,
	"angle": 50,
    "chartCursor": {
        "categoryBalloonEnabled": true,
        "cursorAlpha": 0,
        "zoomable": true
    },    
    "categoryField": "country",
    "categoryAxis": {
        "gridPosition": "start",
		"autoGridCount": true,
		"gridCount": "chartData.length",
        "labelRotation": 60
    },
    "export": {
    	"enabled": true
     }

});


//var chart = AmCharts.makeChart("chartContainer_rack", {
//	"type": "serial",
//     "theme": "light",
//	"categoryField": "year",
//	"rotate": true,
//	"startDuration": 1,
//	"categoryAxis": {
//		"gridPosition": "start",
//		"position": "left"
//	},
//	"trendLines": [],
//	"graphs": [
//		{
//			"balloonText": "Income:[[value]]",
//			"fillAlphas": 0.8,
//			"id": "AmGraph-1",
//			"lineAlpha": 0.2,
//			"labelText":"  [[value]]",
//			"title": "Income",
//			"type": "column",
//			"valueField": "income"
//		},
//		{
//			"balloonText": "Expenses:[[value]]",
//			"fillAlphas": 0.8,
//			"id": "AmGraph-2",
//			"lineAlpha": 0.2,
//			"labelText":"  [[value]]",
//			"title": "Expenses",
//			"type": "column",
//			"valueField": "expenses"
//		}
//	],
//	"guides": [],
//	"valueAxes": [
//		{
//			"id": "ValueAxis-1",
//			"position": "top",
//			"axisAlpha": 0
//		}
//	],
//	"allLabels": [],
//	"balloon": {},
//	"titles": [],
//	"dataProvider": [
//		{
//			"year": 'Locations',
//			"income": 15000,
//			"expenses": 120
//		},
//		{
//			"year": 'PIDs',
//			"income": 4000,
//			"expenses": 980
//		},
//		{
//			"year": 'Quantity',
//			"income": 200000,
//			"expenses": 12000
//		}
//	],
//    "export": {
//    	"enabled": true
//     }
//
//});
}

        $(".knob").knob({
    
          draw: function () {

            // "tron" case
            if (this.$.data('skin') == 'tron') {
	
              var a = this.angle(this.cv)  // Angle
                      , sa = this.startAngle          // Previous start angle
                      , sat = this.startAngle         // Start angle
                      , ea                            // Previous end angle
                      , eat = sat + a                 // End angle
                      , r = true;

              this.g.lineWidth = this.lineWidth;

              this.o.cursor
                      && (sat = eat - 0.3)
                      && (eat = eat + 0.3);

              if (this.o.displayPrevious) {
                ea = this.startAngle + this.angle(this.value);
				
                this.o.cursor
                        && (sa = ea - 0.3)
                        && (ea = ea + 0.3);
                this.g.beginPath();
                this.g.strokeStyle = this.previousColor;
                this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sa, ea, false);
                this.g.stroke();
              }

              this.g.beginPath();
              this.g.strokeStyle = r ? this.o.fgColor : this.fgColor;
              this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sat, eat, false);
              this.g.stroke();

              this.g.lineWidth = 2;
              this.g.beginPath();
              this.g.strokeStyle = this.o.fgColor;
              this.g.arc(this.xy, this.xy, this.radius - this.lineWidth + 1 + this.lineWidth * 2 / 3, 0, 2 * Math.PI, false);
              this.g.stroke();

              return false;
            }
          }
        });

</script>
