<?php

namespace Bc\Bundle\UserAdminBundle\Menu;

use Knp\Menu\FactoryInterface;

class Builder
{
    /** @var FactoryInterface */
    private $factory;

    /**
     * @param FactoryInterface $factory
     */
    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    /**
     * Returns the user admin menu.
     *
     * @return \Knp\Menu\ItemInterface
     */
    public function createUserAdminMenu()
    {
        $menu = $this->factory->createItem('root');

        return $menu;
    }
}
