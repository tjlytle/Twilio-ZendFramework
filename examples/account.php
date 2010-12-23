<?php
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../library'));
require_once 'Twilio/Client.php';
require_once 'Twilio/Resource/Account.php';
require_once 'auth.php';


//Full Setup
$twilio = new Twilio_Client(ACCOUNT_SID, ACCOUNT_TOKEN);
$account = new Twilio_Resource_Account(ACCOUNT_SID);
$account->setTwilioClient($twilio);
echo $account->friendlyName . PHP_EOL;

//Using Default Client
$twilio = new Twilio_Client(ACCOUNT_SID, ACCOUNT_TOKEN);
$account = new Twilio_Resource_Account(ACCOUNT_SID);
echo $account->friendlyName . PHP_EOL;

exit;
$account = $twilio->accounts->account(); //accountSid optional
$account = $twilio->getResource('account', $accountSid);

$call = $account->calls->call();

$call = new Twilio_Resource_Call($callSid);
$call = $twilio->calls->call(); //use $twilio->accounts->account()->calls->call();
$call = $twilio->getResource('call', $callSid);
$call = $twilio->get()->calls->call($callSid);
        
$calls = new Twilio_Resource_List_Calls();
$calls = $twilio->calls; //use $twilio->accounts->account()->calls;
$call = $twilio->getResourceList('calls');
$call = $twilio->get()->calls;

