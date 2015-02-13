<?php

namespace W4f\GameBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $client->request('GET', '/api/');

        //print_r($client->getResponse());
        $this->assertTrue(
		    $client->getResponse()->headers->contains(
		        'Content-Type',
		        'application/json'
		    )
		);

		$response = json_decode($client->getResponse()->getContent())[0];

		$this->assertTrue(array_key_exists('Hello', $response), "System should return an hello key");
		$this->assertEquals('hello!', $response->Hello);

		
    }
}
