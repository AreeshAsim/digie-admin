<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_live extends CI_Controller {
	
	
	public function __construct()
     {
		
		parent::__construct();
	
		// Load Modal
		$this->load->model('admin/mod_dashboard');
		$this->load->model('admin/mod_coins');
		$this->load->model('admin/mod_candel');
	}

	// public function index(){

	// 	$this->db->dbprefix('migrate_buy_orders');
	// 	$this->db->order_by('id DESC');
	// 	$get_orders = $this->db->get('migrate_buy_orders');

	// 	//echo $this->db->last_query();
	// 	$orders_arr = $get_orders->result_array();

	// 	for ($i=0; $i <count($orders_arr) ; $i++) { 

	// 		$id = $orders_arr[$i]['id'];

	// 		$ins_data = array(
	// 		   'symbol' => $orders_arr[$i]['symbol'],
	// 		   'binance_order_id' => $orders_arr[$i]['binance_order_id'],
	// 		   'price' => $orders_arr[$i]['price'],
	// 		   'quantity' => $orders_arr[$i]['quantity'],
	// 		   'order_type' => $orders_arr[$i]['order_type'],
	// 		   'market_value' => $orders_arr[$i]['market_value'],
	// 		   'trail_check' => $orders_arr[$i]['trail_check'],
	// 		   'trail_interval' => $orders_arr[$i]['trail_interval'],
	// 		   'buy_trail_price' => $orders_arr[$i]['buy_trail_price'],
	// 		   'status' => $orders_arr[$i]['status'],
	// 		   'is_sell_order' => $orders_arr[$i]['is_sell_order'],
	// 		   'market_sold_price' => $orders_arr[$i]['market_sold_price'],
	// 		   'sell_order_id' => $orders_arr[$i]['sell_order_id'],
	// 		   'admin_id' => $orders_arr[$i]['admin_id'],
	// 		   'created_date' => $this->mongo_db->converToMongodttime($orders_arr[$i]['created_date'])
	// 		);


	// 		//Insert data in mongoTable 
	//     	$buy_order_id = $this->mongo_db->insert('buy_orders',$ins_data);


	    	
	//     	//Update the record into the database.
	//     	$upd_data = array(
	// 		   'new_mongo_id' => $this->db->escape_str(trim($buy_order_id))
	// 		);
			
	// 		$this->db->dbprefix('migrate_buy_orders');
	// 		$this->db->where('id', $id);
	// 		$this->db->update('migrate_buy_orders', $upd_data);

	// 	}

		

	//     echo "<pre>";
	//     print_r($orders_arr);
	//     exit;

	// }

	// public function sell(){

	// 	$this->db->dbprefix('migrate_sell_orders');
	// 	$this->db->order_by('id DESC');
	// 	$get_orders = $this->db->get('migrate_sell_orders');

	// 	//echo $this->db->last_query();
	// 	$orders_arr = $get_orders->result_array();

	// 	for ($i=0; $i <count($orders_arr) ; $i++) { 

	// 		$id = $orders_arr[$i]['id'];
	// 		$mongo_id = $orders_arr[$i]['buy_order_id'];

	// 		$this->db->dbprefix('migrate_buy_orders');
	// 		$this->db->where('mongo_id',$mongo_id);
	// 		$get_buy = $this->db->get('migrate_buy_orders');

	// 		//echo $this->db->last_query();
	// 		$buy_arr = $get_buy->row_array();
	// 		$new_buy_id = $buy_arr['new_mongo_id'];
			

	// 		$ins_data = array(
	// 		   'symbol' => $orders_arr[$i]['symbol'],
	// 		   'binance_order_id' => $orders_arr[$i]['binance_order_id'],
	// 		   'purchased_price' => $orders_arr[$i]['purchased_price'],
	// 		   'quantity' => $orders_arr[$i]['quantity'],
	// 		   'profit_type' => $orders_arr[$i]['profit_type'],
	// 		   'sell_profit_percent' => $orders_arr[$i]['sell_profit_percent'],
	// 		   'sell_profit_price' => $orders_arr[$i]['sell_profit_price'],
	// 		   'sell_price' => $orders_arr[$i]['sell_price'],
	// 		   'market_value' => $orders_arr[$i]['market_value'],
	// 		   'trail_check' => $orders_arr[$i]['trail_check'],
	// 		   'trail_interval' => $orders_arr[$i]['trail_interval'],
	// 		   'sell_trail_price' => $orders_arr[$i]['sell_trail_price'],
	// 		   'order_type' => $orders_arr[$i]['order_type'],
	// 		   'stop_loss' => $orders_arr[$i]['stop_loss'],
	// 		   'loss_percentage' => $orders_arr[$i]['loss_percentage'],
	// 		   'status' => $orders_arr[$i]['status'],
	// 		   'admin_id' => $orders_arr[$i]['admin_id'],
	// 		   'buy_order_id' => $this->mongo_db->mongoId($new_buy_id),
	// 		   'buy_order_binance_id' => $orders_arr[$i]['buy_order_binance_id'],
	// 		   'created_date' => $this->mongo_db->converToMongodttime($orders_arr[$i]['created_date'])
	// 		);


	// 		//Insert data in mongoTable 
	//     	$sell_order_id = $this->mongo_db->insert('orders',$ins_data);


	    	
	//     	//Update the record into the database.
	//     	$upd_data = array(
	// 		   'new_mongo_id' => $this->db->escape_str(trim($sell_order_id))
	// 		);
			
	// 		$this->db->dbprefix('migrate_sell_orders');
	// 		$this->db->where('id', $id);
	// 		$this->db->update('migrate_sell_orders', $upd_data);

	// 	}

		

	//     echo "<pre>";
	//     print_r($orders_arr);
	//     exit;

	// }

	// public function update_buy(){

	// 	$this->db->dbprefix('migrate_buy_orders');
	// 	$this->db->order_by('id DESC');
	// 	$get_orders = $this->db->get('migrate_buy_orders');

	// 	//echo $this->db->last_query();
	// 	$orders_arr = $get_orders->result_array();

	// 	for ($i=0; $i <count($orders_arr) ; $i++) { 

	// 		$id = $orders_arr[$i]['id'];
	// 		$mongo_id = $orders_arr[$i]['sell_order_id'];
	// 		$buy_mongo_id = $orders_arr[$i]['new_mongo_id'];

	// 		if($mongo_id !=""){

	// 			$this->db->dbprefix('migrate_sell_orders');
	// 			$this->db->where('mongo_id',$mongo_id);
	// 			$get_sell = $this->db->get('migrate_sell_orders');

	// 			//echo $this->db->last_query();
	// 			$sell_arr = $get_sell->row_array();
	// 			$new_sell_id = $sell_arr['new_mongo_id'];


	// 			$upd_data = array(
	// 			   'sell_order_id' => $new_sell_id
	// 			);

	// 			$this->mongo_db->where(array('_id'=> $buy_mongo_id));
	// 			$this->mongo_db->set($upd_data);

	// 			//Update data in mongoTable 
	// 		    $this->mongo_db->update('buy_orders');
	// 		}
	// 	}

		

	//     echo "<pre>";
	//     print_r($orders_arr);
	//     exit;

	// }

	// public function temp_orders(){

	// 	$this->db->dbprefix('migrate_temp_orders');
	// 	$this->db->order_by('id DESC');
	// 	$get_orders = $this->db->get('migrate_temp_orders');

	// 	//echo $this->db->last_query();
	// 	$orders_arr = $get_orders->result_array();

	// 	for ($i=0; $i <count($orders_arr) ; $i++) { 

	// 		$id = $orders_arr[$i]['id'];
	// 		$buy_order_id = $orders_arr[$i]['buy_order_id'];
			

	// 		$this->db->dbprefix('migrate_buy_orders');
	// 		$this->db->where('mongo_id',$buy_order_id);
	// 		$get_buy = $this->db->get('migrate_buy_orders');

	// 		//echo $this->db->last_query();
	// 		$buy_arr = $get_buy->row_array();
	// 		$new_buy_id = $buy_arr['new_mongo_id'];


	// 		$ins_temp_data = array(
	// 			'buy_order_id' => $this->mongo_db->mongoId($new_buy_id),
	// 			'profit_type' => $orders_arr[$i]['profit_type'],
	// 			'profit_percent' => $orders_arr[$i]['profit_percent'],
	// 			'profit_price' => $orders_arr[$i]['profit_price'],
	// 			'order_type' => $orders_arr[$i]['order_type'],
	// 			'trail_check' => $orders_arr[$i]['trail_check'],
	// 			'trail_interval' => $orders_arr[$i]['trail_interval'],
	// 			'stop_loss' => $orders_arr[$i]['stop_loss'],
	// 			'loss_percentage' => $orders_arr[$i]['loss_percentage']
	// 		);


	// 		//Insert data in mongoTable 
	//     	$order_id = $this->mongo_db->insert('temp_sell_orders',$ins_temp_data);


	//     	//Update the record into the database.
	//     	$upd_data = array(
	// 		   'new_mongo_id' => $this->db->escape_str(trim($order_id))
	// 		);
			
	// 		$this->db->dbprefix('migrate_temp_orders');
	// 		$this->db->where('id', $id);
	// 		$this->db->update('migrate_temp_orders', $upd_data);
			
	// 	}

		

	//     echo "<pre>";
	//     print_r($orders_arr);
	//     exit;

	// }

	// public function orders_history_log(){

	// 	$this->db->dbprefix('migrate_orders_history');
	// 	$this->db->order_by('id DESC');
	// 	$get_orders = $this->db->get('migrate_orders_history');

	// 	//echo $this->db->last_query();
	// 	$orders_arr = $get_orders->result_array();

	// 	for ($i=0; $i <count($orders_arr) ; $i++) { 

	// 		$id = $orders_arr[$i]['id'];
	// 		$buy_order_id = $orders_arr[$i]['order_id'];
			

	// 		$this->db->dbprefix('migrate_buy_orders');
	// 		$this->db->where('mongo_id',$buy_order_id);
	// 		$get_buy = $this->db->get('migrate_buy_orders');

	// 		//echo $this->db->last_query();
	// 		$buy_arr = $get_buy->row_array();
	// 		$new_buy_id = $buy_arr['new_mongo_id'];


	// 		$ins_data = array(
	// 			'order_id' => $this->mongo_db->mongoId($new_buy_id),
	// 		    'type' => $orders_arr[$i]['type'],
	// 		    'log_msg' => $orders_arr[$i]['log_msg'],
	// 		    'created_date' => $this->mongo_db->converToMongodttime($orders_arr[$i]['created_date'])
	// 		);

	// 		//Insert data in mongoTable 
	//     	$order_id = $this->mongo_db->insert('orders_history_log',$ins_data);


	//     	//Update the record into the database.
	//     	$upd_data = array(
	// 		   'new_mongo_id' => $this->db->escape_str(trim($order_id))
	// 		);
			
	// 		$this->db->dbprefix('migrate_orders_history');
	// 		$this->db->where('id', $id);
	// 		$this->db->update('migrate_orders_history', $upd_data);
			
	// 	}

		

	//     echo "<pre>";
	//     print_r($orders_arr);
	//     exit;

	// }


}