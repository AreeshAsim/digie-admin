<?php 
/**
 * 
 */
class Migrate_db_controller extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if ( ! is_php('5.4'))
		{
			echo "Hi";
		}
		else
		{
			echo "Hello";
		}
	}
}
?>