<?php

/*
 * This file is part of the JLMContactBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\OfficeBundle\Tests\Controller;

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
        	array('GET', '/office/bill'),
            array('GET', '/office/bill/inseizure'),
            array('GET', '/office/bill/sended'),
            array('GET', '/office/bill/payed'),
            array('GET', '/office/bill/canceled'),
            array('GET', '/office/bill/1/show'),
            array('GET', '/office/bill/new'),
            array('GET', '/office/bill/new/door/1'),
            array('GET', '/office/bill/new/quote/1'),
            array('GET', '/office/bill/new/intervention/1'),
            array('GET', '/office/bill/1/edit'),
            array('GET', '/office/bill/todo'),
            array('GET', '/office/bill/toboost'),
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