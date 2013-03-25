<?php
/**
 * This file is part of braincrafted/user-admin-bundle.
 *
 * (c) 2013 Florian Eckerstorfer
 */

namespace Bc\Bundle\UserAdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Bc\Bundle\UserBundle\Form\Type\UpdateUserType;
use Bc\Bundle\UserBundle\Entity\User;

/**
 * UserAdminController
 *
 * @package     braincrafted/user-admin-bundle
 * @subpackage  Controller
 * @author      Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright   2013 Florian Eckerstorfer
 * @license     http://opensource.org/licenses/MIT The MIT License
 */
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
     * @param Request $request The request
     *
     * @return string The response
     */
    public function createAction(Request $request)
    {
        $form = $this->createForm(new UpdateUserType(), new User());

        if ($request->isMethod('POST')) {
            $form->bind($request);

            if ($form->isValid()) {
                $user = $form->getData();
                $this->get('fos_user.user_manager')->updateUser($user);
                $this->flash('success', sprintf('The user %s has been created.', $user->getUsername()));
                return $this->redirect($this->generateUrl('bc_user_admin_list'));
            }
        }

        return $this->render('BcUserAdminBundle:UserAdmin:create.html.twig', array(
            'form'  => $form->createView()
        ));
    }

    /**
     * The update action.
     *
     * @param integer $userId  The user ID
     * @param Request $request The request object
     *
     * @return string          The response
     */
    public function updateAction($userId, Request $request)
    {
        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->findUserBy(array('id' => $userId));

        if (!$user) {
            $this->flash('error', sprintf('There is no user with the ID %d', $userId));
            return $this->redirect($this->generateUrl('bc_user_admin_list'));
        }

        $form = $this->createForm(new UpdateUserType(), $user);
        if ($request->isMethod('POST')) {
            $form->bind($request);

            if ($form->isValid()) {
                $user = $form->getData();
                $userManager->updateUser($user);

                $this->flash('success', sprintf('The user %s has been updated.', $user->getUsername()));
                return $this->redirect($this->generateUrl('bc_user_admin_list'));
            }
        }

        return $this->render('BcUserAdminBundle:UserAdmin:update.html.twig', array(
            'user'  => $user,
            'form'  => $form->createView()
        ));
    }

    /**
     * The delete action.
     *
     * @param integer $userId The user ID
     *
     * @return string The response
     */
    public function deleteAction($userId)
    {
        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->findUserBy(array('id' => $userId));
        if ($user) {
            $userManager->deleteUser($user);
            $this->flash('success', sprintf('The user %s has been deleted.', $user->getUsername()));
        } else {
            $this->flash('error', sprintf('There is no user with the ID %d', $userId));
        }

        return $this->redirect($this->generateUrl('bc_user_admin_list'));
    }

    /**
     * Sets a flash message.
     *
     * @param  string $type    The type of message (error|info|success|warning)
     * @param  string $message The message
     * @return void
     */
    protected function flash($type, $message)
    {
        $this->get('session')->getFlashBag()->add($type, $message);
    }
}