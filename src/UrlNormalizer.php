<?php
declare(strict_types=1);

namespace Hedii\UrlNormalizer;

use League\Uri\Components\Host;
use League\Uri\Http;

class UrlNormalizer
{
    /**
     * Normalize a given url.
     *
     * @param string $url
     * @return string
     * @throws \Hedii\UrlNormalizer\Exceptions\BadUrlException
     */
    public static function normalize(string $url): string
    {
        $uri = Http::createFromString($url);

        if (self::isFromYoutube($uri)) {
            return YoutubeUrlNormalizer::normalize($uri);
        }

        return GenericUrlNormalizer::normalize($uri);
    }

    /**
     * Check whether the given url is from youtube.
     *
     * @param \League\Uri\Http $uri
     * @return bool
     */
    private static function isFromYoutube(Http $uri): bool
    {
        $host = new Host($uri->getHost());

        return in_array($host->getRegistrableDomain(), [
            'youtube.com', 'youtu.be'
        ]);
    }
}
