import './bootstrap';

function addToCart(id, qty = 1) {
    fetch('/cart/add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ product_id: id, quantity: qty })
    }).then(r => r.json()).then(j => {
        const badge = document.getElementById('cart-badge');
        if (badge) badge.innerText = j.cartCount;
    }).catch(() => { });
}

document.addEventListener('click', function (e) {
    const t = e.target;
    if (t.matches('.btn-add')) {
        e.preventDefault();
        const id = t.dataset.id;
        const qtyInput = document.querySelector('#qty');
        const qty = qtyInput ? Number(qtyInput.value || 1) : 1;
        addToCart(id, qty);
        t.innerText = 'Đã thêm';
        setTimeout(() => t.innerText = 'Thêm vào giỏ', 1200);
    }
});

// Mobile menu toggle
document.addEventListener('DOMContentLoaded', function () {
    const btn = document.querySelector('.mobile-toggle');
    const menu = document.querySelector('.mobile-nav');
    if (btn && menu) {
        btn.addEventListener('click', function () {
            menu.classList.toggle('open');
        });
    }

    // Simple hero slider: rotates .hero-slide inside .hero-slider
    document.querySelectorAll('.hero-slider').forEach(function (slider) {
        const slides = Array.from(slider.querySelectorAll('.hero-slide'));
        const dotsWrap = slider.querySelector('.hero-dots');
        let idx = 0;
        if (!slides.length) return;
        slides.forEach((s, i) => s.classList.toggle('active', i === 0));
        if (dotsWrap) {
            slides.forEach((_, i) => {
                const d = document.createElement('div'); d.className = 'hero-dot' + (i === 0 ? ' active' : ''); d.dataset.idx = i; dotsWrap.appendChild(d);
            });
            dotsWrap.addEventListener('click', e => {
                if (!e.target.classList.contains('hero-dot')) return;
                goto(+e.target.dataset.idx);
            });
        }

        function goto(i) {
            slides[idx].classList.remove('active');
            if (dotsWrap) dotsWrap.children[idx].classList.remove('active');
            idx = (i + slides.length) % slides.length;
            slides[idx].classList.add('active');
            if (dotsWrap) dotsWrap.children[idx].classList.add('active');
        }

        setInterval(() => goto(idx + 1), 4500);
    });
    // Header shadow on scroll
    const header = document.getElementById('site-header');
    window.addEventListener('scroll', () => {
        header.classList.toggle('shadow-md', window.scrollY > 10);
    });

    // User dropdown
    const userToggle = document.getElementById('userToggle');
    const userMenu = document.getElementById('userMenu');

    userToggle?.addEventListener('click', () => {
        userMenu.classList.toggle('hidden');
    });

    // Mobile menu
    const mobileToggle = document.getElementById('mobileToggle');
    const mobileNav = document.getElementById('mobileNav');
    const mobileClose = document.getElementById('mobileClose');

    mobileToggle?.addEventListener('click', () => {
        mobileNav.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    });

    mobileClose?.addEventListener('click', () => {
        mobileNav.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    });
});
