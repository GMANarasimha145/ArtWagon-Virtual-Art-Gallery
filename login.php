<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "artg_users";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Form data
$email = $_POST['email'];
$password = $_POST['password'];

// SQL query to check if user exists
$sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // User found, create session
    session_start();
    $row = $result->fetch_assoc();
    $_SESSION['user_id'] = $row['id'];
    $_SESSION['name'] = $row['name'];
    $_SESSION['email'] = $row['email'];
    $_SESSION['phone'] = $row['phone'];
    $_SESSION['dob'] = $row['dob'];
    echo "Login successful!";
    // Redirect to index.html or any other page after successful login
    header("Location: index.php");
} else {
    echo "Invalid email or password";
}

$conn->close();
?>
