<?php 
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ARTWAGON: VIRTUAL ART GALLERY</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
        }

        .header {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 20px;
            position: relative;
        }

        .navbar {
            background-color: #444;
            padding: 10px 0;
            text-align: center;
        }

        .navbar a {
            color: #fff;
            text-decoration: none;
            margin: 0 20px;
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #444;
            min-width: 160px;
            z-index: 1;
            text-align: left;
            padding: 10px 0;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .dropdown-content a {
            color: #fff;
            text-decoration: none;
            display: block;
            padding: 10px 20px;
        }

        .dropdown-content a:hover {
            background-color: #555;
        }

        .container {
            display: flex;
            justify-content: space-around;
            margin-top: 20px;
        }

        iframe {
            width: 100%;
            height: 400px;
            border: 1px solid #ccc;
        }

        h2 {
            margin-top: 0;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            margin-bottom: 10px;
        }

        select {
            margin-top: 10px;
            background-color: #444;
            color: #fff;
            border: none;
            padding: 5px 10px;
            font-size: 16px;
        }

        a {
            text-decoration: none;
            color: #fff;
        }

        a:hover {
            color: #ccc;
        }

        .response {
            color: #fff;
            position: absolute;
            top: 20px;
            right: 20px;
        }

        .message-form {
            margin-top: 20px;
            text-align: center;
        }

        .message-form input[type="text"] {
            width: 300px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-right: 10px;
        }

        .message-form input[type="submit"] {
            padding: 10px 20px;
            background-color: #444;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>ARTWAGON: VIRTUAL ART GALLERY</h1>
        <div class="navbar">
            <a href="index.php">Home</a>
            <div class="dropdown">
                <a href="#">Artists</a>
                <div class="dropdown-content">
                    <?php
                    // Your database connection parameters
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

                    // Query to get artist names
                    $sql = "SELECT name FROM artists_name";
                    $result = mysqli_query($conn, $sql);
                    // Check if there are artists
                    if (mysqli_num_rows($result) > 0) {
                        // Output data of each row
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<a href="display_art_by_name.php?artist_name=' . urlencode($row['name']) . '" target="bottom_frame">' . $row['name'] . '</a>';
                        }
                    } else {
                        echo "0 artists found";
                    }

                    // Close connection
                    mysqli_close($conn);
                    ?>
                </div>
            </div>
            <div class="dropdown">
                <a href="#">Art Types</a>
                <div class="dropdown-content">
                    <a href="display_art.php?art_type=SCULPTURES" target="bottom_frame">SCULPTURES</a>
                    <a href="display_art.php?art_type=STREET%20ARTS" target="bottom_frame">STREET ARTS</a>
                    <a href="display_art.php?art_type=CONCEPTUAL%20ARTS" target="bottom_frame">CONCEPTUAL ARTS</a>
                    <a href="display_art.php?art_type=OIL%20PAINTINGS" target="bottom_frame">OIL PAINTINGS</a>
                    <a href="display_art.php?art_type=SERIGRAPHS" target="bottom_frame">SERIGRAPHS</a>
                    <!-- Add more art types as needed -->
                </div>
            </div>
            <div class="dropdown">
                <a href="#">Exhibition Rooms</a>
                <div class="dropdown-content">
                    <?php
                    // Your database connection parameters
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

                    // Query to get artist names
                    $sql = "SELECT name FROM artists_name";
                    $result = mysqli_query($conn, $sql);

                    // Check if there are artists
                    if (mysqli_num_rows($result) > 0) {
                        // Output data of each row
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<a href="exhibition_room.php?artist_name=' . urlencode($row['name']) . '" target="__blank">' . $row['name'] . '</a>';
                        }
                    } else {
                        echo "0 artists found";
                    }

                    // Close connection
                    mysqli_close($conn);
                    ?>
                </div>
            </div>
            <a href="about.html" target="bottom_frame">About</a>
            <!-- Add more navigation links as needed -->
            <?php
            // Start the session

            // Check if user is logged in
            if(isset($_SESSION['email']) && isset($_SESSION['name'])) {
                // If logged in, display username and email and logout button
                echo '<div style="position: absolute; top: 4px; right: 3px; color: #fff;">';
                echo 'Welcome, </br>' . $_SESSION['name'] . ' </br> ';
                echo 'Email: ' . $_SESSION['email'] . ' </br> ';
                echo '<a href="logout.php" style="color: #fff; text-decoration: none;">Logout</a>';
                echo '</div>';
            }
            ?>
        </div>
    </div>
    <div class="bottom-frame">
        <iframe src="display_art.php" name="bottom_frame" frameborder="0"></iframe>
    </div>
    <!-- Display response and message form -->
    <div class="response">
        <?php
        // Display user information and logout link if logged in
        if(isset($_SESSION['email']) && isset($_SESSION['name'])) {
            // Connect to database
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "artg_users";
            $conn = mysqli_connect($servername, $username, $password, $dbname);
            // Check connection
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }
            // Query to get response from users table
            $email = $_SESSION['email'];
            $response_query = "SELECT response,from_artist,art_id FROM users WHERE email='$email'";
            $response_result = mysqli_query($conn, $response_query);
            if (mysqli_num_rows($response_result) > 0) {
                $response_row = mysqli_fetch_assoc($response_result);
                #echo 'Response: ' . $response_row['response'];
                #echo $response_row["from_artist"];
            }
            // Close connection
            mysqli_close($conn);
        }
        ?>
    </div>
    <div class="message-form">
        <?php echo 'Response from Artist: '. $response_row['from_artist']. ' is: ' . $response_row['response']; ?> 
        <form action="send_message.php" method="POST">
            <input type="hidden" name="from_art" value="<?php echo $response_row['from_artist']; ?>">
            <input type="hidden" name="from_art_id" value="<?php echo $response_row['art_id']; ?>">
            <input type="text" name="message" placeholder="Enter your message">
            <input type="submit" value="Send Message">
        </form>
    </div>
</body>
</html>
