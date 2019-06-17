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
            if (isset($_SESSION['user'])) {
                $user = $_SESSION['user'];
                echo "<p>You are logged in as " .$user['username'] .
                        ". You may <a href=articleadd.php>post a new article</a>."
                        . " or <a href=logout.php>log out</a>.</p>";
            } else {
                echo "<p>You are NOT logged in. You may <a href=login.php>log in</a>"
                . " or <a href=register.php>register</a></p>";
            }
            //
            $result = mysqli_query($link,"SELECT articles.id, username, tsPosted, "
                    . "title, body FROM articles, users WHERE articles.authorId = users.id");
            if (!$result) {
                echo "SQL Query failed: " . mysqli_error($link);
                exit;
            }
            
            while ($article = mysqli_fetch_assoc($result)) {
                echo "<div class=article>\n";
                echo "<a href=article.php?id=".$article['id']."><h1>" . $article['title'] . "</h1></a>\n";
                echo "<h2>Posted by " . $article['username'] . " on " . $article['tsPosted'] . "</h2>\n";
                $text = strip_tags($article['body']);
                if (strlen($text) > 50) {
                    $text = substr($text, 0, 50) . "...";
                }
                echo "<p>$text</p>";
                echo "</div>\n\n";
            }
            
        ?>
    </div>
    </body>
</html>
