<?php

namespace W4f\GameBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class HomeController extends Controller
{
    public function indexAction()
    {
        $response = new JsonResponse();
        $response->setData(array(
            'Hello' => 1
        ));
        
        return $response;
    }
}
