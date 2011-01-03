<?php
require_once 'Twilio/Client.php';
require_once 'Zend/Http/Client.php';
class Twilio_ClientTest extends PHPUnit_Framework_TestCase
{
	public function testSetDefaultClient()
	{
		$twilio = new Twilio_Client('sid', 'token');
		$this->assertEquals($twilio, Twilio_Client::getDefaultClient());
	}
	
	public function testGetSid()
	{
        $twilio = new Twilio_Client('sid', 'token');
        $this->assertEquals('sid', $twilio->getAccountSid());
	}
	
    /**
     * @expectedException PHPUnit_Framework_Error
     */
	public function testSetBadHttpClient()
	{
        $twilio = new Twilio_Client('sid', 'token');
        $twilio->setHttpClient(new stdClass());
	}
	
	public function testSetGoodHttpClient()
	{
        $twilio = new Twilio_Client('sid', 'token');
		$client = new Zend_Http_Client();
        $twilio->setHttpClient($client);
        $this->assertEquals($client, $twilio->getHttpClient());
	}
	
	public function testHttpClientAuth()
	{
		$twilio = new Twilio_Client('sid', 'token');
		
		$client = $this->getMock('Zend_Http_Client', array('setAuth'));
        $client->expects($this->once())
               ->method('setAuth')
               ->with($this->equalTo('sid'), $this->equalTo('token'));

		$twilio->setHttpClient($client);
	}
	
	public function testDefaultHttpClient()
	{
        $twilio = new Twilio_Client('sid', 'token');
        $client = $twilio->getHttpClient();
        $this->assertType('Zend_Http_Client', $client);
	}
	
	public function testUriConstruction()
	{
		$twilio = new Twilio_Client('sid', 'token');

        $client = $this->getMock('Zend_Http_Client', array('setUri', 'request'));
        $client->expects($this->once())
               ->method('setUri')
               ->with($this->equalTo('https://api.twilio.com/2010-04-01/resource_string'));

        $http_response = new Zend_Http_Response(200, array(), 'test');

        $client->expects($this->once())
               ->method('request')
               ->with($this->equalTo(Zend_Http_Client::GET))
               ->will($this->returnValue($http_response));
               
        $twilio->setHttpClient($client);
        $twilio->get('resource_string');
	}
	
	public function testGet()
	{
        $twilio = new Twilio_Client('sid', 'token');
        $http_response = new Zend_Http_Response(200, array(), 'test');

        $client = $this->getMock('Zend_Http_Client', array('setUri', 'request'));
        $client->expects($this->once())
               ->method('request')
               ->with($this->equalTo(Zend_Http_Client::GET))
               ->will($this->returnValue($http_response));

        $twilio->setHttpClient($client);
        $this->assertEquals($http_response, $twilio->get('resource_string'));
	}
	
	public function testGetAllowsFullURI()
	{
        $twilio = new Twilio_Client('sid', 'token');
        $uri = '/2010-04-01/resource_string';
        $http_response = new Zend_Http_Response(200, array(), 'test');

        $client = $this->getMock('Zend_Http_Client', array('setUri', 'request'));
        $client->expects($this->once())
               ->method('setUri')
               ->with('https://api.twilio.com' . $uri)
               ->will($this->returnValue($http_response));
               
        $client->expects($this->once())
               ->method('request')
               ->with($this->equalTo(Zend_Http_Client::GET))
               ->will($this->returnValue($http_response));
               
        $twilio->setHttpClient($client);
        $this->assertEquals($http_response, $twilio->get($uri));		
	}
}