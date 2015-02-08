<?php

namespace W4f\GameBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use W4f\GameBundle\Model\UserInfo;
use W4f\GameBundle\Action\User\AddUserAction;

class UserController extends Controller {

    public function addUserAction() {
        $request = json_decode($this->get("request")->getContent(), true);

        $newUser = new UserInfo();
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
        
        $uoW = $this->get('w4f_game.UoW');
        $action = new AddUserAction($uoW);
        $resultFromAction = $action->addUser($newUser);
        
        if ($resultFromAction->response){
            $uoW->save();
        }

        $response = new JsonResponse();
        $response->setData(array($resultFromAction));

        return $response;
    }

}
