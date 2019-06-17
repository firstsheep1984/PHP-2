<!DOCTYPE html>
<html>
    <head>
        <title>Register</title>
        <link rel="stylesheet" href="styles.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script>
            $(document).ready(function() {
                $('input[name=username]').keyup(function() {
                    var username = $('input[name=username').val();
                    $('#isTaken').load("istaken.php?username=" + username);
                });
            });
        </script>
    </head>
<body>
    <div id="centerContent">
        <?php

require_once 'db.php';

// here-document or "here-doc"
function getForm($usernameVal = "", $emailVal = "") {    
$form = <<< ENDMARKER
<form method="post">
    Username: <input type="text" name="username" value="$usernameVal">
        <span class="errorMessage" id="isTaken"></span><br>
    Email: <input type="text" name="email" value="$emailVal"><br>
    Password <input type="password" name="pass1"><br>
    Password (repeated) <input type="password" name="pass2"><br>
    <input type="submit" value="Register">
</form>
ENDMARKER;
return $form;
}

// are we receiving form submission?
if (isset($_POST['username'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $pass1 = $_POST['pass1'];
    $pass2 = $_POST['pass2'];
    $errorList = array();
    if (preg_match('/^[a-zA-Z0-9_]{6,20}$/', $username) != 1) {
        array_push($errorList, "Username must be 6-20 characters long and only "
                . "consist of uppercase/lowercase letters, digits, and underscores");
        $username = "";
    } else { // check user is not registered yet
        $result = mysqli_query($link, sprintf("SELECT * FROM users WHERE username='%s'",
            mysqli_real_escape_string($link, $username)));
        if (!$result) {
            echo "SQL Query failed: " . mysqli_error($link);
            exit;
        }
        $user = mysqli_fetch_assoc($result);
        if ($user) {
            array_push($errorList, "Username already registered, try a different one");
            $username = "";
        }
    }
    if (filter_var($email, FILTER_VALIDATE_EMAIL) == FALSE) {
        array_push($errorList, "Email does not look valid");
        $email = "";
    }
    if ($pass1 != $pass2) {
        array_push($errorList, "Passwords do not match");        
    } else {
        if ((strlen($pass1) < 6)
                || (preg_match("/[A-Z]/", $pass1) == FALSE )
                || (preg_match("/[a-z]/", $pass1) == FALSE )
                || (preg_match("/[0-9]/", $pass1) == FALSE )) {
            array_push($errorList, "Password must be at least 6 characters long, "
                    . "with at least one uppercase, one lowercase, and one digit in it");
        }
    }
    //
    if ($errorList) { // array not empty -> errors present
        // STATE 2: Failed submission
        echo "<p>There were problems with your submission:</p>\n<ul>\n";
        foreach ($errorList as $error) {
            echo "<li class=\"errorMessage\">$error</li>\n";
        }
        echo "</ul>\n";
        echo getForm($username, $email);
    } else {
        // STATE 3: Successful submission
        echo "<p>Registration successful</p>";
        echo '<p><a href="login.php">Click here to login</a></p>';
        // FIXME: Security hole here!!!! SQL INJECTION
        $result = mysqli_query($link, sprintf("INSERT INTO users VALUES (NULL, '%s', '%s', '%s')",
            mysqli_real_escape_string($link, $username),
            mysqli_real_escape_string($link, $email),
            mysqli_real_escape_string($link, $pass1)));
        if (!$result) {
            echo "SQL Query failed: " . mysqli_error($link);
            exit;
        }
    }
} else { 
    // STATE 1: First show
    echo getForm();
}

?>
    </div>
</body>
</html>
