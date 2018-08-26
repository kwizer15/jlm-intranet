<?php

/*
 * This file is part of the  package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\ContactBundle\Tests\Form\Type;

use JLM\ContactBundle\Form\Type\PersonType;
use JLM\ContactBundle\Entity\Person;
use JLM\ContactBundle\Form\Type\AddressType;
use JLM\ContactBundle\Form\Type\CitySelectType;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\Form\PreloadedExtension;
use JLM\ContactBundle\Form\Type\ContactType;
use JLM\ContactBundle\Form\Type\ContactPhoneCollectionType;
use JLM\ContactBundle\Form\Type\ContactPhoneType;
use JLM\ContactBundle\Form\Type\PhoneType;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class PersonTypeTest extends TypeTestCase
{

    /**
     * @var AddressType
     */
    protected $type;
    
    /**
     * @var Address
     */
    protected $object;
    
    /**
     * {@inheritdoc}
     */
    protected function getExtensions()
    {
        $om = $this->getMock('Doctrine\Common\Persistence\ObjectManager');
        $s2 = new \Genemu\Bundle\FormBundle\Form\JQuery\Type\Select2Type('hidden');
        $city = new CitySelectType($om);
        $address = new AddressType();
        $contact = new ContactType();
        $contactphonecollection = new ContactPhoneCollectionType();
        $contactphone = new ContactPhoneType();
        $phone = new PhoneType();
        return [new PreloadedExtension([
            $address->getName() => $address,
            $city->getName() => $city,
            $s2->getName() => $s2,
            $contact->getName() => $contact,
            $contactphonecollection->getName() => $contactphonecollection,
            $contactphone->getName() => $contactphone,
            $phone->getName() => $phone,
        ], [])];
    }
    
    public function testCreateForm()
    {
        $this->type = new PersonType;
        $form = $this->factory->create($this->type);
        
        $this->object = new Person;
    }
}
