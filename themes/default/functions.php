<?php
wp_enqueue_script('jquery');
wp_enqueue_script('jquery_validate', get_template_directory_uri() . '/js/jquery.validate.js');
if (function_exists('add_theme_support')) {
    add_theme_support('post-thumbnails');
}
add_filter('show_admin_bar', '__return_false');

// Get theme custom preferences
$site_title = get_option('mobilecomply_site_title');
$landing_page = get_option('mobilecomply_landing_page');
$phone_number = get_option('mobilecomply_phone_number');
$google_map_code = get_option('mobilecomply_google_map_code');
$contact_page = get_option('mobilecomply_contact_page');
$logo_url = get_option('mobilecomply_logo_url');
$footer_copyright = get_option('mobilecomply_footer_copyright');
$footer_javascript = get_option('mobilecomply_footer_javascript');
$opt_in_page_id = get_option('mobilecomply_mobile_opt_in');

$background_color = get_option('mobilecomply_background_color');
$background_image_url = get_option('mobilecomply_background_image_url');

// Header preferences
$header_font_family = get_option('mobilecomply_header_font_family');
$header_font_size = get_option('mobilecomply_header_font_size');
$header_font_size_unit = get_option('mobilecomply_header_font_size_unit');
$header_font_color = get_option('mobilecomply_header_font_color');
$header_background_color = get_option('mobilecomply_header_background_color');

// Toolbar preferences
$toolbar_background_color = get_option('mobilecomply_toolbar_background_color');
$toolbar_button_color = get_option('mobilecomply_toolbar_button_color');
$toolbar_button_font_family = get_option('mobilecomply_toolbar_button_font_family');
$toolbar_button_font_color = get_option('mobilecomply_toolbar_button_font_color');
$footer_copyright_font_color = get_option('mobilecomply_footer_copyright_font_color');
$show_top_toolbar = get_option('mobilecomply_show_top_toolbar');
$show_top_toolbar_search = get_option('mobilecomply_show_top_toolbar_search');
$show_footer_toolbar = get_option('mobilecomply_show_footer_toolbar');

// Menu preferences
$menu_font_family = get_option('mobilecomply_menu_font_family');
$menu_font_size = get_option('mobilecomply_menu_font_size');
$menu_font_size_unit = get_option('mobilecomply_menu_font_size_unit');
$menu_font_color = get_option('mobilecomply_menu_font_color');
$menu_background_color = get_option('mobilecomply_menu_background_color');

$hsl = _color_rgb2hsl(_color_unpack($menu_background_color));
$hsl[2] -= 30;
$menu_background_color_light = _color_pack(_color_hsl2rgb($hsl));
$menu_background_color_light = substr($menu_background_color_light, 1);

// Content preferences
$content_font_family = get_option('mobilecomply_content_font_family');
$content_font_size = get_option('mobilecomply_content_font_size');
$content_font_size_unit = get_option('mobilecomply_content_font_size_unit');
$content_font_color = get_option('mobilecomply_content_font_color');
$content_link_color = get_option('mobilecomply_content_link_color');

$logo_width = 0;
$logo_height = 0;
$logo_margin_left = 0;
$logo_margin_top = 0;
if ($logo_url) {
    list($logo_width, $logo_height) = getimagesize(convertUrlToPath($logo_url));
    if ($logo_height > MC_MAX_LOGO_HEIGHT) {
        $logo_width = intval($logo_width * MC_MAX_LOGO_HEIGHT / $logo_height);
        $logo_height = MC_MAX_LOGO_HEIGHT;
    }

    if ($logo_width > MC_MAX_LOGO_WIDTH) {
        $logo_height = intval($logo_height * MC_MAX_LOGO_WIDTH / $logo_width);
        $logo_width = MC_MAX_LOGO_WIDTH;
    }

    $logo_margin_left = intval((MC_MAX_LOGO_WIDTH - $logo_width) / 2) + 20;
    $logo_margin_top = intval((MC_MAX_LOGO_HEIGHT - $logo_height) / 2);
}

$commenter = wp_get_current_commenter();
$req = get_option('require_name_email');
$aria_req = ( $req ? " aria-required='true'" : '' );

$admin_form_args = array(
    'fields' => array(
        'author' => '<p class="comment-form-author">' . '<label for="author">' . __('Name') . '</label> ' .
        '<input id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="30"' . $aria_req . ' />' . ( $req ? '<span class="required">*</span>' : '' ) . '</p>',
        'email' => '<p class="comment-form-email"><label for="email">' . __('Email') . '</label> ' .
        '<input id="email" name="email" type="text" value="' . esc_attr($commenter['comment_author_email']) . '" size="30"' . $aria_req . ' />' . ( $req ? '<span class="required">*</span>' : '' ) . '</p>',
        'url' => '<p class="comment-form-url"><label for="url">' . __('Website') . '</label>' .
        '<input id="url" name="url" type="text" value="' . esc_attr($commenter['comment_author_url']) . '" size="30" /></p>',
    )
);

