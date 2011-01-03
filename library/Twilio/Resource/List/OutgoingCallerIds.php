<?php
require_once 'Twilio/Resource/List/ListAbstract.php';
require_once 'Twilio/Resource/OutgoingCallerId.php';
class Twilio_Resource_List_OutgoingCallerIds extends Twilio_Resource_List_ListAbstract
{
    protected $listName = 'OutgoingCallerIds';
    protected $resourceName = 'OutgoingCallerId';
    protected $resourceClass = 'Twilio_Resource_OutgoingCallerId';
    
    public function __toString()
    {
        return 'Accounts/'.$this->getAccountSid().'/OutgoingCallerIds' . $this->getQuery();
    }
    
    public function outgoingCallerId($sid){
        $id = new Twilio_Resource_OutgoingCallerId($sid);
        $id->setAccountSid($this->getAccountSid());
        return $id;
    }
}