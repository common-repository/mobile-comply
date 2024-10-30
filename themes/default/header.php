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
global $page, $paged;

wp_title('|', true, 'right');

// Add the blog name.
bloginfo('name');

// Add the blog description for the home/front page.
$site_description = get_bloginfo('description', 'display');
if ($site_description && ( is_home() || is_front_page() ))
    echo " | $site_description";

// Add a page number if necessary:
if ($paged >= 2 || $page >= 2)
    echo ' | ' . sprintf(__('Page %s', 'twentyeleven'), max($paged, $page));
?></title>
        <link rel="profile" href="http://gmpg.org/xfn/11" />
        <link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('stylesheet_url'); ?>" />
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
        <!--[if lt IE 9]>
        <script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
        <![endif]-->
        <?php
        /* We add some JavaScript to pages with the comment form
         * to support sites with threaded comments (when in use).
         */
        if (is_singular() && get_option('thread_comments'))
            wp_enqueue_script('comment-reply');

        /* Always have wp_head() just before the closing </head>
         * tag of your theme, or you will break many plugins, which
         * generally use this hook to add elements to <head> such
         * as styles, scripts, and meta tags.
         */
        wp_head();
        ?>
        <style>
            body {
                background-color: #<?php echo $background_color; ?>;
                <?php
                if ($background_image_url) {
                    ?>
                    background-image: url('<?php echo $background_image_url; ?>');
                    <?php
                }
                ?>
            }
            
            #header img {
                width: <?php echo $logo_width; ?>px;
                margin-left: <?php echo $logo_margin_left; ?>px;
                margin-top: <?php echo $logo_margin_top; ?>px;
            }
            
            #header {
                font-family: '<?php echo $header_font_family; ?>';
                color: #<?php echo $header_font_color; ?>;
                background-color: #<?php echo $header_background_color; ?>;
            }
            
            #header_site_title td h1 {
                font-size: <?php echo $header_font_size . $header_font_size_unit; ?>;
                font-family: '<?php echo $header_font_family; ?>';
            }
            
            #top_bar {
                background-color: #<?php echo $toolbar_background_color; ?>;
            }
            
            #primary_menu,
            #opt_in_form {
                background: -webkit-gradient(linear, left top, left bottom, from(#<?php echo $menu_background_color; ?>), to(#<?php echo $menu_background_color_light; ?>));
                background: -moz-linear-gradient(top,#<?php echo $menu_background_color; ?>,#<?php echo $menu_background_color_light; ?>);
            }
            
            #primary_menu ul li a {
                font-family: '<?php echo $menu_font_family; ?>';
                font-size: <?php echo $menu_font_size . $menu_font_size_unit; ?>;
                color: #<?php echo $menu_font_color; ?>;
            }
            
            #top_bar .active {
                background-color: #<?php echo $menu_background_color; ?> !important;
            }
            
            #main a, 
            #main .post_single .entry-title,
            #main .page .entry-title,
            #footer_copyright a {
                color: #<?php echo $content_link_color; ?>;
            }
            
            #main {
                color: #<?php echo $content_font_color; ?>;
                font-size: <?php echo $content_font_size . $content_font_size_unit; ?>;
                font-family: '<?php echo $content_font_family; ?>';
            }
			
			#opt_in_form {
				color: #<?php echo $content_font_color; ?>;
                font-family: '<?php echo $content_font_family; ?>';
			}
            
            #footer {
                background-color: #<?php echo $toolbar_background_color; ?>;
            }
            
            input[type="button"],
            input[type="submit"],
            .button,
            #navigation_button,
            #main .post .date {
                font-family: '<?php echo $toolbar_button_font_family; ?>' !important;
                background-color: #<?php echo $toolbar_button_color; ?> !important;
                color: #<?php echo $toolbar_button_font_color; ?> !important;
            }
            
            #top_search .text input {
                font-family: '<?php echo $header_font_family; ?>' !important;
            }
            
            #navigation_button .triangle {
                border-top: 9px solid #<?php echo $toolbar_button_color; ?>;
            }
            
            #main .post .date .triangle {
                border-left: 9px solid #<?php echo $toolbar_button_color; ?>;
            }
            
            #footer_copyright {
                color: #<?php echo $footer_copyright_font_color; ?>;
                font-family: '<?php echo $toolbar_button_font_family; ?>' !important;
            }
        </style>
        <script type="text/javascript">
            jQuery(function(){
                jQuery('#navigation_button').click(function(eventObject){
                    eventObject.preventDefault();
                    
                    if (!jQuery(this).hasClass('active')) {
                        jQuery(this).addClass('active');
                        jQuery('#primary_menu').show();
                    } else {
                        jQuery(this).removeClass('active');
                        jQuery('#primary_menu').hide();
                    }
                });
                
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
            <header id="header">
                <table id="header_site_title">
                    <tr>
                        <td>
                            <h1><?php echo $site_title; ?></h1>
                        </td>
                    </tr>
                </table>
                <?php
                if ($logo_url) {
                    ?>
                    <a href="<?php echo home_url(); ?>">
                        <img src="<?php echo $logo_url; ?>" alt="<?php echo $site_title; ?>"/>
                    </a>
                    <?php
                }
                ?>
            </header><!-- #header -->
            <?php
            if ($show_top_toolbar) {
                ?>
                <div id="top_bar">
                    <?php
                    if ($show_top_toolbar_search) {
                        ?>
                        <div id="top_search">
                            <form action="<?php echo get_home_url(); ?>" method="get">
                                <div class="text">
                                    <input type="text" name="s" value=""/>
                                </div>
                                <input type="submit" name="search" value="<?php echo esc_attr__('Search'); ?>" class="button"/>
                            </form>
                        </div>
                        <?php
                    }
                    ?>

                    <a href="#" id="navigation_button">
                        Navigation
                        <span class="triangle"></span>
                        <span class="triangle_shadow"></span>
                    </a>
                    <div id="primary_menu">
                        <?php wp_nav_menu(); ?>
                    </div>
                    <div class="clear"></div>
                </div>
                <?php
            }
            ?>

            <div id="main">