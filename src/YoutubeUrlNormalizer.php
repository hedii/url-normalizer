<?php
declare(strict_types=1);

namespace Hedii\UrlNormalizer;

use Hedii\UrlNormalizer\Exceptions\BadUrlException;
use League\Uri\Components\HierarchicalPath;
use League\Uri\Components\Query;
use League\Uri\Http;

class YoutubeUrlNormalizer implements UrlNormalizerInterface
{
    /**
     * Normalize a given http uri.
     *
     * @param \League\Uri\Http $uri
     * @return string
     * @throws \Hedii\UrlNormalizer\Exceptions\BadUrlException
     */
    public static function normalize(Http $uri): string
    {
        $path = new HierarchicalPath($uri->getPath());
        $query = new Query($uri->getQuery());

        if ($uri->getHost() === 'youtu.be') {
            return (string) Http::createFromString('https://www.youtube.com')
                ->withPath('/watch')
                ->withQuery("v={$path->withoutLeadingSlash()}");
        }

        if ($query->hasPair('v')) {
            return (string) Http::createFromString('https://www.youtube.com')
                ->withPath('/watch')
                ->withQuery("v={$query->getPair('v')}");
        }

        if ($query->hasPair('list')) {
            return (string) Http::createFromString('https://www.youtube.com')
                ->withPath('/playlist')
                ->withQuery("list={$query->getPair('list')}");
        }

        if (string_starts_with($uri->getPath(), '/embed/')) {
            return (string) Http::createFromString('https://www.youtube.com')
                ->withPath('/watch')
                ->withQuery("v={$path->getBasename()}");
        }

        if (string_starts_with($uri->getPath(), '/shared') && $query->hasPair('ci')) {
            return (string) $uri;
        }

        throw new BadUrlException("L'url fournie ({$uri}) ne peut pas être normalisée.");
    }
}
