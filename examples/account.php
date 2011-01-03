<?php
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../library'));
require_once 'Twilio/Client.php';
require_once 'auth.php';

//setup client
$twilio = new Twilio_Client(ACCOUNT_SID, ACCOUNT_TOKEN);

//get account information
echo 'Account: ' . $twilio->accounts->account(ACCOUNT_SID)->friendlyName . PHP_EOL;

//account sid can be ommited, defaults to the client's account sid
echo 'Type: ' . $twilio->accounts->account(ACCOUNT_SID)->type . PHP_EOL;

//get all caller ids
//pagination is automatic, will iterate through all numbers
echo "All Caller IDs" . PHP_EOL;
foreach($twilio->accounts->account()->outgoingCallerIds as $sid => $callerId){
    echo "{$sid} {$callerId->phoneNumber} [{$callerId->friendlyName}]" . PHP_EOL;
}

//get all incomming phone numbers (automatic pagination)
echo "All Phone Numbers" . PHP_EOL;
foreach($twilio->accounts->account()->incomingPhoneNumbers as $sid => $number){
	echo "{$sid} {$number->phoneNumber} -> {$number->voiceUrl}" . PHP_EOL;
}
