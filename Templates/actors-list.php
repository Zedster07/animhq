<?php 
	get_header();
	// Template Name: قائمه الفنانين
?>
<div class="TemplatePage">
	<div class="container">
		<h2 class="TitleAreaTwo">
	        <i class="fa fa-bars"></i>
	        <span><?php the_title() ?></span>
	    </h2>
	    <ul>
	    	<?php
	    		$args = array(
	    			'taxonomy' => 'actor-cat',
	    			'pad_counts' => false,
	    			'hide_empty' => false,
	    			'orderby' => 'name',
	    			'order' => 'ASC',
	    		);
	    		$actors = get_categories($args);
	    		$actors = (is_array($actors)) ? $actors : array();
	    	?>
	    	<?php foreach ($actors as $actor) { ?>
	    		<div class="ActorsListBlock">
	    			<a href="<?=get_term_link($actor->term_id)?>">
	    				<img src="<?=get_template_directory_uri()?>/Interface/images/user.png">
		    			<h1><?=$actor->name?></h1>
		    			<span><em><?=$actor->count?></em>عمل</span>
	    			</a>
	    		</div>
	    	<?php } ?>
	    	<div class="clr"></div>
	    </ul>
    </div>
</div>
<?php get_footer() ?>