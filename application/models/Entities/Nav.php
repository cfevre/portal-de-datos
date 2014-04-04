<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entities\Nav
 */
class Nav
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var string $title
     */
    private $title;

    /**
     * @var string $alias
     */
    private $alias;

    /**
     * @var string $position
     */
    private $position;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $items;

    public function __construct()
    {
        $this->items = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
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
     * Set title
     *
     * @param string $title
     * @return Nav
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set alias
     *
     * @param string $alias
     * @return Nav
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;
        return $this;
    }

    /**
     * Get alias
     *
     * @return string 
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * Set position
     *
     * @param string $position
     * @return Nav
     */
    public function setPosition($position)
    {
        $this->position = $position;
        return $this;
    }

    /**
     * Get position
     *
     * @return string 
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Add items
     *
     * @param Entities\NavItem $items
     * @return Nav
     */
    public function addNavItem(\Entities\NavItem $items)
    {
        $this->items[] = $items;
        return $this;
    }

    /**
     * Get items
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Get published items
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getPublishedItems()
    {
    	$items = array();
    	foreach ($this->items as $key => $item) {
    		if($item->getPublished())
    			$items[] = $item;
    	}
      return $items;
    }
}