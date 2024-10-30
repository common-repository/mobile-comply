<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */
global $site_title, 
        $logo_url,
        $logo_width,
        $logo_margin_left,
        $logo_margin_top,
        $opt_in_page_id,
        $header_font_family, 
        $header_font_size, 
        $header_font_size_unit, 
        $header_font_color,
        $header_background_color,
        $toolbar_background_color,
        $toolbar_button_color,
        $toolbar_button_font_family,
        $toolbar_button_font_color,
        $footer_copyright_font_color,
        $show_top_toolbar,
        $show_top_toolbar_search,
        $menu_font_family,
        $menu_font_size,
        $menu_font_size_unit,
        $menu_font_color,
        $menu_background_color,
        $menu_background_color_light,
        $content_font_family,
        $content_font_size,
        $content_font_size_unit,
        $content_font_color,
        $content_link_color,
        $background_color,
        $background_image_url,
        $oMCWpError;
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo('charset'); ?>" />
        <meta name="viewport" content="width=640" />
        <title><?php
/*
 * Print the <title> tag based on what is being viewed.
 */
wp_title('|', true, 'right');

// Add the blog name.
bloginfo('name');

// Add the blog description for the home/front page.
$site_description = get_bloginfo('description', 'display');
if ($site_description && ( is_home() || is_front_page() ))
    echo " | $site_description";

