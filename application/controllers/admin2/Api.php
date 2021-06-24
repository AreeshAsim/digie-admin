<?php
/**
 *
 */
class Api extends CI_Controller {
    function __construct() {
        parent::__construct();
    }
    public function get_coin_meta() {
        $username = $this->input->server('PHP_AUTH_USER');
        $password = $this->input->server('PHP_AUTH_PW');

        if ($username == 'digiebot' && $password == 'digiebot') {
            $coin = $this->input->post('symbol');
            $ip   = getenv('HTTP_CLIENT_IP') ?:
            getenv('HTTP_X_FORWARDED_FOR') ?:
            getenv('HTTP_X_FORWARDED') ?:
            getenv('HTTP_FORWARDED_FOR') ?:
            getenv('HTTP_FORWARDED') ?:
            getenv('REMOTE_ADDR');

            if ($ip == '58.65.164.72' || true) {
                $this->load->model('admin/mod_api');
                $coin_meta = $this->mod_api->get_all_coin_meta($coin);
                $message   = $coin_meta;
                $type      = '200';
                $this->response($message, $type);
            } else {
                $message = 'You are not allowed To Access this';
                $type    = '403';
                $this->response($message, $type);
            }

        } else {

            $message = 'Sorry You are not Authorized';
            $type    = '401';
            $this->response($message, $type);

            //echo $orders_arr_arr = $this->mod_coins_info->save_coins_info();
        }

    } //end Coin meta Function

    public function get_user_orders() {
        //Basic ZGlnaWVib3Q6ZGlnaWVib3Q=
        $username = $this->input->server('PHP_AUTH_USER');
        $password = $this->input->server('PHP_AUTH_PW');

        if (($username == 'digiebot' && $password == 'digiebot') || ture) {
            $ip = getenv('HTTP_CLIENT_IP') ?:
            getenv('HTTP_X_FORWARDED_FOR') ?:
            getenv('HTTP_X_FORWARDED') ?:
            getenv('HTTP_FORWARDED_FOR') ?:
            getenv('HTTP_FORWARDED') ?:
            getenv('REMOTE_ADDR');

            if ($ip == '58.65.164.72' || true) {
                $admin_id   = $this->input->post('user_id');
                $start_date = $this->input->post('start_date');
                $end_date   = $this->input->post('end_date');
                $status     = $this->input->post('status');

                $this->load->model('admin/mod_api');
                $user_orders = $this->mod_api->get_all_user_orders($admin_id, $start_date, $end_date, $status);
                $message     = $user_orders;
                $type        = '200';
                $this->response($message, $type);
            } else {
                $message = 'You are not allowed To Access this';
                $type    = '403';
                $this->response($message, $type);
            }

        } else {

            $message = 'Sorry You are not Authorized';
            $type    = '401';
            $this->response($message, $type);

            //echo $orders_arr_arr = $this->mod_coins_info->save_coins_info();
        }

    } //end get_user_orders

    public function response($message, $type) {

        $response = array('HTTP Response' => $type, 'Message' => $message);

        echo json_encode($response);
        exit;

    } /**End of response ***/
}