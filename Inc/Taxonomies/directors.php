<?php 
    add_action( 'init', 'director', 0 );
    function director() {
        $labels = array(
            'name'                  => __( 'المخرجين', 'Mekawadaity' ),
            'singular_name'         => __( 'مخرج', 'Mekawadaity' ),
            'search_items'          => __( 'بحث فى المخرجين'  , 'Mekawadaity'),
            'all_items'             => __( 'كل الشركات' , 'Mekawadaity'),
            'update_item'           => __( 'تحديث' , 'Mekawadaity' ),
            'edit_item'             => __( 'تعديل' , 'Mekawadaity' ), 
            'add_new_item'          => __( 'اضافه المخرج' , 'Mekawadaity' ),
            'menu_name'             => __( 'المخرجين' , 'Mekawadaity' ),
            'new_item_name'         => __( 'اسم المخرج الجديده' , 'Mekawadaity' ),
            'not_found'             => __( 'لا يوجد مخرجين' , 'Mekawadaity' )
        ); 	
        register_taxonomy(
            'director-cat',
            array('movie','serie','season'),
            array (
                'public'                => true,
                'show_in_nav_menus'     => true,
                'hierarchical'          => false,
                'labels'                => $labels,
                'show_ui'               => true,
                'query_var'             => true,
                'rewrite'               => array ( 
                    'slug' => 'director',
                    'with_front' => true
                ),
            )
        );
    }
