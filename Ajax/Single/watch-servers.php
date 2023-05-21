<?php 
	if ( $_SERVER['HTTP_X_REQUESTED_WITH'] == "XMLHttpRequest" ) { 
		define('WP_USE_THEMES', false);
		$URI = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
		require_once( $URI[0] . 'wp-load.php' );
		$post = $_POST['postID'];
		$post = get_post($post)
		?>
		<div class="container">
			<div class="ServersRight">
				<h1>
					<i class="fa fa-server"></i>
					<span>سيرفرات المشاهده</span>
					<div class="clr"></div>	
				</h1>
				<ul>
					<?php $watchServers = get_post_meta($post->ID,'servers',true) ?>
					<?php foreach ($watchServers as $server) { ?>
						<li data-watch="<?=$server['server_url']?>">
							<i class="fa fa-play"></i>
							<span><?php echo $server['server_name'] ?></span>
						</li>
					<?php } ?>
				</ul>
			</div>
			<div class="watch-Area">
				<iframe src=""></iframe>
			</div>
			<div class="clr"></div>
		</div>
		<script type="text/javascript">
			$(document).ready(function(){
				$('.ServersRight ul li:first').addClass('active');
				$('.watch-Area iframe').attr('src',$('.ServersRight ul li:first').data('watch'));
				$('.ServersRight ul li').click(function(){
					$(this).addClass('active').siblings().removeClass('active');
					$('.watch-Area iframe').attr('src',$(this).data('watch'));
				})
			})
		</script>
		<?php
	}
?>