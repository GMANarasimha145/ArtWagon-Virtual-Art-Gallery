<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exhibition Room</title>
    <style>
        /* Your CSS styles here */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #000;
            color: #fff;
            overflow-x: hidden; /* Hide horizontal scrollbar */
        }

        .header {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 20px 0;
            margin-bottom: 20px;
        }

        .container {
            position: relative;
            width: 100%;
            height: 80vh; /* Set height of the virtual room */
            overflow: hidden;
        }

        .artwork-container {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%); /* Center horizontally and vertically */
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .artwork-wrapper {
            display: flex;
            justify-content: center; /* Center artworks horizontally */
        }

        .artwork {
            width: 1000px;
            margin: 0 20px; /* Add margin between artworks */
            opacity: 0; /* Hide initially */
            transition: opacity 0.5s ease-in-out; /* Add transition for smooth opacity change */
            position: relative;
            border-radius: 10px; /* Add border radius */
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.3); /* Add shadow */
            display: flex; /* Display flex to align items */
            flex-direction: column; /* Stack items vertically */
            position: relative;
            z-index: 1; /* Set z-index to ensure it's above other elements */
        }

        .artwork.active {
            opacity: 1; /* Show active artwork */
        }

        .artwork img {
            width: 400px;
            height: 400px;
            height: auto;
            object-fit: cover;
            border-radius: 10px; /* Add border radius */
        }

        .text-overlay {
            position: absolute;
            top: 10px; /* Adjust top position */
            right: 10px; /* Adjust right position */
            background-color: rgba(0, 0, 0, 0.7);
            border-radius: 10px;
            display: none; /* Hide initially */
            justify-content: flex-start; /* Align text to the top */
            align-items: flex-end; /* Align text to the right */
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: 2; /* Set a higher z-index */
            padding: 10px; /* Add padding */
            max-width: calc(100% - 440px); /* Limit max width to avoid overlapping with image */
        }

        .artwork:hover .text-overlay {
            opacity: 1; /* Show on hover */
            display: flex; /* Show on hover */
        }

        .text-content {
            text-align: right;
            color: #fff; /* Set text color to white */
            max-width: 100%; /* Ensure text does not exceed parent width */
            overflow: hidden; /* Hide overflowing text */
            text-overflow: ellipsis; /* Add ellipsis for long text */
        }

        .comment-form {
            margin-top: 10px;
            display: none; /* Hide initially */
            flex-direction: column;
            width: 100%;
            z-index: 3; /* Set a higher z-index */
        }

        .artwork:hover .comment-form {
            display: flex; /* Show on hover */
        }

        .comment-input {
    margin-bottom: 5px;
    padding: 5px;
    flex-grow: 1; /* Allow the input to grow and fill the available space */
    width: auto; /* Reset width to auto */
}

.comment-submit {
    padding: 5px 10px;
    background-color: #4CAF50; /* Green button color */
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s;
    align-self: center; /* Align button to the center */
}


        .comment-submit:hover {
            background-color: #45a049; /* Darker green on hover */
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>ARTWAGON: VIRTUAL ART GALLERY</h1>
    </div>
    <div class="container">
        <div class="artwork-container">
            <div class="artwork-wrapper" id="artwork-wrapper">
            </div>
        </div>
    </div>
    <script>
    const artworksData = [
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
                $name_mobile = preg_replace('/[^a-zA-Z0-9_]/', '', $artist_name . "_" . $mobile);
                
                // Query the database to fetch records from the specified table
                $sql = "SELECT * FROM $name_mobile";
                $result = mysqli_query($conn, $sql);

                // Check if there are records
                if (mysqli_num_rows($result) > 0) {
                    // Output data of each row
                    while ($row = mysqli_fetch_assoc($result)) {
                        // Output art data
                        echo json_encode($row) . ",";
                    }
                } else {
                    echo "No records found";
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
    ];

    const artworkWrapper = document.getElementById('artwork-wrapper');
    let pauseAnimation = false; // Flag to control animation pause

    function createArtworkElement(artworkData) {
    const artwork = document.createElement('div');
    artwork.classList.add('artwork');
    artwork.innerHTML = `
        <img src="${artworkData.art_image}" alt="${artworkData.art_name}">
        <div class="text-overlay">
            <div class="text-content">
                <div>${artworkData.art_name}</div>
                <div>${artworkData.art_description}</div>
                <div>ID: ${artworkData.id}</div>
                <div>Art Type: ${artworkData.art_type}</div>
                <div>Date of Art: ${artworkData.date_of_art}</div>
                <div>Describal: ${artworkData.describal}</div>
                <div>Price: ${artworkData.price}</div>
            </div>
        </div>
        <form class="comment-form" action="comment_handling.php" method="POST">
            <div style="display: flex;">
                <input type="hidden" name="art_id" value="${artworkData.id}">
                <input type="hidden" name="art_name" value="${artworkData.art_name}">
                <input class="comment-input" type="text" name="comment" placeholder="Enter your comment here" required>
                <input class="comment-submit" type="submit" value="Post Comment">
            </div>
        </form>
    `;

    // Attach event listeners for comment inputs
    const commentInput = artwork.querySelector('.comment-input');

    commentInput.addEventListener('focus', () => {
        pauseAnimation = true; // Pause animation
    });

    // Resume animation when cursor is removed from the comment box
    commentInput.addEventListener('blur', () => {
        pauseAnimation = false; // Resume animation
    });

    return artwork;
}


    function fadeInArtwork(artwork) {
        artwork.style.opacity = 1; // Set opacity to 1 for fade in effect
    }

    function startExhibition() {
        if (!pauseAnimation) {
            let currentIndex = 0; // Initialize currentIndex

            // Display the first artwork immediately
            const firstArtwork = createArtworkElement(artworksData[currentIndex]);
            artworkWrapper.appendChild(firstArtwork);
            fadeInArtwork(firstArtwork);

            // Start fading in and out artworks after a delay
            setInterval(() => {
                if (!pauseAnimation) {
                    currentIndex = (currentIndex + 1) % artworksData.length; // Update currentIndex
                    const currentArtwork = artworksData[currentIndex];
                    const artwork = createArtworkElement(currentArtwork);
                    artworkWrapper.innerHTML = ''; // Clear previous artworks
                    artworkWrapper.appendChild(artwork); // Append current artwork
                    fadeInArtwork(artwork); // Fade in the next artwork
                }
            }, 5000); // Change artwork every 5 seconds (5000 milliseconds)
        }
    }

    // Start the exhibition
    startExhibition();
</script>



</body>
</html>