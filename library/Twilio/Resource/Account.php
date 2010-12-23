<?php 
require_once 'Twilio/Resource/Sid.php';
/**
 * Account resource
 * 
 * @author tjlytle
 */
class Twilio_Resource_Account extends Twilio_Resource_Sid
{
    public function getFriendlyName()
    {
    	return (string) $this->getXml()->Account->FriendlyName;
    }
    
    public function getStatus()
    {
    	return (string) $this->getXml()->Account->Status;
    }
    
    public function getAuthToken()
    {
    	return (string) $this->getXml()->Account->AuthToken;
    }
    
    public function __toString()
    {
    	return 'Accounts/' . $this->getSid();
    }
}