<?php 
require_once 'Twilio/Resource/Sid.php';
/**
 * Notification Resource
 * 
 * @author tjlytle
 */
class Twilio_Resource_Notification extends Twilio_Resource_Sid
{
    public function __toString()
    {
        return 'Accounts/' . $this->getAccountSid() . '/Notifications/' . $this->getSid();
    }
}