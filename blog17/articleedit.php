<!DOCTYPE html>
<html>
    <head>
        <title>Edit article</title>
        <link rel="stylesheet" href="styles.css">
        <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js"></script>
        <script>tinymce.init({selector: 'textarea'});</script>
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

            $articleId = isset($_GET['id']) ? $_GET['id'] : -1;

// here-document or "here-doc"
            function getForm($titleVal = "", $bodyVal = "") {
                $form = <<< ENDMARKER
<form method="post">
        Title: <input type="text" name="title" value="$titleVal"><br>
        <textarea cols=60 rows=10 name="body">$bodyVal</textarea><br>
        <input type="submit" value="Update article">
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
                    echo "<p>Article updated successfully</p>";
                    echo '<p><a href="index.php">Click here to continue</a></p>';
                    //
                    $authorId = $_SESSION['user']['id']; // ID of currently logged in user
                    $result = mysqli_query($link, sprintf("UPDATE articles SET title='%s', body='%s' WHERE id='%s'",
                            mysqli_real_escape_string($link, $title),
                            mysqli_real_escape_string($link, $body),
                            mysqli_real_escape_string($link, $articleId)));
                    if (!$result) {
                        echo "SQL Query failed: " . mysqli_error($link);
                        exit;
                    }
                }
            } else {
                // STATE 1: First show    
                $result = mysqli_query($link, sprintf("SELECT articles.id, username, tsPosted, "
                                . "title, body FROM articles, users WHERE articles.authorId = users.id "
                                . "AND articles.id='%s'", mysqli_real_escape_string($link, $articleId)));
                if (!$result) {
                    echo "SQL Query failed: " . mysqli_error($link);
                    exit;
                }
                $article = mysqli_fetch_assoc($result);
                if ($article) {
                    echo "<p>Posted by " . $article['username'] . " on " . $article['tsPosted'] . "</p>\n";                    
                    echo getForm($article['title'], $article['body']);
                } else { // 404 - not found
                    http_response_code(404);
                    echo "<p>404 - Article not found <a href=index.php>click to continue</a></p>";
                }
            }
            ?>
        </div>
    </body>
</html>

