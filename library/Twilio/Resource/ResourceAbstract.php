<?php
/**
 * Abstract resource object for interacting with REST and XML data.
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
            $this->xml = simplexml_load_string($response->getBody());
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