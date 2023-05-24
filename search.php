<?php 
get_header(); 
$search_term = get_search_query();

?>

<section class="pageTemplate" style="color: white;">
<div class="page-section-title">
	<h1>نتائج البحث عن : <?=get_search_query()?></h1>
</div>
	<div class="container">
		<div class="content-animehq flex-row" >
		<?php
			$recentQuery = new WP_Query( array( 
				'post_type' => array('serie' , 'movie') ,
				'post_status' => "publish",
				's' => $search_term,
				'orderby' => 'title',
				'order' => 'ASC',
			));
			$years_list = array();
			$cats_list = array();
			$episodes_list = array();
			$rates_list = array();
			if ($recentQuery->have_posts()) { 
					while ($recentQuery->have_posts()){
						$recentQuery->the_post();
						$serie_id = $post->ID;

						array_push($cats_list , get_the_terms($post->ID ,'category' , ''));
						array_push($years_list , get_the_terms($post->ID,'year-cat' , ''));
						array_push($rates_list , get_the_terms($post->ID ,'ratings-cat' , ''));
						array_push($episodes_list , $post);
						
					}
				}

				if(count($episodes_list) == 0){
					?>
						<h1 class="section-title">لا يوجد محتوى</h1>
					<?php
				}
		?>
		<?php $i=0; while ($i < count($episodes_list)) { $post = $episodes_list[$i];  

				$contentType = 1;
				if($post->post_type == "serie"){
					$seasons = getSeasons($post->ID);
					$contentType = 1;
					$season_number = count($seasons);
					$title = $post->post_title;
					$thumb = $seasons[0]->cover;
					
					$ended = false;
					if(has_tag("ended" , $post)){
						$ended = true;
					}
				} else {
					$contentType = 2;
					$movie = getMovie($post->ID);
					$thumb = $movie->cover;
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



<!-- 
<div class="TemplatePage">
	<div class="container">
		<h2 class="TitleAreaTwo">
	        <i class="fa fa-search"></i>
	        <span>
	        	
	        	<?php if (isset($_GET['category']) && $_GET['category'] != '') { ?>
	        		بالقسم : <?=get_cat_name($_GET['category'])?>
	        	<?php } ?>
	        	<?php if (isset($_GET['year']) && $_GET['year'] != '') { ?>
	        		بسنه : <em class="year"><?=$_GET['year']?></em>
	        	<?php } ?>
	        	<?php $quality =  $_GET['quality']; ?>
		    	<?php $quality = str_replace('-', ' ', $quality); ?>
	        	<?php if (isset($_GET['quality']) && $_GET['quality'] != '') { ?>
	        		بالجوده : <em class="year"><?=$quality?></em>
	        	<?php } ?>
        	</span>
	    </h2>
	    <div class="searchResList">
	    	<?php if (!empty($_GET['s'])) { ?>
		    	<?php
		    		$word = $_GET['s'];
		    		$word = str_replace('-', ' ', $word);
					$searchQuery = new WP_Query( array( 
						'posts_per_page' => -1,
						'cat' => $_GET['category'],
						's' => $word,
						'tax_query' => array(
							'relation' => 'OR',
							array(
								'taxonomy' => 'year-cat',
								'field' => 'slug',
								'terms' => $_GET['year'],
							),
							array(
								'taxonomy' => 'quality-cat',
								'field' => 'slug',
								'terms' => $quality,
							),
						),
					)); 
		    	?>
			    <?php if ($searchQuery->have_posts()) { while ($searchQuery->have_posts()) { $searchQuery->the_post() ?>
			    	<?php $thumb = wp_get_attachment_url(get_post_thumbnail_id()) ?>
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
			    <?php } ; } ; wp_reset_query(); ?>
		    <?php } else { ?>
		    	<?php if (have_posts()) { while (have_posts()) { the_post() ?>
			    	<?php $thumb = wp_get_attachment_url(get_post_thumbnail_id()) ?>
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
			    <?php } ; } ; wp_reset_query(); ?>
		    	<div class="clr"></div>
			    <?php pagination() ?>
		    <?php } ?>
	    	<div class="clr"></div>
	    </div>
	</div>
</div> -->
<?php get_footer() ?>