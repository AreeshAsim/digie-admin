<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Buy_orders extends CI_Controller
{
	
	function __construct()
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
		$this->load->model('admin/mod_users');
		$this->load->model('admin/mod_dashboard');
		$this->load->model('admin/mod_market');
		$this->load->model('admin/mod_coins');
		$this->load->model('admin/mod_buy_orders');

	}

	public function index()
	{
		
		//Login Check
		$this->mod_login->verify_is_admin_login();


		if($this->input->post()){
			
		 	$data_arr['filter-data-buy'] = $this->input->post();
			$this->session->set_userdata($data_arr);
			redirect(base_url().'admin/buy_orders/');
		}
		$filled_orders = array();
		$new_orders = array();
		$error_orders = array();
		$cancelled = array();
		$submitted = array();
		$open_trades = array();
		$sold_trades = array();
		$return_data = $this->mod_buy_orders->get_buy_orders();

		$orders_arr = $return_data['fullarray'];
		// echo "<pre>";
		// print_r($orders_arr);
		// exit;
		$data['total_buy_amount'] = $return_data['total_buy_amount'];
		$data['total_sell_amount'] = $return_data['total_sell_amount'];
		$data['total_sold_orders'] = $return_data['total_sold_orders'];
		$data['avg_profit'] = $return_data['avg_profit'];


		foreach ($orders_arr as $key => $value) {
			if ($value['status'] == 'new') {
				$new_orders[] = $value; 
			}
			elseif ($value['status'] == 'FILLED') {
				if ($value['is_sell_order'] =='yes') {
					$open_trades[] = $value;
				}
				if ($value['is_sell_order'] =='sold') {
					$sold_trades[] = $value;
				}

				$filled_orders[] = $value;

			}
			elseif ($value['status'] == 'canceled') {
				$cancelled[] = $value;
			}
			elseif ($value['status'] == 'error') {
				$error_orders[] = $value;
			}
			elseif ($value['status'] == 'submitted') {
				$submitted[] = $value;
				$open_trades[] = $value;
			}
		}

		// echo "<pre>";
		// print_r($open_trades);
		// exit;
		$data['orders_arr'] = $orders_arr;
		$data['filled_arr'] = $filled_orders;
		$data['new_arr'] = $new_orders;
		$data['cancelled_arr'] = $cancelled;
		$data['error_arr'] = $error_orders;
		$data['submitted'] = $submitted;
		$data['open_trades'] = $open_trades;
		$data['sold_trades'] = $sold_trades;

		$id = $this->session->userdata('admin_id');
		$global_symbol = $this->session->userdata('global_symbol');
		//Fetching coins Record
		$coins_arr = $this->mod_coins->get_all_user_coins($id);
		$data['coins_arr'] = $coins_arr;

		//Get Market Price
		$this->mongo_db->where(array('coin'=> $global_symbol));
		$this->mongo_db->limit(1);
		$this->mongo_db->sort(array('_id'=> 'desc'));
		$responseArr = $this->mongo_db->get('market_prices');

		foreach ($responseArr as  $valueArr) {
			if(!empty($valueArr)){
				$market_value = $valueArr['price'];
			}
		}

		$data['market_value'] = $market_value;

		//stencil is our templating library. Simply call view via it
		$this->stencil->paint('admin/buy_order/buy_orders_listing',$data);
	}


	public function add_buy_order()
	{
		//Login Check
		$this->mod_login->verify_is_admin_login();

		$user_id = $this->session->userdata('admin_id');
		$global_symbol = $this->session->userdata('global_symbol');

		//Fetching coins Record
		$coins_arr = $this->mod_coins->get_all_user_coins($user_id);
		$data['coins_arr'] = $coins_arr;

		//Get Market Value
		$market_value = $this->mod_dashboard->get_market_value();
		$data['market_value'] = $market_value;

		//Check Buy Zones
		$check_buy_zones = $this->mod_dashboard->check_buy_zones($market_value);
		$data['in_zone'] = $check_buy_zones['in_zone'];
		$data['type'] = $check_buy_zones['type'];
		$data['start_value'] = $check_buy_zones['start_value'];
		$data['end_value'] = $check_buy_zones['end_value'];
		

		$keywords_str = $this->mod_market->get_coin_keywords($global_symbol);
		$keywords = explode(',', $keywords_str);
		$news = $this->mod_market->get_coin_news($keywords);
		$data['news'] = $news;

		//stencil is our templating library. Simply call view via it
		$this->stencil->paint('admin/buy_order/add_buy_order', $data);

	}//end add_buy_order


	public function add_buy_order_process(){
		
		//Login Check
		$this->mod_login->verify_is_admin_login();
		
		//add_buy_order
		$add_buy_order = $this->mod_dashboard->add_buy_order($this->input->post());
		 
		if($add_buy_order['error'] !=""){

			$this->session->set_flashdata('err_message', $add_buy_order['error']);
			redirect(base_url().'admin/buy_orders/add-buy-order');
		}
		
		if($add_buy_order){		
			
			$this->session->set_flashdata('ok_message', 'Buy Order added successfully.');
			redirect(base_url().'admin/buy_orders/add-buy-order');
			
		}else{
				
			$this->session->set_flashdata('err_message', 'Something went wrong, please try again.');
			redirect(base_url().'admin/buy_orders/add-buy-order');
			
		}//end if

	}//end add_buy_order_process


	public function edit_buy_order($id)
	{
		//Login Check
		$this->mod_login->verify_is_admin_login();

		$user_id = $this->session->userdata('admin_id');
		$global_symbol = $this->session->userdata('global_symbol');

		
		//Fetching coins Record
		$coins_arr = $this->mod_coins->get_all_user_coins($user_id);
		$data['coins_arr'] = $coins_arr;
		

		//Get Market Value
		$market_value = $this->mod_dashboard->get_market_value();
		$data['market_value'] = $market_value;

		//Check Buy Zones
		$check_buy_zones = $this->mod_dashboard->check_buy_zones($market_value);
		$data['in_zone'] = $check_buy_zones['in_zone'];
		$data['type'] = $check_buy_zones['type'];
		$data['start_value'] = $check_buy_zones['start_value'];
		$data['end_value'] = $check_buy_zones['end_value'];
		
		$keywords_str = $this->mod_market->get_coin_keywords($global_symbol);
		$keywords = explode(',', $keywords_str);
		$news = $this->mod_market->get_coin_news($keywords);
		$data['news'] = $news;
		//Get Order Record
		$order_arr = $this->mod_buy_orders->get_buy_order($id);
		$data['order_arr'] = $order_arr;

		//Get Temp Sell Order Record
		$temp_sell_arr = $this->mod_dashboard->get_temp_sell_data($id);
		$data['temp_sell_arr'] = $temp_sell_arr;


		//Get Order History
		$order_history_arr = $this->mod_dashboard->get_order_history_log($id);
		$data['order_history_arr'] = $order_history_arr;


		//stencil is our templating library. Simply call view via it
		$this->stencil->paint('admin/buy_order/edit_buy_order',$data);

	}//end edit_buy_order


	public function edit_buy_order_process(){
		
		//Login Check
		$this->mod_login->verify_is_admin_login();
		
		//edit_buy_order
		$edit_buy_order = $this->mod_dashboard->edit_buy_order($this->input->post());

		$id = $this->input->post('id');

		if($edit_buy_order['error'] !=""){

			$this->session->set_flashdata('err_message', $add_buy_order['error']);
			redirect(base_url().'admin/buy_orders/edit-buy-order/'.$id);
		}
		
		if($edit_buy_order){		
			
			$this->session->set_flashdata('ok_message', 'Edit Order updated successfully.');
			redirect(base_url().'admin/buy_orders/edit-buy-order/'.$id);
			
		}else{
				
			$this->session->set_flashdata('err_message', 'Something went wrong, please try again.');
			redirect(base_url().'admin/buy_orders/edit-buy-order/'.$id);
			
		}//end if

	}//end edit_buy_order_process


	public function delete_buy_order($id,$order_id){
		
		//Login Check
		$this->mod_login->verify_is_admin_login();
		
		//delete_buy_order
		$delete_buy_order = $this->mod_dashboard->delete_buy_order($id,$order_id);

		if($delete_buy_order){		
			
			$this->session->set_flashdata('ok_message', 'Record deleted successfully.');
			redirect(base_url().'admin/buy_orders');
			
		}else{
				
			$this->session->set_flashdata('err_message', 'Something went wrong, please try again.');
			redirect(base_url().'admin/buy_orders');
			
		}//end if

	}//end delete_buy_order
	

	public function get_order_ajax()
	{
		$this->load->library("pagination");

		$old_status = $this->input->get('status');
		
		if ($old_status == 'filled') {
			$status = 'FILLED';
			$count = $this->mod_buy_orders->count_by_status($status);
		}

		elseif ($old_status == 'new') {
			$status = 'new';
			$count = $this->mod_buy_orders->count_by_status($status);
		}

		elseif ($old_status == 'submitted') {
			$status = 'submitted';
			$count = $this->mod_buy_orders->count_by_status($status);
		}

		elseif ($old_status == 'cancelled') {
			$status = 'canceled';
			$count = $this->mod_buy_orders->count_by_status($status);
		}

		elseif ($old_status == 'error') {
			$status = 'error';
			$count = $this->mod_buy_orders->count_by_status($status);
		}

		elseif ($old_status == 'open') {
			$status = 'open';
			$count = $this->mod_buy_orders->count_by_status($status);
		}

		elseif ($old_status == 'sold') {
			$status = 'sold';
			$count = $this->mod_buy_orders->count_by_status($status);
		}

		elseif ($old_status == 'all') {
			$count = $this->mod_buy_orders->count_all();
		}

		$config = array();
		$config["base_url"] = SURL."admin/buy_orders/get_order_ajax";
		$config["total_rows"] = $count;
		$config['per_page'] = 20;
		$config['num_links'] = 5;
		$config['use_page_numbers'] = TRUE;
		$config['uri_segment'] = 4;
		$config['reuse_query_string'] = TRUE;
		$config["first_tag_open"] = '<li>';
		$config["first_tag_close"] = '</li>';
		$config["last_tag_open"] = '<li>';
		$config["last_tag_close"] = '</li>';
		$config['next_link'] = '&raquo;';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '&laquo;';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['first_link'] = 'First';
		$config['last_link'] = 'Last';
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';
		$config['cur_tag_open'] = '<li class="active"><a href="#"><b>';
		$config['cur_tag_close'] = '</b></a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';

		$this->pagination->initialize($config);
		$page = $this->uri->segment(4);
		$start = ($page - 1) * $config["per_page"];
		  
		if ($old_status != 'all') {
			if ($old_status == 'sold') {

				$return_data = $this->mod_buy_orders->get_buy_orders_by_status($old_status,$start,$config["per_page"]);
				$orders_arr = $return_data['fullarray'];

			}elseif ($old_status == 'open') {

				$return_data = $this->mod_buy_orders->get_buy_orders_by_status($old_status,$start,$config["per_page"]);
				$orders_arr = $return_data['fullarray'];

			}else
			{
				$return_data = $this->mod_buy_orders->get_buy_orders_by_status($status,$start,$config["per_page"]);
				$orders_arr = $return_data['fullarray'];
			}

		}else
		{
			$return_data = $this->mod_buy_orders->get_buy_orders($start,$config["per_page"]);
			$orders_arr = $return_data['fullarray'];	
		}

		$page_links = $this->pagination->create_links();

		$response= '<div class="widget-body padding-none">
						<table class="table table-condensed">
	                   		<thead>
	                        	<tr>
		                            <th></th>
		                            <th><strong>Coin</strong></th>
		                            <th><strong>Price</strong></th>
		                            <th><strong>Trail Price</strong></th>
		                            <th><strong>Quantity</strong></th>
		                            <th class="text-center"><strong>P/L</strong></th>
		                            <th class="text-center"><strong>Market(%)</strong></th>
		                            <th class="text-center"><strong>Status</strong></th>
		                            <th class="text-center"><strong>Profit(%)</strong></th>
		                            <th class="text-center"><strong>Actions</strong></th>
	                       		 </tr>
	                    	</thead>
                        <tbody>';
                      
                        if(count($orders_arr)>0){
                            foreach ($orders_arr as $key=>$value) {

                            	//Get Market Price
        						$market_value = $this->mod_dashboard->get_market_value($value['symbol']);

                            	if($value['status'] !='new' && $value['status'] !='error'){
                                    $market_value333 = num($value['market_value']); 
                                }else{
                                    $market_value333 = num($market_value);
                                }


                                if($value['status'] =='new'){
                                	$current_order_price = num($value['price']);
                                }else{
                                	$current_order_price = num($value['market_value']);
                                }

                                $current_data = $market_value333 - $current_order_price; 	
	                        	$market_data = ($current_data * 100 / $market_value333);

	                        	$market_data = number_format((float)$market_data, 2, '.', '');

	                        	if($market_value333 > $current_order_price){
	                        		$class = 'success';
	                        	}else{
	                        		$class = 'danger';	
	                        	}
	                        	

                            $response .= '<tr>
                            <td class="center">
                                <button class="btn btn-default view_order_details" title="View Order Details" data-id="'.$value['_id'].'"><i class="fa fa-eye"></i></button>
                            </td>
                            <td>'.$value['symbol'].'</td>
                            <td>'.num($value['price']).'</td>
                            <td>';
                            if($value['trail_check']=='yes'){
                                $response .=  num($value['buy_trail_price']);
                            }else{
                                $response .= "-";
                            }
                            $response .= '</td>
                            <td>'.$value['quantity'].'</td>
                            <td class="center"><b>'.num($market_value333).'</b></td>';

                            if($value['is_sell_order'] !='sold' && $value['is_sell_order'] !='yes' && $value['status'] !='error'){

                           		$response .= '<td class="center"><span class="text-'.$class.'"><b>'.$market_data.'%</b></span></td>';

                       		}else{

                       			$response .= '<td class="center"><span class="text-default"><b>-</b></span></td>';
                       		}

                            $response .= '<td class="center">';

                            
                            if($value['status'] =='FILLED' && $value['is_sell_order'] =='yes'){
                                    
                                $response .= '<span class="label label-info">SUBMITTED FOR SELL</span>';

                            }elseif($value['status'] =='FILLED' && $value['is_sell_order'] =='sold'){
                                    
                                $response .= '<span class="label label-success">Sold</span>';

                            }else{

                            	if($value['status'] =='error'){
	                            	$status_cls = "danger";
	                            }else{
	                            	$status_cls = "success";
	                            }
                            	
                            	$response .= '<span class="label label-'.$status_cls.'">'.strtoupper($value['status']).'</span>';
                            }
                            
                            
                            $response .= '<span class="custom_refresh" data-id="'.$value['_id'].'" order_id="'.$value['binance_order_id'].'">
		                            		<i class="fa fa-refresh" aria-hidden="true"></i>
		                            	  </span>';   
                          
                            $response .= '</td>

                            <td class="center">';

                            if($value['market_sold_price'] !=""){

                            	$market_sold_price = num($value['market_sold_price']);

	                            $current_data2222 = $market_sold_price - $current_order_price; 	
		                        $profit_data = ($current_data2222 * 100 / $market_sold_price);

		                        $profit_data = number_format((float)$profit_data, 2, '.', '');

		                        if($market_sold_price > $current_order_price){
		                        		$class222 = 'success';
		                        }else{
		                        		$class222 = 'danger';	
		                        }

		                        $response .= '<span class="text-'.$class222.'">
		                        				<b>'.$profit_data.'%</b>
		                        			  </span>';
                            }else{


                            	if($value['status'] =='FILLED'){

                              		if($value['is_sell_order'] =='yes'){ 

                              			$current_data = num($market_value) - num($value['market_value']); 	
			                        	$market_data = ($current_data * 100 / $market_value);

			                        	$market_data = number_format((float)$market_data, 2, '.', '');

			                        	if($market_value > $value['market_value']){
			                        		$class = 'success';
			                        	}else{
			                        		$class = 'danger';	
			                        	}

			                        	$response .= '<span class="text-'.$class.'"><b>'.$market_data.'%</b></span>';

                              		}else{

                              			$response .= '<span class="text-default"><b>-</b></span>';
                              		}

                              	}else{

                              		$response .= '<span class="text-default"><b>-</b></span>';

                              	}

                            	 
                            }

                            $response .= '</td>

                            <td class="center">
                                <div class="btn-group btn-group-xs ">';
                                if($value['status'] =='new' || $value['status'] =='error'){
                                   $response .= '<a href="'.SURL.'admin/buy_orders/edit-buy-order/'.$value['_id'].'" class="btn btn-inverse"><i class="fa fa-pencil"></i></a>';
                                } 
                                if($value['status'] !='FILLED'){   
                                  $response .= '<a href="'.SURL.'admin/buy_orders/delete-buy-order/'.$value['_id'].'/'.$value['binance_order_id'].'" class="btn btn-danger" onclick="return confirm(\'Are you sure want to delete?\')"><i class="fa fa-times"></i></a>';
                              	}

                              	if($value['status'] =='FILLED'){

                              		if($value['is_sell_order'] =='yes'){ 
                                       
                                        $response .= '<a href="'.SURL.'admin/sell_orders/edit-order/'.$value['sell_order_id'].'" class="btn btn-inverse" target="_blank"><i class="fa fa-pencil"></i></a>';
                                        $response .= '<button class="btn btn-danger sell_now_btn" id="'.$value['_id'].'" data-id="'.$value['sell_order_id'].'" market_value="'.num($market_value).'" quantity="'.$value['quantity'].'" symbol="'.$value['symbol'].'">Sell Now</button>';

                                    }elseif($value['is_sell_order'] =='sold'){ 
                                        $response .= '<a href="'.SURL.'admin/sell_orders/edit-order/'.$value['sell_order_id'].'" class="btn btn-success" target="_blank"><i class="fa fa-eye"></i></a>';
                                    }else{ 
                                        $response .= '<a href="'.SURL.'admin/sell_orders/add-order/'.$value['_id'].'" class="btn btn-warning" target="_blank">Set For Sell</a>';
                                        //$response .= '<button class="btn btn-danger sell_now_btn" id="'.$value['_id'].'" data-id="'.$value['sell_order_id'].'" market_value="'.num($market_value).'" quantity="'.$value['quantity'].'" symbol="'.$value['symbol'].'">Sell Now</button>';
                                    }
                                	
                                }

                                $response .= '</div>
                            </td>

                             

                            <td class="text-center">';
                                if($value['status'] =='new'){

                                	$response .= '<button class="btn btn-danger buy_now_btn" id="'.$value['_id'].'" data-id="'.$value['_id'].'" market_value="'.num($market_value).'" quantity="'.$value['quantity'].'" symbol="'.$value['symbol'].'">Buy Now</button>';
                               	}
                            	$response .= '</td>
                            </tr>';
                        	}
                        }
                        $response .= '</tbody>
                    	</table>
              		 </div>
					    <div class="page_links text-center">'.$page_links.'</div>
				        </div>
				   </div>
				</div>';

       	echo $response;
       	exit;
	}

	public function get_coin_balance()
	{
		$id = $this->session->userdata('admin_id');
		//$post = $this->input->post('symbol');
		$post = $this->session->userdata('global_symbol');
		$bal1 = $this->mod_buy_orders->get_balance($post,$id);

		$post = 'BTC';
		$bal2 = $this->mod_buy_orders->get_balance($post,$id);

		echo $bal1.'|'.$bal2;
		exit;
	}

	public function reset_buy_filters($type){
		
		$this->session->unset_userdata('filter-data-buy');
		redirect(base_url().'admin/buy_orders');	
		
	}//End reset_buy_filters

	public function get_all_counts(){
			$count_all = $this->mod_buy_orders->count_all();
			$status = 'FILLED';
			$count_filled = $this->mod_buy_orders->count_by_status($status);

			$status = 'new';
			$count_new = $this->mod_buy_orders->count_by_status($status);

			$status = 'submitted';
			$count_submitted = $this->mod_buy_orders->count_by_status($status);

			$status = 'canceled';
			$count_canceled = $this->mod_buy_orders->count_by_status($status);
			$status = 'error';
			$count_error = $this->mod_buy_orders->count_by_status($status);

			$status = 'open';
			$count_open = $this->mod_buy_orders->count_by_status($status);
	
			$status = 'sold';
			$count_sold = $this->mod_buy_orders->count_by_status($status);

			echo $count_new."|".$count_filled."|".$count_submitted."|".$count_canceled."|".$count_error."|".$count_open."|".$count_sold."|".$count_all;
			/*echo "1|2|3|4|5|6|7|8";*/
			exit;
	}//End get_all_counts
}