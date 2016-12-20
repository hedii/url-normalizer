<?php
declare(strict_types = 1);

namespace Hedii\UrlNormalizer;

use League\Uri\Schemes\Http as HttpUri;

class UrlNormalizer
{
    /**
     * Normalize a given url.
     *
     * @param string $url
     * @return string
     */
    public static function normalize(string $url): string
    {
        $uri = HttpUri::createFromString($url);

        if (self::isFromYoutube($uri)) {
            return YoutubeUrlNormalizer::normalize($uri);
        }

        return GenericUrlNormalizer::normalize($uri);
    }

    /**
     * Check whether the given url is from youtube.
     *
     * @param \League\Uri\Schemes\Http $uri
     * @return bool
     */
    private static function isFromYoutube(HttpUri $uri): bool
    {
        return in_array($uri->host->getRegisterableDomain(), [
            'youtube.com', 'youtu.be'
        ]);
    }
}
