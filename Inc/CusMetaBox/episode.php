<?php

function custom_episode_meta() {
	add_meta_box( 'prfx_meta', __( 'تفاصيل الحلقه', 'MK' ), 'episode_meta_callback', 'episode' );
}

add_action( 'add_meta_boxes', 'custom_episode_meta' );

function episode_meta_callback( $post ) {
	wp_nonce_field( basename( __FILE__ ), 'prfx_nonce' );
	$prfx_stored_meta = get_post_meta( $post->ID );
	?>
	<p class="MBP">
		<label for="meta-select" class="prfx-row-title"><?php _e( 'مسلسل الحلقه', 'MK' )?></label>
		<select name="select-serie" id="meta-select">
			<option value="">المسلسل</option>
			<?php query_posts(array('post_type' => 'serie' ,'posts_per_page' => -1)) ?>
			<?php if (have_posts()) { while (have_posts()) { the_post() ?>
				<option <?php if (get_post_meta($post->ID,'episode_serie',false)[0] == get_the_ID()) { ?> selected <?php } ?> value="<?=get_the_ID()?>"><?php the_title() ?></option>
			<?php } ; } ;wp_reset_query() ?>
		</select>
	</p>
	<p class="MBP">
		<label for="meta-select" class="prfx-row-title"><?php _e( 'موسم الحلقه', 'MK' )?></label>
		<select name="select-season" id="meta-select">
			<option value="">الموسم</option>
			<?php query_posts(array('post_type' => 'season' ,'posts_per_page' => -1)) ?>
			<?php if (have_posts()) { while (have_posts()) { the_post() ?>
				<option <?php if (get_post_meta($post->ID,'episode_season',false)[0] == get_the_ID()) { ?> selected <?php } ?> value="<?=get_the_ID()?>"><?php the_title() ?></option>
			<?php } ; } ;wp_reset_query() ?>
		</select>
	</p>
	<?php
}

function episode_meta_save( $post_id ) {
	$is_autosave = wp_is_post_autosave( $post_id );
	$is_revision = wp_is_post_revision( $post_id );
	$is_valid_nonce = ( isset( $_POST[ 'prfx_nonce' ] ) && wp_verify_nonce( $_POST[ 'prfx_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
	if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
		return;
	}
	if ( isset( $_POST[ 'select-serie' ] ) ) {
		update_post_meta( $post_id, 'episode_serie', $_POST[ 'select-serie' ] );
		$episodeList = get_post_meta($_POST['select-serie'],'episodes_list',true);
		$episodeList = (is_array($episodeList)) ? $episodeList : array();
		$episodeList[] = $post_id;
		update_post_meta($_POST['select-serie'],'episodes_list',$episodeList);
	}
	if ( isset( $_POST[ 'select-season' ] ) ) {
		update_post_meta( $post_id, 'episode_season', $_POST[ 'select-season' ] );
		$season_episodes = get_post_meta($_POST['select-season'],'season_episodes',true);
		$season_episodes = (is_array($season_episodes)) ? $season_episodes : array();
		$season_episodes[] = $post_id;
		update_post_meta($_POST['select-season'],'episodes_list',$season_episodes);
		$episodeList = get_post_meta($_POST['select-serie'],'episodes_list',true);
		$episodeList = (is_array($episodeList)) ? $episodeList : array();
		$episodeList[] = $post_id;
		update_post_meta($_POST['select-serie'],'episodes_list',$episodeList);
	}
}

add_action( 'save_post', 'episode_meta_save' );