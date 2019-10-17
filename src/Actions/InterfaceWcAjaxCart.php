<?php

namespace Dbout\Woocommerce\WcAjaxCart\Actions;

use Dbout\Woocommerce\WcAjaxCart\Response\WcAjaxCartResponse;

/**
 * Interface InterfaceWcAjaxCart
 *
 * @package Dbout\Woocommerce\WcAjaxCart\Actions
 *
 * @author      Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @link        https://github.com/dimitriBouteille Github
 * @copyright   (c) 2019 Dimitri BOUTEILLE
 */
interface InterfaceWcAjaxCart
{

    /**
     * Function getAction
     * Get ajax action name
     *
     * @return string
     */
    public static function getAction(): string;

    /**
     * Function getNonceName
     * Get the nonce name
     *
     * @return string
     */
    public static function getNonceName(): string;

    /**
     * Function getNonceFieldName
     * Get the name of field contain the nonce
     *
     * @return string
     */
    public static function getNonceFieldName(): string;

    /**
     * Function getAjaxUrl
     * Get ajax url
     *
     * @param mixed ...$data
     * @return string
     */
    public static function getAjaxUrl(...$data): string;

    /**
     * Function submit
     * Function that is called during the Ajax request
     *
     * @return WcAjaxCartResponse
     */
    public function submit(): WcAjaxCartResponse;

}