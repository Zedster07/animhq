<?php 
	if ( $_SERVER['HTTP_X_REQUESTED_WITH'] == "XMLHttpRequest" ) { 
		define('WP_USE_THEMES', false);
		$URI = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
		require_once( $URI[0] . 'wp-load.php' );
		?>
		<?php
			$moviesQuery = new WP_Query(array('post_type' => 'movie' , 'posts_per_page' => 6, 'offset' => 5 , 'meta_key' => 'download_count' , 'orderby' => 'meta_value_num' ))
		?>
		<?php if ($moviesQuery->have_posts()) : while ($moviesQuery->have_posts()) : $moviesQuery->the_post(); $thumb = wp_get_attachment_url(get_post_thumbnail_id()); ?>
			<div class="block">
				<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>">
					<?php if (!empty($thumb)) { ?>
						<img src="<?=$thumb?>" alt="<?=the_title() ?>">
					<?php } else { ?>
						<img src="<?=get_template_directory_uri()?>/Interface/images/no-thumb.jpeg" alt="<?=the_title() ?>">
					<?php } ?>
					<h3><?=the_title()?></h3>
					<p><?=wp_trim_words(get_the_content(), 20 , '....')?></p>
				</a>
			</div>
		<?php endwhile;endif;wp_reset_query() ?>
		<div class="clr"></div>
	<?php
	}
?>