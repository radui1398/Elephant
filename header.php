<?php

include 'pages/components/page-head.php';

/**
 * Optiuni Header:
 * + SetHeaderColor($color);
 * + SetBodyColor($color);
 * + SetHeaderClass($class);
 * + SetBodyClass($class);
 * + SetBeforeHeaderHTML($html);
 * + setHeaderHTML($html);
 */
$header = new Header();

# Aici verificam pagina. Daca nu este 'front page' atunci adaugam clasa 'inner' pentru 'page' si 'header'.

if(!is_front_page()) {
    $header->setHeaderClass('inner-header');
    $header->setBodyClass('inner-page');
}

# Generam Header-ul
$header->generate();
