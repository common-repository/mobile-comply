<?php
/**
 * The default template for displaying content
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <?php 
        if (function_exists('has_post_thumbnail') && has_post_thumbnail()) {
            if (is_sticky()) {
                ?>
                <div class="sticky_image">
                    <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
                        <?php the_post_thumbnail(array(600, 3000), array()); ?>
                    </a>
                </div>
                <?php
            } else {
                ?>
                <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
                    <?php the_post_thumbnail(array(150, 150)); ?>
                </a>
                <?php
            }
        }
        ?>
        <?php if (is_sticky()) : ?>
            <hgroup>
                <div class="date">
                    <?php echo get_the_date('F') . '<br/><span>' . get_the_date('j') . '</span><br/>' . get_the_date('Y'); ?>
                    <div class="triangle"></div>
                </div>
                <h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf(esc_attr__('Permalink to %s', 'twentyeleven'), the_title_attribute('echo=0')); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
                <div class="author"><?php echo __('by:', 'twentyeleven') . ' ' . get_the_author_link(); ?></div>
            </hgroup>
        <?php else : ?>
            <h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf(esc_attr__('Permalink to %s', 'twentyeleven'), the_title_attribute('echo=0')); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
            <div class="date"><?php the_date(); ?></div>
            <div class="author"><?php echo __('by:', 'twentyeleven') . ' ' . get_the_author_link(); ?></div>
        <?php endif; ?>
    </header><!-- .entry-header -->

    <?php if (is_search() || is_front_page()) : // Only display Excerpts for Search ?>
        <div class="entry-summary">
            <?php the_excerpt(); ?>
        </div><!-- .entry-summary -->
    <?php else : ?>
        <div class="entry-content">
            <?php the_content(__('Continue reading <span class="meta-nav">&rarr;</span>', 'twentyeleven')); ?>
            <?php wp_link_pages(array('before' => '<div class="page-link"><span>' . __('Pages:', 'twentyeleven') . '</span>', 'after' => '</div>')); ?>
        </div><!-- .entry-content -->
    <?php endif; ?>

    <footer class="entry-meta">
        <?php $show_sep = false; ?>
        <?php if ('post' == get_post_type()) : // Hide category and tag text for pages on Search ?>
            <?php
            /* translators: used between list items, there is a space after the comma */
            $categories_list = get_the_category_list(__(', ', 'twentyeleven'));
            if ($categories_list):
                ?>
                <span class="cat-links">
                    <?php printf(__('<span class="%1$s">Posted in</span> %2$s', 'twentyeleven'), 'entry-utility-prep entry-utility-prep-cat-links', $categories_list);
                    $show_sep = true; ?>
                </span>
            <?php endif; // End if categories ?>
            <?php
            /* translators: used between list items, there is a space after the comma */
            $tags_list = get_the_tag_list('', __(', ', 'twentyeleven'));
            if ($tags_list):
                if ($show_sep) :
                    ?>
                    <span class="sep"> | </span>
                    <?php endif; // End if $show_sep  ?>
                <span class="tag-links">
                    <?php printf(__('<span class="%1$s">Tagged</span> %2$s', 'twentyeleven'), 'entry-utility-prep entry-utility-prep-tag-links', $tags_list);
                    $show_sep = true; ?>
                </span>
            <?php endif; // End if $tags_list ?>
        <?php endif; // End if 'post' == get_post_type()  ?>
    </footer><!-- #entry-meta -->
    <div class="clear"></div>
</article><!-- #post-<?php the_ID(); ?> -->
