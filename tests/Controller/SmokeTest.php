<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SmokeTest extends WebTestCase
{
    public function testHomePageIsSuccessful()
    {
        $client = static::createClient();
        $client->request('GET', '/');
        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function testLoginPageIsSuccessful()
    {
        $client = static::createClient();
        $client->request('GET', '/login');
        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function testGemPageIsSuccessful()
    {
        $client = static::createClient();
        $client->request('GET', '/gem');
        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function testJewelriesPageIsSuccessful()
    {
        $client = static::createClient();
        $client->request('GET', '/jewelries');
        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function testApiDocsPageIsSuccessful()
    {
        $client = static::createClient();
        $client->request('GET', '/api/docs');
        $statusCode = $client->getResponse()->getStatusCode();
        $this->assertTrue(in_array($statusCode, [200, 401, 404]), 
            "Expected 200, 401, or 404 but got $statusCode");
    }

    public function testApiGemsEndpoint()
    {
        $client = static::createClient();
        $client->request('GET', '/api/gems');
        $statusCode = $client->getResponse()->getStatusCode();
        $this->assertTrue(in_array($statusCode, [200, 401]), 
            "Expected 200 or 401 but got $statusCode");
    }
}