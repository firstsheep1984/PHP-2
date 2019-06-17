<?php

if (!$link = mysqli_connect('localhost:3333', 'hello17', 'jL8Bw92vSo7hm2MV', 'hello17')) {
    echo 'Could not connect to mysql';
    exit;
}

// here-document or "here-doc"
function getForm($nameVal = "", $ageVal = "") {
$form = <<< ENDMARKER
<form>
    What is your name? <input type="text" name="name" value="$nameVal"><br>
    What is your age? <input type="number" name="age" value="$ageVal"><br>
    <input type="submit">
</form>
ENDMARKER;
return $form;
}

// are we receiving form submission?
if (isset($_GET['name'])) {
    $name = $_GET['name'];
    $age = $_GET['age'];
    $errorList = array();
    if ($age < 1 || $age > 150) {
        array_push($errorList, "Age must be between 1 and 150");
        $age = "";
    }
    if (strlen($name) < 1 || strlen($name) > 100) {
        array_push($errorList, "Name length must be between 1 and 100");
        $name = "";
    }
    //
    if ($errorList) { // array not empty -> errors present
        // STATE 2: Failed submission
        echo "<p>There were problems with your submission:</p>\n<ul>\n";
        foreach ($errorList as $error) {
            echo "<li>$error</li>\n";
        }
        echo "</ul>\n";
        echo getForm($name, $age);
    } else {
        // STATE 3: Successful submission
        echo "<p>Hi <b>$name</b>, you are $age y/o nice to meet you</p>";
        // FIXME: Security hole here!!!!
        $result = mysqli_query($link, "INSERT INTO people VALUES (NULL, '$name', '$age')");
        if (!$result) {
            echo "SQL Query failed: " . mysqli_error($link);
            exit;
        }
    }
} else { 
    // STATE 1: First show
    echo getForm();
}


