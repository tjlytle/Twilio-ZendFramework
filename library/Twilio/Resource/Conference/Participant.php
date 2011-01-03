<?php 
require_once 'Twilio/Resource/Sid.php';
/**
 * Participant Resource
 * 
 * @author tjlytle
 */
class Twilio_Resource_Conference_Participant extends Twilio_Resource_Sid
{
    protected $call;
    protected $conference;

    public function __construct($sid, Twilio_Resource_Conference $conference)
    {
        parent::__construct($sid);
        $this->conference = $conference;
    }

    public function setConference(Twilio_Resource_Conference $conference)
    {
        $this->conference = $conference;
    }

    public function getConference()
    {
        return $this->conference;
    }

    public function __toString()
    {
        return 'Accounts/' . $this->getAccountSid() . '/Conferences/' . $this->getConference()->getSid() . '/Participants/' . $this->getSid();
    }
    
    public function getCall()
    {
        if(empty($this->call)){
            $this->call = new Twilio_Resource_Call($this->sid);
        }
        
        return $this->call;
    }
}