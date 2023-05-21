<?php
	class cmb_Meta_Box_ajax {
		public static $instance    = null;
		public static $hijack      = false;
		public static $object_id   = 0;
		public static $embed_args  = array();
		public static $object_type = 'post';
		public static function get() {
			if ( self::$instance === null )
				self::$instance = new self();
			return self::$instance;
		}
		public function oembed_handler() {
			if ( ! ( isset( $_REQUEST['cmb_ajax_nonce'], $_REQUEST['oembed_url'] ) && wp_verify_nonce( $_REQUEST['cmb_ajax_nonce'], 'ajax_nonce' ) ) )
				die();
			$oembed_string = sanitize_text_field( $_REQUEST['oembed_url'] );
			if ( empty( $oembed_string ) )
				self::send_result( '<p class="ui-state-error-text">'. __( 'Please Try Again', 'cmb' ) .'</p>', false );
			$embed_width = isset( $_REQUEST['oembed_width'] ) && intval( $_REQUEST['oembed_width'] ) < 640 ? intval( $_REQUEST['oembed_width'] ) : '640';
			$oembed_url = esc_url( $oembed_string );
			$embed_args = array( 'width' => $embed_width );
			$html = self::get_oembed( $oembed_url, $_REQUEST['object_id'], array(
				'object_type' => isset( $_REQUEST['object_type'] ) ? $_REQUEST['object_type'] : 'post',
				'oembed_args' => $embed_args,
				'field_id' => $_REQUEST['field_id'],
			) );
			self::send_result( $html );
		}
		public static function get_oembed( $url, $object_id, $args = array() ) {
			global $wp_embed;
			$oembed_url = esc_url( $url );
			self::$object_id = is_numeric( $object_id ) ? absint( $object_id ) : sanitize_text_field( $object_id );
			$args = wp_parse_args( $args, array(
				'object_type' => 'post',
				'oembed_args' => self::$embed_args,
				'field_id'    => false,
				'cache_key'   => false,
			));

			self::$embed_args =& $args;
			$wp_embed->post_ID = self::$object_id;
			if ( isset( $args['object_type'] ) && $args['object_type'] != 'post' ) {
				if ( 'options-page' == $args['object_type'] ) {
					$wp_embed->post_ID = 1987645321;
					$args['cache_key'] = $args['field_id'] .'_cache';
				}
				self::$hijack = true;
				self::$object_type = $args['object_type'];
				add_filter( 'get_post_metadata', array( 'cmb_Meta_Box_ajax', 'hijack_oembed_cache_get' ), 10, 3 );
				add_filter( 'update_post_metadata', array( 'cmb_Meta_Box_ajax', 'hijack_oembed_cache_set' ), 10, 4 );
			}
			$embed_args = '';
			foreach ( $args['oembed_args'] as $key => $val ) {
				$embed_args .= " $key=\"$val\"";
			}
			$check_embed = $wp_embed->run_shortcode( '[embed'. $embed_args .']'. $oembed_url .'[/embed]' );
			$fallback = $wp_embed->maybe_make_link( $oembed_url );
			if ( $check_embed && $check_embed != $fallback )
				return '<div class="embed_status">'. $check_embed .'<p class="cmb_remove_wrapper"><a href="#" class="cmb_remove_file_button" rel="'. $args['field_id'] .'">'. __( 'Remove Embed', 'cmb' ) .'</a></p></div>';
			return '<p class="ui-state-error-text">'. sprintf( __( 'No oEmbed Results Found for %s. View more info at', 'cmb' ), $fallback ) .' <a href="http://codex.wordpress.org/Embeds" target="_blank">codex.wordpress.org/Embeds</a>.</p>';
		}
		public static function hijack_oembed_cache_get( $check, $object_id, $meta_key ) {
			if ( ! self::$hijack || ( self::$object_id != $object_id && 1987645321 !== $object_id ) )
				return $check;
			$data = 'options-page' === self::$object_type
				? cmb_Meta_Box::get_option( self::$object_id, self::$embed_args['cache_key'] )
				: get_metadata( self::$object_type, self::$object_id, $meta_key, true );
			return $data;
		}
		public static function hijack_oembed_cache_set( $check, $object_id, $meta_key, $meta_value ) {
			if ( ! self::$hijack || ( self::$object_id != $object_id && 1987645321 !== $object_id ) )
				return $check;
			if ( 'options-page' === self::$object_type ) {
				cmb_Meta_Box::update_option( self::$object_id, self::$embed_args['cache_key'], $meta_value, array( 'type' => 'oembed' ) );
				cmb_Meta_Box::save_option( self::$object_id );
			} else {
				update_metadata( self::$object_type, self::$object_id, $meta_key, $meta_value );
			}
			return true;
		}
		public static function send_result( $data, $success = true ) {
			$found = $success ? 'found' : 'not found';
			echo json_encode( array( 'result' => $data, 'id' => $found ) );
			die();
		}
	}