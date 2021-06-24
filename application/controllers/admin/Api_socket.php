<?php

/**
 *
 */
class API_Socket extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        if (!defined('SOCKET_ADDRESS')) {
            define('SOCKET_ADDRESS', '50.28.36.14');
        }

        if (!defined('SOCKET_PORT')) {
            define('SOCKET_PORT', '5888');
        }

        if (!defined('MAX_CLIENTS')) {
            define('MAX_CLIENTS', '10');
        }
        set_time_limit(0);

        $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        socket_set_option($socket, SOL_SOCKET, SO_REUSEADDR, 1);
        socket_bind($socket, SOCKET_ADDRESS, SOCKET_PORT) or die('Could not bind to address ' . SOCKET_ADDRESS . ' on port ' . SOCKET_PORT . "!\n");
        socket_listen($socket, MAX_CLIENTS) or die("Could not setup socket listener!\n");

        // setup read socket array
                $read = array();

        // client array w/ default initial socket
                $clients = array('0' => array('socket' => $socket));

        // force debug at first run..
        $debug = true;
        $time = time();
        printf('Time: %d%s', $time, "\n");
        $status = true;
        while ($status) {

            if (time() - $time >= 10) {
                $time = time();
                printf('Time: %d%s', $time, "\n");
                $debug = true;
            }
            if ($debug === true) {
                printf('Debug: %s%s', $debug, "\n");
            }
            // $read[0] = $socket;
            if ($debug) {
                var_dump($read);
            }

            // Handle clients
            for ($i = 0; $i < count($clients); $i++) {
                if (isset($clients[$i]['socket'])) {
                    if ($debug === true) {
                        printf('Setting socket %d to client %d%s', $i, $i, "\n");
                    }
                    $read[$i] = $clients[$i]['socket'];
                }
            }
            if ($debug) {
                var_dump($read);
            }
            // Any changed sockets?
            // $write and $except are only placeholders
            $changed_sockets = socket_select($read, $write = NULL, $except = NULL, 0);
            if ($debug === true) {
                printf('Changed sockets: %d%s', $changed_sockets, "\n");
            }
            // Handle new connections
            if (in_array($socket, $read)) {
                for ($i = 0; $i < MAX_CLIENTS; $i++) {
                    if (!isset($clients[$i])) {
                        $clients[$i]['socket'] = socket_accept($socket);
                        socket_getpeername($clients[$i]['socket'], $ip);
                        $clients[$i]['ip'] = $ip;
                        printf('Accepting connection into client %d from %s%s', $i, $ip, "\n");
                        break;
                    }
                    // } elseif($i == MAX_CLIENTS - 1) {
                    // echo 'Too many clients connected!', "\n";
                    // }
                    if ($changed_sockets < 1) {
                        continue;
                    }
                }
            }
            if ($debug) {
                var_dump($clients);
            }

            for ($i = 0; $i < count($clients); $i++) {
                $client = $clients[$i];
                // Has our client socket seen any changes?
                if (in_array($client['socket'], $read)) {
                    printf('Client %d has changed! Reading...%s', $i, "\n");
                    $data = socket_read($client['socket'], 1024);
                    if ($data === false) {
                        $error = socket_strerror(socket_last_error());
                        printf('An error occured...%s%s', $error, "\n");
                    }
                    printf("Read raw data %s from client %i%s", $data, $i, "\n");
                    if ($data === null) {
                        // disconnected
                        unset($clients[$i]);
                    }

                    $data = trim($data);
                    if ($data == 'Q') {
                        printf('Received exit command from client%s', "\n");
                        socket_close($clients[$i]['socket']);
                        $status = false;
                    } elseif ($data) {
                        // Strip whitespace
                        printf('Received data: %s from client %d%s', $data, $i, "\n");
                        $output = sprintf('%s%s%s', $data, "\n", chr(0));
                        socket_write($client['socket'], $output);
                    }
                }
            }

            // reset debug
            $debug = false;
        }

        socket_close($socket);
    }
}
