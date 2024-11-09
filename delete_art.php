<?php
// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_name'])) {
    // Redirect to login page if user is not logged in
    header("Location: artist_login.php");
    exit();
}

// Check if art_id is provided
if (isset($_POST['art_id'])) {
    // Get the art_id from GET parameters
    $art_id = $_POST['art_id'];

    // Establish database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "artg_users";

    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Construct table name
    $user_table_name = $_SESSION['user_table_name'];

    // Delete the artwork from the database
    $sql_delete_art = "DELETE FROM $user_table_name WHERE id=$art_id";

    if (mysqli_query($conn, $sql_delete_art)) {
        echo "Artwork deleted successfully!";
    } else {
        echo "Error deleting artwork: " . mysqli_error($conn);
    }

    // Close connection
    mysqli_close($conn);
} else {
    echo "Art ID Not provided.";
}
?>
