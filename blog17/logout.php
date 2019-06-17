<!DOCTYPE html>
<html>
    <head>
        <title>Logout</title>
        <link rel="stylesheet" href="styles.css">
    </head>
<body>
    <div id="centerContent"><?php

        require_once 'db.php';

        unset($_SESSION['user']);
    ?>
        <p>You've been logged out. <a href="index.php">Click here to continue</a></p>
    </div>
</body>
</html>


