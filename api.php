<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "xy_shop";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

// Get the request method
$method = $_SERVER['REQUEST_METHOD'];

// Handle different actions
$action = $_GET['action'] ?? '';

switch ($action) {
    case 'getProducts':
        getProducts($conn);
        break;
    case 'addProduct':
        addProduct($conn);
        break;
    case 'updateProduct':
        updateProduct($conn);
        break;
    case 'deleteProduct':
        deleteProduct($conn);
        break;
    case 'getStockIn':
        getStockIn($conn);
        break;
    case 'addStockIn':
        addStockIn($conn);
        break;
    case 'updateStockIn':
        updateStockIn($conn);
        break;
    case 'deleteStockIn':
        deleteStockIn($conn);
        break;
    case 'getStockOut':
        getStockOut($conn);
        break;
    case 'addStockOut':
        addStockOut($conn);
        break;
    case 'updateStockOut':
        updateStockOut($conn);
        break;
    case 'deleteStockOut':
        deleteStockOut($conn);
        break;
    default:
        echo json_encode(["error" => "Invalid action"]);
}

// Product Functions
function getProducts($conn) {
    $sql = "SELECT * FROM products ORDER BY name";
    $result = $conn->query($sql);
    
    $products = [];
    while($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
    
    echo json_encode($products);
}

function addProduct($conn) {
    $data = json_decode(file_get_contents('php://input'), true);
    
    $stmt = $conn->prepare("INSERT INTO products (code, name, description, stock, purchase_price, selling_price, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issddds", 
        $data['code'],
        $data['name'],
        $data['description'],
        $data['stock'],
        $data['purchase_price'],
        $data['selling_price'],
        $data['status']
    );
    
    if ($stmt->execute()) {
        echo json_encode(["success" => true, "id" => $stmt->insert_id]);
    } else {
        echo json_encode(["error" => $stmt->error]);
    }
}

function updateProduct($conn) {
    $data = json_decode(file_get_contents('php://input'), true);
    
    $stmt = $conn->prepare("UPDATE products SET code = ?, name = ?, description = ?, stock = ?, purchase_price = ?, selling_price = ?, status = ? WHERE id = ?");
    $stmt->bind_param("issdddss", 
        $data['code'],
        $data['name'],
        $data['description'],
        $data['stock'],
        $data['purchase_price'],
        $data['selling_price'],
        $data['status'],
        $data['id']
    );
    
    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["error" => $stmt->error]);
    }
}

function deleteProduct($conn) {
    $id = $_GET['id'] ?? 0;
    
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["error" => $stmt->error]);
    }
}

// Stock In Functions
function getStockIn($conn) {
    $sql = "SELECT si.*, p.code as product_code, p.name as product_name 
            FROM stock_in si
            LEFT JOIN products p ON si.product_id = p.id
            ORDER BY si.transaction_date DESC";
    $result = $conn->query($sql);
    
    $records = [];
    while($row = $result->fetch_assoc()) {
        $records[] = $row;
    }
    
    echo json_encode($records);
}

function addStockIn($conn) {
    $data = json_decode(file_get_contents('php://input'), true);
    
    // Start transaction
    $conn->begin_transaction();
    
    try {
        // Add stock in record
        $stmt = $conn->prepare("INSERT INTO stock_in (product_id, quantity, unit_price, total_price, transaction_date) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iidds",
            $data['product_id'],
            $data['quantity'],
            $data['unit_price'],
            $data['total_price'],
            $data['transaction_date']
        );
        $stmt->execute();
        
        // Update product stock
        $updateStmt = $conn->prepare("UPDATE products SET stock = stock + ? WHERE id = ?");
        $updateStmt->bind_param("ii", $data['quantity'], $data['product_id']);
        $updateStmt->execute();
        
        $conn->commit();
        echo json_encode(["success" => true, "id" => $stmt->insert_id]);
    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode(["error" => $e->getMessage()]);
    }
}

