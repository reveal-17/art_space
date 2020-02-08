$(function() {
    // -----------------------------画像スライダー-----------------------------
    $('.js-slides').append('<ul class="js-pager"><li><a href="#" class="albemSlider__prev js-transition js-prev"><span>&lt;</span></a></li><li><a href="#" class="albemSlider__next js-transition"><span>&gt;</span></a></li></ul><div class="albemSlider__nav js-nav"></div>');
    const $pager = $('.js-pager'),
    $nav = $('.js-nav'),
    $slides = $('.js-inner'),
    $slideImg = $slides.find('.js-slider-img'),
    number = $slideImg.length;
    let current = 0;

    $slideImg.each(function(i) {
        $(this).css({
        left: '100' * i + '%'
        });
        $nav.append('<a href="#" class="js-transition"></a>');
    });

    function navUpdate() {
        $nav.find('.js-transition').removeClass('active');
        $nav.find('.js-transition').eq(current).addClass('active');
    }

    function slider(index) {
        if (index < 0) {
            index = number - 1;
        }
        if (index > number - 1) {
            index = 0;
        }
        $slides.animate({
            left: '-100' * index + '%'
        });
        current = index;
        navUpdate();
    }

    $pager.find('.js-transition').click(function(event) {
        event.preventDefault();
        if ($(this).hasClass('js-prev')) {
            slider(current - 1);
        } else {
            slider(current + 1);
        }
    });

    $nav.find('.js-transition').click(function(event) {
        event.preventDefault();
        let navIndex = $(this).index();
        navUpdate();
        slider(navIndex);
    });

    let start;

    function timerStart() {
        start = setInterval(function() {
            slider(current + 1);
        }, 5000);
    }

    function timerStop() {
        clearInterval(start);
    }

    slider(current);

    timerStart();

    $slideImg.on({
        mouseover: timerStop,
        mouseout: timerStart
    });


// -------------------------------アコーディオンメニュー----------------------------------------------------

function accordionMenu() {
    $(this).toggleClass('ac-active').next().slideToggle(300);
}
$('.js-toggle').click(accordionMenu);
});
