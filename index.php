<?php
require_once 'config.php';
$cakes = $pdo->query("SELECT * FROM cakes LIMIT 3")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dove Bakes | Premium Bakery</title>
    <meta name="description" content="Delicious handcrafted premium cakes for every celebration.">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
  <!-- Header -->
  <header id="header">
      <div class="container navbar">
          <div class="logo">
              <i class="fa-solid fa-cake-candles"></i>
              <span>Dove Bakes</span>
          </div>
          <nav>
              <ul class="nav-links">
                  <li><a href="#home">Home</a></li>
                  <li><a href="#about">About</a></li>
                  <li><a href="#menu">Cakes</a></li>
                  <li><a href="#contact">Contact</a></li>
              </ul>
          </nav>
          <div class="cart-btn">
              <i class="fa-solid fa-cart-shopping"></i>
          </div>
          <!-- Mobile Menu Toggle -->
          <div class="mobile-toggle">
              <i class="fa-solid fa-bars"></i>
          </div>
      </div>
  </header>

  <!-- Hero Section -->
  <section id="home" class="hero">
      <div class="hero-overlay"></div>
      <div class="container hero-content">
          <h1 class="animate-fade-up">Delicious Cakes Made With Love</h1>
          <p class="animate-fade-up delay-1">Handcrafted premium cakes for every celebration and special moment</p>
          <div class="hero-buttons animate-fade-up delay-2">
              <a href="#menu" class="btn btn-primary">View Menu</a>
              <a href="#contact" class="btn btn-outline">Visit Us</a>
          </div>
      </div>
  </section>

  <!-- About Section -->
  <section id="about" class="about section-padding">
      <div class="container about-grid">
          <div class="about-text scroll-reveal left">
              <span class="tag">Our Story</span>
              <h2>Crafting Sweet Memories Since 1995</h2>
              <p>At Dove Bakes, baking is not just a process; it's an art form. We started as a small family kitchen with a passion for creating desserts that bring people together. Over the years, our dedication to quality and flavor has made us a beloved part of countless celebrations.</p>
              <p>Every cake is baked from scratch daily using only the finest ingredients. From rich Belgian chocolate to fresh local fruits, we ensure that every bite is an unforgettable experience. Join us in celebrating life's sweetest moments.</p>
          </div>
          <div class="about-image-wrapper scroll-reveal right">
              <img src="https://images.unsplash.com/photo-1550617931-e17a7b70dce2?auto=format&fit=crop&w=800&q=80" alt="Bakery interior" class="about-img">
              <div class="image-accent"></div>
          </div>
      </div>
  </section>

  <!-- Menu Section -->
  <section id="menu" class="menu section-padding bg-light">
      <div class="container">
          <div class="section-title scroll-reveal up">
              <h2>Our Signature Cakes</h2>
              <p>Choose from our three signature flavors crafted to perfection</p>
          </div>
          <div class="menu-grid">
              <?php $delay = 1; foreach($cakes as $cake): ?>
              <div class="menu-card scroll-reveal up delay-<?= $delay++ ?> <?= !$cake['availability'] ? 'out-of-stock-card' : '' ?>">
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
          </div>
          <div style="text-align: center; margin-top: 40px;">
              <a href="menu.php" class="btn btn-primary">View More Cakes</a>
          </div>
      </div>
  </section>

  <!-- Features Section -->
  <section class="features section-padding">
      <div class="container features-grid">
          <div class="feature-item scroll-reveal up">
              <div class="icon-box">
                  <i class="fa-solid fa-leaf"></i>
              </div>
              <h3>Fresh Daily</h3>
              <p>Baked fresh every morning using locally sourced ingredients.</p>
          </div>
          <div class="feature-item scroll-reveal up delay-1">
              <div class="icon-box">
                  <i class="fa-solid fa-truck-fast"></i>
              </div>
              <h3>Easy Ordering</h3>
              <p>Seamless online ordering process with fast delivery to your door.</p>
          </div>
          <div class="feature-item scroll-reveal up delay-2">
              <div class="icon-box">
                  <i class="fa-solid fa-wand-magic-sparkles"></i>
              </div>
              <h3>Custom Designs</h3>
              <p>Personalized decorations and messages for your special events.</p>
          </div>
      </div>
  </section>

  <!-- Testimonials -->
  <section class="testimonials section-padding bg-light">
      <div class="container">
          <div class="section-title scroll-reveal up">
              <h2>What Our Customers Say</h2>
          </div>
          <div class="testimonials-grid">
              <div class="testimonial-card scroll-reveal up delay-1">
                  <div class="stars">
                      <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                  </div>
                  <p>"The Red Velvet Delight was the highlight of our anniversary. Absolutely perfectly balanced sweetness!"</p>
                  <div class="customer">
                      <div class="avatar" style="background: var(--teal-light);">S</div>
                      <div class="customer-info">
                          <h4>Sarah Jenkins</h4>
                          <span>Verified Buyer</span>
                      </div>
                  </div>
              </div>
              <div class="testimonial-card scroll-reveal up delay-2">
                  <div class="stars">
                      <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star-half-stroke"></i>
                  </div>
                  <p>"Dove Bakes made the most beautiful birthday cake for my daughter. The detail and taste were incredible."</p>
                  <div class="customer">
                      <div class="avatar" style="background: var(--pastel-pink);">M</div>
                      <div class="customer-info">
                          <h4>Michael Chen</h4>
                          <span>Verified Buyer</span>
                      </div>
                  </div>
              </div>
              <div class="testimonial-card scroll-reveal up delay-3">
                  <div class="stars">
                      <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                  </div>
                  <p>"Best chocolate fudge cake in the city. Delivery was fast, and the packaging kept everything perfect."</p>
                  <div class="customer">
                      <div class="avatar" style="background: var(--pastel-yellow);">E</div>
                      <div class="customer-info">
                          <h4>Emily Davis</h4>
                          <span>Verified Buyer</span>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </section>

  <!-- Contact Section -->
  <section id="contact" class="contact section-padding">
      <div class="contact-bg-pattern"></div>
      <div class="container contact-wrapper scroll-reveal up">
          <div class="contact-info">
              <h2>Get in Touch</h2>
              <p>We'd love to hear from you. Stop by our bakery or send us a message.</p>
              <ul class="info-list">
                  <li>
                      <div class="icon-circle"><i class="fa-solid fa-location-dot"></i></div>
                      <div>
                          <h4>Address</h4>
                          <p>123 Bakery Lane, Sweet City, SC 45678</p>
                      </div>
                  </li>
                  <li>
                      <div class="icon-circle"><i class="fa-solid fa-clock"></i></div>
                      <div>
                          <h4>Working Hours</h4>
                          <p>Mon - Sat: 8:00 AM - 8:00 PM<br>Sun: 9:00 AM - 4:00 PM</p>
                      </div>
                  </li>
                  <li>
                      <div class="icon-circle"><i class="fa-solid fa-phone"></i></div>
                      <div>
                          <h4>Phone</h4>
                          <p>(555) 123-4567</p>
                      </div>
                  </li>
                  <li>
                      <div class="icon-circle"><i class="fa-solid fa-envelope"></i></div>
                      <div>
                          <h4>Email</h4>
                          <p>hello@dovebakes.com</p>
                      </div>
                  </li>
              </ul>
          </div>
          <div class="contact-form-container">
              <form class="glass-form" onsubmit="event.preventDefault();">
                  <div class="form-group">
                      <label for="name">Name</label>
                      <input type="text" id="name" placeholder="John Doe" required>
                  </div>
                  <div class="form-group">
                      <label for="email">Email</label>
                      <input type="email" id="email" placeholder="john@example.com" required>
                  </div>
                  <div class="form-group">
                      <label for="message">Message</label>
                      <textarea id="message" rows="4" placeholder="How can we help you?" required></textarea>
                  </div>
                  <button type="submit" class="btn btn-primary btn-block">Send Message</button>
              </form>
          </div>
      </div>
  </section>

  <!-- Footer -->
  <footer>
      <div class="container footer-content">
          <div class="logo">
              <i class="fa-solid fa-cake-candles"></i>
              <span>Dove Bakes</span>
          </div>
          <p>&copy; 2026 Dove Bakes. All rights reserved.</p>
      </div>
  </footer>

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

  <script src="script.js"></script>
</body>
</html>
