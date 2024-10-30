<style>
    #iphone_container.default {
        background-color: #<?php echo $background_color; ?>;
        background-image: url('<?php echo $background_image_url; ?>');
    }

    #iphone_container.default #header img {
        width: <?php echo $logo_width; ?>px;
        margin-left: <?php echo $logo_margin_left; ?>px;
        margin-top: <?php echo $logo_margin_top; ?>px;
    }

    #iphone_container.default #header {
        font-family: '<?php echo $header_font_family; ?>';
        color: #<?php echo $header_font_color; ?>;
        background-color: #<?php echo $header_background_color; ?>;
    }

    #iphone_container.default #header_site_title td h1 {
        font-size: <?php echo $header_font_size . $header_font_size_unit; ?>;
        font-family: '<?php echo $header_font_family; ?>';
    }

    #iphone_container.default #top_bar {
        background-color: #<?php echo $toolbar_background_color; ?>;
    }

    #iphone_container.default div#primary_menu{
        background: -webkit-gradient(linear, left top, left bottom, from(#<?php echo $menu_background_color; ?>), to(#<?php echo $menu_background_color_light; ?>));
		background: -moz-linear-gradient(top,#<?php echo $menu_background_color; ?>,#<?php echo $menu_background_color_light; ?>);
    }

    #iphone_container.default #primary_menu ul li a {
        font-family: '<?php echo $menu_font_family; ?>';
        font-size: <?php echo $menu_font_size . $menu_font_size_unit; ?>;
        color: #<?php echo $menu_font_color; ?>;
    }

    #iphone_container.default #top_bar .active {
        background-color: #<?php echo $menu_background_color; ?>;
    }

    #iphone_container.default #main a, 
    #iphone_container.default #main .post_single .entry-title,
    #iphone_container.default #main .page .entry-title {
        color: #<?php echo $content_link_color; ?>;
    }

    #iphone_container.default #main,
    #iphone_container.default #main p,
    #iphone_container.default #wp-calendar td,
    #iphone_container.default #wp-calendar th {
        color: #<?php echo $content_font_color; ?>;
        font-size: <?php echo $content_font_size . $content_font_size_unit; ?>;
        font-family: '<?php echo $content_font_family; ?>';
    }

    #iphone_container.default #footer {
        background-color: #<?php echo $toolbar_background_color; ?>;
    }

    #iphone_container.default input[type="button"],
    #iphone_container.default input[type="submit"],
    #iphone_container.default .button,
    #iphone_container.default #navigation_button,
    #iphone_container.default #main .post .date {
        font-family: '<?php echo $toolbar_button_font_family; ?>';
        background-color: #<?php echo $toolbar_button_color; ?>;
        color: #<?php echo $toolbar_button_font_color; ?>;
    }

    #iphone_container.default #top_search .text input {
        font-family: '<?php echo $header_font_family; ?>';
    }

    #iphone_container.default #navigation_button .triangle {
        border-top: 9px solid #<?php echo $toolbar_button_color; ?>;
    }

    #iphone_container.default #main .post .date .triangle {
        border-left: 9px solid #<?php echo $toolbar_button_color; ?>;
    }
    
    #iphone_container.default #footer_copyright {
        color: #<?php echo $footer_copyright_font_color; ?>;
        font-family: '<?php echo $toolbar_button_font_family; ?>';
    }
	
	.storage {
		display:none;
	}
	
	/*=========== styles for new theme ======================*/
	
			
			#iphone_container.new #page {
				background-color: #<?php echo $header_background_color; ?>;
			}
            
			#iphone_container.new #list_header {
				background-color: #<?php echo $menu_background_color; ?>;
			}
			
			#iphone_container.new #list_header p {
				font-family: '<?php echo $header_font_family; ?>' ;
				font-size: <?php echo $header_font_size . $header_font_size_unit; ?> ;
				color: #<?php echo $menu_font_color; ?> ;
			}
			
			#iphone_container.new #content .post {
				background-color: #<?php echo $menu_background_color; ?>;
			}
			
			#iphone_container.new #content .post_title a, #content .post_title p {
				color: #<?php echo $toolbar_button_font_color; ?> ;
				font-size: <?php echo $content_font_size . $content_font_size_unit; ?> ;
                font-family: '<?php echo $toolbar_button_font_family; ?>' ;
			}
			
			#iphone_container.new #content .post_description p, #content .post_content p {
				color: #<?php echo $content_font_color; ?> ;
				font-size: <?php echo $content_font_size . $content_font_size_unit; ?> ;
                font-family: '<?php echo $content_font_family; ?>' ;
			}
			
			#iphone_container.new #content .post_description a, #content .post_content a {
				color: #<?php echo $content_link_color; ?> ;
			}
