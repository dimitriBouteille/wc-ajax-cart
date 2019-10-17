<?php

namespace Dbout\Woocommerce\WcAjaxCart\Actions;

use Dbout\Woocommerce\WcAjaxCart\Response\WcAjaxCartResponse;

/**
 * Class CartAddCoupon
 *
 * @package Dbout\Woocommerce\WcAjaxCart\Actions
 *
 * @author      Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @link        https://github.com/dimitriBouteille Github
 * @copyright   (c) 2019 Dimitri BOUTEILLE
 */
class CartAddCoupon extends AbstractWcAjaxCart
{

    /**
     * Function getAction
     *
     * @return string
     */
    public static function getAction(): string { return 'dbout-cart-add-coupon'; }

    /**
     * Function getNonceName
     *
     * @return string
     */
    public static function getNonceName(): string { return 'dbout_cart-add-coupon_lDlzF65NKlkZ9'; }

    /**
     * Function submit
     *
     * @return WcAjaxCartResponse
     */
    public function submit(): WcAjaxCartResponse
    {
        $response = new WcAjaxCartResponse(400);

        $cartWC = WC()->cart;
        $couponId = $_REQUEST['coupon'] ?? null;

        if($cartWC->get_cart_contents_count() < 1) {
            return $response->setErrorMessage('Impossible d\'ajouter un code promo, votre panier est vide.');
        }

        if(is_null($couponId)) {
            return $response->setErrorMessage('Impossible de trouver le code promo à ajouter, veuillez réessayer.');
        }

        if($cartWC->has_discount($couponId)) {
            return $response->setErrorMessage('Impossible d\'ajouter le code promo, il est déjà présent dans votre panier.');
        }

        // Add coupon in cart
        if(!$cartWC->add_discount($couponId)) {
            return $response->setErrorMessage('Impossible d\'ajouter le code promo. Le code promo est peut-être invalide, veuillez réessayer.');
        }

        wc_clear_notices();
        $response->setCode(200);

        return $response;
    }

    /**
     * Function getUrl
     *
     * @param string|null $coupon
     * @return string
     */
    public static function getUrl(string $coupon = null): string {

        $data = [];
        if(!empty($coupon)) {
            $data = ['coupon' => $coupon];
        }

        return self::getAjaxUrl($data);
    }

}