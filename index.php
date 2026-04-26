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
          <div style="display:flex; align-items:center;">
              <a href="javascript:void(0)" class="nav-wa-icon" onclick="openWhatsApp()" style="margin-right: 15px;"><i class="fa-brands fa-whatsapp"></i></a>
              <div class="cart-btn">
                  <i class="fa-solid fa-cart-shopping"></i>
              </div>
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
          <div style="margin: 15px 0;">
              <a href="javascript:void(0)" onclick="openWhatsApp()" style="color: #25D366; font-size: 2rem;"><i class="fa-brands fa-whatsapp"></i></a>
          </div>
          <p>&copy; 2026 Dove Bakes. All rights reserved.</p>
      </div>
  </footer>

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

  <!-- Floating WhatsApp Button -->
  <a href="javascript:void(0)" class="wa-floating-btn" onclick="openWhatsApp()">
      <i class="fa-brands fa-whatsapp"></i>
  </a>

  <script src="script.js"></script>
</body>
</html>
