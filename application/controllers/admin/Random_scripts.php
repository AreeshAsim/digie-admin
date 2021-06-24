<?php 
        
defined('BASEPATH') OR exit('No direct script access allowed');
        
class Random_scripts extends CI_Controller {
    function __construct(){
        parent::__construct();
    }

    // public function print_wallet(){
    //     $db = $this->mongo_db->customQuery();
    //     $resultData = $db->user_wallet_comaprison->aggregate([

    //         ['$lookup' => [ 
    //             'from' => 'users',  
    //             'localField' => 'user_id',
    //             'foreignField'  =>  '_id',
    //             'as'  => 'user_detail',
    //          ]]]);

    //         $myData = array();

    //         foreach($resultData as $result) {
    //         //var_dump($result);
    //         $user = (array)$result['user_detail'];
    //         $user = $user[0];
    //         $data['username'] = $user['username'];
    //         $data['email'] = $user['email_address'];
    //         $data['name'] = $user['first_name']." ".$user['last_name'];
    //         $data['balance'] = (array)$result['balances'];
    //         $data['last_modified'] = $result['modified_date'];
    //         array_push($myData, $data);
    //         }
    //         echo "<pre>";
    //         print_r($myData); 
    //         $file = "report_" . date("Y-m-d") . ".csv";
    //         $this->download_send_headers($file);

    //         echo $this->array2csv($myData);
    
    //         exit;
    
    // }
    
    // public function array2csv($array) {

    //     if (count($array) == 0) {

    //         return null;

    //     }

    //     ob_start();

    //     $df = fopen("php://output", 'w');

    //     fputcsv($df, array_keys((array) reset($array)));

    //     foreach ($array as $row) {

    //         fputcsv($df, (array) $row);

    //     }

    //     fclose($df);

    //     return ob_get_clean();

    // }

    // public function download_send_headers($filename) {

    //     // disable caching

    //     $now = gmdate("D, d M Y H:i:s");

    //     header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");

    //     header("Last-Modified: {$now} GMT");

    //     header("Content-type: application/csv");

    //     header("Pragma: no-cache");

    //     header("Expires: 0");

    //     // force download

    //     header("Content-Type: application/force-download");

    //     header("Content-Type: application/octet-stream");

    //     header("Content-Type: application/download");

    //     // disposition / encoding on response body

    //     header("Content-Disposition: attachment;filename={$filename}");

    //     header("Content-Transfer-Encoding: binary");

    // }
}
        
    /* End of file  Random_scripts.php */
        
