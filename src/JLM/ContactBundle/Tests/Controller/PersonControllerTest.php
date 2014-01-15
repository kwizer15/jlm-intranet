<?php

namespace JLM\ContactBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PersonControllerTest extends WebTestCase
{
    
    public function testCompleteScenario()
    {
        // Create a new client to browse the application
        $client = static::createClient();

        // Create a new entry in the database
        $crawler = $client->request('GET', 'contact/person/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /person/");
        $crawler = $client->click($crawler->selectLink('Nouvelle personne')->link());

        // Fill in the form and submit it
        $form = $crawler->selectButton('Enregistrer')->form(array(
            'jlm_contactbundle_persontype[firstName]'  => 'Test',
        	'jlm_contactbundle_persontype[lastName]'  => 'Test',
        	'jlm_contactbundle_persontype[title]'  => 'M.',
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check data in the show view
        $this->assertGreaterThan(0, $crawler->filter('td:contains("Test")')->count(), 'Missing element td:contains("Test")');

        // Edit the entity
        $crawler = $client->click($crawler->selectLink('Editer')->link());

        $form = $crawler->selectButton('Enregistrer')->form(array(
            'jlm_contactbundle_persontype[firstName]'  => 'Emmanuel',
        	'jlm_contactbundle_persontype[lastName]'  => 'Bernaszuk',
        	'jlm_contactbundle_persontype[title]'  => 'M.',
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check the element contains an attribute with value equals "Foo"
        $this->assertGreaterThan(0, $crawler->filter('[value="Emmanuel"]')->count(), 'Missing element [value="Emmanuel"]');

        // Delete the entity
    //    $client->submit($crawler->selectButton('Supprimer')->form());
    //    $crawler = $client->followRedirect();

        // Check the entity has been delete on the list
    //    $this->assertNotRegExp('/Foo/', $client->getResponse()->getContent());
    }

    
}
