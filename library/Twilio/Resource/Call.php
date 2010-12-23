<?php 
require_once 'Twilio/Resource/Sid.php';
/**
 * Call Resource
 * 
 * @author tjlytle
 */
class Twilio_Resource_Call extends Twilio_Resource_Sid
{
    public function __toString()
    {
        return 'Accounts/' . $this->getAccountSid() . '/Calls/' . $this->getSid();
    }
}