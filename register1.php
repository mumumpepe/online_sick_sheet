<?php
session_start();

// Check if the user is already logged in
if (isset($_SESSION["user_id"])) {
    header("Location: home.php");
    exit();
}

$errorMessage = ""; // Define the errorMessage variable here

// Database connection parameters
$dbHost = "localhost"; // Hostname
$dbUser = "root";      // Username
$dbPass = "";          // Password (leave it empty for no password)
$dbName = "registrations"; // Database name

// Create a connection to the database
$conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $role = $_POST["role"]; // Add a role field to your registration form

    // Check if the user already exists
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $errorMessage = "User already exists please login.";
    } else {
        // Hash the password
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        // Insert new user into the database
        $insertQuery = "INSERT INTO users (username, password_hash, registration_date, role) VALUES ('$username', '$passwordHash', NOW(), '$role')";

        if ($conn->query($insertQuery) === TRUE) {
            $_SESSION["user_id"] = $conn->insert_id;

            // Redirect based on the user's role
            if ($role == 'student') {
                header("Location: home.php");
                exit();
            } elseif ($role == 'medical_officer') {
                header("Location: medical_officer_dashboard.php");
                exit();
            } elseif ($role == 'director') {
                header("Location: director_dashboard.php");
                exit();
            }
        } else {
            $errorMessage = "Error: " . $conn->error;
        }
    }
}

$conn->close();
?>

<!-- Rest of your HTML registration form here -->


<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <style>
        /* Your CSS styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 400px;
            text-align: center;
        }

        h2 {
            margin: 0 0 20px;
            color: #333;
        }

        label {
            display: block;
            text-align: left;
            margin-bottom: 6px;
        }

        input[type="text"],
        input[type="password"],
        select { /* Added select field for role */
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            padding: 12px 20px;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .error-message {
            color: #dc3545;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Register</h2>
        
        <?php
        if ($errorMessage !== "") {
            echo "<p class='error-message'>$errorMessage</p>";
        }
        ?>

        <!-- Registration form -->
        <form action="register1.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            
            <label for="role">Role:</label> <!-- Added Role field -->
            <select id="role" name="role" required>
                <option value="student">Student</option>
            </select>
            
            <input type="submit" value="Register">
        </form>
        
        <p>Already have an account? <a href="login1.php" style="text-decoration:none">Login</a></p>
    </div>
</body>
</html>
