<?php

require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('アートギャラリー');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');

require('auth.php');

debugLogStart();


$currentPageNum = (!empty($_GET['p'])) ? $_GET['p'] : 1 ;

$span = 3;

$currentMinNum = (($currentPageNum-1)*$span);

$dbArtwork = getArtwork($currentMinNum);

$totalPage = $dbArtwork['totalPage'];

$artworkNum = $dbArtwork['total'];




?>


<?php
$siteTitle = 'HELL-O';
require('head.php');
?>

<?php
require('header.php');
?>


<main class='site-width'>

    <div class='artwork-wrapper'>

    <div class='artwork'>

       <?php foreach ($dbArtwork['data'] as $key => $value): ?>

        <a href="artwork.php<?php echo (!empty(appendGetParam())) ? appendGetParam(). '&p_id=' .$value['id'] : '?p_id=' .$value['id']  ?>"><img class='artwork-img' src="<?php echo sanitize($value['picture']) ?>" alt="<?php echo sanitize($value['name']) ?>"></a>

       <?php endforeach; ?>

       <ul class='paging'>
           <a href="?p=1"><li>
           <?php if($currentPageNum != 1): ?>
           &lt;
           <?php endif; ?>
           </li></a>

           <?php 
               $pageColNum = 5;

               if($currentPageNum == $totalPage && $totalPage >= $pageColNum){
                   $minPageNum = $currentPageNum - 4;
                   $maxPageNum = $currentPageNum;
               }elseif($currentPageNum == $totalPage - 1 && $totalPage >= $pageColNum){
                   $minPageNum = $currentPageNum - 3;
                   $maxPageNum = $currentPageNum + 1;
               }elseif($currentPageNum == 2 && $totalPage >= $pageColNum){
                   $minPageNum = $currentPageNum - 1;
                   $maxPageNum = $currentPageNum + 3;
               }elseif($currentPageNum == 1 && $totalPage >= $pageColNum){
                   $minPageNum = $currentPageNum;
                   $maxPageNum = $currentPageNum + 4;
               }elseif($totalPage < $pageColNum){
                   $minPageNum = 1;
                   $maxPageNum = $totalPage;
               }else{
                   $minPageNum = $currentPageNum - 2;
                   $maxPageNum = $currentPageNum + 2;
               }
           ?>


           <?php for($i = $minPageNum; $i <= $maxPageNum; $i++): ?>
           <a href='?p=<?php echo $i ; ?>'>
           <li class='<?php if($currentPageNum == $i){echo 'active';} ?>'><?php echo $i ; ?></li>
           </a>
           <?php endfor; ?>



           <a href="?p=<?php echo $maxPageNum ; ?>"><li>
           <?php if($currentPageNum != $totalPage): ?>
           &gt;
           <?php endif; ?>
           </li></a>
       </ul>

    </div>



    </div>

</main>



<?php
require('footer.php');
?>