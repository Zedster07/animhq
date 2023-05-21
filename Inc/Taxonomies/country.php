<?php 
    add_action( 'init', 'country', 0 );
    function country() {
        $labels = array(
            'name'                  => __( 'الدول', 'Mekawadaity' ),
            'singular_name'         => __( 'الدوله', 'Mekawadaity' ),
            'search_items'          => __( 'بحث فى الدول'  , 'Mekawadaity'),
            'all_items'             => __( 'كل الدول' , 'Mekawadaity'),
            'update_item'           => __( 'تحديث' , 'Mekawadaity' ),
            'edit_item'             => __( 'تعديل' , 'Mekawadaity' ), 
            'add_new_item'          => __( 'اضافه الدوله' , 'Mekawadaity' ),
            'menu_name'             => __( 'الدول' , 'Mekawadaity' ),
            'new_item_name'         => __( 'اسم الدوله الجديده' , 'Mekawadaity' ),
            'not_found'             => __( 'لا يوجد دول' , 'Mekawadaity' )
        ); 	
        register_taxonomy(
            'country-cat',
            array('movie','serie','season'),
            array (
                'public'                => true,
                'show_in_nav_menus'     => true,
                'hierarchical'          => true,
                'labels'                => $labels,
                'show_admin_column'     => true,
                'show_ui'               => true,
                'query_var'             => true,
                'rewrite'               => array(
                    'slug' => 'country',
                    'with_front' => true
                ),
            )
        );
    }
