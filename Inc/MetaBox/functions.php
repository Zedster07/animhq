<?php
    add_filter( 'cmb_meta_boxes', 'MekawadaityMetaBox' );
    function MekawadaityMetaBox( array $meta_boxes ) {
        $prefix = 'MK_';
        $meta_boxes['option_gen'] = array(
            'id'         => 'option_gen',
            'title'      => __( 'اعدادات العرض', 'cmb' ),
            'pages'      => array( 'movie' , 'episode' ),
            'fields'     => array(
                array(
                    'name' => 'مدة العرض',
                    'id'   => 'post_time',
                    'type' => 'text',
                ),
                array(
                    'name' => 'رقم الحلقه',
                    'id'   => 'episode_numbar',
                    'type' => 'text',
                ),
                array(
                    'name'  => 'موضوع مثبت',
                    'id'    => 'pin',
                    'type'  => 'checkbox'
                ),
                array(
                    'name' => 'خلفية الموشوع',
                    'id'   => 'cover',
                    'type' => 'file',
                ),
                array(
                    'name' => 'الرابط imdb',
                    'id'   => 'imdb_link',
                    'type' => 'text_url',
                ),
                array(
                    'name' => 'رابط التحميل المباشر',
                    'id'   => 'direct_link',
                    'type' => 'text_url',
                ),
            ),
        );
        $meta_boxes['watch_servers'] = array(
            'id'         => 'watch_servers',
            'title'      => __( 'سيرفرات المشاهده', 'MK' ),
            'pages'      => array( 'post', 'episode' , 'movie' ),
            'fields'     => array(
                array(
                    'id'          => 'servers',
                    'type'        => 'group',
                    'options'     => array(
                        'group_title'   => __( 'تفصيل {#}', 'MK' ),
                        'add_button'    => __( 'اضافة تفصيل جديدة', 'MK' ),
                        'remove_button' => __( 'حذف التفصيل', 'MK' ),
                        'sortable'      => true,
                    ),
                    'fields'      => array(
                        array(
                            'name' => 'اسم السيرفر',
                            'id'   => 'server_name',
                            'type' => 'text',
                        ),
                        array(
                            'name' => 'رابط السيرفر',
                            'id'   => 'server_url',
                            'type' => 'text_url',
                        ),
                    ),
                ),
            ),
        );
        $meta_boxes['download_links'] = array(
            'id'         => 'download_links',
            'title'      => __( 'سيرفرات التحميل', 'MK' ),
            'pages'      => array( 'post', 'program' , 'game' , 'movie' , 'episode' ),
            'fields'     => array(
                array(
                    'id'          => 'download_servers',
                    'type'        => 'group',
                    'options'     => array(
                        'group_title'   => __( 'سيرفر 1 {#}', 'MK' ),
                        'add_button'    => __( 'اضافة سيرفر تحميل', 'MK' ),
                        'remove_button' => __( 'حذف السيرفر', 'MK' ),
                        'sortable'      => true,
                    ),
                    'fields'      => array(
                        array(
                            'name' => 'اسم السيرفر',
                            'id'   => 'server_name',
                            'type' => 'text',
                        ),
                        array(
                            'name' => 'الرابط',
                            'id'   => 'server_url',
                            'type' => 'text_url',
                        ),
                    ),
                ),
            ),
        );
        $meta_boxes['seo'] = array(
            'id'         => 'option_seo',
            'title'      => __( 'اعدادات الارشفة', 'cmb' ),
            'pages'      => array( 'singer' , 'album' , 'song' , 'news' , 'page' , 'episode' , 'serie' , 'movie' , 'selary' , 'game' , 'program' , 'season'),
            'fields'     => array(
                array(
                    'name' => 'عنوان الموضوع',
                    'id'   => 'seo_name',
                    'type' => 'text',
                    'desc' => 'عنوان الموضوع للارشفه والشير',
                ),
                array(
                    'name' => 'وصف الموضوع',
                    'id'   => 'seo_desc',
                    'type' => 'textarea',
                    'desc' => 'وصف الموضوع للارشفه والشير',
                ),
                array(
                    'name' => 'وسوم الموضوع',
                    'id'   => 'seo_tags',
                    'type' => 'text',
                    'desc' => 'كلمات دلائليه للموضوع لمحركات البحث',
                ),
                array(
                    'name' => 'صوره الارشفه والشير',
                    'id'   => 'seo_img',
                    'type' => 'file',
                ),
            ),
        );
        return $meta_boxes;
    }
    add_action( 'init', 'cmb_initialize_cmb_meta_boxes', 9999 );
    function cmb_initialize_cmb_meta_boxes() {
        if ( ! class_exists( 'cmb_Meta_Box' ) )
            require_once 'init.php';
    }
?>