</style>
<script type="text/javascript">
    var content_selector = 0;
    
    // RGB >> HSL
    function _color_rgb2hsl(rgb) {
        var r = rgb[0];
        var g = rgb[1];
        var b = rgb[2];
        var min = Math.min(r, Math.min(g, b));
        var max = Math.max(r, Math.max(g, b));
        var delta = max - min;
        var l = (min + max) / 2;
        var s = 0;
        if (l > 0 && l < 1) {
            s = delta / (l < 0.5 ? (2 * l) : (2 - 2 * l));
        }
        var h = 0;
        if (delta > 0) {
            if (max == r && max != g)
                h += (g - b) / delta;
            if (max == g && max != b)
                h += (2 + (b - r) / delta);
            if (max == b && max != r)
                h += (4 + (r - g) / delta);
            h /= 6;
        } return [h, s, l];
    }

    // HSL >> RGB
    function _color_hsl2rgb(hsl) {
        var h = hsl[0];
        var s = hsl[1];
        var l = hsl[2];
        var m2 = (l <= 0.5) ? l * (s + 1) : l + s - l * s;
        var m1 = l * 2 - m2;
        return [_color_hue2rgb(m1, m2, h + 0.33333),
            _color_hue2rgb(m1, m2, h),
            _color_hue2rgb(m1, m2, h - 0.33333)];
    }

    // Helper function for _color_hsl2rgb().
    function _color_hue2rgb(m1, m2, h) {
        h = (h < 0) ? h + 1 : ((h > 1) ? h - 1 : h);
        if (h * 6 < 1)
            return m1 + (m2 - m1) * h * 6;
        if (h * 2 < 1)
            return m2;
        if (h * 3 < 2)
            return m1 + (m2 - m1) * (0.66666 - h) * 6;
        return m1;
    }
    
    function hexdec (hex_string) {
        // http://kevin.vanzonneveld.net
        // +   original by: Philippe Baumann
        // *     example 1: hexdec('that');
        // *     returns 1: 10
        // *     example 2: hexdec('a0');
        // *     returns 2: 160
        hex_string = (hex_string + '').replace(/[^a-f0-9]/gi, '');
        return parseInt(hex_string, 16);
    }
    
    function dechex (number) {
        // http://kevin.vanzonneveld.net
        // +   original by: Philippe Baumann
        // +   bugfixed by: Onno Marsman
        // +   improved by: http://stackoverflow.com/questions/57803/how-to-convert-decimal-to-hex-in-javascript
        // +   input by: pilus
        // *     example 1: dechex(10);
        // *     returns 1: 'a'
        // *     example 2: dechex(47);
        // *     returns 2: '2f'
        // *     example 3: dechex(-1415723993);
        // *     returns 3: 'ab9dc427'
        if (number < 0) {
            number = 0xFFFFFFFF + number + 1;
        }
        return parseInt(number, 10).toString(16);
    }
    
    function str_pad (input, pad_length, pad_string, pad_type) {
        // http://kevin.vanzonneveld.net
        // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
        // + namespaced by: Michael White (http://getsprink.com)
        // +      input by: Marco van Oort
        // +   bugfixed by: Brett Zamir (http://brett-zamir.me)
        // *     example 1: str_pad('Kevin van Zonneveld', 30, '-=', 'STR_PAD_LEFT');
        // *     returns 1: '-=-=-=-=-=-Kevin van Zonneveld'
        // *     example 2: str_pad('Kevin van Zonneveld', 30, '-', 'STR_PAD_BOTH');
        // *     returns 2: '------Kevin van Zonneveld-----'
        var half = '',
        pad_to_go;
        
        var str_pad_repeater = function (s, len) {
            var collect = '',
            i;
            
            while (collect.length < len) {
                collect += s;
            }
            collect = collect.substr(0, len);
            
            return collect;
        };
        
        input += '';
        pad_string = pad_string !== undefined ? pad_string : ' ';
        
        if (pad_type != 'STR_PAD_LEFT' && pad_type != 'STR_PAD_RIGHT' && pad_type != 'STR_PAD_BOTH') {
            pad_type = 'STR_PAD_RIGHT';
        }
        if ((pad_to_go = pad_length - input.length) > 0) {
            if (pad_type == 'STR_PAD_LEFT') {
                input = str_pad_repeater(pad_string, pad_to_go) + input;
            } else if (pad_type == 'STR_PAD_RIGHT') {
                input = input + str_pad_repeater(pad_string, pad_to_go);
            } else if (pad_type == 'STR_PAD_BOTH') {
                half = str_pad_repeater(pad_string, Math.ceil(pad_to_go / 2));
                input = half + input + half;
                input = input.substr(0, pad_length);
            }
        }
        
        return input;
    }


    // Convert a hex color into an RGB triplet.

    function _color_unpack(hex, normalize) {
        var out = [];

        if (hex.length == 4) {
            hex = hex[1] . hex[1] . hex[2] . hex[2] . hex[3] . hex[3];
        }
        var c = hexdec(hex);
        
        for (i = 16; i >= 0; i -= 8) {
            out.push(((c >> i) & 0xFF) / (normalize ? 255 : 1));
        } 
        return out;
    }

    // Convert an RGB triplet to a hex color.

    function _color_pack(rgb, normalize) {
        out = 0;

        for ( var k in rgb) {
            out |= ((rgb[k] * (normalize ? 255 : 1)) << (16 - k * 8));
        }
        
        return '#' + str_pad(dechex(out), 6, 0, 'STR_PAD_LEFT');
    }
    
    /**
     * Changes logo image
     */
    function change_logo(imgurl) {
        jQuery('#current_logo').show();
        jQuery('#current_logo img').attr('src', imgurl);
        jQuery('#logo_url').val(imgurl);
        
        var new_logo = new Image();
        new_logo.onload = function(){
            var logo_width = new_logo.width;
            var logo_height = new_logo.height;
            
            if (logo_height > <?php echo MC_MAX_LOGO_HEIGHT; ?>) {
                logo_width = parseInt(logo_width * <?php echo MC_MAX_LOGO_HEIGHT; ?> / logo_height);
                logo_height = <?php echo MC_MAX_LOGO_HEIGHT; ?>;
            }

            if (logo_width > <?php echo MC_MAX_LOGO_WIDTH; ?>) {
                logo_height = parseInt(logo_height * <?php echo MC_MAX_LOGO_HEIGHT; ?> / logo_width);
                logo_width = <?php echo MC_MAX_LOGO_WIDTH; ?>;
            }

            var logo_margin_left = parseInt((<?php echo MC_MAX_LOGO_WIDTH; ?> - logo_width) / 2) + 20;
            var logo_margin_top = parseInt((<?php echo MC_MAX_LOGO_HEIGHT; ?> - logo_height) / 2);
            
            jQuery('#header_logo').attr('src', new_logo.src)
                .css({
                    'height': logo_height,
                    'width': logo_width,
                    'margin-left': logo_margin_left,
                    'margin-top': logo_margin_top
                })
                .show();
        }
        new_logo.src = imgurl;
    }
    
    /**
     * Changes background image
     */
    function change_background_image(imgurl) {
        jQuery('#current_background_image').show();
        jQuery('#current_background_image img').attr('src', imgurl);
        jQuery('#background_image_url').val(imgurl);
        
        jQuery('#iphone_container').css('background-image', 'url(' + imgurl + ')').show();
    }
    
    var click_on_logo_from_media_library = true;
    var default_theme, new_theme;
    jQuery(document).ready(function() {
		default_theme = jQuery('#default_theme').html();
		jQuery('#default_theme').html('');
		new_theme = jQuery('#new_theme').html();
		jQuery('#new_theme').html('');
        content_selector = jQuery('#iphone_container #main,#iphone_container #main p,#iphone_container #wp-calendar td,#iphone_container #wp-calendar th');
        jQuery('#site_title').keyup(function(){
            jQuery('#header_site_title').find('h1').text(jQuery(this).val());
        });
        
        jQuery('#footer_copyright').keyup(function(){
            if (jQuery(this).val() != '') {
                jQuery('#iphone_container #footer_copyright').show().text('&copy; ' + jQuery(this).val());
            } else {
                jQuery('#iphone_container #footer_copyright').hide();
            }
        });
		
		
        
		
		jQuery('input:radio[name="theme"]').change(function(){
			iphone_container = jQuery('#iphone_container');
			if (jQuery('input:radio[name="theme"]:checked').val() == 'new')
			{
				iphone_container.html(new_theme);
			}
			else
			{
				iphone_container.html(default_theme);
				content_selector = jQuery('#iphone_container #main,#iphone_container #main p,#iphone_container #wp-calendar td,#iphone_container #wp-calendar th');
			}
			jQuery('#content_font_family').change();
			jQuery('#content_font_size').keyup();
			jQuery('#content_font_size_unit').change();
			jQuery('input[name="content_font_color"]').change();
			jQuery('input[name="content_link_color"]').change();
			jQuery('#header_font_family').change();
			jQuery('#header_font_size').change();
			jQuery('#header_font_size_unit').change();
			jQuery('input[name="header_font_color"]').change();
			jQuery('input[name="header_background_color"]').change();
			jQuery('input[name="toolbar_background_color"]').change();
			jQuery('input[name="toolbar_button_color"]').change();
			jQuery('#toolbar_button_font_family').change();
			jQuery('input[name="toolbar_button_font_color"]').change();
			jQuery('input[name="footer_copyright_font_color"]').change();
			jQuery('input[name="show_top_toolbar"]').change();
			jQuery('input[name="show_top_toolbar_search"]').change();
			jQuery('input[name="show_footer_toolbar"]').change();
			jQuery('#menu_font_family').change();
			jQuery('#menu_font_size').keyup();
			jQuery('#menu_font_size_unit').change();
			jQuery('input[name="menu_font_color"]').change();
			jQuery('input[name="menu_background_color"]').change();
			jQuery('input[name="background_color"]').change();
			
			jQuery('#iphone_container').toggleClass('default new');
		})
        
        jQuery('#content_font_family').change(function(){
            content_selector.css('font-family', jQuery(this).val());
			jQuery('#iphone_container.new #content .post_description p, #content .post_content p').css('font-family', jQuery(this).val());
        });
        
        jQuery('#content_font_size').keyup(function(){
            content_selector.css('font-size', jQuery('#content_font_size').val() + jQuery('#content_font_size_unit').val());
			jQuery('#iphone_container.new #content .post_description p, #content .post_content p,#iphone_container.new #content .post_title a, #content .post_title p')
				.css('font-size', jQuery('#content_font_size').val() + jQuery('#content_font_size_unit').val());
        });
        
        jQuery('#content_font_size_unit').change(function(){
            content_selector.css('font-size', jQuery('#content_font_size').val() + jQuery('#content_font_size_unit').val());
			jQuery('#iphone_container.new #content .post_description p, #content .post_content p,#iphone_container.new #content .post_title a, #content .post_title p')
				.css('font-size', jQuery('#content_font_size').val() + jQuery('#content_font_size_unit').val());
        });
        
        jQuery('input[name="content_font_color"]').live('change keyup', function(){
            content_selector.css('color', '#' + jQuery(this).val());
			jQuery('#iphone_container.new #content .post_description p, #content .post_content p').css('color', '#' + jQuery(this).val());
        });
        
        jQuery('input[name="content_link_color"]').live('change keyup', function(){
            jQuery('#iphone_container #main a, #iphone_container #main .post_single .entry-title, #iphone_container #main .page .entry-title')
                .css('color', '#' + jQuery(this).val());
			jQuery('#iphone_container.new #content .post_description a, #content .post_content a').css('color', '#' + jQuery(this).val());
        });
        
        jQuery('#header_font_family').change(function(){
            jQuery('#iphone_container #header, #iphone_container #top_search .text input, #iphone_container #header_site_title td h1')
                .css('font-family', jQuery(this).val());
			jQuery('#iphone_container.new #list_header p').css('font-family', jQuery(this).val());
        });
        
        jQuery('#header_font_size').keyup(function(){
            jQuery('#iphone_container #header, #iphone_container #header_site_title td h1').css('font-size', jQuery('#header_font_size').val() + jQuery('#header_font_size_unit').val());
			jQuery('#iphone_container.new #list_header p').css('font-size', jQuery('#header_font_size').val() + jQuery('#header_font_size_unit').val());
        });
        
        jQuery('#header_font_size_unit').change(function(){
            jQuery('#iphone_container #header, #iphone_container #header_site_title td h1').css('font-size', jQuery('#header_font_size').val() + jQuery('#header_font_size_unit').val());
			jQuery('#iphone_container.new #list_header p').css('font-size', jQuery('#header_font_size').val() + jQuery('#header_font_size_unit').val());
        });
        
        jQuery('input[name="header_font_color"]').live('change keyup', function(){
            jQuery('#iphone_container #header').css('color', '#' + jQuery(this).val());
			jQuery('#iphone_container.new #list_header p').css('color', '#' + jQuery(this).val());
        });
        
        jQuery('input[name="header_background_color"]').live('change keyup', function(){
            jQuery('#iphone_container #header').css('background-color', '#' + jQuery(this).val());
			jQuery('#iphone_container.new #page').css('background-color', '#' + jQuery(this).val());
        });
        
        jQuery('input[name="toolbar_background_color"]').live('change keyup', function(){
            jQuery('#iphone_container #footer, #iphone_container #top_bar').css('background-color', '#' + jQuery(this).val());
        });
        
        jQuery('input[name="toolbar_button_color"]').live('change keyup', function(){
            jQuery('#iphone_container input[type="button"], #iphone_container input[type="submit"], #iphone_container .button, #iphone_container #navigation_button, #iphone_container #main .post .date').css('background-color', '#' + jQuery(this).val());
            jQuery('#iphone_container #main .post .date .triangle').css('border-left', '9px solid #' + jQuery(this).val());
        });
        
        jQuery('#toolbar_button_font_family').change(function(){
            jQuery('#iphone_container input[type="button"], '+
                    '#iphone_container input[type="submit"], ' +
                    '#iphone_container .button, ' +
                    '#iphone_container #navigation_button, ' +
                    '#iphone_container #main .post .date,' +
                    '#iphone_container #footer_copyright')
                .css('font-family', jQuery(this).val());
        });
        
        jQuery('input[name="toolbar_button_font_color"]').live('change keyup', function(){
            jQuery('#iphone_container input[type="button"], '+
                    '#iphone_container input[type="submit"], ' +
                    '#iphone_container .button, ' +
                    '#iphone_container #navigation_button, ' +
                    '#iphone_container #main .post .date')
                .css('color', '#' + jQuery(this).val());
			jQuery('#iphone_container.new #content .post_title a, #content .post_title p').css('color', '#' + jQuery(this).val());
        });
        
        jQuery('input[name="footer_copyright_font_color"]').live('change keyup', function(){
            jQuery('#iphone_container #footer_copyright')
                .css('color', '#' + jQuery(this).val());
        });
        
        jQuery('input[name="show_top_toolbar"]').change(function(){
            if (jQuery('#show_top_toolbar_yes').attr('checked')) {
                jQuery('#top_bar').show();
            } else {
                jQuery('#top_bar').hide();
            }
        });
        
        jQuery('input[name="show_top_toolbar_search"]').change(function(){
            if (jQuery('#show_top_toolbar_search_yes').attr('checked')) {
                jQuery('#top_search').show();
            } else {
                jQuery('#top_search').hide();
            }
        });
        
        jQuery('input[name="show_footer_toolbar"]').change(function(){
            if (jQuery('#show_footer_toolbar_yes').attr('checked')) {
                jQuery('#footer').show();
            } else {
                jQuery('#footer').hide();
            }
        });
        
        jQuery('#menu_font_family').change(function(){
            jQuery('#iphone_container #primary_menu ul li a')
                .css('font-family', jQuery(this).val());
        });
        
        jQuery('#menu_font_size').keyup(function(){
            jQuery('#iphone_container #primary_menu ul li a').css('font-size', jQuery('#menu_font_size').val() + jQuery('#menu_font_size_unit').val());
        });
        
        jQuery('#menu_font_size_unit').change(function(){
            jQuery('#iphone_container #primary_menu ul li a').css('font-size', jQuery('#menu_font_size').val() + jQuery('#menu_font_size_unit').val());
        });
        
        jQuery('input[name="menu_font_color"]').live('change keyup', function(){
            jQuery('#iphone_container #primary_menu ul li a').css('color', '#' + jQuery(this).val());
			jQuery('#iphone_container.new #list_header p').css('color', '#' + jQuery(this).val());
        });
        
        jQuery('input[name="menu_background_color"]').live('change keyup', function(){
            var hsl = _color_rgb2hsl(_color_unpack('#' + jQuery(this).val(), false));            
            hsl[2] -= 30;
            var menu_background_color_light = _color_pack(_color_hsl2rgb(hsl), false);
            if (menu_background_color_light.length > 7) {
                menu_background_color_light = '#000000';
            }
            
            jQuery('#iphone_container.default #top_bar .active').css('cssText', 'background-color: #' + jQuery(this).val() + ' !important') ;
            jQuery('#iphone_container.default div#primary_menu')
                .css('background', '-webkit-gradient(linear, left top, left bottom, from(#' + jQuery(this).val() + '), to(' + menu_background_color_light + '))')
                .css('background', '-moz-linear-gradient(top,#' + jQuery(this).val() + ',' + menu_background_color_light + ')');
			jQuery('#iphone_container.new #content .post, #iphone_container.new #list_header').css('cssText', 'background-color: #' + jQuery(this).val()) ;
        });
        
        jQuery('input[name="background_color"]').live('change keyup', function(){
            jQuery('#iphone_container, #iphone_container article, #iphone_container #page').css('background-color', '#' + jQuery(this).val());
        });
        
        jQuery('#logo_from_media_library').click(function(eventObject) {
            eventObject.preventDefault();
            click_on_logo_from_media_library = true;
            
            tb_show('', 'media-upload.php?post_id=0&type=image&TB_iframe=true');
        });
        
        
        jQuery('#background_image_from_media_library').click(function(eventObject) {
            eventObject.preventDefault();
            
            click_on_logo_from_media_library = false;
            
            tb_show('', 'media-upload.php?post_id=0&type=image&TB_iframe=true');
        });
        
        jQuery('#logo_from_template').click(function(){
            tb_show('Template\'s images', '#TB_inline?width=670&height=424&inlineId=logo_template_images');
        });
        
        jQuery('#background_image_from_template').click(function(){
            tb_show('Template\'s images', '#TB_inline?width=670&height=424&inlineId=background_template_images');
        });
        
        window.send_to_editor = function(html) {
            imgurl = jQuery('img', html).attr('src');
            if (click_on_logo_from_media_library) {
                change_logo(imgurl);
            } else {
                change_background_image(imgurl);
            }
            
            tb_remove();
        }
        
        jQuery('.template_image_item').live('click', function(){
            var title = jQuery(this).attr('title');
            var imgurl = jQuery(this).find('img').attr('src');
            
            switch (title) {
                case 'logo':
                    change_logo(imgurl);
                    break;
                case 'background':
                    change_background_image(imgurl);
                    break;
            }
            
            tb_remove();
        });
        
        jQuery('#remove_logo').click(function(){
            jQuery('#current_logo').hide();
            jQuery('#logo_url').val('');
            
            jQuery('#header_logo').attr('src', '');
            jQuery('#header_logo').hide();
        });
        
        jQuery('#remove_background_image').click(function(){
            jQuery('#current_background_image').hide();
            jQuery('#background_image_url').val('');
            
            jQuery('#iphone_container').css('background-image', 'none');
        });
        
        jQuery('.color_select').colourPicker({
            ico: '<?php echo MobileComply::get_dir_plugin_url(); ?>images/jquery.colourPicker.gif', 
            title: false
        });
        
        jQuery('#accordion').accordion({
            autoHeight: false
        });
    });
