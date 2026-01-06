<?php

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

require 'vendor/autoload.php';
require 'sudokuServer.php';

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new SudokuServer()
        )
    ),
    8080
);

$server->run();
