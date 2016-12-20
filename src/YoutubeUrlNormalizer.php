<?php
declare(strict_types = 1);

namespace Hedii\UrlNormalizer;

use Hedii\UrlNormalizer\Exceptions\BadUrlException;
use League\Uri\Schemes\Http as HttpUri;

class YoutubeUrlNormalizer implements UrlNormalizerInterface
{
    /**
     * Normalize a given http uri.
     *
     * @param \League\Uri\Schemes\Http $uri
     * @return string
     * @throws \Hedii\UrlNormalizer\Exceptions\BadUrlException
     */
    public static function normalize(HttpUri $uri): string
    {
        if ($uri->host->getRegisterableDomain() == 'youtu.be') {
            return HttpUri::createFromString('https://www.youtube.com')
                ->withPath('/watch')
                ->withQuery("v={$uri->path->withoutLeadingSlash()->__toString()}")
                ->__toString();
        }

        if ($uri->query->hasKey('v')) {
            return HttpUri::createFromString('https://www.youtube.com')
                ->withPath('/watch')
                ->withQuery("v={$uri->query->getValue('v')}")
                ->__toString();
        }

        if ($uri->query->hasKey('list')) {
            return HttpUri::createFromString('https://www.youtube.com')
                ->withPath('/playlist')
                ->withQuery("list={$uri->query->getValue('list')}")
                ->__toString();
        }

        if (string_starts_with($uri->getPath(), '/embed/')) {
            return HttpUri::createFromString('https://www.youtube.com')
                ->withPath('/watch')
                ->withQuery("v={$uri->path->getBasename()}")
                ->__toString();
        }

        throw new BadUrlException("L'url fournie ({$uri->__toString()}) ne peut pas être normalisée.");
    }
}
