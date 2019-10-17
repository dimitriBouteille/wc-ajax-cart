<?php

namespace Dbout\Woocommerce\WcAjaxCart\Actions;

/**
 * Class AbstractWcAjaxCart
 *
 * @package Dbout\Woocommerce\WcAjaxCart\Actions
 *
 * @author      Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @link        https://github.com/dimitriBouteille Github
 * @copyright   (c) 2019 Dimitri BOUTEILLE
 */
abstract class AbstractWcAjaxCart implements InterfaceWcAjaxCart
{

    /**
     * Function getNonceFieldName
     *
     * @return string
     */
    public static function getNonceFieldName(): string {

        return 'token';
    }

    /**
     * Function getAjaxUrl
     *
     * @param mixed ...$data
     * @return string
     */
    public static function getAjaxUrl(...$data): string
    {
        $baseData = [
            static::getNonceFieldName() => wp_create_nonce(static::getNonceName()),
            'action' => static::getAction()
        ];

        foreach ($data as $dataPassed) {
            $data = array_merge($dataPassed, $baseData);
        }

        return admin_url('admin-ajax.php') . '?' . http_build_query($data);
    }

}