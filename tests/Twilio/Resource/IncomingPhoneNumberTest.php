<?php
require_once 'Twilio/Client.php';
require_once 'Twilio/Resource/IncomingPhoneNumber.php';
require_once 'Zend/Http/Client.php';
class Twilio_Resource_IncomingPhoneNumberTest extends PHPUnit_Framework_TestCase
{
	public function testUriString()
	{
		$twilio = new Twilio_Client('accountSid', 'authToken'); 
		$number = new Twilio_Resource_IncomingPhoneNumber('sid');
		$this->assertEquals('Accounts/accountSid/IncomingPhoneNumbers/sid', (string) $number);
	}
	
	public function testDefaultClient()
	{
		$twilio = $this->getMock('Twilio_Client', array(),  array('sid', 'token'));
		$number = new Twilio_Resource_IncomingPhoneNumber();
		$this->assertEquals($twilio, $number->getTwilioClient());
	}
	
    /**
     * @expectedException Twilio_Resource_Exception
     */
    public function testNoDefaultSid()
    {
        $twilio = new Twilio_Client('accountSid', 'authToken'); 
        $number = new Twilio_Resource_IncomingPhoneNumber();
        $number->getSid();
    }
	
    public function testGetNumber()
    {
        $twilio = $this->getMock('Twilio_Client', array('get'),  array('ACdc5f1e11047ebd6fe7a55f120be3a900', 'token'));
        
        $number = new Twilio_Resource_IncomingPhoneNumber('PN2a0747eba6abf96b7e3c3ff0b4530f6e');
        $number->setTwilioClient($twilio);
        
        //setup sample response
        $xml = "<TwilioResponse>
    <IncomingPhoneNumber>
        <Sid>PN2a0747eba6abf96b7e3c3ff0b4530f6e</Sid>
        <AccountSid>ACdc5f1e11047ebd6fe7a55f120be3a900</AccountSid>
        <FriendlyName>My Company Line</FriendlyName>
        <PhoneNumber>+15105647903</PhoneNumber>
        <VoiceUrl>http://mycompany.com/handleNewCall.php</VoiceUrl>
        <VoiceMethod>POST</VoiceMethod>
        <VoiceFallbackUrl/>
        <VoiceFallbackMethod>POST</VoiceFallbackMethod>
        <VoiceCallerIdLookup>false</VoiceCallerIdLookup>
        <DateCreated>Mon, 16 Aug 2010 23:00:23 +0000</DateCreated>
        <DateUpdated>Mon, 16 Aug 2010 23:00:23 +0000</DateUpdated>
        <SmsUrl/>
        <SmsMethod>POST</SmsMethod>
        <SmsFallbackUrl/>
        <SmsFallbackMethod>GET</SmsFallbackMethod>
        <Capabilities>
            <Voice>true</Voice>
            <SMS>true</SMS>
        </Capabilities>
        <StatusCallback/>
        <StatusCallbackMethod/>
        <ApiVersion>2010-04-01</ApiVersion>
        <Uri>/2010-04-01/Accounts/ACdc5f1e11047ebd6fe7a55f120be3a900/IncomingPhoneNumbers/PN2a0747eba6abf96b7e3c3ff0b4530f6e</Uri>
    </IncomingPhoneNumber>
</TwilioResponse>";
        
        $response = new Zend_Http_Response(200, array(), $xml);
        
        $twilio->expects($this->once())
               ->method('get')
               //->with($this->equalTo($account)) //not sure how to get this to work
               ->will($this->returnValue($response));
        
        $this->assertEquals('PN2a0747eba6abf96b7e3c3ff0b4530f6e', $number->sid);
        $this->assertEquals('ACdc5f1e11047ebd6fe7a55f120be3a900', $number->accountSid);
        $this->assertEquals('My Company Line', $number->friendlyName);
        $this->assertEquals('+15105647903', $number->phoneNumber);
        
        $this->assertEquals('http://mycompany.com/handleNewCall.php', $number->voiceUrl);
        $this->assertEquals('POST', $number->voiceMethod);
        $this->assertEquals('', $number->voiceFallbackUrl);
        $this->assertEquals('POST', $number->voiceFallbackMethod);
        
        $this->assertEquals('false', $number->voiceCallerIdLookup);
        
        $this->assertEquals('Mon, 16 Aug 2010 23:00:23 +0000', $number->dateCreated);
        $this->assertEquals('Mon, 16 Aug 2010 23:00:23 +0000', $number->dateUpdated);
        
        $this->assertEquals('', $number->smsUrl);
        $this->assertEquals('POST', $number->smsMethod);
        $this->assertEquals('', $number->smsFallbackUrl);
        $this->assertEquals('GET', $number->smsFallbackMethod);
        
        $this->assertEquals('', $number->statusCallback);
        $this->assertEquals('', $number->statusCallbackMethod);
   }
}