<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="citiesspain")
 */
class citiespoland
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $miasto;

    /**
     @ORM\Column(type="integer")
     */
    private $populacja;

    /**
     * @ORM\Column(type="decimal")
     */
    private $lat;

    /**
     * @ORM\Column(type="decimal")
     */
    private $lng;


    /**
     * Get id
     *
     * @return integer 
     */
     public function getId()
    {
        return $this->id;
    }

    /**
     * Set miasto
     *
     * @param string $miasto
     * @return citiespoland
     */
    public function setMiasto($miasto)
    {
        $this->miasto = $miasto;

        return $this;
    }

    /**
     * Get miasto
     *
     * @return string 
     */
    public function getMiasto()
    {
        return $this->miasto;
    }

    /**
     * Set populacja
     *
     * @param integer $populacja
     * @return citiespoland
     */
    public function setPopulacja($populacja)
    {
        $this->populacja = $populacja;

        return $this;
    }

    /**
     * Get populacja
     *
     * @return integer 
     */
    public function getPopulacja()
    {
        return $this->populacja;
    }

    /**
     * Set lat
     *
     * @param string $lat
     * @return citiespoland
     */
    public function setLat($lat)
    {
        $this->lat = $lat;

        return $this;
    }

    /**
     * Get lat
     *
     * @return string 
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * Set lng
     *
     * @param string $lng
     * @return citiespoland
     */
    public function setLng($lng)
    {
        $this->lng = $lng;

        return $this;
    }

    /**
     * Get lng
     *
     * @return string 
     */
    public function getLng()
    {
        return $this->lng;
    }
}
