<?php
require_once 'Twilio/Resource/List/ListAbstract.php';
require_once 'Twilio/Resource/Call.php';
class Twilio_Resource_List_Calls extends Twilio_Resource_List_ListAbstract
{
    protected $listName = 'Calls';
    protected $resourceName = 'Call';
    protected $resourceClass = 'Twilio_Resource_Call';
	
    public function __toString()
    {
    	//TODO: Make sure accounSid is inherited
        return 'Accounts/'.$this->getAccountSid().'/Calls' . $this->getQuery();
    }
	
	public function call($sid){
		$call =  new Twilio_Resource_Call($sid);
		$call->setAccountSid($this->getAccountSid());
		return $call;
	}
}