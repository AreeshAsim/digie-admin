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
        if ($this->session->userdata('user_role') != 1) {
            //redirect(base_url() . 'forbidden');
        }
    }
    public function listing()
    {
        $resultsArrAll                           = $this->mod_rulesorder->rulesOrderRecord();
        $data['record_of_rules_for_orders_type'] = $resultsArrAll['record_of_rules_for_orders_type'];
        $data['record_of_rules_for_orders_rule'] = $resultsArrAll['record_of_rules_for_orders_rule'];
		
        $this->stencil->paint('admin/rules_order/rules_order_listing', $data);
    }
	
	
	public function orders_history()
    {
		
		          
	$connect = $this->mongo_db->customQuery();
	$sort    = array('$sort' => array('hour' => -1));
	$limit   = array('$limit' => 10000);
	
	$record_of_rules_for_orders = $connect->record_of_rules_for_orders->aggregate(array( $sort, $limit));
	$rulesSet_arr    = iterator_to_array($record_of_rules_for_orders);
	//echo "<pre>";print_r($rulesSet_arr); exit;	
		
		$global_symbol         = $this->session->userdata('global_symbol');
		$testing               = $this->input->get('testing');
		$global_mode           = 'live';
		//$global_mode         = $this->session->userdata('global_mode');
		$trigger_type          = 'barrier_trigger';	
        $rule_numbernn         = 5;
		$responseArr  = getAvgProfitLoss($global_symbol,$rule_numbernn,$trigger_type);
		//$responseArr = iterator_to_array($cursor);
		echo "<pre>";print_r($responseArr); exit;
		//$data  = getAvgProfitLoss( $start_date, $end_date, $status);
		
		
		$resultsArrAll                           = $this->mod_rulesorder->orders_history(); 
		
        $data['record_of_rules_for_orders_type'] = $resultsArrAll['record_of_rules_for_orders_type'];
        $data['record_of_rules_for_orders_rule'] = $resultsArrAll['record_of_rules_for_orders_rule'];
		
		echo "<prE>";  print_r($data['record_of_rules_for_orders_rule'] ); exit;
		
        $this->stencil->paint('admin/rules_order/orders_history', $data);
    }
	
    public function show_order($rule)
    {
        //Login Check
        $this->mod_login->verify_is_admin_login();
        $error = array();
        //*************************Pagination Code****************************//
        $this->load->library("pagination");
        $resultsArrAll                = $this->mod_rulesorder->show_count_all($rule);
        $count                        = $resultsArrAll;
        $config                       = array();
        $config["base_url"]           = SURL . "admin/rules-order/show_order";
        $config["total_rows"]         = $count;
        $config['per_page']           = 1000;
        $config['num_links']          = 3;
        $config['use_page_numbers']   = TRUE;
        $config['uri_segment']        = 4;
        $config['reuse_query_string'] = TRUE;
        $config["first_tag_open"]     = '<li>';
        $config["first_tag_close"]    = '</li>';
        $config["last_tag_open"]      = '<li>';
        $config["last_tag_close"]     = '</li>';
        $config['next_link']          = '&raquo;';
        $config['next_tag_open']      = '<li>';
        $config['next_tag_close']     = '</li>';
        $config['prev_link']          = '&laquo;';
        $config['prev_tag_open']      = '<li>';
        $config['prev_tag_close']     = '</li>';
        $config['first_link']         = 'First';
        $config['last_link']          = 'Last';
        $config['full_tag_open']      = '<ul class="pagination">';
        $config['full_tag_close']     = '</ul>';
        $config['cur_tag_open']       = '<li class="active"><a href="#"><b>';
        $config['cur_tag_close']      = '</b></a></li>';
        $config['num_tag_open']       = '<li>';
        $config['num_tag_close']      = '</li>';
        $this->pagination->initialize($config);
        $page = $this->uri->segment(4);
        if (!isset($page)) { $page = 1;}
        $start                    = ($page - 1) * $config["per_page"];
        //*************************Pagination Code****************************//
        $order_arr                = $this->mod_rulesorder->showOrderRecord($start, $config["per_page"], $rule);
        $page_links               = $this->pagination->create_links();
        // Data To be send
        $data['rules_orders_arr'] = $order_arr;
        $data['count']            = $count;
        $data['error']            = $ErrorInOrder;
        $data['page_links']       = $page_links;
        //echo "<prE>"; print_r($order_arr); exit;
        $this->stencil->paint('admin/rules_order/show_rules_order_listing', $data);
    }
    public function rule_set()
    {
        $global_symbol         = $this->session->userdata('global_symbol');
        $global_mode           = 'live';
	    $resultsArrAll         = $this->mod_rulesorder->rulesSet($global_symbol, $global_mode);
        $data['rules_set_arr'] = $resultsArrAll;
		
        $this->stencil->paint('admin/rules_order/rules_set', $data);
    }
	
	public function grid_rules()
    {
	   
		$global_symbol         = $this->session->userdata('global_symbol');
		$testing               = $this->input->get('testing');
		$global_mode           = 'live';
		$trigger_type          = 'barrier_trigger';	
        
		$getAllCoin            = $this->mod_rulesorder->getAllCoin();
		$resultsArrAll         = $this->mod_rulesorder->box_trigger($global_symbol, $global_mode ,$trigger_type);
	
		$data['coinArrList']   = $getAllCoin;
		// Testing section goes here 
		$data['testing']       = $testing;
		$data['avgProfit']     = $avgProfit;
        $data['rules_set_arr'] = $resultsArrAll;
		$data['global_symbol'] = $global_symbol;
		$data['trigger_type']  = $trigger_type;
		
		
        $this->stencil->paint('admin/rules_order/boxtrigger', $data);
    }
	
	public function get_all_orders($user_id, $start_date, $end_date, $status) {
		//Check Filter Data
		$session_post_data = $filter_array;
		$search_array = array('admin_id' => $user_id);
		//$search_array = array('admin_id'=> $admin_id);
		if ($start_date != "" && $end_date != "") {

			$created_datetime = date('Y-m-d G:i:s', strtotime($start_date));
			$orig_date = new DateTime($created_datetime);
			$orig_date = $orig_date->getTimestamp();
			$start_date1 = new MongoDB\BSON\UTCDateTime($orig_date * 1000);

			$created_datetime22 = date('Y-m-d G:i:s', strtotime($end_date));
			$orig_date22 = new DateTime($created_datetime22);
			$orig_date22 = $orig_date22->getTimestamp();
			$end_date1 = new MongoDB\BSON\UTCDateTime($orig_date22 * 1000);
			$search_array['created_date'] = array('$gte' => $start_date1, '$lte' => $end_date1);
		}

		$connetct = $this->mongo_db->customQuery();

		if ($status == 'open' || $status == 'sold') {
			if ($status == 'open') {

				$search_array['status'] = 'FILLED';
				$search_array['is_sell_order'] = 'yes';
				$cursor = $connetct->buy_orders->find($search_array);

			} elseif ($status == 'sold') {

				$search_array['status'] = 'FILLED';
				$search_array['is_sell_order'] = 'sold';
				$cursor = $connetct->buy_orders->find($search_array);

			}
		} elseif ($status == 'all') {
			$search_array['status'] = array('$in' => array('error', 'canceled', 'submitted'));
			$cursor = $connetct->buy_orders->find($search_array);

		} else {

			$search_array['status'] = $status;
			$cursor = $connetct->buy_orders->find($search_array);

		}
		$responseArr = iterator_to_array($cursor);

		$fullarray = array();
		foreach ($responseArr as $valueArr) {

			$returArr = array();
			$profit = 0;
			if (!empty($valueArr)) {

				$datetime = $valueArr['created_date']->toDateTime();
				$created_date = $datetime->format(DATE_RSS);

				$datetime = new DateTime($created_date);
				$datetime->format('Y-m-d g:i:s A');

				$new_timezone = new DateTimeZone('Asia/Karachi');
				$datetime->setTimezone($new_timezone);
				$formated_date_time = $datetime->format('Y-m-d g:i:s A');

				$returArr['id'] = (string) $valueArr['_id'];
				$returArr['purchased_price'] = $valueArr['market_value'];
				$returArr['sold_price'] = $valueArr['market_sold_price'];
				$profit = ((($returArr['sold_price'] - $returArr['purchased_price']) / $returArr['purchased_price']) * 100);
				$returArr['profit_loss_percentage'] = number_format($profit, 2);
				$returArr['coin'] = $valueArr['symbol'];
				$returArr['quantity'] = $valueArr['quantity'];
				$returArr['order_type'] = $valueArr['order_type'];
				if ($valueArr['status'] == 'FILLED' && $valueArr['is_sell_order'] == 'yes') {
					$returArr['status'] = 'open';
				}
				if ($valueArr['status'] == 'FILLED' && $valueArr['is_sell_order'] == 'sold') {
					$returArr['status'] = 'sold';
				}
				$returArr['user_id'] = $valueArr['admin_id'];
				$returArr['created_date'] = $formated_date_time;

			}

			$fullarray[] = $returArr;
		}
		return $fullarray;

	}
	
	 public function get_rulesOrderProfit_ajax()
     {
        $order_mode    = $this->input->post('order_mode');
        $coin          = $this->input->post('coin');
		$triggers_type = $this->input->post('triggers_type');
		$userID        = $this->input->post('userID');
		$start_date    = $this->input->post('start_date');
		$end_date      = $this->input->post('end_date');
		
        $rulesOrderProfitLoss_arr = $this->mod_rulesorder->rulesOrderProfitLoss($coin, $order_mode,$triggers_type,$userID,$start_date,$end_date);
		
        if ($rulesOrderProfitLoss_arr) {
            $json_array['success'] = true;
            $json_array['html']    = $html;
        } else {
            $json_array['success'] = false;
            $json_array['html']    = '<div class="alert alert-danger"> No rule found here.</div>';
        }
        echo json_encode($json_array);
        exit;
    } //End  get_rulesOrderProfit_ajax
	
	
	 public function get_global_boxtrigger_ajax()
     {
        $order_mode    = $this->input->post('order_mode');
        $coin          = $this->input->post('coin');
		$triggers_type = $this->input->post('triggers_type');
		
        $rules_set_arr = $this->mod_rulesorder->box_trigger($coin, $order_mode,$triggers_type);
		
		
		$html  = '';	
		if($triggers_type=='trigger_1'){
				$html .= ' <div class="triggercls trg_trigger_1" >
				 <table class="table table-bordered table-condensed table-striped table-primary table-vertical-center checkboxs">
						<thead>
						  <tr>
							<th class="center" style="background:#4267b2"></th>
							<th class="center" style="background:#4267b2"></th>
							
						  </tr>  
						</thead>
						<tbody>';
						
			$cancel                         = '';
			$look_back_hour                 = '';
			$bottom_demand_rejection        = '';
			$bottom_supply_rejection        = '';
			$check_high_open                = '';
			$is_previous_blue_candle        = '';
			$aggressive_stop_rule           = '';
			$apply_factor                   = '';
			$buy_virtural_rule_             = '';

			if ($rules_set_arr['cancel_trade'] == 'cancel') {
				$cancel .= '<td>' .'<span class="label label-success">YES</span>' . '</td>';
				$look_back_hour .= '<td>' . $rules_set_arr['look_back_hour'] . '</td>';
			} else {
				$cancel .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
				$look_back_hour .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
			}
			
		
			if($rules_set_arr['aggressive_stop_rule']=='stop_loss_rule_1') {
			   $aggressive_stop_rule .= '<td>' .'<span class="label label-success">S L R 1</span>' . '</td>';	
			}else if($rules_set_arr['aggressive_stop_rule']=='stop_loss_rule_2') {
			   $aggressive_stop_rule .= '<td>' .'<span class="label label-success">S L R 2</span>' . '</td>';		
			}else if($rules_set_arr['aggressive_stop_rule']=='stop_loss_rule_3') {
			   $aggressive_stop_rule .= '<td>' .'<span class="label label-success">S L R 3</span>' . '</td>';	 		
			}else if($rules_set_arr['aggressive_stop_rule']=='stop_loss_rule_big_wall') {
				$aggressive_stop_rule .= '<td>' .'<span class="label label-success">S L R B W</span>' . '</td>';	
			}else{
                $aggressive_stop_rule .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
            }
			
			
			if ($rules_set_arr['buy_virtual_barrier_rule_' . $rule_numbernn . '_enable'] == 'yes') {
				$buy_virtural_rule_ .= '<td>' . $rules_set_arr['buy_virtural_rule_' . $rule_numbernn . ''] . '</td>';
			} else {
				$buy_virtural_rule_ .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
			}
			
			
			$apply_factor .= '<td>' . $rules_set_arr['apply_factor'] . '</td>';
			   
			if ($rules_set_arr['bottom_demand_rejection'] == 'yes') {
				$bottom_demand_rejection .= '<td>' .'<span class="label label-success">YES</span>' . '</td>';
			} else {
				$bottom_demand_rejection .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
			}
			
			if ($rules_set_arr['bottom_supply_rejection'] == 'yes') {
				$bottom_supply_rejection .= '<td>' .'<span class="label label-success">YES</span>' . '</td>';
			} else {
				$bottom_supply_rejection .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
			}
		
			if ($rules_set_arr['check_high_open'] == 'yes') {
				$check_high_open .= '<td>' .'<span class="label label-success">YES</span>' . '</td>';
			} else {
				$check_high_open .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
			}
			
			
			if ($rules_set_arr['is_previous_blue_candle'] == 'yes') {
				$is_previous_blue_candle .= '<td>' .'<span class="label label-success">YES</span>' . '</td>';
			} else {
				$is_previous_blue_candle .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
			}
			
	$html .= '   <tr class="center">
							<th>Cancel Trade</th>
							
				
		'. $cancel.'';
		
		
		$html .= '  <tr class="center">
                    <th>Aggressive stop rule</th>
                    
                 
'. $aggressive_stop_rule .'

                 </tr>
				 
				   <tr class="center">
                    <th>Trigger Rule</th>
                  
' . $buy_trigger_type_ruleAll . '

                 
                  </tr>';
				 
				 
				 
				 
					$html .= '   <tr class="center">
                    <th>Stop loss factor</th>
                    
                   '. $apply_factor .'
                 </tr>';
		
					    $html .= '	 </tr>
						  
						 
						  <tr class="center">
							<th>look back hour to cancel trade</th>
						
		'. $look_back_hour.'
		
						 
						  </tr>
						 
						 
						  <tr class="center">
							<th>Bottom Demand Rejection</th>
				
		'. $bottom_demand_rejection.'
					 
						  </tr>
						  <tr class="center">
							<th>Bottom Supply Rejection</th>
							
						   
		'. $bottom_supply_rejection.'
		
						 </tr>
						  <tr class="center">
							<th> Check Heigh Open</th>
							'. $check_high_open.'
						  </tr>
						  
						  
						  
						  <tr class="center">
							<th>is_previous_blue_candle</th>
						
		'. $is_previous_blue_candle.'

						 </tr>
						 
						
						</tbody>
					  </table>
				 </div> ';
		}else if($triggers_type=='trigger_2'){
				$html .= ' <div class="triggercls trg_trigger_2" >
				 <table class="table table-bordered table-condensed table-striped table-primary table-vertical-center checkboxs">
						<thead>
						  <tr>
							<th class="center" style="background:#4267b2"></th>
							<th class="center" style="background:#4267b2"></th>
							
						  </tr>  
						</thead>
						<tbody>';
						
$cancel                 = '';
$look_back_hour          = '';
$bottom_demand_rejection         = '';
$bottom_supply_rejection        = '';
$check_high_open       = '';
$is_previous_blue_candle            = '';
$aggressive_stop_rule            = '';

$apply_factor   ='';



        if ($rules_set_arr['cancel_trade'] == 'cancel') {
            $cancel .= '<td>' .'<span class="label label-success">YES</span>' . '</td>';
			$look_back_hour .= '<td>' . $rules_set_arr['look_back_hour'] . '</td>';
        } else {
            $cancel .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
			 $look_back_hour .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
        }
		
		
			if($rules_set_arr['aggressive_stop_rule']=='stop_loss_rule_1') {
			   $aggressive_stop_rule .= '<td>' .'<span class="label label-success">S L R 1</span>' . '</td>';	
			}else if($rules_set_arr['aggressive_stop_rule']=='stop_loss_rule_2') {
			   $aggressive_stop_rule .= '<td>' .'<span class="label label-success">S L R 2</span>' . '</td>';		
			}else if($rules_set_arr['aggressive_stop_rule']=='stop_loss_rule_3') {
			   $aggressive_stop_rule .= '<td>' .'<span class="label label-success">S L R 3</span>' . '</td>';	 		
			}else if($rules_set_arr['aggressive_stop_rule']=='stop_loss_rule_big_wall') {
				$aggressive_stop_rule .= '<td>' .'<span class="label label-success">S L R B W</span>' . '</td>';	
			}else{
                $aggressive_stop_rule .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
            }
		
		
		$apply_factor .= '<td>' . $rules_set_arr['apply_factor'] . '</td>';
           
      
		
		
        if ($rules_set_arr['bottom_demand_rejection'] == 'yes') {
            $bottom_demand_rejection .= '<td>' .'<span class="label label-success">YES</span>' . '</td>';
        } else {
            $bottom_demand_rejection .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
        }
		
		 if ($rules_set_arr['bottom_supply_rejection'] == 'yes') {
            $bottom_supply_rejection .= '<td>' .'<span class="label label-success">YES</span>' . '</td>';
        } else {
            $bottom_supply_rejection .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
        }
		
		
		
		
        if ($rules_set_arr['check_high_open'] == 'yes') {
            $check_high_open .= '<td>' .'<span class="label label-success">YES</span>' . '</td>';
        } else {
            $check_high_open .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
        }
		
		
        if ($rules_set_arr['is_previous_blue_candle'] == 'yes') {
            $is_previous_blue_candle .= '<td>' .'<span class="label label-success">YES</span>' . '</td>';
        } else {
            $is_previous_blue_candle .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
        }
				
	
					  
						
						
						$html .= '   <tr class="center">
							<th>Cancel Trade</th>
							
				
		'. $cancel.'';
		
		
		$html .= '  <tr class="center">
                    <th>Aggressive stop rule</th>
                    
                 
'. $aggressive_stop_rule .'

                 </tr>';
				 
				 
					$html .= '   <tr class="center">
                    <th>Stop loss factor</th>
                    
                   '. $apply_factor .'
                 </tr>';
		
					    $html .= '	 </tr>
						  
						 
						  <tr class="center">
							<th>look back hour to cancel trade</th>
						
		'. $look_back_hour.'
		
						 
						  </tr>
						 
						 
						  <tr class="center">
							<th>Bottom Demand Rejection</th>
				
		'. $bottom_demand_rejection.'
					 
						  </tr>
						  <tr class="center">
							<th>Bottom Supply Rejection</th>
							
						   
		'. $bottom_supply_rejection.'
		
						 </tr>
						  <tr class="center">
							<th> Check Heigh Open</th>
							'. $check_high_open.'
						  </tr>
						  
						  
						  
						  <tr class="center">
							<th>is_previous_blue_candle</th>
						
		'. $is_previous_blue_candle.'

						 </tr>
						 
						
						</tbody>
					  </table>
				 </div> ';
		}else if($triggers_type=='box_trigger_3'){
				$html .= ' <div class="triggercls trg_box_trigger_3" >
				 <table class="table table-bordered table-condensed table-striped table-primary table-vertical-center checkboxs">
						<thead>
						  <tr>
							<th class="center" style="background:#4267b2"></th>
							<th class="center" style="background:#4267b2"></th>
							
						  </tr>  
						</thead>
						<tbody>';
						
		$cancel                 = '';
$look_back_hour          = '';
$bottom_demand_rejection         = '';
$bottom_supply_rejection        = '';
$check_high_open       = '';
$is_previous_blue_candle            = '';
$aggressive_stop_rule            = '';

$apply_factor   ='';



        if ($rules_set_arr['cancel_trade'] == 'cancel') {
            $cancel .= '<td>' .'<span class="label label-success">YES</span>' . '</td>';
			$look_back_hour .= '<td>' . $rules_set_arr['look_back_hour'] . '</td>';
        } else {
            $cancel .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
			 $look_back_hour .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
        }
		
		
			if($rules_set_arr['aggressive_stop_rule']=='stop_loss_rule_1') {
			   $aggressive_stop_rule .= '<td>' .'<span class="label label-success">S L R 1</span>' . '</td>';	
			}else if($rules_set_arr['aggressive_stop_rule']=='stop_loss_rule_2') {
			   $aggressive_stop_rule .= '<td>' .'<span class="label label-success">S L R 2</span>' . '</td>';		
			}else if($rules_set_arr['aggressive_stop_rule']=='stop_loss_rule_3') {
			   $aggressive_stop_rule .= '<td>' .'<span class="label label-success">S L R 3</span>' . '</td>';	 		
			}else if($rules_set_arr['aggressive_stop_rule']=='stop_loss_rule_big_wall') {
				$aggressive_stop_rule .= '<td>' .'<span class="label label-success">S L R B W</span>' . '</td>';	
			}else{
                $aggressive_stop_rule .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
            }
		
		
		$apply_factor .= '<td>' . $rules_set_arr['apply_factor'] . '</td>';
           
      
		
		
        if ($rules_set_arr['bottom_demand_rejection'] == 'yes') {
            $bottom_demand_rejection .= '<td>' .'<span class="label label-success">YES</span>' . '</td>';
        } else {
            $bottom_demand_rejection .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
        }
		
		 if ($rules_set_arr['bottom_supply_rejection'] == 'yes') {
            $bottom_supply_rejection .= '<td>' .'<span class="label label-success">YES</span>' . '</td>';
        } else {
            $bottom_supply_rejection .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
        }
		
		
		
		
        if ($rules_set_arr['check_high_open'] == 'yes') {
            $check_high_open .= '<td>' .'<span class="label label-success">YES</span>' . '</td>';
        } else {
            $check_high_open .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
        }
		
		
        if ($rules_set_arr['is_previous_blue_candle'] == 'yes') {
            $is_previous_blue_candle .= '<td>' .'<span class="label label-success">YES</span>' . '</td>';
        } else {
            $is_previous_blue_candle .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
        }
				
	
					  
						
						
						$html .= '   <tr class="center">
							<th>Cancel Trade</th>
							
				
		'. $cancel.'';
		
		
		$html .= '  <tr class="center">
                    <th>Aggressive stop rule</th>
                    
                 
'. $aggressive_stop_rule .'

                 </tr>';
				 
				 
					$html .= '   <tr class="center">
                    <th>Stop loss factor</th>
                    
                   '. $apply_factor .'
                 </tr>';
		
					    $html .= '	 </tr>
						  
						 
						  <tr class="center">
							<th>look back hour to cancel trade</th>
						
		'. $look_back_hour.'
		
						 
						  </tr>
						 
						 
						  <tr class="center">
							<th>Bottom Demand Rejection</th>
				
		'. $bottom_demand_rejection.'
					 
						  </tr>
						  <tr class="center">
							<th>Bottom Supply Rejection</th>
							
						   
		'. $bottom_supply_rejection.'
		
						 </tr>
						  <tr class="center">
							<th> Check Heigh Open</th>
							'. $check_high_open.'
						  </tr>
						  
						  
						  
						  <tr class="center">
							<th>is_previous_blue_candle</th>
						
		'. $is_previous_blue_candle.'

						 </tr>
						 
						
						</tbody>
					  </table>
				 </div> ';
		}else if($triggers_type=='barrier_trigger'){
		
		
	
	  
	  if($rules_set_arr->aggressive_stop_rule=='stop_loss_rule_1'){
		  $aggressive_stop_ruleA  =  'Stop Loss Rule One';
	  }else if($rules_set_arr->aggressive_stop_rule=='stop_loss_rule_2'){
		  $aggressive_stop_ruleA  =  'Stop Loss Rule Two'; 
	  }else if($rules_set_arr->aggressive_stop_rule=='stop_loss_rule_3'){
		  $aggressive_stop_ruleA  =  'Stop Loss Rule Three';    
	  }else if($rules_set_arr->aggressive_stop_rule=='stop_loss_rule_big_wall'){
	      $aggressive_stop_ruleA  =  'Stop Loss Rule Big Wall';    
	  }
		
		
		$html .= '  <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#buy">Buy Rules</a></li>
            <li><a data-toggle="tab" href="#sell">Sell Rules</a></li>
          </ul>
          <div class="tab-content ">';
        
        $html .= ' <div id="buy" class="tab-pane fade in active">
		
		
		 <table class="table table-bordered">
  <thead>
    <tr>
      <th scope="col" style="background:#4267b2; color: #FFF;">Aggressive Stop Rule</th>
      <th scope="col" style="background:#4267b2; color: #FFF;">Buy Range %</th>
      <th scope="col" style="background:#4267b2; color: #FFF;">Deep % For Active</th>
      <th scope="col" style="background:#4267b2; color: #FFF;">Initial Stop Loss</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td class="centre">
	   '. $aggressive_stop_ruleA .'</td>
      <td class="centre">'. $rules_set_arr->buy_range_percet .' %'.'</td>
      <td class="centre">'. $rules_set_arr->sell_profit_percet .' %'.'</td>
      <td class="centre">'. $rules_set_arr->stop_loss_percet.'</td>
    </tr>
    
  </tbody>
</table> 
		     
              <table class="table table-bordered table-condensed table-striped table-primary table-vertical-center checkboxs">
                <thead>
                  <tr>
                    <th class="" style="background:#4267b2">'. $coin .'</th>';
					
        for ($rule_number = 1; $rule_number <= 10; $rule_number++) {
            if ($rules_set_arr['enable_buy_rule_no_' . $rule_number . ''] == 'yes') {
                $html .= '<th class="center" style="background:#4267b2">' . $rule_number . '</th>';
            }
        }
        $html .= ' </tr></thead><tbody>';
		
        $buy_status_rule_                 = '';
        $big_seller_percent_compare_rule_ = '';
        $closest_black_wall_rule_         = '';
        $closest_yellow_wall_rule_        = '';
        $seven_level_pressure_rule_       = '';
        $buyer_vs_seller_rule_            = '';
        $last_candle_type                 = '';
        $rejection_candle_type            = '';
        $last_200_contracts_buy_vs_sell   = '';
        $last_200_contracts_time          = '';
        $last_qty_buyers_vs_seller        = '';
        $last_qty_time                    = '';
        $score                            = '';
        $comment                          = '';
		$buy_trigger_type_ruleAll         = '';
		$last_candle_status               = '';
		
        for ($rule_numbernn = 1; $rule_numbernn <= 10; $rule_numbernn++) {
            if ($rules_set_arr['enable_buy_rule_no_' . $rule_numbernn . ''] == 'yes') {
				
				
				 $buyrulerecordAll = '';
            foreach ($rules_set_arr['buy_order_level_' . $rule_numbernn] as $buyrulerecord) {
				
				if ($buyrulerecord == 'level_1') {
                    $value1 = '<span class="label label-warning">L 1</span>';
                } else if ($buyrulerecord == 'level_2') {
                    $value1 = '<span class="label label-warning">L 2</span>';
                } else if ($buyrulerecord == 'level_3') {
                    $value1 = '<span class="label label-warning">L 3</span>';
				} else if ($buyrulerecord == 'level_4') {
                    $value1 = '<span class="label label-warning">L 4</span>';
				} else if ($buyrulerecord == 'level_5') {
                    $value1 = '<span class="label label-warning">L 5</span>'; 
				} else if ($buyrulerecord == 'level_6') {
                    $value1 = '<span class="label label-warning">L 6</span>';
				} 

				
                $buyrulerecordAll .= '&nbsp;' . $value1;
            }
				
                $rulerecordaaa = '';
				if ($rules_set_arr['buy_status_rule_' . $rule_numbernn . '_enable'] == 'yes') {
                 foreach ($rules_set_arr['buy_status_rule_' . $rule_numbernn . ''] as $rulerecord) {
                    $rulerecordaaa .= '&nbsp' . $rulerecord;
                 }
				}
				$buy_trigger_type_rule ='';
                foreach ($rules_set_arr['buy_trigger_type_rule_' . $rule_numbernn . ''] as $rulerecord) {
                    if ($rulerecord == 'very_strong_barrier') {
                        $value = '<span class="label label-success">VSB</span>';
                    } else if ($rulerecord == 'weak_barrier') {
                        $value = '<span class="label label-warning">WB</span>';
                    } else if ($rulerecord == 'strong_barrier') {
                        $value = '<span class="label label-info">SB</span>';
                    }
                    $buy_trigger_type_rule .= '&nbsp' . $value;
                }
				
				if ($rules_set_arr['buyer_vs_seller_rule_' . $rule_numbernn . '_buy_enable'] == 'yes') {
					$buyer_vs_seller_rule .= '<td>' . $rules_set_arr['buyer_vs_seller_rule_' . $rule_numbernn . '_buy'] . '</td>';
				} else {
					$buyer_vs_seller_rule .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
				}
				
				if ($rules_set_arr['buy_order_level_' . $rule_numbernn . '_enable'] == 'yes') {
					$buy_order_level .= '<td>' . $buyrulerecordAll . '</td>';
				} else {
					$buy_order_level .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
				}
				
				
				if ($rules_set_arr['done_pressure_rule_' . $rule_numbernn . '_buy_enable'] == 'yes') {
					$done_pressure_rulebuy .= '<td>' . $rules_set_arr['done_pressure_rule_' . $rule_numbernn . '_buy'] . '</td>';
				} else {
					$done_pressure_rulebuy .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
				}
		
				if ($rules_set_arr['buy_virtual_barrier_rule_' . $rule_numbernn . '_enable'] == 'yes') {
					$buy_virtural_rule_ .= '<td>' . number_format($rules_set_arr['buy_virtural_rule_' . $rule_numbernn . '']) . '</td>';
				} else {
					$buy_virtural_rule_ .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
				}
		
                if ($rules_set_arr['buy_status_rule_' . $rule_numbernn . '_enable'] == 'yes') {
                    $buy_status_rule_ .= '<td>' . $rulerecordaaa . '</td>';
                } else {
                    $buy_status_rule_ .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
                }
                if ($rules_set_arr['buy_trigger_type_rule_' . $rule_numbernn . '_enable'] == 'yes') {
                    $buy_trigger_type_ruleAll .= '<td>' . $buy_trigger_type_rule . '</td>';
                } else {
                    $buy_trigger_type_ruleAll .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
                }
                if ($rules_set_arr['buy_check_volume_rule_' . $rule_numbernn . ''] == 'yes') {
                    $buy_volume_rule_ .= '<td>' . number_format($rules_set_arr['buy_volume_rule_' . $rule_numbernn . '']) . '</td>';
                } else {
                    $buy_volume_rule_ .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
                }
                if ($rules_set_arr['buy_trigger_type_rule_' . $rule_numbernn . '_enable'] == 'yes') {
                    $buy_trigger_type_ruleArr .= '<td>' . $buy_trigger_type_rule . '</td>';
                } else {
                    $buy_trigger_type_ruleArr .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
                }
                if ($rules_set_arr['big_seller_percent_compare_rule_' . $rule_numbernn . '_buy_enable'] == 'yes') {
                    $big_seller_percent_compare_rule_ .= ' <td class="center">' . $rules_set_arr['big_seller_percent_compare_rule_' . $rule_numbernn . '_buy'] . ' %' . '</td>';
                } else {
                    $big_seller_percent_compare_rule_ .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
                }
                if ($rules_set_arr['closest_black_wall_rule_' . $rule_numbernn . '_buy_enable'] == 'yes') {
                    $closest_black_wall_rule_ .= ' <td class="center">' . $rules_set_arr['closest_black_wall_rule_' . $rule_numbernn . '_buy'] . '</td>';
                } else {
                    $closest_black_wall_rule_ .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
                }
                if ($rules_set_arr['closest_yellow_wall_rule_' . $rule_numbernn . '_buy_enable'] == 'yes') {
                    $closest_yellow_wall_rule_ .= '<td>' . $rules_set_arr['closest_yellow_wall_rule_' . $rule_numbernn . '_buy'] . '</td>';
                } else {
                    $closest_yellow_wall_rule_ .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
                }
                if ($rules_set_arr['seven_level_pressure_rule_' . $rule_numbernn . '_buy_enable'] == 'yes') {
                    $seven_level_pressure_rule_ .= '<td>' . $rules_set_arr['seven_level_pressure_rule_' . $rule_numbernn . '_buy'] . '</td>';
                } else {
                    $seven_level_pressure_rule_ .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
                }
                if ($rules_set_arr['buy_last_candle_type' . $rule_numbernn . '_enable'] == 'yes') {
                    $last_candle_type .= '<td>' . $rules_set_arr['last_candle_type' . $rule_numbernn . '_buy'] . '</td>';
                } else {
                    $last_candle_type .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
                }
                if ($rules_set_arr['buy_rejection_candle_type8' . $rule_numbernn . '_enable'] == 'yes') {
                    $rejection_candle_type .= '<td>' . $rules_set_arr['rejection_candle_type' . $rule_numbernn . '_buy'] . '</td>';
                } else {
                    $rejection_candle_type .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
                }
                if ($rules_set_arr['buy_last_200_contracts_buy_vs_sell' . $rule_numbernn . '_enable'] == 'yes') {
                    $last_200_contracts_buy_vs_sell .= '<td>' . $rules_set_arr['last_200_contracts_buy_vs_sell' . $rule_numbernn . '_buy'] . '</td>';
                } else {
                    $last_200_contracts_buy_vs_sell .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
                }
                if ($rules_set_arr['buy_last_200_contracts_time' . $rule_numbernn . '_enable'] == 'yes') {
                    $last_200_contracts_time .= '<td>' . $rules_set_arr['last_200_contracts_time' . $rule_numbernn . '_buy'] . '</td>';
                } else {
                    $last_200_contracts_time .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
                }
                if ($rules_set_arr['buy_last_qty_buyers_vs_seller' . $rule_numbernn . '_enable'] == 'yes') {
                    $last_qty_buyers_vs_seller .= '<td>' . $rules_set_arr['last_qty_buyers_vs_seller' . $rule_numbernn . '_buy'] . '</td>';
                } else {
                    $last_qty_buyers_vs_seller .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
                }
                if ($rules_set_arr['buy_last_qty_time' . $rule_numbernn . '_enable'] == 'yes') {
                    $last_qty_time .= '<td>' . $rules_set_arr['last_qty_time' . $rule_numbernn . '_buy'] . '</td>';
                } else {
                    $last_qty_time .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
                }
                if ($rules_set_arr['buy_score' . $rule_numbernn . '_enable'] == 'yes') {
                    $score .= '<td>' . $rules_set_arr['score' . $rule_numbernn . '_buy'] . '</td>';
                } else {
                    $score .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
                }
                if ($rules_set_arr['comment' . $rule_numbernn . '_buy_enable'] == 'yes') {
                    $comment .= '<td>' . $rules_set_arr['comment' . $rule_numbernn . '_buy'] . '</td>';
                } else {
                    $comment .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
                }
				if ($rules_set_arr['buy_last_candle_status' . $rule_numbernn . '_enable'] == 'yes') {
					$last_candle_status .= '<td>' . ucfirst($rules_set_arr['last_candle_status' . $rule_numbernn . '_buy']) . '</td>';
				} else {
					$last_candle_status .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
				}
            }
        }
        $html .= ' <tr class="center">
                    <th>Status</th>
                    
                
' . $buy_status_rule_ . '
                 </tr>
                  
                  <tr class="center">
                    <th>Trigger Rule</th>
' . $buy_trigger_type_ruleAll . '
                  </tr>
				  
                   <tr class="center">
                    <th>(Virtual Order Book Barrier Range)</th>
                 
'. $buy_virtural_rule_.'
                 
                  </tr>
				  
				   <tr class="center">
                    <th>(If Volume greater then the defined value)</th>
                    
' . $buy_volume_rule_. '

                 </tr>
				
                 <tr class="center">
                    <th> Down pressure ( Down pressure is Greater or equal to the defined pressure)</th>
                   '. $done_pressure_rulebuy .'
                  </tr>';
				  
				  
				  
        $html .= '<tr class="center">
                    <th>Big Buyers % ( percent greater then the defined %)</th>
                  
' . $big_seller_percent_compare_rule_ . '' . '</tr>
                  <tr class="center">
                    <th>Closest black wall( Greater then or equal to the defined value)</th>
                   
' . $closest_black_wall_rule_ . '

                 </tr>
                  <tr class="center">
                    <th>Closest yellow wall (Greater then or equal to the defined value)</th>
                    
' . $closest_yellow_wall_rule_ . '

                 </tr>
                  <tr class="center">
                    <th>Seven level pressue (Greater then or equal to the defined value)</th>
                     
' . $seven_level_pressure_rule_ . '

                 </tr>
                  <tr class="center">
                    <th>Buys vs Seller</th>
              
' . $buyer_vs_seller_rule . '
                 </tr>
                  <tr class="center">
                    <th>Last Candle Type</th>
                   
' . $last_candle_type . '

                 </tr>
                  <tr class="center">
                    <th>Rejection Candle Type</th>
                   
' . $rejection_candle_type . '

                 </tr>
                  <tr class="center">
                    <th>Last 200 Contract Buyers Vs Sellers</th>
                   
' . $last_200_contracts_buy_vs_sell . '

                 </tr>
                  <tr class="center">
                    <th>Last 200 Contract Time(Less then)</th>
                    
' . $last_200_contracts_time . '

                 </tr>
                  <tr class="center">
                    <th>Last qty Contract Buyes Vs seller</th>
                   
' . $last_qty_buyers_vs_seller . '

                 </tr>
                  <tr class="center">
                    <th>Last qty Contract time(Less then)</th>
                 
' . $last_qty_time . '

                 </tr>
                  <tr class="center">
                    <th>Score</th>
                    
' . $score . '
                 </tr>
                  
                  <tr class="center">
                    <th>Comment</th>
                   
' . $comment . '

                 </tr>
				 
				 
				 <tr class="center">
                      <th>Order Level</th>
                     
     '.$buy_order_level.'
    
                    </tr>
					
					
					  <tr class="center">
                      <th>Last Candle Status</th>
                  '.
     $last_candle_status.'
                    </tr>
                    
                </tbody>
              </table>
             
            </div>';
			
        $html .= '  <div id="sell" class="tab-pane fade">
             
              <table class="table table-bordered table-condensed table-striped table-primary table-vertical-center checkboxs">
                <thead>
                  <tr>
                    <th class="" style="background:#4267b2; color:white;">'. $coin .'</th>';
        for ($rule_number = 1; $rule_number <= 10; $rule_number++) {
            if ($rules_set_arr['enable_sell_rule_no_' . $rule_number . ''] == 'yes') {
                $html .= '<th class="center" style="background:#4267b2">
        ' . $rule_number;
                $html .= '</th>';
            }
        }
        $html .= ' </tr>
                </thead>
                <tbody>';
        $buy_status_rule_sell             = '';
        $big_seller_percent_compare_rule_ = '';
        $closest_black_wall_rule_         = '';
        $closest_yellow_wall_rule_        = '';
        $seven_level_pressure_rule_       = '';
        $buyer_vs_seller_rule_            = '';
        $last_candle_type                 = '';
        $rejection_candle_type            = '';
        $last_200_contracts_buy_vs_sell   = '';
        $last_200_contracts_time          = '';
        $last_qty_buyers_vs_seller        = '';
        $last_qty_time                    = '';
        $score                            = '';
        $comment                          = '';
		$sell_virtural_rule_              = '';
		//$avgProfit_All                    = '';
		
        for ($rule_numbernn = 1; $rule_numbernn <= 10; $rule_numbernn++) {
			
            if ($rules_set_arr['enable_sell_rule_no_' . $rule_numbernn . ''] == 'yes') {
				
				
				
			$sell_order_level = '';
			foreach ($rules_set_arr['sell_order_level_' . $rule_numbernn . ''] as $rulerecordOrderlevel) {
				
				if ($rulerecordOrderlevel == 'level_1') {
					$value1 = '<span class="label label-warning">L 1</span>';
				} else if ($rulerecordOrderlevel == 'level_2') {
					$value1 = '<span class="label label-warning">L 2</span>';
				} else if ($rulerecordOrderlevel == 'level_3') {
					$value1 = '<span class="label label-warning">L 3</span>';
				} else if ($rulerecordOrderlevel == 'level_4') {
					$value1 = '<span class="label label-warning">L 4</span>';
				} else if ($rulerecordOrderlevel == 'level_5') {
					$value1 = '<span class="label label-warning">L 5</span>'; 
				} else if ($rulerecordOrderlevel == 'level_6') {
					$value1 = '<span class="label label-warning">L 6</span>';
				} 
				$sell_order_level .= '&nbsp;' . $value1;
			}
		
			$rulerecordsell = '';
			foreach ($rules_set_arr['sell_status_rule_' . $rule_numbernn . ''] as $rulerecord) {
				$rulerecordsell .= '&nbsp;' . $rulerecord;
			}
			$sell_trigger_type_rule = '';
			if ($rules_set_arr['sell_trigger_type_rule_' . $rule_numbernn . '_enable'] == 'yes') {
				foreach ($rules_set_arr['sell_trigger_type_rule_' . $rule_numbernn . ''] as $rulerecord) {
					if ($rulerecord == 'very_strong_barrier') {
						$value = '<span class="label label-success">VSB</span>';
					} else if ($rulerecord == 'weak_barrier') {
						$value = '<span class="label label-warning">WB</span>';
					} else if ($rulerecord == 'strong_barrier') {
						$value = '<span class="label label-info">SB</span>';
					}
					$sell_trigger_type_rule .= '&nbsp;' . $value;
				}
			}
			
			if ($rules_set_arr['sell_order_level_' . $rule_numbernn . '_enable'] == 'yes') {
                $sell_order_levelAll .= '<td>' . $sell_order_level . '</td>';
            } else {
                $sell_order_levelAll .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
            }
				
				if ($rules_set_arr['done_pressure_rule_' . $rule_numbernn . '_enable'] == 'yes') {
					$done_pressure_rule .= '<td>' . $rules_set_arr['done_pressure_rule_' . $rule_numbernn . ''] . '</td>';
				} else {
					$done_pressure_rule .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
				}
				if ($rules_set_arr['sell_virtual_barrier_rule_' . $rule_numbernn . '_enable'] == 'yes') {
				    $sell_virtural_rule_ .= '<td>' . number_format($rules_set_arr['sell_virtural_rule_' . $rule_numbernn . '']) . '</td>';
				} else {
				    $sell_virtural_rule_ .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
				}
				
                if ($rules_set_arr['sell_status_rule_' . $rule_numbernn . '_enable'] == 'yes') {
                    $sell_status_rule .= '<td>' . $rulerecordsell . '</td>';
                } else {
                    $sell_status_rule .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
                }
                if ($rules_set_arr['sell_check_volume_rule_' . $rule_numbernn . ''] == 'yes') {
                    $sell_volume_rule_ .= '<td>' . number_format($rules_set_arr['sell_volume_rule_' . $rule_numbernn . '']) . '</td>';
                } else {
                    $sell_volume_rule_ .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
                }
                if ($rules_set_arr['sell_trigger_type_rule_' . $rule_numbernn . '_enable'] == 'yes') {
                    $sell_trigger_type_ruleArr .= '<td>' . $sell_trigger_type_rule . '</td>';
                } else {
                    $sell_trigger_type_ruleArr .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
                }
				
				if ($rules_set_arr['big_seller_percent_compare_rule_' . $rule_numbernn . '_enable'] == 'yes') {
					$big_seller_percent_compare_rule_sell .= ' <td class="center">' . $rules_set_arr['big_seller_percent_compare_rule_' . $rule_numbernn . ''] . ' %' . '</td>';
				} else {
					$big_seller_percent_compare_rule_sell .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
				}
				
                if ($rules_set_arr['closest_black_wall_rule_' . $rule_numbernn . '_enable'] == 'yes') {
                    $closest_black_wall_rule_sell .= ' <td class="center">' . $rules_set_arr['closest_black_wall_rule_' . $rule_numbernn . ''] . '</td>';
                } else {
                    $closest_black_wall_rule_sell .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
                }
                if ($rules_set_arr['sell_percent_rule_' . $rule_numbernn . '_enable'] == 'yes') {
                    $sell_percent_rule .= ' <td class="center">' . $rules_set_arr['sell_percent_rule_' . $rule_numbernn . ''] . '</td>';
                } else {
                    $sell_percent_rule .= ' <td class="center">' . '<span class="label label-danger">OFF</span>' . '</td>';
                }
                if ($rules_set_arr['closest_yellow_wall_rule_' . $rule_numbernn . '_enable'] == 'yes') {
                    $closest_yellow_wall_rule_sell .= '<td>' . $rules_set_arr['closest_yellow_wall_rule_' . $rule_numbernn . ''] . '</td>';
                } else {
                    $closest_yellow_wall_rule_sell .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
                }
                if ($rules_set_arr['seven_level_pressure_rule_' . $rule_numbernn . '_enable'] == 'yes') {
                    $seven_level_pressure_rule_sell .= '<td>' . $rules_set_arr['seven_level_pressure_rule_' . $rule_numbernn . ''] . '</td>';
                } else {
                    $seven_level_pressure_rule_sell .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
                }
                if ($rules_set_arr['sell_last_candle_type' . $rule_numbernn . '_enable'] == 'yes') {
                    $last_candle_type_sell .= '<td>' . $rules_set_arr['last_candle_type' . $rule_numbernn . ''] . '</td>';
                } else {
                    $last_candle_type_sell .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
                }
				
                
				if ($rules_set_arr['sell_rejection_candle_type' . $rule_numbernn . '_enable'] == 'yes') {
			
			    if($rules_set_arr['rejection_candle_type' . $rule_numbernn . '_sell'] =='top_supply_rejection'){
				  $rejection_candle_type_sell .= '<td>' .  '<span class="label label-warning">T S R</span>'. '</td>';	 
				}else{
				  $rejection_candle_type_sell .= '<td>' . $rules_set_arr['rejection_candle_type' . $rule_numbernn . '_sell'] . '</td>';
				}
            
				} else {
					$rejection_candle_type_sell .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
				}
				
				
                if ($rules_set_arr['seller_vs_buyer_rule_' . $rule_numbernn . '_sell_enable'] == 'yes') {
                    $seller_vs_buyer_rule .= '<td>' . $rules_set_arr['seller_vs_buyer_rule_' . $rule_numbernn . '_sell'] . '</td>';
                } else {
                    $seller_vs_buyer_rule .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
                }
                if ($rules_set_arr['sell_last_200_contracts_buy_vs_sell' . $rule_numbernn . '_enable'] == 'yes') {
                    $last_200_contracts_buy_vs_sell .= '<td>' . $rules_set_arr['last_200_contracts_buy_vs_sell' . $rule_numbernn . '_sell'] . '</td>';
                } else {
                    $last_200_contracts_buy_vs_sell .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
                }
                if ($rules_set_arr['sell_last_200_contracts_time' . $rule_numbernn . '_enable'] == 'yes') {
                    $last_200_contracts_time_sell .= '<td>' . $rules_set_arr['last_200_contracts_time' . $rule_numbernn . '_sell'] . '</td>';
                } else {
                    $last_200_contracts_time_sell .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
                }
                if ($rules_set_arr['sell_last_qty_buyers_vs_seller' . $rule_numbernn . '_enable'] == 'yes') {
                    $sell_last_qty_buyers_vs_seller .= '<td>' . $rules_set_arr['last_qty_buyers_vs_seller' . $rule_numbernn . '_sell'] . '</td>';
                } else {
                    $sell_last_qty_buyers_vs_seller .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
                }
                if ($rules_set_arr['sell_last_qty_time' . $rule_numbernn . '_enable'] == 'yes') {
                    $last_qty_time_sell .= '<td>' . $rules_set_arr['last_qty_time' . $rule_numbernn . '_sell'] . '</td>';
                } else {
                    $last_qty_time_sell .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
                }
                if ($rules_set_arr['sell_score' . $rule_numbernn . '_enable'] == 'yes') {
                    $score_sell .= '<td>' . $rules_set_arr['score' . $rule_numbernn . '_sell'] . '</td>';
                } else {
                    $score_sell .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
                }
                if ($rules_set_arr['sell_comment' . $rule_numbernn . '_enable'] == 'yes') {
                    $comment_sell .= '<td>' . $rules_set_arr['comment' . $rule_numbernn . '_sell'] . '</td>';
                } else {
                    $comment_sell .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
                }
				
				if ($rules_set_arr['sell_last_candle_status' . $rule_numbernn . '_enable'] == 'yes') {
					$last_candle_status_sell .= '<td>' . ucfirst($rules_set_arr['last_candle_status' . $rule_numbernn . '_sell']) . '</td>';
				} else {
					$last_candle_status_sell .= '<td>' . '<span class="label label-danger">OFF</span>' . '</td>';
				}
				
				
				
			    $coin         = $this->input->post('coin');
			    $triggers_type   =  $this->input->post('triggers_type');
				$testing   =  $this->input->post('testing');
			  
			  if ($_SERVER['REMOTE_ADDR'] == '101.50.127.90') {
			     /*echo  'coin '.$coin ;
				 echo  'triggers_type '.$triggers_type ;
				 echo "</br>";
				 echo $testing;
				 exit;*/
			  }
			   
              if($testing!='' && $testing=='testing'){
				 $avgProfit  = '';
				 $htmlData   = '';
				 $responseArr  = getAvgProfitLoss($coin,$rule_numbernn,$triggers_type);
				 
				 if($responseArr['avg_profit']!=''){
				   $avgProfitAll .= '<td>' . number_format($responseArr['avg_profit'],2).' %' . '</td>';
				 }else{
				   $avgProfitAll .= '<td>' . '<span class="label label-warning">No Profit</span>' . '</td>';	 
				 }
				 $htmlData     ='<tr class="center" style="background:#4267b2; color:#FFF; "><th>Avg Profit</th> '. $avgProfitAll.'</tr>';	 
				 
				 if($responseArr['total_sold_orders']!=''){
				   $totalSoldOrder .= '<td>' . ($responseArr['total_sold_orders']) . '</td>';
				 }else{
				   $totalSoldOrder .= '<td>' . '<span class="label label-warning">No Order</span>' . '</td>';	 
				 }
				 $htmlDataSoldOrder ='<tr class="center" style="background:#4267b2; color:#FFF; "><th style="    background: #4267b2;color: #FFF;">Total Sold Order</th> '. $totalSoldOrder.'</tr>';	 
			 }
            }
        }
        $html .= '<tr class="center">
                    <th>Status</th>' . $sell_status_rule . '

                 </tr>
                  
                   <tr class="center">
                    <th>Trigger Rule</th>
                 
 ' . $sell_trigger_type_ruleArr . '

                  </tr>
				  
				   <tr class="center">
                    <th>(Virtual Order Book Barrier Range)</th>
             
'. $sell_virtural_rule_.'
                 
                  </tr>
                  
                  <tr class="center">
                    <th>(If Volume greater then the defined value)</th>
                    
               
 ' . $sell_volume_rule_ . '

                 </tr>
                 <tr class="center">
                    <th> Down pressure (Sell: Down pressure is Less or equal to the defined pressure)</th>
                    '. $done_pressure_rule .'
                  </tr>
                  <tr class="center">
                    <th>Big Sellers % ( percent greater then the defined %)</th>
                   
 ' . $big_seller_percent_compare_rule_sell . '

                 </tr>
                  <tr class="center">
                    <th>Closest black wall( Greater then or equal to the defined value)</th>
                
 ' . $closest_black_wall_rule_sell . '

                 </tr>
                  <tr class="center">
                    <th>Closest yellow wall (Greater then or equal to the defined value)</th>
                   
 ' . $closest_yellow_wall_rule_sell . '

                 </tr>
                  <tr class="center">
                    <th>Seven level pressue (Greater then or equal to the defined value)</th>
                     
 ' . $seven_level_pressure_rule_sell . '

                 </tr>
                  
                  <tr class="center">
                    <th> Sell % (when we sell the order we check if the defined percenage is meet)</th>
                     
 ' . $sell_percent_rule . '

                 </tr>
                 
                  <tr class="center">
                    <th> Seller vs Buys</th>
                   
 ' . $seller_vs_buyer_rule . '

                 </tr>
                  <tr class="center">
                    <th>Last Candle Type</th>
                   
 ' . $last_candle_type_sell . '

                 </tr>
                  <tr class="center">
                    <th>Rejection Candle Type</th>
                
 ' . $rejection_candle_type_sell . '

                 </tr>
                  <tr class="center">
                    <th>Last 200 Contract Sellers Vs Buyers</th>
               
' . $last_200_contracts_buy_vs_sell . '

                 </tr>
                  <tr class="center">
                    <th>Last 200 Contract Time(Less then)</th>
                     
 ' . $last_200_contracts_time_sell . '

                 </tr>
                  <tr class="center">
                    <th>Last qty Contract seller Vs Buyes</th>
                    
 ' . $sell_last_qty_buyers_vs_seller . '

                 </tr>
                  <tr class="center">
                    <th>Last qty Contract time(Less then)</th>
                   
 ' . $last_qty_time_sell . '

                 </tr>
                  <tr class="center">
                    <th>Score</th>
                    
 ' . $score_sell . '

                 </tr>
                  
                  <tr class="center">
                    <th>Comment</th>
                  
 ' . $comment_sell . '

                 </tr>
				 
				  <tr class="center">
                      <th>Order Level</th>
                      
    '. $sell_order_levelAll.'
                    </tr>
					
					  <tr class="center">
                      <th>Last Candle Status</th>
              '.
     $last_candle_status_sell.'
                    </tr>
                    
				  '.$htmlData.'
				  '.$htmlDataSoldOrder.'
				 
                </tbody>
              </table>
               
              <!--End of Sell part --> 
            </div></div>';
		}
		
		/*$html  .= ' <div class="pull-right" style="     background: #4267b2; color: #FFF; padding-top: 6px; margin: 0px; padding: 8px 9px 0px 7px;">
          <h4>AVG Profit : '. number_format($avgProfit,2).'%'.'</h4></div>';*/
		
        if ($rules_set_arr) {
            $json_array['success'] = true;
            $json_array['html']    = $html;
        } else {
            $json_array['success'] = false;
            $json_array['html']    = '<div class="alert alert-danger"> No rule found here.</div>';
        }
        echo json_encode($json_array);
        exit;
    } //End  get_global_trigger_setting_ajax
	
	
	 public function sellbuy_order($rule)
     {
        //Login Check
        $this->mod_login->verify_is_admin_login();
        $error = array();
        //*************************Pagination Code****************************//
        $this->load->library("pagination");
        $resultsArrAll                = $this->mod_rulesorder->show_count_all($rule);
        $count                        = $resultsArrAll;
        $config                       = array();
        $config["base_url"]           = SURL . "admin/rules-order/show_order";
        $config["total_rows"]         = $count;
        $config['per_page']           = 1000;
        $config['num_links']          = 3;
        $config['use_page_numbers']   = TRUE;
        $config['uri_segment']        = 4;
        $config['reuse_query_string'] = TRUE;
        $config["first_tag_open"]     = '<li>';
        $config["first_tag_close"]    = '</li>';
        $config["last_tag_open"]      = '<li>';
        $config["last_tag_close"]     = '</li>';
        $config['next_link']          = '&raquo;';
        $config['next_tag_open']      = '<li>';
        $config['next_tag_close']     = '</li>';
        $config['prev_link']          = '&laquo;';
        $config['prev_tag_open']      = '<li>';
        $config['prev_tag_close']     = '</li>';
        $config['first_link']         = 'First';
        $config['last_link']          = 'Last';
        $config['full_tag_open']      = '<ul class="pagination">';
        $config['full_tag_close']     = '</ul>';
        $config['cur_tag_open']       = '<li class="active"><a href="#"><b>';
        $config['cur_tag_close']      = '</b></a></li>';
        $config['num_tag_open']       = '<li>';
        $config['num_tag_close']      = '</li>';
        $this->pagination->initialize($config);
        $page = $this->uri->segment(4);
        if (!isset($page)) {
            $page = 1;
        }
        $start                    = ($page - 1) * $config["per_page"];
        //*************************Pagination Code****************************//
        $order_arr                = $this->mod_rulesorder->showOrderRecord($start, $config["per_page"], $rule);
        $page_links               = $this->pagination->create_links();
        // Data To be send
        $data['rules_orders_arr'] = $order_arr;
        $data['count']            = $count;
        $data['error']            = $ErrorInOrder;
        $data['page_links']       = $page_links;
        //echo "<prE>"; print_r($order_arr); exit;
        $this->stencil->paint('admin/rules_order/show_rules_order_listing', $data);
    }////echo "<prE>";  print_r($order_Array);
	public function exportOrderCsv($parentOrderId='5bea657dfc9aad7b647999f2'){
		
		 $childOrderArr  = $this->mod_rulesorder->child_buy_order($parentOrderId);
		 
		 foreach($childOrderArr as $key =>$row){
			 
		    $childOrderID   = $row->_id; 
		    $order_Array    = $this->mod_rulesorder->getOrderLog($childOrderID,$parentOrderId);
			if($order_Array!=''){
			  $order_Array  = array_filter($order_Array);	
			  $order_ArrayNew[]  = $order_Array;
			}
		 }// Foreachloop
		 	 
			 if($order_ArrayNew){	   
					$filename = ("orderID :".$parentOrderId . date("Y-m-d Gis") . ".csv");
					// Set the Headers for csv 
					$now = gmdate("D, d M Y H:i:s");
					header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
					header("Last-Modified: {$now} GMT");
					header('Content-Type: text/csv;');
					header("Pragma: no-cache");
					header("Expires: 0");
					// force download
					header("Content-Type: application/force-download");
					header("Content-Type: application/octet-stream");
					header("Content-Type: application/download");
					
					// disposition / encoding on response body
					header("Content-Disposition: attachment;filename={$filename}");
					header("Content-Transfer-Encoding: binary");
		            echo $this->array2csv($order_ArrayNew);
			 }//if($order_Array){	
	   exit;
	}//exportParentOrderCsv
	
	public function array2csv($array) {
		
		if (count($array) == 0) {
			return null;
		}
		ob_start();
		$df = fopen("php://output", 'w');
		fputcsv($df, array_keys((array) reset($array)));

		foreach ($array as $key => $row) {
			  //$rowNew  =  htmlspecialchars(trim(strip_tags($row))); 
			  fputcsv($df, (array) $row);
		}
		fclose($df);
		return ob_get_clean();
	}//array2csv

	
    public function dropTable($table)
    {
        if ($table != '') {
            $get_data = $this->mongo_db->drop_collection($table);
            if ($get_data) {
                echo $table;
                exit;
            }
        }
    } //dropTable
}