<?php
require('function.php');
// debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
// debug('パスワードリマインダー');
// debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');

if (!empty($_POST)) {
    $email = $_POST['email'];
//    未入力チェック
    validRequired($email,'email');
//    メール形式チェック、最大文字数チェック
    validEmail($email,'email');
    validMaxLen($email,'email');
    if (empty($error_msg)) {
        debug('バリデーションOK');
        try {
            $dbh = dbConnect();
            $sql = 'SELECT count(*) FROM users WHERE email = :email';
            $data = array(':email' => $email);
            $stmt = queryPost($dbh, $sql, $data);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($stmt && array_shift($result)) {
                debug('クエリ成功 入力されたメールアドレスはDBに存在します');
//                セッションにつめる
                $auth_key = makeRandKey();
                $_SESSION['auth_key'] = $auth_key;
                $_SESSION['auth_email'] = $email;
                $_SESSION['auth_limit'] = time() + (60*30) ;
//                メール送信
                $from = 'Albem';
                $to = $email;
                $subject = 'Password Reset';
                $comment = <<<EOD
パスワードを再発行します。
以下の認証キーを入力して、パスワードを再発行してください。
認証キーは{$auth_key}です。
EOD;
                sendMail($from,$to,$subject,$comment);

                header('Location:remindPassword2.php');

            } else {
                debug('クエリ失敗');
            }
        } catch(Exception $e) {
            error_log('エラー発生：'.$e->getMessage());
        }
    }
}
?>

<?php
$siteTitle = 'Password Reset';
require('head.php');
?>

<?php
require('header.php');
?>

<main class='site-width'>
    <form action="" method='post' class='various-form add-padding'>
        <h2 class='title'>Password Reset</h2>
        <div class='area_msg'><?php if(!empty($error_msg['common'])){echo $error_msg['common'];} ?></div>
        <label for="">
            Email
            <input type="text" name='email' placeholder="Email" value='<?php if(!empty($_POST['email'])) {echo $_POST['email'];} ?>' class='<?php if(!empty($error_msg['email'])) {echo 'err';} ?>'>
        </label>
        <div class='area_msg'><?php if(!empty($error_msg['email'])){echo $error_msg['email'];} ?></div>
        <input type="submit" name='submit' value="Submit" class='s-btn'>
    </form>
</main>

<?php
require('footer.php');
?>
