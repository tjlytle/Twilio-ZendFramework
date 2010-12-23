<?php
/**
 * Abstract Resource - object for storing XML data.
 * TODO: Support JSON as well.
 * 
 * @author tjlytle
 */
class Twilio_Resource_ResourceAbstract
{
    protected $xml; //data from twilio

    public function __get($name)
    {
        $method = 'get' . ucfirst($name);
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
    
    /**
     * Twilio Client used for REST 
     * @var Twilio_Client
     */
    protected $client;
    
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
    
    protected function getXml()
    {
        if(is_null($this->xml)){
            $response  = $this->getTwilioClient()->get($this);
            $this->setXml($response->getBody());
        }
        return $this->xml;
    }
    
    protected function setXml($xml)
    {
        if(is_string($xml)){
            $xml = simplexml_load_string($xml);
        }
        $this->xml = $xml;
    }
}