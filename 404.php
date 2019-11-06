<?php 
/**
 * Template Name: 404
 */
defined( 'ABSPATH' ) or die( 'Direct access is forbidden!' );
get_header(); ?>

<div class="page-content article-page">
	<div class="inner-content inner-content-error">
		<article>
			<?php $title_page_error = get_field('title_page_error', 'options');
			if(!empty($title_page_error)){ ?>
				<div class="centered-content">
					<h1><?php echo $title_page_error; ?></h1>
				</div>
			<?php } ?>
			<?php $content_page_error = get_field('page_404', 'options');
			if(!empty($content_page_error)){ ?>
				<div class="article-content">
					<div class="general-content">
						<?php echo $content_page_error; ?>
					</div>
				</div>
			<?php } ?>
		</article>
	</div>
</div>
     
<?php get_footer(); ?>