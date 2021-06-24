<?php
/** Rueles Order Listings **/
class Rules_order extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        //load main template
        ini_set("memory_limit", -1);
        $this->stencil->layout('admin_layout');
        //load required slices
        $this->stencil->slice('admin_header_script');
        $this->stencil->slice('admin_header');
        $this->stencil->slice('admin_left_sidebar');
        $this->stencil->slice('admin_footer_script');
        //load models
        $this->load->model('admin/mod_rulesorder');
		$this->load->model('admin/mod_dashboard');
        $this->load->model('admin/mod_login');
        $this->mod_login->verify_is_admin_login();
        if ($this->session->userdata('special_role')!= 1) {
            redirect(base_url() . 'forbidden');
        }
    }
    // public function listing()
    // {
    //     $resultsArrAll                           = $this->mod_rulesorder->rulesOrderRecord();
    //     $data['record_of_rules_for_orders_type'] = $resultsArrAll['record_of_rules_for_orders_type'];
    //     $data['record_of_rules_for_orders_rule'] = $resultsArrAll['record_of_rules_for_orders_rule'];
		
    //     $this->stencil->paint('admin/rules_order/rules_order_listing', $data);
    // }//listing
	
    // public function show_order($rule)
    // {
    //     //Login Check
    //     $this->mod_login->verify_is_admin_login();
    //     $error = array();
    //     //*************************Pagination Code****************************//
    //     $this->load->library("pagination");
    //     $resultsArrAll                = $this->mod_rulesorder->show_count_all($rule);
    //     $count                        = $resultsArrAll;
    //     $config                       = array();
    //     $config["base_url"]           = SURL . "admin/rules-order/show_order";
    //     $config["total_rows"]         = $count;
    //     $config['per_page']           = 1000;
    //     $config['num_links']          = 3;
    //     $config['use_page_numbers']   = TRUE;
    //     $config['uri_segment']        = 4;
    //     $config['reuse_query_string'] = TRUE;
    //     $config["first_tag_open"]     = '<li>';
    //     $config["first_tag_close"]    = '</li>';
    //     $config["last_tag_open"]      = '<li>';
    //     $config["last_tag_close"]     = '</li>';
    //     $config['next_link']          = '&raquo;';
    //     $config['next_tag_open']      = '<li>';
    //     $config['next_tag_close']     = '</li>';
    //     $config['prev_link']          = '&laquo;';
    //     $config['prev_tag_open']      = '<li>';
    //     $config['prev_tag_close']     = '</li>';
    //     $config['first_link']         = 'First';
    //     $config['last_link']          = 'Last';
    //     $config['full_tag_open']      = '<ul class="pagination">';
    //     $config['full_tag_close']     = '</ul>';
    //     $config['cur_tag_open']       = '<li class="active"><a href="#"><b>';
    //     $config['cur_tag_close']      = '</b></a></li>';
    //     $config['num_tag_open']       = '<li>';
    //     $config['num_tag_close']      = '</li>';
    //     $this->pagination->initialize($config);
    //     $page = $this->uri->segment(4);
    //     if (!isset($page)) { $page = 1;}
    //     $start                    = ($page - 1) * $config["per_page"];
    //     //*************************Pagination Code****************************//
    //     $order_arr                = $this->mod_rulesorder->showOrderRecord($start, $config["per_page"], $rule);
    //     $page_links               = $this->pagination->create_links();
    //     // Data To be send
    //     $data['rules_orders_arr'] = $order_arr;
    //     $data['count']            = $count;
    //     $data['error']            = $ErrorInOrder;
    //     $data['page_links']       = $page_links;
    
    //     $this->stencil->paint('admin/rules_order/show_rules_order_listing', $data);
    // }//show_order
	
    // public function rule_set()
    // {
    //     $global_symbol         = $this->session->userdata('global_symbol');
    //     $global_mode           = 'live';
	//     $resultsArrAll         = $this->mod_rulesorder->rulesSet($global_symbol, $global_mode);
    //     $data['rules_set_arr'] = $resultsArrAll;
		
    //     $this->stencil->paint('admin/rules_order/rules_set', $data);
    // }//rule_set
	
	// public function grid_rules()
    // {
	// 	$global_symbol         = $this->session->userdata('global_symbol');
	// 	$testing               = $this->input->get('testing');
	// 	$global_mode           = 'live';
	// 	$trigger_type          = 'barrier_percentile_trigger';	 // barrier_percentile_trigger  //barrier_trigger
	// 	$getAllCoin            = $this->mod_rulesorder->getAllCoin();
		
	// 	$percentil_arr         = $this->mod_rulesorder->barr_percentile_coin_meta($coin='NCASHBTC');
	// 	$percentil             = (array)$percentil_arr[0];
		
		
	// 	$rules_set_arr = $this->mod_rulesorder->box_trigger($global_symbol, $global_mode,$trigger_type);		
	// 	//$resultsArrAll         = $this->mod_rulesorder->box_trigger($global_symbol, $global_mode ,$trigger_type);
	// 	//Testing section goes here 
	// 	$data['coinArrList']   = $getAllCoin;
	// 	$data['testing']       = $testing;
	// 	$data['avgProfit']     = $avgProfit;
    //     $data['rules_set_arr'] = $resultsArrAll;
	// 	$data['global_symbol'] = $global_symbol;
	// 	$data['trigger_type']  = $trigger_type;
		
		
    //     $this->stencil->paint('admin/rules_order/boxtrigger', $data);
    // }//grid_rules
	
	// public function compare_rule()
    // {
		
	// 	$global_symbol         = $this->session->userdata('global_symbol');
	// 	$testing               = $this->input->get('testing');
	// 	$global_mode           = 'live';
	// 	$rule                  = 1;
		
	// 	$trigger_type          = 'barrier_trigger';	 // barrier_percentile_trigger  //barrier_trigger
	// 	$getAllCoin            = $this->mod_rulesorder->getAllCoin();
	// 	$resultsArrAll         = $this->mod_rulesorder->box_trigger_rule($rule, $global_mode ,$trigger_type);
		
	// 	//Testing section goes here 
	// 	$data['coinArrList']   = $getAllCoin;
	// 	$data['testing']       = $testing;
	// 	$data['avgProfit']     = $avgProfit;
    //     $data['rules_set_arr'] = $resultsArrAll;
	// 	$data['global_symbol'] = $global_symbol;
	// 	$data['trigger_type']  = $trigger_type;
		
		
    //     $this->stencil->paint('admin/rules_order/compare_rule', $data);
    // }//compare_rule
	
	//  public function get_all_orders($user_id, $start_date, $end_date, $status) {
	// 	//Check Filter Data
	// 	$session_post_data = $filter_array;
	// 	$search_array = array('admin_id' => $user_id);
	// 	//$search_array = array('admin_id'=> $admin_id);
	// 	if ($start_date != "" && $end_date != "") {

	// 		$created_datetime = date('Y-m-d G:i:s', strtotime($start_date));
	// 		$orig_date = new DateTime($created_datetime);
	// 		$orig_date = $orig_date->getTimestamp();
	// 		$start_date1 = new MongoDB\BSON\UTCDateTime($orig_date * 1000);

	// 		$created_datetime22 = date('Y-m-d G:i:s', strtotime($end_date));
	// 		$orig_date22 = new DateTime($created_datetime22);
	// 		$orig_date22 = $orig_date22->getTimestamp();
	// 		$end_date1 = new MongoDB\BSON\UTCDateTime($orig_date22 * 1000);
	// 		$search_array['created_date'] = array('$gte' => $start_date1, '$lte' => $end_date1);
	// 	}

	// 	$connetct = $this->mongo_db->customQuery();

	// 	if ($status == 'open' || $status == 'sold') {
	// 		if ($status == 'open') {

	// 			$search_array['status'] = 'FILLED';
	// 			$search_array['is_sell_order'] = 'yes';
	// 			$cursor = $connetct->buy_orders->find($search_array);

	// 		} elseif ($status == 'sold') {

	// 			$search_array['status'] = 'FILLED';
	// 			$search_array['is_sell_order'] = 'sold';
	// 			$cursor = $connetct->buy_orders->find($search_array);

	// 		}
	// 	} elseif ($status == 'all') {
	// 		$search_array['status'] = array('$in' => array('error', 'canceled', 'submitted'));
	// 		$cursor = $connetct->buy_orders->find($search_array);

	// 	} else {

	// 		$search_array['status'] = $status;
	// 		$cursor = $connetct->buy_orders->find($search_array);

	// 	}
	// 	$responseArr = iterator_to_array($cursor);

	// 	$fullarray = array();
	// 	foreach ($responseArr as $valueArr) {

	// 		$returArr = array();
	// 		$profit = 0;
	// 		if (!empty($valueArr)) {

	// 			$datetime = $valueArr['created_date']->toDateTime();
	// 			$created_date = $datetime->format(DATE_RSS);

	// 			$datetime = new DateTime($created_date);
	// 			$datetime->format('Y-m-d g:i:s A');

	// 			$new_timezone = new DateTimeZone('Asia/Karachi');
	// 			$datetime->setTimezone($new_timezone);
	// 			$formated_date_time = $datetime->format('Y-m-d g:i:s A');

	// 			$returArr['id'] = (string) $valueArr['_id'];
	// 			$returArr['purchased_price'] = $valueArr['market_value'];
	// 			$returArr['sold_price'] = $valueArr['market_sold_price'];
	// 			$profit = ((($returArr['sold_price'] - $returArr['purchased_price']) / $returArr['purchased_price']) * 100);
	// 			$returArr['profit_loss_percentage'] = number_format($profit, 2);
	// 			$returArr['coin'] = $valueArr['symbol'];
	// 			$returArr['quantity'] = $valueArr['quantity'];
	// 			$returArr['order_type'] = $valueArr['order_type'];
	// 			if ($valueArr['status'] == 'FILLED' && $valueArr['is_sell_order'] == 'yes') {
	// 				$returArr['status'] = 'open';
	// 			}
	// 			if ($valueArr['status'] == 'FILLED' && $valueArr['is_sell_order'] == 'sold') {
	// 				$returArr['status'] = 'sold';
	// 			}
	// 			$returArr['user_id'] = $valueArr['admin_id'];
	// 			$returArr['created_date'] = $formated_date_time;

	// 		}

	// 		$fullarray[] = $returArr;
	// 	}
	// 	return $fullarray;

	// }//get_all_orders
	
	//  public function get_rulesOrderProfit_ajax()
    //  {
    //     $order_mode    = $this->input->post('order_mode');
    //     $coin          = $this->input->post('coin');
	// 	$triggers_type = $this->input->post('triggers_type');
	// 	$userID        = $this->input->post('userID');
	// 	$start_date    = $this->input->post('start_date');
	// 	$end_date      = $this->input->post('end_date');
		
    //     $rulesOrderProfitLoss_arr = $this->mod_rulesorder->rulesOrderProfitLoss($coin, $order_mode,$triggers_type,$userID,$start_date,$end_date);
		
    //     if ($rulesOrderProfitLoss_arr) {
    //         $json_array['success'] = true;
    //         $json_array['html']    = $html;
    //     } else {
    //         $json_array['success'] = false;
    //         $json_array['html']    = '<div class="alert alert-danger"> No rule found here.</div>';
    //     }
    //     echo json_encode($json_array);
    //     exit;
    // } //End  get_rulesOrderProfit_ajax
	
	
	//  public function get_global_boxtrigger_ajax(){
		
	// 	$order_mode    = $this->input->post('order_mode');
    //     $coin          = $this->input->post('coin');
	// 	$triggers_type = $this->input->post('triggers_type');
		
    //     $rules_set_arr = $this->mod_rulesorder->box_trigger($coin, $order_mode,$triggers_type);
		
		
	// 	//echo "<pre>";  print_r($rules_set_arr); exit;
		
	// 	$percentil_arr = $this->mod_rulesorder->percentile_coin_meta($coin);
	// 	$percentil     = (array)$percentil_arr[0];	
		
	// 	$html  = '';
			
	// 	if($triggers_type=='trigger_1'){
	// 			$html .= ' <div class="triggercls trg_trigger_1 " > <div class="col-md-12 appnedAjax" >
	// 			 <table class="table table-bordered table-condensed table-striped table-primary table-vertical-center checkboxs">
	// 					<thead>
	// 					  <tr>
	// 						<th class="center" style="background:#4267b2; color:#FFF;"></th>
	// 						<th class="center" style="background:#4267b2; color:#FFF;"></th>
	// 					  </tr>  
	// 					</thead>
	// 					<tbody>';
						
	// 		$cancel                         = '';
	// 		$look_back_hour                 = '';
	// 		$bottom_demand_rejection        = '';
	// 		$bottom_supply_rejection        = '';
	// 		$check_high_open                = '';
	// 		$is_previous_blue_candle        = '';
	// 		$aggressive_stop_rule           = '';
	// 		$apply_factor                   = '';
	// 		$buy_virtural_rule_             = '';

	// 		if ($rules_set_arr['cancel_trade'] == 'cancel') {
	// 			$cancel .= '<td>' .'<span class="label label-success">YES</span>' . '</td>';
	// 			$look_back_hour .= '<td>' . $rules_set_arr['look_back_hour'] . '</td>';
	// 		} else {
	// 			$cancel .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
	// 			$look_back_hour .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
	// 		}
			
		
	// 		if($rules_set_arr['aggressive_stop_rule']=='stop_loss_rule_1') {
	// 		   $aggressive_stop_rule .= '<td>' .'<span class="label label-success">S L R 1</span>' . '</td>';	
	// 		}else if($rules_set_arr['aggressive_stop_rule']=='stop_loss_rule_2') {
	// 		   $aggressive_stop_rule .= '<td>' .'<span class="label label-success">S L R 2</span>' . '</td>';		
	// 		}else if($rules_set_arr['aggressive_stop_rule']=='stop_loss_rule_3') {
	// 		   $aggressive_stop_rule .= '<td>' .'<span class="label label-success">S L R 3</span>' . '</td>';	 		
	// 		}else if($rules_set_arr['aggressive_stop_rule']=='stop_loss_rule_big_wall') {
	// 			$aggressive_stop_rule .= '<td>' .'<span class="label label-success">S L R B W</span>' . '</td>';	
	// 		}else{
    //             $aggressive_stop_rule .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //         }
			
	// 		if ($rules_set_arr['buy_virtual_barrier_rule_' . $rule_numbernn . '_enable'] == 'yes') {
	// 			$buy_virtural_rule_ .= '<td>' . $rules_set_arr['buy_virtural_rule_' . $rule_numbernn . ''] . '</td>';
	// 		} else {
	// 			$buy_virtural_rule_ .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
	// 		}
			
	// 		$apply_factor .= '<td>' . $rules_set_arr['apply_factor'] . '</td>';
			   
	// 		if ($rules_set_arr['bottom_demand_rejection'] == 'yes') {
	// 			$bottom_demand_rejection .= '<td>' .'<span class="label label-success">YES</span>' . '</td>';
	// 		} else {
	// 			$bottom_demand_rejection .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
	// 		}
			
	// 		if ($rules_set_arr['bottom_supply_rejection'] == 'yes') {
	// 			$bottom_supply_rejection .= '<td>' .'<span class="label label-success">YES</span>' . '</td>';
	// 		} else {
	// 			$bottom_supply_rejection .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
	// 		}
		
	// 		if ($rules_set_arr['check_high_open'] == 'yes') {
	// 			$check_high_open .= '<td>' .'<span class="label label-success">YES</span>' . '</td>';
	// 		} else {
	// 			$check_high_open .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
	// 		}
			
			
	// 		if ($rules_set_arr['is_previous_blue_candle'] == 'yes') {
	// 			$is_previous_blue_candle .= '<td>' .'<span class="label label-success">YES</span>' . '</td>';
	// 		} else {
	// 			$is_previous_blue_candle .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
	// 		}
			
	// 				$html .= '<tr class="center"><th>Cancel Trade</th>'. $cancel.'';
	// 				$html .= '<tr class="center">
	// 				       <th>Aggressive stop rule</th> '. $aggressive_stop_rule .'
	// 				       </tr> <tr class="center"> <th>Trigger Rule</th>
	// 				       ' . $buy_trigger_type_ruleAll . '
	// 				       </tr>';
					
	// 				$html .= '   <tr class="center">
	// 				      <th>Stop loss factor</th>'. $apply_factor .'
	// 				      </tr>';
					
	// 				$html .= '	 </tr> <tr class="center">
	// 						<th>look back hour to cancel trade</th>'. $look_back_hour.'
	// 					  </tr>
						 
	// 					  <tr class="center">
	// 						<th>Bottom Demand Rejection</th>'. $bottom_demand_rejection.'
	// 					  </tr>
	// 					  <tr class="center">
	// 						<th>Bottom Supply Rejection</th>'. $bottom_supply_rejection.'
	// 					 </tr>
	// 					  <tr class="center">
	// 						<th> Check Heigh Open</th>
	// 						'. $check_high_open.'
	// 					  </tr>
	// 					  <tr class="center">
	// 						<th>is_previous_blue_candle</th>'. $is_previous_blue_candle.'
	// 					 </tr>
	// 					</tbody>
	// 				  </table>
	// 			 </div> </div> ';
	// 	}
	// 	else if($triggers_type=='trigger_2'){
	// 			$html .= ' <div class="triggercls trg_trigger_2" ><div class="col-md-12 appnedAjax" >
	// 			 <table class="table table-bordered zama_th">
	// 					<thead>
	// 					  <tr>
	// 						<th class="center" style="background:#4267b2; color:#FFF;"></th>
	// 						<th class="center" style="background:#4267b2; color:#FFF;"></th>
							
	// 					  </tr>  
	// 					</thead>
	// 					<tbody>';
						
    //             $cancel                   = '';
    //             $look_back_hour           = '';
    //             $bottom_demand_rejection  = '';
    //             $bottom_supply_rejection  = '';
    //             $check_high_open          = '';
    //             $is_previous_blue_candle  = '';
    //             $aggressive_stop_rule     = '';
    //             $apply_factor             ='';


    //             if ($rules_set_arr['cancel_trade'] == 'cancel') {
    //                 $cancel .= '<td>' .'<span class="label label-success">YES</span>' . '</td>';
    //                 $look_back_hour .= '<td>' . $rules_set_arr['look_back_hour'] . '</td>';
    //             } else {
    //                 $cancel .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 $look_back_hour .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //             }
                
    //                 if($rules_set_arr['aggressive_stop_rule']=='stop_loss_rule_1') {
    //                 $aggressive_stop_rule .= '<td>' .'<span class="label label-success">S L R 1</span>' . '</td>';	
    //                 }else if($rules_set_arr['aggressive_stop_rule']=='stop_loss_rule_2') {
    //                 $aggressive_stop_rule .= '<td>' .'<span class="label label-success">S L R 2</span>' . '</td>';		
    //                 }else if($rules_set_arr['aggressive_stop_rule']=='stop_loss_rule_3') {
    //                 $aggressive_stop_rule .= '<td>' .'<span class="label label-success">S L R 3</span>' . '</td>';	 		
    //                 }else if($rules_set_arr['aggressive_stop_rule']=='stop_loss_rule_big_wall') {
    //                     $aggressive_stop_rule .= '<td>' .'<span class="label label-success">S L R B W</span>' . '</td>';	
    //                 }else{
    //                     $aggressive_stop_rule .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                
    //             $apply_factor .= '<td>' . $rules_set_arr['apply_factor'] . '</td>';
                
    //             if ($rules_set_arr['bottom_demand_rejection'] == 'yes') {
    //                 $bottom_demand_rejection .= '<td>' .'<span class="label label-success">YES</span>' . '</td>';
    //             } else {
    //                 $bottom_demand_rejection .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //             }
                
    //             if ($rules_set_arr['bottom_supply_rejection'] == 'yes') {
    //                 $bottom_supply_rejection .= '<td>' .'<span class="label label-success">YES</span>' . '</td>';
    //             } else {
    //                 $bottom_supply_rejection .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //             }
                
    //             if ($rules_set_arr['check_high_open'] == 'yes') {
    //                 $check_high_open .= '<td>' .'<span class="label label-success">YES</span>' . '</td>';
    //             } else {
    //                 $check_high_open .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //             }
                
    //             if ($rules_set_arr['is_previous_blue_candle'] == 'yes') {
    //                 $is_previous_blue_candle .= '<td>' .'<span class="label label-success">YES</span>' . '</td>';
    //             } else {
    //                 $is_previous_blue_candle .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //             }
                        
    //             $html .= '  <tr class="center">
    //                         <th>Cancel Trade</th>'. $cancel.'';
                
    //             $html .= '  <tr class="center">
    //                         <th>Aggressive stop rule</th>'. $aggressive_stop_rule .'
    //                         </tr>';		 
    //             $html .= '  <tr class="center">
    //                         <th>Stop loss factor</th>'. $apply_factor .'
    //                         </tr>';	
    //             $html .= '	 </tr>
    //                             <tr class="center">
    //                                 <th>look back hour to cancel trade</th>
                                
    //             '. $look_back_hour.'
                
    //                             </tr>
    //                             <tr class="center">
    //                                 <th>Bottom Demand Rejection</th>
                        
    //             '. $bottom_demand_rejection.'
                            
    //                             </tr>
    //                             <tr class="center">
    //                                 <th>Bottom Supply Rejection</th>
                                    
                                
    //             '. $bottom_supply_rejection.'
                
    //                             </tr>
    //                             <tr class="center">
    //                                 <th> Check Heigh Open</th>
    //                                 '. $check_high_open.'
    //                             </tr>
    //                             <tr class="center">
    //                                 <th>is_previous_blue_candle</th>
                                
    //             '. $is_previous_blue_candle.'

    //                             </tr>
    //                             </tbody>
    //                         </table>
    //                     </div></div> ';
    //             }
    //             else if($triggers_type=='box_trigger_3'){
                    
    //             $html .= '<div class="col-md-12 appnedAjax" >
    //                     <div class="tab-content ">
    //                     <table class="table table-bordered zama_th">
    //                     <thead>
    //                         <tr>
    //                         <th class="" style="background:#4267b2; color: #FFF;">'.$global_symbol.'</th>';
            
    //         $level_number = 1;
    //         foreach($rules_set_arr as $row){ 
            
    //         if ($row['trigger_level'] == 'level_'.$level_number ) {
    //                         $html .= '<th class="center" style="background:#4267b2; color: #FFF;">Level '.$level_number.'</th>';
    //             }   
    //                 $level_number++;
    //         }
    //                         $html .= '</tr>
    //                     </thead>
    //                     <tbody>';
                        
    //         $box_trigger_score                            = '';
    //         $apply_factor                                 = '';
    //         $look_back_hour                               = '';
    //         $bottom_demand_rejection                      = '';
    //         $bottom_supply_rejection                      = '';
    //         $cancel_trade                                 = '';
    //         $check_high_open                              = '';
    //         $is_previous_blue_candle                      = '';
    //         $box_trigger_black_wall                       = '';
    //         $box_trigger_virtual_barrier                  = '';
    //         $box_trigger_seven_level_pressure             = '';
    //         $box_trigger_buyer_vs_seller_rolling_candel   = '';
    //         $box_trigger_15_minute_rolling_candel         = '';
    //         $last_200_contracts_buy_vs_sell_box_trigger   = '';
    //         $last_200_contracts_time_box_trigger          = '';
    //         $last_qty_contracts_buyer_vs_seller_box_trigger  = '';
    //         $last_qty_contracts_time_box_trigger          = '';
        
    //         $level_number = 1;
    //         foreach($rules_set_arr as $row){ 
            
    //         if ($row['trigger_level'] == 'level_'.$level_number ) {
                
    //                 if ($row['box_trigger_score']!='') {
    //                     $box_trigger_score .= '<td>' . $row['box_trigger_score'] . ' </td>';
    //                 } else {
    //                     $box_trigger_score .= '<td>' . 'N/A' . '</td>';
    //                 }
                    
    //                 if ($row['apply_factor']!='') {
    //                     $apply_factor .= '<td>' . $row['apply_factor'] . ' </td>';
    //                 } else {
    //                     $apply_factor .= '<td>' . 'N/A' . '</td>';
    //                 }
                    
    //                 if ($row['look_back_hour']!='') {
    //                     $look_back_hour .= '<td>' . $row['look_back_hour'] . ' </td>';
    //                 } else {
    //                     $look_back_hour .= '<td>' . 'N/A' . '</td>';
    //                 }
                    
    //                 if ($row['bottom_demand_rejection']=='yes') {
    //                     $bottom_demand_rejection .= '<td><span class="glyphicon glyphicon-ok" aria-hidden="true" style="color:green;"></span> </td>';
    //                 } else {
    //                     $bottom_demand_rejection .= '<td><span class="glyphicon glyphicon-remove" aria-hidden="true" style="color:red;"></span></td>';
    //                 }
                    
    //                 if ($row['bottom_supply_rejection']=='yes') {
    //                     $bottom_supply_rejection .= '<td><span class="glyphicon glyphicon-ok" aria-hidden="true" style="color:green;"></span> </td>';
    //                 } else {
    //                     $bottom_supply_rejection .= '<td><span class="glyphicon glyphicon-remove" aria-hidden="true" style="color:red;"></span></td>';
    //                 }
                    
    //                 if ($row['cancel_trade']=='cancel') {
    //                     $cancel_trade .= '<td><span class="glyphicon glyphicon-ok" aria-hidden="true" style="color:green;"></span> </td>';
    //                 } else {
    //                     $cancel_trade .= '<td><span class="glyphicon glyphicon-remove" aria-hidden="true" style="color:red;"></span></td>';
    //                 }
                    
    //                 if ($row['check_high_open']=='yes') {
    //                     $check_high_open .= '<td><span class="glyphicon glyphicon-ok" aria-hidden="true" style="color:green;"></span> </td>';
    //                 } else {
    //                     $check_high_open .= '<td><span class="glyphicon glyphicon-remove" aria-hidden="true" style="color:red;"></span></td>';
    //                 }
                    
    //                 if ($row['is_previous_blue_candle']=='yes') {
    //                     $is_previous_blue_candle .= '<td><span class="glyphicon glyphicon-ok" aria-hidden="true" style="color:green;"></span> </td>';
    //                 } else {
    //                     $is_previous_blue_candle .= '<td><span class="glyphicon glyphicon-remove" aria-hidden="true" style="color:red;"></span></td>';
    //                 }
                    
                    
    //                 if ($row['box_trigger_black_wall_apply'] == 'yes') {
    //                     $box_trigger_black_wall .= '<td>' . $row['box_trigger_black_wall'] . ' %</td>';
    //                 } else {
    //                     $box_trigger_black_wall .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                    
                    
    //                 if ($row['box_trigger_virtual_barrier_apply'] == 'yes') {
    //                     $box_trigger_virtual_barrier .= '<td>' . $row['box_trigger_virtual_barrier'] .' %</td>';
    //                 } else {
    //                     $box_trigger_virtual_barrier .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                    
                    
    //                 if ($row['box_trigger_seven_level_pressure_apply'] == 'yes') {
    //                     $box_trigger_seven_level_pressure .= '<td>' . $row['box_trigger_seven_level_pressure']. ' %</td>';
    //                 } else {
    //                     $box_trigger_seven_level_pressure .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                    
                    
    //                 if ($row['box_trigger_buyer_vs_seller_rolling_candel_apply'] == 'yes') {
    //                     $box_trigger_buyer_vs_seller_rolling_candel .= '<td>' . $row['box_trigger_buyer_vs_seller_rolling_candel'] . ' %</td>';
    //                 } else {
    //                     $box_trigger_buyer_vs_seller_rolling_candel .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                    
    //                 if ($row['box_trigger_15_minute_rolling_candel_apply'] == 'yes') {
    //                     $box_trigger_15_minute_rolling_candel .= '<td>' . $row['box_trigger_15_minute_rolling_candel'] . '</td>';
    //                 } else {
    //                     $box_trigger_15_minute_rolling_candel .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                    
                    
    //                 if ($row['last_200_contracts_buy_vs_sell_box_trigger_apply'] == 'yes') {
    //                     $last_200_contracts_buy_vs_sell_box_trigger .= '<td>' . $row['last_200_contracts_buy_vs_sell_box_trigger'] . '</td>';
    //                 } else {
    //                     $last_200_contracts_buy_vs_sell_box_trigger .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                    
                    
    //                 if ($row['last_200_contracts_time_box_trigger_apply'] == 'yes') {
    //                     $last_200_contracts_time_box_trigger .= '<td>' . $row['last_200_contracts_time_box_trigger'] . '</td>';
    //                 } else {
    //                     $last_200_contracts_time_box_trigger .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                    
                    
    //                 if ($row['last_qty_contracts_buyer_vs_seller_box_trigger_apply'] == 'yes') {
    //                     $last_qty_contracts_buyer_vs_seller_box_trigger .= '<td>'  .$row['last_qty_contracts_buyer_vs_seller_box_trigger'].' %</td>';
    //                 } else {
    //                     $last_qty_contracts_buyer_vs_seller_box_trigger .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                    
                    
    //                 if ($row['last_qty_contracts_time_box_trigger_apply'] == 'yes') {
    //                     $last_qty_contracts_time_box_trigger .= '<td>'  .$row['last_qty_contracts_time_box_trigger'].' %</td>';
    //                 } else {
    //                     $last_qty_contracts_time_box_trigger .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                    
    //             } $level_number++;
    //         }
        
    //                         $html .= '<tr class="center">
    //                         <th style="width:350px; border-right:3px solid #ddd;">Score</th>
                            
    //         '. $box_trigger_score;
            
    //                         $html .= '</tr>
    //                         <tr class="center">
    //                         <th>Stop loss rule 2 apply factor</th>
                            
    //         '. $apply_factor;
            
    //                         $html .= '</tr>
    //                         <tr class="center">
    //                         <th>Look back hour to cancel trade</th>
                            
    //         '. $look_back_hour;
        
    //                         $html .= '</tr>
    //                         <tr class="center">
    //                         <th>Bottom Demand Rejection</th>
                            
    //         '. $bottom_demand_rejection;
            
    //                         $html .= '</tr>
    //                         <tr class="center">
    //                         <th> Bottom Supply Rejection</th>
    //         '. $bottom_supply_rejection ;
    //                         $html .= '</tr>
    //                         <tr class="center">
    //                         <th>Cancel Trade</th>
    //         '.$cancel_trade;
            
    //                         $html .= '</tr>
    //                         <tr class="center">
    //                         <th>Check Heigh Open</th>
                    
    //         '.$check_high_open;
            
    //                         $html .= '</tr>
    //                         <tr class="center">
    //                         <th>Is Previous blue candle</th>
                            
    //         '.$is_previous_blue_candle;
        
    //                     $html .= ' </tr>
    //                         <tr class="center">
    //                         <th>(Black Wall Greater From defined percentile)</th>
                        
    //         '.$box_trigger_black_wall;
        
    //                     $html .= '</tr>
    //                         <tr class="center">
    //                         <th>(Virtual Barrier Greater From defined percentile)</th>
                            
    //         '.$box_trigger_virtual_barrier;
            
    //                     $html .= ' </tr>
                            
    //                         <tr class="center">
    //                         <th>(Seven Level Greater From defined percentile)</th>
                            
    //         '.$box_trigger_seven_level_pressure;
            
    //                         $html .= '</tr>
                            
    //                         <tr class="center">
    //                         <th>(Buyers Vs sellers , 5 mins rolling candel Greater From defined percentile)</th>
                            
    //         '.$box_trigger_buyer_vs_seller_rolling_candel;
            
    //                         $html .= '</tr>
                            
    //                         <tr class="center">
    //                         <th>(15 Minute Rolling Candel Greater From defined percentile)</th>
                            
    //         '.$box_trigger_15_minute_rolling_candel;

    //                         $html .= '</tr>
                            
    //                         <tr class="center">
    //                         <th>Last 200 Contract Buyers Vs Sellers</th>
                    
    //         '.$last_200_contracts_buy_vs_sell_box_trigger;
        
    //                         $html .= '</tr>
                            
    //                         <tr class="center">
    //                         <th>Last 200 Contract Time Less Then</th>
                            
    //         '.$last_200_contracts_time_box_trigger;
        
    //                         $html .= '</tr>
                            
    //                         <tr class="center">
    //                         <th>Last Qty Contract Buyers Vs Sellers</th>
                            
    //         '.$last_qty_contracts_buyer_vs_seller_box_trigger;
            
    //                         $html .= '</tr>
    //                         <tr class="center">
    //                         <th>Last qty Contract time(Less then)</th>
                            
    //         '.$last_qty_contracts_time_box_trigger;
            
    //                         $html .= '</tr>
                            
    //                     </tbody>
    //                     </table>
                    
    //                 <div class="clearfix"></div>
    //                 <!--End of Buy part -->
    //                 </div>
    //                 <!-- // Table END --> 
    //             </div> <div class="clearfix"></div>
    //             </div>';
                
                    
                    
    //             }
    //             else if($triggers_type=='barrier_trigger'){
            
    //         if($rules_set_arr->aggressive_stop_rule=='stop_loss_rule_1'){
    //             $aggressive_stop_ruleA  =  'Stop Loss Rule One';
    //         }else if($rules_set_arr->aggressive_stop_rule=='stop_loss_rule_2'){
    //             $aggressive_stop_ruleA  =  'Stop Loss Rule Two'; 
    //         }else if($rules_set_arr->aggressive_stop_rule=='stop_loss_rule_3'){
    //             $aggressive_stop_ruleA  =  'Stop Loss Rule Three';    
    //         }else if($rules_set_arr->aggressive_stop_rule=='stop_loss_rule_big_wall'){
    //             $aggressive_stop_ruleA  =  'Stop Loss Rule Big Wall';    
    //         }

    //             $html .= '  <div class="col-md-12 appnedAjax" > <ul class="nav nav-tabs">
    //                 <li class="active"><a data-toggle="tab" href="#buy">Buy Rules</a></li>
    //                 <li><a data-toggle="tab" href="#sell">Sell Rules</a></li>
    //             </ul>
    //             <div class="tab-content ">';
                
    //             $html .= ' <div id="buy" class="tab-pane fade in active">
                
                
    //             <table class="table table-bordered">
    //             <thead>
    //                 <tr>
    //                 <th scope="col" style="background:#4267b2; color:#FFF;">Aggressive Stop Rule</th>
    //                 <th scope="col" style="background:#4267b2; color:#FFF;">Buy Range %</th>
    //                 <th scope="col" style="background:#4267b2; color:#FFF;">Deep % For Active</th>
    //                 <th scope="col" style="background:#4267b2; color:#FFF;">Initial Stop Loss</th>
    //                 </tr>
    //             </thead>
    //             <tbody>
    //                 <tr>
    //                 <td class="centre">
    //                 '. $aggressive_stop_ruleA .'</td>
    //                 <td class="centre">'. $rules_set_arr->buy_range_percet .' %'.'</td>
    //                 <td class="centre">'. $rules_set_arr->sell_profit_percet .' %'.'</td>
    //                 <td class="centre">'. $rules_set_arr->stop_loss_percet.'</td>
    //                 </tr>
                    
    //             </tbody>
    //             </table> 
                    
    //                 <table class="table table-bordered zama_th">
    //                     <thead>
    //                     <tr>
    //                         <th class="" style="background:#4267b2; color: #FFF;">'. $coin .'</th>';
                            
    //             for ($rule_number = 1; $rule_number <= 10; $rule_number++) {
    //                 if ($rules_set_arr['enable_buy_rule_no_' . $rule_number . ''] == 'yes') {
    //                     $html .= '<th class="center" style="background:#4267b2; color:#FFF;">' . $rule_number . '</th>';
    //                 }
    //             }
    //             $html .= ' </tr></thead><tbody>';
                
    //             $buy_status_rule_                 = '';
    //             $big_seller_percent_compare_rule_ = '';
    //             $closest_black_wall_rule_         = '';
    //             $closest_yellow_wall_rule_        = '';
    //             $seven_level_pressure_rule_       = '';
    //             $buyer_vs_seller_rule_            = '';
    //             $last_candle_type                 = '';
    //             $rejection_candle_type            = '';
    //             $last_200_contracts_buy_vs_sell   = '';
    //             $last_200_contracts_time          = '';
    //             $last_qty_buyers_vs_seller        = '';
    //             $last_qty_time                    = '';
    //             $score                            = '';
    //             $comment                          = '';
    //             $buy_trigger_type_ruleAll         = '';
    //             $last_candle_status               = '';
                
    //             for ($rule_numbernn = 1; $rule_numbernn <= 10; $rule_numbernn++) {
    //                 if ($rules_set_arr['enable_buy_rule_no_' . $rule_numbernn . ''] == 'yes') {
                        
    //                 $buyrulerecordAll = '';
    //                 foreach ($rules_set_arr['buy_order_level_' . $rule_numbernn] as $buyrulerecord) {
                        
    //                     if ($buyrulerecord == 'level_1') {
    //                         $value1 = '<span class="label label-warning">L 1</span>';
    //                     } else if ($buyrulerecord == 'level_2') {
    //                         $value1 = '<span class="label label-warning">L 2</span>';
    //                     } else if ($buyrulerecord == 'level_3') {
    //                         $value1 = '<span class="label label-warning">L 3</span>';
    //                     } else if ($buyrulerecord == 'level_4') {
    //                         $value1 = '<span class="label label-warning">L 4</span>';
    //                     } else if ($buyrulerecord == 'level_5') {
    //                         $value1 = '<span class="label label-warning">L 5</span>'; 
    //                     } else if ($buyrulerecord == 'level_6') {
    //                         $value1 = '<span class="label label-warning">L 6</span>';
    //                     } 
    //                     $buyrulerecordAll .= '&nbsp;' . $value1;
    //                 }
                        
    //                     $rulerecordaaa = '';
    //                     if ($rules_set_arr['buy_status_rule_' . $rule_numbernn . '_enable'] == 'yes') {
    //                     foreach ($rules_set_arr['buy_status_rule_' . $rule_numbernn . ''] as $rulerecord) {
    //                         $rulerecordaaa .= '&nbsp' . $rulerecord;
    //                     }
    //                     }
    //                     $buy_trigger_type_rule ='';
    //                     foreach ($rules_set_arr['buy_trigger_type_rule_' . $rule_numbernn . ''] as $rulerecord) {
    //                         if ($rulerecord == 'very_strong_barrier') {
    //                             $value = '<span class="label label-success">VSB</span>';
    //                         } else if ($rulerecord == 'weak_barrier') {
    //                             $value = '<span class="label label-warning">WB</span>';
    //                         } else if ($rulerecord == 'strong_barrier') {
    //                             $value = '<span class="label label-info">SB</span>';
    //                         }
    //                         $buy_trigger_type_rule .= '&nbsp' . $value;
    //                     }
                        
    //                     if ($rules_set_arr['buyer_vs_seller_rule_' . $rule_numbernn . '_buy_enable'] == 'yes') {
    //                         $buyer_vs_seller_rule .= '<td>' . $rules_set_arr['buyer_vs_seller_rule_' . $rule_numbernn . '_buy'] . '<span style="font-size:11px;  color: #a03d3d;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
    //                         ( '.number_format((float)$percentil['five_min_5']).' )</span></td>';
    //                     } else {
    //                         $buyer_vs_seller_rule .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
    //                     if ($rules_set_arr['buy_order_level_' . $rule_numbernn . '_enable'] == 'yes') {
    //                         $buy_order_level .= '<td>' . $buyrulerecordAll . '</td>';
    //                     } else {
    //                         $buy_order_level .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
                        
    //                     if ($rules_set_arr['sell_virtural_for_buy_rule_' . $rule_numbernn . '_enable'] == 'yes') {
    //                         $sell_virtural_for_buy_rule_ .= '<td>' . $rules_set_arr['sell_virtural_for_buy_rule_' . $rule_numbernn.''] . '</td>';
    //                     } else {
    //                         $sell_virtural_for_buy_rule_ .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
                        
                        
    //                     if ($rules_set_arr['done_pressure_rule_' . $rule_numbernn . '_buy_enable'] == 'yes') {
    //                         $done_pressure_rulebuy .= '<td>' . $rules_set_arr['done_pressure_rule_' . $rule_numbernn . '_buy'] . '</td>';
    //                     } else {
    //                         $done_pressure_rulebuy .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
                
    //                     if ($rules_set_arr['buy_virtual_barrier_rule_' . $rule_numbernn . '_enable'] == 'yes') {
    //                         $buy_virtural_rule_ .= '<td>' . number_format($rules_set_arr['buy_virtural_rule_' . $rule_numbernn . '']) . '<span style="font-size:11px;     color: #a03d3d;">
    //                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ( '.($percentil['bid_quantity_5']).' )</span></td>';
    //                     } else {
    //                         $buy_virtural_rule_ .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
                
    //                     if ($rules_set_arr['buy_status_rule_' . $rule_numbernn . '_enable'] == 'yes') {
    //                         $buy_status_rule_ .= '<td>' . $rulerecordaaa . '</td>';
    //                     } else {
    //                         $buy_status_rule_ .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
    //                     if ($rules_set_arr['buy_trigger_type_rule_' . $rule_numbernn . '_enable'] == 'yes') {
    //                         $buy_trigger_type_ruleAll .= '<td>' . $buy_trigger_type_rule . '</td>';
    //                     } else {
    //                         $buy_trigger_type_ruleAll .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
    //                     if ($rules_set_arr['buy_check_volume_rule_' . $rule_numbernn . ''] == 'yes') {
    //                         $buy_volume_rule_ .= '<td>' . number_format($rules_set_arr['buy_volume_rule_' . $rule_numbernn . '']) . '</td>';
    //                     } else {
    //                         $buy_volume_rule_ .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
    //                     if ($rules_set_arr['buy_trigger_type_rule_' . $rule_numbernn . '_enable'] == 'yes') {
    //                         $buy_trigger_type_ruleArr .= '<td>' . $buy_trigger_type_rule . '</td>';
    //                     } else {
    //                         $buy_trigger_type_ruleArr .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
    //                     if ($rules_set_arr['big_seller_percent_compare_rule_' . $rule_numbernn . '_buy_enable'] == 'yes') {
    //                         $big_seller_percent_compare_rule_ .= ' <td class="center">' . $rules_set_arr['big_seller_percent_compare_rule_' . $rule_numbernn . '_buy'] . ' %' . '</td>';
    //                     } else {
    //                         $big_seller_percent_compare_rule_ .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
    //                     if ($rules_set_arr['closest_black_wall_rule_' . $rule_numbernn . '_buy_enable'] == 'yes') {
    //                         $closest_black_wall_rule_ .= ' <td class="center">' . $rules_set_arr['closest_black_wall_rule_' . $rule_numbernn . '_buy'] . '<span style="font-size:11px;     color: #a03d3d;">
    //                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ( '.($percentil['blackwall_5']).' )</span></td>';
    //                     } else {
    //                         $closest_black_wall_rule_ .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
    //                     if ($rules_set_arr['closest_yellow_wall_rule_' . $rule_numbernn . '_buy_enable'] == 'yes') {
    //                         $closest_yellow_wall_rule_ .= '<td>' . $rules_set_arr['closest_yellow_wall_rule_' . $rule_numbernn . '_buy'] . '</td>';
    //                     } else {
    //                         $closest_yellow_wall_rule_ .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
    //                     if ($rules_set_arr['seven_level_pressure_rule_' . $rule_numbernn . '_buy_enable'] == 'yes') {
    //                         $seven_level_pressure_rule_ .= '<td>' . $rules_set_arr['seven_level_pressure_rule_' . $rule_numbernn . '_buy']  . '<span style="font-size:11px;     color: #a03d3d;">
    //                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ( '.$percentil['sevenlevel_5'].' )</span></td>';
    //                     } else {
    //                         $seven_level_pressure_rule_ .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
    //                     if ($rules_set_arr['buy_last_candle_type' . $rule_numbernn . '_enable'] == 'yes') {
    //                         $last_candle_type .= '<td>' . $rules_set_arr['last_candle_type' . $rule_numbernn . '_buy'] . '</td>';
    //                     } else {
    //                         $last_candle_type .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
    //                     if ($rules_set_arr['buy_rejection_candle_type8' . $rule_numbernn . '_enable'] == 'yes') {
    //                         $rejection_candle_type .= '<td>' . $rules_set_arr['rejection_candle_type' . $rule_numbernn . '_buy'] . '</td>';
    //                     } else {
    //                         $rejection_candle_type .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
    //                     if ($rules_set_arr['buy_last_200_contracts_buy_vs_sell' . $rule_numbernn . '_enable'] == 'yes') {
    //                         $last_200_contracts_buy_vs_sell .= '<td>' . $rules_set_arr['last_200_contracts_buy_vs_sell' . $rule_numbernn . '_buy']  . '<span style="font-size:11px;     color: #a03d3d;">
    //                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ( '.($percentil['last_200_buy_vs_sell_5']).' )</span></td>';
    //                     } else {
    //                         $last_200_contracts_buy_vs_sell .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
    //                     if ($rules_set_arr['buy_last_200_contracts_time' . $rule_numbernn . '_enable'] == 'yes') {
    //                         $last_200_contracts_time .= '<td>' . $rules_set_arr['last_200_contracts_time' . $rule_numbernn . '_buy'] . '</td>';
    //                     } else {
    //                         $last_200_contracts_time .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
    //                     if ($rules_set_arr['buy_last_qty_buyers_vs_seller' . $rule_numbernn . '_enable'] == 'yes') {
    //                         $last_qty_buyers_vs_seller .= '<td>' . $rules_set_arr['last_qty_buyers_vs_seller' . $rule_numbernn . '_buy'] . '<span style="font-size:11px;     color: #a03d3d;">
    //                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ( '.$percentil['last_qty_buy_vs_sell_5'].' )</span></td>';
    //                     } else {
    //                         $last_qty_buyers_vs_seller .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
    //                     if ($rules_set_arr['buy_last_qty_time' . $rule_numbernn . '_enable'] == 'yes') { 
    //                         $last_qty_time .= '<td>' . $rules_set_arr['last_qty_time' . $rule_numbernn . '_buy'] . '<span style="font-size:11px;  color: #a03d3d;">
    //                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ( '.$percentil['last_qty_time_ago_5'].' )</span></td>';
    //                     } else {
    //                         $last_qty_time .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
    //                     if ($rules_set_arr['buy_score' . $rule_numbernn . '_enable'] == 'yes') {
    //                         $score .= '<td>' . $rules_set_arr['score' . $rule_numbernn . '_buy'] . '</td>';
    //                     } else {
    //                         $score .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
    //                     if ($rules_set_arr['buy_comment' . $rule_numbernn . '_enable'] == 'yes') {
    //                         $comment .= '<td class="parent"><a class="parent" data-toggle="tooltip" data-placement="top" title="'.$rules_set_arr['comment' . $rule_numbernn . '_buy'].'">
    //                         '. substr($rules_set_arr['comment' . $rule_numbernn . '_buy'],0,10).'</a></td>';
    //                     } else {
    //                         $comment .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
    //                     if ($rules_set_arr['buy_last_candle_status' . $rule_numbernn . '_enable'] == 'yes') {
    //                         $last_candle_status .= '<td>' . ucfirst($rules_set_arr['last_candle_status' . $rule_numbernn . '_buy']) . '</td>';
    //                     } else {
    //                         $last_candle_status .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
    //                     // New work goes here 
    //                     if ($rules_set_arr['buyers_vs_sellers_buy' . $rule_numbernn . '_enable'] == 'yes') {
    //                         $buyers_vs_sellers .= '<td>' . ucfirst($rules_set_arr['buyers_vs_sellers' . $rule_numbernn . '_buy']) . '</td>';
    //                     } else {
    //                         $buyers_vs_sellers .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
    //                     if ($rules_set_arr['ask_percentile_' . $rule_numbernn . '_apply_buy'] == 'yes') {
    //                         $ask_percentile_ .= '<td>' . ucfirst($rules_set_arr['ask_percentile_' . $rule_numbernn . '_buy']) . '</td>';
    //                     } else {
    //                         $ask_percentile_ .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
    //                     if ($rules_set_arr['bid_percentile_' . $rule_numbernn . '_apply_buy'] == 'yes') {
    //                         $bid_percentile_ .= '<td>' . ucfirst($rules_set_arr['bid_percentile_' . $rule_numbernn . '_buy']) . '</td>';
    //                     } else {
    //                         $bid_percentile_ .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
    //                     if ($rules_set_arr['buy_percentile_' . $rule_numbernn . '_apply_buy'] == 'yes') {
    //                         $buy_percentile_ .= '<td>' . ucfirst($rules_set_arr['buy_percentile_' . $rule_numbernn . '_buy']) . '</td>';
    //                     } else {
    //                         $buy_percentile_ .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
    //                     if ($rules_set_arr['sell_percentile_' . $rule_numbernn . '_apply_buy'] == 'yes') {
    //                         $sell_percentile_ .= '<td>' . ucfirst($rules_set_arr['sell_percentile_' . $rule_numbernn . '_buy']) . '</td>';
    //                     } else {
    //                         $sell_percentile_ .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
    //                     if ($rules_set_arr['order_status' . $rule_numbernn . '_enable'] == 'yes') {
    //                         $order_status .= '<td>' . ucfirst($rules_set_arr['order_status' . $rule_numbernn . '_buy']) . '</td>';
    //                     } else {
    //                         $order_status .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
                        
                        
                        
                        
                        
                        
    //                 }
    //             }
    //             $html .= ' <tr class="center">
    //                         <th style="width:350px; border-right:3px solid #ddd;">Status</th>
    //     ' . $buy_status_rule_ . '
    //                     </tr>
                        
    //                     <tr class="center">
    //                         <th>Trigger Rule</th>
    //     ' . $buy_trigger_type_ruleAll . '
    //                     </tr>
                        
    //                     <tr class="center">
    //                         <th>(Support Barrier)(Virtual Barrier) (Shoul be Greater or Eqaual from Defined value)</th>
                        
    //     '. $buy_virtural_rule_.'
                        
    //                     </tr>
                        
    //                     <tr class="center">
    //                         <th>(Resistance Barrier)(Should be less or Equal from Defined value)</th>
                        
    //     '. $sell_virtural_for_buy_rule_.'
                        
    //                     </tr>
                        
    //                     <tr class="center">
    //                         <th>(If Volume greater then the defined value)</th>
                            
    //     ' . $buy_volume_rule_. '

    //                     </tr>
                        
    //                     <tr class="center">
    //                         <th> Down pressure ( Down pressure is Greater or equal to the defined pressure)</th>
    //                     '. $done_pressure_rulebuy .'
    //                     </tr>';
                        
                        
                        
    //             $html .= '<tr class="center">
    //                         <th>Big Buyers % ( percent greater then the defined %)</th>
                        
    //     ' . $big_seller_percent_compare_rule_ . '' . '</tr>
    //                     <tr class="center">
    //                         <th>Closest black wall( Greater then or equal to the defined value)</th>
                        
    //     ' . $closest_black_wall_rule_ . '

    //                     </tr>
    //                     <tr class="center">
    //                         <th>Closest yellow wall (Greater then or equal to the defined value)</th>
                            
    //     ' . $closest_yellow_wall_rule_ . '

    //                     </tr>
    //                     <tr class="center">
    //                         <th>Seven level pressue (Greater then or equal to the defined value)</th>
                            
    //     ' . $seven_level_pressure_rule_ . '

    //                     </tr>
    //                     <tr class="center">
    //                         <th>Buys vs Seller</th>
                    
    //     ' . $buyer_vs_seller_rule . '
    //                     </tr>
    //                     <tr class="center">
    //                         <th>Last Candle Type</th>
                        
    //     ' . $last_candle_type . '

    //                     </tr>
    //                     <tr class="center">
    //                         <th>Rejection Candle Type</th>
                        
    //     ' . $rejection_candle_type . '

    //                     </tr>
    //                     <tr class="center">
    //                         <th>Last 200 Contract Buyers Vs Sellers</th>
                        
    //     ' . $last_200_contracts_buy_vs_sell . '

    //                     </tr>
    //                     <tr class="center">
    //                         <th>Last 200 Contract Time(Less then)</th>
                            
    //     ' . $last_200_contracts_time . '

    //                     </tr>
    //                     <tr class="center">
    //                         <th>Last qty Contract Buyes Vs seller</th>
                        
    //     ' . $last_qty_buyers_vs_seller . '

    //                     </tr>
    //                     <tr class="center">
    //                         <th>Last qty Contract time(Less then)</th>
                        
    //     ' . $last_qty_time . '

    //                     </tr>
    //                     <tr class="center">
    //                         <th>Score</th>
                            
    //     ' . $score . '
    //                     </tr>
                        
    //                     <tr class="center">
    //                         <th>Comment</th>
                        
    //     ' . $comment . '
    //                     </tr>
    //                     <tr class="center">
    //                         <th>Order Level</th>
                            
    //         '.$buy_order_level.'
    //                         </tr>
    //                         <tr class="center">
    //                         <th>Last Candle Status</th>
    //                     '.
    //         $last_candle_status.'
    //                         </tr>
                            
    //                         <tr class="center">
    //                         <th>Rule Sorting</th>
    //                     '.
    //         $order_status.'
    //                         </tr>
    //                         <tr class="center">
    //                         <th>Buyers Vs Sellers 15 Minute</th>
    //                     '.
    //         $buyers_vs_sellers.'
    //                         </tr>
    //                         <tr class="center">
    //                         <th>( (Binance buy) ASk Should be greater or Equal from Defined value) (One minute Rooling candle)</th>
    //                     '.
    //         $ask_percentile_.'
    //                         </tr>
    //                         <tr class="center">
    //                         <th>((Binance Sell)Bid Should be Less or Equal from Defined value) (One minute Rooling candle)</th>
    //                     '.
    //         $bid_percentile_.'
    //                         </tr>
    //                         <tr class="center">
    //                         <th>((Digie Buy) Buy Should be greater or Eqaual from defined value) (One minute Rooling candle)</th>
    //                     '.
    //         $buy_percentile_.'
    //                         </tr>
    //                         <tr class="center">
    //                         <th>((Digie Sell) Sell Should be Less or Equal from Defined value) (One minute Rooling candle)</th>
    //                     '.
    //         $sell_percentile_.'
    //                         </tr>
                            
    //                     </tbody>
    //                 </table>
                    
    //                 </div>'; 
                    
    //             $html .= '  <div id="sell" class="tab-pane fade">
                    
    //                 <table class="table table-bordered zama_th">
    //                     <thead>
    //                     <tr>
    //                         <th class="" style="background:#4267b2; color: #FFF;">'. $coin .'</th>';
    //                             for ($rule_number = 1; $rule_number <= 10; $rule_number++) {
    //                                 if ($rules_set_arr['enable_sell_rule_no_' . $rule_number . ''] == 'yes') {
    //                                     $html .= '<th class="center" style="background:#4267b2; color:#FFF;">
    //                             ' . $rule_number;
    //                                     $html .= '</th>';
    //                                 }
    //                             }
    //             $html .= ' </tr>
    //                     </thead>
    //                     <tbody>';
    //             $buy_status_rule_sell             = '';
    //             $big_seller_percent_compare_rule_ = '';
    //             $closest_black_wall_rule_         = '';
    //             $closest_yellow_wall_rule_        = '';
    //             $seven_level_pressure_rule_       = '';
    //             $buyer_vs_seller_rule_            = '';
    //             $last_candle_type                 = '';
    //             $rejection_candle_type            = '';
    //             $last_200_contracts_buy_vs_sell   = '';
    //             $last_200_contracts_time          = '';
    //             $last_qty_buyers_vs_seller        = '';
    //             $last_qty_time                    = '';
    //             $score                            = '';
    //             $comment                          = '';
    //             $sell_virtural_rule_              = '';
    //             //$avgProfit_All                    = '';
                
    //             for ($rule_numbernn = 1; $rule_numbernn <= 10; $rule_numbernn++) {
                    
    //                 if ($rules_set_arr['enable_sell_rule_no_' . $rule_numbernn . ''] == 'yes') {
                        
                        
                        
    //                 $sell_order_level = '';
    //                 foreach ($rules_set_arr['sell_order_level_' . $rule_numbernn . ''] as $rulerecordOrderlevel) {
                        
    //                     if ($rulerecordOrderlevel == 'level_1') {
    //                         $value1 = '<span class="label label-warning">L 1</span>';
    //                     } else if ($rulerecordOrderlevel == 'level_2') {
    //                         $value1 = '<span class="label label-warning">L 2</span>';
    //                     } else if ($rulerecordOrderlevel == 'level_3') {
    //                         $value1 = '<span class="label label-warning">L 3</span>';
    //                     } else if ($rulerecordOrderlevel == 'level_4') {
    //                         $value1 = '<span class="label label-warning">L 4</span>';
    //                     } else if ($rulerecordOrderlevel == 'level_5') {
    //                         $value1 = '<span class="label label-warning">L 5</span>'; 
    //                     } else if ($rulerecordOrderlevel == 'level_6') {
    //                         $value1 = '<span class="label label-warning">L 6</span>';
    //                     } 
    //                     $sell_order_level .= '&nbsp;' . $value1;
    //                 }
                
    //                 $rulerecordsell = '';
    //                 foreach ($rules_set_arr['sell_status_rule_' . $rule_numbernn . ''] as $rulerecord) {
    //                     $rulerecordsell .= '&nbsp;' . $rulerecord;
    //                 }
    //                 $sell_trigger_type_rule = '';
    //                 if ($rules_set_arr['sell_trigger_type_rule_' . $rule_numbernn . '_enable'] == 'yes') {
    //                     foreach ($rules_set_arr['sell_trigger_type_rule_' . $rule_numbernn . ''] as $rulerecord) {
    //                         if ($rulerecord == 'very_strong_barrier') {
    //                             $value = '<span class="label label-success">VSB</span>';
    //                         } else if ($rulerecord == 'weak_barrier') {
    //                             $value = '<span class="label label-warning">WB</span>';
    //                         } else if ($rulerecord == 'strong_barrier') {
    //                             $value = '<span class="label label-info">SB</span>';
    //                         }
    //                         $sell_trigger_type_rule .= '&nbsp;' . $value;
    //                     }
    //                 }
                    
    //                 if ($rules_set_arr['sell_order_level_' . $rule_numbernn . '_enable'] == 'yes') {
    //                     $sell_order_levelAll .= '<td>' . $sell_order_level . '</td>';
    //                 } else {
    //                     $sell_order_levelAll .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                        
    //                     if ($rules_set_arr['done_pressure_rule_' . $rule_numbernn . '_enable'] == 'yes') {
    //                         $done_pressure_rule .= '<td>' . $rules_set_arr['done_pressure_rule_' . $rule_numbernn . ''] . '</td>';
    //                     } else {
    //                         $done_pressure_rule .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
    //                     if ($rules_set_arr['sell_virtual_barrier_rule_' . $rule_numbernn . '_enable'] == 'yes') {
    //                         $sell_virtural_rule_ .= '<td>' . number_format($rules_set_arr['sell_virtural_rule_' . $rule_numbernn . '']) . '<span style="font-size:11px;     color: #a03d3d;">
    //                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ( '.number_format((float)$percentil['bid_contract_5']).' )</span></td>';
    //                     } else {
    //                         $sell_virtural_rule_ .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
                        
    //                     if ($rules_set_arr['buy_virtural_rule_for_sell_' . $rule_numbernn . '_enable'] == 'yes') {
    //                         $buy_virtural_rule_for_sell_ .= '<td>' . $rules_set_arr['buy_virtural_rule_for_sell_' . $rule_numbernn . ''] . '</td>';
    //                     } else {
    //                         $buy_virtural_rule_for_sell_ .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
                        
    //                     if ($rules_set_arr['sell_status_rule_' . $rule_numbernn . '_enable'] == 'yes') {
    //                         $sell_status_rule .= '<td>' . $rulerecordsell . '</td>';
    //                     } else {
    //                         $sell_status_rule .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
    //                     if ($rules_set_arr['sell_check_volume_rule_' . $rule_numbernn . ''] == 'yes') {
    //                         $sell_volume_rule_ .= '<td>' . number_format($rules_set_arr['sell_volume_rule_' . $rule_numbernn . '']) . '</td>';
    //                     } else {
    //                         $sell_volume_rule_ .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
    //                     if ($rules_set_arr['sell_trigger_type_rule_' . $rule_numbernn . '_enable'] == 'yes') {
    //                         $sell_trigger_type_ruleArr .= '<td>' . $sell_trigger_type_rule . '</td>';
    //                     } else {
    //                         $sell_trigger_type_ruleArr .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
                        
    //                     if ($rules_set_arr['big_seller_percent_compare_rule_' . $rule_numbernn . '_enable'] == 'yes') {
    //                         $big_seller_percent_compare_rule_sell .= ' <td class="center">' . $rules_set_arr['big_seller_percent_compare_rule_' . $rule_numbernn . ''] . ' %' . '</td>';
    //                     } else {
    //                         $big_seller_percent_compare_rule_sell .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
                        
    //                     if ($rules_set_arr['closest_black_wall_rule_' . $rule_numbernn . '_enable'] == 'yes') {
    //                         $closest_black_wall_rule_sell .= ' <td class="center">' . $rules_set_arr['closest_black_wall_rule_' . $rule_numbernn . ''] . '<span style="font-size:11px;     color: #a03d3d;">
    //                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ( '.number_format((float)$percentil['blackwall_b_5']).' )</span></td>';
    //                     } else {
    //                         $closest_black_wall_rule_sell .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
    //                     if ($rules_set_arr['sell_percent_rule_' . $rule_numbernn . '_enable'] == 'yes') {
    //                         $sell_percent_rule .= ' <td class="center">' . $rules_set_arr['sell_percent_rule_' . $rule_numbernn . ''] . '</td>';
    //                     } else {
    //                         $sell_percent_rule .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
    //                     if ($rules_set_arr['closest_yellow_wall_rule_' . $rule_numbernn . '_enable'] == 'yes') {
    //                         $closest_yellow_wall_rule_sell .= '<td>' . $rules_set_arr['closest_yellow_wall_rule_' . $rule_numbernn . ''] . '</td>';
    //                     } else {
    //                         $closest_yellow_wall_rule_sell .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
    //                     if ($rules_set_arr['seven_level_pressure_rule_' . $rule_numbernn . '_enable'] == 'yes') {
    //                         $seven_level_pressure_rule_sell .= '<td>' . $rules_set_arr['seven_level_pressure_rule_' . $rule_numbernn . ''] . '<span style="font-size:11px;     color: #a03d3d;">
    //                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ( '.number_format((float)$percentil['sevenlevel_b_5']).' )</span></td>';
    //                     } else {
    //                         $seven_level_pressure_rule_sell .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
    //                     if ($rules_set_arr['sell_last_candle_type' . $rule_numbernn . '_enable'] == 'yes') {
    //                         $last_candle_type_sell .= '<td>' . $rules_set_arr['last_candle_type' . $rule_numbernn . ''] . '</td>';
    //                     } else {
    //                         $last_candle_type_sell .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
                        
    //                     if ($rules_set_arr['sell_rejection_candle_type' . $rule_numbernn . '_enable'] == 'yes') {
                    
    //                         if($rules_set_arr['rejection_candle_type' . $rule_numbernn . '_sell'] =='top_supply_rejection'){
    //                         $rejection_candle_type_sell .= '<td>' .  '<span class="label label-warning">T S R</span>'. '</td>';	 
    //                         }else{
    //                         $rejection_candle_type_sell .= '<td>' . $rules_set_arr['rejection_candle_type' . $rule_numbernn . '_sell'] . '</td>';
    //                         }
                    
    //                     } else {
    //                         $rejection_candle_type_sell .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
                        
                        
    //                     if ($rules_set_arr['seller_vs_buyer_rule_' . $rule_numbernn . '_sell_enable'] == 'yes') {
    //                         $seller_vs_buyer_rule .= '<td>' . $rules_set_arr['seller_vs_buyer_rule_' . $rule_numbernn . '_sell'] . '</td>';
    //                     } else {
    //                         $seller_vs_buyer_rule .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
    //                     if ($rules_set_arr['sell_last_200_contracts_buy_vs_sell' . $rule_numbernn . '_enable'] == 'yes') {
    //                         $last_200_contracts_buy_vs_sell .= '<td>' . $rules_set_arr['last_200_contracts_buy_vs_sell' . $rule_numbernn . '_sell'] . '<span style="font-size:11px;     color: #a03d3d;">
    //                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ( '.number_format((float)$percentil['last_200_sell_vs_buy_5']).' )</span></td>';
    //                     } else {
    //                         $last_200_contracts_buy_vs_sell .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
    //                     if ($rules_set_arr['sell_last_200_contracts_time' . $rule_numbernn . '_enable'] == 'yes') {
    //                         $last_200_contracts_time_sell .= '<td>' . $rules_set_arr['last_200_contracts_time' . $rule_numbernn . '_sell'] . '</td>';
    //                     } else {
    //                         $last_200_contracts_time_sell .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
    //                     if ($rules_set_arr['sell_last_qty_buyers_vs_seller' . $rule_numbernn . '_enable'] == 'yes') {
    //                         $sell_last_qty_buyers_vs_seller .= '<td>' . $rules_set_arr['last_qty_buyers_vs_seller' . $rule_numbernn . '_sell'] . '<span style="font-size:11px;     color: #a03d3d;">
    //                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ( '.number_format((float)$percentil['last_qty_buy_vs_sell_b_5']).' )</span></td>';
    //                     } else {
    //                         $sell_last_qty_buyers_vs_seller .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
    //                     if ($rules_set_arr['sell_last_qty_time' . $rule_numbernn . '_enable'] == 'yes') {
    //                         $last_qty_time_sell .= '<td>' . $rules_set_arr['last_qty_time' . $rule_numbernn . '_sell'] . '<span style="font-size:11px;  color: #a03d3d;">
    //                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ( '.number_format((float)$percentil['last_qty_time_ago_5']).' )</span></td>';
    //                     } else {
    //                         $last_qty_time_sell .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
    //                     if ($rules_set_arr['sell_score' . $rule_numbernn . '_enable'] == 'yes') {
    //                         $score_sell .= '<td>' . $rules_set_arr['score' . $rule_numbernn . '_sell'] . '</td>';
    //                     } else {
    //                         $score_sell .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
    //                     if ($rules_set_arr['sell_comment' . $rule_numbernn . '_enable'] == 'yes') {
    //                         $comment_sell .= '<td class="parent"><a class="parent" data-toggle="tooltip" data-placement="top" title="'.$rules_set_arr['comment' . $rule_numbernn . '_sell'].'"> 
    //                             '. substr($rules_set_arr['comment' . $rule_numbernn . '_sell'],0,10).'</a></td>';
    //                     } else {
    //                         $comment_sell .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
    //                     if ($rules_set_arr['sell_last_candle_status' . $rule_numbernn . '_enable'] == 'yes') {
    //                         $last_candle_status_sell .= '<td>' . ucfirst($rules_set_arr['last_candle_status' . $rule_numbernn . '_sell']) . '</td>';
    //                     } else {
    //                         $last_candle_status_sell .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
    //                     // New data here
    //                     if ($rules_set_arr['rule_sorting' . $rule_numbernn . '_enable'] == 'yes') {
    //                         $rule_sort_sell .= '<td>' . $rules_set_arr['rule_sort' . $rule_numbernn . '_sell'] . '</td>';
    //                     } else {
    //                         $rule_sort_sell .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
    //                     if ($rules_set_arr['buyers_vs_sellers_sell' . $rule_numbernn . '_enable'] == 'yes') {
    //                         $buyers_vs_sellers_sell .= '<td>' . $rules_set_arr['buyers_vs_sellers' . $rule_numbernn . '_sell'] . '</td>';
    //                     } else {
    //                         $buyers_vs_sellers_sell .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
    //                     if ($rules_set_arr['buy_percentile_' . $rule_numbernn . '_apply_sell'] == 'yes') {
    //                         $buy_percentile__sell .= '<td>' . $rules_set_arr['buy_percentile_' . $rule_numbernn . '_sell'] . '</td>';
    //                     } else {
    //                         $buy_percentile__sell.= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
                        
                        
    //                     if ($rules_set_arr['ask_percentile_' . $rule_numbernn . '_apply_sell'] == 'yes') {
    //                         $ask_percentile__sell .= '<td>' . $rules_set_arr['ask_percentile_' . $rule_numbernn . '_sell'] . '</td>';
    //                     } else {
    //                         $ask_percentile__sell .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
    //                     if ($rules_set_arr['sell_percentile_' . $rule_numbernn . '_apply_sell'] == 'yes') {
    //                         $sell_percentile__sell .= '<td>' . $rules_set_arr['sell_percentile_' . $rule_numbernn . '_sell'] . '</td>';
    //                     } else {
    //                         $sell_percentile__sell .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
    //                     if ($rules_set_arr['bid_percentile_' . $rule_numbernn . '_apply_sell'] == 'yes') {
    //                         $bid_percentile__sell .= '<td>' . $rules_set_arr['bid_percentile_' . $rule_numbernn . '_sell'] . '</td>';
    //                     } else {
    //                         $bid_percentile__sell .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
                        
                    
                        
    //                     $coin            = $this->input->post('coin');
    //                     $triggers_type   = $this->input->post('triggers_type');
    //                     $testing         = $this->input->post('testing');
                    
    //                 if($testing!='' && $testing=='testing'){
    //                     $avgProfit  = '';
    //                     $htmlData   = '';
    //                     $responseArr  = getAvgProfitLoss($coin,$rule_numbernn,$triggers_type);
                        
    //                     if($responseArr['avg_profit']!=''){
    //                     $avgProfitAll .= '<td>' . number_format($responseArr['avg_profit'],2).' %' . '</td>';
    //                     }else{
    //                     $avgProfitAll .= '<td>' . '<span class="label label-warning">No Profit</span>' . '</td>';	 
    //                     }
    //                     $htmlData     ='<tr class="center" style="background:#4267b2; color:#FFF; "><th>Avg Profit</th> '. $avgProfitAll.'</tr>';	 
                        
    //                     if($responseArr['total_sold_orders']!=''){
    //                     $totalSoldOrder .= '<td>' . ($responseArr['total_sold_orders']) . '</td>';
    //                     }else{
    //                     $totalSoldOrder .= '<td>' . '<span class="label label-warning">No Order</span>' . '</td>';	 
    //                     }
    //                     $htmlDataSoldOrder ='<tr class="center" style="background:#4267b2; color:#FFF; "><th style="    background: #4267b2;color: #FFF;">Total Sold Order</th> '. $totalSoldOrder.'</tr>';	 
    //                 }
    //                 }
    //             }
    //             $html .= '<tr class="center">
    //                         <th style="width:350px; border-right:3px solid #ddd;">Status</th>' . $sell_status_rule . '

    //                     </tr>
                        
    //                     <tr class="center">
    //                         <th>Trigger Rule</th>
                        
    //     ' . $sell_trigger_type_ruleArr . '

    //                     </tr>
                        
                        
                        
                        
    //                         <tr class="center">
    //                         <th>(Support Barrier)(Virtual Barrier) (less or Equal From defined value)</th>
                    
    //     '. $buy_virtural_rule_for_sell_.'
                        
    //                     </tr>
                        
    //                         <tr class="center">
    //                         <th>(Resistance Barrier)(Resistance Should be Greater or Equal then Defined value)</th>
                    
    //     '. $sell_virtural_rule_.'
                        
    //                     </tr>
                        
    //                     <tr class="center">
    //                         <th>(If Volume greater then the defined value)</th>
                            
    //     ' . $sell_volume_rule_ . '

    //                     </tr>
    //                     <tr class="center">
    //                         <th> Down pressure (Sell: Down pressure is Less or equal to the defined pressure)</th>
    //                         '. $done_pressure_rule .'
    //                     </tr>
    //                     <tr class="center">
    //                         <th>Big Sellers % ( percent greater then the defined %)</th>
                        
    //     ' . $big_seller_percent_compare_rule_sell . '

    //                     </tr>
    //                     <tr class="center">
    //                         <th>Closest black wall( Greater then or equal to the defined value)</th>
                        
    //     ' . $closest_black_wall_rule_sell . '

    //                     </tr>
    //                     <tr class="center">
    //                         <th>Closest yellow wall (Greater then or equal to the defined value)</th>
                        
    //     ' . $closest_yellow_wall_rule_sell . '

    //                     </tr>
    //                     <tr class="center">
    //                         <th>Seven level pressue (Greater then or equal to the defined value)</th>
                            
    //     ' . $seven_level_pressure_rule_sell . '

    //                     </tr>
                        
    //                     <tr class="center">
    //                         <th> Sell % (when we sell the order we check if the defined percenage is meet)</th>
                            
    //     ' . $sell_percent_rule . '

    //                     </tr>
                        
    //                     <tr class="center">
    //                         <th> Seller vs Buys</th>
                        
    //     ' . $seller_vs_buyer_rule . '

    //                     </tr>
    //                     <tr class="center">
    //                         <th>Last Candle Type</th>
                        
    //     ' . $last_candle_type_sell . '

    //                     </tr>
    //                     <tr class="center">
    //                         <th>Rejection Candle Type</th>
                        
    //     ' . $rejection_candle_type_sell . '

    //                     </tr>
    //                     <tr class="center">
    //                         <th>Last 200 Contract Sellers Vs Buyers</th>
                    
    //     ' . $last_200_contracts_buy_vs_sell . '

    //                     </tr>
    //                     <tr class="center">
    //                         <th>Last 200 Contract Time(Less then)</th>
                            
    //     ' . $last_200_contracts_time_sell . '

    //                     </tr>
    //                     <tr class="center">
    //                         <th>Last qty Contract seller Vs Buyes</th>
                            
    //     ' . $sell_last_qty_buyers_vs_seller . '

    //                     </tr>
    //                     <tr class="center">
    //                         <th>Last qty Contract time(Less then)</th>
                        
    //     ' . $last_qty_time_sell . '

    //                     </tr>
    //                     <tr class="center">
    //                         <th>Score</th>
                            
    //     ' . $score_sell . '

    //                     </tr>
                        
    //                     <tr class="center">
    //                         <th>Comment</th>
                        
    //     ' . $comment_sell . '

    //                     </tr>
                        
    //                     <tr class="center">
    //                         <th>Order Level</th>
                            
    //         '. $sell_order_levelAll.'
    //                         </tr>
                            
    //                         <tr class="center">
    //                         <th>Last Candle Status</th>
    //                 '.
    //         $last_candle_status_sell.'
    //                         </tr>
                            
    //                         <tr class="center">
    //                         <th>Rule Sorting</th>
    //                 '.
    //         $rule_sort_sell.'
    //                         </tr>
    //                         <tr class="center">
    //                         <th>Buyers Vs Sellers 15 Minute</th>
    //                 '.
    //         $buyers_vs_sellers_sell.'
    //                         </tr>
                            
    //                         <tr class="center">
    //                         <th>((Binance buy) ASk Should be greater or Equal from Defined value) (One minute Rooling candle)</th>
    //                 '.
    //         $buy_percentile__sell.'
    //                         </tr>
                            
    //                         <tr class="center">
    //                         <th>((Binance Sell)Bid Should be Less or Equal from Defined value) (One minute Rooling candle)</th>
    //                 '.
    //         $ask_percentile__sell.'
    //                         </tr>
                            
    //                         <tr class="center">
    //                         <th>((Digie Buy) Buy Should be greater or Eqaual from defined value) (One minute Rooling candle)</th>
    //                 '.
    //         $sell_percentile__sell.'
    //                         </tr>
                            
                            
    //                         <tr class="center">
    //                         <th>((Digie Sell) Sell Should be Less or Equal from Defined value) (One minute Rooling candle)</th>
    //                 '.
    //         $bid_percentile__sell.'
    //                         </tr>
                            
                            
                            
    //                     '.$htmlData.'
    //                     '.$htmlDataSoldOrder.'
                        
    //                     </tbody>
    //                 </table>
                    
    //                 <!--End of Sell part --> 
    //                 </div></div></div>';
    //             }
    //             else if($triggers_type=='barrier_percentile_trigger'){
                    
    //                 $html .= '<div class="col-md-12 appnedAjax">
                
    //                 <ul class="nav nav-tabs">
    //                 <li class="active"><a data-toggle="tab" href="#buy">Buy Rules</a></li>
    //                 <li><a data-toggle="tab" href="#sell">Sell Rules</a></li>
    //                 <li><a data-toggle="tab" href="#stoploss">Stop Loss Rules</a></li>
    //                 </ul>
    //                 <div class="tab-content ">
    //                 <div id="buy" class="tab-pane fade in active"> 
    //                     <!-- Buy part -->
                
    //                     <table class="table table-bordered zama_th">
    //                     <thead>
    //                         <tr>
    //                         <th class="" style="background:#4267b2; color: #FFF;">'. $coin .'</th>';
        
    //             $level_number = 1;
    //             foreach($rules_set_arr as $row){ 
                
    //                 if ($row['trigger_level'] ){
            
    //                         if($row['enable_buy_barrier_percentile']=='yes'){
    //                             $onOff = '<span class="label label-success pull-right">ON</span>';
    //                         }else{
    //                             $onOff = '<span class="label label-danger pull-right">OFF</span>';  
    //                         }
                                    
    //                 $html .= '<th class="center" style="background:#4267b2; color: #FFF;">'.$row['trigger_level'].''.$onOff.'</th>';
    //                 $level_number++;
    //                 }
    //             }
                
    //                         $html .= '</tr>
    //                     </thead>
    //                     <tbody>';
                        
    //         $barrier_percentile_is_previous_blue_candel                       = '';
    //         $barrier_percentile_bottom_demond_rejection                       = '';
    //         $barrier_percentile_bottom_supply_rejection                       = '';      
    //         $barrier_percentile_trigger_default_stop_loss_percenage           = '';
    //         $barrier_percentile_trigger_barrier_range_percentage              = '';
    //         $barrier_percentile_trigger_buy_black_wall_apply                  = '';
    //         $barrier_percentile_trigger_buy_virtual_barrier                   = '';
    //         $barrier_percentile_trigger_buy_seven_level_pressure              = '';
    //         $barrier_percentile_trigger_buy_last_200_contracts_buy_vs_sell    = '';
    //         $barrier_percentile_trigger_buy_last_200_contracts_time           = '';
    //         $barrier_percentile_trigger_buy_last_qty_contracts_buyer_vs_seller= '';
    //         $barrier_percentile_trigger_buy_last_qty_contracts_time           = '';
    //         $barrier_percentile_trigger_5_minute_rolling_candel               = '';
    //         $barrier_percentile_trigger_15_minute_rolling_candel              = '';
    //         $barrier_percentile_trigger_buyers_buy                            = '';
    //         $barrier_percentile_trigger_sellers_buy                           = '';
            
        
    //         $level_number = 0;
    //         foreach($rules_set_arr as $row){ 
            
    //         // if ($row['trigger_level'] == 'level_'.$level_number ) {
    //                 if ($row['trigger_level'] ){ 
    //                 if ($row['barrier_percentile_is_previous_blue_candel'] == 'yes') {
    //                     $barrier_percentile_is_previous_blue_candel .= '<td>' . ucfirst($row['percentile_trigger_last_candle_type']) . '</td>';
    //                 } else {
    //                     $barrier_percentile_is_previous_blue_candel .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                    
    //                 $barrier_percentile_trigger_default_stop_loss_percenageData  = ($row['barrier_percentile_trigger_default_stop_loss_percenage']!='') ?  $row['barrier_percentile_trigger_default_stop_loss_percenage'] : '---';
    //                 $barrier_percentile_trigger_default_stop_loss_percenage     .= '<td>' .$barrier_percentile_trigger_default_stop_loss_percenageData . ' </td>';
                    
    //                 $barrier_percentile_trigger_barrier_range_percentageData  = ($row['barrier_percentile_trigger_barrier_range_percentage']!='') ?  $row['barrier_percentile_trigger_barrier_range_percentage'] : '---';
    //                 $barrier_percentile_trigger_barrier_range_percentage     .= '<td>' .$barrier_percentile_trigger_barrier_range_percentageData . ' </td>';
                    
                    
    //                 if ($row['barrier_percentile_trigger_buy_black_wall_apply'] == 'yes') {
    //                     $barrier_percentile_trigger_buy_black_wall .= '<td> Top ' . $row['barrier_percentile_trigger_buy_black_wall'] . ' % 
    //                     <span style="font-size:11px;     color: #a03d3d;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ( '.number_format((float)$percentil['blackwall_'.$row['barrier_percentile_trigger_buy_black_wall'].''], 2, '.', '').'  ) 
    //                     </span></td>';
    //                 } else {
    //                     $barrier_percentile_trigger_buy_black_wall .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                    
                    
    //                 if ($row['barrier_percentile_trigger_buy_virtual_barrier_apply'] == 'yes') {
    //                     $barrier_percentile_trigger_buy_virtual_barrier .= '<td> Top ' . $row['barrier_percentile_trigger_buy_virtual_barrier'] .' %
    //                     <span style="font-size:11px;     color: #a03d3d;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ( '.number_format((float)$percentil['ask_quantity_'.$row['barrier_percentile_trigger_buy_black_wall'].''], 2, '.', '').'  )
    //                     </span></td>';
    //                 } else {
    //                     $barrier_percentile_trigger_buy_virtual_barrier .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                    
    //                 if ($row['barrier_percentile_trigger_sell_virtual_barrier_for_buy_apply'] == 'yes') {
    //                     $barrier_percentile_trigger_sell_virtual_barrier_for_buy .= '<td> Bottom ' . $row['barrier_percentile_trigger_sell_virtual_barrier_for_buy'] .' %</td>';
    //                 } else {
    //                     $barrier_percentile_trigger_sell_virtual_barrier_for_buy .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                    
                    
                    
    //                 if ($row['barrier_percentile_trigger_buy_seven_level_pressure_apply'] == 'yes') {
    //                     $barrier_percentile_trigger_buy_seven_level_pressure .= '<td> Top ' . $row['barrier_percentile_trigger_buy_seven_level_pressure']. ' %
    //                     <span style="font-size:11px;     color: #a03d3d;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ( '.number_format((float)$percentil['sevenlevel_'.$row['barrier_percentile_trigger_buy_black_wall'].''], 2, '.', '').'  ) 
    //                     </span></td>';
    //                 } else {
    //                     $barrier_percentile_trigger_buy_seven_level_pressure .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                    
                    
    //                 if ($row['barrier_percentile_trigger_buy_last_200_contracts_buy_vs_sell_apply'] == 'yes') {
    //                     $barrier_percentile_trigger_buy_last_200_contracts_buy_vs_sell .= '<td>' . $row['barrier_percentile_trigger_buy_last_200_contracts_buy_vs_sell'] . '</td>';
    //                 } else {
    //                     $barrier_percentile_trigger_buy_last_200_contracts_buy_vs_sell .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                    
    //                 if ($row['barrier_percentile_trigger_buy_last_200_contracts_time_apply'] == 'yes') {
    //                     $barrier_percentile_trigger_buy_last_200_contracts_time .= '<td>' . $row['barrier_percentile_trigger_buy_last_200_contracts_time'] . '</td>';
    //                 } else {
    //                     $barrier_percentile_trigger_buy_last_200_contracts_time .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                    
                    
    //                 if ($row['barrier_percentile_trigger_buy_last_qty_contracts_buyer_vs_seller_apply'] == 'yes') {
    //                     $barrier_percentile_trigger_buy_last_qty_contracts_buyer_vs_seller .= '<td>' . $row['barrier_percentile_trigger_buy_last_qty_contracts_buyer_vs_seller'] . '</td>';
    //                 } else {
    //                     $barrier_percentile_trigger_buy_last_qty_contracts_buyer_vs_seller .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                    
                    
    //                 if ($row['barrier_percentile_trigger_buy_last_qty_contracts_time_apply'] == 'yes') {
    //                     $barrier_percentile_trigger_buy_last_qty_contracts_time .= '<td>' . $row['barrier_percentile_trigger_buy_last_qty_contracts_time'] . '</td>';
    //                 } else {
    //                     $barrier_percentile_trigger_buy_last_qty_contracts_time .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
    //                 //number_format((float)$foo, 2, '.', '')
                    
    //                 if ($row['barrier_percentile_trigger_5_minute_rolling_candel_apply'] == 'yes') {
    //                     $barrier_percentile_trigger_5_minute_rolling_candel .= '<td> Top '  .$row['barrier_percentile_trigger_5_minute_rolling_candel'].' %
    //                     <span style="font-size:11px;     color: #a03d3d;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ( '.number_format((float)$percentil['five_min_'.$row['barrier_percentile_trigger_5_minute_rolling_candel'].''], 2, '.', '')
    //                     .'  )</span></td>';
    //                 } else {
    //                     $barrier_percentile_trigger_5_minute_rolling_candel .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                    
                    
    //                 if ($row['barrier_percentile_trigger_15_minute_rolling_candel_apply'] == 'yes') {
    //                     $barrier_percentile_trigger_15_minute_rolling_candel .= ' <td class="center"> Top ' .  $row['barrier_percentile_trigger_15_minute_rolling_candel']. ' %
    //                     <span style="font-size:11px;     color: #a03d3d;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ( '.number_format((float)$percentil['fifteen_min_'.$row['barrier_percentile_trigger_15_minute_rolling_candel'].''],
    //                     2, '.', '').' )</span></td>';
    //                 } else {
    //                     $barrier_percentile_trigger_15_minute_rolling_candel .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                    
                    
    //                 if ($row['barrier_percentile_trigger_buyers_buy_apply'] == 'yes') {
    //                     $barrier_percentile_trigger_buyers_buy .= ' <td class="center"> Top ' .  $row['barrier_percentile_trigger_buyers_buy']. ' %
    //                     <span style="font-size:11px;     color: #a03d3d;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ( '.number_format((float)$percentil['buy_'.$row['barrier_percentile_trigger_buyers_buy'].''], 2, '.', '').' ) </span></td>';
    //                 } else {
    //                     $barrier_percentile_trigger_buyers_buy .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                    
    //                 if ($row['barrier_percentile_trigger_sellers_buy_apply'] == 'yes') {
    //                     $barrier_percentile_trigger_sellers_buy .= ' <td class="center"> Bottom ' .  $row['barrier_percentile_trigger_sellers_buy']. ' %
    //                     <span style="font-size:11px;     color: #a03d3d;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ( '.number_format((float)$percentil['sell_'.$row['barrier_percentile_trigger_sellers_buy'].''], 2, '.', '').'
    //                     ) </span></td>';
    //                 } else {
    //                     $barrier_percentile_trigger_sellers_buy .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
    //                 // New work 
    //                 if ($row['barrier_percentile_trigger_15_minute_last_time_ago_apply'] == 'yes') {
    //                     $barrier_percentile_trigger_15_minute_last_time_ago .= ' <td class="center"> Bottom ' .  $row['barrier_percentile_trigger_15_minute_last_time_ago']. ' % </td>';
    //                 } else {
    //                     $barrier_percentile_trigger_15_minute_last_time_ago .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
    //                 if ($row['barrier_percentile_trigger_ask_apply'] == 'yes') {
    //                     $barrier_percentile_trigger_ask .= ' <td class="center"> Top ' .  $row['barrier_percentile_trigger_ask']. ' % </td>';
    //                 } else {
    //                     $barrier_percentile_trigger_ask .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
    //                 if ($row['barrier_percentile_trigger_bid_apply'] == 'yes') {
    //                     $barrier_percentile_trigger_bid .= ' <td class="center"> Bottom ' .  $row['barrier_percentile_trigger_bid']. ' % </td>';
    //                 } else {
    //                     $barrier_percentile_trigger_bid .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
    //                 if ($row['barrier_percentile_trigger_buy_apply'] == 'yes') {
    //                     $barrier_percentile_trigger_buy .= ' <td class="center"> Top ' .  $row['barrier_percentile_trigger_buy']. ' % </td>';
    //                 } else {
    //                     $barrier_percentile_trigger_buy .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
    //                 if ($row['barrier_percentile_trigger_sell_apply'] == 'yes') {
    //                     $barrier_percentile_trigger_sell .= ' <td class="center"> Bottom ' .  $row['barrier_percentile_trigger_sell']. ' % </td>';
    //                 } else {
    //                     $barrier_percentile_trigger_sell .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
    //                 if ($row['barrier_percentile_trigger_ask_contracts_apply'] == 'yes') {
    //                     $barrier_percentile_trigger_ask_contracts .= ' <td class="center"> Top ' .  $row['barrier_percentile_trigger_ask_contracts']. ' % </td>';
    //                 } else {
    //                     $barrier_percentile_trigger_ask_contracts .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
    //                 if ($row['barrier_percentile_trigger_bid_contracts_apply'] == 'yes') {
    //                     $barrier_percentile_trigger_bid_contracts .= ' <td class="center"> Bottom ' .  $row['barrier_percentile_trigger_bid_contracts']. ' % </td>';
    //                 } else {
    //                     $barrier_percentile_trigger_bid_contracts .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
    //                 // New Caption 
    //                 if ($row['percentile_trigger_caption_option_buy_apply'] == 'yes') {
    //                     $percentile_trigger_caption_option_buy .= ' <td class="center">  ' .  $row['percentile_trigger_caption_option_buy']. '  </td>';
    //                 } else {
    //                     $percentile_trigger_caption_option_buy .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
    //                 if ($row['percentile_trigger_caption_score_buy_apply'] == 'yes') {
    //                     $percentile_trigger_caption_score_buy .= ' <td class="center">  ' .  $row['percentile_trigger_caption_score_buy']. '  </td>';
    //                 } else {
    //                     $percentile_trigger_caption_score_buy .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
    //                 if ($row['percentile_trigger_buy_trend_buy_apply'] == 'yes') {
    //                     $percentile_trigger_buy_trend_buy .= ' <td class="center">  ' .  $row['percentile_trigger_buy_trend_buy']. '  </td>';
    //                 } else {
    //                     $percentile_trigger_buy_trend_buy .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
    //                 if ($row['percentile_trigger_sell_buy_apply'] == 'yes') {
    //                     $percentile_trigger_sell_buy .= ' <td class="center">  ' .  $row['percentile_trigger_sell_buy']. '  </td>';
    //                 } else {
    //                     $percentile_trigger_sell_buy .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                    
    //                 if ($row['percentile_trigger_demand_buy_apply'] == 'yes') {
    //                     $percentile_trigger_demand_buy .= ' <td class="center">  ' .  $row['percentile_trigger_demand_buy']. '  </td>';
    //                 } else {
    //                     $percentile_trigger_demand_buy .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
    //                 if ($row['percentile_trigger_supply_buy_apply'] == 'yes') {
    //                     $percentile_trigger_supply_buy .= ' <td class="center">  ' .  $row['percentile_trigger_supply_buy']. '  </td>';
    //                 } else {
    //                     $percentile_trigger_supply_buy .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
    //                 if ($row['percentile_trigger_market_trend_buy_apply'] == 'yes') {
    //                     $percentile_trigger_market_trend_buy .= ' <td class="center">  ' .  (($row['percentile_trigger_market_trend_buy']=='POSITIVE') ? '<span class="label label-success">Positive + </span>' 
    //                                                             : '<span class="label label-warning">Negative - </span>').'</td>';
    //                 } else {
    //                     $percentile_trigger_market_trend_buy .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
    //                 if ($row['percentile_trigger_meta_trading_buy_apply'] == 'yes') {
    //                     $percentile_trigger_meta_trading_buy .= ' <td class="center">  ' .  $row['percentile_trigger_meta_trading_buy']. '  </td>';
    //                 } else {
    //                     $percentile_trigger_meta_trading_buy .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
    //                 if ($row['percentile_trigger_riskpershare_buy_apply'] == 'yes') {
    //                     $percentile_trigger_riskpershare_buy .= ' <td class="center">  ' .  $row['percentile_trigger_riskpershare_buy']. '  </td>';
    //                 } else {
    //                     $percentile_trigger_riskpershare_buy .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
    //                 if ($row['percentile_trigger_RL_buy_apply'] == 'yes') {
    //                     $percentile_trigger_RL_buy .= ' <td class="center">  ' .  $row['percentile_trigger_RL_buy']. '  </td>';
    //                 } else {
    //                     $percentile_trigger_RL_buy .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                    
    //             } $level_number++;
    //         //}
    //         }// if ($row['trigger_level'] 
            
    //                     $html .= ' 
                        
    //                     <tr class="center">
    //                         <th style="width:350px; border-right:3px solid #ddd;">Previous Candle Status </th>
                            
    //     '. $barrier_percentile_is_previous_blue_candel;
        
    //                     $html .= '</tr>
                        
                        
    //                     <tr class="center">
    //                         <th style="width:350px; border-right:3px solid #ddd;">By Default Stop Loss in Percentage (Equal To Recommended)</th>
                            
    //     '. $barrier_percentile_trigger_default_stop_loss_percenage;
        
    //                     $html .= '</tr>
    //                         <tr class="center">
    //                         <th style="width:350px; border-right:3px solid #ddd;">Barrier Range Percentage (Current Market Between percentage)</th>
                            
    //     '. $barrier_percentile_trigger_barrier_range_percentage;
        
            
    //                     $html .= '</tr>
    //                         <tr class="center">
    //                         <th style="width:350px; border-right:3px solid #ddd;">(Black Wall Greater From defined percentile)</th>
                            
    //     '. $barrier_percentile_trigger_buy_black_wall;
        
    //                         $html .= '</tr>
    //                         <tr class="center">
    //                         <th>(Virtual Barrier Greater From defined percentile)</th> 
                            
    //         '.$barrier_percentile_trigger_buy_virtual_barrier;
        
    //                         $html .= '</tr>
                            
    //                         <tr class="center">
    //                         <th>Virtual Barrier (Less Then) From defined percentile (Resistance Barrier)</th> 
                            
    //         '.$barrier_percentile_trigger_sell_virtual_barrier_for_buy;
        
    //                         $html .= '</tr>
                            
                            
    //                         <tr class="center">
    //                         <th>(Seven Level Greater From defined percentile)</th>
                            
    //         '.$barrier_percentile_trigger_buy_seven_level_pressure;
        
    //                         $html .= '</tr>
    //                         <tr class="center">
    //                         <th>Last 200 Contract Buyers Vs Sellers Greater then recommended</th>
                            
    //     '. $barrier_percentile_trigger_buy_last_200_contracts_buy_vs_sell;
        
    //                         $html .= '</tr>
    //                         <tr class="center">
    //                         <th> Last 200 Contract Time Less Then recommended Value</th>
    //                         '.  $barrier_percentile_trigger_buy_last_200_contracts_time;
    //                         $html .= ' </tr>
    //                         <tr class="center">
    //                         <th>Last Qty Contract Buyers Vs Sellers (Greater Then Recommended)</th>
                            
    //         '. $barrier_percentile_trigger_buy_last_qty_contracts_buyer_vs_seller;
            
    //                         $html .= '</tr>
    //                         <tr class="center">
    //                         <th>Last qty Contract time(Less then)</th>
                            
    //         '. $barrier_percentile_trigger_buy_last_qty_contracts_time;
            
    //                     $html .= ' </tr>
    //                         <tr class="center">
    //                         <th>(5 Minute Rolling Candel Greater From defined percentile)</th>
                            
    //             '. $barrier_percentile_trigger_5_minute_rolling_candel;
        
    //                         $html .= '</tr>
    //                         <tr class="center">
    //                         <th>(15 Minute Rolling Candel Greater From defined percentile)</th>
                            
    //         '. $barrier_percentile_trigger_15_minute_rolling_candel;
            
            
    //                         $html .= '</tr>
    //                         <tr class="center">
    //                         <th>(Buyer Should be greater from Top percentile)</th>
                            
    //         '. $barrier_percentile_trigger_buyers_buy;
            
            
    //                         $html .= '</tr>
    //                         <tr class="center">
    //                         <th>(Sellers Should be Less Then Bottom percentile)</th>
                            
    //         '. $barrier_percentile_trigger_sellers_buy;
            
    //                         $html .= '</tr>
                            
    //                         <tr class="center">
    //                         <th>(15 Minute last time ago Should be Less Then Bottom percentile)(T3 LTC Time)</th>
                            
    //         '. $barrier_percentile_trigger_15_minute_last_time_ago;
            
            
    //                         $html .= '</tr>
    //                         <tr class="center">
    //                         <th>( (Binance buy) ASk Should be greater from Top percentile) (One minute Rooling candle)</th>
                            
    //         '. $barrier_percentile_trigger_ask;
            
            
    //                         $html .= '</tr>
    //                         <tr class="center">
    //                         <th>((Binance Sell)Bid Should be Less Then Bottom percentile) (One minute Rooling candle)</th>
                            
    //         '. $barrier_percentile_trigger_bid;
            
            
    //                         $html .= '</tr>
    //                         <tr class="center">
    //                         <th>((Digie Buy) Buy Should be greater from Top percentile) (One minute Rooling candle)</th>
                            
    //         '. $barrier_percentile_trigger_buy;
            
            
    //                         $html .= '</tr>
    //                         <tr class="center">
    //                         <th>((Digie Sell) Sell Should be Less Then Bottom percentile) (One minute Rooling candle)</th>
                            
    //         '. $barrier_percentile_trigger_sell;
            
            
    //                         $html .= '</tr>
    //                         <tr class="center">
    //                         <th>((Big Buyers) Ask Contracts Should be Greater from Top percentile)))</th>
                            
    //         '. $barrier_percentile_trigger_ask_contracts;
            
            
    //                         $html .= '</tr>
    //                         <tr class="center">
    //                         <th>((Big Sellers) Bid Contracts Should be Les then Bottom percentile)))</th>
                            
    //         '. $barrier_percentile_trigger_bid_contracts;
            
                    
    //         // Yaha say 
    //         $html .= '</tr>
    //                         <tr class="center">
    //                         <th>Caption Option</th>
                            
    //         '. $percentile_trigger_caption_option_buy;
            
            
    //         $html .= '</tr>
    //                         <tr class="center">
    //                         <th>Caption Score</th>
                            
    //         '. $percentile_trigger_caption_score_buy;
            
            
    //         $html .= '</tr>
    //                         <tr class="center">
    //                         <th>Buy</th>
                            
    //         '. $percentile_trigger_buy_trend_buy;
            
            
    //         $html .= '</tr>
    //                         <tr class="center">
    //                         <th>Sell</th>
                            
    //         '. $percentile_trigger_sell_buy;
            
    //         $html .= '</tr>
    //                         <tr class="center">
    //                         <th>Demand</th>
                            
    //         '. $percentile_trigger_demand_buy;
            
    //         $html .= '</tr>
    //                         <tr class="center">
    //                         <th>Supply</th>
                            
    //         '. $percentile_trigger_supply_buy;
            
    //         $html .= '</tr>
    //                         <tr class="center">
    //                         <th>Market Trend</th>
                            
    //         '. $percentile_trigger_market_trend_buy;
            
    //         $html .= '</tr>
    //                         <tr class="center">
    //                         <th>Meta Tranding</th>
                            
    //         '. $percentile_trigger_meta_trading_buy;
            
            
    //         $html .= '</tr>
    //                         <tr class="center">
    //                         <th>Resk per Share</th>
                            
    //         '. $percentile_trigger_riskpershare_buy;
            
            
    //         $html .= '</tr>
    //                         <tr class="center">
    //                         <th>RL</th>
                            
    //         '. $percentile_trigger_RL_buy;
            
    //                         $html .= '</tr>
                            
    //                     </tbody>
    //                     </table>
    //                 </div>
    //                 <div class="clearfix"></div>
    //                 <!--End of Buy part -->
                    
    //                 <div id="sell" class="tab-pane fade">
    //                     <table class="table table-bordered zama_th">
    //                     <thead>
    //                         <tr>
    //                         <th class="" style="background:#4267b2; color: #FFF;">'. $coin.'</th>';
            
    //         $level_number = 0;
    //         foreach($rules_set_arr as $row){ 
            
    //                 if ($row['trigger_level'] ) {
                
    //                         if($row['enable_sell_barrier_percentile']=='yes'){
    //                             $onOff = '<span class="label label-success pull-right">ON</span>';
    //                         }else{
    //                             $onOff = '<span class="label label-danger pull-right">OFF</span>';  
    //                         }
    //                         $html .= ' <th class="center" style="background:#4267b2; color: #FFF;"> '. $row['trigger_level'] .' '.$onOff.'</th>';
    //                 } 
    //                 $level_number++;
    //         }
    //                         $html .= ' </tr>
    //                     </thead>
    //                     <tbody>';
                        
    //         $barrier_percentile_trigger_default_profit_percenage               = '';               
    //         $trailing_difference_between_stoploss_and_current_market_percentage= '';
    //         $barrier_percentile_trigger_sell_black_wall_apply                  = '';
    //         $barrier_percentile_trigger_sell_virtual_barrier                   = '';
    //         $barrier_percentile_trigger_sell_seven_level_pressure              = '';
    //         $barrier_percentile_trigger_sell_last_200_contracts_buy_vs_sell    = '';
    //         $barrier_percentile_trigger_sell_last_200_contracts_time           = '';
    //         $barrier_percentile_trigger_sell_last_qty_contracts_buyer_vs_seller= '';
    //         $barrier_percentile_trigger_sell_last_qty_contracts_time           = '';
    //         $barrier_percentile_trigger_5_minute_rolling_candel_sell           = '';
    //         $barrier_percentile_trigger_15_minute_rolling_candel_sell          = '';
    //         $barrier_percentile_trigger_buyers_sell                            = '';
    //         $barrier_percentile_trigger_sellers_sell                           = '';
        
    //         $level_number = 0;
    //         foreach($rules_set_arr as $row){ 
            
    //         if ($row['trigger_level']) {
                    
                    
    //                     $barrier_percentile_trigger_default_profit_percenage .= '<td>' . $row['barrier_percentile_trigger_default_profit_percenage'] . ' </td>';
    //                     $trailing_difference_between_stoploss_and_current_market_percentage .= '<td>' . $row['barrier_percentile_trigger_trailing_difference_between_stoploss_and_current_market_percentage'] . ' </td>';
                    
    //                 if ($row['barrier_percentile_trigger_sell_black_wall_apply'] == 'yes') {
    //                     $barrier_percentile_trigger_sell_black_wall .= '<td> Bottom ' . $row['barrier_percentile_trigger_sell_black_wall'] . ' %
    //                     <span style="font-size:11px;     color: #a03d3d;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ( '.number_format((float)$percentil['blackwall_b_'.$row['barrier_percentile_trigger_sell_black_wall'].''], 
    //                     2, '.', '').' ) 
    //                     </span></td>';
    //                 } else {
    //                     $barrier_percentile_trigger_sell_black_wall .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                    
                    
    //                 if ($row['barrier_percentile_trigger_sell_virtual_barrier_apply'] == 'yes') {
    //                     $barrier_percentile_trigger_sell_virtual_barrier .= '<td> Top ' . $row['barrier_percentile_trigger_sell_virtual_barrier'] .' %
    //                     <span style="font-size:11px;     color: #a03d3d;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ( '.number_format((float)$percentil['bid_quantity_'.$row['barrier_percentile_trigger_sell_virtual_barrier'].''], 
    //                     2, '.', '').' ) 
    //                     </span></td>';
    //                 } else {
    //                     $barrier_percentile_trigger_sell_virtual_barrier .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                    
                    
    //                 if ($row['barrier_percentile_trigger_buy_virtual_barrier_for_sell_apply'] == 'yes') {
    //                     $barrier_percentile_trigger_buy_virtual_barrier_for_sell .= '<td> Bottom ' . $row['barrier_percentile_trigger_buy_virtual_barrier_for_sell'] .' % </td>';
    //                 } else {
    //                     $barrier_percentile_trigger_buy_virtual_barrier_for_sell .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                    
                    
                    
    //                 if ($row['barrier_percentile_trigger_sell_seven_level_pressure_apply'] == 'yes') {
    //                     $barrier_percentile_trigger_sell_seven_level_pressure .= '<td> Bottom ' . $row['barrier_percentile_trigger_sell_seven_level_pressure']. ' %
    //                     <span style="font-size:11px;     color: #a03d3d;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ( '.number_format((float)$percentil['sevenlevel_b_'.$row['barrier_percentile_trigger_sell_seven_level_pressure'].''], 
    //                     2, '.', '').' )
    //                     </span></td>';
    //                 } else {
    //                     $barrier_percentile_trigger_sell_seven_level_pressure .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                    
                    
    //                 if ($row['barrier_percentile_trigger_sell_last_200_contracts_buy_vs_sell_apply'] == 'yes') {
    //                     $barrier_percentile_trigger_sell_last_200_contracts_buy_vs_sell .= '<td>' . $row['barrier_percentile_trigger_sell_last_200_contracts_buy_vs_sell'] . '</td>';
    //                 } else {
    //                     $barrier_percentile_trigger_sell_last_200_contracts_buy_vs_sell .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                    
    //                 if ($row['barrier_percentile_trigger_sell_last_200_contracts_time_apply'] == 'yes') {
    //                     $barrier_percentile_trigger_sell_last_200_contracts_time .= '<td>' . $row['barrier_percentile_trigger_sell_last_200_contracts_time'] . '</td>';
    //                 } else {
    //                     $barrier_percentile_trigger_sell_last_200_contracts_time .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                    
                    
    //                 if ($row['barrier_percentile_trigger_sell_last_qty_contracts_buyer_vs_seller_apply'] == 'yes') {
    //                     $barrier_percentile_trigger_sell_last_qty_contracts_buyer_vs_seller .= '<td>' . $row['barrier_percentile_trigger_sell_last_qty_contracts_buyer_vs_seller'] . '</td>';
    //                 } else {
    //                     $barrier_percentile_trigger_sell_last_qty_contracts_buyer_vs_seller .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }

                    
                    
    //                 if ($row['barrier_percentile_trigger_sell_last_qty_contracts_time_apply'] == 'yes') {
    //                     $barrier_percentile_trigger_sell_last_qty_contracts_time .= '<td>' . $row['barrier_percentile_trigger_sell_last_qty_contracts_time'] . '</td>';
    //                 } else {
    //                     $barrier_percentile_trigger_sell_last_qty_contracts_time .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                    
                    
    //                 if ($row['barrier_percentile_trigger_5_minute_rolling_candel_sell_apply'] == 'yes') {
    //                     $barrier_percentile_trigger_5_minute_rolling_candel_sell .= '<td> Bottom '  .$row['barrier_percentile_trigger_5_minute_rolling_candel_sell'].' %
    //                     <span style="font-size:11px;     color: #a03d3d;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ( '.number_format((float)$percentil['five_min_b_'.$row['barrier_percentile_trigger_5_minute_rolling_candel_sell'].''], 2, '.', '').
    //                 ' ) </span></td>';
    //                 } else {
    //                     $barrier_percentile_trigger_5_minute_rolling_candel_sell .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                    
                    
    //                 if ($row['barrier_percentile_trigger_15_minute_rolling_candel_sell_apply'] == 'yes') {
    //                     $barrier_percentile_trigger_15_minute_rolling_candel_sell .= ' <td class="center"> Bottom ' .  $row['barrier_percentile_trigger_15_minute_rolling_candel_sell']. ' %
    //                     <span style="font-size:11px;     color: #a03d3d;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ( '.number_format((float)$percentil['fifteen_min_b_'.$row['barrier_percentile_trigger_15_minute_rolling_candel_sell'].''], 2, '.', '')
    //                     .' ) </span></td>';
    //                 } else {
    //                     $barrier_percentile_trigger_15_minute_rolling_candel_sell .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                    
    //                 if ($row['barrier_percentile_trigger_buyers_sell_apply'] == 'yes') {
    //                     $barrier_percentile_trigger_buyers_sell .= ' <td class="center"> Bottom ' .  $row['barrier_percentile_trigger_buyers_sell']. ' %
    //                     <span style="font-size:11px;     color: #a03d3d;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ( '.number_format((float)$percentil['buyers_fifteen_b_'.$row['barrier_percentile_trigger_buyers_sell'].''], 2, '.', '').' ) 
    //                     </span></td>';
    //                 } else {
    //                     $barrier_percentile_trigger_buyers_sell .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                    
    //                 if ($row['barrier_percentile_trigger_sellers_sell_apply'] == 'yes') {
    //                     $barrier_percentile_trigger_sellers_sell .= ' <td class="center"> Top ' .  $row['barrier_percentile_trigger_sellers_sell']. ' %
    //                     <span style="font-size:11px;     color: #a03d3d;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ( '.number_format((float)$percentil['sellers_fifteen_b_'.$row['barrier_percentile_trigger_sellers_buy'].''], 2, '.', '').' ) 
    //                     </span></td>';
    //                 } else {
    //                     $barrier_percentile_trigger_sellers_sell .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                    
    //                 // New work Old
    //                 if ($row['barrier_percentile_trigger_15_minute_last_time_ago_sell_apply'] == 'yes') {
    //                     $barrier_percentile_trigger_15_minute_last_time_ago_sell .= ' <td class="center"> Bottom ' .  $row['barrier_percentile_trigger_15_minute_last_time_ago_sell']. ' % </td>';
    //                 } else {
    //                     $barrier_percentile_trigger_15_minute_last_time_ago_sell .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
    //                 if ($row['barrier_percentile_trigger_ask_sell_apply'] == 'yes') {
    //                     $barrier_percentile_trigger_ask_sell .= ' <td class="center"> Bottom ' .  $row['barrier_percentile_trigger_ask_sell']. ' % </td>';
    //                 } else {
    //                     $barrier_percentile_trigger_ask_sell .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
    //                 if ($row['barrier_percentile_trigger_bid_sell_apply'] == 'yes') {
    //                     $barrier_percentile_trigger_bid_sell .= ' <td class="center"> Top ' .  $row['barrier_percentile_trigger_bid_sell']. ' % </td>';
    //                 } else {
    //                     $barrier_percentile_trigger_bid_sell .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
    //                 if ($row['barrier_percentile_trigger_buy_sell_apply'] == 'yes') {
    //                     $barrier_percentile_trigger_buy_sell .= ' <td class="center"> Bottom ' .  $row['barrier_percentile_trigger_buy_sell']. ' % </td>';
    //                 } else {
    //                     $barrier_percentile_trigger_buy_sell .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                    
    //                 if ($row['barrier_percentile_trigger_sell_rule_sell_apply'] == 'yes') {
    //                     $barrier_percentile_trigger_sell_sell .= ' <td class="center"> Top ' .  $row['barrier_percentile_trigger_sell_rule_sell']. ' % </td>';
    //                 } else {
    //                     $barrier_percentile_trigger_sell_sell .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
    //                 if ($row['barrier_percentile_trigger_ask_contracts_sell_apply'] == 'yes') {
    //                     $barrier_percentile_trigger_ask_contracts_sell .= ' <td class="center">  Bottom' .  $row['barrier_percentile_trigger_ask_contracts_sell']. ' % </td>';
    //                 } else {
    //                     $barrier_percentile_trigger_ask_contracts_sell .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
    //                 if ($row['barrier_percentile_trigger_bid_contracts_sell_apply'] == 'yes') {
    //                     $barrier_percentile_trigger_bid_contracts_sell .= ' <td class="center"> Top ' .  $row['barrier_percentile_trigger_bid_contracts_sell']. ' % </td>';
    //                 } else {
    //                     $barrier_percentile_trigger_bid_contracts_sell .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
    //                 // New work Start from 4-22-2019
    //                 if ($row['percentile_trigger_caption_option_sell_apply'] == 'yes') {
    //                     $percentile_trigger_caption_option_sell .= ' <td class="center">  ' .  $row['percentile_trigger_caption_option_sell']. '  </td>';
    //                 } else {
    //                     $percentile_trigger_caption_option_sell .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
    //                 if ($row['percentile_trigger_caption_score_sell_apply'] == 'yes') {
    //                     $percentile_trigger_caption_score_sell .= ' <td class="center">  ' .  $row['percentile_trigger_caption_score_sell']. '  </td>';
    //                 } else {
    //                     $percentile_trigger_caption_score_sell .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
    //                 if ($row['percentile_trigger_buy_operator_sell_apply'] == 'yes') {
    //                     $percentile_trigger_buy_sell .= ' <td class="center">  ' .  $row['percentile_trigger_buy_sell']. '  </td>';
    //                 } else {
    //                     $percentile_trigger_buy_sell .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
    //                 if ($row['percentile_trigger_sell_buy_apply'] == 'yes') {
    //                     $percentile_trigger_sell_trend_sell .= ' <td class="center">  ' .  $row['percentile_trigger_sell_trend_sell']. '  </td>';
    //                 } else {
    //                     $percentile_trigger_sell_trend_sell .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                    
    //                 if ($row['percentile_trigger_demand_sell_apply'] == 'yes') {
    //                     $percentile_trigger_demand_sell .= ' <td class="center">  ' .  $row['percentile_trigger_demand_sell']. '  </td>';
    //                 } else {
    //                     $percentile_trigger_demand_sell .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
    //                 if ($row['percentile_trigger_supply_sell_apply'] == 'yes') {
    //                     $percentile_trigger_supply_sell .= ' <td class="center">  ' .  $row['percentile_trigger_supply_sell']. '  </td>';
    //                 } else {
    //                     $percentile_trigger_supply_sell .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
    //                 if ($row['percentile_trigger_market_trend_operator_sell_apply'] == 'yes') {
    //                     $percentile_trigger_market_trend_sell .= ' <td class="center">  ' .  (($row['percentile_trigger_market_trend_sell']=='POSITIVE') ? '<span class="label label-success">Positive + </span>' 
    //                                                             : '<span class="label label-warning">Negative - </span>').'</td>';
    //                 } else {
    //                     $percentile_trigger_market_trend_sell .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
    //                 if ($row['percentile_trigger_meta_trading_sell_apply'] == 'yes') {
    //                     $percentile_trigger_meta_trading_sell .= ' <td class="center">  ' .  $row['percentile_trigger_meta_trading_sell']. '  </td>';
    //                 } else {
    //                     $percentile_trigger_meta_trading_sell .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
    //                 if ($row['percentile_trigger_riskpershare_sell_apply'] == 'yes') {
    //                     $percentile_trigger_riskpershare_sell .= ' <td class="center">  ' .  $row['percentile_trigger_riskpershare_sell']. '  </td>';
    //                 } else {
    //                     $percentile_trigger_riskpershare_sell .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
    //                 if ($row['percentile_trigger_RL_sell_apply'] == 'yes') {
    //                     $percentile_trigger_RL_sell .= ' <td class="center">  ' .  $row['percentile_trigger_RL_sell']. '  </td>';
    //                 } else {
    //                     $percentile_trigger_RL_sell .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
    //             } $level_number++;
    //         }
        
    //                     $html .= ' <tr class="center">
    //                         <th style="width:350px; border-right:3px solid #ddd;">By Default Profit in Percentage(Equal To Recommended)</th>
                        
    //     '. $barrier_percentile_trigger_default_profit_percenage;
        
    //                     $html .= ' </tr>
    //                         <tr class="center">
    //                         <th style="width:350px; border-right:3px solid #ddd;">Trailing Difference between stop loss and current Market in Percentage(Eqaual To Recommended)</th>
                        
    //     '. $trailing_difference_between_stoploss_and_current_market_percentage;
        
        
    //                     $html .= '</tr>
    //                         <tr class="center">
    //                         <th style="width:350px; border-right:3px solid #ddd;">Black Wall (Less Then) From defined percentile</th>
                        
    //     '. $barrier_percentile_trigger_sell_black_wall;
            
                        
            
    //                     $html .= ' </tr>
                        
    //                         <tr class="center">
    //                         <th>(Virtual Barrier less then Bottom percentile)(Support Barrier)</th>
                            
    //         '. $barrier_percentile_trigger_buy_virtual_barrier_for_sell;
            
    //                     $html .= ' </tr>
    //                         <tr class="center">
    //                         <th>Virtual Barrier (Greater Then) From defined percentile (Resistance Barrier)</th>
                            
    //         '. $barrier_percentile_trigger_sell_virtual_barrier;
            
    //                     $html .= ' </tr>
                        
                        
    //                         <tr class="center">
    //                         <th>(Seven Level (Less Then) From defined percentile)</th>
                            
    //         '. $barrier_percentile_trigger_sell_seven_level_pressure;
            
            
    //                     $html .= ' </tr>
    //                         <tr class="center">
    //                         <th>Last 200 Contract Buyers Vs Sellers (Less then Recommended)</th>
                            
    //         '. $barrier_percentile_trigger_sell_last_200_contracts_buy_vs_sell;
            
    //                     $html .= '  </tr>
    //                         <tr class="center">
    //                         <th>Last 200 Contract Time (Less Then Recommended)</th>
                            
    //                         '. $barrier_percentile_trigger_sell_last_200_contracts_time.' </tr>
    //                         <tr class="center">
    //                         <th>Last Qty Contract Buyers Vs Sellers(Less Then Recommended)</th>
                            
    //     '. $barrier_percentile_trigger_sell_last_qty_contracts_buyer_vs_seller.'
            
    //                         </tr>
    //                         <tr class="center">
    //                         <th>Last qty Contract time(Less then Recommended)</th>
                            
    //         '. $barrier_percentile_trigger_sell_last_qty_contracts_time;
            
    //                         $html .= '</tr>
    //                         <tr class="center">
    //                         <th>(5 Minute Rolling Candel (Less Then ) From defined percentile)</th>
                            
    //     '. $barrier_percentile_trigger_5_minute_rolling_candel_sell;
            
    //                         $html .= '</tr>
    //                         <tr class="center">
    //                         <th>15 Minute Rolling Candel (Less Then) From defined percentile</th>
                            
    //         '. $barrier_percentile_trigger_15_minute_rolling_candel_sell;
            
            
    //         $html .= '</tr>
    //                         <tr class="center">
    //                         <th>(Buyer Should (Less Then) Then Bottom percentile)</th>
                            
    //         '. $barrier_percentile_trigger_buyers_sell;
            
            
    //         $html .= '</tr>
    //                         <tr class="center">
    //                         <th>(Sellers Should be (Greater From ) Top percentile)</th>
                            
    //         '. $barrier_percentile_trigger_sellers_sell;
            
    //                     $html .= '</tr>
                            
    //                         <tr class="center">
    //                         <th>(15 Minute last time ago Should be Less Then Bottom percentile)(T3 LTC Time)</th>
                            
    //         '. $barrier_percentile_trigger_15_minute_last_time_ago_sell;
            
            
    //                         $html .= '</tr>
    //                         <tr class="center">
    //                         <th>( (Binance buy) ASk Should be greater from Top percentile) (One minute Rooling candle)</th>
                            
    //         '. $barrier_percentile_trigger_ask_sell;
            
            
    //                         $html .= '</tr>
    //                         <tr class="center">
    //                         <th>((Binance Sell)Bid Should be Less Then Bottom percentile) (One minute Rooling candle)</th>
                            
    //         '. $barrier_percentile_trigger_bid_sell;
            
            
    //                         $html .= '</tr>
    //                         <tr class="center">
    //                         <th>((Digie Buy) Buy Should be greater from Top percentile) (One minute Rooling candle)</th>
                            
    //         '. $barrier_percentile_trigger_buy_sell;
            
            
    //                         $html .= '</tr>
    //                         <tr class="center">
    //                         <th>((Digie Sell) Sell Should be Less Then Bottom percentile) (One minute Rooling candle)</th>
                            
    //         '. $barrier_percentile_trigger_sell_sell;
            
            
    //                         $html .= '</tr>
    //                         <tr class="center">
    //                         <th>((Big Buyers) Ask Contracts Should be Greater from Top percentile)))</th>
                            
    //         '. $barrier_percentile_trigger_ask_contracts_sell;
            
            
    //                         $html .= '</tr>
    //                         <tr class="center">
    //                         <th>((Big Sellers) Bid Contracts Should be Les then Bottom percentile)))</th>
    //         '. $barrier_percentile_trigger_bid_contracts_sell;
            
    //         // New Fileds
    //         $html .= '</tr>
    //                         <tr class="center">
    //                         <th>Caption Option</th>
                            
    //         '. $percentile_trigger_caption_option_sell;
            
            
    //         $html .= '</tr>
    //                         <tr class="center">
    //                         <th>Caption Score</th>
                            
    //         '. $percentile_trigger_caption_score_sell;
            
            
    //         $html .= '</tr>
    //                         <tr class="center">
    //                         <th>Buy</th>
                            
    //         '. $percentile_trigger_buy_sell;
            
            
    //         $html .= '</tr>
    //                         <tr class="center">
    //                         <th>Sell</th>
                            
    //         '. $percentile_trigger_sell_trend_sell;
            
    //         $html .= '</tr>
    //                         <tr class="center">
    //                         <th>Demand</th>
                            
    //         '. $percentile_trigger_demand_sell;
            
    //         $html .= '</tr>
    //                         <tr class="center">
    //                         <th>Supply</th>
                            
    //         '. $percentile_trigger_supply_sell;
            
    //         $html .= '</tr>
    //                         <tr class="center">
    //                         <th>Market Trend</th>
                            
    //         '. $percentile_trigger_market_trend_sell;
            
    //         $html .= '</tr>
    //                         <tr class="center">
    //                         <th>Meta Tranding</th>
                            
    //         '. $percentile_trigger_meta_trading_sell;
            
            
    //         $html .= '</tr>
    //                         <tr class="center">
    //                         <th>Resk per Share</th>
                            
    //         '. $percentile_trigger_riskpershare_sell;
            
            
    //         $html .= '</tr>
    //                         <tr class="center">
    //                         <th>RL</th>
                            
    //         '. $percentile_trigger_RL_sell;
            
            
            
            
    //                         $html .= '</tr>
    //                     </tbody>
    //                     </table>
                        
    //                     <!--End of Sell part --> 
    //                 </div>
    //                 <!-- Stop loss Rule ---->
    //                 <div id="stoploss" class="tab-pane fade">
    //                     <table class="table table-bordered zama_th">
    //                     <thead>
    //                         <tr>
    //                         <th class="" style="background:#4267b2; color: #FFF;">'. $coin.'</th>';
            
    //         $level_number = 0;
    //         foreach($rules_set_arr as $row){ 
            
    //                 if ($row['trigger_level']) {
                
    //                         if($row['enable_percentile_trigger_stop_loss']=='yes'){
    //                             $onOff = '<span class="label label-success pull-right">ON</span>';
    //                         }else{
    //                             $onOff = '<span class="label label-danger pull-right">OFF</span>';  
    //                         }
    //                         $html .= ' <th class="center" style="background:#4267b2; color: #FFF;"> '. $row['trigger_level'] .' '.$onOff.'</th>';
    //                 } 
    //                 $level_number++;
    //                 }
    //                         $html .= ' </tr>
    //                     </thead>
    //                     <tbody>';
                        
    //         $barrier_percentile_stop_loss_black_wall                                 = '';               
    //         $barrier_percentile_trigger_stop_loss_virtual_barrier                    = '';
    //         $barrier_percentile_trigger_stop_loss_virtual_barrier_bid                = '';
    //         $barrier_percentile_trigger_stop_loss_seven_level_pressure               = '';
    //         $barrier_percentile_trigger_stop_loss_last_200_contracts_buy_vs_sell     = '';
    //         $barrier_percentile_trigger_stop_loss_last_200_contracts_time            = '';
    //         $barrier_percentile_trigger_stop_loss_last_qty_contracts_buyer_vs_seller = '';
    //         $barrier_percentile_trigger_sell_last_qty_contracts_buyer_vs_seller      = '';
    //         $barrier_percentile_trigger_stop_loss_last_qty_contracts_time            = '';
    //         $barrier_percentile_stop_loss_5_minute_rolling_candel_sell               = '';
    //         $barrier_percentile_stop_loss_15_minute_rolling_candel_sell              = '';
    //         $barrier_percentile_trigger_buyers_stop_loss                             = '';
        
    //         $level_number = 0;
    //         foreach($rules_set_arr as $row){ 
            
    //         if ($row['trigger_level']) {
                    
                    
    //                 if ($row['barrier_percentile_stop_loss_black_wall_apply'] == 'yes') {
    //                     $barrier_percentile_stop_loss_black_wall .= '<td> Bottom ' . $row['barrier_percentile_trigger_sell_black_wall'] . ' %
    //                     <span style="font-size:11px;     color: #a03d3d;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ( '.number_format((float)$percentil['sellers_fifteen_b_'.$row['barrier_percentile_trigger_sellers_buy'].''], 2, '.', '').' ) 
    //                     </span></td>';
    //                 } else {
    //                     $barrier_percentile_stop_loss_black_wall .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
    //                 if ($row['barrier_percentile_trigger_stop_loss_virtual_barrier_apply'] == 'yes') {
    //                     $barrier_percentile_trigger_stop_loss_virtual_barrier .= '<td> Bottom ' . $row['barrier_percentile_trigger_stop_loss_virtual_barrier'] .' %
    //                     <span style="font-size:11px;     color: #a03d3d;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ( '.number_format((float)$percentil['sellers_fifteen_b_'.$row['barrier_percentile_trigger_sellers_buy'].''], 2, '.', '').' ) 
    //                     </span></td>';
    //                 } else {
    //                     $barrier_percentile_trigger_stop_loss_virtual_barrier .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
    //                 if ($row['barrier_percentile_trigger_stop_loss_virtual_barrier_bid_apply'] == 'yes') {
    //                     $barrier_percentile_trigger_stop_loss_virtual_barrier_bid .= '<td> Bottom ' . $row['barrier_percentile_trigger_stop_loss_virtual_barrier_bid']. ' %
    //                     <span style="font-size:11px;     color: #a03d3d;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ( '.number_format((float)$percentil['sellers_fifteen_b_'.$row['barrier_percentile_trigger_sellers_buy'].''], 2, '.', '').' ) 
    //                     </span></td>';
    //                 } else {
    //                     $barrier_percentile_trigger_stop_loss_virtual_barrier_bid .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
    //                 if ($row['barrier_percentile_trigger_stop_loss_seven_level_pressure_apply'] == 'yes') {
    //                     $barrier_percentile_trigger_stop_loss_seven_level_pressure .= '<td> Bottom ' . $row['barrier_percentile_trigger_stop_loss_seven_level_pressure'] . ' %
    //                     <span style="font-size:11px;     color: #a03d3d;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ( '.number_format((float)$percentil['sellers_fifteen_b_'.$row['barrier_percentile_trigger_sellers_buy'].''], 2, '.', '').' ) 
    //                     </span></td>';
    //                 } else {
    //                     $barrier_percentile_trigger_stop_loss_seven_level_pressure .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                    
    //                 if ($row['barrier_percentile_trigger_stop_loss_last_200_contracts_buy_vs_sell_apply'] == 'yes') {
    //                     $barrier_percentile_trigger_stop_loss_last_200_contracts_buy_vs_sell .= '<td>' . $row['barrier_percentile_trigger_stop_loss_last_200_contracts_buy_vs_sell'] . '</td>';
    //                 } else {
    //                     $barrier_percentile_trigger_stop_loss_last_200_contracts_buy_vs_sell .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                    
    //                 if ($row['barrier_percentile_trigger_stop_loss_last_200_contracts_time_apply'] == 'yes') {
    //                     $barrier_percentile_trigger_stop_loss_last_200_contracts_time .= '<td>' . $row['barrier_percentile_trigger_stop_loss_last_200_contracts_time'] . '</td>';
    //                 } else {
    //                     $barrier_percentile_trigger_stop_loss_last_200_contracts_time .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                    
    //                 if ($row['barrier_percentile_trigger_stop_loss_last_qty_contracts_buyer_vs_seller_apply'] == 'yes') {
    //                     $barrier_percentile_trigger_stop_loss_last_qty_contracts_buyer_vs_seller .= '<td>' . $row['barrier_percentile_trigger_stop_loss_last_qty_contracts_buyer_vs_seller'] . '</td>';
    //                 } else {
    //                     $barrier_percentile_trigger_stop_loss_last_qty_contracts_buyer_vs_seller .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                    
    //                 if ($row['barrier_percentile_trigger_stop_loss_last_qty_contracts_time_apply'] == 'yes') {
    //                     $barrier_percentile_trigger_stop_loss_last_qty_contracts_time .= '<td> Bottom '  .$row['barrier_percentile_trigger_stop_loss_last_qty_contracts_time'].' %
    //                     <span style="font-size:11px;     color: #a03d3d;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ( '.number_format((float)$percentil['sellers_fifteen_b_'.$row['barrier_percentile_trigger_sellers_buy'].''], 2, '.', '').' ) 
    //                     </span></td>';
    //                 } else {
    //                     $barrier_percentile_trigger_stop_loss_last_qty_contracts_time .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                    
    //                 if ($row['barrier_percentile_stop_loss_5_minute_rolling_candel_sell_apply'] == 'yes') {
    //                     $barrier_percentile_stop_loss_5_minute_rolling_candel_sell .= ' <td class="center"> Bottom ' .  $row['barrier_percentile_stop_loss_5_minute_rolling_candel_sell']. ' %
    //                     <span style="font-size:11px;     color: #a03d3d;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ( '.number_format((float)$percentil['sellers_fifteen_b_'.$row['barrier_percentile_trigger_sellers_buy'].''], 2, '.', '').' ) 
    //                     </span></td>';
    //                 } else {
    //                     $barrier_percentile_stop_loss_5_minute_rolling_candel_sell .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                    
    //                 if ($row['barrier_percentile_stop_loss_15_minute_rolling_candel_sell_apply'] == 'yes') {
    //                     $barrier_percentile_stop_loss_15_minute_rolling_candel_sell .= ' <td class="center"> Bottom ' .  $row['barrier_percentile_stop_loss_15_minute_rolling_candel_sell']. ' %
    //                     <span style="font-size:11px;     color: #a03d3d;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ( '.number_format((float)$percentil['sellers_fifteen_b_'.$row['barrier_percentile_trigger_sellers_buy'].''], 2, '.', '').' ) 
    //                     </span></td>';
    //                 } else {
    //                     $barrier_percentile_stop_loss_15_minute_rolling_candel_sell .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                    
    //                 if ($row['barrier_percentile_trigger_buyers_stop_loss_apply'] == 'yes') {
    //                     $barrier_percentile_trigger_buyers_stop_loss .= ' <td class="center"> Top ' .  $row['barrier_percentile_trigger_buyers_stop_loss']. ' %
    //                     <span style="font-size:11px;     color: #a03d3d;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ( '.number_format((float)$percentil['sellers_fifteen_b_'.$row['barrier_percentile_trigger_sellers_buy'].''], 2, '.', '').' ) 
    //                     </span></td>';
    //                 } else {
    //                     $barrier_percentile_trigger_buyers_stop_loss .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                    
                    
    //                 if ($row['barrier_percentile_trigger_sellers_stop_loss_apply'] == 'yes') {
    //                     $barrier_percentile_trigger_sellers_stop_loss .= ' <td class="center"> Top ' . $row['barrier_percentile_trigger_sellers_stop_loss']. ' %
    //                     <span style="font-size:11px;     color: #a03d3d;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ( '.number_format((float)$percentil['sellers_fifteen_b_'.$row['barrier_percentile_trigger_sellers_buy'].''], 2, '.', '').' ) 
    //                     </span></td>';
    //                 } else {
    //                     $barrier_percentile_trigger_sellers_stop_loss .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }  
    //             } $level_number++;
    //         }
    //                     $html .= ' <tr class="center">
    //                         <th style="width:350px; border-right:3px solid #ddd;">Black Wall (Less Then) From defined percentile</th>
                        
    //     '. $barrier_percentile_stop_loss_black_wall;
        
    //                     $html .= ' </tr>
    //                         <tr class="center">
    //                         <th style="width:350px; border-right:3px solid #ddd;">Virtual Barrier (Greater Then) From defined percentile (Ask volume)</th>
                        
    //     '. $barrier_percentile_trigger_stop_loss_virtual_barrier;
        
        
    //                     $html .= '</tr>
    //                         <tr class="center">
    //                         <th style="width:350px; border-right:3px solid #ddd;">(Virtual Barrier Less From defined percentile(Bid Volume))</th>
                        
    //     '. $barrier_percentile_trigger_stop_loss_virtual_barrier_bid;
            
    //                     $html .= ' </tr>
    //                         <tr class="center">
    //                         <th>(Seven Level (Less Then) From defined percentile)</th>
                            
    //         '. $barrier_percentile_trigger_stop_loss_seven_level_pressure;
            
            
    //                     $html .= ' </tr>
    //                         <tr class="center">
    //                         <th>Last 200 Contract Buyers Vs Sellers (Less then Recommended)</th>
                            
    //         '. $barrier_percentile_trigger_stop_loss_last_200_contracts_buy_vs_sell;
            
    //                     $html .= ' </tr>
    //                         <tr class="center">
    //                         <th>Last 200 Contract Time (Less Then Recommended)</th>
                            
    //         '. $barrier_percentile_trigger_stop_loss_last_200_contracts_time;
            
    //                     $html .= '  </tr>
    //                         <tr class="center">
    //                         <th> Last Qty Contract Buyers Vs Sellers(Less Then Recommended)</th>
    //         '. $barrier_percentile_trigger_stop_loss_last_qty_contracts_buyer_vs_seller.' </tr>
    //                         <tr class="center">
    //                         <th>Last qty Contract time(Less then Recommended)</th>
                            
    //     '. $barrier_percentile_trigger_stop_loss_last_qty_contracts_time.'
            
    //                         </tr>
    //                         <tr class="center">
    //                         <th>(5 Minute Rolling Candel (Less Then ) From defined percentile)</th>
                            
    //         '. $barrier_percentile_stop_loss_5_minute_rolling_candel_sell;
            
    //                         $html .= '</tr>
    //                         <tr class="center">
    //                         <th>15 Minute Rolling Candel (Less Then) From defined percentile</th>
                            
    //     '. $barrier_percentile_stop_loss_15_minute_rolling_candel_sell;
            
    //                         $html .= '</tr>
    //                         <tr class="center">
    //                         <th>(Buyer Should (Less Then) Then Bottom percentile)</th>
                            
    //         '. $barrier_percentile_trigger_buyers_stop_loss;
            
            
    //         $html .= '</tr>
    //                         <tr class="center">
    //                         <th>(Sellers Should be (Greater From ) Top percentile)</th>
                            
    //         '. $barrier_percentile_trigger_sellers_stop_loss;
            
    //                     $html .= ' </tr>
    //                     </tbody>
    //                     </table>
    //                 </div>
    //                 <!--End of Stop Loss part --> 
    //                 </div>
    //                 <!-- // Table END --> 
    //             </div> <div class="clearfix"></div>
    //             </div></div>';
                    
    //             }
    //             else if($triggers_type=='market_trend_trigger'){
                    
    //                 $html .= '<div class="col-md-12 appnedAjax">
                
    //                 <ul class="nav nav-tabs">
    //                 <li class="active"><a data-toggle="tab" href="#buy">Buy Rules</a></li>
    //                 <li><a data-toggle="tab" href="#sell">Sell Rules</a></li>
                    
    //                 </ul>
    //                 <div class="tab-content ">
    //                 <div id="buy" class="tab-pane fade in active"> 
    //                     <!-- Buy part -->
                
    //                     <table class="table table-bordered zama_th">
    //                     <thead>
    //                         <tr>
    //                         <th class="" style="background:#4267b2; color: #FFF;">'. $coin .'</th>';
        
    //             $level_number = 1;
    //             foreach($rules_set_arr as $row){ 
                
    //                 if ($row['trigger_level'] ){
            
    //                         if($row['enable_buy_barrier_percentile']=='yes'){
    //                             $onOff = '<span class="label label-success pull-right">ON</span>';
    //                         }else{
    //                             $onOff = '<span class="label label-danger pull-right">OFF</span>';  
    //                         }          
    //                         $html .= '<th class="center" style="background:#4267b2; color: #FFF;">'.$row['trigger_level'].''.$onOff.'</th>';
    //                         $level_number++;
    //                 }
    //             }
                
    //                         $html .= '</tr>
    //                     </thead>
    //                     <tbody>';
        
    //         $level_number = 0;
    //         foreach($rules_set_arr as $row){ 
            
    //                 if ($row['trigger_level'] ){ 
                    
    //     $market_trend_caption_option_buy  .= ($row['market_trend_caption_option_buy_apply']=='yes') ? '<td>'.$row['market_trend_caption_option_buy'].'</td>':'<td>'.'<span class="label label-danger">OFF</span>'.'</td>';
    //     $market_trend_caption_score_buy   .= ($row['market_trend_caption_score_buy_apply']=='yes') ? '<td>'.$row['market_trend_caption_score_buy'].'</td>':'<td>'.'<span class="label label-danger">OFF</span>'.'</td>';
    //     $market_trend_buy_trend_buy       .= ($row['market_trend_buy_trend_buy_apply']=='yes') ? '<td>'.$row['market_trend_buy_trend_buy'].'</td>':'<td>'.'<span class="label label-danger">OFF</span>'.'</td>';
    //     $market_trend_sell_buy            .= ($row['market_trend_sell_buy_apply']=='yes') ? '<td>'.$row['market_trend_sell_buy'].'</td>':'<td>'.'<span class="label label-danger">OFF</span>'.'</td>';
    //     $market_trend_demand_buy          .= ($row['market_trend_demand_buy_apply']=='yes') ? '<td>'.$row['market_trend_demand_buy'].'</td>':'<td>'.'<span class="label label-danger">OFF</span>'.'</td>';
    //     $market_trend_supply_buy          .= ($row['market_trend_supply_buy_apply']=='yes') ? '<td>'.$row['market_trend_supply_buy'].'</td>':'<td>'.'<span class="label label-danger">OFF</span>'.'</td>';
    //     $market_trend_market_trend_buy    .= ($row['market_trend_market_trend_buy_apply']=='yes') ? '<td><span class="label label-success">'.$row['market_trend_market_trend_buy'].'</span></td>':
    //                                         '<td>'.'<span class="label label-warning">Negative</span>'.'</td>';
    //     $market_trend_meta_trading_buy    .= ($row['market_trend_meta_trading_buy_apply']=='yes') ? '<td>'.$row['market_trend_meta_trading_buy'].'</td>':'<td>'.'<span class="label label-danger">OFF</span>'.'</td>';
    //     $market_trend_riskpershare_buy    .= ($row['market_trend_riskpershare_buy_apply']=='yes') ? '<td>'.$row['market_trend_riskpershare_buy'].'</td>':'<td>'.'<span class="label label-danger">OFF</span>'.'</td>';
    //     $market_trend_black_wall_buy      .= ($row['market_trend_black_wall_buy_apply']=='yes') ? '<td>'.$row['market_trend_black_wall_buy'].'</td>':'<td>'.'<span class="label label-danger">OFF</span>'.'</td>';
    //     $seven_level_pressure_buy         .= ($row['market_trend_seven_level_pressure_buy_apply']=='yes') ? '<td>'.$row['market_trend_seven_level_pressure_buy'].'</td>':'<td>'.'<span class="label label-danger">OFF</span>'.'</td>';
    //     $market_trend_RL_buy              .= ($row['market_trend_RL_buy_apply']=='yes') ? '<td>'.$row['market_trend_RL_buy'].'</td>':'<td>'.'<span class="label label-danger">OFF</span>'.'</td>';
                    
    //             } $level_number++;
    //         }// if ($row['trigger_level'] 
            
    //                     $html .= ' 
                        
    //                     <tr class="center">
    //                         <th style="width:350px; border-right:3px solid #ddd;">Caption Option </th>           
    //     '. $market_trend_caption_option_buy;
    //                     $html .= '</tr>
    //                     <tr class="center">
    //                         <th style="width:350px; border-right:3px solid #ddd;">Caption score</th>              
    //     '. $market_trend_caption_score_buy;
    //                     $html .= '</tr>
    //                         <tr class="center">
    //                         <th style="width:350px; border-right:3px solid #ddd;">Buy</th>               
    //     '. $market_trend_buy_trend_buy;
    //                     $html .= '</tr>
    //                         <tr class="center">
    //                         <th style="width:350px; border-right:3px solid #ddd;">Sell</th> 
    //     '. $market_trend_sell_buy;
    //                         $html .= '</tr>
    //                         <tr class="center">
    //                         <th>Demand</th>                   
    //         '.$market_trend_demand_buy;
    //                         $html .= '</tr>
    //                         <tr class="center">
    //                         <th>Supply</th>  
    //         '.$market_trend_supply_buy;
    //                         $html .= '</tr>
    //                         <tr class="center">
    //                         <th>Market Trend</th>
                            
    //         '.$market_trend_market_trend_buy;
        
    //                         $html .= '</tr>
    //                         <tr class="center">
    //                         <th>Meta Tranding</th>
    //     '. $market_trend_meta_trading_buy;
        
    //                         $html .= '</tr>
    //                         <tr class="center">
    //                         <th> Resk per Share</th>
    //                         '.  $market_trend_riskpershare_buy;
    //                         $html .= ' </tr>
    //                         <tr class="center">
    //                         <th>Balack Wall</th>     
    //         '. $market_trend_black_wall_buy;
            
    //                         $html .= '</tr>
    //                         <tr class="center">
    //                         <th>Seven level pressure</th> 
    //         '. $seven_level_pressure_buy;
            
    //                     $html .= ' </tr>
    //                         <tr class="center">
    //                         <th>RL</th>                
    //     '. $market_trend_RL_buy;
    //                         $html .= '</tr>
                            
    //                     </tbody>
    //                     </table>
    //                 </div>
    //                 <div class="clearfix"></div>
    //                 <!--End of Buy part -->
                    
    //                 <div id="sell" class="tab-pane fade">
    //                     <table class="table table-bordered zama_th">
    //                     <thead>
    //                         <tr>
    //                         <th class="" style="background:#4267b2; color: #FFF;">'. $coin.'</th>';
            
    //                             $level_number = 1;
    //                             foreach($rules_set_arr as $row){ 
                                
    //                                 if ($row['trigger_level'] ){
                            
    //                                         if($row['enable_sell_barrier_percentile']=='yes'){
    //                                             $onOff = '<span class="label label-success pull-right">ON</span>';
    //                                         }else{
    //                                             $onOff = '<span class="label label-danger pull-right">OFF</span>';  
    //                                         }          
    //                                         $html .= '<th class="center" style="background:#4267b2; color: #FFF;">'.$row['trigger_level'].''.$onOff.'</th>';
    //                                         $level_number++;
    //                                 }
    //                             }
    //                         $html .= ' </tr>
    //                     </thead>
    //                     <tbody>';
        
    //         $level_number = 0;
    //         foreach($rules_set_arr as $row){ 
            
    //         if ($row['trigger_level']) {

    //     $market_trend_caption_option_sell  .= ($row['market_trend_caption_option_sell_apply']=='yes') ? '<td>'.$row['market_trend_caption_option_sell'].'</td>':'<td>'.'<span class="label label-danger">OFF</span>'.'</td>';
    //     $market_trend_caption_score_sell   .= ($row['market_trend_caption_score_sell_apply']=='yes') ? '<td>'.$row['market_trend_caption_score_sell'].'</td>':'<td>'.'<span class="label label-danger">OFF</span>'.'</td>';
    //     $market_trend_buy_sell             .= ($row['market_trend_buy_operator_sell_apply']=='yes') ? '<td>'.$row['market_trend_buy_sell'].'</td>':'<td>'.'<span class="label label-danger">OFF</span>'.'</td>';
    //     $market_trend_sell_trend_sell      .= ($row['market_trend_sell_trend_sell_apply']=='yes') ? '<td>'.$row['market_trend_sell_trend_sell'].'</td>':'<td>'.'<span class="label label-danger">OFF</span>'.'</td>';
    //     $market_trend_demand_sell          .= ($row['market_trend_demand_sell_apply']=='yes') ? '<td>'.$row['market_trend_demand_sell'].'</td>':'<td>'.'<span class="label label-danger">OFF</span>'.'</td>';
    //     $market_trend_supply_sell          .= ($row['market_trend_supply_sell_apply']=='yes') ? '<td>'.$row['market_trend_supply_sell'].'</td>':'<td>'.'<span class="label label-danger">OFF</span>'.'</td>';
    //     $market_trend_market_trend_sell    .= ($row['market_trend_market_trend_sell_apply']=='yes') ? '<td><span class="label label-success">'.$row['market_trend_market_trend_sell'].'</span></td>':
    //                                         '<td>'.'<span class="label label-warning">Negative</span>'.'</td>';
    //     $market_trend_meta_trading_sell    .= ($row['market_trend_meta_trading_sell_apply']=='yes') ? '<td>'.$row['market_trend_meta_trading_sell'].'</td>':'<td>'.'<span class="label label-danger">OFF</span>'.'</td>';
    //     $market_trend_riskpershare_sell    .= ($row['market_trend_riskpershare_sell_apply']=='yes') ? '<td>'.$row['market_trend_riskpershare_sell'].'</td>':'<td>'.'<span class="label label-danger">OFF</span>'.'</td>';
    //     $market_trend_black_wall_sell      .= ($row['market_trend_black_wall_sell_apply']=='yes') ? '<td>'.$row['market_trend_black_wall_sell'].'</td>':'<td>'.'<span class="label label-danger">OFF</span>'.'</td>';
    //     $seven_level_pressure_sell         .= ($row['market_trend_seven_level_pressure_sell_apply']=='yes') ? '<td>'.$row['market_trend_seven_level_pressure_sell'].'</td>':
    //                                         '<td>'.'<span class="label label-danger">OFF</span>'.'</td>';
    //     $market_trend_RL_sell              .= ($row['market_trend_RL_sell_apply']=='yes') ? '<td>'.$row['market_trend_RL_sell'].'</td>':'<td>'.'<span class="label label-danger">OFF</span>'.'</td>';
            
    //         } $level_number++;
    //     }
        
    //                     $html .= ' 
                        
    //                     <tr class="center">
    //                         <th style="width:350px; border-right:3px solid #ddd;">Caption Option </th>           
    //     '. $market_trend_caption_option_sell;
    //                     $html .= '</tr>
    //                     <tr class="center">
    //                         <th style="width:350px; border-right:3px solid #ddd;">Caption score</th>              
    //     '. $market_trend_caption_score_sell;
    //                     $html .= '</tr>
    //                         <tr class="center">
    //                         <th style="width:350px; border-right:3px solid #ddd;">Buy</th>               
    //     '. $market_trend_buy_sell;
    //                     $html .= '</tr>
    //                         <tr class="center">
    //                         <th style="width:350px; border-right:3px solid #ddd;">Sell</th> 
    //     '. $market_trend_sell_trend_sell;
    //                         $html .= '</tr>
    //                         <tr class="center">
    //                         <th>Demand</th>                   
    //         '.$market_trend_demand_sell;
    //                         $html .= '</tr>
    //                         <tr class="center">
    //                         <th>Supply</th>  
    //         '.$market_trend_supply_sell;
    //                         $html .= '</tr>
    //                         <tr class="center">
    //                         <th>Market Trend</th>
                            
    //         '.$market_trend_market_trend_sell;
        
    //                         $html .= '</tr>
    //                         <tr class="center">
    //                         <th>Meta Tranding</th>
    //     '. $market_trend_meta_trading_sell;
        
    //                         $html .= '</tr>
    //                         <tr class="center">
    //                         <th> Resk per Share</th>
    //                         '.  $market_trend_riskpershare_sell;
    //                         $html .= ' </tr>
    //                         <tr class="center">
    //                         <th>Balack Wall</th>     
    //         '. $market_trend_black_wall_sell;
            
    //                         $html .= '</tr>
    //                         <tr class="center">
    //                         <th>Seven level pressure</th> 
    //         '. $seven_level_pressure_sell;
            
    //                     $html .= ' </tr>
    //                         <tr class="center">
    //                         <th>RL</th>                
    //     '. $market_trend_RL_sell;
    //                         $html .= '</tr>
                            
    //                     </tbody>
    //                     </table>
    //                 </div>
    //                 <div class="clearfix"></div>
                        
    //                     <!--End of Sell part --> 
    //                 </div>
    //                 <!-- Stop loss Rule ---->
    //                 <div id="stoploss" class="tab-pane fade">
    //                     <table class="table table-bordered zama_th">
    //                     <thead>
    //                         <tr>
    //                         <th class="" style="background:#4267b2; color: #FFF;">'. $coin.'</th>';
            
    //         $level_number = 0;
    //         foreach($rules_set_arr as $row){ 
            
    //                 if ($row['trigger_level']) {
                
    //                         if($row['enable_percentile_trigger_stop_loss']=='yes'){
    //                             $onOff = '<span class="label label-success pull-right">ON</span>';
    //                         }else{
    //                             $onOff = '<span class="label label-danger pull-right">OFF</span>';  
    //                         }
    //                         $html .= ' <th class="center" style="background:#4267b2; color: #FFF;"> '. $row['trigger_level'] .' '.$onOff.'</th>';
    //                 } 
    //                 $level_number++;
    //                 }
    //                         $html .= ' </tr>
    //                     </thead>
    //                     <tbody>';
                        
    //         $barrier_percentile_stop_loss_black_wall                                 = '';               
    //         $barrier_percentile_trigger_stop_loss_virtual_barrier                    = '';
    //         $barrier_percentile_trigger_stop_loss_virtual_barrier_bid                = '';
    //         $barrier_percentile_trigger_stop_loss_seven_level_pressure               = '';
    //         $barrier_percentile_trigger_stop_loss_last_200_contracts_buy_vs_sell     = '';
    //         $barrier_percentile_trigger_stop_loss_last_200_contracts_time            = '';
    //         $barrier_percentile_trigger_stop_loss_last_qty_contracts_buyer_vs_seller = '';
    //         $barrier_percentile_trigger_sell_last_qty_contracts_buyer_vs_seller      = '';
    //         $barrier_percentile_trigger_stop_loss_last_qty_contracts_time            = '';
    //         $barrier_percentile_stop_loss_5_minute_rolling_candel_sell               = '';
    //         $barrier_percentile_stop_loss_15_minute_rolling_candel_sell              = '';
    //         $barrier_percentile_trigger_buyers_stop_loss                             = '';
        
    //         $level_number = 0;
    //         foreach($rules_set_arr as $row){ 
            
    //         if ($row['trigger_level']) {
                    
                    
    //                 if ($row['barrier_percentile_stop_loss_black_wall_apply'] == 'yes') {
    //                     $barrier_percentile_stop_loss_black_wall .= '<td> Bottom ' . $row['barrier_percentile_trigger_sell_black_wall'] . ' %
    //                     <span style="font-size:11px;     color: #a03d3d;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ( '.number_format((float)$percentil['sellers_fifteen_b_'.$row['barrier_percentile_trigger_sellers_buy'].''], 2, '.', '').' ) 
    //                     </span></td>';
    //                 } else {
    //                     $barrier_percentile_stop_loss_black_wall .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
    //                 if ($row['barrier_percentile_trigger_stop_loss_virtual_barrier_apply'] == 'yes') {
    //                     $barrier_percentile_trigger_stop_loss_virtual_barrier .= '<td> Bottom ' . $row['barrier_percentile_trigger_stop_loss_virtual_barrier'] .' %
    //                     <span style="font-size:11px;     color: #a03d3d;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ( '.number_format((float)$percentil['sellers_fifteen_b_'.$row['barrier_percentile_trigger_sellers_buy'].''], 2, '.', '').' ) 
    //                     </span></td>';
    //                 } else {
    //                     $barrier_percentile_trigger_stop_loss_virtual_barrier .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
    //                 if ($row['barrier_percentile_trigger_stop_loss_virtual_barrier_bid_apply'] == 'yes') {
    //                     $barrier_percentile_trigger_stop_loss_virtual_barrier_bid .= '<td> Bottom ' . $row['barrier_percentile_trigger_stop_loss_virtual_barrier_bid']. ' %
    //                     <span style="font-size:11px;     color: #a03d3d;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ( '.number_format((float)$percentil['sellers_fifteen_b_'.$row['barrier_percentile_trigger_sellers_buy'].''], 2, '.', '').' ) 
    //                     </span></td>';
    //                 } else {
    //                     $barrier_percentile_trigger_stop_loss_virtual_barrier_bid .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
    //                 if ($row['barrier_percentile_trigger_stop_loss_seven_level_pressure_apply'] == 'yes') {
    //                     $barrier_percentile_trigger_stop_loss_seven_level_pressure .= '<td> Bottom ' . $row['barrier_percentile_trigger_stop_loss_seven_level_pressure'] . ' %
    //                     <span style="font-size:11px;     color: #a03d3d;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ( '.number_format((float)$percentil['sellers_fifteen_b_'.$row['barrier_percentile_trigger_sellers_buy'].''], 2, '.', '').' ) 
    //                     </span></td>';
    //                 } else {
    //                     $barrier_percentile_trigger_stop_loss_seven_level_pressure .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                    
    //                 if ($row['barrier_percentile_trigger_stop_loss_last_200_contracts_buy_vs_sell_apply'] == 'yes') {
    //                     $barrier_percentile_trigger_stop_loss_last_200_contracts_buy_vs_sell .= '<td>' . $row['barrier_percentile_trigger_stop_loss_last_200_contracts_buy_vs_sell'] . '</td>';
    //                 } else {
    //                     $barrier_percentile_trigger_stop_loss_last_200_contracts_buy_vs_sell .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                    
    //                 if ($row['barrier_percentile_trigger_stop_loss_last_200_contracts_time_apply'] == 'yes') {
    //                     $barrier_percentile_trigger_stop_loss_last_200_contracts_time .= '<td>' . $row['barrier_percentile_trigger_stop_loss_last_200_contracts_time'] . '</td>';
    //                 } else {
    //                     $barrier_percentile_trigger_stop_loss_last_200_contracts_time .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                    
    //                 if ($row['barrier_percentile_trigger_stop_loss_last_qty_contracts_buyer_vs_seller_apply'] == 'yes') {
    //                     $barrier_percentile_trigger_stop_loss_last_qty_contracts_buyer_vs_seller .= '<td>' . $row['barrier_percentile_trigger_stop_loss_last_qty_contracts_buyer_vs_seller'] . '</td>';
    //                 } else {
    //                     $barrier_percentile_trigger_stop_loss_last_qty_contracts_buyer_vs_seller .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                    
    //                 if ($row['barrier_percentile_trigger_stop_loss_last_qty_contracts_time_apply'] == 'yes') {
    //                     $barrier_percentile_trigger_stop_loss_last_qty_contracts_time .= '<td> Bottom '  .$row['barrier_percentile_trigger_stop_loss_last_qty_contracts_time'].' %
    //                     <span style="font-size:11px;     color: #a03d3d;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ( '.number_format((float)$percentil['sellers_fifteen_b_'.$row['barrier_percentile_trigger_sellers_buy'].''], 2, '.', '').' ) 
    //                     </span></td>';
    //                 } else {
    //                     $barrier_percentile_trigger_stop_loss_last_qty_contracts_time .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                    
    //                 if ($row['barrier_percentile_stop_loss_5_minute_rolling_candel_sell_apply'] == 'yes') {
    //                     $barrier_percentile_stop_loss_5_minute_rolling_candel_sell .= ' <td class="center"> Bottom ' .  $row['barrier_percentile_stop_loss_5_minute_rolling_candel_sell']. ' %
    //                     <span style="font-size:11px;     color: #a03d3d;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ( '.number_format((float)$percentil['sellers_fifteen_b_'.$row['barrier_percentile_trigger_sellers_buy'].''], 2, '.', '').' ) 
    //                     </span></td>';
    //                 } else {
    //                     $barrier_percentile_stop_loss_5_minute_rolling_candel_sell .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                    
    //                 if ($row['barrier_percentile_stop_loss_15_minute_rolling_candel_sell_apply'] == 'yes') {
    //                     $barrier_percentile_stop_loss_15_minute_rolling_candel_sell .= ' <td class="center"> Bottom ' .  $row['barrier_percentile_stop_loss_15_minute_rolling_candel_sell']. ' %
    //                     <span style="font-size:11px;     color: #a03d3d;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ( '.number_format((float)$percentil['sellers_fifteen_b_'.$row['barrier_percentile_trigger_sellers_buy'].''], 2, '.', '').' ) 
    //                     </span></td>';
    //                 } else {
    //                     $barrier_percentile_stop_loss_15_minute_rolling_candel_sell .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                    
    //                 if ($row['barrier_percentile_trigger_buyers_stop_loss_apply'] == 'yes') {
    //                     $barrier_percentile_trigger_buyers_stop_loss .= ' <td class="center"> Top ' .  $row['barrier_percentile_trigger_buyers_stop_loss']. ' %
    //                     <span style="font-size:11px;     color: #a03d3d;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ( '.number_format((float)$percentil['sellers_fifteen_b_'.$row['barrier_percentile_trigger_sellers_buy'].''], 2, '.', '').' ) 
    //                     </span></td>';
    //                 } else {
    //                     $barrier_percentile_trigger_buyers_stop_loss .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                    
                    
    //                 if ($row['barrier_percentile_trigger_sellers_stop_loss_apply'] == 'yes') {
    //                     $barrier_percentile_trigger_sellers_stop_loss .= ' <td class="center"> Top ' . $row['barrier_percentile_trigger_sellers_stop_loss']. ' %
    //                     <span style="font-size:11px;     color: #a03d3d;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ( '.number_format((float)$percentil['sellers_fifteen_b_'.$row['barrier_percentile_trigger_sellers_buy'].''], 2, '.', '').' ) 
    //                     </span></td>';
    //                 } else {
    //                     $barrier_percentile_trigger_sellers_stop_loss .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }  
    //             } $level_number++;
    //         }
    //                     $html .= ' <tr class="center">
    //                         <th style="width:350px; border-right:3px solid #ddd;">Black Wall (Less Then) From defined percentile</th>
                        
    //     '. $barrier_percentile_stop_loss_black_wall;
        
    //                     $html .= ' </tr>
    //                         <tr class="center">
    //                         <th style="width:350px; border-right:3px solid #ddd;">Virtual Barrier (Greater Then) From defined percentile (Ask volume)</th>
                        
    //     '. $barrier_percentile_trigger_stop_loss_virtual_barrier;
        
        
    //                     $html .= '</tr>
    //                         <tr class="center">
    //                         <th style="width:350px; border-right:3px solid #ddd;">(Virtual Barrier Less From defined percentile(Bid Volume))</th>
                        
    //     '. $barrier_percentile_trigger_stop_loss_virtual_barrier_bid;
            
    //                     $html .= ' </tr>
    //                         <tr class="center">
    //                         <th>(Seven Level (Less Then) From defined percentile)</th>
                            
    //         '. $barrier_percentile_trigger_stop_loss_seven_level_pressure;
            
            
    //                     $html .= ' </tr>
    //                         <tr class="center">
    //                         <th>Last 200 Contract Buyers Vs Sellers (Less then Recommended)</th>
                            
    //         '. $barrier_percentile_trigger_stop_loss_last_200_contracts_buy_vs_sell;
            
    //                     $html .= ' </tr>
    //                         <tr class="center">
    //                         <th>Last 200 Contract Time (Less Then Recommended)</th>
                            
    //         '. $barrier_percentile_trigger_stop_loss_last_200_contracts_time;
            
    //                     $html .= '  </tr>
    //                         <tr class="center">
    //                         <th> Last Qty Contract Buyers Vs Sellers(Less Then Recommended)</th>
    //         '. $barrier_percentile_trigger_stop_loss_last_qty_contracts_buyer_vs_seller.' </tr>
    //                         <tr class="center">
    //                         <th>Last qty Contract time(Less then Recommended)</th>
                            
    //     '. $barrier_percentile_trigger_stop_loss_last_qty_contracts_time.'
            
    //                         </tr>
    //                         <tr class="center">
    //                         <th>(5 Minute Rolling Candel (Less Then ) From defined percentile)</th>
                            
    //         '. $barrier_percentile_stop_loss_5_minute_rolling_candel_sell;
            
    //                         $html .= '</tr>
    //                         <tr class="center">
    //                         <th>15 Minute Rolling Candel (Less Then) From defined percentile</th>
                            
    //     '. $barrier_percentile_stop_loss_15_minute_rolling_candel_sell;
            
    //                         $html .= '</tr>
    //                         <tr class="center">
    //                         <th>(Buyer Should (Less Then) Then Bottom percentile)</th>
                            
    //         '. $barrier_percentile_trigger_buyers_stop_loss;
            
            
    //         $html .= '</tr>
    //                         <tr class="center">
    //                         <th>(Sellers Should be (Greater From ) Top percentile)</th>
                            
    //         '. $barrier_percentile_trigger_sellers_stop_loss;
            
    //                     $html .= ' </tr>
    //                     </tbody>
    //                     </table>
    //                 </div>
    //                 <!--End of Stop Loss part --> 
    //                 </div>
    //                 <!-- // Table END --> 
    //             </div> <div class="clearfix"></div>
    //             </div></div>';
                    
    //             }
                
    //             /*$html  .= ' <div class="pull-right" style="     background: #4267b2; color: #FFF; padding-top: 6px; margin: 0px; padding: 8px 9px 0px 7px;">
    //             <h4>AVG Profit : '. number_format($avgProfit,2).'%'.'</h4></div>'; echo "<pre>";  print_r($rules_set_arr); exit;*/
                
    //             if ($rules_set_arr) {
    //                 $json_array['success'] = true;
    //                 $json_array['html']    = $html;
    //             } else {
    //                 $json_array['success'] = false;
    //                 $json_array['html']    = '<strong> Oops ! </strong> No rule found against <b> '.$triggers_type .' </b> please add the rules against the trigger .</div>';
    //             }
    //             echo json_encode($json_array);
    //             exit;
    //         } //End  get_global_trigger_setting_ajax
            
            
            
            
    //         public function get_global_rules_ajax(){
                
    //             $order_mode    = $this->input->post('order_mode');
    //             $rule          = $this->input->post('rule');
    //             $triggers_type = $this->input->post('triggers_type');
                
    //             $rules_set_arr  = $this->mod_rulesorder->box_trigger_rule($rule, $order_mode,$triggers_type);
                
    //             $rules_set_arr  = (array)$rules_set_arr;
    //             //$rules_set_arr = unique_array($rules_set_Ar, 'coin');
                
    //             $html  = '';	
    //             if($triggers_type=='trigger_1'){
    //                     $html .= ' <div class="triggercls trg_trigger_1 " > <div class="col-md-12 appnedAjax" >
    //                     <table class="table table-bordered table-condensed table-striped table-primary table-vertical-center checkboxs">
    //                             <thead>
    //                             <tr>
    //                                 <th class="center" style="background:#4267b2; color:#FFF;"></th>
    //                                 <th class="center" style="background:#4267b2; color:#FFF;"></th>
    //                             </tr>  
    //                             </thead>
    //                             <tbody>';
                                
    //                 $cancel                         = '';
    //                 $look_back_hour                 = '';
    //                 $bottom_demand_rejection        = '';
    //                 $bottom_supply_rejection        = '';
    //                 $check_high_open                = '';
    //                 $is_previous_blue_candle        = '';
    //                 $aggressive_stop_rule           = '';
    //                 $apply_factor                   = '';
    //                 $buy_virtural_rule_             = '';

    //                 if ($rules_set_arr['cancel_trade'] == 'cancel') {
    //                     $cancel .= '<td>' .'<span class="label label-success">YES</span>' . '</td>';
    //                     $look_back_hour .= '<td>' . $rules_set_arr['look_back_hour'] . '</td>';
    //                 } else {
    //                     $cancel .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     $look_back_hour .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                    
                
    //                 if($rules_set_arr['aggressive_stop_rule']=='stop_loss_rule_1') {
    //                 $aggressive_stop_rule .= '<td>' .'<span class="label label-success">S L R 1</span>' . '</td>';	
    //                 }else if($rules_set_arr['aggressive_stop_rule']=='stop_loss_rule_2') {
    //                 $aggressive_stop_rule .= '<td>' .'<span class="label label-success">S L R 2</span>' . '</td>';		
    //                 }else if($rules_set_arr['aggressive_stop_rule']=='stop_loss_rule_3') {
    //                 $aggressive_stop_rule .= '<td>' .'<span class="label label-success">S L R 3</span>' . '</td>';	 		
    //                 }else if($rules_set_arr['aggressive_stop_rule']=='stop_loss_rule_big_wall') {
    //                     $aggressive_stop_rule .= '<td>' .'<span class="label label-success">S L R B W</span>' . '</td>';	
    //                 }else{
    //                     $aggressive_stop_rule .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                    
    //                 if ($rules_set_arr['buy_virtual_barrier_rule_' . $rule_numbernn . '_enable'] == 'yes') {
    //                     $buy_virtural_rule_ .= '<td>' . $rules_set_arr['buy_virtural_rule_' . $rule_numbernn . ''] . '</td>';
    //                 } else {
    //                     $buy_virtural_rule_ .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                    
    //                 $apply_factor .= '<td>' . $rules_set_arr['apply_factor'] . '</td>';
                    
    //                 if ($rules_set_arr['bottom_demand_rejection'] == 'yes') {
    //                     $bottom_demand_rejection .= '<td>' .'<span class="label label-success">YES</span>' . '</td>';
    //                 } else {
    //                     $bottom_demand_rejection .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                    
    //                 if ($rules_set_arr['bottom_supply_rejection'] == 'yes') {
    //                     $bottom_supply_rejection .= '<td>' .'<span class="label label-success">YES</span>' . '</td>';
    //                 } else {
    //                     $bottom_supply_rejection .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                
    //                 if ($rules_set_arr['check_high_open'] == 'yes') {
    //                     $check_high_open .= '<td>' .'<span class="label label-success">YES</span>' . '</td>';
    //                 } else {
    //                     $check_high_open .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                    
                    
    //                 if ($rules_set_arr['is_previous_blue_candle'] == 'yes') {
    //                     $is_previous_blue_candle .= '<td>' .'<span class="label label-success">YES</span>' . '</td>';
    //                 } else {
    //                     $is_previous_blue_candle .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                    
    //                         $html .= '<tr class="center"><th>Cancel Trade</th>'. $cancel.'';
    //                         $html .= '<tr class="center">
    //                             <th>Aggressive stop rule</th> '. $aggressive_stop_rule .'
    //                             </tr> <tr class="center"> <th>Trigger Rule</th>
    //                             ' . $buy_trigger_type_ruleAll . '
    //                             </tr>';
                            
    //                         $html .= '   <tr class="center">
    //                             <th>Stop loss factor</th>'. $apply_factor .'
    //                             </tr>';
                            
    //                         $html .= '	 </tr> <tr class="center">
    //                                 <th>look back hour to cancel trade</th>'. $look_back_hour.'
    //                             </tr>
                                
    //                             <tr class="center">
    //                                 <th>Bottom Demand Rejection</th>'. $bottom_demand_rejection.'
    //                             </tr>
    //                             <tr class="center">
    //                                 <th>Bottom Supply Rejection</th>'. $bottom_supply_rejection.'
    //                             </tr>
    //                             <tr class="center">
    //                                 <th> Check Heigh Open</th>
    //                                 '. $check_high_open.'
    //                             </tr>
    //                             <tr class="center">
    //                                 <th>is_previous_blue_candle</th>'. $is_previous_blue_candle.'
    //                             </tr>
    //                             </tbody>
    //                         </table>
    //                     </div> </div> ';
    //             }
    //             else if($triggers_type=='trigger_2'){
    //                     $html .= ' <div class="triggercls trg_trigger_2" ><div class="col-md-12 appnedAjax" >
    //                     <table class="table table-bordered zama_th">
    //                             <thead>
    //                             <tr>
    //                                 <th class="center" style="background:#4267b2; color:#FFF;"></th>
    //                                 <th class="center" style="background:#4267b2; color:#FFF;"></th>
                                    
    //                             </tr>  
    //                             </thead>
    //                             <tbody>';
                                
    //     $cancel                   = '';
    //     $look_back_hour           = '';
    //     $bottom_demand_rejection  = '';
    //     $bottom_supply_rejection  = '';
    //     $check_high_open          = '';
    //     $is_previous_blue_candle  = '';
    //     $aggressive_stop_rule     = '';
    //     $apply_factor             ='';


    //     if ($rules_set_arr['cancel_trade'] == 'cancel') {
    //         $cancel .= '<td>' .'<span class="label label-success">YES</span>' . '</td>';
	// 		$look_back_hour .= '<td>' . $rules_set_arr['look_back_hour'] . '</td>';
    //     } else {
    //         $cancel .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
	// 		 $look_back_hour .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //     }
		
	// 		if($rules_set_arr['aggressive_stop_rule']=='stop_loss_rule_1') {
	// 		   $aggressive_stop_rule .= '<td>' .'<span class="label label-success">S L R 1</span>' . '</td>';	
	// 		}else if($rules_set_arr['aggressive_stop_rule']=='stop_loss_rule_2') {
	// 		   $aggressive_stop_rule .= '<td>' .'<span class="label label-success">S L R 2</span>' . '</td>';		
	// 		}else if($rules_set_arr['aggressive_stop_rule']=='stop_loss_rule_3') {
	// 		   $aggressive_stop_rule .= '<td>' .'<span class="label label-success">S L R 3</span>' . '</td>';	 		
	// 		}else if($rules_set_arr['aggressive_stop_rule']=='stop_loss_rule_big_wall') {
	// 			$aggressive_stop_rule .= '<td>' .'<span class="label label-success">S L R B W</span>' . '</td>';	
	// 		}else{
    //             $aggressive_stop_rule .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //         }
		
	// 	$apply_factor .= '<td>' . $rules_set_arr['apply_factor'] . '</td>';
          
    //     if ($rules_set_arr['bottom_demand_rejection'] == 'yes') {
    //         $bottom_demand_rejection .= '<td>' .'<span class="label label-success">YES</span>' . '</td>';
    //     } else {
    //         $bottom_demand_rejection .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //     }
		
	// 	 if ($rules_set_arr['bottom_supply_rejection'] == 'yes') {
    //         $bottom_supply_rejection .= '<td>' .'<span class="label label-success">YES</span>' . '</td>';
    //     } else {
    //         $bottom_supply_rejection .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //     }
		
    //     if ($rules_set_arr['check_high_open'] == 'yes') {
    //         $check_high_open .= '<td>' .'<span class="label label-success">YES</span>' . '</td>';
    //     } else {
    //         $check_high_open .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //     }
		
    //     if ($rules_set_arr['is_previous_blue_candle'] == 'yes') {
    //         $is_previous_blue_candle .= '<td>' .'<span class="label label-success">YES</span>' . '</td>';
    //     } else {
    //         $is_previous_blue_candle .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //     }
				
	// 	$html .= '  <tr class="center">
	// 				<th>Cancel Trade</th>'. $cancel.'';
		
	// 	$html .= '  <tr class="center">
    //                 <th>Aggressive stop rule</th>'. $aggressive_stop_rule .'
    //                 </tr>';		 
	// 	$html .= '  <tr class="center">
    //                 <th>Stop loss factor</th>'. $apply_factor .'
    //                 </tr>';	
	//     $html .= '	 </tr>
	// 					  <tr class="center">
	// 						<th>look back hour to cancel trade</th>
						
	// 	'. $look_back_hour.'
		
	// 					  </tr>
	// 					  <tr class="center">
	// 						<th>Bottom Demand Rejection</th>
				
	// 	'. $bottom_demand_rejection.'
					 
	// 					  </tr>
	// 					  <tr class="center">
	// 						<th>Bottom Supply Rejection</th>
							
						   
	// 	'. $bottom_supply_rejection.'
		
	// 					 </tr>
	// 					  <tr class="center">
	// 						<th> Check Heigh Open</th>
	// 						'. $check_high_open.'
	// 					  </tr>
	// 					  <tr class="center">
	// 						<th>is_previous_blue_candle</th>
						
	// 	'. $is_previous_blue_candle.'

	// 					 </tr>
	// 					</tbody>
	// 				  </table>
	// 			 </div></div> ';
	// 	}
	// 	else if($triggers_type=='box_trigger_3'){
			
	// 	$html .= '<div class="col-md-12 appnedAjax" >
    //               <div class="tab-content ">
    //               <table class="table table-bordered zama_th">
    //               <thead>
    //                 <tr>
    //                   <th class="" style="background:#4267b2; color: #FFF;">'.$global_symbol.'</th>';
    
    //         $level_number = 1;
    //         foreach($rules_set_arr as $row){ 
            
    //         if ($row['trigger_level'] == 'level_'.$level_number ) {
    //                         $html .= '<th class="center" style="background:#4267b2; color: #FFF;">Level '.$level_number.'</th>';
    //             }   
    //                 $level_number++;
    //         }
    //                         $html .= '</tr>
    //                     </thead>
    //                     <tbody>';
                        
    //         $box_trigger_score                            = '';
    //         $apply_factor                                 = '';
    //         $look_back_hour                               = '';
    //         $bottom_demand_rejection                      = '';
    //         $bottom_supply_rejection                      = '';
    //         $cancel_trade                                 = '';
    //         $check_high_open                              = '';
    //         $is_previous_blue_candle                      = '';
    //         $box_trigger_black_wall                       = '';
    //         $box_trigger_virtual_barrier                  = '';
    //         $box_trigger_seven_level_pressure             = '';
    //         $box_trigger_buyer_vs_seller_rolling_candel   = '';
    //         $box_trigger_15_minute_rolling_candel         = '';
    //         $last_200_contracts_buy_vs_sell_box_trigger   = '';
    //         $last_200_contracts_time_box_trigger          = '';
    //         $last_qty_contracts_buyer_vs_seller_box_trigger  = '';
    //         $last_qty_contracts_time_box_trigger          = '';
        
    //         $level_number = 1;
    //         foreach($rules_set_arr as $row){ 
            
    //         if ($row['trigger_level'] == 'level_'.$level_number ) {
                
    //                 if ($row['box_trigger_score']!='') {
    //                     $box_trigger_score .= '<td>' . $row['box_trigger_score'] . ' </td>';
    //                 } else {
    //                     $box_trigger_score .= '<td>' . 'N/A' . '</td>';
    //                 }
                    
    //                 if ($row['apply_factor']!='') {
    //                     $apply_factor .= '<td>' . $row['apply_factor'] . ' </td>';
    //                 } else {
    //                     $apply_factor .= '<td>' . 'N/A' . '</td>';
    //                 }
                    
    //                 if ($row['look_back_hour']!='') {
    //                     $look_back_hour .= '<td>' . $row['look_back_hour'] . ' </td>';
    //                 } else {
    //                     $look_back_hour .= '<td>' . 'N/A' . '</td>';
    //                 }
                    
    //                 if ($row['bottom_demand_rejection']=='yes') {
    //                     $bottom_demand_rejection .= '<td><span class="glyphicon glyphicon-ok" aria-hidden="true" style="color:green;"></span> </td>';
    //                 } else {
    //                     $bottom_demand_rejection .= '<td><span class="glyphicon glyphicon-remove" aria-hidden="true" style="color:red;"></span></td>';
    //                 }
                    
    //                 if ($row['bottom_supply_rejection']=='yes') {
    //                     $bottom_supply_rejection .= '<td><span class="glyphicon glyphicon-ok" aria-hidden="true" style="color:green;"></span> </td>';
    //                 } else {
    //                     $bottom_supply_rejection .= '<td><span class="glyphicon glyphicon-remove" aria-hidden="true" style="color:red;"></span></td>';
    //                 }
                    
    //                 if ($row['cancel_trade']=='cancel') {
    //                     $cancel_trade .= '<td><span class="glyphicon glyphicon-ok" aria-hidden="true" style="color:green;"></span> </td>';
    //                 } else {
    //                     $cancel_trade .= '<td><span class="glyphicon glyphicon-remove" aria-hidden="true" style="color:red;"></span></td>';
    //                 }
                    
    //                 if ($row['check_high_open']=='yes') {
    //                     $check_high_open .= '<td><span class="glyphicon glyphicon-ok" aria-hidden="true" style="color:green;"></span> </td>';
    //                 } else {
    //                     $check_high_open .= '<td><span class="glyphicon glyphicon-remove" aria-hidden="true" style="color:red;"></span></td>';
    //                 }
                    
    //                 if ($row['is_previous_blue_candle']=='yes') {
    //                     $is_previous_blue_candle .= '<td><span class="glyphicon glyphicon-ok" aria-hidden="true" style="color:green;"></span> </td>';
    //                 } else {
    //                     $is_previous_blue_candle .= '<td><span class="glyphicon glyphicon-remove" aria-hidden="true" style="color:red;"></span></td>';
    //                 }
                    
                    
    //                 if ($row['box_trigger_black_wall_apply'] == 'yes') {
    //                     $box_trigger_black_wall .= '<td>' . $row['box_trigger_black_wall'] . ' %</td>';
    //                 } else {
    //                     $box_trigger_black_wall .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                    
                    
    //                 if ($row['box_trigger_virtual_barrier_apply'] == 'yes') {
    //                     $box_trigger_virtual_barrier .= '<td>' . $row['box_trigger_virtual_barrier'] .' %</td>';
    //                 } else {
    //                     $box_trigger_virtual_barrier .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                    
                    
    //                 if ($row['box_trigger_seven_level_pressure_apply'] == 'yes') {
    //                     $box_trigger_seven_level_pressure .= '<td>' . $row['box_trigger_seven_level_pressure']. ' %</td>';
    //                 } else {
    //                     $box_trigger_seven_level_pressure .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                    
                    
    //                 if ($row['box_trigger_buyer_vs_seller_rolling_candel_apply'] == 'yes') {
    //                     $box_trigger_buyer_vs_seller_rolling_candel .= '<td>' . $row['box_trigger_buyer_vs_seller_rolling_candel'] . ' %</td>';
    //                 } else {
    //                     $box_trigger_buyer_vs_seller_rolling_candel .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                    
    //                 if ($row['box_trigger_15_minute_rolling_candel_apply'] == 'yes') {
    //                     $box_trigger_15_minute_rolling_candel .= '<td>' . $row['box_trigger_15_minute_rolling_candel'] . '</td>';
    //                 } else {
    //                     $box_trigger_15_minute_rolling_candel .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                    
                    
    //                 if ($row['last_200_contracts_buy_vs_sell_box_trigger_apply'] == 'yes') {
    //                     $last_200_contracts_buy_vs_sell_box_trigger .= '<td>' . $row['last_200_contracts_buy_vs_sell_box_trigger'] . '</td>';
    //                 } else {
    //                     $last_200_contracts_buy_vs_sell_box_trigger .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                    
                    
    //                 if ($row['last_200_contracts_time_box_trigger_apply'] == 'yes') {
    //                     $last_200_contracts_time_box_trigger .= '<td>' . $row['last_200_contracts_time_box_trigger'] . '</td>';
    //                 } else {
    //                     $last_200_contracts_time_box_trigger .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                    
                    
    //                 if ($row['last_qty_contracts_buyer_vs_seller_box_trigger_apply'] == 'yes') {
    //                     $last_qty_contracts_buyer_vs_seller_box_trigger .= '<td>'  .$row['last_qty_contracts_buyer_vs_seller_box_trigger'].' %</td>';
    //                 } else {
    //                     $last_qty_contracts_buyer_vs_seller_box_trigger .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                    
                    
    //                 if ($row['last_qty_contracts_time_box_trigger_apply'] == 'yes') {
    //                     $last_qty_contracts_time_box_trigger .= '<td>'  .$row['last_qty_contracts_time_box_trigger'].' %</td>';
    //                 } else {
    //                     $last_qty_contracts_time_box_trigger .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                    
    //             } $level_number++;
    //         }
        
    //                         $html .= '<tr class="center">
    //                         <th style="width:350px; border-right:3px solid #ddd;">Score</th>
                            
    //         '. $box_trigger_score;
            
    //                         $html .= '</tr>
    //                         <tr class="center">
    //                         <th>Stop loss rule 2 apply factor</th>
                            
    //         '. $apply_factor;
            
    //                         $html .= '</tr>
    //                         <tr class="center">
    //                         <th>Look back hour to cancel trade</th>
                            
    //         '. $look_back_hour;
        
    //                         $html .= '</tr>
    //                         <tr class="center">
    //                         <th>Bottom Demand Rejection</th>
                            
    //         '. $bottom_demand_rejection;
            
    //                         $html .= '</tr>
    //                         <tr class="center">
    //                         <th> Bottom Supply Rejection</th>
    //         '. $bottom_supply_rejection ;
    //                         $html .= '</tr>
    //                         <tr class="center">
    //                         <th>Cancel Trade</th>
    //         '.$cancel_trade;
            
    //                         $html .= '</tr>
    //                         <tr class="center">
    //                         <th>Check Heigh Open</th>
                    
    //         '.$check_high_open;
            
    //                         $html .= '</tr>
    //                         <tr class="center">
    //                         <th>Is Previous blue candle</th>
                            
    //         '.$is_previous_blue_candle;
        
    //                     $html .= ' </tr>
    //                         <tr class="center">
    //                         <th>(Black Wall Greater From defined percentile)</th>
                        
    //         '.$box_trigger_black_wall;
        
    //                     $html .= '</tr>
    //                         <tr class="center">
    //                         <th>(Virtual Barrier Greater From defined percentile)</th>
                            
    //         '.$box_trigger_virtual_barrier;
            
    //                     $html .= ' </tr>
                            
    //                         <tr class="center">
    //                         <th>(Seven Level Greater From defined percentile)</th>
                            
    //         '.$box_trigger_seven_level_pressure;
            
    //                         $html .= '</tr>
                            
    //                         <tr class="center">
    //                         <th>(Buyers Vs sellers , 5 mins rolling candel Greater From defined percentile)</th>
                            
    //         '.$box_trigger_buyer_vs_seller_rolling_candel;
            
    //                         $html .= '</tr>
                            
    //                         <tr class="center">
    //                         <th>(15 Minute Rolling Candel Greater From defined percentile)</th>
                            
    //         '.$box_trigger_15_minute_rolling_candel;

    //                         $html .= '</tr>
                            
    //                         <tr class="center">
    //                         <th>Last 200 Contract Buyers Vs Sellers</th>
                    
    //         '.$last_200_contracts_buy_vs_sell_box_trigger;
        
    //                         $html .= '</tr>
                            
    //                         <tr class="center">
    //                         <th>Last 200 Contract Time Less Then</th>
                            
    //         '.$last_200_contracts_time_box_trigger;
        
    //                         $html .= '</tr>
                            
    //                         <tr class="center">
    //                         <th>Last Qty Contract Buyers Vs Sellers</th>
                            
    //         '.$last_qty_contracts_buyer_vs_seller_box_trigger;
            
    //                         $html .= '</tr>
    //                         <tr class="center">
    //                         <th>Last qty Contract time(Less then)</th>
                            
    //         '.$last_qty_contracts_time_box_trigger;
            
    //                         $html .= '</tr>
                            
    //                     </tbody>
    //                     </table>
                    
    //                 <div class="clearfix"></div>
    //                 <!--End of Buy part -->
    //                 </div>
    //                 <!-- // Table END --> 
    //             </div> <div class="clearfix"></div>
    //             </div>';
                
                    
                    
    //             }
    //             else if($triggers_type=='barrier_trigger'){
                    
                    
                    
    //             /*	$html .= '<div class="alert alert-danger" role="alert">
    //             In development Stage!
    //             </div>';exit;*/

    //             /* if($rules_set_arr->aggressive_stop_rule=='stop_loss_rule_1'){
    //             $aggressive_stop_ruleA  =  'Stop Loss Rule One';
    //             }else if($rules_set_arr->aggressive_stop_rule=='stop_loss_rule_2'){
    //             $aggressive_stop_ruleA  =  'Stop Loss Rule Two'; 
    //             }else if($rules_set_arr->aggressive_stop_rule=='stop_loss_rule_3'){
    //             $aggressive_stop_ruleA  =  'Stop Loss Rule Three';    
    //             }else if($rules_set_arr->aggressive_stop_rule=='stop_loss_rule_big_wall'){
    //             $aggressive_stop_ruleA  =  'Stop Loss Rule Big Wall';    
    //             }*/

    //             $html .= '  <div class="col-md-12 appnedAjax" > <ul class="nav nav-tabs">
    //                 <li class="active"><a data-toggle="tab" href="#buy">Buy Rules</a></li>
    //                 <li><a data-toggle="tab" href="#sell">Sell Rules</a></li>
    //             </ul>
    //             <div class="tab-content ">';
                
    //             $html .= ' <div id="buy" class="tab-pane fade in active">
                
    //             <!- Here To paste the code -->
                
    //                 <div class="tbresp" style="max-width: 100%; overflow-x: auto;">
    //                 <table class="table table-bordered zama_th">
    //                     <thead>
    //                     <tr>
    //                         <th class="" style="background:#4267b2; color: #FFF; width:450px; float: left;"> Rule <b>'. $rule .'</b> Of Barrier Trigger</th>';
    //             $rule_numbernn = $rule;			
    //             foreach ($rules_set_arr as $coin) {
    //                     $html .= '<th class="center" style="background:#4267b2; color:#FFF;">' . $coin['coin'] . '</th>';
    //             }
    //             $html .= ' </tr></thead><tbody>';
                
    //             $buy_status_rule_                 = '';
    //             $big_seller_percent_compare_rule_ = '';
    //             $closest_black_wall_rule_         = '';
    //             $closest_yellow_wall_rule_        = '';
    //             $seven_level_pressure_rule_       = '';
    //             $buyer_vs_seller_rule_            = '';
    //             $last_candle_type                 = '';
    //             $rejection_candle_type            = '';
    //             $last_200_contracts_buy_vs_sell   = '';
    //             $last_200_contracts_time          = '';
    //             $last_qty_buyers_vs_seller        = '';
    //             $last_qty_time                    = '';
    //             $score                            = '';
    //             $comment                          = '';
    //             $buy_trigger_type_ruleAll         = '';
    //             $last_candle_status               = '';
                
    //             $rule_numbernn = $rule;
    //         foreach($rules_set_arr as $row){ 
            
    //         //print_me($row);
                        
    //                 $buyrulerecordAll = '';
    //                 foreach ($row['buy_order_level_' . $rule_numbernn] as $buyrulerecord) {
                        
    //                     if ($buyrulerecord == 'level_1') {
    //                         $value1 = '<span class="label label-warning">L 1</span>';
    //                     } else if ($buyrulerecord == 'level_2') {
    //                         $value1 = '<span class="label label-warning">L 2</span>';
    //                     } else if ($buyrulerecord == 'level_3') {
    //                         $value1 = '<span class="label label-warning">L 3</span>';
    //                     } else if ($buyrulerecord == 'level_4') {
    //                         $value1 = '<span class="label label-warning">L 4</span>';
    //                     } else if ($buyrulerecord == 'level_5') {
    //                         $value1 = '<span class="label label-warning">L 5</span>'; 
    //                     } else if ($buyrulerecord == 'level_6') {
    //                         $value1 = '<span class="label label-warning">L 6</span>';
    //                     } 

                        
    //                     $buyrulerecordAll .= '&nbsp;' . $value1;
    //                 }
                        
    //                     $rulerecordaaa = '';
    //                     if ($row['buy_status_rule_' . $rule_numbernn . '_enable'] == 'yes') {
    //                     foreach ($row['buy_status_rule_' . $rule_numbernn . ''] as $rulerecord) {
    //                         $rulerecordaaa .= '&nbsp' . $rulerecord;
    //                     }
    //                     }
    //                     $buy_trigger_type_rule ='';
    //                     foreach ($row['buy_trigger_type_rule_' . $rule_numbernn . ''] as $rulerecord) {
    //                         if ($rulerecord == 'very_strong_barrier') {
    //                             $value = '<span class="label label-success">VSB</span>';
    //                         } else if ($rulerecord == 'weak_barrier') {
    //                             $value = '<span class="label label-warning">WB</span>';
    //                         } else if ($rulerecord == 'strong_barrier') {
    //                             $value = '<span class="label label-info">SB</span>';
    //                         }
    //                         $buy_trigger_type_rule .= '&nbsp' . $value;
    //                     }
                        
    //                     if ($row['buyer_vs_seller_rule_' . $rule_numbernn . '_buy_enable'] == 'yes') {
    //                         $buyer_vs_seller_rule .= '<td>' . $row['buyer_vs_seller_rule_' . $rule_numbernn . '_buy'] . '</td>';
    //                     } else {
    //                         $buyer_vs_seller_rule .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
                        
    //                     if ($row['buy_order_level_' . $rule_numbernn . '_enable'] == 'yes') {
    //                         $buy_order_level .= '<td>' . $buyrulerecordAll . '</td>';
    //                     } else {
    //                         $buy_order_level .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
                        
                        
    //                     if ($row['done_pressure_rule_' . $rule_numbernn . '_buy_enable'] == 'yes') {
    //                         $done_pressure_rulebuy .= '<td>' . $row['done_pressure_rule_' . $rule_numbernn . '_buy'] . '</td>';
    //                     } else {
    //                         $done_pressure_rulebuy .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
                
    //                     if ($row['buy_virtual_barrier_rule_' . $rule_numbernn . '_enable'] == 'yes') {
    //                         $buy_virtural_rule_ .= '<td>' . number_format($row['buy_virtural_rule_' . $rule_numbernn . '']) . '</td>';
    //                     } else {
    //                         $buy_virtural_rule_ .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
                
    //                     if ($row['buy_status_rule_' . $rule_numbernn . '_enable'] == 'yes') {
    //                         $buy_status_rule_ .= '<td>' . $rulerecordaaa . '</td>';
    //                     } else {
    //                         $buy_status_rule_ .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
    //                     if ($row['buy_trigger_type_rule_' . $rule_numbernn . '_enable'] == 'yes') {
    //                         $buy_trigger_type_ruleAll .= '<td>' . $buy_trigger_type_rule . '</td>';
    //                     } else {
    //                         $buy_trigger_type_ruleAll .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
    //                     if ($row['buy_check_volume_rule_' . $rule_numbernn . ''] == 'yes') {
    //                         $buy_volume_rule_ .= '<td>' . number_format($row['buy_volume_rule_' . $rule_numbernn . '']) . '</td>';
    //                     } else {
    //                         $buy_volume_rule_ .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
    //                     if ($row['buy_trigger_type_rule_' . $rule_numbernn . '_enable'] == 'yes') {
    //                         $buy_trigger_type_ruleArr .= '<td>' . $buy_trigger_type_rule . '</td>';
    //                     } else {
    //                         $buy_trigger_type_ruleArr .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
    //                     if ($row['big_seller_percent_compare_rule_' . $rule_numbernn . '_buy_enable'] == 'yes') {
    //                         $big_seller_percent_compare_rule_ .= ' <td class="center">' . $row['big_seller_percent_compare_rule_' . $rule_numbernn . '_buy'] . ' %' . '</td>';
    //                     } else {
    //                         $big_seller_percent_compare_rule_ .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
    //                     if ($row['closest_black_wall_rule_' . $rule_numbernn . '_buy_enable'] == 'yes') {
    //                         $closest_black_wall_rule_ .= ' <td class="center">' . $row['closest_black_wall_rule_' . $rule_numbernn . '_buy'] . '</td>';
    //                     } else {
    //                         $closest_black_wall_rule_ .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
    //                     if ($row['closest_yellow_wall_rule_' . $rule_numbernn . '_buy_enable'] == 'yes') {
    //                         $closest_yellow_wall_rule_ .= '<td>' . $row['closest_yellow_wall_rule_' . $rule_numbernn . '_buy'] . '</td>';
    //                     } else {
    //                         $closest_yellow_wall_rule_ .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
    //                     if ($row['seven_level_pressure_rule_' . $rule_numbernn . '_buy_enable'] == 'yes') {
    //                         $seven_level_pressure_rule_ .= '<td>' . $row['seven_level_pressure_rule_' . $rule_numbernn . '_buy'] . '</td>';
    //                     } else {
    //                         $seven_level_pressure_rule_ .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
    //                     if ($row['buy_last_candle_type' . $rule_numbernn . '_enable'] == 'yes') {
    //                         $last_candle_type .= '<td>' . $row['last_candle_type' . $rule_numbernn . '_buy'] . '</td>';
    //                     } else {
    //                         $last_candle_type .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
    //                     if ($row['buy_rejection_candle_type8' . $rule_numbernn . '_enable'] == 'yes') {
    //                         $rejection_candle_type .= '<td>' . $row['rejection_candle_type' . $rule_numbernn . '_buy'] . '</td>';
    //                     } else {
    //                         $rejection_candle_type .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
    //                     if ($row['buy_last_200_contracts_buy_vs_sell' . $rule_numbernn . '_enable'] == 'yes') {
    //                         $last_200_contracts_buy_vs_sell .= '<td>' . $row['last_200_contracts_buy_vs_sell' . $rule_numbernn . '_buy'] . '</td>';
    //                     } else {
    //                         $last_200_contracts_buy_vs_sell .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
    //                     if ($row['buy_last_200_contracts_time' . $rule_numbernn . '_enable'] == 'yes') {
    //                         $last_200_contracts_time .= '<td>' . $row['last_200_contracts_time' . $rule_numbernn . '_buy'] . '</td>';
    //                     } else {
    //                         $last_200_contracts_time .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
    //                     if ($row['buy_last_qty_buyers_vs_seller' . $rule_numbernn . '_enable'] == 'yes') {
    //                         $last_qty_buyers_vs_seller .= '<td>' . $row['last_qty_buyers_vs_seller' . $rule_numbernn . '_buy'] . '</td>';
    //                     } else {
    //                         $last_qty_buyers_vs_seller .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
    //                     if ($row['buy_last_qty_time' . $rule_numbernn . '_enable'] == 'yes') {
    //                         $last_qty_time .= '<td>' . $row['last_qty_time' . $rule_numbernn . '_buy'] . '</td>';
    //                     } else {
    //                         $last_qty_time .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
    //                     if ($row['buy_score' . $rule_numbernn . '_enable'] == 'yes') {
    //                         $score .= '<td>' . $row['score' . $rule_numbernn . '_buy'] . '</td>';
    //                     } else {
    //                         $score .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
    //                     if ($row['buy_comment' . $rule_numbernn . '_enable'] == 'yes') {
    //                         $comment .= '<td class="parent"><a class="parent" data-toggle="tooltip" data-placement="top" title="'.$row['comment' . $rule_numbernn . '_buy'].'"> 
    //                         '. substr($row['comment' . $rule_numbernn . '_buy'],0,10).'</a></td>';
    //                     } else {
    //                         $comment .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
                        
    //                     if ($row['buy_last_candle_status' . $rule_numbernn . '_enable'] == 'yes') {
    //                         $last_candle_status .= '<td>' . ucfirst($row['last_candle_status' . $rule_numbernn . '_buy']) . '</td>';
    //                     } else {
    //                         $last_candle_status .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
    //             }
    //             $html .= ' <tr class="center">
    //                         <th style="width:350px; border-right:3px solid #ddd;">Status</th>
                            
                        
    //     ' . $buy_status_rule_ . '
    //                     </tr>
                        
    //                     <tr class="center">
    //                         <th>Trigger Rule</th>
    //     ' . $buy_trigger_type_ruleAll . '
    //                     </tr>
                        
    //                     <tr class="center">
    //                         <th>(Virtual Order Book Barrier Range)</th>
                        
    //     '. $buy_virtural_rule_.'
                        
    //                     </tr>
                        
    //                     <tr class="center">
    //                         <th>(If Volume greater then the defined value)</th>
                            
    //     ' . $buy_volume_rule_. '

    //                     </tr>
                        
    //                     <tr class="center">
    //                         <th> Down pressure ( Down pressure is Greater or equal to the defined pressure)</th>
    //                     '. $done_pressure_rulebuy .'
    //                     </tr>';
                        
                        
                        
    //             $html .= '<tr class="center">
    //                         <th>Big Buyers % ( percent greater then the defined %)</th>
                        
    //     ' . $big_seller_percent_compare_rule_ . '' . '</tr>
    //                     <tr class="center">
    //                         <th>Closest black wall( Greater then or equal to the defined value)</th>
                        
    //     ' . $closest_black_wall_rule_ . '

    //                     </tr>
    //                     <tr class="center">
    //                         <th>Closest yellow wall (Greater then or equal to the defined value)</th>
                            
    //     ' . $closest_yellow_wall_rule_ . '

    //                     </tr>
    //                     <tr class="center">
    //                         <th>Seven level pressue (Greater then or equal to the defined value)</th>
                            
    //     ' . $seven_level_pressure_rule_ . '

    //                     </tr>
    //                     <tr class="center">
    //                         <th>Buys vs Seller</th>
                    
    //     ' . $buyer_vs_seller_rule . '
    //                     </tr>
    //                     <tr class="center">
    //                         <th>Last Candle Type</th>
                        
    //     ' . $last_candle_type . '

    //                     </tr>
    //                     <tr class="center">
    //                         <th>Rejection Candle Type</th>
                        
    //     ' . $rejection_candle_type . '

    //                     </tr>
    //                     <tr class="center">
    //                         <th>Last 200 Contract Buyers Vs Sellers</th>
                        
    //     ' . $last_200_contracts_buy_vs_sell . '

    //                     </tr>
    //                     <tr class="center">
    //                         <th>Last 200 Contract Time(Less then)</th>
                            
    //     ' . $last_200_contracts_time . '

    //                     </tr>
    //                     <tr class="center">
    //                         <th>Last qty Contract Buyes Vs seller</th>
                        
    //     ' . $last_qty_buyers_vs_seller . '

    //                     </tr>
    //                     <tr class="center">
    //                         <th>Last qty Contract time(Less then)</th>
                        
    //     ' . $last_qty_time . '

    //                     </tr>
    //                     <tr class="center">
    //                         <th>Score</th>
                            
    //     ' . $score . '
    //                     </tr>
                        
    //                     <tr class="center">
    //                         <th>Comment</th>
                        
    //     ' . $comment . '

    //                     </tr>
                        
                        
    //                     <tr class="center">
    //                         <th>Order Level</th>
                            
    //         '.$buy_order_level.'
            
    //                         </tr>
                            
                            
    //                         <tr class="center">
    //                         <th>Last Candle Status</th>
    //                     '.
    //         $last_candle_status.'
    //                         </tr>
                            
    //                     </tbody>
    //                 </table>
                    
    //                 </div></div>'; 
                    
    //             $html .= '  <div id="sell" class="tab-pane fade">
                
                
    //                 <div class="tbresp" style="max-width: 100%; overflow-x: auto;">
    //                 <table class="table table-bordered zama_th">
    //                     <thead>
    //                     <tr>
    //                         <th class="" style="background:#4267b2; color: #FFF; width:450px; float: left;"> Rule <b>'. $rule .'</b> Of Barrier Trigger</th>';
    //             $rule_numbernn = $rule;
    //             foreach ($rules_set_arr as $coin) {
    //                     $html .= '<th class="center" style="background:#4267b2; color:#FFF;"> ' . $coin['coin'];
    //                     $html .= '</th>';
    //             }
    //             $html .= ' </tr> </thead> <tbody>';
    //             $buy_status_rule_sell             = '';
    //             $big_seller_percent_compare_rule_ = '';
    //             $closest_black_wall_rule_         = '';
    //             $closest_yellow_wall_rule_        = '';
    //             $seven_level_pressure_rule_       = '';
    //             $buyer_vs_seller_rule_            = '';
    //             $last_candle_type                 = '';
    //             $rejection_candle_type            = '';
    //             $last_200_contracts_buy_vs_sell   = '';
    //             $last_200_contracts_time          = '';
    //             $last_qty_buyers_vs_seller        = '';
    //             $last_qty_time                    = '';
    //             $score                            = '';
    //             $comment                          = '';
    //             $sell_virtural_rule_              = '';
                
    //             $rule_numbernn = $rule;
    //             foreach($rules_set_arr as $row){ 	
    //             //if ($rules_set_arr['enable_sell_rule_no_' . $rule_numbernn . ''] == 'yes') {		
    //                 $sell_order_level = '';
    //                 foreach ($row['sell_order_level_' . $rule_numbernn . ''] as $rulerecordOrderlevel) {
                        
    //                     if ($rulerecordOrderlevel == 'level_1') {
    //                         $value1 = '<span class="label label-warning">L 1</span>';
    //                     } else if ($rulerecordOrderlevel == 'level_2') {
    //                         $value1 = '<span class="label label-warning">L 2</span>';
    //                     } else if ($rulerecordOrderlevel == 'level_3') {
    //                         $value1 = '<span class="label label-warning">L 3</span>';
    //                     } else if ($rulerecordOrderlevel == 'level_4') {
    //                         $value1 = '<span class="label label-warning">L 4</span>';
    //                     } else if ($rulerecordOrderlevel == 'level_5') {
    //                         $value1 = '<span class="label label-warning">L 5</span>'; 
    //                     } else if ($rulerecordOrderlevel == 'level_6') {
    //                         $value1 = '<span class="label label-warning">L 6</span>';
    //                     } 
    //                     $sell_order_level .= '&nbsp;' . $value1;
    //                 }
                
    //                 $rulerecordsell = '';
    //                 foreach ($row['sell_status_rule_' . $rule_numbernn . ''] as $rulerecord) {
    //                     $rulerecordsell .= '&nbsp;' . $rulerecord;
    //                 }
                    
    //                 $sell_trigger_type_rule = '';
    //                 if ($row['sell_trigger_type_rule_' . $rule_numbernn . '_enable'] == 'yes') {
    //                     foreach ($row['sell_trigger_type_rule_' . $rule_numbernn . ''] as $rulerecord) {
    //                         if ($rulerecord == 'very_strong_barrier') {
    //                             $value = '<span class="label label-success">VSB</span>';
    //                         } else if ($rulerecord == 'weak_barrier') {
    //                             $value = '<span class="label label-warning">WB</span>';
    //                         } else if ($rulerecord == 'strong_barrier') {
    //                             $value = '<span class="label label-info">SB</span>';
    //                         }
    //                         $sell_trigger_type_rule .= '&nbsp;' . $value;
    //                     }
    //                 }
                    
    //                     if ($row['sell_order_level_' . $rule_numbernn . '_enable'] == 'yes') {
    //                         $sell_order_levelAll .= '<td>' . $sell_order_level . '</td>';
    //                     } else {
    //                         $sell_order_levelAll .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
                        
    //                     if ($row['done_pressure_rule_' . $rule_numbernn . '_enable'] == 'yes') {
    //                         $done_pressure_rule .= '<td>' . $row['done_pressure_rule_' . $rule_numbernn . ''] . '</td>';
    //                     } else {
    //                         $done_pressure_rule .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
    //                     if ($row['sell_virtual_barrier_rule_' . $rule_numbernn . '_enable'] == 'yes') {
    //                         $sell_virtural_rule_ .= '<td>' . number_format($row['sell_virtural_rule_' . $rule_numbernn . '']) . '</td>';
    //                     } else {
    //                         $sell_virtural_rule_ .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
                        
    //                     if ($row['sell_status_rule_' . $rule_numbernn . '_enable'] == 'yes') {
    //                         $sell_status_rule .= '<td>' . $rulerecordsell . '</td>';
    //                     } else {
    //                         $sell_status_rule .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
    //                     if ($row['sell_check_volume_rule_' . $rule_numbernn . ''] == 'yes') {
    //                         $sell_volume_rule_ .= '<td>' . number_format($row['sell_volume_rule_' . $rule_numbernn . '']) . '</td>';
    //                     } else {
    //                         $sell_volume_rule_ .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
    //                     if ($row['sell_trigger_type_rule_' . $rule_numbernn . '_enable'] == 'yes') {
    //                         $sell_trigger_type_ruleArr .= '<td>' . $sell_trigger_type_rule . '</td>';
    //                     } else {
    //                         $sell_trigger_type_ruleArr .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
                        
    //                     if ($row['big_seller_percent_compare_rule_' . $rule_numbernn . '_enable'] == 'yes') {
    //                         $big_seller_percent_compare_rule_sell .= ' <td class="center">' . $row['big_seller_percent_compare_rule_' . $rule_numbernn . ''] . ' %' . '</td>';
    //                     } else {
    //                         $big_seller_percent_compare_rule_sell .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
                        
    //                     if ($row['closest_black_wall_rule_' . $rule_numbernn . '_enable'] == 'yes') {
    //                         $closest_black_wall_rule_sell .= ' <td class="center">' . $row['closest_black_wall_rule_' . $rule_numbernn . ''] . '</td>';
    //                     } else {
    //                         $closest_black_wall_rule_sell .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
    //                     if ($row['sell_percent_rule_' . $rule_numbernn . '_enable'] == 'yes') {
    //                         $sell_percent_rule .= ' <td class="center">' . $row['sell_percent_rule_' . $rule_numbernn . ''] . '</td>';
    //                     } else {
    //                         $sell_percent_rule .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
    //                     if ($row['closest_yellow_wall_rule_' . $rule_numbernn . '_enable'] == 'yes') {
    //                         $closest_yellow_wall_rule_sell .= '<td>' . $row['closest_yellow_wall_rule_' . $rule_numbernn . ''] . '</td>';
    //                     } else {
    //                         $closest_yellow_wall_rule_sell .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
    //                     if ($row['seven_level_pressure_rule_' . $rule_numbernn . '_enable'] == 'yes') {
    //                         $seven_level_pressure_rule_sell .= '<td>' . $row['seven_level_pressure_rule_' . $rule_numbernn . ''] . '</td>';
    //                     } else {
    //                         $seven_level_pressure_rule_sell .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
    //                     if ($row['sell_last_candle_type' . $rule_numbernn . '_enable'] == 'yes') {
    //                         $last_candle_type_sell .= '<td>' . $row['last_candle_type' . $rule_numbernn . ''] . '</td>';
    //                     } else {
    //                         $last_candle_type_sell .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
                        
                        
    //                     if ($row['sell_rejection_candle_type' . $rule_numbernn . '_enable'] == 'yes') {
                    
    //                         if($row['rejection_candle_type' . $rule_numbernn . '_sell'] =='top_supply_rejection'){
    //                         $rejection_candle_type_sell .= '<td>' .  '<span class="label label-warning">T S R</span>'. '</td>';	 
    //                         }else{
    //                         $rejection_candle_type_sell .= '<td>' . $row['rejection_candle_type' . $rule_numbernn . '_sell'] . '</td>';
    //                         }
                    
    //                     } else {
    //                         $rejection_candle_type_sell .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
                        
                        
    //                     if ($row['seller_vs_buyer_rule_' . $rule_numbernn . '_sell_enable'] == 'yes') {
    //                         $seller_vs_buyer_rule .= '<td>' . $row['seller_vs_buyer_rule_' . $rule_numbernn . '_sell'] . '</td>';
    //                     } else {
    //                         $seller_vs_buyer_rule .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
    //                     if ($row['sell_last_200_contracts_buy_vs_sell' . $rule_numbernn . '_enable'] == 'yes') {
    //                         $last_200_contracts_buy_vs_sell .= '<td>' . $row['last_200_contracts_buy_vs_sell' . $rule_numbernn . '_sell'] . '</td>';
    //                     } else {
    //                         $last_200_contracts_buy_vs_sell .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
    //                     if ($row['sell_last_200_contracts_time' . $rule_numbernn . '_enable'] == 'yes') {
    //                         $last_200_contracts_time_sell .= '<td>' . $row['last_200_contracts_time' . $rule_numbernn . '_sell'] . '</td>';
    //                     } else {
    //                         $last_200_contracts_time_sell .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
    //                     if ($row['sell_last_qty_buyers_vs_seller' . $rule_numbernn . '_enable'] == 'yes') {
    //                         $sell_last_qty_buyers_vs_seller .= '<td>' . $row['last_qty_buyers_vs_seller' . $rule_numbernn . '_sell'] . '</td>';
    //                     } else {
    //                         $sell_last_qty_buyers_vs_seller .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
    //                     if ($row['sell_last_qty_time' . $rule_numbernn . '_enable'] == 'yes') {
    //                         $last_qty_time_sell .= '<td>' . $row['last_qty_time' . $rule_numbernn . '_sell'] . '</td>';
    //                     } else {
    //                         $last_qty_time_sell .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
    //                     if ($row['sell_score' . $rule_numbernn . '_enable'] == 'yes') {
    //                         $score_sell .= '<td>' . $row['score' . $rule_numbernn . '_sell'] . '</td>';
    //                     } else {
    //                         $score_sell .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
    //                     if ($row['sell_comment' . $rule_numbernn . '_enable'] == 'yes') {
    //                         $comment_sell .= '<td class="parent"><a class="parent" data-toggle="tooltip" data-placement="top" title="'.$row['comment' . $rule_numbernn . '_sell'].'"> 
    //                         '. substr($row['comment' . $rule_numbernn . '_sell'],0,10).'</a></td>';
    //                     } else {
    //                         $comment_sell .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
    //                     if ($row['sell_last_candle_status' . $rule_numbernn . '_enable'] == 'yes') {
    //                         $last_candle_status_sell .= '<td>' . ucfirst($row['last_candle_status' . $rule_numbernn . '_sell']) . '</td>';
    //                     } else {
    //                         $last_candle_status_sell .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                     }
                    
    //                     $coin          =  $this->input->post('coin');
    //                     $triggers_type =  $this->input->post('triggers_type');
    //                     $testing       =  $this->input->post('testing');
                    
    //                 if($testing!='' && $testing=='testing'){
    //                     $avgProfit  = '';
    //                     $htmlData   = '';
    //                     $responseArr  = getAvgProfitLoss($coin,$rule_numbernn,$triggers_type);
                        
    //                     if($responseArr['avg_profit']!=''){
    //                     $avgProfitAll .= '<td>' . number_format($responseArr['avg_profit'],2).' %' . '</td>';
    //                     }else{
    //                     $avgProfitAll .= '<td>' . '<span class="label label-warning">No Profit</span>' . '</td>';	 
    //                     }
    //                     $htmlData     ='<tr class="center" style="background:#4267b2; color:#FFF; "><th>Avg Profit</th> '. $avgProfitAll.'</tr>';	 
                        
    //                     if($responseArr['total_sold_orders']!=''){
    //                     $totalSoldOrder .= '<td>' . ($responseArr['total_sold_orders']) . '</td>';
    //                     }else{
    //                     $totalSoldOrder .= '<td>' . '<span class="label label-warning">No Order</span>' . '</td>';	 
    //                     }
    //                     $htmlDataSoldOrder ='<tr class="center" style="background:#4267b2; color:#FFF; "><th style="    background: #4267b2;color: #FFF;">Total Sold Order</th> '. $totalSoldOrder.'</tr>';	 
    //                 }
    //                 //}
    //             }
    //             $html .= '<tr class="center">
    //                         <th style="width:350px; border-right:3px solid #ddd;">Status</th>' . $sell_status_rule . '

    //                     </tr>
                        
    //                     <tr class="center">
    //                         <th>Trigger Rule</th>
                        
    //     ' . $sell_trigger_type_ruleArr . '

    //                     </tr>
                        
    //                     <tr class="center">
    //                         <th>(Virtual Order Book Barrier Range)</th>
                    
    //     '. $sell_virtural_rule_.'
                        
    //                     </tr>
                        
    //                     <tr class="center">
    //                         <th>(If Volume greater then the defined value)</th>
                            
                    
    //     ' . $sell_volume_rule_ . '

    //                     </tr>
    //                     <tr class="center">
    //                         <th> Down pressure (Sell: Down pressure is Less or equal to the defined pressure)</th>
    //                         '. $done_pressure_rule .'
    //                     </tr>
    //                     <tr class="center">
    //                         <th>Big Sellers % ( percent greater then the defined %)</th>
                        
    //     ' . $big_seller_percent_compare_rule_sell . '

    //                     </tr>
    //                     <tr class="center">
    //                         <th>Closest black wall( Greater then or equal to the defined value)</th>
                        
    //     ' . $closest_black_wall_rule_sell . '

    //                     </tr>
    //                     <tr class="center">
    //                         <th>Closest yellow wall (Greater then or equal to the defined value)</th>
                        
    //     ' . $closest_yellow_wall_rule_sell . '

    //                     </tr>
    //                     <tr class="center">
    //                         <th>Seven level pressue (Greater then or equal to the defined value)</th>
                            
    //     ' . $seven_level_pressure_rule_sell . '

    //                     </tr>
                        
    //                     <tr class="center">
    //                         <th> Sell % (when we sell the order we check if the defined percenage is meet)</th>
                            
    //     ' . $sell_percent_rule . '

    //                     </tr>
                        
    //                     <tr class="center">
    //                         <th> Seller vs Buys</th>
                        
    //     ' . $seller_vs_buyer_rule . '

    //                     </tr>
    //                     <tr class="center">
    //                         <th>Last Candle Type</th>
                        
    //     ' . $last_candle_type_sell . '

    //                     </tr>
    //                     <tr class="center">
    //                         <th>Rejection Candle Type</th>
                        
    //     ' . $rejection_candle_type_sell . '

    //                     </tr>
    //                     <tr class="center">
    //                         <th>Last 200 Contract Sellers Vs Buyers</th>
                    
    //     ' . $last_200_contracts_buy_vs_sell . '

    //                     </tr>
    //                     <tr class="center">
    //                         <th>Last 200 Contract Time(Less then)</th>
                            
    //     ' . $last_200_contracts_time_sell . '

    //                     </tr>
    //                     <tr class="center">
    //                         <th>Last qty Contract seller Vs Buyes</th>
                            
    //     ' . $sell_last_qty_buyers_vs_seller . '

    //                     </tr>
    //                     <tr class="center">
    //                         <th>Last qty Contract time(Less then)</th>
                        
    //     ' . $last_qty_time_sell . '

    //                     </tr>
    //                     <tr class="center">
    //                         <th>Score</th>
                            
    //     ' . $score_sell . '

    //                     </tr>
                        
    //                     <tr class="center">
    //                         <th>Comment</th>
                        
    //     ' . $comment_sell . '

    //              </tr>
				 
	// 			  <tr class="center">
    //                   <th>Order Level</th>
                      
    //     '. $sell_order_levelAll.'
    //                     </tr>
                        
    //                     <tr class="center">
    //                     <th>Last Candle Status</th>
    //             '.
    //     $last_candle_status_sell.'
    //                     </tr>
                        
    //                 '.$htmlData.'
    //                 '.$htmlDataSoldOrder.'
                    
    //                 </tbody>
    //             </table>
    //             </div> 
    //             <!--End of Sell part --> 
    //             </div></div></div>';
    //         }
    //         else if($triggers_type=='barrier_percentile_trigger'){
                
    //             $html .= '<div class="col-md-12 appnedAjax">
            
    //             <ul class="nav nav-tabs">
    //             <li class="active"><a data-toggle="tab" href="#buy">Buy Rules</a></li>
    //             <li><a data-toggle="tab" href="#sell">Sell Rules</a></li>
    //             <li><a data-toggle="tab" href="#stoploss">Stop Loss Rules</a></li>
    //             </ul>
    //             <div class="tab-content ">
    //             <div id="buy" class="tab-pane fade in active"> 
    //                 <!-- Buy part -->
            
    //                 <table class="table table-bordered zama_th compair_hide_row_col_table">
    //                 <thead>
    //                     <tr>
    //                     <th class="" style="background:#4267b2; color: #FFF;"> Level <b>'. $rule .'</b> Of Barrier Percentile</th>';
    
    //     $level_number = $rule;
    //     //$rules_set_Ar  = (array)$rules_set_arr;
    //     //$rules_set_arr = unique_array($rules_set_Ar, 'coin');
    //     // $html .= '<th class="center" style="background:#4267b2; color: #FFF;"> Show Hide </th>';
    //     foreach($rules_set_arr as $row){ 
        
    //                 if ($row['trigger_level'] == 'level_'.$level_number ) {
    //                     if($row['enable_buy_barrier_percentile']=='yes'){
    //                         $onOff = '<span class="label label-success pull-right">ON</span>';
    //                     }else{
    //                         $onOff = '<span class="label label-danger pull-right">OFF</span>';  
    //                     } 
    //                     $html .= '<th class="center" style="background:#4267b2; color: #FFF;"> '.$row['coin'].' <div class="close_colm">X</div></th>';
    //                 } 
    //             }
    //                     $html .= '</tr>
    //                 </thead>
    //                 <tbody>';
    //     $barrier_percentile_is_previous_blue_candel                       = '';
    //     $barrier_percentile_bottom_demond_rejection                       = '';
    //     $barrier_percentile_bottom_supply_rejection                       = '';      
    //     $barrier_percentile_trigger_default_stop_loss_percenage           = '';
    //     $barrier_percentile_trigger_barrier_range_percentage              = '';
    //     $barrier_percentile_trigger_buy_black_wall_apply                  = '';
    //     $barrier_percentile_trigger_buy_virtual_barrier                   = '';
    //     $barrier_percentile_trigger_buy_seven_level_pressure              = '';
    //     $barrier_percentile_trigger_buy_last_200_contracts_buy_vs_sell    = '';
    //     $barrier_percentile_trigger_buy_last_200_contracts_time           = '';
    //     $barrier_percentile_trigger_buy_last_qty_contracts_buyer_vs_seller= '';
    //     $barrier_percentile_trigger_buy_last_qty_contracts_time           = '';
    //     $barrier_percentile_trigger_5_minute_rolling_candel               = '';
    //     $barrier_percentile_trigger_15_minute_rolling_candel              = '';
    //     $barrier_percentile_trigger_buyers_buy                            = '';
    //     $barrier_percentile_trigger_sellers_buy                           = '';
        
    
    //     $level_number = $rule;
    //     foreach($rules_set_arr as $row){ 
            
    //         $coin          = $row['coin'];
    //         $percentil_arr = $this->mod_rulesorder->percentile_coin_meta($coin);
    //         $percentil     = (array)$percentil_arr[0];
        
    //         if ($row['trigger_level'] == 'level_'.$level_number ) {
                
    //             if ($row['barrier_percentile_is_previous_blue_candel'] == 'yes') {
    //                 $barrier_percentile_is_previous_blue_candel .= '<td>' . ucfirst($row['percentile_trigger_last_candle_type']) . '</td>';
    //             } else {
    //                 $barrier_percentile_is_previous_blue_candel .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //             }
                
    //             $barrier_percentile_trigger_default_stop_loss_percenageData  = ($row['barrier_percentile_trigger_default_stop_loss_percenage']!='') ?  $row['barrier_percentile_trigger_default_stop_loss_percenage'] : '---';
    //             $barrier_percentile_trigger_default_stop_loss_percenage     .= '<td>' .$barrier_percentile_trigger_default_stop_loss_percenageData . ' </td>';
                
    //             $barrier_percentile_trigger_barrier_range_percentageData  = ($row['barrier_percentile_trigger_barrier_range_percentage']!='') ?  $row['barrier_percentile_trigger_barrier_range_percentage'] : '---';
    //             $barrier_percentile_trigger_barrier_range_percentage     .= '<td>' .$barrier_percentile_trigger_barrier_range_percentageData . ' </td>';
                
                
    //             if ($row['barrier_percentile_trigger_buy_black_wall_apply'] == 'yes') {
    //                 $barrier_percentile_trigger_buy_black_wall .= '<td> Top ' . $row['barrier_percentile_trigger_buy_black_wall'] . ' % 
    //                 <span style="font-size:11px;     color: #a03d3d;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ( '.number_format((float)$percentil['blackwall_'.$row['barrier_percentile_trigger_buy_black_wall'].''], 2, '.', '').'  ) </span></td>';
    //             } else {
    //                 $barrier_percentile_trigger_buy_black_wall .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //             }
                
                
    //             if ($row['barrier_percentile_trigger_buy_virtual_barrier_apply'] == 'yes') {
    //                 $barrier_percentile_trigger_buy_virtual_barrier .= '<td> Top ' . $row['barrier_percentile_trigger_buy_virtual_barrier'] .' %
    //                 <span style="font-size:11px;     color: #a03d3d;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ( '.number_format((float)$percentil['ask_quantity_'.$row['barrier_percentile_trigger_buy_black_wall'].''], 2, '.', '').'  ) </span></td>';
    //             } else {
    //                 $barrier_percentile_trigger_buy_virtual_barrier .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //             }
                
                
    //             if ($row['barrier_percentile_trigger_buy_seven_level_pressure_apply'] == 'yes') {
    //                 $barrier_percentile_trigger_buy_seven_level_pressure .= '<td> Top ' . $row['barrier_percentile_trigger_buy_seven_level_pressure']. ' %
    //                 <span style="font-size:11px;     color: #a03d3d;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ( '.number_format((float)$percentil['sevenlevel_'.$row['barrier_percentile_trigger_buy_black_wall'].''], 2, '.', '').'  ) </span></td>';
    //             } else {
    //                 $barrier_percentile_trigger_buy_seven_level_pressure .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //             }
                
                
    //             if ($row['barrier_percentile_trigger_buy_last_200_contracts_buy_vs_sell_apply'] == 'yes') {
    //                 $barrier_percentile_trigger_buy_last_200_contracts_buy_vs_sell .= '<td>' . $row['barrier_percentile_trigger_buy_last_200_contracts_buy_vs_sell'] . '</td>';
    //             } else {
    //                 $barrier_percentile_trigger_buy_last_200_contracts_buy_vs_sell .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //             }
                
    //             if ($row['barrier_percentile_trigger_buy_last_200_contracts_time_apply'] == 'yes') {
    //                 $barrier_percentile_trigger_buy_last_200_contracts_time .= '<td>' . $row['barrier_percentile_trigger_buy_last_200_contracts_time'] . '</td>';
    //             } else {
    //                 $barrier_percentile_trigger_buy_last_200_contracts_time .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //             }
                
                
    //             if ($row['barrier_percentile_trigger_buy_last_qty_contracts_buyer_vs_seller_apply'] == 'yes') {
    //                 $barrier_percentile_trigger_buy_last_qty_contracts_buyer_vs_seller .= '<td>' . $row['barrier_percentile_trigger_buy_last_qty_contracts_buyer_vs_seller'] . '</td>';
    //             } else {
    //                 $barrier_percentile_trigger_buy_last_qty_contracts_buyer_vs_seller .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //             }
                
                
    //             if ($row['barrier_percentile_trigger_buy_last_qty_contracts_time_apply'] == 'yes') {
    //                 $barrier_percentile_trigger_buy_last_qty_contracts_time .= '<td>' . $row['barrier_percentile_trigger_buy_last_qty_contracts_time'] . '</td>';
    //             } else {
    //                 $barrier_percentile_trigger_buy_last_qty_contracts_time .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //             }
    //             //number_format((float)$foo, 2, '.', '')
                
    //             if ($row['barrier_percentile_trigger_5_minute_rolling_candel_apply'] == 'yes') {
    //                 $barrier_percentile_trigger_5_minute_rolling_candel .= '<td> Top '  .$row['barrier_percentile_trigger_5_minute_rolling_candel'].' %
    //                 <span style="font-size:11px;     color: #a03d3d;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ( '.number_format((float)$percentil['five_min_'.$row['barrier_percentile_trigger_5_minute_rolling_candel'].''], 2, '.', '').'  )</span></td>';
    //             } else {
    //                 $barrier_percentile_trigger_5_minute_rolling_candel .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //             }
                
                
    //             if ($row['barrier_percentile_trigger_15_minute_rolling_candel_apply'] == 'yes') {
    //                 $barrier_percentile_trigger_15_minute_rolling_candel .= ' <td class="center"> Top ' .  $row['barrier_percentile_trigger_15_minute_rolling_candel']. ' %
    //                 <span style="font-size:11px;     color: #a03d3d;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ( '.number_format((float)$percentil['fifteen_min_'.$row['barrier_percentile_trigger_15_minute_rolling_candel'].''], 2, '.', '').' )</span></td>';
    //             } else {
    //                 $barrier_percentile_trigger_15_minute_rolling_candel .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //             }
                
                
    //             if ($row['barrier_percentile_trigger_buyers_buy_apply'] == 'yes') {
    //                 $barrier_percentile_trigger_buyers_buy .= ' <td class="center"> Top ' .  $row['barrier_percentile_trigger_buyers_buy']. ' %
    //                 <span style="font-size:11px;     color: #a03d3d;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ( '.number_format((float)$percentil['buy_'.$row['barrier_percentile_trigger_buyers_buy'].''], 2, '.', '').' ) </span></td>';
    //             } else {
    //                 $barrier_percentile_trigger_buyers_buy .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //             }
                
    //             if ($row['barrier_percentile_trigger_sellers_buy_apply'] == 'yes') {
    //                 $barrier_percentile_trigger_sellers_buy .= ' <td class="center"> Bottom ' .  $row['barrier_percentile_trigger_sellers_buy']. ' %
    //             <span style="font-size:11px;     color: #a03d3d;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ( '.number_format((float)$percentil['sell_'.$row['barrier_percentile_trigger_sellers_buy'].''], 2, '.', '').' ) </span></td>';
    //             } else {
    //                 $barrier_percentile_trigger_sellers_buy .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //             }
            
            
    //         // New work 
    //             if ($row['barrier_percentile_trigger_15_minute_last_time_ago_apply'] == 'yes') {
    //                 $barrier_percentile_trigger_15_minute_last_time_ago .= ' <td class="center"> Bottom ' .  $row['barrier_percentile_trigger_15_minute_last_time_ago']. ' % </td>';
    //             } else {
    //                 $barrier_percentile_trigger_15_minute_last_time_ago .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //             }
    //             if ($row['barrier_percentile_trigger_ask_apply'] == 'yes') {
    //                 $barrier_percentile_trigger_ask .= ' <td class="center"> Top ' .  $row['barrier_percentile_trigger_ask']. ' % </td>';
    //             } else {
    //                 $barrier_percentile_trigger_ask .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //             }
    //             if ($row['barrier_percentile_trigger_bid_apply'] == 'yes') {
    //                 $barrier_percentile_trigger_bid .= ' <td class="center"> Bottom ' .  $row['barrier_percentile_trigger_bid']. ' % </td>';
    //             } else {
    //                 $barrier_percentile_trigger_bid .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //             }
    //             if ($row['barrier_percentile_trigger_buy_apply'] == 'yes') {
    //                 $barrier_percentile_trigger_buy .= ' <td class="center"> Top ' .  $row['barrier_percentile_trigger_buy']. ' % </td>';
    //             } else {
    //                 $barrier_percentile_trigger_buy .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //             }
    //             if ($row['barrier_percentile_trigger_sell_apply'] == 'yes') {
    //                 $barrier_percentile_trigger_sell .= ' <td class="center"> Bottom ' .  $row['barrier_percentile_trigger_sell']. ' % </td>';
    //             } else {
    //                 $barrier_percentile_trigger_sell .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //             }
    //             if ($row['barrier_percentile_trigger_ask_contracts_apply'] == 'yes') {
    //                 $barrier_percentile_trigger_ask_contracts .= ' <td class="center"> Top ' .  $row['barrier_percentile_trigger_ask_contracts']. ' % </td>';
    //             } else {
    //                 $barrier_percentile_trigger_ask_contracts .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //             }
    //             if ($row['barrier_percentile_trigger_bid_contracts_apply'] == 'yes') {
    //                 $barrier_percentile_trigger_bid_contracts .= ' <td class="center"> Bottom ' .  $row['barrier_percentile_trigger_bid_contracts']. ' % </td>';
    //             } else {
    //                 $barrier_percentile_trigger_bid_contracts .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //             }
    //             // New Caption 
    //             if ($row['percentile_trigger_caption_option_buy_apply'] == 'yes') {
    //                 $percentile_trigger_caption_option_buy .= ' <td class="center">  ' .  $row['percentile_trigger_caption_option_buy']. '  </td>';
    //             } else {
    //                 $percentile_trigger_caption_option_buy .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //             }
    //             if ($row['percentile_trigger_caption_score_buy_apply'] == 'yes') {
    //                 $percentile_trigger_caption_score_buy .= ' <td class="center">  ' .  $row['percentile_trigger_caption_score_buy']. '  </td>';
    //             } else {
    //                 $percentile_trigger_caption_score_buy .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //             }
    //             if ($row['percentile_trigger_buy_trend_buy_apply'] == 'yes') {
    //                 $percentile_trigger_buy_trend_buy .= ' <td class="center">  ' .  $row['percentile_trigger_buy_trend_buy']. '  </td>';
    //             } else {
    //                 $percentile_trigger_buy_trend_buy .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //             }
    //             if ($row['percentile_trigger_sell_buy_apply'] == 'yes') {
    //                 $percentile_trigger_sell_buy .= ' <td class="center">  ' .  $row['percentile_trigger_sell_buy']. '  </td>';
    //             } else {
    //                 $percentile_trigger_sell_buy .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //             }
                
    //             if ($row['percentile_trigger_demand_buy_apply'] == 'yes') {
    //                 $percentile_trigger_demand_buy .= ' <td class="center">  ' .  $row['percentile_trigger_demand_buy']. '  </td>';
    //             } else {
    //                 $percentile_trigger_demand_buy .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //             }
    //             if ($row['percentile_trigger_supply_buy_apply'] == 'yes') {
    //                 $percentile_trigger_supply_buy .= ' <td class="center">  ' .  $row['percentile_trigger_supply_buy']. '  </td>';
    //             } else {
    //                 $percentile_trigger_supply_buy .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //             }
    //             if ($row['percentile_trigger_market_trend_buy_apply'] == 'yes') {
    //                 $percentile_trigger_market_trend_buy .= ' <td class="center">  ' .  (($row['percentile_trigger_market_trend_buy']=='POSITIVE') ? '<span class="label label-success">Positive + </span>' 
    //                                                         : '<span class="label label-warning">Negative - </span>').'</td>';
    //             } else {
    //                 $percentile_trigger_market_trend_buy .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //             }
    //             if ($row['percentile_trigger_meta_trading_buy_apply'] == 'yes') {
    //                 $percentile_trigger_meta_trading_buy .= ' <td class="center">  ' .  $row['percentile_trigger_meta_trading_buy']. '  </td>';
    //             } else {
    //                 $percentile_trigger_meta_trading_buy .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //             }
    //             if ($row['percentile_trigger_riskpershare_buy_apply'] == 'yes') {
    //                 $percentile_trigger_riskpershare_buy .= ' <td class="center">  ' .  $row['percentile_trigger_riskpershare_buy']. '  </td>';
    //             } else {
    //                 $percentile_trigger_riskpershare_buy .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //             }
    //             if ($row['percentile_trigger_RL_buy_apply'] == 'yes') {
    //                 $percentile_trigger_RL_buy .= ' <td class="center">  ' .  $row['percentile_trigger_RL_buy']. '  </td>';
    //             } else {
    //                 $percentile_trigger_RL_buy .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //             }
            
            
            
    //         } 
    //     }
	
	//               $html .= ' 
				  
	// 			  <tr class="center show_hide_row">
				      
    //                   <th style="width:350px; border-right:3px solid #ddd;">Previous Candle Status <div class="close_row">X</div> </th>
                    
					
                            
    //     '. $barrier_percentile_is_previous_blue_candel;
   
    //               $html .= '</tr>
				  
				  
	// 			  <tr class="center show_hide_row">
    //                   <th style="width:350px; border-right:3px solid #ddd;">By Default Stop Loss in Percentage (Equal To Recommended) <div class="close_row">X</div></th>
                    
    //     '. $barrier_percentile_trigger_default_stop_loss_percenage;
   
    //               $html .= '</tr>
	// 			     <tr class="center show_hide_row">
    //                   <th style="width:350px; border-right:3px solid #ddd;">Barrier Range Percentage (Current Market Between percentage) <div class="close_row">X</div></th>
                   
    //     '. $barrier_percentile_trigger_barrier_range_percentage;
   
    
    //                $html .= '</tr>
	// 			     <tr class="center show_hide_row">
    //                   <th style="width:350px; border-right:3px solid #ddd;">(Black Wall Greater From defined percentile) <div class="close_row">X</div></th>
           
    //     '. $barrier_percentile_trigger_buy_black_wall;
   
    //                 $html .= '</tr>
    //                 <tr class="center show_hide_row">
    //                   <th>(Virtual Barrier Greater From defined percentile) <div class="close_row">X</div></th>
                 
    //         '.$barrier_percentile_trigger_buy_virtual_barrier;
        
    //                         $html .= '</tr>
    //                         <tr class="center show_hide_row">
    //                         <th>(Seven Level Greater From defined percentile) <div class="close_row">X</div></th>
                        
    //         '.$barrier_percentile_trigger_buy_seven_level_pressure;
        
    //                         $html .= '</tr>
    //                         <tr class="center show_hide_row">
    //                         <th>Last 200 Contract Buyers Vs Sellers Greater then recommended <div class="close_row">X</div></th>
            
    //     '. $barrier_percentile_trigger_buy_last_200_contracts_buy_vs_sell;
        
    //                         $html .= '</tr>
    //                         <tr class="center show_hide_row">
    //                         <th> Last 200 Contract Time Less Then recommended Value <div class="close_row">X</div></th>
                            
    //                         '.  $barrier_percentile_trigger_buy_last_200_contracts_time;
    //                         $html .= ' </tr>
    //                         <tr class="center show_hide_row">
    //                         <th>Last Qty Contract Buyers Vs Sellers (Greater Then Recommended) <div class="close_row">X</div></th>
                            
    //         '. $barrier_percentile_trigger_buy_last_qty_contracts_buyer_vs_seller;
            
    //                         $html .= '</tr>
    //                         <tr class="center show_hide_row">
    //                         <th>Last qty Contract time(Less then) <div class="close_row">X</div></th>
                        
    //         '. $barrier_percentile_trigger_buy_last_qty_contracts_time;
            
    //                     $html .= ' </tr>
    //                         <tr class="center show_hide_row">
    //                         <th>(5 Minute Rolling Candel Greater From defined percentile)<div class="close_row">X</div></th>
                
    //     '. $barrier_percentile_trigger_5_minute_rolling_candel;
        
    //                         $html .= '</tr>
    //                         <tr class="center show_hide_row">
    //                         <th>(15 Minute Rolling Candel Greater From defined percentile)<div class="close_row">X</div></th>
            
    //         '. $barrier_percentile_trigger_15_minute_rolling_candel;
            
            
    //                         $html .= '</tr>
    //                         <tr class="center show_hide_row">
    //                         <th>(Buyer Should be greater from Top percentile)<div class="close_row">X</div></th>
                        
    //         '. $barrier_percentile_trigger_buyers_buy;
            
            
    //                         $html .= '</tr>
    //                         <tr class="center show_hide_row">
    //                         <th>(Sellers Should be Less Then Bottom percentile)<div class="close_row">X</div></th>
                            
    //         '. $barrier_percentile_trigger_sellers_buy;
            
            
    //                         $html .= '</tr>
                            
                                
    //                         <tr class="center show_hide_row">
    //                         <th>(15 Minute last time ago Should be Less Then Bottom percentile)(T3 LTC Time)<div class="close_row">X</div></th>
            
    //         '. $barrier_percentile_trigger_15_minute_last_time_ago;
            
            
    //                         $html .= '</tr>
    //                         <tr class="center show_hide_row">
    //                         <th>( (Binance buy) ASk Should be greater from Top percentile) (One minute Rooling candle)<div class="close_row">X</div></th>
                            
    //         '. $barrier_percentile_trigger_ask;
            
            
    //                         $html .= '</tr>
    //                         <tr class="center show_hide_row">
    //                         <th>((Binance Sell)Bid Should be Less Then Bottom percentile) (One minute Rooling candle)<div class="close_row">X</div></th>
            
    //         '. $barrier_percentile_trigger_bid;
            
            
    //                         $html .= '</tr>
    //                         <tr class="center show_hide_row">
    //                         <th>((Digie Buy) Buy Should be greater from Top percentile) (One minute Rooling candle)<div class="close_row">X</div></th>
            
    //         '. $barrier_percentile_trigger_buy;
            
            
    //                         $html .= '</tr>
    //                         <tr class="center show_hide_row">
    //                         <th>((Digie Sell) Sell Should be Less Then Bottom percentile) (One minute Rooling candle)<div class="close_row">X</div></th>
            
    //         '. $barrier_percentile_trigger_sell;
            
            
    //                         $html .= '</tr>
    //                         <tr class="center show_hide_row">
    //                         <th>((Big Buyers) Ask Contracts Should be Greater from Top percentile)))<div class="close_row">X</div></th>
                            
    //         '. $barrier_percentile_trigger_ask_contracts;
            
            
    //                         $html .= '</tr>
    //                         <tr class="center show_hide_row">
    //                         <th>((Big Sellers) Bid Contracts Should be Les then Bottom percentile)))<div class="close_row">X</div></th>
                    
    //         '. $barrier_percentile_trigger_bid_contracts;
            
                    
    //         // Yaha say 
    //         $html .= '</tr>
    //                         <tr class="center show_hide_row">
    //                         <th>Caption Option<div class="close_row">X</div></th>
                        
    //         '. $percentile_trigger_caption_option_buy;
            
            
    //         $html .= '</tr>
    //                         <tr class="center show_hide_row">
    //                         <th>Caption Score<div class="close_row">X</div></th>
                    
    //         '. $percentile_trigger_caption_score_buy;
            
            
    //         $html .= '</tr>
    //                         <tr class="center show_hide_row">
    //                         <th>Buy<div class="close_row">X</div></th>
                        
    //         '. $percentile_trigger_buy_trend_buy;
            
            
    //         $html .= '</tr>
    //                         <tr class="center show_hide_row">
    //                         <th>Sell<div class="close_row">X</div></th>
                
    //         '. $percentile_trigger_sell_buy;
            
    //         $html .= '</tr>
    //                         <tr class="center show_hide_row">
    //                         <th>Demand<div class="close_row">X</div></th>
                            
    //         '. $percentile_trigger_demand_buy;
            
    //         $html .= '</tr>
    //                         <tr class="center show_hide_row">
    //                         <th>Supply<div class="close_row">X</div></th>
                    
    //         '. $percentile_trigger_supply_buy;
            
    //         $html .= '</tr>
    //                         <tr class="center show_hide_row">
    //                         <th>Market Trend<div class="close_row">X</div></th>
                
    //         '. $percentile_trigger_market_trend_buy;
            
    //         $html .= '</tr>
    //                         <tr class="center show_hide_row">
    //                         <th>Meta Tranding<div class="close_row">X</div></th>
            
    //         '. $percentile_trigger_meta_trading_buy;
            
            
    //         $html .= '</tr>
    //                         <tr class="center show_hide_row">
    //                         <th>Resk per Share<div class="close_row">X</div></th>
                    
    //         '. $percentile_trigger_riskpershare_buy;
            
            
    //         $html .= '</tr>
    //                         <tr class="center show_hide_row">
    //                         <th>RL<div class="close_row">X</div></th>
                            
    //         '. $percentile_trigger_RL_buy;
            
    //         $html .= '</tr>
                            
    //                     </tbody>
    //                     </table>
    //                 </div>
    //                 <div class="clearfix"></div>
    //                 <!--End of Buy part -->
                    
    //                 <div id="sell" class="tab-pane fade">
    //                     <table class="table table-bordered zama_th compair_hide_row_col_table">
    //                     <thead>
    //                         <tr>
    //                             <th class="" style="background:#4267b2; color: #FFF;"> Level <b>'. $rule .'</b> Of Barrier Percentile</th>';
            
    //                             $level_number = $rule;
    //                             //$html .= ' <th class="center" style="background:#4267b2; color: #FFF;"> Show Hide</th>';	
    //                             foreach($rules_set_arr as $row){ 
    //                             if ($row['trigger_level'] == 'level_'.$level_number ) {
                                    
    //                                             if($row['enable_sell_barrier_percentile']=='yes'){
    //                                                 $onOff = '<span class="label label-success pull-right">ON</span>';
    //                                             }else{
    //                                                 $onOff = '<span class="label label-danger pull-right">OFF</span>';  
    //                                             }
    //                                             $html .= ' <th class="center" style="background:#4267b2; color: #FFF;"> '. $row['coin'].' <div class="close_colm">X</div></th>';	  
    //                                 } 
    //                             }
    //                         $html .= ' </tr>
    //                     </thead>
    //                     <tbody>';
                        
    //         $barrier_percentile_trigger_default_profit_percenage               = '';               
    //         $trailing_difference_between_stoploss_and_current_market_percentage= '';
    //         $barrier_percentile_trigger_sell_black_wall_apply                  = '';
    //         $barrier_percentile_trigger_sell_virtual_barrier                   = '';
    //         $barrier_percentile_trigger_sell_seven_level_pressure              = '';
    //         $barrier_percentile_trigger_sell_last_200_contracts_buy_vs_sell    = '';
    //         $barrier_percentile_trigger_sell_last_200_contracts_time           = '';
    //         $barrier_percentile_trigger_sell_last_qty_contracts_buyer_vs_seller= '';
    //         $barrier_percentile_trigger_sell_last_qty_contracts_time           = '';
    //         $barrier_percentile_trigger_5_minute_rolling_candel_sell           = '';
    //         $barrier_percentile_trigger_15_minute_rolling_candel_sell          = '';
    //         $barrier_percentile_trigger_buyers_sell                            = '';
    //         $barrier_percentile_trigger_sellers_sell                           = '';
        
    //         $level_number = $rule;
    //         foreach($rules_set_arr as $row){ 
            
            
    //                 $coin          = $row['coin'];
    //                 $percentil_arr = $this->mod_rulesorder->percentile_coin_meta($coin);
    //                 $percentil     = (array)$percentil_arr[0];
                
    //                 if ($row['trigger_level'] == 'level_'.$level_number ) {
                    
    //                     $barrier_percentile_trigger_default_profit_percenage .= '<td>' . $row['barrier_percentile_trigger_default_profit_percenage'] . ' </td>';
    //                     $trailing_difference_between_stoploss_and_current_market_percentage .= '<td>' . $row['barrier_percentile_trigger_trailing_difference_between_stoploss_and_current_market_percentage'] . ' </td>';
                    
    //                 if ($row['barrier_percentile_trigger_sell_black_wall_apply'] == 'yes') {
    //                     $barrier_percentile_trigger_sell_black_wall .= '<td> Bottom ' . $row['barrier_percentile_trigger_sell_black_wall'] . ' %
    //                     <span style="font-size:11px;     color: #a03d3d;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ( '.number_format((float)$percentil['blackwall_b_'.$row['barrier_percentile_trigger_sell_black_wall'].''], 
    //                     2, '.', '').' ) 
    //                     </span></td>';
    //                 } else {
    //                     $barrier_percentile_trigger_sell_black_wall .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                    
                    
    //                 if ($row['barrier_percentile_trigger_sell_virtual_barrier_apply'] == 'yes') {
    //                     $barrier_percentile_trigger_sell_virtual_barrier .= '<td> Bottom ' . $row['barrier_percentile_trigger_sell_virtual_barrier'] .' %
    //                     <span style="font-size:11px;     color: #a03d3d;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ( '.number_format((float)$percentil['bid_quantity_'.$row['barrier_percentile_trigger_sell_virtual_barrier'].''], 
    //                     2, '.', '').' ) 
    //                     </span></td>';
    //                 } else {
    //                     $barrier_percentile_trigger_sell_virtual_barrier .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                    
                    
    //                 if ($row['barrier_percentile_trigger_sell_seven_level_pressure_apply'] == 'yes') {
    //                     $barrier_percentile_trigger_sell_seven_level_pressure .= '<td> Bottom ' . $row['barrier_percentile_trigger_sell_seven_level_pressure']. ' %
    //                     <span style="font-size:11px;     color: #a03d3d;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ( '.number_format((float)$percentil['sevenlevel_b_'.$row['barrier_percentile_trigger_sell_seven_level_pressure'].''], 
    //                     2, '.', '').' )
    //                     </span></td>';
    //                 } else {
    //                     $barrier_percentile_trigger_sell_seven_level_pressure .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                    
                    
    //                 if ($row['barrier_percentile_trigger_sell_last_200_contracts_buy_vs_sell_apply'] == 'yes') {
    //                     $barrier_percentile_trigger_sell_last_200_contracts_buy_vs_sell .= '<td>' . $row['barrier_percentile_trigger_sell_last_200_contracts_buy_vs_sell'] . '</td>';
    //                 } else {
    //                     $barrier_percentile_trigger_sell_last_200_contracts_buy_vs_sell .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                    
    //                 if ($row['barrier_percentile_trigger_sell_last_200_contracts_time_apply'] == 'yes') {
    //                     $barrier_percentile_trigger_sell_last_200_contracts_time .= '<td>' . $row['barrier_percentile_trigger_sell_last_200_contracts_time'] . '</td>';
    //                 } else {
    //                     $barrier_percentile_trigger_sell_last_200_contracts_time .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                    
                    
    //                 if ($row['barrier_percentile_trigger_sell_last_qty_contracts_buyer_vs_seller_apply'] == 'yes') {
    //                     $barrier_percentile_trigger_sell_last_qty_contracts_buyer_vs_seller .= '<td>' . $row['barrier_percentile_trigger_sell_last_qty_contracts_buyer_vs_seller'] . '</td>';
    //                 } else {
    //                     $barrier_percentile_trigger_sell_last_qty_contracts_buyer_vs_seller .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }

                    
                    
    //                 if ($row['barrier_percentile_trigger_sell_last_qty_contracts_time_apply'] == 'yes') {
    //                     $barrier_percentile_trigger_sell_last_qty_contracts_time .= '<td>' . $row['barrier_percentile_trigger_sell_last_qty_contracts_time'] . '</td>';
    //                 } else {
    //                     $barrier_percentile_trigger_sell_last_qty_contracts_time .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                    
                    
    //                 if ($row['barrier_percentile_trigger_5_minute_rolling_candel_sell_apply'] == 'yes') {
    //                     $barrier_percentile_trigger_5_minute_rolling_candel_sell .= '<td> Bottom '  .$row['barrier_percentile_trigger_5_minute_rolling_candel_sell'].' %
    //                     <span style="font-size:11px;     color: #a03d3d;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ( '.number_format((float)$percentil['five_min_b_'.$row['barrier_percentile_trigger_5_minute_rolling_candel_sell'].''], 2, '.', '').
    //                 ' ) </span></td>';
    //                 } else {
    //                     $barrier_percentile_trigger_5_minute_rolling_candel_sell .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                    
                    
    //                 if ($row['barrier_percentile_trigger_15_minute_rolling_candel_sell_apply'] == 'yes') {
    //                     $barrier_percentile_trigger_15_minute_rolling_candel_sell .= ' <td class="center"> Bottom ' .  $row['barrier_percentile_trigger_15_minute_rolling_candel_sell']. ' %
    //                     <span style="font-size:11px;     color: #a03d3d;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ( '.number_format((float)$percentil['fifteen_min_b_'.$row['barrier_percentile_trigger_15_minute_rolling_candel_sell'].''], 2, '.', '')
    //                     .' ) </span></td>';
    //                 } else {
    //                     $barrier_percentile_trigger_15_minute_rolling_candel_sell .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                    
    //                 if ($row['barrier_percentile_trigger_buyers_sell_apply'] == 'yes') {
    //                     $barrier_percentile_trigger_buyers_sell .= ' <td class="center"> Bottom ' .  $row['barrier_percentile_trigger_buyers_sell']. ' %
    //                     <span style="font-size:11px;     color: #a03d3d;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ( '.number_format((float)$percentil['buyers_fifteen_b_'.$row['barrier_percentile_trigger_buyers_sell'].''], 2, '.', '').' ) 
    //                     </span></td>';
    //                 } else {
    //                     $barrier_percentile_trigger_buyers_sell .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                    
    //                 if ($row['barrier_percentile_trigger_sellers_sell_apply'] == 'yes') {
    //                     $barrier_percentile_trigger_sellers_sell .= ' <td class="center"> Top ' .  $row['barrier_percentile_trigger_sellers_sell']. ' %
    //                     <span style="font-size:11px;     color: #a03d3d;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ( '.number_format((float)$percentil['sellers_fifteen_b_'.$row['barrier_percentile_trigger_sellers_buy'].''], 2, '.', '').' ) 
    //                     </span></td>';
    //                 } else {
    //                     $barrier_percentile_trigger_sellers_sell .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                    
    //                 ///////////////
    //                 // New work Old
    //                 if ($row['barrier_percentile_trigger_15_minute_last_time_ago_sell_apply'] == 'yes') {
    //                     $barrier_percentile_trigger_15_minute_last_time_ago_sell .= ' <td class="center"> Bottom ' .  $row['barrier_percentile_trigger_15_minute_last_time_ago_sell']. ' % </td>';
    //                 } else {
    //                     $barrier_percentile_trigger_15_minute_last_time_ago_sell .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
    //                 if ($row['barrier_percentile_trigger_ask_sell_apply'] == 'yes') {
    //                     $barrier_percentile_trigger_ask_sell .= ' <td class="center"> Bottom ' .  $row['barrier_percentile_trigger_ask_sell']. ' % </td>';
    //                 } else {
    //                     $barrier_percentile_trigger_ask_sell .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
    //                 if ($row['barrier_percentile_trigger_bid_sell_apply'] == 'yes') {
    //                     $barrier_percentile_trigger_bid_sell .= ' <td class="center"> Top ' .  $row['barrier_percentile_trigger_bid_sell']. ' % </td>';
    //                 } else {
    //                     $barrier_percentile_trigger_bid_sell .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
    //                 if ($row['barrier_percentile_trigger_buy_sell_apply'] == 'yes') {
    //                     $barrier_percentile_trigger_buy_sell .= ' <td class="center"> Bottom ' .  $row['barrier_percentile_trigger_buy_sell']. ' % </td>';
    //                 } else {
    //                     $barrier_percentile_trigger_buy_sell .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                    
    //                 if ($row['barrier_percentile_trigger_sell_rule_sell_apply'] == 'yes') {
    //                     $barrier_percentile_trigger_sell_sell .= ' <td class="center"> Top ' .  $row['barrier_percentile_trigger_sell_rule_sell']. ' % </td>';
    //                 } else {
    //                     $barrier_percentile_trigger_sell_sell .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
    //                 if ($row['barrier_percentile_trigger_ask_contracts_sell_apply'] == 'yes') {
    //                     $barrier_percentile_trigger_ask_contracts_sell .= ' <td class="center">  Bottom' .  $row['barrier_percentile_trigger_ask_contracts_sell']. ' % </td>';
    //                 } else {
    //                     $barrier_percentile_trigger_ask_contracts_sell .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
    //                 if ($row['barrier_percentile_trigger_bid_contracts_sell_apply'] == 'yes') {
    //                     $barrier_percentile_trigger_bid_contracts_sell .= ' <td class="center"> Top ' .  $row['barrier_percentile_trigger_bid_contracts_sell']. ' % </td>';
    //                 } else {
    //                     $barrier_percentile_trigger_bid_contracts_sell .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
    //                 // New work Start from 4-22-2019
    //                 if ($row['percentile_trigger_caption_option_sell_apply'] == 'yes') {
    //                     $percentile_trigger_caption_option_sell .= ' <td class="center">  ' .  $row['percentile_trigger_caption_option_sell']. '  </td>';
    //                 } else {
    //                     $percentile_trigger_caption_option_sell .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
    //                 if ($row['percentile_trigger_caption_score_sell_apply'] == 'yes') {
    //                     $percentile_trigger_caption_score_sell .= ' <td class="center">  ' .  $row['percentile_trigger_caption_score_sell']. '  </td>';
    //                 } else {
    //                     $percentile_trigger_caption_score_sell .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
    //                 if ($row['percentile_trigger_buy_operator_sell_apply'] == 'yes') {
    //                     $percentile_trigger_buy_sell .= ' <td class="center">  ' .  $row['percentile_trigger_buy_sell']. '  </td>';
    //                 } else {
    //                     $percentile_trigger_buy_sell .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
    //                 if ($row['percentile_trigger_sell_buy_apply'] == 'yes') {
    //                     $percentile_trigger_sell_trend_sell .= ' <td class="center">  ' .  $row['percentile_trigger_sell_trend_sell']. '  </td>';
    //                 } else {
    //                     $percentile_trigger_sell_trend_sell .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                    
    //                 if ($row['percentile_trigger_demand_sell_apply'] == 'yes') {
    //                     $percentile_trigger_demand_sell .= ' <td class="center">  ' .  $row['percentile_trigger_demand_sell']. '  </td>';
    //                 } else {
    //                     $percentile_trigger_demand_sell .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
    //                 if ($row['percentile_trigger_supply_sell_apply'] == 'yes') {
    //                     $percentile_trigger_supply_sell .= ' <td class="center">  ' .  $row['percentile_trigger_supply_sell']. '  </td>';
    //                 } else {
    //                     $percentile_trigger_supply_sell .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
    //                 if ($row['percentile_trigger_market_trend_operator_sell_apply'] == 'yes') {
    //                     $percentile_trigger_market_trend_sell .= ' <td class="center">  ' .  (($row['percentile_trigger_market_trend_sell']=='POSITIVE') ? '<span class="label label-success">Positive + </span>' 
    //                                                             : '<span class="label label-warning">Negative - </span>').'</td>';
    //                 } else {
    //                     $percentile_trigger_market_trend_sell .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
    //                 if ($row['percentile_trigger_meta_trading_sell_apply'] == 'yes') {
    //                     $percentile_trigger_meta_trading_sell .= ' <td class="center">  ' .  $row['percentile_trigger_meta_trading_sell']. '  </td>';
    //                 } else {
    //                     $percentile_trigger_meta_trading_sell .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
    //                 if ($row['percentile_trigger_riskpershare_sell_apply'] == 'yes') {
    //                     $percentile_trigger_riskpershare_sell .= ' <td class="center">  ' .  $row['percentile_trigger_riskpershare_sell']. '  </td>';
    //                 } else {
    //                     $percentile_trigger_riskpershare_sell .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
    //                 if ($row['percentile_trigger_RL_sell_apply'] == 'yes') {
    //                     $percentile_trigger_RL_sell .= ' <td class="center">  ' .  $row['percentile_trigger_RL_sell']. '  </td>';
    //                 } else {
    //                     $percentile_trigger_RL_sell .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                    
    //             } //$level_number++;
    //         }
        
        
        
    //                     $html .= ' <tr class="center show_hide_row">
    //                         <th style="width:350px; border-right:3px solid #ddd;">By Default Profit in Percentage(Equal To Recommended)<div class="close_row">X</div></th>
                        
    //     '. $barrier_percentile_trigger_default_profit_percenage;
        
    //                     $html .= ' </tr>
    //                         <tr class="center show_hide_row">
    //                         <th style="width:350px; border-right:3px solid #ddd;">Trailing Difference between stop loss and current Market in Percentage(Eqaual To Recommended)<div class="close_row">X</div></th>
            
    //     '. $trailing_difference_between_stoploss_and_current_market_percentage;
        
        
    //                     $html .= '</tr>
    //                         <tr class="center  show_hide_row">
    //                         <th style="width:350px; border-right:3px solid #ddd;">Black Wall (Less Then) From defined percentile<div class="close_row">X</div></th>
            
    //     '. $barrier_percentile_trigger_sell_black_wall;
            
    //                     $html .= ' </tr>
    //                         <tr class="center show_hide_row">
    //                         <th>Virtual Barrier (Less Then) From defined percentile<div class="close_row">X</div></th>
            
    //         '. $barrier_percentile_trigger_sell_virtual_barrier;
            
    //                     $html .= ' </tr>
    //                         <tr class="center show_hide_row">
    //                         <th>(Seven Level (Less Then) From defined percentile)<div class="close_row">X</div></th>
                    
    //         '. $barrier_percentile_trigger_sell_seven_level_pressure;
            
    //                     $html .= ' </tr>
    //                         <tr class="center show_hide_row">
    //                         <th>Last 200 Contract Buyers Vs Sellers (Less then Recommended)<div class="close_row">X</div></th>
                    
    //         '. $barrier_percentile_trigger_sell_last_200_contracts_buy_vs_sell;
            
    //                     $html .= '  </tr>
    //                         <tr class="center show_hide_row">
    //                         <th>Last 200 Contract Time (Less Then Recommended)<div class="close_row">X</div></th>
                            
    //         '. $barrier_percentile_trigger_sell_last_200_contracts_time.' </tr>
    //                         <tr class="center">
    //                         <th>Last Qty Contract Buyers Vs Sellers(Less Then Recommended)<div class="close_row">X</div></th>
            
    //     '. $barrier_percentile_trigger_sell_last_qty_contracts_buyer_vs_seller.'
            
    //                         </tr>
    //                         <tr class="center show_hide_row">
    //                         <th>Last qty Contract time(Less then Recommended)<div class="close_row">X</div></th>
                        
    //         '. $barrier_percentile_trigger_sell_last_qty_contracts_time;
            
    //                         $html .= '</tr>
    //                         <tr class="center show_hide_row">
    //                         <th>(5 Minute Rolling Candel (Less Then ) From defined percentile)<div class="close_row">X</div></th>
                    
    //     '. $barrier_percentile_trigger_5_minute_rolling_candel_sell;
            
    //                         $html .= '</tr>
    //                         <tr class="center show_hide_row">
    //                         <th>15 Minute Rolling Candel (Less Then) From defined percentile<div class="close_row">X</div></th>
                
    //         '. $barrier_percentile_trigger_15_minute_rolling_candel_sell;
            
            
    //         $html .= '</tr>
    //                         <tr class="center show_hide_row">
    //                         <th>(Buyer Should (Less Then) Then Bottom percentile)<div class="close_row">X</div></th>
                            
    //         '. $barrier_percentile_trigger_buyers_sell;
            
            
    //         $html .= '</tr>
    //                         <tr class="center show_hide_row">
    //                         <th>(Sellers Should be (Greater From ) Top percentile)<div class="close_row">X</div></th>
                        
    //         '. $barrier_percentile_trigger_sellers_sell;
            
    //                     $html .= '</tr>
                            
    //                         <tr class="center show_hide_row">
    //                         <th>(15 Minute last time ago Should be Less Then Bottom percentile)(T3 LTC Time)<div class="close_row">X</div></th>
                
    //         '. $barrier_percentile_trigger_15_minute_last_time_ago_sell;
            
            
    //                         $html .= '</tr>
    //                         <tr class="center show_hide_row">
    //                         <th>( (Binance buy) ASk Should be greater from Top percentile) (One minute Rooling candle)<div class="close_row">X</div></th>
                            
    //         '. $barrier_percentile_trigger_ask_sell;
            
            
    //                         $html .= '</tr>
    //                         <tr class="center show_hide_row">
    //                         <th>((Binance Sell)Bid Should be Less Then Bottom percentile) (One minute Rooling candle)<div class="close_row">X</div></th>
                
    //         '. $barrier_percentile_trigger_bid_sell;
            
            
    //                         $html .= '</tr>
    //                         <tr class="center show_hide_row">
    //                         <th>((Digie Buy) Buy Should be greater from Top percentile) (One minute Rooling candle)<div class="close_row">X</div></th>
                                
    //         '. $barrier_percentile_trigger_buy_sell;
            
            
    //                         $html .= '</tr>
    //                         <tr class="center show_hide_row">
    //                         <th>((Digie Sell) Sell Should be Less Then Bottom percentile) (One minute Rooling candle)<div class="close_row">X</div></th>
                                
    //         '. $barrier_percentile_trigger_sell_sell;
            
            
    //                         $html .= '</tr>
    //                         <tr class="center show_hide_row">
    //                         <th>((Big Buyers) Ask Contracts Should be Greater from Top percentile)))<div class="close_row">X</div></th>
                            
    //         '. $barrier_percentile_trigger_ask_contracts_sell;
            
            
    //                         $html .= '</tr>
    //                         <tr class="center show_hide_row">
    //                         <th>((Big Sellers) Bid Contracts Should be Les then Bottom percentile)))<div class="close_row">X</div></th>
                            
    //         '. $barrier_percentile_trigger_bid_contracts_sell;
            
    //         // New Fileds
    //         $html .= '</tr>
    //                         <tr class="center show_hide_row">
    //                         <th>Caption Option<div class="close_row">X</div></th>
                            
    //         '. $percentile_trigger_caption_option_sell;
            
            
    //         $html .= '</tr>
    //                         <tr class="center show_hide_row">
    //                         <th>Caption Score<div class="close_row">X</div></th>
                            
    //         '. $percentile_trigger_caption_score_sell;
            
            
    //         $html .= '</tr>
    //                         <tr class="center show_hide_row">
    //                         <th>Buy<div class="close_row">X</div></th>
                        
    //         '. $percentile_trigger_buy_sell;
            
            
    //         $html .= '</tr>
    //                         <tr class="center show_hide_row">
    //                         <th>Sell<div class="close_row">X</div></th>
                
    //         '. $percentile_trigger_sell_trend_sell;
            
    //         $html .= '</tr>
    //                         <tr class="center show_hide_row">
    //                         <th>Demand<div class="close_row">X</div></th>
                            
    //         '. $percentile_trigger_demand_sell;
            
    //         $html .= '</tr>
    //                         <tr class="center show_hide_row">
    //                         <th>Supply<div class="close_row">X</div></th>
                
    //         '. $percentile_trigger_supply_sell;
            
    //         $html .= '</tr>
    //                         <tr class="center show_hide_row">
    //                         <th>Market Trend<div class="close_row">X</div></th>
                
    //         '. $percentile_trigger_market_trend_sell;
            
    //         $html .= '</tr>
    //                         <tr class="center show_hide_row">
    //                         <th>Meta Tranding<div class="close_row">X</div></th>
                            
    //         '. $percentile_trigger_meta_trading_sell;
            
            
    //         $html .= '</tr>
    //                         <tr class="center show_hide_row">
    //                         <th>Resk per Share<div class="close_row">X</div></th>
                
    //         '. $percentile_trigger_riskpershare_sell;
            
            
    //         $html .= '</tr>
    //                         <tr class="center show_hide_row">
                            
    //                         <th>RL<div class="close_row">X</div></th>
            
    //         '. $percentile_trigger_RL_sell;
            
            
            
            
    //                         $html .= '</tr>
    //                     </tbody>
    //                     </table>
                        
    //                     <!--End of Sell part --> 
    //                 </div>
    //                 <!-- Stop loass Rule ---->
    //                 <div id="stoploss" class="tab-pane fade">
    //                     <table class="table table-bordered zama_th">
    //                     <thead>
    //                         <tr>
    //                         <th class="" style="background:#4267b2; color: #FFF;"> Rule <b>'. $rule .'</b> Of Barrier Percentile</th>';
            
    //         $level_number = $rule;
    //         foreach($rules_set_arr as $row){ 
            
    //         if ($row['trigger_level'] == 'level_'.$level_number ) {
                
    //                         if($row['enable_percentile_trigger_stop_loss']=='yes'){
    //                             $onOff = '<span class="label label-success pull-right">ON</span>';
    //                         }else{
    //                             $onOff = '<span class="label label-danger pull-right">OFF</span>';  
    //                         }
    //                         $html .= ' <th class="center" style="background:#4267b2; color: #FFF;"> '. $row['coin'].'</th>';
    //         } 
    //         }
    //                         $html .= ' </tr>
    //                     </thead>
    //                     <tbody>';
                        
    //         $barrier_percentile_stop_loss_black_wall                                 = '';               
    //         $barrier_percentile_trigger_stop_loss_virtual_barrier                    = '';
    //         $barrier_percentile_trigger_stop_loss_virtual_barrier_bid                = '';
    //         $barrier_percentile_trigger_stop_loss_seven_level_pressure               = '';
    //         $barrier_percentile_trigger_stop_loss_last_200_contracts_buy_vs_sell     = '';
    //         $barrier_percentile_trigger_stop_loss_last_200_contracts_time            = '';
    //         $barrier_percentile_trigger_stop_loss_last_qty_contracts_buyer_vs_seller = '';
    //         $barrier_percentile_trigger_sell_last_qty_contracts_buyer_vs_seller      = '';
    //         $barrier_percentile_trigger_stop_loss_last_qty_contracts_time            = '';
    //         $barrier_percentile_stop_loss_5_minute_rolling_candel_sell               = '';
    //         $barrier_percentile_stop_loss_15_minute_rolling_candel_sell              = '';
    //         $barrier_percentile_trigger_buyers_stop_loss                             = '';
        
    //         $level_number = $rule;
    //         foreach($rules_set_arr as $row){ 
            
    //                 $coin          = $row['coin'];
    //                 $percentil_arr = $this->mod_rulesorder->percentile_coin_meta($coin);
    //                 $percentil     = (array)$percentil_arr[0];
            
    //                 if ($row['trigger_level'] == 'level_'.$level_number ) {
                    
    //                 if ($row['barrier_percentile_stop_loss_black_wall_apply'] == 'yes') {
    //                     $barrier_percentile_stop_loss_black_wall .= '<td> Bottom ' . $row['barrier_percentile_trigger_sell_black_wall'] . ' %
    //                     <span style="font-size:11px;     color: #a03d3d;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ( '.number_format((float)$percentil['sellers_fifteen_b_'.$row['barrier_percentile_trigger_sellers_buy'].''], 2, '.', '').' ) 
    //                     </span></td>';
    //                 } else {
    //                     $barrier_percentile_stop_loss_black_wall .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
    //                 if ($row['barrier_percentile_trigger_stop_loss_virtual_barrier_apply'] == 'yes') {
    //                     $barrier_percentile_trigger_stop_loss_virtual_barrier .= '<td> Bottom ' . $row['barrier_percentile_trigger_stop_loss_virtual_barrier'] .' %
    //                     <span style="font-size:11px;     color: #a03d3d;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ( '.number_format((float)$percentil['sellers_fifteen_b_'.$row['barrier_percentile_trigger_sellers_buy'].''], 2, '.', '').' ) 
    //                     </span></td>';
    //                 } else {
    //                     $barrier_percentile_trigger_stop_loss_virtual_barrier .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
    //                 if ($row['barrier_percentile_trigger_stop_loss_virtual_barrier_bid_apply'] == 'yes') {
    //                     $barrier_percentile_trigger_stop_loss_virtual_barrier_bid .= '<td> Bottom ' . $row['barrier_percentile_trigger_stop_loss_virtual_barrier_bid']. ' %
    //                     <span style="font-size:11px;     color: #a03d3d;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ( '.number_format((float)$percentil['sellers_fifteen_b_'.$row['barrier_percentile_trigger_sellers_buy'].''], 2, '.', '').' ) 
    //                     </span></td>';
    //                 } else {
    //                     $barrier_percentile_trigger_stop_loss_virtual_barrier_bid .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
    //                 if ($row['barrier_percentile_trigger_stop_loss_seven_level_pressure_apply'] == 'yes') {
    //                     $barrier_percentile_trigger_stop_loss_seven_level_pressure .= '<td> Bottom ' . $row['barrier_percentile_trigger_stop_loss_seven_level_pressure'] . ' %
    //                     <span style="font-size:11px;     color: #a03d3d;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ( '.number_format((float)$percentil['sellers_fifteen_b_'.$row['barrier_percentile_trigger_sellers_buy'].''], 2, '.', '').' ) 
    //                     </span></td>';
    //                 } else {
    //                     $barrier_percentile_trigger_stop_loss_seven_level_pressure .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                    
    //                 if ($row['barrier_percentile_trigger_stop_loss_last_200_contracts_buy_vs_sell_apply'] == 'yes') {
    //                     $barrier_percentile_trigger_stop_loss_last_200_contracts_buy_vs_sell .= '<td>' . $row['barrier_percentile_trigger_stop_loss_last_200_contracts_buy_vs_sell'] . '</td>';
    //                 } else {
    //                     $barrier_percentile_trigger_stop_loss_last_200_contracts_buy_vs_sell .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                    
    //                 if ($row['barrier_percentile_trigger_stop_loss_last_200_contracts_time_apply'] == 'yes') {
    //                     $barrier_percentile_trigger_stop_loss_last_200_contracts_time .= '<td>' . $row['barrier_percentile_trigger_stop_loss_last_200_contracts_time'] . '</td>';
    //                 } else {
    //                     $barrier_percentile_trigger_stop_loss_last_200_contracts_time .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                    
    //                 if ($row['barrier_percentile_trigger_stop_loss_last_qty_contracts_buyer_vs_seller_apply'] == 'yes') {
    //                     $barrier_percentile_trigger_stop_loss_last_qty_contracts_buyer_vs_seller .= '<td>' . $row['barrier_percentile_trigger_stop_loss_last_qty_contracts_buyer_vs_seller'] . '</td>';
    //                 } else {
    //                     $barrier_percentile_trigger_stop_loss_last_qty_contracts_buyer_vs_seller .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                    
    //                 if ($row['barrier_percentile_trigger_stop_loss_last_qty_contracts_time_apply'] == 'yes') {
    //                     $barrier_percentile_trigger_stop_loss_last_qty_contracts_time .= '<td> Bottom '  .$row['barrier_percentile_trigger_stop_loss_last_qty_contracts_time'].' %
    //                     <span style="font-size:11px;     color: #a03d3d;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ( '.number_format((float)$percentil['sellers_fifteen_b_'.$row['barrier_percentile_trigger_sellers_buy'].''], 2, '.', '').' ) 
    //                     </span></td>';
    //                 } else {
    //                     $barrier_percentile_trigger_stop_loss_last_qty_contracts_time .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                    
    //                 if ($row['barrier_percentile_stop_loss_5_minute_rolling_candel_sell_apply'] == 'yes') {
    //                     $barrier_percentile_stop_loss_5_minute_rolling_candel_sell .= ' <td class="center"> Bottom ' .  $row['barrier_percentile_stop_loss_5_minute_rolling_candel_sell']. ' %
    //                     <span style="font-size:11px;     color: #a03d3d;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ( '.number_format((float)$percentil['sellers_fifteen_b_'.$row['barrier_percentile_trigger_sellers_buy'].''], 2, '.', '').' ) 
    //                     </span></td>';
    //                 } else {
    //                     $barrier_percentile_stop_loss_5_minute_rolling_candel_sell .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                    
    //                 if ($row['barrier_percentile_stop_loss_15_minute_rolling_candel_sell_apply'] == 'yes') {
    //                     $barrier_percentile_stop_loss_15_minute_rolling_candel_sell .= ' <td class="center"> Bottom ' .  $row['barrier_percentile_stop_loss_15_minute_rolling_candel_sell']. ' %
    //                     <span style="font-size:11px;     color: #a03d3d;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ( '.number_format((float)$percentil['sellers_fifteen_b_'.$row['barrier_percentile_trigger_sellers_buy'].''], 2, '.', '').' ) 
    //                     </span></td>';
    //                 } else {
    //                     $barrier_percentile_stop_loss_15_minute_rolling_candel_sell .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                    
    //                 if ($row['barrier_percentile_trigger_buyers_stop_loss_apply'] == 'yes') {
    //                     $barrier_percentile_trigger_buyers_stop_loss .= ' <td class="center"> Top ' .  $row['barrier_percentile_trigger_buyers_stop_loss']. ' %
    //                     <span style="font-size:11px;     color: #a03d3d;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ( '.number_format((float)$percentil['sellers_fifteen_b_'.$row['barrier_percentile_trigger_sellers_buy'].''], 2, '.', '').' ) 
    //                     </span></td>';
    //                 } else {
    //                     $barrier_percentile_trigger_buyers_stop_loss .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }
                    
                    
    //                 if ($row['barrier_percentile_trigger_sellers_stop_loss_apply'] == 'yes') {
    //                     $barrier_percentile_trigger_sellers_stop_loss .= ' <td class="center"> Top ' . $row['barrier_percentile_trigger_sellers_stop_loss']. ' %
    //                     <span style="font-size:11px;     color: #a03d3d;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ( '.number_format((float)$percentil['sellers_fifteen_b_'.$row['barrier_percentile_trigger_sellers_buy'].''], 2, '.', '').' ) 
    //                     </span></td>';
    //                 } else {
    //                     $barrier_percentile_trigger_sellers_stop_loss .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
    //                 }  
    //             } //$level_number++;
    //         }
    //                     $html .= ' <tr class="center">
    //                         <th style="width:350px; border-right:3px solid #ddd;">Black Wall (Less Then) From defined percentile</th>
                        
    //     '. $barrier_percentile_stop_loss_black_wall;
        
    //                     $html .= ' </tr>
    //                         <tr class="center">
    //                         <th style="width:350px; border-right:3px solid #ddd;">Virtual Barrier (Greater Then) From defined percentile (Ask volume)</th>
                        
    //     '. $barrier_percentile_trigger_stop_loss_virtual_barrier;
        
        
    //                     $html .= '</tr>
    //                         <tr class="center">
    //                         <th style="width:350px; border-right:3px solid #ddd;">(Virtual Barrier Less From defined percentile(Bid Volume))</th>
                        
    //     '. $barrier_percentile_trigger_stop_loss_virtual_barrier_bid;
            
    //                     $html .= ' </tr>
    //                         <tr class="center">
    //                         <th>(Seven Level (Less Then) From defined percentile)</th>
                            
    //         '. $barrier_percentile_trigger_stop_loss_seven_level_pressure;
            
            
    //                     $html .= ' </tr>
    //                         <tr class="center">
    //                         <th>Last 200 Contract Buyers Vs Sellers (Less then Recommended)</th>
                            
    //         '. $barrier_percentile_trigger_stop_loss_last_200_contracts_buy_vs_sell;
            
    //                     $html .= ' </tr>
    //                         <tr class="center">
    //                         <th>Last 200 Contract Time (Less Then Recommended)</th>
                            
    //         '. $barrier_percentile_trigger_stop_loss_last_200_contracts_time;
            
    //                     $html .= '  </tr>
    //                         <tr class="center">
    //                         <th> Last Qty Contract Buyers Vs Sellers(Less Then Recommended)</th>
    //         '. $barrier_percentile_trigger_stop_loss_last_qty_contracts_buyer_vs_seller.' </tr>
    //                         <tr class="center">
    //                         <th>Last qty Contract time(Less then Recommended)</th>
                            
    //     '. $barrier_percentile_trigger_stop_loss_last_qty_contracts_time.'
            
    //                         </tr>
    //                         <tr class="center">
    //                         <th>(5 Minute Rolling Candel (Less Then ) From defined percentile)</th>
                            
    //         '. $barrier_percentile_stop_loss_5_minute_rolling_candel_sell;
            
    //                         $html .= '</tr>
    //                         <tr class="center">
    //                         <th>15 Minute Rolling Candel (Less Then) From defined percentile</th>
                            
    //     '. $barrier_percentile_stop_loss_15_minute_rolling_candel_sell;
    
    //                 $html .= '</tr>
    //                 <tr class="center">
    //                   <th>(Buyer Should (Less Then) Then Bottom percentile)</th>
                     
    //     '. $barrier_percentile_trigger_buyers_stop_loss;
	
	
    //     $html .= '</tr>
    //                     <tr class="center">
    //                     <th>(Sellers Should be (Greater From ) Top percentile)</th>
                        
    //     '. $barrier_percentile_trigger_sellers_stop_loss;
    
    //                $html .= ' </tr>
    //               </tbody>
    //             </table>
    //           </div>
	// 		  <!--End of Stop Loss part --> 
    //         </div>
    //         <!-- // Table END --> 
    //       </div> <div class="clearfix"></div>
    //     </div></div>';
			
	// 	}
		
	// 	/*$html  .= ' <div class="pull-right" style="     background: #4267b2; color: #FFF; padding-top: 6px; margin: 0px; padding: 8px 9px 0px 7px;">
    //       <h4>AVG Profit : '. number_format($avgProfit,2).'%'.'</h4></div>';*/
		
    //     if ($rules_set_arr) {
    //         $json_array['success'] = true;
    //         $json_array['html']    = $html;
    //     } else {
    //         $json_array['success'] = false;
    //         $json_array['html']    = '<strong> Oops ! </strong> No rule found against <b> '.$triggers_type .' </b> please add the rules against the trigger .</div>';
    //     }
    //     echo json_encode($json_array);
    //     exit;
    //  } //End  get_global_rules_ajax
	
	
	//  public function sellbuy_order($rule)
    //  {
    //     //Login Check
    //     $this->mod_login->verify_is_admin_login();
    //     $error = array();
    //     //*************************Pagination Code****************************//
    //     $this->load->library("pagination");
    //     $resultsArrAll                = $this->mod_rulesorder->show_count_all($rule);
    //     $count                        = $resultsArrAll;
    //     $config                       = array();
    //     $config["base_url"]           = SURL . "admin/rules-order/show_order";
    //     $config["total_rows"]         = $count;
    //     $config['per_page']           = 1000;
    //     $config['num_links']          = 3;
    //     $config['use_page_numbers']   = TRUE;
    //     $config['uri_segment']        = 4;
    //     $config['reuse_query_string'] = TRUE;
    //     $config["first_tag_open"]     = '<li>';
    //     $config["first_tag_close"]    = '</li>';
    //     $config["last_tag_open"]      = '<li>';
    //     $config["last_tag_close"]     = '</li>';
    //     $config['next_link']          = '&raquo;';
    //     $config['next_tag_open']      = '<li>';
    //     $config['next_tag_close']     = '</li>';
    //     $config['prev_link']          = '&laquo;';
    //     $config['prev_tag_open']      = '<li>';
    //     $config['prev_tag_close']     = '</li>';
    //     $config['first_link']         = 'First';
    //     $config['last_link']          = 'Last';
    //     $config['full_tag_open']      = '<ul class="pagination">';
    //     $config['full_tag_close']     = '</ul>';
    //     $config['cur_tag_open']       = '<li class="active"><a href="#"><b>';
    //     $config['cur_tag_close']      = '</b></a></li>';
    //     $config['num_tag_open']       = '<li>';
    //     $config['num_tag_close']      = '</li>';
    //     $this->pagination->initialize($config);
    //     $page = $this->uri->segment(4);
    //     if (!isset($page)) {
    //         $page = 1;
    //     }
    //     $start                    = ($page - 1) * $config["per_page"];
    //     //*************************Pagination Code****************************//
    //     $order_arr                = $this->mod_rulesorder->showOrderRecord($start, $config["per_page"], $rule);
    //     $page_links               = $this->pagination->create_links();
    //     // Data To be send
    //     $data['rules_orders_arr'] = $order_arr;
    //     $data['count']            = $count;
    //     $data['error']            = $ErrorInOrder;
    //     $data['page_links']       = $page_links;
    //     //echo "<prE>"; print_r($order_arr); exit;
    //     $this->stencil->paint('admin/rules_order/show_rules_order_listing', $data);
    // }////echo "<prE>";  print_r($order_Array);

	// public function exportOrderCsv($parentOrderId='5bea657dfc9aad7b647999f2'){
		
    //      $childOrderArr  = $this->mod_rulesorder->child_buy_order($parentOrderId);
		
	// 	 foreach($childOrderArr as $key =>$row){	 
	// 	    $childOrderID   = $row->_id; 
	// 	    $order_Array    = $this->mod_rulesorder->getOrderLog($childOrderID,$parentOrderId);
			
	// 		if($order_Array!=''){
	// 		  $order_Array  = array_filter($order_Array);	
	// 		  $order_ArrayNew[]  = $order_Array;
	// 		}
	// 	 }// Foreachloop
         	
	// 		 if($order_ArrayNew){	   
	// 				$filename = ("orderID :".$parentOrderId . date("Y-m-d Gis") . ".csv");
	// 				// Set the Headers for csv 
	// 				$now = gmdate("D, d M Y H:i:s");
	// 				header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
	// 				header("Last-Modified: {$now} GMT");
	// 				header('Content-Type: text/csv;');
	// 				header("Pragma: no-cache");
	// 				header("Expires: 0");
	// 				// force download
	// 				header("Content-Type: application/force-download");
	// 				header("Content-Type: application/octet-stream");
	// 				header("Content-Type: application/download");
					
	// 				// disposition / encoding on response body
	// 				header("Content-Disposition: attachment;filename={$filename}");
	// 				header("Content-Transfer-Encoding: binary");
	// 	            echo $this->array2csv($order_ArrayNew);
	// 		 }//if($order_Array){	
	//    exit;
	// }//exportParentOrderCsv
	
	// public function orders_history(){
		
		          
    //     $connect = $this->mongo_db->customQuery();
    //     $sort    = array('$sort' => array('hour' => -1));
    //     $limit   = array('$limit' => 10000);
        
    //     $record_of_rules_for_orders = $connect->record_of_rules_for_orders->aggregate(array( $sort, $limit));
    //     $rulesSet_arr    = iterator_to_array($record_of_rules_for_orders);
    //     //echo "<pre>";print_r($rulesSet_arr); exit;	
		
	// 	$global_symbol         = $this->session->userdata('global_symbol');
	// 	$testing               = $this->input->get('testing');
	// 	$global_mode           = 'live';
	// 	//$global_mode         = $this->session->userdata('global_mode');
	// 	$trigger_type          = 'barrier_trigger';	
    //     $rule_numbernn         = 5;
	// 	$responseArr           = getAvgProfitLoss($global_symbol,$rule_numbernn,$trigger_type);
	// 	//$responseArr = iterator_to_array($cursor);
	// 	echo "<pre>";print_r($responseArr); exit;
	// 	//$data  = getAvgProfitLoss( $start_date, $end_date, $status);
		
		
	// 	$resultsArrAll                           = $this->mod_rulesorder->orders_history(); 
		
    //     $data['record_of_rules_for_orders_type'] = $resultsArrAll['record_of_rules_for_orders_type'];
    //     $data['record_of_rules_for_orders_rule'] = $resultsArrAll['record_of_rules_for_orders_rule'];
		
	// 	echo "<prE>";  print_r($data['record_of_rules_for_orders_rule'] ); exit;
		
    //     $this->stencil->paint('admin/rules_order/orders_history', $data);
    // }
	
	// public function array2csv($array) {
		
	// 	if (count($array) == 0) {
	// 		return null;
	// 	}
	// 	ob_start();
	// 	$df = fopen("php://output", 'w');
	// 	fputcsv($df, array_keys((array) reset($array)));

	// 	foreach ($array as $key => $row) {
	// 		  //$rowNew  =  htmlspecialchars(trim(strip_tags($row))); 
	// 		  fputcsv($df, (array) $row);
	// 	}
	// 	fclose($df);
	// 	return ob_get_clean();
	// }//array2csv
	
	//   public function Test($idnam)
    // {
		
		
	// 	exit;
	
	//     $db = $this->mongo_db->customQuery();
    //     $id =  $this->mongo_db->mongoId($idnam);
    //     $where = array('_id'=>$id);
       
    //     $response = $db->trigger_global_setting->deleteOne($where);

    //     echo '<pre>';
    //     print_r($response);
    //     exit;
	
	
	// }

}