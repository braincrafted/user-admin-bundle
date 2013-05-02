<?php
/**
 * This file is part of PhentsUserAdminBundle.
 * (c) 2013 Florian Eckerstorfer
 */

namespace Bc\Bundle\UserAdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * InviteController.
 *
 * @package    PhentsUserAdminBundle
 * @subpackage Controller
 * @author     Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright  2013 Florian Eckerstorfer
 * @link       http://phents.com Phents
 */
class InviteController extends Controller
{
    /**
     * List action.
     */
    public function listAction()
    {
        $manager = $this->get('bc_user.invite_manager');

        $invites = $manager->findInvites();

        $totalCount = $manager->getInviteCount();
        $usedCount = $manager->getUsedInvitesCount();
        $sentCount = $manager->getSentInvitesCount();

        $usedInvitesPercentage = (100/$totalCount)*$usedCount;
        $sentInvitesPercentage = (100/$totalCount)*($sentCount);

        return $this->render('BcUserAdminBundle:Invite:list.html.twig', array(
            'invites'                   => $invites,
            'usedInvitesPercentage'     => $usedInvitesPercentage,
            'sentInvitesPercentage'     => $sentInvitesPercentage,
            'usedInvitesCount'          => $usedCount,
            'sentInvitesCount'          => $sentCount
        ));
    }

    /**
     * Create action.
     */
    public function createAction()
    {
        $manager = $this->get('bc_user.invite_manager');
        $invite = $manager->createInvite();
        $manager->updateInvite($invite);

        $this->get('session')->getFlashBag()->add('success', sprintf('The invite %s has been created.', $invite->getCode()));

        return $this->redirect($this->generateUrl('bc_user_admin_invite_list'));
    }

    /**
     * Batch create action.
     *
     * @param integer $number The number of invites to create
     */
    public function batchCreateAction($number)
    {
        $manager = $this->get('bc_user.invite_manager');
        for ($i = 0; $i < $number; $i++) {
            $invite = $manager->createInvite();
            $manager->updateInvite($invite, false);
        }
        $manager->flush();

        $this->get('session')->getFlashBag()->add('success', sprintf('Created %d invites.', $number));
        return $this->redirect($this->generateUrl('bc_user_admin_invite_list'));
    }

    /**
     * Delete action.
     *
     * @param string $code The code of the invite
     */
    public function deleteAction($code)
    {
        $manager = $this->get('bc_user.invite_manager');
        $invite = $manager->findInviteByCode($code);

        if (!$invite) {
            $this->get('session')->getFlashBag()->add('error', sprintf('The invite %s does not exist.', $code));
        } else {
            if ($invite->getUser()) {
                $this->get('session')->getFlashBag()->add('error', sprintf('The invite %s has already been used by %s. You can\'t delete an used invite.', $invite->getCode(), $invite->getUser()));
            } else {
                $manager->deleteInvite($invite);

                $this->get('session')->getFlashBag()->add('success', sprintf('The invite %s has been deleted.', $invite->getCode()));
            }
        }

        return $this->redirect($this->generateUrl('bc_user_admin_invite_list'));
    }
}
