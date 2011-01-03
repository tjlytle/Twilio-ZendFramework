<?php
require_once 'Twilio/Resource/ResourceAbstract.php';

class Twilio_Resource_ResourceAbstractTest extends PHPUnit_Framework_TestCase
{
    public function testGetType()
    {
    	$name = 'Test';
    	$resource = $this->getMock('Twilio_Resource_ResourceAbstract', null, array(), 'Twilio_Resource_' . $name);
    	$this->assertEquals($name, $resource->getType());
    }
}