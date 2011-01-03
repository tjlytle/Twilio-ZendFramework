<?php 
require_once 'Twilio/Resource/Sid.php';
/**
 * Conference Resource
 * 
 * @author tjlytle
 */
class Twilio_Resource_Conference extends Twilio_Resource_Sid
{
	protected $participants;
	
    public function __toString()
    {
        return 'Accounts/' . $this->getAccountSid() . '/Conferences/' . $this->getSid();
    }
    
    public function getConferenceParticipants()
    {
    	if(empty($this->participants)){
            $this->participants = new Twilio_Resource_List_Participants();
    	}
    	
    	return $this->participants;
    }
}