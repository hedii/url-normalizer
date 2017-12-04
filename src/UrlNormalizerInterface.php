<?php
declare(strict_types=1);

namespace Hedii\UrlNormalizer;

use League\Uri\Http;

interface UrlNormalizerInterface
{
    /**
     * Normalize a given http uri.
     *
     * @param \League\Uri\Http $uri
     * @return string
     */
    public static function normalize(Http $uri): string;
}
