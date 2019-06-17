<!DOCTYPE html>
<html>
    <head>
        <title>People list</title>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <div id="centerContent">
            <?php
            require_once 'db.php';
            $result = mysqli_query($link, "SELECT * FROM people");
            if (!$result) {
                echo "SQL Query failed: " . mysqli_error($link);
                exit;
            }
            echo "<table border=1>\n";
            echo "<tr><th>#</th><th>Name</th><th>GPA</th><th>graduate?</th><th>Gender</th></tr>\n";
            while ($person = mysqli_fetch_assoc($result)) {
                echo "<tr><td>" . $person['id'] . "</td>";
                echo "<td>" . $person['name'] . "</td>";
                echo "<td>" . $person['gpa'] . "</td>";
                echo "<td>" . ($person['isGraduate']=='true' ? "graduate" : "undergraduate") . "</td>";
                echo "<td>" . $person['gender'] . "</td></tr>\n";
            }
            echo "</table>\n\n";
            ?>
        </div>
    </body>
</html>


