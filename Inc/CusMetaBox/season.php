<?php
function custom_season_meta() {
	add_meta_box( 'prfx_meta', __( 'تفاصيل الموسم', 'MK' ), 'season_meta_callback', 'season' );
}
add_action( 'add_meta_boxes', 'custom_season_meta' );
function season_meta_callback( $post ) {
	wp_nonce_field( basename( __FILE__ ), 'prfx_nonce' );
	$prfx_stored_meta = get_post_meta( $post->ID );
	?>
	<p class="MBP">
		<label for="meta-select" class="prfx-row-title"><?php _e( 'مسلسل الموسم', 'MK' )?></label>
		<select name="select-serie" id="meta-select">
			<option value="">مسلسل الموسم</option>
			<?php query_posts(array('post_type' => 'serie' ,'posts_per_page' => -1)) ?>
			<?php if (have_posts()) { while (have_posts()) { the_post() ?>
				<option <?php if (get_post_meta($post->ID,'season_serie',false)[0] == get_the_ID()) { ?> selected <?php } ?> value="<?=get_the_ID()?>"><?php the_title() ?></option>
			<?php } ; } ;wp_reset_query() ?>
		</select>
	</p>
	<?php
}
function season_meta_save( $post_id ) {
	$is_autosave = wp_is_post_autosave( $post_id );
	$is_revision = wp_is_post_revision( $post_id );
	$is_valid_nonce = ( isset( $_POST[ 'prfx_nonce' ] ) && wp_verify_nonce( $_POST[ 'prfx_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
	if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
		return;
	}
	$select_serie = $_POST['select-serie'];
	if (isset($select_serie)) {
		update_post_meta( $post_id, 'season_serie',$select_serie);
		$seasons_list = get_post_meta($select_serie,'seasons_list',true);
		$seasons_list = (is_array($seasons_list)) ? $seasons_list : array();
		$seasons_list[] = $post_id;
		update_post_meta($select_serie,'seasons_list',$seasons_list);
	}
}
add_action( 'save_post', 'season_meta_save' );