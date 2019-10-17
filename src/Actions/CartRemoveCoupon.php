<?php

namespace Dbout\Woocommerce\WcAjaxCart\Actions;

use Dbout\Woocommerce\WcAjaxCart\Response\WcAjaxCartResponse;

/**
 * Class CartRemoveCoupon
 *
 * @package Dbout\Woocommerce\WcAjaxCart\Actions
 *
 * @author      Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @link        https://github.com/dimitriBouteille Github
 * @copyright   (c) 2019 Dimitri BOUTEILLE
 */
class CartRemoveCoupon extends AbstractWcAjaxCart
{

    /**
     * Function getAction
     *
     * @return string
     */
    public static function getAction(): string { return 'dbout-cart-remove-coupon'; }

    /**
     * Function getNonceName
     *
     * @return string
     */
    public static function getNonceName(): string { return 'dbout_cart_remove_coupon_6grMjkGmpZ'; }

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

        if(!key_exists($couponId, $cartWC->get_coupons())) {
            return $response->setErrorMessage('Impossible de supprimer le code promo, le coupon n\'existe pas dans votre panier.');
        }

        $cartWC->remove_coupon($couponId);
        $cartWC->calculate_totals();

        $response->setCode(200);
        return $response;
    }

    /**
     * Function getUrl
     *
     * @param string $coupon
     * @return string
     */
    public static function getUrl(string $coupon): string {

        return self::getAjaxUrl(['coupon' => $coupon]);
    }

}