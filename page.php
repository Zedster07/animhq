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
			global $wpdb;
			$db_name = $wpdb->dbname;
			$db_user = $wpdb->dbuser;
			$db_password = $wpdb->dbpassword;
			$db_host = $wpdb->dbhost;
			// $plan = pms_get_subscription_plan($data['subscription_plan_id']);
			// $ahqPlan = $this->getPlan($plan->name);
			try {
				$pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_password);
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			} catch (PDOException $e) {
				die("Database connection failed: " . $e->getMessage());
			}
			$query = "SELECT * FROM ahq_plans order by id desc";
			$stmt = $pdo->prepare($query);
			$stmt->execute();

			$pms_plans = pms_get_subscription_plans();
			$indexedPlans = array();
			foreach ($pms_plans as $plan) {
				if ($plan instanceof PMS_Subscription_Plan) {
					$indexedPlans[$plan->name][] = array("id"=>$plan->id, "name"=>$plan->name, "duration"=> $plan->duration, "duration_unit" => $plan->duration_unit, "price" => $plan->price );
				}
			}
			print_r($indexedPlans);
			die('');
			$plans = $stmt->fetchAll(PDO::FETCH_OBJ);?>
			<div class="plansContainer">
					<div class="plansWrapper">
			
			<?php foreach ($plans as $plan) {

				?>
				<div class="planSection">
					<h1><?php echo($plan->plan_name) ?></h1>
					<h1 class="price">$<span class="main-price">9.</span><span class="cents">99</span> /mo</h1>
					<select class="plans_months_select">
						<option>1 شهر</option>
						<option>3 أشهر</option>
						<option>6 أشهر</option>
						<option>1 سنة</option>
					</select>
					<div class="planContent">
						<h3 class="planLine">بدون إعلانات</h3>
						<h3 class="planLine">مشاهدة أونلاين</h3>
						<h3 class="planLine">تحميل</h3>
						<h3 class="planLine">4 شاشات</h3>
						<h3 class="planLine">أعلى جودة 4k</h3>
						<h3 class="planLine">بدون تجديد آلي</h3>
						<a href="#" class="plan_sub"><span>إشتراك </span> <span>$9.99</span></a>
					</div>
				</div>
			
			<?php } ?>

				
				
						
						
						
						
					</div>
				</div>
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