<?php

namespace Dbout\Woocommerce\WcAjaxCart\Response;

/**
 * Class WcAjaxCartResponse
 *
 * @package Dbout\Woocommerce\WcAjaxCart\Response
 *
 * @author      Dimitri BOUTEILLE <bonjour@dimitri-bouteille.fr>
 * @link        https://github.com/dimitriBouteille Github
 * @copyright   (c) 2019 Dimitri BOUTEILLE
 */
class WcAjaxCartResponse implements InterfaceWcAjaxCartResponse
{

    /**
     * Http status code
     * @var int
     */
    protected $code;

    /**
     * @var array
     */
    protected $results = [];

    /**
     * @var null|string
     */
    protected $errorMessage =  null;

    /**
     * WcAjaxCartResponse constructor.
     *
     * @param int $code
     */
    public function __construct(int $code = 200)
    {
        $this->code = $code;
    }

    /**
     * Function setCode
     *
     * @param int $code
     * @return WcAjaxCartResponse
     */
    public function setCode(int $code): WcAjaxCartResponse {

        $this->code = $code;
        return $this;
    }

    /**
     * Function setData
     *
     * @param array $data
     * @return WcAjaxCartResponse
     */
    public function setData(array $data): WcAjaxCartResponse {

        $this->results = $data;
        return $this;
    }

    /**
     * Function addData
     *
     * @param array $data
     * @return WcAjaxCartResponse
     */
    public function addData(array $data): WcAjaxCartResponse {

        $this->results = array_merge($this->results, $data);
        return $this;
    }

    /**
     * Function setErrorMessage
     *
     * @param string $message
     * @return WcAjaxCartResponse
     */
    public function setErrorMessage(string $message): WcAjaxCartResponse {

        $this->errorMessage = $message;
        return $this;
    }

    /**
     * Function toArray
     *
     * @return array
     */
    public function toArray(): array {

        return [
            'status' => [
                'code' =>           $this->getCode(),
                'error_message' =>  $this->errorMessage,
            ],
            'results' => $this->results,
        ];
    }

    /**
     * Function getCode
     *
     * @return int
     */
    public function getCode(): int {

        return $this->code;
    }

}