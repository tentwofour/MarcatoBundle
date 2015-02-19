<?php

namespace Ten24\MarcatoIntegrationBundle\CacheWarmer;

use Symfony\Component\HttpKernel\CacheWarmer\CacheWarmerInterface;
use Ten24\MarcatoIntegrationBundle\Service\Synchronizer;

/**
 * Class CacheWarmer
 * @package Ten24\MarcatoIntegrationBundle\Service
 */
class MarcatoDataCacheWarmer implements CacheWarmerInterface
{
    /**
     * @var \Ten24\MarcatoIntegrationBundle\Service\Synchronizer
     */
    private $syncronizer;

    /**
     * @param \Ten24\MarcatoIntegrationBundle\Service\Synchronizer $synchronizer
     */
    public function __construct(Synchronizer $synchronizer)
    {
        $this->syncronizer = $synchronizer;
    }

    /**
     * Warms up the cache.
     *
     * @param string $cacheDir The cache directory
     */
    public function warmUp($cacheDir)
    {
        $enabled = $this->getContainer()->getParameter('ten24_marcato_integration.enabled');

        if ($enabled)
        {
            $this->syncronizer->synchronize();
        }
    }

    /**
     * @return bool
     */
    public function isOptional()
    {
        return true;
    }
}