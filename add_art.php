<?php
// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_name'])) {
    // Redirect to login page if user is not logged in
    header("Location: login.php");
    exit();
}

// Establish database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "artg_users";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
$art_name = $_POST['art_name'];
$art_image = $_FILES['art_image'];
echo "Detailed Array is: ";
print_r($_FILES['art_image']);
$art_type = $_POST['art_type'];
$art_description = $_POST['art_description'];
$date_of_art = $_POST['date_of_art'];
$describal = $_POST['describal'];
$price = $_POST['price'];
$comments = $_POST['comments'];

$imagefilename = $art_image['name'];
$imagefiletemp = $art_image['tmp_name'];
$file_seperate = explode('.',$imagefilename);
$file_extension = strtolower(end($file_seperate));

$extension = array('jpeg','jpg','png');
if (in_array($file_extension, $extension))
{
    $upload_image = 'images/'.$imagefilename;
    move_uploaded_file($imagefiletemp, $upload_image);
}
// Construct table name
$table_name = strtolower(str_replace(' ', '', $_SESSION['user_name'])) . "_" . $_SESSION['user_mobile'];

// Insert data into artist's table
$sql_insert_art = "INSERT INTO $table_name (art_name, art_image, art_type, art_description, date_of_art, describal, price, comments) VALUES ('$art_name', '$upload_image', '$art_type', '$art_description', '$date_of_art', '$describal', '$price', '$comments')";

if ($conn->query($sql_insert_art) === TRUE) {
    echo "Art added successfully!";
} else {
    echo "Error adding art: " . $conn->error;
}

$conn->close();
?>
