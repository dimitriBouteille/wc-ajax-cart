<?php

use Dbout\Woocommerce\WcAjaxCart\Actions\{CartUpdateQuantity, CartRemoveCoupon, CartAddCoupon, CartRemoveProduct};

if(!function_exists('ajaxCartAddQuantityUrl')) {

    /**
     * @param string $itemId
     * @return string
     */
    function ajaxCartAddQuantityUrl(string $itemId): string
    {

        return CartUpdateQuantity::getAddQuantityUrl($itemId);
    }

}

if(!function_exists('ajaxCartRemoveQuantityUrl')) {

    /**
     * @param string $itemId
     * @return string
     */
    function ajaxCartRemoveQuantityUrl(string $itemId): string
    {

        return CartUpdateQuantity::getRemoveQuantityUrl($itemId);
    }

}

if(!function_exists('ajaxCartRemoveCouponUrl')) {

    /**
     * @param string $coupon
     * @return string
     */
    function ajaxCartRemoveCouponUrl(string $coupon): string
    {
        return CartRemoveCoupon::getUrl($coupon);
    }

}

if(!function_exists('ajaxCartAddCouponUrl')) {

    /**
     * @param string|null $coupon
     * @return string
     */
    function ajaxCartAddCouponUrl(string $coupon = null): string
    {
        return CartAddCoupon::getUrl($coupon);
    }

}

if(!function_exists('ajaxCartRemoveProductUrl')) {

    /**
     * @param string $itemId
     * @return string
     */
    function ajaxCartRemoveProductUrl(string $itemId): string
    {

        return CartRemoveProduct::getUrl($itemId);
    }

}