<?php
/**
 *
 */
class Tester_cron extends CI_Controller {

    function __construct() {
        parent::__construct();

        ini_set("display_error", E_ALL);
        error_reporting(E_ALL);
    }

    // public function index() {
    //     $this->mongo_db->where(array("status" => 1));
    //     $get = $this->mongo_db->get("report_setting_collection");

    //     $result_arr = iterator_to_array($get);

    //     foreach ($result_arr as $key => $value) {
    //         $start_date = $value['filter_by_start_date'];
    //         $end_date = $value['filter_by_end_date'];
    //         $parent_id = $value['_id'];
    //         $interval_arr = $this->splitTimeIntoIntervals($start_date, $end_date);
    //         $this->make_child_settings($interval_arr, $value, $parent_id);
    //         $this->mongo_db->where(array("_id" => $parent_id));
    //         $this->mongo_db->set(array("status" => 2));
    //         $this->mongo_db->update("report_setting_collection");
    //     }

    // }

    // public function splitTimeIntoIntervals($work_starts = "2019-01-01 00:00:00", $work_ends = "2019-02-01 00:00:00", $break_starts = null, $break_ends = null, $minutes_per_interval = 7200) {
    //     $intervals = array();
    //     $time = date("Y-m-d H:i", strtotime($work_starts));
    //     $first_after_break = false;
    //     while (strtotime($time) < strtotime($work_ends)) {
    //         // if at least one of the arguments associated with breaks is mising - act like there is no break
    //         if ($break_starts == null || $break_ends == null) {
    //             $time_starts = date("Y-m-d H:i", strtotime($time));
    //             $time_ends = date("Y-m-d H:i", strtotime($time_starts . "+$minutes_per_interval minutes"));
    //         }
    //         // if the break start/end time is specified
    //         else {
    //             if ($first_after_break == true) {
    //                 //first start time after break
    //                 $time = (date("Y-m-d H:i", strtotime($break_ends)));
    //                 $first_after_break = false;
    //             }
    //             $time_starts = (date("Y-m-d H:i", strtotime($time)));
    //             $time_ends = date("Y-m-d H:i", strtotime($time_starts . "+$minutes_per_interval minutes"));
    //             //if end_time intersects break_start and break_end times
    //             if ($this->timesIntersects($time_starts, $time_ends, $break_starts, $break_ends)) {
    //                 $time_ends = date("Y-m-d H:i", strtotime($break_starts));
    //                 $first_after_break = true;
    //             }
    //         }
    //         //if end_time is after work_ends
    //         if (date("Y-m-d H:i", strtotime($time_ends)) > date("Y-m-d H:i", strtotime($work_ends))) {
    //             $time_ends = date("Y-m-d H:i", strtotime($work_ends));
    //         }
    //         $intervals[] = array('starts' => $time_starts, 'ends' => $time_ends);
    //         $time = $time_ends;
    //     }

    //     return $intervals;
    // }
    //time intersects if order of parametrs is one of the following 1342 or 1324

    // function timesIntersects($time1_from, $time1_till, $time2_from, $time2_till) {
    //     $out;
    //     $time1_st = strtotime($time1_from);
    //     $time1_end = strtotime($time1_till);
    //     $time2_st = strtotime($time2_from);
    //     $time2_end = strtotime($time2_till);
    //     $duration1 = $time1_end - $time1_st;
    //     $duration2 = $time2_end - $time2_st;
    //     $time1_length = date("i", strtotime($time1_till . "-$time1_from"));
    //     if (
    //         (($time1_st <= $time2_st && $time2_st <= $time1_end && $time1_end <= $time2_end)
    //             ||
    //             ($time1_st <= $time2_st && $time2_st <= $time2_end && $time2_end <= $time1_end)
    //             &&
    //             ($duration1 >= $duration2)
    //         )
    //         ||
    //         ($time1_st <= $time2_st && $time2_st <= $time1_end && $time1_end <= $time2_end)
    //         &&
    //         ($duration1 < $duration2)
    //     ) {
    //         return true;
    //     }

    //     return false;
    // }

    // public function make_child_settings($interval_arr, $data_arr, $parent_id) {
    //     foreach ($interval_arr as $key => $value) {
    //         $data_arr2 = array();
    //         $data_arr2 = $data_arr;
    //         unset($data_arr2['_id']);
    //         $data_arr2['filter_by_start_date'] = $value['starts'] . ":00";
    //         $data_arr2['filter_by_end_date'] = $value['ends'] . ":00";
    //         $data_arr2['parent_id'] = $parent_id;
    //         $data_arr2 = (array) $data_arr2;
    //         $this->mongo_db->insert("child_report_settings", $data_arr2);
    //     }
    // }

}