<?php 
	if ( $_SERVER['HTTP_X_REQUESTED_WITH'] == "XMLHttpRequest" ) { 
		define('WP_USE_THEMES', false);
		$URI = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
		require_once( $URI[0] . 'wp-load.php' );
		$post = $_POST['postID'];
		$post = get_post($post)
		?>
		<div class="download-servers">
			<div class="container">
				<h2 class="TitleAreaTwo">
			        <i class="fa fa-download"></i>
			        <span>سيرفرات تحميل <?=get_the_title($post->ID)?></span>
			    </h2>
			    <ul>
			    	<?php $download_servers = get_post_meta($post->ID,'download_servers',true) ?>
					<?php foreach ($download_servers as $server) { ?>
						<li>
							<a href="<?=$server['server_url']?>" onclick="downloadCount(<?=$post->ID?>);$(this).removeAttr('onclick')" target="_blank">
								<i class="fa fa-cloud-download"></i>
								<span><?=$server['server_name']?></span>
							</a>
						</li>
					<?php } ?>
					<div class="clr"></div>
					<script type="text/javascript">
	                    function downloadCount(postID) {
	                        $.ajax({
	                            url: '<?=get_template_directory_uri()?>/Ajax/Counters/download.php',
	                            data: 'postID='+postID+'',
	                            type: 'POST',
	                            success: function() {},
	                            error: function() {}
	                        });
	                    }
	                </script>
			    </ul>
			</div>
		</div>
		<?php
	}
?>