<?php
/**
 * Created by PhpStorm.
 * User: Noujoud
 * Date: 12/14/2018
 * Time: 8:00 AM
 */

namespace Cabinet\abinetBundle\Redirection;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Http\Logout\LogoutSuccessHandlerInterface;
use Symfony\Component\Routing\RouterInterface;


class AfterLogoutRedirect implements LogoutSuccessHandlerInterface
{
    /**
     * @var \Symfony\Component\Routing\RouterInterface
     */
    private $router;
    /**
     * @var \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface
     */
    private $security;
    /**
     * @param TokenStorageInterface $security
     */
    public function __construct(RouterInterface $router, TokenStorageInterface $security)
    {
        $this->router = $router;
        $this->security = $security;
    }

    /**
     * Creates a Response object to send upon a successful logout.
     *
     * @return Response never null
     */
    public function onLogoutSuccess(Request $request)
    {
        // Get list of roles for current user
        $roles = $this->security->getToken()->getRoles();
        // Tranform this list in array
        $rolesTab = array_map(function($role){
            return $role->getRole();
        }, $roles);
        // If is a commercial user or admin or super admin we redirect to the login area. Here we used FoseUserBundle bundle
        if (in_array('ROLE_PATIENT', $rolesTab, true) || in_array('ROLE_DOCTOR', $rolesTab, true) || in_array('ROLE_SECRETARY', $rolesTab, true))
            $response = new RedirectResponse($this->router->generate('fos_user_security_login'));
        // otherwise we redirect user to the homepage of website
        else
            $response = new RedirectResponse($this->router->generate('cabinetabinet_homepage'));
        return $response;
    }
}