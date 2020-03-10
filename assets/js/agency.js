(function($) {
  "use strict"; // Start of use strict

  // Smooth scrolling using jQuery easing
  $('a.js-scroll-trigger[href*="#"]:not([href="#"])').click(function() {
    if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
      if (target.length) {
        $('html, body').animate({
          scrollTop: (target.offset().top - 54)
        }, 1000, "easeInOutExpo");
        return false;
      }
    }
  });

  // Closes responsive menu when a scroll trigger link is clicked
  $('.js-scroll-trigger').click(function() {
    $('.navbar-collapse').collapse('hide');
  });

  // Activate scrollspy to add active class to navbar items on scroll
  $('body').scrollspy({
    target: '#mainNav',
    offset: 56
  });

  // Collapse Navbar
  var navbarCollapse = function() {
    if ($("#mainNav").offset().top > 100) {
      $("#mainNav").addClass("navbar-shrink");
    } else {
      $("#mainNav").removeClass("navbar-shrink");
    }
  };
  // Collapse now if page is not at top
  navbarCollapse();
  // Collapse the navbar when page is scrolled
  $(window).scroll(navbarCollapse);

  // Hide navbar when modals trigger
  $('.portfolio-modal').on('show.bs.modal', function(e) {
    $('.navbar').addClass('d-none');
  })
  $('.portfolio-modal').on('hidden.bs.modal', function(e) {
    $('.navbar').removeClass('d-none');
  })

  $("#contactForm").on('submit',function(e){
    e.preventDefault();
    var name = $("input#name").val();
    var email = $("input#email").val();
    var phone = $("input#phone").val();
    var captchaResult = grecaptcha.getResponse();
    var message = $("textarea#message").val();

    var button = $("#sendMessageButton");
    button.prop("disabled", true); // Disable submit button until AJAX call is complete to prevent duplicate messages
    $.ajax({
      url: host_url+"api/sendMessage/",
      type: "POST",
      data: {
        name: name,
        phone: phone,
        email: email,
        message: message,
        captchaToken: captchaResult
      },
      cache: false,
      success: function() {
        // Success message
        $('#success').html("<div class='alert alert-success'>");
        $('#success > .alert-success').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
          .append("</button>");
        $('#success > .alert-success')
          .append("<strong>Tu mensaje ha sido enviado, te responderemos pronto.</strong>");
        $('#success > .alert-success')
          .append('</div>');
        //clear all fields
        $('#contactForm').trigger("reset");
        grecaptcha.reset();
      },
      error: function(err) {
        // Fail message
        $('#success').html("<div class='alert alert-danger'>");
        $('#success > .alert-danger').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
          .append("</button>");
        $('#success > .alert-danger').append($("<strong>").text(err.responseJSON.msg));
        $('#success > .alert-danger').append('</div>');
        grecaptcha.reset();
      },
      complete: function() {
        setTimeout(function() {
          button.prop("disabled", false); // Re-enable submit button when AJAX call is complete
        }, 1000);
      }
    });
  })

  $("a[data-toggle=\"tab\"]").click(function(e) {
    e.preventDefault();
    $(this).tab("show");
  });
  
  /*When clicking on Full hide fail/success boxes */
  $('#name').focus(function() {
    $('#success').html('');
  });
  
  

})(jQuery); // End of use strict
