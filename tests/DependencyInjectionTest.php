<?php
/**
 * Created by PhpStorm.
 * User: Neoson Lam
 * Date: 6/24/2019
 * Time: 4:20 PM.
 */

namespace MoceanSymBundle\Tests;


use MoceanSymBundle\DependencyInjection\MoceanExtension;
use MoceanSymBundle\Services\MoceanManager;

class DependencyInjectionTest extends AbstractTesting
{
    public function setUp()
    {
        parent::setUp();

        $extension = new MoceanExtension();
        $extension->load([$this->getEmptyConfig()], $this->containerBuilder);
    }

    public function testWhetherMoceanableResolveFromContainer()
    {
        $mocean = $this->containerBuilder->get('mocean_manager');
        $this->assertInstanceOf(MoceanManager::class, $mocean);
    }
}
