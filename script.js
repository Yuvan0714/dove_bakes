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
            if (mobileToggle) {
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
        if (hero && window.pageYOffset < hero.offsetHeight) {
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

    // 6. WhatsApp Integration Logic
    window.openWhatsApp = () => {
        // [Replace with your real WhatsApp number]
        const storeNumber = '6374845889';
        let message = '';

        if (cart.length > 0) {
            let total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            let itemsText = cart.map(item => `${item.quantity} ${item.product}`).join('%0A');

            message = `Hello Dove Bakes, I would like to order:%0A%0A${itemsText}%0A%0ATotal: ₹${total}%0A%0APlease confirm my order. Thank you!`;
        } else {
            message = `Hello Dove Bakes, I would like to know more about your cakes, custom orders, pricing, and availability. Please share the details. Thank you!`;
        }

        const whatsappUrl = `https://wa.me/${storeNumber}?text=${message}`;
        window.open(whatsappUrl, '_blank');

        // Optional: close cart after opening WA
        if (cartSidebar.classList.contains('active')) {
            closeCart();
        }
    };
});
