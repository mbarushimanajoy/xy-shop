<?php
require_once 'config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $couponCode = $data['coupon'] ?? '';
    
    // Validate coupon code (in a real app, this would check the database)
    if ($couponCode === 'XYSHOP10') {
        $_SESSION['coupon'] = [
            'code' => 'XYSHOP10',
            'discount' => 0.1, // 10% discount
            'type' => 'percentage'
        ];
        
        echo json_encode([
            'success' => true,
            'message' => '10% discount applied!'
        ]);
    } else if ($couponCode === 'XYSHOP20') {
        $_SESSION['coupon'] = [
            'code' => 'XYSHOP20',
            'discount' => 0.2, // 20% discount
            'type' => 'percentage'
        ];
        
        echo json_encode([
            'success' => true,
            'message' => '20% discount applied!'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Invalid coupon code'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method'
    ]);
}
?>