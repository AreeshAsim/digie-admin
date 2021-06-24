<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Automatic_query_bulder extends CI_Controller {
function __construct() {
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
		$this->load->model('admin/mod_candel');
		$this->load->model('admin/mod_realtime_candle_socket');
		$this->load->model('admin/mod_box_trigger_3');
		$this->load->model('admin/mod_barrier_trigger');
		$this->load->model('admin/mod_chart3');
		$this->load->model('admin/mod_custom_script');
		$this->load->model('admin/mod_Automatic_query_bulder');
		
	}

	public function index(){
		$data = $this->mongo_db->show_All_Collections();
		$data['collections'] = $data;
		$this->stencil->paint('admin/automatic_query_bulder/home', $data);
		
	}//End index

	public function get_collection_fields(){

		 $collection_name = $this->input->post('collection_name');
		$collection_arr = $this->mod_Automatic_query_bulder->get_collection_fields($collection_name);

		$html = '';
		if(!empty($collection_arr)){
			$index = 1;
			foreach ($collection_arr[0] as $key => $value) {
				$html .='<tr>
					<td>'.$index.'</td>
					<td>'.$key.'
					<input type="hidden" value="'.$key.'" id="field_'.$index.'">
					</td>
					<td>'.gettype($value).'</td>
					<td>
						<select class="form-control" id="operator_id_'.$index.'">
							<option value="" >Select Operator</option>
							<option value=">" > > </option>
							<option value="<" > < </option>
							<option value="==" > == </option>
							<option value="<=" > <= </option>
							<option value=">=" > >= </option>
							<option value="!" > ! </option>
						</select>
					</td>
					<td><input class="form-control" type="text" value="" id="compare_value_'.$index.'"> </td>
					<td>
						<div class="checkbox">
						<label><input type="checkbox" class="enable_disable_cls" id="enable_disable_'.$index.'" value="'.$index.'"> Enable/Disable Operation </label>
						</div>            
					</td>
					</tr>';


					
					$index++;				 
			}//End of for each collection
		}//End of check empty

		echo $html;
		exit();


	}//End of get_collection_fields

}//End of Controller
