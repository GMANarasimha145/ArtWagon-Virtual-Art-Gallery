<?php
// Start session
session_start();

// Check if user is logged in
if (isset($_SESSION['user_name'])) {
    $welcome_message = "Welcome, " . $_SESSION['user_name'] . "!";
    $user_email = $_SESSION['user_email'];
    $user_table_name = $_SESSION['user_table_name']; // Get the table name from session
} else {
    // Redirect to login page if user is not logged in
    header("Location: artist_login.php");
    exit();
}

// Function to escape special characters to prevent SQL injection
function escape_string($conn, $string) {
    return mysqli_real_escape_string($conn, $string);
}

// Establish database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "artg_users";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch all image data from user's table
$sql_fetch_data = "SELECT * FROM $user_table_name";
$result_data = mysqli_query($conn, $sql_fetch_data);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #90EE90; /* Light green background */
        }

        h1, h2 {
            margin-bottom: 10px;
            color: #4a2c00; /* Brown text color */
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
            background-color: lightgoldenrodyellow;
        }

        th {
            background-color: #f2f2f2;
        }

        img {
            width: 100px;
            height: auto;
        }

        form {
            max-width: 600px;
            margin: 0 auto; /* Center align the form */
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #333; /* Dark gray text color */
        }

        input[type="text"],
        input[type="file"],
        textarea,
        input[type="date"],
        input[type="submit"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc; /* Light gray border */
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #4CAF50; /* Green button color */
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #45a049; /* Darker green on hover */
        }
    </style>
</head>
<body>
    <h1>Welcome to the Art Gallery</h1>
    <p>Email: <?php echo $user_email; ?></p>

    <h2>Artworks</h2>
    <table>
        <tr>
            <th>Art Name</th>
            <th>Art Image</th>
            <th>Art Type</th>
            <th>Description</th>
            <th>Date of Art</th>
            <th>Describal</th>
            <th>Price</th>
            <th>Comments</th>
            <th>Response</th>
            <th>Actions</th>
        </tr>
        <?php
        if (mysqli_num_rows($result_data) > 0) {
            while ($row = mysqli_fetch_assoc($result_data)) {
                echo '<tr>';
                echo '<td>' . $row['art_name'] . '</td>';
                echo '<td><img src="' . $row['art_image'] . '" alt="Art Image"></td>';
                echo '<td>' . $row['art_type'] . '</td>';
                echo '<td>' . $row['art_description'] . '</td>';
                echo '<td>' . $row['date_of_art'] . '</td>';
                echo '<td>' . $row['describal'] . '</td>';
                echo '<td>$' . $row['price'] . '</td>';
                echo '<td>' . $row['comments'] . '</td>';
                echo '<td>';
                echo '<form action="send_response.php" method="POST">';
                echo '<input type="hidden" name="from_user" value="' . escape_string($conn, $row['from_user']) . '">';
                echo '<input type="hidden" name="artist_mail" value="' . $user_email . '">';
                echo '<input type="hidden" name="artist_id" value="' . $row['id'] . '">';
                echo '<input type="text" name="response" placeholder="Enter your response">';
                echo '<input type="submit" value="Send Response">';
                echo '</form>';
                echo '</td>';
                echo '<td>';
                echo '<form action="update_process.php" method="POST">';
                echo '<input type="hidden" name="art_id" value="' . $row['id'] . '">';
                echo '<input type="submit" value="Update">';
                echo '</form>';
                echo '<form action="delete_art.php" method="POST">';
                echo '<input type="hidden" name="art_id" value="' . $row['id'] . '">';
                echo '<input type="submit" value="Delete">';
                echo '</form>';
                echo '</td>';
                echo '</tr>';
            }
        } else {
            // No art data available
            echo '<tr><td colspan="10">No artworks available. Uploading soon!</td></tr>';
        }

        // Close connection
        mysqli_close($conn);
        ?>
    </table>

    <h2>Add New Art</h2>
    <form action="add_art.php" method="POST" enctype="multipart/form-data">
        <label for="art_name">Art Name:</label><br>
        <input type="text" id="art_name" name="art_name" required><br>

        <label for="art_image">Art Image:</label><br>
        <input type="file" id="art_image" name="art_image" required><br>

        <label for="art_type">Art Type:</label><br>
        <input type="text" id="art_type" name="art_type" required><br>

        <label for="art_description">Art Description:</label><br>
        <textarea id="art_description" name="art_description"></textarea><br>

        <label for="date_of_art">Date of Art:</label><br>
        <input type="date" id="date_of_art" name="date_of_art" required><br>

        <label for="describal">Describal:</label><br>
        <textarea id="describal" name="describal"></textarea><br>

        <label for="price">Price:</label><br>
        <input type="text" id="price" name="price" required><br>

        <label for="comments">Comments:</label><br>
        <textarea id="comments" name="comments"></textarea><br>

        <input type="submit" value="Add Art">
    </form>

</body>
</html>
