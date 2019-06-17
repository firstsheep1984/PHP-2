<?php

session_start();

if (!$link = mysqli_connect('localhost:3333', 'people17', 'qhNEeO4sKOJzPdFM', 'people17')) {
    echo 'Could not connect to mysql';
    exit;
}
