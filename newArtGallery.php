<?php
require('function.php');
require('auth.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('アートギャラリー');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

// ページネーション
$currentPageNum = (!empty($_GET['p'])) ? $_GET['p'] : 1 ;
$span = 3;
$currentMinNum = (($currentPageNum-1)*$span);
$dbArtwork = getArtwork($currentMinNum);
$totalPage = $dbArtwork['totalPage'];
$artworkNum = $dbArtwork['total'];

// 画像スライダー
$currentSliderPosition = 0;
$sliderSpan = 4;
$dbArtwork = getArtworkSlider($currentSliderPosition, $sliderSpan);
?>

<?php
$siteTitle = 'HELL-O';
require('head.php');
?>

<?php
require('header.php');
?>

<!-- 新画像スライダー -->
<div class="albemSlider">
    <div class="albemSlider__slides js-slides">
        <div class="albemSlider__inner js-inner">
            <?php foreach ($dbArtwork['data'] as $key => $value): ?>
            <a href="artwork.php<?php echo (!empty(appendGetParam())) ? appendGetParam(). '&p_id=' .$value['id'] : '?p_id=' .$value['id']  ?>">
                    <img class="js-slider-img" src="<?php echo sanitize($value['picture']) ?>" alt="<?php echo sanitize($value['name']) ?>">
                </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<!-- 新画像一覧 -->
<div class="albemArtworkList">
<p>0000000000000000000000000000</p>
</div>


<?php
require('footer.php');
?>
