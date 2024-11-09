<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Artist</title>
    <style>
        /* Your CSS styles here */
        .artworks {
            display: flex;
            justify-content: center; /* Center align the artworks */
            flex-wrap: wrap; /* Allow artworks to wrap */
            gap: 20px; /* Add gap between artworks */
        }

        .artwork {
            width: 300px; /* Set a fixed width */
            margin-bottom: 20px; /* Add margin at the bottom */
            position: relative; /* Position for hover effect */
            overflow: hidden; /* Hide overflowing elements */
        }

        .artwork img {
            width: 100%; /* Make the image fill the container */
            height: auto; /* Maintain aspect ratio */
            transition: transform 0.3s ease; /* Add smooth transition */
        }

        .artwork:hover img {
            transform: scale(1.1); /* Scale the image on hover */
        }

        .artwork .details {
            position: absolute; /* Position for details */
            bottom: 0;
            left: 0;
            right: 0;
            background-color: rgba(0, 0, 0, 0.7); /* Semi-transparent background for details */
            color: #fff; /* Text color */
            padding: 10px; /* Padding for details */
            box-sizing: border-box; /* Include padding in width and height */
            transform: translateY(100%); /* Initially move details below the container */
            transition: transform 0.3s ease; /* Add smooth transition */
        }

        .artwork:hover .details {
            transform: translateY(0); /* Move details up on hover */
        }
    </style>
</head>
<body>
    <div class="header">
        <center><h1>ARTWAGON: VIRTUAL ART GALLERY</h1></center>
    </div>
    <div class="container">
        <div class="artworks">
            <?php
            // Check if artist name is provided in the URL
            if(isset($_GET['artist_name'])) {
                // Get the artist name from the URL
                $artist_name = $_GET['artist_name'];

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

                // Query the artists_name table to get artist's mobile number
                $sql = "SELECT mobile FROM artists_name WHERE name='$artist_name'";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    // Get the mobile number of the artist
                    $row = mysqli_fetch_assoc($result);
                    $mobile = $row['mobile'];

                    // Form the table name
                    $table_name = preg_replace('/[^a-zA-Z0-9_]/', '', $artist_name . "_" . $mobile);
                    
                    // Query the artist's table to retrieve artworks
                    $art_query = "SELECT * FROM $table_name LIMIT 2"; // Limit to 2 artworks
                    $art_result = mysqli_query($conn, $art_query);

                    if (mysqli_num_rows($art_result) > 0) {
                        // Display artworks
                        while ($art_row = mysqli_fetch_assoc($art_result)) {
                            echo '<div class="artwork">';
                            echo '<img src="' . $art_row['art_image'] . '" alt="' . $art_row['art_name'] . '">';
                            echo '<div class="details">';
                            echo '<h3>' . $art_row['art_name'] . '</h3>';
                            echo '<p>Description: ' . $art_row['art_description'] . '</p>';
                            echo '<p>Describal: ' . $art_row['describal'] . '</p>';
                            echo '<p>Date of Art: ' . $art_row['date_of_art'] . '</p>';
                            echo '</div>'; // End .details
                            echo '</div>'; // End .artwork
                        }
                    } else {
                        echo "<p>No artworks found for artist: {$artist_name}</p>";
                    }
                } else {
                    echo "Artist not found.";
                }

                // Close connection
                mysqli_close($conn);
            } else {
                echo "Artist name not provided.";
            }
            ?>
        </div>
    </div>
</body>
</html>
