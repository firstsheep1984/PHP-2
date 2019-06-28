<?php

require_once 'vendor/autoload.php';
session_start();

//Prevent browser caching
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
//Internationlization
use Symfony\Bridge\Twig\Extension\TranslationExtension;
use Symfony\Component\Translation\Loader\PhpFileLoader;
use Symfony\Component\Translation\MessageSelector;
use Symfony\Component\Translation\Translator;

// create a log channel
$log = new Logger('main');
$log->pushHandler(new StreamHandler('logs/everything.log', Logger::DEBUG));
$log->pushHandler(new StreamHandler('logs/errors.log', Logger::ERROR));

//Define Constants
define("PRODUCTSPERPAGE", 4);
define("ROWSPERPAGE", 5);
define("MAXPAGES", 3);

define("TAX", 0.15);

if ($_SERVER['SERVER_NAME'] == 'localhost') {

    DB::$dbName = 'ecommerce';
    DB::$user = 'root';
    DB::$password = '';
   // DB::$host = 'localhost:3333'; // sometimes needed on Mac OSX
} else { // hosted on external server
    require_once 'fbauth.php';
    DB::$dbName = 'cp4724_fastfood-online';
    DB::$user = 'cp4724_fastfood';
    DB::$password = '[^)EJ;Fw%402';
}

DB::$encoding = 'utf8'; // defaults to latin1 if omitted
DB::$error_handler = 'sql_error_handler';
DB::$nonsql_error_handler = 'nonsql_error_handler';

function nonsql_error_handler($params) {
    global $app, $log;
    $log->error("Database error: " . $params['error']);
    http_response_code(500);
    $app->render('error_internal.html.twig');
    die;
}

function sql_error_handler($params) {
    global $app, $log;
    $log->error("SQL error: " . $params['error']);
    $log->error(" in query: " . $params['query']);
    http_response_code(500);
    $app->render('error_internal.html.twig');
    die; // don't want to keep going if a query broke
}

$app = new \Slim\Slim(array(
    'view' => new \Slim\Views\Twig()
        ));

$view = $app->view();

$view->parserOptions = array(
    'debug' => true,
    'cache' => dirname(__FILE__) . '/cache'
);
$view->setTemplatesDirectory(dirname(__FILE__) . '/templates');

if ($_SERVER['SERVER_NAME'] != 'localhost') {
//sessions and Cookies
    $helper = $fb->getRedirectLoginHelper();
    $permissions = ['public_profile', 'email', 'user_location']; // optional
    $loginUrl = $helper->getLoginUrl('http://fastfood-online.ipd8.info/fblogin-callback.php', $permissions);
    $logoutUrl = $helper->getLoginUrl('http://fastfood-online.ipd8.info/fblogout-callback.php', $permissions);
}
if (!isset($_SESSION['user'])) {
    $_SESSION['user'] = array();
}
if (!isset($_SESSION['facebook_access_token'])) {
    $_SESSION['facebook_access_token'] = array();
}

function getLang() {
    $lang = 'en';
    if (!isset($_GET['lang'])) {
        if (isset($_COOKIE['lang'])) {
            $lang = $_COOKIE['lang'];
        } else {
            setcookie('lang', $lang, time() + 60 * 60 * 24 * 30);
        }
    } else {
        $lang = (string) $_GET['lang'];
        if ($lang == 'en' || $lang == 'fr') {
            setcookie('lang', $lang, time() + 60 * 60 * 24 * 30);
        } else {
            setcookie('lang', "en", time() + 60 * 60 * 24 * 30);
            $lang = 'en';
        }
    }
    return $lang;
}

// First param is the "default language" to use.
$translator = new Translator(getLang(), new MessageSelector());
// Set a fallback language incase you don't have a translation in the default language
$translator->setFallbackLocales(['en']);
// Add a loader that will get the php files we are going to store our translations in
$translator->addLoader('php', new PhpFileLoader());
// Add language files here

