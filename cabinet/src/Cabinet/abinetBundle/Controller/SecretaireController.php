<?php
/**
 * Created by PhpStorm.
 * User: Riadh
 * Date: 12/14/2018
 * Time: 2:26 AM
 */

namespace Cabinet\abinetBundle\Controller;

use Cabinet\abinetBundle\Form\RegistrationSecretaryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use FOS\UserBundle\Event\GetResponseUserEvent;

use FOS\UserBundle\FOSUserEvents;

use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\FormEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;

class SecretaireController extends Controller
{

    public function indexAction()
    {
        return $this->render('@Cabinetabinet/Default/home.html.twig');
    }

    public function registerSecretaryAction(Request $request)
    {
        $eventDispatcher = $this->get('event_dispatcher');
        $formFactory = $this->get('form.factory');
        $userManager = $this->get('fos_user.user_manager');

        $user = $userManager->createUser();
        $user->setEnabled(true);
        $user->addRole('ROLE_SECRETARY');
        $event = new GetResponseUserEvent($user, $request);
        $eventDispatcher->dispatch(FOSUserEvents::REGISTRATION_INITIALIZE, $event);
        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }
        $form = $formFactory->create(RegistrationSecretaryType::class);
        $form->setData($user);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $event = new FormEvent($form, $request);
                $userManager->updateUser($user);
                if (null === $response = $event->getResponse()) {
                    $url = $this->generateUrl('fos_user_registration_confirmed');
                    $response = new RedirectResponse($url);
                }
                $eventDispatcher->dispatch(FOSUserEvents::REGISTRATION_COMPLETED, new FilterUserResponseEvent($user, $request, $response));
                return $response;
            }
            $event = new FormEvent($form, $request);
            $eventDispatcher->dispatch(FOSUserEvents::REGISTRATION_FAILURE, $event);
            if (null !== $response = $event->getResponse()) {
                return $response;
            }
        }
        return $this->render('@Cabinetabinet/Registration/register_secretary.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}