<?php 
	get_header();
	makeViews(get_the_ID());
	$Thumbnail = wp_get_attachment_url( get_post_thumbnail_id() );
	$Cover = get_post_meta($post->ID,'cover',true);
?>
<script type="application/ld+json"> {
	"@context" : "http://schema.org",
	"@type" : "WebSite",
	"name" : "<?php bloginfo('name'); ?>",
	"alternateName" : "<?php bloginfo('description'); ?>",
	"url" : "<?php home_url()?>" }
</script>
<script type="application/ld+json"> {
	"@context": "http://schema.org",
	"@type": "WebSite",
	"url": "<?php home_url()?>", }
</script>
<?php if (!empty($Cover)) { ?>
<style type="text/css">
	.single-header {
		background-image: url(<?=$Cover?>)
	}
</style>
<?php } else { ?>
<style type="text/css">
	.single-header {
		background-image: url(<?=$Thumbnail?>)
	}
</style>
<?php } ?>
<script type="text/javascript">
	$(document).ready(function(){
		$(".single-tabs button").click(function(){
			$(".singleBigBox").fadeIn().addClass('active');
		});
	});
</script>
<div class="single-header">
	<div class="container">
		<div class="post-thumb">
			<?php if (!empty($Thumbnail)) { ?>
				<img src="<?=$Thumbnail?>" alt="<?=the_title() ?>">
			<?php } else { ?>
				<img src="<?=get_template_directory_uri()?>/Interface/images/no-thumb.jpeg" alt="<?=the_title() ?>">
			<?php } ?>
		</div>
		<h1 class="single-title"><span><?=the_title() ?></span></h1>
		<div class="single-tabs">
			<button class="info"><i class="fa fa-info"></i><span>التفاصيل</span></button>
			<?php $episode_list = get_post_meta($post->ID,'episodes_list',true) ?>
			<?php $episode_list = (is_array($episode_list)) ? $episode_list : array() ?>
			<?php $episode_list = array_unique($episode_list) ?>
			<?php if (count($episode_list) != 0) { ?>
				<button class="episodesList"><i class="fa fa-play"></i><span>الحلقات</span></button>
			<?php } ?>
			<?php $seasons_list = get_post_meta($post->ID,'episodes_list',true) ?>
			<?php $seasons_list = (is_array($seasons_list)) ? $seasons_list : array() ?>
			<?php $seasons_list = array_unique($seasons_list) ?>
			<?php if (count($seasons_list) != 0) { ?>
				<button class="seasonsList"><i class="fa fa-film"></i><span>المواسم</span></button>
			<?php } ?>
			<button class="comments"><i class="fa fa-comments"></i><span>التعليقات</span> </button>
			<div class="clr"></div>
			<script type="text/javascript">
				$(document).ready(function(){
					$("button.info").click(function(){
						$('.singleBigBox').html("<div class='loader'></div>");
						$.ajax({
							url: "<?=get_template_directory_uri()?>/Ajax/Single/info.php",
							data: 'postID=<?=$post->ID?>',
							type: 'POST',
							success: function(Res) {
								$('.singleBigBox').html(Res);
							}
						});
					});
					$("button.episodesList").click(function(){
						$('.singleBigBox').html("<div class='loader'></div>");
						$.ajax({
							url: "<?=get_template_directory_uri()?>/Ajax/Single/episodes-list.php",
							data: 'postID=<?=$post->ID?>',
							type: 'POST',
							success: function(Res) {
								$('.singleBigBox').html(Res);
							}
						});
					});
					$("button.comments").click(function(){
						$('.singleBigBox').html("<div class='loader'></div>");
						$.ajax({
							url: "<?=get_template_directory_uri()?>/Ajax/Single/comments.php",
							data: 'postID=<?=$post->ID?>',
							type: 'POST',
							success: function(Res) {
								$('.singleBigBox').html(Res);
							}
						});
					});
					$("button.seasonsList").click(function(){
						$('.singleBigBox').html("<div class='loader'></div>");
						$.ajax({
							url: "<?=get_template_directory_uri()?>/Ajax/Single/seasons-list.php",
							data: 'postID=<?=$post->ID?>',
							type: 'POST',
							success: function(Res) {
								$('.singleBigBox').html(Res);
							}
						});
					});
				})
			</script>
		</div>
		<div class="social-share">
			<h2><i class="fa fa-share-alt"></i>مشاركه الموضوع</h2>
			<ul>
			<li class="share-google">
	            <a href="https://plus.google.com/share?url=<?php the_permalink(); ?>" rel="nofollow" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;">
	                <i class="fa fa-google"></i>
	            </a>
	        </li>
	        <li class="share-facebook">
	            <a href="http://www.facebook.com/sharer.php?u=<?php the_permalink();?>&t=<?php the_title(); ?>" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;" rel="nofollow" target="_blank">
	                <i class="fa fa-facebook"></i>
	            </a>
	        </li>
	        <li class="share-twitter">
	            <a href="http://twitter.com/share?url=<?php the_permalink(); ?>" rel="nofollow" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;" target="_blank">
	                <i class="fa fa-twitter"></i>
	            </a>
	        </li>
	        <li class="share-pinterest">
	        	<a href="http://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&amp;media=<?php $img = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); echo $img; ?>" rel="nofollow" class="pin-it-button" count-layout="horizontal" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;">
	        		<i class="fa fa-pinterest"></i>
	        	</a>
	        </li>
	        <li class="share-linkedin">
	            <a onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;" rel="nofollow" target="_blank" href="http://www.linkedin.com/shareArticle?mini=true&url=<?=the_permalink()?>&title=<?=the_title()?>">
	                <i class="fa fa-linkedin"></i>
	            </a>
	        </li>
	        <div class="clr"></div>
	    </ul>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		$(".single-tabs button").click(function() {
			$(this).addClass("active").siblings().removeClass("active");
		});
	})
</script>
<div class="clr"></div>

<div class="singleBigBox single-info">
	
</div>
<div class="random-posts">
	<div class="container">
		<ul>
			<?php
				$term = get_the_terms($post->ID,'category','');
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
</div>
<script type="text/javascript">
	$(function() {
		$('.fancybox').fancybox();
	});
</script>
<?php get_footer() ?>