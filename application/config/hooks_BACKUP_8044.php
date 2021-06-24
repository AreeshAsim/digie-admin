<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|    https://codeigniter.com/user_guide/general/hooks.html
|
 */
// $hook['pre_controller'] = array(
//     'class' => 'InhibitorHook',
//     'function' => 'error_catcher',
//     'filename' => 'Inhibitor_hook.php',
//     'filepath' => 'hooks',
// );


$hook['pre_controller'] = array(
<<<<<<< HEAD
    'class'    => 'Rule_calls',
    'function' => 'test',
    'filename' => 'Rule_calls.php',
=======
    'class'    => 'Buy_orders',
    'function' => 'test1',
    'filename' => 'Buy_orders.php',
>>>>>>> d0efb23021bda2460e28d530d3fffa3450e0d326
    'filepath' => 'hooks'
);
