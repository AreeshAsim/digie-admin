<?php 
/**
* 
*/
class Test extends CI_Controller
{
	
	function __construct()
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
		$this->load->model('admin/mod_users');
		$this->load->model('admin/mod_dashboard');
		$this->load->model('admin/mod_coins');
		$this->load->model('admin/mod_candel');
        $this->load->model('admin/mod_test');
        $this->load->model('admin/mod_box_trigger_3');

	}

	public function index()
	{
		
		$coins = $this->mod_coins->get_all_coins();
		$data['coins'] = $coins; 
        $this->stencil->paint('admin/dashboard/add_candle_setting',$data);
	}

    public function save_setting_process()
    {	
    	
        $post = $this->mod_test->save_setting($this->input->post());
		redirect(base_url().'admin/test/index');
    }

    public function listing()
    {
    	$symbol = $this->session->userdata('global_symbol');

    	$candle = $this->mod_test->get_settings($symbol);
    	$data['candle'] = $candle; 
    	echo "<pre>";
    	print_r($candle);
    	exit;
    }

    public function test_1()
    {
        $global_symbol = $this->session->userdata('global_symbol');

        if(isset($_GET['market_value']) && $_GET['market_value'] !="" && $market_value ==""){

            $market_value = $_GET['market_value'];

        }elseif($market_value !=""){

            $market_value = 0.00000231;

        }else{

            //Get Market Prices
            $market_value = $this->mod_dashboard->get_market_value($global_symbol);
        }


        ///////////////////////////////////////
        $db = $this->mongo_db->customQuery();
        $priceAsk = (float)$market_value;

        $pipeline = array(
            array(
                '$project' => array(
                    "price" => 1,
                    "quantity"=>1,
                    "type"=>1,
                    "coin"=>1,
                    'created_date'=>1
                )
            ),

            array(
                '$match' => array(
                    'coin'=> $global_symbol,
                    'type'=> 'ask',
                    'price' => array('$gte'=>$priceAsk)
                )
            ),

            array('$sort'=>array('created_date'=>-1)),
            // array('$sort'=>array('price'=>1)),
            array('$group' => array(
                '_id' => array('price' => '$price'),
                'quantity'    => array('$first' => '$quantity'),
                'type'    => array('$first' => '$type'),
                'coin'    => array('$first' => '$coin'),
                'created_date'    => array('$first' => '$created_date'),
                'price'    => array('$first' => '$price'),
            ),

            ),
            array('$sort'=>array('price'=>1)),
            array('$limit'=>20),
        );

        $allow = array('allowDiskUse'=>true);
        $responseArr = $db->market_depth->aggregate($pipeline,$allow);

        $fullarray = array();
        foreach ($responseArr as  $valueArr) {

            $returArr = array();

            if(!empty($valueArr)){

                $datetime = $valueArr['created_date']->toDateTime();
                $created_date = $datetime->format(DATE_RSS);

                $datetime = new DateTime($created_date);
                $datetime->format('Y-m-d g:i:s A');

                $new_timezone = new DateTimeZone('Asia/Karachi');
                $datetime->setTimezone($new_timezone);
                $formated_date_time =  $datetime->format('Y-m-d g:i:s A');

                $returArr['_id'] = $valueArr['_id'];
                $returArr['price'] = $valueArr['price'];
                $returArr['quantity'] = $valueArr['quantity'];
                $returArr['type'] = $valueArr['type'];
                $returArr['coin'] = $valueArr['coin'];
                $returArr['created_date'] = $formated_date_time;
            }

            $fullarray[]= $returArr;
        }

        $sort = array();
        foreach($fullarray as $k=>$v) {
            $sort['price'][$k] = $v['price'];
        }
        array_multisort($sort['price'], SORT_DESC, $fullarray);


        $data['market_value'] = $market_value;
        $data['fullarray'] = $fullarray;

        echo "<pre>";
        print_r($data);
        exit;

    }

    public function test_2()
    {
        $global_symbol = $this->session->userdata('global_symbol');

        if(isset($_GET['market_value']) && $_GET['market_value'] !="" && $market_value ==""){

            $market_value = $_GET['market_value'];

        }elseif($market_value !=""){

            $market_value = 0.00000231;

        }else{

            //Get Market Prices
            $market_value = $this->mod_dashboard->get_market_value($global_symbol);
        }


        ///////////////////////////////////////
        $db = $this->mongo_db->customQuery();
        $priceAsk = (float)$market_value;

        $pipeline = array(
           /* array(
                '$project' => array(
                    "price" => 1,
                    "quantity"=>1,
                    "type"=>1,
                    "coin"=>1,
                    'created_date'=>1
                )
            ),*/

            array(
                '$match' => array(
                    'coin'=> $global_symbol,
                    'type'=> 'ask',
                    'price' => array('$gte'=>$priceAsk)
                )
            ),

            array('$sort'=>array('created_date'=>-1)),
            // array('$sort'=>array('price'=>1)),
           /* array('$group' => array(
                '_id' => array('price' => '$price'),
                'quantity'    => array('$first' => '$quantity'),
                'type'    => array('$first' => '$type'),
                'coin'    => array('$first' => '$coin'),
                'created_date'    => array('$first' => '$created_date'),
                'price'    => array('$first' => '$price'),
            ),

            ),*/
            array('$sort'=>array('price'=>1)),
            array('$limit'=>20),
        );

        $allow = array('allowDiskUse'=>true);
        $responseArr = $db->market_depth->aggregate($pipeline,$allow);

        $fullarray = array();
        foreach ($responseArr as  $valueArr) {

            $returArr = array();

            if(!empty($valueArr)){

                $datetime = $valueArr['created_date']->toDateTime();
                $created_date = $datetime->format(DATE_RSS);

                $datetime = new DateTime($created_date);
                $datetime->format('Y-m-d g:i:s A');

                $new_timezone = new DateTimeZone('Asia/Karachi');
                $datetime->setTimezone($new_timezone);
                $formated_date_time =  $datetime->format('Y-m-d g:i:s A');

                $returArr['_id'] = $valueArr['_id'];
                $returArr['price'] = $valueArr['price'];
                $returArr['quantity'] = $valueArr['quantity'];
                $returArr['type'] = $valueArr['type'];
                $returArr['coin'] = $valueArr['coin'];
                $returArr['created_date'] = $formated_date_time;
            }

            $fullarray[]= $returArr;
        }

        $sort = array();
        foreach($fullarray as $k=>$v) {
            $sort['price'][$k] = $v['price'];
        }
        array_multisort($sort['price'], SORT_DESC, $fullarray);


        $data['market_value'] = $market_value;
        $data['fullarray'] = $fullarray;

        echo "<pre>";
        print_r($data);
        exit;

    }


    public function test(){


       //  $triggers_type = 'box_trigger_3';



    
       // $this->mongo_db->where('triggers_type', $triggers_type);
       //  $response_obj = $this->mongo_db->get('trigger_global_setting');
       //  $response_arr = iterator_to_array($response_obj);
       //  $response = array();
       //  if (count($response_arr) > 0) {
       //      $aggressive_stop_rule = $response_arr[0]['aggressive_stop_rule'];
       //      if($aggressive_stop_rule  == 'stop_loss_rule_2'){   
                
       //      }
       //      $cancel_trade = $response_arr[0]['cancel_trade'];//cancel
       //  }


       //  exit();





        $date = '2018-04-29 4:00:00';
        $this->mod_box_trigger_3->create_box_trigger_3_setting($date);
        $buy_Message = $this->mod_box_trigger_3->create_new_orders_by_Box_Trigger_3_simulator($date);
        $sell_Message = $this->mod_box_trigger_3->sell_order_box_trigger_3_samulater($date);
        $this->mod_box_trigger_3->aggrisive_define_percentage_followup($date);
        $this->mod_box_trigger_3->cancel_wait_for_buy_orders($date);
        exit();


        $db = $this->mongo_db->customQuery();
        $res = $db->orders->deleteMany(array('trigger_type' => 'box_trigger_3', 'application_mode' => 'test'));
        echo '<pre>';
        print_r($res);

        $mongoId = $this->mongo_db->mongoId('5b606b00819e126d9935c8e4');
        $db = $this->mongo_db->customQuery();
        $res = $db->orders->count();
        echo '<pre>';
        print_r($res);
        //exit();

        $response = $db->orders->find(array('_id'=>$mongoId));

        echo '<pre>';
        print_r(iterator_to_array($response));
        exit();

        // $mongoId = $this->mongo_db->mongoId('5b606aef819e126c69352992');
        // $db = $this->mongo_db->customQuery();
        // $response = $db->buy_orders->find(array('symbol','NCASHBTC'));

        $response= $this->mongo_db->get('buy_orders');

        echo '<pre>';
        print_r(iterator_to_array($response));
        exit();
    }

    public function quarter(){
        return  array('H:00:00'=>'H:14:59','H:15:00'=>'H:29:59','H:30:00'=>'H:44:59','H:45:00'=>'H:59:59');
    }//End of quarter

    public function run(){

        $quarter_arr = $this->quarter();

        foreach ($quarter_arr as $start_date => $end_date) {
           echo  $start_second =  (date("Y-m-d ".$start_date,strtotime('-1 hour')));
           echo '<br>';


           echo  $start_second =  (date("Y-m-d ".$end_date,strtotime('-1 hour')));
           echo '<br>';
        }

        exit();
        $date = 'H:10:00';
        $start_second =  (date("Y-m-d ".$date,strtotime('-1 hour')));
        echo $start_second;
        echo '<br>';
        echo  '$start_second'.$start_second =  (date("Y-m-d H:29:59",strtotime('-1 hour')));
        exit();
                    
        $prevouse_date = date('Y-m-d H:00:00', strtotime('-1 hour', strtotime($date)));

        echo $prevouse_date;
        exit();




        echo 'start date'.date('y-m-t H:i:s');
        echo '<br>';

        $start_second =  strtotime(date("Y-m-d H:15:00",strtotime('-1 hour')));
        $end_second   =  strtotime(date("Y-m-d H:29:59",strtotime('-1 hour')));
            $current_date  = date("Y-m-d H:00:00",strtotime('-1 hour'));

      
            
            $start_milli_second = $start_second*1000;
            $end_milli_second   = $end_second*1000;

            $start_milli_second_obj = new MongoDB\BSON\UTCDateTime($start_milli_second); 
            $end_milli_second_obj = new MongoDB\BSON\UTCDateTime($end_milli_second);



            $current_date_milli_second = $current_date*1000;
            $current_date_milli_second_obj = new MongoDB\BSON\UTCDateTime($current_date_milli_second); 


            $pipeline = array(
            '$group'=>array('_id'=>'$price','quantity'=>array('$sum'=>'$quantity'),
            'maker'    => array('$first' => '$maker'),
            'coin'    => array('$first' => '$coin'),
            'created_date'    => array('$first' => '$created_date'),
            'price'    => array('$first' => '$price'),
            ),
            );

            $project =  array(
            '$project' => array(
            "_id" => 1,
            "price" => 1,
            "quantity"=>1,
            "maker"=>1,
            "coin"=>1,
            'created_date'=>1
            )
            );

        $coin_symbol = 'NCASHBTC';
        $match = array(
        '$match' => array(
        'coin'=> $coin_symbol,
        'maker'=>'false',
        'created_date' => array('$gte'=>$start_milli_second_obj,
        '$lte'=> $end_milli_second_obj)
        )
        );

        $connect = $this->mongo_db->customQuery();
        $market_history_Arr = $connect->market_trades->aggregate(array($project,$match,$pipeline));

        $market_history_Arr = iterator_to_array($market_history_Arr);


        echo '<pre>';
        print_r($market_history_Arr);
        exit();



        foreach ($market_history_Arr as $key => $value) {
                $type = 'ask';

                if($value['maker'] =='true'){
                $type = 'bid';
                }

                $insert_array = array(
                'coin'=>$value['coin'],
                'hour'=>$current_date,
                'hour_timestamp'=>$current_date_milli_second,
                'price'=>(float)$value['price'],
                'volume'=>(float)$value['quantity'],
                'timestamp'=>$value['created_date'],
                'type'=>$type,
                'maker'=>$value['maker']
                );

        }

        echo '<pre>';
        print_r($insert_array);
         echo 'end date'.date('y-m-t H:i:s');
        echo '<br>';

    }//end of  Fucntion


}
?>

