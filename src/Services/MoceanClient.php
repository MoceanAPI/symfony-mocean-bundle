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

class MoceanClient
{
    private $mocean;
    private $from;

    /**
     * MoceanClient constructor.
     */
    public function __construct($api_key, $api_secret, $from)
    {
        $this->mocean = new Client(new Basic($api_key, $api_secret));
        $this->from = $from;
    }

    /**
     * @param $to
     * @param $text
     * @param array $params
     *
     * @link http://moceanapi.com/docs/#send-sms Documentation
     *
     * @return string
     * @throws Client\Exception\Exception
     */
    public function message($to, $text, array $params = [])
    {
        $params['mocean-to'] = $to;
        $params['mocean-text'] = $text;
        $params['mocean-resp-format'] = 'json';
        if (!isset($params['mocean-from'])) {
            $params['mocean-from'] = $this->from;
        }
        return $this->mocean->message()->send($params);
    }

    /**
     * Get the configured mocean sdk
     * @return \Mocean\Client
     */
    public function getMocean()
    {
        return $this->mocean;
    }
}
