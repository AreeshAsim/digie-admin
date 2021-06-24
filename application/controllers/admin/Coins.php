<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coins extends CI_Controller {

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
		$this->load->model('admin/mod_coins');
		$this->load->model('admin/mod_trigger_rule_report');
		$this->load->model('admin/mod_dashboard');

	}

	public function index() {
		//Login Check
		$this->mod_login->verify_is_admin_login();
		if ($this->session->userdata('user_role') != 1) {
			redirect(base_url() . 'forbidden');
		}
		//Fetching coins Record
		$coins_arr = $this->mod_coins->get_all_coins();
		$data['coins_arr'] = $coins_arr;



		//stencil is our templating library. Simply call view via it
		$this->stencil->paint('admin/coins/coins', $data);

	} //End index

	public function add_coin() {
		//Login Check
		$this->mod_login->verify_is_admin_login();
		if ($this->session->userdata('user_role') != 1) {
			redirect(base_url() . 'forbidden');
		}
		//stencil is our templating library. Simply call view via it
		$this->stencil->paint('admin/coins/add_coin');

	} //End add_coin

	public function add_coin_process() {

		//Login Check
		$this->mod_login->verify_is_admin_login();
		if ($this->session->userdata('user_role') != 1) {
			redirect(base_url() . 'forbidden');
		}
		//Adding add_coin
		$coin_id = $this->mod_coins->add_coin($this->input->post());

		// if ($coin_id) {
			$this->session->set_flashdata('ok_message', 'Coin added successfully.');
			redirect(base_url() . 'admin/coins/add-coin');

		// } else {

		// 	$this->session->set_flashdata('err_message', 'Coin cannot added. Something went wrong, please try again.');
		// 	redirect(base_url() . 'admin/coins/add-coin');

		// } //end if

	} //end add_coin_process

	public function edit_coin($coin_id) {
		//Login Check
		$this->mod_login->verify_is_admin_login();

		if ($this->session->userdata('user_role') != 1) {
			redirect(base_url() . 'forbidden');
		}
		//Fetching coin Record
		$coin_arr = $this->mod_coins->get_coin($coin_id);
		$data['coin_arr'] = $coin_arr;
		$data['coin_id'] = $coin_id;

		$this->stencil->paint('admin/coins/edit_coin', $data);

	} //End edit_coin

	public function edit_coin_process() {

		//Login Check
		$this->mod_login->verify_is_admin_login();
		//edit_coin
		$coin_id = $this->mod_coins->edit_coin($this->input->post());

		if ($coin_id) {

			redirect(base_url() . 'admin/coins/edit-coin/' . $coin_id);

		} else {

			redirect(base_url() . 'admin/coins/edit-coin/' . $coin_id);

		} //end if

	} //end edit_coin_process

	public function delete_coin($coin_id) {

		//Login Check
		$this->mod_login->verify_is_admin_login();
		if ($this->session->userdata('user_role') != 1) {
			redirect(base_url() . 'forbidden');
		}
		//Delete coin
		$delete_coin = $this->mod_coins->delete_coin($coin_id);

		if ($delete_coin) {

			$this->session->set_flashdata('ok_message', 'coin deleted successfully.');
			redirect(base_url() . 'admin/coins');

		} else {

			$this->session->set_flashdata('err_message', 'coin can not deleted. Something went wrong, please try again.');
			redirect(base_url() . 'admin/coins');

		} //end if

	} //end delete_coin

	public function create_thumbnail() {


		if($_FILES['image']['name'] != ''){
			//Create User Directory if not exist
			$coins_material_folder_path = 'assets/coin_logo/';

			 if(!is_dir($coins_material_folder_path))
			 mkdir($coins_material_folder_path,0777);

			$orignal_file_name = $_FILES['image']['name'];
			$file_ext          = ltrim(strtolower(strrchr($_FILES['image']['name'],'.')),'.');
			$file_name         = 'coin-'.".".$file_ext ;

			$config['upload_path'] = $coins_material_folder_path;
			$config['allowed_types'] = 'jpg|jpeg|gif|tiff|tif|png';
			$config['max_size']	= '6000';
			$config['overwrite'] = true;
			$config['file_name'] = $orignal_file_name;
			$this->load->library('upload', $config);
            $this->upload->initialize($config);


			if(!$this->upload->do_upload('image')){
				$error_file_arr = array('error' => $this->upload->display_errors());
				return $error_file_arr;

			}else{

				$data_image_upload = array('upload_image_data' => $this->upload->data());
				$source_info = $coins_material_folder_path.'/'.$orignal_file_name;

				//Resize the Uploaded Image 800 * 600
				$config_profile['image_library'] = 'gd2';
				$config_profile['source_image'] = $coins_material_folder_path.'/'.$orignal_file_name;
				$config_profile['create_thumb'] = TRUE;
				$config_profile['thumb_marker'] = '';

				$config_profile['maintain_ratio'] = TRUE;
				$config_profile['width'] = 800;
				$config_profile['height'] = 600;

				$this->load->library('image_lib');
				$this->image_lib->initialize($config_profile);
				$this->image_lib->resize();
				$this->image_lib->clear();

				//Creating Thumbmail 28 * 28
				//Uploading is successful now resizing the uploaded image
			 	$config_profile['image_library'] = 'gd2';
				$config_profile['source_image'] = $coins_material_folder_path.'/'.$orignal_file_name;
				$config_profile['new_image']    = $coins_material_folder_path.'/thumbs/'.$orignal_file_name;
				$config_profile['create_thumb'] = TRUE;
				$config_profile['thumb_marker'] = '';

				$config_profile['maintain_ratio'] = TRUE;
				$config_profile['width']  = 30;
				$config_profile['height'] = 30;

				$this->load->library('image_lib');
				$this->image_lib->initialize($config_profile);
				$this->image_lib->resize();
				$this->image_lib->clear();
				echo $orignal_file_name;
		        exit;
			}//end if(!$this->upload->do_upload('prof_image'))

		}//end if($_FILES['image']['name'] != '')




		$error = 0;
		$userfile = $_FILES['image']['tmp_name'];
		$userfile_name = $_FILES['image']['name'];
		$userfile_size = $_FILES['image']['size'];
		$userfile_type = $_FILES['image']['type'];
		/////////////////////////
		//GET-DECLARE DIMENSIONS //
		$dimension = getimagesize($userfile);

		$large_width = $dimension[0]; // GET PHOTO WIDTH
		$large_height = $dimension[1]; //GET PHOTO HEIGHT
		$small_width = 30; // DECLARE THUMB WIDTH
		$small_height = 30; // DECLARE THUMB HEIGHT

		/////////////////////////
		//CHECK SIZE  //

		if ($userfile_size > 102400) {
			$error = 1;
			$msg = "The photo is over 100kb. Please try again.";
		}

		////////////////////////////////
		// CHECK TYPE (IE AND OTHERS) //

		if ($userfile_type = "image/jpeg") {
			if ($userfile_type != "image/jpeg") {
				$error = 1;
				$msg = "The photo must be JPG";
			}
		}

		//////////////////////////////
		//CHECK WIDTH/HEIGHT //
		/*if ($large_width!=600 or$large_height!=400){
		$error=1;
		$msg = "The photo must be 600x400 pixels";
		} */

		///////////////////////////////////////////
		//CREATE THUMB / UPLOAD THUMB AND PHOTO ///

		if ($error != 1) {

			$image = $userfile_name; //if you want to insert it to the database
			$pic = imagecreatefromjpeg($userfile);
			$small = imagecreatetruecolor($small_width, $small_height);
			imagecopyresampled($small, $pic, 0, 0, 0, 0, $small_width, $small_height, $large_width, $large_height);
			if (imagejpeg($small, $_SERVER["DOCUMENT_ROOT"] . '/assets/coin_logo/thumbs/' . $userfile_name, 100)) {
				$large = imagecreatetruecolor($large_width, $large_height);
				imagecopyresampled($large, $pic, 0, 0, 0, 0, $large_width, $large_height, $large_width, $large_height);
				if (imagejpeg($large, $_SERVER["DOCUMENT_ROOT"] . '/assets/coin_logo/' . $userfile_name, 100)) {
					$msg = $userfile_name;

					//$msg .= "<img src ='".SURL."assets/coin_logo/thumbs/".$userfile_name."'>";
				} else {
					$msg = "A problem1 has occured. Please try again.";
					$error = 1;}
			} else {
				$msg = "A problem3 has occured. Please try again.";
				$error = 1;
			}
		}

		echo $msg;
		exit;
		//////////////////////////////////////////////

		/// If everything went right a photo (600x400) and
		/// a thumb(120x90) were uploaded to the given folders
	}

	public function coin_moves(){
		$this->mod_login->verify_is_admin_login();
			if($this->input->post('exchange') == 'kraken'){
				$where['exchange'] = 'kraken';
			}elseif($this->input->post('exchange') == 'bam'){
				$where['exchange'] = 'bam';
			}
			$this->session->set_userdata('filter_order_data', $this->input->post());
			$coin_array_all = $this->mod_coins->get_all_coins();
			$coin_array = array_column($coin_array_all, 'symbol');
			$where['coin'] = ['$in' => $coin_array];
			$this->mongo_db->where($where);
			$return = $this->mongo_db->get('coins_moves');
			$res = iterator_to_array($return);
			$data['final_array'] = $res;
			// $data['coin'] = $coin_array;
		$this->stencil->paint('admin/coins/coin_moves', $data);
	}
	public function coin_moves_cron_saven(){
		$coin_array_all = $this->mod_coins->get_all_coins();
		$coin_array = array_column($coin_array_all, 'symbol');

		for($coin=0; $coin <= count($coin_array); $coin++){
			// $coin= $coin_array[$coin];
			$end_date7 = date('Y-m-d H:i:s');
			$start_date7 = date('Y-m-d H:i:s', strtotime('-7 days'));
			$params = [];
			$params = [   
				'coin'       => $coin_array[$coin],
				'start_date' => (string)$start_date7,
				'end_date'   => (string)$end_date7,
			];	
			
			$jsondata = json_encode($params);
			$curl = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_URL => "http://35.171.172.15:3000/api/minMaxMarketPrices",
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "POST",
				CURLOPT_POSTFIELDS =>$jsondata,
				CURLOPT_HTTPHEADER => array("Content-Type: application/json"), 
			));
			$response_price = curl_exec($curl);	
			curl_close($curl);                                
			$api_response7 = json_decode($response_price);
			$db = $this->mongo_db->customQuery();
			$upsert['upsert'] = true;
			foreach($api_response7 as $as){
				if($as->max_price !='' && $as->min_price !='' && $as->min_price !=0 && $as->max_price !=0){
					$where['coin'] = $as->coin;
					$price = $db->market_prices->find($where);
					$result = iterator_to_array($price);
					$insert = [
						'max_7_days' => $as->max_price,
						'min_7_days' => $as->min_price,
						'coin' => $as->coin,
						'current_market' => $result[0]['price'],
						'is_modified' => $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s'))
					];
					$db->coins_moves->updateOne($where, ['$set' => $insert], $upsert);
					echo "<pre>";print_r($insert);
				} // if inner check	
			} //end foreach loop
		}//end for 
		//Save last Cron Executioon
		$this->last_cron_execution_time('coin move binance', '7d', 'coin moves binance calculate saven days(0   0   *   *  */7)', 'reports');
	}//end function
	public function coin_moves_cron_thirty(){
		$coin_array_all = $this->mod_coins->get_all_coins();
		$coin_array = array_column($coin_array_all, 'symbol');
		for($coin=0; $coin <= count($coin_array); $coin++){
			$end_date30 = date('Y-m-d H:i:s');
			$start_date30 = date('Y-m-d H:i:s', strtotime('-23 days'));
			$params30 = [];
			$params30 = [   
				'coin'       => $coin_array[$coin],
				'start_date' => (string)$start_date30,
				'end_date'   => (string)$end_date30,
			];	
			
			$jsondata = json_encode($params30);
			$curl = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_URL => "http://35.171.172.15:3000/api/minMaxMarketPrices",
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "POST",
				CURLOPT_POSTFIELDS =>$jsondata,
				CURLOPT_HTTPHEADER => array("Content-Type: application/json"), 
			));
			$response_price = curl_exec($curl);	
			curl_close($curl);                                
			$api_response30 = json_decode($response_price);
			$db = $this->mongo_db->customQuery();
			$upsert['upsert'] = true;
			foreach($api_response30 as $as){
				if($as->max_price !='' && $as->min_price !='' && $as->min_price !=0 && $as->max_price !=0){
					$where['coin'] = $as->coin;
					$price = $db->market_prices->find($where);
					$result = iterator_to_array($price);
					$insert = [
						'max_30_days' => $as->max_price,
						'min_30_days' => $as->min_price,
						'coin' => $as->coin,
						'current_market' => $result[0]['price'],
						'is_modified_30' => $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s'))
					];
					echo"<pre>";print_r($insert);
					$db->coins_moves->updateOne($where, ['$set' => $insert], $upsert);
				} // if inner check	
			} //end foreach loop
		}//end coin for 
		//Save last Cron Executioon
		$this->last_cron_execution_time('coin move binance', '30d', 'coin moves binance calculate thirty days(0    0    */30   */1   * )', 'reports');
	}//end function
	public function coin_moves_cron_ninety(){
		$coin_array_all = $this->mod_coins->get_all_coins();
		$coin_array = array_column($coin_array_all, 'symbol');
		for($coin=0; $coin <= count($coin_array); $coin++){
			// $coin= $coin_array[$coin];
			$end_date30 = date('Y-m-d H:i:s');
			$start_date30 = date('Y-m-d H:i:s', strtotime('-60 days'));

			$params90 = [];
			$params90 = [   
				'coin'       => $coin_array[$coin],
				'start_date' => (string)$start_date30,
				'end_date'   => (string)$end_date30,
			];	
			
			$jsondata = json_encode($params90);
			$curl = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_URL => "http://35.171.172.15:3000/api/minMaxMarketPrices",
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "POST",
				CURLOPT_POSTFIELDS =>$jsondata,
				CURLOPT_HTTPHEADER => array("Content-Type: application/json"), 
			));
			$response_price = curl_exec($curl);	
			curl_close($curl);                                
			$api_response90 = json_decode($response_price);
			$db = $this->mongo_db->customQuery();
			$upsert['upsert'] = true;
			foreach($api_response90 as $as){
				if($as->max_price !='' && $as->min_price !='' && $as->min_price !=0 && $as->max_price !=0){
					$where['coin'] = $as->coin;
					$price = $db->market_prices->find($where);
					$result = iterator_to_array($price);
					$insert = [
						'max_90_days' => $as->max_price,
						'min_90_days' => $as->min_price,
						'coin' => $as->coin,
						'current_market' => $result[0]['price'],
						'is_modified_90' => $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s'))
					];
					$db->coins_moves->updateOne($where, ['$set' => $insert], $upsert);
					echo "<pre>";
					print_r($insert);
				} // if inner check	
			} //end foreach loop
		}
		//Save last Cron Executioon
		$this->last_cron_execution_time('coin move binance', '30d', 'coin moves binance calculate ninety days(0   0   */90  */3  *)', 'reports');
	}//end function


	public function coin_moves_cron_saven_kraken(){
		$coin_array_all = $this->mod_coins->get_all_coins_kraken();
		$coin_array = array_column($coin_array_all, 'symbol');

		for($coin=0; $coin <= count($coin_array); $coin++){
			// $coin= $coin_array[$coin];
			$end_date7 = date('Y-m-d H:i:s');
			$start_date7 = date('Y-m-d H:i:s', strtotime('-7 days'));
			$params = [];
			$params = [   
				'coin'       => $coin_array[$coin],
				'start_date' => (string)$start_date7,
				'end_date'   => (string)$end_date7,
			];	
			
			$jsondata = json_encode($params);
			$curl = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_URL => "http://35.171.172.15:3000/api/minMaxMarketPrices",
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "POST",
				CURLOPT_POSTFIELDS =>$jsondata,
				CURLOPT_HTTPHEADER => array("Content-Type: application/json"), 
			));
			$response_price = curl_exec($curl);	
			curl_close($curl);                                
			$api_response7 = json_decode($response_price);
			$db = $this->mongo_db->customQuery();
			$upsert['upsert'] = true;
			foreach($api_response7 as $as){
				if($as->max_price !='' && $as->min_price !='' && $as->min_price !=0 && $as->max_price !=0){
					$where['coin'] = $as->coin;
					$price = $db->market_prices_kraken->find($where);
					$result = iterator_to_array($price);
					$insert = [
						'max_7_days' => $as->max_price,
						'min_7_days' => $as->min_price,
						'coin' => $as->coin,
						'exchange' => 'kraken',
						'current_market' => $result[0]['price'],
						'is_modified' => $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s'))
					];
					$where_kraken['coin'] = $as->coin;
					$where_kraken['exchange'] = 'kraken';
					$db->coins_moves->updateOne($where_kraken, ['$set' => $insert], $upsert);
					echo "<pre>";print_r($insert);
				} // if inner check	
			} //end foreach loop
		}//end for 
		//Save last Cron Executioon
		$this->last_cron_execution_time('coin move kraken weekly', '7d', 'coin moves kraken calculate saven days(0    0    *    *   */7)', 'reports');
	}//end function
	public function coin_moves_cron_thirty_kraken(){
		$coin_array_all = $this->mod_coins->get_all_coins_kraken();
		$coin_array = array_column($coin_array_all, 'symbol');
		for($coin=0; $coin <= count($coin_array); $coin++){
			$end_date30 = date('Y-m-d H:i:s');
			$start_date30 = date('Y-m-d H:i:s', strtotime('-23 days'));
			$params30 = [];
			$params30 = [   
				'coin'       => $coin_array[$coin],
				'start_date' => (string)$start_date30,
				'end_date'   => (string)$end_date30,
			];	
			
			$jsondata = json_encode($params30);
			$curl = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_URL => "http://35.171.172.15:3000/api/minMaxMarketPrices",
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "POST",
				CURLOPT_POSTFIELDS =>$jsondata,
				CURLOPT_HTTPHEADER => array("Content-Type: application/json"), 
			));
			$response_price = curl_exec($curl);	
			curl_close($curl);                                
			$api_response30 = json_decode($response_price);
			$db = $this->mongo_db->customQuery();
			$upsert['upsert'] = true;
			foreach($api_response30 as $as){
				if($as->max_price !='' && $as->min_price !='' && $as->min_price !=0 && $as->max_price !=0){
					$where['coin'] = $as->coin;
					$price = $db->market_prices_kraken->find($where);
					$result = iterator_to_array($price);
					$insert = [
						'max_30_days' => $as->max_price,
						'min_30_days' => $as->min_price,
						'exchange'   => 'kraken',
						'coin' => $as->coin,
						'current_market' => $result[0]['price'],
						'is_modified_30' => $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s'))
					];
					$where_kraken['coin'] = $as->coin;
					$where_kraken['exchange'] = 'kraken';
					echo"<pre>";print_r($insert);
					$db->coins_moves->updateOne($where_kraken, ['$set' => $insert], $upsert);
				} // if inner check	
			} //end foreach loop
		}//end coin for 
		//Save last Cron Executioon
		$this->last_cron_execution_time('coin move kraken month', '30d', 'coin moves kraken calculate thirty days(0    0   */30   */1   * )', 'reports');
	}//end function
	public function coin_moves_cron_ninety_kraken(){
		$coin_array_all = $this->mod_coins->get_all_coins_kraken();
		$coin_array = array_column($coin_array_all, 'symbol');
		for($coin=0; $coin <= count($coin_array); $coin++){
			// $coin= $coin_array[$coin];
			$end_date30 = date('Y-m-d H:i:s');
			$start_date30 = date('Y-m-d H:i:s', strtotime('-60 days'));

			$params90 = [];
			$params90 = [   
				'coin'       => $coin_array[$coin],
				'start_date' => (string)$start_date30,
				'end_date'   => (string)$end_date30,
			];	
			
			$jsondata = json_encode($params90);
			$curl = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_URL => "http://35.171.172.15:3000/api/minMaxMarketPrices",
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "POST",
				CURLOPT_POSTFIELDS =>$jsondata,
				CURLOPT_HTTPHEADER => array("Content-Type: application/json"), 
			));
			$response_price = curl_exec($curl);	
			curl_close($curl);                                
			$api_response90 = json_decode($response_price);
			$db = $this->mongo_db->customQuery();
			$upsert['upsert'] = true;
			foreach($api_response90 as $as){
				if($as->max_price !='' && $as->min_price !='' && $as->min_price !=0 && $as->max_price !=0){
					$where['coin'] = $as->coin;
					$price = $db->market_prices_kraken->find($where);
					$result = iterator_to_array($price);
					$insert = [
						'max_90_days' => $as->max_price,
						'min_90_days' => $as->min_price,
						'coin' => $as->coin,
						'exchange' => 'kraken',
						'current_market' => $result[0]['price'],
						'is_modified_90' => $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s'))
					];
					$where_kraken['coin'] = $as->coin;
					$where_kraken['exchange'] = 'kraken';
					$db->coins_moves->updateOne($where, ['$set' => $insert], $upsert);
					echo "<pre>";
					print_r($insert);
				} // if inner check	
			} //end foreach loop
		}
		//Save last Cron Executioon
		$this->last_cron_execution_time('coin move kraken ninety', '90d', 'coin moves kraken calculate ninety days(0   0   */90  */3  *)', 'reports');
	}//end function
	//  add for crontab details
	public function last_cron_execution_time($name, $duration, $summary, $type=null){
		//Hit CURL to update last cron execution time
		$this->load->library('mongo_db_3');
		$db_3 = $this->mongo_db_3->customQuery();
		$params = [
			'name' => $name,
			'cron_duration' 					=> $duration,
			'cron_summary'  					=> $summary,
			'type'          					=> $type,
			'last_updated_time_human_readible' 	=> date('Y-m-d H:i:s') 
		];
		$whereUpdate['name'] = $name;
		$upsert['upsert'] = true;
		$db_3->cronjob_execution_logs->updateOne($whereUpdate ,['$set' => $params], $upsert);
		// echo "<br>doneeeeeeeeeeeeee";
		
		
		// $params = [
		// 'name' => $name,
		// 'cron_duration' => $duration,
		// 'cron_summary' => $summary,
		// 'type' => $type,
		// ];
		// $req_arr = [
		// 'req_type' => 'POST',
		// 'req_params' => $params,
		// 'req_endpoint' => '',
		// 'req_url' => 'http://35.171.172.15:3000/api/save_cronjob_execution',
		// ];
		// $resp = hitCurlRequest($req_arr);
	}//End last_cron_execution_time

	public function resetSlippageReport(){
		$this->session->unset_userdata('filterSlippageReport');
		$this->coinSlippage();
	}
    public function coinSlippage(){
		$this->mod_login->verify_is_admin_login();
	    $coin_array_all = $this->mod_coins->get_all_coins();

		if($this->input->post()){
			$data_arr['filterSlippageReport'] = $this->input->post();
			$this->session->set_userdata($data_arr);
		}

		$FilterData = $this->session->userdata('filterSlippageReport');
		if(!empty($FilterData)){
			if(!empty($FilterData['filter_by_coin'])){
				$searchOrder['coin']['$in'] = $FilterData['filter_by_coin'];
			}else{
				$searchOrder['coin']['$in'] = array_column($coin_array_all, 'symbol') ; 
			}

			if(!empty($FilterData['filter_by_month'])){
				$searchOrder['month']['$in'] = $FilterData['filter_by_month'];
			}else{
				$searchOrder['month']['$in'] = [date('Y-m')] ; 
			}


			$CollectionName = 'opportunity_logs_monthly_'.$FilterData['exchange'];   

			// $searchOrder['application_mode'] = $FilterData['mode'];
			
			// if($FilterData['filter_by_start_date'] && $FilterData['filter_by_end_date']){
			// 	$startTimeMongo = $this->mongo_db->converToMongodttime($FilterData['filter_by_start_date']);

			// 	$endTimeMongo  = $this->mongo_db->converToMongodttime($FilterData['filter_by_end_date']);

			// 	$searchOrder['created_date'] = array('$gte' => $startTimeMongo, '$lte' => $endTimeMongo);
			// }
			// if($FilterData['userName']){
			// 	$where['username'] = $FilterData['userName'];
			// 	$this->mongo_db->where($where);
			// 	$userData = $this->mongo_db->get('users');
			// 	$getDetail = iterator_to_array($userData);
			// 	$searchOrder['admin_id'] =  (string)$getDetail[0]['_id'];
			// }
			// if($FilterData['opportunityId']){
			// 	$searchOrder['opportunityId'] =  (string)$FilterData['opportunityId'];
			// }
			// if($FilterData['orderId']){
			// 	$searchOrder['_id'] =  $this->mongo_db->mongoId ($FilterData['orderId']);  
			// }
			// if($FilterData['filter_by_level']){
			// 	$searchOrder['order_level']['$in'] = $FilterData['filter_by_level'];
			// }
			// $searchOrder1['is_sell_order'] 		= 'sold';
			// $searchOrder1['trading_status'] 	= 'complete';
			// $searchOrder1['status'] 			= 'FILLED';
			// $searchOrder1['cavg_parent'] 		= ['$exists' => false];
			// $searchOrder1['cost_avg']    		= ['$exists' => false];
			// $searchOrder1['avg_sell_price']  	= ['$exists' => false];


			// $searchOrder2['is_sell_order'] 		= 'sold';
			// $searchOrder2['trading_status'] 	= 'complete';
			// $searchOrder2['status'] 			= 'FILLED';
			// $searchOrder2['cavg_parent'] 		= 'yes';
			// $searchOrder2['cost_avg']    		= 'completed';
			// $searchOrder2['avg_sell_price']  	= ['$exists' => true];

			// $searchOrder['$or'] = [$searchOrder1, $searchOrder2];

			$db = $this->mongo_db->customQuery();
			$responseCount = $db->$CollectionName->count($searchOrder);
			$config['base_url']   = base_url() .'admin/coins/coinSlippage';
			$config['total_rows'] = $responseCount;
		
			$config['per_page'] = 100;
			$config['num_links'] = 3;
			$config['use_page_numbers'] = TRUE;
			$config['uri_segment'] = 4;
			$config['reuse_query_string'] = TRUE;
		
			$config['next_link'] = '&raquo;';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';
		
			$config['prev_link'] = '&laquo;';
		
			$config['prev_tag_open'] = '<li>';
			$config['prev_tag_close'] = '</li>';
		
			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';

			$config['full_tag_open'] = '<ul class="pagination">';
			$config['full_tag_close'] = '</ul>';
		
			$config['cur_tag_open'] = '<li class="active"><a href="#"><b>';
			$config['cur_tag_close'] = '</b></a></li>';
		
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
		
			$this->pagination->initialize($config);
			$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
			
			if($page !=0) 
			{
				$page = ($page-1) * $config['per_page'];
			}
			$record["links"] = $this->pagination->create_links();
			$query =
			[
				['$match' => $searchOrder],  
				['$sort'  => ['created_date' => -1]],
				['$skip'  => $page],
				['$limit' => $config['per_page']],
			];
			$response = $db->$CollectionName->aggregate($query);   
			$responseOrderReturn = iterator_to_array($response);
			$record['total']  = $responseCount;
			$record['orders'] = $responseOrderReturn;
		}
		$record['coins'] = $coin_array_all;
	    $this->stencil->paint('admin/coins/coinSlippageReport', $record);
	}

}//end controller 
