<?php

/*
 * This file is part of the JLMFeeBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\FeeBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class FeesFollowerControllerTest extends WebTestCase
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
            ['GET', '/'],
            ['GET', '/1/edit'],
//          array('GET', '/1/generate'),
//          array('GET', '/1/print'),
        ];
    }
    
    /**
     * @dataProvider getUrls
     * @param string $method
     * @param string $url
     */
    public function testUrlIsSuccessful($method, $url)
    {
        $prefix = '/fee/fees';
        $crawler = $this->client->request(
            $method,
            $prefix.$url
        );
        $crawler = $this->login($crawler);
        $this->assertTrue($this->client->getResponse()->isSuccessful());
    }
    
    /**
     * Log the user
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
