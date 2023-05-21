<?php
    function Main() {
        load_theme_textdomain('MK' , get_template_directory().'/lang');
        // Theme Supports
        add_theme_support('post-thumbnails');
        add_theme_support('menus');
        add_theme_support('widgets');
        add_theme_support('title-tag');
        add_theme_support( 'automatic-feed-links' );
        add_filter('show_admin_bar', '__return_false');
        // Register Menus
        register_nav_menus(array(
            'TopMenu'      => __( 'القائمة العلوية', 'MK' ),
            'VisitorMenu'      => __( 'القائمة الزائر', 'MK' ),
            'MemberMenu'      => __( 'القائمة العضو', 'MK' ),
            'PromoMenu'      => __( 'القائمة الاشهارية', 'MK' ),
            'MainMenu'     => __( 'القائمة الاساسية', 'MK' ),
            'FooterMenu'   => __( 'القائمة الفوتر', 'MK' ),
            'SlideMenu'    => __( 'القائمه الجانبيه' , 'MK' ),
        ));
    }
    add_action('after_setup_theme','Main');
    //////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////
    function admin() {
        wp_enqueue_style('admin-style', get_template_directory_uri() . '/Interface/css/style-admin.css' );
    }
    add_action('admin_enqueue_scripts','admin');
    add_action('admin_menu','RemoveP');
    function RemoveP() {
        remove_menu_page('edit.php');
    }
    ///////////////////////////////////////////////
    ///////////////////////////////////////////////
    add_filter('show_admin_bar','__return_false');
    function media_uploader() {
      wp_enqueue_media();
    }
    add_action('admin_enqueue_scripts','media_uploader');
    /////////////////////////////////////////////////////
    /////////////////////////////////////////////////////
    function makeViews($postID) {
        $count_key = 'Views';
        $count = get_post_meta($postID, $count_key, true);
        if ( $count =='' ) {
            $count = 0;
            delete_post_meta($postID, $count_key);
            add_post_meta($postID, $count_key, '0');
        } else {
            $count++;
            update_post_meta($postID, $count_key, $count);
        }
    }
    function getViews($postID){
        $count_key = 'Views';
        $count = get_post_meta($postID, $count_key, true);
        if ( $count=='' ) {
            delete_post_meta($postID, $count_key);
            add_post_meta($postID, $count_key, '0');
            return "0";
        }
        return $count;
    }
    ///////////////////////////////////////////////
    ///////////////////////////////////////////////
    add_filter('manage_posts_columns' , 'add_sticky_column');
    add_action( 'manage_posts_custom_column' , 'custom_columns', 5, 2 );
    function add_sticky_column($columns) {
        return array_merge( $columns,array('Views' => __('المشاهدات')) );
    }
    function custom_columns( $column, $post_id ) {
        switch ( $column ) {
            case 'Views':
                echo get_post_meta( $post_id, 'Views', true );
            break;
        }
    }
    /////////////////////////////////
    function pagination($pages = '', $range = 2){  
        $showitems = ($range * 2)+1;  
        global $paged;
        if(empty($paged)) $paged = 1;
        if($pages == '') {
            global $wp_query;
            $pages = $wp_query->max_num_pages;
            if(!$pages) {
                $pages = 1; 
            }
        }   
        if(1 != $pages) {
            echo "<div class=\"pagination\" role=\"navigation\" itemscope itemtype=\"http://schema.org/SiteNavigationElement\">";
            if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<li itemprop=\"url\"><a style='font-family: main-font !important' rel=\"prev\" href='".get_pagenum_link(1)."' itemprop=\"name\">&laquo; الاول</a></li>";
            if($paged > 1 && $showitems < $pages) echo "<li itemprop=\"url\"><a style='font-family: main-font !important' href='".get_pagenum_link($paged - 1)."' itemprop=\"name\">&lsaquo; السابق</a></li>";
            for ($i=1; $i <= $pages; $i++) {
                if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )) {
                    echo ($paged == $i)? "<li itemprop=\"url\"><span class=\"current\">".$i."</span>":"<a class=\"inactive\" href='".get_pagenum_link($i)."' itemprop=\"name\">".$i."</a></li>";
                }
            }
            if ($paged < $pages && $showitems < $pages) echo "<li itemprop=\"url\"><a style='font-family: main-font !important' rel=\"next\" href=\"".get_pagenum_link($paged + 1)."\"  itemprop=\"name\"><i class='fa fa-angle-left'></i></a></li>";  
            echo "</div>\n";
        }
    }
    //////////////////////////////////////////////////////////////////
    function custom_admin_js() {
        $url = get_bloginfo('template_directory') . '/dada.js';
        echo '"<script type="text/javascript" src="'. $url . '"></script>"';
    }
    add_action('admin_footer', 'custom_admin_js');
    function remove_admin_bar_links() {
        global $wp_admin_bar;
        $wp_admin_bar->remove_menu('updates');
        $wp_admin_bar->remove_menu('about');
        $wp_admin_bar->remove_menu('comments');
        $wp_admin_bar->remove_menu('w3tc');
        $wp_admin_bar->remove_menu('wp-logo');
    }
    add_action( 'wp_before_admin_bar_render', 'remove_admin_bar_links' );
    function search_filter($query) {
        if ( !is_admin() && $query->is_main_query() ) {
            if ($query->is_search) {
                $query->set('post_type',array('serie','season','movie','episode'));
            }
        }
    }
    add_action('pre_get_posts','search_filter');
    function ajax_login_init(){
        wp_register_script('ajax-login-script', get_template_directory_uri() . '/Interface/js/login-script.js', array('jquery') );
        wp_enqueue_script('ajax-login-script');
        wp_localize_script( 'ajax-login-script', 'ajax_login_object', array(
            'ajaxurl' => admin_url( 'admin-ajax.php' ),
            'redirecturl' => home_url(),
            'loadingmessage' => __('برجاء الانتظار')
        ));
        add_action( 'wp_ajax_nopriv_ajaxlogin', 'ajax_login' );
    }
    if (!is_user_logged_in()) {
        add_action('init', 'ajax_login_init');
    }
    function ajax_login(){
        check_ajax_referer( 'ajax-login-nonce', 'security' );
        $info = array();
        $info['user_login'] = $_POST['username'];
        $info['user_password'] = $_POST['password'];
        $info['remember'] = true;
        $user_signon = wp_signon( $info, false );
        if ( is_wp_error($user_signon) ){
            echo json_encode(array('loggedin'=>false, 'message'=>__('خطا فى البيانات')));
        } else {
            echo json_encode(array('loggedin'=>true, 'message'=>__('تم تسجيل الدخول .. جارى توجيهيك للارئيسيه')));
        }
        die();
    }
    add_action('wp_ajax_register_user_front_end', 'register_user_front_end', 0);
    add_action('wp_ajax_nopriv_register_user_front_end', 'register_user_front_end');
    function register_user_front_end() {
        $new_user_name      = stripcslashes($_POST['new_user_name']);
        $new_user_email     = stripcslashes($_POST['new_user_email']);
        $new_user_password  = $_POST['new_user_password'];
        $user_nice_name     = strtolower($_POST['new_user_email']);
        $user_data = array(
            'user_login'        => $new_user_name,
            'user_email'        => $new_user_email,
            'user_pass'         => $new_user_password,
            'user_nicename'     => $new_user_name,
            'display_name'      => $new_user_name,
            'role'              => 'subscriber'
            );
        $user_id = wp_insert_user($user_data);
        if (!is_wp_error($user_id)) {
            echo 'تم تسجيل الحساب بنجاح';
        } else {
            if (isset($user_id->errors['empty_user_login'])) {
                $notice_key = 'تاكد من اسم المستخدم';
                echo $notice_key;
            } elseif (isset($user_id->errors['existing_user_login'])) {
                echo'اسم المستخدم موجود مسبقا';
            } else {
                echo'تاكد من البيانات المدخله بشكل صحيح';
            }
        }
        die();
    }
    add_action ('wp_loaded', 'userisLogedIn', 10 , 1);
	function userisLogedIn($post_slug) {
		
		if($post_slug == "login" && is_user_logged_in()){
			wp_redirect(bloginfo('url'));
			exit;
		}
	}  
    require_once(get_template_directory() . '/Inc/manage.php');
