<?php

/**
 * Class Menu
 *
 * Simplifica utilizarea meniurilor din wordpress.
 *
 * Exemplu: $headerMenu = new Menu('header_menu','Header Menu', array('container'=> ''));
 * header_menu - va fi locatia meniului ce apare in back-end wordpress
 * 'Header Menu' - va fi numele meniului ce apare in back-end wordpress
 * array() - este acelasi array folosit si la meniul clasic unde adaugam optiuni pentru meniu.
 *
 * Acum pentru a genera meniul, pe pagina principala de exemplu, adaugam:
 * + global $headerMenu pentru a prelua variabila in care am salvat meniul.
 *
 * Apoi folosim una dintre metode:
 * $header->printMenu() pentru a afisa direct (echo)
 * $header->getMenu() pentru a salva intr-o variabila meniul
 *
 */

class Menu
{
    private $name;
    private $location;
    private $options;

    public function __construct($location,$name, $options = null)
    {
        $this->name = $name;
        $this->location = $location;
        $this->options = $options;

        # register navigation menus
        $this->registerMenu();

        add_action('after_setup_theme', array($this,'registerMenu'));
    }

    public function registerMenu(){
        register_nav_menu($this->location, $this->name);
    }

    public function printMenu(){
        $this->options['theme_location'] = $this->location;
        $this->options['echo'] = true;
        wp_nav_menu($this->options);
    }

    public function getMenu(){
        $this->options['theme_location'] = $this->location;
        $this->options['echo'] = false;
        return wp_nav_menu($this->options);
    }

}