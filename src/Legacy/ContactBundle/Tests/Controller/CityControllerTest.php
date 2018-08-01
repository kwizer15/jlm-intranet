<?php

/*
 * This file is part of the JLMContactBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\ContactBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class CityControllerTest extends WebTestCase
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
    } 
    
    public function testGet()
    {
        $this->client->request(
            'GET',
            '/contact/city.json',
            array('id' => 1),
            array(),
            array(
                'CONTENT_TYPE' => 'application/json',
                'HTTP_X-Requested-With' => 'XMLHttpRequest',
            )
        );
        $this->assertTrue($this->client->getResponse()->isSuccessful());
    }
    
    public function testGetBadId()
    {
        $this->client->request(
            'GET',
            '/contact/city.json',
            array('id' => 'foo'),
            array(),
            array(
                'CONTENT_TYPE' => 'application/json',
                'HTTP_X-Requested-With' => 'XMLHttpRequest',
            )
        );
        $this->assertTrue($this->client->getResponse()->isSuccessful());
    }
    
    public function testSearch()
    {
        $this->client->request(
            'GET',
            '/contact/cities.json',
            array('q' => 'Othis'),
            array(),
            array(
                'CONTENT_TYPE' => 'application/json',
                'HTTP_X-Requested-With' => 'XMLHttpRequest',
            )
        );
        $this->assertTrue($this->client->getResponse()->isSuccessful());
    }
}