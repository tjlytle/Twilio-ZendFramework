<?php
require_once 'Twilio/Resource/List/ListAbstract.php';
require_once 'Twilio/Resource/IncomingPhoneNumber.php';
class Twilio_Resource_List_IncomingPhoneNumbers extends Twilio_Resource_List_ListAbstract
{
    protected $listName = 'IncomingPhoneNumbers';
    protected $resourceName = 'IncomingPhoneNumber';
    protected $resourceClass = 'Twilio_Resource_IncomingPhoneNumber';
    
    public function __toString()
    {
        return 'Accounts/'.$this->getAccountSid().'/IncomingPhoneNumbers' . $this->getQuery();
    }
    
    public function incomingPhoneNumber($sid){
        $number = new Twilio_Resource_IncomingPhoneNumber($sid);
        $number->setAccountSid($this->getAccountSid());
        return $number;
    }
}