<?php
	get_header();
?>
<div id = "list_header">
	<a href="<?php echo home_url(); ?>">
	<img alt = "Home" src = "<?php echo get_theme_root_uri() . '/new/images/home_button.png'; ?>">
	</a>
	<div id = "category_title">
		<p><?php wp_title(""); ?></p>
	</div>
</div>
<div id="content">
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	<div class="post">
		<div class="post_image">
		<a href = "<?php echo home_url('/').'?p='.get_the_ID().'&title='; wp_title(""); ?>">
		<?php if(has_post_thumbnail()) the_post_thumbnail(array(268,142));
			else {?>
			<img alt="No image" src="<?php echo get_theme_root_uri() . '/new/images/default_image.jpg'; ?>">
		<?php } ?>
		</a>
		</div>
		<div class="title_and_description">
		<div class="post_title">
		<a href = "<?php echo home_url('/').'?p='.get_the_ID().'&title='; wp_title(""); ?>"><?php the_title(); ?></a>
		</div>
		<div class="post_description">
		<?php the_excerpt(); ?>
		</div>
		<img src = "<?php echo plugins_url(); ?>/mobilecomply/themes/new/images/addtoplaylist.png" alt="Add to playlist">
		</div>
	</div>
	<?php endwhile; endif; ?>
</div>


<?php
	get_footer(); 
?>