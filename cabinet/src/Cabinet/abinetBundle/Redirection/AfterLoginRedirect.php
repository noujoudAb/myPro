<?php
/**
 * Created by PhpStorm.
 * User: Riadh
 * Date: 12/14/2018
 * Time: 3:18 AM
 */

namespace Cabinet\abinetBundle\Redirection;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;

class AfterLoginRedirect implements AuthenticationSuccessHandlerInterface
    /*    implements AuthenticationSuccessHandlerInterface*/
{
    /**
     * @var \Symfony\Component\Routing\RouterInterface
     */
    private $router;

    /**
     * AfterLoginRedirect constructor.
     * @param RouterInterface $router
     */
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * This is called when an interactive authentication attempt succeeds. This
     * is called by authentication listeners inheriting from
     * AbstractAuthenticationListener.
     *
     * @return Response never null
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        // Get list of roles for current user
        $roles = $token->getRoles();
        // Tranform this list in array
        $rolesTab = array_map(function($role){ return $role->getRole(); }, $roles);
        // If is a doctor or super admin we redirect to the backoffice area
        if (in_array('ROLE_ADMIN', $rolesTab, true) )
        {
            $redirection = new RedirectResponse($this->router->generate('#'));
        }
        // If is a patient we redirect to the patient home
        elseif (in_array('ROLE_PATIENT', $rolesTab, true) )
        {
            $redirection = new RedirectResponse($this->router->generate('cabinetabinet_homepage'));
        }
        // If is a secretary we redirect to the secretaire home
        elseif (in_array('ROLE_SECRETARY', $rolesTab, true))
        {
            $redirection = new RedirectResponse($this->router->generate('cabinetabinet_homepage'));
        }
        else
        {
            $redirection = new RedirectResponse($this->router->generate('fos_user_registration_register'));

        }
        return $redirection;

    }

}