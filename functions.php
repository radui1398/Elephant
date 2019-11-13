<?php

# Configurare
require_once TEMPLATEPATH . '/framework/config.php';

# Adaugare Plugin-uri
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
$plugins->addCSS('https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css',true);
//$plugins->setVersion('random');
$plugins->init();


# Optiuni tema
$theme = new Theme();

$theme->setAjax(true);
$theme->setAutoHomepage(true);
$theme->setHideAdminBar(false);
$theme->setTodo(false);
$theme->setWoocommerce(false);
#$theme->setSidebar('Article Sidebar');
#$theme->customThumbnailSize(1400,475,true);

$theme->imageSize('homepage-gallery', 222, 192, true);

# Paginile de optiuni ACF
$theme->addControlPage('General','General');

$theme->init();


# Adaugare meniuri
$headerMenu = new Menu('header_menu','Header Menu', array('container'=> ''));
$footerMenu = new Menu('footer_menu', 'Footer Menu', array('container' => ''));

