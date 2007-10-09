<?php


require_once 'qCal/Property.php';
Mock::Generate('qCal_Property');
        
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
        
        $this->mockProperty = $property;
    }
/*
    public function testqCalIsAComponent()
    {
        $cal = new qCal();
        $this->assertIsA($cal, 'qCal_Component_Abstract');
    }
    public function testqCalDefaults()
    {
        $cal = new qCal();
        $version = (string) $cal->getProperty('version');
        $prodid = (string) $cal->getProperty('prodid');
        d($cal);
        $this->assertEqual($version, '2.0');
        $this->assertEqual($prodid, '-//MC2 Design Group, Inc.//qCal v' . qCal::VERSION . '//EN');
    }*/
    public function testInstantiateqCal()
    {
        $cal = qCal::create();
        $this->assertIsA($cal, 'qCal_Component_vcalendar');
    }
    public function testAddProperty()
    {
        
        $cal = qCal::create();
        $cal->addProperty($this->mockProperty);
        $compareprop = $cal->getProperty('PRODID');
        
        $this->assertEqual($compareprop->serialize(), 'value');
    }
    public function testRemoveProperty()
    {
        $cal = qCal::create();
        $cal->addProperty($this->mockProperty);
        $this->assertEqual($cal->getProperty('PRODID')->serialize(), 'value');
        
        $cal->removeProperty('PRODID');
        $this->assertNull($cal->getProperty('PRODID'));
    }
    /*
    public function testAddExistingNonMultiplePropertyThrowsException()
    {
        $cal = qCal::create();
        $property = new Mock_qCal_Property('test');
        
        $this->expectException(new qCal_Component_Exception('Property ' . $property->getName() . ' may not be set on a VCALENDAR component'));
        // should throw an exception because prodid is already set (by default)
        $cal->addProperty($property);
    }
    public function testAddExistingMultiplePropertyAddsProperty()
    {
        $cal = new qCal();
        $property = new Mock_qCal_Property_MultipleValue();
        $property->setValue('test');
        $property->setValue('test_number_two');
        d($property);
        
        $value = 'QCALTESTPROPERTY:test' . qCal::LINE_ENDING . 'QCALTESTPROPERTY:test_number_two';
        
        $this->assertEqual($property->serialize(), $value);
    }
    public function testAddProperty()
    {
        $value = 'value';
        $cal = new qCal();
        
        $cal->addProperty(new qCal_Property_calscale($value));
        $calscale = (string) $cal->getProperty('calscale');
        //$this->assertEqual($calscale, $value);
        
        $cal->addProperty('prodid', $value);
        $prodid = (string) $cal->getProperty('prodid');
        //$this->assertEqual($prodid, $value);
    }
    public function testqCalSerialize()
    {
    }
    public function testSendsRightContentType()
    {
    }
    // @todo: check that it is a requirement to have at least one component... I think it is - luke
    public function testToStringFailsWithoutAnyComponents()
    {
    }
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