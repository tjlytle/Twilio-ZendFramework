<?php
require_once 'Twilio/Client.php';
require_once 'Twilio/Resource/Account.php';
require_once 'Zend/Http/Client.php';
class Twilio_Resource_AccountTest extends PHPUnit_Framework_TestCase
{
	public function testUriString()
	{
		$account = new Twilio_Resource_Account('sid');
		$this->assertEquals('Accounts/sid', (string) $account);
	}
	
	public function testDefaultClient()
	{
		$twilio = $this->getMock('Twilio_Client', array(),  array('sid', 'token'));
		$account = new Twilio_Resource_Account();
		$this->assertEquals($twilio, $account->getTwilioClient());
	}
	
    public function testDefaultSid()
    {
        $twilio = $this->getMock('Twilio_Client', array('getAccountSid'),  array('sid', 'token'));
        $twilio->expects($this->once())
               ->method('getAccountSid')
               ->will($this->returnValue('sid'));
        
        $account = new Twilio_Resource_Account();
        $this->assertEquals('sid', $account->getSid());
    }
	
    public function testGetAccount()
    {
        $twilio = $this->getMock('Twilio_Client', array('get'),  array('sid', 'token'));
        $account = new Twilio_Resource_Account('ACba8bc05eacf94afdae398e642c9cc32d');
        $account->setTwilioClient($twilio);
        
        //setup sample response
        $xml = "<TwilioResponse>
    <Account>
        <Sid>ACba8bc05eacf94afdae398e642c9cc32d</Sid>
        <FriendlyName>Do you like my friendly name?</FriendlyName>
        <Status>Active</Status>
        <DateCreated>Wed, 04 Aug 2010 21:37:41 +0000</DateCreated>
        <DateUpdated>Fri, 06 Aug 2010 01:15:02 +0000</DateUpdated>
        <AuthToken>redacted</AuthToken>
        <Uri>/2010-04-01/Accounts/ACba8bc05eacf94afdae398e642c9cc32d</Uri>
        <SubresourceUris>
            <AvailablePhoneNumbers>/2010-04-01/Accounts/ACba8bc05eacf94afdae398e642c9cc32d/AvailablePhoneNumbers</AvailablePhoneNumbers>
            <Calls>/2010-04-01/Accounts/ACba8bc05eacf94afdae398e642c9cc32d/Calls</Calls>
            <Conferences>/2010-04-01/Accounts/ACba8bc05eacf94afdae398e642c9cc32d/Conferences</Conferences>
            <IncomingPhoneNumbers>/2010-04-01/Accounts/ACba8bc05eacf94afdae398e642c9cc32d/IncomingPhoneNumbers</IncomingPhoneNumbers>
            <Notifications>/2010-04-01/Accounts/ACba8bc05eacf94afdae398e642c9cc32d/Notifications</Notifications>
            <OutgoingCallerIds>/2010-04-01/Accounts/ACba8bc05eacf94afdae398e642c9cc32d/OutgoingCallerIds</OutgoingCallerIds>
            <Recordings>/2010-04-01/Accounts/ACba8bc05eacf94afdae398e642c9cc32d/Recordings</Recordings>
            <Sandbox>/2010-04-01/Accounts/ACba8bc05eacf94afdae398e642c9cc32d/Sandbox</Sandbox>
            <SMSMessages>/2010-04-01/Accounts/ACba8bc05eacf94afdae398e642c9cc32d/SMS/Messages</SMSMessages>
            <Transcriptions>/2010-04-01/Accounts/ACba8bc05eacf94afdae398e642c9cc32d/Transcriptions</Transcriptions>
        </SubresourceUris>
    </Account>
</TwilioResponse>";
        
        $response = new Zend_Http_Response(200, array(), $xml);
        
        $twilio->expects($this->once())
               ->method('get')
               //->with($this->equalTo($account)) //not sure how to get this to work
               ->will($this->returnValue($response));
        
        $this->assertEquals('ACba8bc05eacf94afdae398e642c9cc32d', $account->sid);
        $this->assertEquals('Do you like my friendly name?', $account->friendlyName);
        $this->assertEquals('Active', $account->status);
        $this->assertEquals('Wed, 04 Aug 2010 21:37:41 +0000', $account->dateCreated);
        $this->assertEquals('Fri, 06 Aug 2010 01:15:02 +0000', $account->dateUpdated);
        $this->assertEquals('redacted', $account->authToken);
    }
}