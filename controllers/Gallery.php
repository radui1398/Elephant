<?php

/**
 * Class Gallery
 *
 * Gallery este realizat pe baza de Repeater. Se foloseste exact la fel.
 * Atribute disponibile:
 * _url - url-ul catre imagine
 * _alt - alt-ul imaginii
 * _caption - caption pentru imagine
 * _sizes_custom-size - imaginea pe dimensiunea custom-size
 */
class Gallery extends Repeater
{
    public function endLoop()
    {
        $gallery = $this->getRepeater();
        $loopContent = ob_get_clean();
        $content = '';

        if (!empty($gallery)) {
            foreach ($gallery as $image) {
                $string = preg_replace_callback('/{{((?:[^}]|}[^}])+)}}/', function ($match) use ($image) {
                    if($match[1] == 'url')
                        return esc_url($image['url']);
                    if($match[1] == 'alt')
                        return $image['alt'];
                    if($match[1] == 'caption')
                        return $image['caption'];
                    return $image['sizes'][$match[1]];
                }, $loopContent);
                $content .= $string;
            }
        }
        $this->setContent($content);
        ob_start();
    }
}