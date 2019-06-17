<?php

require_once 'db.php';

$username = $_GET['username'];

$result = mysqli_query($link, sprintf("SELECT * FROM users WHERE username='%s'",
        mysqli_real_escape_string($link, $username)));
if (!$result) {
    echo "SQL Query failed: " . mysqli_error($link);
    exit;
}
$user = mysqli_fetch_assoc($result);
if ($user) {
    echo "Username already registered, try a different one";
}
