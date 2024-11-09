<?php
// Check if the form is submitted
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from the form
    $artId = $_POST['art_id'];
    $artName = $_POST['art_name'];
    $comment = $_POST['comment'];

    // Database connection parameters
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "artg_users";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve name and mobile from artists_name table
    $artistNameQuery = "SELECT name, mobile FROM artists_name";
    $artistNameResult = $conn->query($artistNameQuery);

    if ($artistNameResult->num_rows > 0) {
        // Fetching each artist's name and mobile
        while ($row = $artistNameResult->fetch_assoc()) {
            // Form the table name as name_mobile
            $tableName = preg_replace('/[^a-zA-Z0-9_]/', '', $row['name'] . "_" . $row['mobile']);

            // Check if the table contains the artname
            $checkArtQuery = "SELECT * FROM $tableName WHERE art_name='$artName'";
            $result = $conn->query($checkArtQuery);
            $em = $_SESSION['email'];
            if ($result->num_rows > 0) {
                // Update the comment attribute in the corresponding table
                $updateQuery = "UPDATE $tableName SET comments='$comment', from_user='$em' WHERE art_name='$artName'";
                echo "User is: ".$em;

                if ($conn->query($updateQuery) === TRUE) {
                    echo "Comment updated successfully for artist: " . $row['name'];
                } else {
                    echo "Error updating comment: " . $conn->error;
                }
                // Exit the loop if comment is updated
                break;
            }
        }
    } else {
        echo "No artists found.";
    }

    // Close connection
    $conn->close();
}
?>
