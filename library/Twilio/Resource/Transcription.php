<?php 
require_once 'Twilio/Resource/Sid.php';

/**
 * Transcription Resource
 * 
 * @author tjlytle
 */
class Twilio_Resource_Transcription extends Twilio_Resource_Sid
{
	protected $recording;
	
    public function __toString()
    {
        return 'Accounts/' . $this->getAccountSid() . '/Transcriptions/' . $this->getSid();
    }
    
    public function getRecording()
    {
    	if(empty($this->recording)){
    		require_once 'Twilio/Resource/Recording.php';
    		$this->recording = new Twilio_Resource_Recording($this->recordingSid);
    		$this->recording->setAccountSid($this->getAccountSid());
    	}
    	
    	return $this->recording;
    }

}