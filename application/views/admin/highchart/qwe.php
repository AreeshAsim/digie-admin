<script src="<?php echo ASSETS; ?>js/highcharts/highcharts.js"></script>
<script src="<?php echo ASSETS; ?>js/highcharts/series-label.js"></script>
<script src="<?php echo ASSETS; ?>js/highcharts/exporting.js"></script>
<script src="<?php echo ASSETS; ?>js/highcharts/export-data.js"></script>
<link href="<?php echo ASSETS ?>buyer_order/bootstrap-datetimepicker.css" rel="stylesheet">
<script src="<?php echo ASSETS ?>buyer_order/moment-with-locales.js"></script>
<script src="<?php echo ASSETS ?>buyer_order/bootstrap-datetimepicker.js"></script>
<style>
.sidebar.sidebar-inverse {
    z-index: 9999;
}
</style>
<div id="content">
  <!--<h1 class="content-heading bg-white border-bottom">coins</h1>-->
  <div class="innerAll bg-white border-bottom">
  <!--<ul class="menubar">
  <li class="active"><a href="<?php echo SURL; ?>/admin/coins">Coins</a></li>
  </ul>-->
  </div>
  <div class="innerAll spacing-x2">
	 <?php
if ($this->session->flashdata('err_message')) {
	?>
      <div class="alert alert-danger"><?php echo $this->session->flashdata('err_message'); ?></div>
      <?php
}
if ($this->session->flashdata('ok_message')) {
	?>
      <div class="alert alert-success alert-dismissable"><?php echo $this->session->flashdata('ok_message'); ?></div>
      <?php
}
?>

    <!-- Widget -->
    <div class="widget widget-inverse">

      <div class="widget-body padding-bottom-none">
        <!-- Table -->
        
        <!-- // Table END -->
			<div class="col-md-12 ">
            <form action="<?php  echo SURL ?>admin/highchart"  id="highchartform" enctype="multipart/form-data" method="post">
            
            <!--<div class="alert alert-warning fade in alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
    <strong>Alert!</strong> Please add the date range between two points  will be maximum 24 -30 hours.
</div>-->
              <div class="form-group col-md-1">
                <label class="control-label" for="hour"> No. with Price </label>
                
                
                 <input type='text' class="form-control mutiply_no_score" name="mutiply_no_score"  value="<?php echo $post_data['mutiply_no_score']; ?>" />
                
               
              </div>
              <div class="form-group col-md-1">
                <label class="control-label" for="hour"> No. Market  </label>
                
                 <input type='text' class="form-control mutiply_no_market" name="mutiply_no_market"  value="<?php echo $post_data['mutiply_no_market']; ?>" />
                
              </div>
              <div class="form-group col-md-1">
                <label class="control-label" for="hour"> - No. Price</label>
                
                 <input type='text' class="form-control minus_no_score" name="minus_no_score"  value="<?php echo $post_data['minus_no_score']; ?>" />
                
              </div>
              
              
              <div class="form-group col-md-1">
                <label class="control-label" for="hour">Select Coin </label>
                <select class="form-control coin" name="coin" id="coin">
                  <?php if($post_data['coin']==''){
				           $coinval  =  $global_symbol;
			            }else{
				           $coinval  =  $post_data['coin'];	
				        } ?>
                  <?php foreach($coins_arr as $coin){?>
                  <option value="<?php echo $coin['symbol']; ?>" <?php  echo ($coinval==$coin['symbol']) ? 'selected="selected"' : ''; ?>><?php echo $coin['symbol']; ?></option>
                  <?php }?>
                </select>
              </div>
              <div class="form-group col-md-1">
                <label class="control-label" for="coin">Time Duration</label>
                <select class="form-control time" name="time" id="time">
                  <option value="minut" <?php echo ($post_data['time']=='minut') ? 'selected="selected"' : ''; ?>> Minut</option>
                  <option value="hour" <?php echo ($post_data['time']=='hour') ? 'selected="selected"' : ''; ?>> Hour</option>
                <!--  <option value="day"   <?php echo ($post_data['time']=='day')   ? 'selected="selected"' : ''; ?>> Day</option>-->
                </select>
              </div>
              
              <div class="col-md-2">
                <div class="form-group col-md-12">
                  <label class="control-label">Start Date</label>
                  <input type='text' class="form-control datetime_picker" name="start_date" placeholder="Search By Start Date" value="<?php echo $startDate; ?>" />
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group col-md-12">
                  <label class="control-label">End Date</label>
                  <input type='text' class="form-control datetime_picker" name="end_date" placeholder="Search By End Date" value="<?php echo $endDate ; ?>" />
                </div>
              </div>
              <script type="text/javascript">
                        $(function () {
                            $('.datetime_picker').datetimepicker();
                        });
                    </script>
              <div class="form-group col-md-2">
                <div class="row">
                  <div class="col-xs-5">
                    <label for="comment" class="col-md-1">&nbsp;</label>
                    <input type="submit" class="btn btn-success btn-block btn-sm " value="Refresh">
                    <button type="button" class="btn btn-success btn-block btn-sm wait_run_ajax" style="display: none;"><i class="fa fa-spinner fa-spin" style="font-size:24px"></i></button>
                  </div>
                </div>
              </div>
            </form>
          </div>
          
          <div class="clearfix"></div>
          
            <div id="container"></div>
            
             <div class="clearfix"></div>



      </div>
    </div>
    <!-- // Widget END -->

  </div>
