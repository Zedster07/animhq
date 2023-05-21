
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

	$query = "SELECT * FROM episodes ORDER BY ID DESC LIMIT 24";
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
					<div class="single-poster flex-item  visiblegroup-<?=$group?>" <?=$hide?>>

					
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
									<?php if($season->sorder && !empty($years_list[$i]) ){ ?>
										<h6>-</h6>
									<?php }?>
									
									<?php if (!empty($years_list[$i])) { foreach (array_slice($years_list[$i], 0,1 ) as $key ) { ?>
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


<section class="posts-section recent-posts" id="recent-posts">
<div class="container">
		
		<div class="content-animehq flex-row" >
			
			<?php
				$total = 0;
				$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
				$recentQuery = new WP_Query( array( 
					'post_type' => array('serie') ,
					'post_status' => "publish",
					'posts_per_page' => 24,
					'orderby' => 'publish_date',
    				'order' => 'DESC',
					'tag' => "ongoing",
					'paged' => 1,
				));
				$years_list = array();
				$cats_list = array();
				$episodes_list = array();
				$rates_list = array();
				if ($recentQuery->have_posts()) { 
					while ($recentQuery->have_posts()){
						$recentQuery->the_post();
						array_push($cats_list , get_the_terms($post->ID,'category' , ''));
					array_push($years_list , get_the_terms($post->ID,'year-cat' , ''));
					array_push($rates_list , get_the_terms($post->ID,'ratings-cat' , ''));
						$postQuery = new WP_Query( array(
							'post_type' => array('episode') ,
							'post_status' => "publish",
							'posts_per_page' => 1,
							'meta_key' => array('episode_numbar' , 'episode_season'),
							'orderby' => 'meta_value_num',
							'meta_query' => array(
								array(
									'key' => 'episode_serie',
									'value' => $post->ID,
									'compare' => '=='
								),
							),
						));

						if($postQuery->have_posts()){
							$postQuery->the_post();
							array_push($episodes_list , get_post($post->ID));
						}
					}
				}

			?>
			<?php 
				if(count($episodes_list) != 0){
					?>
						<h1 class="section-title"> آخر الحلقات</h1>
					<?php
					$total = count($episodes_list);
					$group = 1;
				}
			?>
			<?php $i=0; while ($i < count($episodes_list)) { $post = $episodes_list[$i];  
				if($i > 11){
					$group = 2;
				}
				$season = get_post_meta($post->ID,'episode_season',true);
				$serie = get_post_meta($post->ID,'episode_serie',true);
				$season_post = get_post( $season );
				$season_number = $season_post->post_title;
				$season_number = explode("-", $season_number)[1];
				$serie_post = get_post( $serie ); 

				$title = $serie_post->post_title;
				$thumb = wp_get_attachment_url(get_post_thumbnail_id($season_post->ID));
				
				
				$serie_title = $serie_post->post_title;
			

				$episode = get_post_meta($post->ID,'episode_numbar',true);
				
				$hide = "";
				if($group > 1){
					$hide = "style='display:none;'";
				}
				 ?>
				 
				<div class="single-poster flex-item visiblegroup-<?=$group?>" <?=$hide?> >

					
						<?php if (!empty($thumb)) { ?>
							<img class="poster-img" src="<?=$thumb?>" alt="<?=the_title() ?>">
						<?php } else { ?>
							<img class="poster-img" src="<?=get_template_directory_uri()?>/Interface/images/no-thumb.jpeg" alt="<?=the_title() ?>">
						<?php } ?>


					<div class="poster-wrapper">
						
						
						<div class="poster-tags showOnmobile">
							<span class="poster-tag"><?="الحلقة ".$episode ?></span> 
							<?php if (!empty($rates_list[$i])) { foreach (array_slice($rates_list[$i], 0,1 ) as $key ) {
							?>
							<span class="poster-rate showOnmobile"><?=$key->name?><img src="<?php bloginfo('template_url')?>/Interface/images/star.png" width="15" height="15" /></span>
							<?php } }?>
							
						</div>
						
						
						<div class="poster-play-button showOnmobile">
							<a href="<?php the_permalink() ?>" title="<?=the_title() ?>"><i class="fa fa-play"></i></a>
						</div>
						<div class="poster-title">
							<div class="poster-cats showOnmobile">
							<?php if (!empty($cats_list[$i])) { $j = 1; foreach ($arr = array_slice($cats_list[$i], 0,2 ) as $key ) { ?>
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
							<h3><?=$title;?></h3>
							<div class="poster-year-season">
								<?php if($season_number){ ?>
									<h6><?=$season_number?></h6>
								<?php } ?>
								<?php if($season_number && !empty($years_list[$i]) ){ ?>
									<h6>-</h6>
								<?php }?>
								
								<?php if (!empty($years_list[$i])) { foreach (array_slice($years_list[$i], 0,1 ) as $key ) { ?>
									<h6><?=$key->name?></h6>
								<?php }} ?>
							</div>
						</div>
					</div>
					
				</div>
			<?php $i++; } ; wp_reset_query() ?>
			
		</div>
		<?php if($total > 12){ ?>
		<div class="showmore">
			<button class="showmorebutton" for="recent-posts"><span class="more"> المزيد </span>  <i class="fa fa-plus" aria-hidden="true"></i></button>
		</div>
		<?php } ?>
		<?php if($total > 0) { ?>
			<hr>
		<?php } ?>
	</div>
		</section>