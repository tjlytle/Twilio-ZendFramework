<?php
require_once 'Twilio/Resource/List/ListAbstract.php';
require_once 'Twilio/Resource/Notification.php';
class Twilio_Resource_List_Notifications extends Twilio_Resource_List_ListAbstract
{
    protected $listName = 'Notifications';
    protected $resourceName = 'Notification';
    protected $resourceClass = 'Twilio_Resource_Notification';
    
    protected $call;
    
    public function __toString()
    {
        $uri = 'Accounts/'.$this->getAccountSid();
        
        if(isset($this->call)){
            $uri .= '/Calls/' . $this->getCall()->sid;
        }
        return $uri.'/Notifications' . $this->getQuery();
    }
    
    public function current() {
        return new $this->resourceClass((string) $this->getXml()->{$this->listName}->{$this->resourceName}[$this->position - (int) $this->getXml()->{$this->listName}['start']]->Sid);
    }
    
    public function notification($sid){
        $notification = new Twilio_Resource_Notification($sid);
        $notification->setAccountSid($this->getAccountSid());
        return $notification;
    }
    
    public function setCall(Twilio_Resource_Call $call)
    {
        $this->call = $call;
        $this->setAccountSid($call->getAccountSid());
    }
    
    public function getCall()
    {
        return $this->call;
    }
}