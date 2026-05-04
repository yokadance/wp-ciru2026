/* =====================================================
   CONGRESO DE CIRUGÍA 2026 — JavaScript
   ===================================================== */
(function () {
  'use strict';

  var cfg = window.congresoConfig || {};

  /* =====================================================
     HERO SLIDER
     ===================================================== */
  var heroEl = document.querySelector('.ciru-hero');
  if (heroEl) {
    var slides   = Array.from(heroEl.querySelectorAll('[data-slide-index]'));
    var dots     = Array.from(heroEl.querySelectorAll('.ciru-hero__dot'));
    var tabs     = Array.from(heroEl.querySelectorAll('.ciru-hero__event-tab'));
    var prevBtn  = heroEl.querySelector('.ciru-hero__arrow--prev');
    var nextBtn  = heroEl.querySelector('.ciru-hero__arrow--next');
    var progBar  = heroEl.querySelector('[data-progress]');

    var current   = 0;
    var autoTimer = null;
    var DELAY     = 5500; // ms entre slides

    function activate(index) {
      var total = slides.length;
      var next  = (index + total) % total;

      slides[current].classList.remove('is-active');
      if (dots[current])  dots[current].classList.remove('is-active');
      if (tabs[current])  tabs[current].classList.remove('is-active');

      current = next;

      slides[current].classList.add('is-active');
      if (dots[current])  dots[current].classList.add('is-active');
      if (tabs[current])  tabs[current].classList.add('is-active');

      // Progress bar
      if (progBar) {
        progBar.style.transition = 'none';
        progBar.style.width = '0%';
        requestAnimationFrame(function () {
          requestAnimationFrame(function () {
            progBar.style.transition = 'width ' + DELAY + 'ms linear';
            progBar.style.width = '100%';
          });
        });
      }
    }

    function startAuto() {
      clearInterval(autoTimer);
      autoTimer = setInterval(function () { activate(current + 1); }, DELAY);
    }
    function stopAuto() { clearInterval(autoTimer); }

    if (prevBtn) prevBtn.addEventListener('click', function () { activate(current - 1); startAuto(); });
    if (nextBtn) nextBtn.addEventListener('click', function () { activate(current + 1); startAuto(); });

    dots.forEach(function (d, i) {
      d.addEventListener('click', function () { activate(i); startAuto(); });
    });
    tabs.forEach(function (t, i) {
      t.addEventListener('click', function () { activate(i); startAuto(); });
    });

    heroEl.addEventListener('mouseenter', stopAuto);
    heroEl.addEventListener('mouseleave', startAuto);

    // Swipe táctil
    var touchX = 0;
    heroEl.addEventListener('touchstart', function (e) {
      touchX = e.touches[0].clientX;
    }, { passive: true });
    heroEl.addEventListener('touchend', function (e) {
      var diff = touchX - e.changedTouches[0].clientX;
      if (Math.abs(diff) > 50) {
        activate(current + (diff > 0 ? 1 : -1));
        startAuto();
      }
    });

    // Teclado
    document.addEventListener('keydown', function (e) {
      if (e.key === 'ArrowLeft')  { activate(current - 1); startAuto(); }
      if (e.key === 'ArrowRight') { activate(current + 1); startAuto(); }
    });

    activate(0);
    startAuto();
  }

  /* =====================================================
     CUENTA REGRESIVA
     ===================================================== */
  var targetDate = new Date(cfg.targetDate || '2026-09-15T00:00:00');

  function updateCountdown() {
    var now  = new Date();
    var diff = targetDate - now;
    if (diff <= 0) return;

    var d = Math.floor(diff / 864e5);
    var h = Math.floor((diff % 864e5) / 36e5);
    var m = Math.floor((diff % 36e5)  / 6e4);
    var s = Math.floor((diff % 6e4)   / 1e3);

    function pad(n) { return String(n).padStart(2, '0'); }
    function set(id, v) { var el = document.getElementById(id); if (el) el.textContent = pad(v); }

    set('countdown-days',    d);
    set('countdown-hours',   h);
    set('countdown-minutes', m);
    set('countdown-seconds', s);
  }

  if (document.getElementById('countdown-days')) {
    updateCountdown();
    setInterval(updateCountdown, 1000);
  }

  /* =====================================================
     TABS DE PRECIOS
     ===================================================== */
  document.querySelectorAll('.ciru-precios__tab').forEach(function (tab) {
    tab.addEventListener('click', function () {
      var target    = tab.dataset.tab;
      var container = tab.closest('.ciru-precios');
      if (!container) return;

      container.querySelectorAll('.ciru-precios__tab').forEach(function (t) {
        t.classList.remove('is-active');
      });
      container.querySelectorAll('.ciru-precios__panel').forEach(function (p) {
        p.classList.remove('is-active');
      });

      tab.classList.add('is-active');
      var panel = container.querySelector('#tab-' + target);
      if (panel) panel.classList.add('is-active');
    });
  });

  /* =====================================================
     FORMULARIO DE CONTACTO — AJAX
     ===================================================== */
  var contactForm = document.getElementById('congreso-contact-form');
  if (contactForm) {
    contactForm.addEventListener('submit', function (e) {
      e.preventDefault();

      var feedback = document.getElementById('form-feedback');
      var btn      = contactForm.querySelector('[type="submit"]');
      var data     = new FormData(contactForm);
      data.append('action', 'congreso_contact');
      data.append('nonce',  cfg.nonce || '');

      var originalText = btn.textContent;
      btn.disabled    = true;
      btn.textContent = 'Enviando…';
      if (feedback) { feedback.className = 'ciru-form__feedback'; feedback.textContent = ''; }

      fetch(cfg.ajaxUrl || '/wp-admin/admin-ajax.php', { method: 'POST', body: data })
        .then(function (r) { return r.json(); })
        .then(function (json) {
          if (feedback) {
            feedback.textContent = (json.data && json.data.message) || (json.success ? 'Mensaje enviado.' : 'Error al enviar.');
            feedback.className   = 'ciru-form__feedback ' + (json.success ? 'is-success' : 'is-error');
          }
          if (json.success) contactForm.reset();
        })
        .catch(function () {
          if (feedback) {
            feedback.textContent = 'Error de conexión. Por favor intente nuevamente.';
            feedback.className   = 'ciru-form__feedback is-error';
          }
        })
        .finally(function () {
          btn.disabled    = false;
          btn.textContent = originalText;
        });
    });
  }

  /* =====================================================
     SMOOTH SCROLL — links ancla internos
     ===================================================== */
  document.querySelectorAll('a[href^="#"]').forEach(function (link) {
    link.addEventListener('click', function (e) {
      var id = link.getAttribute('href').slice(1);
      if (!id) return;
      var target = document.getElementById(id);
      if (!target) return;
      e.preventDefault();
      var offset = document.querySelector('.site-header') ? 80 : 20;
      var top    = target.getBoundingClientRect().top + window.scrollY - offset;
      window.scrollTo({ top: top, behavior: 'smooth' });
    });
  });

})();
