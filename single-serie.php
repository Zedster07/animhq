<?php 
	get_header();
	makeViews(get_the_ID());
	$seasons = getSeasons($post->ID);
	$years = get_the_terms($post->ID,'year-cat' , '');
	$cats = get_the_terms($post->ID,'category' , '');
	$ratings = get_the_terms($post->ID,'ratings-cat' , '');
	$tags = get_the_terms($post->ID,'post_tag' , '');
	$isFreeSerie = false;
	foreach ($tags as $tag) {
		if($tag->name == "free"){
			$isFreeSerie = true;
			break;
		}
	}
	$rate = null;
	if(!empty($ratings)){
		$rate = $ratings[0]->name;
	}

	$episode_number = isset($_GET['episodes']) ? $_GET['episodes'] : null;
	$season_number = isset($_GET['seasons']) ? $_GET['seasons'] : null;

	
	$season = $season_number ? getSeason($season_number) : null;
	$episodes = $season ? getEpisodes($season->id) : null;
	$episode = $episodes ? $episodes[0] : null;

	
	
	if($season_number == null and $episode_number == null) {
		$season = $seasons[0];
		$episodes = getEpisodes($season->id);
		$episode = $episodes[0];
	} 

	if($season_number != null) {
		if($episode_number != null) {
			foreach ($episodes as $ep) {
				if($ep->id == $episode_number) {
					$episode = $ep;
					break;
				}
			}
		}
	} else if($episode_number != null) {
		$episode = getEpisode($episode_number);
		$season = getSeason($episode->seasonId);
		$episodes = getEpisodes($season->id);
	}

	$Thumbnail = $season->cover;


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
				<div class="series-data-title"><span> القصة :</span></div>
				<?php the_content(); ?>
			</div>
		</div>

        <?php if(count($seasons) > 1) { ?> 
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
		<?php } ?>
	</section>
	<div class="container">
		<section class="serie-episodes-watch">
			<div class="serie-episodes-watch-list">
				<h1> حلقات - <?php echo $season->name ?></h1>
				<ul>
				<?php $i = 1; foreach ($episodes as $ep) { ?>
					<?php $class=""; if($episode->id == $ep->id){
						$class = "active";
					} ?>
					<li data-watch="<?=home_url()."?embed=".$ep->id."&ep=1"?>" class="<?=$class?>">
						<i class="fa fa-play"></i>
						<span><?php echo $ep->name ?></span>
					</li>
				<?php $i++;} ?>
				</ul>
			</div>
			<div class="serie-watch-area">
				<?php 
					$allowed = false;
					$user = wp_get_current_user();
					$member_plan =hasSubscription(pms_get_member_subscriptions(array("user_id" => $user->ID)));
					if($isFreeSerie) {
						$allowed = true;
					} else if( $member_plan != null ){
						$allowed = true;
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
</div>


<?php get_footer() ?>