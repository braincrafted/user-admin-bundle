<?php

namespace Bc\Bundle\UserAdminBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUserData implements FixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /** @var array */
    private $users = array(array(
        'username'  => 'admin',
        'password'  => 'admin',
        'email'     => 'admin@example.com',
        'role'     => 'ROLE_ADMIN'
    ));

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $manager = $this->container->get('fos_user.user_manager');

        foreach ($this->users as $userData) {
            $user = $manager->createUser();
            $user->setUsername($userData['username']);
            $user->setPlainPassword($userData['password']);
            $user->setEmail($userData['email']);
            $user->setRoles(array($userData['role']));
            $user->setEnabled(true);
            $manager->updateUser($user, false);
        }

        $this->container->get('doctrine.orm.entity_manager')->flush();
    }
}