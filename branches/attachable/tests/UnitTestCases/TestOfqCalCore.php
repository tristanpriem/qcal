<?php


require_once 'qCal/Property.php';
require_once 'qCal/Property/prodid.php';
require_once 'qCal/Component.php';
require_once 'qCal/Property/MultipleValue.php';
Mock::Generate('qCal_Property');
Mock::Generate('qCal_Property_MultipleValue');

Mock::Generate('qCal_Component');

        
function d($val)
{
    echo "<pre>";
    echo htmlentities(var_dump($val));
    echo "</pre>";
}

class TestOfqCalCore extends UnitTestCase
{
    protected $mockProperty;
    public function setup()
    {
        $property = new MockqCal_Property;
        $type = 'PRODID';
        $value = 'value';
        // create property mock object
        $property->setReturnValue('serialize', $value);
        $property->setReturnValue('getType', $type);
        $property->setReturnValue('allowsParent', true);
        
        $this->mockProperty = $property;
    }
    public function testCannontInstantiateqCal()
    {
        // @todo: don't know how to test this
    }
    public function testCreatevCalendarObject()
    {
        $cal = qCal::create();
        $this->assertTrue($cal instanceof qCal_Component_vcalendar);
    }
    public function testAttachProperty()
    {
        
        $cal = qCal::create();
        $cal->attach($this->mockProperty);
        $compareprop = $cal->get('PRODID');
        
        $this->assertEqual($compareprop->serialize(), 'value');
    }
    public function testRemoveProperty()
    {
        $cal = qCal::create();
        $cal->attach($this->mockProperty);
        $this->assertEqual($cal->get('PRODID')->serialize(), 'value');
        
        $cal->remove('PRODID');
        $this->assertNull($cal->getProperty('PRODID'));
    }
    public function testAddExistingNonMultiplePropertyThrowsException()
    {
        $cal = qCal::create();
        $property = new MockqCal_Property;
        $property->setReturnValue('getType', 'PROPERTY');
        $property->setReturnValue('isMultiple', false);
        $property->setReturnValue('allowsParent', true);
        
        $this->expectException(new qCal_Exception('Property ' . $property->getType() . ' is already set and does not allow multiple values'));
        $cal->attach($property);
        $cal->attach($property);
    }
    public function testAddExistingMultiplePropertyAddsToProperty()
    {
        $compare = array('value', 'value');
        
        $cal = qCal::create();
        
        $property = new MockqCal_Property_MultipleValue;
        $property->setReturnValue('getType', 'PROPERTY');
        $property->setReturnValue('isMultiple', true);
        $property->setReturnValue('allowsParent', true);
        $property->setReturnValue('getValue', $compare);
        
        $property2 = new MockqCal_Property_MultipleValue;
        $property2->setReturnValue('getType', 'PROPERTY');
        $property2->setReturnValue('isMultiple', true);
        $property2->setReturnValue('allowsParent', true);
        
        $cal->attach($property);
        $cal->attach($property2);
        
        $properties = $cal->getProperty('PROPERTY');
        
        $this->assertEqual($compare, $properties->getValue());
    }
    public function testqCalInvalidWithoutAnyComponents()
    {
        $cal = qCal::create();
        $this->assertFalse($cal->isValid());
    }
    public function testPrintCalendarSendsRightContentType()
    {
        // @todo: don't know how to test this
    }
    public function testAddComponent()
    {
        $cal = qCal::create();
        
        $component = new MockqCal_Component;
        $component->setReturnValue('getType', 'test');
        $component->setReturnValue('serialize', 'test');
        
        $cal->addComponent($component);
        $comparecomponent = $cal->get('test');
        $this->assertEqual($comparecomponent->serialize(), 'test');
    }
    /*
    // @todo: check that it is a requirement to have at least one component... I think it is - luke
    public function testCannotAddInvalidComponents()
    {
        $value = 'value';
        $cal = new qCal();
        
        $cal->addProperty('invalid', $value);
        $this->expectException();
    }
    public function testCanAddValidComponents()
    {
    }
    public function testRemoveComponents()
    {
    }
    public function testEditComponent()
    {
    }
    public function testCannotAddInvalidProperties()
    {
    }
    public function testCanAddValidProperties()
    {
    }
    public function testRemoveProperties()
    {
    }
    public function testEditProperties()
    {
    }*/
}