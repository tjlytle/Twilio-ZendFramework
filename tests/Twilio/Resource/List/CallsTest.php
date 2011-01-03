<?php
require_once 'Twilio/Client.php';
require_once 'Twilio/Resource/List/Calls.php';
require_once 'Zend/Http/Client.php';
class Twilio_Resource_List_CallsTest extends PHPUnit_Framework_TestCase
{
    public function testUriString()
    {
        $calls = new Twilio_Resource_List_Calls();
        $calls->setAccountSid('sid');
        $this->assertEquals('Accounts/sid/Calls', (string) $calls);
    }
	
    public function testGetSingleCall()
    {
        $calls = new Twilio_Resource_List_Calls();
        $call = $calls->call('sid');
        $this->assertEquals('sid', $call->sid);
    }
	
	public function testSimpleIteration()
	{
		//XML has no next page URI, only testing iteration
		$xml = simplexml_load_file('Twilio/Resource/List/Calls2.xml');
		$calls = new Twilio_Resource_List_Calls();
		$calls->setXml($xml);
		
		foreach($calls as $index => $call){
			$this->assertEquals($index, $call->sid);
		}
	}
	
	public function testSimpleLoad()
	{
		$calls = new Twilio_Resource_List_Calls();
        
		$twilio = $this->getMock('Twilio_Client', array('get'),  array('sid', 'token'));

		$xml = simplexml_load_file('Twilio/Resource/List/Calls.xml');
		$response = new Zend_Http_Response(200, array(), $xml);

        $twilio->expects($this->at(0))
               ->method('get')
               ->with($this->equalTo('Accounts/sid/Calls'))
               ->will($this->returnValue($response));

        $xml2 = simplexml_load_file('Twilio/Resource/List/Calls2.xml');
        $response2 = new Zend_Http_Response(200, array(), $xml2);

        $twilio->expects($this->at(1))
               ->method('get')
               ->with($this->equalTo((string)$xml->Calls['nextpageuri']))
               ->will($this->returnValue($response));
               
        $twilio->expects($this->exactly(2))
               ->method('get');
               
        $calls = new Twilio_Resource_List_Calls();
        $calls->setTwilioClient($twilio);
        
        foreach($calls as $index => $call){
            $this->assertEquals($index, $call->sid);
        }
    }
	
	public function testCount()
	{
        $xml = simplexml_load_file('Twilio/Resource/List/Calls2.xml');
        $calls = new Twilio_Resource_List_Calls();
        $calls->setXml($xml);
		
		$this->assertEquals((int) $xml->Calls['total'], count($calls));
	}
	
	public function testManualPaging()
	{
		$calls = new Twilio_Resource_List_Calls();
        $twilio = $this->getMock('Twilio_Client', array('get'),  array('sid', 'token'));

        $xml = simplexml_load_file('Twilio/Resource/List/Calls.xml');
        $response = new Zend_Http_Response(200, array(), $xml);

        $twilio->expects($this->at(0))
               ->method('get')
               ->with($this->equalTo('Accounts/sid/Calls?page=1&pagesize=50'))
               ->will($this->returnValue($response));

               
        $twilio->expects($this->at(1))
               ->method('get')
               ->with($this->equalTo('Accounts/sid/Calls?page=3&pagesize=50'))
               ->will($this->returnValue($response));
        
        $this->assertEquals($calls, $calls->setPage(1, 50), 'Function not fluent');
        
        foreach($calls as $call){
            break;
        }
        
        $this->assertEquals($calls, $calls->setPage(3), 'Function not fluent');
        
        foreach($calls as $call){
            break;
        }
        
        
    }
}
