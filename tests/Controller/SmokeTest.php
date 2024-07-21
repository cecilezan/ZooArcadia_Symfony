<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SmokeTest extends WebTestCase
{
    public function testApiDocUrlIsSuccessful(){
        $client = self::createClient();
        $client->request('GET', '/api/doc');

        self::assertResponseIsSuccessful();
    }

    public function testLoginRouteCanConnectAValidUser(){
        $client = self::createClient();
        $client->request('POST', 'api/login');
        $statusCode = $client->getResponse()->getStatusCode();
        dd($statusCode);
    }

}