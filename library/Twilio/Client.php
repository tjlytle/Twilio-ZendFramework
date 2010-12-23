<?php
/**
 * Twilio HTTP Client 
 * 
 * @author tjlytle
 *
 */
class Twilio_Client
{
    protected $client;
    protected $authToken;
    protected $accountSid;
    protected $apiVersion = '2010-04-01';
    protected $apiUrl = 'https://api.twilio.com';
	
    protected static $defaultClient;
    
    public static function setDefaultClient(Twilio_Client $client)
    {
    	self::$defaultClient = $client;
    }
    
    public static function getDefaultClient()
    {
    	return self::$defaultClient;
    }
    
    public function __construct($accountSid, $authToken, $checkCredentials = false, $setDefault = true)
    {
        $this->accountSid = $accountSid;
        $this->authToken = $authToken;

        if($checkCredentials){
            if(!$this->checkCredentials()){
            	throw new Exception('Credentials Invalid');
            }
        }
        
        if($setDefault){
        	self::setDefaultClient($this);
        }
    }
	
    public function getAccountSid()
    {
    	return $this->accountSid;
    }
    
	protected function checkCredentials()
	{
		$account = new Twilio_Account();
		$account->setClient($this);
		
		return $account->sid == $this->accountSid; 
	}
	
	/**
	 * @return Zend_Http_Client
	 */
	public function getHttpClient()
	{
		if(empty($this->client)){
			require_once 'Zend/Http/Client.php';
			$client = new Zend_Http_Client();
			$this->setHttpClient($client);
		}
		return $this->client;
	}
	
	public function setHttpClient(Zend_Http_Client $client)
	{
		$client->setAuth($this->accountSid, $this->authToken, Zend_Http_Client::AUTH_BASIC);
		$this->client = $client;
	}
	
	/**
	 * @param string $uri
	 * @return Zend_Http_Response
	 */
	public function get($uri)
	{
		$uri = (string) $uri;
		$this->getHttpClient()->setUri($this->apiUrl.'/'.$this->apiVersion.'/'.$uri);
		
		$response = $this->getHttpClient()->request(Zend_Http_Client::GET);
		if($response->isError()){
            require_once 'Twilio/Resource/Exception.php';
            throw new Twilio_Resource_Exception('Bad HTTP status: ' . $response->getStatus());
        }

		return $response;
	}
}