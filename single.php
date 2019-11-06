<?php
defined('ABSPATH') or die('Direct access is forbidden!');

include('pages/components/page-utils.php');
get_header();
$postID = get_the_ID();
$shareButton = _f('share_button',1);
$sharePlatforms = _f('where_to_share',1);
$sidebar = _f('show_sidebar');
?>

    <div class="page meet-the-team">
        <div class="container">
            <?php yoastBreadcrumb() ?>
            <h1 class="page-title"><?php indexTitle() ?></h1>
            <div class="row">
                <div class="<?=($sidebar)?'col-md-9':'col-md-12'?>">
                    <?php singlePageContent(); ?>
                    <div class="share-article-button">

                        <a href="#" id="share-button"><i class="fas fa-share"></i> <?=$shareButton?></a>
                        <?php if(!empty($sharePlatforms)):?>
                            <?php foreach($sharePlatforms as $platform):?>
                                <a class="brand" target="_blank" rel="nofollow" href="<?=share_network($platform, $postID);?>"><i class="fab fa-<?=$platform?>"></i></a>
                            <?php endforeach;?>
                        <?php endif;?>
                    </div>
                </div>
                <?php if($sidebar):?>
                <div class="col-md-3">
                    <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar("Article Sidebar")) : ?>
                    <?php endif; ?>
                </div>
                <?php endif;?>
            </div>
        </div>
    </div>

<?php get_footer(); ?>
