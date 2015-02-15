<?php

namespace W4f\GameBundle\Tests;

use Liip\FunctionalTestBundle\Test\WebTestCase;

class GenericTestCase extends WebTestCase
{
	protected $apiPath;
	protected $method;

	public function __construct(){
		$this->apiPath = '/';
		$this->method = 'GET';
	}

	public function setUp(){
		$this->loadFixtures(array('W4f\GameBundle\Tests\DataFixtures\ORM\LoadAccountData'));
	}

	protected function checkError($input, $expectedError, $nbExpectedErrors = 1){
    	$response = $this->launchQuery($input);
    	
    	$this->assertFalse($response->response, "Response should be false");		
    	$this->assertEquals($nbExpectedErrors, count($response->report->errors), 
    		"$nbExpectedErrors error was awaited, got ".implode($response->report->errors, " --- "));
    	if ($nbExpectedErrors == 1){
    		$this->assertEquals($expectedError, $response->report->errors[0]);
    	}
    }

	protected function launchQuery($input=null){
    	$client = static::createClient();

    	$client->request($this->method, $this->apiPath, array(),array(),array(),$input);

    	$this->assertTrue(
    		$client->getResponse()->headers->contains(
    			'Content-Type',
    			'application/json'
    			)
    		);

    	return json_decode($client->getResponse()->getContent())[0];
    }
}