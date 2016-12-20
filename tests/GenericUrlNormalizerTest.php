<?php
declare(strict_types = 1);

namespace Hedii\UrlNormalizer\Tests;

use Hedii\UrlNormalizer\UrlNormalizer;

class GenericUrlNormalizerTest extends TestCase
{
    function test_it_should_normalize()
    {
        $url = 'https://example.com/path/';
        $this->assertEquals('https://example.com/path', UrlNormalizer::normalize($url));

        $url = 'https://example.com/long/path/';
        $this->assertEquals('https://example.com/long/path', UrlNormalizer::normalize($url));

        $url = 'https://example.com/path';
        $this->assertEquals('https://example.com/path', UrlNormalizer::normalize($url));

        $url = 'https://example.com/path/?key=value';
        $this->assertEquals('https://example.com/path?key=value', UrlNormalizer::normalize($url));

        $url = 'https://example.com/path?key=value';
        $this->assertEquals('https://example.com/path?key=value', UrlNormalizer::normalize($url));
    }
}
