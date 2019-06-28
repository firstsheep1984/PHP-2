<?php

session_cache_limiter(false);
session_start();

require_once 'vendor/autoload.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

// create a log channel
$log = new Logger('main');
$log->pushHandler(new StreamHandler('everything.log', Logger::DEBUG));
$log->pushHandler(new StreamHandler('errors.log', Logger::ERROR));

DB::$user = 'todorest17';
DB::$password = '7U8WM9tfAjwU7WKN';
DB::$dbName = 'todorest17';
DB::$encoding = 'utf8';
DB::$port = 3333;

DB::$error_handler = 'database_error_handler';
DB::$nonsql_error_handler = 'database_error_handler';

function database_error_handler($params) {
    global $app, $log;
    $log->error("SQL Error: " . $params['error']);
    if (isset($params['query'])) {
        $log->error("SQL Query: " . $params['query']);
    }
    echo json_encode("500 - internal error");
    http_response_code(500);
    die(); // don't want to keep going if a query broke
}

// Slim creation and setup
$app = new \Slim\Slim();

$app->response()->header('content-type', 'application/json');

\Slim\Route::setDefaultConditions(array(
    'id' => '[1-9][0-9]*',
    'integer'=> '(0|-?[1-9][0-9]*)'
));

function getUserIpAddr() {
    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
        //ip from share internet
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
        //ip pass from proxy
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }else{
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}



$app->get('/todos', function() use ($app, $log) {
    $list = DB::query("SELECT * FROM todos");
    echo json_encode($list, JSON_PRETTY_PRINT);
});

$app->get('/todos/:id', function($id) use ($app, $log) {
    $item = DB::queryFirstRow("SELECT * FROM todos WHERE id=%i", $id);
    if ($item) {
        echo json_encode($item, JSON_PRETTY_PRINT);
    } else {
        $app->response()->setStatus(404);
        echo json_encode("404 - not found");
    }
});

$app->post('/todos', function() use ($app, $log) {
    $json = $app->request()->getBody();
    $todo = json_decode($json, true);
    // FIXME: verify data before inserting
    DB::insert('todos', $todo);
    echo DB::insertId();
});

$app->put('/todos/:id', function($id) use ($app, $log) {
    $json = $app->request()->getBody();
    $todo = json_decode($json, true);
    // FIXME: verify data before inserting
    unset($todo['id']); // prevent changing of record id
    DB::update('todos', $todo, "id=%i", $id);
    echo json_encode(true);
});

$app->delete('/todos/:id', function($id) use ($app, $log) {
    DB::delete('todos', "id=%i", $id);
    echo json_encode(true);
});


$app->run();
