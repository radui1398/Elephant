<?php
defined('ABSPATH') or die('Direct access is forbidden!');
include('pages/components/page-utils.php');
get_header();
$postCategories = get_categories();
?>

    <div class="page">
        <div class="container">
            <?php yoastBreadcrumb() ?>
            <h1 class="page-title"><?php indexTitle() ?></h1>

            <?php
            if (is_category() || is_home())
                displayCategories($postCategories);
            ?>

            <?php
            global $wp_query;
            $args = array(
                'ignore_sticky_posts' => true,
                'paged' => (get_query_var('paged')) ? absint(get_query_var('paged')) : 1
            );

            if (is_year()) {
                $args['year'] = get_the_time('Y');
            }

            query_posts($args);
            ?>

            <?php if (have_posts()): ?>
                <div class="posts-grid">
                    <div class="row">
                        <?php
                        while (have_posts()):
                            the_post();
                            $postID = get_the_ID();
                            displayPost($postID);
                        endwhile;
                        ?>
                        <div class="col-md-3">
                            <?php
                            filterPostsWithDate();
                            ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-9">
                        <?php
                        $pagination = customPagination(array(
                            'mid_size' => 2,
                            'prev_text' => __('', 'textdomain'),
                            'next_text' => __('', 'textdomain'),
                        ));

                        echo $pagination;
                        ?>
                    </div>
                </div>

            <?php endif; ?>

        </div>
    </div>

<?php get_footer(); ?>
