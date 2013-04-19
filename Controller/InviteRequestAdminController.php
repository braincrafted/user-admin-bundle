<?php
/**
 * This file is part of braincrafted/user-admin-bundle.
 *
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
 * @package     braincrafted/user-admin-bundle
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
        $inviteRequestManager = $this->get('bc_user.invite_request_manager');

        return $this->render('BcUserAdminBundle:InviteRequestAdmin:list.html.twig', array(
            'inviteRequests' => $inviteRequestManager->findInviteRequests()
        ));
    }
}