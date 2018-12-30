<?php

namespace Cabinet\abinetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@Cabinetabinet/Default/index.html.twig');
    }
}
