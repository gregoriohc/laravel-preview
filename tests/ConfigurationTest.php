<?php

namespace Gregoriohc\Preview\Tests;

class ConfigurationTest extends TestCase
{
    public function testForceIsNotEnabled()
    {
        $this->assertEquals(true, $this->app['config']['preview.force_enable']);
    }

    public function testDefaultRoute()
    {
        $this->assertEquals('_preview', $this->app['config']['preview.route']);
    }

    public function testDefaultMiddleware()
    {
        $this->assertEquals(['web'], $this->app['config']['preview.middleware']);
    }
}
