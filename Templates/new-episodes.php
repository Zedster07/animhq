<?php 
	get_header();
	// Template Name: احدث الحلقات
?>
<div class="TemplatePage">
	<div class="container">
		<h2 class="TitleAreaTwo">
	        <i class="fa fa-fire"></i>
	        <span><?php the_title() ?></span>
	    </h2>
	    <ul>
	    	<?php
				$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
				$tempalateQuery = new WP_Query( array( 
					'post_type' => array('episode') ,
					'posts_per_page' => 40,
					'paged' => $paged,
				)); 
			?>
			<?php if ($tempalateQuery->have_posts()) { while ($tempalateQuery->have_posts()) { $tempalateQuery->the_post(); $thumb = wp_get_attachment_url(get_post_thumbnail_id())?>
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
	    </ul>
	</div>
</div>
<?php get_footer() ?>