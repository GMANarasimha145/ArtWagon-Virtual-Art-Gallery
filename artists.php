<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artist Page</title>
</head>
<body>
    <?php
    // Start session
    session_start();

    // Check if artist is logged in
    if(isset($_SESSION['artist_name'])) {
        // If logged in, display welcome message and arts
        echo '<div>Welcome, ' . $_SESSION['artist_name'] . ' | Email: ' . $_SESSION['artist_email'] . ' | <a href="logout.php">Logout</a></div>';

        // Display form to add new art
        echo '<h2>Add New Art</h2>';
        echo '<form action="add_art.php" method="POST" enctype="multipart/form-data">';
        echo 'Art Name: <input type="text" name="art_name" required><br>';
        echo 'Art Image: <input type="file" name="art_image" required><br>';
        echo 'Art Type: <input type="text" name="art_type" required><br>';
        echo 'Art Description: <textarea name="art_description"></textarea><br>';
        echo 'Date of Art: <input type="date" name="date_of_art"><br>';
        echo 'Describal: <textarea name="describal"></textarea><br>';
        echo 'Price: <input type="number" name="price" step="0.01"><br>';
        echo 'Comments: <textarea name="comments"></textarea><br>';
        echo '<input type="submit" value="Submit">';
        echo '</form>';

        // Display existing arts
        // Add your code here to fetch and display existing arts from the database
    } else {
        // If not logged in, display login form
        echo '<h2>Login</h2>';
        echo '<form action="login_artist.php" method="POST">';
        echo 'Email: <input type="email" name="email" required><br>';
        echo 'Password: <input type="password" name="password" required><br>';
        echo '<input type="submit" value="Login">';
        echo '</form>';
    }
    ?>
</body>
</html>
