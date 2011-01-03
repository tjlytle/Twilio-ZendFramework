<?php 
require_once 'Twilio/Resource/Sid.php';
/**
 * Call Resource
 * 
 * @author tjlytle
 */
class Twilio_Resource_Recording extends Twilio_Resource_Sid
{
	protected $transcriptions;
	
    public function __toString()
    {
        return 'Accounts/' . $this->getAccountSid() . '/Recordings/' . $this->getSid();
    }
    
    public function getRecordingTranscriptions()
    {
        if(empty($this->transcriptions)){
            require_once 'Twilio/Resource/List/Transcriptions.php';
            $this->transcriptions = new Twilio_Resource_List_Transcriptions();
            $this->transcriptions->setRecording($this);
        }
        return $this->transcriptions;
    }
}