<?php
// Start session
session_start();

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
$email = $_POST['email'];
$password = $_POST['password'];

// Check if user exists
$sql_check_user = "SELECT * FROM artists_name WHERE email='$email' AND password='$password'";
$result = $conn->query($sql_check_user);

if ($result->num_rows > 0) {
    // User found, retrieve user data
    $user_data = $result->fetch_assoc();
    
    // Store user data in session variables
    $_SESSION['user_id'] = $user_data['id'];
    $_SESSION['user_name'] = $user_data['name'];
    $_SESSION['user_email'] = $user_data['email'];
    $_SESSION['user_mobile'] = $user_data['mobile'];
    
    // Construct table name
    $artist_name = str_replace(' ', '', $user_data['name']); // Remove spaces from artist name
    $mobile_number = $user_data['mobile'];
    $table_name = strtolower($artist_name) . "_" . $mobile_number;

    // Store table name in session variable
    $_SESSION['user_table_name'] = $table_name;

    // Redirect to index page
    header("Location: artist_index.php");
    exit();
} else {
    // User not found, show error message
    echo "Invalid email or password";
}

$conn->close();
?>
