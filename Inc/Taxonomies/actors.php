<?php 
    add_action( 'init', 'actor', 0 );
    function actor() {
        $labels = array(
            'name'                  => __( 'الممثلين', 'Mekawadaity' ),
            'singular_name'         => __( 'ممثل', 'Mekawadaity' ),
            'search_items'          => __( 'بحث فى الممثلين'  , 'Mekawadaity'),
            'all_items'             => __( 'كل الشركات' , 'Mekawadaity'),
            'update_item'           => __( 'تحديث' , 'Mekawadaity' ),
            'edit_item'             => __( 'تعديل' , 'Mekawadaity' ), 
            'add_new_item'          => __( 'اضافه الممثل' , 'Mekawadaity' ),
            'menu_name'             => __( 'الممثلين' , 'Mekawadaity' ),
            'new_item_name'         => __( 'اسم الممثل الجديده' , 'Mekawadaity' ),
            'not_found'             => __( 'لا يوجد ممثلين' , 'Mekawadaity' )
        ); 	
        register_taxonomy(
            'actor-cat',
            array('movie','serie','season'),
            array (
                'public'                => true,
                'show_in_nav_menus'     => true,
                'hierarchical'          => false,
                'labels'                => $labels,
                'show_ui'               => true,
                'query_var'             => true,
                'rewrite'               => array ( 
                    'slug' => 'actor',
                    'with_front' => true
                ),
            )
        );
    }
