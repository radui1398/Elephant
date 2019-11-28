<?php

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

class Repeater
{
    private $repeater;
    private $header;
    private $footer;
    private $content = '';
    private $key = 0;

    public function __construct($repeater, $option = null)
    {
        if (!$option)
            $this->repeater = _f($repeater);
        else
            $this->repeater = _f($repeater, $option);
        ob_start();
    }

    public function startLoop()
    {
        $this->header = ob_get_clean();
        ob_start();
    }

    public function endLoop()
    {
        $loopContent = ob_get_clean();
        if (!empty($this->repeater)) {
            foreach ($this->repeater as $key=>$element) {
                $string = preg_replace_callback('/{{((?:[^}]|}[^}])+)}}/', function ($match) use ($element,$key) {
                    if (($php = str_replace('php: ', '', $match[1])) != $match[1]){
                        return eval($php);
                    }
                    if (($href = str_replace('_url', '', $match[1])) != $match[1]) {
                        return ($element[$href]['url']);
                    }
                    if (($text = str_replace('_title', '', $match[1])) != $match[1]) {
                        return ($element[$text]['title']);
                    }
                    if (($alt = str_replace('_alt', '', $match[1])) != $match[1]) {
                        return ($element[$alt]['alt']);
                    }
                    if (($group = str_replace('_group', '', $match[1])) != $match[1]) {
                        $groupElement = explode('_',$group);
                        return ($element[$groupElement[0]][$groupElement[1]]);
                    }
                    if(($image = str_replace('_sizes','', $match[1])) != $match[1]){
                        $imageSize = explode('_', $image);
                        return ($element[$imageSize[0]]['sizes'][$imageSize[1]]);
                    }
                    return ($element[$match[1]]);
                }, $loopContent);
                $this->content .= $string;
            }
        }
        ob_start();
    }

    public function finish()
    {
        $this->footer = ob_get_clean();
        if (!empty($this->repeater)) {
            echo $this->header;
            echo $this->content;
            echo $this->footer;
        }
    }

    /**
     * @return mixed
     */
    public function getRepeater()
    {
        return $this->repeater;
    }

    /**
     * @void
     * @param $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

}