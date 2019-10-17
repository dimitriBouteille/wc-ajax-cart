<?php

namespace Dbout\Woocommerce\WcAjaxCart\Actions;

use Dbout\Woocommerce\WcAjaxCart\Response\WcAjaxCartResponse;

/**
 * Class CartRemoveProduct
 *
 * @package Dbout\Woocommerce\WcAjaxCart\Actions
 *
 * @author      Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @link        https://github.com/dimitriBouteille Github
 * @copyright   (c) 2019 Dimitri BOUTEILLE
 */
class CartRemoveProduct extends AbstractWcAjaxCart
{

    /**
     * Function getAction
     * @return string
     */
    public static function getAction(): string { return 'dbout-cart-remove-product'; }

    /**
     * Function getNonceName
     *
     * @return string
     */
    public static function getNonceName(): string { return 'dbout_cart_remove_product_hPEne54GJK5286mp'; }

    /**
     * Function submit
     *
     * @return WcAjaxCartResponse
     */
    public function submit(): WcAjaxCartResponse
    {
        $response = new WcAjaxCartResponse(400);

        $itemId = $_REQUEST['item'] ?? null;

        if(is_null($itemId) || !WC()->cart->remove_cart_item($itemId)) {
            return $response->setErrorMessage('Impossible de supprimer ce produit du panier, veuillez réessayer.');
        }

        $response->setCode(200);
        return $response;
    }

    /**
     * Function getUrl
     *
     * @param string $itemId
     * @return string
     */
    public static function getUrl(string $itemId): string {

        return self::getAjaxUrl(['item' => $itemId]);
    }

}