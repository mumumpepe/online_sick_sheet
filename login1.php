<?php
session_start();

$loginError = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Replace with your database connection and query logic
    $dbHost = "localhost";
    $dbUser = "root";
    $dbPass = "";
    $dbName = "registrations";

    $conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT id, username, password_hash, role FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    // ... (previous code)

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $hashedPassword = $row["password_hash"];
    $role = $row["role"]; // Fetch the user's role from the database
    // After fetching the user's role
    $_SESSION["role"] = $role;


    if (password_verify($password, $hashedPassword)) {
        $_SESSION["user_id"] = $row["id"];
        $_SESSION["username"] = $username;

        // Redirect based on the user's role
        if ($role == 'student') {
            header("Location: home.php");
            exit();
        } elseif ($role == 'medical_officer') {
            header("Location: medical_officer_dashboard.php");
            exit();
        } elseif ($role == 'director') {
            header("Location: director_dashboard1.php");
            exit();
        }
    } else {
        $loginError = "Invalid username or password.";
    }
} else {
    $loginError = "Invalid username or password.";
}

    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
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
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 300px;
            text-align: center;
        }
        
        h2 {
            margin: 0 0 20px;
            color: #333;
        }
        
        input[type="text"],
        input[type="password"] {
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

        .register-link {
            color: #28a745;
            text-decoration: none;
        }

        .register-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        
        <!-- Display the error message if loginError is not empty -->
        <?php if (!empty($loginError)) : ?>
            <p style="color: #ff5252;"><?php echo $loginError; ?></p>
        <?php endif; ?>
        
        <form action="login1.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br>
            
            <input type="submit" value="Login">
        </form>
        
        <p>New user? <a class="register-link" href="register1.php">Register</a></p>
    </div>
</body>
</html>
