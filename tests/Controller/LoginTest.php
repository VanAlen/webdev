<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginTest extends WebTestCase
{
    public function testLoginPageLoads()
    {
        $client = static::createClient();
        $client->request('GET', '/login');
        
        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('form');
    }
    
    public function testLoginWithValidCredentials()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        
        $form = $crawler->selectButton('Sign in')->form([
            'username' => 'admin',
            'password' => 'admin123'
        ]);
        
        $client->submit($form);
        $this->assertResponseRedirects();
    }
}