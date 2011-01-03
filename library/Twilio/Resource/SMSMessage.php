<?php 
require_once 'Twilio/Resource/Sid.php';
/**
 * SMSMessage Resource
 * 
 * @author tjlytle
 */
class Twilio_Resource_SMSMessage extends Twilio_Resource_Sid
{
    public function __toString()
    {
        return 'Accounts/' . $this->getAccountSid() . '/SMS/Messages/' . $this->getSid();
    }

}