<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */

global $sOptInSuccess;
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <h1 class="entry-title"><?php the_title(); ?></h1>
    </header><!-- .entry-header -->

    <div class="entry-content">
        <?php
        if (!empty ($sOptInSuccess)) {
            ?>
            <div class="success">
                <?php echo $sOptInSuccess; ?>
            </div>
            <?php
        }
        ?>
        <?php the_content(); ?>
        <?php wp_link_pages(array('before' => '<div class="page-link"><span>' . __('Pages:', 'twentyeleven') . '</span>', 'after' => '</div>')); ?>
    </div><!-- .entry-content -->
</article><!-- #post-<?php the_ID(); ?> -->
