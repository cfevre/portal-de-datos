<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entities\Page
 */
class Page
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
     * @var boolean $restricted
     */
    private $restricted;

    /**
     * @var text $content
     */
    private $content;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $navitem;

    public function __construct()
    {
        $this->navitem = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Page
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
     * @return Page
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
     * Set restricted
     *
     * @param boolean $restricted
     * @return Page
     */
    public function setRestricted($restricted)
    {
        $this->restricted = $restricted;
        return $this;
    }

    /**
     * Get restricted
     *
     * @return boolean 
     */
    public function getRestricted()
    {
        return $this->restricted;
    }

    /**
     * Set content
     *
     * @param text $content
     * @return Page
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * Get content
     *
     * @return text 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Add navitem
     *
     * @param Entities\NavItem $navitem
     * @return Page
     */
    public function addNavItem(\Entities\NavItem $navitem)
    {
        $this->navitem[] = $navitem;
        return $this;
    }

    /**
     * Get navitem
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getNavitem()
    {
        return $this->navitem;
    }
}