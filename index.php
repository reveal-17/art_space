<?php
require('function.php');
// debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
// debug('トップページ');
// debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');

// if(!empty($_POST)){
//     if (!empty($_SESSION['user_id'])){
//         debug('ログインしています');
//         header('Location:artGallery.php');
//     } else {
//         debug('ログインしていません');
//         header('Location:login.php');
//     }
// }
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

    <div class="albemTopInfo">
        <div class="albemTopInfoTab">
            <input id="news" type="radio" name="tab_item" checked>
            <label class="albemTopInfoTab__item" for="news">News</label>
            <input id="history" type="radio" name="tab_item">
            <label class="albemTopInfoTab__item" for="history">History</label>
            <div class="albemTopInfoTab__content" id="news-content">
                <div class="tab_content_description">
                    <p class="c-txtsp">2019/12/25 : Released our first album titled "「」" </p>
                    <p class="c-txtsp">2019/4/21 : Released our first single titled "箱庭より", "神話" </p>
                </div>
            </div>
            <div class="albemTopInfoTab__content" id="history-content">
                <div class="tab_content_description">
                <p class="c-txtsp">Albem is a Japanese music project formed in 2018.</p>
                </div>
            </div>
            <div class="albemTopInfoTab__content tab_content" id="design_content">
                <div class="tab_content_description">
                <p class="c-txtsp">デザインの内容がここに入ります</p>
                </div>
            </div>
        </div>
    </div>

    <div class="albemTopArtwork">
        <p class="c-heading1">Discograpy</p>
        <div class="albemTopArtwork__wrapper">
            <img class="albemTopArtwork__wrapper--first" src="img/bracket.jpg" alt="">
        </div>
        <div class="albemTopArtwork__wrapper">
            <img class="albemTopArtwork__wrapper--second" src="img/bracket.jpg" alt="">
        </div>
        <div class="albemTopArtwork__wrapper">
            <img class="albemTopArtwork__wrapper--third" src="img/bracket.jpg" alt="">
        </div>
    </div>

    <div class="albemTopPrize">
        <p class="c-heading1">Prize</p>
        <div class="albemTopPrize__background"></div>
        <div class="albemTopPrize__accordion">
            <ul class="albemTopPrize__accordionContent">
                <li class="albemTopPrize__accordionItem">
                    <a class="albemTopPrize__accordionItem--toggle js-toggle">hao123</a>
                    <ul class="albemTopPrize__accordionItem--child">
                        <li>baidu</li>
                        <li>baidu</li>
                        <li>baidu</li>
                        <li>baidu</li>
                    </ul>
                </li>
                <li class="albemTopPrize__accordionItem">
                    <a class="albemTopPrize__accordionItem--toggle js-toggle">hao123</a>
                    <ul class="albemTopPrize__accordionItem--child">
                        <li>baidu</li>
                        <li>baidu</li>
                        <li>baidu</li>
                        <li>baidu</li>
                    </ul>
                </li>
                <li class="albemTopPrize__accordionItem">
                    <a class="albemTopPrize__accordionItem--toggle js-toggle">hao123</a>
                    <ul class="albemTopPrize__accordionItem--child">
                        <li>baidu</li>
                        <li>baidu</li>
                        <li>baidu</li>
                        <li>baidu</li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>


<?php
require('footer.php');
?>
