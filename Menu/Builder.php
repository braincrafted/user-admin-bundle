<?php
/**
 * This file is part of BcUserAdminBundle.
 * (c) 2013 Florian Eckerstorfer
 */

namespace Bc\Bundle\UserAdminBundle\Menu;

use Symfony\Component\Translation\TranslatorInterface;
use Knp\Menu\FactoryInterface;

/**
 * Builder
 *
 * @category   MenuBuilder
 * @package    BcUserAdminBundle
 * @subpackage Menu
 * @author     Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright  2013 Florian Eckerstorfer
 * @license    http://opensource.org/licenses/MIT The MIT License
 */
class Builder
{
    /** @var FactoryInterface */
    private $factory;

    /** @var TranslatorInterface */
    private $translator;

    /**
     * @param FactoryInterface $factory
     */
    public function __construct(FactoryInterface $factory, TranslatorInterface $translator)
    {
        $this->factory      = $factory;
        $this->translator   = $translator;
    }

    /**
     * Returns the user admin menu.
     *
     * @return \Knp\Menu\ItemInterface
     */
    public function createUserAdminMenu()
    {
        $menu = $this->factory->createItem('root');

        $menu->addChild(
            $this->translator->trans('menu.users', array(), 'BcUserAdminBundle'),
            array('route' => 'bc_user_admin_list')
        );

        $menu->addChild(
            $this->translator->trans('menu.invite', array(), 'BcUserAdminBundle'),
            array('route' => 'bc_user_admin_invite_list')
        );

        $menu->addChild(
            $this->translator->trans('menu.invite_requests', array(), 'BcUserAdminBundle'),
            array('route' => 'bc_user_admin_invite_request_list')
        );

        return $menu;
    }
}
