<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}
require_once '../config.php';

if (isset($_GET['toggle'])) {
    $id = $_GET['toggle'];
    $pdo->query("UPDATE cakes SET availability = NOT availability WHERE id = $id");
    header("Location: manage_cakes.php");
    exit;
}
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $pdo->query("DELETE FROM cakes WHERE id = $id");
    header("Location: manage_cakes.php");
    exit;
}

$cakes = $pdo->query("SELECT * FROM cakes ORDER BY id DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Cakes - Dove Bakes</title>
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
        table { width: 100%; border-collapse: collapse; background: white; border-radius: 10px; overflow: hidden; box-shadow: var(--shadow-sm); }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid #eee; }
        th { background: var(--light-teal); color: var(--dark-teal); }
        .header-flex { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        img { width: 50px; height: 50px; object-fit: cover; border-radius: 5px; }
        .actions a { margin-right: 10px; color: var(--dark-teal); transition: 0.2s; font-size: 1.2rem; }
        .actions a:hover { color: var(--primary-teal); }
        .status { padding: 5px 10px; border-radius: 20px; font-size: 0.85rem; font-weight: 500; }
        .status.in-stock { background: #d4edda; color: #155724; }
        .status.out-of-stock { background: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="logo"><i class="fa-solid fa-cake-candles"></i> Dove Bakes</div>
        <a href="dashboard.php"><i class="fa-solid fa-house"></i> Dashboard</a>
        <a href="manage_cakes.php" class="active"><i class="fa-solid fa-cake-candles"></i> Manage Cakes</a>
        <a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
    </div>
    <div class="main-content">
        <div class="header-flex">
            <h2 style="color: var(--dark-teal);">Manage Cakes</h2>
            <a href="add_product.php" class="btn btn-primary" style="padding: 10px 20px; font-size: 0.9rem;"><i class="fa-solid fa-plus"></i> Add New Cake</a>
        </div>
        
        <table>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Price</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            <?php foreach($cakes as $cake): ?>
            <tr>
                <td><img src="<?= htmlspecialchars($cake['image']) ?>" alt="Cake"></td>
                <td><?= htmlspecialchars($cake['name']) ?></td>
                <td>₹<?= number_format($cake['price'], 2) ?></td>
                <td>
                    <span class="status <?= $cake['availability'] ? 'in-stock' : 'out-of-stock' ?>">
                        <?= $cake['availability'] ? 'In Stock' : 'Out of Stock' ?>
                    </span>
                </td>
                <td class="actions">
                    <a href="?toggle=<?= $cake['id'] ?>" title="Toggle Availability"><i class="fa-solid fa-power-off"></i></a>
                    <a href="?delete=<?= $cake['id'] ?>" onclick="return confirm('Are you sure?');" title="Delete" style="color:#e74c3c;"><i class="fa-solid fa-trash"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php if(empty($cakes)): ?>
            <tr><td colspan="5" style="text-align:center;">No cakes found. Add one!</td></tr>
            <?php endif; ?>
        </table>
    </div>
</body>
</html>
