<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Check_last_balance extends CI_Controller {
	
	public function __construct(){
		
		parent::__construct();
		
		// Load Modal
		$this->load->model('admin/mod_dashboard');
		
	}


  // public function index()
  // {

  //     $admin_id = $this->session->userdata('admin_id');

  //     //Get user Details
  //     $this->db->dbprefix('settings');
  //     $this->db->where('user_id',$admin_id);
  //     $get_settings = $this->db->get('settings');
  //     $setting_arr = $get_settings->row_array();

  //     if($setting_arr['api_key'] !="" && $setting_arr['api_secret'] !="" && $setting_arr['auto_sell_enable'] =="yes"){

  //       //Get user Balance
  //       $this->db->dbprefix('coin_balance');
  //       $this->db->where('user_id',$admin_id);
  //       $get_coin_record = $this->db->get('coin_balance');
  //       $coin_record_arr = $get_coin_record->result_array();

  //       for($i=0; $i<count($coin_record_arr); $i++){

  //           $symbol = $coin_record_arr[$i]['coin_symbol'];
  //           $coin_balance = $coin_record_arr[$i]['coin_balance'];

  //           //Get Orders
  //           $run = $this->mongo_db->customQuery();
  //           $count = $run->orders->count(array('status'=>'new', 'symbol'=>$symbol, 'admin_id'=>$admin_id));

  //           if($count ==1){

  //               //Get Orders
  //               $this->mongo_db->where(array('status'=>'new', 'symbol'=>$symbol, 'admin_id'=>$admin_id));
  //               $responseArr = $this->mongo_db->get('orders');
               
  //               foreach ($responseArr as  $valueArr) {

  //                   $id = $valueArr['_id'];
  //                   $quantity = $valueArr['quantity'];
  //                   $buy_order_id = $valueArr['buy_order_id'];
  //                   $last_quantity_updated = $valueArr['last_quantity_updated'];
                    
  //                   if($last_quantity_updated !="yes"){

  //                       //Update Order Record
  //                       $upd_data = array(
  //                           'quantity' => $coin_balance,
  //                           'last_quantity_updated' => 'yes'
  //                         );

  //                       $this->mongo_db->where(array('_id'=> $id));
  //                       $this->mongo_db->set($upd_data);
  //                       $this->mongo_db->update('orders');

  //                       //////////////////////////////////////////////////////////////////////////////
  //                       ////////////////////////////// Order History Log /////////////////////////////
  //                       $log_msg = "Sell Order Quantity Updated from <b>".$quantity."</b> to <b>".$coin_balance."</b> as per your Last Order Settings";
  //                       $this->mod_dashboard->insert_order_history_log($buy_order_id,$log_msg,'auto_update_quantity',$admin_id);
  //                       ////////////////////////////// End Order History Log /////////////////////////
  //                       //////////////////////////////////////////////////////////////////////////////

  //                   }//end if last quantity not updated

                   

  //               }//end foreach

  //           }//end if last order


  //       }//end for


  //     }//end if setting is yes

  // }


}
	
