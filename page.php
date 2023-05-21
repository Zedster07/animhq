<?php 

global $post;
$post_slug = $post->post_name;

 

$url = get_bloginfo('url');
if( ( $post_slug == "login" && is_user_logged_in())|| ($post_slug == "logout" && !is_user_logged_in())  ){
	
	if(wp_redirect($url)){
		exit;
	}
}
$pages = array("contactus", "plans");
	
?> 

<?php get_header() ?>

<section class="pageTemplate" style="color: white;">

	

	
	<?php 
	 	if( !in_array($post_slug, $pages)) {
			?>
				<div class="page-section-title">
					<h1><?php 
						the_title();
					?></h1>
				</div>

				<div class="container">
					<?php if (have_posts()) { while (have_posts()) { the_post() ?>
							<?php the_content() ?>
						<?php } ; } ; wp_reset_query(); ?>
				</div>

		<?php
		} else if ($post_slug == "plans") {
			?>
				<h1>Dada</h1>
			<?php
		}
	
		
		else if($post_slug == "contactus"){

			?>
				<div class="page-section-title">
					<h1><?php 
						the_title();
					?></h1>
				</div>
				<div class="container">
					<div class="modal-content contactusForm">
						<span id="reportalertsuccess" style="display:none;color: seagreen;margin-bottom: 10px;" > تم الإرسال بنجاح, شكرا على تواصلك معنا. </span>
						<span id="reportalert" style="display:none;color: brown;margin-bottom: 10px;" > يرجى تعبئة جميع الحقول المطلوبة </span>
						<input type="hidden" value="<?php echo get_current_user_id();?>" id="contactuser"/>
						<input placeholder="البريد الإلكتروني" id="contactemail" type="text">
						<input placeholder="الموضوع" id="contactsubject" type="text">
						<textarea placeholder="الرسالة" id="contactcontent" rows="5"></textarea>
						<button id="contactbutton" >إرسال</button>
					</div>
					<script>
						$('#contactbutton').click(function(){
							let content = $("#contactcontent").val().trim();
							let sub = $("#contactsubject").val().trim();
							let user = $("#contactuser").val();
							let email = $("#contactemail").val().trim();

							if(sub == "" || content == "" || email == ""){
								$("#reportalert").css("display" , "block");
							} else {
								$("#reportalert").css("display" , "none");
								$("#contactbutton").html("<i class='fa fa-spinner'></i>");
								$.post('/wp-content/themes/arbCinema/Ajax/contactus.php', {action: "SET" , subject: sub , cnt: content , uid: user , email:email } , function(data) {
									$("#reportalertsuccess").css("display" , "block");
									$("#contactbutton").html("إرسال");
									$("#contactcontent").val("");
									$("#contactsubject").val("");
									$("#contactemail").val("");
								});
							}
						});
					</script>
				</div>

			<?php

		}
			

	?>
	

</section>
<?php get_footer() ?>