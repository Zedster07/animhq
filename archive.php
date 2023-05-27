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
				$rates_list = array();
				
				$movies_years_list = array();
				$movies_cats_list = array();
				$movies_rates_list = array();


				$episodes_list = array();
				$movies_list = array();
				
				
				if ($recentQuery->have_posts()) { 
					while ($recentQuery->have_posts()){
						$recentQuery->the_post();
						
						$serie_id = $post->ID;
						if($post->post_type == "serie"){
							array_push($cats_list , get_the_terms($post->ID,'category' , ''));
							array_push($years_list , get_the_terms($post->ID,'year-cat' , ''));
							array_push($rates_list , get_the_terms($post->ID,'ratings-cat' , ''));
							array_push($episodes_list , get_post($post->ID));
							
						} else {
							array_push($movies_cats_list , get_the_terms($post->ID,'category' , ''));
							array_push($movies_years_list , get_the_terms($post->ID,'year-cat' , ''));
							array_push($movies_rates_list , get_the_terms($post->ID,'ratings-cat' , ''));
							array_push($movies_list , $post);
						}
						
					}
				}

			?>
			<?php 
				if(count($episodes_list) != 0){
					$add = "";
					if($term->slug != "serie"){
						$add = "مسلسلات - ";
					}
					?>
					<div class="section-title-wrapper">
						<h1 class="section-title"><?=$add.$term->name?> <div><span><?=count($episodes_list)?></span></div></h1>
					</div>
					<?php
					$i=0; while ($i < count($episodes_list)) { $post = $episodes_list[$i];  

						$contentType = 1;
						$seasons = getSeasons($post->ID);
						$season = get_post_meta($post->ID,'episode_season',true);
						$serie = get_post_meta($post->ID,'episode_serie',true);
						$season_post = get_post( $season );
						
						$season_number = count($seasons);
						$serie_post = get_post( $serie ); 
	
						$title = $post->post_title;
						$thumb = $seasons[0]->cover;
						
						
						$serie_title = $post->post_title;

						$ended = false;

						if(has_tag("ended" , $post)){
							$ended = true;
						}
						$addedclass = "";
						if($i > 3){
							$addedclass = "archive-series";
						}
						
						 ?>
						<div class="single-poster flex-item <?php echo $addedclass; ?>">
		
							
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
													<?php if($j < count($arr)){ ?>
														<h6>-</h6>
													<?php $j++; } ?>
												<?php }else{
													$j++;
												}  ?>
										<?php }} ?>
									
									</div>
									<h3><?=$title;?></h3>
									<div class="poster-year-season">
										<?php if($contentType == 1){ ?>
		
											<h6><?=$season_number?> Seasons</h6>
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
						
					<?php $i++; } ; wp_reset_query();
					
					if(count($episodes_list) > 4){
					?>
					<div class="showmore" style="width:100%;">
						<button class="showmorebutton" for="archive-series"><span class="more"> المزيد </span>  <i class="fa fa-angle-down" aria-hidden="true"></i></button>
					</div>

					<?php } ?>
					<hr style="width: 100%;margin: 37px 6px;">

				<?php }
			?>
			
			<?php 
				if(count($movies_list) != 0){
					$add = "";
					if($term->slug != "movie"){
						$add = "أفلام - ";
					}
					
					?>
					<div class="section-title-wrapper">
						<h1 class="section-title"><?=$add.$term->name?><div><span><?=count($movies_list)?></span></div></h1>
					</div>	
					<?php
					$i=0; 
					
					while ($i < count($movies_list)) { $post = $movies_list[$i];  

						$contentType = 2;
						$movie = getMovie($post->ID);
						$thumb = $movie->cover;
						$episode = null;
						$title = $post->post_title;
						$addedclass = "";
						if($i > 3){
							$addedclass = "archive-movies";
						}
						
						?>
						<div class="single-poster flex-item <?php echo $addedclass; ?>">

							
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
									<?php if (!empty($movies_rates_list[$i])) { foreach (array_slice($movies_rates_list[$i], 0,1 ) as $key ) {
									?>
									<span class="poster-rate showOnmobile"><?=$key->name?><img src="<?php bloginfo('template_url')?>/Interface/images/star.png" width="20" height="20" /></span>
									<?php } }?>
									
								</div>
								
								
								<div class="poster-play-button showOnmobile">
									<a href="<?php the_permalink() ?>" title="<?=the_title() ?>"><i class="fa fa-play"></i></a>
								</div>
								<div class="poster-title">
									<div class="poster-cats showOnmobile">
									<?php if (!empty($movies_cats_list[$i])) { $j = 1; foreach ($arr = array_slice($movies_cats_list[$i], 0,2) as $key ) { ?>
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
									<h3><?=$title;?></h3>
									<div class="poster-year-season">
										<?php if($contentType == 1){ ?>

											<h6><?=$season_number?></h6>
											<?php if($season_number && !empty($movies_years_list[$i]) ){ ?>
												<h6>-</h6>
											<?php }?>

										<?php } else { ?>
												<h6>فلم</h6>
											<?php if(!empty($movies_years_list[$i]) ){ ?>
												<h6>-</h6>
											<?php }?>
											<?php } ?>
										<?php if (!empty($movies_years_list[$i])) { foreach (array_slice($movies_years_list[$i], 0,1 ) as $key ) { ?>
											<h6><?=$key->name?></h6>
										<?php }} ?>
									</div>
								</div>
							</div>
							
						</div>
					<?php $i++; } ; wp_reset_query();

				}
				if(count($movies_list) > 4){
				?>		
				<div class="showmore" style="width:100%;">
					<button class="showmorebutton" for="archive-movies"><span class="more"> المزيد </span>  <i class="fa fa-angle-down" aria-hidden="true"></i></button>
				</div>	
			<?php 
				}
			if(count($movies_list) == 0 && count($episodes_list) == 0 ){?>
				
				<h1 class="section-title">لا يوجد محتوى</h1>
		
			<?php 
			}
			
			?>
		</div>
	</div>
</section>
<?php 
	if($term->slug == "serie"){
		?>
		<script>
			$(".archive-series").each(function(){
				$(this).css("display" , "unset");
				$(".showmorebutton[for='archive-series']").find("i").attr("class" , "fa fa-minus");
			});
		</script>
		
		<?php 
	}
?> 
<?php 
	if($term->slug == "movie"){
		?>
		<script>
			$(".archive-movies").each(function(){
				$(this).css("display" , "unset");
				$(".showmorebutton[for='archive-movies']").find("i").attr("class" , "fa fa-minus");
			});
		</script>
		
		<?php 
	}
?> 
<script>
	$(".showmorebutton").click(function(){
		var section = $(this).attr("for");
		$(this).find("i").attr("class" , "fa fa-spinner");
		var visible = false;
		setTimeout(() => {
			var posters = $("."+section).each(function(){
				if($(this).css("display") == "none"){
					$(this).css("display" , "unset");
					visible = true;
				} else {
					$(this).css("display" , "none");
					visible = false;
				}
			});

			if(visible){
				$(this).find("i").attr("class" , "fa fa-minus");
				$(".showmorebutton[for='"+section+"']").find("span").text("إخفاء");
			}else{
				$(this).find("i").attr("class" , "fa fa-angle-down");
				$(".showmorebutton[for='"+section+"']").find("span").text("المزيد");
			}
		}, 500);
			
	});
</script>
<?php get_footer() ?>