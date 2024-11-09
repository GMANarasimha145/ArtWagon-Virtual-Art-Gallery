<?php
// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_name'])) {
    // Redirect to login page if user is not logged in
    header("Location: artist_login.php");
    exit();
}

// Check if the form fields are set and not empty
if (isset($_POST['from_user'], $_POST['artist_mail'], $_POST['response']) && !empty($_POST['from_user']) && !empty($_POST['artist_mail']) && !empty($_POST['response'])) {
    // Escape special characters to prevent SQL injection
    $from_user = $_POST['from_user'];
    $artist_mail = $_POST['artist_mail'];
    $response = $_POST['response'];
    $id = $_POST['artist_id'];

    // Database connection parameters
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "artg_users";

    // Establish database connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Update the users table with the response and artist's email
    $update_query = "UPDATE users SET from_artist='$artist_mail', response='$response',art_id = '$id' WHERE email='$from_user'";

    // Execute the update query
    if (mysqli_query($conn, $update_query)) {
        echo "Response sent successfully!";
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }

    // Close connection
    mysqli_close($conn);
} else {
    // Redirect to the index page if form fields are not set or empty
    header("Location: artist_index.php");
    exit();
}
?>
