<?php
ini_set('display_errors',1);
require('function.php');
require('auth.php');
// debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
// debug('退会機能ページ');
// debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
// debugLogStart();

if (!empty($_POST)) {
    debug('ポスト送信あり');
    try {
        $dbh = dbConnect();
        $sql1 = 'UPDATE users SET delete_flg = 1 WHERE id = :u_id';
        $sql2 = 'UPDATE favorite SET delete_flg = 1 WHERE user_id = :u_id';
        $data1 = array(':u_id' => $_SESSION['user_id']);
        $data2 = array(':u_id' => $_SESSION['user_id']);
        $stmt1 = queryPost($dbh,$sql1,$data1);
        $stmt2 = queryPost($dbh,sql2,$data2);

        if ($stmt) {
            debug('クエリ成功');
            debug('セッション変数の中身：'.print_r($_SESSION,true));
            session_destroy();
            header('Location:index.php');
        } else {
            debug('クエリ失敗');
            $error_msg['common'] = MSG8;
        }
    } catch(Exception $e) {
        error_log('エラー発生：'.$e->getMessage());
        $error_msg['common'] = MSG8;
    }
}
?>

<?php
$siteTitle = 'Unsubscribe';
require('head.php');
?>

<?php
require('header.php');
?>

<main class='site-width'>
    <form action="" method="post" class='various-form'>
        <h2 class='title'>Unsubscribe</h2>
        <div class='un-form'><input type="submit" name="submit" class='un-btn' value='Really?'></div>
    </form>
</main>

<?php
require('footer.php');
?>
