<?php
  /**
   *
   */
  class mod_cronjob_listing extends CI_Model
  {

    function __construct()
    {
      parent::__construct();
    }

    public function get_cron_listing(){
        $data = $this->mongo_db->get('cronjob_listing_update');
        return iterator_to_array($data);
    }

    public function add_cronjob($data){
      extract($data);
      $ins_data = array(
          'cron_name' => $cron_name,
          'cron_duration' => $cron_duration,
      );

      $cron_id = $this->mongo_db->insert('cronbjob_listing',$ins_data);

      return $cron_id;
    }

    public function check_when_last_cron_ran($url){
      $this->mongo_db->where(array('cron_url' => $url));
      $this->mongo_db->limit(1);
      $this->mongo_db->order_by(array('_id' => -1));
      $res = $this->mongo_db->get('cronjob_listing_update');
      $res_arr = iterator_to_array($res);

      $cron_duration = $res_arr[0]['cron_duration'];

      $cron_duration_arr = explode(' ',$cron_duration);

      $duration = $cron_duration_arr[0];
      $time = $cron_duration_arr[1];

      $param = 5;
      switch($time){
        case 'second':
          $param = 1+120;
          break;
        case 'minute':
          $param = 60+120;
          break;
        case 'minutes':
          $param = 60+120;
          break;
        case 'hour':
          $param = (60 * 60) + 3600;
          break;
        case 'day':
          $param = (60 * 60 * 24) + 3600;
          break;
        case 'week':
          $param = (60 * 60 * 24 * 7)+3600;
          break;
        default:
          $param = 1;
          break;
      }




      $last_run_time =  strtotime($res_arr[0]['last_updated_time_human_readible']);
      $now_time = strtotime(date("Y-m-d H:i:s"));

      $difference_time = $now_time - $last_run_time;

      if($difference_time <= (($duration*$param)+5)){
          return true;
      }else{
          return false;
      }


    }
  }

?>
