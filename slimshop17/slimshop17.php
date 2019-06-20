<?php

session_cache_limiter(false);
session_start();

require_once 'vendor/autoload.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

// create a log channel
$log = new Logger('main');
$log->pushHandler(new StreamHandler('logs/everything.log', Logger::DEBUG));
$log->pushHandler(new StreamHandler('logs/errors.log', Logger::ERROR));

DB::$user = 'slimshop17';
DB::$password = 'gptrcBR4JrqAYwfS';
DB::$dbName = 'slimshop17';
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
    $app->render("internal_error.html.twig");
    http_response_code(500);
    die(); // don't want to keep going if a query broke
}

// Slim creation and setup
$app = new \Slim\Slim(array(
    'view' => new \Slim\Views\Twig()
        ));

$view = $app->view();
$view->parserOptions = array(
    'debug' => true,
    'cache' => dirname(__FILE__) . '/cache'
);
$view->setTemplatesDirectory(dirname(__FILE__) . '/templates');

\Slim\Route::setDefaultConditions(array(
    'id' => '[1-9][0-9]*'
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

require_once 'admin.php';

$app->get('/', function() use ($app) {
    $list = DB::query("SELECT * FROM articles");
    $app->render('index.html.twig');
});

$app->get('/internalerror', function() use ($app, $log) {
    $app->render("internal_error.html.twig");
});

$app->get('/forbidden', function() use ($app) {
    $app->render('forbidden.html.twig');
});

$app->get('/isemailregistered/(:email)', function($email = "") use ($app) {
    $user = DB::queryFirstRow("SELECT * FROM users WHERE email=%s", $email);
    if ($user) {
        echo "Email already registered";
    }
});

// STATE 1: first show
$app->get('/register', function() use ($app) {
    $app->render('register.html.twig');
});

$app->post('/register', function() use ($app, $log) {
    $email = $app->request()->post('email');
    $name = $app->request()->post('name');
    $pass1 = $app->request()->post('pass1');
    $pass2 = $app->request()->post('pass2');
    //
    $errorList = array();
    if (filter_var($email, FILTER_VALIDATE_EMAIL) == FALSE) {
        array_push($errorList, "Email invalid");
        $email = "";
    } else {
        // FIXME: Make sure email is not already registered !
    }
    // FIXME: sanitize html tags
    if (strlen($name) < 2 || strlen($name) > 50) {
        array_push($errorList, "Name must be 2-50 characters long");
        $name = "";
    }
    if ($pass1 != $pass2) {
        array_push($errorList, "Passwords do not match");        
    } else {
        if ((strlen($pass1) < 6)
                || (preg_match("/[A-Z]/", $pass1) == FALSE )
                || (preg_match("/[a-z]/", $pass1) == FALSE )
                || (preg_match("/[0-9]/", $pass1) == FALSE )) {
            array_push($errorList, "Password must be at least 6 characters long, "
                    . "with at least one uppercase, one lowercase, and one digit in it");
        }
    }
    if ($errorList) { // STATE 2: failed submission
        $app->render('register.html.twig', array(
            'errorList' => $errorList,
            'v' => array('email' => $email, 'name' => $name)
            ));
    } else { // STATE 3: successful submission
        DB::insert('users', array('email' => $email, 'name' => $name, 'password' => $pass1));
        $userId = DB::insertId();
        $log->debug("User registed with id=" . $userId);
        $app->render('register_success.html.twig');
    }
});

// STATE 1: first show
$app->get('/login', function() use ($app) {
    $app->render('login.html.twig');
});

$app->post('/login', function() use ($app, $log) {
    $email = $app->request()->post('email');
    $password = $app->request()->post('password');
    //
    $loginSuccessful = false;
    $user = DB::queryFirstRow("SELECT * FROM users WHERE email=%s", $email);    
    if ($user) {
        if ($user['password'] == $password) {
            $loginSuccessful = true;
        }        
    }    
    //
    if (!$loginSuccessful) { // array not empty -> errors present
        $log->info(sprintf("Login failed, email=%s, from IP=%s", $email, getUserIpAddr()));
        $app->render('login.html.twig', array('error' => true));
    } else { // STATE 3: successful submission
        unset($user['password']);
        $_SESSION['user'] = $user;
        $log->info(sprintf("Login successful, email=%s, from IP=%s", $email, getUserIpAddr()));
        $app->render('login_success.html.twig');
    }
});

$app->get('/logout', function() use ($app) {
    unset($_SESSION['user']);
    $app->render('logout.html.twig');
});

$app->get('/session', function() {
    echo '<pre>';
    print_r($_SESSION);
});

$app->run();
