<?php
declare(strict_types=1);

namespace Hedii\UrlNormalizer\Tests;

use Hedii\UrlNormalizer\Exceptions\BadUrlException;
use Hedii\UrlNormalizer\UrlNormalizer;
use PHPUnit\Framework\TestCase;

class YoutubeUrlNormalizerTest extends TestCase
{
    function test_it_should_preserve_simple_url()
    {
        $url = 'https://www.youtube.com/watch?v=W1xb2_AuT1g';
        $this->assertEquals($url, UrlNormalizer::normalize($url));
    }

    function test_it_should_preserve_playlist()
    {
        $url = 'https://www.youtube.com/playlist?list=PLAQ_MPsE0NDdXx5_Z6OFA2rqPYjnE4rCW';
        $this->assertEquals('https://www.youtube.com/playlist?list=PLAQ_MPsE0NDdXx5_Z6OFA2rqPYjnE4rCW', UrlNormalizer::normalize($url));

        $url = 'https://m.youtube.com/playlist?list=PL1Pt51M5eWusZLTSPelXH4nvqn0MS_tvf';
        $this->assertEquals('https://www.youtube.com/playlist?list=PL1Pt51M5eWusZLTSPelXH4nvqn0MS_tvf', UrlNormalizer::normalize($url));
    }

