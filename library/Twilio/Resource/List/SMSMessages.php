<?php
require_once 'Twilio/Resource/List/ListAbstract.php';
require_once 'Twilio/Resource/Conference.php';
class Twilio_Resource_List_SMSMessages extends Twilio_Resource_List_ListAbstract
{
    protected $listName = 'SMSMessages';
    protected $resourceName = 'SMSMessage';
    protected $resourceClass = 'Twilio_Resource_SMSMessage';
    
    public function __toString()
    {
        return 'Accounts/'.$this->getAccountSid().'/SMS/Messages' . $this->getQuery();
    }
    
    public function smsMessage($sid){
        $message = new Twilio_Resource_SMSMessage($sid);
        $message->setAccountSid($this->getAccountSid());
        return $message;
    }
}