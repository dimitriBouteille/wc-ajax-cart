<?php

namespace Dbout\Woocommerce\WcAjaxCart\Response;

/**
 * Interface InterfaceWcAjaxCartResponse
 *
 * @package Dbout\Woocommerce\WcAjaxCart\Response
 *
 * @author      Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @link        https://github.com/dimitriBouteille Github
 * @copyright   (c) 2019 Dimitri BOUTEILLE
 */
interface InterfaceWcAjaxCartResponse
{

    /**
     * Function toArray
     * Transform object to array
     *
     * @return array
     */
    public function toArray(): array;

    /**
     * Function getCode
     * Get http status code
     *
     * @return int
     */
    public function getCode(): int;

}