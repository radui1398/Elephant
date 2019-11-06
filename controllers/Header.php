<?php

/**
 * Class Header
 *
 * Utila pentru a customiza header-ul direct din PHP.
 * Metode disponibile:
 * body - getBodyClass() si setBodyClass() ce returneaza/seteaza clasa pentru <body>
 * header - getHeaderClass() si setHeaderClass() ce returneaza/seteaza clasa pentru <header>
 * culoare body - getBodyColor() si setBodyColor() ce returneaza/seteaza culoare de fundal pentru <body>
 * culoare header - getHeaderColor() si setHeaderColor() ce returneaza/seteaza culoarea de fundal pentru <header>
 */

class Header
{
    private $bodyClass = '';
    private $headerClass = '';
    private $bodyColor;
    private $headerColor;

    public function __construct()
    {

    }

    public function generate()
    {
        include TEMPLATEPATH . '/templates/page-header.php';
    }


    /**
     * @return mixed
     */
    public function getBodyClass()
    {
        return $this->bodyClass;
    }

    /**
     * @param mixed $bodyClass
     */
    public function setBodyClass($bodyClass)
    {
        $this->bodyClass = $bodyClass;
    }

    /**
     * @return mixed
     */
    public function getHeaderClass()
    {
        return $this->headerClass;
    }

    /**
     * @param mixed $headerClass
     */
    public function setHeaderClass($headerClass)
    {
        $this->headerClass = $headerClass;
    }

    /**
     * @return mixed
     */
    public function getBodyColor()
    {
        return $this->bodyColor;
    }

    /**
     * @param mixed $bodyColor
     */
    public function setBodyColor($bodyColor)
    {
        $this->bodyColor = $bodyColor;
    }

    /**
     * @return mixed
     */
    public function getHeaderColor()
    {
        return $this->headerColor;
    }

    /**
     * @param mixed $headerColor
     */
    public function setHeaderColor($headerColor)
    {
        $this->headerColor = $headerColor;
    }
}