    function test_it_should_normalize()
    {
        $url = 'https://youtu.be/W1xb2_AuT1g';
        $this->assertEquals('https://www.youtube.com/watch?v=W1xb2_AuT1g', UrlNormalizer::normalize($url));

        $url = 'https://youtu.be/TDE3WdDZZkg?list=PLN89NxbH9NdVd71p7IXQKUCR2mD5FatS-';
        $this->assertEquals('https://www.youtube.com/watch?v=TDE3WdDZZkg', UrlNormalizer::normalize($url));

        $url = 'https://youtu.be/W1xb2_AuT1g?t=35s';
        $this->assertEquals('https://www.youtube.com/watch?v=W1xb2_AuT1g', UrlNormalizer::normalize($url));

        $url = 'https://youtu.be/TDE3WdDZZkg?list=PLN89NxbH9NdVd71p7IXQKUCR2mD5FatS-&index=3';
        $this->assertEquals('https://www.youtube.com/watch?v=TDE3WdDZZkg', UrlNormalizer::normalize($url));

        $url = 'https://www.youtube.com/watch?v=zXm9Wh01AdI&list=RDzXm9Wh01AdI#t=433';
        $this->assertEquals('https://www.youtube.com/watch?v=zXm9Wh01AdI', UrlNormalizer::normalize($url));

        $url = 'https://www.youtube.com/watch?list=PLw1x_9cqfRAJlaZXSdmXutpLD9uxx3F-C&v=-CzyZ563oq4';
        $this->assertEquals('https://www.youtube.com/watch?v=-CzyZ563oq4', UrlNormalizer::normalize($url));

        $url = 'https://youtu.be/BaW_jenozKc';
        $this->assertEquals('https://www.youtube.com/watch?v=BaW_jenozKc', UrlNormalizer::normalize($url));

        $url = 'http://youtu.be/BaW_jenozKc';
        $this->assertEquals('https://www.youtube.com/watch?v=BaW_jenozKc', UrlNormalizer::normalize($url));

        $url = 'https://m.youtube.com/watch?v=BaW_jenozKc';
        $this->assertEquals('https://www.youtube.com/watch?v=BaW_jenozKc', UrlNormalizer::normalize($url));

        $url = 'http://m.youtube.com/watch?v=BaW_jenozKc';
        $this->assertEquals('https://www.youtube.com/watch?v=BaW_jenozKc', UrlNormalizer::normalize($url));

        $url = 'https://www.youtube.com/watch?v=34q6tCsH8pI&feature=youtu.be&list=PL27A1108E686D913B';
        $this->assertEquals('https://www.youtube.com/watch?v=34q6tCsH8pI', UrlNormalizer::normalize($url));

        $url = 'https://www.youtube.com/watch?v=zXm9Wh01AdI&list=RDzXm9Wh01AdI#t=433';
        $this->assertEquals('https://www.youtube.com/watch?v=zXm9Wh01AdI', UrlNormalizer::normalize($url));

        $url = 'https://youtu.be/TDE3WdDZZkg?list=PLN89NxbH9NdVd71p7IXQKUCR2mD5FatS-';
        $this->assertEquals('https://www.youtube.com/watch?v=TDE3WdDZZkg', UrlNormalizer::normalize($url));

        $url = 'https://www.youtube.com/watch?v=zXm9Wh01AdI&list=RDzXm9Wh01AdI&t=433';
        $this->assertEquals('https://www.youtube.com/watch?v=zXm9Wh01AdI', UrlNormalizer::normalize($url));

        $url = 'https://youtu.be/0DdGTsenvjw?t=35s';
        $this->assertEquals('https://www.youtube.com/watch?v=0DdGTsenvjw', UrlNormalizer::normalize($url));

        $url = 'https://youtu.be/TDE3WdDZZkg?list=PLN89NxbH9NdVd71p7IXQKUCR2mD5FatS-&index=3';
        $this->assertEquals('https://www.youtube.com/watch?v=TDE3WdDZZkg', UrlNormalizer::normalize($url));

        $url = 'https://www.youtube.com/watch?v=W1xb2_AuT1g&t=1s&list=PLAQ_MPsE0NDdXx5_Z6OFA2rqPYjnE4rCW&index=2';
        $this->assertEquals('https://www.youtube.com/watch?v=W1xb2_AuT1g', UrlNormalizer::normalize($url));

        $url = 'https://www.youtube.com/watch?v=W1xb2_AuT1g&index=2&list=PLAQ_MPsE0NDdXx5_Z6OFA2rqPYjnE4rCW';
        $this->assertEquals('https://www.youtube.com/watch?v=W1xb2_AuT1g', UrlNormalizer::normalize($url));

        $url = 'https://www.youtube.com/embed/1v9vo6Wkn_o?autoplay=1&enablejsapi=1&origin=https://www.bing.com';
        $this->assertEquals('https://www.youtube.com/watch?v=1v9vo6Wkn_o', UrlNormalizer::normalize($url));

        $url = 'https://www.youtube.com/watch?v=64Jc_9lTObg&oref=https://www.youtube.com/watch?v=64Jc_9lTObg&has_verified=1';
        $this->assertEquals('https://www.youtube.com/watch?v=64Jc_9lTObg', UrlNormalizer::normalize($url));

        $url = 'https://www.youtube.com/watch?v=RRRSem1ux_U&spfreload=1';
        $this->assertEquals('https://www.youtube.com/watch?v=RRRSem1ux_U', UrlNormalizer::normalize($url));

        $url = 'https://www.youtube.com/watch?v=gjxHdNxvySU&app=desktop';
        $this->assertEquals('https://www.youtube.com/watch?v=gjxHdNxvySU', UrlNormalizer::normalize($url));

        $url = 'https://m.youtube.com/watch?v=O6GW76RnpL8&itct=CA4QpDAYAyITCNuvgqL67tACFU8BHAodpFwMvjIGcmVsbWZ1SKjzoo_lz7Ko8AE=';
        $this->assertEquals('https://www.youtube.com/watch?v=O6GW76RnpL8', UrlNormalizer::normalize($url));

        $url = 'https://m.youtube.com/watch?list=PL1Pt51M5eWusZLTSPelXH4nvqn0MS_tvf&v=RPX8dKNhKyA';
        $this->assertEquals('https://www.youtube.com/watch?v=RPX8dKNhKyA', UrlNormalizer::normalize($url));

        $url = 'https://www.youtube.com/watch?v=elNnDylfSBo&gl=BE';
        $this->assertEquals('https://www.youtube.com/watch?v=elNnDylfSBo', UrlNormalizer::normalize($url));

        $url = 'https://www.youtube.com/watch?v=8B2KSUr95k8&feature=share';
        $this->assertEquals('https://www.youtube.com/watch?v=8B2KSUr95k8', UrlNormalizer::normalize($url));

        $url = 'http://www.youtube.com/watch?v=hbPQhCfgYqk&feature=youtube_gdata_player';
        $this->assertEquals('https://www.youtube.com/watch?v=hbPQhCfgYqk', UrlNormalizer::normalize($url));

        $url = 'https://www.youtube.com/watch?list=PLnT9vL8uxFW4SaU1a1z9fotQ4tux9VpGl&v=8Yfh2HcJvDc';
        $this->assertEquals('https://www.youtube.com/watch?v=8Yfh2HcJvDc', UrlNormalizer::normalize($url));
    }

    function test_it_should_throw_exception_if_url_cannot_be_normalized()
    {
        $url = 'http://www.youtube.com/blablablabla';

        $this->expectException(BadUrlException::class);
        $this->expectExceptionMessage("L'url fournie ({$url}) ne peut pas être normalisée.");

        UrlNormalizer::normalize($url);
    }

    function test_it_should_normalize_shared()
    {
        $url = 'https://www.youtube.com/shared?ci=5cFnziL4ufY';
        $this->assertEquals('https://www.youtube.com/shared?ci=5cFnziL4ufY', UrlNormalizer::normalize($url));
    }
}
