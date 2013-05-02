<?php

namespace Bc\Bundle\UserAdminBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Client;

use Bc\Bundle\TestingBundle\Test\WebTestCase;

class InviteControllerTest extends WebTestCase
{
    public function setUp()
    {
        $this->setUpKernel();
    }

    public function tearDown()
    {
        $this->tearDownKernel();
    }

    /**
     * @covers Bc\Bundle\UserAdminBundle\Controller\InviteController::listAction()
     */
    public function testList()
    {
        $client = $this->createClient();
        $this->login($client);

        $client->followRedirects();
        $crawler = $client->request('GET', '/invite');
        $this->assertGreaterThan(0, $crawler->filter('h1:contains("Invites")')->count());
    }

    /**
     * Login.
     *
     * @param Client $client The client
     *
     * @return void
     */
    protected function login(Client $client)
    {
        $crawler = $client->request('GET', '/login');
        $button = $crawler->selectButton('_submit');
        $form = $button->form(array(
            '_username' => 'admin',
            '_password' => 'admin'
        ));
        $client->submit($form);
    }
}
