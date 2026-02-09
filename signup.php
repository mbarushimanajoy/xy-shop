<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            padding: 250px;
        }

        .form-container {
            max-width: 600px;
            height: auto;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #004b63;
        }

        input[type="text"], input[type="password"], button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        button {
            background-color: #004b63;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #49d6f3;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Sign Up</h1>
        <form action="" method="POST">
            <input type="text" name="username" placeholder="Enter Username" required pattern="[A-Za-z\s]+" title="Please enter only letters.">
            <input type="password" name="password" placeholder="Enter Password" required>
            <button type="submit">Sign Up</button>
        </form>
        <p>Already have an account? <a href="login.php">Login</a></p>
    </div>
</body>
</html>

<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "xy_shop");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // Hash password

    // Use prepared statements to insert data
    $stmt = $conn->prepare("INSERT INTO shopkeeper (UserName, Password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $password);

    if ($stmt->execute()) {
        echo "<script>alert('Signup successful! Redirecting to login page.');</script>";
        header("Location: login.php");
        exit;
    } else {
        echo "<script>alert('Error: Could not sign up. Please try again.');</script>";
    }

    $stmt->close();
}

$conn->close();
?>
