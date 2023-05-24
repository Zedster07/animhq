	<div class="container">
		
		<div class="content-animehq flex-row">
			<?php
				$total = 0;
				$recentQuery = new WP_Query( array( 
					'post_type' => array('movie') ,
					'post_status' => "publish",
					'posts_per_page' => 24,
					'orderby' => 'publish_date',
    				'order' => 'DESC',
				));
				$years_list = array();
				$cats_list = array();
				$episodes_list = array();
				$rates_list = array();
				if ($recentQuery->have_posts()) {
					?>
						<h1 class="section-title"> أفلام أنمي  </h1>
					<?php
					$total = $recentQuery->post_count;
					$group = 1;
				}
				$years_list = array();
				$cats_list = array();
				$rates_list = array();
			?>
			<?php if($recentQuery->have_posts()){ $i = 0; while ($recentQuery->have_posts()) {   
				if($i > 11){
					$group = 2;
				}
				$hide = "";
				if($group > 1){
					$hide = "style='display:none;'";
				}
				$recentQuery->the_post();
				$movie = getMovie($post->ID);
				$thumb = $movie->cover;
				
				array_push($cats_list , get_the_terms($post->ID,'category' , ''));
				array_push($years_list , get_the_terms($post->ID,'year-cat' , ''));
				array_push($rates_list , get_the_terms($post->ID,'ratings-cat' , ''));
				 ?>
				<div class="single-poster flex-item visiblegroup-<?=$group?>" <?=$hide?>>

					
						<?php if (!empty($thumb)) { ?>
							<div class="poster-img" style="background: url(<?php echo($thumb) ?>);   background-size: cover;
  background-position: center center;"></div>
						<?php } else { ?>
							<img class="poster-img" src="<?=get_template_directory_uri()?>/Interface/images/no-thumb.jpeg" alt="<?=the_title() ?>">
						<?php } ?>


					<div class="poster-wrapper">
						
						
						<div class="poster-tags showOnmobile">
							<?php if (!empty($rates_list[$i])) { foreach (array_slice($rates_list[$i], 0,1 ) as $key ) {
							?>
							<span class="poster-rate showOnmobile"><?=$key->name?><img src="<?php bloginfo('template_url')?>/Interface/images/star.png" width="15" height="15" /></span>
							<?php } }?>
							
						</div>
						
						
						<div class="poster-play-button showOnmobile">
							<a href="<?php the_permalink() ?>" title="<?=the_title() ?>"><i class="fa fa-play"></i></a>
						</div>
						<div class="poster-title">
							<div class="poster-cats showOnmobile">
							<?php if( !empty($cats_list) ) { $j = 1; foreach ($arr = array_slice($cats_list[0] ,0,2)  as $key ) { ?>
										<?php 
										if($key->slug != "movie" && $key->slug != "serie") { ?>
											<h6><a href="<?=get_term_link($key)?>"><?=$key->name?></a></h6>
											<?php if($j < count($arr)){ ?>
												<h6>-</h6>
											<?php $j++; } ?>
										<?php }else{
											$j++;
										}  ?>
								
								<?php }} ?>
							
							
							</div>
							<h3><?=$post->post_title;?></h3>
							<div class="poster-year-season">
								
								<h6>فلم</h6>
								<?php if(!empty($years_list[$i]) ){ ?>
									<h6>-</h6>
								<?php }?>
								<?php if (!empty($years_list[$i])) { foreach (array_slice($years_list[$i], 0,1 ) as $key ) { ?>
									<h6><?=$key->name?></h6>
								<?php }} ?>
							</div>
						</div>
					</div>
					
				</div>
			<?php $i++; }} ; wp_reset_query() ?>
			
		</div>
		<?php if($total > 12){ ?>
		<div class="showmore">
			<button class="showmorebutton" for="movies-posts-anime"><span class="more"> المزيد </span>  <i class="fa fa-plus" aria-hidden="true"></i></button>
		</div>
		<?php } ?>
		<?php if($total > 0) { ?>
			<hr>
		<?php } ?>
	</div>