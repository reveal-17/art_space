<?php

require('function.php');





if(!empty($_POST)){

    //ポストを変数に格納
    $name = $_POST['name'];
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $pass_re = $_POST['pass_re'];


    //未入力チェック
    validRequired($name,'name');
    validRequired($email,'email');
    validRequired($pass,'pass');
    validRequired($pass_re,'pass_re');
    
    if(empty($error_msg)){
        
//        name最大文字数
        validMaxLen($name,'name');
//        email最大文字数、形式チェック、重複チェック
        validMaxLen($email,'email');
        validEmail($email,'email');
        validEmailDup($email);
        debug('重複チェックしました');
//        password最小文字数、最大文字数、半角英数字チェック
        validMinLen($pass,'pass');
        validMaxLen($pass,'pass');
        validHalf($pass,'pass');
        
        if(empty($error_msg)){
//            passとpass_reが一致しているかどうか
            validSame($pass,$pass_re,'pass_re');
            
            
//            DB接続→インサート
            
            try{
                $dbh = dbConnect();
                $sql = 'INSERT INTO users (name,email,password,login_time,create_date) VALUES (:name,:email,:pass,:login_time,:create_date)';
                $data = array(':name' => $name, ':email' => $email, ':pass' => password_hash($pass,PASSWORD_DEFAULT), ':login_time' => date("Y/m/d H:i:s"), ':create_date' => date("Y/m/d H:i:s"));
                
                $stmt = queryPost($dbh,$sql,$data);
                
                if($stmt){
                    debug('クエリ成功');
                    $sesLimit = 60*60;
                    $_SESSION['login_date'] = time();
                    $_SESSION['login_limit'] = $sesLimit;
                    $_SESSION['user_id'] = $dbh->lastInsertId();
                    debug('セッションの中身：'.print_r($_SESSION,true));
                    header('Location:artGallery.php');
                }else{
                    debug('クエリ失敗');
                    return false;
                }
                
                
            }catch(Exception $e){
                error_log('エラー発生：'.$e->getMessage());
                $error_msg['common'] = MSG8;
            }
            

        }
    }

}



?>

<?php
$siteTitle = 'Sign up';
require('head.php');
?>

<?php

require('header.php');
?>


        
        <main class='site-width'>
        
        
        
        <form action="" method="post" class='various-form'>
           <h2 class='title'>Sign up</h2>
           <div class='area_msg'><?php if(!empty($error_msg['common'])){echo $error_msg['common'];} ?></div>
           
            <label for="" >
            Name
            <input type="text" name='name' placeholder="Name" value='<?php if(!empty($_POST['name'])) {echo $_POST['name'];} ?>' class='<?php if(!empty($error_msg['name'])) {echo 'err';} ?>'>
            </label>
            <div class='area_msg'><?php if(!empty($error_msg['name'])){echo $error_msg['name'];} ?></div>
            
            
            <label for="">
            Email
            <input type="text" name='email' placeholder='Email' value='<?php if(!empty($_POST['email'])) {echo $_POST['email'];} ?>' class='<?php if(!empty($error_msg['email'])) {echo 'err';} ?>'>
            </label>
            <div class='area_msg'><?php if(!empty($error_msg['email'])){echo $error_msg['email'];} ?></div>
            
            
            <label for="">
            Password
            <input type="password" name='pass' placeholder='Password' value='<?php if(!empty($_POST['pass'])) {echo$_POST['pass'];} ?>' class='<?php if(!empty($error_msg['pass'])) {echo 'err';} ?>'>
            </label>
            <div class='area_msg'><?php if(!empty($error_msg['pass'])){echo $error_msg['pass'];} ?></div>
            
            
            <label for="">
            Password [Retype]
            <input type="password" name='pass_re' placeholder="Password Retype" value='<?php if(!empty($_POST['pass_re'])) {echo $_POST['pass_re'];} ?>' class='<?php if(!empty($error_msg['pass_re'])) {echo 'err';} ?>'>
            </label>
            <div class='area_msg'><?php if(!empty($error_msg['pass_re'])){echo $error_msg['pass_re'];} ?></div>
            
            
            <div class='btn-container'>
            <input class='s-btn' type="submit" value='Submit'>
            </div>
        </form>
        
        </main>

<?php
require('footer.php');
?>