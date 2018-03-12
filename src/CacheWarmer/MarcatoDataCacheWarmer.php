<?php

namespace Ten24\MarcatoIntegrationBundle\CacheWarmer;

use Symfony\Component\HttpKernel\CacheWarmer\CacheWarmerInterface;
use Ten24\MarcatoIntegrationBundle\Service\Synchronizer;

/**
 * Class CacheWarmer
 *
 * @package Ten24\MarcatoIntegrationBundle\Service
 * @todo    - this could download the XML data on cache warmup to save a bit of time?
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
        // @todo - call to the downloader to download and cache the XML from Marcato?
        return;
    }

    /**
     * @return bool
     */
    public function isOptional()
    {
        return true;
    }
}