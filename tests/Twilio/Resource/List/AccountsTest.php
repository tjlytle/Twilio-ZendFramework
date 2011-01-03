<?php
require_once 'Twilio/Client.php';
require_once 'Twilio/Resource/List/Accounts.php';
require_once 'Zend/Http/Client.php';
class Twilio_Resource_List_AccountsTest extends PHPUnit_Framework_TestCase
{
    public function testUriString()
    {
        $accounts = new Twilio_Resource_List_Accounts();
        $this->assertEquals('Accounts', (string) $accounts);
    }
	
	public function testGetSingleAccount()
	{
		$accounts = new Twilio_Resource_List_Accounts();
		$account = $accounts->account('sid');
		$this->assertEquals('sid', $account->sid);
	}
	
	public function testDefaultAccountSid()
	{
        $twilio = new Twilio_Client('sid', 'token');
		$accounts = new Twilio_Resource_List_Accounts();
        $account = $accounts->account();
        $this->assertEquals('sid', $account->sid);
	}
	
	public function testSimpleIteration()
	{
		$xml = simplexml_load_file('Twilio/Resource/List/Accounts.xml');
		$accounts = new Twilio_Resource_List_Accounts();
		$accounts->setXml($xml);
		
		foreach($accounts as $index => $account){
			$this->assertEquals($index, $account->sid);
		}
	}
}