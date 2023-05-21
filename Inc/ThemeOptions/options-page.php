<?php
    function mekawdaity_menu_page(){
        add_menu_page( 'اعادات القالب', 'اعادات القالب', 'administrator', 'mk-panel', 'MekawdaityOptions'); 
    }
    add_action( 'admin_menu', 'mekawdaity_menu_page' );
    function MekawdaityOptions(){
        ?>
        <?php require ( get_template_directory().'/Inc/ThemeOptions/options.php'); ?>
        <link rel="stylesheet" href="<?=get_template_directory_uri()?>/Inc/ThemeOptions/style.css">
        <link rel="stylesheet" href="<?php bloginfo('template_url')?>/Interface/css/font-awesome.min.css">
        <div id="Mekawdaity-panel">
            <div class="Mekawdaity-header-panel">Mekawdaity.Net</div>
            <div id="main">
                <ul class="tabContainer">
                	<?php foreach ( $options as $option ) { ?>
    					<?php if ( $option['type'] == 'tab' ) { ?>
                        	<script>
                                $(document).ready(function(){
        							$("#<?=$option['id']?>-tab").click(function(){
        								$(".input_section").hide().removeClass('active');
        								$(".panel-field-<?=$option['id']?>").show().addClass('active');
        							});
        						});
                            </script>
                            <li id="<?=$option['id']?>-tab">
                                <a href="javascript:void(0);" class="tab">
                                    <i class="<?=$option['icon']?>"></i>
                                    <span><?=$option['name']?></span>
                                </a>
                            </li>
                        <?php } ?>
                    <?php } ?>
                	<?php foreach ( $options as $option ) { ?>
    					<?php $i = 0; ?>
                        <?php if ( $option['type'] == 'tab' ) { ?>
                        	<?php $optffds[] = $option['id']; ?>
                        <?php $i++; } ?>
                    <?php } ?>
                    <?php foreach ( array_slice($optffds, 0, 1) as $v ) { ?>
                    	<script>
        					$(document).ready(function(){
        						$(".input_section").hide();
        						$(".panel-field-<?=$v?>").show();
        					});
    					</script>
                    <?php } ?>
                </ul>
                <div class="clr"></div>
                <div id="tabContent">
                    <div id="contentHolder">
                        <div class="options_wrap">
                            <div class="content_options">
                                <form action="#" method="POST">
                                	<?php $i = 0; ?>
                                    <?php foreach ( $options as $option ) { ?>
    									<?php if  ( $option['type'] == 'title' ) { ?>
    	                                    <h1 class="Mekawdaity-title-cont-ajax input_section panel-field-<?=$option['to']?>"><?=$option['name']?></h1>
                                        <?php } ?>
    									<?php if  ( $option['type'] == 'text' ) { ?>
                                            <div class="input_section panel-field-<?=$option['to']?>" id="field-<?=$option['id']?>">
                                                <div class="all_options">
                                                    <div class="option_input option_select">
                                                        <label for="<?=$option['id']?>"><?=$option['name']?></label>
                                                        <div class="well">
    	                                                    <input class="regular-text" type="text" name="<?=$option['id']?>" value="<?=get_option($option['id'])?>">
                                                        </div>
                                                        <div class="clr"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } elseif  ( $option['type'] == 'textarea' ) { ?>
                                            <div class="input_section panel-field-<?=$option['to']?>" id="field-<?=$option['id']?>">
                                                <div class="all_options">
                                                    <div class="option_input option_select">
                                                        <label for="<?=$option['id']?>"><?=$option['name']?></label>
                                                        <div class="well">
    	                                                    <textarea id="textAreaBox" name="<?=$option['id']?>"><?=get_option($option['id'])?></textarea>
                                                        </div>
                                                        <div class="clr"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } elseif  ( $option['type'] == 'date' ) { ?>
                                            <div class="input_section panel-field-<?=$option['to']?>" id="field-<?=$option['id']?>">
                                                <div class="all_options">
                                                    <div class="option_input datepicker">
                                                        <label for="<?=$option['id']?>"><?=$option['name']?></label>
                                                        <div class="well">
                                                            <input type="text" data-beatpicker="true" value="<?=get_option($option['id'])?>" id="<?=$option['id']?>" name="<?=$option['id']?>">
                                                        </div>
                                                        <div class="clr"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } elseif  ( $option['type'] == 'color' ) { ?>
                                            <div class="input_section panel-field-<?=$option['to']?>" id="field-<?=$option['id']?>">
                                                <div class="all_options">
                                                    <div class="option_input datepicker">
                                                        <label for="<?=$option['id']?>"><?=$option['name']?></label>
                                                        <div class="well">
                                                            <input type="text" class="span2" value="<?=get_option($option['id'])?>" id="<?=$option['id']?>" name="<?=$option['id']?>">
                                                        </div>
                                                        <div class="clr"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } elseif  ( $option['type'] == 'select' ) { ?>
                                            <div class="input_section panel-field-<?=$option['to']?>" id="field-<?=$option['id']?>">
                                                <div class="all_options">
                                                    <div class="option_input datepicker">
                                                        <label for="<?=$option['id']?>"><?=$option['name']?></label>
                                                        <div class="well">
                                                            <select id="<?=$option['id']?>" data-live-search="true" name="<?=$option['id']?>">
                                                                <option value="" selected>Select from list</option>
                                                            	<?php foreach ( $option['options'] as $key => $opt ) { ?>
                                                                	<option <?php if ( get_option($option['id']) == $key ) { ?>selected<?php } ?> value="<?=$key?>"><?=$opt?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                        <div class="clr"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } elseif  ( $option['type'] == 'select_taxonomy' ) { ?>
                                            <div class="input_section panel-field-<?=$option['to']?>" id="field-<?=$option['id']?>">
                                                <div class="all_options">
                                                    <div class="option_input datepicker">
                                                        <label for="<?=$option['id']?>"><?=$option['name']?></label>
                                                        <div class="well">
                                                            <select id="<?=$option['id']?>" data-live-search="true" name="<?=$option['id']?>">
                                                                <option value="" selected>اختر من القائمه</option>
                                                            	<?php foreach ( get_categories( array( 'taxonomy'=>$option['tax'], 'hide_empty'=>0 ) ) as $opt ) { ?>
                                                                	<option <?php if ( get_option($option['id']) == $opt->term_taxonomy_id ) { ?>selected<?php } ?> value="<?=$opt->term_taxonomy_id?>"><?=$opt->cat_name?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                        <div class="clr"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } elseif  ( $option['type'] == 'upload' ) { ?>
                                            <div class="input_section panel-field-<?=$option['to']?>" id="field-<?=$option['id']?>">
                                                <div class="all_options">
                                                    <div class="option_input datepicker">
                                                        <label for="<?=$option['id']?>"><?=$option['name']?></label>
                                                        <div class="well">
                                                            <p>
                                                                <input class="<?=$option['id']?>_url" type="hidden" name="<?=$option['id']?>" size="60" value="<?=get_option($option['id']); ?>">
                                                                <a href="#" class="<?=$option['id']?>_upload btn button button-primary">رفع صوره</a>
                                                                <a style="margin-right: 10px" href="Javascript:void(0);" class="<?=$option['id']?>_remove button">ازالة الصورة</a>
    															<div style="margin-bottom:10px;"></div>
                                                                <img class="<?=$option['id']?>" src="<?=get_option($option['id']); ?>">
                                                            </p>
                                                        </div>
                                                        <div class="clr"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } elseif  ( $option['type'] == 'editor' ) { ?>
                                            <div class="input_section panel-field-<?=$option['to']?>" id="field-<?=$option['id']?>">
                                                <div class="all_options">
                                                    <div class="option_input datepicker">
                                                        <label for="<?=$option['id']?>"><?=$option['name']?></label>
                                                        <div class="well">
                                                            <?php 
                                                                $textarea_name = $option['id'];
                                                                $editor_id = $option['id'];
                                                                wp_editor( 
                                                                    get_option($option['id']), 
                                                                    $editor_id, 
                                                                    $settings = array( 
                                                                        'media_buttons' => false,
                                                                        'textarea_name' => $textarea_name,
                                                                        'quicktags' => true,
                                                                        'tinymce' => true,
                                                                        'textarea_rows' => 20,
    															    )
    														    ); 
    														?>
                                                        </div>
                                                        <div class="clr"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } elseif  ( $option['type'] == 'select_img' ) { ?>
                                            <div class="input_section panel-field-<?=$option['to']?>" id="field-<?=$option['id']?>"><div class="all_options">
                                                    <div class="option_input datepicker">
                                                        <label for="<?=$option['id']?>"><?=$option['name']?></label>
                                                        <div class="well select_imagespat <?=$option['id']?>-select">
                                                        	<input id="set-<?=$option['id']?>" type="hidden" name="<?=$option['id']?>" value="<?=get_option($option['id'])?>">
                                                            <?php foreach ( $option['images'] as $k => $img ) { ?>
                                                            	<?php if  ( get_option($option['id']) == $img ) { ?>
                                                                    <img class="current" id="<?=$option['id']?>-<?=$k?>" src="<?=$img?>">
                                                                <?php }else { ?>
                                                                    <img id="<?=$option['id']?>-<?=$k?>" src="<?=$img?>">
                                                                <?php } ?>
                                                                <script>
                                                                	$(document).ready(function(){
    																	$("img#<?=$option['id']?>-<?=$k?>").click(function(){
    																		$(".<?=$option['id']?>-select img").removeClass("current");
    																		$(this).addClass("current");
    																		$("#set-<?=$option['id']?>").val("<?=$img?>");
    																	});
    																});
                                                                </script>
                                                            <?php } ?>
                                                        </div>
                                                        <div class="clr"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } elseif  ( $option['type'] == 'fonts' ) { ?>
                                            <div class="input_section panel-field-<?=$option['to']?>" id="field-<?=$option['id']?>">
                                                <div class="all_options">
                                                    <div class="option_input datepicker">
                                                        <label for="<?=$option['id']?>"><?=$option['name']?></label>
                                                        <div class="well">
                                                        	<input id="<?=$option['id']?>"  data-live-search="true" name="<?=$option['id']?>" value="<?=get_option($option['id'])?>" type="text">
                                                        </div>
                                                        <div class="clr"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } elseif  ( $option['type'] == 'show_field' ) { ?>
                                            <div class="input_section panel-field-<?=$option['to']?>" id="field-<?=$option['id']?>">
                                                <div class="all_options">
                                                    <div class="option_input datepicker">
                                                        <label for="<?=$option['id']?>"><?=$option['name']?></label>
                                                        <div class="well">
                                                        	<input id="<?=$option['id']?>" name="<?=$option['id']?>" value="<?=get_option($option['id'])?>" type="checkbox">
                                                            <script>
                                                                $(document).ready(function() {
        															$("#field-<?=$option['show']?>").hide();
                                                                    $("#<?=$option['id']?>").click(function(){
        																$("#field-<?=$option['show']?>").toggleClass("show");
        															});
                                                                });
                                                            </script>
                                                        </div>
                                                        <div class="clr"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } elseif  ( $option['type'] == 'radio' ) { ?>
                                            <div class="input_section panel-field-<?=$option['to']?>" id="field-<?=$option['id']?>">
                                                <div class="all_options">
                                                    <div class="option_input datepicker">
                                                        <label for="<?=$option['id']?>"><?=$option['name']?></label>
                                                        <div class="well">
                                                        	<?php $ri = 0; ?>
                                                            <?php foreach ( $option['options'] as $key => $opt ) { ?>
                                                            	<div class="radio-item">
    	                                                            <input <?php if  ( get_option($option['id']) == $key ) { ?>checked<?php } ?> id="radio-<?=$ri?>-<?=$option['id']?>" name="<?=$option['id']?>" value="<?=$key?>" type="radio">
                                                                	<label for="radio-<?=$ri?>-<?=$option['id']?>"><?=$opt?></label>
                                                                    <div class="clr"></div>
                                                                </div>
                                                            <?php $ri++; } ?>
                                                        </div>
                                                        <div class="clr"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } elseif  ( $option['type'] == 'multicheck' ) { ?>
                                            <div class="input_section panel-field-<?=$option['to']?>" id="field-<?=$option['id']?>">
                                                <div class="all_options">
                                                    <div class="option_input datepicker">
                                                        <label for="<?=$option['id']?>"><?=$option['name']?></label>
                                                        <div class="well">
                                                        	<script>
                                                                $(document).ready(function(){
        															$(".checkall_<?=$option['id']?>").click(function(){
        																$(".check-item<?=$option['id']?> input").attr("checked",'checked');
        															});
        															$(".uncheckall_<?=$option['id']?>").click(function(){
        																$(".check-item<?=$option['id']?> input").removeAttr('checked');
        															});
        														});
                                                            </script>
                                                        	<a href="Javascript:void(0);" class="checkall_<?=$option['id']?> btn btn-primary">Check All</a>
                                                        	<a href="Javascript:void(0);" style="display:none;" class="uncheckall_<?=$option['id']?> btn btn-danger">UnCheck All</a>
                                                        	<?php $ri = 0; foreach ( $option['options'] as $key => $opt ) { ?>
                                                            	<div class="check-item<?=$option['id']?>">
    	                                                            <input <?php if ( in_array($key, get_option($option['id'])) ) { ?>checked<?php } ?> id="check-<?=$ri?>-<?=$option['id']?>" name="<?=$option['id']?>[]" value="<?=$key?>" type="checkbox">
                                                                	<label for="check-<?=$ri?>-<?=$option['id']?>"><?=$opt?></label>
                                                                    <div class="clr"></div>
                                                                </div>
                                                            <?php $ri++; } ?>
                                                        </div>
                                                        <div class="clr"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } elseif  ( $option['type'] == 'text_url' ) { ?>
                                            <div class="input_section panel-field-<?=$option['to']?>" id="field-<?=$option['id']?>">
                                                <div class="all_options">
                                                    <div class="option_input option_select">
                                                        <label for="<?=$option['id']?>"><?=$option['name']?></label>
                                                        <div class="well">
    	                                                    <input type="url" name="<?=$option['id']?>" value="<?=get_option($option['id'])?>">
                                                        </div>
                                                        <div class="clr"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } elseif  ( $option['type'] == 'time' ) { ?>
                                            <div class="input_section panel-field-<?=$option['to']?>" id="field-<?=$option['id']?>">
                                                <div class="all_options">
                                                    <div class="option_input datepicker">
                                                        <label for="<?=$option['id']?>"><?=$option['name']?></label>
                                                        <div class="well">
                                                            <input type="text" class="span2" value="<?=get_option($option['id'])?>" id="<?=$option['id']?>" name="<?=$option['id']?>">
                                                        </div>
                                                        <div class="clr"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } elseif  ( $option['type'] == 'timezone' ) { ?>
                                            <div class="input_section panel-field-<?=$option['to']?>" id="field-<?=$option['id']?>">
                                                <div class="all_options">
                                                    <div class="option_input datepicker">
                                                        <label for="<?=$option['id']?>"><?=$option['name']?></label>
                                                        <div class="well">
                                                            <select id="<?=$option['id']?>" value="<?=get_option($option['id'])?>" name="<?=$option['id']?>" class="form-control bfh-countries" data-country="EG"></select>
                                                        </div>
                                                        <div class="clr"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } elseif  ( $option['type'] == 'datetime' ) { ?>
                                            <div class="input_section panel-field-<?=$option['to']?>" id="field-<?=$option['id']?>">
                                                <div class="all_options">
                                                    <div class="option_input datepicker">
                                                        <label for="<?=$option['id']?>"><?=$option['name']?></label>
                                                        <div class="well">
                                                        	<?php $opt = get_option($option['id']); ?>
                                                            <input type="text" data-date-format="mm/dd/yy" value="<?=$opt['date']?>" id="date-<?=$option['id']?>" name="<?=$option['id']?>[date]">
                                                            <input type="text" value="<?=$opt['time']?>" id="time-<?=$option['id']?>" name="<?=$option['id']?>[time]">
                                                        </div>
                                                        <div class="clr"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } elseif  ( $option['type'] == 'textarea_html' ) { ?>
                                            <div class="input_section panel-field-<?=$option['to']?>" id="field-<?=$option['id']?>">
                                                <div class="all_options">
                                                    <div class="option_input datepicker">
                                                        <label for="<?=$option['id']?>"><?=$option['name']?></label>
                                                        <div class="well">
                                                            <textarea name="<?=$option['id']?>"><?=get_option($option['id'])?></textarea>
                                                        </div>
                                                        <div class="clr"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } elseif  ( $option['type'] == 'textarea_css' ) { ?>
                                            <div class="input_section panel-field-<?=$option['to']?>" id="field-<?=$option['id']?>">
                                                <div class="all_options">
                                                    <div class="option_input datepicker">
                                                        <label for="<?=$option['id']?>"><?=$option['name']?></label>
                                                        <div class="well">
                                                        	<pre dir="ltr">
    	                                                    	<textarea name="<?=$option['id']?>"><?=get_option($option['id'])?></textarea>
                                                            </pre>
                                                        </div>
                                                        <div class="clr"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } elseif  ( $option['type'] == 'radio_taxonomy' ) { ?>
                                            <div class="input_section panel-field-<?=$option['to']?>" id="field-<?=$option['id']?>">
                                                <div class="all_options">
                                                    <div class="option_input datepicker">
                                                        <label for="<?=$option['id']?>"><?=$option['name']?></label>
                                                        <div class="well">
                                                        	<?php $ri = 0; ?>
                                                            <?php foreach ( get_categories( array( 'taxonomy' => $option['tax'] , 'hide_empty' => 0 ) ) as $key => $opt ) { ?>
                                                            	<div class="radio-item">
    	                                                            <input <?php if  (get_option($option['id']) == $opt->term_id ) { ?>checked<?php } ?> id="radio-<?=$opt->term_id?>-<?=$option['id']?>" name="<?=$option['id']?>" value="<?=$opt->term_id?>" type="radio">
                                                                	<label for="radio-<?=$opt->term_id?>-<?=$option['id']?>"><?=$opt->cat_name?></label>
                                                                <div class="clr"></div>
                                                                </div>
                                                            <?php $ri++; } ?>
                                                        </div>
                                                        <div class="clr"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } elseif  ( $option['type'] == 'multi_taxonomy' ) { ?>
                                            <div class="input_section panel-field-<?=$option['to']?>" id="field-<?=$option['id']?>">
                                                <div class="all_options">
                                                    <div class="option_input datepicker">
                                                        <label for="<?=$option['id']?>"><?=$option['name']?></label>
                                                        <div class="well">
                                                        	<script>
                                                                $(document).ready(function(){
        															$(".checkall_<?=$option['id']?>").click(function(){
        																$(".check-item<?=$option['id']?> input").attr("checked",'checked');
        																$(".checkall_<?=$option['id']?>").hide();
        																$(".uncheckall_<?=$option['id']?>").show();
        															});
        															$(".uncheckall_<?=$option['id']?>").click(function(){
        																$(".check-item<?=$option['id']?> input").removeAttr('checked');
        																$(".uncheckall_<?=$option['id']?>").hide();
        																$(".checkall_<?=$option['id']?>").show();
        															});
        														});
                                                            </script>
                                                            <a href="Javascript:void(0);" style="margin-bottom: 10px;" class="checkall_<?=$option['id']?> btn btn-primary">Check All</a>
                                                        	<a href="Javascript:void(0);" style="display:none; margin-bottom: 10px;" class="uncheckall_<?=$option['id']?> btn btn-danger">UnCheck All</a>
                                                        	<?php $ri = 0; foreach ( get_categories( array( 'taxonomy'=>$option['tax'], 'hide_empty'=>0 ) ) as $key => $opt ) { ?>
                                                            	<div class="check-item<?=$option['id']?>">
    	                                                            <input <?php if  (in_array($opt->term_id, get_option($option['id'])) ) { ?>checked<?php } ?> id="check-<?=$opt->term_id?>-<?=$option['id']?>" name="<?=$option['id']?>[]" value="<?=$opt->term_id?>" type="checkbox">
                                                                	<label for="check-<?=$opt->term_id?>-<?=$option['id']?>"><?=$opt->cat_name?></label>
                                                                <div class="clr"></div>
                                                                </div>
                                                            <?php $ri++; } ?>
                                                        </div>
                                                        <div class="clr"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    <?php } ?>
                                    <input class="button" style="margin: 10px" type="submit" name="save" value="حفظ">
                                    <?php
                                        if  ( isset( $_POST['save'] ) ) {
                                            if  ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
                                                foreach ( $options as $option ) {
                                                    if ( $option['type'] !== 'tab' ) {
                                                        update_option ( $option['id'] , $_POST[$option['id'] ] );
                                                    }
                                                }
                                            }
                                        }
                                    ?>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clr"></div>
            <div class="Mekawdaity-footer">
                <span>من اعمال : <a href="http://www.mekawdaity.net/">El Mekawdaity | المكوداتى</a></span>
            </div>   
        </div>
        <?php foreach ( $options as $option ) { ?>
            <?php if ( $option['type'] == 'upload' ) { ?>
                <script>
                    $(document).ready(function() {
                        $('.<?=$option['id']?>_upload').click(function(e) {
                            e.preventDefault();
                            MyUploader = wp.media({
                                title: '<?=$option['name']?>',
                                button: { text: 'رفع صورة' },
                                multiple: false,
                            })
                            .on('select', function() {
                                var attachment = MyUploader.state().get('selection').first().toJSON();
                                $('.<?=$option['id']?>').attr('src', attachment.url);
                                $('.<?=$option['id']?>_url').val(attachment.url);
                                $('.<?=$option['id']?>_remove').show();
                            })
                            .open();
                        });
                        $(".<?=$option['id']?>_remove").click(function(){
                            $('.<?=$option['id']?>').attr('src', "");
                            $('.<?=$option['id']?>_url').val("");
                            $('.<?=$option['id']?>_remove').hide();
                        });
                    });
                </script>
            <?php } ?>
        <?php } ?>
    <?php
    } 
?>