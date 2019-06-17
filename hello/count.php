<?php

session_start();

if (!isset($_SESSION['count'])) {
    $_SESSION['count'] = 0;
}

$_SESSION['count']++;

echo "You've visited this page " . $_SESSION['count'] . " times";


$v = false;

echo "   true is $v";