function updateStockIn($conn) {
    $data = json_decode(file_get_contents('php://input'), true);
    
    // Start transaction
    $conn->begin_transaction();
    
    try {
        // Get the original record to calculate the difference
        $originalStmt = $conn->prepare("SELECT product_id, quantity FROM stock_in WHERE id = ?");
        $originalStmt->bind_param("i", $data['id']);
        $originalStmt->execute();
        $original = $originalStmt->get_result()->fetch_assoc();
        
        $quantityDiff = $data['quantity'] - $original['quantity'];
        
        // Update stock in record
        $stmt = $conn->prepare("UPDATE stock_in SET product_id = ?, quantity = ?, unit_price = ?, total_price = ?, transaction_date = ? WHERE id = ?");
        $stmt->bind_param("iiddsi",
            $data['product_id'],
            $data['quantity'],
            $data['unit_price'],
            $data['total_price'],
            $data['transaction_date'],
            $data['id']
        );
        $stmt->execute();
        
        // Update product stock
        $updateStmt = $conn->prepare("UPDATE products SET stock = stock + ? WHERE id = ?");
        $updateStmt->bind_param("ii", $quantityDiff, $data['product_id']);
        $updateStmt->execute();
        
        $conn->commit();
        echo json_encode(["success" => true]);
    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode(["error" => $e->getMessage()]);
    }
}

function deleteStockIn($conn) {
    $id = $_GET['id'] ?? 0;
    
    // Start transaction
    $conn->begin_transaction();
    
    try {
        // Get the record to adjust the product stock
        $getStmt = $conn->prepare("SELECT product_id, quantity FROM stock_in WHERE id = ?");
        $getStmt->bind_param("i", $id);
        $getStmt->execute();
        $record = $getStmt->get_result()->fetch_assoc();
        
        // Delete the record
        $delStmt = $conn->prepare("DELETE FROM stock_in WHERE id = ?");
        $delStmt->bind_param("i", $id);
        $delStmt->execute();
        
        // Update product stock
        $updateStmt = $conn->prepare("UPDATE products SET stock = stock - ? WHERE id = ?");
        $updateStmt->bind_param("ii", $record['quantity'], $record['product_id']);
        $updateStmt->execute();
        
        $conn->commit();
        echo json_encode(["success" => true]);
    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode(["error" => $e->getMessage()]);
    }
}

// Stock Out Functions
function getStockOut($conn) {
    $sql = "SELECT so.*, p.code as product_code, p.name as product_name 
            FROM stock_out so
            LEFT JOIN products p ON so.product_id = p.id
            ORDER BY so.transaction_date DESC";
    $result = $conn->query($sql);
    
    $records = [];
    while($row = $result->fetch_assoc()) {
        $records[] = $row;
    }
    
    echo json_encode($records);
}

function addStockOut($conn) {
    $data = json_decode(file_get_contents('php://input'), true);
    
    // Start transaction
    $conn->begin_transaction();
    
    try {
        // Check if enough stock is available
        $checkStmt = $conn->prepare("SELECT stock FROM products WHERE id = ? FOR UPDATE");
        $checkStmt->bind_param("i", $data['product_id']);
        $checkStmt->execute();
        $product = $checkStmt->get_result()->fetch_assoc();
        
        if ($product['stock'] < $data['quantity']) {
            throw new Exception("Not enough stock available");
        }
        
        // Add stock out record
        $stmt = $conn->prepare("INSERT INTO stock_out (product_id, quantity, unit_price, total_price, transaction_date) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iidds",
            $data['product_id'],
            $data['quantity'],
            $data['unit_price'],
            $data['total_price'],
            $data['transaction_date']
        );
        $stmt->execute();
        
        // Update product stock
        $updateStmt = $conn->prepare("UPDATE products SET stock = stock - ? WHERE id = ?");
        $updateStmt->bind_param("ii", $data['quantity'], $data['product_id']);
        $updateStmt->execute();
        
        // Update product status if stock reaches 0
        $statusStmt = $conn->prepare("UPDATE products SET status = CASE WHEN stock - ? <= 0 THEN 'out_of_stock' ELSE status END WHERE id = ?");
        $statusStmt->bind_param("ii", $data['quantity'], $data['product_id']);
        $statusStmt->execute();
        
        $conn->commit();
        echo json_encode(["success" => true, "id" => $stmt->insert_id]);
    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode(["error" => $e->getMessage()]);
    }
}

