<!DOCTYPE html>
<html>
    <head>
        <title>Article</title>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <div id="centerContent">
            <?php
            require_once 'db.php';

            $articleId = isset($_GET['id']) ? $_GET['id'] : -1;
            $result = mysqli_query($link, sprintf("SELECT articles.id, username, tsPosted, "
                            . "title, body FROM articles, users WHERE articles.authorId = users.id "
                            . "AND articles.id='%s'", mysqli_real_escape_string($link, $articleId)));
            if (!$result) {
                echo "SQL Query failed: " . mysqli_error($link);
                exit;
            }
            $article = mysqli_fetch_assoc($result);
            if ($article) {
                echo "<div class=article>\n";
                echo "<h1>" . $article['title'] . "</h1>\n";
                echo "<h2>Posted by " . $article['username'] . " on " . $article['tsPosted'] . "</h2>\n";
                echo "<div class=articleBody>".$article['body']."</div>";
                echo "</div>\n\n";
            } else { // 404 - not found
                http_response_code(404);
                echo "<p>404 - Article not found <a href=index.php>click to continue</a></p>";
            }
            
            ?>
            <p>To get back to index<a href="register.php">click here</a></p>
        </div>
    </body>
</html>



