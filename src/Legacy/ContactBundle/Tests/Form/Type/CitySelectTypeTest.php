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

use JLM\ContactBundle\Form\Type\CitySelectType;
use JLM\ContactBundle\Entity\City;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\Form\PreloadedExtension;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class CitySelectTypeTest extends TypeTestCase
{   
    /**
     * @var CitySelectType
     */
    protected $type;
    
    /**
     * @var City
     */
    protected $object;
    
    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();
    }
    
    /**
     * {@inheritdoc}
     */
    protected function getExtensions()
    {
        $childType = new \Genemu\Bundle\FormBundle\Form\JQuery\Type\Select2Type('hidden');
        return array(new PreloadedExtension(array(
            $childType->getName() => $childType,
        ), array()));
    }
    
    public function testCreateForm()
    {
        $om = $this->getMock('Doctrine\Common\Persistence\ObjectManager');
        $this->type = new CitySelectType($om);
        $this->object = new City();
        $this->object->setName('Othis')->setZip(77280);
        $form = $this->factory->create($this->type);
    }
}
 