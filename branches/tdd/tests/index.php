<?php
// @todo: change qCal_Component_vcalendar to qCal_Component_Core or qCal_Component_Calendar
set_include_path(
    //'\\\\Mc2-server\\Software Downloads\\PHP Libs' . PATH_SEPARATOR .
    //'\\\\Mc2-server\\Projects\\MC2 Design\\002967_qCal_ Library_and_App\\Web_Build\\lib' . PATH_SEPARATOR .
    'C:\\htdocs\\qcal-rewrite\\lib' . PATH_SEPARATOR .
    'C:\\phplib' . PATH_SEPARATOR .
    'C:\\htdocs\\library' . PATH_SEPARATOR .
    // add simpletest directory here
    get_include_path()
);

require_once 'simpletest/unit_tester.php';
require_once 'simpletest/reporter.php';
require_once 'simpletest/mock_objects.php';

require_once 'qCal.php';
require_once 'qCal/Component.php';
require_once 'qCal/Property.php';
require_once 'qCal/Renderer.php';
require_once 'qCal/Exception.php';

Mock::generate('qCal_Property', 'Mock_qCal_Property');
Mock::generate('qCal_Component', 'Mock_qCal_Component');
Mock::generate('qCal_Attachable', 'Mock_qCal_Attachable');
Mock::generate('qCal_Renderer', 'Mock_qCal_Renderer');

class Mock_qCal_Component_ValidParents extends qCal_Component
{
    protected $validParents = array('VCALENDAR');
}

/**
 * Test components generically (none specifically)
 */
class Test_Of_qCal_Component extends UnitTestCase
{
    /**
     * Test that a component is "attachable" (extendes qCal_Attachable)
     * to another component
     */
    public function test_qCal_Component_Is_Attachable()
    {
        $calendar = new Mock_qCal_Component;
        $this->assertTrue($calendar instanceof qCal_Attachable);
    }
    /**
     * Test that when you serialize the data, it is valid according to 
     * RFC 2445
     */
    public function test_qCal_Component_Default_Renders_To_RFC2445()
    {
        $expected = "BEGIN:VCALENDAR\r\n";
        $expected .= "BEGIN:TESTCOMPONENT\r\n";
        $expected .= "END:TESTCOMPONENT\r\n";
        $expected .= "END:VCALENDAR";
        
        $cal = qCal::create();
        $component = new Mock_qCal_Component;
        $component->setReturnValue('canAttachTo', true);
        $component->setReturnValue('getType', 'TESTCOMPONENT');
        $component->setReturnValue('render', "BEGIN:TESTCOMPONENT\r\nEND:TESTCOMPONENT");
        $component->setReturnValue('getChildren', array());
        $cal->attach($component);
        $this->assertEqual($cal->render(), $expected);
    }
    /**
     * An attempt to attach an invalid attachable should result in an exception being thrown
     */
    public function test_qCal_Cannot_Attach_Invalid_Attachable()
    {
        $this->expectException(new qCal_Exception('You have supplied an invalid object to qCal_Component::attach'));
        $calendar = qCal::create();
        $attachable = new Mock_qCal_Attachable(); // property or component
        $attachable->setReturnValue('canAttachTo', false);
        $calendar->attach($attachable);
    }
    /**
     * Attaching a valid "attachable" results in a return value of true
     * also it should become available via said component's get() method
     */
    public function test_qCal_Can_Attach_Valid_Attachable()
    {
        $calendar = qCal::create();
        $attachable = new Mock_qCal_Attachable(); // property or component
        $attachable->setReturnValue('canAttachTo', true);
        $attachable->setReturnValue('getType', 'ACTUAL');
        $this->assertTrue($calendar->attach($attachable));
        $this->assertEqual($calendar->get('ACTUAL'), $attachable);
    }
    /**
     * Detach method should return true if it successfully removes, false if
     * the object it is trying to remove does't exist
     */
    public function test_qCal_Detach()
    {
        $cal = qCal::create();
        $attachable = new Mock_qCal_Attachable(); // property or component or param
        $attachable->setReturnValue('canAttachTo', true);
        $attachable->setReturnValue('getType', 'TESTTYPE');
        $cal->attach($attachable);
        $this->assertTrue($cal->detach('TESTTYPE'));
        $this->assertFalse($cal->detach('NONEXISTANT'));
    }
    
