<?php

namespace W4f\GameBundle\Action\User;

use W4f\GameBundle\Action\GenericAction;

use W4f\GameBundle\Model\UserInfo;
use W4f\GameBundle\Model\UnitOfWork;
use W4f\GameBundle\Model\ControllerResponse;

/**
 * Performs checks on the user suscription.
 */
class AddUserAction extends GenericAction{
    
    /**
     * The current user being added.
     * @var \W4f\GameBundle\Model\UserInfo
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
    public function addUser(UserInfo $user){
        
        // Set the different elements that will be used in the response.
        $this->user = $user;
        $this->result = new ControllerResponse();
        
        if (!$this->checkUserValidity()){
            $this->result->response = false;
            return $this->result;
        }
        
        // Hash the password
        $this->user->setPassword(password_hash($this->user->getPassword(), PASSWORD_BCRYPT));
        
        // Create the user
        $context = $this->uoW->getDbContext();
        $context->persist($user);
        
        $this->result->response = true;
        return $this->result;
        
    }
    
    private function checkUserValidity(){
        
        if ($this->user == null)
        {
            $this->result->report->logError("No user provided");
            return false;
        }

        // Check login
        $login = $this->user->getLogin();
        if ($login == null || strlen($login) < 3 || strlen($login) > 16
                || !preg_match('#^[a-zA-Z][a-zA-Z0-9 ]+$#', $login)){
            $this->result->report->logError('Invalid login');
        }
        //TODO: add check that login does not exist.
        
        $email = $this->user->getEmail();
        if($email == null || !preg_match('#^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$#',$email)){
            $this->result->report->logError('Invalid email');
        }
        
        // Check password
        $password = $this->user->getPassword();
        if ($password == null || strlen($password) < 5){
            $this->result->report->logError('Invalid password');
        }
        
        return count($this->result->report->errors) == 0;
    }
}
