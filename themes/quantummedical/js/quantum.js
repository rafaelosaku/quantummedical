$('.j_buttom').click(function(){
	$('.main-menu').slideToggle();
});

$(document).ready(function(){
	//Efeito de slide na página inicial
    var slideAuto = setInterval(slideGo, 4000);

    $('.slide_nav.go').click(function () {
        clearInterval(slideAuto);
        slideGo();
        slideAuto = setInterval(slideGo, 4000);
    });

    $('.slide_nav.back').click(function () {
        clearInterval(slideAuto);
        slideBack();
        slideAuto = setInterval(slideGo, 4000);
    });

    function slideGo() {
        if ($('.slide_item.first').next().size()) {
            $('.slide_item.first').fadeOut(400, function () {
                $(this).removeClass('first').next().fadeIn().addClass('first');
            });
        } else {
            $('.slide_item.first').fadeOut(400, function () {
                $('.slide_item').removeClass('first');
                $('.slide_item:eq(0)').fadeIn().addClass('first');
            });
        }
    }

    function slideBack() {
        if ($('.slide_item.first').index() > 1 ) {
            $('.slide_item.first').fadeOut(400, function () {
                $(this).removeClass('first').prev().fadeIn().addClass('first');
            });
        } else {
            $('.slide_item.first').fadeOut(400, function () {
                $('.slide_item').removeClass('first');
                $('.slide_item:last-of-type').fadeIn().addClass('first');
            });
        }
    }
});

$("#slider").owlCarousel({
 
      navigation : true, // Show next and prev buttons
      slideSpeed : 300,
      paginationSpeed : 400,
      singleItem:true,
      autoPlay: true,
      navigation : false,
      pagination : false
 
      // "singleItem:true" is a shortcut for:
      // items : 1, 
      // itemsDesktop : false,
      // itemsDesktopSmall : false,
      // itemsTablet: false,
      // itemsMobile : false
 
  });