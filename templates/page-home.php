<?php
/**
 * Template Name: Home Page Template
 */
defined('ABSPATH') or die('Direct access is forbidden!');
include('parts/page-utils.php');

get_header(); ?>

<?php

$repeater = new Repeater('repeater');
$repeater->startLoop();
?>
    {{container_group_image_url}}
<?php
$repeater->endLoop();
$repeater->finish();
?>

<?php get_footer(); ?>