<?php

if (!isset($_GET['min']) || !isset($_GET['max'])) {
    die("Error: min and max must be provided");
}

$min = $_GET['min'];
$max = $_GET['max'];

if (!is_numeric($min) || !is_numeric($max)) {
    die("Error: min and max must be non-empty integer values");
}

if ($min > $max) {
    die("Error: minimum must not be greater than maximum");
}

$num = rand($min, $max);
echo $num;
