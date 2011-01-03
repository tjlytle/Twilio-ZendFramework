<?php 
require_once 'Twilio/Resource/Sid.php';
/**
 * Account Resource - uses the accountSid from Twilio_Client if it's not set.
 * 
 * @author tjlytle
 */
class Twilio_Resource_Account extends Twilio_Resource_Sid
{
	protected $calls;
	protected $outgoingCallerIds;
	protected $incomingPhoneNumbers;
	
    public function __toString()
    {
        return 'Accounts/' . $this->getSid();
    }
    
    //Defaults to client's accountSid by default 
    public function getSid()
    {
        if(empty($this->xml) AND empty($this->sid)){
            $this->setSid($this->getTwilioClient()->getAccountSid());
        }
        return parent::getSid();
    }
    
    public function getAccountCalls()
    {
    	if(empty($this->calls)){
    		require_once 'Twilio/Resource/List/Calls.php';
    		$this->calls = new Twilio_Resource_List_Calls();
    		$this->calls->setAccountSid($this->getSid());
    	}
    	return $this->calls;
    }

    public function getAccountIncomingPhoneNumbers()
    {
        if(empty($this->incomingPhoneNumbers)){
            require_once 'Twilio/Resource/List/IncomingPhoneNumbers.php';
            $this->incomingPhoneNumbers = new Twilio_Resource_List_IncomingPhoneNumbers();
            $this->incomingPhoneNumbers->setAccountSid($this->getSid());
        }
        return $this->incomingPhoneNumbers;
    }
    
    public function getAccountOutgoingCallerIds()
    {
        if(empty($this->outgoingCallerIds)){
            require_once 'Twilio/Resource/List/OutgoingCallerIds.php';
            $this->outgoingCallerIds = new Twilio_Resource_List_OutgoingCallerIds();
            $this->outgoingCallerIds->setAccountSid($this->getSid());
        }
        return $this->outgoingCallerIds;
    }
}