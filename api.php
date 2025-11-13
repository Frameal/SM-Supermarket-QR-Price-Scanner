<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');

$host = 'localhost';
$dbname = 'sm_supermarket';
$username = 'root';
$password = '';

// Create connection
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo json_encode([
        'success' => false,
        'error' => 'Database connection failed: ' . $e->getMessage()
    ]);
    exit();
}

$method = $_SERVER['REQUEST_METHOD'];

$action = isset($_GET['action']) ? $_GET['action'] : '';

if ($method === 'GET' && $action === 'scan') {
    // Get product by QR code
    $qr_code = isset($_GET['qr_code']) ? $_GET['qr_code'] : '';
    
    if (empty($qr_code)) {
        echo json_encode([
            'success' => false,
            'error' => 'QR code is required'
        ]);
        exit();
    }
    
    try {
        $stmt = $pdo->prepare("SELECT product_id, product_name, product_price, qr_code, created_at FROM products WHERE qr_code = ?");
        $stmt->execute([$qr_code]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($product) {
            echo json_encode([
                'success' => true,
                'product' => [
                    'id' => $product['product_id'],
                    'name' => $product['product_name'],
                    'price' => floatval($product['product_price']),
                    'code' => $product['qr_code'],
                    'created_at' => $product['created_at']
                ]
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'error' => 'Product not found'
            ]);
        }
    } catch(PDOException $e) {
        echo json_encode([
            'success' => false,
            'error' => 'Query failed: ' . $e->getMessage()
        ]);
    }
    
} elseif ($method === 'GET' && $action === 'products') {
    // Get all products
    try {
        $stmt = $pdo->query("SELECT product_id, product_name, product_price, qr_code, created_at FROM products ORDER BY product_ID");
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo json_encode([
            'success' => true,
            'products' => $products
        ]);
    } catch(PDOException $e) {
        echo json_encode([
            'success' => false,
            'error' => 'Query failed: ' . $e->getMessage()
        ]);
    }
    
} elseif ($method === 'POST' && $action === 'add') {
    // Add new product (Admin only)
    $data = json_decode(file_get_contents('php://input'), true);
    
    $product_name = isset($data['product_name']) ? $data['product_name'] : '';
    $product_price = isset($data['product_price']) ? $data['product_price'] : 0;
    $qr_code = isset($data['qr_code']) ? $data['qr_code'] : '';
    
    if (empty($product_name) || empty($qr_code)) {
        echo json_encode([
            'success' => false,
            'error' => 'Product name and QR code are required'
        ]);
        exit();
    }
    
    try {
        $stmt = $pdo->prepare("INSERT INTO products (product_name, product_price, qr_code) VALUES (?, ?, ?)");
        $stmt->execute([$product_name, $product_price, $qr_code]);
        
        echo json_encode([
            'success' => true,
            'message' => 'Product added successfully',
            'product_id' => $pdo->lastInsertId()
        ]);
    } catch(PDOException $e) {
        if ($e->getCode() == 23000) {
            echo json_encode([
                'success' => false,
                'error' => 'QR code already exists'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'error' => 'Insert failed: ' . $e->getMessage()
            ]);
        }
    }
    
} elseif ($method === 'POST' && $action === 'update') {
    // Update product (Admin only)
    $data = json_decode(file_get_contents('php://input'), true);
    
    $product_id = isset($data['product_id']) ? $data['product_id'] : 0;
    $product_name = isset($data['product_name']) ? $data['product_name'] : '';
    $product_price = isset($data['product_price']) ? $data['product_price'] : 0;
    
    if (empty($product_id) || empty($product_name)) {
        echo json_encode([
            'success' => false,
            'error' => 'Product ID and name are required'
        ]);
        exit();
    }
    
    try {
        $stmt = $pdo->prepare("UPDATE products SET product_name = ?, product_price = ? WHERE product_id = ?");
        $stmt->execute([$product_name, $product_price, $product_id]);
        
        echo json_encode([
            'success' => true,
            'message' => 'Product updated successfully'
        ]);
    } catch(PDOException $e) {
        echo json_encode([
            'success' => false,
            'error' => 'Update failed: ' . $e->getMessage()
        ]);
    }
    
} elseif ($method === 'POST' && $action === 'delete') {
    // Delete product (Admin only)
    $data = json_decode(file_get_contents('php://input'), true);
    
    $product_id = isset($data['product_id']) ? $data['product_id'] : 0;
    
    if (empty($product_id)) {
        echo json_encode([
            'success' => false,
            'error' => 'Product ID is required'
        ]);
        exit();
    }
    
    try {
        $stmt = $pdo->prepare("DELETE FROM products WHERE product_id = ?");
        $stmt->execute([$product_id]);
        
        echo json_encode([
            'success' => true,
            'message' => 'Product deleted successfully'
        ]);
    } catch(PDOException $e) {
        echo json_encode([
            'success' => false,
            'error' => 'Delete failed: ' . $e->getMessage()
        ]);
    }
    
} elseif (empty($action)) {
    echo json_encode([
        'success' => false,
        'error' => 'No action specified',
        'help' => 'Available actions: scan (GET), products (GET), add (POST), update (POST), delete (POST)',
        'examples' => [
            'Get all products' => 'api.php?action=products',
            'Scan product' => 'api.php?action=scan&qr_code=QR001'
        ]
    ]);
} else {
    // Invalid endpoint
    echo json_encode([
        'success' => false,
        'error' => 'Invalid API endpoint or method',
        'received' => [
            'method' => $method,
            'action' => $action
        ]
    ]);
}

$pdo = null;
?>