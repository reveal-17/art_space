<?php
ini_set('display_errors',1);
require('function.php');
require('auth.php');
// debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
// debug('パスワード変更ページ');
// debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
// debugLogStart();

//$userInfo = getUser($_SESSION['user_id']);
//ログイン機能完成したら↑の変数ができる

//post送信あるか

if (!empty($_POST)) {
//    ポストを変数に格納
    $old_pass = $_POST['old_pass'];
    $new_pass = $_POST['new_pass'];
    $new_pass_re = $_POST['new_pass_re'];

//    未入力チェック
    validRequired($new_pass,'new_pass');
    validRequired($old_pass,'old_pass');
    validRequired($new_pass_re,'new_Pass_re');

    if (empty($error_msg)) {
//        バリデーションチェック続き
//        パスワード形式チェック
        validPass($old_pass,'old_pass');
        validPass($new_pass,'new_pass');
//        新パスワード一致しているか
        validSame($new_pass,$new_pass_re,'new_pass_re');
//        新旧パスワードが異なっているか
        validDiff($new_pass,$old_pass,'new_pass');

        if (empty($error_msg)) {
            // debug('バリデーションOK');
//            古いパスワードがDBに登録されているか
            try {
                $dbh = dbConnect();
                $sql = 'SELECT password FROM users WHERE id = :u_id';
                $data = array(':u_id' => $user_id);
                $stmt = queryPost($dbh,$sql,$data);
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($stmt) {
                    // debug('クエリ成功');
                    if (password_verify($old_pass,array_shift($result))) {
                        // debug('古いパスワードはDBのものと一致しています');
                    } else {
                        // debug('古いパスワードはDBのものと一致していません');
                    }
                } else {
                    // debug('クエリ失敗');
                    return false;
                }
            } catch (Exception $e) {
                error_log('エラー発生'.$e->getMessage());
                $error_msg['common'] = MSG11;
            }

//            新しいパスワードをハッシュ化してDBに登録
            if (empty($error_msg)) {
                try {
                    $dbh = dbConnect();
                    $sql = 'UPDATE users SET password = :pass WHERE id = :u_id';
                    $data = array(':pass' => password_hash($new_pass,PASSWORD_DEFAULT), ':u_id' => $user_id);
                    $stmt = queryPost($dbh,$sql,$data);
                    if ($stmt) {
                        // debug('クエリ成功');
//                        メール送信
                        $from = 'Albem';
                        $to = 'albemalbem4@gmail.com';
                        $subject = 'Change Password';
                        $comment = <<<EOF
パスワードを変更しました。
===================================
Albem Art Gallery
===================================
EOF;
                        sendMail($from,$to,$subject,$comment);
                        // debug('メール送信しました');
                    }

                } catch(Exception $e) {
                    error_log('エラー発生：'.$e->getMessage());
                    $error_msg['common'] = MSG8;
                }
            }
        }
    }
}
?>

<?php
$siteTitle = 'Change Password';
require('head.php');
?>

<?php
require('header.php');
?>

<main class='site-width'>
    <form action="" method="post" class='various-form add-padding'>
        <h2 class='title'>Change Password</h2>

        <div class='<?php if(!empty($error_msg)){echo 'area_msg';} ?>'><?php if(!empty($error_msg['common'])){echo $error_msg['common'];} ?></div>

        <label for="" class='<?php if(!empty($error_msg['old_pass'])){echo $error_msg['old_pass'];} ?>'>
            Old Password
            <input type="password" name='old_pass' value='<?php if(!empty($_POST['old_pass'])){echo $_POST['old_pass'];} ?>' class='<?php if(!empty($error_msg['old_pass'])){echo 'err';} ?>' placeholder='Old Password'>
        </label>
        <div class='<?php if(!empty($error_msg['old_pass'])){echo 'area_msg';} ?>'><?php if(!empty($error_msg['old_pass'])){echo $error_msg['old_pass'];} ?></div>

        <label for="" class='<?php if(!empty($error_msg['new_pass'])){echo $error_msg['new_pass'];} ?>'>
            New Password
            <input type="password" name='new_pass' value='<?php if(!empty($_POST['new_pass'])){echo $_POST['new_pass'];} ?>' class='<?php if(!empty($error_msg['new_pass'])){echo 'err';} ?>' placeholder='New Password'>
        </label>
        <div class='<?php if(!empty($error_msg['new_pass'])){echo 'area_msg';} ?>'><?php if(!empty($error_msg['new_pass'])){echo $error_msg['new_pass'];} ?></div>

        <label for="" class='<?php if(!empty($error_msg['new_pass_re'])){echo $error_msg['new_pass_re'];} ?>'>
            New Password [Retype]
            <input type="password" name='new_pass_re' value='<?php if(!empty($_POST['new_pass_re'])){echo $_POST['new_pass_re'];} ?>' class='<?php if(!empty($error_msg['new_pass_re'])){echo 'err';} ?>' placeholder='New password [Retype]'>
        </label>
        <div class='<?php if(!empty($error_msg['new_pass_re'])){echo 'area_msg';} ?>'><?php if(!empty($error_msg['new_pass_re'])){echo $error_msg['new_pass_re'];} ?></div>

        <input type="submit" name='submit' value='submit' class='s-btn'>
    </form>
</main>

<?php
require('footer.php');
?>
