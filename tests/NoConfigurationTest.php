<?php
/**
 * Created by PhpStorm.
 * User: Neoson Lam
 * Date: 12/31/2018
 * Time: 11:29 AM.
 */

namespace MoceanSymBundle\Tests;

use MoceanSymBundle\DependencyInjection\MoceanExtension;

class NoConfigurationTest extends AbstractTesting
{
    public function setUp()
    {
        parent::setUp();

        $config = $this->getEmptyConfig();
        $config['accounts']['main']['api_key'] = '';

        $extension = new MoceanExtension();
        $extension->load([$config], $this->containerBuilder);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage api_key is not configured
     */
    public function testExceptionRaisedIfSettingNotConfigured()
    {
        $this->containerBuilder->get('mocean_manager')->getMocean();
    }
}
