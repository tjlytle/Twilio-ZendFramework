<?php
require_once 'Twilio/Resource/List/ListAbstract.php';
require_once 'Twilio/Resource/Conference.php';
class Twilio_Resource_List_Conferences extends Twilio_Resource_List_ListAbstract
{
    protected $listName = 'Conferences';
    protected $resourceName = 'Conference';
    protected $resourceClass = 'Twilio_Resource_Conference';
    
    public function __toString()
    {
        return 'Accounts/'.$this->getAccountSid().'/Conferences' . $this->getQuery();
    }
    
    public function conference($sid){
        $conference = new Twilio_Resource_Conference($sid);
        $conference->setAccountSid($this->getAccountSid());
        return $conference;
    }
}