<?php
require('function.php');
require('auth.php');
// debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
// debug('ログインページ');
// debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
// debugLogStart();

if (!empty($_POST)) {

//    ポスト送信された値を変数に格納
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $pass_save =(!empty($_POST['pass_save'])) ? true : false;

//    未入力チェック
    validRequired($email,'email');
    validRequired($pass,'pass');

    if (empty($error_msg)) {
//        email最大文字数、形式チェック
        validMaxLen($email,'email');
        validEmail($email,'email');

//        password最小文字数、最大文字数、半角英数字チェック
        validMinLen($pass,'pass');
        validMaxLen($pass,'pass');
        validHalf($pass,'pass');

        if (empty($error_msg)) {

            try {
//            DB接続
                $dbh = dbConnect();
                $sql = 'SELECT password,id  FROM users WHERE email = :email';
                $data = array(':email' => $email);
                $stmt = queryPost($dbh, $sql, $data);
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
    //                ここにfalseが入ってしまい、実行不可能らしい
                debug('クエリ結果の中身$result：'.print_r($result,true));

                if (!empty($stmt) && password_verify($pass,array_shift($result))) {
                    debug('クエリ成功＆パスワードあり');
                    debug('パスワードが一致しました');
                    $sesLimit = 60*60;
                    $_SESSION['login_date'] = time();
                    $_SESSION['user_id'] = $result['id'];
                    if ($pass_save) {
                        debug('自動ログインにチェックがあります');
                        $_SESSION['login_limit'] = $sesLimit*24*30;
                    } else {
                        debug('自動ログインにチェックはありません');
                        $_SESSION['login_limit'] = $sesLimit;
                    }
                    header('Location:artGallery.php');
                    debug('アートギャラリーへ遷移します');
                } else {
                    debug('クエリ失敗orパスワードなし');
                    $error_msg['common'] = MSG8;
                }
            } catch(Exception $e) {
                error_log('エラー発生：'.$e->getMessage());
                $error_msg['common'] = MSG8;
            }
        }
    }
}
?>

<?php
$siteTitle = 'Log in';
require('head.php');
?>

<?php
require('header.php');
?>

<main class='site-width'>
    <form action="" method="post" class='various-form'>
    <h2 class='title'>Log in</h2>
    <div class='area_msg'><?php if(!empty($error_msg['common'])){echo $error_msg['common'];} ?></div>
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

        <label>
            <input type="checkbox" name='pass_save'>Auto Log in
        </label>

        <a href='remindPassword.php'><p class='forgot-pass'>Forgot Password ?</p></a>

        <div class='btn-container'>
            <input class='s-btn' type="submit" value='Submit'>
        </div>
    </form>
</main>

<?php
require('footer.php');
?>