    /**
     * Test that components are only allowed to be attached to a "valid" parent
     */
    public function test_qCal_Component_Cannot_Attach_If_Not_In_Valid_Parents()
    {
        $cal = qCal::create();
        $event = new Mock_qCal_Component_ValidParents;
        
        $this->assertTrue($cal->attach($event));
    }
}

/**
 * Test qCal_Component_vcalendar (core vcalendar component) specifically
 */
class Test_Of_qCal_Core_Component extends UnitTestCase
{
    /**
     * Test that components give you the correct type (this may need to
     * be moved into more specific since it uses a specific component
     */
    public function test_qCal_Get_Type()
    {
        $this->assertEqual(qCal::create()->getType(), 'VCALENDAR');
    }
    /**
     * The qCal class cannot be instantiated because it is just a factory
     * for creating qCal_Component_vcalendar objects
     */
    public function test_qCal_Cannot_Be_Instantiated()
    {
        $this->expectException(new qCal_Exception('qCal cannot be instantiated. Use qCal::create()'));
        $calendar = new qCal();
    }
    /**
     * Test the factory method that generates a new qCal_Component_vcalendar component
     */
    public function test_Create_qCal_Component_vcalendar()
    {
        $calendar = qCal::create();
        $this->assertTrue($calendar instanceof qCal_Component_vcalendar);
        $this->assertTrue($calendar instanceof qCal_Component);
        $this->assertTrue($calendar instanceof qCal_Attachable);
    }
    /**
     * Test that qCal object uses rfc-compliant line endings
     */
    public function test_qCal_Uses_Correct_Line_Endings()
    {
        $this->assertEqual(qCal::LINE_ENDING, "\r\n");
    }
}

/**
 * Test calendar renderer
 */
class Test_Of_qCal_Property extends UnitTestCase
{
    /**
     * Test that a property is "attachable" (extendes qCal_Attachable)
     * to another component
     */
    public function test_qCal_Property_Is_Attachable()
    {
        $property = new Mock_qCal_Property;
        $this->assertTrue($property instanceof qCal_Attachable);
    }
}

require_once 'qCal/Renderer/Default.php';

/**
 * Test calendar renderer
 */
class Test_Of_qCal_Renderer extends UnitTestCase
{
    public function test_Default_Renderer()
    {
        $cal = qCal::create();
        $component = new Mock_qCal_Component;
        $component->setReturnValue('canAttachTo', true);
        $component->setReturnValue('getType', 'TESTCOMPONENT');
        $component->setReturnValue('getChildren', array());
        $component->setReturnValue('render', "BEGIN:TESTCOMPONENT\r\nEND:TESTCOMPONENT");
        $cal->attach($component);
        
        $expected = "BEGIN:VCALENDAR\r\n";
        $expected .= "BEGIN:TESTCOMPONENT\r\n";
        $expected .= "END:TESTCOMPONENT\r\n";
        $expected .= "END:VCALENDAR";
        
        $renderer = new qCal_Renderer_Default();
        $this->assertEqual($expected, $cal->render($renderer));
        
        // if you don't pass in a renderer, it uses the default one
        $this->assertEqual($expected, $cal->render());
    }
}

$test = new GroupTest('Core qCal Tests');
$test->addTestCase(new Test_Of_qCal_Property);
$test->addTestCase(new Test_Of_qCal_Component);
$test->addTestCase(new Test_Of_qCal_Core_Component);
$test->addTestCase(new Test_Of_qCal_Renderer);
$test->run(new HtmlReporter());