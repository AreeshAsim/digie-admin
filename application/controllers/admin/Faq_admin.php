<?php
/**
 *
 */
class Faq_admin extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->stencil->layout('admin_layout');
        //load required slices
        $this->stencil->slice('admin_header_script');
        $this->stencil->slice('admin_header');
        $this->stencil->slice('admin_left_sidebar');
        $this->stencil->slice('admin_footer_script');
    }

    public function index() {
        $data['questions'] = $this->get_faq_client_q();
        $this->stencil->paint("admin/faq/faq_admin", $data);
    }

    public function faq_add_process() {
        $faq_question = $this->input->post('faq_question');
        $faq_answer = $this->input->post('faq_answer');
        $faq_type = $this->input->post('faq_type');
        $hidden_id = $this->input->post("hidden_id");
        $insert_arr = array('faq_question' => $faq_question, 'faq_answer' => $faq_answer, 'faq_type' => $faq_type);

        $this->mongo_db->insert("faq_questions", $insert_arr);

        if ($hidden_id != 'empty') {
            $this->mongo_db->where(array('_id' => $hidden_id));
            $this->mongo_db->set(array('status' => '1'));
            $this->mongo_db->update("faq_client_question");
        }
    }

    public function faq_update_process() {
        $faq_question = $this->input->post('faq_question');
        $faq_answer = $this->input->post('faq_answer');
        $faq_type = $this->input->post('faq_type');
        $hidden_id = $this->input->post("hidden_id");
        $insert_arr = array('faq_question' => $faq_question, 'faq_answer' => $faq_answer, 'faq_type' => $faq_type);

        if ($hidden_id != 'empty') {
            $this->mongo_db->where(array('_id' => $hidden_id));
            $this->mongo_db->set($insert_arr);
            $this->mongo_db->update("faq_questions");
        }
    }

    public function faq_add_client_process() {
        $faq_question = $this->input->post('faq_question');
        $user_id = $this->session->userdata("admin_id");
        $username = $this->session->userdata("username");
        $insert_arr = array('faq_question' => $faq_question, 'status' => '0', 'username' => $username, 'user_id' => $user_id);

        $this->mongo_db->insert("faq_client_question", $insert_arr);
    }

    public function get_faq_client_q() {
        $this->mongo_db->where(array('status' => '0'));
        $iterator = $this->mongo_db->get("faq_client_question");
        $retArr = iterator_to_array($iterator);
        return $retArr;
    }
    public function faq() {
        $data['faq'] = $this->get_faqs();
        $this->stencil->paint("admin/faq/faq", $data);
    }

    public function faq_listing() {
        $iterator = $this->mongo_db->get("faq_questions");
        $faq_arr = iterator_to_array($iterator);

        $data['faq'] = $faq_arr;
        $this->stencil->paint("admin/faq/faq_listing", $data);

    }

    public function edit_faq($id = '') {
        $this->mongo_db->where(array('_id' => $this->mongo_db->mongoId($id)));
        $iterator = $this->mongo_db->get("faq_questions");
        $faq_arr = iterator_to_array($iterator);
        $faq = $faq_arr[0];
        $data['faq'] = $faq;

        $this->stencil->paint("admin/faq/faq_edit", $data);
    }

    public function get_faqs() {
        $iterator = $this->mongo_db->get("faq_questions");

        $Digiebot = array();
        $Balance = array();
        $Trades = array();
        $Rules = array();
        $Triggers = array();
        $Errors = array();
        $Others = array();

        foreach ($iterator as $key => $value) {
            if ($value['faq_type'] == 'Digiebot') {
                array_push($Digiebot, $value);
            }
            if ($value['faq_type'] == 'Balance') {
                array_push($Balance, $value);
            }
            if ($value['faq_type'] == 'Trades') {
                array_push($Trades, $value);
            }
            if ($value['faq_type'] == 'Rules') {
                array_push($Rules, $value);
            }
            if ($value['faq_type'] == 'Triggers') {
                array_push($Triggers, $value);
            }
            if ($value['faq_type'] == 'Errors') {
                array_push($Errors, $value);
            }
            if ($value['faq_type'] == 'Others') {
                array_push($Others, $value);
            }
        }

        $retArr['Digiebot'] = $Digiebot;
        $retArr['Balance'] = $Balance;
        $retArr['Trades'] = $Trades;
        $retArr['Rules'] = $Rules;
        $retArr['Triggers'] = $Triggers;
        $retArr['Errors'] = $Errors;
        $retArr['Others'] = $Others;
        // echo "<pre>";
        // print_r($retArr);
        // exit;
        return $retArr;
    }
}