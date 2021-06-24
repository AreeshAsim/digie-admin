<?php
/**
 *
 */
class Merge_trades extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->stencil->layout('admin_layout');
		//load required slices
		$this->stencil->slice('admin_header_script');
		$this->stencil->slice('admin_header');
		$this->stencil->slice('admin_left_sidebar');
		$this->stencil->slice('admin_footer_script');
  }

  // public function merge_all_orders($symbol,$user_id){
  //     $search['status'] = 'FILLED';
  //     $search['symbol'] = $symbol;
  //     $search['admin_id'] = $user_id;
  //     $search['is_sell_order'] = 'yes';

  //     $this->mongo_db->where($search);
  //     $iterator = $this->mongo_db->get("buy_orders");
  //     $data['order_arr'] = iterator_to_array($iterator);
  //     $data['symbol'] = $symbol;
  //     $data['admin_id'] = $user_id;
  //     $this->stencil->paint('admin/extra_views/index',$data);
  // }

  // public function sell_merged_order(){
  //   $data_post = $this->input->post();
    
  // }
}
