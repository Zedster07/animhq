<?php
	function register_serie() {
		$labels = array( 
			'name' 					=> __( 'المسلسلات', 'MokawdaTy' ), 
			'singular_name' 		=> __( 'مسلسل', 'MokawdaTy' ), 
			'add_new' 				=> __( 'اضافه مسلسل جديد ', 'MokawdaTy' ), 
			'add_new_item'			=> __( 'اضافه مسلسل جديد', 'MokawdaTy' ), 
			'edit' 					=> __( 'تعديل مسلسل', 'MokawdaTy' ), 
			'edit_item' 			=> __( 'تعديل مسلسل', 'MokawdaTy' ), 
			'new_item' 				=> __( 'مسلسل جديد', 'MokawdaTy' ), 
			'search_items' 			=> __( 'بحث فى المسلسلات', 'MokawdaTy' ), 
			'not_found' 			=> __( 'لا يوجد مسلسلات', 'MokawdaTy' ), 
			'not_found_in_trash' 	=> __( 'لا يوجد مسلسلات', 'MokawdaTy' ), 
			'parent' 				=> __( 'الافلام', 'MokawdaTy' )
		);
		register_post_type( 'serie', array( 
			'labels' 	 				=> $labels,
			'public' 					=> true, 
			'show_ui' 					=> true,
			'publicly_queryable'		=> true, 
			'show_in_nav_menus' 		=> true, 
			'menu_position' 			=> 5,
			'rewrite' 					=> array( 'slug' => 'serie' ), 
			'supports' 					=> array( 'title', 'thumbnail', 'editor','comments' ),
			'has_archive'         		=> false,
            'taxonomies'                => array ( 'category' , 'production','post_tag' ),
		));
	}
	add_action( 'init', 'register_serie' );
	/*
	** End Register Album Post Type
	*/