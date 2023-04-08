$(document).ready(function () {
  if (/Edge\/\d./i.test(navigator.userAgent)) {
    $('html').addClass('ie');
  };

  // Animation
  new WOW().init();

  //Background image
  $("#banner, .choose-me .figure2").each(function () {
    var src = $(this).find("img").attr("src");
    $(this).find('img').css("visibility", "hidden");
    $(this).css("background-image", "url(" + src + ")");
    $(this).css("background-repeat", "no-repeat");
    $(this).css("background-size", "cover");
  });


  // Main-menu
  $('#main-menu').meanmenu({
    meanScreenWidth: "767",
    meanMenuContainer: '.mobile-menu',
  });

  // Slideshow 
$(".slideshow").owlCarousel({    
  items : 1, 
  itemsDesktop : false,
  itemsDesktopSmall : false,
  itemsTablet: false,
  itemsMobile : false,
  autoplay:true,
  slideSpeed : 300,
  autoplayTimeout:5000,
  autoplayHoverPause:false, //Set AutoPlay to 3 seconds
  nav : false,
  dots: true,
  loop:true
});

$(".slideshow-2").owlCarousel({    
  center: true,
  items : 5, 
  itemsDesktop : false,
  itemsDesktopSmall : false,
  itemsTablet: false,
  itemsMobile : false,
  autoplay:true,
  slideSpeed : 300,
  autoplayTimeout:5000,
  autoplayHoverPause:false, //Set AutoPlay to 3 seconds
  nav : false,
  dots: false,
  loop:true,
  responsive:{
    0:{
        items: 3,
    },
    576:{
        items: 2
    },
    768:{
        items: 3
    },
    992:{
      items: 4
    },
    1200:{
      items: 5
  }
}
});

//Match height
$(".match-height .column").matchHeight();
// Add minus icon for collapse element which is open by default
$(".collapse.show").each(function(){
  $(this).prev(".card-header").addClass("show-desc");
});

// Toggle plus minus icon on show hide of collapse element
$(".collapse").on('show.bs.collapse', function(){
  $(this).prev(".card-header").addClass("show-desc");
}).on('hide.bs.collapse', function(){
  $(this).prev(".card-header").removeClass("show-desc");
});

});

 // Image object fit 
// $(window).load(function () { 
//   objectFitImages();
// });

//sticky header
$(window).on("scroll", function () {
  var headerHeight = $('#header').height();
  var totalHeight = headerHeight; 
  var totalDHeight = headerHeight*2;
    if ($(window).scrollTop() >= totalHeight) {
      $('#header').addClass('fixed-header box-shadow');
      // $('#banner').css('margin-top', totalDHeight);
    }
    else {
      $('#header').removeClass('fixed-header box-shadow');
      // $('#banner').css('margin-top', '0px');
    }
});

$(window).on("resize", function () {
  var headerHeight = $('#header').height();
  var totalHeight = headerHeight; 
  var totalDHeight = headerHeight*2;
  if ($(window).scrollTop() >= totalHeight) {
    $('#header').addClass('fixed-header box-shadow');
    // $('#banner').css('margin-top', totalDHeight);
  }
  else {
    $('#header').removeClass('fixed-header box-shadow');
    // $('#banner').css('margin-top', '0px');
  }
});

$(window).on("load", function () {
  var headerHeight = $('#header').height();
  var totalHeight = headerHeight; 
  var totalDHeight = headerHeight*2;
  if ($(window).scrollTop() >= totalHeight) {
    $('#header').addClass('fixed-header box-shadow');
    // $('#banner').css('margin-top', totalDHeight);
  }
  else {
    $('#header').removeClass('fixed-header box-shadow');
    // $('#banner').css('margin-top', '0px');
  }

//Match height
  $(".match-height .column").matchHeight();
});
