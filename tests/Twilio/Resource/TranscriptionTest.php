<?php
require_once 'Twilio/Client.php';
require_once 'Twilio/Resource/Transcription.php';
require_once 'Zend/Http/Client.php';
class Twilio_Resource_TranscriptionTest extends PHPUnit_Framework_TestCase
{
	public function testUriString()
	{
		$twilio = new Twilio_Client('accountSid', 'authToken'); 
		$transcription = new Twilio_Resource_Transcription('sid');
		$this->assertEquals('Accounts/accountSid/Transcriptions/sid', (string) $transcription);
	}
	
	public function testDefaultClient()
	{
		$twilio = $this->getMock('Twilio_Client', array(),  array('sid', 'token'));
		$transcription = new Twilio_Resource_Transcription();
		$this->assertEquals($twilio, $transcription->getTwilioClient());
	}
	
    public function testNoDefaultSid()
    {
        $twilio = new Twilio_Client('accountSid', 'authToken'); 
        $transcription = new Twilio_Resource_Transcription();
        $this->assertEquals(null, $transcription->getSid());
    }
	
    public function testGetRecording()
    { 
        $twilio = $this->getMock('Twilio_Client', array('get'),  array('AC5ef872f6da5a21de157d80997a64bd33', 'token'));
        
        $transcription = new Twilio_Resource_Transcription('TR8c61027b709ffb038236612dc5af8723');
        $transcription->setTwilioClient($twilio);
        
        //setup sample response
        $data = file_get_contents('Twilio/Resource/Transcription.xml');
        $response = new Zend_Http_Response(200, array(), $data);
        $xml = simplexml_load_string($data);
        
        $twilio->expects($this->once())
               ->method('get')
               //->with($this->equalTo($account)) //not sure how to get this to work
               ->will($this->returnValue($response));

        $xml = $xml->Transcription;
    	
    	$recording = $transcription->getRecording();
        $this->assertType('Twilio_Resource_Recording', $recording, 'Participant did not return correct recording resource');
        $this->assertEquals((string) $xml->RecordingSid, $recording->sid);
    }
    
    public function testGetData()
    {
        $twilio = $this->getMock('Twilio_Client', array('get'),  array('AC5ef872f6da5a21de157d80997a64bd33', 'token'));
        
        $transcription = new Twilio_Resource_Transcription('TR8c61027b709ffb038236612dc5af8723');
        $transcription->setTwilioClient($twilio);
        
        //setup sample response
        $data = file_get_contents('Twilio/Resource/Transcription.xml');
        $response = new Zend_Http_Response(200, array(), $data);
        $xml = simplexml_load_string($data);
        
        $twilio->expects($this->once())
               ->method('get')
               //->with($this->equalTo($account)) //not sure how to get this to work
               ->will($this->returnValue($response));

        $xml = $xml->Transcription;
               
        $this->assertEquals((string) $xml->Sid, $transcription->sid);
        $this->assertEquals((string) $xml->AccountSid, $transcription->accountSid);
        $this->assertEquals((string) $xml->DateCreated, $transcription->dateCreated);
        $this->assertEquals((string) $xml->DateUpdated, $transcription->dateUpdated);
        $this->assertEquals((string) $xml->Status, $transcription->status);
        
        $this->assertEquals((string) $xml->Type, $transcription->type);
        $this->assertEquals((string) $xml->RecordingSid, $transcription->recordingSid);
        $this->assertEquals((string) $xml->Duration, $transcription->duration);
        $this->assertEquals((string) $xml->TranscriptionText, $transcription->transcriptionText);
        $this->assertEquals((string) $xml->Price, $transcription->price);
    }
}