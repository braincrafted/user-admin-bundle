<?php

namespace Bc\Bundle\UserAdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Bc\Bundle\UserBundle\Form\Type\CreateUserType;
use Bc\Bundle\UserBundle\Entity\User;

class UserAdminController extends Controller
{
    /**
     * List action.
     *
     * @return string The response
     */
    public function listAction()
    {
        $userManager = $this->get('fos_user.user_manager');
        return $this->render('BcUserAdminBundle:UserAdmin:list.html.twig', array(
            'users' => $userManager->findUsers()
        ));
    }

    /**
     * The create action.
     *
     * @param  Request $request The request
     *
     * @return string The response
     */
    public function createAction(Request $request)
    {
        $form = $this->createForm(new CreateUserType(), new User());

        if ($request->isMethod('POST')) {
            $form->bind($request);

            if ($form->isValid()) {
                $this->get('fos_user.user_manager')->updateUser($form->getData());
                return $this->redirect($this->generateUrl('bc_user_admin_list'));
            }
        }

        return $this->render('BcUserAdminBundle:UserAdmin:create.html.twig', array(
            'form'  => $form->createView()
        ));
    }

    public function deleteAction($userId)
    {
        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->findUserBy(array('id' => $userId));
        if ($user) {
            $userManager->deleteUser($user);
            return $this->redirect($this->generateUrl('bc_user_admin_list'));
        }
    }
}