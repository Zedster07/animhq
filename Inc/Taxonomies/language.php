<?php 
    add_action( 'init', 'language', 0 );
    function language() {
        $labels = array(
            'name'                  => __( 'اللغات', 'Mekawadaity' ),
            'singular_name'         => __( 'اللغه', 'Mekawadaity' ),
            'search_items'          => __( 'بحث فى شركات الانتاج'  , 'Mekawadaity'),
            'all_items'             => __( 'كل اللغات' , 'Mekawadaity'),
            'update_item'           => __( 'تحديث' , 'Mekawadaity' ),
            'edit_item'             => __( 'تعديل' , 'Mekawadaity' ), 
            'add_new_item'          => __( 'اضافه اللغه' , 'Mekawadaity' ),
            'menu_name'             => __( 'اللغات' , 'Mekawadaity' ),
            'new_item_name'         => __( 'اسم الاللغه الجديده' , 'Mekawadaity' ),
            'not_found'             => __( 'لا يوجد لغات' , 'Mekawadaity' )
        ); 	
        register_taxonomy(
            'language-cat',
            array('movie','serie','season'),
            array (
                'public'                => true,
                'show_in_nav_menus'     => true,
                'hierarchical'          => true,
                'labels'                => $labels,
                'show_ui'               => true,
                'query_var'             => true,
                'rewrite'               => array(
                    'slug' => 'language',
                    'with_front' => true
                ),
            )
        );
    }
