<?php get_header(); ?>

<!-- <div class="AdvancedSearch">
	<div class="container">
		<span><i class="fa fa-search"></i><em>البحث المتقدم</span> </span>
		<form method="get" action="<?php bloginfo('url');?>">
            <input type="text" name="s" id="s" value="<?=the_search_query(); ?>" placeholder="<?=_e('ادخل كلمه البحث','Mekawadaity-Net')?>">
            <select name="category">
            	<option selected disabled value="">اختر القسم</option>
            	<?php
            		$catArgs = array(
            			'taxonomy' => 'category',
            			'hide_empty' => true,
            		);
            		$catArgs = get_categories($catArgs);
            		$catArgs = (is_array($catArgs)) ? $catArgs : array();
        		?>
            	<?php foreach ($catArgs as $cat) { ?>
            		<option value="<?=$cat->term_id?>"><?=$cat->name?></option>
            	<?php } ?>
            </select>
            <select name="year" class="year">
            	<option selected disabled value="">اختر السنه</option>
            	<?php
            		$yearsArgs = array(
            			'taxonomy' => 'year-cat',
            			'hide_empty' => true,
            		);
            		$yearsArgs = get_categories($yearsArgs);
            		$yearsArgs = (is_array($yearsArgs)) ? $yearsArgs : array();
        		?>
            	<?php foreach ($yearsArgs as $year) { ?>
            		<option value="<?=$year->slug?>"><?=$year->name?></option>
            	<?php } ?>
            </select>
            <select name="quality" class="year">
            	<option selected disabled value="">اختر الجوده</option>
            	<?php
            		$qualitiesArgs = array(
            			'taxonomy' => 'quality-cat',
            			'hide_empty' => true,
            		);
            		$qualitiesArgs = get_categories($qualitiesArgs);
            		$qualitiesArgs = (is_array($qualitiesArgs)) ? $qualitiesArgs : array();
        		?>
            	<?php foreach ($qualitiesArgs as $quality) { ?>
            		<option value="<?=$quality->slug?>"><?=$quality->name?></option>
            	<?php } ?>
            </select>
            <button type="submit" id="searchsubmit"><i class="fa fa-search"></i>بحث</button>
        </form>
	</div>
</div> -->

<!--:: Advanced Search Area ::-->
<!-- <div class="container">
	<div class="filterItems">
		<h1>
			<i class="fa fa-clock-o"></i>
			<span>المضاف حديثا</span>
		</h1>
		<ul>
			<li id="lastPosts" class="active"><i class="fa fa-clock-o"></i>المضاف حديثا</li>
			<li id="MostViews"><i class="fa fa-fire"></i>الاكثر مشاهده</li>
			<li id="MostDownload"><i class="fa fa-download"></i>الاكثر تحميلا</li>
		</ul>
		<div class="clr"></div>
	</div>
</div> -->
<script type="text/javascript">
	$(function() {
		$(".filterItems li").click(function() {
			$(this).addClass("active").siblings().removeClass("active");
		});
		$("li#lastPosts").click(function(){
			$("ul.tab-content").html('<div class="loader"></div>');
			$(".filterItems > h1").html('<i class="fa fa-clock-o"></i><span>المضاف حديثا</span>');
			$.ajax({
				url: "<?=get_template_directory_uri()?>/Ajax/Home/last-posts.php",
				data: "",
				type: "POST",
				success: function(RES) {
					$("ul.tab-content").html(RES)
				},
				error: function() {}
			})
		});
		$("li#MostViews").click(function(){
			$("ul.tab-content").html('<div class="loader"></div>');
			$(".filterItems > h1").html('<i class="fa fa-fire"></i><span>الاكثر مشاهده</span>');
			$.ajax({
				url: "<?=get_template_directory_uri()?>/Ajax/Home/most-views.php",
				data: "",
				type: "POST",
				success: function(RES) {
					$("ul.tab-content").html(RES)
				},
				error: function() {}
			})
		});
		$("li#MostDownload").click(function(){
			$("ul.tab-content").html('<div class="loader"></div>');
			$(".filterItems > h1").html('<i class="fa fa-cloud-download"></i><span>الاكثر تحميلا</span>');
			$.ajax({
				url: "<?=get_template_directory_uri()?>/Ajax/Home/most-download.php",
				data: "",
				type: "POST",
				success: function(RES) {
					$("ul.tab-content").html(RES)
				},
				error: function() {}
			})
		});
	})
</script>
<!--: Recent Posts :-->
<section class="posts-section recent-posts" id="recent-posts">
	<?php get_template_part('template', 'recent_posts'); ?>
</section>

<section class="posts-section ended-posts" id="ended-posts">
		
	<?php get_template_part('template', 'ended_posts'); ?>

</section>


<section class="posts-section movies-posts" id="movies-posts-anime">
		
<?php get_template_part('template', 'movie_posts'); ?>

</section>

<section class="posts-section movies-posts" id="movies-posts-cartoon">
		
	
<?php get_template_part('template', 'cartoon_posts'); ?>
</section>

<script>
			$(".showmorebutton").click(function(){
				var section = $(this).attr("for");
				$(this).find("i").attr("class" , "fa fa-spinner");
				var visible = false;
				setTimeout(() => {
					var posters = $("#"+section+" .visiblegroup-2").each(function(){
						if($(this).css("display") == "none"){
							$(this).css("display" , "unset");
							visible = true;
						} else {
							$(this).css("display" , "none");
							visible = false;
						}
					});

					if(visible){
						$(".showmorebutton .more").text("اخفاء");
						$(this).find("i").attr("class" , "fa fa-minus");
					}else{
						$(".showmorebutton .more").text("المزيد");
						$(this).find("i").attr("class" , "fa fa-plus");
					}
				}, 500);
				
				

				
				
				
				
			});
		</script>
<?php get_footer() ?>