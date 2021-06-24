<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Highchart_opp extends CI_Controller
{
    public function __construct()
    {
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
		$this->load->model('admin/mod_coins');
        $this->load->model('admin/mod_sockets');
        $this->load->model('admin/mod_high_opp');
    }
	
    public function index()
    {
		$this->stencil->paint('admin/highchart/oppertunity', $data);
    } //End index
	
	
	// public function oppertunity() {
		
	// 	$this->mod_login->verify_is_admin_login();
	// 	$coin_array_all = $this->mod_coins->get_all_coins();

	// 	if ($this->input->post()) {
	// 		$data_arr['filter_order_data'] = $this->input->post();
	// 		$this->session->set_userdata($data_arr);
	// 		$coin_array = array();
	// 		if (!empty($this->input->post('filter_by_coin'))) {
	// 			$coin_array = $this->input->post('filter_by_coin'); 
	// 		} else {
	// 			$coin_array = array_column($coin_array_all, 'symbol');
	// 		}	
	// 		if (!empty($this->input->post('opp_status'))) {
	// 			$opp_status = $this->input->post('opp_status');
	// 			if($opp_status=='open'){
	// 			   $collection = "buy_orders";
	// 			}else {
	// 			   $collection = "sold_buy_orders";
	// 		    }
	// 		}
	// 		if ($this->input->post('filter_by_mode')) {
	// 			$search['order_mode'] = $this->input->post('filter_by_mode');
	// 		}
	// 		if ($this->input->post('peak_factor')) {
	// 			$peak_factor = $this->input->post('peak_factor');
	// 		}
			
	// 		if ($this->input->post('filter_by_trigger') != "") {
	// 			$filter_by_trigger = $this->input->post('filter_by_trigger');
	// 		} else {
	// 			$filter_by_trigger = array('barrier_trigger','barrier_percentile_trigger','no');
	// 		}
			
	// 		if ($this->input->post('filter_by_level') != "" && $filter_by_trigger=='barrier_percentile_trigger') {
	// 			$filter_by_level = $this->input->post('filter_by_level');
	// 			$search['order_level']['$in'] = $filter_by_level;
				
	// 		} else {
	// 			//$filter_by_level = array('level_1','level_2','level_3','level_4','level_5','level_6','level_7','level_8','level_9','level_10');
	// 		}
	// 		if ($this->input->post('filter_by_rule') != "" && $filter_by_trigger=='barrier_trigger') {
	// 			$filter_by_rule = $this->input->post('filter_by_rule');
	// 			$search['buy_rule_number']['$in'] = $filter_by_rule;
	// 		} else {
	// 			//$filter_by_rule = array(1,2,3,4,5,6,7,8,9,10);
	// 		}
	// 		if ($_POST['filter_by_start_date'] != "" && $_POST['filter_by_end_date'] != "") {
	// 			$created_datetime = date('Y-m-d G:i:s', strtotime($_POST['filter_by_start_date']));
	// 			$orig_date = new DateTime($created_datetime);
	// 			$orig_date = $orig_date->getTimestamp();
	// 			$start_date = new MongoDB\BSON\UTCDateTime($orig_date * 1000);

	// 			$created_datetime22 = date('Y-m-d G:i:s', strtotime($_POST['filter_by_end_date']));
	// 			$orig_date22 = new DateTime($created_datetime22);
	// 			$orig_date22 = $orig_date22->getTimestamp();
	// 			$end_date = new MongoDB\BSON\UTCDateTime($orig_date22 * 1000);
	// 			$search['created_date'] = array('$gte' => $start_date, '$lte' => $end_date);
	// 		}
	// 	  }else{
			
	// 			$coin_array           = array_column($coin_array_all, 'symbol');	
	// 			$opp_status           = 'sold';	
	// 			$collection           = "sold_buy_orders";
	// 			$search['order_mode'] = 'live';
	// 			$filter_by_trigger    = 'barrier_percentile_trigger';
	// 			$search['order_level']['$in'] =  array('level_1','level_2','level_3','level_4','level_5','level_6','level_7','level_8','level_9','level_10','level_11','level_12','level_13','level_14','level_15');
				
	// 			$filter_by_end_date        = date('Y-m-d G:i:s');
	// 			$filter_by_end_date1111    = date("m/d/Y H:i a", strtotime($filter_by_end_date));
	// 			$filter_by_start_date      = date('Y-m-d G:i:s',strtotime('-1 months'));
	// 			$filter_by_start_date111   = date("m/d/Y H:i a", strtotime($filter_by_start_date));
		
	// 			$array['filter_by_mode']       = $search['order_mode'];
	// 			$array['filter_by_start_date'] = $filter_by_start_date111;
	// 			$array['filter_by_end_date']   = $filter_by_end_date1111;
	// 			$array['opp_status']           = $opp_status;
	// 			$array['filter_by_trigger']    = $filter_by_trigger;
	// 			$array['filter_by_level']      = $search['order_level']['$in'];
	// 			$array['filter_by_coin']       = $coin_array;
		
	// 			$data_arr['filter_order_data'] = $array;
	// 			$this->session->set_userdata($data_arr);
	// 			// Start Date 
	// 			$orig_date = new DateTime($filter_by_start_date);
	// 			$orig_date = $orig_date->getTimestamp();
	// 			$start_date = new MongoDB\BSON\UTCDateTime($orig_date * 1000);
	// 			// End Date  
	// 			$orig_date22 = new DateTime($filter_by_end_date);
	// 			$orig_date22 = $orig_date22->getTimestamp();
	// 			$end_date = new MongoDB\BSON\UTCDateTime($orig_date22 * 1000);
	// 			$search['created_date'] = array('$gte' => $start_date, '$lte' => $end_date);
	// 	}
	// 	 $filter = 'trigger';	
	// 	 if ($filter == 'all') {
    //             $conn = $this->mongo_db->customQuery();
    //             $order_arr_all = array();
    //             foreach ($coin_array as $key => $value) {
    //                 $search['symbol'] = $value;
    //                 $db_obj = $conn->sold_buy_orders->find($search);
    //                 $order_arr = iterator_to_array($db_obj);
	// 				$order_arr_all[$value] = $order_arr;
    //             }
    //             $data['full_arr'] = $order_arr_all;
    //         } else if ($filter == 'trigger') {
    //             $conn = $this->mongo_db->customQuery();
    //             $order_arr_all = array();
    //             $trigger_array = array("barrier_trigger", "barrier_percentile_trigger");
	// 			//$trigger_array = array( "barrier_percentile_trigger");
    //             foreach ($coin_array as $key => $value) {
    //                 $search['symbol'] = $value;
    //                 foreach ($trigger_array as $key1 => $value_trigger) {
	// 					$search['trigger_type'] = $value_trigger;
						
    //                     $db_obj = $conn->sold_buy_orders->find($search);
    //                     $order_arr = iterator_to_array($db_obj);
	// 					$order_arr_all[$value][$value_trigger] = $order_arr;
    //                 }
    //             }
				
    //             $resultArr = $this->make_array_for_view($order_arr_all, 'trigger');
    //             $data['full_arr'] = $resultArr;
				
    //         } elseif ($filter == "rule") {
    //             if ($this->input->post('filter_by_trigger')) {
    //                 $search['trigger_type'] = $this->input->post('filter_by_trigger');
    //             }
    //             $conn = $this->mongo_db->customQuery();
    //             $order_arr_all = array();
    //             $trigger_array = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10,11,12,13,14,15);
    //             if ($this->input->post('filter_by_trigger') == 'barrier_trigger') {
    //                 $trigger_array = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10);
    //             } elseif ($this->input->post('filter_by_trigger') == 'barrier_percentile_trigger') {
    //                 $trigger_array = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10,11,12,13,14,15);
    //             }
				
					
    //             foreach ($coin_array as $key => $value) {
    //                 $search['symbol'] = $value;
    //                 foreach ($trigger_array as $key1 => $value_trigger) {

    //                     if ($this->input->post('filter_by_trigger') == 'barrier_trigger') {
    //                         $search['buy_rule_number'] = $value_trigger;
    //                     } elseif ($this->input->post('filter_by_trigger') == 'barrier_percentile_trigger') {
    //                         $search['order_level'] = "level_" . $value_trigger;
    //                     }
    //                     $db_obj = $conn->sold_buy_orders->find($search);
    //                     $order_arr = iterator_to_array($db_obj);
    //                     $order_arr_all[$value][$value_trigger] = $order_arr;
    //                 }
    //             }
    //             $resultArr = $this->make_array_for_view($order_arr_all, 'trigger');
    //             $data['full_arr'] = $resultArr;
    //         }
	// 	$prefix                 = '';
	// 	foreach($data['full_arr'] as $key => $recordArr){
		
	// 			if($recordArr['barrier_percentile_trigger']){		  	
	// 			$percentile             = $recordArr['barrier_percentile_trigger'];	
				
	// 			      $prefix                    = '';
	// 				  if($percentile['opp']['op']!=0 && $percentile['opp']['op']!=''){ 
	// 					  $avg_profit_per        = $prefix . '' . ($percentile['avg_profit'] == 'nan' ?  0 : $percentile['avg_profit']) . ''; 
	// 					  $max_profit_5h_per     = $prefix . '' . ($percentile['max_profit_5h'] == 'nan' ? 0 :$percentile['max_profit_5h']) . ''; 
	// 					  $min_profit_5h_per     = $prefix . '' . ($percentile['min_profit_5h'] == 'nan' ? 0 : $percentile['min_profit_5h']) . ''; 
	// 					  $max_profit_high_per   = $prefix . '' . ($percentile['max_profit_high'] == 'nan' ? 0 : $percentile['max_profit_high']) . ''; 
	// 					  $min_profit_low_per    = $prefix . '' . ($percentile['min_profit_low'] == 'nan' ? 0 : $percentile['min_profit_low']) . '';
	// 					  $peak_factor           = ($peak_factor=='') ? 1 : $peak_factor; 
	// 					  $opp_per               = $prefix . '' . (floor($percentile['opp']['op']/$peak_factor)) . ''; 
	// 					  $prefix                = ', ';
	// 					  $final_Per[$key]       =  $avg_profit_per.$prefix.$max_profit_5h_per.$prefix.$min_profit_5h_per.$prefix.$max_profit_high_per.$prefix.$min_profit_low_per.$prefix.$opp_per ;
						    
	// 				  }else{
	// 					  $avg_profit_per        = $prefix . '0' ;
	// 					  $max_profit_5h_per     = $prefix . '0' ;
	// 					  $min_profit_5h_per     = $prefix . '0' ;
	// 					  $max_profit_high_per   = $prefix . '0' ;
	// 					  $min_profit_low_per    = $prefix . '0' ;
	// 					  $opp_per               = $prefix . '' ; 
	// 					  $prefix                =  ', ';
	// 					  $final_Per[$key]       =  $avg_profit_per.$prefix.$max_profit_5h_per.$prefix.$min_profit_5h_per.$prefix.$max_profit_high_per.$prefix.$min_profit_low_per.$prefix.$opp_per ;
	// 				  }
					  
	// 			}else if($recordArr['barrier_trigger']){
				  
	// 				  $barrier                = $recordArr['barrier_trigger'];	
	// 				  if($barrier['opp']['op']!=0 && $barrier['opp']['op']!=''){ 
	// 					  $avg_profit_bar         = $prefix . '' . ($barrier['avg_profit'] == 'nan' ? 0 : $barrier['avg_profit']) . ''; 
	// 					  $max_profit_5h_bar      = $prefix . '' . ($barrier['max_profit_5h'] == 'nan' ? 0 : $barrier['max_profit_5h']) . ''; 
	// 					  $min_profit_5h_bar      = $prefix . '' . ($barrier['min_profit_5h'] == 'nan' ? 0 : $barrier['min_profit_5h']) . ''; 
	// 					  $max_profit_high_bar    = $prefix . '' . ($barrier['max_profit_high'] == 'nan' ? 0 : $barrier['max_profit_high']) . ''; 
	// 					  $min_profit_low_bar     = $prefix . '' . ($barrier['min_profit_low'] == 'nan' ? 0 : $barrier['min_profit_low']) . ''; 
	// 					  $opp_bar                = $prefix . '' . ($barrier['opp']['op'] == 'nan' ? 0 : $barrier['opp']['op']) . ''; 
	// 					  $prefix                 = ', '; 
	// 					  $final_Per[$key]        =  $avg_profit_per.$prefix.$max_profit_5h_per.$prefix.$min_profit_5h_per.$prefix.$max_profit_high_per.$prefix.$min_profit_low_per.$prefix.$opp_per ;
						  
	// 				  }else{
	// 					  $avg_profit_bar         = $prefix . '0' ; 
	// 					  $max_profit_5h_bar      = $prefix . '0' ; 
	// 					  $min_profit_5h_bar      = $prefix . '0' ; 
	// 					  $max_profit_high_bar    = $prefix . '0' ; 
	// 					  $min_profit_low_bar     = $prefix . '0' ; 
	// 					  $opp_bar                = $prefix . '' ;
	// 					  $prefix                 = ', ';
	// 					  $final_Per[$key]        =  $avg_profit_per.$prefix.$max_profit_5h_per.$prefix.$min_profit_5h_per.$prefix.$max_profit_high_per.$prefix.$min_profit_low_per.$prefix.$opp_per ;
	// 				  }
	// 			}else if($recordArr['box_trigger']){
			      
	// 				  $box                    = $recordArr['box_trigger'];
	// 				  if($box['opp']['op']!=0 && $box['opp']['op']!=''){ 			
	// 					  $avg_profit_box         = $prefix . '' . ($box['avg_profit'] == 'nan' ? 0 : $box['avg_profit']) . ''; 
	// 					  $max_profit_5h_box      = $prefix . '' . ($box['max_profit_5h'] == 'nan' ? 0 : $box['max_profit_5h']) . ''; 
	// 					  $min_profit_5h_box      = $prefix . '' . ($box['min_profit_5h'] == 'nan' ? 0 : $box['min_profit_5h']) . ''; 
	// 					  $max_profit_high_box    = $prefix . '' . ($box['max_profit_high'] == 'nan' ? 0 : $box['max_profit_high']) . ''; 
	// 					  $min_profit_low_box     = $prefix . '' . ($box['min_profit_low'] == 'nan' ? 0 : $box['min_profit_low']) . ''; 
	// 					  $opp_box                = $prefix . '' . ($box['opp']['op'] == 'nan' ? 0 : $box['opp']['op']) . ''; 
	// 					  $prefix                 = ', ';
	// 					  $final_Per[$key]        =  $avg_profit_per.$prefix.$max_profit_5h_per.$prefix.$min_profit_5h_per.$prefix.$max_profit_high_per.$prefix.$min_profit_low_per.$prefix.$opp_box ;
	// 				  }else{
	// 					  $avg_profit_box         = $prefix . '0'; 
	// 					  $max_profit_5h_box      = $prefix . '0' ;
	// 					  $min_profit_5h_box      = $prefix . '0' ;
	// 					  $max_profit_high_box    = $prefix . '0' ;
	// 					  $min_profit_low_box     = $prefix . '0' ;
	// 					  $opp_box                = $prefix . '' ; 
	// 					  $prefix                 = ', ';
	// 					  $final_Per[$key]        =  $avg_profit_per.$prefix.$max_profit_5h_per.$prefix.$min_profit_5h_per.$prefix.$max_profit_high_per.$prefix.$min_profit_low_per.$prefix.$opp_box ;
	// 				  }
	// 			}
	// 			$onlyCoin  .= "'".$key."'".$prefix;
	// 	}
		
	// 	$data['final_arr']           = ($filter == "rule") ? $data['full_arr'] : $final_Per;
	// 	$data['coin_array_all']      = $coin_array_all;
	// 	$data['onlyCoin']            = $onlyCoin;
	// 	$data['peak_factor']         = $peak_factor;
	// 	$data['avg_profit_per']      = $avg_profit_per;
	// 	$data['max_profit_5h_per']   = $max_profit_5h_per;
	// 	$data['min_profit_5h_per']   = $min_profit_5h_per;
	// 	$data['max_profit_high_per'] = $max_profit_high_per;
	// 	$data['min_profit_low_per']  = $min_profit_low_per;
	// 	$data['avg_profit_bar']      = $avg_profit_bar;
	// 	$data['max_profit_5h_bar']   = $max_profit_5h_bar;
	// 	$data['min_profit_5h_bar']   = $min_profit_5h_bar;
	// 	$data['max_profit_high_bar'] = $max_profit_high_bar;
	// 	$data['min_profit_low_bar']  = $min_profit_low_bar;
	// 	$data['avg_profit_box']      = $avg_profit_box;
	// 	$data['max_profit_5h_box']   = $max_profit_5h_box;
	// 	$data['min_profit_5h_box']   = $min_profit_5h_box;
	// 	$data['max_profit_high_box'] = $max_profit_high_box;
	// 	$data['min_profit_low_box']  = $min_profit_low_box;
	// //	echo "<pre>";
	// //	print_r($data); exit;
    //     $this->stencil->paint('admin/highchart/high_opp', $data);
    // }
	
	// public function oppertunity_second() {
		
	// 	$this->mod_login->verify_is_admin_login();
	// 	$coin_array_all = $this->mod_coins->get_all_coins();
		
	// 	if ($this->input->post()) {
	// 		$data_arr['filter_order_data'] = $this->input->post();
	// 		$this->session->set_userdata($data_arr);

	// 		$coin_array = array();
	// 		if (!empty($this->input->post('filter_by_coin'))) {
	// 			$coin_array = $this->input->post('filter_by_coin');
	// 		} else {
	// 			$coin_array = array_column($coin_array_all, 'symbol');
	// 		}
			
	// 		if (!empty($this->input->post('opp_status'))) {
	// 			$opp_status = $this->input->post('opp_status');
	// 			if($opp_status=='open'){
	// 			   $collection = "buy_orders";
	// 			}else {
	// 			   $collection = "sold_buy_orders";
	// 		    }
	// 		}
	// 		if ($this->input->post('filter_by_mode')) {
	// 			$search['order_mode'] = $this->input->post('filter_by_mode');
	// 		}
			
	// 		if ($this->input->post('filter_by_trigger') != "") {
	// 			$filter_by_trigger = $this->input->post('filter_by_trigger');
	// 		} else {
	// 			$filter_by_trigger = array('barrier_trigger','barrier_percentile_trigger','no');
	// 		}
			
	// 		if ($this->input->post('filter_by_level') != "" && $filter_by_trigger=='barrier_percentile_trigger') {
	// 			$filter_by_level = $this->input->post('filter_by_level');
	// 			$search['order_level']['$in'] = $filter_by_level;
	// 		} else {
	// 			//$filter_by_level = array('level_1','level_2','level_3','level_4','level_5','level_6','level_7','level_8','level_9','level_10');
	// 		}
	// 		if ($this->input->post('filter_by_rule') != "" && $filter_by_trigger=='barrier_trigger') {
	// 			$filter_by_rule = $this->input->post('filter_by_rule');
	// 			$search['buy_rule_number']['$in'] = $filter_by_rule;
	// 		} else {
	// 			//$filter_by_rule = array(1,2,3,4,5,6,7,8,9,10);
	// 		}
	// 		if ($_POST['filter_by_start_date'] != "" && $_POST['filter_by_end_date'] != "") {
	// 			$created_datetime = date('Y-m-d G:i:s', strtotime($_POST['filter_by_start_date']));
	// 			$orig_date = new DateTime($created_datetime);
	// 			$orig_date = $orig_date->getTimestamp();
	// 			$start_date = new MongoDB\BSON\UTCDateTime($orig_date * 1000);

	// 			$created_datetime22 = date('Y-m-d G:i:s', strtotime($_POST['filter_by_end_date']));
	// 			$orig_date22 = new DateTime($created_datetime22);
	// 			$orig_date22 = $orig_date22->getTimestamp();
	// 			$end_date = new MongoDB\BSON\UTCDateTime($orig_date22 * 1000);
	// 			$search['created_date'] = array('$gte' => $start_date, '$lte' => $end_date);
	// 		}
	// 	  }else{
			
	// 			//$coin_array           = array_column($coin_array_all, 'symbol');	
	// 			$coin_array           = array('XRPBTC','XEMBTC','ZENBTC');	
	// 			$opp_status           = 'sold';	
	// 			$collection           = "sold_buy_orders";
	// 			//$search['order_mode'] = '';
	// 			$filter_by_trigger    = 'barrier_percentile_trigger';
	// 			$search['order_level']['$in'] =  array('level_1','level_2','level_3','level_4','level_5','level_6','level_7','level_8','level_9','level_10','level_11','level_12','level_13','level_14','level_15');
				
	// 			$filter_by_end_date        = date('Y-m-d G:i:s');
	// 			$filter_by_end_date1111    = date("m/d/Y H:i a", strtotime($filter_by_end_date));
	// 			$filter_by_start_date      = date('Y-m-d G:i:s',strtotime('-2 months'));
	// 			$filter_by_start_date111   = date("m/d/Y H:i a", strtotime($filter_by_start_date));
		
	// 			$array['filter_by_mode']       = $search['order_mode'];
	// 			$array['filter_by_start_date'] = $filter_by_start_date111;
	// 			$array['filter_by_end_date']   = $filter_by_end_date1111;
	// 			$array['opp_status']           = $opp_status;
	// 			$array['filter_by_trigger']    = $filter_by_trigger;
	// 			$array['filter_by_level']      = $search['order_level']['$in'];
	// 			$array['filter_by_coin']       = $coin_array;
		
	// 			$data_arr['filter_order_data'] = $array;
	// 			$this->session->set_userdata($data_arr);
	// 			// Start Date 
	// 			$orig_date = new DateTime($filter_by_start_date);
	// 			$orig_date = $orig_date->getTimestamp();
	// 			$start_date = new MongoDB\BSON\UTCDateTime($orig_date * 1000);
	// 			// End Date  
	// 			$orig_date22 = new DateTime($filter_by_end_date);
	// 			$orig_date22 = $orig_date22->getTimestamp();
	// 			$end_date = new MongoDB\BSON\UTCDateTime($orig_date22 * 1000);
	// 			$search['created_date'] = array('$gte' => $start_date, '$lte' => $end_date);
	// 	}
	// 	$filter = 'trigger';	
		
	// 	 if ($filter == 'all') {
    //             $conn = $this->mongo_db->customQuery();
    //             $order_arr_all = array();
    //             foreach ($coin_array as $key => $value) {
    //                 $search['symbol'] = $value;
    //                 $db_obj = $conn->sold_buy_orders->find($search);
    //                 $order_arr = iterator_to_array($db_obj);
    //                 $order_arr_all[$value] = $order_arr;
    //             }
				
    //             $data['full_arr'] = $order_arr_all;
    //         } else if ($filter == 'trigger') {
    //             $conn = $this->mongo_db->customQuery();
    //             $order_arr_all = array();
    //             $trigger_array = array( "barrier_percentile_trigger");
	// 			//$trigger_array = array( "barrier_percentile_trigger");
    //             foreach ($coin_array as $key => $value) {
    //                 $search['symbol'] = $value;
    //                 foreach ($trigger_array as $key1 => $value_trigger) {
    //                     $search['trigger_type'] = $value_trigger;

    //                     $db_obj = $conn->sold_buy_orders->find($search);
    //                     $order_arr = iterator_to_array($db_obj);
    //                     $order_arr_all[$value][$value_trigger] = $order_arr;
    //                 }
    //             }
    //             $resultArr = $this->make_array_for_view($order_arr_all, 'trigger');
    //             $data['full_arr'] = $resultArr;
    //         } elseif ($filter == "rule") {
    //             if ($this->input->post('filter_by_trigger')) {
    //                 $search['trigger_type'] = $this->input->post('filter_by_trigger');
    //             }
    //             $conn = $this->mongo_db->customQuery();
    //             $order_arr_all = array();
    //             $trigger_array = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10);
    //             if ($this->input->post('filter_by_trigger') == 'barrier_trigger') {
    //                 $trigger_array = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10);
    //             } elseif ($this->input->post('filter_by_trigger') == 'barrier_percentile_trigger') {
    //                 $trigger_array = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10);
    //             }
				
					
    //             foreach ($coin_array as $key => $value) {
    //                 $search['symbol'] = $value;
    //                 foreach ($trigger_array as $key1 => $value_trigger) {

    //                     if ($this->input->post('filter_by_trigger') == 'barrier_trigger') {
    //                         $search['buy_rule_number'] = $value_trigger;
    //                     } elseif ($this->input->post('filter_by_trigger') == 'barrier_percentile_trigger') {
    //                         $search['order_level'] = "level_" . $value_trigger;
    //                     }
    //                     $db_obj = $conn->sold_buy_orders->find($search);
    //                     $order_arr = iterator_to_array($db_obj);
    //                     $order_arr_all[$value][$value_trigger] = $order_arr;
    //                 }
    //             }
    //             $resultArr = $this->make_array_for_view($order_arr_all, 'trigger');
    //             $data['full_arr'] = $resultArr;
    //         }
			
		
	// 	//echo "<pre>";  print_r($data['full_arr'] ); exit;   	
			
	// 	$prefix                 = '';
	// 	foreach($data['full_arr'] as $key => $recordArr){
			
			    
			
	// 			if($recordArr['barrier_percentile_trigger']){		  	
	// 			$percentile             = $recordArr['barrier_percentile_trigger'];	
	// 			      $prefix                    = '';
	// 				  if($percentile['opp']['op']!=0 && $percentile['opp']['op']!=''){ 
	// 					  $avg_profit_per        = $prefix . '' . ($percentile['avg_profit']) . ''; 
	// 					  $max_profit_5h_per     = $prefix . '' . ($percentile['max_profit_5h']) . ''; 
	// 					  $min_profit_5h_per     = $prefix . '' . ($percentile['min_profit_5h']) . ''; 
	// 					  $max_profit_high_per   = $prefix . '' . ($percentile['max_profit_high']) . ''; 
	// 					  $min_profit_low_per    = $prefix . '' . ($percentile['min_profit_low']) . ''; 
	// 					  $opp_per               = $prefix . '' . ($percentile['opp']['op']) . ''; 
	// 					  $coin_avg_move         = $prefix . '' . ($recordArr['coin_meta']['coin_avg_move']) . ''; 
						  
	// 					  $prefix                = ', ';
	// 					  $final_Per[$key]['avg_profit_per']        =  $avg_profit_per;
	// 					  $final_Per[$key]['max_profit_5h_per']     =  $max_profit_5h_per;
	// 					  $final_Per[$key]['max_profit_5h_per']     =  $max_profit_5h_per;
	// 					  $final_Per[$key]['max_profit_high_per']   =  $max_profit_high_per;
	// 					  $final_Per[$key]['min_profit_low_per']    =  $min_profit_low_per;
	// 					  $final_Per[$key]['opp_per']               =  $opp_per;
	// 					  $final_Per[$key]['coin_avg_move']         =  $coin_avg_move;
	// 					  $final_Per[$key]       =  $avg_profit_per.$prefix.$max_profit_5h_per.$prefix.$max_profit_5h_per.$prefix.$max_profit_high_per.$prefix.$min_profit_low_per.$prefix.$coin_avg_move.$prefix.$opp_per ;
						    
	// 				  }else{
	// 					  $avg_profit_per        = $prefix . '' ;
	// 					  $max_profit_5h_per     = $prefix . '' ;
	// 					  $min_profit_5h_per     = $prefix . '' ;
	// 					  $max_profit_high_per   = $prefix . '' ;
	// 					  $min_profit_low_per    = $prefix . '' ;
	// 					  $opp_per               = $prefix . '' ; 
	// 					  $coin_avg_move         = $prefix . '' ; 
	// 					  $prefix                =  ', ';
	// 					  $final_Per[$key]       =  $avg_profit_per.$prefix.$max_profit_5h_per.$prefix.$max_profit_5h_per.$prefix.$max_profit_high_per.$prefix.$min_profit_low_per.$prefix.$coin_avg_move.$prefix.$opp_per ;
	// 				  }
	// 				  //echo "<pre>";  print_r( $final_Per); exit;   
	// 			}else if($recordArr['barrier_trigger']){
				  
	// 				  $barrier                = $recordArr['barrier_trigger'];	
	// 				  if($barrier['opp']['op']!=0 && $barrier['opp']['op']!=''){ 
	// 					  $avg_profit_bar         = $prefix . '' . ($barrier['avg_profit']) . ''; 
	// 					  $max_profit_5h_bar      = $prefix . '' . ($barrier['max_profit_5h']) . ''; 
	// 					  $min_profit_5h_bar      = $prefix . '' . ($barrier['min_profit_5h']) . ''; 
	// 					  $max_profit_high_bar    = $prefix . '' . ($barrier['max_profit_high']) . ''; 
	// 					  $min_profit_low_bar     = $prefix . '' . ($barrier['min_profit_low']) . ''; 
	// 					  $opp_bar                    = $prefix . '' . ($barrier['opp']['op']) . ''; 
	// 					  $prefix                 = ', '; 
	// 					  $final_bar[$key]        =  $avg_profit_per.$prefix.$max_profit_5h_per.$prefix.$max_profit_5h_per.$prefix.$max_profit_high_per.$prefix.$min_profit_low_per.$prefix.$coin_avg_move.$prefix.$opp_per ;
						  
	// 				  }else{
	// 					  $avg_profit_bar         = $prefix . '' ; 
	// 					  $max_profit_5h_bar      = $prefix . '' ; 
	// 					  $min_profit_5h_bar      = $prefix . '' ; 
	// 					  $max_profit_high_bar    = $prefix . '' ; 
	// 					  $min_profit_low_bar     = $prefix . '' ; 
	// 					  $opp_bar                    = $prefix . '' ;
	// 					  $prefix                 = ', ';
	// 					  $final_bar[$key]        =  $avg_profit_per.$prefix.$max_profit_5h_per.$prefix.$max_profit_5h_per.$prefix.$max_profit_high_per.$prefix.$min_profit_low_per.$prefix.$opp_per ;
	// 				  }
	// 			}else if($recordArr['box_trigger']){
			      
	// 				  $box                    = $recordArr['box_trigger'];
	// 				  if($box['opp']['op']!=0 && $box['opp']['op']!=''){ 			
	// 					  $avg_profit_box         = $prefix . '' . ($box['avg_profit']) . ''; 
	// 					  $max_profit_5h_box      = $prefix . '' . ($box['max_profit_5h']) . ''; 
	// 					  $min_profit_5h_box      = $prefix . '' . ($box['min_profit_5h']) . ''; 
	// 					  $max_profit_high_box    = $prefix . '' . ($box['max_profit_high']) . ''; 
	// 					  $min_profit_low_box     = $prefix . '' . ($box['min_profit_low']) . ''; 
	// 					  $opp_box                    = $prefix . '' . ($box['opp']['op']) . ''; 
	// 					  $prefix                 = ', ';
	// 					  $final_box[$key]        =  $avg_profit_per.$prefix.$max_profit_5h_per.$prefix.$max_profit_5h_per.$prefix.$max_profit_high_per.$prefix.$min_profit_low_per.$prefix.$opp_box ;
	// 				  }else{
	// 					  $avg_profit_box         = $prefix . ''; 
	// 					  $max_profit_5h_box      = $prefix . '' ;
	// 					  $min_profit_5h_box      = $prefix . '' ;
	// 					  $max_profit_high_box    = $prefix . '' ;
	// 					  $min_profit_low_box     = $prefix . '' ;
	// 					  $opp_box                    = $prefix . '' ; 
	// 					  $prefix                 = ', ';
	// 					  $final_box[$key]        =  $avg_profit_per.$prefix.$max_profit_5h_per.$prefix.$max_profit_5h_per.$prefix.$max_profit_high_per.$prefix.$min_profit_low_per.$prefix.$opp_box ;
	// 				  }
	// 			}
	// 			$onlyCoin  .= "'".$key."'".$prefix;
	// 	}
    //     //echo "<pre>";  print_r( $final_Per); exit;  
		
	// 	$arrayLable  =  "['Average Profit','Maximum Profit 5H','Minimum Profit 5H','Max Profit High','Min Profit Low','Average Move','Oppertunity']";       
		 
		 
	// 	$data['final_arr_label']     =  $arrayLable;
	// 	$data['final_arr']           =  $final_Per;
	// 	$data['onlyCoin']            =  $onlyCoin;
		
	// 	$data['avg_profit_per']      = $avg_profit_per;
	// 	$data['max_profit_5h_per']   = $max_profit_5h_per;
	// 	$data['min_profit_5h_per']   = $min_profit_5h_per;
	// 	$data['max_profit_high_per'] = $max_profit_high_per;
	// 	$data['min_profit_low_per']  = $min_profit_low_per;
	// 	$data['coin_avg_move']       = $coin_avg_move;
		
	// 	$data['avg_profit_bar']      = $avg_profit_bar;
	// 	$data['max_profit_5h_bar']   = $max_profit_5h_bar;
	// 	$data['min_profit_5h_bar']   = $min_profit_5h_bar;
	// 	$data['max_profit_high_bar'] = $max_profit_high_bar;
	// 	$data['min_profit_low_bar']  = $min_profit_low_bar;
		
		
	// 	$data['avg_profit_box']      = $avg_profit_box;
	// 	$data['max_profit_5h_box']   = $max_profit_5h_box;
	// 	$data['min_profit_5h_box']   = $min_profit_5h_box;
	// 	$data['max_profit_high_box'] = $max_profit_high_box;
	// 	$data['min_profit_low_box']  = $min_profit_low_box;
		
		
	// 	$data['coin_array_all']  = $coin_array_all;
		
		
		
	  	
		
    //     $this->stencil->paint('admin/highchart/high_opp_second', $data);
    // }
	
	// public function oppertunity_third() {
		
	// 	$this->mod_login->verify_is_admin_login();
	// 	$coin_array_all = $this->mod_coins->get_all_coins();
		
	// 	if ($this->input->post()) {
	// 		$data_arr['filter_order_data'] = $this->input->post();
	// 		$this->session->set_userdata($data_arr);

	// 		$coin_array = array();
	// 		if (!empty($this->input->post('filter_by_coin'))) {
	// 			$coin_array = $this->input->post('filter_by_coin');
	// 		} else {
	// 			$coin_array = array_column($coin_array_all, 'symbol');
	// 		}
			
	// 		if (!empty($this->input->post('opp_status'))) {
	// 			$opp_status = $this->input->post('opp_status');
	// 			if($opp_status=='open'){
	// 			   $collection = "buy_orders";
	// 			}else {
	// 			   $collection = "sold_buy_orders";
	// 		    }
	// 		}
	// 		if ($this->input->post('filter_by_mode')) {
	// 			$search['order_mode'] = $this->input->post('filter_by_mode');
	// 		}
			
	// 		if ($this->input->post('filter_by_trigger') != "") {
	// 			$filter_by_trigger = $this->input->post('filter_by_trigger');
	// 		} else {
	// 			$filter_by_trigger = array('barrier_trigger','barrier_percentile_trigger','no');
	// 		}
			
	// 		if ($this->input->post('filter_by_level') != "" && $filter_by_trigger=='barrier_percentile_trigger') {
	// 			$filter_by_level = $this->input->post('filter_by_level');
	// 			$search['order_level']['$in'] = $filter_by_level;
	// 		} else {
	// 			//$filter_by_level = array('level_1','level_2','level_3','level_4','level_5','level_6','level_7','level_8','level_9','level_10');
	// 		}
	// 		if ($this->input->post('filter_by_rule') != "" && $filter_by_trigger=='barrier_trigger') {
	// 			$filter_by_rule = $this->input->post('filter_by_rule');
	// 			$search['buy_rule_number']['$in'] = $filter_by_rule;
	// 		} else {
	// 			//$filter_by_rule = array(1,2,3,4,5,6,7,8,9,10);
	// 		}
	// 		if ($_POST['filter_by_start_date'] != "" && $_POST['filter_by_end_date'] != "") {
	// 			$created_datetime = date('Y-m-d G:i:s', strtotime($_POST['filter_by_start_date']));
	// 			$orig_date = new DateTime($created_datetime);
	// 			$orig_date = $orig_date->getTimestamp();
	// 			$start_date = new MongoDB\BSON\UTCDateTime($orig_date * 1000);

	// 			$created_datetime22 = date('Y-m-d G:i:s', strtotime($_POST['filter_by_end_date']));
	// 			$orig_date22 = new DateTime($created_datetime22);
	// 			$orig_date22 = $orig_date22->getTimestamp();
	// 			$end_date = new MongoDB\BSON\UTCDateTime($orig_date22 * 1000);
	// 			$search['created_date'] = array('$gte' => $start_date, '$lte' => $end_date);
	// 		}
	// 	  }else{
			
	// 			//$coin_array           = array_column($coin_array_all, 'symbol');	
	// 			$coin_array           = array('XRPBTC','XEMBTC','ZENBTC');	
	// 			$opp_status           = 'sold';	
	// 			$collection           = "sold_buy_orders";
	// 			//$search['order_mode'] = '';
	// 			$filter_by_trigger    = 'barrier_percentile_trigger';
	// 			$search['order_level']['$in'] =  array('level_1','level_2','level_3','level_4','level_5','level_6','level_7','level_8','level_9','level_10');
				
	// 			$filter_by_end_date        = date('Y-m-d G:i:s');
	// 			$filter_by_end_date1111    = date("m/d/Y H:i a", strtotime($filter_by_end_date));
	// 			$filter_by_start_date      = date('Y-m-d G:i:s',strtotime('-2 months'));
	// 			$filter_by_start_date111   = date("m/d/Y H:i a", strtotime($filter_by_start_date));
		
	// 			$array['filter_by_mode']       = $search['order_mode'];
	// 			$array['filter_by_start_date'] = $filter_by_start_date111;
	// 			$array['filter_by_end_date']   = $filter_by_end_date1111;
	// 			$array['opp_status']           = $opp_status;
	// 			$array['filter_by_trigger']    = $filter_by_trigger;
	// 			$array['filter_by_level']      = $search['order_level']['$in'];
	// 			$array['filter_by_coin']       = $coin_array;
		
	// 			$data_arr['filter_order_data'] = $array;
	// 			$this->session->set_userdata($data_arr);
	// 			// Start Date 
	// 			$orig_date = new DateTime($filter_by_start_date);
	// 			$orig_date = $orig_date->getTimestamp();
	// 			$start_date = new MongoDB\BSON\UTCDateTime($orig_date * 1000);
	// 			// End Date  
	// 			$orig_date22 = new DateTime($filter_by_end_date);
	// 			$orig_date22 = $orig_date22->getTimestamp();
	// 			$end_date = new MongoDB\BSON\UTCDateTime($orig_date22 * 1000);
	// 			$search['created_date'] = array('$gte' => $start_date, '$lte' => $end_date);
	// 	}
		
	
	// 		$filter = 'trigger';	
			
			
	    
	
	// 	 if ($filter == 'all') {
    //             $conn = $this->mongo_db->customQuery();
    //             $order_arr_all = array();
    //             foreach ($coin_array as $key => $value) {
    //                 $search['symbol'] = $value;
    //                 $db_obj = $conn->sold_buy_orders->find($search);
    //                 $order_arr = iterator_to_array($db_obj);
    //                 $order_arr_all[$value] = $order_arr;
    //             }
				
    //             $data['full_arr'] = $order_arr_all;
    //         } else if ($filter == 'trigger') {
    //             $conn = $this->mongo_db->customQuery();
    //             $order_arr_all = array();
    //             $trigger_array = array( "barrier_percentile_trigger");
	// 			//$trigger_array = array( "barrier_percentile_trigger");
    //             foreach ($coin_array as $key => $value) {
    //                 $search['symbol'] = $value;
    //                 foreach ($trigger_array as $key1 => $value_trigger) {
    //                     $search['trigger_type'] = $value_trigger;

    //                     $db_obj = $conn->sold_buy_orders->find($search);
    //                     $order_arr = iterator_to_array($db_obj);
    //                     $order_arr_all[$value][$value_trigger] = $order_arr;
    //                 }
    //             }
				
    //             $resultArr = $this->make_array_for_view($order_arr_all, 'trigger');
    //             $data['full_arr'] = $resultArr;
				
				
    //         } elseif ($filter == "rule") {
    //             if ($this->input->post('filter_by_trigger')) {
    //                 $search['trigger_type'] = $this->input->post('filter_by_trigger');
    //             }
    //             $conn = $this->mongo_db->customQuery();
    //             $order_arr_all = array();
    //             $trigger_array = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10);
    //             if ($this->input->post('filter_by_trigger') == 'barrier_trigger') {
    //                 $trigger_array = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10);
    //             } elseif ($this->input->post('filter_by_trigger') == 'barrier_percentile_trigger') {
    //                 $trigger_array = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10);
    //             }
				
					
    //             foreach ($coin_array as $key => $value) {
    //                 $search['symbol'] = $value;
    //                 foreach ($trigger_array as $key1 => $value_trigger) {

    //                     if ($this->input->post('filter_by_trigger') == 'barrier_trigger') {
    //                         $search['buy_rule_number'] = $value_trigger;
    //                     } elseif ($this->input->post('filter_by_trigger') == 'barrier_percentile_trigger') {
    //                         $search['order_level'] = "level_" . $value_trigger;
    //                     }
    //                     $db_obj = $conn->sold_buy_orders->find($search);
    //                     $order_arr = iterator_to_array($db_obj);
    //                     $order_arr_all[$value][$value_trigger] = $order_arr;
    //                 }
    //             }
    //             $resultArr = $this->make_array_for_view($order_arr_all, 'trigger');
    //             $data['full_arr'] = $resultArr;
    //         }
			
		
			
			
	// 	$prefix                 = '';
	// 	foreach($data['full_arr'] as $key => $recordArr){
		
	// 			if($recordArr['barrier_percentile_trigger']){		  	
	// 			$percentile             = $recordArr['barrier_percentile_trigger'];	
	// 			      $prefix                    = '';
	// 				  if($percentile['opp']['op']!=0 && $percentile['opp']['op']!=''){ 
	// 					  $avg_profit_per        = $prefix . '' . ($percentile['avg_profit']) . ''; 
	// 					  $max_profit_5h_per     = $prefix . '' . ($percentile['max_profit_5h']) . ''; 
	// 					  $min_profit_5h_per     = $prefix . '' . ($percentile['min_profit_5h']) . ''; 
	// 					  $max_profit_high_per   = $prefix . '' . ($percentile['max_profit_high']) . ''; 
	// 					  $min_profit_low_per    = $prefix . '' . ($percentile['min_profit_low']) . ''; 
	// 					  $opp_per               = $prefix . '' . ($percentile['opp']['op']) . ''; 
	// 					  $prefix                = ', ';
	// 					  $final_Per[$key]['avg_profit_per']        =  $avg_profit_per;
	// 					  $final_Per[$key]['max_profit_5h_per']     =  $max_profit_5h_per;
	// 					  $final_Per[$key]['max_profit_5h_per']     =  $max_profit_5h_per;
	// 					  $final_Per[$key]['max_profit_high_per']   =  $max_profit_high_per;
	// 					  $final_Per[$key]['min_profit_low_per']    =  $min_profit_low_per;
	// 					  $final_Per[$key]['opp_per']               =  $opp_per;
						 
						    
	// 				  }else{
	// 					  $avg_profit_per        = $prefix . '' ;
	// 					  $max_profit_5h_per     = $prefix . '' ;
	// 					  $min_profit_5h_per     = $prefix . '' ;
	// 					  $max_profit_high_per   = $prefix . '' ;
	// 					  $min_profit_low_per    = $prefix . '' ;
	// 					  $opp_per               = $prefix . '' ; 
	// 					  $prefix                =  ', ';
	// 					  $final_Per[$key]       =  $avg_profit_per.$prefix.$max_profit_5h_per.$prefix.$max_profit_5h_per.$prefix.$max_profit_high_per.$prefix.$min_profit_low_per.$prefix.$opp_per ;
	// 				  }
	// 				  //echo "<pre>";  print_r( $final_Per); exit;   
	// 			}else if($recordArr['barrier_trigger']){
				  
	// 				  $barrier                = $recordArr['barrier_trigger'];	
	// 				  if($barrier['opp']['op']!=0 && $barrier['opp']['op']!=''){ 
	// 					  $avg_profit_bar         = $prefix . '' . ($barrier['avg_profit']) . ''; 
	// 					  $max_profit_5h_bar      = $prefix . '' . ($barrier['max_profit_5h']) . ''; 
	// 					  $min_profit_5h_bar      = $prefix . '' . ($barrier['min_profit_5h']) . ''; 
	// 					  $max_profit_high_bar    = $prefix . '' . ($barrier['max_profit_high']) . ''; 
	// 					  $min_profit_low_bar     = $prefix . '' . ($barrier['min_profit_low']) . ''; 
	// 					  $opp_bar                    = $prefix . '' . ($barrier['opp']['op']) . ''; 
	// 					  $prefix                 = ', '; 
	// 					  $final_Per[$key]        =  $avg_profit_per.$prefix.$max_profit_5h_per.$prefix.$max_profit_5h_per.$prefix.$max_profit_high_per.$prefix.$min_profit_low_per.$prefix.$opp_per ;
						  
	// 				  }else{
	// 					  $avg_profit_bar         = $prefix . '' ; 
	// 					  $max_profit_5h_bar      = $prefix . '' ; 
	// 					  $min_profit_5h_bar      = $prefix . '' ; 
	// 					  $max_profit_high_bar    = $prefix . '' ; 
	// 					  $min_profit_low_bar     = $prefix . '' ; 
	// 					  $opp_bar                    = $prefix . '' ;
	// 					  $prefix                 = ', ';
	// 					  $final_Per[$key]        =  $avg_profit_per.$prefix.$max_profit_5h_per.$prefix.$max_profit_5h_per.$prefix.$max_profit_high_per.$prefix.$min_profit_low_per.$prefix.$opp_per ;
	// 				  }
	// 			}else if($recordArr['box_trigger']){
			      
	// 				  $box                    = $recordArr['box_trigger'];
	// 				  if($box['opp']['op']!=0 && $box['opp']['op']!=''){ 			
	// 					  $avg_profit_box         = $prefix . '' . ($box['avg_profit']) . ''; 
	// 					  $max_profit_5h_box      = $prefix . '' . ($box['max_profit_5h']) . ''; 
	// 					  $min_profit_5h_box      = $prefix . '' . ($box['min_profit_5h']) . ''; 
	// 					  $max_profit_high_box    = $prefix . '' . ($box['max_profit_high']) . ''; 
	// 					  $min_profit_low_box     = $prefix . '' . ($box['min_profit_low']) . ''; 
	// 					  $opp_box                    = $prefix . '' . ($box['opp']['op']) . ''; 
	// 					  $prefix                 = ', ';
	// 					  $final_Per[$key]        =  $avg_profit_per.$prefix.$max_profit_5h_per.$prefix.$max_profit_5h_per.$prefix.$max_profit_high_per.$prefix.$min_profit_low_per.$prefix.$opp_box ;
	// 				  }else{
	// 					  $avg_profit_box         = $prefix . ''; 
	// 					  $max_profit_5h_box      = $prefix . '' ;
	// 					  $min_profit_5h_box      = $prefix . '' ;
	// 					  $max_profit_high_box    = $prefix . '' ;
	// 					  $min_profit_low_box     = $prefix . '' ;
	// 					  $opp_box                    = $prefix . '' ; 
	// 					  $prefix                 = ', ';
	// 					  $final_Per[$key]        =  $avg_profit_per.$prefix.$max_profit_5h_per.$prefix.$max_profit_5h_per.$prefix.$max_profit_high_per.$prefix.$min_profit_low_per.$prefix.$opp_box ;
	// 				  }
	// 			}
	// 			$onlyCoin  .= "'".$key."'".$prefix;
	// 	}
    //     //echo "<pre>";  print_r( $final_Per); exit;   
	// 	$data['final_arr']           =  $final_Per;
	// 	$data['onlyCoin']            =  $onlyCoin;
		
	// 	$data['avg_profit_per']      = $avg_profit_per;
	// 	$data['max_profit_5h_per']   = $max_profit_5h_per;
	// 	$data['min_profit_5h_per']   = $min_profit_5h_per;
	// 	$data['max_profit_high_per'] = $max_profit_high_per;
	// 	$data['min_profit_low_per']  = $min_profit_low_per;
		
	// 	$data['avg_profit_bar']      = $avg_profit_bar;
	// 	$data['max_profit_5h_bar']   = $max_profit_5h_bar;
	// 	$data['min_profit_5h_bar']   = $min_profit_5h_bar;
	// 	$data['max_profit_high_bar'] = $max_profit_high_bar;
	// 	$data['min_profit_low_bar']  = $min_profit_low_bar;
		
		
	// 	$data['avg_profit_box']      = $avg_profit_box;
	// 	$data['max_profit_5h_box']   = $max_profit_5h_box;
	// 	$data['min_profit_5h_box']   = $min_profit_5h_box;
	// 	$data['max_profit_high_box'] = $max_profit_high_box;
	// 	$data['min_profit_low_box']  = $min_profit_low_box;
		
		
		
	  	
		
    //     $this->stencil->paint('admin/highchart/high_opp_third', $data);
    // }
	
	
	
	
	// public function make_array_for_view($order_arr, $values) {
		
		
    //     if ($values == 'trigger') {
    //         if (!empty($order_arr)) {

    //             foreach ($order_arr as $coin_key => $coin_arr) {
    //                 $coin = $coin_key;
    //                 $coin_count = 0;
				
    //                 foreach ($coin_arr as $key => $value) {
						
						
						
    //                     $trigger = $key;
    //                     $trigger_count = count($value);
    //                     $coin_count += $trigger_count;

    //                     $market_heighest_value = array_column($value, 'market_heighest_value');
    //                     $market_lowest_value   = array_column($value, 'market_lowest_value');
    //                     $five_hour_max_market_price = array_column($value, '5_hour_max_market_price');
    //                     $five_hour_min_market_price = array_column($value, '5_hour_min_market_price');

    //                     $max_high = max($market_heighest_value);
    //                     $min_high = min($market_heighest_value);
    //                     $max_low = max($market_lowest_value);
    //                     $min_low = min($market_lowest_value);

    //                     $market_heighest_value = array_filter($market_heighest_value);
    //                     $max_high_average = array_sum($market_heighest_value) / count($market_heighest_value);

    //                     $market_lowest_value = array_filter($market_lowest_value);
    //                     $max_low_average = array_sum($market_lowest_value) / count($market_lowest_value);

    //                     $five_hour_max_market_price = array_filter($five_hour_max_market_price);
    //                     $high_five_average = array_sum($five_hour_max_market_price) / count($five_hour_max_market_price);

    //                     $five_hour_min_market_price = array_filter($five_hour_min_market_price);
    //                     $low_five_average = array_sum($five_hour_min_market_price) / count($five_hour_min_market_price);

    //                     $max_high_five = max($five_hour_max_market_price);
    //                     $min_high_five = min($five_hour_max_market_price);
    //                     $max_low_five = max($five_hour_min_market_price);
    //                     $min_low_five = min($five_hour_min_market_price);

    //                     $a = array_filter($a);
    //                     $average = array_sum($a) / count($a);

    //                     $avg_profit   = 0;
    //                     $total_profit = 0;
    //                     $total_quantity = 0;
    //                     $winning = 0;
    //                     $losing  = 0;
    //                     $top1    = 0;
    //                     $top2    = 0;
    //                     $bottom2 = 0;

    //                     $max_profit_per = array();
    //                     $min_profit_per1 = array();
    //                     $max_profit_pert = array();
    //                     $min_profit_per2 = array();

    //                     $opp = $this->calculate_no_of_oppurtunities($coin, $value);
					
    //                     foreach ($value as $col => $row) {
							
							  
    //                         if (!empty($row)) {

    //                             if (isset($row['5_hour_max_market_price']) && $row['5_hour_max_market_price'] != '') {

    //                                 $five_hour_max_market_price = $row['5_hour_max_market_price'];
    //                                 $purchased_price = (float) $row['market_value'];
    //                                 $profit = $five_hour_max_market_price - $purchased_price;

    //                                 $profit_margin = ($profit / $five_hour_max_market_price) * 100;

    //                                 $max_profit_per_5 = ($profit) * (100 / $purchased_price);

    //                                 $max_profit_per[] = number_format($max_profit_per_5, 2);
    //                             }

    //                             if (isset($row['5_hour_min_market_price']) && $row['5_hour_min_market_price'] != '') {

    //                                 $market_lowest_value = $row['5_hour_min_market_price'];
    //                                 $purchased_price = (float) $row['market_value'];
    //                                 $profit = $market_lowest_value - $purchased_price;

    //                                 $profit_margin = ($profit / $market_lowest_value) * 100;

    //                                 $min_profit_per_5 = ($profit) * (100 / $purchased_price);
    //                                 $min_profit_per1[] = number_format($min_profit_per_5, 2);
    //                             }

    //                             if (isset($row['market_heighest_value']) && $row['market_heighest_value'] != '') {

    //                                 $five_hour_max_market_price1 = $row['market_heighest_value'];
    //                                 $purchased_price1 = (float) $row['market_value'];
    //                                 $profit1 = $five_hour_max_market_price1 - $purchased_price1;

    //                                 $profit_margin1 = ($profit1 / $five_hour_max_market_price1) * 100;

    //                                 $max_profit_per_t = ($profit1) * (100 / $purchased_price1);

    //                                 $max_profit_pert[] = number_format($max_profit_per_t, 2);
    //                             }

    //                             if (isset($row['market_lowest_value']) && $row['market_lowest_value'] != '') {

    //                                 $market_lowest_value2 = $row['market_lowest_value'];
    //                                 $purchased_price2 = (float) $row['market_value'];
    //                                 $profit2 = $market_lowest_value2 - $purchased_price2;

    //                                 $profit_margin2 = ($profit2 / $market_lowest_value2) * 100;

    //                                 $min_profit_per2_t = ($profit2) * (100 / $purchased_price2);
    //                                 $min_profit_per2[] = number_format($min_profit_per2_t, 2);
    //                             }

    //                             $total_sold_orders++;
    //                             $market_sold_price = $row['market_sold_price'];
    //                             $current_order_price = $row['market_value'];
    //                             $quantity = $row['quantity'];

    //                             $current_data2222 = $market_sold_price - $current_order_price;
    //                             $profit_data = ($current_data2222 * 100 / $market_sold_price);
    //                             if ($profit_data > 0) {
    //                                 $winning++;
    //                             } elseif ($profit_data < 0) {
    //                                 $losing++;
    //                             }

    //                             if ($profit_data >= 1 && $profit_data <= 2) {
    //                                 $top1++;
    //                             }
    //                             if ($profit_data >= 2) {
    //                                 $top2++;
    //                             }
    //                             if ($profit_data <= -2) {
    //                                 $bottom2++;
    //                             }
    //                             $profit_data = $profit_data; //- 0.4;
    //                             $profit_data = number_format((float) $profit_data, 2, '.', '');
    //                             $total_btc = $quantity * (float) $current_order_price;
    //                             $total_profit += $total_btc * $profit_data;
    //                             $total_quantity += $total_btc;
    //                         }
    //                     }
    //                     if ($total_quantity == 0) {
    //                         $total_quantity = 1;
    //                     }
    //                     $avg_profit = $total_profit / $total_quantity;

    //                     $max_profit_5h = (array_sum($max_profit_per) / count($max_profit_per));
    //                     $min_profit_5h = (array_sum($min_profit_per1) / count($min_profit_per1));
    //                     $max_profit_high = (array_sum($max_profit_pert) / count($max_profit_pert));
    //                     $min_profit_low = (array_sum($min_profit_per2) / count($min_profit_per2));

    //                     $retArr = array(
    //                         'trigger_count' => $trigger_count,
    //                         'avg_profit' => number_format($avg_profit, 2),
    //                         'max_high_average' => num($max_high_average),
    //                         'max_low_average' => num($max_low_average),
    //                         'high_five_average' => num($high_five_average),
    //                         'low_five_average' => num($low_five_average),
    //                         'max_profit_5h' => number_format($max_profit_5h, 2),
    //                         'min_profit_5h' => number_format($min_profit_5h, 2),
    //                         'max_profit_high' => number_format($max_profit_high, 2),
    //                         'min_profit_low' => number_format($min_profit_low, 2),
    //                         'winning_trades' => $winning,
    //                         'losing_trades' => $losing,
    //                         'top_1_per' => $top1,
    //                         'top_2_per' => $top2,
    //                         'bottom_2_per' => $bottom2,
    //                         'opp' => $opp,
    //                     );
    //                     $t_arr[$trigger] = $retArr;
						
    //                 }
    //                 $my_coin_data = $this->get_order_arr($coin_arr, $coin);
    //                 $t_arr['coin_meta'] = $my_coin_data;
    //                 $finalArray[$coin] = $t_arr;	
    //             }
    //         }
    //     }
    //     return $finalArray;
    // }
	
	// public function get_order_arr($order_arr, $coin) {

    //     foreach ($order_arr as $key1 => $value_arr) {
    //         foreach ($value_arr as $key2 => $value2) {
    //             $barrier[] = $value2;
    //         }
    //     }

    //     if (count($barrier)) {
    //         array_multisort(array_column($barrier, "created_date"), SORT_ASC, $barrier);

    //         $start_date = $barrier[0]['created_date']->toDatetime()->format("Y-m-d H:i:s");
    //         $end_date = $barrier[count($barrier) - 1]['created_date']->toDatetime()->format("Y-m-d H:i:s");
    //         $first_price = $barrier[0]['market_value'];
    //         $last_price = $barrier[count($barrier) - 1]['market_value'];

    //         $coin_avg_move = (($last_price - $first_price) / $first_price) * 100;

    //         $high_low_arr = $this->get_high_low_value($coin, $start_date, $end_date);

    //         $returnArr = $high_low_arr;
    //         $returnArr['coin_avg_move'] = number_format($coin_avg_move, 2);
    //         $returnArr['total'] = count($barrier);
    //         return $returnArr;
    //     } else {
    //         return array();
    //     }

    // } //End of get_order_arr

    // public function calculate_no_of_oppurtunities($coin, $trades) {
    //     $old_time = "";
    //     $op = 0;
    //     $tempArr = array();
    //     array_multisort(array_column($trades, "created_date"), SORT_ASC, $trades);
    //     foreach ($trades as $key => $value) {
    //         $time = $value['created_date']->toDateTime()->format("Y-m-d H");
    //         if ($time != $old_time) {
    //             $op++;
    //             $old_time = $time;
    //             $tempArr[$time][] = $value;
    //         } else {
    //             $tempArr[$time][] = $value;
    //         }
    //     }
    //     $retArr = array();
    //     foreach ($tempArr as $key => $value) {
    //         $profit_data = 0;
    //         $total_btc = 0;
    //         $total_profit = 0;
    //         $total_quantity = 0;
    //         $avg_profit = 0;
    //         $total_sold_orders = 0;
    //         $max_profit_per = array();
    //         $min_profit_per1 = array();
    //         $max_profit_pert = array();
    //         $min_profit_per2 = array();
    //         $first_buy_price = $value[0]['market_value'];
    //         $first_sell_price = $value[0]['market_sold_price'];
    //         foreach ($value as $key_1 => $valueArr) {
    //             $total_sold_orders++;

    //             if (isset($valueArr['5_hour_max_market_price']) && $valueArr['5_hour_max_market_price'] != '') {

    //                 $five_hour_max_market_price = $valueArr['5_hour_max_market_price'];
    //                 $purchased_price = (float) $valueArr['market_value'];
    //                 $profit = $five_hour_max_market_price - $purchased_price;

    //                 $profit_margin = ($profit / $five_hour_max_market_price) * 100;

    //                 $max_profit_per_5 = ($profit) * (100 / $purchased_price);

    //                 $max_profit_per[] = number_format($max_profit_per_5, 2);
    //             }

    //             if (isset($valueArr['5_hour_min_market_price']) && $valueArr['5_hour_min_market_price'] != '') {

    //                 $market_lowest_value = $valueArr['5_hour_min_market_price'];
    //                 $purchased_price = (float) $valueArr['market_value'];
    //                 $profit = $market_lowest_value - $purchased_price;

    //                 $profit_margin = ($profit / $market_lowest_value) * 100;

    //                 $min_profit_per_5 = ($profit) * (100 / $purchased_price);
    //                 $min_profit_per1[] = number_format($min_profit_per_5, 2);
    //             }

    //             if (isset($valueArr['market_heighest_value']) && $valueArr['market_heighest_value'] != '') {

    //                 $five_hour_max_market_price1 = $valueArr['market_heighest_value'];
    //                 $purchased_price1 = (float) $valueArr['market_value'];
    //                 $profit1 = $five_hour_max_market_price1 - $purchased_price1;

    //                 $profit_margin1 = ($profit1 / $five_hour_max_market_price1) * 100;

    //                 $max_profit_per_t = ($profit1) * (100 / $purchased_price1);

    //                 $max_profit_pert[] = number_format($max_profit_per_t, 2);
    //             }

    //             if (isset($valueArr['market_lowest_value']) && $valueArr['market_lowest_value'] != '') {

    //                 $market_lowest_value2 = $valueArr['market_lowest_value'];
    //                 $purchased_price2 = (float) $valueArr['market_value'];
    //                 $profit2 = $market_lowest_value2 - $purchased_price2;

    //                 $profit_margin2 = ($profit2 / $market_lowest_value2) * 100;

    //                 $min_profit_per2_t = ($profit2) * (100 / $purchased_price2);
    //                 $min_profit_per2[] = number_format($min_profit_per2_t, 2);
    //             }

    //             $market_sold_price = $valueArr['market_sold_price'];
    //             $current_order_price = $valueArr['market_value'];
    //             $quantity = $valueArr['quantity'];
    //             $current_data2222 = $market_sold_price - $current_order_price;
    //             $profit_data = ($current_data2222 * 100 / $market_sold_price);
    //             $profit_data = number_format((float) $profit_data, 2, '.', '');
    //             $total_btc = $quantity * (float) $current_order_price;
    //             $total_profit += $total_btc * $profit_data;
    //             $total_quantity += $total_btc;
    //         }
    //         if ($total_quantity == 0) {
    //             $total_quantity = 1;
    //         }
    //         $max_profit_5h = (array_sum($max_profit_per) / count($max_profit_per));
    //         $min_profit_5h = (array_sum($min_profit_per1) / count($min_profit_per1));
    //         $max_profit_high = (array_sum($max_profit_pert) / count($max_profit_pert));
    //         $min_profit_low = (array_sum($min_profit_per2) / count($min_profit_per2));
    //         $avg_profit = $total_profit / $total_quantity;

    //         $retArr['avg'][$key]['count'] = $total_sold_orders;
    //         $retArr['avg'][$key]['avg'] = $avg_profit;

    //         $retArr['avg'][$key]['max_profit_5h'] = $max_profit_5h;
    //         $retArr['avg'][$key]['min_profit_5h'] = $min_profit_5h;

    //         $retArr['avg'][$key]['first_sell_price'] = $first_sell_price;
    //         $retArr['avg'][$key]['first_buy_price'] = $first_buy_price;

    //         $retArr['avg'][$key]['max_profit_high'] = $max_profit_high;
    //         $retArr['avg'][$key]['min_profit_low'] = $min_profit_low;

    //         $five_hr_up_down = $this->get_high_low_value($coin, $key . ":00:00", date("Y-m-d H:i:s", strtotime("+5 hours", strtotime($key . ":00:00"))));
    //         $retArr['avg'][$key]['high_low'] = $five_hr_up_down;

    //     }
    //     // echo "<pre>";
    //     // print_r($tempArr);

    //     //print_me($retArr['avg'], 'waqar');
    //     $retArr['op'] = $op;
    //     return $retArr;
    // }

    // public function get_high_low_value($symbol, $start_date, $end_date) {
    //     // $start_date = "2019-02-01 00:00:00";
    //     // $end_date = "2019-03-15 00:00:00";

    //     $search_arr['coin'] = $symbol;
    //     $search_arr['timestampDate']['$gte'] = $this->mongo_db->converToMongodttime($start_date);
    //     $search_arr['timestampDate']['$lte'] = $this->mongo_db->converToMongodttime($end_date);

    //     $this->mongo_db->where($search_arr);
    //     $curser = $this->mongo_db->get("market_chart");
    //     $result = iterator_to_array($curser);

    //     $high_arr = array_column($result, 'high');
    //     $low_arr = array_column($result, 'low');

    //     $high = max($high_arr);
    //     $low = min($low_arr);

    //     return array("high" => $high, "low" => $low);

    // }
	
	// public function getHoghchartData(){
		
	// }
}