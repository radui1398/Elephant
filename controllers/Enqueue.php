<?php

/**
 * Class Enqueue
 * Metode:
 * + addCSS - Adauga un nou fisier CSS
 *      Exemplu: $theme->addCSS('slick')
 *      Se ofera doar numele fisierului, fara extensie.
 *      Fisierul trebuie sa fie adaugat in assets/css.
 *      Pentru incarcarea din CDN al doiela argument trebuie sa fie true.
 *
 * + addFont - Adauga lista de fonturi
 *      Exemplu: $theme->addFont('font.css')
 *      Se ofera fisierul css din folderul fonts ce contine toate fonturile folosite.
 *      Fisierul trebuie sa fie adaugat in assets/fonts.
 *      Pentru incarcarea din CDN al doilea argument trebuie sa fie true.
 * + addJS - Adauga un nou fisier JS
 *      Exemplu: $theme->addJS('slick')
 *      Se ofera fisierul js fara extensie.
 *      Fisierul trebuie sa fie adaugat in assets/js.
 *      Se poate adauga si al doilea argument 'true' pentru a se specifica incarcarea in header.
 *      Pentru CDN al treilea argument trebuie setat true.
 * + addPlugin - Adauga un nou plugin
 *      Exemplu: $theme->addPlugin('slick')
 *      Se ofera nume plugin-ului. Metoda va cauta in folderele js/css dupa slick.js/slick.css si le va adauga.
 */


class Enqueue
{
    private $cssFiles = array();
    private $jsFiles = array();
    private $fontFiles = array();
    private $cssCFiles = array();
    private $jsCFiles = array();
    private $fontCFiles = array();

    public function init()
    {
        add_action('wp_enqueue_scripts', array($this, 'enqueue_files'));
    }

    public function addCSS($file, $CDN = false)
    {
        if ($CDN)
            array_push($this->cssCFiles, $file);
        else
            array_push($this->cssFiles, $file);
    }

    public function addFont($file, $CDN = false)
    {
        if ($CDN)
            array_push($this->fontCFiles, $file);
        else
            array_push($this->fontFiles, $file);
    }

    public function addJS($file, $footer = false, $CDN = false)
    {
        if($CDN)
            array_push($this->jsCFiels,array($file,$footer));
        else
            array_push($this->jsFiles, array($file, $footer));
    }

    public function addPlugin($plugin, $footer = false)
    {
        array_push($this->jsFiles, array($plugin, $footer));
        array_push($this->cssFiles, $plugin);
    }


    function enqueue_files()
    {
        # jQuery
        wp_enqueue_script('jquery');

        # CDN Fonts
        foreach ($this->fontCFiles as $font) {
            $fontName = substr(md5(microtime()),rand(0,26),10);
            wp_enqueue_style($fontName . '-font', $font);
        }

        # Fonts
        foreach ($this->fontFiles as $font) {
            wp_enqueue_style(slugify($font) . '-font', public_dir() . '/fonts/' . $font);
        }

        # CDN CSS
        foreach ($this->cssCFiles as $cssFile) {
            $cssFileName = substr(md5(microtime()),rand(0,26),10);
            wp_enqueue_style($cssFileName . '-css', $cssFile);
        }

        # CSS
        foreach ($this->cssFiles as $cssFile) {
            wp_enqueue_style(slugify($cssFile) . '-css', public_dir() . '/css/' . $cssFile . '.css');
        }

        # JS CDN
        foreach ($this->jsCFiles as $jsFile) {
            $jsFileName = substr(md5(microtime()),rand(0,26),10);
            wp_register_script($jsFileName . '-script', $jsFile[0], '', '', $jsFile[1]);
            wp_enqueue_script($jsFileName . '-script', array('jquery'));
        }

        # JS
        foreach ($this->jsFiles as $jsFile) {
            wp_register_script(slugify($jsFile[0]) . '-script', public_dir() . '/js/' . $jsFile[0] . '.js', '', '', $jsFile[1]);
            wp_enqueue_script(slugify($jsFile[0]) . '-script', array('jquery'));
        }



        # Main JavaScript File
        wp_register_script('scripts', public_dir() . '/js/script.js', '', false, true);
        wp_enqueue_script('scripts', array('jquery'));

        # Loads our main stylesheet.
        wp_enqueue_style('site-style', get_stylesheet_uri(), false, '');
    }
}