$translator->addResource('php', './lang/fr_CA.php', 'fr'); // French
$translator->addResource('php', './lang/en_US.php', 'en'); // English
// Add the parserextensions TwigExtension and TranslationExtension to the view
$view->parserExtensions = array(
    new \Slim\Views\TwigExtension(),
    new TranslationExtension($translator)
);
$twig = $app->view()->getEnvironment();
if ($_SERVER['SERVER_NAME'] != 'localhost') {
    $twig->addGlobal('fbUser', $_SESSION['facebook_access_token']);
    $twig->addGlobal('loginUrl', $loginUrl);
}
$twig->addGlobal('user', $_SESSION['user']);


//FIXME: VAlidate all parameters
\Slim\Route::setDefaultConditions(array(
    'ID' => '\d+',
    'slug' => '[A-Za-z0-9-]+',
    'isVegetarian' => '[0,1]{2}',
    'pageNum' => '\d+',
));

//Handler for the home page
$app->get('/', function() use ($app, $log) {
    //if a fb user than check id does already have a record in the users table, 
    if ($_SESSION['facebook_access_token']) {
        $userID = DB::queryFirstField('SELECT ID from users WHERE fbID = %s', $_SESSION['facebook_access_token']['ID']);
        if (!$userID) {
            $result = DB::insert('users', array(
                        'fbID' => $_SESSION['facebook_access_token']['ID'],
            ));
            if ($result) {
                $userID = DB::insertId();
                $log->debug(sprintf("Regisetred fbUsere %s with id %s", $_SESSION['facebook_access_token']['ID'], $userID));
                $_SESSION['facebook_access_token']['userID'] = $userID;
            } else {
                //add the userId to the fbUser session for convenience
                $log->debug(sprintf("Failed to register fbUsere %d", $_SESSION['facebook_access_token']['ID']));
                $_SESSION['facebook_access_token'] = null;
                $app->render('fblogin_failed.html.twig');
            }
        } else {
            $_SESSION['facebook_access_token']['userID'] = $userID;
        }
    }
    $categoryList = DB::query('SELECT * FROM productcategory WHERE lang=%s', getLang());

    $app->render('index.html.twig', array(
        'categoryList' => $categoryList));
});

//Ajax -> refresh products by filter
$app->get('/category/:categoryID/:isVeget/page/:pageNum', function($categoryID, $isVeget, $pageNum) use ($app) {
    $start = ((int) $pageNum - 1) * PRODUCTSPERPAGE;
    $isVegetSql = ($isVeget == 1) ? 'AND isVegetarian = 1' : '';
    $prodList = DB::query('SELECT products.ID, name, description, price, picture, products_i18n.slugname '
                    . 'FROM products, products_i18n '
                    . 'WHERE products.ID = products_i18n.productID AND '
                    . 'lang=%s' . $isVegetSql . ' AND productCategoryID = %d ORDER BY products.ID DESC LIMIT %d, %d'
                    , getLang(), $categoryID, $start, PRODUCTSPERPAGE * MAXPAGES);
    $availableRecords = DB::count();
    $maxPages = round($availableRecords / PRODUCTSPERPAGE);
    $pageProductList = array();
    if (count($prodList) < PRODUCTSPERPAGE) {
        $pageProductList = $prodList;
        $maxPages = 0;
    } else {
        for ($x = 0; $x < PRODUCTSPERPAGE; $x++) {
            $pageProductList[$x] = $prodList[$x];
        }
    }
    foreach ($pageProductList as &$product) {
        $ID = $product['ID'];
        $product['picture'] = base64_encode($product['picture']);
        $ID = $product['ID'];
        $average = DB::queryFirstField('SELECT avg(rating) as average FROM ratingsreviews WHERE rating >0 AND productID=%d ORDER BY productID', $ID);
        $totalReviews = DB::queryFirstField('SELECT count(review) as totalReviews FROM ratingsreviews WHERE productID=%d ORDER BY productID', $ID);
        $product['totalReviews'] = $totalReviews;
        $product['stars'] = round($average);
    }
    // print_r($prodList['']);
    $pagination = array('min' => max(($pageNum - MAXPAGES - 1), 1), 'max' => $maxPages, 'current' => $pageNum);
    $app->render('index-products.html.twig', array('prodList' => $pageProductList, 'pag' => $pagination));
});

require_once 'product.php';
require_once 'cart.php';
require_once 'login.php';
require_once 'register.php';
require_once 'resetPassword.php';
require_once 'admin.php';

$app->run();
