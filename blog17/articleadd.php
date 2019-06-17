<!DOCTYPE html>
<html>
    <head>
        <title>Add article</title>
        <link rel="stylesheet" href="styles.css">
        <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js"></script>
        <script>tinymce.init({selector:'textarea'});</script>
    </head>
<body>
    <div id="centerContent">
<?php

require_once 'db.php';

// only allow access if user is logged in
if (!isset($_SESSION['user'])) {
    echo '<p>Access denied: you must be <a href="login.php">logged in</a> to access this page</p>';
    exit;
}

// here-document or "here-doc"
function getForm($titleVal = "", $bodyVal = "") {    
$form = <<< ENDMARKER
<form method="post">
        Title: <input type="text" name="title" value="$titleVal"><br>
        <textarea cols=60 rows=10 name="body">$bodyVal</textarea><br>
        <input type="submit" value="Add article">
</form>
ENDMARKER;
return $form;
}

// are we receiving form submission?
if (isset($_POST['title'])) {
    $title = $_POST['title'];
    $body = $_POST['body'];
    $errorList = array();
    //
    if (strlen($title) < 5 || strlen($title) > 200) {
        array_push($errorList, "Title must be 5-200 characters long");
    }
    if (strlen($body) < 5 || strlen($body) > 65000) {
        array_push($errorList, "Body must be 5-65000 characters long");
    }
    // FIXME: sanitize body - 1) only allow certain HTML tags, 2) make sure it is valid html
    // $body = stripUnwantedTagsAndAttrs($body);
    $body = strip_tags($body, "<p><ul><li><em><strong><i><b><ol><h3><h4>");
    if ($errorList) { // array not empty -> errors present
        // STATE 2: Failed submission
        echo "<p>There were problems with your submission:</p>\n<ul>\n";
        foreach ($errorList as $error) {
            echo "<li class=\"errorMessage\">$error</li>\n";
        }
        echo "</ul>\n";
        echo getForm($title, $body);
    } else {
        // STATE 3: Successful submission
        echo "<p>Article added successfully</p>";
        echo '<p><a href="index.php">Click here to continue</a></p>';
        //
        $authorId = $_SESSION['user']['id']; // ID of currently logged in user
        $result = mysqli_query($link, sprintf("INSERT INTO articles VALUES (NULL, '%s', NULL, '%s', '%s')",
            mysqli_real_escape_string($link, $authorId),
            mysqli_real_escape_string($link, $title),
            mysqli_real_escape_string($link, $body)));
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

<?php
function stripUnwantedTagsAndAttrs($html_str){
  $xml = new DOMDocument();
//Suppress warnings: proper error handling is beyond scope of example
  libxml_use_internal_errors(true);
//List the tags you want to allow here, NOTE you MUST allow html and body otherwise entire string will be cleared
  $allowed_tags = array("b", "br", "em", "hr", "i", "li", "ol", "p", "span", "table", "tr", "td", "u", "ul", "strong");
//List the attributes you want to allow here
  $allowed_attrs = array ("class", "id", "style");
  if (!strlen($html_str)){return false;}
  if ($xml->loadHTML($html_str, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD)){
    foreach ($xml->getElementsByTagName("*") as $tag){
      if (!in_array($tag->tagName, $allowed_tags)){
        $tag->parentNode->removeChild($tag);
      }else{
        foreach ($tag->attributes as $attr){
          if (!in_array($attr->nodeName, $allowed_attrs)){
            $tag->removeAttribute($attr->nodeName);
          }
        }
      }
    }
  }
  return $xml->saveHTML();
}