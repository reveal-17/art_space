        <body>
          <header>
           <div class='top_wrapper site-width'>
            <div class='left-logo'>
                <a href="index.php"><img src="img/albemMosaic2.jpg" alt="" class='mosaic'></a>
            </div>
                <nav class='top-nav'>
                    <ul class='top-list'>
                       <?php
                        if(empty($_SESSION['user_id'])){
                        ?>
                        <li><a href="signup.php">Sign up</a></li>
                        <li><a href="login.php">Log in</a></li>
                        <?php
                        }else{
                        ?>
                        <li><a href="artGallery.php">HELL-O</a></li>
                        <li><a href="logout.php">Log out</a></li>
                        <li><a href="changePassword.php">Change Password</a></li>
                        <li><a href="unsubscribe.php">Unsubscribe</a></li>
                        <?php 
                        } 
                        ?>
                    </ul>
                </nav>
            </div>
        </header>