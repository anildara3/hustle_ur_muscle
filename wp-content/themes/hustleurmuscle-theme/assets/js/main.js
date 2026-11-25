/**
 * HUSTLE UR MUSCLE / COACH SAGAR SOMA - WORDPRESS JAVASCRIPT & JQUERY
 * Handles Dynamic Hero Slider, Testimonials Swiper, Search, Interactive Modals, Counters, CF7 Toast & Fallback AJAX Forms
 */

jQuery(document).ready(function ($) {
  'use strict';

  const wpData = typeof window.hustleurmuscleData !== 'undefined' ? window.hustleurmuscleData : null;
  const themeUrl = wpData && wpData.themeUrl ? wpData.themeUrl : '.';

  // 1. Initialize AOS (Animate on Scroll)
  if (typeof AOS !== 'undefined') {
    AOS.init({
      duration: 850,
      easing: 'ease-out-cubic',
      once: true,
      offset: 50
    });
  }

  // 2. Sticky Header & Back to Top behavior on Scroll
  const $header = $('.main-header');
  const $backToTop = $('.back-to-top');
  const isInitiallyScrolled = $header.hasClass('scrolled');

  $(window).on('scroll', function () {
    const scrollPos = $(this).scrollTop();

    if (!isInitiallyScrolled) {
      if (scrollPos > 60) {
        $header.addClass('scrolled');
      } else {
        $header.removeClass('scrolled');
      }
    }

    if (scrollPos > 400) {
      $backToTop.addClass('show');
    } else {
      $backToTop.removeClass('show');
    }
  });

  // Back to top click
  $backToTop.on('click', function (e) {
    e.preventDefault();
    $('html, body').animate({ scrollTop: 0 }, 600);
  });

  // 3. Hero Section Slider Logic (supports dynamic CPT slides via wpData.slides)
  const defaultSlides = [
    {
      image: themeUrl + '/assets/images/hero-bg.jpg',
      tag: 'COACH SAGAR SOMA — HUSTLE UR MUSCLE',
      title: 'KEEP YOUR <span class="highlight">BODY FIT &amp; STRONG</span>',
      description: 'Transform your physique with science-based personal training, tailored nutrition protocols, and 1-on-1 expert coaching designed for life-changing results with Sagar Soma.'
    },
    {
      image: themeUrl + '/assets/images/about-1.jpg',
      tag: 'NO PAIN NO GAIN',
      title: 'UNLEASH YOUR <span class="highlight">TRUE POWER &amp; AGILITY</span>',
      description: 'Elevate your performance and endurance. Our customized functional strength conditioning at Hustle Ur Muscle unlocks peak athletic capability.'
    },
    {
      image: themeUrl + '/assets/images/banner-gym.jpg',
      tag: 'ELITE TRAINING METHOD',
      title: 'BUILD LEAN MUSCLE <span class="highlight">&amp; PEAK RESILIENCE</span>',
      description: 'Step into the personal training zone with professional equipment, certified guidance from Coach Sagar Soma, and relentless motivation.'
    }
  ];

  const slides = (wpData && Array.isArray(wpData.slides) && wpData.slides.length > 0) ? wpData.slides : defaultSlides;

  let currentSlide = 0;
  const slideIntervalTime = 6500;
  let slideTimer;

  function showSlide(index) {
    if (!$('.hero-slide').length || !slides.length) return;
    if (index < 0) index = slides.length - 1;
    if (index >= slides.length) index = 0;
    currentSlide = index;

    const slideData = slides[currentSlide];

    const $heroContent = $('.hero-content');
    $heroContent.css('opacity', 0.2);

    setTimeout(function () {
      $('#heroTag').text(slideData.tag);
      $('#heroTitle').html(slideData.title);
      $('#heroDesc').text(slideData.description);
      $heroContent.css('opacity', 1);
    }, 250);

    $('.hero-slide').removeClass('active');
    $(`.hero-slide[data-slide="${currentSlide}"]`).addClass('active');

    $('.hero-dot').removeClass('active');
    $(`.hero-dot[data-index="${currentSlide}"]`).addClass('active');
  }

  function startSlideShow() {
    if ($('.hero-slide').length > 1) {
      slideTimer = setInterval(function () {
        showSlide(currentSlide + 1);
      }, slideIntervalTime);
    }
  }

  function stopSlideShow() {
    clearInterval(slideTimer);
  }

  $('.hero-dot').on('click', function () {
    stopSlideShow();
    const targetIdx = parseInt($(this).data('index'), 10);
    showSlide(targetIdx);
    startSlideShow();
  });

  startSlideShow();

  // 4. Testimonials Swiper Carousel
  if ($('.testimonial-swiper').length && typeof Swiper !== 'undefined') {
    new Swiper('.testimonial-swiper', {
      slidesPerView: 1,
      spaceBetween: 30,
      loop: $('.testimonial-swiper .swiper-slide').length > 3,
      autoplay: {
        delay: 5000,
        disableOnInteraction: false
      },
      pagination: {
        el: '.testimonial-swiper-pagination',
        clickable: true
      },
      breakpoints: {
        768: {
          slidesPerView: 2,
          spaceBetween: 25
        },
        1200: {
          slidesPerView: 3,
          spaceBetween: 30
        }
      }
    });
  }

  // 5. Search Overlay Toggle
  const $searchOverlay = $('#searchOverlay');
  $('#searchTriggerBtn, .open-search').on('click', function (e) {
    e.preventDefault();
    $searchOverlay.addClass('active');
    setTimeout(function () {
      $searchOverlay.find('input').focus();
    }, 200);
  });

  $('#searchCloseBtn').on('click', function () {
    $searchOverlay.removeClass('active');
  });

  $(document).on('keydown', function (e) {
    if (e.key === 'Escape' && $searchOverlay.hasClass('active')) {
      $searchOverlay.removeClass('active');
    }
  });

  // 6. Smooth Scroll for internal navigation links
  $('a[href^="#"]').on('click', function (e) {
    const href = this.getAttribute('href');
    if (!href || href === '#') return;
    const target = $(href);
    if (target.length) {
      e.preventDefault();
      $('.navbar-collapse').collapse('hide');

      $('html, body').stop().animate({
        scrollTop: target.offset().top - 80
      }, 700);
    }
  });

  // 7. Contact Form 7 Integration (Close Modal & Trigger Success Toast)
  document.addEventListener('wpcf7mailsent', function (event) {
    const modalEl = document.getElementById('consultationModal');
    if (modalEl && modalEl.contains(event.target)) {
      const consultationModal = bootstrap.Modal.getInstance(modalEl);
      if (consultationModal) consultationModal.hide();
      $('#contactSuccessToast').find('.toast-body').text('Thank you! Your trial session has been scheduled. Coach Sagar Soma from Hustle Ur Muscle will contact you shortly.');
    } else {
      $('#contactSuccessToast').find('.toast-body').text('Thank you for reaching out! Coach Sagar Soma from Hustle Ur Muscle will contact you within 24 hours.');
    }
    $('#contactSuccessToast').toast('show');
  }, false);

  // 8. Fallback Native Form Handlers (used if CF7 plugin is disabled)
  $('#contactForm, #contactPageForm').on('submit', function (e) {
    e.preventDefault();
    const $form = $(this);
    const $btn = $form.find('button[type="submit"]');
    const originalText = $btn.html();
    const isPageForm = $form.attr('id') === 'contactPageForm';

    const payload = {
      action: 'hum_submit_form',
      nonce: wpData ? wpData.nonce : '',
      form_type: isPageForm ? 'inquiry' : 'contact',
      name: isPageForm ? $('#cName').val() : $('#contactName').val(),
      phone: isPageForm ? $('#cPhone').val() : $('#contactPhone').val(),
      email: isPageForm ? $('#cEmail').val() : $('#contactEmail').val(),
      goal: isPageForm ? $('#cService').val() : $('#contactGoal').val(),
      time: isPageForm ? $('#cTime').val() : '',
      city: isPageForm ? $('#cCity').val() : '',
      message: isPageForm ? $('#cMessage').val() : $('#contactMessage').val()
    };

    $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> SUBMITTING...');

    const showFeedback = function (msg) {
      $btn.prop('disabled', false).html(originalText);
      if (msg) {
        $('#contactSuccessToast').find('.toast-body').text(msg);
      }
      $('#contactSuccessToast').toast('show');
      $form[0].reset();
    };

    if (wpData && wpData.ajaxUrl) {
      $.post(wpData.ajaxUrl, payload)
        .done(function (res) {
          const msg = res && res.data && res.data.message ? res.data.message : '';
          showFeedback(msg);
        })
        .fail(function () {
          showFeedback();
        });
    } else {
      setTimeout(function () {
        showFeedback();
      }, 1200);
    }
  });

  $('#consultationForm').on('submit', function (e) {
    e.preventDefault();
    const $form = $(this);
    const $btn = $form.find('button[type="submit"]');
    const originalText = $btn.html();

    const payload = {
      action: 'hum_submit_form',
      nonce: wpData ? wpData.nonce : '',
      form_type: 'consultation',
      name: $form.find('input[type="text"]').val(),
      phone: $form.find('input[type="tel"]').val(),
      time: $form.find('select').val()
    };

    $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> BOOKING...');

    const finishBooking = function () {
      $btn.prop('disabled', false).html(originalText);
      const consultationModal = bootstrap.Modal.getInstance(document.getElementById('consultationModal'));
      if (consultationModal) consultationModal.hide();
      $('#contactSuccessToast').find('.toast-body').text('Thank you! Your trial session has been scheduled. Coach Sagar Soma from Hustle Ur Muscle will contact you shortly.');
      $('#contactSuccessToast').toast('show');
      $form[0].reset();
    };

    if (wpData && wpData.ajaxUrl) {
      $.post(wpData.ajaxUrl, payload).always(finishBooking);
    } else {
      setTimeout(finishBooking, 1200);
    }
  });

  // 9. Interactive BMI Calculator
  $('#calculateBmiBtn').on('click', function () {
    const weight = parseFloat($('#bmiWeight').val());
    const height = parseFloat($('#bmiHeight').val()) / 100;

    if (weight > 0 && height > 0) {
      const bmi = (weight / (height * height)).toFixed(1);
      let category = '';
      let badgeClass = '';

      if (bmi < 18.5) {
        category = 'Underweight';
        badgeClass = 'bg-info';
      } else if (bmi >= 18.5 && bmi < 24.9) {
        category = 'Normal weight (Healthy)';
        badgeClass = 'bg-success';
      } else if (bmi >= 25 && bmi < 29.9) {
        category = 'Overweight';
        badgeClass = 'bg-warning text-dark';
      } else {
        category = 'Obese';
        badgeClass = 'bg-danger';
      }

      $('#bmiScoreVal').text(bmi);
      $('#bmiCategoryBadge').text(category).attr('class', `badge ${badgeClass} fs-6 py-2 px-3`);
      $('#bmiResultWrap').slideDown();
    } else {
      alert('Please enter valid positive values for weight and height.');
    }
  });

  // 10. Number Counter Animation on scroll
  let countersAnimated = false;
  $(window).on('scroll', function () {
    const $counterSection = $('.experience-badge, .section-stats-dark').first();
    if ($counterSection.length && !countersAnimated) {
      const oTop = $counterSection.offset().top - window.innerHeight;
      if ($(window).scrollTop() > oTop) {
        $('.count-number').each(function () {
          const $this = $(this);
          const countTo = $this.attr('data-count');
          $({ countNum: $this.text() }).animate({
            countNum: countTo
          },
          {
            duration: 2000,
            easing: 'swing',
            step: function () {
              $this.text(Math.floor(this.countNum));
            },
            complete: function () {
              $this.text(this.countNum);
            }
          });
        });
        countersAnimated = true;
      }
    }
  });

});
