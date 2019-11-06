<?php
/**
 * Default Page.
 * Pagina care defineste o pagina fara template.
 */
defined('ABSPATH') or die('Direct access is forbidden!');
get_header();
?>

    <div class="page-content page-default">
        <h1><?= get_the_title() ?></h1>

        <article>
            <!-- Afisam continutul paginii din content editor-ul paginii -->
            <?php if (have_posts()) :
                while (have_posts()) : the_post(); ?>
                    <?php the_content(); ?>
                <?php endwhile; ?>
            <?php endif; ?>
        </article>
    </div>

<?php get_footer(); ?>