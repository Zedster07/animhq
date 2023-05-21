<!-- index.php top -->
<div class="MainSLider">
	<span class="slider-home-next"><i class="fa fa-chevron-right"></i></span>
	<span class="slider-home-prev"><i class="fa fa-chevron-left"></i></span>
	<div class="homeSlider owl-carousel owl-theme">
		<?php
			$sldierQuery = new WP_Query(array(
				'post_type' => 'movie',
				'posts_per_page' => 12,
				'meta_key' => 'pin'
			));
		?>
		<?php if ($sldierQuery->have_posts()) : while ($sldierQuery->have_posts()) : $sldierQuery->the_post(); ?>
			<?php $thumb = wp_get_attachment_url(get_post_thumbnail_id()); ?>
			<div class="item">
				<a href="<?php the_permalink() ?>" title="<?php the_title() ?>">
					<?php if (!empty($thumb)) { ?>
						<img src="<?=$thumb?>" alt="<?=the_title() ?>">
					<?php } else { ?>
						<img src="<?=get_template_directory_uri()?>/Interface/images/no-thumb.jpeg" alt="<?=the_title() ?>">
					<?php } ?>
					<h2><?php the_title() ?></h2>
				</a>
			</div>
		<?php endwhile;endif;wp_reset_query() ?>
	</div>
</div>
<script type="text/javascript">
	$(function() {
		$('.homeSlider').owlCarousel({
		    loop:true,
		    margin:8,
		    nav:true,
		    items:<?php if (!wp_is_mobile()) { ?> 5.3 <?php } else { ?>1.3<?php } ?>,
		    nav:false,
			dots:false,
			center:true,
			//autoplay: true,
		    autoplayTimeout: 4000,
		    autoplayHoverPause: true
		});
		$(".slider-home-next").click(function() {
			$(".MainSLider .owl-next").click();
		});
		$(".slider-home-prev").click(function() {
			$(".MainSLider .owl-prev").click();
		});
	})
</script>
<div class="shadow"></div>
<div class="adsHome">
	<div class="container">
		<div class="col">
			<?php $headerRightAD = get_option('headerRightAD') ?>
			<?php if (empty($headerRightAD)) { ?>
				<img src="<?=get_template_directory_uri()?>/Interface/images/bannerDark.png">
			<?php } else { ?>
				<a href="<?=get_option('headerRightADUrl')?>">
					<img src="<?=$headerRightAD?>">
				</a>
			<?php } ?>
		</div>
		<div class="col">
			<?php $headerCenterAD = get_option('headerCenterAD') ?>
			<?php if (empty($headerCenterAD)) { ?>
				<img src="<?=get_template_directory_uri()?>/Interface/images/bannerLight.png">
			<?php } else { ?>
				<a href="<?=get_option('headerCenterADUrl')?>">
					<img src="<?=$headerCenterAD?>">
				</a>
			<?php } ?>
		</div>
		<div class="col">
			<?php $headerLeftAD = get_option('headerLeftAD') ?>
			<?php if (empty($headerLeftAD)) { ?>
				<img src="<?=get_template_directory_uri()?>/Interface/images/bannerRed.png">
			<?php } else { ?>
				<a href="<?=get_option('headerLeftADUrl')?>">
					<img src="<?=$headerLeftAD?>">
				</a>
			<?php } ?>
		</div>
		<div class="clr"></div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$(".filter-slider ul li").click(function(){
			$(this).addClass('active').siblings().removeClass('active')
		})
		$("li#newMovies").click(function(){
			$(".NewMoviesHolder").html('<div class="loader"></div>');
			$.ajax({
				url: "<?=get_template_directory_uri()?>/Ajax/Home/new-movies.php",
				type: 'POST',
				data: '',
				success: function(data) {
					$(".NewMoviesHolder").html(data)
				}
			});
		});
		$("li#fireMovies").click(function(){
			$(".NewMoviesHolder").html('<div class="loader"></div>');
			$.ajax({
				url: "<?=get_template_directory_uri()?>/Ajax/Home/fire-movies.php",
				type: 'POST',
				data: '',
				success: function(data) {
					$(".NewMoviesHolder").html(data)
				}
			});
		});
		$("li#MDMovies").click(function(){
			$(".NewMoviesHolder").html('<div class="loader"></div>');
			$.ajax({
				url: "<?=get_template_directory_uri()?>/Ajax/Home/md-movies.php",
				type: 'POST',
				data: '',
				success: function(data) {
					$(".NewMoviesHolder").html(data)
				}
			});
		});
		$("li#newSeries").click(function(){
			$(".SeriesBlocksHolder").html('<div class="loader"></div>');
			$.ajax({
				url: "<?=get_template_directory_uri()?>/Ajax/Home/new-series.php",
				type: 'POST',
				data: '',
				success: function(data) {
					$(".SeriesBlocksHolder").html(data)
				}
			});
		});
		$("li#fireSeries").click(function(){
			$(".SeriesBlocksHolder").html('<div class="loader"></div>');
			$.ajax({
				url: "<?=get_template_directory_uri()?>/Ajax/Home/fire-series.php",
				type: 'POST',
				data: '',
				success: function(data) {
					$(".SeriesBlocksHolder").html(data)
				}
			});
		});
	});
