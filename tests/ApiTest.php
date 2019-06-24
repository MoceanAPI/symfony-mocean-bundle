<?php
/**
 * Created by PhpStorm.
 * User: Neoson Lam
 * Date: 6/24/2019
 * Time: 3:21 PM.
 */

namespace MoceanSymBundle\Tests;

use MoceanSymBundle\DependencyInjection\MoceanExtension;

class ApiTest extends AbstractTesting
{
    public function setUp()
    {
        parent::setUp();

        $config = $this->getEmptyConfig();
        $config['accounts']['backup']['api_key'] = 'test_backup_api_key';
        $config['accounts']['backup']['api_secret'] = 'test_backup_api_secret';

        $extension = new MoceanExtension();
        $extension->load([$config], $this->containerBuilder);
    }

    public function testBasicCredentialCreatedObject()
    {
        $mocean = $this->containerBuilder->get('mocean_manager');
        $crendentialObject = $this->getClass(\Mocean\Client::class, 'credentials', $mocean->getMocean());
        $crendentialData = $this->getClass(\Mocean\Client\Credentials\Basic::class, 'credentials', $crendentialObject);

        $this->assertInstanceOf(\Mocean\Client\Credentials\Basic::class, $crendentialObject);
        $this->assertEquals(['mocean-api-key' => 'test_api_key', 'mocean-api-secret' => 'test_api_secret'], $crendentialData);
    }

    public function testUsingDifferentAccount()
    {
        $mocean = $this->containerBuilder->get('mocean_manager');
        $crendentialObject = $this->getClass(\Mocean\Client::class, 'credentials', $mocean->using('backup')->getMocean());
        $crendentialData = $this->getClass(\Mocean\Client\Credentials\Basic::class, 'credentials', $crendentialObject);

        $this->assertInstanceOf(\Mocean\Client\Credentials\Basic::class, $crendentialObject);
        $this->assertEquals(['mocean-api-key' => 'test_backup_api_key', 'mocean-api-secret' => 'test_backup_api_secret'], $crendentialData);
    }

    public function testUsingBasicCrendetialAccount()
    {
        $mocean = $this->containerBuilder->get('mocean_manager');
        $basicCrendentials = new \Mocean\Client\Credentials\Basic('test_basic_key', 'test_basic_secret');

        $crendentialObject = $this->getClass(\Mocean\Client::class, 'credentials', $mocean->using($basicCrendentials)->getMocean());
        $crendentialData = $this->getClass(\Mocean\Client\Credentials\Basic::class, 'credentials', $crendentialObject);

        $this->assertInstanceOf(\Mocean\Client\Credentials\Basic::class, $crendentialObject);
        $this->assertEquals(['mocean-api-key' => 'test_basic_key', 'mocean-api-secret' => 'test_basic_secret'], $crendentialData);
    }

    public function testUsingArrayAccount()
    {
        $mocean = $this->containerBuilder->get('mocean_manager');
        $crendentials = [
            'api_key' => 'test_array_key',
            'api_secret' => 'test_array_secret',
        ];

        $crendentialObject = $this->getClass(\Mocean\Client::class, 'credentials', $mocean->using($crendentials)->getMocean());
        $crendentialData = $this->getClass(\Mocean\Client\Credentials\Basic::class, 'credentials', $crendentialObject);

        $this->assertInstanceOf(\Mocean\Client\Credentials\Basic::class, $crendentialObject);
        $this->assertEquals(['mocean-api-key' => 'test_array_key', 'mocean-api-secret' => 'test_array_secret'], $crendentialData);
    }
}
