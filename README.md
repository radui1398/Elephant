# Elephant - Un framework nu chiar atat de mare

##### $ Updates
    --- 13.01.2020
    + Testare update.bat
    --- 06.01.2020
    + Rezolvare BUG Admin Bar 
        - Fisiere modificate
            ~ framework/security.php
    --- 28.11.2019
    + Adaugare suport image-size pentru Repeater
        - Fisiere modificate
            ~ controllers/Repeater.php
    --- 26.11.2019
    + Bugfix Enqueue 
        - Fisiere modificate
            ~ controllers/Enqueue.php
    --- 21.11.2019
    + Adaugare Updater (ruleaza prin update.bat)
        - Fisiere adaugate:
            ~ update.bat
            ~ framework/update/update1.bat
            ~ framework/update/update2.bat
    + Adaugare functie util - _fp() - print rapid acf  
        - Fisiere editate:
            ~ framework/util.php
    + BUGFIX createLink()
        - Fisiere editate:
            ~ framework/util.php
            
    --- 20.11.2019
    + Adaugare Controller Image (control pentru imagini ACF/Featured)
        - Fisiere adaugate:
            ~ controllers/Image.php
        - Fisiere editate:
            ~ framework/config.php
    + Stergere Controller Header (era prea complicat fara nici un scop)
        - Fisiere editate:
            ~ framework/config.php
            ~ header.php
        - Fisiere sterse:
            ~ templates/parts/page-head.php
            ~ templates/parts/page-header.php
            ~ controllers/Header.php
    + Sterge SCSS Default (stilul de scriere/baza de plecare scss difera in functie de dev(
        - Fisiere sterse:
            ~ tot din folderul scss
        - Fisiere editate:
            ~ style.scss
    + Stergere parts inutile
        - Fisiere sterse:
            ~ parts/blog-post.php
            ~ parts/single-page-content.php
        - Fisiere editate:
            ~ index.php
            ~ single.php
            ~ page.php    
            
    --- 04.11.2019
    + Adaugare CDN Enqueue - Fisier Editat: controllers/Enqueue.php
    + Adaugare Versiune Enqueue - Fisier Editat: controllers/Enqueue.php
    + Adaugare Debug Mode (Afisare Erori PHP) - Fisier Editat: controllers/Theme.php

### Structura foldere:

    -   controllers
    -   framework 
    -   pages
        + parts
    -   assets
        +   css
        +   fonts
        +   images
        +   js
    -   scss

### Sfaturi utilizare:

    - Modularizarea este cheia. Elementele comune pot fi adaugate in folderul parts.
    - Imaginile grupate dupa extensie in assets.
    - Setarile de wordpress extra vor fi adaugate la sfarsitul fisierului config.php 

### Functii interesante:
    + Templetizare Repeater
    + Templetizare Gallery
    + Generare Meniu
    + Control rapid al temei
   
### Ce functii poti folosi usor si rapid?
    + getImage('path') - path va fi calea catre imagine pornind din folderul images
        Ex: getImage('png/logo.png');
        Returneaza: String (URL)
        
        
    + _f(field,options) - field va fi numele field-ului iar options argumentul
        ce defineste pagina de optiuni/id-ul.
        Ex: _f('hero_title');
            _f('hero_title',1); // scurtatura pentru _f('hero_title','options')
            _f('hero_title,$postID);
        Returneaza: valoare/array (depinde de field)
        
        
    + phoneNumber(tel) - tel va fi numarul de telefon. Functia curata numarul de telefon
        de caracterele invalide.
        Returneaza: String
        
        
    + public_dir() - Functie pentru preluarea folder-ului assets.
        Ex: include public_dir() . '/ceva.extensie';
        Returneaza: String (Path-ul catre folder-ul assets fara '/' la urma)
        
        
    +  yoastBreadcrumb() - Functie pentru afisarea breadcrumb-ului yoast.
        Necesita Yoast instalat.
        Afiseaza: Breadcrumbs.
### Repeater:
    /**
     * Class Repeater
     *
     * Clasa Repeater este utilizata pentru a simplifica folosirea Repeater-ului din ACF.
     * Exemplu:
     * Sa spunem ca am realizat un repeater 'list' ce contine elemente ['item','icon']
     *
     * 1.Vom incepe prin a initializa repeater-ul:
     * $repeater = new Repeater('list') sau new Repeater('list', $postID / 1(pentru pagina de optiuni))
     * Dupa intializare putem scrie orice cod dorim sa apara inainte de loop daca repeater-ul are elemente.
     *
     * 2.Pentru a incepe loop-ul:
     * $repeater->startLoop()
     *
     * 3.Pentru a finaliza structura loop-ului:
     * $repetaer->endLoop()
     *
     * Intre 3 si 4 putem scrie orice cod dorim sa reprezinte loop-ul nostru.
     * In loop pentru a simplifica munca am templetizat folosirea ACF-ului.
     * Astfel pentru 'item' si 'icon' vom utiliza urmatoarea scriere {{element}} sau {{element_optiune}}
     *
     * Exemplu:
     * - icon (de tipul Image) - <img src="{{icon_url}}" alt={{icon_alt}}>
     * - item (de tipul Text) - <h1>{{item}}</h1>
     *
     * Alte exemple:
     * - link - <a href={{link_url}} > {{link_title}} </a>
     * - group (ex grupul 'gp') - {{gp_group_element1}}, {{gp_group_element2}} .. etc
     *      _group_ poate fi folosit pentru orice optiune.
     *      Spre exemplu pentru elementul de 'link' de tip link putem accesa
     *      tip-ul de target prin {{link_group_target}} pentru ca asta va fi automat
     *      transformat in link['target'].
     * - sizes - {{image_sizes_custom-size}} 
     *      _sizes_ poate fi folosit pentru size-uri custom
     *      unde "custom-size" va fi size-ul setat de noi.
     *
     * 4. Dupa $repeater->endLoop() putem adauga cod-ul ce dorim sa apara dupa loop daca repeater-ul are elemente.
     *
     * 5. Pentru a finaliza repeater-ul vom folosi:
     * $repeater->finish()
     *
     *
     */
     
### Gallery: 
    /**
     * Class Gallery
     *
     * Gallery este realizat pe baza de Repeater. Se foloseste exact la fel.
     * Atribute disponibile:
     * url - url-ul catre imagine
     * alt - alt-ul imaginii
     * caption - caption pentru imagine
     * sizes_custom-size - imaginea pe dimensiunea custom-size
     */
     
### Generare Meniu:
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

### Control Tema:
    /**
     * Class Theme
     *
     * Clasa Theme ajuta la controlarea temei.
     * Pentru a folosi aceste optiuni trebuie doar sa urmam cei 3 pasi:
     *
     * 1. Setam o variabila pentru a controla tema:
     * $theme = new Theme();
     *
     * 2. Adaugam ce optiuni dorim (cele cu flag sunt by default = false)
     * $theme->setTodo(true)
     * $theme->setAutoHomepage(true)
     * $theme->imageSize('dimensiune-noua', 222, 192, true);
     * $theme->addControlPage('General','General');
     *
     * 3. Dupa setarea optiunilor initializam tema:
     * $theme->init()
     *
     * Metode:
     * setTodo(true/false) - Daca flag-ul este true notice-ul to/do ce are continutul in fisierul framework/todo.php va fi activat
     * setAjax(true/false) - Daca flag-ul este true va fi activat suport-ul pentru ajax
     * setAutoHomepage(true/false) - Daca flag-ul este true atunci la activarea temei va fi realizata automat o pagina Homepage ce foloseste template-ul page-home.php
     * setSidebar(name) - Seteaza sidebar-ul cu numele 'name' pentru widget-uri
     * setHideAdminBar(true/false) - Daca flag-ul este true atunci bara admin-ului din front-end va fi ascunsa.
     * setWoocommerce(true/false) - Daca flag-ul este true atunci suportul pentru woocommerce va fi activat.
     *
     * imageSize($name,$width,$height,$crop = false) - Adauga o noua dimensiune pentru imagine.
     * addControlPage($pageTitle,$menu_title) - Adauga o noua pagina de optiuni ACF.
     * enableDebug() - Afiseaza toate erorile PHP
     */

## Functii utile
   
    <?php
    /**
     * Aici sunt prezente toate functiile descrise in readme
     */
    
    /**
     * Aceasta functie curata un numar de telefon pentru a putea fi utilizat in href.
     * Ex: 0760.234.234 -> 0760234234
     *
     * @param $args - numarul de telefon
     * @return string|string[]|null
     */
    function phoneNumber($args)
    {
        $str = $args;
        $str = preg_replace('/[^+0-9a-zA-Z]/', '', $str);
        return $str;
    }
    
    /**
     * Aceasta functie preia un text si il curata de caractere nedorite pentru a putea fi folosit ca si "slug".
     *
     * @param $text
     * @return false|string|string[]|null
     */
    function slugify($text)
    {
        $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
        $text = trim($text, '-');
        if (function_exists('iconv')) {
            $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        }
        $text = strtolower($text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        if (empty($text)) {
            return 'n-a';
        }
        return $text;
    }
    
    
    /**
     * Aceasta functie returneaza anul curent.
     * Formatul difera in functie de parametrul $year.
     * Formate posibile
     * 2019
     * 2017 - 2019
     *
     * @param string $year
     * @return false|int|string
     */
    function copyright($year = 'auto')
    {
        if (intval($year) == 'auto') {
            $year = date('Y');
        }
        if (intval($year) == date('Y')) {
            return intval($year);
        }
        if (intval($year) < date('Y')) {
            return intval($year) . ' - ' . date('Y');
        }
        if (intval($year) > date('Y')) {
            return date('Y');
        }
    }
    
    /**
     * Aceasta functie returneaza o imagine din folderul images.
     * Exemplu de folosire:
     * getImage('jpg/bg.jpg')
     * getImage('gif/ajax-loader.gif)
     *
     * @param $img - Extensie/Imaginea.extensie
     * @return string
     */
    function getImage($img)
    {
        return get_template_directory_uri() . "/assets/images/" . $img;
    }
    
    
    /**
     * Aceasta functie primeste ca si parametru un obiect ACF de tip-ul link si returneaza un <a>
     * Exemplu de returnare:
     * <a href="link_specificat" class="parametrul class" target="target_specificat" rel="rel_specificat" title="title_specificat">Nume specificat</a>
     *
     * @param $object - obiect ACF
     * @param null $class - clasa link-ului
     * @return string
     */
    function createLink($object, $class = null)
    {
        $link = '<a href="';
        $link .= esc_url($object['url']);
        $link .= '" target="';
        $link .= $object['target'] ? $object['target'] : '_self';
        $link .= '" class="';
        if ($class) {
            if (!is_array($class)) {
                $link .= $class;
            } else {
                foreach ($class as $cls) {
                    $link .= $cls . ' ';
                }
            }
        }
    
        $link .= '">';
        $link .= $object['title'];
        $link .= '</a>';
        return $link;
    }
    
    /**
     * Aceasta functie poate returna:
     * Pentru $type='img' : <img src....>
     * Pentru $type='bg' : style="background-image:url()...."
     *
     * @param string id        => is the main ID
     * @param string size        => the size of the image / default value = full
     * @param string type        => img or bg
     * @param string class    => extra classes added for img tag
     * @param $no_img => default img
     * @return string img tag or style background image
     */
    function featureImage($id = "", $size = "full", $type = "", $class = "", $no_img)
    {
        if (!$id) {
            $id = get_the_ID();
        }
    
        if (has_post_thumbnail($id)) {
            $img = wp_get_attachment_image_src(get_post_thumbnail_id($id), $size);
            if (!$img)
                $img[0] = $no_img;
            switch ($type) {
                case 'img':
                    return '<img src="' . $img[0] . '" alt="' . esc_html(get_the_post_thumbnail_caption($id)) . '"' . ($class ? ' class="' . $class . '"' : '') . '>';
                    break;
                case 'bg':
                    return 'style="background-image:url(' . $img[0] . ')"';
                    break;
                default:
                    break;
            }
        } else {
            if (!empty($no_img)) {
                switch ($type) {
                    case 'img':
                        return '<img src="' . $no_img . '" alt="">';
                        break;
                    case 'bg':
                        return 'style="background-image:url(' . $no_img . ')"';
                        break;
                    default:
                        break;
                }
            }
        }
    }
    
    
    /**
     * Aceasta functie returneaza link-ul de share al unui post pentru o platforma primita ca si parametru.
     * Ex: shareNetwork('facebook',23)
     *
     * @param $network - nume platforma
     * @param $id - id post
     */
    function shareNetwork($network, $id)
    {
        switch ($network) {
            case 'facebook':
                echo "https://www.facebook.com/sharer/sharer.php?u=" . get_permalink($id);
                break;
            case 'twitter':
                echo "http://twitter.com/home?status=" . get_the_title($id) . "+" . get_permalink($id);
                break;
            case 'linkedin':
                echo "http://www.linkedin.com/shareArticle?mini=true&url=" . get_permalink($id) . "&title=" . get_the_title($id) . "&source=" . site_url();
                break;
            case 'pinterest':
                $img = wp_get_attachment_image_src(get_post_thumbnail_id($id), 'full');
                if ($img[0]) {
                    echo "http://pinterest.com/pin/create/button/?url=" . get_permalink($id) . "&media={" . $img[0] . "}&description=" . get_the_title($id);
                }
                break;
            default:
                break;
        }
    }
    
    /**
     * Functia public_dir returneaza directorul in care sunt fisierele publice.
     *
     * @return string
     */
    function public_dir()
    {
        return get_template_directory_uri() . '/assets';
    }
    
    
    /**
     * Aceasta functie returneaza valoarea unui camp acf.
     *
     * @param $acfFieldName - ACF Field Name
     * @param bool $acfOptions - If true then get from acf 'options'
     * @return mixed
     */
    function _f($acfFieldName, $acfOptions = false)
    {
        if ($acfOptions === 1)
            return get_field($acfFieldName, 'options');
        if ($acfOptions)
            return get_field($acfFieldName, $acfOptions);
        return get_field($acfFieldName);
    }
    
    /**
     * Aceasta functie afiseaza breadcrumbs-ul activat din pluginul Yoast.
     * Link Plugin: https://ro.wordpress.org/plugins/wordpress-seo/
     */
    function yoastBreadcrumb()
    {
        if (function_exists('yoast_breadcrumb')) {
            yoast_breadcrumb('<div class="breadcrumbs">', '</div>');
        }
    }
    
    /**
     * Aceasta functie returneaza numele arhivei.
     * Folosita in index.php pentru a stabili corect numele paginii.
     */
    function indexTitle()
    {
        if (is_404() || is_category() || is_tag() || is_day() || is_month() || is_year() || is_search()) { ?>
            <?php /* If this is a category archive */
            if (is_category()) { ?>
                <?php single_cat_title(); ?>
                <?php /* If this is a tag archive */
            } elseif (is_tag()) { ?>
                <?php _e('Tag: ', THEME_TEXT_DOMAIN);
                single_tag_title(); ?>
                <?php /* If this is a daily archive */
            } elseif (is_day()) { ?>
                <?php the_time('F jS, Y');
                _e(' Archives ', THEME_TEXT_DOMAIN); ?>
                <?php /* If this is a monthly archive */
            } elseif (is_month()) { ?>
                <?php the_time('F, Y');
                _e(' Archives ', THEME_TEXT_DOMAIN); ?>
                <?php /* If this is a yearly archive */
            } elseif (is_year()) { ?>
                <?php the_time('Y');
                _e(' Archives ', THEME_TEXT_DOMAIN); ?>
                <?php /* If this is an author archive */
            } elseif (is_author()) {
                _e('Author Archive ', THEME_TEXT_DOMAIN); ?>
                <?php /* If this is a paged archive */
            } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {
                _e('Blog Archives ', THEME_TEXT_DOMAIN); ?>
            <?php } elseif (is_search()) { ?>
                <?php _e('Results for: ', THEME_TEXT_DOMAIN);
                the_search_query() ?>
            <?php } ?>
        <?php } else { ?>
            <?php _e('Blog ', THEME_TEXT_DOMAIN);
        }
    }
    
    /**
     * Pe baza paginatiei clasice din wordpress, afiseaza paginatia in query.
     *
     * @param array $args - optiuni paginatie
     * @return string
     */
    function customPagination( $args = array() ) {
        $navigation = '';
    
        // Don't print empty markup if there's only one page.
        if ( $GLOBALS['wp_query']->max_num_pages > 1 ) {
            $args = wp_parse_args(
                $args,
                array(
                    'mid_size'           => 1,
                    'prev_text'          => _x( 'Previous', 'previous set of posts' ),
                    'next_text'          => _x( 'Next', 'next set of posts' ),
                )
            );
    
            // Make sure we get a string back. Plain is the next best thing.
            if ( isset( $args['type'] ) && 'array' == $args['type'] ) {
                $args['type'] = 'plain';
            }
    
            // Set up paginated links.
            $links = paginate_links( $args );
    
            if ( $links ) {
                $navigation = _navigation_markup( $links, 'pagination', '' );
            }
        }
    
        return $navigation;
    }


## TODO:
+   Terminare Scorpio
