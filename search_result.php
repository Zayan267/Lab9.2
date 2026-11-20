<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Car search results">
    <meta name="keywords" content="cars, search results, MySQL, PHP">
    <meta name="author" content="zayan">
    <title>Search Results</title>
    <style>
        body { font-family: Arial, Helvetica, sans-serif; margin: 2rem; color: #222; }
        table { border-collapse: collapse; width: 100%; max-width: 40rem; }
        th, td { border: 1px solid #999; padding: 0.5rem 0.75rem; text-align: left; }
        th { background: #1f3a5f; color: #fff; }
        tr:nth-child(even) td { background: #f0f3f7; }
    </style>
</head>
<body>
    <h1>Search Results</h1>
<?php
    require_once "settings.php";

    $conn = @mysqli_connect($host, $user, $pwd, $sql_db);

    if ($conn) {
        if (isset($_GET['model']) && trim($_GET['model']) != "") {
            // Sanitise the input to prevent SQL injection
            $model = mysqli_real_escape_string($conn, trim($_GET['model']));
            $sql = "SELECT * FROM cars WHERE model LIKE '%$model%'";
            $result = mysqli_query($conn, $sql);

            if ($result && mysqli_num_rows($result) > 0) {
                echo "<table>";
                echo "<tr><th>ID</th><th>Make</th><th>Model</th><th>Price</th><th>Year</th></tr>";
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['car_id'] . "</td>";
                    echo "<td>" . $row['make'] . "</td>";
                    echo "<td>" . $row['model'] . "</td>";
                    echo "<td>" . $row['price'] . "</td>";
                    echo "<td>" . $row['yom'] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
                mysqli_free_result($result);
            } else {
                echo "<p>No matching cars found.</p>";
            }
        } else {
            echo "<p>Please enter a model to search.</p>";
        }
        mysqli_close($conn);
    } else {
        echo "<p>Unable to connect to the db.</p>";
    }
?>
    <p><a href="search_form.php">Search again</a></p>
</body>
</html>