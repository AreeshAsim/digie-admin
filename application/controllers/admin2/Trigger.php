<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Trigger extends CI_Controller {

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
		$this->load->model('admin/mod_users');
		$this->load->model('admin/mod_trigger');

		$this->mod_login->verify_is_admin_login();
		if ($this->session->userdata('user_role') != 1) {
			redirect(base_url() . 'forbidden');
		}
	}

	public function rules() {

		$this->mod_login->verify_is_admin_login();
		//Fetching All Categories Results
		$trigger_count = $this->mod_trigger->get_all_trigger_count();
		$data['trigger_list_count'] = $trigger_count;

		$trigger_data = $this->mod_trigger->get_all_trigger();
		$data['trigger_list_arr'] = $trigger_data;

		$this->stencil->paint('admin/trigger/manage_trigger', $data);

	}/** End of index**/

	//Add New Trigger
	public function add_new_trigger() {
		$this->mod_login->verify_is_admin_login();
		//Fetching Trigger Listing
		$get_trigger_list = $this->mod_trigger->get_all_trigger();
		$data['trigger_list_arr'] = $get_trigger_list['trigger_list_arr'];
		$data['trigger_list_count'] = $get_trigger_list['trigger_list_count'];

		$this->stencil->paint('admin/trigger/add_trigger', $data);

	} //add_new_trigger

	//Add New Trigger
	public function add_column($cat_id) {
		$this->mod_login->verify_is_admin_login();
		//Fetching Trigger Listing
		$get_trigger_list = $this->mod_trigger->get_all_trigger();
		$data['trigger_list_arr'] = $get_trigger_list['trigger_list_arr'];
		$data['trigger_list_count'] = $get_trigger_list['trigger_list_count'];
		//trigger TYPE
		$get_trigger_record = $this->mod_trigger->get_trigger_fields($cat_id);
		$data['trigger_fields'] = $get_trigger_record;
		
		
		
		$get_variables_record = $this->mod_trigger->get_variables();
		$data['variables_arr'] = $get_variables_record;
		
		//Get Trigger Data
		$get_trigger_record  = $this->mod_trigger->get_trigger($cat_id);
		$data['trigger_arr'] = $get_trigger_record['trigger_arr'];
		$data['trigger_count'] = $get_trigger_record['trigger_arr_count'];
		$data['cat_id'] = $cat_id;

		$this->stencil->paint('admin/trigger/add_trigger_type', $data);

	} //add_new_trigger

	public function update_cattype() {

		//Login Check
		$this->mod_admin->verify_is_admin_login();
		//Verify if Page is Accessable
		/*if(!in_array(38,$this->session->userdata('permissions_arr'))){
			redirect(base_url().'errors/page-not-found-404');
			exit;
		}//end if*/
		error_reporting(0);
		$meta_id = $this->input->post('meta_id');
		$value = $this->input->post('value');
		$count_id = $this->input->post('count_id');
		//If Post is not SET
		if (!isset($meta_id)) {
			redirect(base_url());
		}

		$json_array = array();
		//Updating Page
		$update_cattype = $this->mod_trigger->update_cattype($this->input->post());
		if ($update_cattype == 1) {
			$json_array['success'] = true;
			$json_array['message'] = "Your record update Successfully";
			$json_array['active_row'] = $count_id;
		} else {
			$json_array['success'] = false;
			$json_array['message'] = "Your record cannot update  Successfully";
		}
		echo json_encode($json_array);
		exit;

	}
	public function ajax_add_trigger_type_value() {
		$this->mod_login->verify_is_admin_login();
		$cat_type_value = $this->input->post('cat_type_value');
		$cat_type_id = $this->input->post('cat_type_id');
		error_reporting(0);
		//Login Check
		$this->mod_admin->verify_is_admin_login();
		$json_array = array();
		//Add trigger type
		$trigger_type_value = $this->mod_trigger->ajax_add_trigger_type_value($this->input->post());
		header('Content-Type: application/json');
		echo json_encode($trigger_type_value);
		exit;

	}

	public function ajax_delete_trigger_type_value() {
		$this->mod_login->verify_is_admin_login();
		$cat_type_value = $this->input->post('cat_type_value');
		$cat_type_id = $this->input->post('cat_type_id');
		error_reporting(0);
		//Login Check
		$this->mod_admin->verify_is_admin_login();
		$json_array = array();
		//Add trigger type
		$trigger_type_value = $this->mod_trigger->ajax_delete_trigger_type_value($this->input->post());
		header('Content-Type: application/json');
		echo json_encode($trigger_type_value);
		exit;

	}

	public function add_field_value() {

		///echo "<pre>";   print_r($this->input->post()); exit;
		$this->mod_login->verify_is_admin_login();
		$trigger_id = $this->input->post('trigger_id');

		$err_msg = '';
		if (trim($this->input->post('field_id')) == '') {
			$err_msg .= '- Field Name cannot be empty.<br>';
		} //end if(trim($this->input->post('page_title')) == '')

		if (trim($this->input->post('field_value')) == '') {
			$err_msg .= '- Field Value cannot be empty.<br>';
		} //end if(trim($this->input->post('page_title')) == '')

		if ($err_msg != '') {
			$this->session->set_flashdata('err_message', $err_msg);
			redirect(base_url() . 'admin/trigger/add-column/' . $trigger_id);
		} //end if($err_msg !='')

		$trigger_fields = $this->mod_trigger->add_field_value($this->input->post());

		if ($trigger_fields) {
			//Unset POST values from sessio
			$this->session->set_flashdata('ok_message', '- New Trigger Fields added successfully.');
			redirect(base_url() . 'admin/trigger/add-column/' . $trigger_id);

		} else {
			$this->session->set_flashdata('err_message', '- New Trigger Fields is not added. Something went wrong, please try again.');
			redirect(base_url() . 'admin/trigger/add-column/' . $trigger_id);
		} //end if($add_new_trigger)

	}

	public function add_rule_type_process() {
		
	
		
		$this->mod_login->verify_is_admin_login();
		$trigger_id = $this->input->post('trigger_id');
		//If Post is not SET
		if (!$this->input->post() && !$this->input->post('add_cat_type')) {
			redirect(base_url());
		}

		//Login Check

		if (trim($this->input->post('field_name')) == '') {
			$this->session->set_flashdata('err_message', 'Fields Name is empty.');
			redirect(base_url() . 'admin/trigger/add-column/' . $trigger_id);
		} //end if(trim($this->input->post('trigger_name')) == '')
		
		$variables_Arr = $this->mod_trigger->get_variables();
		$trigger_fields = $this->mod_trigger->add_cat_type($this->input->post());
		  
		  $html  = '';
		  foreach($trigger_fields['cat_fields_array'] as $key => $field){ 
            $html  .= '<div class="row" id="active-row-'.$key.'">
               <div class="col-md-4 col-sm-4 col-xs-4 item form-group">
                  <label for="standard-list1">Variable Name</label>
                 <input type="text" placeholder="Enter variable" name="variable" id="variable" class="form-control"  value="'.$field['variable'].'" required readonly="readonly">
                 </div>
               
               
                <div class="col-md-2 col-sm-2 col-xs-2 item form-group">
                  <label for="standard-list1">Operateor</label>
                  <input type="text" placeholder="Enter Operator" name="field_name" id="field_name" class="form-control" value="'.$field['field_name'].'" required readonly="readonly">
                 </div>
                 
                 
                <div class="col-md-4 col-sm-4 col-xs-4 item form-group">
                  <label for="standard-list1">Value</label>
                  <input type="text" placeholder="Add Value" name="field_value" id="field_value" class="form-control"  value="'. $field['field_value'].'" required readonly="readonly">
                 </div>
                  <div class="col-md-1 col-sm-1 col-xs-1 item form-group">
                  <label for="standard-list1"></label>';
            
						 $html  .= ' <a  name="delete" id="delete" class=" btn btn-danger btn-xs"  onclick="delete_cattype('. $field['field_id'].','. $key.')" style="    margin-top: 29px;">X</a>';
					
                 $html  .= '</div>
                
                 </div>';
                 
          }
		
		
		
		if ($trigger_fields) {
			$json_array['success'] = true;
			$json_array['finalArray'] = $html;
			$json_array['active_row'] = $count_id;
			$json_array['message'] = "You have Successfully added a rule type .";
		} else {
			$json_array['success'] = false;
			$json_array['message'] = "Your record cannot deleted  Successfully .";
		}
		echo json_encode($json_array);
		exit;
		
		

		if ($trigger_fields) {
			//Unset POST values from sessio
			$this->session->set_flashdata('ok_message', '- New Trigger Fields added successfully.');
			redirect(base_url() . 'admin/trigger/add-column/' . $trigger_id);

		} else {
			$this->session->set_flashdata('err_message', '- New Trigger Fields is not added. Something went wrong, please try again.');
			redirect(base_url() . 'admin/trigger/add-column/' . $trigger_id);
		} //end if($add_trigger_type_process)

	}

	public function delete_cattype() {
		$this->mod_login->verify_is_admin_login();
		error_reporting(0);
		$field_id = $this->input->post('field_id');
		$count_id = $this->input->post('active_row');
		//If Post is not SET
		if (!isset($field_id)) {
			redirect(base_url());
		}

		$json_array = array();
		//Updating Page
		$del_cattype = $this->mod_trigger->delete_cattype($field_id);
		if ($del_cattype == 1) {
			$json_array['success'] = true;
			$json_array['message'] = "Your record deleted Successfully";
			$json_array['active_row'] = $count_id;
		} else {
			$json_array['success'] = false;
			$json_array['message'] = "Your record cannot deleted  Successfully";
		}
		echo json_encode($json_array);
		exit;
	} //delete_cattype

	public function add_new_trigger_process() {

		//If Post is not SET
		$this->mod_login->verify_is_admin_login();
		if (!$this->input->post() && !$this->input->post('add_new_cat_sbt')) {
			redirect(base_url());
		}

		$data_arr['add-new-cat-data'] = $this->input->post();
		$this->session->set_userdata($data_arr);

		if (trim($this->input->post('trigger_name')) == '') {
			$this->session->set_flashdata('err_message', 'Trigger Name is empty.');
			redirect(base_url() . 'admin/trigger/add-new-trigger');

		} //end if(trim($this->input->post('trigger_name')) == '')

		$add_new_trigger = $this->mod_trigger->add_new_trigger($this->input->post());

		if ($add_new_trigger) {
			//Unset POST values from session
			$this->session->unset_userdata('add-new-cat-data');
			$this->session->set_flashdata('ok_message', '- New Trigger added successfully.');
			redirect(base_url() . 'admin/trigger/trigger');

		} else {
			$this->session->set_flashdata('err_message', '- New Trigger is not added. Something went wrong, please try again.');
			redirect(base_url() . 'admin/trigger/add-new-trigger');
		} //end if($add_new_trigger)
	} //end add_new_trigger_process

	//Edit Trigger
	public function edit_trigger($cat_id) {
		$this->mod_login->verify_is_admin_login();
		//Get Trigger Data
		$get_trigger_record = $this->mod_trigger->get_trigger($cat_id);
		$data['trigger_arr'] = $get_trigger_record['trigger_arr'];
		$data['trigger_count'] = $get_trigger_record['trigger_arr_count'];
		//if($get_trigger_record['trigger_arr_count'] == 0) redirect(base_url().'errors/page-not-found-404');
		$this->stencil->paint('admin/trigger/edit_trigger', $data);

	} //edit_trigger

	public function edit_trigger_process() {
		$this->mod_login->verify_is_admin_login();
		if (trim($this->input->post('trigger_name')) == '') {

			$this->session->set_flashdata('err_message', 'Trigger Name is empty.');
			redirect(base_url() . 'admin/trigger/add-new-trigger');

		} //end if(trim($this->input->post('trigger_name')) == '')

		$upd_new_trigger = $this->mod_trigger->edit_trigger($this->input->post());

		if ($upd_new_trigger) {

			$this->session->set_flashdata('ok_message', ' Trigger Updated successfully.');
			redirect(base_url() . 'admin/trigger/edit-trigger/' . $this->input->post('cat_id'));

		} else {
			$this->session->set_flashdata('err_message', ' Trigger is not updated. Something went wrong, please try again.');
			redirect(base_url() . 'admin/trigger/trigger');

		} //end if($upd_new_trigger)

	} //end edit_trigger_process

	public function change_cattype() {
		$this->mod_login->verify_is_admin_login();
		$cat_type_id = $this->input->post('cat_type_id');
		$html_structure = $this->input->post('html_structure');

		//If Post is not SET
		if (!isset($cat_type_id)) {
			redirect(base_url());
		}

		$json_array = array();
		//Updating Page
		$change_cattype = $this->mod_trigger->change_cattype($cat_type_id, $html_structure);
		if ($change_cattype == 1) {
			$json_array['success'] = true;
			$json_array['message'] = "You change type Successfully";

		} else {
			$json_array['success'] = false;
			$json_array['message'] = "Your cannot change the type Something went wrong";
		}
		echo json_encode($json_array);
		exit;

	}

	public function delete_trigger() {
		$this->mod_login->verify_is_admin_login();
		$cat_id = $this->input->post('cat_id');
		$count_id = $this->input->post('active_row');
		//Login Check

		//If Post is not SET
		if (!isset($cat_id)) {
			redirect(base_url());
		}

		$json_array = array();
		//Updating Page
		$del_trigger = $this->mod_trigger->delete_trigger($cat_id);
		if ($del_trigger == 1) {
			$json_array['success'] = true;
			$json_array['message'] = "Your record deleted Successfully";
			$json_array['active_row'] = $count_id;
		} else {
			$json_array['success'] = false;
			$json_array['message'] = "Your record cannot deleted  Successfully";
		}
		echo json_encode($json_array);
		exit;
	} //end delete_trigger

	public function get_cat_fields() {
		$this->mod_login->verify_is_admin_login();
		$cat_id = $this->input->post('cat_id');
		//If Post is not SET
		if (!isset($cat_id)) {
			redirect(base_url());
		}

		$json_array = array();
		//Updating Page
		$get_trigger_type = $this->mod_trigger->get_trigger_type($cat_id);
		if ($get_trigger_type == 1) {
			$json_array['success'] = true;
			$json_array['message'] = "Your record deleted Successfully";
			$json_array['active_row'] = $count_id;
		} else {
			$json_array['success'] = false;
			$json_array['message'] = "Your record cannot deleted  Successfully";
		}
		echo json_encode($json_array);
		exit;
	} //end get_cat_fields

	public function change_trigger() {
		$this->mod_login->verify_is_admin_login();
		$cat_id = $this->input->post('cat_id');
		$cat_id = 1;
		//If Post is not SET
		if (!isset($cat_id)) {
			redirect(base_url());
		}

		$json_array = array();
		//Updating Page
		$get_trigger_type = $this->mod_trigger->getCategories($cat_id);

		if ($get_trigger_type) {
			$json_array['success'] = true;
			$json_array['message'] = "Your record deleted Successfully";
			$json_array['finalArray'] = $get_trigger_type;
		} else {
			$json_array['success'] = false;
			$json_array['message'] = "Your record cannot deleted  Successfully";
		}
		echo json_encode($json_array);
		exit;
	} //end get_cat_fields

}
