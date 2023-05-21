<?php 
    add_action( 'init', 'quality', 0 );
    function quality() {
        $labels = array(
            'name'                  => __( 'الجودات', 'Mekawadaity' ),
            'singular_name'         => __( 'الجوده', 'Mekawadaity' ),
            'search_items'          => __( 'بحث فى الجودات'  , 'Mekawadaity'),
            'all_items'             => __( 'كل الجودات' , 'Mekawadaity'),
            'update_item'           => __( 'تحديث' , 'Mekawadaity' ),
            'edit_item'             => __( 'تعديل' , 'Mekawadaity' ), 
            'add_new_item'          => __( 'اضافه الجوده' , 'Mekawadaity' ),
            'menu_name'             => __( 'الجودات' , 'Mekawadaity' ),
            'new_item_name'         => __( 'اسم الجوده الجديده' , 'Mekawadaity' ),
            'not_found'             => __( 'لا يوجد جودات' , 'Mekawadaity' )
        ); 	
        register_taxonomy(
            'quality-cat',
            array('movie','serie','season','episode'),
            array (
                'public'                => true,
                'show_in_nav_menus'     => true,
                'hierarchical'          => true,
                'labels'                => $labels,
                'show_admin_column'     => true,
                'show_ui'               => true,
                'query_var'             => true,
                'rewrite'               => array(
                    'slug' => 'quality',
                    'with_front' => true
                ),
            )
        );
    }
