<?php
// Start session
session_start();

// Check if form data is received
if(isset($_POST['from_art']) && isset($_POST['message']) && isset($_POST['from_art_id'])) {
    // Form data
    $from_artist = $_POST['from_art'];
    #echo "From the ARTIST: ".$_POST['from_art'];
    #echo "From the ARTIST: ".$_POST['message'];
    $message = $_POST['message'];
    $art_id = $_POST['from_art_id'];

    echo "POST ID IS: ".$_POST['from_art_id'];
    // Database connection parameters
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

    // Query to search for name and mobile attributes from artists_name table
    $search_query = "SELECT name, mobile FROM artists_name WHERE email='$from_artist'";
    $search_result = mysqli_query($conn, $search_query);

    if(mysqli_num_rows($search_result) > 0) {
        // Fetch name and mobile
        $row = mysqli_fetch_assoc($search_result);
        $artist_name = $row['name'];
        $mobile = $row['mobile'];

        // Form the table name
        $table_name = preg_replace('/[^a-zA-Z0-9_]/', '', $artist_name . "_" . $mobile);

        // Update comments field in the table
        $update_query = "UPDATE $table_name SET comments='$message' WHERE id ='$art_id'";
        echo "ID WHERE MESSG: ".$art_id;
        if(mysqli_query($conn, $update_query)) {
            echo "Message sent successfully!";
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }
    } else {
        echo "Artist not found!";
    }

    // Close connection
    mysqli_close($conn);
} else {
    echo "Form data not received!";
}
?>
