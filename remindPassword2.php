<?php

//バリデーションチェック
if(!empty($_POST)){
    validRequired($auth_key,'auth_key');
    validMaxLen($auth_key,'auth_key');
    
    //セッションのキーと入力されたキーが合っているか
    if(empty($error_msg)){
        debug('バリデーションOK');
        if($_SESSION['auth_key'] !== $_POST['auth_key']){
            debug('認証キーが違います');
            global $error_msg;
            $error_msg['auth_key'] = MSG12;
        }
        
        //セッションのキーが有効期限以内か
        if($_SESSION['auth_limit'] < time()){
            debug('ログイン有効期限が切れています');
            global $error_msg;
            $error_msg['auth_key'] = MSG13;
        }
        
        debug('認証キーOK');
        
        $newPass = makeRandKey();
        
        try{
            $dbh = dbConnect();
            $sql = 'UPDATE users SET password = :newPass WHERE email = :email';
            $data = array(':newPass' => password_hash($newPass,PASSWORD_DEFAULT), ':email' => $_SESSION['auth_email']);
            $stmt = queryPost($dbh, $sql, $data);
            if($stmt){
                debug('クエリ成功');
                $from = 'Albem';
                $to = $_SESSION['auth_email'];
                $subject = 'Password Reset Done';
                $comment = <<<EOD
パスワードを再発行しました。
新しいパスワードは、{$newPass}です。
EOD;
                sendMail($from,$to,$subject,$comment);
                debug('メールを送信しました');
                
                
                session_unset();
                debug('セッションアンセット');
                
                header('Location:artGallery.php');
                
            }else{
                debug('クエリ失敗');
                return false;
            }
            
        }catch(Exception $e){
            error_log('エラー発生'.$e->getMessage());
            $error_msg['common'] = MSG8;
        }
    }
}





?>



<?php
$siteTitle = 'Auth Code' ;
require('head.php');
?>

<?php
require('header.php');
?>


<main class='site-width'>
    <form action="" method='post' class='various-form add-padding'>
        <h2 class='title'>Auth Code</h2>
        <div class='area_msg'><?php if(!empty($error_msg['common'])){echo $error_msg['common'];} ?></div>
        <label for="">
           Auth Code
            <input type="text" name='email' placeholder="Auth Code" value='<?php if(!empty($_POST['auth_key'])) {echo $_POST['auth_key'];} ?>' class='<?php if(!empty($error_msg['auth_key'])) {echo 'err';} ?>'>
        </label>
        <div class='area_msg'><?php if(!empty($error_msg['auth_key'])){echo $error_msg['auth_key'];} ?></div>
        <input type="submit" name='submit' value="Submit" class='s-btn'>
    </form>
</main>


<?php
require('footer.php');
?>