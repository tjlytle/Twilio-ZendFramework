<?php
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../library'));
require_once 'auth.php'; //Define Twilio Credentials
require_once 'Twilio/Client.php';

//setup client
$twilio = new Twilio_Client(ACCOUNT_SID, ACCOUNT_TOKEN);

//get calls using default account 
$calls = $twilio->accounts->account()->calls;

//pagination is automatic, would iterate through all calls
echo "All calls" . PHP_EOL;
foreach($calls as $sid => $call){ 
    echo " {$sid} {$call->startTime}, {$call->from} -> {$call->to}: {$call->duration} [page: " . $calls->getXml()->Calls['page'] . "]" . PHP_EOL;
    break;
}

//using manual paging
echo "First 10 calls" . PHP_EOL;
$calls->setPage(0, 10); //first page of 10 calls;
foreach($calls as $sid => $call){ 
    echo " {$sid} {$call->startTime}, {$call->from} -> {$call->to}: {$call->duration} [page: " . $calls->getXml()->Calls['page'] . "]" . PHP_EOL;
}

echo "Next 10 calls" . PHP_EOL;
$calls->setPage(1); //next page, using same page size
foreach($calls as $sid => $call){ 
    echo " {$sid} {$call->startTime}, {$call->from} -> {$call->to}: {$call->duration} [page: " . $calls->getXml()->Calls['page'] . "]" . PHP_EOL;
}

//get a single call
echo "Getting call sid: " . CALL_SID . PHP_EOL;
$call = $twilio->accounts->account()->calls->call(CALL_SID);
echo " {$call->sid} {$call->startTime}, {$call->from} -> {$call->to}: {$call->duration}" . PHP_EOL;

//get call's recordings
echo "Getting recordings" . PHP_EOL;
foreach($call->recordings as $sid => $recording){
	echo (string) $recording . PHP_EOL; //URI of recording
	//get transcriptions
	foreach($recording->transcriptions as $sid => $transcription){
		echo $transcription->transcriptionText . PHP_EOL;
	}
}

//get call's notifications
echo "Getting notifications" . PHP_EOL;
foreach($call->notifications as $sid => $notification){
    echo $notification->messageText . PHP_EOL; //notification message
}