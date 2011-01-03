<?php
require_once 'Twilio/Client.php';
require_once 'Twilio/Resource/Conference.php';
require_once 'Zend/Http/Client.php';
class Twilio_Resource_ConferenceTest extends PHPUnit_Framework_TestCase
{
	public function testUriString()
	{
		$twilio = new Twilio_Client('accountSid', 'authToken'); 
		$conference = new Twilio_Resource_Conference('sid');
		$this->assertEquals('Accounts/accountSid/Conferences/sid', (string) $conference);
	}
	
	public function testDefaultClient()
	{
		$twilio = $this->getMock('Twilio_Client', array(),  array('sid', 'token'));
		$conference = new Twilio_Resource_Conference();
		$this->assertEquals($twilio, $conference->getTwilioClient());
	}
	
    public function testNoDefaultSid()
    {
        $twilio = new Twilio_Client('accountSid', 'authToken'); 
        $conference = new Twilio_Resource_Conference();
        
        $this->assertEquals(null, $conference->getSid());
    }
	
	
    public function testGetCall()
    {
        $twilio = $this->getMock('Twilio_Client', array('get'),  array('AC5ef872f6da5a21de157d80997a64bd33', 'token'));
        
        $conference = new Twilio_Resource_Conference('CFbbe46ff1274e283f7e3ac1df0072ab39');
        $conference->setTwilioClient($twilio);
        
        //setup sample response
        $data = file_get_contents('Twilio/Resource/Conference.xml');
        $response = new Zend_Http_Response(200, array(), $data);
        $xml = simplexml_load_string($data);
        
        $twilio->expects($this->once())
               ->method('get')
               //->with($this->equalTo($account)) //not sure how to get this to work
               ->will($this->returnValue($response));

        $xml = $xml->Conference;
               
        $this->assertEquals((string) $xml->Sid, $conference->sid);
        $this->assertEquals((string) $xml->AccountSid, $conference->accountSid);
        $this->assertEquals((string) $xml->FriendlyName, $conference->friendlyName);
        $this->assertEquals((string) $xml->Status, $conference->status);
        
        $this->assertEquals((string) $xml->DateCreated, $conference->dateCreated);
        $this->assertEquals((string) $xml->DateUpdated, $conference->dateUpdated);
    }
}