<?php
require_once 'Twilio/Client.php';
require_once 'Twilio/Resource/Call.php';
require_once 'Zend/Http/Client.php';
class Twilio_Resource_CallTest extends PHPUnit_Framework_TestCase
{
	public function testUriString()
	{
		$twilio = new Twilio_Client('accountSid', 'authToken'); 
		$call = new Twilio_Resource_Call('sid');
		$this->assertEquals('Accounts/accountSid/Calls/sid', (string) $call);
	}
	
	public function testDefaultClient()
	{
		$twilio = $this->getMock('Twilio_Client', array(),  array('sid', 'token'));
		$call = new Twilio_Resource_Call();
		$this->assertEquals($twilio, $call->getTwilioClient());
	}
	
    /**
     * @expectedException Twilio_Resource_Exception
     */
    public function testNoDefaultSid()
    {
        $twilio = new Twilio_Client('accountSid', 'authToken'); 
        $call = new Twilio_Resource_Call();
        $call->getSid();
    }
	
	
    public function testGetCall()
    {
        $twilio = $this->getMock('Twilio_Client', array('get'),  array('AC5ef872f6da5a21de157d80997a64bd33', 'token'));
        
        $call = new Twilio_Resource_Call('CAe1644a7eed5088b159577c5802d8be38');
        $call->setTwilioClient($twilio);
        
        //setup sample response
        $xml = "<TwilioResponse>
    <Call>
        <Sid>CAe1644a7eed5088b159577c5802d8be38</Sid>
        <DateCreated>Tue, 10 Aug 2010 08:02:17 +0000</DateCreated>
        <DateUpdated>Tue, 10 Aug 2010 08:02:47 +0000</DateUpdated>
        <ParentCallSid/>
        <AccountSid>AC5ef872f6da5a21de157d80997a64bd33</AccountSid>
        <To>+14153855708</To>
        <From>+14158141819</From>
        <PhoneNumberSid></PhoneNumberSid>
        <Status>completed</Status>
        <StartTime>Tue, 10 Aug 2010 08:02:31 +0000</StartTime>
        <EndTime>Tue, 10 Aug 2010 08:02:47 +0000</EndTime>
        <Duration>16</Duration>
        <Price>-0.03000</Price>
        <Direction>outbound-api</Direction>
        <AnsweredBy/>
        <ApiVersion>2008-08-01</ApiVersion>
        <ForwardedFrom/>
        <CallerName/>
        <Uri>/2010-04-01/Accounts/AC5ef872f6da5a21de157d80997a64bd33/Calls/CAe1644a7eed5088b159577c5802d8be38</Uri>
        <SubresourceUris>
            <Notifications>/2010-04-01/Accounts/AC5ef872f6da5a21de157d80997a64bd33/Calls/CAe1644a7eed5088b159577c5802d8be38/Notifications</Notifications>
            <Recordings>/2010-04-01/Accounts/AC5ef872f6da5a21de157d80997a64bd33/Calls/CAe1644a7eed5088b159577c5802d8be38/Recordings</Recordings>
        </SubresourceUris>
    </Call>
</TwilioResponse>";
        
        $response = new Zend_Http_Response(200, array(), $xml);
        
        $twilio->expects($this->once())
               ->method('get')
               //->with($this->equalTo($account)) //not sure how to get this to work
               ->will($this->returnValue($response));
        
        $this->assertEquals('CAe1644a7eed5088b159577c5802d8be38', $call->sid);
        $this->assertEquals('Tue, 10 Aug 2010 08:02:17 +0000', $call->dateCreated);
        $this->assertEquals('Tue, 10 Aug 2010 08:02:47 +0000', $call->dateUpdated);
        
        $this->assertEquals('', $call->parentCallSid);
        $this->assertEquals('AC5ef872f6da5a21de157d80997a64bd33', $call->accountSid);
        $this->assertEquals('+14153855708', $call->to);
        $this->assertEquals('+14158141819', $call->from);
        $this->assertEquals('', $call->phoneNumberSid);
        $this->assertEquals('completed', $call->status);
        $this->assertEquals('Tue, 10 Aug 2010 08:02:31 +0000', $call->startTime);
        $this->assertEquals('Tue, 10 Aug 2010 08:02:47 +0000', $call->endTime);
        $this->assertEquals('16', $call->duration);
        $this->assertEquals('-0.03000', $call->price);
        $this->assertEquals('outbound-api', $call->direction);
        $this->assertEquals('', $call->answeredBy);
        $this->assertEquals('', $call->forwardedFrom);
        $this->assertEquals('', $call->callerName);
        
        $this->assertEquals('completed', $call->status);
    }
}