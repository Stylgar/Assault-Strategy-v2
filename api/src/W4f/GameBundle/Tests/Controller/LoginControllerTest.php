<?php 

namespace W4f\GameBundle\Tests\Controller;

use W4f\GameBundle\Tests\GenericTestCase;

class LoginControllerTest extends GenericTestCase
{
	public function setUp(){
		parent::setUp();
		$this->apiPath ='/api/login';
		$this->method = 'POST';
	}

	/**
	 *Correct login and password provided
	 */
	public function testNominalCase(){
		$response = $this->launchQuery('{"login":"user1","password":"password"}');
    	$this->assertTrue($response->response);
	}

	/**
	 * Nothing in entry
	 */
	public function testNothingProvided(){
		$this->checkError('{}', 'ACCOUNT_MISSING_INFORMATION');
	}

	/**
	 * No login
	 */
	public function testLoginNotProvided(){
		$this->checkError('{"password":"password"}', 'ACCOUNT_MISSING_INFORMATION');
	}

	/**
	 * No password
	 */
	public function testPasswordNotProvided(){
		$this->checkError('{"login":"user1"}', 'ACCOUNT_MISSING_INFORMATION');
	}

	/**
	 * Non existent login
	 */
	public function testNonExistentLogin(){
		$this->checkError('{"login":"userdsqdqs1", "password":"password"}', 'AUTHENTICATION_FAILED');
	}

	/**
	 * Existing login, but bad password
	 */
	public function testBadPassword(){
		$this->checkError('{"login":"user1", "password":"password12345"}', 'AUTHENTICATION_FAILED');
	}
}