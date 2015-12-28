<?php

namespace Omid\ShopBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Basket
 *
 * @ORM\Table(name="basket")
 * @ORM\Entity(repositoryClass="Omid\ShopBundle\Repository\BasketRepository")
 */
class Basket
{
    const STATUS_SELECT_ITEMS = 1;
    const STATUS_PAYMENT_SUCCESS = 2;
    const STATUS_CANCELED = 3;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Product
     *
     * @ORM\ManyToMany(targetEntity="Omid\ShopBundle\Entity\Product")
     */
    private $items;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="smallint")
     */
    private $status;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="Omid\ShopBundle\Entity\User")
     */
    private $user;

    public function __construct($user)
    {
        $this->setUser($user);
        $this->items = new ArrayCollection();
        $this->setStatus(static::STATUS_SELECT_ITEMS);
    }

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
     * Set status
     *
     * @param integer $status
     *
     * @return Basket
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set user
     *
     * @param \Omid\ShopBundle\Entity\User $user
     *
     * @return Basket
     */
    public function setUser(\Omid\ShopBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Omid\ShopBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add item
     *
     * @param \Omid\ShopBundle\Entity\Product $item
     *
     * @return Basket
     */
    public function addItem(\Omid\ShopBundle\Entity\Product $item)
    {
        $this->items[] = $item;

        return $this;
    }

    /**
     * Remove item
     *
     * @param \Omid\ShopBundle\Entity\Product $item
     */
    public function removeItem(\Omid\ShopBundle\Entity\Product $item)
    {
        $this->items->removeElement($item);
    }

    /**
     * Get items
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getItems()
    {
        return $this->items;
    }
}
