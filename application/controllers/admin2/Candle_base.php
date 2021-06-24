<?php
/**
 *
 */
class Candle_base extends CI_Controller {

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
		$this->load->model('admin/mod_coins');
		$this->load->model('admin/mod_candle_base');

		if ($this->session->userdata('user_role') != 1) {
			redirect(base_url() . 'forbidden');
		}
	}

	public function index() {
		$this->mod_login->verify_is_admin_login();
		$coins = $this->mod_candle_base->get_all_data();
		$data['settings_arr'] = $coins;
		$this->stencil->paint("admin/candle_base/candle_base", $data);
	}

	public function add_base_candle() {
		$this->mod_login->verify_is_admin_login();
		$coins = $this->mod_coins->get_all_coins();
		$data['coins'] = $coins;
		$this->stencil->paint("admin/candle_base/add_candle_base", $data);
	}

	public function search_base_candle() {
		$this->mod_login->verify_is_admin_login();
		$coins = $this->mod_coins->get_all_coins();
		$data['coins'] = $coins;
		$this->stencil->paint("admin/candle_base/search_candle_base", $data);
	}

	public function save_candle_base() {
		$this->mod_login->verify_is_admin_login();
		$save_base = $this->mod_candle_base->save_candle_base($this->input->post());
		if ($save_base) {

			$this->session->set_flashdata('ok_message', 'Base Value added successfully.');
			redirect(base_url() . 'admin/candle_base/');

		} else {

			$this->session->set_flashdata('err_message', 'Problem Reported. Something went wrong, please try again.');
			redirect(base_url() . 'admin/candle_base/');
		}
	}

	public function get_base_values($coin, $start_date, $interval) {
		//date_default_timezone_set("ASIA/KARACHI");
		/*$coin = $this->input->post('coins');
		$start_date = $this->input->post('start_date');
		$interval = $this->input->post('interval');*/
		$this->mod_login->verify_is_admin_login();
		$start_date = date("Y-m-d g:i:s", strtotime($start_date));

		$start_date_mongo = $this->mongo_db->converToMongodttime($start_date);

		$params['coin'] = $coin;
		$params['start_date'] = array('$lte' => $start_date_mongo);
		$params['end_date'] = array('$gte' => $start_date_mongo);
		$params['interval'] = $interval;
		$this->mongo_db->where($params);
		$this->mongo_db->sort(array('_id' => -1));
		$this->mongo_db->limit(1);
		$res = $this->mongo_db->get('base_candles');

		foreach ($res as $key => $value) {
			if (!empty($value)) {
				$datetime = $value['start_date']->toDateTime();
				$created_date = $datetime->format(DATE_RSS);

				$datetime = new DateTime($created_date);
				$datetime->format('Y-m-d g:i:s A');

				$formated_date_time = $datetime->format('Y-m-d g:i:s A');

				$datetime1 = $value['end_date']->toDateTime();
				$created_date1 = $datetime1->format(DATE_RSS);

				$datetime1 = new DateTime($created_date1);
				$datetime1->format('Y-m-d g:i:s A');

				$formated_date_time1 = $datetime1->format('Y-m-d g:i:s A');

				$returnArr['id'] = $value['_id'];
				$returnArr['start_date'] = $formated_date_time;
				$returnArr['coin'] = $value['coin'];
				$returnArr['end_date'] = $formated_date_time1;
				$returnArr['base_value'] = $value['base_value'];
				$final_arr[] = $returnArr;
			}
		}
		return $final_arr[0]['base_value'];
	}

	public function dropTable() {
		$get_data = $this->mongo_db->drop_collection('base_candles');

		echo $get_data;
		exit;
	}

	public function edit_base($id) {
		//Login Check
		$this->mod_login->verify_is_admin_login();

		$coins = $this->mod_coins->get_all_coins();
		$data['coins'] = $coins;
		//Fetching user Record
		$base_arr = $this->mod_candle_base->get_base($id);

		$data['base_arr'] = $base_arr;
		$data['base_id'] = $id;

		$this->stencil->paint("admin/candle_base/edit_candle_base", $data);
	}

	public function edit_candle_base() {
		$this->mod_login->verify_is_admin_login();
		$save_base = $this->mod_candle_base->edit_candle_base($this->input->post());
		if ($save_base) {

			$this->session->set_flashdata('ok_message', 'Base Value Updated successfully.');
			redirect(base_url() . 'admin/candle_base/');

		} else {

			$this->session->set_flashdata('err_message', 'Problem Reported. Something went wrong, please try again.');
			redirect(base_url() . 'admin/candle_base/');
		}
	}

	public function delete_base($id) {
		$this->mod_login->verify_is_admin_login();
		$this->mongo_db->where(array('_id' => $id));
		$del_id = $this->mongo_db->delete('base_candles');

		if ($del_id) {
			$this->session->set_flashdata('ok_message', 'Base Value Deleted successfully.');
			redirect(base_url() . 'admin/candle_base/');

		} else {

			$this->session->set_flashdata('err_message', 'Problem Reported. Something went wrong, please try again.');
			redirect(base_url() . 'admin/candle_base/');
		}
	}

}