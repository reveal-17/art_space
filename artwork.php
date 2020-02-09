<?php
require('function.php');
require('auth.php');
// debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
// debug('アートワーク詳細ページ');
// debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
// debugLogStart();

$p_id = (!empty($_GET['p_id'])) ? $_GET['p_id'] : '';

$artwork = getArtworkOnly($p_id);

debug('$artworkの中身：'.print_r($artwork,true));

if(empty($artwork)){
    debug('URLに不正な値が入力されました');
    header('Location:artGallery.php');
}
?>

<?php
$siteTitle = $artwork['name'];
require('head.php');
?>

<?php
require('header.php');
?>

<main class='site-width'>
    <section class='all'>
        <section class="one">
            <img src="<?php echo $artwork['picture'] ; ?>" class="art-work">
        </section>

        <section class='two js-good-parent'>
            <div class='two-itemone js-btn-good' data-artid='<?php echo sanitize($artwork['id']); ?>'>
                <i class="fas fa-heart fa-2x" aria-hidden="true"></i>
        <!--        クラス追加するとバグる-->
                <span></span><!-- ここにいいね数を表示 -->
            </div>

            <div class='two-itemtwo'>
                <h1 class='music-title'><?php echo $artwork['name'] ; ?></h1>
            </div>
        </section>

        <section class='three'>
        <div class='border-b'>
        <div class='number'>1.</div>
        <a class='music-list' href="https://linkco.re/tZXnRhgy" target='_blank'><?php echo $artwork['name'] ; ?></a>
        <div class='music-time'><?php echo $artwork['time'] ; ?></div>
        </div>
        <p><?php echo $artwork['comment'] ; ?></p>
        </section>
    </section>
</main>

<?php
require('footer.php');
?>
