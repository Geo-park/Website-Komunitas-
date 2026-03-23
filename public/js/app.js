// ==============================
// HIMA INFORMATIKA — JavaScript
// ==============================

// --- HELPERS ---
const $ = (id) => document.getElementById(id);
const $$ = (sel) => document.querySelectorAll(sel);

// --- NAVBAR SCROLL ---
const navbar = $('navbar');
if (navbar) {
  window.addEventListener('scroll', () => {
    navbar.classList.toggle('scrolled', window.scrollY > 20);
  }, { passive: true });
}

// --- HAMBURGER MENU (mobile) ---
const hamburger = $('hamburger');
const navMenu = $('navMenu');

if (hamburger && navMenu) {
  hamburger.addEventListener('click', () => {
    const isOpen = navMenu.classList.toggle('open');
    hamburger.setAttribute('aria-expanded', isOpen);
    const spans = hamburger.querySelectorAll('span');
    if (isOpen) {
      spans[0].style.transform = 'rotate(45deg) translate(5px, 5px)';
      spans[1].style.opacity = '0';
      spans[2].style.transform = 'rotate(-45deg) translate(5px, -5px)';
    } else {
      spans.forEach(s => { s.style.transform = ''; s.style.opacity = ''; });
    }
  });

  // Close nav on outside click
  document.addEventListener('click', (e) => {
    if (!navbar.contains(e.target)) {
      navMenu.classList.remove('open');
      hamburger.querySelectorAll('span').forEach(s => { s.style.transform = ''; s.style.opacity = ''; });
    }
  });

  // Dropdown toggle on mobile: tap parent nav-link with arrow
  $$('.nav-item.has-dropdown').forEach(item => {
    const link = item.querySelector('.nav-link');
    if (link) {
      link.addEventListener('click', (e) => {
        // Only intercept on mobile (hamburger visible)
        if (window.innerWidth <= 900) {
          e.preventDefault();
          item.classList.toggle('open');
        }
      });
    }
  });

  // Close nav when a leaf link is clicked
  $$('.dropdown a, .nav-item:not(.has-dropdown) .nav-link').forEach(link => {
    link.addEventListener('click', () => {
      navMenu.classList.remove('open');
      hamburger.querySelectorAll('span').forEach(s => { s.style.transform = ''; s.style.opacity = ''; });
    });
  });
}

// --- SERVER FLASH TOAST AUTO-DISMISS ---
const serverToast = $('serverToast');
if (serverToast) {
  setTimeout(() => serverToast.classList.remove('show'), 4000);
}

// --- FILTER TABS (PROGRAM) ---
const filterBtns = $$('.filter-btn[data-filter]');
const programCards = $$('.program-card');

if (filterBtns.length && programCards.length) {
  filterBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      filterBtns.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      const filter = btn.dataset.filter;
      programCards.forEach(card => {
        const show = filter === 'all' || card.dataset.cat === filter;
        card.style.opacity = show ? '1' : '0.25';
        card.style.transform = show ? '' : 'scale(0.95)';
        card.style.pointerEvents = show ? '' : 'none';
      });
    });
  });
}

// --- MARKETPLACE TABS ---
const marketTabs = $$('.market-tab');
const marketCards = $$('.market-card');

if (marketTabs.length && marketCards.length) {
  marketTabs.forEach(tab => {
    tab.addEventListener('click', () => {
      marketTabs.forEach(t => t.classList.remove('active'));
      tab.classList.add('active');
      const filter = tab.dataset.tab;
      marketCards.forEach(card => {
        const show = filter === 'all' || card.dataset.market === filter;
        card.style.display = show ? '' : 'none';
      });
    });
  });
}

document.addEventListener('DOMContentLoaded', () => {
  // Placeholder for updateCartUI if it exists elsewhere
  // updateCartUI(); 

  // --- Announcement Carousel ---
  const carousel = document.getElementById('announcementCarousel');
  if (carousel) {
    const slides = carousel.querySelectorAll('.carousel-slide');
    const prevBtn = document.querySelector('.carousel-control.prev');
    const nextBtn = document.querySelector('.carousel-control.next');
    const indicators = document.querySelectorAll('.indicator');
    
    if (slides.length > 1) {
      let currentSlide = 0;
      let slideInterval;

      const goToSlide = (n) => {
        slides[currentSlide].classList.remove('active');
        if (indicators.length) indicators[currentSlide].classList.remove('active');
        
        currentSlide = (n + slides.length) % slides.length;
        
        slides[currentSlide].classList.add('active');
        if (indicators.length) indicators[currentSlide].classList.add('active');
      };

      const nextSlide = () => goToSlide(currentSlide + 1);
      const prevSlide = () => goToSlide(currentSlide - 1);

      const startSlide = () => {
        slideInterval = setInterval(nextSlide, 5000); // 5 seconds
      };

      const resetSlide = () => {
        clearInterval(slideInterval);
        startSlide();
      };

      if (nextBtn) nextBtn.addEventListener('click', () => { nextSlide(); resetSlide(); });
      if (prevBtn) prevBtn.addEventListener('click', () => { prevSlide(); resetSlide(); });

      indicators.forEach((indicator, idx) => {
        indicator.addEventListener('click', () => {
          goToSlide(idx);
          resetSlide();
        });
      });

      startSlide();
    }
  }
});

// --- TOAST ---
function showToast(msg, type) {
  const toast = $('toast');
  if (!toast) return;
  toast.textContent = msg;
  if (type === 'success') toast.style.borderColor = '#4ade80';
  else toast.style.borderColor = '';
  toast.classList.add('show');
  setTimeout(() => {
    toast.classList.remove('show');
    toast.style.borderColor = '';
  }, 3500);
}

// --- GALERI FILTER (client-side, used on home preview) ---
const galBtns = $$('.gal-btn[data-gal]');
const galItems = $$('.gal-item');

if (galBtns.length && galItems.length) {
  galBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      galBtns.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      const filter = btn.dataset.gal;
      galItems.forEach(item => {
        const show = filter === 'all' || item.dataset.galCat === filter;
        item.style.opacity = show ? '1' : '0.2';
        item.style.transform = show ? '' : 'scale(0.9)';
        item.style.pointerEvents = show ? '' : 'none';
      });
    });
  });
}

// --- INTERSECTION OBSERVER (REVEAL ANIMATIONS) ---
const revealObserver = new IntersectionObserver(entries => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.style.opacity = '1';
      entry.target.style.transform = 'translateY(0)';
      revealObserver.unobserve(entry.target);
    }
  });
}, { threshold: 0.08 });

document.querySelectorAll('.program-card, .market-card, .vm-card, .mission-item, .sosmed-card, .org-card, .gal-item').forEach(el => {
  // Skip if already positioned absolutely
  if (getComputedStyle(el).position === 'absolute') return;
  el.style.opacity = '0';
  el.style.transform = 'translateY(20px)';
  el.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
  revealObserver.observe(el);
});

// --- ACTIVE NAV LINK STYLE ---
const styleActive = document.createElement('style');
styleActive.textContent = `.active-nav { color: var(--accent) !important; }`;
document.head.appendChild(styleActive);

// Console branding
console.log(
  '%c⬡ HIMA INFORMATIKA\n%cBersama Maju, Berinovasi Tanpa Batas',
  'color:#a855f7;font-size:1.2rem;font-weight:bold;',
  'color:#9880b8;font-size:0.85rem;'
);
