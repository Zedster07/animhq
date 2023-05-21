<?php 
    add_action( 'init', 'ratings', 0 );
    function ratings() {
        $labels = array(
            'name'                  => __( 'التقييمات', 'Mekawadaity' ),
            'singular_name'         => __( 'التقييم', 'Mekawadaity' ),
            'search_items'          => __( 'بحث في التقييمات'  , 'Mekawadaity'),
            'all_items'             => __( 'كل التقييمات' , 'Mekawadaity'),
            'update_item'           => __( 'تحديث' , 'Mekawadaity' ),
            'edit_item'             => __( 'تعديل' , 'Mekawadaity' ), 
            'add_new_item'          => __( 'اضافه التقييم' , 'Mekawadaity' ),
            'menu_name'             => __( 'التقييمات' , 'Mekawadaity' ),
            'new_item_name'         => __( 'اسم التقييم الجديده' , 'Mekawadaity' ),
            'not_found'             => __( 'لا يوجد تقييمات' , 'Mekawadaity' )
        ); 	
        register_taxonomy(
            'ratings-cat',
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
                    'slug' => 'ratings',
                    'with_front' => true
                ),
            )
        );
    }
