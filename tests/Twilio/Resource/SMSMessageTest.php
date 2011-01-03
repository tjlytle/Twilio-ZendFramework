<?php
require_once 'Twilio/Client.php';
require_once 'Twilio/Resource/SMSMessage.php';
require_once 'Zend/Http/Client.php';
class Twilio_Resource_SMSMessageTest extends PHPUnit_Framework_TestCase
{
	public function testUriString()
	{
		$twilio = new Twilio_Client('accountSid', 'authToken'); 
		$sms = new Twilio_Resource_SMSMessage('sid');
		$this->assertEquals('Accounts/accountSid/SMS/Messages/sid', (string) $sms);
	}
	
	public function testDefaultClient()
	{
		$twilio = $this->getMock('Twilio_Client', array(),  array('sid', 'token'));
		$sms = new Twilio_Resource_SMSMessage();
		$this->assertEquals($twilio, $sms->getTwilioClient());
	}
	
    public function testNoDefaultSid()
    {
        $twilio = new Twilio_Client('accountSid', 'authToken'); 
        $sms = new Twilio_Resource_SMSMessage();
        
        $this->assertEquals(null, $sms->getSid());
    }
	
    public function testGetMessage()
    {
        $twilio = $this->getMock('Twilio_Client', array('get'),  array('AC5ef872f6da5a21de157d80997a64bd33', 'token'));
        
        $sms = new Twilio_Resource_SMSMessage('SM800f449d0399ed014aae2bcc0cc2f2ec');
        $sms->setTwilioClient($twilio);
        
        //setup sample response
        $data = file_get_contents('Twilio/Resource/SMSMessage.xml');
        $response = new Zend_Http_Response(200, array(), $data);
        $xml = simplexml_load_string($data);
        
        $twilio->expects($this->once())
               ->method('get')
               //->with($this->equalTo($account)) //not sure how to get this to work
               ->will($this->returnValue($response));

        $xml = $xml->SMSMessage;
               
        $this->assertEquals((string) $xml->Sid, $sms->sid);
        $this->assertEquals((string) $xml->AccountSid, $sms->accountSid);
        $this->assertEquals((string) $xml->DateSent, $sms->dateSent);
        $this->assertEquals((string) $xml->Status, $sms->status);
        
        $this->assertEquals((string) $xml->DateCreated, $sms->dateCreated);
        $this->assertEquals((string) $xml->DateUpdated, $sms->dateUpdated);

        $this->assertEquals((string) $xml->To, $sms->to);
        $this->assertEquals((string) $xml->From, $sms->from);
        $this->assertEquals((string) $xml->Body, $sms->body);
        $this->assertEquals((string) $xml->Direction, $sms->direction);
        $this->assertEquals((string) $xml->Price, $sms->price);
    }
}