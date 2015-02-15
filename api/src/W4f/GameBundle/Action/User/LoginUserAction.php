<?php

namespace W4f\GameBundle\Action\User;

use W4f\GameBundle\Action\GenericAction;

use W4f\GameBundle\Model\Account;
use W4f\GameBundle\Model\UnitOfWork;
use W4f\GameBundle\Model\ControllerResponse;
use W4F\GameBundle\Action\ActionConstants;

/**
 * Performs checks on the user suscription.
 */
class LoginUserAction extends GenericAction{
    
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
        
        if ($this->user === null 
            || $this->user->getLogin() === null
            || $this->user->getPassword() === null)
        {
            $this->result->report->logError("ACCOUNT_MISSING_INFORMATION");
            $this->result->response = false;
            return $this->result;
        }

        // Hash the password
        $this->user->setPassword(password_hash($this->user->getPassword(), PASSWORD_BCRYPT, array('salt'=>ActionConstants::$userBcryptSalt)));
        
        if(!$this->comparePassword()){
            $this->result->response = false;
            return $this->result;
        }
        
        $this->result->response = true;
        return $this->result;
    }
    
    private function comparePassword(){
        // Get user and password
        $login = $this->user->getLogin();
        $password = $this->user->getPassword();
        
        // Find account and check password.
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
                $this->result->report->logError('AUTHENTICATION_FAILED');
            }
        }
        return count($this->result->report->errors) === 0;   
    }
}