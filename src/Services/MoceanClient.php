<?php
/**
 * Created by PhpStorm.
 * User: Neoson Lam
 * Date: 12/14/2018
 * Time: 10:40 AM
 */

namespace MoceanSymBundle\Services;


use Mocean\Client;
use Mocean\Client\Credentials\Basic;

/**
 * @mixin Client
 */
class MoceanClient
{
    private $mocean;

    /**
     * MoceanClient constructor.
     */
    public function __construct($api_key, $api_secret)
    {
        $this->mocean = new Client(new Basic($api_key, $api_secret));
    }

    /**
     * Get the configured mocean sdk
     * @return \Mocean\Client
     */
    public function getMocean()
    {
        if ($this->mocean) {
            return $this->mocean;
        }

        return $this->mocean = new Client(new Basic($this->apiKey, $this->apiSecret));
    }

    public function __call($method, $arguments)
    {
        return call_user_func_array([$this->getMocean(), $method], $arguments);
    }
}
