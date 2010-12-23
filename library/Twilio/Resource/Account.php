<?php 
require_once 'Twilio/Resource/Sid.php';
/**
 * Account Resource - uses the accountSid from Twilio_Client if it's not set.
 * 
 * @author tjlytle
 */
class Twilio_Resource_Account extends Twilio_Resource_Sid
{
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
}