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
					$indexedPlans[$plan->name][$plan->duration_unit][$plan->duration] = array(
						"id"=>$plan->id, 
						"name"=>$plan->name, 
						"duration"=> $plan->duration, 
						"duration_unit" => $plan->duration_unit, 
						"price" => $plan->price );
				}
			}
			$plans = $stmt->fetchAll(PDO::FETCH_OBJ);?>
			<div class="plansContainer">
				<h1> باقات الإشتراك </h1>
					<div class="plansWrapper">
						
			
			<?php foreach ($plans as $plan) {
				$price = explode('.', $indexedPlans[$plan->plan_name]['month']['1']['price']);
				?>
				<div class="planSection" id="plan-<?php echo($plan->id); ?>">
					<h1><?php echo($plan->plan_name) ?></h1>
					<h1 class="price">$<span class="main-price"><?php echo($price[0]); ?>.</span><span class="cents"><?php echo(isset($price[1])?$price[1]:0); ?></span> /mo</h1>
					<input type="hidden" id="plan_<?php echo($plan->id); ?>_1" value="<?php echo($indexedPlans[$plan->plan_name]['month']['1']['price'])?>" pid="<?php echo($indexedPlans[$plan->plan_name]['month']['1']['id'])?>" />
					<input type="hidden" id="plan_<?php echo($plan->id); ?>_3" value="<?php echo($indexedPlans[$plan->plan_name]['month']['3']['price'])?>" pid="<?php echo($indexedPlans[$plan->plan_name]['month']['3']['id'])?>"  />
					<input type="hidden" id="plan_<?php echo($plan->id); ?>_6" value="<?php echo($indexedPlans[$plan->plan_name]['month']['6']['price'])?>" pid="<?php echo($indexedPlans[$plan->plan_name]['month']['6']['id'])?>"  />
					<input type="hidden" id="plan_<?php echo($plan->id); ?>_12" value="<?php echo($indexedPlans[$plan->plan_name]['month']['12']['price'])?>" pid="<?php echo($indexedPlans[$plan->plan_name]['month']['12']['id'])?>"  />
					<div class="planContent">
						<h3 class="planLine">بدون إعلانات</h3>
						<h3 class="planLine">مشاهدة أونلاين</h3>
						<h3 class="planLine <?php echo($plan->candownload ? '' : 'linethrough'); ?>">تحميل</h3>
						<h3 class="planLine"><?php echo($plan->screens." "); echo($plan->screens == 1 ? "شاشة" : 'شاشات'); ?> </h3>
						<?php if($plan->quality_4k) { ?>  <h3 class="planLine">أعلى جودة 4k</h3> <?php 
						} else if($plan->quality_2k) { ?> <h3 class="planLine"> أعلى جودة 2k</h3> <?php
						} else if($plan->quality_1080) { ?><h3 class="planLine">أعلى جودة 1080p</h3> <?php 
						} else if($plan->quality_720p) { ?> <h3 class="planLine"> أعلى جودة 720p</h3><?php }
						?>
						<h3 class="planLine">بدون تجديد آلي</h3>
						<select class="plans_months_select" id="plans_months_select-<?php echo($plan->id); ?>">
							<option value="1">1 شهر</option>
							<option value="3">3 أشهر</option>
							<option value="6">6 أشهر</option>
							<option value="12">1 سنة</option>
						</select>
						<a href="<?php echo(get_site_url()); ?>/register?subscription_plan=<?php echo($indexedPlans[$plan->plan_name]['month']['1']['id'])?>&single_plan=yes" websiteurl="<?php echo(get_site_url()); ?>" class="plan_sub"><span>إشتراك </span> <span>$<span class="pricetopay"><?php echo($indexedPlans[$plan->plan_name]['month']['1']['price'])?></span></span></a>
					</div>
				</div>
				
			<?php } ?>
						
					</div>
				</div>
				<script>
					var selects = document.querySelectorAll(".plans_months_select");
					selects.forEach(select => {
						select.addEventListener('change', function(e){
							var planId = select.id.split('-')[1];
							var plan = document.querySelector("#plan-"+planId);
							var planprice = plan.querySelector(".pricetopay");
							var price = plan.querySelector("#plan_"+planId+"_"+e.target.value);
							var pid = price.getAttribute('pid');
							var website = plan.querySelector('.plan_sub').getAttribute('websiteurl');
							plan.querySelector('.plan_sub').setAttribute("href", website+`/register?subscription_plan=${pid}&single_plan=yes`);
							planprice.textContent  = price.value;
						});
					});
					
					
				</script>
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