<?php


/**
 * Class Image
 *
 * Instructiuni utilizare:
 *
 * Initializare ACF:
 *  $image = Image::createACF(field-name, default, options)
 *      + field-name - numele field-ului
 *       + default - true, in caz ca field-ul nu are o imagine setata se va genera una automat in functie de size
 *                - false, nu se adauga imagine default
 *      + options - 1, pentru field din pagina de optiuni
 *                - postID, pentru un post anume
 *                - null, valoarea default, se preia din pagina actuala
 *
 * Initializare Feature Image:
 * $image = Image::createFeaturedImage($id, $default)
 *      + $id - id-ul post-ului
 *      + default - true, in caz ca post-ul nu are o imagine setata se va genera una automat in functie de size
 *                - false, nu se adauga imagine default
 *
 * Pentru a genera o image de background adica un atribut style="etc"...
 *      Ex: <div class="bg" <?php echo $image->printBackground(); ?> >
 * Pentru a genera o imagine <img src="..">
 *      Ex: <?php echo $image->printImage(); ?>
 * Pentru a seta un size predefinit:
 *      Ex: $image->setSize('size-ul meu')
 */


class Image
{
    private $id; # required for featured
    private $field; # required for acf
    private $size;
    private $default;
    private $class;
    private $replace;

    public $url;
    public $title;
    public $alt;
    public $caption;
    public $width;
    public $height;

    private function __construct()
    {

    }

    private function createACF($fieldName, $options, $default)
    {
        $field = _f($fieldName, $options);
        if($default == 1){
            $this->replace = true;
        }
        else{
            if($default)
                $this->default = $default;
        }
        $this->url = $field['url'];
        $this->title = $field['title'];
        $this->alt = $field['alt'];
        $this->caption = $field['caption'];

        if (!$field && $this->replace) {
            $this->url = 'https://via.placeholder.com/1920x1080';
        }
    }

    private function createFeaturedImage($id, $default)
    {
        $this->id = $id;
        if($default == 1){
            $this->replace = true;
        }
        else{
            if($default)
                $this->default = $default;
        }
        $this->size = 'full';
        $this->url = wp_get_attachment_image_src(get_post_thumbnail_id($this->id), $this->size)[0];
        if($this->url) {
            $this->alt = get_post_meta($this->id, '_wp_attachment_image_alt', TRUE);
            $this->title = get_the_title($this->id);
            $this->caption = wp_get_attachment_caption($this->id);
        }
        else{
            if($this->default)
                $this->url = $this->default;
            else
                if($this->replace)
                    $this->url = 'https://via.placeholder.com/1920x1080';
        }
    }

    public static function ACF($fieldName, $default = false, $options = null)
    {
        $instance = new self();
        $instance->createACF($fieldName, $options, $default);
        return $instance;
    }

    public static function Featured($default = false, $id = null)
    {
        if (!$id) {
            $id = get_the_ID();
        }

        $instance = new self();
        $instance->createFeaturedImage($id, $default);
        return $instance;
    }

    public function setSize($size)
    {
        if ($this->field) {
            $this->size = $size;
            $this->url = $this->field['sizes'][$size];
            $this->width = $this->field['sizes'][$size . '-width'];
            $this->height = $this->field['sizes'][$size . '-height'];

            if (!$this->field && ($this->replace || $this->default)) {
                if($this->replace)
                    $this->url = 'https://via.placeholder.com/' . $this->width . 'x' . $this->height;
                else
                    $this->url = $this->default;
            }
        } else {
            $this->size = $size;
            $image = wp_get_attachment_image_src(get_post_thumbnail_id($this->id), $size);
            $this->url = $image[0];
            if (!$this->url && ($this->replace || $this->default)) {
                if ($this->replace) {
                    if($size != 'full') {
                        $size = $this->get_image_sizes($size);
                        $this->width = $size['width'];
                        $this->height = $size['height'];
                        $this->url = 'https://via.placeholder.com/' . $this->width . 'x' . $this->height;
                    }
                    else{
                        $this->url = 'https://via.placeholder.com/1920x1080';
                    }
                }
                else{
                    $this->url = $this->default;
                }
            }
        }
    }

    private function get_image_sizes( $size = '' ) {
        $wp_additional_image_sizes = wp_get_additional_image_sizes();

        $sizes = array();
        $get_intermediate_image_sizes = get_intermediate_image_sizes();

        // Create the full array with sizes and crop info
        foreach( $get_intermediate_image_sizes as $_size ) {
            if ( in_array( $_size, array( 'thumbnail', 'medium', 'large' ) ) ) {
                $sizes[ $_size ]['width'] = get_option( $_size . '_size_w' );
                $sizes[ $_size ]['height'] = get_option( $_size . '_size_h' );
                $sizes[ $_size ]['crop'] = (bool) get_option( $_size . '_crop' );
            } elseif ( isset( $wp_additional_image_sizes[ $_size ] ) ) {
                $sizes[ $_size ] = array(
                    'width' => $wp_additional_image_sizes[ $_size ]['width'],
                    'height' => $wp_additional_image_sizes[ $_size ]['height'],
                    'crop' =>  $wp_additional_image_sizes[ $_size ]['crop']
                );
            }
        }

        // Get only 1 size if found
        if ( $size ) {
            if( isset( $sizes[ $size ] ) ) {
                return $sizes[ $size ];
            } else {
                return false;
            }
        }
        return $sizes;
    }

    public function setDefaultImage($imageURL)
    {
        $this->default = $imageURL;
    }

    public function setClass($imageClass)
    {
        $this->class = $imageClass;
    }

    public function printImage()
    {
        echo sprintf('<img src="%s" alt="%s" title="%s">', $this->url, $this->alt, $this->title);
    }

    public function printBackground()
    {
        echo sprintf('style="background-image: url(%s);"', $this->url);
    }

    public function hasImage(){
        if($this->url)
            return true;
        return false;
    }
}
