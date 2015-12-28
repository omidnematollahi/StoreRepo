<?php

namespace Omid\ShopBundle\Controller;

use Omid\ShopBundle\Entity\Basket;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class FrontedController
 *
 * @package Omid\ShopBundle\Controller
 *
 * @Route("/api")
 */
class FrontedController extends Controller
{
    /**
     * @Route("/category/{id}/show")
     * @Method("GET")
     */
    public function getCategory($id)
    {
        $category = $this->get('doctrine')->getRepository('OmidShopBundle:Category')->find($id);

        if (!$category) {
            throw $this->createNotFoundException();
        }

        $serializer = $this->get('jms_serializer');
        $data = $serializer->serialize($category, 'json');
        return new JsonResponse($data);
    }

    /**
     * @Route("/categories/{limit}/{offset}")
     * @Method("GET")
     *
     * @param int $limit
     * @param int $offset
     * @return JsonResponse
     */
    public function getCategories($limit=50, $offset=0)
    {
        $categories = $this->get('doctrine')->getRepository('OmidShopBundle:Category')->findBy(array(), null, $limit, $offset);

        if (!$categories) {
            throw $this->createNotFoundException();
        }

        $serializer = $this->get('jms_serializer');
        $data = $serializer->serialize($categories, 'json');
        return new JsonResponse($data);
    }

    /**
     * @Route("/product/{id}/show")
     * @Method("GET")
     * 
     * @param $id
     * @return JsonResponse
     */
    public function getProduct($id)
    {
        $product = $this->get('doctrine')->getRepository('OmidShopBundle:Product')->find($id);

        if (!$product) {
            throw $this->createNotFoundException();
        }

        $serializer = $this->get('jms_serializer');
        $data = $serializer->serialize($product, 'json');
        return new JsonResponse($data);
    }

    /**
     * @Route("/products/{limit}/{offset}")
     * @Method("GET")
     * 
     * @param int $limit
     * @param int $offset
     * @return JsonResponse
     */
    public function getProducts($limit=50, $offset=0)
    {
        $products = $this->get('doctrine')->getRepository('OmidShopBundle:Product')->findBy(array(), null, $limit, $offset);

        if (!$products) {
            throw $this->createNotFoundException();
        }

        $serializer = $this->get('jms_serializer');
        $data = $serializer->serialize($products, 'json');
        return new JsonResponse($data);
    }

    /**
     * @Route("/basket/{productId}/add")
     * @Method("POST")
     *
     * @param $product
     * @return JsonResponse
     */
    public function addItemToBasket($productId)
    {
        if (!$this->get('security.authorization_checker')->isGranted("IS_AUTHENTICATED_FULLY")) {
            return new JsonResponse(array(
                'code' => 403,
                'message' => 'you must be a user',
            ));
        }

        $doctrine = $this->get('doctrine');

        $product = $doctrine->getRepository('OmidShopBundle:Product')->find($productId);

        if (!$product) {
            return new JsonResponse(array(
                'code' => 404,
                'message' => 'product is not found',
            ));
        }

        $basket = $doctrine->getRepository('OmidShopBundle:Basket')->findOneByStatus(Basket::STATUS_SELECT_ITEMS);

        if (!$basket) {
            $basket = new Basket($this->getUser());
            $doctrine->getManager()->persist($basket);
        }

        $basket->addItem($product);
        $doctrine->getManager()->flush();

        $serializer = $this->get('jms_serializer');
        return new JsonResponse($serializer->serialize($basket, 'json'));

    }

    /**
     * @Route("/basket/{productId}/remove")
     * @Method("delete")
     *
     * @param $product
     * @return JsonResponse
     */
    public function removeItemFromBasket($productId)
    {
        if (!$this->get('security.authorization_checker')->isGranted("IS_AUTHENTICATED_FULLY")) {
            return new JsonResponse(array(
                'code' => 403,
                'message' => 'you must be a user',
            ));
        }

        $doctrine = $this->get('doctrine');

        $product = $doctrine->getRepository('OmidShopBundle:Product')->find($productId);

        if (!$product) {
            return new JsonResponse(array(
                'code' => 404,
                'message' => 'product is not found',
            ));
        }

        $basket = $doctrine->getRepository('OmidShopBundle:Basket')->findOneByStatus(Basket::STATUS_SELECT_ITEMS);

        if (!$basket or !$basket->getItems()->contains($product)) {
            return new JsonResponse(array(
                'code' => 400,
                'message' => 'Your basket have not given product',
            ));
        }

        $basket->removeItem($product);
        $doctrine->getManager()->flush();

        $serializer = $this->get('jms_serializer');
        return new JsonResponse($serializer->serialize($basket, 'json'));

    }

    /**
     * @Route("/basket")
     * @Method("GET")
     *
     * @param $product
     * @return JsonResponse
     */
    public function getBasket()
    {
        $doctrine = $this->get('doctrine');

        $basket = $doctrine->getRepository('OmidShopBundle:Basket')->findOneByStatus(Basket::STATUS_SELECT_ITEMS);

        if (!$basket) {
            return new JsonResponse(array(
                'code' => 400,
                'message' => 'Your basket have not given product',
            ));
        }

        $serializer = $this->get('jms_serializer');
        return new JsonResponse($serializer->serialize($basket, 'json'));
    }
}