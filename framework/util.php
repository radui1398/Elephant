<?php
/**
 * Aici sunt prezente toate functiile descrise in readme
 */

/**
 * Aceasta functie este folositoare pentru string-urile mai mari de o anumita lungime.
 * Functie folositoare pe front-end, va adauga "..." la sfarsitul limitarii.
 *
 * @param $string
 * @param int $length
 * @return string
 */
function stringLimiter($string, $length = 50){

    if(strlen($string) > $length){
        return substr($string, 0, $length - 3) . '...';
    }

    return $string;
}


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
 * Aceasta functie returneaza permalink-ul unei pagini.
 * Exemplu de folosire:
 *
 * getPageLink(47) # cu postId
 * getPageLink($page) # cu obiectul page
 * getPageLink('map','slug') # in functie de slug
 * getPageLink('Map', 'title') # in functie de title
 * getPageLink() # va return home_url()
 *
 * @param $page - id/pageObject/string
 * @param $type - string ('id','slug','title')
 * @return string
 */
function getPageLink($page = null, $type = 'id')
{
    $link = home_url();

    switch ($type) {
        case 'id':
            $link = get_page_link($page);
            break;
        case 'slug':
            $link = get_permalink(get_page_by_path($page));
            break;
        case 'title':
            $link = get_permalink(get_page_by_title($page));
            break;
        default:
    }

    return $link;
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
    if (!empty($object)) {
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
    } else {
        $link = '';
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
 * Aceasta functie afiseaza valoarea unui camp acf.
 *
 * @param $acfFieldName - ACF Field Name
 * @param bool $acfOptions - If true then get from acf 'options'
 * @print acf
 */
function _fp($acfFieldName, $acfOptions = false)
{
    echo _f($acfFieldName, $acfOptions);
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
function customPagination($args = array())
{
    $navigation = '';

    // Don't print empty markup if there's only one page.
    if ($GLOBALS['wp_query']->max_num_pages > 1) {
        $args = wp_parse_args(
            $args,
            array(
                'mid_size' => 1,
                'prev_text' => _x('Previous', 'previous set of posts'),
                'next_text' => _x('Next', 'next set of posts'),
            )
        );

        // Make sure we get a string back. Plain is the next best thing.
        if (isset($args['type']) && 'array' == $args['type']) {
            $args['type'] = 'plain';
        }

        // Set up paginated links.
        $links = paginate_links($args);

        if ($links) {
            $navigation = _navigation_markup($links, 'pagination', '');
        }
    }

    return $navigation;
}
