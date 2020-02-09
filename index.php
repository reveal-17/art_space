<?php
require('function.php');
?>

<?php
$siteTitle = 'Albem';
require('head.php');
?>

<?php
require('header.php');
?>

<div class='albemTop'>
    <p id='js-show-msg' style='display:none;' class='msg-slide'></p>
    <div class='albemTop__mainImg'>
        <img src="img/mujina.JPG" alt="">
    </div>
    <div class="albemTop__button">
        <a href="artGallery.php"><button>Art Space</button></a>
    </div>

    <div class="albemTopInfo">
        <div class="albemTopInfoTab">
            <input id="news" type="radio" name="tab_item" checked>
            <label class="albemTopInfoTab__item" for="news">News</label>
            <input id="history" type="radio" name="tab_item">
            <label class="albemTopInfoTab__item" for="history">History</label>
            <div class="albemTopInfoTab__content" id="news-content">
                <div class="albemTopInfo__description">
                    <p class="albemTopInfo__descriptionItem">2019/3/30 : Released our second album titled "器官" </p>
                    <p class="albemTopInfo__descriptionItem">2019/12/25 : Released our first album titled "「」" </p>
                    <p class="albemTopInfo__descriptionItem">2019/4/21 : Released our first single titled "箱庭より", "神話" </p>
                </div>
            </div>
            <div class="albemTopInfoTab__content" id="history-content">
                <div class="albemTopInfo__description">
                    <p class="albemTopInfo__descriptionItem--history">Albem is a Japanese music project formed in 2018.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="albemTopArtwork">
        <p class="c-heading1">Discograpy</p>

        <div class="albemTopArtwork__wrapper">
            <img class="albemTopArtwork__wrapper--first js-modal-open" src="img/bracket.jpg" data-target="modal1">
        </div>
        <div  id="modal1" class="albemTopArtwork__modal js-modal">
            <div class="albemTopArtwork__modalBackground js-modal-close"></div>
            <div class="albemTopArtwork__modalContent">
                <img src="img/bracket.jpg">
                <p>「、」</p>
                <audio controls src="music/dot.wav"></audio>
            </div>
        </div>

        <div class="albemTopArtwork__wrapper">
            <img class="albemTopArtwork__wrapper--second js-modal-open" src="img/bracket.jpg" data-target="modal2">
        </div>
        <div id="modal2" class="albemTopArtwork__modal js-modal">
            <div class="albemTopArtwork__modalBackground js-modal-close"></div>
            <div class="albemTopArtwork__modalContent">
                <img src="img/bracket.jpg">
                <p>「...」</p>
                <audio controls src="music/line.wav"></audio>
            </div>
        </div>

        <div class="albemTopArtwork__wrapper">
            <img class="albemTopArtwork__wrapper--third js-modal-open" src="img/bracket.jpg" data-target="modal3">
        </div>
        <div id="modal3" class="albemTopArtwork__modal js-modal">
            <div class="albemTopArtwork__modalBackground js-modal-close"></div>
            <div class="albemTopArtwork__modalContent">
                <img src="img/bracket.jpg">
                <p>「。」</p>
                <audio controls src="music/circle.wav"></audio>
            </div>
        </div>
    </div>

    <div class="albemTopPrize">
        <p class="c-heading1">Prize</p>
        <div class="albemTopPrize__background"></div>
        <div class="albemTopPrize__accordion">
            <ul class="albemTopPrize__accordionContent">
                <li class="albemTopPrize__accordionItem">
                    <a class="albemTopPrize__accordionItem--toggle js-toggle">『2020年を代表する50のアルバム』第50位</a>
                    <ul class="albemTopPrize__accordionItem--child">
                        <li><a href="https://note.com/unsatisfied/n/n30ebad2e301a?magazine_key=m65d09fd77d07">『2020年を代表する50のアルバム』</a></li>
                        <li>↑リンクへ飛びます</li>
                        <li>hao123</li>
                        <li>hao123</li>
                    </ul>
                </li>
                <li class="albemTopPrize__accordionItem">
                    <a class="albemTopPrize__accordionItem--toggle js-toggle">hao123</a>
                    <ul class="albemTopPrize__accordionItem--child">
                        <li>hao123</li>
                        <li>hao123</li>
                        <li>hao123</li>
                        <li>hao123</li>
                    </ul>
                </li>
                <li class="albemTopPrize__accordionItem">
                    <a class="albemTopPrize__accordionItem--toggle js-toggle">hao123</a>
                    <ul class="albemTopPrize__accordionItem--child">
                        <li>hao123</li>
                        <li>hao123</li>
                        <li>hao123</li>
                        <li>hao123</li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>

    <div class="albemTopRightBackground">
        <div class="albemTopRightBackground--content"></div>
    </div>
</div>


<?php
require('footer.php');
?>
