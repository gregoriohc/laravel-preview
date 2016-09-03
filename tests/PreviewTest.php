<?php

namespace Gregoriohc\Preview\Tests;

use Gregoriohc\Preview\Tests\Models\User;

class PreviewTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->artisan('migrate', [
            '--database' => 'testing',
            '--realpath' => realpath(__DIR__.'/migrations'),
        ]);
    }

    public function testDecodesJson()
    {
        $crawler = $this->call('GET', '_preview/preview-tests::json', [
            'myobject' => '{"foo": "bar"}',
        ]);

        $this->assertEquals('bar', $crawler->getContent());
    }

    public function testLoadsModel()
    {
        $userData = [
            'name'     => 'John Doe',
            'email'    => 'johndoe@example.com',
            'password' => 'secret',
        ];

        $user = User::create($userData);

        $user = User::find($user->id);

        $crawler = $this->call('GET', '_preview/preview-tests::model', [
            'user' => User::class.'::'.$user->id,
        ]);

        $this->assertEquals($userData['email'], $crawler->getContent());
    }

    public function testCallsCallableWithParams()
    {
        $crawler = $this->call('GET', '_preview/preview-tests::callable', [
            'something' => 'Config::get::app.missing_key::default_value',
        ]);

        $this->assertEquals('default_value', $crawler->getContent());

        $crawler = $this->call('GET', '_preview/preview-tests::callable', [
            'something' => 'Config::get::database.default',
        ]);

        $this->assertEquals('testing', $crawler->getContent());
    }

    public function testCreateAndCallsObjectMethodWithoutParams()
    {
        $crawler = $this->call('GET', '_preview/preview-tests::callable', [
            'something' => User::class.'::getTable',
        ]);

        $this->assertEquals('users', $crawler->getContent());
    }
}
