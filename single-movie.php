<?php 
	get_header();
	makeViews(get_the_ID());
	$movie = getMovie($post->ID);
	
	$Thumbnail = $movie->cover;
	$cats = get_the_terms($post->ID,'category' , '');
	$years = get_the_terms($post->ID,'year-cat' , '');
	$ratings = get_the_terms($post->ID,'ratings-cat' , '');
	$rate = null;
	if(!empty($ratings)){
		$rate = $ratings[0]->name;
	}
?>

<div class="container">
	<section class="serie-info">

			<div class="single-poster flex-item serie-info-poster">	
					<?php if (!empty($Thumbnail)) { ?>
						<div class="poster-img" style="background: url(<?php echo($Thumbnail) ?>);   background-size: cover;
  background-position: center center;"></div>
					<?php } else { ?>
						<img class="poster-img" src="<?=get_template_directory_uri()?>/Interface/images/no-thumb.jpeg" alt="<?=the_title() ?>">
					<?php } ?>
			</div>

			<div class="serie-data">
				<div class="serie-title"><h1><?php the_title(); ?></h1></div>
				<div class="serie-rate serie-data-row">
					
					<div class="series-data-title">: التقييمات </div>
					<div class="series-data-content rate-container">
						<div class="rate">              
							<?php if($rate != null){ ?>
								<span><?=$rate?></span>
							<?php } ?>
						</div>
						<div class="rate">-</div>
						<?php 
							if($rate != null){
								$rateval = floatval($rate);
								$rateval = $rateval / 2;
								$intval = intval($rateval);
								$i = 0;
								while($i < $intval){?>

									<img src="<?php bloginfo('template_url')?>/Interface/images/star.png" width="15" height="15" />

								<?php $i++; } 
								$rest = 5 - $intval;
								if($rateval > $intval){?>
									<img src="<?php bloginfo('template_url')?>/Interface/images/star-half.png" width="15" height="15"/>
								<?php 
								$rest - 1;
								}
								$i = 1;
								while ($i < $rest){?>
									<img src="<?php bloginfo('template_url')?>/Interface/images/star-empty.png" width="15" height="15"/>

								<?php $i++;
								}
							}
						?>
					</div>
				</div>
				<div class="serie-date serie-data-row">
					<div class="series-data-title"><span> العام :</span></div>
					<div class="series-data-content">
						<?php if($years){?>
							<?php foreach ($years as $Yr) { ?>
							<a href="<?=get_term_link($Yr)?>"><?=$Yr->name?></a>
						<?php }} ?>
					</div>
				</div>
				<div class="serie-cats serie-data-row">
					<div class="series-data-title"><span> التصنيفات :</span></div>
					<div class="series-data-content">
						<?php 
						if (!empty($cats)) { 
							foreach ($cats as $key => $cat ) { 
								if($cat->slug != "series" and $cat->slug != "movies"){
								?>
								<?php if($key != 0) { ?><div class="rate">-</div> <?php } ?>
								<a href="<?=get_term_link($cat)?>"><?=$cat->name?></a>
								
						
							<?php }}
						}
						
						?>
					</div>
				</div>
				<div class="serie-desc serie-data-row">
					<div class="series-data-title"><span> القصة :</span></div>
					<div class="series-data-desc series-data-content">
						<?php the_content(); ?>
					</div>
				</div>
			</div>
		
	</section>

	<section class="serie-episodes-watch">
			<div class="serie-watch-area">
				<?php 
					$allowed = false;
					$subscription_plans = array('18');
					if( !pms_is_post_restricted( $post->ID ) ){
						if(pms_is_member_of_plan( $subscription_plans)){
							$allowed = true;
						} 
					}
				?>

				<?php if($allowed){ ?>
					<iframe src="<?php echo home_url()."?embed=".$movie->id."&ep=0"; ?>" frameborder="0" allowfullscreen></iframe>
				<?php } else {?>
					<div class="notAllowed">
						<h2>فقط المشتركين يمكنهم مشاهدة هذا المحتوى</h2>
						<div class="flip">
							<a href="<?=bloginfo('url')?>/plans">
								<div class="front">شارك</div>
								<div class="back">الآن</div>
							</a>
						</div>
					</div>
				<?php }?>
			</div>
		</section>
	
</div>

<script>
	$(document).ready(function(){
		$('.serie-watch-area iframe').attr('src',$('.serie-episodes-watch-list ul li.active').data('watch'));
		$('.serie-episodes-watch-list ul li').click(function(){
			$(this).addClass('active').siblings().removeClass('active');
			$('.serie-watch-area iframe').attr('src',$(this).data('watch'));
		});
	});
</script>


<!-- <div class="random-posts">
	<div class="container">
		<ul>
			<?php
				$episode_serie = get_post_meta($post->ID,'episode_serie',true);
				$term = get_the_terms($episode_serie,'category','');
				$randQuery = new WP_Query( array ( 
					'post_type' 		=> array('serie'), 
					'posts_per_page' 	=> 10, 
					'orderby' 			=> 'rand',
					'cat' 				=> $term[0]->term_id,
					'post__not_in' 		=> array( get_queried_object_id() ),
				)); 
				if ( $randQuery->have_posts() ) : while ( $randQuery->have_posts() ) : $randQuery->the_post(); $Thumb = wp_get_attachment_url( get_post_thumbnail_id() ); 
					?>
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
				<?php endwhile;?>
			<?php endif; ?>
			<div class="clr"></div>
		</ul>
	</div>
</div> -->

<?php get_footer() ?>