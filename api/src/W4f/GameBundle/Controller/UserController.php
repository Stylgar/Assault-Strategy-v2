<?php

namespace W4f\GameBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use W4f\GameBundle\Model\Account;
use W4f\GameBundle\Action\User\AddUserAction;

class UserController extends Controller {

    
    /**
     * Awaited in the query:
     * { newUser: { login : xxx, password: yyyy, email : zzzz }}
     * @return JsonResponse<ServiceResponse<boolean>>
     */
    public function addUserAction() {
        $request = json_decode($this->get("request")->getContent(), true);

        // Decode request
        $newUser = $this->decodeAddQuery($request);
        
        // Call the business
        $uoW = $this->get('w4f_game.UoW');
        $action = new AddUserAction($uoW);
        $resultFromAction = $action->addUser($newUser);
        
        // Save the account
        if ($resultFromAction->response){
            $uoW->save();
        }

        // Answer.
        $response = new JsonResponse();
        $response->setData(array($resultFromAction));
        return $response;
    }
    
    /**
     * Performs clean decoding of the query.
     * @param array $request
     * @return Account
     */
    private function decodeAddQuery($request){
        $newUser = new Account();
        if (array_key_exists("newUser", $request)) {
            $newUserPost = $request["newUser"];
            if (array_key_exists('login', $newUserPost)){
                $newUser->setLogin($newUserPost["login"]);
            }
            if (array_key_exists('password', $newUserPost)){
                $newUser->setPassword($newUserPost["password"]);
            }
            if (array_key_exists('email', $newUserPost)){
                $newUser->setEmail($newUserPost["email"]);
            }
        }
        return $newUser;
    }

}
