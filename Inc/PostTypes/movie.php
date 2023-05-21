<?php 
	add_action( 'init', 'movie' );
	function movie() {
		$labels = array(
			'name' 					=> __( 'الافلام' , 'Mekawadaity' ),
			'singular_name' 		=> __( 'الافلام' , 'Mekawadaity' ),
			'add_new' 				=> __( 'اضافة فيلم ' , 'Mekawadaity' ),
			'add_new_item' 			=> __( 'اضافة فيلم جديد' , 'Mekawadaity' ),
			'edit' 					=> __( 'تعديل' , 'Mekawadaity' ),
			'edit_item' 			=> __( 'تعديل' , 'Mekawadaity' ),
			'new_item' 				=> __( 'فيلم جديد'  , 'Mekawadaity'),
			'search_items' 			=> __( 'بحث فى الافلام' , 'Mekawadaity' ),
			'not_found' 			=> __( 'لا يوجد افلام'  , 'Mekawadaity'),
			'not_found_in_trash' 	=> __( 'لا يوجد افلام فى سلة المهملات' , 'Mekawadaity' ),
			'parent' 				=> __( 'الافلام' , 'Mekawadaity' )
		);
		register_post_type( 'movie',
			array(
				'labels' 				=> $labels,
				'public' 				=> true,
				'show_ui' 				=> true,
				'publicly_queryable' 	=> true,
				'show_in_nav_menus' 	=> false,
				'menu_position'			=> 5,
				'hierarchical' 			=> false,
				'taxonomies' 			=> array('category','post_tag'),
	            'rewrite' 				=> array( 'slug'=>'movie' ),
				'supports' 				=> array( 'title', 'thumbnail' , 'editor' ),
			)
		);
	}