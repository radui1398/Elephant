<?php
defined('ABSPATH') or die('Direct access is forbidden!');

include('pages/components/page-utils.php');
get_header();
$postID = get_the_ID();
?>

<div class="page">
    <div class="container">
        <?php yoastBreadcrumb() ?>
        <h1 class="page-title"><?php indexTitle() ?></h1>
        <?php singlePageContent(); ?>
    </div>
</div>

<?php get_footer(); ?>
