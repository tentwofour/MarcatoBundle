<?php

namespace Ten24\Tests\MarcatoIntegrationBundle\Service;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class SynchronizerTest
 * @package Ten24\Tests\MarcatoIntegrationBundle\Service
 */
class SynchronizerTest extends KernelTestCase
{
    /**
     * @var \Ten24\MarcatoIntegrationBundle\Service\Synchronizer
     */
    private $synchronizer;

    /**
     * Setup before each test
     */
    public function setUp()
    {
        $kernel = $this->createKernel();
        $kernel->boot();

        $this->synchronizer = $kernel->getContainer()
            ->get('ten24_marcato_integration.synchronizer');
    }

    public function testSynchronize()
    {
        $this->synchronizer->synchronize();

        // Check that the cache exists

    }

}