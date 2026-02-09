<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>XY Shop - Messages</title>
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        body {
            background-color: #f4f7fc;
            color: #333;
            display: flex;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background-color: #004b63;
            color: white;
            height: 100vh;
            padding: 20px;
            position: fixed;
            top: 0;
            left: 0;
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 20px;
            color: #49d6f3;
        }

        .sidebar ul {
            list-style: none;
        }

        .sidebar ul li {
            margin-bottom: 20px;
        }

        .sidebar ul li a {
            color: white;
            display: block;
            padding: 10px 15px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .sidebar ul li a:hover {
            background-color: #49d6f3;
        }

        /* Main Content */
        .main-content {
            margin-left: 270px;
            padding: 40px 20px;
            flex: 1;
        }

        .main-content h1 {
            font-size: 28px;
            margin-bottom: 20px;
            color: #004b63;
            text-align: center;
        }

        .filter-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .filter-bar input {
            padding: 10px;
            width: 300px;
            border: 1px solid #ccc;
            border-radius: 5px;
            outline: none;
        }

        .filter-bar button {
            padding: 10px 20px;
            background-color: #004b63;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .filter-bar button:hover {
            background-color: #49d6f3;
        }

        .message-table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .message-table th,
        .message-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .message-table th {
            background-color: #004b63;
            color: white;
        }

        .message-table tr:hover {
            background-color: #f1f1f1;
        }

        .message-actions {
            display: flex;
            gap: 10px;
        }

        .message-actions button {
            padding: 8px 12px;
            font-size: 14px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .message-actions .view {
            background-color: #49d6f3;
            color: white;
        }

        .message-actions .view:hover {
            background-color: #1aa0cb;
        }

        .message-actions .delete {
            background-color: #ff6b6b;
            color: white;
        }

        .message-actions .delete:hover {
            background-color: #e04444;
        }
    </style>
</head>
<body>
<div class="sidebar">
    <h2>Admin Menu</h2>
    <ul>
        <li><a href="dashboard.php">Dashboard</a></li>
        <li><a href="product.php">Products</a></li>
        <li><a href="stockin.php">Stock In</a></li>
        <li><a href="stockout.php">Stock Out</a></li>
        <li><a href="order.php">View Orders</a></li>
        <li><a href="reports.php">Reports</a></li>
        <li><a href="message.php">Messages</a></li>
        <li><a href="setting.php">Settings</a></li>
    </ul>
</div>

<main class="main-content">
    <h1>Messages</h1>

    <div class="filter-bar">
        <input type="text" placeholder="Search messages...">
        <button>Filter</button>
    </div>

    <table class="message-table">
        <thead>
            <tr>
                <th>id</th>
                <th>Sender</th>
                <th>Subject</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Joy</td>
                <td>Product Inquiry</td>
                <td>2024-11-24</td>
                <td class="message-actions">
                    <button class="view">View</button>
                    <button class="delete">Delete</button>
                </td>
            </tr>
            <tr>
                <td>2</td>
                <td>Jess</td>
                <td>Order Issue</td>
                <td>2024-11-23</td>
                <td class="message-actions">
                    <button class="view">View</button>
                    <button class="delete">Delete</button>
                </td>
            </tr>
            <!-- Add more rows as needed -->
        </tbody>
    </table>
</main>
</body>
</html>
