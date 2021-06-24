<?php 
/**
 * 
 */
	class Migrate_db_controller extends CI_Controller{
		function __construct()
		{
			parent::__construct();
			$this->stencil->layout('admin_layout');
			//load required slices
			$this->stencil->slice('admin_header_script');
			$this->stencil->slice('admin_header');
			$this->stencil->slice('admin_left_sidebar');
			$this->stencil->slice('admin_footer_script');
		
			$this->load->model('admin/mod_login');
		}
		// public function index(){
		// 	$this->mod_login->verify_is_admin_login();
		// 	$this->stencil->paint('admin/migrate_db/insert_collection');
		// }

		// public function update(){
		// 	$this->mod_login->verify_is_admin_login();
		// 	if($this->input->post()){
		// 		$url = $this->input->post('json_file_url');
		// 		$extension = pathinfo($url, PATHINFO_EXTENSION);
		// 		print_r($url);
		// 		print_r("<br>extension = ".$extension);
		// 		$collection_name = $this->input->post('collection_name'); 
		// 		if(!empty($url)){
		// 			$json_file = file_get_contents($url);
		// 			$json_file_converted = json_decode($json_file, true);
		// 			if(!empty($collection_name) && $extension == 'json'){
		// 				foreach($json_file_converted as $value){
		// 				$db = $this->mongo_db->customQuery();
		// 				$where['_id'] = $this->mongo_db->mongoId($value['_id']);
		// 				$upsert['upsert'] = true; 
		// 				// $db->$collection_name->updateOne($where, ['$set'=> $value], $upsert);
		// 				}//end loop
		// 				echo "<br>Done";
		// 			}else{
		// 				echo "<br>file extension is not valid";
		// 			}
		// 		}
		// 	}
		// }
	}// end controller 
