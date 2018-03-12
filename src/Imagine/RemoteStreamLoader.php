<?php

namespace Ten24\MarcatoIntegrationBundle\Imagine;

use Liip\ImagineBundle\Imagine\Data\Loader\StreamLoader;

class RemoteStreamLoader extends StreamLoader
{
    public function find($path)
    {
        // The http:// becomes http:/ in the url path due to how routing urls are converted
        // so we need to replace it by http:// in order to load the remote file
        $path = preg_replace('@\:/(\w)@', '://$1', $path);

        return parent::find($path);
    }
}