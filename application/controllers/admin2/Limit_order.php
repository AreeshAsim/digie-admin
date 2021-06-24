<?php 
/**
* 
*/
class Limit_order extends CI_Controller
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
		$this->load->model('admin/mod_coins');
		$this->load->model('admin/mod_candel');
        $this->load->model('admin/mod_limit_order');
		$this->load->model('admin/mod_box_trigger_3');
	}

	public function index()
	{
		exit('Remove to continue');
		$coins = $this->mod_coins->get_all_coins();
		$data['coins'] = $coins; 
        $this->stencil->paint('admin/dashboard/add_candle_setting',$data);
	}

	public function cron_job_cancelled_limit_orders(){
		exit('Remove to continue');
		$response = $this->mod_limit_order->cancel_buy_trade();
		$response = $this->mod_limit_order->cancel_sell_trade();
	} //End of cron_job_cancelled_limit_orders

    public function get_order_status(){
		exit('Remove to continue');
		$response = $this->mod_limit_order->cancel_buy_trade($type='buy');

		exit;

        $symbol = 'NCASHBTC';
        $quantity = 1500;
        $user_id = $this->session->userdata('admin_id');
        $price = '0.00000072';
        
        
        // $res_0 = $this->binance_api->get_all_orders_history($symbol, $user_id);
        // echo '<pre>';
        // print_r($res_0);
        // exit;

		// echo '-------------';
		// $order = $this->binance_api->place_buy_limit_order($symbol, $quantity, $price, $user_id);

		// echo '<pre>';
		// print_r($order);
		// exit;

		
		$order_id = 21203150;
		$order = $this->binance_api->order_status($symbol, $order_id, $user_id );
		echo '<pre>';
		print_r($order);

		exit;
		
		$cancel_order = $this->binance_api->cancel_order($symbol, $order_id, $user_id);
		echo '<pre>';
        print_r($cancel_order);



		
        
    }// get_order_status
   


}//End Of Limit_order
?>

