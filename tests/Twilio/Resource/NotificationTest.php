<?php
require_once 'Twilio/Client.php';
require_once 'Twilio/Resource/Notification.php';
require_once 'Zend/Http/Client.php';
class Twilio_Resource_NotificationTest extends PHPUnit_Framework_TestCase
{
	public function testUriString()
	{
		$twilio = new Twilio_Client('accountSid', 'authToken'); 
		$notification = new Twilio_Resource_Notification('sid');
		$this->assertEquals('Accounts/accountSid/Notifications/sid', (string) $notification);
	}
	
	public function testDefaultClient()
	{
		$twilio = $this->getMock('Twilio_Client', array(),  array('sid', 'token'));
		$notification = new Twilio_Resource_Notification();
		$this->assertEquals($twilio, $notification->getTwilioClient());
	}
	
    public function testNoDefaultSid()
    {
        $twilio = new Twilio_Client('accountSid', 'authToken'); 
        $notification = new Twilio_Resource_Notification();
        
        $this->assertEquals(null, $notification->getSid());
    }
	
    public function testGetData()
    {
        $twilio = $this->getMock('Twilio_Client', array('get'),  array('ACda6f1e11047ebd6fe7a55f120be3a900', 'token'));
        
        $notification = new Twilio_Resource_Notification('NO5a7a84730f529f0a76b3e30c01315d1a');
        $notification->setTwilioClient($twilio);
        
        //setup sample response
        $data = file_get_contents('Twilio/Resource/Notification.xml');
        $response = new Zend_Http_Response(200, array(), $data);
        $xml = simplexml_load_string($data);
        
        $twilio->expects($this->once())
               ->method('get')
               //->with($this->equalTo($account)) //not sure how to get this to work
               ->will($this->returnValue($response));

        $xml = $xml->Notification;
               
        $this->assertEquals((string) $xml->Sid, $notification->sid);
        $this->assertEquals((string) $xml->AccountSid, $notification->accountSid);
        $this->assertEquals((string) $xml->DateUpdated, $notification->dateUpdated);
    }
}