<?php

/*
 * This file is part of the JLMContactBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\DailyBundle\Tests\Controller;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class InterventionControllerTest extends WebTestCase
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
    
    public function testNew()
    {
        $this->client->enableProfiler();
        $this->client->followRedirects();
        
        $crawler = $this->client->request('GET', '/daily/intervention/today');
        // Page d'identification (a supprimer plus tard)
        $crawler = $this->login($crawler);
        $this->assertTrue($this->client->getResponse()->isSuccessful());
    }
    
    public function testEntitiesAreValid()
    {
        $this->client->enableProfiler();
        $this->client->followRedirects();
        
        $crawler = $this->client->request('GET', '/daily/intervention/today');
        // Page d'identification (a supprimer plus tard)
        $crawler = $this->login($crawler);
        if ($profile = $this->client->getProfile()) {
            $this->assertEquals(0, $profile->getCollector('db')->getInvalidEntityCount());
        } else {
            $this->markTestSkipped('Profiler is not activated');
        }
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
