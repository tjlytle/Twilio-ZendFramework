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
    
    /**
     * Allows sid to be set only once, and if the XML is not already loaded.
     * 
     * @param string $sid
     * @throws Twilio_Resource_Exception
     */
    public function setSid($sid)
    {
        if(!empty($this->sid) OR !empty($this->xml)){
            require_once 'Twilio/Resource/Exception.php';
            throw new Twilio_Resource_Exception('SID can only be sent once, before data is loaded');
        }
        
        $this->sid = $sid;
        return $this;
    }
    
    /**
     * Returns the sid
     * 
     * @return string
     */
    public function getSid()
    {
        if(empty($this->xml) AND empty($this->sid)){
        	require_once 'Twilio/Resource/Exception.php';
        	return null;
        } elseif (!empty($this->sid)){
        	return $this->sid;
        }
        return (string) $this->getXml()->Sid;
    }
    
    /**
     * Allows sid to be accessed without loading XML data, allow access to 
     * resource data as properties. Using format get[Type][Property]
     * 
     * 'status' on a call resource would check getCallStatus()
     * 
     * @see Twilio/Resource/Twilio_Resource_ResourceAbstract::__get()
     */
    public function __get($name)
    {
        //special case for sid - perhaps force using getSid()
        if('sid' == $name){
            return $this->getSid();
        }

        $return = parent::__get($name);
        if(!is_null($return)){
            return $return;
        }

        $property = ucfirst($name);
        if(isset($this->getXml()->{$this->getType()}->$property)){
            return (string) $this->getXml()->{$this->getType()}->$property;
        }

    }
}
