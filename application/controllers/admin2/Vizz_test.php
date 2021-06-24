<?php
class Vizz_test extends CI_Controller {
	function __construct() {
		parent::__construct();
	}
	public function index() {
		 $txt = "vizz test hit---  ".date('y-m-d g:i:s');
		$myfile = file_put_contents('/home/digiebot/public_html/app.digiebot.com/custom_cornjobs/cron_logs.txt', $txt . PHP_EOL, FILE_APPEND | LOCK_EX);
	}

}//End of controller