$sidebars_widgets = wp_get_sidebars_widgets();
if ($sidebars_widgets) {
    foreach ($sidebars_widgets as $sidebar_id => $sidebar_widgets) {
        if ($sidebar_id != 'wp_inactive_widgets') {
            register_sidebar(array(
                'name' => $sidebar_id,
                'id' => $sidebar_id,
                'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                'after_widget' => "</aside>",
                'before_title' => '<h3 class="widget-title">',
                'after_title' => '</h3>',
            ));
        }
    }
}

$oMCWpError = new WP_Error();

// Save opt in data
$sOptInSuccess = '';
if (isset ($_SESSION['mc_opt_in_success'])) {
    $sOptInSuccess =  $_SESSION['mc_opt_in_success'];
    unset ($_SESSION['mc_opt_in_success']);
}

function saveOptInData() {
    global $oMCWpError, $contact_page, $opt_in_page_id;
    
    if (isset ($_POST['submit_opt_in'])
    && isset ($_POST['opt_in_name'])
    && isset ($_POST['opt_in_mobile_number'])
    && isset ($_POST['opt_in_email'])
    && isset ($_POST['receive_mobile_offers'])) {        
        $oMobilecomplyOptIn = new MobilecomplyOptIn();
        
        if (empty ($_POST['opt_in_name'])) {
            $oMCWpError->add(1000, 'Please, fill in name field.');
        }

        if (empty ($_POST['opt_in_mobile_number'])) {
            $oMCWpError->add(1000, 'Please, fill in mobile number field.');
        }

        if (empty ($_POST['opt_in_email'])) {
            $oMCWpError->add(1000, 'Please, fill in e-mail field.');
        }
        
        if ($oMobilecomplyOptIn->isUserRegisteredWithEmail($_POST['opt_in_email'])) {
            $oMCWpError->add(1000, 'User with such e-mail is already registered in system.');
        }

        if (!$oMCWpError->get_error_messages()) {
            $aNewOptInUser = array(
                'opt_in_name' => $_POST['opt_in_name'],
                'opt_in_mobile_phone' => $_POST['opt_in_mobile_number'],
                'opt_in_email' => $_POST['opt_in_email'],
                'visitor_id' => MobilecomplyTracking::getCurrentVisitorId(),
                'opt_in_date' => current_time('mysql'),
                'opt_in_receive_mobile_offers' => $_POST['receive_mobile_offers']
            );

            $oMobilecomplyOptIn->addNewOptInUser($aNewOptInUser);

            $sMessage = '';
            if ($_POST['receive_mobile_offers']) {
                $_SESSION['mc_opt_in_success'] = 'Thank you for your registration for mobile offers!';
                $sMessage = 'Yes';
            } else {
                $_SESSION['mc_opt_in_success'] = 'We are sorry you selected not to receive mobile offers. If you change your mind please email us!';
                
                if ($contact_page) {
                    $_SESSION['mc_opt_in_success'] .= ' <a href="' . get_permalink($contact_page) . '">' . get_the_title($contact_page) . '</a>';
                }
                
                $sMessage = 'No';
            }
                        
            mail($_POST['opt_in_email'], 'Registration result', $sMessage);
            
            wp_redirect(get_permalink($opt_in_page_id));
            exit();
        } else {
            $oMCWpError->add_data($_POST, '1000');
        }
    }
}
add_action('mc_track', 'saveOptInData');

/**
 * Displays posts navigation(previous|next links)
 */
function posts_navigation() {
    global $wp_query;

    if ($wp_query->max_num_pages > 1) :
        $next_link = get_next_posts_link(__('<span class="meta-nav">&larr;</span> Older posts', 'piraeus'));
        $prev_link = get_previous_posts_link(__('Newer posts <span class="meta-nav">&rarr;</span>', 'piraeus'));
        ?>
        <nav>
            <?php
            if ($next_link) {
                ?>
                <div class="nav-previous"><?php echo $next_link ?></div>
                <?php
            }

            if ($prev_link) {
                ?>
                <div class="nav-next"><?php echo $prev_link; ?></div>
                <?php
            }
            ?>
            <div class="clear"></div>
        </nav><!-- #nav-above -->
        <?php
    endif;
}

function wpr_snap($atts, $content = null) {
    extract(shortcode_atts(array(
                'snap' => 'http://s.wordpress.com/mshots/v1/',
                'url' => '',
                'alt' => 'Хабр',
                'w' => '400',
                'h' => '300'
                    ), $atts));
    $img = '<img 
                src="' . $snap . '' . urlencode($url) . '?w=' . $w . '&h=' . $h . '" 
                alt="' . $alt . '"/>';
    return $img;
}

add_shortcode('snap', 'wpr_snap');

/**
 * Indicates if there is need to show opt in form
 * 
 * @return boolean
 */
