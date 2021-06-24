<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Highchart extends CI_Controller
{
    public function __construct()
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
        $this->load->model('admin/mod_sockets');
        $this->load->model('admin/mod_highchart');
    }
	
    // public function index()
    // {
	// 	$this->mod_login->verify_is_admin_login();
	// 	$data['hide_chart']  = 1;
	// 	$all_coins_arr       = $this->mod_sockets->get_all_coins();
	// 	$data['coins_arr']   = array_reverse($all_coins_arr);
		
	// 	$global_symbol = $this->session->userdata('global_symbol');
	// 	$form_sesion_data_arr = $this->mod_highchart->get_sesion_data($global_symbol);
	// 	$data['session_data_array']           = $form_sesion_data_arr;
		
		
	// 	$data['endDate']     = date('m/d/Y h:00 A', strtotime(date('m/d/Y H:i:s')));
	// 	$data['startDate']   = date('m/d/Y h:00 A', strtotime('-1 hours'));
		
		
	// 	$this->stencil->paint('admin/highchart/candle_report', $data);
    // } //End index
    // public function coin_average()
    // {
    //     //Login Check
    //     $this->mod_login->verify_is_admin_login();
    //     $all_coins_arr     = $this->mod_sockets->get_all_coins();
    //     $finalArr[]        = array(
    //         'coin_name' => 'Bitcoin',
    //         'symbol'    => 'BTC'
    //     );
    //     $all_coins_arrList = array_merge($all_coins_arr, $finalArr);
    //     $time              = $this->input->post('time');
    //     $timezone          = $this->session->userdata('timezone');
    //     if ($this->input->post()) {
    //         $this->session->set_userdata(array(
    //             'page_post_data_coin' => $this->input->post()
    //         ));
    //     }
    //     if ($this->input->post('clear') == 'clear') {
    //         $this->session->unset_userdata('page_post_data_coin');
    //         $this->session->unset_userdata(array(
    //             'page_post_data_coin' => $this->input->post()
    //         ));
    //     }
    //     if ($time == '') {
    //         $time = 'minut';
    //     } else {
    //         $time = $time;
    //     }
    //     if ($this->input->post('start_date') != '' && $this->input->post('end_date') == '') {
    //         $this->session->set_flashdata('err_message', 'Please add the End date .');
    //         redirect(base_url() . 'admin/highchart/coin-average');
    //     }
    //     if ($this->input->post('start_date') == '' && $this->input->post('end_date') != '') {
    //         $this->session->set_flashdata('err_message', 'Please add the Start date .');
    //         redirect(base_url() . 'admin/highchart/coin-average');
    //     }
    //     if ($this->input->post('start_date') != '' && $this->input->post('end_date') != '' && $time == 'hour') {
    //         $start_dateOrg  = $this->input->post('start_date');
    //         $newDateTime    = $this->input->post('start_date');
    //         $end_dateA      = $this->input->post('end_date');
    //         $start_date     = strtotime($start_dateOrg);
    //         $start_dateGG   = date("Y-m-d G:i:00", $start_date);
    //         $lastHour       = $start_date + 3600;
    //         $endDateHour    = date("Y-m-d G:00:00", $lastHour);
    //         $end_date       = strtotime($end_dateA);
    //         $end_date       = date("Y-m-d G:i:s", $end_date);
    //         $starttimestamp = strtotime($start_dateOrg);
    //         $endtimestamp   = strtotime($end_dateA);
    //         $difference     = abs($endtimestamp - $starttimestamp) / 3600;
    //         $totalHours     = $difference;
    //         $z              = 1;
    //         for ($x = 0; $x <= $totalHours; $x++) {
    //             $new                  = 3600;
    //             $seconds              = 3600;
    //             $finale               = $seconds * $x;
    //             $finaleIst            = $finale - $seconds;
    //             // convert date and time to seconds 
    //             $start_dateStratOtime = strtotime($start_dateGG);
    //             //$start_dateStratOtimeOne = strtotime($start_dateGG)+ $zk ; 
    //             $finalTimeSecond      = $start_dateStratOtime + $finale;
    //             // convert seconds into a specific format 
    //             $start_dateGGNew      = date("Y-m-d G:00:00", $start_dateStratOtime + $finale);
    //             // convert seconds into a specific format 
    //             $endDateHour          = date("Y-m-d G:00:00", $finalTimeSecond);
    //             $dt                   = new DateTime($start_dateGGNew, new DateTimeZone($timezone));
    //             $dt->setTimezone(new DateTimeZone('UTC'));
    //             $start_dateGGNew = $dt->format('Y-m-d H:i:s');
    //             $dt              = new DateTime($endDateHour, new DateTimeZone($timezone));
    //             $dt->setTimezone(new DateTimeZone('UTC'));
    //             $endDateHour   = $dt->format('Y-m-d H:i:s');
    //             $ChartData_arr = $this->mod_highchart->getCoinaverage($coinval, $time = 'hour', $start_dateGGNew, $endDateHour, $ChartData_arrA, $x);
    //             if (!empty($ChartData_arr)) {
    //                 $fianalArr[]    = $ChartData_arr;
    //                 $ChartData_arrA = $ChartData_arr;
    //             }
    //             $z++;
    //         }
    //     } else if ($this->input->post('start_date') == '' && $this->input->post('end_date') == '' && $time == 'hour') {
    //         // From Current date time and get the value 
    //         $timezone = $this->session->userdata('timezone');
    //         date_default_timezone_set($timezone);
    //         $currentDateTime = date('m/d/Y H:i:s');
    //         $end_dateA       = date('m/d/Y h:i A', strtotime($currentDateTime));
    //         $start_dateOrg   = $end_dateA;
    //         // convert date and time to seconds 
    //         $start_date      = strtotime($start_dateOrg);
    //         // convert seconds into a specific format 
    //         $start_dateGG    = date("Y-m-d G:i:00", $start_date);
    //         // convert date and time to seconds 
    //         $lastHour        = $start_date + 3600;
    //         // convert seconds into a specific format 
    //         $endDateHour     = date("Y-m-d G:00:00", $lastHour);
    //         // ********************************** ENd date ********************************//
    //         $newDateTime     = date('m/d/Y h:i A', strtotime('-1 days'));
    //         // convert date and time to seconds 
    //         $end_date        = strtotime($newDateTime);
    //         // convert seconds into a specific format 
    //         $end_date        = date("Y-m-d G:i:s", $end_date);
    //         $starttimestamp  = strtotime($end_dateA);
    //         $endtimestamp    = strtotime($newDateTime); //paroon
    //         $difference      = abs($endtimestamp - $starttimestamp) / 3600;
    //         $totalHours      = $difference;
    //         $z               = 1;
    //         for ($x = 1; $x <= $totalHours; $x++) {
    //             $new                  = 3600;
    //             $seconds              = 3600;
    //             $finale               = $seconds * $x;
    //             $finaleIst            = $finale - $seconds;
    //             // convert date and time to seconds 
    //             $start_dateStratOtime = strtotime($start_dateGG);
    //             //$start_dateStratOtimeOne = strtotime($start_dateGG)+ $zk ; 
    //             $finalTimeSecond      = $start_dateStratOtime + $finale;
    //             // convert seconds into a specific format 
    //             $start_dateGGNew      = date("Y-m-d G:00:00", $start_dateStratOtime + $finale);
    //             // convert seconds into a specific format 
    //             $endDateHour          = date("Y-m-d G:00:00", $finalTimeSecond);
    //             $ChartData_arr        = $this->mod_highchart->getCoinaverage($coinval, $time = 'hour', $start_dateGGNew, $endDateHour, $ChartData_arrA, $x);
    //             if (!empty($ChartData_arr)) {
    //                 $fianalArr[]    = $ChartData_arr;
    //                 $ChartData_arrA = $ChartData_arr;
    //             }
    //             $z++;
    //         }
    //     }
    //     if ($this->input->post('start_date') != '' && $this->input->post('end_date') != '' && $time == 'minut') {
    //         $start_dateOrg  = $this->input->post('start_date');
    //         $newDateTime    = $this->input->post('start_date');
    //         // convert date and time to seconds 
    //         $start_date     = strtotime($start_dateOrg);
    //         // convert seconds into a specific format 
    //         $start_dateGG   = date("Y-m-d G:i:00", $start_date);
    //         // convert date and time to seconds 
    //         $lastHour       = $start_date + 3600;
    //         // convert seconds into a specific format 
    //         $endDateHour    = date("Y-m-d G:i:00", $lastHour);
    //         // ********************************** ENd date ********************************//
    //         $end_dateA      = $this->input->post('end_date');
    //         // convert date and time to seconds 
    //         $end_date       = strtotime($end_dateA);
    //         // convert seconds into a specific format 
    //         $end_date       = date("Y-m-d h:i:s", $end_date);
    //         $start_dateNew  = $this->input->post('start_date');
    //         $end_dateNew    = $this->input->post('end_date');
    //         $starttimestamp = strtotime($start_dateNew);
    //         $endtimestamp   = strtotime($end_dateNew);
    //         $difference     = abs($endtimestamp - $starttimestamp) / 3600;
    //         $difference     = $difference * 60;
    //         $totalHours     = $difference;
    //         $z              = 1;
    //         for ($x = 1; $x <= $totalHours; $x++) {
    //             $new                  = 60;
    //             $seconds              = 60;
    //             $hourVal              = 3600;
    //             $finale               = $seconds * $x;
    //             $finaleIst            = $finale - $seconds;
    //             $finalTimeSecond      = '';
    //             // convert date and time to seconds 
    //             $start_dateStratOtime = strtotime($start_dateGG);
    //             //$start_dateStratOtimeOne = strtotime($start_dateGG)+ $zk ; 
    //             $finalTimeSecond      = $start_dateStratOtime + $finale;
    //             // convert seconds into a specific format 
    //             $start_dateGGNew      = date("Y-m-d H:i:00", $finalTimeSecond);
    //             // convert seconds into a specific format 
    //             $endDateHour          = date("Y-m-d H:i:00", $finalTimeSecond);
    //             $dt1                  = new DateTime($start_dateGGNew, new DateTimeZone($timezone));
    //             $dt1->setTimezone(new DateTimeZone('UTC'));
    //             $start_dateGGNew1 = $dt1->format('Y-m-d H:i:s');
    //             $dt2              = new DateTime($endDateHour, new DateTimeZone($timezone));
    //             $dt2->setTimezone(new DateTimeZone('UTC'));
    //             $endDateHour2  = $dt2->format('Y-m-d H:i:s');
    //             $ChartData_arr = $this->mod_highchart->getCoinaverage($coinval, $time = 'minut', $start_dateGGNew1, $endDateHour2, $ChartData_arrA, $x);
    //             if (!empty($ChartData_arr)) {
    //                 $fianalArr[]    = $ChartData_arr;
    //                 $ChartData_arrA = $ChartData_arr;
    //             }
    //             $z++;
    //         }
    //     } else if ($this->input->post('start_date') == '' && $this->input->post('end_date') == '' && $time == 'minut') {
    //         // Get date from current date and time 
    //         $timezone        = $this->session->userdata('timezone');
    //         //date_default_timezone_set($timezone );
    //         $currentDateTime = date('m/d/Y H:i:s');
    //         $end_dateA       = date('m/d/Y h:00 A', strtotime($currentDateTime));
    //         $start_dateOrg   = $end_dateA;
    //         // convert date and time to seconds 
    //         $start_date      = strtotime($start_dateOrg);
    //         // convert seconds into a specific format 
    //         $start_dateGG    = date("Y-m-d G:i:00", $start_date);
    //         // convert date and time to seconds 
    //         $lastHour        = $start_date + 3600;
    //         // convert seconds into a specific format 
    //         $endDateHour     = date("Y-m-d G:00:00", $lastHour);
    //         // ********************************** ENd date ********************************//
    //         $newDateTime     = date('m/d/Y h:00 A', strtotime('-2 hours'));
    //         // convert date and time to seconds 
    //         $end_date        = strtotime($newDateTime);
    //         // convert seconds into a specific format 
    //         $end_date        = date("Y-m-d G:i:s", $end_date);
    //         $starttimestamp  = strtotime($end_dateA);
    //         $endtimestamp    = strtotime($newDateTime); //paroon
    //         $difference      = abs($endtimestamp - $starttimestamp) / 3600 * 60;
    //         $totalHours      = $difference;
    //         $z               = 1;
    //         $fianalArr       = array();
    //         for ($x = 1; $x <= $totalHours; $x++) {
    //             $new                  = 60;
    //             $seconds              = 60;
    //             $finale               = $seconds * $x;
    //             $finaleIst            = $finale - $seconds;
    //             // convert date and time to seconds 
    //             $start_dateStratOtime = strtotime($end_date);
    //             //$start_dateStratOtimeOne = strtotime($start_dateGG)+ $zk ; 
    //             $finalTimeSecond      = $start_dateStratOtime + $finale;
    //             // convert seconds into a specific format 
    //             $start_dateGGNew      = date("Y-m-d G:i:00", $start_dateStratOtime + $finale);
    //             // convert seconds into a specific format 
    //             $endDateHour          = date("Y-m-d G:i:00", $finalTimeSecond);
    //             $ChartData_arr        = $this->mod_highchart->getCoinaverage($coinval, $time = 'minut', $start_dateGGNew, $endDateHour, $ChartData_arrA, $x);
    //             if (!empty($ChartData_arr)) {
    //                 $fianalArr[]    = $ChartData_arr;
    //                 $ChartData_arrA = end($fianalArr);
    //             }
    //             $z++;
    //         }
    //     }
    //     $data['chart_arr'] = array_reverse($fianalArr);
    //     $fianalArrCount    = count($fianalArr);
    //     $totalDifference   = $totalHours - $fianalArrCount;
    //     $totalHoursNew     = $totalHours - $totalDifference;
    //     $ZENBTCnwArr       = array();
    //     $QTUMBTCnwArr      = array();
    //     $XLMBTCnwArr       = array();
    //     $XEMBTCnwArr       = array();
    //     $XRPBTCnwArr       = array();
    //     $ETCBTCnwArr       = array();
    //     $NEOBTCnwArr       = array();
    //     $POEBTCnwArr       = array();
    //     $EOSBTCnwArr       = array();
    //     $TRXBTCnwArr       = array();
    //     $NCASHBTCnwArr     = array();
    //     $BTCnwArr          = array();
    //     foreach ($data['chart_arr'] as $key => $data) {
    //         if ($key == 0) {
    //             $S_ZENBTC   = $data['ZENBTC'];
    //             $S_QTUMBTC  = $data['QTUMBTC'];
    //             $S_XLMBTC   = $data['XLMBTC'];
    //             $S_XEMBTC   = $data['XEMBTC'];
    //             $S_XRPBTC   = $data['XRPBTC'];
    //             $S_ETCBTC   = $data['ETCBTC'];
    //             $S_NEOBTC   = $data['NEOBTC'];
    //             $S_POEBTC   = $data['POEBTC'];
    //             $S_EOSBTC   = $data['EOSBTC'];
    //             $S_TRXBTC   = $data['TRXBTC'];
    //             $S_NCASHBTC = $data['NCASHBTC'];
    //             $S_BTC      = $data['BTC'];
    //         }
    //         $ZENBTCnw         = $S_ZENBTC - $data['ZENBTC'];
    //         $finalValZENBTC   = $ZENBTCnw / $S_ZENBTC;
    //         $finalValZENBTC   = round($finalValZENBTC * 100, 2);
    //         $QTUMBTCnw        = $S_QTUMBTC - $data['QTUMBTC'];
    //         $finalValQTUMBTC  = $QTUMBTCnw / $S_QTUMBTC;
    //         $finalValQTUMBTC  = round($finalValQTUMBTC * 100, 2);
    //         $XLMBTCnw         = $S_XLMBTC - $data['XLMBTC'];
    //         $finalValS_XLMBTC = $XLMBTCnw / $S_XLMBTC;
    //         $finalValS_XLMBTC = round($finalValS_XLMBTC * 100, 2);
    //         $XEMBTCnw         = $S_XEMBTC - $data['XEMBTC'];
    //         $finalValXEMBTC   = $XEMBTCnw / $S_XEMBTC;
    //         $finalValXEMBTC   = round($finalValXEMBTC * 100, 2);
    //         $XRPBTCnw         = $S_XRPBTC - $data['XRPBTC'];
    //         $finalValXRPBTC   = $XRPBTCnw / $S_XRPBTC;
    //         $finalValXRPBTC   = round($finalValXRPBTC * 100, 2);
    //         $ETCBTCnw         = $S_ETCBTC - $data['ETCBTC'];

    //         $finalValETCBTC   = $ETCBTCnw / $S_ETCBTC;
    //         $finalValETCBTC   = round($finalValETCBTC * 100, 2);
    //         $NEOBTCnw         = $S_NEOBTC - $data['NEOBTC'];
    //         $finalValNEOBTC   = $NEOBTCnw / $S_NEOBTC;
    //         $finalValNEOBTC   = round($finalValNEOBTC * 100, 2);
    //         $POEBTCnw         = $S_POEBTC - $data['POEBTC'];
    //         $finalValPOEBTC   = $POEBTCnw / $S_POEBTC;
    //         $finalValPOEBTC   = round($finalValPOEBTC * 100, 2);
    //         $EOSBTCnw         = $S_EOSBTC - $data['EOSBTC'];
    //         $finalValEOSBTC   = $EOSBTCnw / $S_EOSBTC;
    //         $finalValEOSBTC   = round($finalValEOSBTC * 100, 2);
    //         $TRXBTCnw         = $S_TRXBTC - $data['TRXBTC'];
    //         $finalValTRXBTC   = $TRXBTCnw / $S_TRXBTC;
    //         $finalValTRXBTC   = round($finalValTRXBTC * 100, 2);
    //         $NCASHBTCnw       = $S_NCASHBTC - $data['NCASHBTC'];
    //         $finalValNCASHBTC = $NCASHBTCnw / $S_NCASHBTC;
    //         $finalValNCASHBTC = round($finalValNCASHBTC * 100, 2);
    //         $BTCnw            = $S_BTC - $data['BTC'];
    //         $finalValBTC      = $BTCnw / $S_BTC;
    //         $finalValBTC      = round($finalValBTC * 100, 2);
    //         array_push($ZENBTCnwArr, $finalValZENBTC);
    //         array_push($QTUMBTCnwArr, $finalValQTUMBTC);
    //         array_push($XLMBTCnwArr, $finalValS_XLMBTC);
    //         array_push($XEMBTCnwArr, $finalValXEMBTC);
    //         array_push($XRPBTCnwArr, $finalValXRPBTC);
    //         array_push($ETCBTCnwArr, $finalValETCBTC);
    //         array_push($NEOBTCnwArr, $finalValNEOBTC);
    //         array_push($POEBTCnwArr, $finalValPOEBTC);
    //         array_push($EOSBTCnwArr, $finalValEOSBTC);
    //         array_push($TRXBTCnwArr, $finalValTRXBTC);
    //         array_push($NCASHBTCnwArr, $finalValNCASHBTC);
    //         array_push($BTCnwArr, $finalValBTC);
    //     }
    //     $data['ZENBTC']        = implode(', ', ($ZENBTCnwArr));
    //     $data['QTUMBTC']       = implode(', ', ($QTUMBTCnwArr));
    //     $data['XLMBTC']        = implode(', ', ($XLMBTCnwArr));
    //     $data['XEMBTC']        = implode(', ', ($XEMBTCnwArr));
    //     $data['XRPBTC']        = implode(', ', ($XRPBTCnwArr));
    //     $data['ETCBTC']        = implode(', ', ($ETCBTCnwArr));
    //     $data['NEOBTC']        = implode(', ', ($NEOBTCnwArr));
    //     $data['POEBTC']        = implode(', ', ($POEBTCnwArr));
    //     $data['EOSBTC']        = implode(', ', ($EOSBTCnwArr));
    //     $data['TRXBTC']        = implode(', ', ($TRXBTCnwArr));
    //     $data['NCASHBTC']      = implode(', ', ($NCASHBTCnwArr));
    //     $data['BTC']           = implode(', ', ($BTCnwArr));
    //     $data['coinsArr']      = $all_coins_arrList;
    //     $data['post_data']     = $this->input->post();
    //     $data['startDate']     = $newDateTime;
    //     $data['endDate']       = $end_dateA;
    //     $newDateTimeAAA        = date('m/d/Y', strtotime('-2 days'));
    //     $explodeDate           = explode('/', $newDateTimeAAA);
    //     $data['dtepickerdate'] = $explodeDate;
    //     $data['totalHours']    = $totalHours; // Change on 1-14-2018
    //     $data['time']          = $time;
    //     $data['price_format']  = $prc_formate;
    //     $data['timezone']      = $this->session->userdata('timezone');
    //     //stencil is our templating library. Simply call view via it
    //     $this->stencil->paint('admin/highchart/coinaverage', $data);
    // } //End coin_average
	
	
    // public function highchart_oneminut_cron($clear = '')
    // {
    //     $all_coins_arr           = $this->mod_sockets->get_all_coins();
		
    //     $created_datetimeISt     = date('Y-m-d G:i:00', strtotime('-3 minutes'));
    //     // convert date and time to seconds 
    //     $start_dateStratOtime    = strtotime($created_datetimeISt);
    //     $finalTimeSecond         = $start_dateStratOtime + 60;
    //     $created_datetimeIStScnd = date("Y-m-d G:i:00", $finalTimeSecond);
    //     foreach ($all_coins_arr as $coin) {
    //         $insertRecord = $this->mod_highchart->ChartDataOneMinutCron($coin->symbol, $created_datetimeISt, $created_datetimeIStScnd);
    //         echo $insertRecord . "<br />";
    //     }
    // } //highchart_oneminut_cron
	
	
    // public function test_highchart_oneminut_cron($clear = '')
    // {
    //     $all_coins_arr           = $this->mod_sockets->get_all_coins();
    //     $created_datetimeISt     = date('Y-m-d G:i:00', strtotime('-1 hours'));
    //     // convert date and time to seconds 
    //     $start_dateStratOtime    = strtotime($created_datetimeISt);
    //     $finalTimeSecond         = $start_dateStratOtime + 120;
    //     $created_datetimeIStScnd = date("Y-m-d G:i:00", $finalTimeSecond);
    //     foreach ($all_coins_arr as $coin) {
    //         $insertRecord = $this->mod_highchart->testChartDataOneMinutCron('XRPBTC', $created_datetimeISt, $created_datetimeIStScnd);
    //         //echo $insertRecord. "<br />";
    //     }
    // } //highchart_oneminut_cron
	
	
	// public function candle_reports_hackup($clear = ''){
		
    //  $data['hide_chart']  = 1;
	//  $all_coins_arr       = $this->mod_sockets->get_all_coins();
	//  $data['coins_arr']   = array_reverse($all_coins_arr);
	 
	//  $global_symbol = $this->session->userdata('global_symbol');
	//  $form_sesion_data_arr = $this->mod_highchart->get_sesion_data($global_symbol);
	//  $data['session_data_array']           = $form_sesion_data_arr;
	 
	//  $this->stencil->paint('admin/highchart/candle_report_back', $data);
	
	// }// candle_reports to load fiest time 
	
	
    // public function candle_report_backup($clear = '')
    // {
    //     error_reporting(0);
    //     //Login Check
    //     $this->mod_login->verify_is_admin_login();
    //     $all_coins_arr = $this->mod_sockets->get_all_coins();
    //     $global_symbol = $this->session->userdata('global_symbol');
    //     $timezone      = $this->session->userdata('timezone');
    //     if ($this->input->post('submitbtn')) {
    //         $this->session->unset_userdata('page_post_data');
    //     }
    //     if ($clear == 'clear') {
    //         $this->session->unset_userdata('page_post_data');
    //         $this->session->unset_userdata('form_session_session');
    //         redirect(base_url() . 'admin/highchart/candle-report');
    //     }
	// 	if(empty($this->input->post()) && empty($this->session->userdata('page_post_data'))){
    //         redirect(base_url() . 'admin/highchart/candle-reports');
    //     }
		
    //     if ($this->input->post('form_session') != '') {
    //         $form_session_session = $this->input->post('form_session');
    //         $this->session->set_userdata("form_session_session", $form_session_session);
    //         $sess_data                              = $this->mod_highchart->get_sesion_by_id($this->input->post('form_session'));
    //         $session_data_save['coin']              = $sess_data['coin'];
    //         $session_data_save['time']              = $sess_data['time'];
    //         $session_data_save['mutiply_no_market'] = $sess_data['mutiply_no_market'];
    //         $session_data_save['minus_no_score']    = $sess_data['minus_no_score'];
    //         $session_data_save['price_format']      = $sess_data['price_format'];
    //         $session_data_save['time_cot']          = $sess_data['time_cot'];
    //         $session_data_save['m_buyers_sellers']  = $sess_data['m_buyers_sellers'];
    //         $session_data_save['s_b_15']            = $sess_data['s_b_15'];
    //         $session_data_save['l_quantity_15']     = $sess_data['l_quantity_15'];
    //         $session_data_save['rule_buy_sell']     = $sess_data['rule_buy_sell'];
    //         $session_data_save['start_date']        = $sess_data['start_date'];
    //         $session_data_save['end_date']          = $sess_data['end_date'];
    //         $session_data_save['ask_buy_for']       = $sess_data['ask_buy_for'];
    //         $session_data_save['bid_sell_for']      = $sess_data['bid_sell_for'];
    //         $session_data_save['trigger']           = $sess_data['trigger'];
    //         $session_data_save['form_session']      = $this->mongo_db->mongoId($sess_data['_id']);
    //         $session_data_save['tab_no']            = $sess_data['tab_no'];
	// 		$session_data_save['average_c_m_v']     = $sess_data['average_c_m_v'];
			
    //         $session_data_save['check0']            = $sess_data['check0'];
    //         $session_data_save['check1']            = $sess_data['check1'];
    //         $session_data_save['check2']            = $sess_data['check2'];
    //         $session_data_save['check3']            = $sess_data['check3'];
    //         $session_data_save['check4']            = $sess_data['check4'];
    //         $session_data_save['check5']            = $sess_data['check5'];
    //         $session_data_save['check6']            = $sess_data['check6'];
    //         $session_data_save['check7']            = $sess_data['check7'];
    //         $session_data_save['check8']            = $sess_data['check8'];
    //         $session_data_save['check9']            = $sess_data['check9'];
    //         $session_data_save['check10']           = $sess_data['check10'];
    //         $session_data_save['check11']           = $sess_data['check11'];
    //         $session_data_save['check12']           = $sess_data['check12'];
    //         $session_data_save['check13']           = $sess_data['check13'];
    //         $session_data_save['check14']           = $sess_data['check14'];
    //         $session_data_save['check15']           = $sess_data['check15'];
    //         $session_data_save['check16']           = $sess_data['check16'];
    //         $session_data_save['check17']           = $sess_data['check17'];
    //         $session_data_save['check18']           = $sess_data['check18'];
    //         $session_data_save['check19']           = $sess_data['check19'];
    //         $session_data_save['check20']           = $sess_data['check20'];
    //         $session_data_save['check21']           = $sess_data['check21'];
    //         $session_data_save['check22']           = $sess_data['check22'];
    //         $session_data_save['check23']           = $sess_data['check23'];
    //         $session_data_save['check24']           = $sess_data['check24'];
    //         $session_data_save['check25']           = $sess_data['check25'];
    //         $session_data_save['check26']           = $sess_data['check26'];
    //         $session_data_save['check27']           = $sess_data['check27'];
    //         $session_data_save['check28']           = $sess_data['check28'];
    //         $session_data_save['check29']           = $sess_data['check29'];
    //         $session_data_save['check30']           = $sess_data['check30'];
    //         $session_data_save['check31']           = $sess_data['check31'];
    //         $session_data_save['check32']           = $sess_data['check32'];
    //         $session_data_save['check33']           = $sess_data['check33'];
    //         $session_data_save['check34']           = $sess_data['check34'];
    //         $session_data_save['check35']           = $sess_data['check35'];
	// 		$session_data_save['check37']           = $sess_data['check36'];
	// 		$session_data_save['check37']           = $sess_data['check37'];
	// 		$session_data_save['check38']           = $sess_data['check38'];
	// 		$session_data_save['check39']           = $sess_data['check39'];
	// 		$session_data_save['check40']           = $sess_data['check40'];
	// 		$session_data_save['check41']           = $sess_data['check41'];
	// 		$session_data_save['check42']           = $sess_data['check42'];
	// 		$session_data_save['check43']           = $sess_data['check43'];
	// 		$session_data_save['check44']           = $sess_data['check44'];
	// 		$session_data_save['check45']           = $sess_data['check45'];
	// 		$session_data_save['check46']           = $sess_data['check46'];
	// 		$session_data_save['check47']           = $sess_data['check47'];
	// 		$session_data_save['check48']           = $sess_data['check48'];
	// 		$session_data_save['check49']           = $sess_data['check49'];
			
    //         $this->session->set_userdata(array(
    //             'page_post_data' => $session_data_save
    //         ));
    //         $this->session->set_userdata(array(
    //             'form_session_session' => $this->mongo_db->mongoId($sess_data['_id'])
    //         ));
    //     }
    //     $page_session_data = $this->session->userdata('page_post_data');
    //     if ($page_session_data == '') {
			
    //         $time              = $this->input->post('time');
    //         $time              = ($time == '') ? 'minut' : $time;
    //         $coin              = $this->input->post('coin');
    //         $coinval           = ($coin == '') ? $global_symbol : $coin;
    //         $time_cot          = $this->input->post('time_cot');
    //         $time_cot          = ($time_cot == '') ? 1 : $time_cot;
    //         $mutiply_no_score  = $this->input->post('mutiply_no_score');
    //         $mutiply_no_score  = ($mutiply_no_score == '') ? 1 : $mutiply_no_score;
    //         $mutiply_no_market = $this->input->post('mutiply_no_market');
    //         $mutiply_no_market = ($mutiply_no_market == '') ? 1 : $mutiply_no_market;
    //         $minus_no_score    = $this->input->post('minus_no_score');
    //         $minus_no_score    = ($minus_no_score == '') ? 0 : $minus_no_score;
    //         $m_buyers_sellers  = $this->input->post('m_buyers_sellers');
    //         $m_buyers_sellers  = ($m_buyers_sellers == '') ? 1 : $m_buyers_sellers;
    //         $s_b_15            = $this->input->post('s_b_15');
    //         $s_b_15            = ($s_b_15 == '') ? 1 : $s_b_15;
    //         $l_quantity_15     = $this->input->post('l_quantity_15');
    //         $l_quantity_15     = ($l_quantity_15 == '') ? 1 : $l_quantity_15;
    //         $rule_buy_sell     = $this->input->post('rule_buy_sell');
    //         $rule_buy_sell     = ($rule_buy_sell == '') ? 1 : $rule_buy_sell;
    //         $bottom_height     = $this->input->post('bottom_height');
    //         $bottom_height     = ($bottom_height == '') ? 10 : $bottom_height;
    //         $ask_buy_for       = $this->input->post('ask_buy_for');
    //         $ask_buy_for       = ($ask_buy_for == '') ? 1 : $ask_buy_for;
    //         $bid_sell_for      = $this->input->post('bid_sell_for');
    //         $bid_sell_for      = ($bid_sell_for == '') ? 1 : $bid_sell_for;
    //         $trigger           = $this->input->post('trigger');
    //         $trigger           = ($trigger == '') ? barrier_trigger : $trigger;
    //         $price_format      = $this->input->post('price_format');
    //         $price_format      = ($price_format == '') ? 1 : $price_format;
    //         $start_dateMain    = $this->input->post('start_date');
    //         $end_dateMain      = $this->input->post('end_date');
    //         $tab_no            = $this->input->post('tab_no');
    //         $trigger           = $this->input->post('trigger');
	// 		$average_c_m_v     = $this->input->post('average_c_m_v');
			
			
    //         if ($this->input->post('submitbtn')) {
    //             $this->session->set_userdata(array(
    //                 'page_post_data' => $this->input->post()
    //             ));
    //         }
    //         $end_dateA   = ($start_dateMain == '') ? date('m/d/Y h:00 A', strtotime(date('m/d/Y H:i:s'))) : $this->input->post('end_date');
    //         $newDateTime = ($end_dateMain == '')   ? date('m/d/Y h:00 A', strtotime('-1 hours')) : $this->input->post('start_date');
			
    //     } else {
			
    //         $coin              = $page_session_data['coin'];
    //         $coinval           = ($coin == '') ? $global_symbol : $coin;
    //         $time              = $page_session_data['time'];
    //         $mutiply_no_market = $page_session_data['mutiply_no_market'];
    //         $minus_no_score    = $page_session_data['minus_no_score'];
    //         $chart_width       = $page_session_data['chart_width'];
    //         $bottom_height     = ($page_session_data['bottom_height'] != '') ? $page_session_data['bottom_height'] : 10;
    //         $price_format      = $page_session_data['price_format'];
    //         $time_cot          = $page_session_data['time_cot'];
    //         $m_buyers_sellers  = $page_session_data['m_buyers_sellers'];
    //         $s_b_15            = $page_session_data['s_b_15'];
    //         $l_quantity_15     = $page_session_data['l_quantity_15'];
    //         $rule_buy_sell     = $page_session_data['rule_buy_sell'];
    //         $start_dateMain    = $page_session_data['start_date'];
    //         $end_dateMain      = $page_session_data['end_date'];
    //         $ask_buy_for       = $page_session_data['ask_buy_for'];
    //         $bid_sell_for      = $page_session_data['bid_sell_for'];
    //         $trigger           = $page_session_data['trigger'];
	// 		$average_c_m_v     = $page_session_data['average_c_m_v'];
    //         $end_dateA         = ($start_dateMain == '') ? $this->input->post('end_date') : $page_session_data['end_date'];
    //         $newDateTime       = ($end_dateMain == '')   ? $this->input->post('start_date') : $page_session_data['start_date'];
    //     }
	// 	if ($this->input->post('OpenSession') == 'OpenSession') {
    //         redirect(base_url() . 'admin/highchart/next-session/1');
    //     }
    //     // *** Convert time ZOne *** //    
    //     $newDateTimeForView = $newDateTime;
    //     $end_dateAForView   = $end_dateA;
    //     // *** Convert time ZOne ***//  
    //     $dt                 = new DateTime($newDateTime, new DateTimeZone($timezone));
    //     $dt->setTimezone(new DateTimeZone('UTC'));
    //     $newDateTime        = $dt->format("Y-m-d H:i:s");
		
    //     $dt2                = new DateTime($end_dateA, new DateTimeZone($timezone));
    //     $dt2->setTimezone(new DateTimeZone('UTC'));
    //     $end_dateA          = $dt2->format("Y-m-d H:i:s");
    //     // *** Convert time ZOne *** //  
    //     $form_sesion_data_arr = $this->mod_highchart->get_sesion_data($coinval);
    //     // *** Empty Array Decalaration *** //
    //     $black_wall_pressure          = '';
    //     $yellow_wall_pressure         = '';
    //     $pressure_diff                = '';
    //     $great_wall_price             = '';
    //     $seven_level_depth            = '';
    //     $score                        = '';
    //     $straightline                 = '';
    //     $current_market_value         = '';
    //     $last_qty_time_ago            = '';
    //     $last_200_time_ago            = '';
    //     $last_200_time_ago            = '';
    //     $market_depth_quantity        = '';
    //     $market_depth_ask             = '';
    //     $last_qty_buy_vs_sell         = '';
    //     $last_200_buy_vs_sell         = '';
    //     $last_qty_buy_vs_sell_15      = '';
    //     $last_qty_time_ago_15         = '';
    //     $buyers                       = '';
    //     $sellers                      = '';
    //     $buyers_fifteen               = '';
    //     $sellers_fifteen              = '';
    //     $sellers_buyers_per_fifteen   = '';
    //     $bid_contracts                = '';
    //     $ask_contract                 = '';
    //     $buySum                       = '';
    //     $sellSum                      = '';
    //     $ask                          = '';
    //     $bid                          = '';
    //     $buy                          = '';
    //     $sell                         = '';
    //     $black_wall_percentile        = '';
    //     $sevenlevel_percentile        = '';
    //     $rolling_five_bid_percentile  = '';
    //     $rolling_five_ask_percentile  = '';
    //     $five_buy_sell_percentile     = '';
    //     $fifteen_buy_sell_percentile  = '';
    //     $last_qty_buy_sell_percentile = '';
    //     $last_qty_time_percentile     = '';
		
	// 	$virtual_barrier_percentile      = '';
	// 	$virtual_barrier_percentile_ask  = '';
	// 	$last_qty_time_fif_percentile    = '';
	// 	$big_buyers_percentile           = '';
	// 	$big_sellers_percentile          = '';
	// 	$buy_percentile                  = '';
	// 	$sell_percentile                 = '';
	// 	$ask_percentile                  = '';
	// 	$bid_percentile                  = '';
    //     // *** Empty Array Decalaration *** //    
    //     $black_wall_percentile        .= $prefix . '' . ($chartDataFinal->black_wall_percentile) . '';
    //     $sevenlevel_percentile        .= $prefix . '' . ($chartDataFinal->sevenlevel_percentile) . '';
    //     $rolling_five_bid_percentile  .= $prefix . '' . ($chartDataFinal->rolling_five_bid_percentile) . '';
    //     $rolling_five_ask_percentile  .= $prefix . '' . ($chartDataFinal->rolling_five_ask_percentile) . '';
    //     $five_buy_sell_percentile     .= $prefix . '' . ($chartDataFinal->five_buy_sell_percentile) . '';
    //     $fifteen_buy_sell_percentile  .= $prefix . '' . ($chartDataFinal->fifteen_buy_sell_percentile) . '';
    //     $last_qty_buy_sell_percentile .= $prefix . '' . ($chartDataFinal->last_qty_buy_sell_percentile) . '';
    //     $last_qty_time_percentile     .= $prefix . '' . ($chartDataFinal->last_qty_time_percentile) . '';
    //     $checktime  = $newDateTime;
		
		
		
		
	// 	if ($end_dateA != '' && $newDateTime != '' && $time == 'hour') {
    //         $MmnutHour      = 3600;
    //         $formate        = 'd M Y H:i a';
    //         $starttimestamp = strtotime($end_dateA);
    //         $endtimestamp   = strtotime($newDateTime); //paroon
    //         $difference     = abs($endtimestamp - $starttimestamp) / 3600;
    //         $totalHours     = $difference;
    //         $z              = 1;
    //         for ($x = 1; $x <= $totalHours; $x++) {
    //             $seconds              = 3600;
    //             $finale               = $seconds * $x;
    //             $finaleIst            = $finale - $seconds;
    //             // convert date and time to seconds 
    //             $start_dateStratOtime = strtotime($newDateTime);
    //             //$start_dateStratOtimeOne = strtotime($start_dateGG)+ $zk ; 
    //             $finalTimeSecond      = $start_dateStratOtime + $finale;
    //             // convert seconds into a specific format 
    //             $start_dateGGNew      = date("Y-m-d G:00:00", $start_dateStratOtime + $finale);
    //             // convert seconds into a specific format 
    //             $endDateHour          = date("Y-m-d G:00:00", $finalTimeSecond);
    //             $ChartData_arr        = $this->mod_highchart->getChartDataHours($coinval, $time = 'hour', $start_dateGGNew, $endDateHour, $mutiply_no_score, $mutiply_no_market, $totalHours, $minus_no_score, $price_format, $time_cot, $m_buyers_sellers, $s_b_15, $l_quantity_15, $rule_buy_sell, $ask_buy_for, $bid_sell_for, $trigger);
    //             if (!empty($ChartData_arr)) {
    //                 $fianalArr[] = $ChartData_arr;
    //             }
    //             $z++;
    //         }
    //         foreach ($fianalArr as $chartDataFinal) {
    //             $currentMarket     = ($mutiply_no_market != '') ? num($chartDataFinal['current_market_value'] * $mutiply_no_market) : num($current_market_value);
    //             $currentMarketFinl = ($minus_no_score != '') ? num($currentMarket - $minus_no_score) : num($currentMarket);
    //             $black_wall_pressure .= $prefix . '' . (num($chartDataFinal['black_wall_pressure'])) . '';
    //             $yellow_wall_pressure .= $prefix . '' . num($chartDataFinal['yellow_wall_pressure']) . '';
    //             $pressure_diff .= $prefix . '' . num($chartDataFinal['pressure_diff']) . '';
    //             $great_wall_price .= $prefix . '' . num($chartDataFinal['great_wall_priceArr']) . '';
    //             $seven_level_depth .= $prefix . '' . num($chartDataFinal['seven_level_depth']) . '';
    //             $score .= $prefix . '' . num($chartDataFinal['score']) . '';
    //             $straightline .= $prefix . '' . num($chartDataFinal['straightline']) . '';
    //             $current_market_value .= $prefix . '' . num($currentMarketFinl) . '';
    //             $last_qty_time_ago .= $prefix . '' . num($chartDataFinal['last_qty_time_agoNew']) . '';
    //             $last_200_time_ago .= $prefix . '' . num($chartDataFinal['last_200_time_agoNew']) . '';
    //             $market_depth_quantity .= $prefix . '' . num($chartDataFinal['market_depth_quantity'] / $price_format) . '';
    //             $market_depth_ask .= $prefix . '' . num($chartDataFinal['market_depth_ask'] / $price_format) . '';
    //             $last_qty_buy_vs_sell .= $prefix . '' . num($chartDataFinal['last_qty_buy_vs_sell']) . '';
    //             $last_200_buy_vs_sell .= $prefix . '' . num($chartDataFinal['last_200_buy_vs_sell']) . '';
    //             $last_qty_buy_vs_sell_15 .= $prefix . '' . num($chartDataFinal['last_qty_buy_vs_sell_15']) . '';
    //             $last_qty_time_ago_15 .= $prefix . '' . num($chartDataFinal['last_qty_time_ago_15'] / $l_quantity_15) . '';
    //             $buyers .= $prefix . '' . num($chartDataFinal['buyers'] / $time_cot) . '';
    //             $sellers .= $prefix . '' . num($chartDataFinal['sellers'] / $time_cot) . '';
    //             $buyers_fifteen .= $prefix . '' . num($chartDataFinal['buyers_fifteen'] / $s_b_15) . '';
    //             $sellers_fifteen .= $prefix . '' . num($chartDataFinal['sellers_fifteen'] / $s_b_15) . '';
    //             $sellers_buyers_per_fifteen .= $prefix . '' . num($chartDataFinal['sellers_buyers_per_fifteen'] / $s_b_15) . '';
    //             $bid_contracts .= $prefix . '' . num($chartDataFinal['bid_contracts'] / $m_buyers_sellers) . '';
    //             $ask_contract .= $prefix . '' . num($chartDataFinal['ask_contract'] / $m_buyers_sellers) . '';
    //             $buySum .= $prefix . '' . num($chartDataFinal['buyrule'] * $rule_buy_sell) . '';
    //             $sellSum .= $prefix . '' . num($chartDataFinal['sellrule'] * $rule_buy_sell) . '';
    //             $ask .= $prefix . '' . num($chartDataFinal['ask'] / $ask_buy_for) . '';
    //             $bid .= $prefix . '' . num($chartDataFinal['bid'] / $ask_buy_for) . '';
    //             $buy .= $prefix . '' . num($chartDataFinal['buy'] / $bid_sell_for) . '';
    //             $sell .= $prefix . '' . num($chartDataFinal['sell'] / $bid_sell_for) . '';
    //             $sellers_buyers_per .= $prefix . '' . num($chartDataFinal['sellers_buyers_per'] / $time_cot) . '';
    //             $prefix          = ', ';
    //             // ************** For view ************ //
    //             $htmlView        = '';
    //             $currentDateTime = $newDateTimeForView;
    //             $end_dateA       = date('m/d/Y h:i A', strtotime($currentDateTime));
    //             $dt              = new DateTime($currentDateTime, new DateTimeZone($timezone));
    //             $dt->setTimezone(new DateTimeZone('PKT'));
    //             $pre_time  = $dt->format('Y-m-d H:i:s');
    //             $second    = strtotime($pre_time) + ($i * $MmnutHour);
    //             $end_dateB = date($formate, ($second));
    //             $htmlViewTime .= "'" . $end_dateB . "'";
    //             if (++$i === $recent_count) {
    //             } else {
    //                 $htmlViewTime .= ',';
    //             }
    //             // ************** For view ************ //
    //         }
    //     } else if ($end_dateA != '' && $newDateTime != '' && $time == 'minut') {
			
    //         $getChartDataReportCandle = $this->mod_highchart->getChartDataReportCandle($coinval, $newDateTime, $end_dateA);
    //         $getChartDataReportCandle = array_reverse($getChartDataReportCandle);
    //         //echo "<prE>";  print_r($getChartDataReportCandle); exit;
    //         $starttimestamp           = strtotime($end_dateA);
    //         $endtimestamp             = strtotime($newDateTime); //paroon
    //         $difference               = abs($endtimestamp - $starttimestamp) / 3600 * 60;
    //         $totalHours               = $difference;
    //         $prefix                   = $market_depth_quantity = '';
    //         $i                        = 1;
    //         $MmnutHour                = 60;
    //         $formate                  = 'd M Y H:i A';
			
	
    //         foreach ($getChartDataReportCandle as $key => $chartDataFinal) {
				
    //             $currentMarketOrg  = num($chartDataFinal->current_market_value);
    //             $currentMarket     = ($mutiply_no_market != '') ? num($chartDataFinal->current_market_value * $mutiply_no_market) : num($currentMarketOrg);
    //             $currentMarketFinl = ($minus_no_score != '') ? num($currentMarket - $minus_no_score) : num($currentMarket);
    //             $newCurrentMarket  = num($chartDataFinal->current_market_value);
    //             $black_wall_pressure .= $prefix . '' . num(round($chartDataFinal->black_wall_pressure, 1, PHP_ROUND_HALF_UP)) . '';
	// 			// New work Goes here 
	// 			$currentMarketOrgHighest  = num($chartDataFinal->highest_market_value);
    //             $currentMarketHighest     = ($mutiply_no_market != '') ? num($chartDataFinal->highest_market_value * $mutiply_no_market) : num($currentMarketOrgHighest);
    //             $currentMarketFinlHighest = ($minus_no_score != '') ? num($currentMarketHighest - $minus_no_score) : num($currentMarketHighest);
				
	// 			$currentMarketOrgLowest   = num($chartDataFinal->lowest_market_value);
    //             $currentMarketLowest      = ($mutiply_no_market != '') ? num($chartDataFinal->lowest_market_value * $mutiply_no_market) : num($currentMarketOrgLowest);
    //             $currentMarketFinlLowest  = ($minus_no_score != '') ? num($currentMarketLowest - $minus_no_score) : num($currentMarketLowest);
				
	// 			// Current Market Value 3-14
	// 			$currentMarket_normal          = num($chartDataFinal->current_market_value);
	// 			$currentMarket_normal_high     = num($chartDataFinal->highest_market_value);
	// 			$currentMarket_normal_low      = num($chartDataFinal->lowest_market_value);
				
	// 		    if($key == 0 && $currentMarket_normal!=0) {
    //               $currentMarket_normalFirst   = $currentMarket_normal;
	// 			  $timeZoneDateTimeForview     = $chartDataFinal->datetime_user_friend;
	// 			  continue;
    //             }else if($key == 1 && $currentMarket_normal!=0) { 
	// 			  $timeZoneDateTimeForview     = $chartDataFinal->datetime_user_friend;
	// 			  $currentMarket_normalFirst   = $currentMarket_normal;
	// 			   continue;
	// 			}else if($key == 2 && $currentMarket_normal!=0) { 
	// 			  $timeZoneDateTimeForview     = $chartDataFinal->datetime_user_friend;
	// 			  $currentMarket_normalFirst   = $currentMarket_normal;  
	// 			   continue;
	// 			}
    //             $currentMarket_Diff       = $currentMarket_normal - $currentMarket_normalFirst;
			
	// 			if($currentMarket_Diff ==0 || is_nan($currentMarket_Diff) || is_infinite($currentMarket_Diff)|| $currentMarket_Diff ==1 ||  $currentMarket_Diff ==-1 ){
				      
	// 				 if($oldValToStore==''){
	// 				   $finalValToShow  = $average_c_m_v;		 
	// 				 }else{
	// 				   $finalValToShow =  $oldValToStore;	 
	// 				   $finalValToShow  = $average_c_m_v;		
	// 				 }
	// 			}else if($currentMarket_normal ==0){	 
				
	// 			     if($oldValToStore==''){
	// 				   $finalValToShow  = $average_c_m_v;		 
	// 				 }else{
	// 				   $finalValToShow  =  $oldValToStore[0];	 
	// 				 }			    		 
	// 			}else{
					
	// 				  $finalValToShow  = ($currentMarket_Diff / $currentMarket_normalFirst)*100;
	// 				  $finalValToShow  = ($finalValToShow * 8 ) + $average_c_m_v;
	// 				  $oldValToStore   = '';
	// 				  $oldValToStore[] = $finalValToShow;
	// 			}
	// 			// Low 
    //             $currentMarket_Diff_high       = $currentMarket_normal_high - $currentMarket_normalFirst;
	// 			if($currentMarket_Diff_high ==0 || is_nan($currentMarket_Diff_high) || is_infinite($currentMarket_Diff_high)|| $currentMarket_Diff_high ==1 ||  $currentMarket_Diff_high ==-1 ){
				      
	// 				 if($oldValToStore_high==''){
	// 				   $finalValToShow_high  = $average_c_m_v;		 
	// 				 }else{
	// 				   $finalValToShow_high =  $oldValToStore_high;	 
	// 				   $finalValToShow_high  = $average_c_m_v;		
	// 				 }
	// 			}else if($currentMarket_normal_high ==0){	 
				
	// 			     if($oldValToStore_high==''){
	// 				   $finalValToShow_high  = $average_c_m_v;		 
	// 				 }else{
	// 				   $finalValToShow_high  =  $oldValToStore_high[0];	 
	// 				 }			    		 
	// 			}else{
					
	// 				  $finalValToShow_high  = ($currentMarket_Diff_high / $currentMarket_normalFirst)*100;
	// 				  $finalValToShow_high  = ($finalValToShow_high * 8 ) + $average_c_m_v;
	// 				  $oldValToStore_high   = '';
	// 				  $oldValToStore_high[] = $finalValToShow_high;
	// 			}
	// 			$currentMarket_Diff_low       = $currentMarket_normal_low - $currentMarket_normalFirst;
	// 			if($currentMarket_Diff_low ==0 || is_nan($currentMarket_Diff_low) || is_infinite($currentMarket_Diff_low)|| $currentMarket_Diff_low ==1 ||  $currentMarket_Diff_low ==-1 ){
				      
	// 				 if($oldValToStore_low==''){
	// 				   $finalValToShow_low  = $average_c_m_v;		 
	// 				 }else{
	// 				   $finalValToShow_low =  $oldValToStore_low;	 
	// 				   $finalValToShow_low  = $average_c_m_v;		
	// 				 }
	// 			}else if($currentMarket_normal_low ==0){	 
				
	// 			     if($oldValToStore_low==''){
	// 				   $finalValToShow_low  = $average_c_m_v;		 
	// 				 }else{
	// 				   $finalValToShow_low  =  $oldValToStore_low[0];	 
	// 				 }			    		 
	// 			}else{
					
	// 				  $finalValToShow_low  = ($currentMarket_Diff_low / $currentMarket_normalFirst)*100;
	// 				  $finalValToShow_low  = ($finalValToShow_low * 8 ) + $average_c_m_v;
	// 				  $oldValToStore_low   = '';
	// 				  $oldValToStore_low[] = $finalValToShow_low;
	// 			}
				
	// 			$currentMarket_normalF         .= $prefix . '' . num($finalValToShow) . '';
	// 			$currentMarket_Highest_normalF .= $prefix . '' . num($finalValToShow_high) . '';
	// 			$currentMarket_Lowest_normalF  .= $prefix . '' . num($finalValToShow_low) . '';
	// 			$highest_market_value .= $prefix . '' . num($currentMarketFinlHighest) . '';
	// 			$lowest_market_value  .= $prefix . '' . num($currentMarketFinlLowest) . '';
	// 			// New work Goes End here 
    //             $yellow_wall_pressure .= $prefix . '' . num($chartDataFinal->yellow_wall_pressure) . '';
    //             $pressure_diff        .= $prefix . '' . num($chartDataFinal->pressure_diff) . '';
    //             $great_wall_price     .= $prefix . '' . num($chartDataFinal->great_wall_price) . '';
    //             $seven_level_depth    .= $prefix . '' . num($chartDataFinal->seven_level_depth) . '';
    //             $score                .= $prefix . '' . num($chartDataFinal->score) . '';
    //             $straightline         .= $prefix . '' . num($chartDataFinal->straightline) . '';
    //             $current_market_value .= $prefix . '' . num($currentMarketFinl) . '';
    //             $last_qty_time_ago    .= $prefix . '' . num($chartDataFinal->last_qty_time_ago) . '';
    //             $last_200_time_ago    .= $prefix . '' . num($chartDataFinal->last_200_time_ago) . '';
    //             $market_depth_quantity.= $prefix . '' . num($chartDataFinal->market_depth_quantity / $price_format) . '';
    //             $market_depth_ask     .= $prefix . '' . num($chartDataFinal->market_depth_ask / $price_format) . '';
    //             $last_qty_buy_vs_sell .= $prefix . '' . num($chartDataFinal->last_qty_buy_vs_sell) . '';
    //             $last_200_buy_vs_sell .= $prefix . '' . num($chartDataFinal->last_200_buy_vs_sell) . '';
    //             $last_qty_buy_vs_sell_15 .= $prefix . '' . num($chartDataFinal->last_qty_buy_vs_sell_15 / $l_quantity_15) . '';
    //             $last_qty_time_ago_15    .= $prefix . '' . num($chartDataFinal->last_qty_time_ago_15) . '';
    //             $buyers  .= $prefix . '' . num($chartDataFinal->buyers / $time_cot) . '';
    //             $sellers .= $prefix . '' . num($chartDataFinal->sellers / $time_cot) . '';
    //             $buyers_fifteen  .= $prefix . '' . num(round($chartDataFinal->buyers_fifteen / $s_b_15, 1, PHP_ROUND_HALF_UP)) . '';
    //             $sellers_fifteen .= $prefix . '' . num($chartDataFinal->sellers_fifteen / $s_b_15) . '';
    //             $sellers_buyers_per_fifteen .= $prefix . '' . num($chartDataFinal->sellers_buyers_per_fifteen) . '';
    //             $bid_contracts .= $prefix . '' . num($chartDataFinal->bid_contracts / $m_buyers_sellers) . '';
    //             $ask_contract  .= $prefix . '' . num($chartDataFinal->ask_contract / $m_buyers_sellers) . '';
    //             $ask  .= $prefix . '' . num($chartDataFinal->ask / $ask_buy_for) . '';
    //             $bid  .= $prefix . '' . num($chartDataFinal->bid / $ask_buy_for) . '';
    //             $buy  .= $prefix . '' . num($chartDataFinal->buy / $bid_sell_for) . '';
    //             $sell .= $prefix . '' . num($chartDataFinal->sell / $bid_sell_for) . '';
    //             $sellers_buyers_per_t4cot .= $prefix . '' . num($chartDataFinal->sellers_buyers_per_t4cot / $time_cot) . '';
    //             $sellers_buyers_per       .= $prefix . '' . num($chartDataFinal->sellers_buyers_per) . '';
    //             $buyerCot    = ($chartDataFinal->buyers / $time_cot);
    //             $sellersCot  = ($chartDataFinal->sellers / $time_cot);
    //             $tcotBuyer   = ($buyerCot == 0) ? 1 : $buyerCot;
    //             $tcotSellers = ($sellersCot == 0) ? 1 : $sellersCot;
    //             $bigBuyDivideSell .= $prefix . '' . ($tcotBuyer / $tcotSellers) . '';
				
	// 			$black_wall_percentileFin        =  ($chartDataFinal->black_wall_percentile) ? $chartDataFinal->black_wall_percentile : 0 ;
	// 			$sevenlevel_percentileFin        =  ($chartDataFinal->sevenlevel_percentile) ? $chartDataFinal->sevenlevel_percentile : 0 ;
	// 			$rolling_five_bid_percentileFin  =  ($chartDataFinal->rolling_five_bid_percentile) ? $chartDataFinal->rolling_five_bid_percentile : 0 ;
	// 			$rolling_five_ask_percentileFin  =  ($chartDataFinal->rolling_five_ask_percentile) ? $chartDataFinal->rolling_five_ask_percentile : 0 ;
	// 			$five_buy_sell_percentileFin     =  ($chartDataFinal->five_buy_sell_percentile) ? $chartDataFinal->five_buy_sell_percentile : 0 ;
	// 			$fifteen_buy_sell_percentileFin  =  ($chartDataFinal->fifteen_buy_sell_percentile) ? $chartDataFinal->fifteen_buy_sell_percentile : 0 ;
	// 			$last_qty_buy_sell_percentileFin =  ($chartDataFinal->last_qty_buy_sell_percentile) ? $chartDataFinal->last_qty_buy_sell_percentile : 0 ;
	// 			$last_qty_time_percentileFin     =  ($chartDataFinal->last_qty_time_percentile) ? $chartDataFinal->last_qty_time_percentile : 0 ;
				
	// 			$virtual_barrier_percentileFin     =  ($chartDataFinal->virtual_barrier_percentile) ? $chartDataFinal->virtual_barrier_percentile : 0 ;
	// 			$virtual_barrier_percentile_askFin =  ($chartDataFinal->virtual_barrier_percentile_ask) ? $chartDataFinal->virtual_barrier_percentile_ask : 0 ;
	// 			$last_qty_time_fif_percentileFin   =  ($chartDataFinal->last_qty_time_fif_percentile) ? $chartDataFinal->last_qty_time_fif_percentile : 0 ;
	// 			$big_buyers_percentileFin          =  ($chartDataFinal->big_buyers_percentile)  ? $chartDataFinal->big_buyers_percentile : 0 ;
	// 			$big_sellers_percentileFin         =  ($chartDataFinal->big_sellers_percentile) ? $chartDataFinal->big_sellers_percentile : 0 ;
	// 			$buy_percentileFin                 =  ($chartDataFinal->buy_percentile)  ? $chartDataFinal->buy_percentile : 0 ;
	// 			$sell_percentileFin                =  ($chartDataFinal->sell_percentile) ? $chartDataFinal->sell_percentile : 0 ;
	// 			$ask_percentileFin                 =  ($chartDataFinal->ask_percentile)  ? $chartDataFinal->ask_percentile : 0 ;
	// 			$bid_percentileFin                 =  ($chartDataFinal->bid_percentile)  ? $chartDataFinal->bid_percentile : 0 ;
				
    //             // Percentile Code Goes here 
    //             $black_wall_percentile        .= $prefix . '' . ($black_wall_percentileFin) . '';
    //             $sevenlevel_percentile        .= $prefix . '' . ($sevenlevel_percentileFin) . '';
    //             $rolling_five_bid_percentile  .= $prefix . '' . ($rolling_five_bid_percentileFin) . '';
    //             $rolling_five_ask_percentile  .= $prefix . '' . ($rolling_five_ask_percentileFin) . '';
    //             $five_buy_sell_percentile     .= $prefix . '' . ($five_buy_sell_percentileFin) . '';
    //             $fifteen_buy_sell_percentile  .= $prefix . '' . ($fifteen_buy_sell_percentileFin) . '';
    //             $last_qty_buy_sell_percentile .= $prefix . '' . ($last_qty_buy_sell_percentileFin) . '';
    //             $last_qty_time_percentile     .= $prefix . '' . ($last_qty_time_percentileFin) . '';
				
	// 			$virtual_barrier_percentile     .= $prefix . '' . ($virtual_barrier_percentileFin) . '';
	// 			$virtual_barrier_percentile_ask .= $prefix . '' . ($virtual_barrier_percentile_askFin) . '';
	// 			$last_qty_time_fif_percentile   .= $prefix . '' . ($last_qty_time_fif_percentileFin) . '';
	// 			$big_buyers_percentile          .= $prefix . '' . ($big_buyers_percentileFin) . '';
	// 			$big_sellers_percentile         .= $prefix . '' . ($big_sellers_percentileFin) . '';
	// 			$buy_percentile                 .= $prefix . '' . ($buy_percentileFin) . '';
	// 			$sell_percentile                .= $prefix . '' . ($sell_percentileFin) . '';
	// 			$ask_percentile                 .= $prefix . '' . ($ask_percentileFin) . '';
	// 			$bid_percentile                 .= $prefix . '' . ($bid_percentileFin) . '';
    //             // Percentile Code Goes end here 
    //             if ($trigger == 'all') {
    //                 $buySum  .= $prefix . '' . num($chartDataFinal->buyrule  * $rule_buy_sell) . '';
    //                 $sellSum .= $prefix . '' . num($chartDataFinal->sellrule * $rule_buy_sell) . '';
    //             } else {
    //                 if ($trigger == 'barrier_percentile_trigger') {
    //                     $rulesBuy_pArr  = explode(',', $chartDataFinal->rulesBuy_pArr);
    //                     $rulesSell_pArr = explode(',', $chartDataFinal->rulesSell_pArr);
    //                 } else if ($trigger == 'barrier_trigger') {
    //                     $rulesBuy_pArr  = explode(',', $chartDataFinal->rulesBuy_bArr);
    //                     $rulesSell_pArr = explode(',', $chartDataFinal->rulesSell_bArr);
    //                 } else if ($trigger == 'box_trigger_3') {
    //                     $rulesBuy_pArr  = explode(',', $chartDataFinal->rulesBuy_bt3Arr);
    //                     $rulesSell_pArr = explode(',', $chartDataFinal->rulesSell_bt3Arr);
    //                 } else if ($trigger == 'barrier_trigger_simulator') {
    //                     $rulesBuy_pArr  = explode(',', $chartDataFinal->rulesBuy_btsArr);
    //                     $rulesSell_pArr = explode(',', $chartDataFinal->rulesSell_btsArr);
    //                 }
    //                 if (in_array(1, $rulesBuy_pArr)) {
    //                     $ruleBuy1 = 1;
    //                 } else {
    //                     $ruleBuy1 = 0;
    //                 }
    //                 if (in_array(2, $rulesBuy_pArr)) {
    //                     $ruleBuy2 = 1;
    //                 } else {
    //                     $ruleBuy2 = 0;
    //                 }
    //                 if (in_array(3, $rulesBuy_pArr)) {
    //                     $ruleBuy3 = 1;
    //                 } else {
    //                     $ruleBuy3 = 0;
    //                 }
    //                 if (in_array(4, $rulesBuy_pArr)) {
    //                     $ruleBuy4 = 1;
    //                 } else {
    //                     $ruleBuy4 = 0;
    //                 }
    //                 if (in_array(5, $rulesBuy_pArr)) {
    //                     $ruleBuy5 = 1;
    //                 } else {
    //                     $ruleBuy5 = 0;
    //                 }
    //                 $ruleBuy1 = ($ruleBuy1 != 0) ? 1 * $rule_buy_sell : 0;
    //                 $ruleBuy2 = ($ruleBuy2 != 0) ? 1 * $rule_buy_sell : 0;
    //                 $ruleBuy3 = ($ruleBuy3 != 0) ? 1 * $rule_buy_sell : 0;
    //                 $ruleBuy4 = ($ruleBuy4 != 0) ? 1 * $rule_buy_sell : 0;
    //                 $ruleBuy5 = ($ruleBuy5 != 0) ? 1 * $rule_buy_sell : 0;
    //                 if ($ruleBuy1 != 0) {
    //                     $ruleValue = "{  y: 1, color: '#3CB371'}";
    //                     $buySum .= $prefix . '' . $ruleValue . '';
    //                 } else if ($ruleBuy2 != 0) {
    //                     $ruleValue = "{  y: 2, color: '#008000'}";
    //                     $buySum .= $prefix . '' . $ruleValue . '';
    //                 } else if ($ruleBuy3 != 0) {
    //                     $ruleValue = "{  y: 3, color: '#3CB371'}";
    //                     $buySum .= $prefix . '' . $ruleValue . '';
    //                 } else if ($ruleBuy4 != 0) {
    //                     $ruleValue = "{  y: 4, color: '#6B8E23'}";
    //                     $buySum .= $prefix . '' . $ruleValue . '';
    //                 } else if ($ruleBuy5 != 0) {
    //                     $ruleValue = "{  y: 5, color: '#9ACD32'}";
    //                     $buySum .= $prefix . '' . $ruleValue . '';
    //                 } else {
    //                     $buySum .= $prefix . '0';
    //                 }
    //                 if (in_array(1, $rulesSell_pArr)) {
    //                     $ruleSell1 = 1;
    //                 } else {
    //                     $ruleSell1 = 0;
    //                 }
    //                 if (in_array(2, $rulesSell_pArr)) {
    //                     $ruleSell2 = 1;
    //                 } else {
    //                     $ruleSell2 = 0;
    //                 }
    //                 if (in_array(3, $rulesSell_pArr)) {
    //                     $ruleSell3 = 1;
    //                 } else {
    //                     $ruleSell3 = 0;
    //                 }
    //                 if (in_array(4, $rulesSell_pArr)) {
    //                     $ruleSell4 = 1;
    //                 } else {
    //                     $ruleSell4 = 0;
    //                 }
    //                 if (in_array(5, $rulesSell_pArr)) {
    //                     $ruleSell5 = 1;
    //                 } else {
    //                     $ruleSell5 = 0;
    //                 }
    //                 $ruleSell1 = ($ruleSell1 != 0) ? 1 * $rule_buy_sell : 0;
    //                 $ruleSell2 = ($ruleSell2 != 0) ? 1 * $rule_buy_sell : 0;
    //                 $ruleSell3 = ($ruleSell3 != 0) ? 1 * $rule_buy_sell : 0;
    //                 $ruleSell4 = ($ruleSell4 != 0) ? 1 * $rule_buy_sell : 0;
    //                 $ruleSell5 = ($ruleSell5 != 0) ? 1 * $rule_buy_sell : 0;
    //                 if ($ruleSell1 != 0) {
    //                     //$categroy   .= $prefix . "'level 1'"; 
    //                     $ruleValues = "{  y: 1, color: '#FFA07A'}";
    //                     $sellSum .= $prefix . '' . $ruleValues . '';
    //                 } else if ($ruleSell2 != 0) {
    //                     $ruleValues = "{  y: 2, color: '#8B0000'}";
    //                     $sellSum .= $prefix . '' . $ruleValues . '';
    //                 } else if ($ruleSell3 != 0) {
    //                     $ruleValues = "{  y: 3, color: '#FF6347'}";
    //                     $sellSum .= $prefix . '' . $ruleValues . '';
    //                 } else if ($ruleSell4 != 0) {
    //                     $ruleValues = "{  y: 4, color: '#DB7093'}";
    //                     $sellSum .= $prefix . '' . $ruleValues . '';
    //                 } else if ($ruleSell5 != 0) {
    //                     $ruleValues = "{  y: 5, color: '#B22222'}";
    //                     $sellSum .= $prefix . '' . $ruleValues . '';
    //                 } else {
    //                     $sellSum .= $prefix . '0';
    //                 }
    //             }
    //             $prefix          = ', ';
    //             // ************** For view ************ //
    //             $htmlView        = '';
    //             $currentDateTime = $newDateTimeForView;
    //             $end_dateA       = date('m/d/Y h:i A', strtotime($currentDateTime));
    //             $dt              = new DateTime($currentDateTime, new DateTimeZone($timezone));
    //             $dt->setTimezone(new DateTimeZone('UTC'));
    //             $pre_time  = $dt->format('Y-m-d H:i:s');

	// 			$pre_time  = date('Y-m-d H:i:s', strtotime($newDateTimeForView)); 
				
	// 			//$pre_time  = date('Y-m-d H:i:s', strtotime($checktime)); 
				
    //             $second    = strtotime($pre_time) + ($i * $MmnutHour);
    //             $end_dateB = date($formate, ($second));
    //             $htmlViewTime .= "'" . $end_dateB . "'";
    //             if (++$i === $recent_count) {} else { $htmlViewTime .= ','; }
    //             // ************** For view ************ //
    //         }
    //     }
		
	// 	//exit;
	// 	// Curent Market value Withou Calculation 3-14
	// 	$data['highest_market_value_sample']  = $currentMarket_Highest_normalF;
	// 	$data['lowest_market_value_sample']   = $currentMarket_Lowest_normalF;
	// 	$data['current_market_value_sample']  = $currentMarket_normalF;
    //     // New Work Goes here 
	// 	$data['highest_market_value']         = $highest_market_value;
	// 	$data['lowest_market_value']          = $lowest_market_value;
	//     $data['bigBuyDivideSell']             = $bigBuyDivideSell;
    //     $data['last_qty_time_ago']            = $last_qty_time_ago;
    //     $data['last_200_time_ago']            = $last_200_time_ago;
    //     $data['black_wall_pressure']          = $black_wall_pressure;
    //     $data['yellow_wall_pressure']         = $yellow_wall_pressure;
    //     $data['pressure_diff']                = $pressure_diff;
    //     $data['great_wall_price']             = $great_wall_price;
    //     $data['seven_level_depth']            = $seven_level_depth;
    //     $data['score']                        = $score;
    //     $data['current_market_value']         = $current_market_value;
    //     $data['current_market_value2']        = $current_market_value2;
    //     $data['market_depth_quantity']        = $market_depth_quantity;
    //     $data['askFormate']                   = number_format_symbol($ask_buy_for);
    //     $data['bidFormate']                   = number_format_symbol($ask_buy_for);
    //     $data['buyFormate']                   = number_format_symbol($bid_sell_for);
    //     $data['sellFormate']                  = number_format_symbol($bid_sell_for);
    //     $data['time_cot']                     = number_format_symbol($time_cot);
    //     $data['sellers_buyers_per_t4cot']     = $sellers_buyers_per_t4cot;
    //     $data['sellers_buyers_per']           = $sellers_buyers_per;
    //     $data['market_depth_ask']             = $market_depth_ask;
    //     $data['straightline']                 = $straightline;
    //     $data['last_qty_buy_vs_sell']         = $last_qty_buy_vs_sell;
    //     $data['last_200_buy_vs_sell']         = $last_200_buy_vs_sell;
    //     $data['buyers']                       = $buyers;
    //     $data['sellers']                      = $sellers;
    //     $data['last_qty_buy_vs_sell_15']      = $last_qty_buy_vs_sell_15;
    //     $data['last_qty_time_ago_15']         = $last_qty_time_ago_15;
    //     $data['buyers_fifteen']               = $buyers_fifteen;
    //     $data['sellers_fifteen']              = $sellers_fifteen;
    //     $data['sellers_buyers_per_fifteen']   = $sellers_buyers_per_fifteen;
    //     $data['bid_contracts']                = $bid_contracts;
    //     $data['ask_contract']                 = $ask_contract;
    //     $data['buySum']                       = trim($buySum, ",");
    //     $data['sellSum']                      = trim($sellSum, ",");
    //     $data['rulesBuy']                     = trim($buySum, ",");
    //     $data['rulesSell']                    = trim($sellSum, ",");
    //     $data['ask']                          = $ask;
    //     $data['bid']                          = $bid;
    //     $data['buy']                          = $buy;
    //     $data['sell']                         = $sell;
    //     $data['black_wall_percentile']        = $black_wall_percentile;
    //     $data['sevenlevel_percentile']        = $sevenlevel_percentile;
    //     $data['rolling_five_bid_percentile']  = $rolling_five_bid_percentile;
    //     $data['rolling_five_ask_percentile']  = $rolling_five_ask_percentile;
    //     $data['five_buy_sell_percentile']     = $five_buy_sell_percentile;
    //     $data['fifteen_buy_sell_percentile']  = $fifteen_buy_sell_percentile;
    //     $data['last_qty_buy_sell_percentile'] = $last_qty_buy_sell_percentile;
    //     $data['last_qty_time_percentile']     = $last_qty_time_percentile;
		
	// 	$data['virtual_barrier_percentile']     = $virtual_barrier_percentile;
	// 	$data['virtual_barrier_percentile_ask'] = $virtual_barrier_percentile_ask;
	// 	$data['last_qty_time_fif_percentile']   = $last_qty_time_fif_percentile;
	// 	$data['big_buyers_percentile']          = $big_buyers_percentile;
	// 	$data['big_sellers_percentile']         = $last_qty_time_percentile;
	// 	$data['buy_percentile']                 = $buy_percentile;
	// 	$data['sell_percentile']                = $sell_percentile;
	// 	$data['ask_percentile']                 = $ask_percentile;
	// 	$data['bid_percentile']                 = $bid_percentile;
		
    //     $data['timView']                      = $htmlViewTime;
    //     $data['coins_arr']                    = $all_coins_arr;
    //     $data['global_symbol']                = $global_symbol;
    //     $data['startDate']                    = $newDateTimeForView;
    //     $data['endDate']                      = $end_dateAForView;
    //     $data['totalHours']                   = $totalHours;
    //     $data['time']                         = $time;
    //     $data['bottom_height']                = $bottom_height;
    //     $data['chart_arr']                    = $fianalArr;
    //     $data['get_sesion_data_arr']          = $get_sesion_data_arr;
    //     $data['price_format']                 = $prc_formate;
    //     $data['timezone']                     = $this->session->userdata('timezone');
    //     $data['session_data_array']           = $form_sesion_data_arr;
    //     $data['categroy']                     = $categroy;
		
    //     $this->stencil->paint('admin/highchart/candle_report', $data);
    // } //End candle_report
	
	
	// public function chart_candle_reports($clear = ''){
		
    //  $data['hide_chart']  = 1;
	//  $all_coins_arr       = $this->mod_sockets->get_all_coins();
	//  $data['coins_arr']   = array_reverse($all_coins_arr);
	 
	//  $global_symbol = $this->session->userdata('global_symbol');
	//  $form_sesion_data_arr = $this->mod_highchart->get_sesion_data($global_symbol);
	//  $data['session_data_array']           = $form_sesion_data_arr;
	 
	//  $this->stencil->paint('admin/highchart/candle_report', $data);
	
	// }// candle_reports to load fiest time 
	
	
	
	
	//  public function candle_report($clear = '')
    // {
    //     error_reporting(0);
    //     //Login Check
    //     $this->mod_login->verify_is_admin_login();
	// 	$all_coins_arr = $this->mod_sockets->get_all_coins();
    //     $global_symbol = $this->session->userdata('global_symbol');
    //     $timezone      = $this->session->userdata('timezone');
		
	// 	if ($this->input->post('submitbtn')) {
	// 		$this->session->unset_userdata('page_post_data');
	// 	}
        
    //     if ($clear == 'clear') {
    //         $this->session->unset_userdata('page_post_data');
    //         $this->session->unset_userdata('form_session_session');
    //         redirect(base_url() . 'admin/highchart');
    //     }
	// 	if(empty($this->input->post()) && empty($this->session->userdata('page_post_data'))){
    //         redirect(base_url() . 'admin/highchart');
    //     }
       
    //     if ($this->input->post('form_session') != '') {
    //         $form_session_session = $this->input->post('form_session');
    //         $this->session->set_userdata("form_session_session", $form_session_session);
    //         $sess_data                              = $this->mod_highchart->get_sesion_by_id($this->input->post('form_session'));
    //     }
    //     $page_session_data = $this->session->userdata('page_post_data');
    //     if ($page_session_data == '') {
			
    //         $time              = ($this->input->post('time') == '') ? 'minut' : $this->input->post('time');
    //         $coinval           = ($this->input->post('coin') == '') ? $global_symbol : $this->input->post('coin');
    //         $time_cot          = ($this->input->post('time_cot') == '') ? 1 : $this->input->post('time_cot');
    //         $mutiply_no_score  = ($this->input->post('mutiply_no_score') == '') ? 1 : $this->input->post('mutiply_no_score');
    //         $mutiply_no_market = ($this->input->post('mutiply_no_market') == '') ? 1 : $this->input->post('mutiply_no_market');
    //         $minus_no_score    = ($this->input->post('minus_no_score') == '') ? 0 : $this->input->post('minus_no_score');
    //         $m_buyers_sellers  = ($this->input->post('m_buyers_sellers') == '') ? 1 : $this->input->post('m_buyers_sellers');
    //         $s_b_15            = ($this->input->post('s_b_15') == '') ? 1 : $this->input->post('s_b_15');
    //         $l_quantity_15     = ($this->input->post('l_quantity_15') == '') ? 1 : $this->input->post('l_quantity_15');
    //         $rule_buy_sell     = ($this->input->post('rule_buy_sell') == '') ? 1 : $this->input->post('rule_buy_sell');
    //         $bottom_height     = ($this->input->post('bottom_height') == '') ? 10 : $this->input->post('bottom_height');
    //         $ask_buy_for       = ($this->input->post('ask_buy_for') == '') ? 1 : $this->input->post('ask_buy_for');
    //         $bid_sell_for      = ($this->input->post('bid_sell_for') == '') ? 1 : $this->input->post('bid_sell_for');
    //         $trigger           = ($this->input->post('trigger')== '') ? 'barrier_trigger' : $this->input->post('trigger');
    //         $price_format      = ($this->input->post('price_format') == '') ? 1 : $this->input->post('price_format');
    //         $start_dateMain    = $this->input->post('start_date');
    //         $end_dateMain      = $this->input->post('end_date');
    //         $tab_no            = $this->input->post('tab_no');
	// 		$average_c_m_v     = $this->input->post('average_c_m_v');
			
    //         if ($this->input->post('submitbtn')) {
    //             $this->session->set_userdata(array(
    //                 'page_post_data' => $this->input->post()
    //             ));
    //         }
    //         $end_dateA   = ($start_dateMain == '') ? date('m/d/Y h:00 A', strtotime(date('m/d/Y H:i:s'))) : $this->input->post('end_date');
    //         $newDateTime = ($end_dateMain == '')   ? date('m/d/Y h:00 A', strtotime('-1 hours')) : $this->input->post('start_date');
			
    //     } else {

    //         $coinval           = ($page_session_data['coin']== '') ? $global_symbol : $page_session_data['coin'];
    //         $time              = $page_session_data['time'];
    //         $mutiply_no_market = $page_session_data['mutiply_no_market'];
    //         $minus_no_score    = $page_session_data['minus_no_score'];
    //         $chart_width       = $page_session_data['chart_width'];
    //         $bottom_height     = ($page_session_data['bottom_height'] != '') ? $page_session_data['bottom_height'] : 10;
    //         $price_format      = $page_session_data['price_format'];
    //         $time_cot          = $page_session_data['time_cot'];
    //         $m_buyers_sellers  = $page_session_data['m_buyers_sellers'];
    //         $s_b_15            = $page_session_data['s_b_15'];
    //         $l_quantity_15     = $page_session_data['l_quantity_15'];
    //         $rule_buy_sell     = $page_session_data['rule_buy_sell'];
    //         $start_dateMain    = $page_session_data['start_date'];
    //         $end_dateMain      = $page_session_data['end_date'];
    //         $ask_buy_for       = $page_session_data['ask_buy_for'];
    //         $bid_sell_for      = $page_session_data['bid_sell_for'];
    //         $trigger           = $page_session_data['trigger'];
	// 		$average_c_m_v     = $page_session_data['average_c_m_v'];
    //         $end_dateA         = ($start_dateMain == '') ? $this->input->post('end_date') : $page_session_data['end_date'];
    //         $newDateTime       = ($end_dateMain == '')   ? $this->input->post('start_date') : $page_session_data['start_date'];
    //     }
	// 	if ($this->input->post('OpenSession') == 'OpenSession') {
    //         redirect(base_url() . 'admin/highchart/next-session/1');
    //     }
    //     // *** Convert time ZOne *** //    
    //     $newDateTimeForView = $newDateTime;
    //     $end_dateAForView   = $end_dateA;
    //     // *** Convert time ZOne ***//  
    //     $dt                 = new DateTime($newDateTime, new DateTimeZone($timezone));
    //     $dt->setTimezone(new DateTimeZone('UTC'));
    //     $newDateTime        = $dt->format("Y-m-d H:i:s");
		
    //     $dt2                = new DateTime($end_dateA, new DateTimeZone($timezone));
    //     $dt2->setTimezone(new DateTimeZone('UTC'));
    //     $end_dateA          = $dt2->format("Y-m-d H:i:s");
    //     // *** Convert time ZOne End Here *** // 
		
	// 	// *** Get Session data of form from here  *** //  
    //     $form_sesion_data_arr = $this->mod_highchart->get_sesion_data($coinval);
    //     // ***    Empty Varainle decalration       *** //  
	// 	$highchart_empty_variable = $this->mod_highchart->highchart_empty_variable();
       
      
	// 	if ($end_dateA != '' && $newDateTime != '' && $time == 'minut') {
		
    //         $getChartDataReportCandle = $this->mod_highchart->getChartDataReportCandle($coinval, $newDateTime, $end_dateA);
    //         $getChartDataReportCandle = array_reverse($getChartDataReportCandle);
    //         $prefix                   = $market_depth_quantity = '';
    //         $i                        = 1;
	// 		$k                        = 0;
    //         $MmnutHour                = 60;
    //         $formate                  = 'd M Y H:i A';
			
    //         foreach ($getChartDataReportCandle as $key => $chartDataFinal) {
				
    //             $currentMarketOrg         = num($chartDataFinal->current_market_value);
    //             $currentMarket            = ($mutiply_no_market != '') ? num($chartDataFinal->current_market_value * $mutiply_no_market) : num($currentMarketOrg);
    //             $currentMarketFinl        = ($minus_no_score != '') ? num($currentMarket - $minus_no_score) : num($currentMarket);
    //             $newCurrentMarket         = num($chartDataFinal->current_market_value);
              
	// 			$currentMarketOrgHighest  = num($chartDataFinal->highest_market_value);
    //             $currentMarketHighest     = ($mutiply_no_market != '') ? num($chartDataFinal->highest_market_value * $mutiply_no_market) : num($currentMarketOrgHighest);
    //             $currentMarketFinlHighest = ($minus_no_score != '') ? num($currentMarketHighest - $minus_no_score) : num($currentMarketHighest);
				
	// 			$currentMarketOrgLowest   = num($chartDataFinal->lowest_market_value);
    //             $currentMarketLowest      = ($mutiply_no_market != '') ? num($chartDataFinal->lowest_market_value * $mutiply_no_market) : num($currentMarketOrgLowest);
    //             $currentMarketFinlLowest  = ($minus_no_score != '') ? num($currentMarketLowest - $minus_no_score) : num($currentMarketLowest);
				
	// 			// *** ================ All Percintile Work Goes here ================ ***//
	// 			$currentMarket_normal          = num($chartDataFinal->current_market_value);
	// 			$currentMarket_normal_high     = num($chartDataFinal->highest_market_value);
	// 			$currentMarket_normal_low      = num($chartDataFinal->lowest_market_value);
				
	// 			if($key == 0 && $currentMarket_normal!=0) {	
	// 			  $k++; 	
    //               $currentMarket_normalFirst   = $currentMarket_normal;
	// 			  continue;
    //             }else if($key == 1 && $currentMarket_normal!=0) { 
	// 			  $k++;
	// 			  $currentMarket_normalFirst   = $currentMarket_normal;
	// 			  continue;
	// 			}else if($key == 2 && $currentMarket_normal!=0) { 
	// 			  $k++;
	// 			  $currentMarket_normalFirst   = $currentMarket_normal;  
	// 			  continue;
	// 			}
				
	// 			// *** ====================================================================== ***
	// 			//  Function call to get Avg price of current market Value NORMALL
	// 			$CurrentMarketAvg        =  $this->mod_highchart->getCurrentMarketAvg($currentMarket_normal,$currentMarket_normalFirst,$average_c_m_v);
	// 			// *** ====================================================================== ***
	// 			//  Function call to get Avg price of current market Value LOW
	// 			$CurrentMarketAvgLow     =  $this->mod_highchart->getCurrentMarketAvg($currentMarket_normal_low,$currentMarket_normalFirst,$average_c_m_v);
	// 			// *** ====================================================================== ***
	// 			//  Function call to get Avg price of current market Value HIGHSET
	// 			$CurrentMarketAvgHigh    =  $this->mod_highchart->getCurrentMarketAvg($currentMarket_normal_high,$currentMarket_normalFirst,$average_c_m_v);
	// 			// *** ====================================================================== ***
			    
	// 			$currentMarket_normalF         .= $prefix . '' . num($CurrentMarketAvg) . '';
	// 			$currentMarket_Highest_normalF .= $prefix . '' . num($CurrentMarketAvgHigh) . '';
	// 			$currentMarket_Lowest_normalF  .= $prefix . '' . num($CurrentMarketAvgLow) . '';
	// 			$highest_market_value          .= $prefix . '' . num($currentMarketFinlHighest) . '';
	// 			$lowest_market_value           .= $prefix . '' . num($currentMarketFinlLowest) . '';
	// 			$black_wall_pressure           .= $prefix . '' . num(round($chartDataFinal->black_wall_pressure, 1, PHP_ROUND_HALF_UP)) . '';
    //             $yellow_wall_pressure          .= $prefix . '' . num($chartDataFinal->yellow_wall_pressure) . '';
    //             $pressure_diff                 .= $prefix . '' . num($chartDataFinal->pressure_diff) . '';
    //             $great_wall_price              .= $prefix . '' . num($chartDataFinal->great_wall_price) . '';
    //             $seven_level_depth             .= $prefix . '' . num($chartDataFinal->seven_level_depth) . '';
    //             $score                         .= $prefix . '' . num($chartDataFinal->score) . '';
    //             $straightline                  .= $prefix . '' . num($chartDataFinal->straightline) . '';
    //             $current_market_value          .= $prefix . '' . num($currentMarketFinl) . '';
    //             $last_qty_time_ago             .= $prefix . '' . num($chartDataFinal->last_qty_time_ago) . '';
    //             $last_200_time_ago             .= $prefix . '' . num($chartDataFinal->last_200_time_ago) . '';
    //             $market_depth_quantity         .= $prefix . '' . num($chartDataFinal->market_depth_quantity / $price_format) . '';
    //             $market_depth_ask              .= $prefix . '' . num($chartDataFinal->market_depth_ask / $price_format) . '';
    //             $last_qty_buy_vs_sell          .= $prefix . '' . num($chartDataFinal->last_qty_buy_vs_sell) . '';
    //             $last_200_buy_vs_sell          .= $prefix . '' . num($chartDataFinal->last_200_buy_vs_sell) . '';
    //             $last_qty_buy_vs_sell_15       .= $prefix . '' . num($chartDataFinal->last_qty_buy_vs_sell_15 / $l_quantity_15) . '';
    //             $last_qty_time_ago_15          .= $prefix . '' . num($chartDataFinal->last_qty_time_ago_15) . '';
    //             $buyers                        .= $prefix . '' . num($chartDataFinal->buyers / $time_cot) . '';
    //             $sellers                       .= $prefix . '' . num($chartDataFinal->sellers / $time_cot) . '';
    //             $buyers_fifteen                .= $prefix . '' . num(round($chartDataFinal->buyers_fifteen / $s_b_15, 1, PHP_ROUND_HALF_UP)) . '';
    //             $sellers_fifteen               .= $prefix . '' . num($chartDataFinal->sellers_fifteen / $s_b_15) . '';
    //             $sellers_buyers_per_fifteen    .= $prefix . '' . num($chartDataFinal->sellers_buyers_per_fifteen) . '';
    //             $bid_contracts                 .= $prefix . '' . num($chartDataFinal->bid_contracts / $m_buyers_sellers) . '';
    //             $ask_contract                  .= $prefix . '' . num($chartDataFinal->ask_contract / $m_buyers_sellers) . '';
    //             $ask                           .= $prefix . '' . num($chartDataFinal->ask / $ask_buy_for) . '';
    //             $bid                           .= $prefix . '' . num($chartDataFinal->bid / $ask_buy_for) . '';
    //             $buy                           .= $prefix . '' . num($chartDataFinal->buy / $bid_sell_for) . '';
    //             $sell                          .= $prefix . '' . num($chartDataFinal->sell / $bid_sell_for) . '';
    //             $sellers_buyers_per_t4cot      .= $prefix . '' . num($chartDataFinal->sellers_buyers_per_t4cot / $time_cot) . '';
    //             $sellers_buyers_per            .= $prefix . '' . num($chartDataFinal->sellers_buyers_per) . '';
    //             $buyerCot                       = ($chartDataFinal->buyers / $time_cot);
    //             $sellersCot                     = ($chartDataFinal->sellers / $time_cot);
    //             $tcotBuyer                      = ($buyerCot == 0) ? 1 : $buyerCot;
    //             $tcotSellers                    = ($sellersCot == 0) ? 1 : $sellersCot;
    //             $bigBuyDivideSell              .= $prefix . '' . ($tcotBuyer / $tcotSellers) . '';
								
    //             // Percentile Code Goes here 
    //             $black_wall_percentile          .= $prefix . '' . (($chartDataFinal->black_wall_percentile) ? $chartDataFinal->black_wall_percentile : 0) . '';
    //             $sevenlevel_percentile          .= $prefix . '' . (($chartDataFinal->sevenlevel_percentile) ? $chartDataFinal->sevenlevel_percentile : 0) . '';
    //             $rolling_five_bid_percentile    .= $prefix . '' . (($chartDataFinal->rolling_five_bid_percentile) ? $chartDataFinal->rolling_five_bid_percentile : 0) . '';
    //             $rolling_five_ask_percentile    .= $prefix . '' . (($chartDataFinal->rolling_five_ask_percentile) ? $chartDataFinal->rolling_five_ask_percentile : 0 ) . '';
    //             $five_buy_sell_percentile       .= $prefix . '' . (($chartDataFinal->five_buy_sell_percentile) ? $chartDataFinal->five_buy_sell_percentile : 0) . '';
    //             $fifteen_buy_sell_percentile    .= $prefix . '' . (($chartDataFinal->fifteen_buy_sell_percentile) ? $chartDataFinal->fifteen_buy_sell_percentile : 0) . '';
    //             $last_qty_buy_sell_percentile   .= $prefix . '' . (($chartDataFinal->last_qty_buy_sell_percentile) ? $chartDataFinal->last_qty_buy_sell_percentile : 0 ) . '';
    //             $last_qty_time_percentile       .= $prefix . '' . (($chartDataFinal->last_qty_time_percentile) ? $chartDataFinal->last_qty_time_percentile : 0) . '';	
	// 			$virtual_barrier_percentile     .= $prefix . '' . (($chartDataFinal->virtual_barrier_percentile) ? $chartDataFinal->virtual_barrier_percentile : 0) . '';
	// 			$virtual_barrier_percentile_ask .= $prefix . '' . (($chartDataFinal->virtual_barrier_percentile_ask) ? $chartDataFinal->virtual_barrier_percentile_ask : 0) . '';
	// 			$last_qty_time_fif_percentile   .= $prefix . '' . (($chartDataFinal->last_qty_time_fif_percentile) ? $chartDataFinal->last_qty_time_fif_percentile : 0) . '';
	// 			$big_buyers_percentile          .= $prefix . '' . (($chartDataFinal->big_buyers_percentile)  ? $chartDataFinal->big_buyers_percentile : 0) . '';
	// 			$big_sellers_percentile         .= $prefix . '' . (($chartDataFinal->big_sellers_percentile) ? $chartDataFinal->big_sellers_percentile : 0) . '';
	// 			$buy_percentile                 .= $prefix . '' . (($chartDataFinal->buy_percentile)  ? $chartDataFinal->buy_percentile : 0 ) . '';
	// 			$sell_percentile                .= $prefix . '' . (($chartDataFinal->sell_percentile) ? $chartDataFinal->sell_percentile : 0 ) . '';
	// 			$ask_percentile                 .= $prefix . '' . (($chartDataFinal->ask_percentile)  ? $chartDataFinal->ask_percentile : 0) . '';
	// 			$bid_percentile                 .= $prefix . '' . (($chartDataFinal->bid_percentile)  ? $chartDataFinal->bid_percentile : 0 ) . '';
    //             // Percentile Code Goes end here 
    //             if ($trigger == 'all') {
    //                 $buySum  .= $prefix . '' . num($chartDataFinal->buyrule  * $rule_buy_sell) . '';
    //                 $sellSum .= $prefix . '' . num($chartDataFinal->sellrule * $rule_buy_sell) . '';
    //             } else {
					
	// 				if ($trigger == 'barrier_percentile_trigger') {
    //                     $rulesBuy_pArr  = explode(',', $chartDataFinal->rulesBuy_pArr);
    //                     $rulesSell_pArr = explode(',', $chartDataFinal->rulesSell_pArr);
						
    //                 } else if ($trigger == 'barrier_trigger') {
    //                     $rulesBuy_pArr  = explode(',', $chartDataFinal->rulesBuy_bArr);
    //                     $rulesSell_pArr = explode(',', $chartDataFinal->rulesSell_bArr);
						
    //                 } else if ($trigger == 'box_trigger_3') {
    //                     $rulesBuy_pArr  = explode(',', $chartDataFinal->rulesBuy_bt3Arr);
    //                     $rulesSell_pArr = explode(',', $chartDataFinal->rulesSell_bt3Arr);
						
    //                 } else if ($trigger == 'barrier_trigger_simulator') {
    //                     $rulesBuy_pArr  = explode(',', $chartDataFinal->rulesBuy_btsArr);
    //                     $rulesSell_pArr = explode(',', $chartDataFinal->rulesSell_btsArr);
    //                 }
	// 				//  Function call to get getTriggerCalForHighchartBuy Buy rule data
	// 				$buySum    =  $this->mod_highchart->getTriggerCalForHighchartBuy($rulesBuy_pArr);
	// 				// *** ====================================================================== ***
	// 				//  Function call to get getTriggerCalForHighchartBuy Sell rule Data
	// 				$sellSum   =  $this->mod_highchart->getTriggerCalForHighchartBuy($rulesSell_pArr);
	// 				// *** ====================================================================== ***
                   
    //             }//////////////////////////////////////
    //             $prefix          = ', ';
    //             // ************** For view ************ //
	// 			$pre_time  = date('Y-m-d H:i:s', strtotime($newDateTimeForView)); 
    //             $second    = strtotime($pre_time) + ((($k+$i)-1) * $MmnutHour);
    //             $end_dateB = date($formate, ($second));
    //             $htmlViewTime .= "'" . $end_dateB . "'";
    //             if (++$i === $recent_count) {} else { $htmlViewTime .= ','; }
    //             // ************** For view ************ //
    //         }
    //     }
	// 	// Curent Market value Withou Calculation 3-14
	// 	$data['highest_market_value_sample']  = $currentMarket_Highest_normalF;
	// 	$data['lowest_market_value_sample']   = $currentMarket_Lowest_normalF;
	// 	$data['current_market_value_sample']  = $currentMarket_normalF;
	// 	$data['highest_market_value']         = $highest_market_value;
	// 	$data['lowest_market_value']          = $lowest_market_value;
	//     $data['bigBuyDivideSell']             = $bigBuyDivideSell;
    //     $data['last_qty_time_ago']            = $last_qty_time_ago;
    //     $data['last_200_time_ago']            = $last_200_time_ago;
    //     $data['black_wall_pressure']          = $black_wall_pressure;
    //     $data['yellow_wall_pressure']         = $yellow_wall_pressure;
    //     $data['pressure_diff']                = $pressure_diff;
    //     $data['great_wall_price']             = $great_wall_price;
    //     $data['seven_level_depth']            = $seven_level_depth;
    //     $data['score']                        = $score;
    //     $data['current_market_value']         = $current_market_value;
    //     $data['current_market_value2']        = $current_market_value2;
    //     $data['market_depth_quantity']        = $market_depth_quantity;
    //     $data['askFormate']                   = number_format_symbol($ask_buy_for);
    //     $data['bidFormate']                   = number_format_symbol($ask_buy_for);
    //     $data['buyFormate']                   = number_format_symbol($bid_sell_for);
    //     $data['sellFormate']                  = number_format_symbol($bid_sell_for);
    //     $data['time_cot']                     = number_format_symbol($time_cot);
    //     $data['sellers_buyers_per_t4cot']     = $sellers_buyers_per_t4cot;
    //     $data['sellers_buyers_per']           = $sellers_buyers_per;
    //     $data['market_depth_ask']             = $market_depth_ask;
    //     $data['straightline']                 = $straightline;
    //     $data['last_qty_buy_vs_sell']         = $last_qty_buy_vs_sell;
    //     $data['last_200_buy_vs_sell']         = $last_200_buy_vs_sell;
    //     $data['buyers']                       = $buyers;
    //     $data['sellers']                      = $sellers;
    //     $data['last_qty_buy_vs_sell_15']      = $last_qty_buy_vs_sell_15;
    //     $data['last_qty_time_ago_15']         = $last_qty_time_ago_15;
    //     $data['buyers_fifteen']               = $buyers_fifteen;
    //     $data['sellers_fifteen']              = $sellers_fifteen;
    //     $data['sellers_buyers_per_fifteen']   = $sellers_buyers_per_fifteen;
    //     $data['bid_contracts']                = $bid_contracts;
    //     $data['ask_contract']                 = $ask_contract;
    //     $data['buySum']                       = trim($buySum, ",");
    //     $data['sellSum']                      = trim($sellSum, ",");
    //     $data['rulesBuy']                     = trim($buySum, ",");
    //     $data['rulesSell']                    = trim($sellSum, ",");
    //     $data['ask']                          = $ask;
    //     $data['bid']                          = $bid;
    //     $data['buy']                          = $buy;
    //     $data['sell']                         = $sell;
		
    //     $data['black_wall_percentile']          = $black_wall_percentile;
    //     $data['sevenlevel_percentile']          = $sevenlevel_percentile;
    //     $data['rolling_five_bid_percentile']    = $rolling_five_bid_percentile;
    //     $data['rolling_five_ask_percentile']    = $rolling_five_ask_percentile;
    //     $data['five_buy_sell_percentile']       = $five_buy_sell_percentile;
    //     $data['fifteen_buy_sell_percentile']    = $fifteen_buy_sell_percentile;
    //     $data['last_qty_buy_sell_percentile']   = $last_qty_buy_sell_percentile;
    //     $data['last_qty_time_percentile']       = $last_qty_time_percentile;
	// 	$data['virtual_barrier_percentile']     = $virtual_barrier_percentile;
	// 	$data['virtual_barrier_percentile_ask'] = $virtual_barrier_percentile_ask;
	// 	$data['last_qty_time_fif_percentile']   = $last_qty_time_fif_percentile;
	// 	$data['big_buyers_percentile']          = $big_buyers_percentile;
	// 	$data['big_sellers_percentile']         = $last_qty_time_percentile;
	// 	$data['buy_percentile']                 = $buy_percentile;
	// 	$data['sell_percentile']                = $sell_percentile;
	// 	$data['ask_percentile']                 = $ask_percentile;
	// 	$data['bid_percentile']                 = $bid_percentile;
		
    //     $data['timView']                      = $htmlViewTime;
    //     $data['coins_arr']                    = $all_coins_arr;
    //     $data['global_symbol']                = $global_symbol;
    //     $data['startDate']                    = $newDateTimeForView;
    //     $data['endDate']                      = $end_dateAForView;
    //     $data['totalHours']                   = $totalHours;
    //     $data['time']                         = $time;
    //     $data['bottom_height']                = $bottom_height;
    //     $data['chart_arr']                    = $fianalArr;
    //     $data['get_sesion_data_arr']          = $get_sesion_data_arr;
    //     $data['price_format']                 = $prc_formate;
    //     $data['timezone']                     = $this->session->userdata('timezone');
    //     $data['session_data_array']           = $form_sesion_data_arr;
    //     $data['categroy']                     = $categroy;
	
    //     $this->stencil->paint('admin/highchart/candle_report', $data);
    // } //End candle_report
	
	
	
    // public function next_session($tabNo)
    // {
    //     $timezone       = $this->session->userdata('timezone');
    //     $page_post_data = $this->session->userdata('page_post_data');
    //     $start_dateOrg  = $page_post_data['start_date'];
    //     $end_dateOrg    = $page_post_data['end_date'];
    //     $tabNoOrg       = $tabNo;
    //     $tabNoA         = $tabNo;
		
		
	// 	// convert seconds into a specific format 
    //     $start_dateGG   = date("Y-m-d G:i:00", $start_dateOrg);
    //     $end_date       = date("Y-m-d G:i:s", $end_dateOrg);
    //     $starttimestamp = strtotime($start_dateOrg);
    //     $endtimestamp   = strtotime($end_dateOrg);
    //     $difference     = abs($endtimestamp - $starttimestamp) / 3600;
    //     $totalHours     = $difference;
    //     if ($tabNo > 1) {
    //         $tabNo                = $tabNo - 1;
    //         $start_dateStratOtime = strtotime($end_dateOrg);
    //         $totalFinalSeconds    = $tabNo * ($totalHours * 3600);
    //         $finalTimeSecond      = $start_dateStratOtime + $totalFinalSeconds;
    //         $start_dateGGNew      = date("m/d/Y h:i A", $finalTimeSecond);
    //         $end_dateOrg          = $start_dateGGNew;
    //     }
    //     if ($tabNoA > 2) {
    //         $totalFinalSeconds = ($totalHours * 3600);
    //     } else {
    //         $tabNo             = $tabNo;
    //         $totalFinalSeconds = $tabNo * ($totalHours * 3600);
    //     }
		
    //     $End_dateStratOtime = strtotime($end_dateOrg);
    //     $finalTimeSecond    = $End_dateStratOtime + $totalFinalSeconds;
    //     $End_dateGGNew      = date("m/d/Y h:i A", $finalTimeSecond);
    //     $nextStartDate      = $end_dateOrg;
    //     $nextEndDate        = $End_dateGGNew;
    //     $newDateTime        = $nextStartDate;
    //     $end_dateA          = $nextEndDate;
		
    //     // *** Convert time ZOne *** //    
    //     $dt                 = new DateTime($newDateTime, new DateTimeZone($timezone));
    //     $dt->setTimezone(new DateTimeZone('UTC'));
    //     $newDateTime = $dt->format("Y-m-d H:i:s");
    //     $dt2         = new DateTime($end_dateA, new DateTimeZone($timezone));
    //     $dt2->setTimezone(new DateTimeZone('UTC'));
    //     $end_dateA          = $dt2->format("Y-m-d H:i:s");
    //     // *** Convert time ZOne *** //  
    //     // This is use fro only views//  
    //     $newDateTimeForView = $nextStartDate;
    //     $end_dateAForView   = $nextEndDate;
    //     // *** Convert time ZOne ***//  
    //     error_reporting(0);
    //     //Login Check
    //     $this->mod_login->verify_is_admin_login();
    //     $all_coins_arr     = $this->mod_sockets->get_all_coins();
    //     $global_symbol     = $this->session->userdata('global_symbol');
    //     $timezone          = $this->session->userdata('timezone');
		
    //     $price_format      = $page_post_data['price_format'];
    //     $price_format      = ($price_format == '') ? 1000000 : $price_format;
    //     $time              = $page_post_data['time'];
    //     $time              = ($time == '') ? 'minut' : $time;
    //     $coin              = $page_post_data['coin'];
    //     $coinval           = ($coin == '') ? $global_symbol : $coin;
    //     $time_cot          = $page_post_data['time_cot'];
    //     $time_cot          = ($time_cot == '') ? 1 : $time_cot;
    //     $mutiply_no_score  = $page_post_data['mutiply_no_score'];
    //     $mutiply_no_score  = ($mutiply_no_score == '') ? 1 : $mutiply_no_score;
    //     $mutiply_no_market = $page_post_data['mutiply_no_market'];
    //     $mutiply_no_market = ($mutiply_no_market == '') ? 1 : $mutiply_no_market;
    //     $minus_no_score    = $page_post_data['minus_no_score'];
    //     $minus_no_score    = ($minus_no_score == '') ? 0 : $minus_no_score;
    //     $m_buyers_sellers  = $page_post_data['m_buyers_sellers'];
    //     $m_buyers_sellers  = ($m_buyers_sellers == '') ? 1 : $m_buyers_sellers;
    //     $s_b_15            = $page_post_data['s_b_15'];
    //     $s_b_15            = ($s_b_15 == '') ? 1 : $s_b_15;
    //     $l_quantity_15     = $page_post_data['l_quantity_15'];
    //     $l_quantity_15     = ($l_quantity_15 == '') ? 1 : $l_quantity_15;
    //     $rule_buy_sell     = $page_post_data['rule_buy_sell'];
    //     $rule_buy_sell     = ($rule_buy_sell == '') ? 1 : $rule_buy_sell;
    //     $bottom_height     = $page_post_data['bottom_height'];
    //     $bottom_height     = ($bottom_height == '') ? 10 : $bottom_height;
    //     $ask_buy_for       = $page_post_data['ask_buy_for'];
    //     $ask_buy_for       = ($ask_buy_for == '') ? 10 : $ask_buy_for;
    //     $bid_sell_for      = $page_post_data['bid_sell_for'];
    //     $bid_sell_for      = ($bid_sell_for == '') ? 10 : $bid_sell_for;
    //     $trigger           = $page_post_data['trigger'];
		
    //     if ($this->input->post()) {
    //         $this->session->set_userdata(array(
    //             'page_post_data' => $this->input->post()
    //         ));
    //     }
		
	// 	 // *** Convert time ZOne *** //  
    //     $form_sesion_data_arr = $this->mod_highchart->get_sesion_data($coinval);
		
    //     // *** Empty Array Decalaration *** //
    //     $black_wall_pressure          = '';
    //     $yellow_wall_pressure         = '';
    //     $pressure_diff                = '';
    //     $great_wall_price             = '';
    //     $seven_level_depth            = '';
    //     $score                        = '';
    //     $straightline                 = '';
    //     $current_market_value         = '';
    //     $last_qty_time_ago            = '';
    //     $last_200_time_ago            = '';
    //     $last_200_time_ago            = '';
    //     $market_depth_quantity        = '';
    //     $market_depth_ask             = '';
    //     $last_qty_buy_vs_sell         = '';
    //     $last_200_buy_vs_sell         = '';
    //     $last_qty_buy_vs_sell_15      = '';
    //     $last_qty_time_ago_15         = '';
    //     $buyers                       = '';
    //     $sellers                      = '';
    //     $buyers_fifteen               = '';
    //     $sellers_fifteen              = '';
    //     $sellers_buyers_per_fifteen   = '';
    //     $bid_contracts                = '';
    //     $ask_contract                 = '';
    //     $buySum                       = '';
    //     $sellSum                      = '';
    //     $ask                          = '';
    //     $bid                          = '';
    //     $buy                          = '';
    //     $sell                         = '';
    //     $black_wall_percentile        = '';
    //     $sevenlevel_percentile        = '';
    //     $rolling_five_bid_percentile  = '';
    //     $rolling_five_ask_percentile  = '';
    //     $five_buy_sell_percentile     = '';
    //     $fifteen_buy_sell_percentile  = '';
    //     $last_qty_buy_sell_percentile = '';
    //     $last_qty_time_percentile     = '';
    //     // *** Empty Array Decalaration *** //    
	// 	if ($newDateTime != '' && $end_dateA != '' && $time == 'minut') {
			
			
		
			
			
    //         $getChartDataReportCandle = $this->mod_highchart->getChartDataReportCandle($coinval, $newDateTime, $end_dateA);
    //         $getChartDataReportCandle = array_reverse($getChartDataReportCandle);
    //         //echo "<prE>";  print_r($getChartDataReportCandle); exit;
    //         $starttimestamp           = strtotime($end_dateA);
    //         $endtimestamp             = strtotime($newDateTime); //paroon
    //         $difference               = abs($endtimestamp - $starttimestamp) / 3600 * 60;
    //         $totalHours               = $difference;
    //         $prefix                   = $market_depth_quantity = '';
    //         $i                        = 1;
    //         $MmnutHour                = 60;
    //         $formate                  = 'd M Y H:i A';
    //         foreach ($getChartDataReportCandle as $key => $chartDataFinal) {
    //             $currentMarketOrg  = num($chartDataFinal->current_market_value);
    //             $currentMarket     = ($mutiply_no_market != '') ? num($chartDataFinal->current_market_value * $mutiply_no_market) : num($currentMarketOrg);
    //             $currentMarketFinl = ($minus_no_score != '') ? num($currentMarket - $minus_no_score) : num($currentMarket);
    //             $newCurrentMarket  = num($chartDataFinal->current_market_value);
    //             $black_wall_pressure .= $prefix . '' . num(round($chartDataFinal->black_wall_pressure, 1, PHP_ROUND_HALF_UP)) . '';
    //             $yellow_wall_pressure .= $prefix . '' . num($chartDataFinal->yellow_wall_pressure) . '';
    //             $pressure_diff .= $prefix . '' . num($chartDataFinal->pressure_diff) . '';
    //             $great_wall_price .= $prefix . '' . num($chartDataFinal->great_wall_price) . '';
    //             $seven_level_depth .= $prefix . '' . num($chartDataFinal->seven_level_depth) . '';
    //             $score .= $prefix . '' . num($chartDataFinal->score) . '';
    //             $straightline .= $prefix . '' . num($chartDataFinal->straightline) . '';
    //             $current_market_value .= $prefix . '' . num($currentMarketFinl) . '';
    //             $last_qty_time_ago .= $prefix . '' . num($chartDataFinal->last_qty_time_ago) . '';
    //             $last_200_time_ago .= $prefix . '' . num($chartDataFinal->last_200_time_ago) . '';
    //             $market_depth_quantity .= $prefix . '' . num($chartDataFinal->market_depth_quantity / $price_format) . '';
    //             $market_depth_ask .= $prefix . '' . num($chartDataFinal->market_depth_ask / $price_format) . '';
    //             $last_qty_buy_vs_sell .= $prefix . '' . num($chartDataFinal->last_qty_buy_vs_sell) . '';
    //             $last_200_buy_vs_sell .= $prefix . '' . num($chartDataFinal->last_200_buy_vs_sell) . '';
    //             $last_qty_buy_vs_sell_15 .= $prefix . '' . num($chartDataFinal->last_qty_buy_vs_sell_15 / $l_quantity_15) . '';
    //             $last_qty_time_ago_15 .= $prefix . '' . num($chartDataFinal->last_qty_time_ago_15) . '';
    //             $buyers .= $prefix . '' . num($chartDataFinal->buyers / $time_cot) . '';
    //             $sellers .= $prefix . '' . num($chartDataFinal->sellers / $time_cot) . '';
    //             $buyers_fifteen  .= $prefix . '' . num(round($chartDataFinal->buyers_fifteen / $s_b_15, 1, PHP_ROUND_HALF_UP)) . '';
    //             $sellers_fifteen .= $prefix . '' . num($chartDataFinal->sellers_fifteen / $s_b_15) . '';
    //             $sellers_buyers_per_fifteen .= $prefix . '' . num($chartDataFinal->sellers_buyers_per_fifteen) . '';
    //             $bid_contracts .= $prefix . '' . num($chartDataFinal->bid_contracts / $m_buyers_sellers) . '';
    //             $ask_contract  .= $prefix . '' . num($chartDataFinal->ask_contract / $m_buyers_sellers) . '';
    //             $ask  .= $prefix . '' . num($chartDataFinal->ask / $ask_buy_for) . '';
    //             $bid  .= $prefix . '' . num($chartDataFinal->bid / $ask_buy_for) . '';
    //             $buy  .= $prefix . '' . num($chartDataFinal->buy / $bid_sell_for) . '';
    //             $sell .= $prefix . '' . num($chartDataFinal->sell / $bid_sell_for) . '';
    //             $sellers_buyers_per_t4cot .= $prefix . '' . num($chartDataFinal->sellers_buyers_per_t4cot / $time_cot) . '';
    //             $sellers_buyers_per .= $prefix . '' . num($chartDataFinal->sellers_buyers_per) . '';
    //             $buyerCot    = ($chartDataFinal->buyers / $time_cot);
    //             $sellersCot  = ($chartDataFinal->sellers / $time_cot);
    //             $tcotBuyer   = ($buyerCot == 0) ? 1 : $buyerCot;
    //             $tcotSellers = ($sellersCot == 0) ? 1 : $sellersCot;
    //             $bigBuyDivideSell .= $prefix . '' . ($tcotBuyer / $tcotSellers) . '';
				
	// 			$black_wall_percentileFin        =  ($chartDataFinal->black_wall_percentile) ? $chartDataFinal->black_wall_percentile : 0 ;
	// 			$sevenlevel_percentileFin        =  ($chartDataFinal->sevenlevel_percentile) ? $chartDataFinal->sevenlevel_percentile : 0 ;
	// 			$rolling_five_bid_percentileFin  =  ($chartDataFinal->rolling_five_bid_percentile) ? $chartDataFinal->rolling_five_bid_percentile : 0 ;
	// 			$rolling_five_ask_percentileFin  =  ($chartDataFinal->rolling_five_ask_percentile) ? $chartDataFinal->rolling_five_ask_percentile : 0 ;
	// 			$five_buy_sell_percentileFin     =  ($chartDataFinal->five_buy_sell_percentile) ? $chartDataFinal->five_buy_sell_percentile : 0 ;
	// 			$fifteen_buy_sell_percentileFin  =  ($chartDataFinal->fifteen_buy_sell_percentile) ? $chartDataFinal->fifteen_buy_sell_percentile : 0 ;
	// 			$last_qty_buy_sell_percentileFin =  ($chartDataFinal->last_qty_buy_sell_percentile) ? $chartDataFinal->last_qty_buy_sell_percentile : 0 ;
	// 			$last_qty_time_percentileFin     =  ($chartDataFinal->last_qty_time_percentile) ? $chartDataFinal->last_qty_time_percentile : 0 ;
				
	// 			$virtual_barrier_percentileFin     =  ($chartDataFinal->virtual_barrier_percentile) ? $chartDataFinal->virtual_barrier_percentile : 0 ;
	// 			$virtual_barrier_percentile_askFin =  ($chartDataFinal->virtual_barrier_percentile_ask) ? $chartDataFinal->virtual_barrier_percentile_ask : 0 ;
	// 			$last_qty_time_fif_percentileFin   =  ($chartDataFinal->last_qty_time_fif_percentile) ? $chartDataFinal->last_qty_time_fif_percentile : 0 ;
	// 			$big_buyers_percentileFin          =  ($chartDataFinal->big_buyers_percentile)  ? $chartDataFinal->big_buyers_percentile : 0 ;
	// 			$big_sellers_percentileFin         =  ($chartDataFinal->big_sellers_percentile) ? $chartDataFinal->big_sellers_percentile : 0 ;
	// 			$buy_percentileFin                 =  ($chartDataFinal->buy_percentile)  ? $chartDataFinal->buy_percentile : 0 ;
	// 			$sell_percentileFin                =  ($chartDataFinal->sell_percentile) ? $chartDataFinal->sell_percentile : 0 ;
	// 			$ask_percentileFin                 =  ($chartDataFinal->ask_percentile)  ? $chartDataFinal->ask_percentile : 0 ;
	// 			$bid_percentileFin                 =  ($chartDataFinal->bid_percentile)  ? $chartDataFinal->bid_percentile : 0 ;
				
    //             // Percentile Code Goes here 
    //             $black_wall_percentile        .= $prefix . '' . ($black_wall_percentileFin) . '';
    //             $sevenlevel_percentile        .= $prefix . '' . ($sevenlevel_percentileFin) . '';
    //             $rolling_five_bid_percentile  .= $prefix . '' . ($rolling_five_bid_percentileFin) . '';
    //             $rolling_five_ask_percentile  .= $prefix . '' . ($rolling_five_ask_percentileFin) . '';
    //             $five_buy_sell_percentile     .= $prefix . '' . ($five_buy_sell_percentileFin) . '';
    //             $fifteen_buy_sell_percentile  .= $prefix . '' . ($fifteen_buy_sell_percentileFin) . '';
    //             $last_qty_buy_sell_percentile .= $prefix . '' . ($last_qty_buy_sell_percentileFin) . '';
    //             $last_qty_time_percentile     .= $prefix . '' . ($last_qty_time_percentileFin) . '';
				
	// 			$virtual_barrier_percentile     .= $prefix . '' . ($virtual_barrier_percentileFin) . '';
	// 			$virtual_barrier_percentile_ask .= $prefix . '' . ($virtual_barrier_percentile_askFin) . '';
	// 			$last_qty_time_fif_percentile   .= $prefix . '' . ($last_qty_time_fif_percentileFin) . '';
	// 			$big_buyers_percentile          .= $prefix . '' . ($big_buyers_percentileFin) . '';
	// 			$big_sellers_percentile         .= $prefix . '' . ($big_sellers_percentileFin) . '';
	// 			$buy_percentile                 .= $prefix . '' . ($buy_percentileFin) . '';
	// 			$sell_percentile                .= $prefix . '' . ($sell_percentileFin) . '';
	// 			$ask_percentile                 .= $prefix . '' . ($ask_percentileFin) . '';
	// 			$bid_percentile                 .= $prefix . '' . ($bid_percentileFin) . '';
    //             // Percentile Code Goes end here 
    //             // Percentile Code Goes end here 
    //             if ($trigger == 'all') {
    //                 $buySum .= $prefix . '' . num($chartDataFinal->buyrule * $rule_buy_sell) . '';
    //                 $sellSum .= $prefix . '' . num($chartDataFinal->sellrule * $rule_buy_sell) . '';
    //             } else {
    //                 if ($trigger == 'barrier_percentile_trigger') {
    //                     $rulesBuy_pArr  = explode(',', $chartDataFinal->rulesBuy_pArr);
    //                     $rulesSell_pArr = explode(',', $chartDataFinal->rulesSell_pArr);
    //                 } else if ($trigger == 'barrier_trigger') {
    //                     $rulesBuy_pArr  = explode(',', $chartDataFinal->rulesBuy_bArr);
    //                     $rulesSell_pArr = explode(',', $chartDataFinal->rulesSell_bArr);
    //                 } else if ($trigger == 'box_trigger_3') {
    //                     $rulesBuy_pArr  = explode(',', $chartDataFinal->rulesBuy_bt3Arr);
    //                     $rulesSell_pArr = explode(',', $chartDataFinal->rulesSell_bt3Arr);
    //                 } else if ($trigger == 'barrier_trigger_simulator') {
    //                     $rulesBuy_pArr  = explode(',', $chartDataFinal->rulesBuy_btsArr);
    //                     $rulesSell_pArr = explode(',', $chartDataFinal->rulesSell_btsArr);
    //                 }
    //                 if (in_array(1, $rulesBuy_pArr)) {
    //                     $ruleBuy1 = 1;
    //                 } else {
    //                     $ruleBuy1 = 0;
    //                 }
    //                 if (in_array(2, $rulesBuy_pArr)) {
    //                     $ruleBuy2 = 1;
    //                 } else {
    //                     $ruleBuy2 = 0;
    //                 }
    //                 if (in_array(3, $rulesBuy_pArr)) {
    //                     $ruleBuy3 = 1;
    //                 } else {
    //                     $ruleBuy3 = 0;
    //                 }
    //                 if (in_array(4, $rulesBuy_pArr)) {
    //                     $ruleBuy4 = 1;
    //                 } else {
    //                     $ruleBuy4 = 0;
    //                 }
    //                 if (in_array(5, $rulesBuy_pArr)) {
    //                     $ruleBuy5 = 1;
    //                 } else {
    //                     $ruleBuy5 = 0;
    //                 }
    //                 $ruleBuy1 = ($ruleBuy1 != 0) ? 1 * $rule_buy_sell : 0;
    //                 $ruleBuy2 = ($ruleBuy2 != 0) ? 1 * $rule_buy_sell : 0;
    //                 $ruleBuy3 = ($ruleBuy3 != 0) ? 1 * $rule_buy_sell : 0;
    //                 $ruleBuy4 = ($ruleBuy4 != 0) ? 1 * $rule_buy_sell : 0;
    //                 $ruleBuy5 = ($ruleBuy5 != 0) ? 1 * $rule_buy_sell : 0;
    //                 if ($ruleBuy1 != 0) {
    //                     $ruleValue = "{  y: 1, color: '#3CB371'}";
    //                     $buySum .= $prefix . '' . $ruleValue . '';
    //                 } else if ($ruleBuy2 != 0) {
    //                     $ruleValue = "{  y: 2, color: '#008000'}";
    //                     $buySum .= $prefix . '' . $ruleValue . '';
    //                 } else if ($ruleBuy3 != 0) {
    //                     $ruleValue = "{  y: 3, color: '#3CB371'}";
    //                     $buySum .= $prefix . '' . $ruleValue . '';
    //                 } else if ($ruleBuy4 != 0) {
    //                     $ruleValue = "{  y: 4, color: '#6B8E23'}";
    //                     $buySum .= $prefix . '' . $ruleValue . '';
    //                 } else if ($ruleBuy5 != 0) {
    //                     $ruleValue = "{  y: 5, color: '#9ACD32'}";
    //                     $buySum .= $prefix . '' . $ruleValue . '';
    //                 } else {
    //                     $buySum .= $prefix . '0';
    //                 }
    //                 if (in_array(1, $rulesSell_pArr)) {
    //                     $ruleSell1 = 1;
    //                 } else {
    //                     $ruleSell1 = 0;
    //                 }
    //                 if (in_array(2, $rulesSell_pArr)) {
    //                     $ruleSell2 = 1;
    //                 } else {
    //                     $ruleSell2 = 0;
    //                 }
    //                 if (in_array(3, $rulesSell_pArr)) {
    //                     $ruleSell3 = 1;
    //                 } else {
    //                     $ruleSell3 = 0;
    //                 }
    //                 if (in_array(4, $rulesSell_pArr)) {
    //                     $ruleSell4 = 1;
    //                 } else {
    //                     $ruleSell4 = 0;
    //                 }
    //                 if (in_array(5, $rulesSell_pArr)) {
    //                     $ruleSell5 = 1;
    //                 } else {
    //                     $ruleSell5 = 0;
    //                 }
    //                 $ruleSell1 = ($ruleSell1 != 0) ? 1 * $rule_buy_sell : 0;
    //                 $ruleSell2 = ($ruleSell2 != 0) ? 1 * $rule_buy_sell : 0;
    //                 $ruleSell3 = ($ruleSell3 != 0) ? 1 * $rule_buy_sell : 0;
    //                 $ruleSell4 = ($ruleSell4 != 0) ? 1 * $rule_buy_sell : 0;
    //                 $ruleSell5 = ($ruleSell5 != 0) ? 1 * $rule_buy_sell : 0;
    //                 if ($ruleSell1 != 0) {
    //                     //$categroy   .= $prefix . "'level 1'"; 
    //                     $ruleValues = "{  y: 1, color: '#FFA07A'}";
    //                     $sellSum .= $prefix . '' . $ruleValues . '';
    //                 } else if ($ruleSell2 != 0) {
    //                     $ruleValues = "{  y: 2, color: '#8B0000'}";
    //                     $sellSum .= $prefix . '' . $ruleValues . '';
    //                 } else if ($ruleSell3 != 0) {
    //                     $ruleValues = "{  y: 3, color: '#FF6347'}";
    //                     $sellSum .= $prefix . '' . $ruleValues . '';
    //                 } else if ($ruleSell4 != 0) {
    //                     $ruleValues = "{  y: 4, color: '#DB7093'}";
    //                     $sellSum .= $prefix . '' . $ruleValues . '';
    //                 } else if ($ruleSell5 != 0) {
    //                     $ruleValues = "{  y: 5, color: '#B22222'}";
    //                     $sellSum .= $prefix . '' . $ruleValues . '';
    //                 } else {
    //                     $sellSum .= $prefix . '0';
    //                 }
    //             }
    //             $prefix          = ', ';
    //             // ************** For view ************ //
    //             $htmlView        = '';
    //             $currentDateTime = $newDateTimeForView;
    //             $end_dateA       = date('m/d/Y h:i A', strtotime($currentDateTime));
    //             $dt              = new DateTime($currentDateTime, new DateTimeZone($timezone));
    //             $dt->setTimezone(new DateTimeZone('UTC'));
    //             $pre_time  = $dt->format('Y-m-d H:i:s');
    //             $second    = strtotime($pre_time) + ($i * $MmnutHour);
    //             $end_dateB = date($formate, ($second));
    //             $htmlViewTime .= "'" . $end_dateB . "'";
    //             if (++$i === $recent_count) {} else { $htmlViewTime .= ','; }
    //             // ************** For view ************ //
    //         }
    //     }
    //     $data['bigBuyDivideSell']             = $bigBuyDivideSell;
    //     $data['last_qty_time_ago']            = $last_qty_time_ago;
    //     $data['last_200_time_ago']            = $last_200_time_ago;
    //     $data['black_wall_pressure']          = $black_wall_pressure;
    //     $data['yellow_wall_pressure']         = $yellow_wall_pressure;
    //     $data['pressure_diff']                = $pressure_diff;
    //     $data['great_wall_price']             = $great_wall_price;
    //     $data['seven_level_depth']            = $seven_level_depth;
    //     $data['score']                        = $score;
    //     $data['current_market_value']         = $current_market_value;
    //     $data['current_market_value2']        = $current_market_value2;
    //     $data['market_depth_quantity']        = $market_depth_quantity;
    //     $data['askFormate']                   = number_format_symbol($ask_buy_for);
    //     $data['bidFormate']                   = number_format_symbol($ask_buy_for);
    //     $data['buyFormate']                   = number_format_symbol($bid_sell_for);
    //     $data['sellFormate']                  = number_format_symbol($bid_sell_for);
    //     $data['time_cot']                     = number_format_symbol($time_cot);
    //     $data['sellers_buyers_per_t4cot']     = $sellers_buyers_per_t4cot;
    //     $data['sellers_buyers_per']           = $sellers_buyers_per;
    //     $data['market_depth_ask']             = $market_depth_ask;
    //     $data['straightline']                 = $straightline;
    //     $data['last_qty_buy_vs_sell']         = $last_qty_buy_vs_sell;
    //     $data['last_200_buy_vs_sell']         = $last_200_buy_vs_sell;
    //     $data['buyers']                       = $buyers;
    //     $data['sellers']                      = $sellers;
    //     $data['last_qty_buy_vs_sell_15']      = $last_qty_buy_vs_sell_15;
    //     $data['last_qty_time_ago_15']         = $last_qty_time_ago_15;
    //     $data['buyers_fifteen']               = $buyers_fifteen;
    //     $data['sellers_fifteen']              = $sellers_fifteen;
    //     $data['sellers_buyers_per_fifteen']   = $sellers_buyers_per_fifteen;
    //     $data['bid_contracts']                = $bid_contracts;
    //     $data['ask_contract']                 = $ask_contract;
    //     $data['buySum']                       = trim($buySum, ",");
    //     $data['sellSum']                      = trim($sellSum, ",");
    //     $data['rulesBuy']                     = trim($buySum, ",");
    //     $data['rulesSell']                    = trim($sellSum, ",");
    //     $data['ask']                          = $ask;
    //     $data['bid']                          = $bid;
    //     $data['buy']                          = $buy;
    //     $data['sell']                         = $sell;
		
    //     $data['black_wall_percentile']        = $black_wall_percentile;
    //     $data['sevenlevel_percentile']        = $sevenlevel_percentile;
    //     $data['rolling_five_bid_percentile']  = $rolling_five_bid_percentile;
    //     $data['rolling_five_ask_percentile']  = $rolling_five_ask_percentile;
    //     $data['five_buy_sell_percentile']     = $five_buy_sell_percentile;
    //     $data['fifteen_buy_sell_percentile']  = $fifteen_buy_sell_percentile;
    //     $data['last_qty_buy_sell_percentile'] = $last_qty_buy_sell_percentile;
    //     $data['last_qty_time_percentile']     = $last_qty_time_percentile;
		
	// 	$data['virtual_barrier_percentile']     = $virtual_barrier_percentile;
	// 	$data['virtual_barrier_percentile_ask'] = $virtual_barrier_percentile_ask;
	// 	$data['last_qty_time_fif_percentile']   = $last_qty_time_fif_percentile;
	// 	$data['big_buyers_percentile']          = $big_buyers_percentile;
	// 	$data['big_sellers_percentile']         = $last_qty_time_percentile;
	// 	$data['buy_percentile']                 = $buy_percentile;
	// 	$data['sell_percentile']                = $sell_percentile;
	// 	$data['ask_percentile']                 = $ask_percentile;
	// 	$data['bid_percentile']                 = $bid_percentile;
		
    //     $data['timView']                      = $htmlViewTime;
    //     $data['coins_arr']                    = $all_coins_arr;
    //     $data['global_symbol']                = $global_symbol;
    //     $data['startDate']                    = $newDateTimeForView;
    //     $data['endDate']                      = $end_dateAForView;
    //     $data['totalHours']                   = $totalHours;
    //     $data['time']                         = $time;
    //     $data['bottom_height']                = $bottom_height;
    //     $data['chart_arr']                    = $fianalArr;
    //     $data['get_sesion_data_arr']          = $get_sesion_data_arr;
    //     $data['price_format']                 = $prc_formate;
    //     $data['timezone']                     = $this->session->userdata('timezone');
    //     $data['session_data_array']           = $form_sesion_data_arr;
    //     $data['categroy']                     = $categroy;
	// 	$data['tab_no']                       = $tabNoA;
        
      
    //     //stencil is our templating library. Simply call view via it
    //     $this->stencil->paint('admin/highchart/nextsession', $data);
    // } //End next_session
    // Save the main session Goes here
    // public function save_session()
    // {
    //     $save_sesion_data     = $this->input->post('save_sesion_data');
    //     $coin                 = $this->input->post('coin');
    //     $save_sesion_data_arr = $this->mod_highchart->save_sesion_data($save_sesion_data, $coin);
    //     $form_sesion_data_arr = $this->mod_highchart->get_sesion_data($coin);
    //     $html                 = '<option value="">Select Session</option>';
    //     foreach ($form_sesion_data_arr as $session) {
    //         $html .= '<option value="' . $session->_id . '">' . $session->session_name . '</option>';
    //     }
    //     if ($save_sesion_data_arr) {
    //         $json_array['success'] = true;
    //         $json_array['html']    = $html;
    //     } else {
    //         $json_array['success'] = false;
    //         $json_array['html']    = '<div class="alert alert-danger"> </div>';
    //     }
    //     echo json_encode($json_array);
    //     exit;
    // } //End  save_session
    // public function update_session()
    // {
    //     $formarray  = array();
    //     $formData   = $this->input->post('formData');
    //     $session_id = $this->input->post('update_session_id');
    //     parse_str($_POST['formData'], $searcharray);
    //     $update_sesion_data_arr = $this->mod_highchart->update_sesion_data($searcharray, $session_id);
    //     if ($update_sesion_data_arr) {
    //         $json_array['success'] = true;
    //         $json_array['html']    = $html;
    //     } else {
    //         $json_array['success'] = false;
    //         $json_array['html']    = '<div class="alert alert-danger"> </div>';
    //     }
    //     echo json_encode($json_array);
    //     exit;
    // } //End  update_session
	
	//  public function candle_report_csv()
    // {
    //     error_reporting(0);
    //     //Login Check
    //     $this->mod_login->verify_is_admin_login();
    //     $global_symbol     = $this->session->userdata('global_symbol');
    //     $timezone          = $this->session->userdata('timezone');
	// 	$start_date_csv    = $this->input->post('start_date_csv');
	// 	$end_date_csv      = $this->input->post('end_date_csv');
	// 	$coin_csv          = $this->input->post('coin_csv');
	// 	$time_csv          = $this->input->post('time_csv');
	 
    //     // *** Convert time ZOne ***//  
    //     $dt                 = new DateTime($start_date_csv, new DateTimeZone($timezone));
    //     $dt->setTimezone(new DateTimeZone('UTC'));
    //     $newDateTime        = $dt->format("Y-m-d H:i:s");
    //     $dt2                = new DateTime($end_date_csv, new DateTimeZone($timezone));
    //     $dt2->setTimezone(new DateTimeZone('UTC'));
    //     $end_dateA          = $dt2->format("Y-m-d H:i:s");		
    //     // *** Convert time ZOne *** //  
    //     // ***    Empty Varainle decalration       *** //  
	// 	$highchart_empty_variable = $this->mod_highchart->highchart_empty_variable();
       
    //    if ($end_dateA != '' && $newDateTime != '' && $time_csv == 'minut') {
			
    //         $getChartDataReportCandle = $this->mod_highchart->getChartDataReportCandle($coin_csv, $newDateTime, $end_dateA);
    //         $getChartDataReportCandle = array_reverse($getChartDataReportCandle);
			
		
    //         $prefix                   = $market_depth_quantity = '';
    //         $i                        = 1;
    //         $MmnutHour                = 60;
    //         $formate                  = 'd M Y H:i A';
    //         foreach ($getChartDataReportCandle as $key => $chartDataFinal) {
				
	// 			$dt                   = new DateTime($chartDataFinal->datetime_user_friend, new DateTimeZone("UTC"));
    //             $dt->setTimezone(new DateTimeZone($timezone));
    //             $newDateTimeUser      = $dt->format("Y-m-d H:i:s");
				
    //             $finalArr['Time']                  =  $newDateTimeUser;//($chartDataFinal->datetime_user_friend);
    //             $finalArr['Highest Market Value']  =  num($chartDataFinal->highest_market_value) . '';
	// 			$finalArr['Current Market']        =  num($chartDataFinal->current_market_value);		
	// 			$finalArr['Lowest Market Value']   =  num($chartDataFinal->lowest_market_value) . '';
    //             $finalArr['TW 2']                   =  num(round($chartDataFinal->black_wall_pressure, 1, PHP_ROUND_HALF_UP)) . '';
	// 		    $finalArr['TW 1']                  =  num($chartDataFinal->yellow_wall_pressure) . '';
    //             $finalArr['TL5 Delta']             =  num($chartDataFinal->pressure_diff) . '';
    //             $finalArr['TL5 S/R']               =  num($chartDataFinal->great_wall_price) . '';
    //             $finalArr['TL7 Delta']             =  num($chartDataFinal->seven_level_depth) . '';
    //             $finalArr['Score']                 =  num($chartDataFinal->score) . '';
    //             $finalArr['TL5 SA']                =  num($chartDataFinal->last_qty_time_ago) . '';
    //             $finalArr['TL5 TA']                =  num($chartDataFinal->last_200_time_ago) . '';
    //             $finalArr['TL1 BID']               =  num($chartDataFinal->market_depth_quantity ) . '';
    //             $finalArr['TL1 ASK']               =  num($chartDataFinal->market_depth_ask ) . '';
    //             $finalArr['TQ5 Delta Buy/Sell']    =  num($chartDataFinal->last_qty_buy_vs_sell) . '';
    //             $finalArr['TC5 Delta Buy/Sell']    =  num($chartDataFinal->last_200_buy_vs_sell) . '';
    //             $finalArr['TL5 S/A 15']            =  num($chartDataFinal->last_qty_buy_vs_sell_15) . '';
    //             $finalArr['TQ5D 15 Buy/Sell']      =  num($chartDataFinal->last_qty_time_ago_15) . '';
    //             $finalArr['TR5 Buyers']            =  num($chartDataFinal->buyers ) . '';
    //             $finalArr['TR5 Sellers']           =  num($chartDataFinal->sellers ) . '';
    //             $finalArr['TR15 Buyers']           =  num(round($chartDataFinal->buyers_fifteen, 1, PHP_ROUND_HALF_UP)) . '';
    //             $finalArr['TR15 Sellers']          =  num($chartDataFinal->sellers_fifteen) . '';
    //             $finalArr['TR15 Delta']            =  num($chartDataFinal->sellers_buyers_per_fifteen) . '';
    //             $finalArr['Bid contracts']         =  num($chartDataFinal->bid_contracts) . '';
    //             $finalArr['Ask contracts']         =  num($chartDataFinal->ask_contract ) . '';
    //             $finalArr['Ask']                   =  num($chartDataFinal->ask ) . '';
    //             $finalArr['Bid']                   =  num($chartDataFinal->bid ) . '';
    //             $finalArr['Buy']                   =  num($chartDataFinal->buy ) . '';
    //             $finalArr['Sell']                  =  num($chartDataFinal->sell ) . '';
    //             $finalArr['Sellers buyers per t4cot']  = num($chartDataFinal->sellers_buyers_per_t4cot) . '';
    //             $finalArr['Sellers buyers per']    =  num($chartDataFinal->sellers_buyers_per) . '';
    //             $finalArr['BuyerCot']              =  ($chartDataFinal->buyers );
    //             $finalArr['SellersCot']            =  ($chartDataFinal->sellers);
    //             $finalArr['TcotBuyer']             =  ($finalArr['BuyerCot'] == 0) ? 1 :  $finalArr['BuyerCot'];
    //             $finalArr['TcotSellers']           =  ($finalArr['SellersCot'] == 0) ? 1 :  $finalArr['SellersCot'];
    //             $finalArr['BigBuyDivideSell']      =  ($finalArr['TcotBuyer'] / $finalArr['TcotSellers']) . '';
				
	// 			// ** IST
	// 			// ********** Black_wall_percentileVal ************ //
	// 			$black_wall_percentile             =  ($chartDataFinal->black_wall_percentile) ? $chartDataFinal->black_wall_percentile : 0 ;
	// 			$black_wall_percentileVal          =  $this->mod_highchart->checkPercentile($black_wall_percentile); 
	// 			$sevenlevel_percentile             =  ($chartDataFinal->sevenlevel_percentile) ? $chartDataFinal->sevenlevel_percentile : 0 ;
	// 			$sevenlevel_percentileVal          =  $this->mod_highchart->checkPercentile($sevenlevel_percentile); 
	// 			$rolling_five_bid_percentile       =  ($chartDataFinal->rolling_five_bid_percentile) ? $chartDataFinal->rolling_five_bid_percentile : 0 ;
	// 			$rolling_five_bid_percentileVal    =  $this->mod_highchart->checkPercentile($rolling_five_bid_percentile); 
	// 			$rolling_five_ask_percentile       =  ($chartDataFinal->rolling_five_ask_percentile) ? $chartDataFinal->rolling_five_ask_percentile : 0 ;
	// 			$rolling_five_ask_percentileVal    =  $this->mod_highchart->checkPercentile($rolling_five_ask_percentile); 
	// 			$five_buy_sell_percentile          =  ($chartDataFinal->five_buy_sell_percentile) ? $chartDataFinal->five_buy_sell_percentile : 0 ;
	// 			$five_buy_sell_percentileVal       =  $this->mod_highchart->checkPercentile($five_buy_sell_percentile); 
	// 			$fifteen_buy_sell_percentile       =  ($chartDataFinal->fifteen_buy_sell_percentile) ? $chartDataFinal->fifteen_buy_sell_percentile : 0 ;
	// 			$fifteen_buy_sell_percentileVal    =  $this->mod_highchart->checkPercentile($fifteen_buy_sell_percentile); 			
	// 			$last_qty_buy_sell_percentile      =  ($chartDataFinal->last_qty_buy_sell_percentile) ? $chartDataFinal->last_qty_buy_sell_percentile : 0 ;
	// 			$last_qty_buy_sell_percentileVal   =  $this->mod_highchart->checkPercentile($last_qty_buy_sell_percentile); 			
	// 			$last_qty_time_percentile          =  ($chartDataFinal->last_qty_time_percentile) ? $chartDataFinal->last_qty_time_percentile : 0 ;
	// 			$last_qty_time_percentileVal       =  $this->mod_highchart->checkPercentile($last_qty_time_percentile); 			  
	// 			$virtual_barrier_percentile        =  ($chartDataFinal->virtual_barrier_percentile) ? $chartDataFinal->virtual_barrier_percentile : 0 ;
	// 			$virtual_barrier_percentileVal     =  $this->mod_highchart->checkPercentile($virtual_barrier_percentile); 	
	// 			$virtual_barrier_percentile_ask    =  ($chartDataFinal->virtual_barrier_percentile_ask) ? $chartDataFinal->virtual_barrier_percentile_ask : 0 ;
	// 			$virtual_barrier_percentile_askVal =  $this->mod_highchart->checkPercentile($virtual_barrier_percentile_ask); 
	// 			$last_qty_time_fif_percentile      =  ($chartDataFinal->last_qty_time_fif_percentile) ? $chartDataFinal->last_qty_time_fif_percentile : 0 ;
	// 			$last_qty_time_fif_percentileVal   =  $this->mod_highchart->checkPercentile($last_qty_time_fif_percentile); 
	// 			$big_buyers_percentile             =  ($chartDataFinal->big_buyers_percentile) ? $chartDataFinal->big_buyers_percentile : 0 ;
	// 			$big_buyers_percentileVal          =  $this->mod_highchart->checkPercentile($big_buyers_percentile); 
				
	// 			$big_sellers_percentile            =  ($chartDataFinal->big_sellers_percentile) ? $chartDataFinal->big_sellers_percentile : 0 ;
	// 			$big_sellers_percentileVal         =  $this->mod_highchart->checkPercentile($big_sellers_percentile); 
				
	// 			$buy_percentile                    =  ($chartDataFinal->buy_percentile) ? $chartDataFinal->buy_percentile : 0 ;
	// 			$buy_percentileVal                 =  $this->mod_highchart->checkPercentile($buy_percentile); 
	// 			$sell_percentile                   =  ($chartDataFinal->sell_percentile) ? $chartDataFinal->sell_percentile : 0 ;
	// 			$sell_percentileVal                =  $this->mod_highchart->checkPercentile($sell_percentile); 
	// 			$ask_percentile                    =  ($chartDataFinal->ask_percentile) ? $chartDataFinal->ask_percentile : 0 ;
	// 			$ask_percentileVal                 =  $this->mod_highchart->checkPercentile($ask_percentile); 
	// 			$bid_percentile                    =  ($chartDataFinal->bid_percentile) ? $chartDataFinal->bid_percentile : 0 ;
	// 			$bid_percentileVal                 =  $this->mod_highchart->checkPercentile($bid_percentile); 
				
	// 			$finalArr['Black wall percentile']          =  ($black_wall_percentileVal);
	// 			$finalArr['Seven level percentile']         =  ($sevenlevel_percentileVal);
	// 			$finalArr['Rolling five bid percentile']    =  ($rolling_five_bid_percentileVal);
	// 			$finalArr['Rolling five ask percentile']    =  ($rolling_five_ask_percentileVal);
	// 			$finalArr['Five buy sell percentile']       =  ($five_buy_sell_percentileVal);
	// 			$finalArr['Fifteen buy sell percentile']    =  ($fifteen_buy_sell_percentileVal)  ;
	// 			$finalArr['Last Qty buy sell percentile']   =  ($last_qty_buy_sell_percentileVal) ;
	// 			$finalArr['Last Qty time percentile']       =  ($last_qty_time_percentileVal)  ;
	// 			$finalArr['Virtual barrier percentile']     =  ($virtual_barrier_percentileVal)  ;
	// 			$finalArr['Virtual barrier percentile ask'] =  ($virtual_barrier_percentile_askVal)  ;
	// 			$finalArr['Last Qty Time 15 percentile']   =   ($last_qty_time_fif_percentileVal)  ;
	// 			$finalArr['Big buyers percentile']          =  ($big_buyers_percentileVal)  ;
	// 			$finalArr['Big sellers percentile']         =  ($big_sellers_percentileVal)  ;
	// 			$finalArr['Buy percentile']                 =  ($buy_percentileVal);
	// 			$finalArr['Sell percentile']                =  ($sell_percentileVal) ;
	// 			$finalArr['Ask percentile']                 =  ($ask_percentileVal) ;
	// 			$finalArr['Bid percentile']                 =  ($bid_percentileVal)  ;
				
	// 			$finalArrAll[] = $finalArr;
				
    //         }
    //     }		
	// 	if($finalArrAll){	
	// 		$filename = ($coin_csv .'-'. date("Y-m-d Gis") . ".csv");
	// 		// Set the Headers for csv 
	// 		$now = gmdate("D, d M Y H:i:s");
	// 		header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
	// 		header("Last-Modified: {$now} GMT");
	// 		header('Content-Type: text/csv;');
	// 		header("Pragma: no-cache");
	// 		header("Expires: 0");
	// 		// force download
	// 		header("Content-Type: application/force-download");
	// 		header("Content-Type: application/octet-stream");
	// 		header("Content-Type: application/download");
			
	// 		// disposition / encoding on response body
	// 		header("Content-Disposition: attachment;filename={$filename}");
	// 		header("Content-Transfer-Encoding: binary");
	// 		echo $this->arrayToCsv($finalArrAll);
	//     }//if($data){	
		
    // } //End candle_report_csv
	
	// public function arrayToCsv($array) {
		
	// 	if (count($array) == 0) {
	// 		return null;
	// 	}
	// 	ob_start();
	// 	$df = fopen("php://output", 'w');
	// 	fputcsv($df, array_keys((array) reset($array)));

	// 	foreach ($array as $key => $row) {
	// 		  //$rowNew  =  htmlspecialchars(trim(strip_tags($row))); 
	// 		  fputcsv($df, (array) $row);
	// 	}
	// 	fclose($df);
	// 	return ob_get_clean();
	// }//arrayToCsv
	
	// public function test_abcde(){
	   
	       
		   
	// 	$search_array['coin'] = 'TRXBTC';
	// 	//$search_array['modified_date'] = array(
	// 		//'$gte' => $start_date1,
	// 		//'$lte' => $end_date2
	// 	//);
	// 	$connetct = $this->mongo_db->customQuery();
	// 	$limit = 100;
	// 	$qr = array(
	// 		'skip' => $skip,
	// 		'sort' => array(
	// 			'modified_date' => - 1
	// 		) ,
	// 		'limit' => $limit
	// 	);
	// 	$cursor   = $connetct->coin_meta_history->find($search_array, $qr);
	// 	$resArray = iterator_to_array($cursor);
		
		   
		   
	// 	   echo "<pre>";  print_r($resArray);   exit;
		   
		   
		   
		 	
		
	// }
	
	
	// public function test(){
		
	//      $global_symbol  = 'NCASHBTC';
	//      $this->mongo_db->where(array('coin' => $global_symbol));

    //     $res = $this->mongo_db->get('task_manager_setting');	
		
	// 	$array =  iterator_to_array($res);
	// 	//echo "<pre>";  print_r( $array); exit;
		
		
	// }
}