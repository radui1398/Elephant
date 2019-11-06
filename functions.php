<?php

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
# Configuration
require_once TEMPLATEPATH . '/framework/config.php';






////////////////////////////////////////////////////

//$homeACF =  new Scorpio('Options','options','Edit Content','fields-home.php');

////////////////////////////////////////////////////


$plugins = new Enqueue();
$plugins->addCSS('fontawesome-all.min');
$plugins->addFont('fonts.css');
$plugins->addJS('modernizr_2.8.3');
$plugins->addPlugin('hc-navmenu');
$plugins->addPlugin('slick');
$plugins->addCSS('slick-theme');
$plugins->addCSS('hover-min');
$plugins->addPlugin('jquery.fancybox.min');
$plugins->addPlugin('thumbs');
$plugins->init();

$theme = new Theme();

$theme->setAjax(true);
$theme->setAutoHomepage(true);
$theme->setHideAdminBar(false);
$theme->setTodo(false);
$theme->setWoocommerce(false);
$theme->setSidebar('Article Sidebar');
$theme->customThumbnailSize(1400,475,true);

$theme->imageSize('homepage-gallery', 222, 192, true);

//ACF Pages
$theme->addControlPage('Footer','Footer');
$theme->addControlPage('Header','Header');
$theme->addControlPage('General','General');
$theme->addControlPage('Team','Team');
$theme->addControlPage('Blog','Blog');

$theme->init();

$headerMenu = new Menu('header_menu','Header Menu', array('container'=> ''));
$footerMenu = new Menu('footer_menu', 'Footer Menu', array('container' => ''));

