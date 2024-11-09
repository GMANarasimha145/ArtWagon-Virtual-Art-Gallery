<?php
// Establish database connection
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

// Retrieve form data
$name = $conn->real_escape_string($_POST['name']);
$email = $conn->real_escape_string($_POST['email']);
$mobile = $conn->real_escape_string($_POST['mobile']);
$dob = $conn->real_escape_string($_POST['dob']);
$password = $conn->real_escape_string($_POST['password']);

// Sanitize table name
$table_name = preg_replace('/[^a-zA-Z0-9_]/', '', $name . "_" . $mobile);

// Insert data into main table
$sql_insert_main = "INSERT INTO artists_name (name, email, mobile, dob, password) VALUES ('$name', '$email', '$mobile', '$dob', '$password')";

if ($conn->query($sql_insert_main) === TRUE) {
    // Create new table
    $sql_create_table = "CREATE TABLE IF NOT EXISTS $table_name (
        id INT AUTO_INCREMENT PRIMARY KEY,
        art_name VARCHAR(255) NOT NULL,
        art_image VARCHAR(60) NOT NULL,
        art_type VARCHAR(100) NOT NULL,
        art_description TEXT,
        date_of_art DATE,
        describal TEXT,
        price DECIMAL(10, 2),
        comments TEXT
    )";

    if ($conn->query($sql_create_table) === TRUE) {
        echo "Signup successful!";
    } else {
        echo "Error creating table: " . $conn->error;
    }
} else {
    echo "Error inserting data into main table: " . $conn->error;
}

$conn->close();
?>
