<?php
require_once 'Twilio/Resource/List/ListAbstract.php';
require_once 'Twilio/Resource/Recording.php';
class Twilio_Resource_List_Recordings extends Twilio_Resource_List_ListAbstract
{
    protected $listName = 'Recordings';
    protected $resourceName = 'Recording';
    protected $resourceClass = 'Twilio_Resource_Recording';
	
    protected $call;
    
    public function __toString()
    {
    	$uri = 'Accounts/'.$this->getAccountSid();
    	
    	if(isset($this->call)){
    		$uri .= '/Calls/' . $this->getCall()->sid;
    	}
        return $uri.'/Recordings' . $this->getQuery();
    }
    
	public function recording($sid){
		//TODO: Make sure accountSid inherits from this object
		$recording = new Twilio_Resource_Recording($sid);
		$recording->setAccountSid($this->getAccountSid()); 
		return $recording;
	}
	
	public function setCall(Twilio_Resource_Call $call)
	{
		$this->call = $call;
		$this->setAccountSid($call->getAccountSid());
	}
	
	public function getCall()
	{
		return $this->call;
	}
}