<?php
session_start();

// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'xy_shop');
define('DB_USER', 'root');
define('DB_PASS', '');

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ATTR_ERRMODE_EXCEPTION);

        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        // Prepare SQL statement
        $stmt = $pdo->prepare("SELECT * FROM shopkeeper WHERE username = :username LIMIT 1");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verify user and password
        if ($user && password_verify($password, $user['password'])) {
            // Authentication successful
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_id'] = $user['id'];
            $_SESSION['admin_username'] = $user['username'];
            $_SESSION['admin_role'] = $user['role'];
            
            // Update last login time
            $updateStmt = $pdo->prepare("UPDATE shopkeeper SET last_login = NOW() WHERE id = :id");
            $updateStmt->bindParam(':id', $user['id']);
            $updateStmt->execute();
            
            header('Location: dashboard.php');
            exit;
        } else {
            $error = "Invalid username or password";
        }
    } catch (PDOException $e) {
        $error = "Database error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>XY_SHOP - Admin Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2980b9;
            --danger-color: #e74c3c;
            --success-color: #2ecc71;
            --bg-color: #f5f7fa;
            --card-radius: 8px;
            --shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: var(--bg-color);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(135deg, #1e3c72, #2a5298);
        }

        .login-container {
            width: 100%;
            max-width: 400px;
            padding: 40px;
            background: white;
            border-radius: var(--card-radius);
            box-shadow: var(--shadow);
            text-align: center;
        }

        .login-logo {
            margin-bottom: 30px;
        }

        .login-logo i {
            font-size: 3rem;
            color: var(--primary-color);
        }

        .login-logo h1 {
            font-size: 1.5rem;
            margin-top: 10px;
            color: #333;
        }

        .login-form .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .login-form label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #555;
        }

        .login-form input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: var(--card-radius);
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .login-form input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
        }

        .btn {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: var(--card-radius);
            background-color: var(--primary-color);
            color: white;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
        }

        .error-message {
            color: var(--danger-color);
            margin-bottom: 20px;
            padding: 10px;
            background-color: rgba(231, 76, 60, 0.1);
            border-radius: var(--card-radius);
            border: 1px solid rgba(231, 76, 60, 0.3);
        }

        .login-footer {
            margin-top: 20px;
            font-size: 0.9rem;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-logo">
            <i class="fas fa-store-alt"></i>
            <h1>XY_SHOP Admin</h1>
        </div>

        <?php if (isset($error)): ?>
            <div class="error-message">
                <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form class="login-form" method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit" class="btn">Login</button>
        </form>

        <div class="login-footer">
            <p>Need help? Contact support@xyshop.com</p>
        </div>
    </div>
</body>
</html>