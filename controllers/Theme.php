<?php

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

class Theme
{
    private $todo = true;
    private $ajax;
    private $autoHomepage;
    private $hideAdminBar;
    private $woocommerce;
    private $thumbnailWidth;
    private $thumbnailHeight;
    private $thumbnailCrop;
    private $sidebar;
    private $acfPages = array();

    public function __construct()
    {
    }

    /**
     * @return mixed
     */
    public function getTodo()
    {
        return $this->todo;
    }

    /**
     * @param mixed $todo
     */
    public function setTodo($todo)
    {
        $this->todo = $todo;
    }

    /**
     * @return mixed
     */
    public function getAjax()
    {
        return $this->ajax;
    }

    /**
     * @param mixed $ajax
     */
    public function setAjax($ajax)
    {
        $this->ajax = $ajax;
    }

    /**
     * @return mixed
     */
    public function getAutoHomepage()
    {
        return $this->autoHomepage;
    }

    /**
     * @param mixed $autoHomepage
     */
    public function setAutoHomepage($autoHomepage)
    {
        $this->autoHomepage = $autoHomepage;
    }

    /**
     * @param mixed $sidebar
     */
    public function setSidebar($sidebar)
    {
        $this->sidebar = $sidebar;
    }



    /**
     * @return mixed
     */
    public function getHideAdminBar()
    {
        return $this->hideAdminBar;
    }

    /**
     * @param mixed $hideAdminBar
     */
    public function setHideAdminBar($hideAdminBar)
    {
        $this->hideAdminBar = $hideAdminBar;
    }

    /**
     * @return mixed
     */
    public function getWoocommerce()
    {
        return $this->woocommerce;
    }

    /**
     * @param mixed $woocommerce
     */
    public function setWoocommerce($woocommerce)
    {
        $this->woocommerce = $woocommerce;
    }

    public function init()
    {
        if ($this->todo == true)
            add_action('admin_notices', array($this, 'todo_notice'));
        if ($this->ajax == true)
            add_action('wp_head', array($this, 'add_localize_script'), 999);
        if ($this->autoHomepage == true)
            $this->createHomepage();
        if ($this->hideAdminBar == true)
            add_filter('show_admin_bar', array($this, 'hide_admin_bar'));
        if ($this->woocommerce == true)
            add_action('after_setup_theme', array($this, 'mytheme_add_woocommerce_support'));
        if ($this->thumbnailWidth && $this->thumbnailHeight)
            add_action('after_setup_theme', array($this,'extraThemeSettings'));

        if($this->sidebar)
            if ( function_exists('register_sidebar') )
                register_sidebar(array(
                        'name' => $this->sidebar,
                        'before_widget' => '<div class = "theme-sidebar">',
                        'after_widget' => '</div>',
                        'before_title' => '<h3>',
                        'after_title' => '</h3>',
                    )
                );


        if( function_exists('acf_add_options_page') && !empty($this->acfPages) ) {

            // add parent
            $parent = acf_add_options_page(array(
                'page_title' 	=> 'Edit Content',
                'menu_title' 	=> 'Edit Content',
                'icon_url'     => 'dashicons-layout',
                'redirect' 		=> true
            ));

            foreach($this->acfPages as $page){
                // add sub page
                acf_add_options_sub_page(array(
                    'page_title' 	=> $page['title'],
                    'menu_title' 	=> $page['name'],
                    'parent_slug' 	=> $parent['menu_slug'],
                ));
            }
        }
    }


    public function createHomepage()
    {
        if (isset($_GET['activated']) && is_admin()) {

            $new_page_title = 'Homepage';
            $new_page_template = 'templates/page-home.php';

            $page_check = get_page_by_title($new_page_title);
            $new_page = array(
                'post_type' => 'page',
                'post_title' => $new_page_title,
                'post_content' => '',
                'post_status' => 'publish',
                'post_author' => 1,
            );
            if (!isset($page_check->ID)) {
                $new_page_id = wp_insert_post($new_page);
                if (!empty($new_page_template)) {
                    update_post_meta($new_page_id, '_wp_page_template', $new_page_template);
                }
            }
        }
    }

    public function mytheme_add_woocommerce_support()
    {
        add_theme_support('woocommerce');
    }


    public function todo_notice()
    {
        include TEMPLATEPATH . '/framework/todo.php';
    }

    public function add_localize_script()
    {
        ?>
        <script type="text/javascript">
            var jsHomeUrl = '<?php echo home_url(); ?>';
            var ajaxUrl = "<?php echo admin_url('admin-ajax.php') ?>";
        </script>
        <?php
    }


    public function hide_admin_bar()
    {
        return false;
    }

    public function imageSize($name,$width,$height,$crop = false){
        add_image_size($name, $width, $height, $crop);
    }

    public function customThumbnailSize($width,$height,$crop = false){
        $this->thumbnailWidth = $width;
        $this->thumbnailHeight = $height;
        $this->thumbnailCrop = $crop;
    }

    public function extraThemeSettings(){
        add_theme_support('post-thumbnails');
        set_post_thumbnail_size($this->thumbnailWidth, $this->thumbnailHeight, $this->thumbnailCrop);
    }

    public function addControlPage($pageTitle,$menu_title){
        $page = array("title" => $pageTitle, "name" => $menu_title);
        array_push($this->acfPages,$page);
    }

    public function enableDebug(){
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }
}

