<?php
declare(strict_types = 1);

namespace Hedii\UrlNormalizer;

use League\Uri\Schemes\Http as HttpUri;

class GenericUrlNormalizer implements UrlNormalizerInterface
{
    /**
     * Normalize a given http uri.
     *
     * @param \League\Uri\Schemes\Http $uri
     * @return string
     */
    public static function normalize(HttpUri $uri): string
    {
        return $uri->withPath(
            $uri->path->withoutTrailingSlash()->__toString()
        )->__toString();
    }
}
