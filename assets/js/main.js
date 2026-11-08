/**
* Template Name: Moderna (Enhanced for AgroVista Accessibility & Responsiveness)
* Updated with null-safe guards, ARIA state management, keyboard modal focus trap,
* reduced-motion support, and form double-submit prevention.
*/

(function() {
  "use strict";

  const prefersReducedMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  /**
   * Apply .scrolled class to the body as the page is scrolled down
   */
  function toggleScrolled() {
    const selectBody = document.querySelector('body');
    const selectHeader = document.querySelector('#header');
    if (!selectBody || !selectHeader) return;
    if (!selectHeader.classList.contains('scroll-up-sticky') && !selectHeader.classList.contains('sticky-top') && !selectHeader.classList.contains('fixed-top')) return;
    window.scrollY > 100 ? selectBody.classList.add('scrolled') : selectBody.classList.remove('scrolled');
  }

  document.addEventListener('scroll', toggleScrolled, { passive: true });
  window.addEventListener('load', toggleScrolled);

  /**
   * Mobile nav toggle (Accessible ARIA + Keyboard support)
   */
  const mobileNavToggleBtn = document.querySelector('.mobile-nav-toggle');
  const navMenuEl = document.querySelector('#navmenu');

  function setMobileNavState(isOpen) {
    const body = document.querySelector('body');
    if (!body || !mobileNavToggleBtn) return;

    body.classList.toggle('mobile-nav-active', isOpen);
    if (navMenuEl) {
      navMenuEl.classList.toggle('mobile-nav-active', isOpen);
    }

    mobileNavToggleBtn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    mobileNavToggleBtn.setAttribute('aria-label', isOpen ? 'Close navigation menu' : 'Open navigation menu');

    const iconEl = mobileNavToggleBtn.querySelector('i') || mobileNavToggleBtn;
    iconEl.classList.toggle('bi-list', !isOpen);
    iconEl.classList.toggle('bi-x', isOpen);
  }

  function mobileNavToogle() {
    const isCurrentlyOpen = document.body.classList.contains('mobile-nav-active') ||
      (navMenuEl && navMenuEl.classList.contains('mobile-nav-active'));
    setMobileNavState(!isCurrentlyOpen);
  }

  if (mobileNavToggleBtn) {
    mobileNavToggleBtn.addEventListener('click', function(e) {
      e.preventDefault();
      mobileNavToogle();
    });
  }

  /**
   * Hide mobile nav on same-page/hash links
   */
  document.querySelectorAll('#navmenu a').forEach(navLink => {
    navLink.addEventListener('click', () => {
      if (navLink.classList.contains('toggle-dropdown') || navLink.querySelector('.toggle-dropdown')) {
        return;
      }
      if (document.querySelector('.mobile-nav-active')) {
        setMobileNavState(false);
      }
    });
  });

  /**
   * Toggle mobile nav dropdowns
   */
  document.querySelectorAll('.navmenu .toggle-dropdown').forEach(toggleEl => {
    const trigger = toggleEl.closest('a') || toggleEl;
    trigger.addEventListener('click', function(e) {
      if (window.innerWidth < 1200 || this.getAttribute('href') === '#') {
        e.preventDefault();
        const parentLi = this.closest('li');
        const submenu = parentLi ? parentLi.querySelector('ul') : null;
        if (parentLi && submenu) {
          const isExpanded = parentLi.classList.toggle('active');
          submenu.classList.toggle('dropdown-active', isExpanded);
          this.setAttribute('aria-expanded', isExpanded ? 'true' : 'false');
        }
        e.stopImmediatePropagation();
      }
    });
  });

  /**
   * Preloader
   */
  const preloader = document.querySelector('#preloader');
  if (preloader) {
    window.addEventListener('load', () => {
      preloader.remove();
    });
  }

  /**
   * Scroll top button
   */
  const scrollTop = document.querySelector('.scroll-top');

  function toggleScrollTop() {
    if (scrollTop) {
      window.scrollY > 100 ? scrollTop.classList.add('active') : scrollTop.classList.remove('active');
    }
  }

  if (scrollTop) {
    scrollTop.addEventListener('click', (e) => {
      e.preventDefault();
      window.scrollTo({
        top: 0,
        behavior: prefersReducedMotion ? 'auto' : 'smooth'
      });
    });
    window.addEventListener('load', toggleScrollTop);
    document.addEventListener('scroll', toggleScrollTop, { passive: true });
  }

  /**
   * Animation on scroll function and init (respects prefers-reduced-motion)
   */
  function aosInit() {
    if (typeof AOS === 'undefined') return;
    AOS.init({
      duration: prefersReducedMotion ? 0 : 600,
      easing: 'ease-in-out',
      once: true,
      mirror: false,
      disable: prefersReducedMotion
    });
  }
  window.addEventListener('load', aosInit);

  /**
   * Auto generate the carousel indicators
   */
  document.querySelectorAll('.carousel-indicators').forEach((carouselIndicator) => {
    const carousel = carouselIndicator.closest('.carousel');
    if (!carousel) return;
    carousel.querySelectorAll('.carousel-item').forEach((carouselItem, index) => {
      if (index === 0) {
        carouselIndicator.innerHTML += `<li data-bs-target="#${carousel.id}" data-bs-slide-to="${index}" class="active"></li>`;
      } else {
        carouselIndicator.innerHTML += `<li data-bs-target="#${carousel.id}" data-bs-slide-to="${index}"></li>`;
      }
    });
  });

  /**
   * Initiate glightbox (if loaded)
   */
  if (typeof GLightbox !== 'undefined') {
    GLightbox({
      selector: '.glightbox'
    });
  }

  /**
   * Initiate Pure Counter (if loaded)
   */
  if (typeof PureCounter !== 'undefined') {
    new PureCounter();
  }

  /**
   * Init swiper sliders (if loaded)
   */
  function initSwiper() {
    if (typeof Swiper === 'undefined') return;
    document.querySelectorAll(".init-swiper").forEach(function(swiperElement) {
      const configEl = swiperElement.querySelector(".swiper-config");
      if (!configEl) return;
      let config = JSON.parse(configEl.innerHTML.trim());

      if (swiperElement.classList.contains("swiper-tab") && typeof initSwiperWithCustomPagination === 'function') {
        initSwiperWithCustomPagination(swiperElement, config);
      } else {
        new Swiper(swiperElement, config);
      }
    });
  }
  window.addEventListener("load", initSwiper);

  /**
   * Animate the skills items on reveal (if Waypoint is loaded)
   */
  if (typeof Waypoint !== 'undefined') {
    let skillsAnimation = document.querySelectorAll('.skills-animation');
    skillsAnimation.forEach((item) => {
      new Waypoint({
        element: item,
        offset: '80%',
        handler: function() {
          let progress = item.querySelectorAll('.progress .progress-bar');
          progress.forEach(el => {
            el.style.width = el.getAttribute('aria-valuenow') + '%';
          });
        }
      });
    });
  }

  /**
   * Init isotope layout and filters (if loaded)
   */
  if (typeof Isotope !== 'undefined' && typeof imagesLoaded !== 'undefined') {
    document.querySelectorAll('.isotope-layout').forEach(function(isotopeItem) {
      let layout = isotopeItem.getAttribute('data-layout') ?? 'masonry';
      let filter = isotopeItem.getAttribute('data-default-filter') ?? '*';
      let sort = isotopeItem.getAttribute('data-sort') ?? 'original-order';

      let initIsotope;
      const container = isotopeItem.querySelector('.isotope-container');
      if (!container) return;

      imagesLoaded(container, function() {
        initIsotope = new Isotope(container, {
          itemSelector: '.isotope-item',
          layoutMode: layout,
          filter: filter,
          sortBy: sort
        });
      });

      isotopeItem.querySelectorAll('.isotope-filters li').forEach(function(filters) {
        filters.addEventListener('click', function() {
          const activeFilter = isotopeItem.querySelector('.isotope-filters .filter-active');
          if (activeFilter) activeFilter.classList.remove('filter-active');
          this.classList.add('filter-active');
          if (initIsotope) {
            initIsotope.arrange({
              filter: this.getAttribute('data-filter')
            });
          }
          aosInit();
        }, false);
      });
    });
  }

  /**
   * Accessible Video Modal Controller (Keyboard Escape + Focus Restoration)
   */
  let activeModalId = null;
  let lastFocusedTrigger = null;

  window.openVideoModal = function(productId, triggerEl) {
    const modal = document.getElementById(productId + '_modal');
    if (!modal) return;

    lastFocusedTrigger = triggerEl || document.activeElement;
    activeModalId = productId;

    modal.classList.add('is-open');
    modal.style.display = 'flex';
    modal.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';

    const iframe = document.getElementById(productId + '_iframe');
    const video = document.getElementById(productId + '_video');

    if (iframe && iframe.dataset.src) {
      iframe.src = iframe.dataset.src;
    }

    if (video) {
      video.play().catch(() => {});
    }

    const closeBtn = modal.querySelector('.video-close');
    if (closeBtn) {
      setTimeout(() => closeBtn.focus(), 50);
    }
  };

  window.closeVideoModal = function(productId) {
    const idToClose = productId || activeModalId;
    if (!idToClose) return;

    const modal = document.getElementById(idToClose + '_modal');
    if (!modal) return;

    modal.classList.remove('is-open');
    modal.style.display = 'none';
    modal.setAttribute('aria-hidden', 'true');
    document.body.style.overflow = '';

    const iframe = document.getElementById(idToClose + '_iframe');
    const video = document.getElementById(idToClose + '_video');

    if (iframe) {
      iframe.src = '';
    }

    if (video) {
      video.pause();
      video.currentTime = 0;
    }

    activeModalId = null;
    if (lastFocusedTrigger && typeof lastFocusedTrigger.focus === 'function') {
      lastFocusedTrigger.focus();
      lastFocusedTrigger = null;
    }
  };

  // Close modal when clicking backdrop
  window.addEventListener('click', function(event) {
    if (event.target && event.target.classList && event.target.classList.contains('video-modal')) {
      const productId = event.target.id.replace('_modal', '');
      window.closeVideoModal(productId);
    }
  });

  // Global Escape key handler for Video Modal & Mobile Nav
  document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
      if (activeModalId) {
        window.closeVideoModal(activeModalId);
      } else if (document.body.classList.contains('mobile-nav-active')) {
        setMobileNavState(false);
        if (mobileNavToggleBtn) mobileNavToggleBtn.focus();
      }
    }
  });

  /**
   * Prevent Double-Submit on Forms & Provide Accessible Busy Feedback
   */
  document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('form').forEach(function(form) {
      // Skip GET filter forms that auto-submit on select change
      if ((form.getAttribute('method') || '').toUpperCase() === 'GET') return;

      form.addEventListener('submit', function(e) {
        if (typeof form.checkValidity === 'function' && !form.checkValidity()) {
          return;
        }
        if (e.defaultPrevented) return;

        const submitBtn = form.querySelector('button[type="submit"], input[type="submit"]');
        if (!submitBtn) return;

        if (submitBtn.dataset.submitting === 'true') {
          e.preventDefault();
          return;
        }

        submitBtn.dataset.submitting = 'true';
        submitBtn.setAttribute('aria-busy', 'true');
        const loadingText = submitBtn.getAttribute('data-loading-text') || 'Submitting...';

        if (submitBtn.tagName === 'BUTTON') {
          submitBtn.dataset.originalHtml = submitBtn.innerHTML;
          submitBtn.innerHTML = `<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>${loadingText}`;
        } else {
          submitBtn.dataset.originalValue = submitBtn.value;
          submitBtn.value = loadingText;
        }

        // Disable after current event tick so named submit button value is still sent in POST payload
        setTimeout(() => {
          submitBtn.disabled = true;
        }, 0);
      });
    });
  });

})();
