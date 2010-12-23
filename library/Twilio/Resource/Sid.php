<?php
require_once 'Twilio/Resource/ResourceAbstract.php';
/**
 * Sid Resource - base for resources identified by a Sid (everything but 
 * available-phone-numbers and sandbox)
 * 
 * @author tjlytle
 */
class Twilio_Resource_Sid extends Twilio_Resource_ResourceAbstract
{
    protected $accountSid; //write once property, defaults to client's accountSid
    protected $sid; //write once property, used to fetch resource
    protected $parentTag; //tag data is wrapped in
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
        if(empty($this->xml) AND empty($this->sid)){
        	require_once 'Twilio/Resource/Exception.php';
        	throw new Twilio_Resource_Exception('Sid not set');
            return $this->sid;
        } elseif (!empty($this->sid)){
        	return $this->sid;
        }
        return (string) $this->getXml()->Sid;
    }
    
    public function getAccountSid()
    {
        if(empty($this->accountSid)){
            $this->setAccountSid($this->getTwilioClient()->getAccountSid());
        }
        return $this->accountSid;
    }
    
    //TODO: Make settable only once
    public function setAccountSid($sid)
    {
        $this->accountSid = $sid;
    }
    
    //used to determine top leve XML element
    public function getParentTag()
    {
    	if(empty($this->parentTag)){
    		$parts = explode('_', get_class($this));
    		$this->setParentTag(ucfirst(end($parts)));
    	}
    	return $this->parentTag;
    }
    
    public function setParentTag($tag)
    {
    	$this->parentTag = $tag;
    }
    
    public function setXml($xml)
    {
    	parent::setXml($xml);
    	if(isset($this->xml->{$this->getParentTag()})){
    	   $this->xml = $this->xml->{$this->getParentTag()};
    	}
    }
}