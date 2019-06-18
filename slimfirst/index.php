<?php

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
    DB::insert('people', array('name' => $name, 'age' => $age));
    $app->render('hello.html.twig', array('nameQQQ' => $name, 'ageQQQ' => $age));
    // echo "<p>Hello, $name, you are $age y/o</p>\n";
});

$app->run();
