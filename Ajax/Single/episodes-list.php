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
		        <i class="fa fa-th"></i>
		        <span>كل حلقات <?=get_the_title($post->ID)?></span>
		    </h2>
		    <?php
				$episodesQuery = new WP_Query(array(
					'post_type' => 'episode',
					'posts_per_page' => -1,
					'meta_query' => array(
						'relation' => 'or',
						array(
							'key' => 'episode_serie',
							'value' => $post->ID,
							'compare' => '=='
						),
					),
				));
			?>
			<div class="episodes_list">
				<?php if ($episodesQuery->have_posts()) { while ($episodesQuery->have_posts()) { $episodesQuery->the_post(); ?>
					<li class="singleBB">
						<a href="<?php the_permalink() ?>" title="<?=the_title() ?>">
							<?php $thumb = wp_get_attachment_url(get_post_thumbnail_id()) ?>
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
				<?php } ; } ; wp_reset_query(); ?>
				<div class="clr"></div>
			</div>
		</div>
		<?php
	}
?>