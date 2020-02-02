<?php
require('function.php');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('アートワーク詳細ページ');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
require('auth.php');
debugLogStart();



$p_id = (!empty($_GET['p_id'])) ? $_GET['p_id'] : '';

$artwork = getArtworkOnly($p_id);

debug('$artworkの中身：'.print_r($artwork,true));

if(empty($artwork)){
    debug('URLに不正な値が入力されました');
    header('Location:artGallery.php');
}




?>

<?php
$siteTitle = $artwork['name'];
require('head.php');
?>
<?php
require('header.php');
?>

<style>

.all{
      width: 100%;
      position: relative;
      height: 600px;
      font-family: 'Sawarabi Mincho', sans-serif;
      margin-bottom: 250px;
}


.one{
  /* background: grey; */
  width: 50%;
  height: 600px;
  position: absolute;
  top: 60px;
  box-sizing: border-box;
  z-index: -10;

}

.two{
    /* background: silver; */
    width: 50%;
    height: 100px;
    position: absolute;
    top: 60px;
    left: 490px;
    box-sizing: border-box;
    z-index: -10;
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
}


.two .favorite{
    color: #f6f5f4;
}




.three{
  /* background: gold; */
  width: 50%;
  height: 500px;
  position: absolute;
  top: 160px;
  left: 490px;
  box-sizing: border-box;

}




main .music-title{
  position: absolute;
  font-weight: lighter;
  font-size:28px;

  right: 0;

}





main .art-work{
  position: absolute;
  top: 100px;
  margin: 0;
  width: 490px;
  height: 490px;

}


main .number{
  float: left;
  padding-right: 20px;
}

main .music-list{
  width: 400px;
  display: inline-block;
  font-size: 18px;
}

main a{
  text-decoration: none;
  color: black;
  position: relative;
}

main a:hover{
  opacity: 0.6;
}

main .music-time{
  float: right;
}

main .border-b{
  border-bottom: solid 1px black;
  line-height: 250%;
  margin-bottom: 100px;
}

main p{
  text-align: center;
}

</style>


<main class='site-width'>
    <section class='all'>

     <section class="one">


     <img src="<?php echo $artwork['picture'] ; ?>" class="art-work">

    </section>

    <section class='two'>

     <div class='two-itemone'>
        <i class="fas fa-heart js_favorite favorite fa-2x" aria-hidden="true" data-artid='<?php echo $artwork['id']; ?>'></i>
<!--        クラス追加するとバグる-->
     </div>

     <div class='two-itemtwo'>
        <h1 class='music-title'><?php echo $artwork['name'] ; ?></h1>
    </div>

    </section>

    <section class='three'>
      <div class='border-b'>
       <div class='number'>1.</div>
       <a class='music-list' href="https://linkco.re/tZXnRhgy" target='_blank'><?php echo $artwork['name'] ; ?></a>
       <div class='music-time'><?php echo $artwork['time'] ; ?></div>
     </div>

    <p><?php echo $artwork['comment'] ; ?></p>




    </section>

   </section>

</main>


<?php
require('footer.php');
?>
