<?php

session_start();

if (!$link = mysqli_connect('localhost:3333', 'blog17', 'FKr6zA1i2IyvxnKH', 'blog17')) {
    echo 'Could not connect to mysql';
    exit;
}

