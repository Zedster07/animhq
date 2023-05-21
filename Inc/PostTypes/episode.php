<?php 
	add_action( 'init', 'episode' );
	function episode() {
		$labels = array(
			'name' 					=> __( 'الحلقات' , 'Mekawadaity' ),
			'singular_name' 		=> __( 'الحلقات' , 'Mekawadaity' ),
			'add_new' 				=> __( 'اضافة حلقه ' , 'Mekawadaity' ),
			'add_new_item' 			=> __( 'اضافة حلقه جديد' , 'Mekawadaity' ),
			'edit' 					=> __( 'تعديل' , 'Mekawadaity' ),
			'edit_item' 			=> __( 'تعديل' , 'Mekawadaity' ),
			'new_item' 				=> __( 'حلقه جديد'  , 'Mekawadaity'),
			'search_items' 			=> __( 'بحث فى الحلقات' , 'Mekawadaity' ),
			'not_found' 			=> __( 'لا يوجد حلقات'  , 'Mekawadaity'),
			'not_found_in_trash' 	=> __( 'لا يوجد حلقات فى سلة المهملات' , 'Mekawadaity' ),
			'parent' 				=> __( 'الحلقات' , 'Mekawadaity' )
		);
		register_post_type( 'episode',
			array(
				'labels' 				=> $labels,
				'public' 				=> true,
				'show_ui' 				=> true,
				'publicly_queryable' 	=> true,
				'show_in_nav_menus' 	=> false,
				'show_in_menu' 			=> 'edit.php?post_type=serie',
				'taxonomies' 			=> array('post_tag'),
				'hierarchical' 			=> false,
	            'rewrite' 				=> array( 'slug'=>'episode' ),
				'supports' 				=> array( 'title', 'thumbnail' , 'editor' ),
			)
		);
	}