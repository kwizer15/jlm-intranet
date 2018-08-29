<?php

/*
 * This file is part of the JLMStateBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\StateBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class DefaultControllerTest extends WebTestCase
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
                '/state/technicians',
            ],
            [
                'GET',
                '/state/technicians/2013',
            ],
            [
                'GET',
                '/state/maintenance',
            ],
            [
                'GET',
                '/state/top',
            ],
            [
                'GET',
                '/state/contracts',
            ],
            [
                'GET',
                '/state/quotes/2015',
            ],
            [
                'GET',
                '/state/transmitters',
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
