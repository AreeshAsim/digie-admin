<?php
/**
 *
 */
class Api_trend_setting extends CI_Controller {
    function __construct() {
        parent::__construct();
    }
    // public function post_market_trends() {

    //     $username = 'digiebot'; //$this->input->server('PHP_AUTH_USER');
    //     $password = 'digiebot'; //$this->input->server('PHP_AUTH_PW');
    //     $post_data = $this->input->post();

    //     $ip   = getenv('HTTP_CLIENT_IP') ?:
    //     getenv('HTTP_X_FORWARDED_FOR') ?:
    //     getenv('HTTP_X_FORWARDED') ?:
    //     getenv('HTTP_FORWARDED_FOR') ?:
    //     getenv('HTTP_FORWARDED') ?:
    //     getenv('REMOTE_ADDR');

    //     if ($username != 'digiebot' && $password != 'digiebot') {
    //         $message = 'access denied';
    //         $type    = '401';
    //         $this->response($message, $type);
    //     }else if($ip =='45.115.84.51 ---'){
    //         $message   = 'access denied';
    //         $type      = '403';
    //         $this->response($message, $type);
    //     }else if(empty($post_data)){
    //         $message   = 'Method Not Allowed';
    //         $type      = '405';
    //         $this->response($message, $type);
    //     }else if(empty($post_data['coin'])){
        
    //         $message   = 'Bad Request - the request could not be understood or was missing required parameter coin symbol';
    //         $type      = '400';
    //         $this->response($message, $type);
    //     }else{
    //         $this->save_trend_setting($post_data);
    //     }
    // } //end Coin meta Function

    // public function save_trend_setting($post_data)
    // {

    //     if(isset($post_data['market_trend']) && ($post_data['market_trend'] !='')){
    //         $insert_arr['market_trend'] = strtoupper($post_data['market_trend']);
    //     }

    //     if(isset($post_data['caption_option']) && ($post_data['caption_option'] !='')){
    //         $insert_arr['caption_option'] = (float)$post_data['caption_option'];
    //     }

    //     if(isset($post_data['meta_trading']) && ($post_data['meta_trading'] !='')){
    //         $insert_arr['meta_trading'] = (float)$post_data['meta_trading'];
    //     }

        
    //     if(isset($post_data['demand']) && ($post_data['demand'] !='')){
    //         $insert_arr['demand'] = strtolower($post_data['demand']);
    //     }
        
    //     if(isset($post_data['supply']) && ($post_data['supply'] !='')){
    //         $insert_arr['supply'] =strtolower($post_data['supply']);
    //     }

        
    //     if(isset($post_data['caption_score']) && ($post_data['caption_score'] !='')){
    //         $insert_arr['caption_score'] = (float)$post_data['caption_score'];
    //     }


    //     if(isset($post_data['riskpershare']) && ($post_data['riskpershare'] !='')){
    //         $insert_arr['riskpershare'] = (float)$post_data['riskpershare'];
    //     }

    //     if(isset($post_data['buy']) && ($post_data['buy'] !='')){
    //         $insert_arr['buy'] =(float) $post_data['buy'];
    //     }

    //     if(isset($post_data['sell']) && ($post_data['sell'] !='')){
    //         $insert_arr['sell'] = (float)$post_data['sell'];
    //     }

    //     if(isset($post_data['RL']) && ($post_data['RL'] !='')){
    //         $insert_arr['RL'] = (float)$post_data['RL'];
    //     }

    //     if(isset($post_data['long_term_intension']) && ($post_data['long_term_intension'] !='')){  //added by abbas new feild , need to give them,
    //         $insert_arr['long_term_intension'] = (float)$post_data['long_term_intension'];
    //     }


    //     if(empty($insert_arr)){
    //         $message   = 'At Least one parameter required';
    //         $type      = '405';
    //         $this->response($message, $type);
    //     }else{
    //         $db = $this->mongo_db->customQuery();
    //         $search_criteria['coin'] = $post_data['coin'];
    //         $upsert['upsert'] = true;
    //         $set['$set'] = $insert_arr;
    //         $resp = $db->market_trending->updateOne($search_criteria,$set,$upsert);
    //         $message['message']   = 'Trending  Submitted successfully.';
    //         $type      = '200';
    //         $this->response($message, $type);
    //     }
        
    // }//End of 

    // public function response($message, $type) {

    //     $response = array('HTTP Response' => $type, 'Message' => $message);

    //     echo json_encode($response);
    //     exit;

    // } /**End of response ***/


    // public function run(){
        
    //     $res = $this->mongo_db->get('market_trending');
    //     echo '<pre>';
    //     print_r(iterator_to_array($res));
    // }

}