<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Highchart extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		//load main template
		$this->stencil->layout('admin_layout');

		//load required slices
		$this->stencil->slice('admin_header_script');
		$this->stencil->slice('admin_header');
		$this->stencil->slice('admin_left_sidebar');
		$this->stencil->slice('admin_footer_script');
		
		// Load Modal
		$this->load->model('admin/mod_login');
		$this->load->model('admin/mod_sockets');
		$this->load->model('admin/mod_highchart');

	}

 
	public function index() {
		
		//Login Check
		$this->mod_login->verify_is_admin_login();
		
		$all_coins_arr = $this->mod_sockets->get_all_coins();
		$time          = $this->input->post('time');
		$price_format  = $this->input->post('price_format');
		if($price_format==''){
			$price_format = 1000000;
		}else{
			$price_format = $price_format;
		}
		$timezone      = $this->session->userdata('timezone');
		
		if( $this->input->post() ) {
             $this->session->set_userdata( array(
            'page_post_data' => $this->input->post(),
            )); 
		}
		if( $this->input->post('clear')=='clear' ) {
             $this->session->unset_userdata( array(
            'page_post_data' => $this->input->post(),
            )); 
		}
				
		if($time==''){ $time='minut';}else{$time  = $time ;}
		
		$global_symbol = $this->session->userdata('global_symbol');
		
		if($this->input->post('coin')==''){
		    $coinval  =  $global_symbol;
	    }else{
			$coinval  =  $this->input->post('coin');	
		}
		//Fetching users Record
		if($this->input->post('mutiply_no_score')==''){
			$mutiply_no_score = 1;  
		}else{
			$mutiply_no_score = $this->input->post('mutiply_no_score');  
		}
		if($this->input->post('mutiply_no_market')==''){
			$mutiply_no_market = 1;  
		}else{
			$mutiply_no_market = $this->input->post('mutiply_no_market');  
		}
		
		if($this->input->post('minus_no_score')==''){
			$minus_no_score = 0;  
		}else{
			$minus_no_score = $this->input->post('minus_no_score');  
		}
		if($this->input->post('start_date')!='' && $this->input->post('end_date')==''){
			$this->session->set_flashdata('err_message', 'Please add the End date .');
			redirect(base_url() . 'admin/highchart');
		}
		if($this->input->post('start_date')=='' && $this->input->post('end_date')!=''){
			$this->session->set_flashdata('err_message', 'Please add the Start date .');
			redirect(base_url() . 'admin/highchart');
		}
		
		if($this->input->post('start_date')!=''  && $this->input->post('end_date')!='' && $time=='hour'){
			
		  
		    $start_dateOrg  = $this->input->post('start_date');
			$newDateTime    = $this->input->post('start_date');
			
			// convert date and time to seconds 
			$start_date = strtotime($start_dateOrg); 
			// convert seconds into a specific format 
			$start_dateGG = date("Y-m-d G:i:00", $start_date); 
			// convert date and time to seconds 
			$lastHour   = $start_date + 3600; 	
			// convert seconds into a specific format 
			$endDateHour = date("Y-m-d G:00:00", $lastHour); 	
			// ********************************** ENd date ********************************//
		    $end_dateA    = $this->input->post('end_date');
			// convert date and time to seconds 
			$end_date = strtotime($end_dateA); 
			// convert seconds into a specific format 
			$end_date = date("Y-m-d G:i:s", $end_date); 
		
		    $start_dateNew   =  $this->input->post('start_date');
			$end_dateNew     =  $this->input->post('end_date');
		    $starttimestamp  =  strtotime($start_dateNew);
			$endtimestamp    =  strtotime($end_dateNew);
			$difference      =  abs($endtimestamp - $starttimestamp)/3600 ;
			$totalHours      =  $difference;
			
			$z= 1; 
			for ($x = 1; $x <= $totalHours; $x++) {

				$new        = 3600;  
				$seconds    = 3600;  
				$finale     = $seconds*$x;
				$finaleIst  = $finale-$seconds;				
				// convert date and time to seconds 
				$start_dateStratOtime = strtotime($start_dateGG); 
				//$start_dateStratOtimeOne = strtotime($start_dateGG)+ $zk ; 
				$finalTimeSecond      = $start_dateStratOtime + $finale ; 
				// convert seconds into a specific format 
				$start_dateGGNew = date("Y-m-d G:00:00", $start_dateStratOtime +$finale); 
				// convert seconds into a specific format 
				$endDateHour = date("Y-m-d G:00:00", $finalTimeSecond); 
				
				$dt = new DateTime($start_dateGGNew, new DateTimeZone($timezone));
				$dt->setTimezone(new DateTimeZone('UTC'));
				$start_dateGGNew = $dt->format('Y-m-d H:i:s');
				
				$dt = new DateTime($endDateHour, new DateTimeZone($timezone));
				$dt->setTimezone(new DateTimeZone('UTC'));
				$endDateHour = $dt->format('Y-m-d H:i:s');
				
					
				
			  $ChartData_arr = $this->mod_highchart->getChartDataHours($coinval,$time='hour',$start_dateGGNew,$endDateHour,$mutiply_no_score,$mutiply_no_market,$totalHours,$minus_no_score,$price_format);
			  $fianalArr[] = $ChartData_arr;
			  $z++;
			}
			
		}else if($this->input->post('start_date')==''  && $this->input->post('end_date')=='' && $time=='hour'){
			
			
			// From Current date time and get the value 
			$timezone         = $this->session->userdata('timezone');
			date_default_timezone_set($timezone );
			$currentDateTime=date('m/d/Y H:i:s');
			$end_dateA = date('m/d/Y h:i A', strtotime($currentDateTime));
			
		    $start_dateOrg  = $end_dateA;
			// convert date and time to seconds 
			$start_date   = strtotime($start_dateOrg); 
			// convert seconds into a specific format 
			$start_dateGG = date("Y-m-d G:i:00", $start_date); 
			// convert date and time to seconds 
			$lastHour     = $start_date + 3600; 	
			// convert seconds into a specific format 
			$endDateHour  = date("Y-m-d G:00:00", $lastHour); 	
			// ********************************** ENd date ********************************//
		    $newDateTime     =  date('m/d/Y h:i A', strtotime('-1 days'));
			// convert date and time to seconds 
			$end_date = strtotime($newDateTime); 
			// convert seconds into a specific format 
			$end_date = date("Y-m-d G:i:s", $end_date); 
		
			$starttimestamp  =  strtotime($end_dateA);
			$endtimestamp    =  strtotime($newDateTime); //paroon
			$difference      =  abs($endtimestamp - $starttimestamp)/3600 ;
			$totalHours      =  $difference;
			
			$z= 1; 
			for ($x = 1; $x <= $totalHours; $x++) {

				$new        = 3600;  
				$seconds    = 3600;  
				$finale     = $seconds*$x;
				$finaleIst  = $finale-$seconds;				
				// convert date and time to seconds 
				$start_dateStratOtime = strtotime($start_dateGG); 
				//$start_dateStratOtimeOne = strtotime($start_dateGG)+ $zk ; 
				$finalTimeSecond      = $start_dateStratOtime + $finale ; 
				// convert seconds into a specific format 
				$start_dateGGNew = date("Y-m-d G:00:00", $start_dateStratOtime +$finale); 
				// convert seconds into a specific format 
				$endDateHour = date("Y-m-d G:00:00", $finalTimeSecond); 	
				
			  $ChartData_arr = $this->mod_highchart->getChartDataHours($coinval,$time='hour',$start_dateGGNew,$endDateHour,$mutiply_no_score,$mutiply_no_market,$totalHours,$minus_no_score,$price_format);
			  $fianalArr[] = $ChartData_arr;
			  $z++;
			} 	
			
		}
		
	
		
		if($this->input->post('start_date')!=''  && $this->input->post('end_date')!='' && $time=='minut'){
			
			
			
			
		 
		    $start_dateOrg  = $this->input->post('start_date');
			$newDateTime    = $this->input->post('start_date');
			
			
			
			// convert date and time to seconds 
			$start_date = strtotime($start_dateOrg); 
			// convert seconds into a specific format 
			$start_dateGG = date("Y-m-d H:i:00", $start_date); 
			// convert date and time to seconds 
			$lastHour   = $start_date + 3600; 	
			// convert seconds into a specific format 
			$endDateHour = date("Y-m-d H:00:00", $lastHour); 	
			// ********************************** ENd date ********************************//
		    $end_dateA    = $this->input->post('end_date');
			// convert date and time to seconds 
			$end_date = strtotime($end_dateA); 
			// convert seconds into a specific format 
			$end_date = date("Y-m-d h:i:s", $end_date); 
		
		    $start_dateNew   =  $this->input->post('start_date');
			$end_dateNew     =  $this->input->post('end_date');
		    $starttimestamp  =  strtotime($start_dateNew);
			$endtimestamp    =  strtotime($end_dateNew);
			$difference      =  abs($endtimestamp - $starttimestamp)/3600 * 60;
			$totalHours      =  $difference;
			
			
			$z= 1; 
			for ($x = 1; $x <= $totalHours; $x++) {

				$new        = 60;  
				$seconds    = 60;  
				$finale     = $seconds*$x;
				$finaleIst  = $finale-$seconds;				
				// convert date and time to seconds 
				$start_dateStratOtime = strtotime($start_dateGG); 
				//$start_dateStratOtimeOne = strtotime($start_dateGG)+ $zk ; 
				$finalTimeSecond      = $start_dateStratOtime + $finale ; 
				// convert seconds into a specific format 
				$start_dateGGNew = date("Y-m-d h:i:00", $start_dateStratOtime +$finale); 
				// convert seconds into a specific format 
				$endDateHour = date("Y-m-d h:i:00", $finalTimeSecond); 	
				
				$dt = new DateTime($start_dateGGNew, new DateTimeZone($timezone));
				$dt->setTimezone(new DateTimeZone('UTC'));
				$start_dateGGNew = $dt->format('Y-m-d H:i:s');
				
				$dt = new DateTime($endDateHour, new DateTimeZone($timezone));
				$dt->setTimezone(new DateTimeZone('UTC'));
				$endDateHour = $dt->format('Y-m-d H:i:s');
				
				
				
				
				
			  $ChartData_arr = $this->mod_highchart->getChartDataHours($coinval,$time='minut',$start_dateGGNew,$endDateHour,$mutiply_no_score,$mutiply_no_market,$totalHours,$minus_no_score,$price_format);
			  $fianalArr[] = $ChartData_arr;
			  $z++;
			}
			//exit;
		}	
		else if($this->input->post('start_date')==''  && $this->input->post('end_date')=='' && $time=='minut'){
			
			// Get date from current date and time 
			$timezone         = $this->session->userdata('timezone');
			//date_default_timezone_set($timezone );
			$currentDateTime = date('m/d/Y H:i:s');
			$end_dateA       = date('m/d/Y h:00 A', strtotime($currentDateTime));
		 
		    $start_dateOrg   = $end_dateA;
			// convert date and time to seconds 
			$start_date      = strtotime($start_dateOrg); 
			// convert seconds into a specific format 
			$start_dateGG    = date("Y-m-d G:i:00", $start_date); 
			// convert date and time to seconds 
			$lastHour        = $start_date + 3600; 	
			// convert seconds into a specific format 
			$endDateHour     = date("Y-m-d G:00:00", $lastHour); 	
			// ********************************** ENd date ********************************//
		    $newDateTime     = date('m/d/Y h:00 A', strtotime('-2 hours'));
			// convert date and time to seconds 
			$end_date        = strtotime($newDateTime); 
			// convert seconds into a specific format 
			$end_date = date("Y-m-d G:i:s", $end_date); 
		    $starttimestamp  =  strtotime($end_dateA);
			$endtimestamp    =  strtotime($newDateTime); //paroon
			$difference      =  abs($endtimestamp - $starttimestamp)/3600 * 60;
			$totalHours      =  $difference;
			
			$z= 1; 
			for ($x = 1; $x <= $totalHours; $x++) {

				$new        = 60;  
				$seconds    = 60;  
				$finale     = $seconds*$x;
				$finaleIst  = $finale-$seconds;				
				// convert date and time to seconds 
				$start_dateStratOtime = strtotime($end_date); 
				//$start_dateStratOtimeOne = strtotime($start_dateGG)+ $zk ; 
				$finalTimeSecond      = $start_dateStratOtime + $finale ; 
				// convert seconds into a specific format 
				$start_dateGGNew = date("Y-m-d G:i:00", $start_dateStratOtime +$finale); 
				// convert seconds into a specific format 
				$endDateHour = date("Y-m-d G:i:00", $finalTimeSecond); 	
				
				//if($x==100){
			      $ChartData_arr = $this->mod_highchart->getChartDataHours($coinval,$time='minut',$start_dateGGNew,$endDateHour,$mutiply_no_score,$mutiply_no_market,$totalHours,$minus_no_score,$price_format);
			      $fianalArr[] = $ChartData_arr;
				//}
			  $z++;
			}
		}	
		//echo "<pre>";  print_r($fianalArr); exit;
		$data['chart_arr']      = $fianalArr;
		$black_wall_pressure    = array();
		$yellow_wall_pressure   = array();
		$pressure_diff          = array();
		$great_wall_price       = array();
		$seven_level_depth      = array();
		$score                  = array();
		$straightline           = array();
		$current_market_value   = array();
		$last_qty_time_agoArr   = array();
		$last_200_time_agoArr   = array();
		$last_200_time_agoArr   = array();
		$market_depth_quantity  = array();
		
	    foreach($data['chart_arr']  as $data){
			
				$last_qty_time_agoNew     = $data['last_qty_time_agoNew'];
				$last_200_time_agoNew     = $data['last_200_time_agoNew'];
				$black_wall_pressureNew   = $data['black_wall_pressure'];
				$yellow_wall_pressureNew  = $data['yellow_wall_pressure'];
				$pressure_diffNew         = $data['pressure_diff'];
				$seven_level_depthNew     = $data['seven_level_depth'];
				$scoreNew                 = $data['score'];
				$straightlineNew          = $data['straightline'];
				$great_wall_priceNew      = num($data['great_wall_priceArr']);
				$current_market_valueNew  = num($data['current_market_value']);
				$datetimeNew              = $data['datetime'];
				$market_depth_quantityNw  = $data['market_depth_quantity'];
				$market_depth_quantityNw  = round($market_depth_quantityNw,2);
				
				array_push($last_qty_time_agoArr, $last_qty_time_agoNew);
				array_push($last_200_time_agoArr, $last_200_time_agoNew);
				array_push($black_wall_pressure,  $black_wall_pressureNew);
			
				array_push($yellow_wall_pressure, $yellow_wall_pressureNew);
				array_push($pressure_diff,        $pressure_diffNew);
				array_push($seven_level_depth,    $seven_level_depthNew);
				array_push($score,                $scoreNew);
				array_push($straightline,         $straightlineNew);
				
				array_push($great_wall_price,     $great_wall_priceNew);
				array_push($current_market_value, $current_market_valueNew);	
				array_push($market_depth_quantity,$market_depth_quantityNw);	
				
	    }
		
		    //echo "<pre>";  print_r($market_depth_quantity); exit;
		
			$data['last_qty_time_ago']       =  implode(', ', $last_qty_time_agoArr);
			$data['last_200_time_ago']       =  implode(', ', $last_200_time_agoArr);
			$data['black_wall_pressure']     =  implode(', ', $black_wall_pressure);
			$data['yellow_wall_pressure']    =  implode(', ', $yellow_wall_pressure);
			$data['pressure_diff']           =  implode(', ', $pressure_diff);
			$data['great_wall_price']        =  implode(', ', $great_wall_price);
			$data['seven_level_depth']       =  implode(', ', $seven_level_depth);
			$data['score']                   =  implode(', ', $score);
			$data['current_market_value']    =  implode(', ', $current_market_value);
			$data['market_depth_quantity']   =  implode(', ', $market_depth_quantity);
			$data['straightline         ']   =  implode(', ', $straightline);
			
			$data['market_depth_quantity']   =  $data['market_depth_quantity'];
			$data['coins_arr']               =  $all_coins_arr;
			$data['global_symbol']           =  $global_symbol;
		    $data['post_data']               =  $this->input->post();
			$data['startDate']               =  $newDateTime;
			$data['endDate']                 =  $end_dateA;
			$data['totalHours']              =  $totalHours;
			$data['time']                    =  $time;
			
			if($price_format=='1000'){ $prc_formate  =  ' K+'; } else if($price_format=='10000'){$prc_formate  =  ' 10 K+'; }else if($price_format=='100000'){$prc_formate  =  ' 100 K+'; }
			else if($price_format=='1000000'){$prc_formate  =  ' 1 M+'; }
			
			$data['price_format']            =  $prc_formate;
			$data['timezone']                =  $this->session->userdata('timezone');
			
			//echo $data['price_format'] ; exit;
		
		//stencil is our templating library. Simply call view via it
		$this->stencil->paint('admin/highchart/highchart', $data);

	} //End index
	
	
	public function report() {
		
		//Login Check
		$this->mod_login->verify_is_admin_login();
		
		$all_coins_arr = $this->mod_sockets->get_all_coins();
		$time          = $this->input->post('time');
		$price_format  = $this->input->post('price_format');
		
		if($price_format==''){
			$price_format = 1000000;
		}else{
			$price_format = $price_format;
		}
		$timezone      = $this->session->userdata('timezone');
		
		if( $this->input->post() ) {
             $this->session->set_userdata( array(
            'page_post_data' => $this->input->post(),
            )); 
		}
		if( $this->input->post('clear')=='clear' ) {
			
			 $this->session->unset_userdata('page_post_data');
             $this->session->unset_userdata( array(
            'page_post_data' => $this->input->post(),
            )); 
		}
		
				
		if($time==''){ $time='minut';}else{$time  = $time ;}
		
		$global_symbol = $this->session->userdata('global_symbol');
		
		if($this->input->post('coin')==''){
		    $coinval  =  $global_symbol;
	    }else{
			$coinval  =  $this->input->post('coin');	
		}
		//Fetching users Record
		if($this->input->post('mutiply_no_score')==''){
			$mutiply_no_score = 1;  
		}else{
			$mutiply_no_score = $this->input->post('mutiply_no_score');  
		}
		if($this->input->post('mutiply_no_market')==''){
			$mutiply_no_market = 1;  
		}else{
			$mutiply_no_market = $this->input->post('mutiply_no_market');  
		}
		
		if($this->input->post('minus_no_score')==''){
			$minus_no_score = 0;  
		}else{
			$minus_no_score = $this->input->post('minus_no_score');  
		}
		if($this->input->post('start_date')!='' && $this->input->post('end_date')==''){
			$this->session->set_flashdata('err_message', 'Please add the End date .');
			redirect(base_url() . 'admin/highchart');
		}
		if($this->input->post('start_date')=='' && $this->input->post('end_date')!=''){
			$this->session->set_flashdata('err_message', 'Please add the Start date .');
			redirect(base_url() . 'admin/highchart');
		}
		
		if($this->input->post('start_date')!=''  && $this->input->post('end_date')!='' && $time=='hour'){
			
		  
		   $start_dateOrg  = $this->input->post('start_date');
			
			$newDateTime    = $this->input->post('start_date');
			
			// convert date and time to seconds 
			$start_date = strtotime($start_dateOrg); 
			// convert seconds into a specific format 
			$start_dateGG = date("Y-m-d G:i:00", $start_date); 
			// convert date and time to seconds 
			$lastHour   = $start_date + 3600; 	
			// convert seconds into a specific format 
			$endDateHour = date("Y-m-d G:00:00", $lastHour); 	
			// ********************************** ENd date ********************************//
		    $end_dateA    = $this->input->post('end_date');
			
			// convert date and time to seconds 
			$end_date = strtotime($end_dateA); 
			// convert seconds into a specific format 
			$end_date = date("Y-m-d G:i:s", $end_date); 
		
		    $start_dateNew   =  $this->input->post('start_date');
			$end_dateNew     =  $this->input->post('end_date');
		    $starttimestamp  =  strtotime($start_dateNew);
			$endtimestamp    =  strtotime($end_dateNew);
			$difference      =  abs($endtimestamp - $starttimestamp)/3600 ;
			$totalHours      =  $difference;
			
			$z= 1; 
			for ($x = 0; $x <= $totalHours; $x++) {

				$new        = 3600;  
				$seconds    = 3600;  
				$finale     = $seconds*$x;
				$finaleIst  = $finale-$seconds;				
				// convert date and time to seconds 
				$start_dateStratOtime = strtotime($start_dateGG); 
				//$start_dateStratOtimeOne = strtotime($start_dateGG)+ $zk ; 
				$finalTimeSecond      = $start_dateStratOtime + $finale ; 
				// convert seconds into a specific format 
				$start_dateGGNew = date("Y-m-d G:00:00", $start_dateStratOtime +$finale); 
				
				// convert seconds into a specific format 
				$endDateHour = date("Y-m-d G:00:00", $finalTimeSecond); 
				
				$dt = new DateTime($start_dateGGNew, new DateTimeZone($timezone));
				$dt->setTimezone(new DateTimeZone('UTC'));
				$start_dateGGNew = $dt->format('Y-m-d H:i:s');
				
				$dt = new DateTime($endDateHour, new DateTimeZone($timezone));
				$dt->setTimezone(new DateTimeZone('UTC'));
				$endDateHour = $dt->format('Y-m-d H:i:s');
				
			  $ChartData_arr = $this->mod_highchart->getChartDataHours($coinval,$time='hour',$start_dateGGNew,$endDateHour,$mutiply_no_score,$mutiply_no_market,$totalHours,$minus_no_score,$price_format);
			  
			  if(!empty($ChartData_arr)){
			   $fianalArr[] = $ChartData_arr;
			  }
			  $z++;
			}
			
		}else if($this->input->post('start_date')==''  && $this->input->post('end_date')=='' && $time=='hour'){
			
			
			// From Current date time and get the value 
			$timezone         = $this->session->userdata('timezone');
			date_default_timezone_set($timezone );
			$currentDateTime=date('m/d/Y H:i:s');
			$end_dateA = date('m/d/Y h:i A', strtotime($currentDateTime));
			
		    $start_dateOrg  = $end_dateA;
			// convert date and time to seconds 
			$start_date   = strtotime($start_dateOrg); 
			// convert seconds into a specific format 
			$start_dateGG = date("Y-m-d G:i:00", $start_date); 
			// convert date and time to seconds 
			$lastHour     = $start_date + 3600; 	
			// convert seconds into a specific format 
			$endDateHour  = date("Y-m-d G:00:00", $lastHour); 	
			// ********************************** ENd date ********************************//
		    $newDateTime     =  date('m/d/Y h:i A', strtotime('-1 days'));
			// convert date and time to seconds 
			$end_date = strtotime($newDateTime); 
			// convert seconds into a specific format 
			$end_date = date("Y-m-d G:i:s", $end_date); 
		
			$starttimestamp  =  strtotime($end_dateA);
			$endtimestamp    =  strtotime($newDateTime); //paroon
			$difference      =  abs($endtimestamp - $starttimestamp)/3600 ;
			$totalHours      =  $difference;
			
			$z= 1; 
			for ($x = 1; $x <= $totalHours; $x++) {

				$new        = 3600;  
				$seconds    = 3600;  
				$finale     = $seconds*$x;
				$finaleIst  = $finale-$seconds;				
				// convert date and time to seconds 
				$start_dateStratOtime = strtotime($start_dateGG); 
				//$start_dateStratOtimeOne = strtotime($start_dateGG)+ $zk ; 
				$finalTimeSecond      = $start_dateStratOtime + $finale ; 
				// convert seconds into a specific format 
				$start_dateGGNew = date("Y-m-d G:00:00", $start_dateStratOtime +$finale); 
				// convert seconds into a specific format 
				$endDateHour = date("Y-m-d G:00:00", $finalTimeSecond); 	
				
			  $ChartData_arr = $this->mod_highchart->getChartDataHours($coinval,$time='hour',$start_dateGGNew,$endDateHour,$mutiply_no_score,$mutiply_no_market,$totalHours,$minus_no_score,$price_format);
			  if(!empty($ChartData_arr)){
			   $fianalArr[] = $ChartData_arr;
			  }
			  $z++;
			} 	
			
		}
		
	
		
		if($this->input->post('start_date')!=''  && $this->input->post('end_date')!='' && $time=='minut'){
			
		 
		    $start_dateOrg  = $this->input->post('start_date');
			$newDateTime    = $this->input->post('start_date');
			// echo "<br />";
			// convert date and time to seconds 
			$start_date = strtotime($start_dateOrg); 
			// convert seconds into a specific format 
			$start_dateGG = date("Y-m-d G:i:00", $start_date); 
			// convert date and time to seconds 
			$lastHour   = $start_date + 3600; 	
			// convert seconds into a specific format 
			$endDateHour = date("Y-m-d G:i:00", $lastHour); 	
			// ********************************** ENd date ********************************//
		    $end_dateA    = $this->input->post('end_date');
			//echo "<br />";
			// convert date and time to seconds 
			$end_date = strtotime($end_dateA); 
			// convert seconds into a specific format 
			$end_date = date("Y-m-d h:i:s", $end_date); 
		
		    $start_dateNew   =  $this->input->post('start_date');
			$end_dateNew     =  $this->input->post('end_date');
		    $starttimestamp  =  strtotime($start_dateNew);
			$endtimestamp    =  strtotime($end_dateNew);
			$difference      =  abs($endtimestamp - $starttimestamp)/3600 ;
			$difference      =  $difference * 60; 
			$totalHours      =  $difference;
			
			$z= 1; 
			for ($x = 1; $x <= $totalHours; $x++) {
                
				$new        = 60; 
				$seconds    = 60;
				$hourVal    = 3600; 	
				$finale     = $seconds * $x ;
				$finaleIst  = $finale-$seconds;				
				$finalTimeSecond = '';
				// convert date and time to seconds 
				$start_dateStratOtime = strtotime($start_dateGG); 
				//$start_dateStratOtimeOne = strtotime($start_dateGG)+ $zk ; 
				$finalTimeSecond      = $start_dateStratOtime + $finale ; 
				// convert seconds into a specific format 
				$start_dateGGNew = date("Y-m-d H:i:00", $finalTimeSecond); 
				// convert seconds into a specific format 
				$endDateHour = date("Y-m-d H:i:00", $finalTimeSecond); 	
				
				
				$dt1 = new DateTime($start_dateGGNew, new DateTimeZone($timezone));
				$dt1->setTimezone(new DateTimeZone('UTC'));
				$start_dateGGNew1 = $dt1->format('Y-m-d H:i:s');
				
				$dt2 = new DateTime($endDateHour, new DateTimeZone($timezone));
				$dt2->setTimezone(new DateTimeZone('UTC'));
				$endDateHour2 = $dt2->format('Y-m-d H:i:s');
				
			  $ChartData_arr = $this->mod_highchart->getChartDataHours($coinval,$time='minut',$start_dateGGNew1,$endDateHour2,$mutiply_no_score,$mutiply_no_market,$totalHours,$minus_no_score,$price_format);
			  if(!empty($ChartData_arr)){
			   $fianalArr[] = $ChartData_arr;
			  }
			  $z++;
			}
			//exit;
		}	
		else if($this->input->post('start_date')==''  && $this->input->post('end_date')=='' && $time=='minut'){
			
			// Get date from current date and time 
			$timezone         = $this->session->userdata('timezone');
			//date_default_timezone_set($timezone );
			$currentDateTime = date('m/d/Y H:i:s');
			$end_dateA       = date('m/d/Y h:00 A', strtotime($currentDateTime));
		 
		    $start_dateOrg   = $end_dateA;
			// convert date and time to seconds 
			$start_date      = strtotime($start_dateOrg); 
			// convert seconds into a specific format 
			$start_dateGG    = date("Y-m-d G:i:00", $start_date); 
			// convert date and time to seconds 
			$lastHour        = $start_date + 3600; 	
			// convert seconds into a specific format 
			$endDateHour     = date("Y-m-d G:00:00", $lastHour); 	
			// ********************************** ENd date ********************************//
		    $newDateTime     = date('m/d/Y h:00 A', strtotime('-2 hours'));
			// convert date and time to seconds 
			$end_date        = strtotime($newDateTime); 
			// convert seconds into a specific format 
			$end_date = date("Y-m-d G:i:s", $end_date); 
		    $starttimestamp  =  strtotime($end_dateA);
			$endtimestamp    =  strtotime($newDateTime); //paroon
			$difference      =  abs($endtimestamp - $starttimestamp)/3600 * 60;
			$totalHours      =  $difference;
			
			$z= 1; 
			for ($x = 1; $x <= $totalHours; $x++) {

				$new        = 60;  
				$seconds    = 60;  
				$finale     = $seconds*$x;
				$finaleIst  = $finale-$seconds;				
				// convert date and time to seconds 
				$start_dateStratOtime = strtotime($end_date); 
				//$start_dateStratOtimeOne = strtotime($start_dateGG)+ $zk ; 
				$finalTimeSecond      = $start_dateStratOtime + $finale ; 
				// convert seconds into a specific format 
				$start_dateGGNew = date("Y-m-d G:i:00", $start_dateStratOtime +$finale); 
				// convert seconds into a specific format 
				$endDateHour = date("Y-m-d G:i:00", $finalTimeSecond); 	
				
				//if($x==100){
			      $ChartData_arr = $this->mod_highchart->getChartDataHours($coinval,$time='minut',$start_dateGGNew,$endDateHour,$mutiply_no_score,$mutiply_no_market,$totalHours,$minus_no_score,$price_format);
			  if(!empty($ChartData_arr)){
			   $fianalArr[] = $ChartData_arr;
			  }
				//}
			  $z++;
			}
		}	
		
		//echo "<pre>";  print_r($fianalArr); exit;
		$data['chart_arr']      = $fianalArr;
		$black_wall_pressure    = array();
		$yellow_wall_pressure   = array();
		$pressure_diff          = array();
		$great_wall_price       = array();
		$seven_level_depth      = array();
		$score                  = array();
		$straightline           = array();
		$current_market_value   = array();
		$last_qty_time_agoArr   = array();
		$last_200_time_agoArr   = array();
		$last_200_time_agoArr   = array();
		$market_depth_quantity  = array();
		$market_depth_ask       = array();
		
	    foreach($data['chart_arr']  as $data){
			
				$last_qty_time_agoNew     = $data['last_qty_time_agoNew'];
				$last_200_time_agoNew     = $data['last_200_time_agoNew'];
				$black_wall_pressureNew   = $data['black_wall_pressure'];
				$yellow_wall_pressureNew  = $data['yellow_wall_pressure'];
				$pressure_diffNew         = $data['pressure_diff'];
				$seven_level_depthNew     = $data['seven_level_depth'];
				$scoreNew                 = $data['score'];
				$straightlineNew          = $data['straightline'];
				$great_wall_priceNew      = $data['great_wall_priceArr'];
				$current_market_valueNew  = $data['current_market_value'];
				$datetimeNew              = $data['datetime'];
				$market_depth_quantityNw  = $data['market_depth_quantity'];
				$market_depth_askNw       = $data['market_depth_ask'];
				
				$market_depth_askNwNw     = round($market_depth_askNw,2);
				$market_depth_quantityNw  = round($market_depth_quantityNw,2);
				
				array_push($last_qty_time_agoArr, $last_qty_time_agoNew);
				array_push($last_200_time_agoArr, $last_200_time_agoNew);
				array_push($black_wall_pressure,  $black_wall_pressureNew);
			
				array_push($yellow_wall_pressure, $yellow_wall_pressureNew);
				array_push($pressure_diff,        $pressure_diffNew);
				array_push($seven_level_depth,    $seven_level_depthNew);
				array_push($score,                $scoreNew);
				array_push($straightline,         $straightlineNew);
				
				array_push($great_wall_price,     $great_wall_priceNew);
				array_push($current_market_value, $current_market_valueNew);	
				array_push($market_depth_ask,     $market_depth_askNwNw);	
				array_push($market_depth_quantity,$market_depth_quantityNw);	
				
	    }
		
			$data['last_qty_time_ago']       =  rtrim(implode(', ', $last_qty_time_agoArr),',');
			$data['last_200_time_ago']       =  implode(', ', $last_200_time_agoArr);
			$data['black_wall_pressure']     =  implode(', ', $black_wall_pressure);
			$data['yellow_wall_pressure']    =  implode(', ', $yellow_wall_pressure);
			$data['pressure_diff']           =  implode(', ', $pressure_diff);
			$data['great_wall_price']        =  implode(', ', $great_wall_price);
			$data['seven_level_depth']       =  implode(', ', $seven_level_depth);
			$data['score']                   =  implode(', ', $score);
			$data['current_market_value']    =  implode(', ', $current_market_value);
			$data['market_depth_quantity']   =  implode(', ', $market_depth_quantity);
			$data['market_depth_ask']        =  implode(', ', $market_depth_ask);
			$data['straightline         ']   =  implode(', ', $straightline);
			
			$data['market_depth_ask']        =  $data['market_depth_ask'];
			$data['market_depth_quantity']   =  $data['market_depth_quantity'];
			$data['coins_arr']               =  $all_coins_arr;
			$data['global_symbol']           =  $global_symbol;
		    $data['post_data']               =  $this->input->post();
			$data['startDate']               =  $newDateTime;
			$data['endDate']                 =  $end_dateA;
			$data['totalHours']              =  $totalHours;
			$data['time']                    =  $time;
			
			if($price_format=='1000'){ $prc_formate  =  ' K+'; } else if($price_format=='10000'){$prc_formate  =  ' 10 K+'; }else if($price_format=='100000'){$prc_formate  =  ' 100 K+'; }
			else if($price_format=='1000000'){$prc_formate  =  ' 1 M+'; }
			
			$data['price_format']            =  $prc_formate;
			$data['timezone']                =  $this->session->userdata('timezone');
			
		//stencil is our templating library. Simply call view via it
		$this->stencil->paint('admin/highchart/highchart', $data);

	} //End report
	
	
	 public function get_chartdata_ajax()
    {
        $time          = $this->input->post('time');
        $coin          = $this->input->post('coin');
		
		$html  = '';	
		$global_symbol = $this->session->userdata('global_symbol');
		$time          = 'minut';
		
		//Fetching users Record
		$ChartData_arr = $this->mod_highchart->get_chartdata_ajax($global_symbol,$time);
		$data['chart_arr'] = $ChartData_arr;
	     echo "<pre>";  print_r($ChartData_arr);  exit;  
		
		$black_wall_pressure    = array();
		$yellow_wall_pressure   = array();
		$pressure_diff          = array();
		$great_wall_price       = array();
		$seven_level_depth      = array();
		$score                  = array();
		$current_market_value   = array();
		$last_qty_time_agoArr   = array();
		$last_200_time_agoArr   = array();
		
	    foreach($ChartData_arr as $data){
			
				$last_qty_time_ago     = ($data->last_qty_time_ago) ? $data->last_qty_time_ago : 0;
				$last_200_time_ago     = ($data->last_200_time_ago) ? $data->last_200_time_ago : 0;
				
				$last_qty_time_agoNew = str_replace(" min ago","",$last_qty_time_ago);
				$last_200_time_agoNew = str_replace(" min ago","",$last_200_time_ago);
				
				array_push($last_qty_time_agoArr, $last_qty_time_agoNew);
				array_push($last_200_time_agoArr, $last_200_time_agoNew);
				array_push($black_wall_pressure, $data->black_wall_pressure);
			
				array_push($yellow_wall_pressure, $data->yellow_wall_pressure);
				array_push($pressure_diff, $data->pressure_diff);
				array_push($great_wall_price, $data->great_wall_price);
				array_push($seven_level_depth, $data->seven_level_depth);
				array_push($score, $data->score);
				array_push($current_market_value, $data->current_market_value);
	    }
		
		
			$returnArr['last_qty_time_ago']       =  implode(', ', $last_qty_time_agoArr);
			$returnArr['last_200_time_ago']       =  implode(', ', $last_200_time_agoArr);
			$returnArr['black_wall_pressure']     =  implode(', ', $black_wall_pressure);
			$returnArr['yellow_wall_pressure']    =  implode(', ', $yellow_wall_pressure);
			$returnArr['pressure_diff']           =  implode(', ', $pressure_diff);
			$returnArr['great_wall_price']        =  implode(', ', $great_wall_price);
			$returnArr['seven_level_depth']       =  implode(', ', $seven_level_depth);
			$returnArr['score']                   =  implode(', ', $score);
			$returnArr['current_market_value']    =  implode(', ', $current_market_value);
		
        if ($data) {
            $json_array['success'] = true;
            $json_array['data']    = $returnArr;
        } else {
            $json_array['success'] = false;
        }
        echo json_encode($json_array);
        exit;
    } //End  get_global_trigger_setting_ajax
	


}
