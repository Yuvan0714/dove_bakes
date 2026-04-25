<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}
require_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image = $_POST['image']; // URL for simplicity
    
    $stmt = $pdo->prepare("INSERT INTO cakes (name, description, price, image, availability) VALUES (?, ?, ?, ?, 1)");
    $stmt->execute([$name, $description, $price, $image]);
    
    header("Location: manage_cakes.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Cake - Dove Bakes</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        body { background: var(--light-teal); display: flex; justify-content: center; align-items: center; min-height: 100vh; padding: 40px; }
        .form-container { background: white; padding: 40px; border-radius: 20px; box-shadow: var(--shadow-md); width: 100%; max-width: 500px; }
        .form-container h2 { color: var(--dark-teal); margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Add New Cake</h2>
        <form method="POST">
            <div class="form-group">
                <label>Cake Name</label>
                <input type="text" name="name" required>
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label>Price (₹)</label>
                <input type="number" name="price" step="0.01" required>
            </div>
            <div class="form-group">
                <label>Image URL</label>
                <input type="url" name="image" placeholder="https://..." required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Save Cake</button>
            <a href="manage_cakes.php" class="btn btn-outline btn-block" style="margin-top: 10px; color: var(--text-color); border-color: #ccc;">Cancel</a>
        </form>
    </div>
</body>
</html>
