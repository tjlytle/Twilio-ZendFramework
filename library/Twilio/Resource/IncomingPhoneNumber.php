<?php 
require_once 'Twilio/Resource/Sid.php';
/**
 * IncomingPhoneNumber Resource
 * 
 * @author tjlytle
 */
class Twilio_Resource_IncomingPhoneNumber extends Twilio_Resource_Sid
{
    protected $accountSid;
    
    public function __toString()
    {
        return 'Accounts/' . $this->getAccountSid() . '/IncomingPhoneNumbers/' . $this->getSid();
    }
    
    public function getAccountSid()
    {
        if(empty($this->accountSid)){
            $this->setAccountSid($this->getTwilioClient()->getAccountSid());
        }
        return $this->accountSid;
    }
    
    public function setAccountSid($sid)
    {
        $this->accountSid = $sid;
    }
}