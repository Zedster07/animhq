<?php 

	get_header();
	makeViews(get_the_ID());
	$pageid = get_the_ID();
	$watchServers = get_post_meta($post->ID,'servers',true);
	$epnumber = get_post_meta($post->ID,'episode_numbar',true);
	$page = $post;
	$current_season_id = get_post_meta($post->ID,'episode_season',true);
	$post = get_post($current_season_id );
	$serie = get_post_meta($post->ID,'episode_serie',true);
	$Thumbnail = wp_get_attachment_url( get_post_thumbnail_id() );
	$cats = get_the_terms($serie,'category' , '');
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
					<img class="poster-img" src="<?=$Thumbnail?>" alt="<?=the_title() ?>">
				<?php } else { ?>
					<img class="poster-img" src="<?=get_template_directory_uri()?>/Interface/images/no-thumb.jpeg" alt="<?=the_title() ?>">
				<?php } ?>
			</div>

			<div class="serie-data">
			
				<div class="serie-title"><h1><?php the_title(); ?></h1></div>
				
				<?php 
				if ( is_user_logged_in() ) {
					?>
						<input type="hidden" value="<?php echo $current_season_id;?>" id="pid"/>
						<input type="hidden" value="<?php echo get_current_user_id();?>" id="uid"/>
						<span class="episode_actions" style="color:#dd9933; font-size: 0.8rem; display:flex;margin-bottom:45px;"> <i id="fav" class="fas fa-heart"></i> <i id="report" class="fa fa-exclamation-circle"></i></span>
						<script>
							//$(".episode_actions #fav").attr("class" , "fa fa-spinner");
							$.post('/wp-content/themes/arbCinema/Ajax/wishlist.php', {action: "GET" , uid: $('#uid').val() , pid: $('#pid').val()} , function(data) {
								data = jQuery.parseJSON(data);
								if(data.reponse){
									$(".episode_actions #fav").attr("title" , "حذف من المفضلة");
									$(".episode_actions #fav").attr("act" , "del");
									$(".episode_actions #fav").attr("class" , "fa fa-heart");
									//$(".episode_actions #fav").css("color", "#dd6133");
								} else {
									$(".episode_actions #fav").attr("title" , "أضف الى المفضلة");
									$(".episode_actions #fav").attr("act" , "add");
									$(".episode_actions #fav").attr("class" , "fa fa-heart outline");
									//$(".episode_actions #fav").css("color", "#dd9933");
								}
							});

							$(".episode_actions #fav").click(function(){
								let action = $(this).attr("act");
								//$(".episode_actions #fav").attr("class" , "fa fa-spinner");
								switch (action) {
									case "add":
										$(".episode_actions #fav").attr("title" , "حذف من المفضلة");
										$(".episode_actions #fav").attr("act" , "del");
										$(".episode_actions #fav").attr("class" , "fa fa-heart");
										$.post('/wp-content/themes/arbCinema/Ajax/wishlist.php', {action: "SET" , uid: $('#uid').val() , pid: $('#pid').val()} , function(data) {});
										break;
									case "del":
										$(".episode_actions #fav").attr("title" , "أضف الى المفضلة");
										$(".episode_actions #fav").attr("act" , "add");
										$(".episode_actions #fav").attr("class" , "fa fa-heart outline");
										$.post('/wp-content/themes/arbCinema/Ajax/wishlist.php', {action: "DEL" , uid: $('#uid').val() , pid: $('#pid').val() }, function(data) {});
										break;
									default:
										break;
								}
							});
						</script>
					<?php
				}
				?>
				
				
				
				
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
							$j = 1;
							foreach ($cats as $cat ) { ?>

							<?php 
							if($cat->slug != "movie" && $cat->slug != "serie") { ?>
								<h6 class="rate"><a href="<?=get_term_link($cat)?>"><?=$cat->name?></a></h6>
								<?php if($j < count($cats)){ ?>
									<h6 class="rate">-</h6>
								<?php $j++; } ?>
							<?php }else{
								$j++;
							}  ?>
						<?php }
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
		<div class="serie-related">
		
				<?php 
					$relatedQuery = new WP_Query( array(
						'post_type' => array('season') ,
						'post_status' => "publish",
						'orderby' => 'publish_date',
						'order' => 'DESC',
						'meta_query' => array(
							array(
								'key' => 'season_serie',
								'value' => $serie,
								'compare' => '=='
							),
						),
					));

					if($relatedQuery->have_posts() && $relatedQuery->found_posts > 1) {
						?> <div class="aside-title">مواسم أخرى</div> <div class="serie-related-container"> <?php 
					}
					while($relatedQuery->have_posts()){
						$relatedQuery->the_post();
						$season = $post;
						if($season->ID != $current_season_id){

							$season_number = $season->post_title;
							$season_number = explode("-", $season_number)[1];
							$thumb = wp_get_attachment_url(get_post_thumbnail_id($season->ID));
							$postQuery = new WP_Query( array(
								'post_type' => array('episode') ,
								'post_status' => "publish",
								'posts_per_page' => 1,
								'meta_key' => array('episode_numbar'),
								'orderby' => 'meta_value_num',
								'meta_query' => array(
									array(
										'key' => 'episode_season',
										'value' => $season->ID,
										'compare' => '=='
									),
								),
							));

							if($postQuery->have_posts()){
								$postQuery->the_post();
								$ep = $post;
								?>
								<a href="<?=the_permalink()?>">
									<img class="serie-related-poster" src="<?=$thumb?>" width="40"/>
									<div class="serie-related-data">
										<h1><?=$season_number?></h1>
									</div>
									<div class="serie-related-icon">
										<i class="fa fa-chevron-circle-left"></i>
									</div>
									
								</a>
								<?php
							}
						}
						
					}wp_reset_query();
				?>
			</div>
	</section>

	<section class="serie-episodes-watch">
		<div class="serie-episodes-watch-list">
			<h1>الحلقات</h1>
			<ul>
			<?php $i = 1; foreach ($watchServers as $server) { ?>
				<?php $class=""; if($i == intval($epnumber)){
					$class = "active";
				} ?>
				<li data-watch="<?=$server['server_url']?>" class="<?=$class?>">
					<i class="fa fa-play"></i>
					<span><?php echo $server['server_name'] ?></span>
				</li>
			<?php $i++;} ?>
			</ul>
		</div>
		<div class="serie-watch-area">
			<?php 
				$allowed = false;
				 $subscription_plans = array('9283' , '9284' , '9285');
				if( !pms_is_post_restricted( $pageid ) ){
					// if(pms_is_member_of_plan( $subscription_plans)){
						$allowed = true;
					// } 
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
<div class="report-modal">
	<div class="report-modal-wrapper">
		<i class="fa fa-close"></i>
		<div class="modal-title">
			<h1>تبليغ عن خطأ</h1>
		</div>
		<div class="modal-content">
			<span id="reportalert" style="display:none;color: brown;margin-bottom: 10px;" > يرجى تعبئة جميع الحقول المطلوبة </span>
			<input type="hidden" value="<?php echo get_current_user_id();?>" id="reportuser"/>
			<input placeholder="الموضوع" id="reportsubject" type="text">
			<textarea placeholder="وصف المشكل" id="reportcontent" rows="5"></textarea>
			<button id="reportbutton" >إرسال</button>
		</div>
		
	</div>							

</div>

<script>
	$(".report-modal").hide();
	$("#report").click(function(){
		$(".report-modal").show(200);
	});
	$(".report-modal-wrapper .fa-close ").click(function(){
		$(".report-modal").hide(200);
	});


	$('#reportbutton').click(function(){
		let content = $("#reportcontent").val().trim();
		let sub = $("#reportsubject").val().trim();
		let user = $("#reportuser").val();
		if(sub == "" || content == ""){
			$("#reportalert").css("display" , "block");
		} else {
			$("#reportalert").css("display" , "none");
			$("#reportbutton").html("<i class='fa fa-spinner'></i>");
			$.post('/wp-content/themes/arbCinema/Ajax/reports.php', {action: "SET" , subject: sub , cnt: content , uid: user } , function(data) {
				$("#reportbutton").html("إرسال");
				$("#reportcontent").val("");
				$("#reportsubject").val("");
				$(".report-modal").hide(200);
			});
		}
	});
</script>


<?php get_footer() ?>