<?php 
	if ( $_SERVER['HTTP_X_REQUESTED_WITH'] == "XMLHttpRequest" ) { 
		define('WP_USE_THEMES', false);
		$URI = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
		require_once( $URI[0] . 'wp-load.php' );
		$post = $_POST['postID'];
		$post = get_post($post)
		?>
		<div class="container">
			<h2 class="TitleAreaTwo">
		        <i class="fa fa-comments"></i>
		        <span>تعليقات الفيس بوك </span>
		    </h2>
		    <div id="fb-root"></div>
		    <script>(function(d, s, id) {
				var js, fjs = d.getElementsByTagName(s)[0];
				if (d.getElementById(id)) return;
				js = d.createElement(s); js.id = id;
				js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&appId=221304917993155&version=v2.0";
				fjs.parentNode.insertBefore(js, fjs);
		    }(document, 'script', 'facebook-jssdk'));</script>
		    <div class="fb-comments" data-href="<?php echo get_the_permalink($post->ID); ?>" data-width="100%" data-numposts="10" data-colorscheme="light"></div>
		</div>
		<?php
	}
?>