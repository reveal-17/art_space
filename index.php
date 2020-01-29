<?php

require('function.php');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('トップページ');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');


if(!empty($_POST)){
    if(!empty($_SESSION['user_id'])){
        debug('ログインしています');
        header('Location:artGallery.php');
    }else{
        debug('ログインしていません');
        header('Location:login.php');
    }
}

?>

<?php
$siteTitle = 'Albem';
require('head.php');
?>

<?php
require('header.php');
?>
        
        <main class='site-width'>
           <p id='js-show-msg' style='display:none;' class='msg-slide'></p>
           
            <div class='top-img'>
                <img src="img/mujina.JPG" alt="">
            </div>
            
<!--
            <form class='btn' method=''>
            <input id='submit-btn' type="submit" name='submit' value='Art-Gallery'>
            </form>
-->

        </main>
        
        
<?php
require('footer.php');
?>