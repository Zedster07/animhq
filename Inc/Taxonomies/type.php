<?php 
    add_action( 'init', 'type', 0 );
    function type() {
        $labels = array(
            'name'                  => __( 'الانواع', 'Mekawadaity' ),
            'singular_name'         => __( 'النوع', 'Mekawadaity' ),
            'search_items'          => __( 'بحث فى الانواع'  , 'Mekawadaity'),
            'all_items'             => __( 'كل الانواع' , 'Mekawadaity'),
            'update_item'           => __( 'تحديث' , 'Mekawadaity' ),
            'edit_item'             => __( 'تعديل' , 'Mekawadaity' ), 
            'add_new_item'          => __( 'اضافه نوع' , 'Mekawadaity' ),
            'menu_name'             => __( 'الانواع' , 'Mekawadaity' ),
            'new_item_name'         => __( 'اسم النوع الجديد' , 'Mekawadaity' ),
            'not_found'             => __( 'لا يوجد انواع' , 'Mekawadaity' )
        ); 	
        register_taxonomy(
            'type-cat',
            array('movie','serie','season'),
            array (
                'public'                => true,
                'show_in_nav_menus'     => true,
                'labels'                => $labels,
                'hierarchical'          => true,
                'show_ui'               => true,
                'query_var'             => true,
                'rewrite'               => array(
                    'slug' => 'type',
                    'with_front' => true
                ),
            )
        );
    }
