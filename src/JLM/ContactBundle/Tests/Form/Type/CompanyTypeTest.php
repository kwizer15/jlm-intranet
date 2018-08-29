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

use JLM\ContactBundle\Form\Type\CompanyType;
use JLM\ContactBundle\Entity\Company;
use JLM\ContactBundle\Form\Type\AddressType;
use JLM\ContactBundle\Form\Type\CitySelectType;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\Form\PreloadedExtension;
use JLM\ContactBundle\Form\Type\ContactPhoneCollectionType;
use JLM\ContactBundle\Form\Type\ContactPhoneType;
use JLM\ContactBundle\Form\Type\ContactType;
use JLM\ContactBundle\Form\Type\PhoneType;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class CompanyTypeTest extends TypeTestCase
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
        $phone = new PhoneType();
        $contactphone = new ContactPhoneType();
        $contactphonecollection = new ContactPhoneCollectionType();
        return [
            new PreloadedExtension(
                [
                    $address->getName() => $address,
                    $city->getName() => $city,
                    $s2->getName() => $s2,
                    $phone->getName() => $phone,
                    $contactphone->getName() => $contactphone,
                    $contactphonecollection->getName() => $contactphonecollection,
                ],
                []
            ),
        ];
    }

    public function testCreateForm()
    {
        $this->type = new CompanyType();
        $form = $this->factory->create($this->type);

        $this->object = new Company();
    }
}
