<?php

namespace Omid\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Product
 *
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="Omid\ShopBundle\Repository\ProductRepository")
 */
class Product
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var
     *
     * @ORM\Column()
     */
    private $name;

    /**
     * @var
     *
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @var Category
     *
     * @ORM\ManyToOne(targetEntity="Omid\ShopBundle\Entity\Category")
     */
    private $category;

    /**
     * @var
     *
     * @ORM\Column(name="is_exists", type="boolean")
     */
    private $isExists;

    /**
     * @var
     *
     * @ORM\Column(type="text")
     */
    private $extra;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Product
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set price
     *
     * @param integer $price
     *
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return integer
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set isExists
     *
     * @param boolean $isExists
     *
     * @return Product
     */
    public function setIsExists($isExists)
    {
        $this->isExists = $isExists;

        return $this;
    }

    /**
     * Get isExists
     *
     * @return boolean
     */
    public function getIsExists()
    {
        return $this->isExists;
    }

    /**
     * Set category
     *
     * @param \Omid\ShopBundle\Entity\Category $category
     *
     * @return Product
     */
    public function setCategory(\Omid\ShopBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \Omid\ShopBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set extra
     *
     * @param string $extra
     *
     * @return Product
     */
    public function setExtra($extra)
    {
        $this->extra = $extra;

        return $this;
    }

    /**
     * Get extra
     *
     * @return string
     */
    public function getExtra()
    {
        return $this->extra;
    }
}
