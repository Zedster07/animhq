<?php 
    add_action( 'init', 'writer', 0 );
    function writer() {
        $labels = array(
            'name'                  => __( 'المؤلفين', 'Mekawadaity' ),
            'singular_name'         => __( 'مؤلف', 'Mekawadaity' ),
            'search_items'          => __( 'بحث فى المؤلفين'  , 'Mekawadaity'),
            'all_items'             => __( 'كل الشركات' , 'Mekawadaity'),
            'update_item'           => __( 'تحديث' , 'Mekawadaity' ),
            'edit_item'             => __( 'تعديل' , 'Mekawadaity' ), 
            'add_new_item'          => __( 'اضافه المؤلف' , 'Mekawadaity' ),
            'menu_name'             => __( 'المؤلفين' , 'Mekawadaity' ),
            'new_item_name'         => __( 'اسم المؤلف الجديده' , 'Mekawadaity' ),
            'not_found'             => __( 'لا يوجد مؤلفين' , 'Mekawadaity' )
        ); 	
        register_taxonomy(
            'writer-cat',
            array('movie','serie','season'),
            array (
                'public'                => true,
                'show_in_nav_menus'     => true,
                'hierarchical'          => false,
                'labels'                => $labels,
                'show_ui'               => true,
                'query_var'             => true,
                'rewrite'               => array ( 
                    'slug' => 'writer',
                    'with_front' => true
                ),
            )
        );
    }
