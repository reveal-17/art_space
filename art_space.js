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

// ---------------------------------------モーダル---------------------------------------------
    $('.js-modal-open').each(function() {
        $(this).on('click', function() {
            const target =  $(this).data('target');
            const modal = document.getElementById(target);
            $(modal).fadeIn();
        });
    });

    $('.js-modal-close').on('click', function() {
        $('.js-modal').fadeOut();
    });

    // -------------------------------------------いいね-----------------------------------------------------
    const good = $('.js-btn-good');
    good.on('click', function(e) {
        e.stopPropagation();
        const $this = $(this);
        goodPostId =  $this.parents('.js-good-parent').data('artid');
        $.ajax({
            type: 'POST',
            url: 'ajaxFavorite.php',
            data: {artid: goodPostId}
        }).done(function(data) {
            console.log('Ajax Success');
            // いいねの総数を表示
            $this.children('span').html(data);
            // いいね取り消しのスタイル
            $this.children('i').toggleClass('far'); //空洞ハート
            // いいね押した時のスタイル
            $this.children('i').toggleClass('fas'); //塗りつぶしハート
            $this.children('i').toggleClass('active');
            $this.toggleClass('active');
        }).fail(function() {
            console.log('Ajax Error');
        });
    });
});
