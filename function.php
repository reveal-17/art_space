<?php
ini_set('log_errors','On');
ini_set('error_log','php.log');

error_reporting(E_ALL);
ini_set('display_errors', '1');

define('MSG1','入力必須です。');
define('MSG2','最大文字数は255文字です。');
define('MSG3','Emailの形式で入力してください。');
define('MSG4','そのEmailはすでに登録されています。');
define('MSG5','半角英数字で入力してください。');
define('MSG6','パスワードが一致しません。');
define('MSG7','6文字以上で入力してください。');
define('MSG8','エラーが発生しました。しばらく経ってから再度お試しください。');
define('MSG9','メールアドレスまたはパスワードが違います。');
define('MSG10','古いパスワードと新しいパスワードが同一です。');
define('MSG11','古いパスワードが間違っています。');
define('MSG12','認証キーが違います。');
define('MSG13','認証キーの有効期限が切れています。');
define('SUC1','ログアウトしました。');


$error_msg = array();


//================================デバッグ==================================
$debug_flg = true;
function debug($str){
    global $debug_flg;
    if($debug_flg){
        error_log('デバッグ：'.$str);
    }
}

function debugLogStart(){
      debug('>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> 画面表示処理開始');
      debug('セッションID：'.session_id());
      debug('セッション変数の中身：'.print_r($_SESSION,true));
      debug('現在日時タイムスタンプ：'.time());
      if(!empty($_SESSION['login_date']) && !empty($_SESSION['login_limit'])){
      debug( 'ログイン期限日時タイムスタンプ：'.( $_SESSION['login_date'] + $_SESSION['login_limit'] ) );
}
}

//===============================SESSION===================================

session_save_path('/var/tmp');

ini_set('session.gc_maxlifetime',60*60*24*30);

ini_set('session.cookie_ifetime',60*60*24*30);

session_start();

session_regenerate_id();





//    =================================バリデーションチェック==================================
function validRequired($str,$key){
    if(empty($str)){
        global $error_msg;
        $error_msg[$key] = MSG1;
    }
}

function validMaxLen($str,$key,$max = 255){
    if(mb_strlen($str) > $max){
        global $error_msg;
        $error_msg[$key] = MSG2;
    }
}

function validEmail($str,$key){
    if(!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/",$str)){
        global $error_msg;
        $error_msg[$key] = MSG3;
    }
}

function validEmailDup($email){
    try{
        $dbh = dbConnect();
        $sql = 'SELECT count(*) FROM users WHERE email = :email';
        $data = array(':email' => $email);
        $stmt = queryPost($dbh,$sql,$data);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if(!empty(array_shift($result))){
            global $error_msg;
            $error_msg['email'] = MSG4;
        }

        }catch(Exception $e){
            error_log('エラー発生：'.$e->getMessage());
            $error_msg['common'] = MSG8;
    }
}

function validHalf($str,$key){
    if(!preg_match("/^[a-zA-Z0-9]+$/", $str)){
        global $error_msg;
        $error_msg[$key] = MSG5;
    }
}

function validSame($str1,$str2,$key){
    if($str1 !== $str2){
        global $error_msg;
        $error_msg[$key] = MSG6;
    }
}


function validMinLen($str,$key,$min = 5){
    if(mb_strlen($str) < $min){
        global $error_msg;
        $error_msg[$key] = MSG7;
    }
}

function validPass($str,$key){
    validMaxLen($str,$key);
    validMinLen($str,$key);
    validHalf($str,$key);
}

function validDiff($str1,$str2,$key){
    if($str1 === $str2){
        global $error_msg;
        $error_msg[$key] = MSG10;
    }
}


//=============================DB接続====================================
function dbConnect(){
  //DBへの接続準備
  $dsn = 'mysql:dbname=albem_artgallery;host=localhost;charset=utf8';
  $user = 'root';
  $password = 'root';
  $options = array(
    // SQL実行失敗時にはエラーコードのみ設定
    PDO::ATTR_ERRMODE => PDO::ERRMODE_SILENT,
    // デフォルトフェッチモードを連想配列形式に設定
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    // バッファードクエリを使う(一度に結果セットをすべて取得し、サーバー負荷を軽減)
    // SELECTで得た結果に対してもrowCountメソッドを使えるようにする
    PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
  );
  // PDOオブジェクト生成（DBへ接続）
  $dbh = new PDO($dsn, $user, $password, $options);
  return $dbh;
}

function queryPost($dbh,$sql,$data){
    debug('$sqlの中身：'.print_r($sql,true));
    $stmt = $dbh->prepare($sql);
    $result = $stmt->execute($data);
  //プレースホルダに値をセットし、SQL文を実行
  if(!$result){
    debug('クエリに失敗しました。');
    debug('失敗したSQL：'.print_r($stmt,true));
    $err_msg['common'] = MSG7;
    return 0;
  }
  debug('クエリ成功。');
  return $stmt;
}



//================================その他===================================
function getUser($u_id){
    try{
//        DB接続してユーザー情報取得　カラム取得
        $dbh = dbConnect();
        $sql = 'SELECT * FROM users WHERE id = :u_id';
        $data = array(':u_id' => $u_id);
        $stmt = queryPost($dbh,$sql,$data);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }catch(Exception $e){
        error_log('エラー発生：'.$e->getMessage());
        return false;
    }
}

