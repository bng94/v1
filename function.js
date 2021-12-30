
$(document).ready(function() {

  $(window).scroll(function () {
    var intViewportHeight = window.innerHeight;
    if ($(window).scrollTop() > intViewportHeight) {
      $('.navbar').addClass('navbar-fixed');
    }
    if ($(window).scrollTop() < intViewportHeight) {
      $('.navbar').removeClass('navbar-fixed');
    }
  });

  $("form.contact").submit(function(event){
    event.preventDefault();
    var formData = new FormData(this);
    let submitName = $("input[type=submit]", this).attr('name');
    let submitVal = $("input[type=submit]", this).val();
    formData.append(submitName, submitVal);
    $.ajax({
      url: './includes/contact.inc.php',
      data: formData,
      processData: false,
      contentType: false,
      cache: false,
      type: 'POST',
      error: function (xhr, ajaxOptions, thrownError) {
        if(xhr.status != 200){
          $('.formResults').html('Error '+xhr.status+'<br/> Something Went Wrong');
          $('.formResults').addClass('error');
          console.log(xhr);
          console.log(ajaxOptions);
          console.log(thrownError);
        }
      }
    }).done(function(data){
        $('.formResults').html(data);
    });
  });


  (function ($) {
    $.fn.extend({
      limiter: function (minLimit, maxLimit, counter) {
        $(this).on("keydown keyup focus keypress", function (e) {
            setCount(this, counter, e);
        });

        function setCount(thisInput, counter, e) {
          var chars = thisInput.value.length;
          if (chars == maxLimit) {
            counter.html(maxLimit - chars+' / 4000');
            counter.addClass('maxLimit');
            return false;
          } else if (chars > maxLimit) {
            thisInput.value = thisInput.value.substr(0, maxLimit);
            chars = maxLimit;
            counter.addClass('maxLimit');
          } else {
            counter.removeClass('maxLimit');
          }
          if (chars < minLimit) {
            counter.addClass('minLimit');
          } else {
            counter.removeClass('minLimit');
          }
          counter.html(maxLimit - chars+' / 4000');
        }
        setCount($(this)[0], counter);
      }
    });
  })(jQuery);
  
  var counter = $(".chars");
  $("#msg").limiter(100, 4000, counter);

  //if no animation use this:
  // $(".burger").click(function (){
  //   $(".nav-links").toggleClass("nav-active");
  //   $(".burger").toggleClass("toggle");
  // });

  var selector = 'ul.navbar-list li';
  var url = window.location.href;
  var target = url;
  $(selector).each(function(){
    console.log(target)
    if($(this).find('a').attr('href')===(target)){
      $(selector).find('a').removeClass('active');
      $(this).find('a').removeClass('active').addClass('active');
    }
  });
});
function navSlide() {
  const burger = document.querySelector(".burger");
  const nav = document.querySelector(".nav-links");
  const navLinks = document.querySelectorAll(".nav-links li");
  
  burger.addEventListener("click", () => {
      //Toggle Nav
      nav.classList.toggle("nav-active");  
      //Animate Links
      navLinks.forEach((link, index) => {
          if (link.style.animation) {
              link.style.animation = ""
          } else {
              link.style.animation = `navLinkFade 0.3s ease forwards ${index / 7 + 0.5}s`;
          }
      });
      //Burger Animation
      burger.classList.toggle("toggle");
  });
}

navSlide();

