<?php
require_once 'Twilio/Client.php';
require_once 'Twilio/Resource/Conference/Participant.php';
require_once 'Zend/Http/Client.php';
class Twilio_Resource_Conference_Participant_ParticipantTest extends PHPUnit_Framework_TestCase
{
    public function testUriString()
    {
        $twilio = new Twilio_Client('accountSid', 'authToken');
        $conference = new Twilio_Resource_Conference('confSid');
        $participant = new Twilio_Resource_Conference_Participant('sid', $conference);
        $this->assertEquals('Accounts/accountSid/Conferences/confSid/Participants/sid', (string) $participant);
    }

    public function testDefaultClient()
    {
        $twilio = $this->getMock('Twilio_Client', array(),  array('sid', 'token'));
        $conference = new Twilio_Resource_Conference('confSid');
        $participant = new Twilio_Resource_Conference_Participant('sid', $conference);
        $this->assertEquals($twilio, $participant->getTwilioClient());
    }
	
    public function testNoDefaultSid()
    {
        $this->markTestIncomplete('Refactor to test for required Sid/Conference');
        $twilio = new Twilio_Client('accountSid', 'authToken'); 
        $conference = new Twilio_Resource_Conference('confSid');
        $participant = new Twilio_Resource_Conference_Participant('sid', $conference);
       
        $this->assertEquals(null, $participant->getSid());
    }

    public function testGetCall()
    { 
        $conference = new Twilio_Resource_Conference('CFbbe46ff1274e283f7e3ac1df0072ab39');
        $participant = new Twilio_Resource_Conference_Participant('CA386025c9bf5d6052a1d1ea42b4d16662', $conference);
    	$call = $participant->getCall();
    	$this->assertType('Twilio_Resource_Call', $call, 'Participant did not return correct call resource');
    	$this->assertEquals('CA386025c9bf5d6052a1d1ea42b4d16662', $call->sid);
    }
    
    public function testLoad()
    {
        $twilio = $this->getMock('Twilio_Client', array('get'),  array('AC5ef872f6da5a21de157d80997a64bd33', 'token'));

        $conference = new Twilio_Resource_Conference('CFbbe46ff1274e283f7e3ac1df0072ab39');
        $participant = new Twilio_Resource_Conference_Participant('CA386025c9bf5d6052a1d1ea42b4d16662', $conference);
        $participant->setTwilioClient($twilio);
        
        //setup sample response
        $data = file_get_contents('Twilio/Resource/Conference/Participant.xml');
        $response = new Zend_Http_Response(200, array(), $data);
        $xml = simplexml_load_string($data);
        
        $twilio->expects($this->once())
               ->method('get')
               //->with($this->equalTo($account)) //not sure how to get this to work
               ->will($this->returnValue($response));

        $xml = $xml->Participant;
               
        $this->assertEquals((string) $xml->CallSid, $participant->sid);
        $this->assertEquals((string) $xml->ConferenceSid, $participant->conferenceSid);
        $this->assertEquals((string) $xml->AccountSid, $participant->accountSid);
        $this->assertEquals((string) $xml->Muted, $participant->muted);
        $this->assertEquals((string) $xml->Status, $participant->status);
        $this->assertEquals((string) $xml->StartConferenceOnEnter, $participant->startConferenceOnEnter);
        $this->assertEquals((string) $xml->EndConferenceOnExit, $participant->endConferenceOnExit);

        $this->assertEquals((string) $xml->DateCreated, $participant->dateCreated);
        $this->assertEquals((string) $xml->DateUpdated, $participant->dateUpdated);
    }
}