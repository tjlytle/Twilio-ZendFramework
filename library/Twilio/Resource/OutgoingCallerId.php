<?php 
require_once 'Twilio/Resource/Sid.php';
/**
 * OutgoingCallerId Resource
 * 
 * @author tjlytle
 */
class Twilio_Resource_OutgoingCallerId extends Twilio_Resource_Sid
{
    protected $accountSid;
    
    public function __toString()
    {
        return 'Accounts/' . $this->getAccountSid() . '/OutgoingCallerId/' . $this->getSid();
    }
}