		<div class="bodytopmargin"></div>
        <?php if (!is_404()) { ?>
        <!-- <div class="adsHome">
            <div class="container">
                <div class="col">
                    <?php $footerRightAD = get_option('footerRightAD') ?>
                    <?php if (empty($footerRightAD)) { ?>
                        <img src="<?=get_template_directory_uri()?>/Interface/images/bannerRed.png">
                    <?php } else { ?>
                        <a href="<?=get_option('footerRightADUrl')?>">
                            <img src="<?=$footerRightAD?>">
                        </a>
                    <?php } ?>
                </div>
                <div class="col">
                    <?php $footerCenterAD = get_option('footerCenterAD') ?>
                    <?php if (empty($footerCenterAD)) { ?>
                        <img src="<?=get_template_directory_uri()?>/Interface/images/bannerLight.png">
                    <?php } else { ?>
                        <a href="<?=get_option('footerCenterADUrl')?>">
                            <img src="<?=$footerCenterAD?>">
                        </a>
                    <?php } ?>
                </div>
                <div class="col">
                    <?php $footerLeftAD = get_option('footerLeftAD') ?>
                    <?php if (empty($footerLeftAD)) { ?>
                        <img src="<?=get_template_directory_uri()?>/Interface/images/bannerDark.png">
                    <?php } else { ?>
                        <a href="<?=get_option('footerLeftADUrl')?>">
                            <img src="<?=$footerLeftAD?>">
                        </a>
                    <?php } ?>
                </div>
                <div class="clr"></div>
            </div>
        </div> -->
        <?php } ?>
        </div>
		<footer>
			<div class="container">
				<div id="copyright"> 
					جميع الحقوق محفوظه لدى <a href="<?=home_url()?>"><?=bloginfo('name')?></a><span> &copy; <?=date("Y")?></span>
				</div>
                <div id="social">
                    <ul id="social-list">
                        <li><a href="#"><img src="<?=get_template_directory_uri()?>/Interface/images/social_icons/facebook-01.png" width="30" /> </a></li>
                        <li><a href="#"><img src="<?=get_template_directory_uri()?>/Interface/images/social_icons/instagram-01.png" width="30"/> </a></li>
                        <li><a href="#"><img src="<?=get_template_directory_uri()?>/Interface/images/social_icons/snapchat-01.png" width="30"/> </a></li>
                        <li><a href="#"><img src="<?=get_template_directory_uri()?>/Interface/images/social_icons/twitter-01.png" width="30"/> </a></li>
                        <li><a href="#"><img src="<?=get_template_directory_uri()?>/Interface/images/social_icons/whatsapp-01.png" width="30"/> </a></li>
                    </ul>
                </div>
			</div>
		</footer>
        <?php wp_footer(); ?>
    </body>
</html>