function sendMail($from,$to,$subject,$comment){

    if(!empty($to) && !empty($subject) && !empty($comment)){
        mb_language("Japanese");
        mb_internal_encoding("UTF-8");
        mb_send_mail($to,$subject,$comment,'From:'.$from);
    }

}

function getArtworkSlider($currentSliderPosition, $sliderSpan){
    try{
        // 1.すべての画像データを一旦取り込む
        $dbh = dbConnect();
        $sql = 'SELECT * FROM art';
        $data = array();
        $stmt = queryPost($dbh,$sql,$data);
        $result['total'] = $stmt->rowCount();
        $result['totalPage'] = ceil($result['total']/$sliderSpan);

        if($stmt){
            debug('クエリ成功');
            debug('クエリで取得した$result'.print_r($result,true));
        }else{
            debug('クエリ失敗');
            return false;
        }

        // 2.該当するページに対応する画像を取り出す
        $sql = 'SELECT * FROM art ORDER BY id ASC';
        $sql .= ' LIMIT '.$sliderSpan .' OFFSET ' .$currentSliderPosition ;
        //↑虫喰いでもやってみて
        $data = array();
        $stmt = queryPost($dbh,$sql,$data);
        if($stmt){
            debug('クエリ成功');
            $result['data'] = $stmt->fetchAll();
            debug('クエリで取得した$result'.print_r($result,true));
            return $result;
        }else{
            debug('クエリ失敗');
            return false;
        }

    }catch(Exception $e){
        error_log('エラー発生：'.$e->getMessage());
    }
}


function getArtwork($currentMinNum=0, $span=3){
    try{
        // 1.すべての画像データを一旦取り込む
        $dbh = dbConnect();
        $sql = 'SELECT * FROM art';
        $data = array();
        $stmt = queryPost($dbh,$sql,$data);
        $result['total'] = $stmt->rowCount();
        $result['totalPage'] = ceil($result['total']/$span);

        if($stmt){
            debug('クエリ成功');
            debug('クエリで取得した$result'.print_r($result,true));
        }else{
            debug('クエリ失敗');
            return false;
        }

        // 2.該当するページに対応する画像を取り出す
        $sql = 'SELECT * FROM art ORDER BY id ASC';
        $sql .= ' LIMIT '.$span .' OFFSET ' .$currentMinNum ;
        //↑虫喰いでもやってみて
        $data = array();
        $stmt = queryPost($dbh,$sql,$data);
        if($stmt){
            debug('クエリ成功');
            $result['data'] = $stmt->fetchAll();
            debug('クエリで取得した$result'.print_r($result,true));
            return $result;
        }else{
            debug('クエリ失敗');
            return false;
        }

    }catch(Exception $e){
        error_log('エラー発生：'.$e->getMessage());
    }
}

function getArtworkOnly($p_id){
    try{

        $dbh = dbConnect();
        $sql = 'SELECT * FROM art WHERE id = :p_id';
        $data = array(':p_id' => $p_id);
        $stmt = queryPost($dbh, $sql, $data);
        if($stmt){
            debug('クエリ成功');
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            debug('クエリで取得した$result'.print_r($result,true));
            return $result;
        }else{
            debug('クエリ失敗');
            return false;
        }
    }catch(Exception $e){
        error_log('エラー発生：'.$e->getMessage());
    }
}

function sanitize($str){
    return htmlspecialchars($str,ENT_QUOTES);
}

function makeRandKey($length=8){
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $str = '';
    for($i=0; $i<$length; $i++){
        $str .= $chars[mt_rand(0,61)];
    }
    return $str;
}

function appendGetParam($arr_del_key = array()){
    if(!empty($_GET)){
        $str = '?';
        foreach ($_GET as $key => $value){
            if(!in_array($key, $arr_del_key, true)){
                $str .= $key .'=' .$value .'&';
            }
        }
        // 後ろから数えて一文字以降を消去（＆を消す）
        $str = mb_substr($str,0,-1,'UTF-8');
        return $str;
    }
}

function getSessionFlash($key){
    if(!empty($_SESSION[$key])){
        $data = $_SESSION[$key];
        $_SESSION[$key] = '';
        return $data;
    }
}

function isFavorite($u_id,$a_id){
    debug('お気に入り確認');
    debug('$u_id:'.print_r($u_id,true));
    debug('$a_id:'.print_r($a_id,true));
    try{
        $data = dbConnect();
        $sql = 'SELECT * FROM favorite WHERE user_id = :u_id AND art_id = :a_id AND delete-flg = 0';
        $data = array(':u_id' => $u_id, ':a_id' => $a_id);
        $stmt = queryPost($data,$sql,$data);
        $result = $stmt->rowCount();
        debug('isFavorite-$resultの中身：'.print_r($result,true));

        if($result){
            debug('お気に入りあり');
            return true;
        }else{
            debug('お気に入りなし');
            return false;
        }

    }catch(Exception $e){
        error_log('エラー発生：'.$e->getMessage());
    }

}


function isLogin(){
    if(!empty($_SESSION['login_date'])){
        debug('ログイン経験あり');
        if($_SESSION['login_date'] + $_SESSION['login_limit'] < time()){
            debug('ログイン有効期限がきれています');
            return false;
        }else{
            debug('ログイン有効期限内です');
            return true;
        }
    }else{
        debug('ログイン経験なし');
        return false;
    }
}

?>