</script>
<h2>Mobile Comply</h2>
<div class="form">
    <form action="" method="post" enctype="multipart/form-data">
        <?php
        if (!$is_activated) {
            ?>
            <div class="error">
                <p>
                    Your plugin isn't activated. Please input your username 
                    and password from mobilecomply.com for activation.<br/><br/>
                    <label for="username">Username</label><br/>
                    <input type="text" name="username" value="" id="username"/><br/>
                    <label for="password">Password</label><br/>
                    <input type="password" name="password" value="" id="password"/><br/><br/>
                    <input type="submit" name="save_mobilecomply_options" value="Save" class="button-primary"/>
                </p>
            </div>
            <?php
        }
        ?>
        <table style="width: 100%">
            <tr>
                <td style="vertical-align: top; padding-right: 20px;">
                    <div id="accordion">
                        <h3><a href="#">Appearance</a></h3>
                        <div>
                            <table class="form-table mobilecomply_table">
                                <tr>
                                    <th>
                                        Please upload or select your logo:
                                    </th>
                                    <td>
                                        <div id="current_logo" <?php if (empty($logo_url)) {echo 'class="hidden"';} ?>>
                                            <img src="<?php echo $logo_url; ?>" alt="No logo"/>
                                            <input type="hidden" name="logo_url" value="<?php echo $logo_url; ?>" id="logo_url"/>
                                            <br/>
                                            <input type="button" name="remove_logo" value="Remove logo" id="remove_logo" class="button-secondary"/>
                                            <br/><br/>
                                        </div>
                                        <input type="button" name="upload_logo_button" value="Choose image from Media Library" id="logo_from_media_library" class="button-secondary"/>
                                        OR
                                        <input type="button" name="images_from_template" value="Choose image from template directory" id="logo_from_template" class="button-secondary"/>

                                        <div id="logo_template_images" class="hidden">
                                            <div>
                                                <?php
                                                foreach ($template_images as $image) {
                                                    $image_parts = explode('/', $image);
                                                    $image_title = end($image_parts);

                                                    $image_size = getimagesize(convertUrlToPath($image));
                                                    $margin_top = 0;
                                                    if ($image_size[0] > 300) {
                                                        $height = 300 * $image_size[1] / $image_size[0];
                                                    } else {
                                                        $height = $image_size[1];
                                                    }

                                                    if ($height > 150) {
                                                        $height = 150;
                                                    }

                                                    $margin_top = intval((150 - $height) / 2);
                                                    ?>
                                                    <div class="template_image_item" title="logo">
                                                        <img src="<?php echo $image; ?>" alt="" style="margin-top: <?php echo $margin_top; ?>px"/>
                                                        <div class="title"><?php echo $image_title; ?></div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </td>
                                    <td rowspan="33">

                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Choose design theme:
                                    </th>
                                    <td>
                                        <?php echo $design_theme_select; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th></th>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th colspan="2"><b>Content styles</b></th>
                                </tr>
                                <tr>
                                    <th>
                                        <label for="content_font_family">Content font:</label>
                                    </th>
                                    <td>
                                        <?php echo $content_font_family_select; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <label for="content_font_size">Content font size:</label>
                                    </th>
                                    <td>
                                        <input type="text" name="content_font_size" value="<?php echo $content_font_size; ?>" id="content_font_size" class="small-text"/>
                                        <?php echo $content_font_size_unit_select; ?>
                                    </td>                
                                </tr>
                                <tr>
                                    <th>
                                        <label for="content_font_color">Content font color:</label>
                                    </th>
                                    <td class="colorpicker">
                                        <?php echo $content_font_color_select; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <label for="content_link_color">Content link color:</label>
                                    </th>
                                    <td class="colorpicker">
                                        <?php echo $content_link_color_select; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th></th>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th colspan="2"><b>Header styles</b></th>
                                </tr>
                                <tr>
                                    <th>
                                        <label for="header_font_family">Header font:</label>
                                    </th>
                                    <td>
                                        <?php echo $header_font_family_select; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <label for="header_font_size">Header font size:</label>
                                    </th>
                                    <td>
                                        <input type="text" name="header_font_size" value="<?php echo $header_font_size; ?>" id="header_font_size" class="small-text"/>
                                        <?php echo $header_font_size_unit_select; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <label for="header_font_color">Header font color:</label>
                                    </th>
                                    <td class="colorpicker">
                                        <?php echo $header_font_color_select; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <label for="header_background_color">Header background color:</label>
                                    </th>
                                    <td class="colorpicker">
                                        <?php echo $header_background_color_select; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th></th>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th colspan="2"><b>Toolbars styles</b></th>
                                </tr>
                                <tr>
                                    <th>
                                        <label for="toolbar_background_color">Toolbar background color:</label>
                                    </th>
                                    <td class="colorpicker">
                                        <?php echo $toolbar_background_color_select; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <label for="toolbar_button_color">Toolbar button color:</label>
                                    </th>
                                    <td class="colorpicker">
                                        <?php echo $toolbar_button_color_select; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <label for="toolbar_button_font_family">Toolbar button font:</label>
                                    </th>
                                    <td class="colorpicker">
                                        <?php echo $toolbar_button_font_family_select; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <label for="toolbar_button_font_color">Toolbar button font color:</label>
                                    </th>
                                    <td class="colorpicker">
                                        <?php echo $toolbar_button_font_color_select; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <label for="footer_copyright_font_color">Footer copyright font color:</label>
                                    </th>
                                    <td class="colorpicker">
                                        <?php echo $footer_copyright_font_color_select; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <label>Show top toolbar:</label>
                                    </th>
                                    <td>
                                        <input type="radio" name="show_top_toolbar" value="1" id="show_top_toolbar_yes" <?php echo $show_top_toolbar ? 'checked="checked"' : ''; ?>/> 
                                        <label for="show_top_toolbar_yes">YES</label>
                                        <input type="radio" name="show_top_toolbar" value="0" id="show_top_toolbar_no" <?php echo !$show_top_toolbar ? 'checked="checked"' : ''; ?>/> 
                                        <label for="show_top_toolbar_no">NO</label>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <label>Show top toolbar search form:</label>
                                    </th>
                                    <td>
                                        <input type="radio" name="show_top_toolbar_search" value="1" id="show_top_toolbar_search_yes" <?php echo $show_top_toolbar_search ? 'checked="checked"' : ''; ?>/> 
                                        <label for="show_top_toolbar_search_yes">YES</label>
                                        <input type="radio" name="show_top_toolbar_search" value="0" id="show_top_toolbar_search_no" <?php echo !$show_top_toolbar_search ? 'checked="checked"' : ''; ?>/> 
                                        <label for="show_top_toolbar_search_no">NO</label>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <label>Show footer toolbar:</label>
                                    </th>
                                    <td>
                                        <input type="radio" name="show_footer_toolbar" value="1" id="show_footer_toolbar_yes" <?php echo $show_footer_toolbar ? 'checked="checked"' : ''; ?>/> 
                                        <label for="show_footer_toolbar_yes">YES</label>
                                        <input type="radio" name="show_footer_toolbar" value="0" id="show_footer_toolbar_no" <?php echo !$show_footer_toolbar ? 'checked="checked"' : ''; ?>/> 
                                        <label for="show_footer_toolbar_no">NO</label>
                                    </td>
                                </tr>
                                <tr>
                                    <th></th>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th colspan="2"><b>Menu styles</b></th>
                                </tr>
                                <tr>
                                    <th>
                                        <label for="menu_font_family">Menu font:</label>
                                    </th>
                                    <td>
                                        <?php echo $menu_font_family_select; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <label for="menu_font_size">Menu font size:</label>
                                    </th>
                                    <td>
                                        <input type="text" name="menu_font_size" value="<?php echo $menu_font_size; ?>" id="menu_font_size" class="small-text"/>
                                        <?php echo $menu_font_size_unit_select; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <label for="menu_font_color">Menu font color:</label>
                                    </th>
                                    <td class="colorpicker">
                                        <?php echo $menu_font_color_select; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <label for="menu_background_color">Menu background color:</label>
                                    </th>
                                    <td class="colorpicker">
                                        <?php echo $menu_background_color_select; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th></th>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th colspan="2"><b>Background styles</b></th>
                                </tr>
                                <tr>
                                    <th>
                                        <label for="background_color">Background color:</label>
                                    </th>
                                    <td class="colorpicker">
                                        <?php echo $background_color_select; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Background image:
                                    </th>
                                    <td>
                                        <div id="current_background_image" <?php if (empty($background_image_url)) {echo 'class="hidden"';} ?>>
                                            <img src="<?php echo $background_image_url; ?>" alt="No background image"/>
                                            <input type="hidden" name="background_image_url" value="<?php echo $background_image_url; ?>" id="background_image_url"/>
                                            <br/>
                                            <input type="button" name="remove_background_image" value="Remove background image" id="remove_background_image" class="button-secondary"/>
                                            <br/><br/>
                                        </div>
                                        <input type="button" name="background_image_from_media_library" value="Choose image from Media Library" id="background_image_from_media_library" class="button-secondary"/>
                                        OR
                                        <input type="button" name="background_image_from_template" value="Choose image from template directory" id="background_image_from_template" class="button-secondary"/>

                                        <div id="background_template_images" class="hidden">
                                            <div>
                                                <?php
                                                foreach ($template_images as $image) {
                                                    $image_parts = explode('/', $image);
                                                    $image_title = end($image_parts);

                                                    $image_size = getimagesize(convertUrlToPath($image));
                                                    $margin_top = 0;
                                                    if ($image_size[0] > 300) {
                                                        $height = 300 * $image_size[1] / $image_size[0];
                                                    } else {
                                                        $height = $image_size[1];
                                                    }

                                                    if ($height > 150) {
                                                        $height = 150;
                                                    }

                                                    $margin_top = intval((150 - $height) / 2);
                                                    ?>
                                                    <div class="template_image_item" title="background">
                                                        <img src="<?php echo $image; ?>" alt="" style="margin-top: <?php echo $margin_top; ?>px"/>
                                                        <div class="title"><?php echo $image_title; ?></div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <input type="hidden" name="save_mobilecomply_options" value="Save"/>
                                        <input type="submit" name="save_mobilecomply_options" value="Save" class="button-primary"/>
                                    </th>
                                    <td>

                                    </td>
                                </tr>
                            </table> <!-- .mobilecomply_table -->
                        </div>
                        
                        <h3><a href="#">General Options</a></h3>
                        <div>
                            <table class="form-table mobilecomply_table">
                                <tr>
                                    <th>
                                        <label for="site_title">
                                            Site title:
                                            <br/>
                                            <i>The site title is displayed in the header of the site.</i>
                                        </label>
                                    </th>
                                    <td>
                                        <input type="text" name="site_title" value="<?php echo $site_title; ?>" id="site_title"/>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <label for="landing_page">
                                            Please Select Default Page:
                                            <br/>
                                            <i>This page will display as the home or landing page.</i>
                                        </label>
                                    </th>
                                    <td>
                                        <?php echo $landing_page_select; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <label for="phone_number">
                                            Phone Number:
                                            <br/>
                                            <i>The number entered here will display in the footer as an interactive number.</i>
                                        </label>
                                    </th>
                                    <td>
                                        <input type="text" name="phone_number" value="<?php echo $phone_number; ?>" id="phone_number"/>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <label for="google_map_code">
                                            Google Map Link:
                                            <br/>
                                            <i>Click here to learn how to create a link.</i>
                                        </label>
                                    </th>
                                    <td>
                                        <input type="text" name="google_map_code" value="<?php echo $google_map_code; ?>" id="google_map_code"/>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <label for="google_map_code">
                                            Contact page:
                                            <br/>
                                            <i>The page selected will display as the contact page.</i>
                                        </label>
                                    </th>
                                    <td>
                                        <?php echo $contact_page_select; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <label for="footer_copyright">
                                            Footer text:
                                            <br/>
                                            <i>This text will display in the footer.</i>
                                        </label>
                                    </th>
                                    <td>
                                        <input type="text" name="footer_copyright" value="<?php echo $footer_copyright; ?>" id="footer_copyright"/>
                                    </td>
                                </tr>                    
                                <tr>
                                    <th>
                                        <label>
                                            Remove Flash from posts content:
                                            <br/>
                                            <i>
                                                If you have flash in your site this will remove 
                                                for iPhone or WP7 output. If you seledt no a blank 
                                                area will be displayed.
                                            </i>
                                        </label>
                                    </th>
                                    <td>
                                        <input type="radio" name="remove_flash" value="1" id="remove_flash_yes" <?php echo $remove_flash ? 'checked="checked"' : ''; ?>/> 
                                        <label for="remove_flash_yes">YES</label>
                                        <input type="radio" name="remove_flash" value="0" id="remove_flash_no" <?php echo !$remove_flash ? 'checked="checked"' : ''; ?>/> 
                                        <label for="remove_flash_no">NO</label>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <input type="hidden" name="save_mobilecomply_options" value="Save"/>
                                        <input type="submit" name="save_mobilecomply_options" value="Save" class="button-primary"/>
                                    </th>
                                    <td>

                                    </td>
                                </tr>
                                <tr>
                                    <th></th>
                                    <td></td>
                                </tr>
                            </table> <!-- .mobilecomply_table -->
                        </div>

                        <h3><a href="#">Mobile Marketing</a></h3>
                        <div>
                            <table class="form-table mobilecomply_table">
                                <tr>
                                    <th>
                                        <label for="mobile_opt_in">
                                            Mobile Opt-in:
                                            <br/>
                                            <i>
                                                Mobile Opt-in allows your customers to visit your mobile site and 
                                                provide approval to receive your mobile offers. 
                                                <br/> 
                                                Selecting this page prompts Mobile Compy to display the 'opt-in' 
                                                page when this page is selected by your users.
                                            </i>
                                        </label>
                                    </th>
                                    <td>
                                        <?php echo $mobile_opt_in_select; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <label for="footer_javascript">
                                            Google Analytic Code or Custom Code for statistics:
                                            <br/>
                                            <i>Insert code here to allow tracking of your statistics from an outside application.</i>
                                        </label>
                                    </th>
                                    <td>
                                        <textarea name="footer_javascript" id="footer_javascript"><?php echo $footer_javascript; ?></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <label>
                                            Facebook Plugin:
                                            <br/>
                                            <i>
                                                The facebook plugin allows you to post to your Facebook fanpage that you are mobile.
                                            </i>
                                        </label>
                                    </th>
                                    <td>
                                        <input type="radio" name="facebook" value="1" id="facebook_yes" <?php echo $facebook ? 'checked="checked"' : ''; ?>/> 
                                        <label for="facebook_yes">YES</label>
                                        <input type="radio" name="facebook" value="0" id="facebook_no" <?php echo !$facebook ? 'checked="checked"' : ''; ?>/> 
                                        <label for="facebook_no">NO</label>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <input type="hidden" name="save_mobilecomply_options" value="Save"/>
                                        <input type="submit" name="save_mobilecomply_options" value="Save" class="button-primary"/>
                                    </th>
                                    <td>

                                    </td>
                                </tr>
                            </table> <!-- .mobilecomply_table -->
                        </div>
                    </div><!-- #accordion -->
                </td>
                <td style="vertical-align: top; width: 389px;">
                    <div id="iphone_block">
				<div id="iphone_block_phone"></div>
				<div class="clear"></div>
				<div id="iphone_container" class="<?php echo get_option('mobilecomply_theme');?>">
				<?php require(get_option('mobilecomply_theme').'.php'); ?>
				</div>
				</div>
                </td>
            </tr>
        </table>
        
    </form>
</div>
<div class="storage" id="default_theme"><?php require('default.php'); ?></div>
<div class="storage" id="new_theme"><?php require('new.php'); ?></div>