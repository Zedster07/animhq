<?php 
	get_header();
	makeViews(get_the_ID());
	$seasons = getSeasons($post->ID);
	$years = get_the_terms($post->ID,'year-cat' , '');
	$cats = get_the_terms($post->ID,'category' , '');
	$ratings = get_the_terms($post->ID,'ratings-cat' , '');
	$rate = null;
	if(!empty($ratings)){
		$rate = $ratings[0]->name;
	}

	$episode_number = isset($_GET['episodes']) ? $_GET['episodes'] : null;
	$season_number = isset($_GET['seasons']) ? $_GET['seasons'] : null;

	
	$season = getSeason($season_number);
	$episodes = getEpisodes($season->id);
	$episode = $episodes[0];

	
	
	if($season_number == null and $episode_number == null) {
		$season = $seasons[0];
		$episodes = getEpisodes($season->id);
		$episode = $episodes[0];
	} 
	
	if($episode_number != null) {
		$episode = getEpisode($episode_number);
		$season = getSeason($episode->seasonId);
	}

	$Thumbnail = $season->cover;


?>
<div class="container">
	<section class="serie-info">
		<div class="single-poster flex-item serie-info-poster">	
			<?php if (!empty($Thumbnail)) { ?>
				<img class="poster-img" src="<?=$Thumbnail?>" alt="<?=the_title() ?>">
			<?php } else { ?>
				<img class="poster-img" src="<?=get_template_directory_uri()?>/Interface/images/no-thumb.jpeg" alt="<?=the_title() ?>">
			<?php } ?>
		</div>
		<div class="serie-data">
			
			<div class="serie-title"><h1><?php echo $post->post_title; ?></h1></div>
			
			
			
			
			
			
			<div class="serie-rate serie-data-row">
			<div class="series-data-title"> التقييمات :</div>
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
				<?php the_content(); ?>
			</div>
		</div>


		<div class="serie-related">
			<div class="aside-title">مواسم أخرى</div> 
				<div class="serie-related-container">
					<?php 
						$i = 0;
						while($i < count($seasons)){
							if($seasons[$i]->id != $season->id){

								$season_name = $seasons[$i]->name;
								$thumb = $seasons[$i]->cover;

								?>
									<a href="<?=the_permalink().'?seasons='.$seasons[$i]->id?>">
										<img class="serie-related-poster" src="<?=$thumb?>" width="40"/>
										<div class="serie-related-data">
											<h1><?=$season_name?></h1>
										</div>
										<div class="serie-related-icon">
											<i class="fa fa-chevron-circle-left"></i>
										</div>
									</a>
									<?php
							}

							$i = $i + 1;
							
						}wp_reset_query();

					?>
				</div>
			</div>
		</div>
	
	</section>
	<section class="serie-episodes-watch">
		<div class="serie-episodes-watch-list">
			<h1> حلقات - <?php echo $season->name ?></h1>
			<ul>
			<?php $i = 1; foreach ($episodes as $ep) { ?>
				<?php $class=""; if($episode->id == $ep->id){
					$class = "active";
				} ?>
				<li data-watch="<?=home_url()."?embed=".$ep->id?>" class="<?=$class?>">
					<i class="fa fa-play"></i>
					<span><?php echo $ep->name ?></span>
				</li>
			<?php $i++;} ?>
			</ul>
		</div>
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
				<iframe src="" frameborder="0" allowfullscreen></iframe>
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
	<script>
	$(document).ready(function(){
		$('.serie-watch-area iframe').attr('src',$('.serie-episodes-watch-list ul li.active').data('watch'));
		$('.serie-episodes-watch-list ul li').click(function(){
			$(this).addClass('active').siblings().removeClass('active');
			$('.serie-watch-area iframe').attr('src',$(this).data('watch'));
		});
	});
</script>
</div>


<?php get_footer() ?>