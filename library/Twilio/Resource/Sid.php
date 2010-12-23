<?php
require_once 'Twilio/Resource/ResourceAbstract.php';

/**
 * Common Sid based resources (everything but available-phone-numbers and 
 * sandbox)
 * 
 * @author tjlytle
 */
class Twilio_Resource_Sid extends Twilio_Resource_ResourceAbstract
{
    protected $sid; //write once property, used to fetch data (if needed)

    /**
     * Created the resource, optionally setting a sid or the XML data (when 
     * constructed by a resource list).
     * 
     * @param string $sid
     */
    public function __construct($sid = null)
    {
        if(!empty($sid)){
            if(is_string($sid)){
                $this->setSid($sid);    
            } else {
                $this->setXml($sid);
            }
        }
    }
    
    public function setSid($sid)
    {
        if(!empty($this->sid) OR !empty($this->xml)){
            require_once 'Twilio/Resource/Exception.php';
            throw new Twilio_Resource_Exception('SID can only be sent once, before data is loaded');
        }
        
        $this->sid = $sid;
    }
    
    public function getSid()
    {
        if(empty($this->xml)){
            if(empty($this->sid)){
                $this->setSid($this->getTwilioClient()->getAccountSid());
            }
            return $this->sid;
        }
        return (string) $this->getXml()->Account->Sid;
    }
    
    public function getDateCreated()
    {
        return (string) $this->getXml()->Account->DateCreated;
    }
    
    public function getDateUpdated()
    {
        return (string) $this->getXml()->Account->DateUpdated;
    }
}