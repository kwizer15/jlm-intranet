<?php

/*
 * This file is part of the JLMCommerceBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\CommerceBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class BillControllerTest extends WebTestCase
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
        return array(
        	array('GET', '/bill/'),
        	array('GET', '/bill/?state=all'),
            array('GET', '/bill/?state=in_seizure'),
            array('GET', '/bill/?state=sended'),
            array('GET', '/bill/?state=payed'),
            array('GET', '/bill/?state=canceled'),
        	array('GET', '/bill/?state=canceled'),
        	array('GET', '/bill/?page=2'),
        	array('GET', '/bill/?state=canceled&page=1&limit=5'),
            array('GET', '/bill/1'),
            array('GET', '/bill/new'),
            array('GET', '/bill/1/edit'),
            array('GET', '/bill/todo'),
           // array('GET', '/bill/toboost'),
        );
    }
    
    /**
     * @dataProvider getUrls
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