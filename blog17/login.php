<!DOCTYPE html>
<html>
    <head>
        <title>Login</title>
        <link rel="stylesheet" href="styles.css">
    </head>
<body>
    <div id="centerContent">
        <?php

require_once 'db.php';

// here-document or "here-doc"
function getForm($usernameVal = "", $emailVal = "") {    
$form = <<< ENDMARKER
<form method="post">
    Username: <input type="text" name="username"><br>
    Password: <input type="password" name="password"><br>
    <input type="submit" value="Login">
</form>
ENDMARKER;
return $form;
}

// are we receiving form submission?
if (isset($_POST['username'])) {
    $username = $_POST['username'];    
    $password = $_POST['password'];
    
    $loginSuccessful = false;
    //
    $result = mysqli_query($link, sprintf("SELECT * FROM users WHERE username='%s'",
            mysqli_real_escape_string($link, $username)));
    if (!$result) {
            echo "SQL Query failed: " . mysqli_error($link);
            exit;
    }
    $user = mysqli_fetch_assoc($result);
    if ($user) {
        if ($user['password'] == $password) {
            $loginSuccessful = true;
        }        
    }    
    //
    if (!$loginSuccessful) { // array not empty -> errors present
        // STATE 2: Failed submission
        echo "<p>Login failed<p>\n";
        echo getForm($username, $email);
    } else {
        // STATE 3: Successful submission
        echo "<p>Login successful</p>";
        echo '<p><a href="index.php">Click to continue</a></p>';
        unset($user['password']); // remove password from array for security reasons
        $_SESSION['user'] = $user;
    }
} else { 
    // STATE 1: First show
    echo getForm();
}

?>
        <p>If you don't have an account <a href="register.php">click here to register</a></p>
    </div>
</body>
</html>



