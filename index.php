<?php
defined('ABSPATH') or die('Direct access is forbidden!');
include('templates/parts/page-utils.php');
get_header();
?>

<div class="page">
    <div class="container">
        <?php yoastBreadcrumb(); # afisam breadcrumb daca este activata functia din yoast ?>
        <h1 class="page-title"><?php indexTitle() # afisam titlul pentru arhiva ?></h1>

        <?php
        global $wp_query;
        $args = array(
            'ignore_sticky_posts' => true,
            'paged' => (get_query_var('paged')) ? absint(get_query_var('paged')) : 1
        );

        query_posts($args); # rulam query-ul
        ?>

        <?php if (have_posts()): ?>
            <div class="posts-grid">
                <div class="row">
                    <?php
                    # Aici este loop-ul care afiseaza toate articolele.
                    while (have_posts()):
                        the_post();

                        $postID = get_the_ID();

                        displayPost($postID); # Functie din page-utils.php;
                    endwhile;
                    ?>
                </div>
            </div>

            <?php
            # Paginarea
            $pagination = customPagination(array(
                'mid_size' => 2,
                'prev_text' => __('', 'textdomain'),
                'next_text' => __('', 'textdomain'),
            ));

            echo $pagination;
            ?>

        <?php endif; ?>
    </div>
</div>

<?php get_footer(); ?>
