<?php get_header() ?>
<?php $term = get_queried_object() ?>

<section class="posts-section archive-posts">
	<div class="container">
		
		<div class="content-animehq flex-row" >
			
			<?php
			
				$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

				$recentQuery = new WP_Query( array( 
					'post_type' => array('serie', 'movie'),
					'post_status' => "publish",
					'posts_per_page' => 24,
					'orderby' => 'publish_date',
    				'order' => 'DESC',
					'tax_query' => array(array(
						'taxonomy' => $term->taxonomy,
						'field' => 'id',
						'terms' => $term->term_id
					)),
					'paged' => 1,
				));
				$years_list = array();
				$cats_list = array();
				$episodes_list = array();
				$rates_list = array();
				if ($recentQuery->have_posts()) { 
					while ($recentQuery->have_posts()){
						$recentQuery->the_post();
						array_push($cats_list , get_the_terms($post->ID,'category' , ''));
						array_push($years_list , get_the_terms($post->ID,'year-cat' , ''));
						array_push($rates_list , get_the_terms($post->ID,'ratings-cat' , ''));

						if($post->post_type == "serie"){
							$seasonQuery = new WP_Query( array(
								'post_type' => array('season') ,
								'post_status' => "publish",
								'posts_per_page' => -1,
								'orderby' => 'date',
								'meta_query' => array(
									array(
										'key' => 'season_serie',
										'value' => $post->ID,
										'compare' => '=='
									),
								),
							));

							if($seasonQuery->have_posts()){
								while($seasonQuery->have_posts()){
									$seasonQuery->the_post();
									$postQuery = new WP_Query( array(
										'post_type' => array('episode') ,
										'post_status' => "publish",
										'posts_per_page' => 1,
										'meta_key' => array('episode_numbar'),
										'orderby' => 'meta_value_num',
										'meta_query' => array(
											array(
												'key' => 'episode_season',
												'value' => $post->ID,
												'compare' => '=='
											),
										),
									));
									if($postQuery->have_posts()){
										$postQuery->the_post();
										array_push($episodes_list , get_post($post->ID));
									}
								}
								
							}
						} else {
							array_push($episodes_list , $post);
						}
						
					}
				}

			?>
			<?php 
				if(count($episodes_list) != 0){
					?>
						<h1 class="section-title"><?=$term->name?></h1>
					<?php
				} else {
					?>
						<h1 class="section-title">لا يوجد محتوى</h1>
					<?php
				}
			?>
			<?php $i=0; while ($i < count($episodes_list)) { $post = $episodes_list[$i];  

				$contentType = 1;
				if($post->post_type == "episode"){
					$contentType = 1;
					$season = get_post_meta($post->ID,'episode_season',true);
					$serie = get_post_meta($post->ID,'episode_serie',true);
					$season_post = get_post( $season );
					
					$season_number = $season_post->post_title;
					$season_number = explode("-", $season_number)[1];
					$serie_post = get_post( $serie ); 

					$title = $serie_post->post_title;
					$thumb = wp_get_attachment_url(get_post_thumbnail_id($season_post->ID));
					
					
					$serie_title = $serie_post->post_title;
				

					$episode = get_post_meta($post->ID,'episode_numbar',true);
					$ended = false;
					if(has_tag("ended" , $season)){
						$ended = true;
					}
				} else {
					$contentType = 2;
					$thumb = wp_get_attachment_url(get_post_thumbnail_id());
					$episode = null;
					$title = $post->post_title;
				}
				
				
				 ?>
				<div class="single-poster flex-item">

					
						<?php if (!empty($thumb)) { ?>
							<img class="poster-img" src="<?=$thumb?>" alt="<?=the_title() ?>">
						<?php } else { ?>
							<img class="poster-img" src="<?=get_template_directory_uri()?>/Interface/images/no-thumb.jpeg" alt="<?=the_title() ?>">
						<?php } ?>


					<div class="poster-wrapper">
						
						
						<div class="poster-tags showOnmobile">
							<?php if( $contentType == 1 && !$ended) { ?>
								<span  class="poster-tag"><?="مستمر"?></span> 
							<?php } else if($contentType == 1 && $ended) {
								?>
									<span  class="poster-tag"><?="كامل"?></span> 
								<?php
							} ?>
							<?php if (!empty($rates_list[$i])) { foreach (array_slice($rates_list[$i], 0,1 ) as $key ) {
							?>
							<span class="poster-rate showOnmobile"><?=$key->name?><img src="<?php bloginfo('template_url')?>/Interface/images/star.png" width="20" height="20" /></span>
							<?php } }?>
							
						</div>
						
						
						<div class="poster-play-button showOnmobile">
							<a href="<?php the_permalink() ?>" title="<?=the_title() ?>"><i class="fa fa-play"></i></a>
						</div>
						<div class="poster-title">
							<div class="poster-cats showOnmobile">
							<?php if (!empty($cats_list[$i])) { $j = 1; foreach ($arr = array_slice($cats_list[$i], 0,2) as $key ) { ?>
								<?php 
									if($key->slug != "movie" && $key->slug != "serie") { ?>
										<h6><a href="<?=get_term_link($key)?>"><?=$key->name?></a></h6>
										<?php 
										if($j < count($arr)){ ?>
											<h6>-</h6>
											<?php $j++; 
										} ?>
											<?php 
									} else {
										// if($j < count($arr)){
										// 	$j++;
										// }
									}  ?>

							<?php }} ?>
							
							</div>
							<h3><?=$title;?></h3>
							<div class="poster-year-season">
								<?php if($contentType == 1){ ?>

									<h6><?=$season_number?></h6>
									<?php if($season_number && !empty($years_list[$i]) ){ ?>
										<h6>-</h6>
									<?php }?>

								<?php } else { ?>
										<h6>فلم</h6>
									<?php if(!empty($years_list[$i]) ){ ?>
										<h6>-</h6>
									<?php }?>
									<?php } ?>
								<?php if (!empty($years_list[$i])) { foreach (array_slice($years_list[$i], 0,1 ) as $key ) { ?>
									<h6><?=$key->name?></h6>
								<?php }} ?>
							</div>
						</div>
					</div>
					
				</div>
			<?php $i++; } ; wp_reset_query() ?>
			
		</div>
	</div>
</section>
<!-- <div class="ActorPage">
	<div class="container">
		

			<div class="ActorBlocksHolder">
				<h2 class="TitleAreaTwo">
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

		
		<div class="clr"></div>
	</div>
</div> -->
<?php get_footer() ?>