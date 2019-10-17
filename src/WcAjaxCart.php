<?php

namespace Dbout\Woocommerce\WcAjaxCart;

use Dbout\Woocommerce\WcAjaxCart\Actions\CartAddCoupon;
use Dbout\Woocommerce\WcAjaxCart\Actions\CartRemoveCoupon;
use Dbout\Woocommerce\WcAjaxCart\Actions\CartRemoveProduct;
use Dbout\Woocommerce\WcAjaxCart\Actions\CartUpdateQuantity;
use Dbout\Woocommerce\WcAjaxCart\Actions\InterfaceWcAjaxCart;
use Dbout\Woocommerce\WcAjaxCart\Response\InterfaceWcAjaxCartResponse;
use Dbout\Woocommerce\WcAjaxCart\Response\WcAjaxCartResponse;

/**
 * Class WcAjaxCart
 *
 * @package Dbout\Woocommerce\WcAjaxCart
 *
 * @author      Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @link        https://github.com/dimitriBouteille Github
 * @copyright   (c) 2019 Dimitri BOUTEILLE
 */
class WcAjaxCart
{

    /**
     * @var null|WcAjaxCart
     */
    private static $instance = null;

    /**
     * @var InterfaceWcAjaxCart[]
     */
    private $actions = [];

    /**
     * WcAjaxCart constructor.
     */
    private function __construct() { }

    /**
     * Function getInstance
     *
     * @return WcAjaxCart
     */
    public static function getInstance(): WcAjaxCart {

        if(is_null(self::$instance)) {

            self::$instance = new WcAjaxCart();
        }

        return self::$instance;
    }

    /**
     * Function register
     * Save all ajax action
     */
    public function register() : void {

        if($this->checkApp()) {

            $this->include('/helpers-functions.php');

            $this->actions = [
                CartAddCoupon::getAction() =>       new CartAddCoupon(),
                CartRemoveCoupon::getAction() =>    new CartRemoveCoupon(),
                CartRemoveProduct::getAction() =>   new CartRemoveProduct(),
                CartUpdateQuantity::getAction() =>  new CartUpdateQuantity(),
            ];

            foreach ($this->actions as $actionName => $classObject) {
                $this->addAjax($actionName);
            }
        }
    }

    /**
     * Function loadFiles
     *
     * @return void
     */
    public function loadFiles(): void {

        $this->include('/Actions/InterfaceWcAjaxCartResponse.php');
        $this->include('/Actions/WcAjaxCartResponse.php');
        $this->include('/Actions/InterfaceWcAjaxCart.php');
        $this->include('/Actions/AbstractWcAjaxCart.php');
        $this->include('/Actions/CartAddCoupon.php');
        $this->include('/Actions/CartRemoveCoupon.php');
        $this->include('/Actions/CartRemoveProduct.php');
        $this->include('/Actions/CartUpdateQuantity.php');
    }

    /**
     * Function dispatch
     * Function that is called during Ajax requests
     *
     * @return void
     */
    public function dispatch(): void {

        $action = $_REQUEST['action'] ?? null;
        $response = new WcAjaxCartResponse(400);

        if(!is_null($action) && key_exists($action, $this->actions)) {

            $actionClass = $this->actions[$action];
            if(wp_verify_nonce($_REQUEST[$actionClass::getNonceFieldName()], $actionClass::getNonceName())) {
                $response = apply_filters('dbout_wc_ajax_cart_response_success', $actionClass->submit(), $action);
            } else {
                $response->setErrorMessage('Le formulaire n\'est pas valide. Veuillez rafraichir la page pour tenter de corriger le problème. Si le problème persiste, veuillez réessayer dans quelques instants.');
            }
        } else {
            $response->setErrorMessage('Impossible de trouver l\'action demandée, veuillez réessayer.');
        }

        $response = apply_filters('dbout_wc_ajax_cart_response', $response, $action);

        if($response instanceof InterfaceWcAjaxCartResponse) {
            wp_send_json($response->toArray(), $response->getCode());
        } else {
            wp_send_json(['error' => sprintf('Response must be implement %s interface.', InterfaceWcAjaxCartResponse::class)]);
        }
        die;
    }

    /**
     * Function addAjax
     * Call add_action

     * @param string $action
     */
    private function addAjax(string $action): void {

        add_action('wp_ajax_'. $action, [$this, 'dispatch']);
        add_action('wp_ajax_nopriv_'. $action, [$this, 'dispatch']);
    }

    /**
     * Function checkApp
     * Check if Woocommerce is enabled
     *
     * @return bool
     */
    private function checkApp(): bool {

        if(!class_exists('woocommerce')) {
            return false;
        }

        if(!function_exists('WC')) {
            return false;
        }

        return true;
    }

    /**
     * @param string $fileDIr
     */
    private function include(string $fileDIr): void {

        require_once realpath (__DIR__).$fileDIr;
    }

}