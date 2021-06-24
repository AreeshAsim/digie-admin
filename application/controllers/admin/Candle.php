<?php
defined('BASEPATH') or exit('No direct script access allowed');
// Don't forget include/define REST_Controller path

/**
 *
 * Controller Candle
 *
 * This controller for ...
 *
 * @package   CodeIgniter
 * @category  Controller CI
 * @author    Setiawan Jodi <jodisetiawan@fisip-untirta.ac.id>
 * @author    Raul Guerrero <r.g.c@me.com>
 * @link      https://github.com/setdjod/myci-extension/
 * @param     ...
 * @return    ...
 *
 */

class Candle extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    //load main template

    $this->stencil->layout('admin_layout');
    ini_set("memory_limit" , -1);
    //load required slices

    $this->stencil->slice('admin_header_script');

    $this->stencil->slice('admin_header');

    $this->stencil->slice('admin_left_sidebar');

    $this->stencil->slice('admin_footer_script');

    $this->load->model('admin/mod_login');
  }

  // public function index()
  // {
  //   //
  //   $this->mod_login->verify_is_admin_login();
  //     // set post fields
  //     $post = [
  //       'symbol' => $this->session->userdata('global_symbol'),
  //     ];

  //     $ch = curl_init('https://scripts.digiebot.com/admin/candles_api/get_candles');
  //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  //     curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

  //     // execute!
  //     $response = curl_exec($ch);
  //     $result = json_decode($response);
  //     $data = json_decode(json_encode($result), TRUE);
  //     // close the connection, release resources used
  //     curl_close($ch);
  //     //echo $response;

  //     if($_GET['waqar'] == 'true'){
  //       echo "<pre>";
  //       print_r($data);
  //       exit;
  //     }
  //     $data['offset'] = 15;
  //     // do anything you want with your response
  //     $this->stencil->paint('admin/candle_stick/candlesdtick22', $data);
  // }

  // public function candle_old_2()
  // {
  //   //
  //   $this->mod_login->verify_is_admin_login();
  //   if(isset($_GET['perc']) && $_GET['perc']!= ''){
  //     $var = $_GET['perc'];
  //   }else{
  //     $var = 10;
  //   }
  //   $post = [
  //     'symbol' => $this->session->userdata('global_symbol'),
  //     'var' => $var,
  //     'percentile_type' => 'both',
  //     'percentile' => '10',
  //     'radius' => '5'
  //   ];

  //     $ch = curl_init('https://scripts.digiebot.com/admin/Candles_one_api/get_candles');
  //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  //     curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

  //     // execute!
  //     $response = curl_exec($ch);
  //     $result = json_decode($response);
  //     $data = json_decode(json_encode($result), TRUE);
  //     // close the connection, release resources used
  //     curl_close($ch);
  //     //echo $response;

  //     if($_GET['waqar'] == 'true'){
  //       echo "<pre>";
  //       print_r($data);
  //       exit;
  //     }
  //     $data['offset'] = 15;
  //     // do anything you want with your response
  //     $this->stencil->paint('admin/candle_stick/candlesdtick22_old2', $data);
  // }


  // public function candle_old()
  // {
  //   //
  //   $this->mod_login->verify_is_admin_login();
  //   if(isset($_GET['perc']) && $_GET['perc']!= ''){
  //     $var = $_GET['perc'];
  //   }else{
  //     $var = 10;
  //   }

  //   if(isset($_GET['radius']) && $_GET['radius']!= ''){
  //     $var1 = $_GET['radius'];
  //   }else{
  //     $var1 = 5;
  //   }
  //   $post = [
  //     'symbol' => $this->session->userdata('global_symbol'),
  //     'var' => $var,
  //     'percentile_type' => 'both',
  //     'percentile' => '10',
  //     'radius' => $var1
  //   ];

  //     $ch = curl_init('https://scripts.digiebot.com/admin/Candles_one_api/get_candles');
  //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  //     curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

  //     // execute!
  //     $response = curl_exec($ch);
  //     $result = json_decode($response);
  //     $data = json_decode(json_encode($result), TRUE);
  //     // close the connection, release resources used
  //     curl_close($ch);
  //     //echo $response;

  //     if($_GET['waqar'] == 'true'){
  //       echo "<pre>";
  //       print_r($data);
  //       exit;
  //     }
  //     $data['offset'] = 15;
  //     // do anything you want with your response
  //     $this->stencil->paint('admin/candle_stick/candlesdtick22_old', $data);
  // }

  // public function autoload_ajax_data()
  // {
  //   //

  //     // set post fields
  //     $post = [
  //       'symbol' => $this->session->userdata('global_symbol'),
  //     ];

  //     if ($this->input->post('previous_date')) {
  //       $post['previous_date'] = $this->input->post('previous_date');
  //     }

  //     $forward_date = '';

  //     if ($this->input->post('forward_date')) {
  //       $post['forward_date'] = $this->input->post('forward_date');
  //     }

  //     $ch = curl_init('https://scripts.digiebot.com/admin/candles_api/get_candles');
  //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  //     curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

  //     // execute!
  //     $response = curl_exec($ch);
  //     $result = json_decode($response);
  //     $data = json_decode(json_encode($result), TRUE);
  //     // close the connection, release resources used
  //     curl_close($ch);
  //     //echo $response;

  //     //echo "<pre>";
  //     //print_r($data);
  //     //exit;
  //     $data['offset'] = 15;
  //     // do anything you want with your response
  //     echo json_encode($data);
  //     exit;
  // }

  // public function autoload_ajax_data_old()
  // {
  //   //

  //     // set post fields
  //     $post = [
  //       'symbol' => $this->session->userdata('global_symbol'),
  //     ];

  //     if ($this->input->post('previous_date')) {
  //       $post['previous_date'] = $this->input->post('previous_date');
  //     }

  //     $forward_date = '';

  //     if ($this->input->post('forward_date')) {
  //       $post['forward_date'] = $this->input->post('forward_date');
  //     }

  //     if ($this->input->post('percentile_type')) {
  //       $post['percentile_type'] = $this->input->post('percentile_type');
  //     }else{
  //       $post['percentile_type'] = "both";
  //     }

  //     if ($this->input->post('percentile')) {
  //       $post['percentile'] = $this->input->post('percentile');
  //     }else{
  //       $post['percentile'] = "10";
  //     }

  //     if ($this->input->post('radius')) {
  //       $post['radius'] = $this->input->post('radius');
  //     }else{
  //       $post['radius'] = "5";
  //     }

  //     $ch = curl_init('https://scripts.digiebot.com/admin/Candles_one_api/get_candles');
  //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  //     curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

  //     // execute!
  //     $response = curl_exec($ch);
  //     $result = json_decode($response);
  //     $data = json_decode(json_encode($result), TRUE);
  //     // close the connection, release resources used
  //     curl_close($ch);
  //     //echo $response;

  //     //echo "<pre>";
  //     //print_r($data);
  //     //exit;
  //     $data['offset'] = 15;
  //     // do anything you want with your response
  //     echo json_encode($data);
  //     exit;
  // }


}


/* End of file Candle.php */
/* Location: ./application/controllers/Candle.php */
