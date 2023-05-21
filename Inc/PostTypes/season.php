<?php 
	add_action( 'init', 'season' );
	function season() {
		$labels = array(
			'name' 					=> __( 'المواسم' , 'Mekawadaity' ),
			'singular_name' 		=> __( 'المواسم' , 'Mekawadaity' ),
			'add_new' 				=> __( 'اضافة موسم ' , 'Mekawadaity' ),
			'add_new_item' 			=> __( 'اضافة موسم جديد' , 'Mekawadaity' ),
			'edit' 					=> __( 'تعديل' , 'Mekawadaity' ),
			'edit_item' 			=> __( 'تعديل' , 'Mekawadaity' ),
			'new_item' 				=> __( 'موسم جديد'  , 'Mekawadaity'),
			'search_items' 			=> __( 'بحث فى المواسم' , 'Mekawadaity' ),
			'not_found' 			=> __( 'لا يوجد مواسم'  , 'Mekawadaity'),
			'not_found_in_trash' 	=> __( 'لا يوجد مواسم فى سلة المهملات' , 'Mekawadaity' ),
			'parent' 				=> __( 'المواسم' , 'Mekawadaity' )
		);
		register_post_type( 'season',
			array(
				'labels' 				=> $labels,
				'public' 				=> true,
				'show_ui' 				=> true,
				'publicly_queryable' 	=> true,
				'show_in_nav_menus' 	=> false,
				'show_in_menu' 			=> 'edit.php?post_type=serie',
				'menu_position'			=> 5,
				'hierarchical' 			=> false,
				'taxonomies' 			=> array('post_tag'),
	            'rewrite' 				=> array( 'slug'=>'season' ),
				'supports' 				=> array( 'title', 'thumbnail' , 'editor' ),
			)
		);
	}