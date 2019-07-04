<?php

session_cache_limiter(false);
session_start();

require_once 'vendor/autoload.php';

DB::$user = 'slimfirst17';
DB::$password = '7kgFnax1b5l6HOiT';
DB::$dbName = 'slimfirst17';
DB::$encoding = 'utf8';
DB::$port = 3333;

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


$app->get('/hello/:name', function ($name) {
    echo "Hello, $name";
});

$app->get('/hello/:name/:age', function ($name, $age) use ($app) {
    DB::insert('peopleZZZZ', array('name' => $name, 'age' => $age));
    $app->render('hello.html.twig', array('nameQQQ' => $name, 'ageQQQ' => $age));
    // echo "<p>Hello, $name, you are $age y/o</p>\n";
});

// STATE 1: first show
$app->get('/people/add', function() use ($app) {
    $app->render('people_add.html.twig');
});

$app->post('/people/add', function() use ($app) {
    $name = $app->request()->post('name');
    $age = $app->request()->post('age');
    //
    $errorList = array();
    if (strlen($name) < 2 || strlen($name) > 100) {
        array_push($errorList, "Name must be 2-100 characters long");
        $name = "";
    }
    if ($age == '' || $age < 0 || $age > 150) {
        array_push($errorList, "Age must be within 0-150 range");
        $age = "";
    }
    //
    if ($errorList) { // STATE 2: failed submission
        $app->render('people_add.html.twig', array(
            'errorList' => $errorList,
            'v' => array('name' => $name, 'age' => $age)
            ));
    } else { // STATE 3: successful submission
        DB::insert('people', array('name' => $name, 'age' => $age));
        $app->render('people_add_success.html.twig');
    }
});

$app->run();
