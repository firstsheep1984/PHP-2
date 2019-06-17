<!DOCTYPE html>
<html>
    <head>
        <title>Add person</title>
        <link rel="stylesheet" href="styles.css">
    </head>
<body>
    <div id="centerContent">
<?php

require_once 'db.php';

// here-document or "here-doc"
function getForm($nameVal = "", $gpaVal = "", $isGraduateVal = false, $genderVal = "male") {
    // TODO: handle checkbox and radio buttons values coming in
    $isGradChecked = $isGraduateVal ? 'checked' : '';
    $rbMaleChecked = $rbFemaleChecked = $rbOtherChecked = "";
    switch ($genderVal) {
        case "male": $rbMaleChecked = 'checked'; break;
        case "female": $rbFemaleChecked = 'checked'; break;
        case "other": $rbOtherChecked = 'checked'; break;
        default: // $rbOtherChecked = 'checked';
            // FIXME: maybe display error message here
            die("Error: gender value submitted is unrecognized.");
    }
$form = <<< ENDMARKER
<form method="post">
    Name: <input type="text" name="name" value="$nameVal"><br>
    GPA: <input type="number" step="0.01" name="gpa" value="$gpaVal"><br>
    Is graduate? <input type="checkbox" name="isGraduate" value="true" $isGradChecked><br>
    Gender: <input type="radio" name="gender" value="male" $rbMaleChecked>Male</input>
    <input type="radio" name="gender" value="female" $rbFemaleChecked>Female</input>
    <input type="radio" name="gender" value="other" $rbOtherChecked>Other</input><br>
    <input type="submit" value="Add person">
</form>
ENDMARKER;
return $form;
}

// are we receiving form submission?
if (isset($_POST['name'])) {
    $name = $_POST['name'];
    $gpa = $_POST['gpa'];
    $isGraduate = isset($_POST['isGraduate']);
    $gender = $_POST['gender'];
    $errorList = array();
    // TODO: verify values
    if (strlen($name) < 1 || strlen($name) > 50) {
        array_push($errorList, "Name must be 1-50 characters long");
        $name = "";
    }
    if (!is_numeric($gpa) || $gpa < 0 || $gpa > 4.3) {
        array_push($errorList, "GPA must be a number 0 to 4.3");
        $gpa = "";
    }
    //
    if ($errorList) { // array not empty -> errors present
        // STATE 2: Failed submission
        echo "<p>There were problems with your submission:</p>\n<ul>\n";
        foreach ($errorList as $error) {
            echo "<li class=\"errorMessage\">$error</li>\n";
        }
        echo "</ul>\n";
        echo getForm($name, $gpa, $isGraduate, $gender);
    } else {
        // STATE 3: Successful submission
        $result = mysqli_query($link, sprintf("INSERT INTO people VALUES (NULL, '%s', '%s', '%s', '%s')",
            mysqli_real_escape_string($link, $name),
            mysqli_real_escape_string($link, $gpa),
            mysqli_real_escape_string($link, $isGraduate ? 'true' : 'false'),
            mysqli_real_escape_string($link, $gender)));
        if (!$result) {
            echo "SQL Query failed: " . mysqli_error($link);
            exit;
        }
        echo "<p>Person added successfully</p>";
    }
} else { 
    // STATE 1: First show
    echo getForm();
}

?>
    </div>
</body>
</html>


