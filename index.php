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
    <div class="albemTop__button">
    <?php
        if(empty($_SESSION['user_id'])){
    ?>
        <a href="login.php"><button>Art Space</button></a>
    <?php
        } else {
    ?>
        <a href="artGallery.php"><button>Art Space</button></a>
    <?php
        }
    ?>
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
</div>


<?php
require('footer.php');
?>