function updateStockOut($conn) {
    $data = json_decode(file_get_contents('php://input'), true);
    
    // Start transaction
    $conn->begin_transaction();
    
    try {
        // Get the original record to calculate the difference
        $originalStmt = $conn->prepare("SELECT product_id, quantity FROM stock_out WHERE id = ?");
        $originalStmt->bind_param("i", $data['id']);
        $originalStmt->execute();
        $original = $originalStmt->get_result()->fetch_assoc();
        
        $quantityDiff = $data['quantity'] - $original['quantity'];
        
        // Check if enough stock is available (for the difference)
        if ($quantityDiff > 0) {
            $checkStmt = $conn->prepare("SELECT stock FROM products WHERE id = ? FOR UPDATE");
            $checkStmt->bind_param("i", $original['product_id']);
            $checkStmt->execute();
            $product = $checkStmt->get_result()->fetch_assoc();
            
            if ($product['stock'] < $quantityDiff) {
                throw new Exception("Not enough stock available for this update");
            }
        }
        
        // Update stock out record
        $stmt = $conn->prepare("UPDATE stock_out SET product_id = ?, quantity = ?, unit_price = ?, total_price = ?, transaction_date = ? WHERE id = ?");
        $stmt->bind_param("iiddsi",
            $data['product_id'],
            $data['quantity'],
            $data['unit_price'],
            $data['total_price'],
            $data['transaction_date'],
            $data['id']
        );
        $stmt->execute();
        
        // Update product stock
        $updateStmt = $conn->prepare("UPDATE products SET stock = stock - ? WHERE id = ?");
        $updateStmt->bind_param("ii", $quantityDiff, $data['product_id']);
        $updateStmt->execute();
        
        // Update product status if needed
        $statusStmt = $conn->prepare("UPDATE products SET status = CASE WHEN stock <= 0 THEN 'out_of_stock' ELSE 'active' END WHERE id = ?");
        $statusStmt->bind_param("i", $data['product_id']);
        $statusStmt->execute();
        
        $conn->commit();
        echo json_encode(["success" => true]);
    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode(["error" => $e->getMessage()]);
    }
}

function deleteStockOut($conn) {
    $id = $_GET['id'] ?? 0;
    
    // Start transaction
    $conn->begin_transaction();
    
    try {
        // Get the record to adjust the product stock
        $getStmt = $conn->prepare("SELECT product_id, quantity FROM stock_out WHERE id = ?");
        $getStmt->bind_param("i", $id);
        $getStmt->execute();
        $record = $getStmt->get_result()->fetch_assoc();
        
        // Delete the record
        $delStmt = $conn->prepare("DELETE FROM stock_out WHERE id = ?");
        $delStmt->bind_param("i", $id);
        $delStmt->execute();
        
        // Update product stock
        $updateStmt = $conn->prepare("UPDATE products SET stock = stock + ? WHERE id = ?");
        $updateStmt->bind_param("ii", $record['quantity'], $record['product_id']);
        $updateStmt->execute();
        
        // Update product status if needed
        $statusStmt = $conn->prepare("UPDATE products SET status = CASE WHEN stock > 0 THEN 'active' ELSE status END WHERE id = ?");
        $statusStmt->bind_param("i", $record['product_id']);
        $statusStmt->execute();
        
        $conn->commit();
        echo json_encode(["success" => true]);
    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode(["error" => $e->getMessage()]);
    }
}

$conn->close();