?></title>
        <link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('stylesheet_url'); ?>" />
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
        <?php
        wp_head();
        ?>
        <style>
			#splash_screen {
				background-color: #<?php echo $header_background_color; ?>;
			}
			
			#page {
				background-color: #<?php echo $background_color; ?>;
			}
            
            #header {
                font-family: '<?php echo $header_font_family; ?>';
                color: #<?php echo $header_font_color; ?>;
                background-color: #<?php echo $header_background_color; ?>;
            }
            
			#select_a_page{
				font-family: '<?php echo $header_font_family; ?>';
				font-size: <?php echo $header_font_size . $header_font_size_unit; ?>;
				color: #<?php echo $header_font_color; ?>;
				background-color: #<?php echo $menu_background_color; ?>;
			}
			
			#list_header {
				font-family: '<?php echo $header_font_family; ?>';
				font-size: <?php echo $header_font_size . $header_font_size_unit; ?>;
				color: #<?php echo $menu_font_color; ?>;
				background-color: #<?php echo $menu_background_color; ?>;
			}
			
			#navigation {
				background-color: #<?php echo $background_color; ?>;
			}
			
			#navigation .menu_item a {
				font-family: '<?php echo $header_font_family; ?>';
				color: #<?php echo $menu_font_color; ?>;
			}
			
			#navigation .menu_item_title a {
				font-size: <?php echo $header_font_size . $header_font_size_unit; ?>;
			}
         
			#navigation .menu_item:hover {
				background-color: #<?php echo $header_background_color; ?>;
			}
			
			#navigation .menu_item:hover a{
				color: #<?php echo $header_font_color; ?>;
			}
            
            #main {
                color: #<?php echo $content_font_color; ?>;
                font-size: <?php echo $content_font_size . $content_font_size_unit; ?>;
                font-family: '<?php echo $content_font_family; ?>';
            }
			
			#opt_in_form {
				color: #<?php echo $content_font_color; ?>;
                font-family: '<?php echo $content_font_family; ?>';
				background: -webkit-gradient(linear, left top, left bottom, from(#<?php echo $menu_background_color; ?>), to(#<?php echo $menu_background_color_light; ?>));
                background: -moz-linear-gradient(top,#<?php echo $menu_background_color; ?>,#<?php echo $menu_background_color_light; ?>);
			}
			
			#content .post {
				background-color: #<?php echo $menu_background_color; ?>;
			}
			
			#content .post_title a, #content .post_title {
				color: #<?php echo $toolbar_button_font_color; ?>;
				font-size: <?php echo $content_font_size . $content_font_size_unit; ?>;
                font-family: '<?php echo $toolbar_button_font_family; ?>';
			}
			
			#content .post_description, #content .post_content {
				color: #<?php echo $content_font_color; ?>;
				font-size: <?php echo $content_font_size . $content_font_size_unit; ?>;
                font-family: '<?php echo $content_font_family; ?>';
			}
			
			#content .post_description a, #content .post_content a {
				color: #<?php echo $content_link_color; ?>;
			}
			
			.jspDrag {
				background-image: url('<?php echo get_theme_root_uri() .'/new/images/scroller.png' ?>');
			}
        </style>
		
		<script src="<?php echo get_theme_root_uri() . '/new/js/jquery.mousewheel.js'?>" type="text/javascript"></script>
		<script src="<?php echo get_theme_root_uri() . '/new/js/jquery.jscrollpane.min.js'?>" type="text/javascript"></script>
		<script type="text/javascript">
			jQuery(function($)
			{
				jQuery('*').load(function() {
					jQuery('#page').show();
					jQuery('#splash_screen').hide();
				});
				jQuery('#navigation,#content').jScrollPane({
					verticalDragMinHeight: 240,
					verticalDragMaxHeight: 240
				});
				jQuery('#page').hide();
				jQuery('#opt_in_form form').validate();
                
                var width = jQuery(window).width() - 46;
                var height = jQuery(window).height() - 58;
                jQuery('#opt_in_form').css({
                    width: width,
                    height: height
                }).fadeOut(0).fadeIn(1000);
				jQuery('#opt_in_form #cancel_opt_in').click(function(){
					jQuery('#opt_in_form').hide();
				})
			});
		</script>
    </head>

    <body <?php body_class(); ?>>
		<div id="splash_screen">
			<?php
				if ($logo_url) {
                    ?>
                        <img src="<?php echo $logo_url; ?>" alt="<?php echo $site_title; ?>"/>
                    <?php
                }
            ?>
			<p>Loading.....</p>
		</div>
        <div id="page">
		 <?php
            if (is_page($opt_in_page_id) && showOptInForm()) {
                $form_values = $oMCWpError->get_error_data();
                
                $receive_mobile_offers = isset ($form_values['receive_mobile_offers']) ? $form_values['receive_mobile_offers'] : 0;
                $opt_in_name = isset ($form_values['opt_in_name']) ? $form_values['opt_in_name'] : '';
                $opt_in_mobile_number = isset ($form_values['opt_in_mobile_number']) ? $form_values['opt_in_mobile_number'] : '';
                $opt_in_email = isset ($form_values['opt_in_email']) ? $form_values['opt_in_email'] : '';
                ?>
                <div id="opt_in_form">
                    <div class="arrow"></div>
                    <form action="<?php the_permalink($opt_in_page_id); ?>" method="post">
                        Would you like to receive mobile offers?
                        <br/>
                        <input type="radio" name="receive_mobile_offers" value="0" <?php if (!$receive_mobile_offers) { echo 'checked="checked"'; } ?> id="receive_mobile_offers_no"/> 
                        <label for="receive_mobile_offers_no">No</label>
                        <input type="radio" name="receive_mobile_offers" value="1" <?php if ($receive_mobile_offers) { echo 'checked="checked"'; } ?> id="receive_mobile_offers_yes"/> 
                        <label for="receive_mobile_offers_yes">Yes</label>
                        <br/><br/>
                        Please provide the following information:
                        <br/><br/>
                        <?php
                        if ($error_messages = $oMCWpError->get_error_messages(1000)) {
                            ?>
                            <div class="error">
                                <?php echo implode('<br/>', $error_messages); ?>
                            </div><br/>
                            <?php
                        }
                        ?>
                        <label for="opt_in_name">Name:</label>
                        <br/>
                        <input type="text" name="opt_in_name" value="<?php echo $opt_in_name; ?>" class="required" id="opt_in_name"/>
                        <br/><br/>
                        <label for="opt_in_mobile_number">Mobile Number:</label>
                        <br/>
                        <input type="tel" name="opt_in_mobile_number" value="<?php echo $opt_in_mobile_number; ?>" class="required" id="opt_in_mobile_number"/>
                        <br/><br/>
                        <label for="opt_in_email">Email Address:</label>
                        <br/>
                        <input type="email" name="opt_in_email" value="<?php echo $opt_in_email; ?>" class="required email" id="opt_in_email" autocorrect="off"/>
                        <br/><br/>
                        <input type="hidden" name="submit_opt_in" value=""/>
                        <input type="submit" name="submit_opt_in" value="Submit" class="submit" id="submit_opt_in"/>
						<input type="button" value="Cancel" id="cancel_opt_in"/>
                    </form>
                </div>
                <?php
            }
            ?>
		<div id="header">
                <?php
				if ($logo_url) {
                    ?>
                    <a href="<?php echo home_url(); ?>">
                        <img src="<?php echo $logo_url; ?>" alt="<?php echo $site_title; ?>"/>
                    </a>
                    <?php
                }
            ?>
		</div>
		<div id = "main">