function showOptInForm() {
    $oMobilecomplyOptIn = new MobilecomplyOptIn();
    $iVisitorId = MobilecomplyTracking::getCurrentVisitorId();
    
    return !$oMobilecomplyOptIn->isVisitorRegistered($iVisitorId);
}

if (!function_exists('get_post_format')) {

    /**
     * Retrieve the format slug for a post
     *
     * @since 3.1.0
     *
     * @param int|object $post A post
     *
     * @return mixed The format if successful. False if no format is set.  WP_Error if errors.
     */
    function get_post_format($post = null) {
        $post = get_post($post);

        $format_slug = 'post';
        if (is_page($post->ID)) {
            $format_slug = 'page';
        }

        return ( str_replace('post-format-', '', $format_slug) );
    }

}

if (!function_exists('wp_nav_menu')) {

    function wp_nav_menu($args = array()) {
        $pages = get_pages();
        ?>
        <ul>
            <?php
            foreach ($pages as $page) {
                ?>
                <li>
                    <a href="<?php echo get_permalink($page->ID); ?>">
                        <?php echo get_the_title($page->ID); ?>
                    </a>
                </li>
                <?php
            }
            ?>
        </ul>
        <?php
    }

}

if (!function_exists('get_the_author_link')) {

    /**
     * Retrieve either author's link or author's name.
     *
     * If the author has a home page set, return an HTML link, otherwise just return the
     * author's name.
     *
     * @uses get_the_author_meta()
     * @uses get_the_author()
     */
    function get_the_author_link() {
        if (get_the_author_meta('url')) {
            return '<a href="' . get_the_author_meta('url') . '" title="' . esc_attr(sprintf(__("Visit %s&#8217;s website"), get_the_author())) . '" rel="external">' . get_the_author() . '</a>';
        } else {
            return get_the_author();
        }
    }

}

if (!function_exists('comment_form')) {

    function comment_form() {
        if (comments_open()) :
            $req = get_option('require_name_email');
            $aria_req = ( $req ? " aria-required='true'" : '' );

            extract(wp_get_current_commenter());
            ?>
            <div id="respond">
                <h3><?php comment_form_title('Leave a Reply', 'Leave a Reply to %s'); ?></h3>

                <div class="cancel-comment-reply">
                    <small><?php cancel_comment_reply_link(); ?></small>
                </div>

                <?php
                if (get_option('comment_registration') && !is_user_logged_in()) :
                    ?>
                    <p>You must be <a href="<?php echo wp_login_url(get_permalink()); ?>">logged in</a> to post a comment.</p>
                    <?php
                else :
                    ?>
                    <form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
                        <?php
                        if (is_user_logged_in()) :
                            ?>
                            <p>Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="Log out of this account">Log out &raquo;</a></p>
                            <?php
                        else :
                            ?>
                            <p><input type="text" name="author" id="author" value="<?php echo esc_attr($comment_author); ?>" size="22" tabindex="1" <?php if ($req)
                        echo "aria-required='true'"; ?> />
                                <label for="author"><small>Name <?php if ($req)
                        echo "(required)"; ?></small></label></p>

                            <p><input type="text" name="email" id="email" value="<?php echo esc_attr($comment_author_email); ?>" size="22" tabindex="2" <?php if ($req)
                        echo "aria-required='true'"; ?> />
                                <label for="email"><small>Mail <?php if ($req)
                        echo "(required)"; ?></small></label></p>

                            <p><input type="text" name="url" id="url" value="<?php echo esc_attr($comment_author_url); ?>" size="22" tabindex="3" />
                                <label for="url"><small>Website</small></label></p>
                        <?php
                        endif;
                        ?>

                                        <!--<p><small><strong>XHTML:</strong> You can use these tags: <code><?php echo allowed_tags(); ?></code></small></p>-->

                        <p><textarea name="comment" id="comment" cols="50" rows="10" tabindex="4"></textarea></p>

                        <p><input name="submit" type="submit" id="submit" tabindex="5" value="Submit Comment" />
                        <?php comment_id_fields(); ?>
                        </p>
                        <?php
                        global $post;
                        do_action('comment_form', $post->ID);
                        ?>

                    </form>

            <?php endif; // If registration required and not logged in     ?>
            </div>
            <?php
        endif;
    }

}

if (!function_exists('get_the_date')) {

    /**
     * Retrieve the date the current $post was written.
     *
     * Unlike the_date() this function will always return the date.
     * Modify output with 'get_the_date' filter.
     *
     * @since 3.0.0
     *
     * @param string $d Optional. PHP date format defaults to the date_format option if not specified.
     * @return string|null Null if displaying, string if retrieving.
     */
    function get_the_date($d = '') {
        global $post;
        $the_date = '';

        if ('' == $d)
            $the_date .= mysql2date(get_option('date_format'), $post->post_date);
        else
            $the_date .= mysql2date($d, $post->post_date);

        return apply_filters('get_the_date', $the_date, $d);
    }

}