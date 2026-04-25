document.addEventListener('DOMContentLoaded', () => {
    // 1. Sticky Header
    const header = document.getElementById('header');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 50) header.classList.add('scrolled');
        else header.classList.remove('scrolled');
    });

    // 2. Mobile Menu Toggle
    const mobileToggle = document.querySelector('.mobile-toggle');
    const navLinks = document.querySelector('.nav-links');
    if (mobileToggle) {
        mobileToggle.addEventListener('click', () => {
            navLinks.classList.toggle('active');
            const icon = mobileToggle.querySelector('i');
            if (navLinks.classList.contains('active')) {
                icon.classList.remove('fa-bars');
                icon.classList.add('fa-times');
            } else {
                icon.classList.remove('fa-times');
                icon.classList.add('fa-bars');
            }
        });
    }

    // Close mobile menu on click
    document.querySelectorAll('.nav-links a').forEach(link => {
        link.addEventListener('click', () => {
            navLinks.classList.remove('active');
            if(mobileToggle){
                mobileToggle.querySelector('i').classList.replace('fa-times', 'fa-bars');
            }
        });
    });

    // 3. Scroll Reveal Animations
    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.15 });
    document.querySelectorAll('.scroll-reveal').forEach(el => observer.observe(el));

    // 4. Parallax Effect
    const hero = document.querySelector('.hero');
    window.addEventListener('scroll', () => {
        if(hero && window.pageYOffset < hero.offsetHeight) {
            hero.style.backgroundPositionY = `${window.pageYOffset * 0.5}px`;
        }
    });

    // 5. Cart Logic
    let cart = JSON.parse(localStorage.getItem('dove_cart')) || [];
    const cartBtn = document.querySelector('.cart-btn');
    const cartSidebar = document.getElementById('cart-sidebar');
    const cartOverlay = document.getElementById('cart-overlay');
    const closeCartBtn = document.getElementById('close-cart');
    const cartItemsContainer = document.getElementById('cart-items');
    const cartTotalPrice = document.getElementById('cart-total-price');

    const updateCartCount = () => {
        let count = cart.reduce((sum, item) => sum + item.quantity, 0);
        // Could add a small badge here if desired
    };

    const saveCart = () => {
        localStorage.setItem('dove_cart', JSON.stringify(cart));
        renderCart();
    };

    const openCart = () => {
        renderCart();
        cartSidebar.classList.add('active');
        cartOverlay.classList.add('active');
        document.body.style.overflow = 'hidden';
    };

    const closeCart = () => {
        cartSidebar.classList.remove('active');
        cartOverlay.classList.remove('active');
        document.body.style.overflow = '';
    };

    cartBtn.addEventListener('click', openCart);
    closeCartBtn.addEventListener('click', closeCart);
    cartOverlay.addEventListener('click', closeCart);

    const renderCart = () => {
        cartItemsContainer.innerHTML = '';
        let total = 0;

        if (cart.length === 0) {
            cartItemsContainer.innerHTML = '<p style="text-align:center; color:var(--text-light); margin-top:20px;">Your cart is empty.</p>';
        } else {
            cart.forEach((item, index) => {
                total += item.price * item.quantity;
                cartItemsContainer.innerHTML += `
                    <div class="cart-item">
                        <img src="${item.img}" alt="${item.product}">
                        <div class="item-details">
                            <h4>${item.product}</h4>
                            <p>₹${item.price.toLocaleString('en-IN')}</p>
                            <div class="qty-controls">
                                <button onclick="updateQty(${index}, -1)"><i class="fa-solid fa-minus"></i></button>
                                <span>${item.quantity}</span>
                                <button onclick="updateQty(${index}, 1)"><i class="fa-solid fa-plus"></i></button>
                            </div>
                        </div>
                        <button class="remove-item" onclick="removeItem(${index})"><i class="fa-solid fa-trash"></i></button>
                    </div>
                `;
            });
        }
        cartTotalPrice.textContent = '₹' + total.toLocaleString('en-IN');
        updateCartCount();
    };

    window.updateQty = (index, change) => {
        cart[index].quantity += change;
        if (cart[index].quantity <= 0) cart.splice(index, 1);
        saveCart();
    };

    window.removeItem = (index) => {
        cart.splice(index, 1);
        saveCart();
    };

    document.querySelectorAll('.btn-add-cart').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.getAttribute('data-id');
            const product = btn.getAttribute('data-product');
            const price = parseInt(btn.getAttribute('data-price'));
            const img = btn.getAttribute('data-img');

            const existingItem = cart.find(item => item.id === id);
            if (existingItem) existingItem.quantity += 1;
            else cart.push({ id, product, price, img, quantity: 1 });

            saveCart();
            openCart();
        });
    });

    // 6. Payment Gateway Logic
    const paymentModal = document.getElementById('payment-modal');
    const closePaymentBtn = document.getElementById('close-payment');
    const checkoutBtn = document.getElementById('checkout-btn');
    const checkoutProduct = document.getElementById('checkout-product');
    const checkoutPrice = document.getElementById('checkout-price');
    const checkoutForm = document.getElementById('checkout-form');
    const payBtn = document.getElementById('pay-btn');
    const payText = document.querySelector('.pay-text');
    const spinner = document.querySelector('.spinner');
    const paymentSuccess = document.getElementById('payment-success');
    const continueShoppingBtn = document.getElementById('continue-shopping');
    const paymentMethods = document.querySelectorAll('.method');
    const paymentInputsGroups = document.querySelectorAll('.payment-inputs-group');
    const selectedMethodInput = document.getElementById('selected-payment-method');

    // Dynamic Payment Methods
    paymentMethods.forEach(method => {
        method.addEventListener('click', () => {
            // Update active styling
            paymentMethods.forEach(m => m.classList.remove('active'));
            method.classList.add('active');
            
            const methodType = method.getAttribute('data-method');
            selectedMethodInput.value = methodType;
            
            // Hide all input groups
            paymentInputsGroups.forEach(group => {
                group.style.display = 'none';
            });
            
            // Show corresponding input group
            if(methodType === 'Card') document.getElementById('card-inputs').style.display = 'block';
            else if(methodType === 'UPI') document.getElementById('upi-inputs').style.display = 'block';
            else if(methodType === 'Netbanking') document.getElementById('netbanking-inputs').style.display = 'block';
        });
    });

    // Open Checkout from Cart
    checkoutBtn.addEventListener('click', () => {
        if(cart.length === 0) return alert('Your cart is empty!');
        
        let total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        let productsStr = cart.map(item => `${item.product} (x${item.quantity})`).join(', ');
        
        checkoutProduct.textContent = productsStr;
        checkoutPrice.textContent = total.toLocaleString('en-IN') + '.00';
        document.getElementById('success-product').textContent = productsStr;
        
        closeCart(); // Close cart sidebar
        
        // Reset form
        checkoutForm.reset();
        paymentSuccess.classList.remove('active');
        checkoutForm.style.opacity = '1';
        checkoutForm.style.visibility = 'visible';
        payBtn.style.display = 'block';
        
        paymentModal.classList.add('active');
        document.body.style.overflow = 'hidden';
    });

    const closePaymentModal = () => {
        paymentModal.classList.remove('active');
        document.body.style.overflow = '';
        setTimeout(() => {
            paymentSuccess.classList.remove('active');
            checkoutForm.style.opacity = '1';
            checkoutForm.style.visibility = 'visible';
            payBtn.style.display = 'block';
        }, 500);
    };

    closePaymentBtn.addEventListener('click', closePaymentModal);
    continueShoppingBtn.addEventListener('click', () => {
        closePaymentModal();
        cart = []; // Empty cart after success
        saveCart();
    });

    paymentModal.addEventListener('click', (e) => {
        if (e.target === paymentModal) closePaymentModal();
    });

    checkoutForm.addEventListener('submit', (e) => {
        e.preventDefault();
        
        // Simulate processing and AJAX to checkout.php
        payText.style.display = 'none';
        spinner.style.display = 'inline-block';
        payBtn.disabled = true;
        payBtn.style.opacity = '0.8';
        
        // Prepare data to send to server
        const orderData = {
            cart: cart,
            total: cart.reduce((sum, item) => sum + (item.price * item.quantity), 0),
            payment_method: selectedMethodInput.value,
            customer_name: 'Guest User', // Hardcoded for demo, normally from form
            customer_email: 'guest@example.com'
        };

        fetch('checkout.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(orderData)
        })
        .then(res => res.json())
        .then(data => {
            // Processing complete
            payText.style.display = 'inline';
            spinner.style.display = 'none';
            payBtn.disabled = false;
            payBtn.style.opacity = '1';
            
            if(data.success) {
                // Show success animation
                checkoutForm.style.opacity = '0';
                checkoutForm.style.visibility = 'hidden';
                payBtn.style.display = 'none';
                setTimeout(() => paymentSuccess.classList.add('active'), 300);
            } else {
                alert("Payment failed: " + data.message);
            }
        })
        .catch(err => {
            console.error(err);
            alert("An error occurred during checkout.");
            payText.style.display = 'inline';
            spinner.style.display = 'none';
            payBtn.disabled = false;
            payBtn.style.opacity = '1';
        });
    });
});
