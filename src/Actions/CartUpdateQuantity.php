<?php

namespace Dbout\Woocommerce\WcAjaxCart\Actions;

use Dbout\Woocommerce\WcAjaxCart\Response\WcAjaxCartResponse;

/**
 * Class CartUpdateQuantity
 *
 * @package Dbout\Woocommerce\WcAjaxCart\Actions
 *
 * @author      Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @link        https://github.com/dimitriBouteille Github
 * @copyright   (c) 2019 Dimitri BOUTEILLE
 */
class CartUpdateQuantity extends AbstractWcAjaxCart
{

    /**
     * Function getAction
     *
     * @return string
     */
    public static function getAction(): string { return 'dbout-update-cart-quantity'; }

    /**
     * Function getNonceName
     *
     * @return string
     */
    public static function getNonceName(): string { return 'dbout_cart_update_quantity_665mgrAlf2S65'; }

    /**
     * Function submit
     *
     * @return WcAjaxCartResponse
     */
    public function submit(): WcAjaxCartResponse
    {
        $response = new WcAjaxCartResponse(400);

        $typeAction = $_REQUEST['type'] ?? null;
        if(!in_array($typeAction, ['add', 'remove'])) {
            return $response->setErrorMessage('Impossible de mettre à jour la quantité de ce produit. Veuillez réactualiser la page.');
        }

        $cartWC = WC()->cart;
        $cart = $cartWC->cart_contents;
        $itemId = $_REQUEST['item'] ?? null;

        if(!key_exists($itemId, $cart)) {
            return $response->setErrorMessage('Impossible de trouver le produit à mettre à jour.');
        }

        $cartItem = $cart[$itemId];
        $product = apply_filters( 'woocommerce_cart_item_product', $cartItem['data'], $cartItem, $itemId);

        if(!$product || !$product->exists()) {
            return $response->setErrorMessage('Impossible de mettre à jour la quantité de ce produit. Le produit n\'existe pas.');
        }

        if(!$product->is_in_stock()) {
            return $response->setErrorMessage('Impossible de mettre à jour la quantité de ce produit. Le produit n\'est plus en stock. Veuillez supprimer le produit du panier.');
        }

        $maxQuantity = $product->get_max_purchase_quantity();
        $quantity = $cartItem['quantity'];
        switch ($typeAction) {
            case 'add':
                $quantity++;
                break;
            case 'remove':
                $quantity--;
                break;
        }

        if($maxQuantity == -1 || ($typeAction == 'add' && $quantity <= $maxQuantity) || $typeAction == 'remove') {
            if ($quantity <= 0) {
                $cartWC->remove_cart_item($itemId);
            } else {
                $cartWC->set_quantity($itemId, $quantity);
            }

            $response->setCode(200)
                ->setData([
                    'quantity' => $quantity,
                    'subTotalProduct' => apply_filters('woocommerce_cart_item_subtotal', $cartWC->get_product_subtotal($product, $quantity), $cartItem, $itemId),
                    'unitPrice' => apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $product ), $cartItem, $itemId),
                ]);
        } else {
            if(($quantity -1) == $maxQuantity) {
                $response->setErrorMessage('Impossible de mettre à jour la quantité de ce produit. Vous avez atteint la quantité maximale autorisée.');
            } else {
                $response->setErrorMessage(sprintf('Impossible de mettre à jour la quantité de ce produit. La quantité dépasse le stock disponible pour ce produit. Veuillez diminuer la quantité jusqu\'à atteindre %s.',
                    $maxQuantity));
            }
        }

        return $response;
    }

    /**
     * Function getAddQuantityUrl
     *
     * @param string $itemId
     * @return string
     */
    public static function getAddQuantityUrl(string $itemId): string {

        return self::getAjaxUrl(['type' => 'add', 'item' => $itemId]);
    }

    /**
     * Function getRemoveQuantityUrl
     *
     * @param string $itemId
     * @return string
     */
    public static function getRemoveQuantityUrl(string $itemId): string {

        return self::getAjaxUrl(['type' => 'remove', 'item' => $itemId]);
    }

}