<?php 

?>
<!DOCTYPE html PUBLIC"-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html <?php language_attributes() ?>>
    <head>
        <meta name="description" content="<?php bloginfo('description'); ?>">
        <meta name="viewport" content="width=device-width">
        <meta name="googlebot" content="archive">
        <meta name="robots" content="index, follow">
        <meta name="robots" content="NOODP,NOYDIR">
        <meta name="rating" content="General">
        <meta http-equiv="Content-Language" content="ar-eg">
        <meta name="revisit-after" content="1 hour">
        <meta name="distribution" content="Global">
        <meta name="resource-type" content="document">
        <meta http-equiv="cache-control" content="no-cache">
        <meta property="og:type" content="website">
        <meta property="og:title" content="<?php bloginfo('name')?>">
        <meta property="og:description" content="<?php bloginfo('description')?>">
        <!--:: Links Tag ::-->
        <link rel="profile" href="http://gmpg.org/xfn/11">
        <link href="<?php bloginfo('pingback_url'); ?>" rel="pingback">
        <link rel="stylesheet" href="<?php bloginfo('template_url')?>/Interface/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?php bloginfo('template_url')?>/Interface/css/owl.carousel.min.css">
        <link rel="stylesheet" href="<?php bloginfo('template_url')?>/Interface/css/owl.theme.default.min.css">
        <link rel="stylesheet" href="<?php bloginfo('template_url')?>/style.css">
        <!--:: jS Scripts ::-->
        <script src="<?php bloginfo('template_directory')?>/Interface/js/jquery.min.js"></script>
        <script src="<?php bloginfo('template_directory')?>/Interface/js/owl.carousel.min.js"></script>
        <link rel="stylesheet" href="<?php bloginfo('template_url')?>/Interface/css/mobileStyle.css">
        <script type="text/javascript">
            $(window).scroll(function() {
                $('.scroll-load').addClass('load');
            });
        </script>
        <!--:: WordPress Header ::-->
        <?php wp_head() ?>
    </head>
    <body <?php body_class(); ?>>
        <div class="scrollTop"><i class="fa fa-angle-double-up"></i></div>
        <div class="animeHqContent">
        <!--:: Header ::-->
        <header>
            <a class="logo" href="<?=bloginfo('url')?>" title="<?=bloginfo('description')?>">
                <?php $logo = get_option('logo') ?>
                <?php if (empty($logo)) : ?>
                    <img src="<?=bloginfo('template_url')?>/Interface/images/LOGO1.png">
                <?php else : ?>
                    <img src="<?=$logo; ?>">
                <?php endif; ?>
            </a>
            <!--:: Header Bottom ::-->
            <div class="container navigationgroup">
                <div class="middleNav">
                
                        <!-- <a class="header-logo" title="<?php bloginfo('name') ?>" href="<?php bloginfo('url') ?>"><?php bloginfo('name') ?></a> -->
                        <?php if ( !wp_is_mobile() ) : ?>
                            <div class="menu-toggler"><i class="fa fa-bars"></i><?=_e('القائمه الرئيسيه','Mekawadaity-Net')?></div>
                            <?php
                            
                                wp_nav_menu( array (
                                    'theme_location'    => 'MainMenu',
                                    'echo'              => true,
                                    'container'         => false,
                                    'container_id'      => '',
                                    'menu_class'        => '',
                                    'menu'              => '',
                                    'depth'             => 2,
                                    'items_wrap'        => '<ul role="navigation">%3$s</ul>',
                                ));
                            ?>
                        <?php else : ?>
                            <!--:: Header Mobile Menu ::-->
                            <select id="selectbox" onChange="javascript:location.href = this.value;">
                                <option value="" selected="selected"><?=_e( 'القائمة الرئيسية' , 'Mekawadaity-Net' )?></option> 
                                <?php $menu = wp_nav_menu( array ( 'echo' => false , 'theme_location'  => 'MainMenu' ) );
                                    if (preg_match_all('#(<a [^<]+</a>)#',$menu,$matches)) {
                                        $hrefpat = '/(href *= *([\"\']?)([^\"\' ]+)\2)/';
                                        foreach ($matches[0] as $link) {
                                            if (preg_match($hrefpat,$link,$hrefs)) {
                                                $href = $hrefs[3];
                                            }
                                            if (preg_match('#>([^<]+)<#',$link,$names)) {
                                                $name = $names[1];
                                            }
                                        ?>
                                    <option value="<?=$href?>"><?=$name?></option> 
                                <?php } } ?>
                            </select>
                        <?php endif; ?>
                </div>
                <div class="promoNav">
                    <ul role="navigation">            
                        <?php 
                        $menu_name = 'PromoMenu';
                        $locations = get_nav_menu_locations();
                        $menu = wp_get_nav_menu_object( $locations[ $menu_name ] );
                        $menuitems = wp_get_nav_menu_items( $menu->term_id, array( 'order' => 'DESC' ) );
                        foreach( $menuitems as $item ){
                            $title = $item->title;
                            $link = $item->url;
                            $class = "";
                            $icon = "";
                            if(strpos($link, "plans" ) !== false){
                                $class = "itemplans";
                            }
                            if(strpos($link, "kids" ) !== false){
                                $icon = '<img src="'.get_template_directory_uri().'/Interface/images/lollipop.png" width="15" />';
                            }
                            
                            ?>
                                <li class="menu-item menu-item-type-taxonomy menu-item-object-category <?=$class?>"><a href="<?=$link?>"><?php echo $title.$icon; ?> </a></li>
                            <?php 
                        }

                            
                    ?>   
                    </ul>              
                </div>
                    </div>
            <div class="leftNav">
                <i class="fa fa-search navicons" id="searchIcon" aria-hidden="true" title=""></i>
                <div class="searchForm">
                    <form method="get" id="search_form" action="">
                        <input type="text" name="s" placeholder="البحث عن فلم او مسلسل"/>
                    </form>
                </div>
                <?php if( is_user_logged_in() ) {?>
                    <a href="<?=bloginfo('url')?>/account"><i class="fa fa-user navicons" aria-hidden="true" title="حسابي"></i></a>
                    <a href="<?=wp_logout_url(get_bloginfo('url'))?>"><i class="fa fa-sign-out navicons" aria-hidden="true" title="تسجيل الخروج"></i></a>
                <?php } else { ?>
                    <a href="<?=bloginfo('url')?>/new-member"><i class="fa fa-user-plus navicons" aria-hidden="true" title="عضو جديد"></i></a>
                    <a href="<?=bloginfo('url')?>/login"><i class="fa fa-sign-in navicons" aria-hidden="true" title="تسجيل الدخول"></i></a>
                <?php } ?>
                
                
                <!-- <div class="account">
                    
                    <img class="user-avatar" src="<?=bloginfo('template_url')?>/Interface/images/user.png"  width="40" height="40"/>          
                    <i class="fa fa-angle-down" aria-hidden="true"></i>
                    <?php 
                    if( is_user_logged_in() ) {
                        wp_nav_menu( array (
                                    'theme_location'    => 'MemberMenu',
                                    'echo'              => true,
                                    'container'         => false,
                                    'container_id'      => '',
                                    'menu_class'        => '',
                                    'menu'              => '',
                                    'depth'             => 2,
                                    'items_wrap'        => '<ul class="AcountList">%3$s</ul>',
                            ));
                    } else {
                            wp_nav_menu( array (
                                    'theme_location'    => 'VisitorMenu',
                                    'echo'              => true,
                                    'container'         => false,
                                    'container_id'      => '',
                                    'menu_class'        => '',
                                    'menu'              => '',
                                    'depth'             => 2,
                                    'items_wrap'        => '<ul class="AcountList">%3$s</ul>',
                            ));
                    }
                    
                    ?>
                
                </div> -->
            </div>
            
            <script>
                $( document ).ready(function() {
                    $("#search_form").submit(function(e){
                        if($(".leftNav input").val() == ""){
                            return false;
                        }
                    });
                    $("#searchIcon").click(function(){
                        
                        if($(".leftNav input").css("width") != "18px"){
                            if($(".leftNav input").val() != ""){
                                 $("#search_form").submit();
                            } else {
                                $(".leftNav input").animate({width: "0px"} , '500' , function(){
                                    $(this).hide();
                                });
                            }
                            
                        } else {
                            $(".leftNav input").show();
                            $(".leftNav input").animate({width: "215px"} , '500' , function(){
                                $(this).focus();
                            });
                        }
                        
                    });
                    $(".account").click(function(){
                        var val = $(".AcountList").css("display");
                        if(val == "block") {
                            $(".AcountList").css("display" , "none");
                        } else {
                            $(".AcountList").css("display" , "block");
                        }
                        
                    });
                });
            </script>
        </header>
        <script type="text/javascript">
            // $(window).scroll(function() {
            //     if ($(this).scrollTop() > $('header').height()) {
            //         $('header').addClass('scrolled');
            //     } else {
            //         $('header').removeClass('scrolled');
            //     }
            // });
        </script>
        <!--:: Introducation ::-->
        <?php  if (is_home()) {  ?>
            <?php
           
				$recentQuery = new WP_Query( array( 
					'post_type' => array('movie','serie') ,
					'posts_per_page' => 40,
                    'tag' => 'onslider',
					'paged' => 1
				)); 
              
            if ($recentQuery->have_posts()) {
            
            ?>
            
            <div class="animehq-slider hideonMobile">
                <?php if($recentQuery->post_count > 1){ ?>
                    <span class="slider-control slider-next">
                        <img src="<?php bloginfo('template_url')?>/Interface/images/next-arrow.png" width="50" />
                    </span>
                    <span class="slider-control slider-prev">
                        <img src="<?php bloginfo('template_url')?>/Interface/images/prev-arrow.png" width="50"/>
                    </span>  
                <?php } ?>
            <?php  $slide_id = 0; while ($recentQuery->have_posts()) { 
                
                $recentQuery->the_post(); 
                
                $title = $post->post_title;
                $postType = get_post_type($post->ID);

                if($postType == "serie" ) {
                    $db_name = $wpdb->dbname;
                    $db_user = $wpdb->dbuser;
                    $db_password = $wpdb->dbpassword;
                    $db_host = $wpdb->dbhost;
                    try {
                        $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_password);
                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    } catch (PDOException $e) {
                        die("Database connection failed: " . $e->getMessage());
                    }
                    $query = "SELECT s.serieId, s.name as season_name, e.seasonId, e.eorder , e.name  , e.video , s.cover FROM episodes e JOIN seasons s ON e.seasonId = s.id WHERE (e.seasonId, e.eorder) IN ( SELECT seasonId, MAX(eorder) FROM episodes GROUP BY seasonId ) and s.serieId = :serie_id ORDER BY s.serieId;";
                    $stmt = $pdo->prepare($query);
                    $stmt->bindParam(':serie_id', $post->ID, PDO::PARAM_INT);
                    $stmt->execute();
                    $episode = $stmt->fetch(PDO::FETCH_OBJ);

                    $serie = $post;
                    $cats = get_the_terms($serie->ID ,'category','');
                    $title = $serie->post_title;
                    if($episode) {
                        $title .= ' - '. $episode->season_name.' - '.$episode->name;
                    }
                    $thumb = wp_get_attachment_url(get_post_thumbnail_id($serie->ID));
                } else {
                    $thumb = wp_get_attachment_url(get_post_thumbnail_id());
                }
                ?>

                <?php 
                    if (empty($thumb)){
                        $thumb = get_template_directory_uri() . "/Interface/images/no-thumb.jpeg";
                    }
                    $slide_id++;
                ?>
                
                <div class="animehq-slide <?php echo $slide_id==1?"slider-selected":""; ?>" id="slide-<?php echo $slide_id;?>" style="background-image:url(<?php echo $thumb?>)">
                     
                    <div class="slide-wrapper">
                            
                            <div class="slider-title">
                                <h4><?=$title; ?></h4>
                            </div>
                            <div class="slider-metdata">
                                <div class="rate-container">
                                    <?php $rates = get_the_terms(get_the_ID() ,'ratings-cat',''); ?>
                                    <div class="rate">
                                        
                                        <?php if(!empty($rates)){ foreach ($rates as $rate) { ?>
                                            <span><?=$rate->name?></span>
                                        <?php }} ?>
                                    </div>
                                    <img src="<?=get_template_directory_uri()?>/Interface/images/mal-logo.png" width="30" style="margin-right: 10px;" />
                                    <?php  
                                    
                                        $rate = 0;
                                        if($rates && count($rates) != 0){
                                            $rate = $rates[0]->name;
                                            $rateval = floatval($rate);
                                            $rateval = $rateval / 2;
                                            $intval = intval($rateval);
                                            $i = 0;
                                            while($i < $intval){?>
                                    
                                                <img src="<?php bloginfo('template_url')?>/Interface/images/star.png" width="15" height="15" />
                                    
                                            <?php $i++; } 
                                            $rest = 5 - $intval;
                                            if($rateval > $intval){?>
                                                <img src="<?php bloginfo('template_url')?>/Interface/images/star-half.png" width="15" height="15"/>
                                            <?php 
                                            $rest - 1;
                                            }
                                            $i = 1;
                                            while ($i < $rest){?>
                                                <img src="<?php bloginfo('template_url')?>/Interface/images/star-empty.png" width="15" height="15"/>

                                            <?php $i++;
                                            }
                                        }
                                    ?> 
                            
                                </div>
                                

                                <!-- <div class="seasonsNumber">
                                    <?php $seasons_list = get_post_meta(get_the_ID(),'seasons_list',true); ?>
                                    <?php $seasons_list = (is_array($seasons_list)) ? $seasons_list : array() ; ?>
                                    <?php $seasons_list = array_unique($seasons_list) ?>
                                    <?php if (count($seasons_list) != 0) { ?>
                                        <span><?php echo count($seasons_list); ?>  مواسم  </span>
                                    <?php } ?>
                                </div> -->

                                <div class="year">
                                    
                                    <?php $Yrs = get_the_terms(get_the_ID() ,'year-cat','');  ?>
                                    <?php if($Yrs){?>
                                        <span style="color:white;">-</span>
                                       <?php foreach ($Yrs as $Yr) { ?>
                                        <a href="<?=get_term_link($Yr)?>"><?=$Yr->name?></a>
                                    <?php }} ?>
                                </div>
                                

                            </div>
                            <div class="slider-metdata">
                                

                                <div class="slider-cats">
                                    <?php if ($cats) { 
                                        $toprint = array();
                                        $collected = 0;
                                        $cats_length = count($cats);
                                        $j=0; 
                                        while($j < $cats_length && $collected < 3) {
                                            $key = $cats[$j]; 
                                            if($key->slug != "movies" && $key->slug != "series") {
                                                array_push($toprint , $key);
                                                $collected++;
                                            }
                                            $j++;
                                        }

                                        
                                        
                                        $j = 0; $cats_length = count($toprint); 
                                        while($j < $cats_length) { 
                                            $key = $toprint[$j]; ?> 
                                            <h6><a href="<?=get_term_link($key)?>"><?=$key->name?></a></h6>
                                            <?php if($j < $cats_length-1){ ?>
                                                <h6 class="separators"><i class="fa fa-circle" aria-hidden="true"></i></h6>
                                            <?php } ?>
                                        <?php $j++;}
                                    } ?>
                                   
                                    

                                </div>
                                

                            </div>
                            <div class="slider-desc">
                                <?php the_content(); ?>
                            </div>
                            <div class="slider-watchNow">
                                <div class="flip">
                                        <a href="<?php the_permalink(); ?>">
                                            <div class="front">شاهد</div>
                                            <div class="back">الآن</div>
                                        </a>
                                    <?php 
                                        $serie = get_post_meta($post->ID,'season_serie',true);

                                       $linkQuery = new WP_Query( array( 
                                            'post_type' => array('episode') ,
                                            'post_status' => "publish",
                                            'posts_per_page' => 1,
                                            'meta_key' => array('episode_numbar' , 'episode_season'),
                                            'orderby' => 'meta_value_num',
                                            'meta_query' => array(
                                                array(
                                                    'key' => 'season_serie',
                                                    'value' => $serie,
                                                    'compare' => '=='
                                                ),
                                            ),
                                        )); 

                                        if($linkQuery->have_posts()){
                                            $linkQuery->the_post();
                                            ?>
                                        <a href="<?php the_permalink(); ?>">
                                            <div class="front">شاهد</div>
                                            <div class="back">الآن</div>
                                        </a>

                                    <?php
                                        }
                                    ?>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                

                <?php } ; } ; wp_reset_query() ?>
                </div>

        <?php } ?>
        <!--:: Shadow DiV ::-->
        <?php if (is_home()) { ?>
        <script type="text/javascript">
           
            $(window).scroll(function() {
                let scroll = $(this).scrollTop();
                if(scroll > 10){
                    $("header").addClass("headerScrolled");
                    //$("header").css("background" , "linear-gradient(0deg,rgba(0, 0, 0, 1) 0%,rgba(0, 0, 0, 1) 41%,rgba(0, 0, 0, 1) 91%,rgba(0, 0, 0, 1) 100%)");
                }else {
                    $("header").removeClass("headerScrolled");
                    //$("header").css("background" , "linear-gradient(0deg,rgba(0, 0, 0, 0) 0%,rgba(0, 0, 0, .5) 41%,rgba(0, 0, 0, 0.9) 91%,rgba(0, 0, 0, 0.9) 100%)");
                }
            });
        </script>
        <?php } else { ?>
            <script type="text/javascript">
                $("header").addClass("headerScrolled");
            </script>

        <?php } ?>
        <script>
            setInterval(() => {
                slidenext();
            }, 7000);

            function slidenext(){
                var currentslide = $(".slider-selected").attr('id');
                if(currentslide){
                    $("#"+currentslide).removeClass("slider-selected");
                    var nextslide = parseInt(currentslide.split("-")[1]) + 1 ;
                
                    if( $("#slide-"+nextslide).length ){
                        $("#slide-"+nextslide).addClass("slider-selected");
                    }else{
                        $("#slide-1").addClass("slider-selected");
                    }
                }
                
            }


            $(".slider-control").click(function(){
                var but = $(this).attr("class").split(" ")[1];
                var currentslide = $(".slider-selected").attr('id');
                $("#"+currentslide).removeClass("slider-selected");

                if(but == "slider-next"){
                    var nextslide = parseInt(currentslide.split("-")[1]) + 1 ;
                }else{
                    var nextslide = parseInt(currentslide.split("-")[1]) - 1;
                }

                if( $("#slide-"+nextslide).length ){
                    $("#slide-"+nextslide).addClass("slider-selected");
                }else{
                    $("#slide-1").addClass("slider-selected");
                }
            });
        </script>
<!--<div class="bodytopmargin">
</div>-->