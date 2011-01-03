<?php
require_once 'Twilio/Resource/List/ListAbstract.php';
require_once 'Twilio/Resource/Transcription.php';
class Twilio_Resource_List_Transcriptions extends Twilio_Resource_List_ListAbstract
{
    protected $listName = 'Transcriptions';
    protected $resourceName = 'Transcription';
    protected $resourceClass = 'Twilio_Resource_Transcription';
    
    protected $recording;
    
    public function __toString()
    {
        $uri = 'Accounts/'.$this->getAccountSid();
        
        if(isset($this->recording)){
            $uri .= '/Recordings/' . $this->getRecording()->sid;
        }
        return $uri.'/Transcriptions' . $this->getQuery();
    }
    
    public function transcription($sid){
        $transcription = new Twilio_Resource_Transcription($sid);
        $transcription->setAccountSid($this->getAccountSid());
        return $transcription;
    }
    
    public function setRecording(Twilio_Resource_Recording $recording)
    {
        $this->recording = $recording;
        $this->setAccountSid($recording->getAccountSid());
    }
    
    public function getRecording()
    {
        return $this->recording;
    }
}