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

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PersonControllerTest extends WebTestCase
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
        $this->client->followRedirects();
        
        $crawler = $this->client->request('GET', '/contact/person/ajax/new');
        // Page d'identification (a supprimer plus tard)
        $crawler = $this->login($crawler);
        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $form = $crawler->selectButton('submit')->form();
        $form['jlm_contact_person[lastName]'] = 'Foo';
        $form['jlm_contact_person[firstName]'] = 'Bar';
        $form['jlm_contact_person[role]'] = 'FooBar';
        $form['jlm_contact_person[address][street]'] = '21 Jump Street';
        $form['jlm_contact_person[address][city]'] = '1';
        $form['jlm_contact_person[fixedPhone]'] = '0102030405';
        $form['jlm_contact_person[mobilePhone]'] = '0607080910';
        $form['jlm_contact_person[email]'] = 'machin@truc.com';

        $this->client->submit($form);
        $this->assertRegExp('/Bar Foo/', $this->client->getResponse()->getContent());       
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