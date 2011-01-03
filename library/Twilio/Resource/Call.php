<?php 
require_once 'Twilio/Resource/Sid.php';
/**
 * Call Resource
 * 
 * @author tjlytle
 */
class Twilio_Resource_Call extends Twilio_Resource_Sid
{
	protected $recordings;
	protected $notifications;
	
    public function __toString()
    {
        return 'Accounts/' . $this->getAccountSid() . '/Calls/' . $this->getSid();
    }
    
    public function getCallRecordings()
    {
    	if(empty($this->recordings)){
    		require_once 'Twilio/Resource/List/Recordings.php';
            $this->recordings = new Twilio_Resource_List_Recordings();
            $this->recordings->setCall($this);	
    	}
    	
    	return $this->recordings;
    }
    
    public function getCallNotifications()
    {
        if(empty($this->notifications)){
            require_once 'Twilio/Resource/List/Notifications.php';
            $this->notifications = new Twilio_Resource_List_Notifications();
            $this->notifications->setCall($this);   
        }
        
        return $this->notifications;
    }
}