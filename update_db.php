<?php
// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_name'])) {
    // Redirect to login page if user is not logged in
    header("Location: artist_login.php");
    exit();
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user table name from session
    $user_table_name = $_SESSION['user_table_name'];

    // Establish database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "artg_users";

    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Check if the required POST variables are set
    if (isset($_POST['art_id'], $_POST['art_name'], $_POST['art_type'], $_POST['art_description'], $_POST['date_of_art'], $_POST['describal'], $_POST['price'], $_POST['comments'])) {
        // Retrieve form data
        $art_id = $_POST['art_id'];
        $art_name = $_POST['art_name'];
        $art_type = $_POST['art_type'];
        $art_description = $_POST['art_description'];
        $date_of_art = $_POST['date_of_art'];
        $describal = $_POST['describal'];
        $price = $_POST['price'];
        $comments = $_POST['comments'];

        // Update the artwork in the database
        $sql_update_art = "UPDATE $user_table_name 
                           SET art_name='$art_name', art_type='$art_type', 
                               art_description='$art_description', date_of_art='$date_of_art', 
                               describal='$describal', price='$price', comments='$comments' 
                           WHERE id=$art_id";

        if (mysqli_query($conn, $sql_update_art)) {
            echo "Artwork updated successfully!";
        } else {
            echo "Error updating artwork: " . mysqli_error($conn);
        }
    } else {
        echo "Required POST variables are not set!";
    }

    // Close connection
    mysqli_close($conn);
} else {
    echo "Invalid request!";
}
?>
