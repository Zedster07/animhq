
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

	function getSeason($seasonID){
		global $pdo;
		$query = "SELECT * FROM seasons where id = :season_id";
		$stmt = $pdo->prepare($query);
		$stmt->bindParam(':season_id', $seasonID, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_OBJ);
	}

	$query = "SELECT s.serieId, s.name, e.seasonId, e.eorder , e.name  , e.video , s.cover FROM episodes e JOIN seasons s ON e.seasonId = s.id WHERE (e.seasonId, e.eorder) IN ( SELECT seasonId, MAX(eorder) FROM episodes GROUP BY seasonId ) ORDER BY s.serieId;";
	$stmt = $pdo->prepare($query);
	$stmt->execute();
	
	if($stmt->rowCount() > 0) {
		?> 
			<section class="posts-section recent-posts" id="recent-posts">
			<div class="container">
			<div class="content-animehq flex-row">
			<h1 class="section-title"> آخر الحلقات </h1>	
		<?php 
		$episodes = $stmt->fetchAll(PDO::FETCH_OBJ);
		foreach ($episodes as $episode) {
			$years_list = array();
			$cats_list = array();
			$episodes_list = array();
			$rates_list = array();
			$season = getSeason($episode->seasonId);
			$postQuery = new WP_Query( array(
				'p' => $season->serieId, // Set the post ID to retrieve
				'post_type' => 'serie', // Specify the post type (e.g., 'post', 'page', 'custom_post_type')
				'post_status' => 'publish', // Limit to published posts
				'posts_per_page' => 1 // Limit to one post
			));
			if ($postQuery->have_posts()) {
				$postQuery->the_post();
				$serie_name = $post->post_title;
				array_push($cats_list , get_the_terms($post->ID,'category' , ''));
				array_push($years_list , get_the_terms($post->ID,'year-cat' , ''));
				array_push($rates_list , get_the_terms($post->ID,'ratings-cat' , ''));
				
				?>
					<div class="single-poster flex-item  visiblegroup-<?=$group?>" >

					
						<?php if (!empty($season->cover)) { ?>
							<img class="poster-img" src="<?=$season->cover?>" alt="<?=the_title() ?>">
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
										<h6><?=$season->name.' - '.$episode->name?></h6>
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
		

		?>	
			</div>
			</div>
			</section>
		<?php

	}

?>


