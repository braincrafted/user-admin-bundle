<?php
/**
 * This file is part of BcUserAdminBundle.
 * (c) 2013 Florian Eckerstorfer
 */

namespace Bc\Bundle\UserAdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Bc\Bundle\UserAdminBundle\Form\Type\CreateUserType;
use Bc\Bundle\UserAdminBundle\Form\Type\UpdateUserType;
use Bc\Bundle\UserBundle\Entity\User;

/**
 * UserAdminController
 *
 * @category    Controller
 * @package     BcUserAdminBundle
 * @subpackage  Controller
 * @author      Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright   2013 Florian Eckerstorfer
 * @license     http://opensource.org/licenses/MIT The MIT License
 */
class InviteRequestAdminController extends Controller
{
    /**
     * List action.
     *
     * @return string The response
     */
    public function listAction()
    {
        $inviteRequestManager = $this->getInviteRequestManager();

        return $this->render('BcUserAdminBundle:InviteRequestAdmin:list.html.twig', array(
            'inviteRequests' => $inviteRequestManager->findInviteRequests()
        ));
    }

    public function inviteAction($inviteRequestId)
    {
        $inviteRequestManager = $this->getInviteRequestManager();
        $inviteManager        = $this->getInviteManager();

        $inviteRequest = $inviteRequestManager->findInviteRequest($inviteRequestId);
        $invite        = $inviteManager->createInvite();

        $invite->setEmail($inviteRequest->getEmail());
        $inviteManager->updateInvite($invite);

        $inviteRequest->delete();
        $inviteRequestManager->updateInviteRequest($inviteRequest);

        return $this->redirect($this->generateUrl('bc_user_admin_invite_request_list'));
    }

    private function getInviteRequestManager()
    {
        return $this->get('bc_user.invite_request_manager');
    }

    private function getInviteManager()
    {
        return $this->get('bc_user.invite_manager');
    }
}