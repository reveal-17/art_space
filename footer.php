        <footer id='footer'>
            Copyright © 2019 Albem All Rights Reserved.
        </footer>
        <script>
        $(function(){
//            footer
            var $ftr = $('#footer');
                if ( window.innerHeight > $ftr.offset().top + $ftr.outerHeight()) {
                $ftr.attr({'style': 'position:fixed; top:' + (window.innerHeight - $ftr.outerHeight()) +'px;' });
                }
            var $js_favorite = $('.js_favorite') || null;
            var favoriteArtId = $js_favorite.data('artid') || null;
            $js_favorite.on('click', function() {
                var $this = $(this);
                $.ajax({
                    url: "ajaxFavorite.php",
                    type: "POST",
//                            向こうに渡すデータ
                    data: {artId : favoriteArtId}
                }).done(function(data){
                        console.log('Ajax success');
                        $this.toggleClass('active');
                }).fail(function(msg){
                        console.log('Ajax fail');
                });
            });
        });
        </script>
    </body>
</html>
