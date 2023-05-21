<?php 
	if ( $_SERVER['HTTP_X_REQUESTED_WITH'] == "XMLHttpRequest" ) { 
		define('WP_USE_THEMES', false);
		$URI = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
		require_once( $URI[0] . 'wp-load.php' );
		$post = $_POST['postID'];
		?>
		<?php $thumbnail = wp_get_attachment_url(get_post_thumbnail_id($post)) ?>
		<div class="container">
			<div class="right">
				<div class="post-thumbnail">
					<img src="<?=$thumbnail?>">
				</div>
			</div>
			<div class="center">
				<?php if (get_post_type($post) != 'episode') { ?>
					<?php $content = get_post($post) ?>
					<?php if (!empty($content->post_content)) { ?>
						<p class="description">
							<?php echo $content->post_content ?>
						</p>
					<?php } ?>
				<?php } ?>
				<?php if (get_post_type($post) == 'episode') { ?>
					<?php $episodeSerie = get_post_meta($post,'episode_serie',true) ?>
					<?php $episodeSeason = get_post_meta($post,'episode_season',true) ?>
					<?php if (!empty(get_post($post)->post_content)) { ?>
						<p class="description">
							<?php echo get_post($post)->post_content ?>
						</p>
					<?php } elseif (!empty(get_post($episodeSeason)->post_content)) { ?>
						<p class="description">
							<?php echo get_post($episodeSeason)->post_content ?>
						</p>
					<?php } elseif (!empty(get_post($episodeSerie)->post_content)) { ?>
						<p class="description">
							<?php echo get_post($episodeSerie)->post_content ?>
						</p>
					<?php } ?>
				<?php } ?>
				<div class="Box">
					<h1><i class="fa fa-bars"></i><span>تفاصيل العرض</span></h1>
					<ul>
						<?php $Cat = get_the_terms($post,'category','') ?>
						<?php $Cat = (is_array($Cat)) ? $Cat : array() ?>
						<?php if (!empty($Cat)) { ?>
							<li>
								<i class="fa fa-bars"></i>
								<em>القسم : </em>
								<?php foreach ($Cat as $Ca) { ?>
									<a href="<?=get_term_link($Ca)?>"><?=$Ca->name?></a>
								<?php } ?>
							</li>
						<?php } ?>
						<?php $Posttime = get_post_meta($post,'post_time',true) ?>
						<?php if (!empty($Posttime)) { ?>
							<li>
								<i class="fa fa-clock-o"></i>
								<em>مده العرض : </em>
								<a href="javascript:void(0)"><?php echo $Posttime ?></a>
							</li>
						<?php } ?>
						<?php $Qus = get_the_terms($post,'quality-cat','') ?>
						<?php $Qus = (is_array($Qus)) ? $Qus : array(); ?>
						<?php if (!empty($Qus)) { ?>
							<li class="quality-cat">
								<i class="fa fa-video-camera"></i>
								<em>الجوده : </em>
								<?php foreach ($Qus as $Qu) { ?>
									<a href="<?=get_term_link($Qu)?>"><?=$Qu->name?></a>
								<?php } ?>
							</li>
						<?php } ?>
						<?php $Yrs = get_the_terms($post,'year-cat','') ?>
						<?php $Yrs = (is_array($Yrs)) ? $Yrs : array(); ?>
						<?php if (!empty($Yrs)) { ?>
							<li class="quality-cat">
								<i class="fa fa-calendar"></i>
								<em>سنه الاصدار : </em>
								<?php foreach ($Yrs as $Yr) { ?>
									<a href="<?=get_term_link($Yr)?>"><?=$Yr->name?></a>
								<?php } ?>
							</li>
						<?php } ?>
						<?php $Types = get_the_terms($post,'type-cat','') ?>
						<?php $Types = (is_array($Types)) ? $Types : array(); ?>
						<?php if (!empty($Types)) { ?>
							<li>
								<i class="fa fa-tags"></i>
								<em>النوع : </em>
								<?php foreach ($Types as $TY) { ?>
									<a href="<?=get_term_link($TY)?>"><?=$TY->name?></a>
								<?php } ?>
							</li>
						<?php } ?>
						<?php $Langs = get_the_terms($post,'language-cat','') ?>
						<?php $Langs = (is_array($Langs)) ? $Langs : array(); ?>
						<?php if (!empty($Langs)) { ?>
							<li>
								<i class="fa fa-language"></i>
								<em>اللغه : </em>
								<?php foreach ($Langs as $Lang) { ?>
									<a href="<?=get_term_link($Lang)?>"><?=$Lang->name?></a>
								<?php } ?>
							</li>
						<?php } ?>
						<?php $Countries = get_the_terms($post,'country-cat','') ?>
						<?php $Countries = (is_array($Countries)) ? $Countries : array(); ?>
						<?php if (!empty($Countries)) { ?>
							<li>
								<i class="fa fa-globe"></i>
								<em>بلد الانتاج : </em>
								<?php foreach ($Countries as $Coun) { ?>
									<a href="<?=get_term_link($Coun)?>"><?=$Coun->name?></a>
								<?php } ?>
							</li>
						<?php } ?>
						<?php $Writers = get_the_terms($post,'writer-cat','') ?>
						<?php $Writers = (is_array($Writers)) ? $Writers : array(); ?>
						<?php if (!empty($Writers)) { ?>
							<li>
								<i class="fa fa-pencil"></i>
								<em>الكاتب : </em>
								<?php foreach ($Writers as $writer) { ?>
									<a href="<?=get_term_link($writer)?>"><?=$writer->name?></a>
								<?php } ?>
							</li>
						<?php } ?>
						<?php $Productions = get_the_terms($post,'production-cat','') ?>
						<?php $Productions = (is_array($Productions)) ? $Productions : array(); ?>
						<?php if (!empty($Productions)) { ?>
							<li>
								<i class="fa fa-money"></i>
								<em>انتاج : </em>
								<?php foreach ($Productions as $production) { ?>
									<a href="<?=get_term_link($production)?>"><?=$production->name?></a>
								<?php } ?>
							</li>
						<?php } ?>
						<?php if (get_post_type($post) == 'serie') { ?>
							<?php $episodesNum = get_post_meta($post,'episodes_list',true) ?>
							<?php $episodesNum = array_unique($episodesNum) ?>
							<li class="quality-cat">
								<i class="fa fa-clock-o"></i>
								<em>عدد الحلقات : </em>
								<a href="javascript:void(0)"><?php echo count($episodesNum) ?></a>
							</li>
							<?php $seasons_list = get_post_meta($post,'seasons_list',true); ?>
							<?php $seasons_list = (is_array($seasons_list)) ? $seasons_list : array() ; ?>
							<?php $seasons_list = array_unique($seasons_list) ?>
							<?php if (count($seasons_list) != 0) { ?>
								<li class="quality-cat">
									<i class="fa fa-play"></i>
									<em>عدد المواسم : </em>
									<a href="javascript:void(0)"><?php echo count($seasons_list) ?></a>
								</li>
							<?php } ?>
						<?php } ?>
						<?php if (get_post_type($post) == 'episode') { ?>
							<?php $episodeSerie = get_post_meta($post,'episode_serie',true) ?>
							<?php $episode_season = get_post_meta($post,'episode_season',true) ?>
							<?php if (!empty($episode_season)) { ?>
								<?php $Cat = get_the_terms($episodeSerie,'category','') ?>
								<?php $Cat = (is_array($Cat)) ? $Cat : array() ?>
								<?php if (!empty($Cat)) { ?>
									<li>
										<i class="fa fa-bars"></i>
										<em>القسم : </em>
										<?php foreach ($Cat as $Ca) { ?>
											<a href="<?=get_term_link($Ca)?>"><?=$Ca->name?></a>
										<?php } ?>
									</li>
								<?php } ?>
								<?php $Posttime = get_post_meta($episode_season,'post_time',true) ?>
								<?php if (!empty($Posttime)) { ?>
									<li>
										<i class="fa fa-clock-o"></i>
										<em>مده العرض : </em>
										<a href="javascript:void(0)"><?php echo $Posttime ?></a>
									</li>
								<?php } ?>
								<?php $Yrs = get_the_terms($episode_season,'year-cat','') ?>
								<?php $Yrs = (is_array($Yrs)) ? $Yrs : array(); ?>
								<?php if (!empty($Yrs)) { ?>
									<li class="quality-cat">
										<i class="fa fa-calendar"></i>
										<em>سنه الاصدار : </em>
										<?php foreach ($Yrs as $Yr) { ?>
											<a href="<?=get_term_link($Yr)?>"><?=$Yr->name?></a>
										<?php } ?>
									</li>
								<?php } ?>
								<?php $Types = get_the_terms($episode_season,'type-cat','') ?>
								<?php $Types = (is_array($Types)) ? $Types : array(); ?>
								<?php if (!empty($Types)) { ?>
									<li>
										<i class="fa fa-tags"></i>
										<em>النوع : </em>
										<?php foreach ($Types as $TY) { ?>
											<a href="<?=get_term_link($TY)?>"><?=$TY->name?></a>
										<?php } ?>
									</li>
								<?php } ?>
								<?php $Langs = get_the_terms($episode_season,'language-cat','') ?>
								<?php $Langs = (is_array($Langs)) ? $Langs : array(); ?>
								<?php if (!empty($Langs)) { ?>
									<li>
										<i class="fa fa-language"></i>
										<em>اللغه : </em>
										<?php foreach ($Langs as $Lang) { ?>
											<a href="<?=get_term_link($Lang)?>"><?=$Lang->name?></a>
										<?php } ?>
									</li>
								<?php } ?>
								<?php $Countries = get_the_terms($episode_season,'country-cat','') ?>
								<?php $Countries = (is_array($Countries)) ? $Countries : array(); ?>
								<?php if (!empty($Countries)) { ?>
									<li>
										<i class="fa fa-globe"></i>
										<em>بلد الانتاج : </em>
										<?php foreach ($Countries as $Coun) { ?>
											<a href="<?=get_term_link($Coun)?>"><?=$Coun->name?></a>
										<?php } ?>
									</li>
								<?php } ?>
								<?php $Writers = get_the_terms($episode_season,'writer-cat','') ?>
								<?php $Writers = (is_array($Writers)) ? $Writers : array(); ?>
								<?php if (!empty($Writers)) { ?>
									<li>
										<i class="fa fa-pencil"></i>
										<em>الكاتب : </em>
										<?php foreach ($Writers as $writer) { ?>
											<a href="<?=get_term_link($writer)?>"><?=$writer->name?></a>
										<?php } ?>
									</li>
								<?php } ?>
								<?php $Productions = get_the_terms($episode_season,'production-cat','') ?>
								<?php $Productions = (is_array($Productions)) ? $Productions : array(); ?>
								<?php if (!empty($Productions)) { ?>
									<li>
										<i class="fa fa-money"></i>
										<em>انتاج : </em>
										<?php foreach ($Productions as $production) { ?>
											<a href="<?=get_term_link($production)?>"><?=$production->name?></a>
										<?php } ?>
									</li>
								<?php } ?>
								<li>
									<i class="fa fa-folder"></i>
									<em>المسلسل : </em>
									<?php $season_serie = get_post_meta($episode_season,'season_serie',true) ?>
									<a href="<?=get_the_permalink($season_serie)?>"><?php echo get_the_title($season_serie) ?></a>
								</li>
								<li>
									<i class="fa fa-th-large"></i>
									<em>الموسم : </em>
									<a href="<?=get_the_permalink($episode_season)?>"><?php echo get_the_title($episode_season) ?></a>
								</li>
								<?php $episode_numbar = get_post_meta($post,'episode_numbar',true) ?>
								<?php if (!empty($episode_numbar)) { ?>
									<li>
										<i class="fa fa-th"></i>
										<em>رقم الحلقه : </em>
										<a href="javascript:void(0)"><?php echo $episode_numbar ?></a>
									</li>
								<?php } ?>
							<?php } else { ?>
								<?php $Cat = get_the_terms($episodeSerie,'category','') ?>
								<?php $Cat = (is_array($Cat)) ? $Cat : array() ?>
								<?php if (!empty($Cat)) { ?>
									<li>
										<i class="fa fa-bars"></i>
										<em>القسم : </em>
										<?php foreach ($Cat as $Ca) { ?>
											<a href="<?=get_term_link($Ca)?>"><?=$Ca->name?></a>
										<?php } ?>
									</li>
								<?php } ?>
								<?php $Posttime = get_post_meta($episodeSerie,'post_time',true) ?>
								<?php if (!empty($Posttime)) { ?>
									<li>
										<i class="fa fa-clock-o"></i>
										<em>مده العرض : </em>
										<a href="javascript:void(0)"><?php echo $Posttime ?></a>
									</li>
								<?php } ?>
								<?php $Yrs = get_the_terms($episodeSerie,'year-cat','') ?>
								<?php $Yrs = (is_array($Yrs)) ? $Yrs : array(); ?>
								<?php if (!empty($Yrs)) { ?>
									<li class="quality-cat">
										<i class="fa fa-calendar"></i>
										<em>سنه الاصدار : </em>
										<?php foreach ($Yrs as $Yr) { ?>
											<a href="<?=get_term_link($Yr)?>"><?=$Yr->name?></a>
										<?php } ?>
									</li>
								<?php } ?>
								<?php $Types = get_the_terms($episodeSerie,'type-cat','') ?>
								<?php $Types = (is_array($Types)) ? $Types : array(); ?>
								<?php if (!empty($Types)) { ?>
									<li>
										<i class="fa fa-tags"></i>
										<em>النوع : </em>
										<?php foreach ($Types as $TY) { ?>
											<a href="<?=get_term_link($TY)?>"><?=$TY->name?></a>
										<?php } ?>
									</li>
								<?php } ?>
								<?php $Langs = get_the_terms($episodeSerie,'language-cat','') ?>
								<?php $Langs = (is_array($Langs)) ? $Langs : array(); ?>
								<?php if (!empty($Langs)) { ?>
									<li>
										<i class="fa fa-language"></i>
										<em>اللغه : </em>
										<?php foreach ($Langs as $Lang) { ?>
											<a href="<?=get_term_link($Lang)?>"><?=$Lang->name?></a>
										<?php } ?>
									</li>
								<?php } ?>
								<?php $Countries = get_the_terms($episodeSerie,'country-cat','') ?>
								<?php $Countries = (is_array($Countries)) ? $Countries : array(); ?>
								<?php if (!empty($Countries)) { ?>
									<li>
										<i class="fa fa-globe"></i>
										<em>بلد الانتاج : </em>
										<?php foreach ($Countries as $Coun) { ?>
											<a href="<?=get_term_link($Coun)?>"><?=$Coun->name?></a>
										<?php } ?>
									</li>
								<?php } ?>
								<?php $Writers = get_the_terms($episodeSerie,'writer-cat','') ?>
								<?php $Writers = (is_array($Writers)) ? $Writers : array(); ?>
								<?php if (!empty($Writers)) { ?>
									<li>
										<i class="fa fa-pencil"></i>
										<em>الكاتب : </em>
										<?php foreach ($Writers as $writer) { ?>
											<a href="<?=get_term_link($writer)?>"><?=$writer->name?></a>
										<?php } ?>
									</li>
								<?php } ?>
								<?php $Productions = get_the_terms($episodeSerie,'production-cat','') ?>
								<?php $Productions = (is_array($Productions)) ? $Productions : array(); ?>
								<?php if (!empty($Productions)) { ?>
									<li>
										<i class="fa fa-money"></i>
										<em>انتاج : </em>
										<?php foreach ($Productions as $production) { ?>
											<a href="<?=get_term_link($production)?>"><?=$production->name?></a>
										<?php } ?>
									</li>
								<?php } ?>
								<li>
									<i class="fa fa-folder"></i>
									<em>المسلسل : </em>
									<a href="<?=get_the_permalink($episodeSerie)?>"><?php echo get_the_title($episodeSerie) ?></a>
								</li>
								<?php $episode_numbar = get_post_meta($post,'episode_numbar',true) ?>
								<?php if (!empty($episode_numbar)) { ?>
									<li>
										<i class="fa fa-th"></i>
										<em>رقم الحلقه : </em>
										<a href="javascript:void(0)"><?php echo $episode_numbar ?></a>
									</li>
								<?php } ?>
							<?php } ?>
						<?php } ?>
						<?php if (get_post_type($post) == 'season') { ?>
							<li>
								<i class="fa fa-th"></i>
								<em>المسلسل : </em>
								<?php $season_serie = get_post_meta($post,'season_serie',true) ?>
								<a href="<?=get_the_permalink($season_serie)?>"><?=get_the_title($season_serie) ?></a>
							</li>
						<?php } ?>
						<?php $Views = get_post_meta($post,'Views',true) ?>
						<li class="quality-cat">
							<i class="fa fa-eye"></i>
							<em>عدد المشاهدات : </em>
							<a href="javascript:void(0)"><?php echo $Views ?></a>
						</li>
						<?php $downloadCount = get_post_meta($post,'download_count',true) ?>
						<?php if (!empty($downloadCount)) { ?>
							<li class="quality-cat">
								<i class="fa fa-cloud-download"></i>
								<em>عدد التحميلات : </em>
								<a href="javascript:void(0)"><?php echo $downloadCount ?></a>
							</li>
						<?php } ?>
						<div class="clr"></div>
					</ul>
					<div class="clr"></div>
				</div>
			</div>
			<div class="left">
				<h1><i class="fa fa-user"></i><span>فريق العمل</span><div class="clr"></div></h1>
				<?php if (get_post_type($post) != 'episode') { ?>
					<?php $actors = get_the_terms($post,'actor-cat','') ?>
					<?php $actors = (is_array($actors)) ? $actors : array() ?>
					<?php if (!empty($actors)) { ?>
						<?php foreach ($actors as $actor) { ?>
							<li class="TeamWork">
								<a href="<?php echo get_term_link($actor->term_id) ?>">
									<i class="fa fa-user"></i>
									<div class="TMleft">
										<h1><?=$actor->name?></h1>
										<p>مشاهده كل اعمال <?=$actor->name?></p>
									</div>
								</a>
							</li>
							<hr>
						<?php } ?>
					<?php } ?>
					<?php $directors = get_the_terms($post,'director-cat','') ?>
					<?php $directors = (is_array($directors)) ? $directors : array() ?>
					<?php if (!empty($directors)) { ?>
						<?php foreach ($directors as $director) { ?>
							<li class="TeamWork">
								<a href="<?php echo get_term_link($director->term_id) ?>">
									<i class="fa fa-user"></i>
									<div class="TMleft">
										<h1><?=$director->name?></h1>
										<p>مشاهده كل اعمال <?=$director->name?></p>
									</div>
								</a>
							</li>
							<hr>
						<?php } ?>
					<?php } ?>
				<?php } else { ?>
					<?php $episodeSerie = get_post_meta($post,'episode_serie',true) ?>
					<?php $episode_season = get_post_meta($post,'episode_season',true) ?>
					<?php if (!empty($episode_season)) { ?>
						<?php $actors = get_the_terms($episode_season,'actor-cat','') ?>
						<?php $actors = (is_array($actors)) ? $actors : array() ?>
						<?php if (!empty($actors)) { ?>
							<?php foreach ($actors as $actor) { ?>
								<li class="TeamWork">
									<a href="<?php echo get_term_link($actor->term_id) ?>">
										<i class="fa fa-user"></i>
										<div class="TMleft">
											<h1><?=$actor->name?></h1>
											<p>الممثل <?=$actor->name?></p>
										</div>
									</a>
								</li>
								<hr>
							<?php } ?>
						<?php } ?>
						<?php $directors = get_the_terms($episode_season,'director-cat','') ?>
						<?php $directors = (is_array($directors)) ? $directors : array() ?>
						<?php if (!empty($directors)) { ?>
							<?php foreach ($directors as $director) { ?>
								<li class="TeamWork">
									<a href="<?php echo get_term_link($director->term_id) ?>">
										<i class="fa fa-user"></i>
										<div class="TMleft">
											<h1><?=$director->name?></h1>
											<p>المخرج <?=$director->name?></p>
										</div>
									</a>
								</li>
								<hr>
							<?php } ?>
						<?php } ?>
					<?php } else { ?>
						<?php $actors = get_the_terms($episodeSerie,'actor-cat','') ?>
						<?php $actors = (is_array($actors)) ? $actors : array() ?>
						<?php if (!empty($actors)) { ?>
							<?php foreach ($actors as $actor) { ?>
								<li class="TeamWork">
									<a href="<?php echo get_term_link($actor->term_id) ?>">
										<i class="fa fa-user"></i>
										<div class="TMleft">
											<h1><?=$actor->name?></h1>
											<p>الممثل <?=$actor->name?></p>
										</div>
									</a>
								</li>
								<hr>
							<?php } ?>
						<?php } ?>
						<?php $directors = get_the_terms($episodeSerie,'director-cat','') ?>
						<?php $directors = (is_array($directors)) ? $directors : array() ?>
						<?php if (!empty($directors)) { ?>
							<?php foreach ($directors as $director) { ?>
								<li class="TeamWork">
									<a href="<?php echo get_term_link($director->term_id) ?>">
										<i class="fa fa-user"></i>
										<div class="TMleft">
											<h1><?=$director->name?></h1>
											<p>المخرج <?=$director->name?></p>
										</div>
									</a>
								</li>
								<hr>
							<?php } ?>
						<?php } ?>
					<?php } ?>
				<?php } ?>
			</div>
			<div class="clr"></div>
		</div>
		<?php
	}
?>