<?php
require_once 'Twilio/Resource/List/ListAbstract.php';
require_once 'Twilio/Resource/Account.php';
class Twilio_Resource_List_Accounts extends Twilio_Resource_List_ListAbstract
{
    protected $listName = 'Accounts';
    protected $resourceName = 'Account';
    protected $resourceClass = 'Twilio_Resource_Account';
	
    public function __toString()
    {
        return 'Accounts';
    }
	
	public function account($sid = null){
		if(is_null($sid)){
			$sid = $this->getTwilioClient()->getAccountSid();
		}
		
		return new Twilio_Resource_Account($sid);
	}
	
}