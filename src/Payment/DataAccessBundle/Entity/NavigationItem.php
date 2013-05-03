<?php

namespace Payment\DataAccessBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * NavigationItem
 */
class NavigationItem
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $parentId;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $linkId;

    /**
     * @var string
     */
    private $icon;

    /**
     * @var integer
     */
    private $ordering;

    /**
     * @var boolean
     */
    private $isActive;

    /**
     * @var integer
     */
    private $level;

    /**
     * @var string
     */
    private $style;

    /**
     * @var string
     */
    private $alt;

    /**
     * @var string
     */
    private $roles;


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
     * Set parentId
     *
     * @param integer $parentId
     * @return NavigationItem
     */
    public function setParentId($parentId)
    {
        $this->parentId = $parentId;
    
        return $this;
    }

    /**
     * Get parentId
     *
     * @return integer 
     */
    public function getParentId()
    {
        return $this->parentId;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return NavigationItem
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
     * Set linkId
     *
     * @param string $linkId
     * @return NavigationItem
     */
    public function setLinkId($linkId)
    {
        $this->linkId = $linkId;
    
        return $this;
    }

    /**
     * Get linkId
     *
     * @return string 
     */
    public function getLinkId()
    {
        return $this->linkId;
    }

    /**
     * Set icon
     *
     * @param string $icon
     * @return NavigationItem
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;
    
        return $this;
    }

    /**
     * Get icon
     *
     * @return string 
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * Set ordering
     *
     * @param integer $ordering
     * @return NavigationItem
     */
    public function setOrdering($ordering)
    {
        $this->ordering = $ordering;
    
        return $this;
    }

    /**
     * Get ordering
     *
     * @return integer 
     */
    public function getOrdering()
    {
        return $this->ordering;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return NavigationItem
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
    
        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean 
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set level
     *
     * @param integer $level
     * @return NavigationItem
     */
    public function setLevel($level)
    {
        $this->level = $level;
    
        return $this;
    }

    /**
     * Get level
     *
     * @return integer 
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set style
     *
     * @param string $style
     * @return NavigationItem
     */
    public function setStyle($style)
    {
        $this->style = $style;
    
        return $this;
    }

    /**
     * Get style
     *
     * @return string 
     */
    public function getStyle()
    {
        return $this->style;
    }

    /**
     * Set alt
     *
     * @param string $alt
     * @return NavigationItem
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;
    
        return $this;
    }

    /**
     * Get alt
     *
     * @return string 
     */
    public function getAlt()
    {
        return $this->alt;
    }

    /**
     * Set roles
     *
     * @param string $roles
     * @return NavigationItem
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
    
        return $this;
    }

    /**
     * Get roles
     *
     * @return string 
     */
    public function getRoles()
    {
        return $this->roles;
    }
}