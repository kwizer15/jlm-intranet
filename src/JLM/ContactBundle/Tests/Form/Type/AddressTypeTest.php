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

use JLM\ContactBundle\Form\Type\AddressType;
use JLM\ContactBundle\Entity\Address;
use JLM\ContactBundle\Form\Type\CitySelectType;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\Form\PreloadedExtension;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class AddressTypeTest extends TypeTestCase
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
        return [new PreloadedExtension([
            $city->getName() => $city,
            $s2->getName() => $s2,
        ], [])];
    }
    
    public function testCreateForm()
    {
        $this->type = new AddressType;
        $form = $this->factory->create($this->type);
        
        $this->object = new Address;
    }
}
