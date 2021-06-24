<?php
/**
 *
 */
class Cron_listing extends CI_Controller
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

    $this->load->model('admin/mod_cronjob_listing');
  }

  // public function index(){
  //   $data_arr = $this->mod_cronjob_listing->get_cron_listing();
  //   $data['cron_list'] = $data_arr;
  //   $this->stencil->paint('admin/cron_listing/index',$data);
  // }

  // public function cron_list(){
  //   $output = shell_exec('crontab -l');
  //   echo "<pre>";
  //   echo $output;
  // }
  // public function add_cronjob()
  // {
  //   $this->stencil->paint('admin/cron_listing/add_cron');
  // }

  // public function add_cronjob_process(){
  //   //Adding add_user
	// 	$cron_id = $this->mod_cronjob_listing->add_cronjob($this->input->post());

	// 	if ($cron_id) {

	// 		$this->session->set_flashdata('ok_message', 'Cron added successfully with id.'. $cron_id);
	// 		redirect(base_url() . 'admin/cron-listing/add-cronjob');

	// 	} else {

	// 		$this->session->set_flashdata('err_message', 'Cron cannot added. Something went wrong, please try again.');
	// 		redirect(base_url() . 'admin/cron-listing/add-cronjob');

	// 	} //end if
  // }

  // public function test(){
  //   $url = 'https://app.digiebot.com/index.php/admin/candle_chart/get_market_trade_quarterly_history';
  //   $test = $this->mod_cronjob_listing->check_when_last_cron_ran($url);

  // }
}
