<?php
/**
 * Created by PhpStorm.
 * User: Neoson Lam
 * Date: 12/14/2018
 * Time: 12:06 PM
 */

namespace MoceanSymBundle\Services;

use InvalidArgumentException;
use Mocean\Client\Credentials\Basic;

/**
 * @mixin MoceanClient
 */
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
        if (is_array($account)) {
            $settings = $account;
        } elseif ($account instanceof Basic) {
            $settings = [
                'api_key' => $account['mocean-api-key'],
                'api_secret' => $account['mocean-api-secret'],
            ];
        } else {
            if (!isset($this->accounts[$account])) {
                throw new \InvalidArgumentException("Account \"$account\" is not configured.");
            }

            $settings = $this->accounts[$account];
        }

        if (!isset($settings['api_key']) || $settings['api_key'] === '') {
            throw new InvalidArgumentException('api_key is not configured');
        }

        if (!isset($settings['api_secret']) || $settings['api_secret'] === '') {
            throw new InvalidArgumentException('api_secret is not configured');
        }

        return new MoceanClient($settings['api_key'], $settings['api_secret']);
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
