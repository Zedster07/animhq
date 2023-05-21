<?php 
	if ( $_SERVER['HTTP_X_REQUESTED_WITH'] == "XMLHttpRequest" ) { 
		define('WP_USE_THEMES', false);
		$URI = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
		require_once( $URI[0] . 'wp-load.php' );
		?>
		<?php
			$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
			$recentQuery = new WP_Query( array( 
				'post_type' => array('movie','episode') ,
				'posts_per_page' => 40,
				'paged' => $paged,
				'meta_key' => 'Views',
				'orderby' => 'meta_value_num'
			)); 
		?>
		<?php if ($recentQuery->have_posts()) { while ($recentQuery->have_posts()) { $recentQuery->the_post(); $thumb = wp_get_attachment_url(get_post_thumbnail_id())?>
			<li class="singleBB">
				<a href="<?php the_permalink() ?>" title="<?=the_title() ?>">
					<?php if (!empty($thumb)) { ?>
						<img src="<?=$thumb?>" alt="<?=the_title() ?>">
					<?php } else { ?>
						<img src="<?=get_template_directory_uri()?>/Interface/images/no-thumb.jpeg" alt="<?=the_title() ?>">
					<?php } ?>
					<i class="fa fa-play"></i>
					<h3><?=the_title();?></h3>
					<?php if (!empty(get_the_terms($post->ID,'quality-cat'))) { foreach (array_slice(get_the_terms($post->ID,'quality-cat',''), 0,1 ) as $key ) {
					?>
					<span><?=$key->name?></span>
					<?php } }?>
					<em><i class="fa fa-eye"></i><?=getViews(get_the_ID())?></em>
				</a>
			</li>
		<?php } ; } ; wp_reset_query() ?>
		<div class="clr"></div>
		<?php if (function_exists('pagination')) { ?>
			<?php pagination($recentQuery->max_num_pages) ?>
		<?php } ?>
		<?php
	}
?>