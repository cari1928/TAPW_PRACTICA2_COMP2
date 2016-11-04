<?php

namespace Practica2Bundle\Entity;

/**
 * Countrylanguage
 */
class Countrylanguage
{
    /**
     * @var string
     */
    private $language;

    /**
     * @var boolean
     */
    private $isofficial;

    /**
     * @var float
     */
    private $percentage;

    /**
     * @var \Practica2Bundle\Entity\Country
     */
    private $countrycode;


    /**
     * Set language
     *
     * @param string $language
     *
     * @return Countrylanguage
     */
    public function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language
     *
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Set isofficial
     *
     * @param boolean $isofficial
     *
     * @return Countrylanguage
     */
    public function setIsofficial($isofficial)
    {
        $this->isofficial = $isofficial;

        return $this;
    }

    /**
     * Get isofficial
     *
     * @return boolean
     */
    public function getIsofficial()
    {
        return $this->isofficial;
    }

    /**
     * Set percentage
     *
     * @param float $percentage
     *
     * @return Countrylanguage
     */
    public function setPercentage($percentage)
    {
        $this->percentage = $percentage;

        return $this;
    }

    /**
     * Get percentage
     *
     * @return float
     */
    public function getPercentage()
    {
        return $this->percentage;
    }

    /**
     * Set countrycode
     *
     * @param \Practica2Bundle\Entity\Country $countrycode
     *
     * @return Countrylanguage
     */
    public function setCountrycode(\Practica2Bundle\Entity\Country $countrycode = null)
    {
        $this->countrycode = $countrycode;

        return $this;
    }

    /**
     * Get countrycode
     *
     * @return \Practica2Bundle\Entity\Country
     */
    public function getCountrycode()
    {
        return $this->countrycode;
    }
}
