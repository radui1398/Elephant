<?php

include 'pages/components/page-head.php';
include 'controllers/Header.php';

/*
 * Options:
 * + SetHeaderColor($color);
 * + SetBodyColor($color);
 * + SetHeaderClass($class);
 * + SetBodyClass($class);
 * + SetBeforeHeaderHTML($html);
 * + setHeaderHTML($html);
 */
$header = new Header();

if(!is_front_page()) {
    $header->setHeaderClass('inner-header');
    $header->setBodyClass('inner-page');
}
$header->generate();
