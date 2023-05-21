<?php 
    add_action( 'init', 'year', 0 );
    function year() {
        $labels = array(
            'name'                  => __( 'سنة الاصدار', 'Mekawadaity' ),
            'singular_name'         => __( 'سنة الاصدار', 'Mekawadaity' ),
            'search_items'          => __( 'بحث فى سنة الاصدار'  , 'Mekawadaity'),
            'all_items'             => __( 'كل السنوات' , 'Mekawadaity'),
            'update_item'           => __( 'تحديث' , 'Mekawadaity' ),
            'edit_item'             => __( 'تعديل' , 'Mekawadaity' ), 
            'add_new_item'          => __( 'اضافه السنه' , 'Mekawadaity' ),
            'menu_name'             => __( 'السنوات' , 'Mekawadaity' ),
            'new_item_name'         => __( 'اسم سنة الاصدار الجديد' , 'Mekawadaity' ),
            'not_found'             => __( 'لا يوجد سنوات اصدار' , 'Mekawadaity' )
        ); 	
        register_taxonomy(
            'year-cat',
            array('movie','serie','season','selary'),
            array (
                'public'                => true,
                'show_in_nav_menus'     => true,
                'hierarchical'          => true,
                'labels'                => $labels,
                'show_ui'               => true,
                'query_var'             => true,
                'show_admin_column'     => true,
                'rewrite'               => array( 
                    'slug' => 'year',
                    'with_front' => true
                ),
            )
        );
    }