</script>
<!--: Pin Posts :-->
<div class="newset-master scroll-load">
	<div class="container">
		<div class="right">
			<h2 class="section-title">
				<i class="fa fa-play"></i><span><?=_e('احدث الافلام','Mekawadity'); ?></span>
			</h2>
			<div class="movie">
				<span class="next"><i class="fa fa-chevron-right"></i></span>
				<span class="prev"><i class="fa fa-chevron-left"></i></span>
				<?php
					$moviesQuery = new WP_Query(array('post_type' => 'movie' , 'posts_per_page' => 5 ));
				?>
				<div class="movie-slider owl-carousel owl-theme">
					<?php if ($moviesQuery->have_posts()) : while ($moviesQuery->have_posts()) : $moviesQuery->the_post(); ?>
						<?php $thumb = wp_get_attachment_url(get_post_thumbnail_id()); ?>
						<div class="item" style="background: url(<?=$thumb?>)">
							<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>">
								<h3><?=the_title()?></h3>
							</a>
						</div>
		        	<?php endwhile;endif;wp_reset_query() ?>
		        </div>
		        <div class="filter-slider">
		        	<ul>
		        		<li id="newMovies" class="active"><i class="fa fa-clock-o"></i>المضاف حديثا</li>
		    			<li id="fireMovies"><i class="fa fa-fire"></i>الاكثر مشاهده</li>
		    			<li id="MDMovies"><i class="fa fa-download"></i>الاكثر تحميلا</li>
		    			<div class="clr"></div>
		        	</ul>
		        </div>
		        <div class="BlocksHolder NewMoviesHolder">
					<?php
						$moviesQuery = new WP_Query(array('post_type' => 'movie' , 'posts_per_page' => 6, 'offset' => 5 ))
					?>
					<?php if ($moviesQuery->have_posts()) : while ($moviesQuery->have_posts()) : $moviesQuery->the_post(); $thumb = wp_get_attachment_url(get_post_thumbnail_id()); ?>
						<div class="block">
							<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>">
								<?php if (!empty($thumb)) { ?>
									<img src="<?=$thumb?>" alt="<?=the_title() ?>">
								<?php } else { ?>
									<img src="<?=get_template_directory_uri()?>/Interface/images/no-thumb.jpeg" alt="<?=the_title() ?>">
								<?php } ?>
								<h3><?=the_title()?></h3>
								<p><?=wp_trim_words(get_the_content(), 20 , '....')?></p>
							</a>
						</div>
					<?php endwhile;endif;wp_reset_query() ?>
					<div class="clr"></div>
		        </div>
			</div>
		</div>
		<div class="left">
			<h2 class="section-title">
				<i class="fa fa-tv"></i><span><?=_e('احدث المسلسلات','Mekawadity'); ?></span>
			</h2>
			<div class="series">
		 	 	<span class="next"><i class="fa fa-chevron-right"></i></span>
			  	<span class="prev"><i class="fa fa-chevron-left"></i></span>
				<div class="series-slider owl-carousel owl-theme">
					<?php 
						$seriesQuery = new WP_Query(array('post_type' => array('serie','season') , 'posts_per_page' => 5  ));
					?>
					<?php if ($seriesQuery->have_posts()) : while ($seriesQuery->have_posts()) : $seriesQuery->the_post(); ?>
						<?php $thumb = wp_get_attachment_url(get_post_thumbnail_id()); ?>
						<div class="item" style="background: url(<?=$thumb; ?>);background-size: cover;background-repeat: no-repeat;background-position:top center;">
							<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>">
								<h3><?=the_title()?></h3>
							</a>
						</div>
		        	<?php endwhile;endif;wp_reset_query() ?>
		        </div>
		        <div class="filter-slider">
		        	<ul>
		        		<li id="newSeries" class="active"><i class="fa fa-clock-o"></i>المضاف حديثا</li>
		    			<li id="fireSeries"><i class="fa fa-fire"></i>الاكثر مشاهده</li>
		    			<div class="clr"></div>
		        	</ul>
		        </div>
		        <div class="BlocksHolder SeriesBlocksHolder">
					<?php 
						query_posts(array('post_type' => array('serie','season') , 'posts_per_page' => 6 , 'offset' => 5  ))
					?>
					<?php if (have_posts()) { while (have_posts()) { the_post(); $thumb = wp_get_attachment_url(get_post_thumbnail_id()); ?>
						<div class="block">
							<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>">
								<?php if (!empty($thumb)) { ?>
									<img src="<?=$thumb?>" alt="<?=the_title() ?>">
								<?php } else { ?>
									<img src="<?=get_template_directory_uri()?>/Interface/images/no-thumb.jpeg" alt="<?=the_title() ?>">
								<?php } ?>
								<h3><?=the_title()?></h3>
								<p><?=wp_trim_words(get_the_content(), 20 , '....')?></p>
							</a>
						</div>
					<?php } ; } ; wp_reset_query() ?>
		        </div>
				<div class="clr"></div>
			</div>
		</div>
		<div class="clr"></div>
	</div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
    	$('.slidersubcats').owlCarousel({
		    loop:true,
		    margin:10,
		    nav:true,
		    items:6,
		    nav:false,
			dots:true
		});
		$('.movie-slider').owlCarousel({
		    loop:true,
		    margin:10,
		    nav:true,
		    items:1,
		    nav:false,
			dots:false
		});
		$('.movie span.next').on('click',function(){
	    	$('.movie-slider .owl-next').click();
	    });
	    $('.movie span.prev').on('click',function(){
	    	$('.movie-slider .owl-prev').click();
	    });
        $('.series-slider').owlCarousel({
		    loop:true,
		    margin:10,
		    nav:true,
			items:1,
			nav:false,
			dots:false
		});
	    $('.series span.next').on('click',function(){
	    	$('.series-slider .owl-next').click();
	    });
	    $('.series span.prev').on('click',function(){
	    	$('.series-slider .owl-prev').click();
	    });
    });
</script>

