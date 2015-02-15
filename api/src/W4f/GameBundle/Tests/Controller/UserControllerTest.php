<?php

namespace W4f\GameBundle\Tests\Controller;

use W4f\GameBundle\Action\ActionConstants;
use W4f\GameBundle\Tests\GenericTestCase;

class UserControllerTest extends GenericTestCase
{
	public function setUp(){
        parent::setUp();
		$this->apiPath ='/api/user';
        $this->method = 'POST';
	}

	public function testNominalCase(){
		$response = $this->launchQuery('{"newUser":{"login":"fred",
			"email":"an@email.fr","password":"fred1"}}');
    	$this->assertTrue($response->response);

    	// Retrieve the user
    	$em = $this->getContainer()->get('doctrine')->getManager();
    	$newUser = $em->getRepository('W4fModel:Account')->findOneByLogin("fred");
    	$this->assertNotNull($newUser, "User should be created in database");
    	$this->assertEquals("an@email.fr", $newUser->getEmail());

    	$cryptedPwd = password_hash("fred1", PASSWORD_BCRYPT, array('salt'=>ActionConstants::$userBcryptSalt));
    	$this->assertEquals($cryptedPwd, $newUser->getPassword());
    	
	}

	/**
	 * Test no user provided
	 */
	public function testNoUserProvided()
    {
    	$this->checkError('{}',
    		'ACCOUNT_EMAIL_EXISTS', 3);
    }

	/**
	 * Login should be provided
	 */
	public function testLoginNotProvided()
	{
		$this->checkError('{"newUser":{"email":"an@email.fr","password":"fred1"}}',
			'ACCOUNT_INVALID_LOGIN');
	}

	/**
	 * Login should be minimum 3 characters
	 */
	public function testLoginTooShort()
	{
		$this->checkError('{"newUser":{"login":"fr","email":"an@email.fr","password":"fred1"}}',
			'ACCOUNT_INVALID_LOGIN');
	}

    /**
     * Login should be maximum 16 characters
     */
    public function testLoginTooLong(){
    	$this->checkError('{"newUser":{"login":"Seventeeeen chars","email":"an@email.fr","password":"fred1"}}',
    		'ACCOUNT_INVALID_LOGIN');	
    }

    /**
     * Login contains invalid characters
     */
    public function testLoginForInvalidCharacters(){
    	$this->checkError('{"newUser":{"login":"stéphane","email":"an@email.fr","password":"fred1"}}',
    		'ACCOUNT_INVALID_LOGIN');
    	$this->checkError('{"newUser":{"login":"ste_phane","email":"an@email.fr","password":"fred1"}}',
    		'ACCOUNT_INVALID_LOGIN');
    	$this->checkError('{"newUser":{"login":"ste-phane","email":"an@email.fr","password":"fred1"}}',
    		'ACCOUNT_INVALID_LOGIN');
    }

    /**
     * Login "user1 already exists"
     */
    public function testLoginAlreadyExisting()
    {
    	$this->checkError('{"newUser":{"login":"user1","email":"an@email.fr","password":"fred1"}}',
    		'ACCOUNT_LOGIN_EXISTS');
    }

    /**
	 * Email should be provided
	 */
	public function testEmailNotProvided()
	{
		$this->checkError('{"newUser":{"login":"fred","password":"fred1"}}',
			'ACCOUNT_INVALID_EMAIL');
	}

    /**
     * Invalid email format
     */
    public function testWrongEmailFormat()
    {
    	$this->checkError('{"newUser":{"login":"user2","email":"an@email","password":"fred1"}}',
    		'ACCOUNT_INVALID_EMAIL');
    }

    /**
     * Email already used
     */
    public function testEmailAlreadyUsed()
    {
    	$this->checkError('{"newUser":{"login":"user2","email":"user1@mail.com","password":"fred1"}}',
    		'ACCOUNT_EMAIL_EXISTS');
    }

	/**
	 * Password should be provided
	 */
	public function testPasswordNotProvided()
	{
		$this->checkError('{"newUser":{"login":"fred","email":"an@email.fr", "password":"pwd"}}',
			'ACCOUNT_INVALID_PASSWORD', 1);
	}

    /**
     * Invalid password
     */
    public function testInvalidPassword()
    {
    	$this->checkError('{"newUser":{"login":"user2","email":"user2@mail.com","password":"pwd"}}',
    		'ACCOUNT_INVALID_PASSWORD');
    }

}
