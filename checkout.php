<?php
require_once 'config.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (!$data || empty($data['cart'])) {
    echo json_encode(['success' => false, 'message' => 'Cart is empty.']);
    exit;
}

try {
    $pdo->beginTransaction();

    // Insert order
    $stmt = $pdo->prepare("INSERT INTO orders (customer_name, customer_email, total_amount, payment_method, status) VALUES (?, ?, ?, ?, 'Completed')");
    $stmt->execute([
        $data['customer_name'],
        $data['customer_email'],
        $data['total'],
        $data['payment_method']
    ]);
    
    $orderId = $pdo->lastInsertId();

    // Insert order items
    $stmtItem = $pdo->prepare("INSERT INTO order_items (order_id, cake_id, quantity, price) VALUES (?, ?, ?, ?)");
    foreach ($data['cart'] as $item) {
        $stmtItem->execute([
            $orderId,
            $item['id'],
            $item['quantity'],
            $item['price']
        ]);
    }

    $pdo->commit();
    echo json_encode(['success' => true, 'order_id' => $orderId]);

} catch (Exception $e) {
    $pdo->rollBack();
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
?>
