<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 */
global $show_footer_toolbar,
 $phone_number,
 $google_map_code,
 $contact_page,
 $footer_copyright,
 $footer_javascript;

$footer_items_num = 1;

if ($phone_number) {
    ++$footer_items_num;
}

if ($google_map_code) {
    ++$footer_items_num;
}

if ($contact_page) {
    ++$footer_items_num;
}

$footer_toolbar_class = 'footer-' . $footer_items_num;
?>

        </div><!-- #main -->

        <?php
        if ($show_footer_toolbar) {
            ?>
            <footer id="footer" class="<?php echo $footer_toolbar_class; ?>">
                <a href="<?php echo home_url(); ?>" class="button">
                    <?php echo __('Home'); ?>
                </a>
                <?php
                if ($phone_number) {
                    ?>
                    <a href="tel:<?php echo $phone_number; ?>" class="button">
                        <?php echo __('Call'); ?>
                    </a>
                    <?php
                }
                if ($google_map_code) {
                    ?>
                    <a href="<?php echo $google_map_code; ?>" class="button" target="_blank">
                        <?php echo __('Map'); ?>
                    </a>
                    <?php
                }
                if ($contact_page) {
                    ?>
                    <a href="<?php echo get_permalink($contact_page); ?>" class="button">
                        <?php echo __('Contact'); ?>
                    </a>
                    <?php
                }
                ?>
                <div class="clear"></div>
                <?php
                if ($footer_copyright) {
                    ?>
                    <div id="footer_copyright">&copy; <?php echo $footer_copyright; ?></div>
                    <?php
                }
                ?>
                
            </footer><!-- #footer -->
            <?php
        }
        ?>
    </div><!-- #page -->
<?php echo $footer_javascript; ?>
<?php wp_footer(); ?>

</body>
</html>