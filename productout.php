
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Out - Inventory System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            height: 100vh; /* Full viewport height */
            overflow: hidden;
        }

        /* Sidebar Styles */
        aside {
            width: 240px;
            background-color: #005f73;
            color: white;
            height: 100vh;
            padding: 20px;
            box-shadow: 4px 0 8px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            left: 0;
            overflow-y: auto;
        }

        aside h2 {
            font-size: 20px;
            margin-bottom: 20px;
            text-align: center;
        }

        aside ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        aside ul li {
            margin-bottom: 15px;
        }

        aside ul li a {
            color: white;
            font-size: 16px;
            display: block;
            padding: 10px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            text-decoration: none;
        }

        aside ul li a:hover {
            background-color: #4eedb5;
        }
        .content {
        margin-left: 350px; /* Matches the sidebar width + slight buffer */
        padding: 100px;
        background-color: #f4f4f4;
        width: 160vh;
        box-sizing: border-box; /* Ensures padding is included in the width calculation */
        display: flex;
        flex-direction:column;
        gap: 20px;
        overflow-y: auto; /* Enables scrolling for longer pages */
        min-height: 100vh;
        align-content: center;
        border-radius: 5vh;
    }

    .content header {
        background-color: #007bff;
        color: white;
        padding: 30px;
        text-align: center;
        border-radius: 5px;
        font-size: 22px;
        font-weight: bold;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    form {
        margin-top: 30px;
        background-color: white;
        padding: 80px;
        border-radius: 4px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    label {
        font-size: 20px;
        margin-bottom: 10px;
        display: block;
        font-weight: bold;
        color: #333;
    }

    input, select, button {
        padding: 10px;
        font-size: 16px;
        width: 100%;
        margin-bottom: 20px;
        border-radius: 5px;
        border: 1px solid #ccc;
        box-sizing: border-box;
    }

    button {
        background-color:rgb(0, 123, 255);
        color: white;
        cursor: pointer;
        border: none;
        transition: background-color 0.3s ease;
    }

    button:hover {
        background-color:rgb(239, 144, 145);
    }

    </style>
</head>
<body>
    <!-- Sidebar -->
    <aside>
        <h2>Dashboard</h2>
        <ul>
            <li><a href="dashboard.php">Overview</a></li>
            <li><a href="stock.php">Stock</a></li>
            <li><a href="sales.php">Sales</a></li>
            <li><a href="reports.php">Reports</a></li>
            <li><a href="setting.php">Settings</a></li>
        </ul>
    </aside>

    <!-- Content Section -->
    <div class="content">
        <header>Product Out</header>
        <form id="stock-out-form" method="POST" action="">
    <label for="product-id">Product ID</label>
    <input type="number" id="product-id" name="product-id" placeholder="Enter Product ID" required>

    <label for="quantity">Quantity</label>
    <input type="number" id="quantity" name="quantity" placeholder="Enter Quantity" required>

    <label for="customer">Customer</label>
    <input type="text" id="customer" name="customer" placeholder="Enter Customer Name" required
    pattern="[A-Za-z\s]+">

    <label for="date">Date</label>
    <input type="date" id="date" name="date" required>

    <button type="submit">Submit Product Out</button>
</form>

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
    $productCode = intval($_POST["product-id"]);
    $dateTime = $_POST["date"];
    $quantity = intval($_POST["quantity"]);
    $unitPrice = 10000; // Replace with actual price logic
    $totalPrice = $unitPrice * $quantity;

    // Insert data into the productout table
    $sql = "INSERT INTO productout (ProductCode, DateTime, Quantity, UnitPrice, TotalPrice)
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isidd", $productCode, $dateTime, $quantity, $unitPrice, $totalPrice);

    if ($stmt->execute()) {
        echo "<script>alert('Product-Out record added successfully!');</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

