<?php
declare(strict_types = 1);

namespace Hedii\UrlNormalizer;

use League\Uri\Schemes\Http as HttpUri;

interface UrlNormalizerInterface
{
    /**
     * Normalize a given http uri.
     *
     * @param \League\Uri\Schemes\Http $uri
     * @return string
     */
    public static function normalize(HttpUri $uri): string;
}
