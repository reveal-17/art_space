<?php
//ログインユーザー
if(!empty($_SESSION['login_date'])){
    debug('ログイン経験あり');
    if(($_SESSION['login_date'] + $_SESSION['login_limit']) < time() ){
        debug('ログイン有効期限が切れています');
        session_destroy();
            if(basename($_SERVER['PHP_SELF'] !== '/php/login.php')){
        header('Location:login.php');
    }
    }else{
        debug('ログイン有効期限内です');
        $_SESSION['login_date'] = time();
        header('artGallery.php');
    }
}else{
    debug('ログイン経験なし');
    if(basename($_SERVER['PHP_SELF'] !== '/php/login.php')){
        header('Location:login.php');
    }
    
}
//未ログインユーザー
?>