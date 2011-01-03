<?php
require_once 'Twilio/Client.php';
require_once 'Twilio/Resource/OutgoingCallerId.php';
require_once 'Zend/Http/Client.php';
class Twilio_Resource_OutgoingCallerIdTest extends PHPUnit_Framework_TestCase
{
	public function testUriString()
	{
		$twilio = new Twilio_Client('accountSid', 'authToken');
		$sid = 'PNe905d7e6b410746a0fb08c57e5a186f3'; 
		$number = new Twilio_Resource_OutgoingCallerId($sid);
		$this->assertEquals('Accounts/accountSid/OutgoingCallerId/' . $sid, (string) $number, 'Incorrect Resource URI');
	}
	
	public function testDefaultClient()
	{
		$twilio = $this->getMock('Twilio_Client', array(),  array('sid', 'token'));
		$number = new Twilio_Resource_OutgoingCallerId();
		$this->assertEquals($twilio, $number->getTwilioClient());
	}
	
    public function testNoDefaultSid()
    {
        $twilio = new Twilio_Client('accountSid', 'authToken'); 
        $number = new Twilio_Resource_OutgoingCallerId();
        
        $this->assertEquals(null, $number->getSid());
    }
	
    public function testGetNumber()
    {
        $twilio = $this->getMock('Twilio_Client', array('get'),  array('AC228ba7a5fe4238be081ea6f3c44186f3', 'token'));
        
        $number = new Twilio_Resource_OutgoingCallerId('PNe905d7e6b410746a0fb08c57e5a186f3');
        $number->setTwilioClient($twilio);
        
        //setup sample response
        $data = file_get_contents('Twilio/Resource/OutgoingCallerId.xml');
        $response = new Zend_Http_Response(200, array(), $data);
        $xml = simplexml_load_string($data);
        
        $twilio->expects($this->once())
               ->method('get')
               //->with($this->equalTo($account)) //not sure how to get this to work
               ->will($this->returnValue($response));
        
        $xml = $xml->OutgoingCallerId;
               
        $this->assertEquals((string) $xml->Sid, $number->sid);
        $this->assertEquals((string) $xml->AccountSid, $number->accountSid);
        $this->assertEquals((string) $xml->FriendlyName, $number->friendlyName);
        $this->assertEquals((string) $xml->PhoneNumber, $number->phoneNumber);
        
        $this->assertEquals((string) $xml->DateCreated, $number->dateCreated);
        $this->assertEquals((string) $xml->DateUpdated, $number->dateUpdated);
   }
}