<?php
/**
 *
 */
class Test extends CI_Controller {

	function __construct() {
		parent::__construct();
	}

	public function index() {
	
		$data_to_insert = array(
			"amount" => 20000,
		);

		$db = $this->mongo_db->customQuery();
		$ins_data = $db->test_collection->updateOne(array("price" => 2000), array('$set' => $data_to_insert), array('upsert' => true));

		//$update = $collection->update($criteria,$document,array( 'upsert' =>true));
		//$this->mongo_db->insert("test_collection",$data_to_insert);
		echo "<pre>";
		print_r($ins_data);
		exit;
	}

	public function test() {
		$this->mongo_db->where(array('trigger_type' => 'trigger_2'));
		$res = $this->mongo_db->get('buy_orders');
		echo "<pre>";
		print_r(iterator_to_array($res));
		exit;
		/*price = 0.00000500;
			$per = ($price * 0.1)/100;

		*/

	}

	public function migrate_coins_to_mongo_db() {

		$res = $this->db->get('coins');
		$coin_arr = $res->result_array();

		foreach ($coin_arr as $key => $value) {
			$insert_array = array(
				'coin_id' => $value['id'],
				'coin_name' => $value['coin_name'],
				'symbol' => $value['symbol'],
				'coin_logo' => $value['coin_logo'],
				'coin_keywords' => $value['coin_keywords'],
				'unit_value' => $value['unit_value'],
				'offset_value' => $value['offset_value'],
				'created_date' => $this->mongo_db->converToMongodttime($value['created_date']),
			);
			$this->mongo_db->insert('coins', $insert_array);
		}
	}

	public function get_all_coins() {
		//$this->mongo_db->drop_collection('coins');
		$res = $this->mongo_db->get('coins');
		$coin_arr = iterator_to_array($res);

		echo "<pre>";
		print_r($coin_arr);
		exit;
	}

    public function importmember() {
		//$this->mongo_db->drop_collection('coins');
		
		
		
	/*	
		$getUserArr = $this->mongo_db->get('member_users');
		$responseArr = iterator_to_array($getUserArr);	
		
		echo "<pre>";  print_r($responseArr); exit;
		*/
	
		
		$sql	= "SELECT * FROM tr_member_details ";
		
		$query	= $this->db->query( $sql );
		$member_Arr  =   $query->result_array();
		
		
		//echo "<pre>";   print_r($member_Arr); exit;
		
		

		foreach ($member_Arr as $key => $value) {
			$insert_array = array(
				'wp_user_id' => $value['wp_user_id'],
				'member_id' => $value['member_id'],
				'referral_member_id' => $value['referral_member_id'],
				'class_code_id' => $value['class_code_id'],
				'member_name' => $value['member_name'],
				'birthday' => $value['Birthday'],
				'aff_code' => $value['aff_code'],
				'password' => md5($value['password']),
				'contact_id' => $value['contact_id'],
				'street_address_1' => $value['street_address_1'],
				'street_address_2' => $value['street_address_2'],
				'city' => $value['city'],
				'state' => $value['state'],
				'country' => $value['country'],
				'post_code' => $value['post_code'],
				
                'phone' => $value['phone'],
                'tags_groups' => $value['tags_groups'],
                'registered_on' => $this->mongo_db->converToMongodttime($value['registered_on']),
                'auth_token' => $value['auth_token'],
                'created_on' => $this->mongo_db->converToMongodttime($value['created_on']),
                'package' => $value['package'],
                'balance_amount' => $value['balance_amount'],
                'product_package' => $value['product_package'],
                'sms_notification' => $value['sms_notification'],
                'push_notification' => $value['push_notification'],
                'updated_class_code' => $value['updated_class_code'],
                'inactive' => $value['inactive'],
				
			);
			$mongoid =  $this->mongo_db->insert('member_users', $insert_array);

			

			$sql	= "UPDATE `tr_member_details` SET `mongoid`='".$mongoid."' where id =". $value['id']."";
		    $query	=  $this->db->query( $sql );
			if($query){

	           	//$res = $this->mongo_db->get('member_users');
				//$member_users_arr = iterator_to_array($res);

			}
		}
		
	}
	
	
	
	public function get_all_user_orders() {
		
		extract($_POST);
		
		
		
		 $user_id;
		 $start_date;
		  $end_date;
		   $status;

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
		
		
	
		$array  =  json_encode($fullarray);
		
		echo $array; exit;
		


	}
	

	 public function dropTable()
    {
    	$table = 'member_users';
        if ($table != '') {
            $get_data = $this->mongo_db->drop_collection($table);
            if ($get_data) {
                echo $table;
                exit;
            }
        }
    } //dropTable

	public function run(){
		//$resp = $this->mongo_db->get('market_prices_okx');

		$db = $this->mongo_db->customQuery();
		
		$resp = $db->market_depth_history_okex->count();
		echo  '<pre>';
		print_r($resp);
		exit;

		$this->mongo_db->limit(20);

		$this->mongo_db->order_by(array('_id'=>-1));
		// $this->mongo_db->where(array('coin'=>'TRXBTC'));
		
		//$resp = $this->mongo_db->get('market_depth_history_okex');
		//$resp = $this->mongo_db->get('market_depth');
		 $resp = $this->mongo_db->get('market_trade_history');
		//$resp = $this->mongo_db->get('market_trades');
		$resp = iterator_to_array($resp);
		echo '<pre>';
		print_r($resp);
		echo 'Comming';
	}//End of run

}
?>