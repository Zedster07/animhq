<?php get_header() ?>
<?php $term = get_queried_object() ?>
<div class="ActorPage">
	<div class="container">
		<div class="right">
			<div class="header">
				<h1 class="QualityT"><i class="fa fa-bars"></i><span>test <?=$term->name?></span></h1>
				<div class="share">
					<ul>
						<span>شارك : </span>
						<li class="share-google">
				            <a href="https://plus.google.com/share?url=<?php echo get_term_link($term->term_id)?>" rel="nofollow" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;">
				                <i class="fa fa-google"></i>
				            </a>
				        </li>
				        <li class="share-facebook">
				            <a href="http://www.facebook.com/sharer.php?u=<?php echo get_term_link($term->term_id)?>&t=<?php echo $term->name ?>" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;" rel="nofollow" target="_blank">
				                <i class="fa fa-facebook"></i>
				            </a>
				        </li>
				        <li class="share-twitter">
				            <a href="http://twitter.com/share?url=<?php echo get_term_link($term->term_id)?>" rel="nofollow" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;" target="_blank">
				                <i class="fa fa-twitter"></i>
				            </a>
				        </li>
				    </ul>
				</div>
			</div>
			<div class="ActorBlocksHolder">
				<h2 class="TitleAreaTwo QualityT">
			        <i class="fa fa-th"></i>
			        <span><?=$term->name?></span>
			    </h2>
				<?php
					$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
					$taxQuery = new WP_Query(array(
						'post_type' => array('movie','serie','season','episode'),
						'posts_per_page' => 24,
						'paged' => $paged,
						'tax_query' => array(array(
							'taxonomy' => $term->taxonomy,
							'field' => 'id',
							'terms' => $term->term_id
						))
					))
				?>
				<?php if ($taxQuery->have_posts()) { while ($taxQuery->have_posts()) { $taxQuery->the_post() ?>
					<li class="random-block">
						<a href="<?php the_permalink() ?>" title="<?=the_title()?>">
							<?php $thumb = wp_get_attachment_url(get_post_thumbnail_id()) ?>
							<?php if (!empty($thumb)) { ?>
								<img src="<?=$thumb?>" alt="<?=the_title() ?>">
							<?php } else { ?>
								<img src="<?=get_template_directory_uri()?>/Interface/images/no-thumb.jpeg" alt="<?=the_title() ?>">
							<?php } ?>
							<h4><?=the_title();?></h4>
							<?php if ( !empty(get_the_terms($post->ID,'category','')) ) { ?>
								<?php foreach (array_slice(get_the_terms($post->ID,'category',''), 0,1) as $key): ?>
									<a class="randcat" href="<?=get_term_link($key->term_id)?>"><?=$key->name?></a>
								<?php endforeach ?>
							<?php } ?>
						</a>
					</li>
				<?php } ; } ; wp_reset_query(); ?>
				<div class="clr"></div>
				<?php if (function_exists('pagination')) { ?>
					<?php pagination($taxQuery->max_num_pages) ?>
				<?php } ?>
			</div>
		</div>
		<div class="left">
			<div class="MostViews">
				<h1 class="QualityT"><i class="fa fa-clock-o"></i><span><?=$term->name?></span><em>المضاف حديثا</em></h1>
				<ul>
					<?php
						$taxQuery = new WP_Query(array(
							'post_type' => array('movie','serie','season','episode'),
							'posts_per_page' => 10,
							'tax_query' => array(array(
								'taxonomy' => $term->taxonomy,
								'field' => 'id',
								'terms' => $term->term_id
							))
						))
					?>
					<?php if ($taxQuery->have_posts()) { while ($taxQuery->have_posts()) { $taxQuery->the_post() ?>
						<li>
							<a href="<?php the_permalink() ?>" title="<?php the_title() ?>">
								<?php $thumb = wp_get_attachment_url(get_post_thumbnail_id()) ?>
								<?php if (!empty($thumb)) { ?>
									<img src="<?=$thumb?>" alt="<?=the_title() ?>">
								<?php } else { ?>
									<img src="<?=get_template_directory_uri()?>/Interface/images/no-thumb.jpeg" alt="<?=the_title() ?>">
								<?php } ?>
								<h1><?=the_title()?></h1>
								<p><?php echo wp_trim_words(get_the_content() , 15 , ' ...') ?></p>
							</a>
						</li>
					<?php } ; } ; wp_reset_query() ?>
				</ul>
			</div>
			<div class="MostViews" style="margin-top: 15px">
				<h1 class="QualityT"><i class="fa fa-fire"></i><span><?=$term->name?></span><em>الاكثر مشاهده</em></h1>
				<ul>
					<?php
						$taxQuery = new WP_Query(array(
							'post_type' => array('movie','serie','season','episode'),
							'posts_per_page' => 10,
							'meta_key' => 'Views',
							'orderby' => 'meta_value_num',
							'tax_query' => array(array(
								'taxonomy' => $term->taxonomy,
								'field' => 'id',
								'terms' => $term->term_id
							))
						))
					?>
					<?php if ($taxQuery->have_posts()) { while ($taxQuery->have_posts()) { $taxQuery->the_post() ?>
						<li>
							<a href="<?php the_permalink() ?>" title="<?php the_title() ?>">
								<?php $thumb = wp_get_attachment_url(get_post_thumbnail_id()) ?>
								<?php if (!empty($thumb)) { ?>
									<img src="<?=$thumb?>" alt="<?=the_title() ?>">
								<?php } else { ?>
									<img src="<?=get_template_directory_uri()?>/Interface/images/no-thumb.jpeg" alt="<?=the_title() ?>">
								<?php } ?>
								<h1><?=the_title()?></h1>
								<p><?php echo wp_trim_words(get_the_content() , 15 , ' ...') ?></p>
							</a>
						</li>
					<?php } ; } ; wp_reset_query() ?>
				</ul>
			</div>
		</div>
		<div class="clr"></div>
	</div>
</div>
<?php get_footer() ?>