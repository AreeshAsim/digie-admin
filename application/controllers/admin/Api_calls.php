<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH .'libraries/REST_Controller.php';
/**
* This is an example of a few basic user interaction methods you could use
* all done with a hardcoded array
*
* @package         CodeIgniter
* @subpackage      Rest Server
* @category        Controller
* @author          Phil Sturgeon, Chris Kacerguis
* @license         MIT
* @link            https://github.com/chriskacerguis/codeigniter-restserver
*/

Class Api_calls extends REST_Controller {
   
    function __construct()
    {
        parent::__construct();

        $this->load->model('admin/mod_login');

    }    
     public function save_histroy_and_return_test_post(){
        //     $db = $this->mongo_db->customQuery();
        //     $username = md5($this->input->server('PHP_AUTH_USER'));
        //     $password = md5($this->input->server('PHP_AUTH_PW'));
        //     if( $username == '1755e99ca881fc22958890d7a41b026b' &&  $password == 'fa6b9d534c05016dc660f93daefbf3d0'){
        //         $user_id_input = (string)trim($this->post('admin_id')); 
        //         $name = (string)trim($this->post('name'));  
        //         $cron_summary = (string)trim($this->post('cron_summary'));  
        //         $cron_id = (string)$this->post('cron_id');
        //         $page_num = (int)$this->post('page_num');
        //         $cron_preority = trim($this->post('priority_setting'));
        //         if(!empty($user_id_input) && !empty($cron_id) && !empty($name) && !empty($cron_summary)){
        //             $page_num =1;
        //             $payload = [
        //                 'priority_setting' => (string)$cron_preority,
        //                 'admin_id'         => $user_id_input,
        //                 'name'             => $name,
        //                 'cron_summary'     => $cron_summary,
        //                 'sub_cron_id'      => (string)$cron_id,
        //                 'last_updated_time' => $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s')),
        //             ];
        //             $upsert['upsert'] = true;
        //             $where_cron['admin_id'] = $user_id_input;
        //             $where_cron['name'] = $name;
        //             $query = $db->cronjobs_app_setting->updateOne($where_cron, ['$set'=> $payload], $upsert);
        //             //return saved data
                
        //             $search['admin_id'] = $user_id_input;
        //             $this->mongo_db->where($search);
        //             $count = $this->mongo_db->get('cronjobs_app_setting');
        //             $responce = iterator_to_array($count);

        //             $search1['admin_id'] = ['$ne'=>$user_id_input];
        //             $this->mongo_db->where($search1);
        //             $count1 = $this->mongo_db->get('cronjobs_app_setting');
        //             $responce1 = iterator_to_array($count1);
        //             $config['base_url'] = base_url() .'admin/Api_calls/save_histroy_and_return';
        //             $config['total_rows'] = count($responce) + count($responce1);
    
        //             $config['per_page'] = 8;
        //             $config['use_page_numbers'] = TRUE;
                
        //             if($page_num !=0) 
        //             {
        //                 $page = ($page_num-1) * $config['per_page'];
        //             }
        //             $lookup = [
        //                 [
        //                     '$match' => [
        //                        'admin_id' => $user_id_input,
        //                     ]
        //                 ],
        //                 [
        //                     '$project' => [
        //                         '_id' =>  '$sub_cron_id',
        //                         $user_id_input => 1,
        //                         "name" =>'$name',
        //                         'cron_summary' => '$cron_summary',
        //                         'priority_setting' => '$priority_setting'    
        //                     ]
        //                 ],
        //                 ['$skip'  => $page],
        //                 ['$limit' => $config['per_page']],
        //             ]; 
        //             $res = $db->cronjobs_app_setting->aggregate($lookup);
        //             $data = iterator_to_array($res);
        //             $lookup_get_ids = [
        //                 [
        //                     '$match' => [
        //                        'admin_id' => $user_id_input,
        //                     ]
        //                 ],
        //                 [
        //                     '$project' => [
        //                         '_id' => ['$toObjectId' => '$sub_cron_id']
        //                     ]
        //                 ],
        //             ]; 
        //             $cron_ids = $db->cronjobs_app_setting->aggregate($lookup_get_ids);
        //             $cron_ids_return = iterator_to_array($cron_ids);
        //             $idss = array_column($cron_ids_return ,'_id'); 
        //             $lookup1 = [
        //                 [
        //                     '$match' => [
        //                         '_id' => ['$nin'=> $idss],
        //                     ]
        //                 ],
        //                 [
        //                     '$project' => [
        //                         '_id' => ['$toString' => '$_id'],
        //                         "name" =>'$name',
        //                         'cron_summary' => '$cron_summary',
        //                         'priority_setting' => '$priority_setting'    
        //                     ]
        //                 ],
        //                 ['$skip'  => $page],
        //                 ['$limit' => $config['per_page']],
        //             ]; 
        //             $res1 = $db->cronjobs_app_setting->aggregate($lookup1);
        //             $data1 = iterator_to_array($res1);

        //             $return['data'] = array_merge($data ,$data1);
        //             $this->set_response($return, REST_Controller::HTTP_CREATED);

        //         }elseif(!empty($user_id_input) && !empty($page_num)){
        //             $search['admin_id'] = $user_id_input;
        //             $this->mongo_db->where($search);
        //             $count = $this->mongo_db->get('cronjobs_app_setting');
        //             $responce = iterator_to_array($count);

        //             $search1['admin_id'] = ['$ne'=>$user_id_input];
        //             $this->mongo_db->where($search1);
        //             $count1 = $this->mongo_db->get('cronjobs_app_setting');
        //             $responce1 = iterator_to_array($count1);
        //             $config['base_url'] = base_url() .'admin/Api_calls/save_histroy_and_return';
        //             $config['total_rows'] = count($responce) + count($responce1);
    
        //             $config['per_page'] = 8;
        //             $config['use_page_numbers'] = TRUE;               
        //             if($page_num !=0) 
        //             {
        //                 $page = ($page_num-1) * $config['per_page'];
        //             }
        //             $lookup = [
        //                 [
        //                     '$match' => [
        //                        'admin_id' => $user_id_input,
        //                     ]
        //                 ],
        //                 [
        //                     '$project' => [
        //                         '_id' =>  '$sub_cron_id',
        //                         $user_id_input => 1,
        //                         'name' =>'$name',
        //                         'cron_summary' => '$cron_summary',
        //                         'priority_setting' => '$priority_setting'    
        //                     ]
        //                 ],
        //                 ['$skip'  => $page],
        //                 ['$limit' => $config['per_page']],
        //             ]; 
        //             $res = $db->cronjobs_app_setting->aggregate($lookup);
        //             $data = iterator_to_array($res);
        //             $lookup_get_ids = [
        //                 [
        //                     '$match' => [
        //                        'admin_id' => $user_id_input,
        //                     ]
        //                 ],
        //                 [
        //                     '$project' => [
        //                         '_id' => ['$toObjectId' => '$sub_cron_id']
        //                     ]
        //                 ],
        //             ]; 
        //             $cron_ids = $db->cronjobs_app_setting->aggregate($lookup_get_ids);
        //             $cron_ids_return = iterator_to_array($cron_ids);
        //             $id = array_column($cron_ids_return, '_id');
        //             $lookup = [
        //                 [
        //                     '$match' => [
        //                         '_id' => ['$nin'=> $id]
        //                     ]
        //                 ],
        //                 [
        //                     '$project' => [
        //                         '_id' => ['$toString' => '$_id'],
        //                         'name' => '$name',
        //                         'cron_summary' => '$cron_summary',
        //                         'priority_setting' => '$priority_setting'    
        //                     ]
        //                 ],
        //                 ['$skip'  => $page],
        //                 ['$limit' => $config['per_page']],
        //             ]; 
        //             $res1 = $db->cronjobs_app_setting->aggregate($lookup);
        //             $data1 = iterator_to_array($res1);
        //             $return['data'] = array_merge($data ,$data1);
        //             $this->set_response($return, REST_Controller::HTTP_CREATED);
        //         }else{
        //             $message = 'Payload Invalid';
        //             $this->set_response($message, REST_Controller::HTTP_NOT_FOUND);
        //         }
        //     }
     }//end cron
    ////////////////////////////////////////////////////////////////////////
    ///  Login Validation For App and hassan opportunity locked         ///
    ///////////////////////////////////////////////////////////////////////
    public function login_validation_post(){
        header('Content-Type: application/json');
        $username = md5($this->input->server('PHP_AUTH_USER'));
        $password = md5($this->input->server('PHP_AUTH_PW'));
        if( $username == '1755e99ca881fc22958890d7a41b026b' &&  $password == 'fa6b9d534c05016dc660f93daefbf3d0'){
            $username_input = trim($this->post('username'));  
            $password_input = trim($this->post('password'));
            $chk_isvalid_user = $this->mod_login->validate_credentials_digie($username_input, $password_input);
            if($chk_isvalid_user){
                if($chk_isvalid_user['password'] == md5($password_input)){
                    $response_array = array(
                        'user_id'  => (string)$chk_isvalid_user['_id'],
                        'username' => $chk_isvalid_user['username'],
                        'email'    => $chk_isvalid_user['email_address'],
                        'profile_image' => 'https://app.digiebot.com/assets/profile_images/'.$chk_isvalid_user['profile_image'],
                        'message'  => 'username and Password corrected',
                    );
                    $this->set_response($response_array, REST_Controller::HTTP_CREATED);
                }else{
                    $response_array =  'Password are incorrect';
                    $this->set_response($response_array, REST_Controller::HTTP_NOT_FOUND);
                }
            }else{//end model response check
                $response_array = 'username and Password are incorrect';
                $this->set_response($response_array, REST_Controller::HTTP_NOT_FOUND);
            } 
        }else{
            $response_array = 'Authorization Wrong';
            $this->set_response($response_array, REST_Controller::HTTP_UNAUTHORIZED);
        }
    }//end function

    public function currentStatusCronJobs_post() {
        $filterData = $this->post("filter");
        if($this->post("filter") == 1 || $this->post("filter") == 2){
            $api_url   = "http://35.171.172.15:3000/api/all_cronjobs";
            $data_json = file_get_contents($api_url);
            $data_arr  = (array)json_decode($data_json);
            $data_arr  = (array)$data_arr['data'];
            $arr       = json_decode(json_encode($data_arr) , true);
    
            $inactive  = false;
            foreach ($arr as $row) {
                $url = $row['name'];
                $post['name'] = $url;
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_PORT           => "3000",
                    CURLOPT_URL            => "http://35.171.172.15:3000/api/all_cronjobs",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING       => "",
                    CURLOPT_MAXREDIRS      => 10,
                    CURLOPT_TIMEOUT        => 30,
                    CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST  => "POST",
                    CURLOPT_POSTFIELDS     => json_encode($post) ,
                    CURLOPT_HTTPHEADER     => array(
                        "cache-control: no-cache",
                        "content-type: application/json"
                    ) ,
                ));
    
                $response              = curl_exec($curl);
                $err                   = curl_error($curl);
    
                curl_close($curl);
    
                if ($err) {
                    echo "cURL Error #:" . $err;
                }
                else {
                    //echo $response;
                }
                $res_arr          = (array)json_decode($response);
                $res_arr          = $res_arr['data'];
                $res_arr          = json_decode(json_encode($res_arr) , true);
                $cron_duration    = $res_arr['cron_duration'];
                $last_updatedtime = $res_arr['last_updated_time_human_readible'];
                
                // $cron_duration_arr = explode(' ',$cron_duration);
                //Umer Abbas [6-11-19]
                $duration_arr     = str_split($cron_duration, 1);
                $time             = array_pop($duration_arr);
                $add_time         = strtoupper($time);
                $duration         = implode('', $duration_arr);
    
                $dt               = new DateTime($last_updatedtime);
                // echo $dt->format('Y-m-d H:i:s');
                $last_time        = date("Y-m-d H:i:s", strtotime($last_updatedtime));
    
                if ($time == 's') {
                    $padding_duration = 2;
                    $padding_time     = "M";
                    $interval_str     = "PT$padding_duration$padding_time$duration$add_time";
                    $dt->add(new DateInterval($interval_str));
                    $param            = 12;
    
                }
                else if ($time == 'm') {
    
                    $padding_duration = 5;
                    $duration         = $duration + $padding_duration;
                    $interval_str     = "PT$duration$add_time";
                    $dt->add(new DateInterval($interval_str));
                    $param            = 300;
    
                }
                else if ($time == 'h') {
    
                    $padding_duration = 15;
                    $padding_time     = "M";
                    $interval_str     = "PT$duration$add_time$padding_duration$padding_time";
                    $dt->add(new DateInterval($interval_str));
    
                    $param        = 900;
    
                }
                else if ($time == 'd') {
                    $interval_str = "P$duration$add_time";
                    $dt->add(new DateInterval($interval_str));
                    $padding_duration = 1;
                    $padding_time     = "H";
                    $interval_str     = "PT$padding_duration$padding_time";
                    $dt->add(new DateInterval($interval_str));
    
                    $param        = 3600;
    
                }
                else if ($time == 'w') {
                    $interval_str = "P$duration$add_time";
                    $dt->add(new DateInterval($interval_str));
                    $padding_duration = 1;
                    $padding_time     = "H";
                    $interval_str     = "PT$padding_duration$padding_time";
                    $dt->add(new DateInterval($interval_str));
    
                    $param    = 3600;
                }
    
                $dt2 = new DateTime();
                $timezone = date_default_timezone_get();

                if($filterData == 1 && $dt2 <= $dt){
                    $return[]     = array(
                        "title" => $url,
                        "url" => $row['cron_summary'],
                        "last_run" => time_elapsed_string($last_updatedtime, $timezone, $full = true),
                        "priority" => "high",
                        "cron_duration" => $cron_duration, 
                        'status' => 'active'
                    );
                }elseif($filterData == 2 && $dt2 >= $dt){
                     $inactive = true;
                     $timezone = "UTC";
                     $return[]     = array(
                         "title" => $url,
                         "url" => $row['cron_summary'],
                         "last_run" => time_elapsed_string($last_updatedtime, $timezone, $full = true),
                         "priority" => "high",
                         "cron_duration" => $cron_duration,
                         'status' => 'inactive'
                     );
                }   
            }//end loop 
            if(empty($return)){
                $return = [];
            }
            $returnData['data'] = $return;
            $this->set_response($returnData, REST_Controller::HTTP_CREATED);
        }else{
            $api_url   = "http://35.171.172.15:3000/api/all_cronjobs";
            $data_json = file_get_contents($api_url);
            $data_arr  = (array)json_decode($data_json);
            $data_arr  = (array)$data_arr['data'];
            $arr       = json_decode(json_encode($data_arr) , true);

            $inactive  = false;
            foreach ($arr as $row) {
                $url = $row['name'];
                $post['name'] = $url;
                $curl = curl_init();

                //
                curl_setopt_array($curl, array(
                    CURLOPT_PORT           => "3000",
                    CURLOPT_URL            => "http://35.171.172.15:3000/api/all_cronjobs",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING       => "",
                    CURLOPT_MAXREDIRS      => 10,
                    CURLOPT_TIMEOUT        => 30,
                    CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST  => "POST",
                    CURLOPT_POSTFIELDS     => json_encode($post) ,
                    CURLOPT_HTTPHEADER     => array(
                        "cache-control: no-cache",
                        "content-type: application/json"
                    ) ,
                ));

                $response              = curl_exec($curl);
                $err                   = curl_error($curl);

                curl_close($curl);

                if ($err) {
                    echo "cURL Error #:" . $err;
                }
                else {
                    //echo $response;
                }
                $res_arr          = (array)json_decode($response);
                $res_arr          = $res_arr['data'];
                $res_arr          = json_decode(json_encode($res_arr) , true);
                $cron_duration    = $res_arr['cron_duration'];
                $last_updatedtime = $res_arr['last_updated_time_human_readible'];
                
                // $cron_duration_arr = explode(' ',$cron_duration);
                //Umer Abbas [6-11-19]
                $duration_arr     = str_split($cron_duration, 1);
                $time             = array_pop($duration_arr);
                $add_time         = strtoupper($time);
                $duration         = implode('', $duration_arr);

                $dt               = new DateTime($last_updatedtime);
                // echo $dt->format('Y-m-d H:i:s');
                $last_time        = date("Y-m-d H:i:s", strtotime($last_updatedtime));

                if ($time == 's') {
                    $padding_duration = 2;
                    $padding_time     = "M";
                    $interval_str     = "PT$padding_duration$padding_time$duration$add_time";
                    $dt->add(new DateInterval($interval_str));
                    $param            = 12;

                }
                else if ($time == 'm') {

                    $padding_duration = 5;
                    $duration         = $duration + $padding_duration;
                    $interval_str     = "PT$duration$add_time";
                    $dt->add(new DateInterval($interval_str));
                    $param            = 300;
                }
                else if ($time == 'h') {

                    $padding_duration = 15;
                    $padding_time     = "M";
                    $interval_str     = "PT$duration$add_time$padding_duration$padding_time";
                    $dt->add(new DateInterval($interval_str));
                    $param        = 900;
                }
                else if ($time == 'd') {

                    $interval_str = "P$duration$add_time";
                    $dt->add(new DateInterval($interval_str));
                    $padding_duration = 1;
                    $padding_time     = "H";
                    $interval_str     = "PT$padding_duration$padding_time";
                    $dt->add(new DateInterval($interval_str));
                    $param        = 3600;
                }
                else if ($time == 'w') {
                    $interval_str = "P$duration$add_time";
                    $dt->add(new DateInterval($interval_str));
                    $padding_duration = 1;
                    $padding_time     = "H";
                    $interval_str     = "PT$padding_duration$padding_time";
                    $dt->add(new DateInterval($interval_str));

                    $param    = 3600;
                }

                $dt2 = new DateTime();
                $timezone = date_default_timezone_get();

                if ($dt2 <= $dt) {
                    //echo $url . " Is Active <br>";
                    // $inactive = true;
                    $return[]     = array(
                        "title" => $res_arr["name"],
                        "url" => $res_arr["cron_summary"], 
                        "last_run" => time_elapsed_string($last_updatedtime, $timezone, $full = true),
                        "priority" => "high",
                        "cron_duration" => $cron_duration, 
                        'status' => 'active'
                    ); 
                }
                else {
                    //echo $url . " Is Inactive <br>";
                    $inactive = true;
                    $timezone = "UTC";
                    $return[]     = array(
                        "title" => $res_arr["name"],
                        "url" => $res_arr["cron_summary"], 
                        "last_run" => time_elapsed_string($last_updatedtime, $timezone, $full = true),
                        "priority" => "high",
                        "cron_duration" => $cron_duration,
                        'status' => 'inactive'
                    );
                }
            } //end loop
            if(empty($return)){
                $return = [];
            }
            $returnData['data'] = $return;
            $this->set_response($returnData, REST_Controller::HTTP_CREATED);
        }//end else
    } //end controller 

    public function save_histroy_and_return_post(){
        $this->load->library('mongo_db_3');
        $db_3 = $this->mongo_db_3->customQuery();
        $username = md5($this->input->server('PHP_AUTH_USER'));
        $password = md5($this->input->server('PHP_AUTH_PW'));
        if($username == '1755e99ca881fc22958890d7a41b026b' &&  $password == 'fa6b9d534c05016dc660f93daefbf3d0'){
            $user_id_input = (string)trim($this->post('admin_id'));  
            $cron_id = (string)$this->post('cron_id');
            $page_num = (int)$this->post('page_num');
            $cron_preority = trim($this->post('priority_setting'));
            if(!empty($user_id_input) && !empty($cron_id)){
                $page_num =1;
                $payload = [
                    'priority_setting' => (string)$cron_preority,
                    'admin_id'         => $user_id_input,
                ];
                $where_cron['_id'] = $this->mongo_db->mongoId((string)$cron_id);
                $query = $db_3->cronjob_execution_logs->updateOne($where_cron, ['$set'=> $payload]);
                //return saved data
               
                $search['admin_id'] = $user_id_input;
                $this->mongo_db_3->where($search);
                $count = $this->mongo_db_3->get('cronjob_execution_logs');
                $responce = iterator_to_array($count);

                $search1['admin_id'] = ['$ne'=>$user_id_input];
                $this->mongo_db_3->where($search1);
                $count1 = $this->mongo_db_3->get('cronjob_execution_logs');
                $responce1 = iterator_to_array($count1);
                $config['base_url'] = base_url() .'admin/Api_calls/save_histroy_and_return';
                $config['total_rows'] = count($responce) + count($responce1);
   
                $config['per_page'] = 8;
                $config['use_page_numbers'] = TRUE;
               
                if($page_num !=0) 
                {
                    $page = ($page_num-1) * $config['per_page'];
                }
                $lookup = [
                    [
                        '$match' => [
                            '$or'=> [
                                ['admin_id' => $user_id_input],
                                ['admin_id' =>['$ne' => $user_id_input]],
                                ['admin_id' =>['$exists' => false]],
                            ],
                        ],
                    ],
                    [
                        '$project' => [
                            '_id' => ['$toString' => '$_id'],
                            "name" =>'$name',
                            'cron_summary' => '$cron_summary',
                            'priority_setting' =>   '$priority_setting',
                            'cron_duration'    =>   '$cron_duration',
                            'last_run'         =>   '$cron_duration'
                        ]
                    ],
                    // ['$skip'  => $page],
                    // ['$limit' => $config['per_page']],
                ]; 

                $res = $db_3->cronjob_execution_logs->aggregate($lookup);
                $data = iterator_to_array($res);

                $return['data'] = $data;//array_merge($data ,$data1);
                $this->set_response($return, REST_Controller::HTTP_CREATED);

            }elseif(!empty($user_id_input) && !empty($page_num)){
                $search['admin_id'] = $user_id_input;
                $this->mongo_db_3->where($search);
                $count = $this->mongo_db_3->get('cronjob_execution_logs');
                $responce = iterator_to_array($count);

                $search1['admin_id'] = ['$ne'=>$user_id_input];
                $this->mongo_db_3->where($search1);
                $count1 = $this->mongo_db_3->get('cronjob_execution_logs');
                $responce1 = iterator_to_array($count1);
                $config['base_url'] = base_url() .'admin/Api_calls/save_histroy_and_return';
                $config['total_rows'] = count($responce) + count($responce1);
   
                $config['per_page'] = 8;
                $config['use_page_numbers'] = TRUE;               
                if($page_num !=0) 
                {
                    $page = ($page_num-1) * $config['per_page'];
                }
                $lookup = [
                    [
                        '$match' => [
                            '$or'=> [
                                ['admin_id' => $user_id_input],
                                ['admin_id' =>['$ne' => $user_id_input]],
                                ['admin_id' =>['$exists' => false]],
                            ],
                        ]
                    ],
                    [
                        '$project' => [
                            '_id' => ['$toString' => '$_id'],
                            'name' =>'$name',
                            'cron_summary' => '$cron_summary',
                            'priority_setting' => '$priority_setting',
                            'cron_duration'    =>   '$cron_duration',
                            'last_run'         =>   '$cron_duration'   
                        ]
                    ],
                    // ['$skip'  => $page],
                    // ['$limit' => $config['per_page']],
                ]; 
                $res = $db_3->cronjob_execution_logs->aggregate($lookup);
                $data = iterator_to_array($res);
              
                $return['data'] = $data;//array_merge($data ,$data1);
                $this->set_response($return, REST_Controller::HTTP_CREATED);
            }else{
                $message = 'Payload Invalid';
                $this->set_response($message, REST_Controller::HTTP_NOT_FOUND);
            }
        }
    }//end cronz

    public function opportunityLogKraken_post(){
        // digiebot.com
        // YaAllah
        $username = md5($this->input->server('PHP_AUTH_USER'));  
        $password = md5($this->input->server('PHP_AUTH_PW'));

        if($username == '1755e99ca881fc22958890d7a41b026b' && $password == 'fa6b9d534c05016dc660f93daefbf3d0'){

            $opportunityId          = $this->post('opportunityId');
            $first_stop_loss_update = $this->post('first_stop_loss_update');
            $traget_profit          = $this->post('traget_profit');
            $trade_limit            = $this->post('trade_limit');
            $coin_symbol            = $this->post('symbol');
            $level                  = $this->post('level');
            $mode                   = $this->post('mode');
            $exchanges              = $this->post('exchange');
            $current_price          = $this->post('current_price');
            $upsert['upsert'] = true;
            $custom = $this->mongo_db->customQuery();
            
            $search_parent['parent_status']     = 'parent';
            $search_parent['status']            = 'new';
            $search_parent['pause_status']      = 'play'; 
            $search_parent['trigger_type']      =  'barrier_percentile_trigger'; 
            $search_parent['symbol']            =  $coin_symbol;
            $search_parent['order_level']       =  $level; 

            $pickParentYes['parent_status']     = 'parent';
            $pickParentYes['status']            = 'new';
            $pickParentYes['pause_status']      = 'play'; 
            $pickParentYes['trigger_type']      =  'barrier_percentile_trigger'; 
            $pickParentYes['symbol']            =  $coin_symbol;
            $pickParentYes['order_level']       =  $level; 
            $pickParentYes['pick_parent']       =  'yes'; 

            $insert_array = array(
                'created_date'           =>  $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s')),
                'sendHitTime'            =>  $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s')),        
                'modified_date'          =>  $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s')),
                'level'                  =>  $level,
                'opportunity_id'         =>  (string)$opportunityId,
                'coin'                   =>  $coin_symbol,
                'current_price'          =>  $current_price,
                'purchase_price'         =>  $current_price,
                'first_stop_loss_update' =>  $first_stop_loss_update,
                'traget_profit'          =>  $traget_profit,
                'trade_limit'            =>  $trade_limit,
                'month_modified_time'    =>  $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s'))
            );
            if($mode == 'both'){
                $collection_name_live   = 'opportunity_logs_kraken';
                $collection_name_test   = 'opportunity_logs_test_kraken';
                $buy_order_collection   = 'buy_orders_kraken';

                $search['opportunity_id'] = (string)$opportunityId;

                //live opportunity logs inserting 
                $search_parent['exchange']          = 'kraken';
                $search_parent['application_mode']  = 'live';
                $search_parent['order_mode']        = 'live'; 

                $parent = $custom->$buy_order_collection->find($search_parent);
                $insert_array['mode'] = 'live';
                $parent_response = iterator_to_array($parent);
                if(count($parent_response) > 0){
                    $insert_array['parent_active_count'] = count($parent_response);
                }else{
                    $insert_array['parent_active_count'] = 0;
                }

                $pickParentYes['exchange']          = 'kraken';
                $pickParentYes['application_mode']  = 'live';
                $pickParentYes['order_mode']        = 'live'; 
                $pickParentYesReturn = $custom->$buy_order_collection->count($pickParentYes);


                // testing temp query
                $testingResult = $custom->$buy_order_collection->find($pickParentYes);
                $testingResultResponse  = iterator_to_array($testingResult);
                $insertDumyArry = [

                    'oppprtunity_id'  =>   $opportunityId,
                    'parent_detail'   =>   $testingResultResponse,
                    'exchange'        =>   'kraken',
                    'mode'            =>   'live'      
                ];
                $custom->asim_temp->insertOne($insertDumyArry);
                // end code  dummy 


                if($pickParentYesReturn > 0){
                    $insert_array['pickParentYes'] = $pickParentYesReturn;
                }else{
                    $insert_array['pickParentYes'] = 0;
                }

                $query = $custom->$collection_name_live->updateOne($search, ['$set'=> $insert_array], $upsert);
                $message = array(
                    'message'       => 'inserted successfully',
                    'exchnage'      => 'kraken',
                    'level'         => $level,
                    'symbol'        => $coin_symbol,
                    'pickParentYes' => $pickParentYesReturn,
                    'current_price' => $current_price,
                    'opportunityId' => $opportunityId,
                    'parent'        => $insert_array['parent_active_count'],
                    'mode'          => $search_parent['order_mode'],
                    'type'          => '200'
                );
                $response_array[] = $message;

                // start test opportunity log inserting 
                $search_parent['exchange']          = 'kraken';
                $search_parent['application_mode']  = 'test';
                $search_parent['order_mode']        = 'test'; 

                $parent = $custom->$buy_order_collection->find($search_parent);
                $parent_response = iterator_to_array($parent);

                $insert_array['mode'] = 'test';
                if(count($parent_response) > 0){
                    $insert_array['parent_active_count'] = count($parent_response);
                }else{
                    $insert_array['parent_active_count'] = 0;
                }

                $$pickParentYes['exchange']          = 'kraken';
                $$pickParentYes['application_mode']  = 'test';
                $$pickParentYes['order_mode']        = 'test'; 

                $pickParentYesReturn = $custom->$buy_order_collection->count($pickParentYes);
                if($pickParentYesReturn > 0){
                    $insert_array['pickParentYes'] = $pickParentYesReturn;
                }else{
                    $insert_array['pickParentYes'] = 0;
                }

                $query = $custom->$collection_name_test->updateOne($search, ['$set'=> $insert_array], $upsert);
                $message = array(
                    'message'       => 'inserted successfully',
                    'exchnage'      => 'kraken',
                    'level'         => $level,
                    'symbol'        => $coin_symbol,
                    'parent'        => $insert_array['parent_active_count'],
                    'pickParentYes' => $pickParentYesReturn,
                    'mode'          => $search_parent['order_mode'],
                    'opportunityId' => $opportunityId,
                    'current_price' => $current_price,
                    'type'          => '200'
                );
                $response_array[] = $message;

                $this->set_response($response_array, REST_Controller::HTTP_CREATED);
            }elseif($mode == 'test'){
                $buy_order_collection = 'buy_orders_kraken';
                $collection_name_test = 'opportunity_logs_test_kraken';

                $search['opportunity_id']  = (string)$opportunityId; 

                $search_parent['exchange']          = 'kraken';
                $search_parent['application_mode']  = 'test';
                $search_parent['order_mode']        = 'test'; 

                $parent_test = $custom->$buy_order_collection->find($search_parent);
                $response_parent = iterator_to_array($parent_test);
                $insert_array['mode'] = 'test';
                if(count($response_parent) > 0){
                    $insert_array['parent_active_count'] = count($response_parent);
                }else{
                    $insert_array['parent_active_count'] = 0;
                }
                $pickParentYes['exchange']          = 'kraken';
                $pickParentYes['application_mode']  = 'test';
                $pickParentYes['order_mode']        = 'test'; 

                $pickParentYesReturn = $custom->$buy_order_collection->count($pickParentYes);
                if($pickParentYesReturn > 0){
                    $insert_array['pickParentYes'] = $pickParentYesReturn;
                }else{
                    $insert_array['pickParentYes'] = 0;
                }

                $query = $custom->$collection_name_test->updateOne($search, ['$set'=> $insert_array], $upsert);
                $message = array(
                    'message'       => 'inserted successfully',
                    'exchnage'      => 'kraken',
                    'level'         => $level,
                    'pickParentYes' => $pickParentYesReturn,
                    'current_price' => $current_price,
                    'symbol'        => $coin_symbol,
                    'opportunityId' => $opportunityId,
                    'parent'        => $insert_array['parent_active_count'],
                    'mode'          => $search_parent['order_mode'],
                    'type'          => '200',
                );
                $this->set_response($message, REST_Controller::HTTP_CREATED);
            }elseif($mode == 'live'){
                $buy_order_collection = 'buy_orders_kraken';

                $collection_name_live      = 'opportunity_logs_kraken';
                $search['opportunity_id']  = (string)$opportunityId; 
            
                $search_parent['exchange']          = 'kraken';
                $search_parent['application_mode']  = 'live';
                $search_parent['order_mode']        = 'live';

                $parent = $custom->$buy_order_collection->find($search_parent);
                $insert_array['mode'] = 'live';
                $parent_response = iterator_to_array($parent);

                if(count($parent_response) > 0){
                    $insert_array['parent_active_count'] = count($parent_response);
                }else{
                    $insert_array['parent_active_count'] = 0;
                }

                $pickParentYes['exchange']          = 'kraken';
                $pickParentYes['application_mode']  = 'live';
                $pickParentYes['order_mode']        = 'live'; 
                $pickParentYesReturn = $custom->$buy_order_collection->count($pickParentYes);

                //testing temp query
                $testingResult = $custom->$buy_order_collection->find($pickParentYes);
                $testingResultResponse  = iterator_to_array($testingResult);
                $insertDumyArry = [

                    'oppprtunity_id'  =>   $opportunityId,
                    'parent_detail'   =>   $testingResultResponse,
                    'exchange'        =>   'kraken',
                    'mode'            =>   'live'      
                ];
                $custom->asim_temp->insertOne($insertDumyArry);
                //end code  dummy 


                if($pickParentYesReturn > 0){
                    $insert_array['pickParentYes'] = $pickParentYesReturn;
                }else{
                    $insert_array['pickParentYes'] = 0;
                }

                $query = $custom->$collection_name_live->updateOne($search, ['$set'=> $insert_array], $upsert);
                $message = array(
                    'message'       =>  'inserted successfully',
                    'exchnage'      =>  'kraken',
                    'level'         =>  $level,
                    'current_price' =>  $current_price,
                    'opportunityId' =>  $opportunityId,
                    'symbol'        =>  $coin_symbol,
                    'pickParentYes' =>  $pickParentYesReturn,
                    'parent'        =>  $insert_array['parent_active_count'],
                    'mode'          =>  $search_parent['order_mode'],
                    'type'          =>  '200'
                );
                $this->set_response($message, REST_Controller::HTTP_CREATED);
            }else{
                $message = array(
                'message' => 'payload have some Issue',
                'type'    => '404'
            );
            echo json_encode($message);
            }
        }else{
            $message = array(
                'message' => 'Authentication field',
                'type'    => '404'
            );
            echo json_encode($message);
        }
    }// end insert kraken opportunity logs 


    public function opportunityLogBinance_post(){
        $username = md5($this->input->server('PHP_AUTH_USER'));  
        $password = md5($this->input->server('PHP_AUTH_PW'));

        if($username == '1755e99ca881fc22958890d7a41b026b' && $password == 'fa6b9d534c05016dc660f93daefbf3d0'){

            $opportunityId          = $this->post('opportunityId');
            $first_stop_loss_update = $this->post('first_stop_loss_update');
            $traget_profit          = $this->post('traget_profit');
            $trade_limit            = $this->post('trade_limit');
            $coin_symbol            = $this->post('symbol');
            $level                  = $this->post('level');
            $mode                   = $this->post('mode');
            $exchanges              = $this->post('exchange');
            $current_price          = $this->post('current_price');

            $upsert['upsert'] = true;
            $custom = $this->mongo_db->customQuery();
            
            $search_parent['parent_status']     = 'parent';
            $search_parent['status']            = 'new';
            $search_parent['pause_status']      = 'play'; 
            $search_parent['trigger_type']      =  'barrier_percentile_trigger'; 
            $search_parent['symbol']            =  $coin_symbol;
            $search_parent['order_level']       =  $level; 

            $pickParentYes['parent_status']     = 'parent';
            $pickParentYes['status']            = 'new';
            $pickParentYes['pause_status']      = 'play'; 
            $pickParentYes['trigger_type']      =  'barrier_percentile_trigger'; 
            $pickParentYes['symbol']            =  $coin_symbol;
            $pickParentYes['order_level']       =  $level; 
            $pickParentYes['pick_parent']       =  'yes'; 

            $insert_array = array(
                'created_date'           =>  $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s')),
                'sendHitTime'            =>  $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s')),        
                'modified_date'          =>  $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s')),
                'level'                  =>  $level,
                'opportunity_id'         =>  (string)$opportunityId,
                'coin'                   =>  $coin_symbol,
                'current_price'          =>  $current_price,
                'purchase_price'         =>  $current_price,
                'first_stop_loss_update' =>  $first_stop_loss_update,
                'traget_profit'          =>  $traget_profit,
                'trade_limit'            =>  $trade_limit,
                'month_modified_time'    =>  $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s'))
            );
            
            if($mode == 'both'){
                $collection_name_live   = 'opportunity_logs_binance';
                $collection_name_test   = 'opportunity_logs_test_binance';
                $buy_order_collection   = 'buy_orders';

                $search['opportunity_id'] = (string)$opportunityId;
                // inserting live opportunity logs
                $search_parent['exchange']          = 'binance';
                $search_parent['application_mode']  = 'live';
                $search_parent['order_mode']        = 'live'; 

                $parent = $custom->$buy_order_collection->find($search_parent);
                $insert_array['mode'] = 'live';
                $parent_response = iterator_to_array($parent);
                if(count($parent_response) > 0){
                    $insert_array['parent_active_count'] = count($parent_response);
                }else{
                    $insert_array['parent_active_count'] = 0;
                }

                $pickParentYes['exchange']          = 'binance';
                $pickParentYes['application_mode']  = 'live';
                $pickParentYes['order_mode']        = 'live'; 
                $pickParentYesReturn = $custom->$buy_order_collection->count($pickParentYes);

                // testing temp query
                $testingResult = $custom->$buy_order_collection->find($pickParentYes);
                $testingResultResponse  = iterator_to_array($testingResult);
                $insertDumyArry = [

                    'oppprtunity_id'  =>   $opportunityId,
                    'parent_detail'   =>   $testingResultResponse,
                    'exchange'        =>   'binance',
                    'mode'            =>   'live'      
                ];
                $custom->asim_temp->insertOne($insertDumyArry);
                // end code  dummy 




                if($pickParentYesReturn > 0){
                    $insert_array['pickParentYes'] = $pickParentYesReturn;
                }else{
                    $insert_array['pickParentYes'] = 0;
                }

                $query = $custom->$collection_name_live->updateOne($search, ['$set'=> $insert_array], $upsert);
                $message = array(
                    'message'       => 'inserted successfully',
                    'exchange'      => 'binance',
                    'level'         => $level,
                    'symbol'        => $coin_symbol,
                    'pickParentYes' => $pickParentYesReturn,
                    'current_price' => $current_price,
                    'opportunityId' => $opportunityId,
                    'parent'        => $insert_array['parent_active_count'],
                    'mode'          => $search_parent['order_mode'],
                    'type'          => '200'
                );
                $response_array[] = $message;

                //inserting test opportunity logs 
                 $search_parent['exchange']         = 'binance';
                $search_parent['application_mode']  = 'test';
                $search_parent['order_mode']        = 'test'; 

                $parent = $custom->$buy_order_collection->find($search_parent);
                $parent_response = iterator_to_array($parent);

                $insert_array['mode'] = 'test';
                if(count($parent_response) > 0){
                    $insert_array['parent_active_count'] = count($parent_response);
                }else{
                    $insert_array['parent_active_count'] = 0;
                }

                $$pickParentYes['exchange']          = 'binance';
                $$pickParentYes['application_mode']  = 'test';
                $$pickParentYes['order_mode']        = 'test'; 

                $pickParentYesReturn = $custom->$buy_order_collection->count($pickParentYes);
                if($pickParentYesReturn > 0){
                    $insert_array['pickParentYes'] = $pickParentYesReturn;
                }else{
                    $insert_array['pickParentYes'] = 0;
                }

                $query = $custom->$collection_name_test->updateOne($search, ['$set'=> $insert_array], $upsert);
                $message = array(
                    'message'       => 'inserted successfully',
                    'exchnage'      => 'binance',
                    'level'         => $level,
                    'symbol'        => $coin_symbol,
                    'parent'        => $insert_array['parent_active_count'],
                    'pickParentYes' => $pickParentYesReturn,
                    'mode'          => $search_parent['order_mode'],
                    'opportunityId' => $opportunityId,
                    'current_price' => $current_price,
                    'type'          => '200'
                );
                $response_array[] = $message;
                $this->set_response($response_array, REST_Controller::HTTP_CREATED);
            }elseif($mode == 'test'){
                $buy_order_collection = 'buy_orders';
                $collection_name_test = 'opportunity_logs_test_binance';

                $search['opportunity_id']  = (string)$opportunityId; 

                $search_parent['exchange']          = 'binance';
                $search_parent['application_mode']  = 'test';
                $search_parent['order_mode']        = 'test'; 

                $parent_test = $custom->$buy_order_collection->find($search_parent);
                $response_parent = iterator_to_array($parent_test);
                $insert_array['mode'] = 'test';
                if(count($response_parent) > 0){
                    $insert_array['parent_active_count'] = count($response_parent);
                }else{
                    $insert_array['parent_active_count'] = 0;
                }
                $pickParentYes['exchange']          = 'binance';
                $pickParentYes['application_mode']  = 'test';
                $pickParentYes['order_mode']        = 'test'; 

                $pickParentYesReturn = $custom->$buy_order_collection->count($pickParentYes);
                if($pickParentYesReturn > 0){
                    $insert_array['pickParentYes'] = $pickParentYesReturn;
                }else{
                    $insert_array['pickParentYes'] = 0;
                }

                $query = $custom->$collection_name_test->updateOne($search, ['$set'=> $insert_array], $upsert);
                $message = array(
                    'message'       => 'inserted successfully',
                    'exchnage'      => 'binance',
                    'level'         => $level,
                    'pickParentYes' => $pickParentYesReturn,
                    'current_price' => $current_price,
                    'symbol'        => $coin_symbol,
                    'opportunityId' => $opportunityId,
                    'parent'        => $insert_array['parent_active_count'],
                    'mode'          => $search_parent['order_mode'],
                    'type'          => '200',
                );
                $this->set_response($message, REST_Controller::HTTP_CREATED);
            }elseif($mode == 'live'){
                $buy_order_collection = 'buy_orders';

                $collection_name_live      = 'opportunity_logs_binance';
                $search['opportunity_id']  = (string)$opportunityId; 
            
                $search_parent['exchange']          = 'binance';
                $search_parent['application_mode']  = 'live';
                $search_parent['order_mode']        = 'live';

                $parent = $custom->$buy_order_collection->find($search_parent);
                $insert_array['mode'] = 'live';
                $parent_response = iterator_to_array($parent);

                if(count($parent_response) > 0){
                    $insert_array['parent_active_count'] = count($parent_response);
                }else{
                    $insert_array['parent_active_count'] = 0;
                }

                $pickParentYes['exchange'] = 'binance';
                $pickParentYes['application_mode']  = 'live';
                $pickParentYes['order_mode']        = 'live'; 
                $pickParentYesReturn = $custom->$buy_order_collection->count($pickParentYes);



                //  testing temp query
                 $testingResult = $custom->$buy_order_collection->find($pickParentYes);
                 $testingResultResponse  = iterator_to_array($testingResult);
                 $insertDumyArry = [
 
                    'oppprtunity_id'  =>   $opportunityId,
                    'parent_detail'   =>   $testingResultResponse,
                    'exchange'        =>   'binance',
                    'mode'            =>   'live'      
                 ];
                 $custom->asim_temp->insertOne($insertDumyArry);
                //  end code  dummy 
 

                if($pickParentYesReturn > 0){
                    $insert_array['pickParentYes'] = $pickParentYesReturn;
                }else{
                    $insert_array['pickParentYes'] = 0;
                }

                $query = $custom->$collection_name_live->updateOne($search, ['$set'=> $insert_array], $upsert);
                $message = array(
                    'message'       => 'inserted successfully',
                    'exchnage'      => 'binance',
                    'level'         => $level,
                    'current_price' => $current_price,
                    'opportunityId' => $opportunityId,
                    'symbol'        => $coin_symbol,
                    'pickParentYes' => $pickParentYesReturn,
                    'parent'        =>  $insert_array['parent_active_count'],
                    'mode'          => $search_parent['order_mode'],
                    'type'          => '200'
                );
                $this->set_response($message, REST_Controller::HTTP_CREATED);
            }else{
                $message = array(
                    'message' => 'payload have some Issue',
                    'type'    => '404'
                );
                $this->set_response($message, REST_Controller:: HTTP_NOT_FOUND);
            }
        }else{
            $message = array(
                'message' => 'Authentication field',
                'type'    => '404'
            );
            $this->set_response($message, REST_Controller:: HTTP_NOT_FOUND);
        }
    }// end insert binance opportunity logs 


    public function opportunityLogOkex_post(){
        $username = md5($this->input->server('PHP_AUTH_USER'));  
        $password = md5($this->input->server('PHP_AUTH_PW'));

        if($username == '1755e99ca881fc22958890d7a41b026b' && $password == 'fa6b9d534c05016dc660f93daefbf3d0'){

            $opportunityId          = $this->post('opportunityId');
            $first_stop_loss_update = $this->post('first_stop_loss_update');
            $traget_profit          = $this->post('traget_profit');
            $trade_limit            = $this->post('trade_limit');
            $coin_symbol            = $this->post('symbol');
            $level                  = $this->post('level');
            $mode                   = $this->post('mode');
            $exchanges              = $this->post('exchange');
            $current_price          = $this->post('current_price');

            $upsert['upsert'] = true;
            $custom = $this->mongo_db->customQuery();
            
            $search_parent['parent_status']     = 'parent';
            $search_parent['status']            = 'new';
            $search_parent['pause_status']      = 'play'; 
            $search_parent['trigger_type']      =  'barrier_percentile_trigger'; 
            $search_parent['symbol']            =  $coin_symbol;
            $search_parent['order_level']       =  $level; 

            $pickParentYes['parent_status']     = 'parent';
            $pickParentYes['status']            = 'new';
            $pickParentYes['pause_status']      = 'play'; 
            $pickParentYes['trigger_type']      =  'barrier_percentile_trigger'; 
            $pickParentYes['symbol']            =  $coin_symbol;
            $pickParentYes['order_level']       =  $level; 
            $pickParentYes['pick_parent']       =  'yes'; 

            $insert_array = array(
                'created_date'           =>  $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s')),
                'sendHitTime'            =>  $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s')),        
                'modified_date'          =>  $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s')),
                'level'                  =>  $level,
                'opportunity_id'         =>  (string)$opportunityId,
                'coin'                   =>  $coin_symbol,
                'current_price'          =>  $current_price,
                'purchase_price'         =>  $current_price,
                'first_stop_loss_update' =>  $first_stop_loss_update,
                'traget_profit'          =>  $traget_profit,
                'trade_limit'            =>  $trade_limit,
                'month_modified_time'    =>  $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s'))
            );
            
            if($mode == 'both'){
                $collection_name_live   = 'opportunity_logs_okex';
                $collection_name_test   = 'opportunity_logs_test_okex';
                $buy_order_collection   = 'buy_orders_okex';

                $search['opportunity_id'] = (string)$opportunityId;
                // inserting live opportunity logs
                $search_parent['exchange']          = 'okex';
                $search_parent['application_mode']  = 'live';
                $search_parent['order_mode']        = 'live'; 

                $parent = $custom->$buy_order_collection->find($search_parent);
                $insert_array['mode'] = 'live';
                $parent_response = iterator_to_array($parent);
                if(count($parent_response) > 0){
                    $insert_array['parent_active_count'] = count($parent_response);
                }else{
                    $insert_array['parent_active_count'] = 0;
                }

                $pickParentYes['exchange']          = 'okex';
                $pickParentYes['application_mode']  = 'live';
                $pickParentYes['order_mode']        = 'live'; 
                $pickParentYesReturn = $custom->$buy_order_collection->count($pickParentYes);

                if($pickParentYesReturn > 0){
                    $insert_array['pickParentYes'] = $pickParentYesReturn;
                }else{
                    $insert_array['pickParentYes'] = 0;
                }

                $query = $custom->$collection_name_live->updateOne($search, ['$set'=> $insert_array], $upsert);
                $message = array(
                    'message'       => 'inserted successfully',
                    'exchange'      => 'okex',
                    'level'         => $level,
                    'symbol'        => $coin_symbol,
                    'pickParentYes' => $pickParentYesReturn,
                    'current_price' => $current_price,
                    'opportunityId' => $opportunityId,
                    'parent'        => $insert_array['parent_active_count'],
                    'mode'          => $search_parent['order_mode'],
                    'type'          => '200'
                );
                $response_array[] = $message;

                //inserting test opportunity logs 
                 $search_parent['exchange']         = 'okex';
                $search_parent['application_mode']  = 'test';
                $search_parent['order_mode']        = 'test'; 

                $parent = $custom->$buy_order_collection->find($search_parent);
                $parent_response = iterator_to_array($parent);

                $insert_array['mode'] = 'test';
                if(count($parent_response) > 0){
                    $insert_array['parent_active_count'] = count($parent_response);
                }else{
                    $insert_array['parent_active_count'] = 0;
                }

                $$pickParentYes['exchange']          = 'okex';
                $$pickParentYes['application_mode']  = 'test';
                $$pickParentYes['order_mode']        = 'test'; 

                $pickParentYesReturn = $custom->$buy_order_collection->count($pickParentYes);
                if($pickParentYesReturn > 0){
                    $insert_array['pickParentYes'] = $pickParentYesReturn;
                }else{
                    $insert_array['pickParentYes'] = 0;
                }

                $query = $custom->$collection_name_test->updateOne($search, ['$set'=> $insert_array], $upsert);
                $message = array(
                    'message'       => 'inserted successfully',
                    'exchnage'      => 'okex',
                    'level'         => $level,
                    'symbol'        => $coin_symbol,
                    'parent'        => $insert_array['parent_active_count'],
                    'pickParentYes' => $pickParentYesReturn,
                    'mode'          => $search_parent['order_mode'],
                    'opportunityId' => $opportunityId,
                    'current_price' => $current_price,
                    'type'          => '200'
                );
                $response_array[] = $message;
                $this->set_response($response_array, REST_Controller::HTTP_CREATED);
            }elseif($mode == 'test'){
                $buy_order_collection = 'buy_orders_okex';
                $collection_name_test = 'opportunity_logs_test_okex';

                $search['opportunity_id']  = (string)$opportunityId; 

                $search_parent['exchange']          = 'okex';
                $search_parent['application_mode']  = 'test';
                $search_parent['order_mode']        = 'test'; 

                $parent_test = $custom->$buy_order_collection->find($search_parent);
                $response_parent = iterator_to_array($parent_test);
                $insert_array['mode'] = 'test';
                if(count($response_parent) > 0){
                    $insert_array['parent_active_count'] = count($response_parent);
                }else{
                    $insert_array['parent_active_count'] = 0;
                }
                $pickParentYes['exchange']          = 'okex';
                $pickParentYes['application_mode']  = 'test';
                $pickParentYes['order_mode']        = 'test'; 

                $pickParentYesReturn = $custom->$buy_order_collection->count($pickParentYes);
                if($pickParentYesReturn > 0){
                    $insert_array['pickParentYes'] = $pickParentYesReturn;
                }else{
                    $insert_array['pickParentYes'] = 0;
                }

                $query = $custom->$collection_name_test->updateOne($search, ['$set'=> $insert_array], $upsert);
                $message = array(
                    'message'       => 'inserted successfully',
                    'exchnage'      => 'okex',
                    'level'         => $level,
                    'pickParentYes' => $pickParentYesReturn,
                    'current_price' => $current_price,
                    'symbol'        => $coin_symbol,
                    'opportunityId' => $opportunityId,
                    'parent'        => $insert_array['parent_active_count'],
                    'mode'          => $search_parent['order_mode'],
                    'type'          => '200',
                );
                $this->set_response($message, REST_Controller::HTTP_CREATED);
            }elseif($mode == 'live'){
                $buy_order_collection = 'buy_orders';

                $collection_name_live      = 'opportunity_logs_okex';
                $search['opportunity_id']  = (string)$opportunityId; 
            
                $search_parent['exchange']          = 'okex';
                $search_parent['application_mode']  = 'live';
                $search_parent['order_mode']        = 'live';

                $parent = $custom->$buy_order_collection->find($search_parent);
                $insert_array['mode'] = 'live';
                $parent_response = iterator_to_array($parent);

                if(count($parent_response) > 0){
                    $insert_array['parent_active_count'] = count($parent_response);
                }else{
                    $insert_array['parent_active_count'] = 0;
                }

                $pickParentYes['exchange'] = 'okex';
                $pickParentYes['application_mode']  = 'live';
                $pickParentYes['order_mode']        = 'live'; 
                $pickParentYesReturn = $custom->$buy_order_collection->count($pickParentYes);



                //  testing temp query
                 $testingResult = $custom->$buy_order_collection->find($pickParentYes);
                 $testingResultResponse  = iterator_to_array($testingResult);
                 $insertDumyArry = [
 
                    'oppprtunity_id'  =>   $opportunityId,
                    'parent_detail'   =>   $testingResultResponse,
                    'exchange'        =>   'okex',
                    'mode'            =>   'live'      
                 ];
                 $custom->asim_temp->insertOne($insertDumyArry);
                //  end code  dummy 
 

                if($pickParentYesReturn > 0){
                    $insert_array['pickParentYes'] = $pickParentYesReturn;
                }else{
                    $insert_array['pickParentYes'] = 0;
                }

                $query = $custom->$collection_name_live->updateOne($search, ['$set'=> $insert_array], $upsert);
                $message = array(
                    'message'       => 'inserted successfully',
                    'exchnage'      => 'okex',
                    'level'         => $level,
                    'current_price' => $current_price,
                    'opportunityId' => $opportunityId,
                    'symbol'        => $coin_symbol,
                    'pickParentYes' => $pickParentYesReturn,
                    'parent'        =>  $insert_array['parent_active_count'],
                    'mode'          => $search_parent['order_mode'],
                    'type'          => '200'
                );
                $this->set_response($message, REST_Controller::HTTP_CREATED);
            }else{
                $message = array(
                    'message' => 'payload have some Issue',
                    'type'    => '404'
                );
                $this->set_response($message, REST_Controller:: HTTP_NOT_FOUND);
            }
        }else{
            $message = array(
                'message' => 'Authentication field',
                'type'    => '404'
            );
            $this->set_response($message, REST_Controller:: HTTP_NOT_FOUND);
        }
    }// end insert okex opportunity logs 

    public function opportunityLogBam_post(){
        $username = md5($this->input->server('PHP_AUTH_USER'));  
        $password = md5($this->input->server('PHP_AUTH_PW'));

        if($username == '1755e99ca881fc22958890d7a41b026b' && $password == 'fa6b9d534c05016dc660f93daefbf3d0'){

            $opportunityId          = $this->post('opportunityId');
            $first_stop_loss_update = $this->post('first_stop_loss_update');
            $traget_profit          = $this->post('traget_profit');
            $trade_limit            = $this->post('trade_limit');
            $coin_symbol            = $this->post('symbol');
            $level                  = $this->post('level');
            $mode                   = $this->post('mode');
            $exchanges              = $this->post('exchange');
            $current_price          = $this->post('current_price');

            $upsert['upsert'] = true;
            $custom = $this->mongo_db->customQuery();
            
            $search_parent['parent_status']     = 'parent';
            $search_parent['status']            = 'new';
            $search_parent['pause_status']      = 'play'; 
            $search_parent['trigger_type']      =  'barrier_percentile_trigger'; 
            $search_parent['symbol']            =  $coin_symbol;
            $search_parent['order_level']       =  $level; 

            $pickParentYes['parent_status']     = 'parent';
            $pickParentYes['status']            = 'new';
            $pickParentYes['pause_status']      = 'play'; 
            $pickParentYes['trigger_type']      =  'barrier_percentile_trigger'; 
            $pickParentYes['symbol']            =  $coin_symbol;
            $pickParentYes['order_level']       =  $level; 
            $pickParentYes['pick_parent']       =  'yes'; 

            $insert_array = array(
                'created_date'           =>  $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s')),
                'sendHitTime'            =>  $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s')),        
                'modified_date'          =>  $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s')),
                'level'                  =>  $level,
                'opportunity_id'         =>  (string)$opportunityId,
                'coin'                   =>  $coin_symbol,
                'current_price'          =>  $current_price,
                'purchase_price'         =>  $current_price,
                'first_stop_loss_update' =>  $first_stop_loss_update,
                'traget_profit'          =>  $traget_profit,
                'trade_limit'            =>  $trade_limit,
                'month_modified_time'    =>  $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s'))
            );
            if($mode == 'both'){
                $collection_name_live   = 'opportunity_logs_bam';
                $collection_name_test   = 'opportunity_logs_test_bam';
                $buy_order_collection   = 'buy_orders_bam';

                $search['opportunity_id'] = (string)$opportunityId;

                //insert live opportunity logs 
                $search_parent['exchange']          = 'bam';
                $search_parent['application_mode']  = 'live';
                $search_parent['order_mode']        = 'live'; 

                $parent = $custom->$buy_order_collection->find($search_parent);
                $insert_array['mode'] = 'live';
                $parent_response = iterator_to_array($parent);
                if(count($parent_response) > 0){
                    $insert_array['parent_active_count'] = count($parent_response);
                }else{
                    $insert_array['parent_active_count'] = 0;
                }

                $pickParentYes['exchange']          = 'bam';
                $pickParentYes['application_mode']  = 'live';
                $pickParentYes['order_mode']        = 'live'; 
                $pickParentYesReturn = $custom->$buy_order_collection->count($pickParentYes);
                if($pickParentYesReturn > 0){
                    $insert_array['pickParentYes'] = $pickParentYesReturn;
                }else{
                    $insert_array['pickParentYes'] = 0;
                }

                $query = $custom->$collection_name_live->updateOne($search, ['$set'=> $insert_array], $upsert);
                $message = array(
                    'message'       => 'inserted successfully',
                    'exchnage'      => 'bam',
                    'level'         => $level,
                    'symbol'        => $coin_symbol,
                    'pickParentYes' => $pickParentYesReturn,
                    'current_price' => $current_price,
                    'opportunityId' => $opportunityId,
                    'parent'        => $insert_array['parent_active_count'],
                    'mode'          => $search_parent['order_mode'],
                    'type'          => '200'
                );
                $response_array[] = $message;

                //inserting test opportunity logs 
                $search_parent['exchange']          = 'bam';
                $search_parent['application_mode']  = 'test';
                $search_parent['order_mode']        = 'test'; 

                $parent = $custom->$buy_order_collection->find($search_parent);
                $parent_response = iterator_to_array($parent);

                $insert_array['mode'] = 'test';
                if(count($parent_response) > 0){
                    $insert_array['parent_active_count'] = count($parent_response);
                }else{
                    $insert_array['parent_active_count'] = 0;
                }

                $$pickParentYes['exchange']          = 'bam';
                $$pickParentYes['application_mode']  = 'test';
                $$pickParentYes['order_mode']        = 'test'; 

                $pickParentYesReturn = $custom->$buy_order_collection->count($pickParentYes);
                if($pickParentYesReturn > 0){
                    $insert_array['pickParentYes'] = $pickParentYesReturn;
                }else{
                    $insert_array['pickParentYes'] = 0;
                }

                $query = $custom->$collection_name_test->updateOne($search, ['$set'=> $insert_array], $upsert);
                $message = array(
                    'message'       => 'inserted successfully',
                    'exchnage'      => 'bam',
                    'level'         => $level,
                    'symbol'        => $coin_symbol,
                    'parent'        => $insert_array['parent_active_count'],
                    'pickParentYes' => $pickParentYesReturn,
                    'mode'          => $search_parent['order_mode'],
                    'opportunityId' => $opportunityId,
                    'current_price' => $current_price,
                    'type'          => '200'
                );
                $response_array[] = $message;
                $this->set_response($response_array, REST_Controller:: HTTP_CREATED);
            }elseif($mode == 'test'){
                $buy_order_collection = 'buy_orders_bam';
                $collection_name_test = 'opportunity_logs_test_bam';

                $search['opportunity_id']  = (string)$opportunityId; 

                $search_parent['exchange']          = 'bam';
                $search_parent['application_mode']  = 'test';
                $search_parent['order_mode']        = 'test'; 

                $parent_test = $custom->$buy_order_collection->find($search_parent);
                $response_parent = iterator_to_array($parent_test);
                $insert_array['mode'] = 'test';
                if(count($response_parent) > 0){
                    $insert_array['parent_active_count'] = count($response_parent);
                }else{
                    $insert_array['parent_active_count'] = 0;
                }
                $pickParentYes['exchange']          = 'bam';
                $pickParentYes['application_mode']  = 'test';
                $pickParentYes['order_mode']        = 'test'; 

                $pickParentYesReturn = $custom->$buy_order_collection->count($pickParentYes);
                if($pickParentYesReturn > 0){
                    $insert_array['pickParentYes'] = $pickParentYesReturn;
                }else{
                    $insert_array['pickParentYes'] = 0;
                }

                $query = $custom->$collection_name_test->updateOne($search, ['$set'=> $insert_array], $upsert);
                $message = array(
                    'message'       => 'inserted successfully',
                    'exchnage'      => 'bam',
                    'level'         => $level,
                    'pickParentYes' => $pickParentYesReturn,
                    'current_price' => $current_price,
                    'symbol'        => $coin_symbol,
                    'opportunityId' => $opportunityId,
                    'parent'        => $insert_array['parent_active_count'],
                    'mode'          => $search_parent['order_mode'],
                    'type'          => '200',
                );
                $this->set_response($message, REST_Controller::HTTP_CREATED);
            }elseif($mode == 'live'){
                $buy_order_collection = 'buy_orders_bam';

                $collection_name_live      = 'opportunity_logs_bam';
                $search['opportunity_id']  = (string)$opportunityId; 
            
                $search_parent['exchange']          = 'bam';
                $search_parent['application_mode']  = 'live';
                $search_parent['order_mode']        = 'live';

                $parent = $custom->$buy_order_collection->find($search_parent);
                $insert_array['mode'] = 'live';
                $parent_response = iterator_to_array($parent);

                if(count($parent_response) > 0){
                    $insert_array['parent_active_count'] = count($parent_response);
                }else{
                    $insert_array['parent_active_count'] = 0;
                }

                $pickParentYes['exchange'] = $echange;
                $pickParentYes['application_mode']  = 'live';
                $pickParentYes['order_mode']        = 'live'; 
                $pickParentYesReturn = $custom->$buy_order_collection->count($pickParentYes);

                if($pickParentYesReturn > 0){
                    $insert_array['pickParentYes'] = $pickParentYesReturn;
                }else{
                    $insert_array['pickParentYes'] = 0;
                }

                $query = $custom->$collection_name_live->updateOne($search, ['$set'=> $insert_array], $upsert);
                $message = array(
                    'message'       =>  'inserted successfully',
                    'exchnage'      =>  'bam',
                    'level'         =>  $level,
                    'current_price' =>  $current_price,
                    'opportunityId' =>  $opportunityId,
                    'symbol'        =>  $coin_symbol,
                    'pickParentYes' =>  $pickParentYesReturn,
                    'parent'        =>  $insert_array['parent_active_count'],
                    'mode'          =>  $search_parent['order_mode'],
                    'type'          =>  '200'
                );
                $this->set_response($message, REST_Controller::HTTP_CREATED);
            }else{
                $message = array(
                    'message' => 'payload have some Issue',
                    'type'    => '404'
                );
                $this->set_response($message, REST_Controller::HTTP_NOT_FOUND);
            }
        }else{
            $message = array(
                'message' => 'Authentication field',
                'type'    => '404'
            );
            $this->set_response($message, REST_Controller::HTTP_NOT_FOUND);
        }
    }// end insert bam opportunity logs 

    public function sellPriceLockInOpportunityReportBinance_post(){
        // digiebot.com
        // YaAllah
        $usernameSend = md5($this->input->server('PHP_AUTH_USER'));  
        $passwordSend = md5($this->input->server('PHP_AUTH_PW'));

        if($usernameSend == '1755e99ca881fc22958890d7a41b026b' && $passwordSend == 'fa6b9d534c05016dc660f93daefbf3d0'){
            $coin                   =   $this->post('symbol');
            $sell_signal_price      =   (float)$this->post('sell_signal_price');
            $mode                   =   $this->post('mode');
            $type                   =   $this->post('type');
            $recomended_price       =   $this->post('recomended_price');
           
            $orderLevel             =   $this->post('orderLevel');
            $sell_signal_created_date = $this->mongo_db->converToMongodttime(($this->post('sell_signal_created_date')));

            $db                     =   $this->mongo_db->customQuery();
            if(!empty($coin) && !empty($sell_signal_price) && !empty($mode) && $orderLevel != 'level_15' && !empty($type) && !empty($recomended_price) &&  !empty($sell_signal_created_date)){
                $updationCOllectionName     =  'opportunity_logs_binance';
                $updationCOllectionNameTest =  'opportunity_logs_test_binance';

                $insertArray = [
                    'sell_signal_price'  =>     $sell_signal_price,
                    'orderLevel'         =>     $orderLevel,
                    'type'               =>     $type,
                    'modeSend'           =>     $mode,
                    'recomended_price'   =>     $recomended_price,
                    'sell_signal_time'   =>     $sell_signal_created_date,
                ];

                $lookup = [
                    [
                        '$match' => [
                            'coin'              =>     $coin,
                            'sell_signal_price' =>     ['$exists' => false]
                        ]
                    ],

                    [
                        '$match' => [
                            'current_price' => ['$lte' => $recomended_price],   
                            'created_date'  => ['$lte' => $sell_signal_created_date]
                        ]
                    ],
                    

                    [
                        '$project' => [
                            '_id'            => 1,
                            'opportunity_id' => 1
                        ]
                    ],
                ];

                if($mode == 'both'){
                    $getDetailLive  = $db->$updationCOllectionName->aggregate($lookup);
                    $getDetailTestResponse = iterator_to_array($getDetailLive);

                    foreach($getDetailTestResponse as $id){
                        $where['opportunity_id'] = $id['opportunity_id'];
                        $getDetailLiveNew  = $db->$updationCOllectionName->updateOne($where, ['$set' => $insertArray]);
                        $response = [
                            'exchange'          =>  'binance',
                            'sell_signal_price' =>  $sell_signal_price,
                            'coin'              =>  $coin,
                            'orderLevel'        =>  $orderLevel,
                            'mode'              =>  'live',  
                            'opportunity_id'    =>  $id['opportunity_id'],
                            'modifiedCountTest' =>  $getDetailLiveNew->getModifiedCount(),
                            'sell_signal_time'  =>  date('Y-m-d H:i:s')
                        ];
                        $this->set_response($response, REST_Controller ::HTTP_CREATED);
                    }

                    //for test
                    $getDetailTest  = $db->$updationCOllectionNameTest->aggregate($lookup);
                    $getDetailTestResponseTest = iterator_to_array($getDetailTest);

                    foreach($getDetailTestResponseTest as $id){

                        $where['opportunity_id'] = $id['opportunity_id'];
                        $getDetailTestNew  = $db->$updationCOllectionNameTest->updateOne($where, ['$set' => $insertArray]);
                        $response = [
                            'exchange'          =>  'binance',
                            'sell_signal_price' =>  $sell_signal_price,
                            'coin'              =>  $coin,
                            'orderLevel'        =>  $orderLevel,
                            'mode'              =>  'test',  
                            'opportunity_id'    =>  $id['opportunity_id'],
                            'modifiedCountTest' =>  $getDetailTestNew->getModifiedCount(),
                            'sell_signal_time'  =>  date('Y-m-d H:i:s')
                        ];
                        $this->set_response($response, REST_Controller ::HTTP_CREATED);
                    }

                }elseif($mode == 'live'){

                    $getDetailLive  = $db->$updationCOllectionName->aggregate($lookup);
                    $getDetailTestResponse = iterator_to_array($getDetailLive);

                    foreach($getDetailTestResponse as $id){

                        $where['opportunity_id'] = $id['opportunity_id'];
                        $getDetailLiveNew  = $db->$updationCOllectionName->updateOne($where, ['$set' => $insertArray]);
                        $response = [
                            'exchange'          =>  'binance',
                            'sell_signal_price' =>  $sell_signal_price,
                            'coin'              =>  $coin,
                            'orderLevel'        =>  $orderLevel,                            
                            'mode'              =>  $mode,  
                            'opportunity_id'    =>  $id['opportunity_id'],
                            'modifiedCountTest' =>  $getDetailLiveNew->getModifiedCount(),
                            'sell_signal_time'  =>  date('Y-m-d H:i:s')
                        ];
                        $this->set_response($response, REST_Controller ::HTTP_CREATED);
                    }

                }elseif($mode == 'test'){
                    $getDetailTest  = $db->$updationCOllectionNameTest->aggregate($lookup);
                    $getDetailTestResponse = iterator_to_array($getDetailTest);

                    foreach($getDetailTestResponse as $id){

                        $where['opportunity_id'] = $id['opportunity_id'];
                        $getDetailTestNew  = $db->$updationCOllectionNameTest->updateOne($where, ['$set' => $insertArray]);
                        $response = [
                            'exchange'          =>  'binance',
                            'sell_signal_price' =>  $sell_signal_price,
                            'coin'              =>  $coin,
                            'mode'              =>  $mode,  
                            'opportunity_id'    =>  $id['opportunity_id'],
                            'modifiedCountTest' =>  $getDetailTestNew->getModifiedCount(),
                            'sell_signal_time'  =>  date('Y-m-d H:i:s')
                        ];
                        $this->set_response($response, REST_Controller ::HTTP_CREATED);
                    }
                }else{
                    $response = array(
                        'response' => 'Wrong parameters',
                        'type'    => '404'
                    );
                    $this->set_response($response, REST_Controller::HTTP_NOT_FOUND);
                }
            }else{
                $response = array(
                    'response' => 'Wrong parameters',
                    'type'    => '404'
                );
                $this->set_response($response, REST_Controller::HTTP_NOT_FOUND);
            }
        }else{
            $response = array(
                'response' => 'Authentication field',
                'type'    => '404'
            );
            $this->set_response($response, REST_Controller::HTTP_NOT_FOUND);
        }
    }// end insert sell Signal in binance opportunity logs 

    public function sellPriceLockInOpportunityReportKraken_post(){
        // digiebot.com
        // YaAllah
        $usernameSend = md5($this->input->server('PHP_AUTH_USER'));  
        $passwordSend = md5($this->input->server('PHP_AUTH_PW'));
        if($usernameSend == '1755e99ca881fc22958890d7a41b026b' && $passwordSend == 'fa6b9d534c05016dc660f93daefbf3d0'){
            $coin                   =   $this->post('symbol');
            $sell_signal_price      =   $this->post('sell_signal_price');
            $mode                   =   $this->post('mode');
            $type                   =   $this->post('type');
            $recomended_price       =   $this->post('recomended_price');
            $orderLevel             =   $this->post('orderLevel');
            $sell_signal_created_date = $this->mongo_db->converToMongodttime(($this->post('sell_signal_created_date')));

            if(!empty($coin) && !empty($sell_signal_price) && !empty($mode) && $orderLevel != 'level_15' && !empty($recomended_price) && !empty($sell_signal_created_date)){
                $db                         =   $this->mongo_db->customQuery();
                $updationCOllectionName     =  'opportunity_logs_kraken';
                $updationCOllectionNameTest =  'opportunity_logs_test_kraken';

                $insertArray = [
                    'sell_signal_price'  =>     $sell_signal_price,
                    'orderLevel'         =>     $orderLevel,
                    'type'               =>     $type,
                    'recomended_price'   =>     $recomended_price,
                    'sell_signal_time'   =>     $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s'))
                ];
                $lookup = [
                    [
                        '$match' => [
                            'coin'              =>     $coin,
                            'sell_signal_price' =>     ['$exists' => false]
                        ]
                    ],

                    [
                        '$match' => [
                            'current_price' => ['$lte' => $recomended_price],
                            'created_date'  => ['$lte' => $sell_signal_created_date]
                        ]
                    ],

                    
                    [
                        '$project' => [
                            '_id'            => 1,
                            'opportunity_id' => 1
                        ]
                    ],
                ];


                if($mode == 'both'){

                    $getDetailLive  = $db->$updationCOllectionName->aggregate($lookup);
                    $getDetailTestResponse = iterator_to_array($getDetailLive);

                    foreach($getDetailTestResponse as $id){

                        $where['opportunity_id'] = $id['opportunity_id'];
                        $getDetailLiveNew  = $db->$updationCOllectionName->updateOne($where, ['$set' => $insertArray]);
                        $response = [
                            'exchange'          =>  'kraken',
                            'sell_signal_price' =>  $sell_signal_price,
                            'coin'              =>  $coin,
                            'orderLevel'        =>  $orderLevel,
                            'mode'              =>  'live',  
                            'opportunity_id'    =>  $id['opportunity_id'],
                            'modifiedCountTest' =>  $getDetailLiveNew->getModifiedCount(),
                            'sell_signal_time'  =>  date('Y-m-d H:i:s')
                        ];
                        $this->set_response($response, REST_Controller ::HTTP_CREATED);
                    }


                    //for test
                    $getDetailTest  = $db->$updationCOllectionNameTest->aggregate($lookup);
                    $getDetailTestResponseTest = iterator_to_array($getDetailTest);

                    foreach($getDetailTestResponseTest as $id){

                        $where['opportunity_id'] = $id['opportunity_id'];
                        $getDetailTestNew  = $db->$updationCOllectionNameTest->updateOne($where, ['$set' => $insertArray]);
                        $response = [
                            'exchange'          =>  'kraken',
                            'sell_signal_price' =>  $sell_signal_price,
                            'coin'              =>  $coin,
                            'orderLevel'        =>     $orderLevel,
                            'mode'              =>  'test',  
                            'opportunity_id'    =>  $id['opportunity_id'],
                            'modifiedCountTest' =>  $getDetailTestNew->getModifiedCount(),
                            'sell_signal_time'  =>  date('Y-m-d H:i:s')
                        ];
                        $this->set_response($response, REST_Controller ::HTTP_CREATED);
                    }


                }elseif($mode == 'live'){
                    $getDetailLive  = $db->$updationCOllectionName->aggregate($lookup);
                    $getDetailTestResponse = iterator_to_array($getDetailLive);

                    foreach($getDetailTestResponse as $id){
                        $where['opportunity_id'] = $id['opportunity_id'];
                        $getDetailLiveNew  = $db->$updationCOllectionName->updateOne($where, ['$set' => $insertArray]);
                        $response = [
                            'exchange'          =>  'kraken',
                            'orderLevel'        =>     $orderLevel,
                            'sell_signal_price' =>  $sell_signal_price,
                            'coin'              =>  $coin,
                            'mode'              =>  'live',  
                            'opportunity_id'    =>  $id['opportunity_id'],
                            'modifiedCountTest' =>  $getDetailLiveNew->getModifiedCount(),
                            'sell_signal_time'  =>  date('Y-m-d H:i:s')
                        ];
                        $this->set_response($response, REST_Controller ::HTTP_CREATED);
                    }

                }elseif($mode == 'test'){
                    $getDetailTest  = $db->$updationCOllectionNameTest->aggregate($lookup);
                    $getDetailTestResponse = iterator_to_array($getDetailTest);
                    foreach($getDetailTestResponse as $id){

                        $where['opportunity_id'] = $id['opportunity_id'];
                        $getDetailTestNew  = $db->$updationCOllectionNameTest->updateOne($where, ['$set' => $insertArray]);
                        $response = [
                            'exchange'          =>  'kraken',
                            'sell_signal_price' =>  $sell_signal_price,
                            'coin'              =>  $coin,
                            'mode'              =>  'test',  
                            'opportunity_id'    =>  $id['opportunity_id'],
                            'modifiedCountTest' =>  $getDetailTestNew->getModifiedCount(),
                            'sell_signal_time'  =>  date('Y-m-d H:i:s')
                        ];
                        $this->set_response($response, REST_Controller ::HTTP_CREATED);
                    }

                }else{
                    $response = array(
                        'response' => 'Wrong parameter',
                        'type'    => '404'
                    );
                    $this->set_response($response, REST_Controller::HTTP_NOT_FOUND);
                }
                
            }else{
                $response = array(
                    'response' => 'Wrong parameter',
                    'type'    => '404'
                );
                $this->set_response($response, REST_Controller::HTTP_NOT_FOUND);
            }
        }else{
            $response = array(
                'response' => 'Authentication field',
                'type'    => '404'
            );
            $this->set_response($response, REST_Controller::HTTP_NOT_FOUND);
        }
    }// end insert sell Signal in kraken opportunity logs 

    public function sellPriceLockInOpportunityReportBam_post(){
        // digiebot.com
        // YaAllah
        $usernameSend = md5($this->input->server('PHP_AUTH_USER'));  
        $passwordSend = md5($this->input->server('PHP_AUTH_PW'));

        if($usernameSend == '1755e99ca881fc22958890d7a41b026b' && $passwordSend == 'fa6b9d534c05016dc660f93daefbf3d0'){
            $coin                   =   $this->post('symbol');
            $sell_signal_price      =   $this->post('sell_signal_price');
            $mode                   =   $this->post('mode');
            $orderLevel             =   $this->post('orderLevel');
            $type                   =   $this->post('type');
            $recomended_price       =   $this->post('recomended_price');

            $sell_signal_created_date = $this->mongo_db->converToMongodttime(($this->post('sell_signal_created_date')));

            if(!empty($coin) && !empty($sell_signal_price) && !empty($mode) && $orderLevel != 'level_15'){

                $db                         =   $this->mongo_db->customQuery();
                $updationCOllectionName     =  'opportunity_logs_bam';
                $updationCOllectionNameTest =  'opportunity_logs_test_bam';

                $insertArray = [
                    'sell_signal_price'  =>     $sell_signal_price,
                    'orderLevel'         =>     $orderLevel,
                    'type'               =>     $type,
                    'sell_signal_time'   =>     $sell_signal_created_date
                ];

                $updateWhere['coin']              =     $coin;
                $updateWhere['sell_signal_price'] =     ['$exists' => false];
                $updateWhere['$expr']             =     ['$gte' => ['$current_price', $sell_signal_price ]];

                if($mode == 'both'){
                    $getDetail      = $db->$updationCOllectionName->updateMany($updateWhere, ['$set' => $insertArray]);
                    $getDetailTest  = $db->$updationCOllectionNameTest->updateMany($updateWhere, ['$set' => $insertArray]);
    
                    $response = [
    
                        'exchange'          =>  'bam',
                        'mode'              =>  'both',
                        'orderLevel'        =>  $orderLevel,
                        'sell_signal_price' =>  $sell_signal_price,
                        'coin'              =>  $coin,
                        'modifiedCountLive' =>  $getDetail->getModifiedCount(),
                        'modifiedCountTest' =>  $getDetailTest->getModifiedCount(),
                        'sell_signal_time'  =>  $sell_signal_created_date
                    ];
    
                    $this->set_response($response, REST_Controller ::HTTP_CREATED);

                }elseif($mode == 'live'){
                    $getDetail      = $db->$updationCOllectionName->updateMany($updateWhere, ['$set' => $insertArray]);
    
                    $response = [
    
                        'exchange'          =>  'bam',
                        'mode'              =>  'live',
                        'orderLevel'        =>  $orderLevel,
                        'sell_signal_price' =>  $sell_signal_price,
                        'coin'              =>  $coin,
                        'modifiedCountLive' =>  $getDetail->getModifiedCount(),
                        'sell_signal_time'  =>  $sell_signal_created_date
                    ];
    
                    $this->set_response($response, REST_Controller ::HTTP_CREATED);

                }elseif($mode == 'test'){
                    $getDetail      = $db->$updationCOllectionName->updateMany($updateWhere, ['$set' => $insertArray]);
    
                    $response = [
                        'exchange'          =>  'bam',
                        'mode'              =>  'test',
                        'orderLevel'        =>  $orderLevel,
                        'sell_signal_price' =>  $sell_signal_price,
                        'coin'              =>  $coin,
                        'modifiedCountLive' =>  $getDetail->getModifiedCount(),
                        'sell_signal_time'  =>  $sell_signal_created_date
                    ];
                    $this->set_response($response, REST_Controller ::HTTP_CREATED);
                }else{
                    $response = array(
                        'response' => 'Wrong Paramters',
                        'type'    => '404'
                    );
                    $this->set_response($response, REST_Controller::HTTP_NOT_FOUND);
                }
            }else{
                $response = array(
                    'response' => 'Wrong Paramters',
                    'type'    => '404'
                );
                $this->set_response($response, REST_Controller::HTTP_NOT_FOUND);
            }
        }else{
            $response = array(
                'response' => 'Authentication field',
                'type'    => '404'
            );
            $this->set_response($response, REST_Controller::HTTP_NOT_FOUND);
        }
    }// end insert sell Signal in bam opportunity logs 

    public function childCreateUnderUserAccount_post(){
        // digiebot.com
        // YaAllah
        $usernameSend = md5($this->input->server('PHP_AUTH_USER'));  
        $passwordSend = md5($this->input->server('PHP_AUTH_PW'));

        if($usernameSend == '1755e99ca881fc22958890d7a41b026b' && $passwordSend == 'fa6b9d534c05016dc660f93daefbf3d0'){
            if( !empty($this->post('_id')) && !empty($this->post('trasectionId'))  && !empty($this->post('userid')) && !empty($this->post('purchase_price')) && !empty($this->post('exchange')) ){
                $coin_array  = ['XMRBTC','XLMBTC','ETHBTC','XRPBTC', 'NEOBTC', 'QTUMBTC', 'XEMBTC', 'POEBTC', 'TRXBTC', 'ZENBTC', 'ETCBTC', 'EOSBTC', 'LINKBTC', 'DASHBTC', 'ADABTC'];
                  
                if($this->post('exchange') == 'binance'){
                    exit;
                }
                $purchase_price     =   (float)$this->post('purchase_price');
                $userid             =   (string)$this->post('userid');
                $orderId            =   (string)$this->post('trasectionId');
                $createdDate        =    $this->post('created_date');

                $quantity   =   (float)$this->post('quantity');
                $symbol     =   $this->post('symbol');
                $exchange   =   $this->post('exchange');

                $db         =   $this->mongo_db->customQuery();

                $walletCollection  =    ($exchange == 'binance')? 'user_wallet': 'user_wallet_'.$exchange;
                $buyOrdersColcton  =    ($exchange == 'binance')? 'buy_orders': 'buy_orders_'.$exchange;
                $tradeHistoryCollection = ($exchange == 'binance')? 'user_trade_history' : 'user_trade_history_'.$exchange;

                if($exchange == 'kraken'){
                    if(in_array($symbol, $coin_array)){

                        $getCoinBalance['coin_symbol'] =  str_replace('BTC', '' ,$symbol);
                    }else{
                        $getCoinBalance['coin_symbol'] =  str_replace('USDT', '' ,$symbol);
                    }
                }elseif($exchange == 'binance'){

                    $getCoinBalance['coin_symbol'] =  $symbol;
                }elseif($exchange == 'bam'){

                    $getCoinBalance['coin_symbol'] =  $symbol;
                }
                $getCoinBalance['user_id']  = $userid;


                $getCoinBalance = $db->$walletCollection->find($getCoinBalance);
                $getCoinBalanceRes = iterator_to_array($getCoinBalance);

                $getOrderLookUp = [
                    [
                        '$match' => [

                            'admin_id'               =>     (string)$userid,
                            'application_mode'       =>     'live',
                            'status'                 =>     ['$nin' =>  ['credentials_ERROR','canceled_ERROR','error' ,'new', 'new_ERROR', 'canceled', 'pause', 'submitted_buy', 'fraction_submitted_buy']],
                            'parent_status'          =>     ['$ne'  =>     'parent'],
                            'cost_avg'               =>     ['$ne'  =>   'completed'],
                            'is_sell_order'          =>     ['$nin' =>   ['sold', 'resume_pause']],
                            'resume_status'          =>     ['$ne'  =>   'completed'],
                            'symbol'                 =>     $symbol,
                        ]

                    ],
                    [
                        '$addFields' => [

                            'coinBalanceTotalSum'  => ['$sum' => ['$quantity']]
                        ]

                    ],
                ];

                $getOrders = $db->$buyOrdersColcton->aggregate($getOrderLookUp);
                $getOrdersRes = iterator_to_array($getOrders);

                $coin_balance        = (float)$getCoinBalanceRes[0]['coin_balance'];
                $coinBalanceTotalSum = (float)$getOrdersRes[0]['coinBalanceTotalSum'];

                if( ($coin_balance - $coinBalanceTotalSum) >= $quantity  ){

                    $getUserTradingIp['_id'] = $this->mongo_db->mongoId($userid);
                    $getUsers           =   $db->users->find($getUserTradingIp);
                    $getUsersresponse   =   iterator_to_array($getUsers);
    
                    $trading_ip =  $getUsersresponse[0]['trading_ip'];
    
                    $price_search['coin'] = $symbol;
                    $this->mongo_db->where($price_search);
                    
                    if($this->post('exchange') == 'binance'){
    
                        $priceses = $this->mongo_db->get('market_prices');
                        $buy_array_collection = 'buy_orders';
                        $sell_array_collection = 'orders';
                    }elseif($this->post('exchange') == 'bam'){
    
                        $priceses = $this->mongo_db->get('market_prices_bam');
                        $buy_array_collection = 'buy_orders_bam';
                        $sell_array_collection = 'orders_bam';
                    }elseif($this->post('exchange') == 'kraken'){
    
                        $priceses = $this->mongo_db->get('market_prices_kraken');
                        $buy_array_collection = 'buy_orders_kraken';
                        $sell_array_collection = 'orders_kraken';
                    }
                    $market_prices  = iterator_to_array($priceses);
                    $current_market = $market_prices[0]['price'];
    
                    $sell_price             =   (float)((($purchase_price / 100)* 1.2) + $purchase_price);
                    $iniatial_trail_stop    =   (float)($purchase_price - (($purchase_price / 100)*1.2));
                    $current_datetime       =   $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s'));
                    $buy_array = [
                        'price'                        =>   $purchase_price,
                        'quantity'                     =>   $quantity,   
                        'symbol'                       =>   $symbol,
                        'trading_ip'                   =>   $trading_ip,
                        'admin_id'                     =>   $userid,
                        'sell_price'                   =>   (float)$sell_price,
                        'lth_functionality'            =>   'yes',
                        'activate_stop_loss_profit_percentage' => (float)1.2,
                        'lth_profit'                   =>   (float)1.2,
                        'stop_loss_rule'               =>   'custom_stop_loss',
                        'trigger_type'                 =>   'barrier_percentile_trigger',
                        'order_level'                  =>   'level_11',
                        'created_date'                 =>   $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s' ,$createdDate)),
                        'modified_date'                =>   $current_datetime,
                        'mapped_date'                  =>   $current_datetime,   
                        'application_mode'             =>   'live',
                        'order_mode'                   =>   'live', 
                        'created_buy'                  =>   'asimScript',
                        'market_value'                 =>   (float)$current_market,
                        'iniatial_trail_stop'          =>   $iniatial_trail_stop,
                        'defined_sell_percentage'      =>   (float)1.2,
                        'sell_profit_percent'          =>   (float)1.2,
                        'is_sell_order'                =>   'yes', 
                        'auto_sell'                    =>   'yes',
                        'purchased_price'              =>   $purchase_price,
                        'status'                       =>   'FILLED',
                        'sell_order_id'                =>   '',
                        'exchange'                     =>  $this->post('exchange'),
                        'buy_fraction_filled_order_arr' => [
                            'filledPrice'           => $purchase_price,
                            'commission'      => '0',
                            'commissionPercentRatio' => '0',
                            'orderFilledId'   => $orderId,
                            'filledQty'       => $quantity,
                        ],
                    ];
                    if($this->post('exchange') == 'kraken'){
    
                        $buy_array['kraken_order_id']   =   $orderId;
                        $buy_array['tradeId']           =   $orderId;
                    }elseif($this->post('exchange') == 'binance'){
    
                        $buy_array['binance_order_id'] =    $orderId;
                        $buy_array['tradeId']          =    $orderId;
                    }
                                   
                    $sell_array = [
                        'symbol'                       =>   $symbol,
                        'quantity'                     =>   $quantity,  
                        'market_value'                 =>   (float)$current_market,
                        'sell_price'                   =>   (float)$sell_price, 
                        'lth_functionality'            =>   'yes',
                        'lth_profit'                   =>   (float)1.2,
                        'activate_stop_loss_profit_percentage' => (float)1.2,
                        'stop_loss_rule'               =>   'custom_stop_loss',
                        'order_type'                   =>   'market_order',
                        'admin_id'                     =>   $userid,
                        'trading_ip'                   =>   $trading_ip,
                        'created_date'                 =>   $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s',$createdDate)),
                        'mapped_date'                  =>   $current_datetime,
                        'modified_date'                =>   $current_datetime,
                        'application_mode'             =>   'live',
                        'trigger_type'                 =>   'barrier_percentile_trigger',
                        'order_level'                  =>   'level_11',
                        'buy_order_id'                 =>   '',
                        'created_buy'                  =>   'asimScript',
                        'iniatial_trail_stop'          =>   $iniatial_trail_stop,
                        'order_mode'                   =>   'live',
                        'sell_profit_percent'          =>   (float)1.2,
                        'status'                       =>   'new',
                        'purchased_price'              =>   $purchase_price,
                        'defined_sell_percentage'      =>   (float)1.2
                    ];
    
                    $buy_return  = $db->$buy_array_collection->insertOne($buy_array); // insert buy array
                    $sell_return = $db->$sell_array_collection->insertOne($sell_array); // insert sell array
                    $sell_set =[
                        'buy_order_id' =>$buy_return->getInsertedId()
                    ];
                    $buy_set =[
                        'sell_order_id' => $sell_return->getInsertedId()
                    ];
                    $where_buy['_id']      = $sell_return->getInsertedId();
                    $where_buy['admin_id'] = $userid;
                    $res = $db->$sell_array_collection->updateOne($where_buy, ['$set'=> $sell_set]);
    
                    $where_sell['_id']      = $buy_return->getInsertedId();
                    $where_sell['admin_id'] = $userid;
                    $res = $db->$buy_array_collection->updateOne($where_sell, ['$set'=> $buy_set]);
    
                    $id = (string)$buy_return->getInsertedId();
                    $exchange = $this->post('exchange');
                    $date = date('Y-m-d G:i:s');
    
                    $insert_log_array = array(
                        'order_id'      => $id,
                        'created_date'  => $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s')),
                        'log_msg'       => 'order map using trade history report',
                        'type'          => 'map trade history button',
                        'show_hide_log' => 'yes'
                    );
                    
                    if ($exchange == 'binance') {
                        $collection1 = "orders_history_log_live_" . date('Y') . "_" . date('m', strtotime('-1 month'));
                    } elseif($exchange == 'bam') {
                        $collection1 = "orders_history_log_" . $exchange . "_live_" . date('Y') . "_" . date('m', strtotime('-1 month'));
                    } elseif($exchange == 'kraken') {
                        $collection1 = "orders_history_log_" . $exchange . "_live_" . date('Y') . "_" . date('m', strtotime('-1 month'));
                    }
                
                    if ( !empty($exchange) ) {
                        $this->mongo_db->insert($collection1, $insert_log_array);
                    }
                    
                    //update order under trade history collection
                    $updateOrder['_id'] = $this->mongo_db->mongoId((string)$this->post('_id'));
                    $db->$tradeHistoryCollection->updateOne($updateOrder, ['$set' => ['status' => 'user_map']]);
                    //end

                    $returnResponseArray = [
                        'exhange'           =>  $exchange,
                        'level'             =>  'level_11',
                        'trading_ip'        =>  $trading_ip,
                        'admin_id'          =>  $userid,
                        'purchased_price'   =>  $purchase_price,
                        'quantity'          =>  $quantity,
                        'symbol'            =>  $symbol,
                        'quantity'          =>  $quantity,
                        'digie commited'    =>  $getOrdersRes[0]['coinBalanceTotalSum'],
                        'Coinbalance'       =>  $getCoinBalanceRes[0]['coin_balance'],
                        'trasection_id'     =>  $orderId,
                        'status'            =>  'successfully created child under this userid and exchange' 
                    ];
                    $this->set_response($returnResponseArray, REST_Controller::HTTP_CREATED);
                }else{
                    $response = array(
                        'response'      => 'Balance issue',
                        'quantity'      =>  $quantity,
                        'digie commited'=>  $getOrdersRes[0]['coinBalanceTotalSum'],
                        'Coinbalance'   =>  $getCoinBalanceRes[0]['coin_balance'],
                        'type'          => '404'
                    );
                    $this->set_response($response, REST_Controller::HTTP_NOT_FOUND);
                }
            }else{
                $response = array(
                    'response' => 'parameters wrong',
                    'type'    => '404'
                );
                $this->set_response($response, REST_Controller::HTTP_NOT_FOUND);
            }
        }else{
            $response = array(
                'response' => 'Authentication field',
                'type'    => '404'
            );
            $this->set_response($response, REST_Controller::HTTP_NOT_FOUND);
        }
    }//end function

    public function mappDuplicateSellUnderUserAccount_post(){
        // digiebot.com
        // YaAllah
        exit;
        $usernameSend = md5($this->input->server('PHP_AUTH_USER'));  
        $passwordSend = md5($this->input->server('PHP_AUTH_PW'));

        if($usernameSend == '1755e99ca881fc22958890d7a41b026b' && $passwordSend == 'fa6b9d534c05016dc660f93daefbf3d0'){
            if(!empty($this->post('buyArr')) && !empty($this->post('symbol')) && !empty( $this->post('trasectionId')) && !empty($this->post('admin_id')) && !empty($this->post('market_sold_price')) && !empty($this->post('exchange')) ){

                $market_sold_price      =   (float)$this->post('market_sold_price');
                $admin_id               =   (string)$this->post('admin_id');
                $orderTrasectionId      =   $this->post('trasectionId');
                $quantity               =   (float)$this->post('quantity');
                $symbol                 =   $this->post('symbol');
                $exchange               =   $this->post('exchange');
                $buy_details            =   $this->post('buyArr');

                $purchased_price        =   $buy_details[0]['trades']['value']['price'];
                $buyTrasectionid        =   $buy_details[0]['trades']['value']['ordertxid'];
                $created_date           =   $buy_details[0]['trades']['value']['time'];


                $sellCollecton  =   ($exchange == 'binance') ? 'sold_buy_orders'     : 'sold_buy_orders_'.$exchange;

                $db   =   $this->mongo_db->customQuery();
                $sell_price             =   (float)((($purchased_price / 100)* 1.2) + $purchased_price);
                $iniatial_trail_stop    =   (float)($purchased_price - (($purchased_price / 100)*1.2));

                //get trading ip
                $getUserTradingIp['_id'] = $this->mongo_db->mongoId($admin_id);
                $getUsers           =   $db->users->find($getUserTradingIp);
                $getUsersresponse   =   iterator_to_array($getUsers);
                $trading_ip =  $getUsersresponse[0]['trading_ip'];


                $sellArray = [
                    'activate_stop_loss_profit_percentage' =>  1.2,
                    'application_mode'                     =>  'live',
                    'admin_id'                             =>  (string)$admin_id,
                    'auto_sell'                            =>  'yes',
                    'iniatial_trail_stop'                  =>   $iniatial_trail_stop,
                    'sell_price'                           =>   $sell_price,
                    'trading_ip'                           =>   $trading_ip,

                    'buy_fraction_filled_order_arr'        =>  [
                        'filledPrice'            =>  $buyTrasectionid,
                        'commission'             =>  0,
                        'commissionPercentRatio' =>  0,
                        'orderFilledId'          =>  $buyTrasectionid,
                        'filledQty'              =>  $quantity,
                    ],

                    'cancel_order_hours_range_buy'         =>   'not',
                    'cancel_order_on_off'                  =>   'not',
                    'created_date'                         =>   $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s' ,$created_date)),
                    'mapp_time'                            =>   $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s')),
                    'csl_sold'                             =>   'yes',
                    'custom_stop_loss_percentage'          =>   1.2,
                    'defined_sell_percentage'              =>   1.5,
                    'deprecated_lossPercentage'            =>   1.2,
                    'first_stop_loss_update'               =>   1.4,
                    'is_sell_order'                        =>   'sold',
                    'lang'                                 =>   'go',
                    'loss_percentage'                      =>   1.2,
                    'lth_functionality'                    =>   'yes',
                    'lth_profit'                           =>   2,
                    'market_sold_price'                    =>   $market_sold_price,
                    'market_sold_price_usd'                =>   '',
                    'market_value'                         =>   '',
                    'market_value_usd'                     =>   '',
                    'order_level'                          =>   'level_11',
                    'order_mode'                           =>   'live',
                    'order_type'                           =>   'market_order',
                    'price'                                =>   $purchased_price,
                    'purchased_price'                      =>   $purchased_price,
                    'quantity'                             =>   $quantity,
                    'modified_date'                        =>   $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s')),
                    'order_send_time'                      =>   $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s')),
                    'sell_date'                            =>   $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s')),

                    'sell_fraction_filled_order_arr'       => [

                        'commissionPercentRatio'    =>  0,
                        'orderFilledId'             =>  $orderTrasectionId,
                        'filledQty'                 =>  $quantity,
                        'filledPrice'               =>  '',
                        'commission'                =>  ''
                    ],

                    'sell_order_id'                        =>   $orderTrasectionId,
                    'sell_kraken_order_id'                 =>   $orderTrasectionId,
                    'sell_profit_percent'                  =>   1.5,
                    'status'                               =>   'FILLED',
                    'stop_loss_rule'                       =>   'custom_stop_loss',
                    'symbol'                               =>   $symbol,
                    'tradeId'                              =>   $orderTrasectionId,
                    'trading_status'                       =>   'complete',
                    'transactTime'                         =>   $this->mongo_db->converToMongodttime(date('Y-m-d H:i:s')),

                    'transaction_logs'                     => [
                       [
                            'type'          =>  'buy',
                            'bool'          =>  true,
                            'tryNo'         =>  '',
                            'errorString'   =>  'No Error',
                            'txid'          =>  ''
                       ],
                       [
                            'errorString'   =>  'No Error',
                            'txid'          =>  $orderTrasectionId,
                            'type'          =>  'sell',
                            'bool'          =>  true,
                            'tryNo'         =>  1
                        ]
                        
                    ],
                    'trigger_type'                         =>   'barrier_percentile_trigger',
                    'buy_trail_price'                      =>   0,
                    'market_heighest_value'                =>   0,
                    'market_lowest_value'                  =>   0
                ];
            
                if($exchange == 'binance'){

                    $sellArray['tradeId']            =     $this->post('trasectionId');
                }elseif($exchange == 'kraken'){

                    $sellArray['kraken_order_id']    =    (string)$this->post('trasectionId');
                }


                $insertedCountSell  = $db->$sellCollecton->insertOne($sellArray);

                $returnResponseArray = [
                    'exhange'               =>  $exchange,
                    'level'                 =>  $symbol,
                    'purchased_price'       =>  $purchased_price, 
                    'admin_id'              =>  $admin_id,
                    'market_sold_price'     =>  $market_sold_price,
                    'quantity'              =>  $quantity,
                    'insertedId'            =>  $insertedCountSell->getInsertedId() ,
                    'symbol'                =>  $symbol,
                    'quantity'              =>  $quantity,
                    'buy_details'           =>  $buy_details,
                    'trasection_id'         =>  $orderTrasectionId,
                    'status'                =>  'successfully mapped order' 
                ];
                $this->set_response($returnResponseArray, REST_Controller::HTTP_CREATED);
              
            }else{
                $response = array(
                    'response' => 'parameters wrong',
                    'type'    => '404'
                );
                $this->set_response($response, REST_Controller::HTTP_NOT_FOUND);
            }
        }else{
            $response = array(
                'response' => 'Authentication field',
                'type'    => '404'
            );
            $this->set_response($response, REST_Controller::HTTP_NOT_FOUND);
        }
    }//end function

    //  api call for server cron added in cron listing page for shahzad
	public function last_cron_execution_time_post(){
        // digiebot.com
        // YaAllah
        $usernameSend = md5($this->input->server('PHP_AUTH_USER'));  
        $passwordSend = md5($this->input->server('PHP_AUTH_PW'));
        
        if($usernameSend == '1755e99ca881fc22958890d7a41b026b' && $passwordSend == 'fa6b9d534c05016dc660f93daefbf3d0'){
            if(!empty($this->post('name')) && !empty($this->post('cron_duration')) && !empty( $this->post('cron_summary')) && !empty($this->post('type')) ){


                $name       =   $this->post('name');
                $duration   =   $this->post('cron_duration');
                $summary    =   $this->post('cron_summary');
                $type       =   $this->post('type');



                $this->load->library('mongo_db_3');
                $db_3 = $this->mongo_db_3->customQuery();
                $params = [
                    'name' => $name,
                    'cron_duration' 					=> 	$duration,
                    'cron_summary'  					=> 	$summary,
                    'type'          					=> 	$type,
                    'last_updated_time_human_readible'	=> 	date('Y-m-d H:i:s')
                ];
                $whereUpdate['name'] = $name;
                $upsert['upsert'] = true;
                $db_3->cronjob_execution_logs->updateOne($whereUpdate ,['$set' => $params], $upsert);

                $this->set_response($params, REST_Controller::HTTP_CREATED);
            }else{
                $response = array(
                    'response' => 'parameters wrong',
                    'type'    => '404'
                );
                $this->set_response($response, REST_Controller::HTTP_NOT_FOUND);
            }
        }else{
            $response = array(
                'response' => 'Authentication field',
                'type'    => '404'
            );
            $this->set_response($response, REST_Controller::HTTP_NOT_FOUND);
        }
	}//End last_cron_execution_time

    public function search_delete_orderApi_post(){
        // digiebot.com
        // YaAllah
        $usernameSend = md5($this->input->server('PHP_AUTH_USER'));  
        $passwordSend = md5($this->input->server('PHP_AUTH_PW'));
        
        if($usernameSend == '1755e99ca881fc22958890d7a41b026b' && $passwordSend == 'fa6b9d534c05016dc660f93daefbf3d0'){
            if(!empty($this->post('exchange')) && !empty($this->post('order_id')) ){
                $db = $this->mongo_db->customQuery();

                $exchange   =   $this->post('exchange');
                $order_id   =   $this->post('order_id');

                $coll   =   ($exchange == 'binance') ? 'buy_orders' : 'buy_orders_'.$exchange;
                $coll2  =   ($exchange == 'binance') ? 'orders' : 'orders_'.$exchange;


                $order  =   $db->$coll->find(array("_id" => $this->mongo_db->mongoId($order_id)));
                $data   =   iterator_to_array($order);

                $order_craeted_date     =   (string)$data[0]['created_date'];
                $order_craeted          =   $data[0]['created_date'];
                $application_mode       =   $data[0]['application_mode'];


                $current_time   =   (string)$this->mongo_db->converToMongodttime(date('2019-12-27 04:21:59'));
                $collectionName =   ($exchange == 'binance') ? 'orders_history_log' : 'orders_history_log_'.$exchange;

                if ($order_craeted_date > $current_time) {

                    $created    =   $order_craeted->toDateTime()->format("Y-m-d");
                    $timestamp  =   strtotime($created); 
                    $month      =   date("m", $timestamp);
                    $month      =   ($month -1);

                    $fullCollectionName =  $collectionName.'_'.$application_mode.'_'.date("Y", $timestamp).'_'.$month; //log collection name
                     
                } else {

                    $fullCollectionName = ($exchange == 'binance') ? 'orders_history_log' : 'orders_history_log_'.$exchange; //log collection name
                }

                // logs delete
                $searchArray_log['order_id'] = $this->mongo_db->mongoId($order_id);
                $log_delete = $db->$fullCollectionName->deleteMany($searchArray_log);

                // delete order
                $query_buy_remove   =   $db->$coll->deleteOne(array("_id" => $this->mongo_db->mongoId($order_id)));
                $query_sell_remove  =   $db->$coll2->deleteOne(array("buy_order_id" => $this->mongo_db->mongoId($order_id)));

                $response = [
                    'log_Collection'            =>  $fullCollectionName,
                    'logs_delete_Count'         =>  $log_delete->getDeletedCount(),
                    'buy_collection_dlt_count'  =>  $query_buy_remove->getDeletedCount(),
                    'order_collection_dlt_count' =>  $query_sell_remove->getDeletedCount(),
                    'buy_collection_name'       =>  $coll,
                    'order_collection_name'      =>  $coll2,
                   
                ];
                $this->set_response($response, REST_Controller::HTTP_CREATED);
            }else{
                $response = array(
                    'response' => 'parameters wrong',
                    'type'    => '404'
                );
                $this->set_response($response, REST_Controller::HTTP_NOT_FOUND);

            }
        }else{
            $response = array(
                'response' => 'Authentication field',
                'type'    => '404'
            );
            $this->set_response($response, REST_Controller::HTTP_NOT_FOUND);
        }
    }//end controller

    public function getUserAcculation_post(){
        // digiebot.com
        // YaAllah
        $usernameSend = md5($this->input->server('PHP_AUTH_USER'));  
        $passwordSend = md5($this->input->server('PHP_AUTH_PW'));

        if($usernameSend == '1755e99ca881fc22958890d7a41b026b' && $passwordSend == 'fa6b9d534c05016dc660f93daefbf3d0'){
            if(!empty($this->post('admin_id')) &&  !empty($this->post('exchange'))){
                $db = $this->mongo_db->customQuery();

                $exchange   =   $this->post('exchange');
                $admin_id   =   $this->post('admin_id');

                $match = [

                    'exchange' => $exchange,
                    'user_id'  => (string)$admin_id
                ];

                $data     = $db->monthly_accumolution->find($match);
                $response = iterator_to_array($data);


                $response = array(
                    'response' => $response,
                    'type'     => '200',
                );
                $this->set_response($response, REST_Controller::HTTP_CREATED);
            }else{

                $response = array(
                    'response' => 'parameters wrong',
                    'type'    => '404'
                );
                $this->set_response($response, REST_Controller::HTTP_NOT_FOUND);
            }
        }else{

            $response = array(
                'response' => 'Authentication field',
                'type'    => '404'
            );
            $this->set_response($response, REST_Controller::HTTP_NOT_FOUND);
        }
    }//end function

}