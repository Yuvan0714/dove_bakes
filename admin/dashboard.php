<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}
require_once '../config.php';

// Get counts
$cakesCount = $pdo->query("SELECT COUNT(*) FROM cakes")->fetchColumn();
$ordersCount = $pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn();
$revenue = $pdo->query("SELECT SUM(total_amount) FROM orders")->fetchColumn() ?: 0;

$recentOrders = $pdo->query("SELECT * FROM orders ORDER BY created_at DESC LIMIT 5")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - Dove Bakes</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { display: flex; background: var(--bg-color); margin: 0; }
        .sidebar { width: 250px; background: var(--dark-teal); color: white; min-height: 100vh; padding: 20px 0; }
        .sidebar .logo { padding: 0 20px 20px; font-size: 1.5rem; font-weight: 700; border-bottom: 1px solid rgba(255,255,255,0.1); margin-bottom: 20px; display: block;}
        .sidebar a { display: block; padding: 15px 20px; color: rgba(255,255,255,0.8); transition: var(--transition); }
        .sidebar a:hover, .sidebar a.active { background: rgba(255,255,255,0.1); color: white; border-left: 4px solid var(--primary-teal); }
        .sidebar a i { width: 25px; }
        .main-content { flex: 1; padding: 40px; }
        .cards { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 40px; }
        .card { background: white; padding: 20px; border-radius: 10px; box-shadow: var(--shadow-sm); }
        .card h3 { color: var(--text-light); font-size: 1rem; margin-bottom: 10px; }
        .card .val { font-size: 2rem; font-weight: 700; color: var(--dark-teal); }
        table { width: 100%; border-collapse: collapse; background: white; border-radius: 10px; overflow: hidden; box-shadow: var(--shadow-sm); }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid #eee; }
        th { background: var(--light-teal); color: var(--dark-teal); }
        .status { padding: 5px 10px; border-radius: 20px; font-size: 0.85rem; font-weight: 500; }
        .status.pending { background: #fff3cd; color: #856404; }
        .status.completed { background: #d4edda; color: #155724; }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="logo"><i class="fa-solid fa-cake-candles"></i> Dove Bakes</div>
        <a href="dashboard.php" class="active"><i class="fa-solid fa-house"></i> Dashboard</a>
        <a href="manage_cakes.php"><i class="fa-solid fa-cake-candles"></i> Manage Cakes</a>
        <a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
    </div>
    <div class="main-content">
        <h2 style="margin-bottom: 30px; color: var(--dark-teal);">Dashboard Overview</h2>
        
        <div class="cards">
            <div class="card">
                <h3>Total Products</h3>
                <div class="val"><?= $cakesCount ?></div>
            </div>
            <div class="card">
                <h3>Total Orders</h3>
                <div class="val"><?= $ordersCount ?></div>
            </div>
            <div class="card">
                <h3>Revenue</h3>
                <div class="val">₹<?= number_format($revenue, 2) ?></div>
            </div>
        </div>

        <h3 style="margin-bottom: 15px; color: var(--dark-teal);">Recent Orders</h3>
        <table>
            <tr>
                <th>Order ID</th>
                <th>Customer</th>
                <th>Amount</th>
                <th>Method</th>
                <th>Status</th>
                <th>Date</th>
            </tr>
            <?php foreach($recentOrders as $order): ?>
            <tr>
                <td>#<?= $order['id'] ?></td>
                <td><?= htmlspecialchars($order['customer_name']) ?></td>
                <td>₹<?= number_format($order['total_amount'], 2) ?></td>
                <td><?= $order['payment_method'] ?></td>
                <td><span class="status <?= strtolower($order['status']) ?>"><?= $order['status'] ?></span></td>
                <td><?= date('M d, Y', strtotime($order['created_at'])) ?></td>
            </tr>
            <?php endforeach; ?>
            <?php if(empty($recentOrders)): ?>
            <tr><td colspan="6" style="text-align:center;">No orders yet.</td></tr>
            <?php endif; ?>
        </table>
    </div>
</body>
</html>
