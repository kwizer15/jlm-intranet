<?php

/*
 * This file is part of the JLMModelBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\ModelBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class DoorControllerTest extends WebTestCase
{
    /**
     * @var Symfony\Bundle\FrameworkBundle\Client
     */
    private $client;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->client = static::createClient();
        $this->client->followRedirects();
    }

    public function getUrls()
    {
        return [
            [
                'GET',
                '/model/door/1/show',
            ],
            [
                'GET',
                '/model/door/1/edit',
            ],
            [
                'GET',
                '/model/door/new/1',
            ],
        ];
    }

    /**
     * @dataProvider getUrls
     *
     * @param string $method
     * @param string $url
     */
    public function testUrlIsSuccessful($method, $url)
    {
        $crawler = $this->client->request(
            $method,
            $url
        );
        $crawler = $this->login($crawler);
        $this->assertTrue($this->client->getResponse()->isSuccessful());
    }

    /**
     * Log the user
     *
     * @param Crawler $crawler
     */
    private function login($crawler)
    {
        $form = $crawler->selectButton('_submit')->form();

        // définit certaines valeurs
        $form['_username'] = 'kwizer';
        $form['_password'] = 'sslover';
        return $this->client->submit($form);
    }
}