</div>

<script type="text/javascript">

 
	
<!--- On chnage trigger tyepe  -------->
/*	
var black_wall_pressure  = '<?php echo $black_wall_pressure ; ?>';
var yellow_wall_pressure = '<?php echo '['.$yellow_wall_pressure.']'; ?>';
var pressure_diff        = '<?php echo '['.$pressure_diff.']'; ?>';
var great_wall_price     = '<?php echo '['.$great_wall_price.']'; ?>';
var seven_level_depth    = '<?php echo '['.$seven_level_depth.']'; ?>';
var score                = '<?php echo '['.$score.']'; ?>';
var last_qty_time_ago    = '<?php echo '['.$last_qty_time_ago.']'; ?>';
var last_200_time_ago    = '<?php echo '['.$last_200_time_ago.']'; ?>';
var current_market_value = '<?php echo '['.$current_market_value.']'; ?>';*/


function load_hight_chart(black_wall_pressure,yellow_wall_pressure,pressure_diff,great_wall_price,seven_level_depth,score,last_qty_time_ago,last_200_time_ago,current_market_value){
	
	
	Highcharts.setOptions({
    time: {
        timezone: 'America/New_York'
    }
});

	<?php if($time =='minut'){ $MmnutHour = 60; $formate =  'h:i A';}else{$MmnutHour = 3600; $formate =  'd M Y H:i:s';} ?>
	
	Highcharts.chart('container', {
		
		
		time: {
             timezone: 'America/New_York'
        },
	
		title: {
			text: 'Show the data of last <b> <?php echo $totalHours; ?> </b> <?php echo ucfirst($time).'s';?> over the graph .'
		},
		width: 300,
			height: 200,
	
		subtitle: {
			text: ''
		},
		
		/* tooltip: {
			xDateFormat: '%Y-%m-%d %H:%M',
			pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y:.2f}</b><br/>'
        },*/
		
		
		
		
		
		
		
		
		
		
		
		xAxis: {
	
							gridLineColor: '#e5eaee',
							lineColor: '#e5eaee',
							tickColor: '#e5eaee',
							title:{ text:'Current Time Zone : <?php echo date_default_timezone_get();?>    Current Chart : <?php echo ucfirst($time).'s';?> '},
							categories: [
							
							<?php 
							$i=0; 
							
							$recent_count  =  $totalHours;
							for ($x = 1; $x <= $totalHours; $x++) {
								
								$currentDateTime = $startDate;
								$end_dateA       = date('m/d/Y h:i A', strtotime($currentDateTime));
								$second          = strtotime($currentDateTime) + ($x * $MmnutHour);
								$end_dateB       = date($formate, ($second));
							?>            
							'<?php echo $end_dateB; ?>'
							
							<?php 
							 if(++$i === $recent_count){}else{ ?>,<?php }
							} ?>
                                 	
							]
						},
	
		yAxis: {
			title: {
				text: ''
			},
			 min: -10,
				minRange: 1,
				 tickInterval: 1,
		},
		legend: {
			layout: 'vertical',
			align: 'right',
			verticalAlign: 'middle'
		},
	
		plotOptions: {
			series: {
				label: {
					connectorAllowed: false
				},
				pointStart: 0
			}
		},
		 chart: {
			renderTo: 'chart',
			
			width: 5000,
			height: 600,
			
		},    

	
		series: [ {
			name: 'Black Wall Pressure'+'  <?php echo date_default_timezone_get();?> '+'</br>',
			data: [<?php echo $black_wall_pressure ; ?>]
			
		}, {
			name: 'Pressure Difference',
			data: [<?php echo $pressure_diff ; ?>]
		}, {
			name: 'Great Wall Price',
			data: [<?php echo $great_wall_price ; ?>]
		}, {
		   name: 'Seven Level Pressure',
			data: [<?php echo $seven_level_depth ; ?>]
		}, {
		   name: 'Score ',
			data: [<?php echo $score ; ?>]
		}, {
		   name: 'Yellow Wall Pressure',
			data: [<?php echo $yellow_wall_pressure ; ?>]
		}, {
		   name: 'Current Market Value',
			data: [<?php echo $current_market_value ; ?>]
		}],
	
		responsive: {
			rules: [{
				condition: {
					maxWidth: 500
				},
				chartOptions: {
					legend: {
						layout: 'horizontal',
						align: 'center',
						verticalAlign: 'bottom'
					}
				}
			}]	
		}
	});	
	
	// Use the Time object
console.log(
       'Current time in New York',
       chart.time.dateFormat('%Y-%m-%d %H:%M:%S', Date.now())
);


}

black_wall_pressure='';
yellow_wall_pressure='';
pressure_diff='';
great_wall_price='';
seven_level_depth='';
score='';
last_qty_time_ago='';
last_200_time_ago='';
current_market_value='';

load_hight_chart(black_wall_pressure,yellow_wall_pressure,pressure_diff,great_wall_price,seven_level_depth,score,last_qty_time_ago,last_200_time_ago,current_market_value);
//var chart = new Highcharts.Chart(options);
</script>
