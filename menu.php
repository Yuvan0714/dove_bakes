<?php
require_once 'config.php';
$cakes = $pdo->query("SELECT * FROM cakes ORDER BY id DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Menu - Dove Bakes</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { padding-top: 80px; }
        .navbar { background: white; box-shadow: var(--shadow-sm); }
        .navbar a { color: var(--text-color); }
        .logo { color: var(--dark-teal); }
        .cart-btn { color: var(--dark-teal); }
        .mobile-toggle { color: var(--dark-teal); }
    </style>
</head>
<body>
  <!-- Header -->
  <header id="header" class="scrolled">
      <div class="container navbar">
          <div class="logo">
              <i class="fa-solid fa-cake-candles"></i>
              <span>Dove Bakes</span>
          </div>
          <nav>
              <ul class="nav-links">
                  <li><a href="index.php">Home</a></li>
                  <li><a href="menu.php" style="color:var(--primary-teal)">Cakes</a></li>
              </ul>
          </nav>
          <div style="display:flex; align-items:center;">
              <a href="javascript:void(0)" class="nav-wa-icon" onclick="openWhatsApp()" style="margin-right: 15px;"><i class="fa-brands fa-whatsapp"></i></a>
              <div class="cart-btn">
                  <i class="fa-solid fa-cart-shopping"></i>
              </div>
          </div>
          <div class="mobile-toggle">
              <i class="fa-solid fa-bars"></i>
          </div>
      </div>
  </header>

  <section class="menu section-padding bg-light" style="min-height: 70vh;">
      <div class="container">
          <div class="section-title">
              <h2>All Our Cakes</h2>
              <p>Explore our full selection of delicious handcrafted cakes.</p>
          </div>
          <div class="menu-grid">
              <?php foreach($cakes as $cake): ?>
              <div class="menu-card <?= !$cake['availability'] ? 'out-of-stock-card' : '' ?>">
                  <div class="card-img">
                      <img src="<?= htmlspecialchars($cake['image']) ?>" alt="<?= htmlspecialchars($cake['name']) ?>">
                      <?php if(!$cake['availability']): ?>
                          <div class="out-of-stock-overlay">Out of Stock</div>
                      <?php endif; ?>
                  </div>
                  <div class="card-content">
                      <h3><?= htmlspecialchars($cake['name']) ?></h3>
                      <p><?= htmlspecialchars($cake['description']) ?></p>
                      <div class="card-footer">
                          <span class="price">₹<?= number_format($cake['price'], 0) ?></span>
                          <?php if($cake['availability']): ?>
                              <button class="btn-add btn-add-cart" data-id="<?= $cake['id'] ?>" data-price="<?= $cake['price'] ?>" data-product="<?= htmlspecialchars($cake['name']) ?>" data-img="<?= htmlspecialchars($cake['image']) ?>"><i class="fa-solid fa-cart-plus"></i> Add to Cart</button>
                          <?php else: ?>
                              <button class="btn-add" disabled style="background:#ddd; color:#999; cursor:not-allowed;"><i class="fa-solid fa-ban"></i> Unavailable</button>
                          <?php endif; ?>
                      </div>
                  </div>
              </div>
              <?php endforeach; ?>
              <?php if(empty($cakes)): ?>
              <p style="text-align:center; width:100%; color:var(--text-light)">No cakes available right now.</p>
              <?php endif; ?>
          </div>
      </div>
  </section>

  <!-- Payment Gateway Modal Removed -->

  <!-- Slide-in Cart -->
  <div class="cart-overlay" id="cart-overlay"></div>
  <div class="cart-sidebar" id="cart-sidebar">
      <div class="cart-header">
          <h2>Your Cart</h2>
          <button class="close-cart" id="close-cart"><i class="fa-solid fa-xmark"></i></button>
      </div>
      <div class="cart-items" id="cart-items">
          <!-- Items injected via JS -->
      </div>
      <div class="cart-footer">
          <div class="cart-total">
              <span>Total:</span>
              <span class="total-price" id="cart-total-price">₹0</span>
          </div>
          <button class="btn btn-whatsapp btn-block" id="checkout-btn" onclick="openWhatsApp()"><i class="fa-brands fa-whatsapp"></i> Order on WhatsApp</button>
      </div>
  </div>

  <footer>
      <div class="container footer-content" style="text-align: center; padding: 20px;">
          <div style="margin-bottom: 15px;">
              <a href="javascript:void(0)" onclick="openWhatsApp()" style="color: #25D366; font-size: 2rem;"><i class="fa-brands fa-whatsapp"></i></a>
          </div>
          <p>&copy; 2026 Dove Bakes. All rights reserved.</p>
      </div>
  </footer>

  <!-- Floating WhatsApp Button -->
  <a href="javascript:void(0)" class="wa-floating-btn" onclick="openWhatsApp()">
      <i class="fa-brands fa-whatsapp"></i>
  </a>

  <script src="script.js"></script>
</body>
</html>
