<?php 
    add_action( 'init', 'production', 0 );
    function production() {
        $labels = array(
            'name'                  => __( 'المنتجين', 'Mekawadaity' ),
            'singular_name'         => __( 'منتج', 'Mekawadaity' ),
            'search_items'          => __( 'بحث فى المنتجين'  , 'Mekawadaity'),
            'all_items'             => __( 'كل الشركات' , 'Mekawadaity'),
            'update_item'           => __( 'تحديث' , 'Mekawadaity' ),
            'edit_item'             => __( 'تعديل' , 'Mekawadaity' ), 
            'add_new_item'          => __( 'اضافه المنتج' , 'Mekawadaity' ),
            'menu_name'             => __( 'المنتجين' , 'Mekawadaity' ),
            'new_item_name'         => __( 'اسم المنتج الجديده' , 'Mekawadaity' ),
            'not_found'             => __( 'لا يوجد منتجين' , 'Mekawadaity' )
        ); 	
        register_taxonomy(
            'production-cat',
            array('movie','serie','season'),
            array (
                'public'                => true,
                'show_in_nav_menus'     => true,
                'hierarchical'          => false,
                'labels'                => $labels,
                'show_ui'               => true,
                'query_var'             => true,
                'rewrite'               => array ( 
                    'slug' => 'production',
                    'with_front' => true
                ),
            )
        );
    }
