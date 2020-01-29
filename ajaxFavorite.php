<?php

require('funciton.php');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('ajax');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

if(isset($_POST['artId']) && isset($_SESSION['user_id']) && isLogin()){
    debug('ログインOKかつ作品ありかつユーザーあり');
     try{
         $dbh = dbConnect();
         $sql = 'SELECT * FROM favorite WHERE art_id = :a_id AND user_id = :u_id AND delete_flg = 0';
         $data = array(':a_id' => $_POST['artId'], ':u_id' => $_SESSION['user_id']);
         $stmt = queryPost($dbh,$sql,$data);
         $result = $stmt->rowCount();
         debug('$resultお気に入りレコード件数：'.print_r($result,true));
         
         if($result){
//             レコードが１件でもあったら
             $dbh =dbConnect();
             $sql = 'DELETE FROM favorite WHERE art_id = :a_id AND user_id = :u_id';
             $data = array(':a_id' => $_POST['artId'], ':u_id' => $_SESSION['user_id']);
             $stmt = queryPost($dbh,$sql,$data);
             
             if($stmt){
                 debug('クエリ成功ーお気に入りを解除しました');
             }else{
                 debug('クエリ失敗');
                 return false;
             }
             
         }else{
//             レコードが０件だったら
             $dbh = dbConnect();
             $sql = 'INSERT INTO [favorite] (art_id, user_id, delete_flg, create_date) VALUE (:a_id, :u_id, 0, :c_date)';
             $data = array(':a_id' => $_POST['artId'], ':u_id' => $_SESSION['user_id'], ':c_date' => date("Y/m/d H:i:s"));
             $stmt = queryPost($dbh,$sql,$data);
             
             if($stmt){
                 debug('クエリ成功ーお気に入りを登録しました');
             }else{
                 debug('クエリ失敗');
                 return false;
             }
             
         }
     }catch(Exception $e){
         error_log('エラー発生：'.$e->getMessage());
     }
}

?>