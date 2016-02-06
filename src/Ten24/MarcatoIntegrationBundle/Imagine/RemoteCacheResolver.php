<?php

namespace Ten24\MarcatoIntegrationBundle\Imagine;

use Liip\ImagineBundle\Imagine\Cache\Resolver\WebPathResolver;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RemoteCacheResolver extends WebPathResolver
{
    /**
     * {@inheritDoc}
     */
    public function resolve(Request $request,
                            $path,
                            $filter)
    {
        $browserPath    = $this->decodeBrowserPath($this->getBrowserPath($path, $filter));
        $this->basePath = $request->getBaseUrl();
        $targetPath     = $this->getFilePath($path, $filter);
        $pattern        = '@http(s)?\:/{1,2}(?:\w+\.)?([\w\.\-]+)\.\w+/@';

        // We can't use a folder with "http://" in its name so this will transform the output path name
        $targetPath = preg_replace($pattern, '$2/', $targetPath);
        $targetPath = pathinfo($targetPath, PATHINFO_DIRNAME);

        // if the file has already been cached, we're probably not rewriting
        // correctly, hence make a 301 to proper location, so browser remembers
        if (file_exists($targetPath))
        {
            // Strip the base URL of this request from the browserpath to not interfere with the base path.
            $baseUrl = $request->getBaseUrl();
            if ($baseUrl && 0 === strpos($browserPath, $baseUrl))
            {
                $browserPath = substr($browserPath, strlen($baseUrl));
            }

            // We can't use a folder with "http://" in its name so this will transform the output path name
            $browserPath = preg_replace($pattern, '$2/', $browserPath);
            $browserPath = pathinfo($browserPath, PATHINFO_DIRNAME);

            return new RedirectResponse($request->getBasePath() . $browserPath, 301);
        }

        return $targetPath;
    }

    /**
     * Stores the content into a static file.
     *
     * @param Response $response
     * @param string   $targetPath
     * @param string   $filter
     *
     * @return Response
     *
     * @throws \RuntimeException
     */
    public function store(Response $response,
                          $targetPath,
                          $filter)
    {
        // We can't use a folder with "http://" in its name so this will transform the output path name
        $targetPath = preg_replace('@http(s)?\:/{1,2}(?:\w+\.)?([\w\.\-]+)\.\w+/@', '$2/', $targetPath);
        $dir        = pathinfo($targetPath, PATHINFO_DIRNAME);

        $this->makeFolder($dir);

        file_put_contents($targetPath, $response->getContent());

        $response->setStatusCode(201);

        return $response;
    }
}