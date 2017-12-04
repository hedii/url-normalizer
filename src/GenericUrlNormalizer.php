<?php
declare(strict_types=1);

namespace Hedii\UrlNormalizer;

use League\Uri\Components\HierarchicalPath;
use League\Uri\Http;

class GenericUrlNormalizer implements UrlNormalizerInterface
{
    /**
     * Normalize a given http uri.
     *
     * @param \League\Uri\Http $uri
     * @return string
     */
    public static function normalize(Http $uri): string
    {
        $path = new HierarchicalPath($uri->getPath());

        return (string) $uri->withPath("{$path->withoutTrailingSlash()}");
    }
}
