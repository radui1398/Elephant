<?php 
defined( 'ABSPATH' ) or die( 'Direct access is forbidden!' );
get_header(); ?>

<div class="page-content article-page">
	<div class="inner-content">
		<h1><?php echo get_the_title(); ?></h1>
	</div>
	<div class="inner-content">
		<article>
			<div class="article-content">
				<div class="general-content">
					<?php if (have_posts()) : while (have_posts()) : the_post();?>
						<?php the_content(); ?>
					<?php endwhile; endif; ?>
				</div>
			</div>
		</article>
	</div>
</div>
    
<?php get_footer(); ?>