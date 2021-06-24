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
    'class'    => 'Buy_orders',
    'function' => 'test1',
    'filename' => 'Buy_orders.php',
    'filepath' => 'hooks'
);