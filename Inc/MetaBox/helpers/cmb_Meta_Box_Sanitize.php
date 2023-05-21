<?php

class cmb_Meta_Box_Sanitize {
	public $field;
	public $value;
	public function __construct( $field, $value ) {
		$this->field       = $field;
		$this->value       = $value;
		$this->object_id   = cmb_Meta_Box::get_object_id();
		$this->object_type = cmb_Meta_Box::get_object_type();
	}
	public function __call( $name, $arguments ) {
		list( $value ) = $arguments;
		return $this->default_sanitization( $value );
	}
	public function default_sanitization( $value ) {
		$updated = apply_filters( 'cmb_validate_'. $this->field->type(), null, $value, $this->object_id, $this->field->args(), $this );
		if ( null !== $updated )
			return $updated;
		switch ( $this->field->type() ) {
			case 'wysiwyg':
			case 'textarea_small':
				return $this->textarea( $value );
			case 'taxonomy_select':
			case 'taxonomy_radio':
			case 'taxonomy_multicheck':
				if ( $this->field->args( 'taxonomy' ) ) {
					return wp_set_object_terms( $this->object_id, $value, $this->field->args( 'taxonomy' ) );
				}
			case 'multicheck':
			case 'file_list':
			case 'oembed':
				return $value;
			default:
				return is_array( $value ) ? array_map( 'sanitize_text_field', $value ) : call_user_func( 'sanitize_text_field', $value );
		}
	}
	public function checkbox( $value ) {
		return $value === 'on' ? 'on' : false;
	}
	public function text_url( $value ) {
		$protocols = $this->field->args( 'protocols' );
		// for repeatable
		if ( is_array( $value ) ) {
			foreach ( $value as $key => $val ) {
				$value[ $key ] = $val ? esc_url_raw( $val, $protocols ) : $this->field->args( 'default' );
			}
		} else {
			$value = $value ? esc_url_raw( $value, $protocols ) : $this->field->args( 'default' );
		}
		return $value;
	}
	public function colorpicker( $value ) {
		if ( is_array( $value ) ) {
			$check = $value;
			$value = array();
			foreach ( $check as $key => $val ) {
				if ( $val && '#' != $val ) {
					$value[ $key ] = esc_attr( $val );
				}
			}
		} else {
			$value = ! $value || '#' == $value ? '' : esc_attr( $value );
		}
		return $value;
	}
	public function text_email( $value ) {
		// for repeatable
		if ( is_array( $value ) ) {
			foreach ( $value as $key => $val ) {
				$val = trim( $val );
				$value[ $key ] = is_email( $val ) ? $val : '';
			}
		} else {
			$value = trim( $value );
			$value = is_email( $value ) ? $value : '';
		}
		return $value;
	}
	public function text_money( $value ) {
		global $wp_locale;
		$search = array( $wp_locale->number_format['thousands_sep'], $wp_locale->number_format['decimal_point'] );
		$replace = array( '', '.' );
		if ( is_array( $value ) ) {
			foreach ( $value as $key => $val ) {
				$value[ $key ] = number_format_i18n( (float) str_ireplace( $search, $replace, $val ), 2 );
			}
		} else {
			$value = number_format_i18n( (float) str_ireplace( $search, $replace, $value ), 2 );
		}
		return $value;
	}
	public function text_date_timestamp( $value ) {
		return is_array( $value ) ? array_map( 'strtotime', $value ) : strtotime( $value );
	}
	public function text_datetime_timestamp( $value, $repeat = false ) {
		$test = is_array( $value ) ? array_filter( $value ) : '';
		if ( empty( $test ) )
			return '';
		if ( $repeat_value = $this->_check_repeat( $value, __FUNCTION__, $repeat ) )
			return $repeat_value;
		$value = strtotime( $value['date'] .' '. $value['time'] );
		if ( $tz_offset = $this->field->field_timezone_offset() )
			$value += $tz_offset;
		return $value;
	}
	public function text_datetime_timestamp_timezone( $value, $repeat = false ) {
		$test = is_array( $value ) ? array_filter( $value ) : '';
		if ( empty( $test ) )
			return '';
		if ( $repeat_value = $this->_check_repeat( $value, __FUNCTION__, $repeat ) )
			return $repeat_value;
		$tzstring = null;
		if ( is_array( $value ) && array_key_exists( 'timezone', $value ) )
			$tzstring = $value['timezone'];
		if ( empty( $tzstring ) )
			$tzstring = cmb_Meta_Box::timezone_string();
		$offset = cmb_Meta_Box::timezone_offset( $tzstring, true );
		if ( substr( $tzstring, 0, 3 ) === 'UTC' )
			$tzstring = timezone_name_from_abbr( '', $offset, 0 );
		$value = new DateTime( $value['date'] .' '. $value['time'], new DateTimeZone( $tzstring ) );
		$value = serialize( $value );
		return $value;
	}
	public function textarea( $value ) {
		return is_array( $value ) ? array_map( 'wp_kses_post', $value ) : wp_kses_post( $value );
	}
	public function textarea_code( $value, $repeat = false ) {
		if ( $repeat_value = $this->_check_repeat( $value, __FUNCTION__, $repeat ) )
			return $repeat_value;
		return htmlspecialchars_decode( stripslashes( $value ) );
	}
	public function _save_file_id( $value ) {
		$group      = $this->field->group;
		$args       = $this->field->args();
		$args['id'] = $args['_id'] . '_id';
		unset( $args['_id'], $args['_name'] );
		$field      = new cmb_Meta_Box_field( $args, $group );
		$id_key     = $field->_id();
		$id_val_old = $field->escaped_value( 'absint' );
		if ( $group ) {
			$i       = $group->index;
			$base_id = $group->_id();
			$id_val  = isset( $_POST[ $base_id ][ $i ][ $id_key ] ) ? absint( $_POST[ $base_id ][ $i ][ $id_key ] ) : 0;
		} else {
			$id_val = isset( $_POST[ $field->id() ] ) ? $_POST[ $field->id() ] : null;
		}
		if ( $value && ! $id_val ) {
			$id_val = cmb_Meta_Box::image_id_from_url( $value );
		}
		if ( $group ) {
			return array(
				'attach_id' => $id_val,
				'field_id'  => $id_key
			);
		}
		if ( $id_val && $id_val != $id_val_old ) {
			return $field->update_data( $id_val );
		} elseif ( empty( $id_val ) && $id_val_old ) {
			return $field->remove_data( $old );
		}
	}
	public function file( $value ) {
		if ( $this->field->args( 'save_id' ) ) {
			$id_value = $this->_save_file_id( $value );
		}
		$clean = $this->text_url( $value );
		return $this->field->group ? array_merge( array( 'url' => $clean), $id_value ) : $clean;
	}
	public function _check_repeat( $value, $method, $repeat ) {
		if ( $repeat || ! $this->field->args( 'repeatable' ) )
			return;
		$new_value = array();
		foreach ( $value as $iterator => $val ) {
			$new_value[] = $this->$method( $val, true );
		}
		return $new_value;
	}
}
