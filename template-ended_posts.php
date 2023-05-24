
						
<div class="container">
	<div class="content-animehq flex-row">
	<?php
		$db_name = $wpdb->dbname;
		$db_user = $wpdb->dbuser;
		$db_password = $wpdb->dbpassword;
		$db_host = $wpdb->dbhost;
		
		try {
			$pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_password);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {
			die("Database connection failed: " . $e->getMessage());
		}

		$total = 0;
		$recentQuery = new WP_Query( array( 
			'post_type' => array('serie') ,
			'post_status' => "publish",
			'posts_per_page' => 24,
			'orderby' => 'publish_date',
			'order' => 'DESC',
			'paged' => 1,
		));

		
		if ($recentQuery->have_posts()) { 
			?> 
			<h1 class="section-title"> أحدث المسلسلات  </h1>
			<?php
			while ($recentQuery->have_posts()){
				$years_list = array();
				$cats_list = array();
				$episodes_list = array();
				$rates_list = array();
				$seasons_list = array(); 

				$recentQuery->the_post();
				$serie_name = $post->post_title;
				$query = "SELECT * FROM seasons WHERE serieId = :post_id ORDER BY ID DESC LIMIT 1";
				$stmt = $pdo->prepare($query);
				$stmt->bindParam(':post_id', $post->ID, PDO::PARAM_INT);
				$stmt->execute();
				
				if($stmt->rowCount() > 0) {
					$season = $stmt->fetch(PDO::FETCH_OBJ);
					
					array_push($cats_list , get_the_terms($post->ID,'category' , ''));
					array_push($years_list , get_the_terms($post->ID,'year-cat' , ''));
					array_push($rates_list , get_the_terms($post->ID,'ratings-cat' , ''));
					array_push($episodes_list , get_post($post->ID));
					?>
					<div class="single-poster flex-item  visiblegroup-<?=$group?>" >

					
						<?php if (!empty($season->cover)) { ?>
							<div class="poster-img" style="background: url(<?php echo($season->cover) ?>);   background-size: cover;
  background-position: center center;"></div>
						<?php } else { ?>
							<img class="poster-img" src="<?=get_template_directory_uri()?>/Interface/images/no-thumb.jpeg" alt="<?=the_title() ?>">
						<?php } ?>


						<div class="poster-wrapper">


							<div class="poster-tags">
								<?php if (!empty($rates_list[0])) { foreach (array_slice($rates_list[0], 0,1 ) as $key ) {
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
								<h3><?=$serie_name;?></h3>
								<div class="poster-year-season">
									<?php if($season->sorder){ ?>
										<h6><?=$season->name?></h6>
									<?php } ?>
									<?php if($season->sorder && !empty($years_list[0]) ){ ?>
										<h6>-</h6>
									<?php }?>
									
									<?php if (!empty($years_list[0])) { foreach (array_slice($years_list[0], 0,1 ) as $key ) { ?>
										<h6><?=$key->name?></h6>
									<?php }} ?>
								</div>
							</div>
						</div>

						</div>
						<?php 
					} ?>
					<?php
				}
			}
		
	?>
	</div>
</div>