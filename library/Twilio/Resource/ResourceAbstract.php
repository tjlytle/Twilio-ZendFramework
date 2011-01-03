<?php
/**
 * Abstract Resource - object for storing XML data.
 * TODO: Support JSON as well.
 * 
 * @author tjlytle
 */
class Twilio_Resource_ResourceAbstract
{
    /**
     * Twilio Client used for REST 
     * @var Twilio_Client
     */
    protected $client;
    
    /**
     * Resource XML from Twilio
     * @var SimpleXMLElement
     */
	protected $xml; //data from twilio

    /**
     * Returns the resource type (Account/Call/Recording/etc).
     * 
     * @return string
     */
    public function getType()
    {
    	$class = get_class($this);
    	$parts = explode('_', $class);
    	return end($parts); 
    }
    
    /**
     * Allow access to resource data as properties. Using format 
     * get[Property]
     * 
     * @param string $name
     */
    public function __get($name)
    {
    	//TODO: Update to get[ResourceName][Property]
        $method = 'get' . ucfirst($this->getType()) . ucfirst($name);
        if(method_exists($this, $method)){
            return $this->$method();
        }
        
        //allow access to any undefined properties as long as they exsist, not
        //sure if it would be better to force get functions for all properties
        $property = ucfirst($name);
        if(isset($this->getXml()->$property)){
        	return (string) $this->getXml()->$property;
        }
    }
    
    public function setTwilioClient(Twilio_Client $client)
    {
        $this->client = $client;
    }
    
    /**
     * @return Twilio_Client
     */
    public function getTwilioClient()
    {
        if(empty($this->client)){
            $this->setTwilioClient(Twilio_Client::getDefaultClient());
        }
        return $this->client;
    }
    
    /**
     * Returns Twilio's XML response for the resource. If the XML has not been
     * loaded, it is requested from the Twilio_Client.
     * 
     * @return SimpleXMLElement
     */
    public function getXml()
    {
        if(is_null($this->xml)){
            //casting as string to make unit testing easier (for now)
            $response  = $this->getTwilioClient()->get((string) $this);
            $this->setXml($response->getBody());
        }
        return $this->xml;
    }
    
    /**
     * Sets Twilio's XML response for the resource. If a string is passed it is
     * loaded using simplexml_load_string. Returns the resource for a fluent 
     * interface.
     * 
     * @param SimpleXMLElement | string $xml
     * @return Twilio_Resource_ResourceAbstract
     */
    public function setXml($xml)
    {
        if(is_string($xml)){
            $xml = simplexml_load_string($xml);
        }
        $this->xml = $xml;
        
        return $this;
    }
    
    /**
     * Returns the AccountSid for the resource, defaults to the Twilio_Cleint's
     * AccountSid if none has been set.
     * 
     * @return string
     */
    public function getAccountSid()
    {
        if(empty($this->accountSid)){
            $this->setAccountSid($this->getTwilioClient()->getAccountSid());
        }
        return $this->accountSid;
    }
    
    /**
     * Sets the AccountSid for the resource. Returns the resource for a fluent 
     * interface. 
     * 
     * TODO: Make settable only once
     * 
     * @param unknown_type $sid
     */
    public function setAccountSid($sid)
    {
        $this->accountSid = $sid;
        
        return $this;
    }
    
    /**
     * TODO: Allow fluent access to resource data setters. Function format same
     * as __get() and __set(): set[ResourceName][Property]
     * 
     * @param string $name
     * @param array $params
     */
    public function __call($name, $params)
    {
        require_once 'Twilio/Resource/Exception.php';
        throw new Twilio_Resource_Exception("Method: $name is not defined");
    }
}
