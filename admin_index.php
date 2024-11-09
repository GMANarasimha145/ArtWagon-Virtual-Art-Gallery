<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4; /* Light background color */
            margin: 0;
            padding: 20px;
        }

        h2, h3 {
            color: #333; /* Dark color for headings */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: #d4edda; /* Light green background color for tables */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Box shadow for tables */
        }

        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ccc; /* Border color */
        }

        th {
            background-color: #c3e6cb; /* Light green background color for table headers */
        }
    </style>
</head>
<body>
    <?php
    session_start();

    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Check if username and password are correct
        if ($_POST['username'] === 'admin' && $_POST['password'] === 'admin@123') {
            // Authentication successful, set session variables
            $_SESSION['loggedin'] = true;
        } else {
            // Authentication failed, redirect back to admin.php
            header("Location: admin.php");
            exit;
        }
    }

    // Check if the user is logged in
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        // User is not logged in, redirect to admin.php
        header('Location: admin.php');
        exit;
    }

    // Your database connection parameters
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "artg_users";

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Fetch and display records from the users table
    $sql_users = "SELECT * FROM users";
    $result_users = mysqli_query($conn, $sql_users);

    echo "<h2>Users</h2>";
    echo "<table>";
    echo "<tr><th>ID</th><th>Name</th><th>Email</th><th>Mobile</th><th>DOB</th></tr>";
    while ($row_users = mysqli_fetch_assoc($result_users)) {
        echo "<tr>";
        echo "<td>{$row_users['id']}</td>";
        echo "<td>{$row_users['name']}</td>";
        echo "<td>{$row_users['email']}</td>";
        echo "<td>{$row_users['mobile']}</td>";
        echo "<td>{$row_users['dob']}</td>";
        echo "</tr>";
    }
    echo "</table>";

    // Fetch and display records from the artists_name table
    $sql_artists = "SELECT * FROM artists_name";
    $result_artists = mysqli_query($conn, $sql_artists);

    echo "<h2>Artists</h2>";
    while ($row_artists = mysqli_fetch_assoc($result_artists)) {
        echo "<h3>{$row_artists['name']}</h3>";
        echo "<table>";
        echo "<tr><th>ID</th><th>Art Name</th><th>Art Image</th><th>Art Type</th><th>Art Description</th><th>Date of Art</th><th>Describal</th><th>Price</th></tr>";
        $table_name = preg_replace('/[^a-zA-Z0-9_]/', '', "{$row_artists['name']}_{$row_artists['mobile']}");
        $sql_artist_details = "SELECT * FROM $table_name";
        $result_artist_details = mysqli_query($conn, $sql_artist_details);
        while ($row_artist_details = mysqli_fetch_assoc($result_artist_details)) {
            echo "<tr>";
            echo "<td>{$row_artist_details['id']}</td>";
            echo "<td>{$row_artist_details['art_name']}</td>";
            echo '<td><img src="' . $row_artist_details['art_image'] . '" alt="Art Image" style="max-width: 100px; max-height: 100px;"></td>';
            echo "<td>{$row_artist_details['art_type']}</td>";
            echo "<td>{$row_artist_details['art_description']}</td>";
            echo "<td>{$row_artist_details['date_of_art']}</td>";
            echo "<td>{$row_artist_details['describal']}</td>";
            echo "<td>{$row_artist_details['price']}</td>";
            echo "</tr>";
        }
        echo "</table>";
    }

    // Close connection
    mysqli_close($conn);
    ?>
</body>
</html>
