<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Artwork</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #90EE90; /* Light green background */
        }

        h2 {
            text-align: center;
            color: #4a2c00; /* Brown text color */
        }

        form {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff; /* White background for form */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Box shadow for form */
        }

        label {
            display: block;
            margin-bottom: 10px;
            color: #333; /* Dark gray text color */
        }

        input[type="text"],
        input[type="date"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc; /* Light gray border */
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4a2c00; /* Brown button color */
            color: #fff; /* White text color */
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #693f13; /* Darker brown on hover */
        }
    </style>
</head>
<body>
    <h2>Update Artwork</h2>
    <form action="update_db.php" method="POST">
        <?php
        // Start session
        session_start();

        // Check if user is logged in
        if (!isset($_SESSION['user_name'])) {
            // Redirect to login page if user is not logged in
            header("Location: artist_login.php");
            exit();
        }

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

        // Check if art ID is provided
        if (!isset($_POST['art_id'])) {
            echo "Art ID not provided!";
            exit();
        }

        // Fetch artwork details based on art ID
        $art_id = $_POST['art_id'];
        $sql_fetch_artwork = "SELECT * FROM $user_table_name WHERE id=$art_id";
        $result_artwork = mysqli_query($conn, $sql_fetch_artwork);

        if (mysqli_num_rows($result_artwork) > 0) {
            $row = mysqli_fetch_assoc($result_artwork);
        ?>
            <input type="hidden" name="art_id" value="<?php echo $art_id; ?>">
            <label for="art_name">Art Name:</label><br>
            <input type="text" id="art_name" name="art_name" value="<?php echo $row['art_name']; ?>" required><br>

            <label for="art_type">Art Type:</label><br>
            <input type="text" id="art_type" name="art_type" value="<?php echo $row['art_type']; ?>" required><br>

            <label for="art_description">Art Description:</label><br>
            <textarea id="art_description" name="art_description"><?php echo $row['art_description']; ?></textarea><br>

            <label for="date_of_art">Date of Art:</label><br>
            <input type="date" id="date_of_art" name="date_of_art" value="<?php echo $row['date_of_art']; ?>" required><br>

            <label for="describal">Describal:</label><br>
            <textarea id="describal" name="describal"><?php echo $row['describal']; ?></textarea><br>

            <label for="price">Price:</label><br>
            <input type="text" id="price" name="price" value="<?php echo $row['price']; ?>" required><br>

            <label for="comments">Comments:</label><br>
            <textarea id="comments" name="comments"><?php echo $row['comments']; ?></textarea><br>

            <input type="submit" value="Update Art">
        <?php
        } else {
            echo "Artwork not found!";
        }

        // Close connection
        mysqli_close($conn);
        ?>
    </form>
</body>
</html>
