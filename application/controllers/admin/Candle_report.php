<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Candle_report extends CI_Controller
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
        $this->load->model('admin/mod_candlereport');
        // New model 
        $this->load->model('admin/mod_users');
        $this->load->model('admin/mod_dashboard');
        $this->load->model('admin/mod_coins');
        $this->load->model('admin/mod_candel');
    }
    // public function index()
    // {
    //     ini_set("memory_limit", -1);
    //     $global_symbol     = $this->session->userdata('global_symbol');
    //     $global_mode       = $this->session->userdata('global_mode');
    //     $admin_id          = $this->session->userdata('admin_id');
    //     $offset            = $this->mod_candlereport->get_coin_offset_value($global_symbol);
    //     $data['offset']    = $offset;
    //     $periods           = '1h';
    //     $global_symbol     = 'TRXBTC';
    //     // Get candle stick data
    //     $candel_stick_arr_ = $this->mod_candlereport->get_candelstick_data_from_database($global_symbol, $periods);
    //     $candel_stick_arr  = $candel_stick_arr_['candle_arr'];
    //     $fianlArr          = array();
    //     foreach ($candel_stick_arr as $key => $row) {
			
    //         $compareVal   = num($row['close']) ;
    //         $boxWidthPerc = 4;
    //         if ($key == 0) {
    //             $valueToMul            = 1000000;
    //             $startPrice            = num($row['close']) * $valueToMul;
    //             $totalWidth            = $startPrice;
    //             $new_width             = ($boxWidthPerc / 100) * $totalWidth;
    //             $percentage            = num($new_width);
    //             $newPriceToMakeBoxTop  = ($startPrice + $percentage);
    //             $newPriceToMakeBoxTop  = num($newPriceToMakeBoxTop / $valueToMul) ;
    //             $newPriceToMakeBoxDown = ($startPrice - $percentage);
    //             $newPriceToMakeBoxDown = num($newPriceToMakeBoxDown / $valueToMul);
    //         }
    //         //{"top":"52","bottom":"48","color":"red"},
    //         if ($compareVal > $newPriceToMakeBoxTop) {
    //             // Second step code here
    //             $valueToMul            = 1000000;
    //             $compareVal            = num($row['close']);
    //             $startPrice            = num($row['close']) * $valueToMul;
    //             $totalWidth            = $startPrice;
    //             $new_width             = ($boxWidthPerc / 100) * $totalWidth;
    //             $percentage            = num($new_width);
    //             $newPriceToMakeBoxTop  = ($startPrice + $percentage);
    //             $newPriceToMakeBoxTop  = num($newPriceToMakeBoxTop / $valueToMul);
    //             $newPriceToMakeBoxDown = ($startPrice - $percentage);
    //             $newPriceToMakeBoxDown = num($newPriceToMakeBoxDown / $valueToMul);
    //             // Second step code End here
               
    //             $color                 = 'green';
    //             $candleStart           = num($compareVal);
    //             $candlendheight        = num($newPriceToMakeBoxTop);
    //             $fianlArr['top']       = $candleStart * $valueToMul  ; /// For general use 
    //             $fianlArr['bottom']    = $candlendheight * $valueToMul  ;
    //             $fianlArr['color']     = $color;
    //             $myArray[]             = $fianlArr;
				
    //         } else if ($compareVal < $newPriceToMakeBoxDown) {
    //             // Second step code here
    //             $valueToMul            = 1000000;
    //             $compareVal            = num($row['close']);
    //             $startPrice            = num($row['close']) * $valueToMul;
    //             $totalWidth            = $startPrice;
    //             $new_width             = ($boxWidthPerc / 100) * $totalWidth;
    //             $percentage            = num($new_width);
    //             $newPriceToMakeBoxTop  = ($startPrice + $percentage);
    //             $newPriceToMakeBoxTop  = num($newPriceToMakeBoxTop / $valueToMul);
    //             $newPriceToMakeBoxDown = ($startPrice - $percentage);
    //             $newPriceToMakeBoxDown = num($newPriceToMakeBoxDown / $valueToMul);
    //             // Second step code End here
               
    //             $color                 = 'red';
    //             $candleStart           = num($compareVal);
    //             $candlendheight        = num($newPriceToMakeBoxDown);
    //             $fianlArr['top']       = $candleStart * $valueToMul  ;
    //             $fianlArr['bottom']    = $candlendheight * $valueToMul  ;
    //             $fianlArr['color']     = $color;
    //             $myArray[]             = $fianlArr;
    //         }
    //     }
		
		
	
	
		
		
    //     $data['percentage'] = $boxWidthPerc;
    //     $data['final_arr']  = $myArray;
    //     $this->stencil->paint('admin/candle_report/candle_report', $data);
    // } //End index
    // public function test()
    // {
    //     ini_set("memory_limit", -1);
    //     $global_symbol     = $this->session->userdata('global_symbol');
    //     $global_mode       = $this->session->userdata('global_mode');
    //     $admin_id          = $this->session->userdata('admin_id');
    //     $offset            = $this->mod_candlereport->get_coin_offset_value($global_symbol);
    //     $data['offset']    = $offset;
    //     $periods           = '1h';
    //     $global_symbol     = 'TRXBTC';
    //     // Get candle stick data
    //     $candel_stick_arr_ = $this->mod_candlereport->get_candelstick_data_from_database($global_symbol, $periods);
    //     $candel_stick_arr  = $candel_stick_arr_['candle_arr'];
    //     $fianlArr          = array();
    //     foreach ($candel_stick_arr as $key => $row) {
    //         $compareVal   = num($row['close']);
    //         $boxWidthPerc = 2;
    //         if ($key == 0) {
    //             $valueToMul            = 100000;
    //             $startPrice            = num($row['close']) * $valueToMul;
    //             $totalWidth            = $startPrice;
    //             $new_width             = ($boxWidthPerc / 100) * $totalWidth;
    //             $percentage            = num($new_width);
    //             $newPriceToMakeBoxTop  = ($startPrice + $percentage);
    //             $newPriceToMakeBoxTop  = num($newPriceToMakeBoxTop / $valueToMul);
    //             $newPriceToMakeBoxDown = ($startPrice - $percentage);
    //             $newPriceToMakeBoxDown = num($newPriceToMakeBoxDown / $valueToMul);
    //         }
    //         //{"top":"52","bottom":"48","color":"red"},
    //         if ($compareVal > $newPriceToMakeBoxTop) {
    //             // Second step code here
    //             $valueToMul            = 100000;
    //             $compareVal            = num($row['close']);
    //             $startPrice            = num($row['close']) * $valueToMul;
    //             $totalWidth            = $startPrice;
    //             $new_width             = ($boxWidthPerc / 100) * $totalWidth;
    //             $percentage            = num($new_width);
    //             $newPriceToMakeBoxTop  = ($startPrice + $percentage);
    //             $newPriceToMakeBoxTop  = num($newPriceToMakeBoxTop / $valueToMul);
    //             $newPriceToMakeBoxDown = ($startPrice - $percentage);
    //             $newPriceToMakeBoxDown = num($newPriceToMakeBoxDown / $valueToMul);
    //             // Second step code End here
    //             $compareVal            = num($row['close']);
    //             $color                 = 'green';
    //             $candleStart           = num($compareVal);
    //             $candlendheight        = num($newPriceToMakeBoxTop);
    //             $fianlArr['top']       = $candleStart * $valueToMul;
    //             $fianlArr['bottom']    = $candlendheight * $valueToMul;
    //             $fianlArr['color']     = $color;
    //             $myArray[]             = $fianlArr;
    //         } else if ($compareVal < $newPriceToMakeBoxDown) {
    //             // Second step code here
    //             $valueToMul            = 100000;
    //             $compareVal            = num($row['close']);
    //             $startPrice            = num($row['close']) * $valueToMul;
    //             $totalWidth            = $startPrice;
    //             $new_width             = ($boxWidthPerc / 100) * $totalWidth;
    //             $percentage            = num($new_width);
    //             $newPriceToMakeBoxTop  = ($startPrice + $percentage);
    //             $newPriceToMakeBoxTop  = num($newPriceToMakeBoxTop / $valueToMul);
    //             $newPriceToMakeBoxDown = ($startPrice - $percentage);
    //             $newPriceToMakeBoxDown = num($newPriceToMakeBoxDown / $valueToMul);
    //             // Second step code End here
    //             $compareVal            = num($row['close']);
    //             $color                 = 'red';
    //             $candleStart           = num($compareVal);
    //             $candlendheight        = num($newPriceToMakeBoxDown);
    //             $fianlArr['top']       = $candleStart * $valueToMul;
    //             $fianlArr['bottom']    = $candlendheight * $valueToMul;
    //             $fianlArr['color']     = $color;
    //             $myArray[]             = $fianlArr;
    //         }
    //     }
    //     $data['percentage'] = $boxWidthPerc;
    //     echo "<pre>";
    //     print_r($myArray);
    //     exit;
    //     $max_volume_hourly = $candel_stick_arr_['max_volume'];
    //     $max_volume_bvs    = $candel_stick_arr_['max_volume_bvs'];
    //     if (count($candel_stick_arr) > 0) {
    //         $start_date_for_time_zone      = $candel_stick_arr[0]['openTime'];
    //         $end_date_for_time_zone        = $candel_stick_arr[count($candel_stick_arr) - 1]['openTime'];
    //         $start_date_for_time_zone_time = $candel_stick_arr[0]['timestampDate'];
    //         $end_date_for_time_zone_time   = $candel_stick_arr[count($candel_stick_arr) - 1]['timestampDate'];
    //     } //End of candel_stick_arr
    //     //Call function to get task Manager setting
    //     $order_data                       = $this->mod_candlereport->get_order_array($global_symbol, $admin_id, $global_mode, $start_date_for_time_zone_time, $end_date_for_time_zone_time);
    //     $task_manager_setting_arr         = $this->mod_candlereport->get_task_manager_setting($global_symbol);
    //     $data['task_manager_setting_arr'] = $task_manager_setting_arr;
    //     $coin_unit_val                    = $this->mod_candlereport->get_coin_unit_value($global_symbol);
    //     //$candel_stick_arr = $this->binance_api->get_candelstick($global_symbol,$periods);
    //     $draw_target_zone_arr             = $this->mod_candlereport->get_chart_target_zones($global_symbol);
    //     /***Check if target zone Exist***/
    //     if (count($draw_target_zone_arr) > 0) {
    //         foreach ($draw_target_zone_arr as $target_zone_value) {
    //             $start_date_second                     = $start_date_for_time_zone / 1000;
    //             $end_date_second                       = $end_date_for_time_zone / 1000;
    //             $unit_value                            = $coin_unit_val;
    //             $start_date                            = date("Y-m-d H:00:00", $start_date_second);
    //             $end_date                              = date("Y-m-d H:59:59", $end_date_second);
    //             $get_market_history_for_candel         = $this->mod_candlereport->get_candle_price_volume_detail($global_symbol, $start_date, $end_date, $unit_value);
    //             $target_zone_value['draw_target_zone'] = $get_market_history_for_candel;
    //             array_push($draw_target_zone_arr_full, $target_zone_value);
    //         }
    //     }
    //     /** End of for each **/
    //     $from_date_for_candel        = $candel_stick_arr[0]['openTime'];
    //     $end_date_for_candel         = $candel_stick_arr[count($candel_stick_arr) - 1]['openTime'];
    //     $from_date_for_candel_second = $from_date_for_candel / 1000;
    //     $end_date_for_candel_second  = $end_date_for_candel / 1000;
    //     $from_date_for_candel        = date("Y-m-d H:00:00", $from_date_for_candel_second);
    //     $end_date_for_candel         = date("Y-m-d H:59:59", $end_date_for_candel_second);
    //     $all_candle_volume_detail    = $this->mod_candlereport->get_candle_price_volume_detail($global_symbol, $from_date_for_candel, $end_date_for_candel, $unit_value = 0);
    //     $candel_stick_arr_new        = array();
    //     $bid_hour_arr_volume         = array();
    //     $ask_hour_arr_volume         = array();
    //     $total_hour_volume_arr       = array();
    //     foreach ($candel_stick_arr as $candel_stick_single_arr) {
    //         $openTime_current_time_zone                            = $candel_stick_single_arr['openTime'];
    //         $start_date_1                                          = date("Y-m-d H:00:00", $openTime_current_time_zone / 1000);
    //         $end_date_1                                            = date("Y-m-d H:59:59", $openTime_current_time_zone / 1000);
    //         $is_box_trade_buy                                      = $this->mod_candlereport->is_box_trigger_trade_buyed($start_date_1, $end_date_1, $global_symbol);
    //         $candel_stick_single_arr['is_boxtrigger_order_buy']    = $is_box_trade_buy['is_exist'];
    //         $candel_stick_single_arr['boxtrigger_order_buy_price'] = $is_box_trade_buy['price'];
    //         $bid_hour_arr_volume[$start_date_1]                    = $candel_stick_single_arr['bid_volume'];
    //         $ask_hour_arr_volume[$start_date_1]                    = $candel_stick_single_arr['ask_volume'];
    //         $total_hour_volume_arr[$start_date_1]                  = $candel_stick_single_arr['total_volume'];
    //         $down_status                                           = $this->mod_candlereport->calculate_pressure_up_and_down($start_date_1, $end_date_1, $candel_stick_single_arr['coin'], $pressure_type = 'down');
    //         $up_status                                             = $this->mod_candlereport->calculate_pressure_up_and_down($start_date_1, $end_date_1, $candel_stick_single_arr['coin'], $pressure_type = 'up');
    //         $avg_score                                             = $this->mod_candlereport->calculate_average_score($candel_stick_single_arr['coin'], $start_date_1, $end_date_1);
    //         $candel_stick_single_arr['avg_score']                  = $avg_score;
    //         $candel_stick_single_arr['down_status']                = $down_status;
    //         $candel_stick_single_arr['up_status']                  = $up_status;
    //         $open_time_zone_time                                   = $this->mod_candlereport->convert_time_zone($openTime_current_time_zone);
    //         $candel_stick_single_arr['open_time_zone_time']        = $open_time_zone_time;
    //         $candel_stick_single_arr['ask_volume']                 = $ask_hour_arr_volume[$candel_stick_single_arr['openTime_human_readible']];
    //         $candel_stick_single_arr['bid_volume']                 = $bid_hour_arr_volume[$candel_stick_single_arr['openTime_human_readible']];
    //         $candel_stick_single_arr['total_volume']               = $total_hour_volume_arr[$candel_stick_single_arr['openTime_human_readible']];
    //         $candel_stick_single_arr['max_volume']                 = $max_volume_hourly;
    //         $candel_stick_single_arr['max_volume_bvs']             = $max_volume_bvs;
    //         $candel_stick_single_arr['time_index']                 = $candel_stick_single_arr['openTime_human_readible'];
    //         echo "<pre>";
    //         print_r($candel_stick_single_arr);
    //         exit;
    //         array_push($candel_stick_arr_new, $candel_stick_single_arr);
    //     } // %%%%%%%%%%% -- End of candel_stick_arr -- %%%%%%%%%%
    //     $this->stencil->paint('admin/candle_report/candle_report', $data);
    // } //End index
    // public function autoload_candle_stick_report_data_ajax()
    // {
    //     $this->mod_login->verify_is_admin_login();
    //     $global_symbol    = $this->session->userdata('global_symbol');
    //     $admin_id         = $this->session->userdata('admin_id');
    //     $global_mode      = $this->session->userdata('global_mode');
    //     $periods          = '1h';
    //     $from_date_object = '';
    //     $to_date_object   = '';
    //     $previous_date    = '';
    //     $is_sma_checked   = '';
    //     $sma_offset       = '';
    //     if ($this->input->post('is_sma')) {
    //         $is_sma_checked = $this->input->post('is_sma');
    //         $sma_offset     = $this->input->post('sma_offset');
    //     }
    //     $previous_date     = ($this->input->post('previous_date')) ? $this->input->post('previous_date') : '';
    //     $forward_date      = ($this->input->post('forward_date')) ? $this->input->post('forward_date') : '';
    //     $candel_stick_arr_ = $this->mod_candlereport->get_candelstick_data_from_database($global_symbol, $periods, $from_date_object, $to_date_object, $previous_date, $forward_date);
    //     $candel_stick_arr  = $candel_stick_arr_['candle_arr'];
    //     $max_volume_hourly = $candel_stick_arr_['max_volume'];
    //     $max_volume_bvs    = $candel_stick_arr_['max_volume_bvs'];
    //     if (count($candel_stick_arr) > 0) {
    //         $start_date_for_time_zone      = $candel_stick_arr[0]['openTime'];
    //         $end_date_for_time_zone        = $candel_stick_arr[count($candel_stick_arr) - 1]['openTime'];
    //         $start_date_for_time_zone_time = $candel_stick_arr[0]['timestampDate'];
    //         $end_date_for_time_zone_time   = $candel_stick_arr[count($candel_stick_arr) - 1]['timestampDate'];
    //     }
    //     //Call function to get task Manager setting
    //     $order_data                       = $this->mod_candlereport->get_order_array($global_symbol, $admin_id, $global_mode, $start_date_for_time_zone_time, $end_date_for_time_zone_time);
    //     //Call function to get task Manager setting
    //     $task_manager_setting_arr         = $this->mod_candlereport->get_task_manager_setting($global_symbol);
    //     $data['task_manager_setting_arr'] = $task_manager_setting_arr;
    //     $coin_unit_val                    = $this->mod_candlereport->get_coin_unit_value($global_symbol);
    //     //$candel_stick_arr = $this->binance_api->get_candelstick($global_symbol,$periods);
    //     $draw_target_zone_arr             = $this->mod_candlereport->get_chart_target_zones($global_symbol);
    //     $draw_target_zone_arr_full        = array();
    //     /***Check if target zone Exist***/
    //     if (count($draw_target_zone_arr) > 0) {
    //         foreach ($draw_target_zone_arr as $target_zone_value) {
    //             $start_date_second                     = $start_date_for_time_zone / 1000;
    //             $end_date_second                       = $end_date_for_time_zone / 1000;
    //             $unit_value                            = $coin_unit_val;
    //             $start_date                            = date("Y-m-d H:00:00", $start_date_second);
    //             $end_date                              = date("Y-m-d H:59:59", $end_date_second);
    //             $get_market_history_for_candel         = $this->mod_candlereport->get_candle_price_volume_detail($global_symbol, $start_date, $end_date, $unit_value);
    //             $target_zone_value['draw_target_zone'] = $get_market_history_for_candel;
    //             array_push($draw_target_zone_arr_full, $target_zone_value);
    //         }
    //     }
    //     /** End of for each **/
    //     $from_date_for_candel        = $candel_stick_arr[0]['openTime'];
    //     $end_date_for_candel         = $candel_stick_arr[count($candel_stick_arr) - 1]['openTime'];
    //     $from_date_for_candel_second = $from_date_for_candel / 1000;
    //     $end_date_for_candel_second  = $end_date_for_candel / 1000;
    //     $from_date_for_candel        = date("Y-m-d H:00:00", $from_date_for_candel_second);
    //     $end_date_for_candel         = date("Y-m-d H:59:59", $end_date_for_candel_second);
    //     $all_candle_volume_detail    = $this->mod_candlereport->get_candle_price_volume_detail($global_symbol, $from_date_for_candel, $end_date_for_candel, $unit_value = 0);
    //     //$all_Hour_candle_volume_detail = $this->mod_candel->get_hour_volume_array_detail($global_symbol,$from_date_for_candel,$end_date_for_candel);
    //     $candel_stick_arr_new        = array();
    //     $bid_hour_arr_volume         = array();
    //     $ask_hour_arr_volume         = array();
    //     $total_hour_volume_arr       = array();
    //     foreach ($candel_stick_arr as $candel_stick_single_arr) {
    //         $openTime_current_time_zone           = $candel_stick_single_arr['openTime'];
    //         $start_date_1                         = date("Y-m-d H:00:00", $openTime_current_time_zone / 1000);
    //         $end_date_1                           = date("Y-m-d H:59:59", $openTime_current_time_zone / 1000);
    //         $bid_hour_arr_volume[$start_date_1]   = $candel_stick_single_arr['bid_volume'];
    //         $ask_hour_arr_volume[$start_date_1]   = $candel_stick_single_arr['ask_volume'];
    //         $total_hour_volume_arr[$start_date_1] = $candel_stick_single_arr['total_volume'];
    //         $down_status                          = $this->mod_candlereport->calculate_pressure_up_and_down($start_date_1, $end_date_1, $candel_stick_single_arr['coin'], $pressure_type = 'down');
    //         $up_status                            = $this->mod_candlereport->calculate_pressure_up_and_down($start_date_1, $end_date_1, $candel_stick_single_arr['coin'], $pressure_type = 'up');
    //         if ($is_sma_checked == 'yes') {
    //             $status_arrr = $this->mod_candlereport->sma_of_pressure($start_date_1, $end_date_1, $candel_stick_single_arr['coin'], $sma_offset);
    //             $up_status   = $status_arrr['up_sma'];
    //             $down_status = $status_arrr['down_sma'];
    //         }
    //         $calculate_up_down_wall                         = $this->mod_candlereport->calculate_up_down_wall($candel_stick_single_arr['coin'], $start_date_1);
    //         $ask_diff                                       = $calculate_up_down_wall['ask_diff'];
    //         $bid_diff                                       = $calculate_up_down_wall['bid_diff'];
    //         $candel_stick_single_arr['bid_diff']            = $bid_diff;
    //         $candel_stick_single_arr['ask_diff']            = $ask_diff;
    //         $candel_stick_single_arr['down_status']         = $down_status;
    //         $candel_stick_single_arr['up_status']           = $up_status;
    //         $open_time_zone_time                            = $this->mod_candlereport->convert_time_zone($openTime_current_time_zone);
    //         $candel_stick_single_arr['open_time_zone_time'] = $open_time_zone_time;
    //         $candel_stick_single_arr['ask_volume']          = $ask_hour_arr_volume[$candel_stick_single_arr['openTime_human_readible']];
    //         $candel_stick_single_arr['bid_volume']          = $bid_hour_arr_volume[$candel_stick_single_arr['openTime_human_readible']];
    //         $candel_stick_single_arr['total_volume']        = $total_hour_volume_arr[$candel_stick_single_arr['openTime_human_readible']];
    //         $candel_stick_single_arr['max_volume']          = $max_volume_hourly;
    //         $candel_stick_single_arr['max_volume_bvs']      = $max_volume_bvs;
    //         $candel_stick_single_arr['time_index']          = $candel_stick_single_arr['openTime_human_readible'];
    //         array_push($candel_stick_arr_new, $candel_stick_single_arr);
    //     }
    //     $all_Hour_candle_volume_detail['total_hour_volume_arr'] = $total_hour_volume_arr;
    //     $all_Hour_candle_volume_detail['bid_hour_arr_volume']   = $bid_hour_arr_volume;
    //     $all_Hour_candle_volume_detail['ask_hour_arr_volume']   = $ask_hour_arr_volume;
    //     $all_Hour_candle_volume_detail['max_volume_hourly']     = $max_volume_hourly;
    //     $data['all_candle_volume_detail']                       = $all_candle_volume_detail;
    //     $data['all_Hour_candle_volume_detail']                  = $all_Hour_candle_volume_detail;
    //     $data["compare_val"]                                    = $resp;
    //     $data["candlesdtickArr"]                                = $candel_stick_arr_new;
    //     $data["candle_period"]                                  = $periods;
    //     $data["get_market_history_for_candel"]                  = $get_market_history_for_candel;
    //     $data["draw_target_zone_arr"]                           = $draw_target_zone_arr_full;
    //     $ask_volume_arr                                         = $get_market_history_for_candel['ask_arr_volume'];
    //     $bid_volume_arr                                         = $get_market_history_for_candel['bid_arr_volume'];
    //     $total_volume_arr                                       = $get_market_history_for_candel['total_volume_arr'];
    //     $max_volume                                             = $get_market_history_for_candel['max_volume'];
    //     $unit_value                                             = $get_market_history_for_candel['unit_value'];
    //     $max_volumer                                            = $max_volume;
    //     $data["ask_volume_arr"]                                 = $ask_volume_arr;
    //     $data["bid_volume_arr"]                                 = $bid_volume_arr;
    //     $data["total_volume_arr"]                               = $total_volume_arr;
    //     $data["max_volumer"]                                    = $max_volumer;
    //     $data["unit_value"]                                     = $unit_value;
    //     $data['order_data']                                     = $order_data;
    //     echo json_encode($data);
    // }
    /** End of autoload_candle_stick_report_data_ajax**/
}