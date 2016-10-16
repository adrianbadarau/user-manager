<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class UsersController extends Controller
{
    /**
     * @\Sensio\Bundle\FrameworkExtraBundle\Configuration\Route("/users")
    **/
    public function indexAction()
    {
        return new Response("Working");
    }
}
