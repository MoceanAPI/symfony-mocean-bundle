<?php
/**
 * Created by PhpStorm.
 * User: Neoson Lam
 * Date: 12/14/2018
 * Time: 12:06 PM
 */

namespace MoceanSymBundle\Services;

class MoceanManager
{
    /**
     * @var string
     */
    protected $default;
    /**
     * @var array
     */
    protected $accounts;

    public function __construct($default, $accounts)
    {
        $this->default = $default;
        $this->accounts = $accounts;
    }

    /**
     * abilitity to switch account defined in config
     *
     * @param $account
     * @return MoceanClient
     */
    public function using($account)
    {
        if (!isset($this->accounts[$account])) {
            throw new \InvalidArgumentException("Account \"$account\" is not configured.");
        }
        $settings = $this->accounts[$account];
        return new MoceanClient($settings['api_key'], $settings['api_secret'], $settings['from']);
    }

    /**
     * this will be called to use default connections
     * @return MoceanClient
     */
    public function defaultConnection()
    {
        return $this->using($this->default);
    }

    /**
     * @param string $method
     * @param array $arguments
     *
     * @return mixed
     */
    public function __call($method, $arguments)
    {
        return call_user_func_array([$this->defaultConnection(), $method], $arguments);
    }
}
