<?php 
	if ( $_SERVER['HTTP_X_REQUESTED_WITH'] == "XMLHttpRequest" ) { 
		define('WP_USE_THEMES', false);
		$URI = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
		require_once( $URI[0] . 'wp-load.php' );
		$postID    = $_POST['postID'];
		$download_count = get_post_meta( $postID , 'download_count' , true ); 
		$download_count = $download_count + 1;
		update_post_meta($postID, 'download_count', $download_count);
	}
?>