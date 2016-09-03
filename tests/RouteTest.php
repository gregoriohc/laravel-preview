<?php

namespace Gregoriohc\Preview\Tests;

class RouteTest extends TestCase
{
    public function testPreviewFound()
    {
        $crawler = $this->call('GET', '_preview/preview-tests::welcome');

        $this->assertEquals(200, $crawler->getStatusCode());

        $this->assertEquals('Welcome!', $crawler->getContent());
    }
}