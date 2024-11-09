<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Art</title>
    <style>
        /* Your CSS styles here */
        .container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(10px, 1fr)); /* Adjusted image width */
            gap: 20px;
            justify-content: center; /* Center horizontally */
            align-items: center; /* Center vertically */
        }

        .artwork {
            position: relative;
            overflow: hidden;
        }

        .artwork img {
            width: 50%;
            height: 50%;
            height: auto;
            transition: transform 0.3s ease;
            display: block;
            margin: 0 auto; /* Center image */
        }

        .artwork:hover img {
            transform: scale(1.1);
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
            // Check if art type is provided in the URL
            if(isset($_GET['art_type'])) {
                // Get the art type from the URL
                $art_type = $_GET['art_type'];

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

                // Query the artists_name table to get artist name and mobile number
                $sql = "SELECT name, mobile FROM artists_name";
                $result = mysqli_query($conn, $sql);
                echo "<center><h2>Artworks by Selected Art Type</h2></center>";

                if (mysqli_num_rows($result) > 0) {
                    // Loop through each artist
                    while ($row = mysqli_fetch_assoc($result)) {
                        // Form the table name
                        $table_name = preg_replace('/[^a-zA-Z0-9_]/', '', $row['name'] . "_" . $row['mobile']);
                        
                        // Query the artist's table to retrieve artworks of the selected art type
                        $art_query = "SELECT * FROM $table_name WHERE art_type = '$art_type'";
                        $art_result = mysqli_query($conn, $art_query);

                        if (mysqli_num_rows($art_result) > 0) {
                            // Display artworks
                            while ($art_row = mysqli_fetch_assoc($art_result)) {
                                echo '<div class="artwork">';
                                echo '<center><h3>' . $art_row['art_name'] . '</h3></center>';
                                echo '<img src="' . $art_row['art_image'] . '" alt="' . $art_row['art_name'] . '">';
                                echo '<center><p>Artist: ' . $row['name'] . '</p></center>'; // Display artist's name
                                echo '<center><p>Description: ' . $art_row['art_description'] . '</p></center>'; // Display artwork description
                                // Display other attributes as needed
                                echo '</div>';
                            }
                        } else {
                            echo "<p>No artworks found for artist: {$row['name']}</p>";
                        }
                    }
                } else {
                    echo "No artists found.";
                }

                // Close connection
                mysqli_close($conn);
            }  else {
                echo '<marquee behavior="scroll" direction="left" scrollamount="19" style="width: 100%;">'; // Adjust scrollamount as needed
                // Array of art types and corresponding prefix for images
                $artTypes = ['SG', 'OILP', 'STA', 'Sculp', 'VCA'];
                // Loop through each art type
                foreach($artTypes as $type) {
                    // Loop through each image for the art type
                    for ($i = 1; $i <= 5; $i++) {
                        $imagePath = "images/{$type}{$i}.jpg"; // Forming the image path
                        // Add a crossed image at the beginning
                        
                        echo '<img src="'.$imagePath.'" alt="Art Image" style="width: 200px; height: 250; margin-right: 50px;">'; // Adjust width, height, and margin as needed
                    }
                }
                echo '</marquee>';
            }
            ?>
        </div>
    </div>
</body>
</html>
