<?php

namespace W4f\GameBundle\Action\User;

use W4f\GameBundle\Action\GenericAction;

use W4f\GameBundle\Model\Account;
use W4f\GameBundle\Model\UnitOfWork;
use W4f\GameBundle\Model\ControllerResponse;

/**
 * Performs checks on the user suscription.
 */
class LoginUserAction extends GenericAction{
    
    public static $bcryptSalt = "war4funIsAWargameThatRocks";

    /**
     * The current user being added.
     * @var \W4f\GameBundle\Model\Account
     */
    private $user;
    
    /**
     * The current response to be sent back
     * @var \W4f\GameBundle\Model\ControllerResponse 
     */
    private $result;
    
    public function __construct(UnitOfWork $uow){
        $this->uoW = $uow;
    }
    
    /**
     * Checks a user can be added. Add the user to database.
     * 
     * @param \W4f\GameBundle\Action\User\UserInfo $user
     * @return \W4f\GameBundle\Model\ControllerResponse
     */
    public function loginUser(Account $user){
        // Set the different elements that will be used in the response.
        $this->user = $user;
        $this->result = new ControllerResponse();
        
        if (!$this->checkUserValidity()){
            $this->result->response = false;
            return $this->result;
        }
        // Hash the password
        $this->user->setPassword(password_hash($this->user->getPassword(), PASSWORD_BCRYPT, array('salt'=>static::$bcryptSalt)));
        
        
        $login = $this->user->getLogin();
        if(!$this->comparePassword($login)){
            $this->result->response = false;
            return $this->result;
        }
        
        
        $this->result->response = true;
        return $this->result;
    }
    
    /**
     * Verifies user account validity. Includes:
     * - login
     * - email
     * - password
     * @return boolean
     */
    private function checkUserValidity(){
        if ($this->user == null)
        {
            $this->result->report->logError("No user provided");
            return false;
        }

        // Check login
        $this->checkLogin();
             
        // Check password
        $this->checkPassword();

        return count($this->result->report->errors) == 0;
    }
    
    private function checkLogin(){
        $login = $this->user->getLogin();
        if ($login == null ){
            $this->result->report->logError('ACCOUNT_INVALID_LOGIN');
        }
    }
    
    private function checkPassword(){
        $password = $this->user->getPassword();
        if ($password === null){
            $this->result->report->logError('ACCOUNT_INVALID_PASSWORD');
        }
    }
    
    private function comparePassword($login){
        //recup le password
        $password = $this->user->getPassword();
        
        //trouve l'objet account
        $context = $this->uoW->getDbContext();
        $repository = $context->getRepository('W4fModel:Account');
        $accounts = $repository->findByLogin($login);
        if (count($accounts) !== 1){
            $this->result->report->logError("AUTHENTICATION_FAILED");
        }
        else{
            $account = $accounts[0];
            $passFromDb = $account->getPassword();
            if($passFromDb !== $password){
                $this->result->report->logError('ACCOUNT_INCORRECT_PASSWORD');
            }
        }
        return count($this->result->report->errors) === 0;   
    }
}