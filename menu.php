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
          <div class="cart-btn">
              <i class="fa-solid fa-cart-shopping"></i>
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

  <!-- Payment Gateway Modal -->
  <div class="payment-overlay" id="payment-modal">
      <div class="payment-modal-content">
          <button class="close-modal" id="close-payment"><i class="fa-solid fa-xmark"></i></button>
          
          <div class="payment-header">
              <h3>Secure Checkout</h3>
              <p>Complete your purchase for <strong id="checkout-product">Product</strong></p>
          </div>
          
          <div class="payment-amount">
              <span class="currency">₹</span>
              <span id="checkout-price">0.00</span>
          </div>
          
          <form class="payment-form" id="checkout-form" onsubmit="event.preventDefault();">
              <input type="hidden" id="selected-payment-method" value="Card">
              <div class="payment-methods">
                  <div class="method active" data-method="Card"><i class="fa-regular fa-credit-card"></i> Card</div>
                  <div class="method" data-method="UPI"><i class="fa-brands fa-google-pay"></i> UPI</div>
                  <div class="method" data-method="Netbanking"><i class="fa-solid fa-building-columns"></i> Netbanking</div>
              </div>
              
              <!-- Card Inputs -->
              <div id="card-inputs" class="payment-inputs-group active-group">
                  <div class="form-group">
                      <label for="card-name">Name on Card</label>
                      <input type="text" id="card-name" placeholder="John Doe" required>
                  </div>
                  <div class="form-group">
                      <label for="card-num">Card Number</label>
                      <div class="input-with-icon">
                          <i class="fa-brands fa-cc-visa" style="color:var(--text-light)"></i>
                          <input type="text" id="card-num" placeholder="0000 0000 0000 0000" maxlength="19" required>
                      </div>
                  </div>
                  <div class="form-row" style="display:flex; gap:15px;">
                      <div class="form-group" style="flex:1;">
                          <label for="expiry">Expiry</label>
                          <input type="text" id="expiry" placeholder="MM/YY" maxlength="5" required>
                      </div>
                      <div class="form-group" style="flex:1;">
                          <label for="cvv">CVV</label>
                          <input type="password" id="cvv" placeholder="123" maxlength="3" required>
                      </div>
                  </div>
              </div>

              <!-- UPI Inputs -->
              <div id="upi-inputs" class="payment-inputs-group" style="display:none;">
                  <div class="form-group">
                      <label for="upi-id">UPI ID</label>
                      <div class="input-with-icon">
                          <i class="fa-solid fa-at" style="color:var(--text-light)"></i>
                          <input type="text" id="upi-id" placeholder="username@upi">
                      </div>
                  </div>
              </div>

              <!-- Netbanking Inputs -->
              <div id="netbanking-inputs" class="payment-inputs-group" style="display:none;">
                  <div class="form-group">
                      <label for="bank-select">Select Bank</label>
                      <select id="bank-select" style="width: 100%; padding: 12px 15px; border: 1px solid rgba(0,0,0,0.1); border-radius: 10px; font-family: inherit;">
                          <option value="">Choose a bank...</option>
                          <option value="sbi">State Bank of India</option>
                          <option value="hdfc">HDFC Bank</option>
                          <option value="icici">ICICI Bank</option>
                          <option value="axis">Axis Bank</option>
                      </select>
                  </div>
              </div>
              
              <button type="submit" class="btn btn-primary btn-block btn-pay" id="pay-btn">
                  <span class="pay-text">Pay Now</span>
                  <div class="spinner" style="display:none;"><i class="fa-solid fa-circle-notch fa-spin"></i> Processing...</div>
              </button>
          </form>
          
          <div class="payment-success" id="payment-success">
              <div class="success-icon"><i class="fa-solid fa-circle-check"></i></div>
              <h3>Payment Successful!</h3>
              <p>Your order for <span id="success-product" style="font-weight:600;color:var(--dark-teal)"></span> has been placed.</p>
              <button class="btn btn-primary btn-block" id="continue-shopping">Continue Shopping</button>
          </div>
      </div>
  </div>

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
          <button class="btn btn-primary btn-block" id="checkout-btn">Proceed to Checkout</button>
      </div>
  </div>

  <footer>
      <div class="container footer-content" style="text-align: center; padding: 20px;">
          <p>&copy; 2026 Dove Bakes. All rights reserved.</p>
      </div>
  </footer>

  <script src="script.js"></script>
</body>
</html>
