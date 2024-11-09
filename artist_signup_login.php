<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artist Signup/Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: lightgreen; /* Light gray background */
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

        h3 {
            color: #006400; /* Dark green color */
        }

        input[type="text"],
        input[type="email"],
        input[type="file"],
        input[type="tel"],
        input[type="password"],
        textarea {
            width: 100%;
            margin-bottom: 10px;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ccc; /* Light gray border */
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #4a2c00; /* Brown button color */
            color: #fff; /* White text color */
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #693f13; /* Darker brown on hover */
        }

        .error {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <h2>Artist Signup/Login</h2>

    <!-- Signup Form -->
    <div>
        <center><h3>Signup</h3></center>
        <form id="registerForm" action="artist_signup.php" method="POST" enctype="multipart/form-data">
            <input type="text" name="name" placeholder="Name" required><br>
            <input type="email" name="email" placeholder="Email" required><br>
            <input type="text" name="mobile" placeholder="Mobile" required><br>
            <input type="date" name="dob" placeholder="Date of Birth" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <input type="submit" value="Signup">
        </form>
    </div>

    <!-- Login Form -->
    <div>
        <center><h3>Login</h3></center>
        <form id="loginForm" action="artist_login.php" method="POST">
            <input type="email" name="email" placeholder="Email" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <input type="submit" value="Login">
        </form>
    </div>
</body>
</html>
