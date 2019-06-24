<?php
/**
 * Created by PhpStorm.
 * User: Neoson Lam
 * Date: 6/24/2019
 * Time: 3:21 PM.
 */

namespace MoceanSymBundle\Tests;


use MoceanSymBundle\DependencyInjection\MoceanExtension;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Yaml\Parser;

class AbstractTesting extends TestCase
{
    /* @var ContainerBuilder $containerBuilder */
    protected $containerBuilder;

    public function setUp()
    {
        $this->containerBuilder = new ContainerBuilder();
    }

    protected function getEmptyConfig()
    {
        $yaml = <<<EOF
defaults: main
accounts:
  main:
    api_key: test_api_key
    api_secret: test_api_secret
EOF;
        $parser = new Parser();
        return $parser->parse($yaml);
    }

    public function getClass($class, $property, $object)
    {
        $reflectionClass = new \ReflectionClass($class);
        $refProperty = $reflectionClass->getProperty($property);
        $refProperty->setAccessible(true);

        return $refProperty->getValue($object);
    }
}
