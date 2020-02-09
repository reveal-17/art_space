<?php
require('function.php');
require('auth.php');
// debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
// debug('アートギャラリー');
// debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
// debugLogStart();

// ページネーション
$currentPageNum = (!empty($_GET['p'])) ? $_GET['p'] : 1 ;
$span = 9;
$currentMinNum = (($currentPageNum-1)*$span);
$dbArtwork = getArtwork($currentMinNum);
$totalPage = $dbArtwork['totalPage'];
$artworkNum = $dbArtwork['total'];

// 画像スライダー
$currentSliderPosition = 0;
$sliderSpan = 4;
$dbArtworkSlider = getArtworkSlider($currentSliderPosition, $sliderSpan);

// // 画像一覧
// $listSpan = 9;
// $currentMinNum = (($currentPageNum-1)*$listSpan);
// $dbArtworkList = getArtworkList($currentMinNum);
// $listTotalPage = $dbArtworkList['totalPage'];
// $artworkListNum = $dbArtworkList['total'];
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
            <?php foreach ($dbArtworkSlider['data'] as $key => $value): ?>
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
    <div class="albemArtworkList__artworks">
        <h1 class="albemArtworkList__title">Artwork</h1>
        <div class="albemArtworkList__imgWrapper">
            <?php foreach ($dbArtwork['data'] as $key => $value): ?>
            <a href="artwork.php<?php echo (!empty(appendGetParam())) ? appendGetParam(). '&p_id=' .$value['id'] : '?p_id=' .$value['id']  ?>">
                <img class="js-slider-img" src="<?php echo sanitize($value['picture']) ?>" alt="<?php echo sanitize($value['name']) ?>">
            </a>
            <?php endforeach; ?>
        </div>

        <ul class='albemArtworkList__paging'>
            <a href="?p=1">
                <li>
                <?php if($currentPageNum != 1): ?>
                &lt;
                <?php endif; ?>
                </li>
            </a>

            <?php
            $pageColNum = 5;

            if ($currentPageNum == $totalPage && $totalPage >= $pageColNum) {
                $minPageNum = $currentPageNum - 4;
                $maxPageNum = $currentPageNum;
            } elseif ($currentPageNum == $totalPage - 1 && $totalPage >= $pageColNum) {
                $minPageNum = $currentPageNum - 3;
                $maxPageNum = $currentPageNum + 1;
            } elseif ($currentPageNum == 2 && $totalPage >= $pageColNum) {
                $minPageNum = $currentPageNum - 1;
                $maxPageNum = $currentPageNum + 3;
            } elseif ($currentPageNum == 1 && $totalPage >= $pageColNum) {
                $minPageNum = $currentPageNum;
                $maxPageNum = $currentPageNum + 4;
            } elseif ($totalPage < $pageColNum) {
                $minPageNum = 1;
                $maxPageNum = $totalPage;
            } else {
                $minPageNum = $currentPageNum - 2;
                $maxPageNum = $currentPageNum + 2;
            }
            ?>

            <?php for($i = $minPageNum; $i <= $maxPageNum; $i++): ?>
            <a href='?p=<?php echo $i ; ?>'>
                <li class='<?php if($currentPageNum == $i){echo 'active';} ?>'><?php echo $i ; ?></li>
            </a>
            <?php endfor; ?>

            <a href="?p=<?php echo $maxPageNum ; ?>">
                <li>
                <?php if($currentPageNum != $totalPage): ?>
                &gt;
                <?php endif; ?>
                </li>
            </a>
        </ul>
    </div>
</div>

<?php
require('footer.php');
?>
