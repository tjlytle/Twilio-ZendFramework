# Twilio Client for Zend Framework
-----------------------------
Zend Framework based client for the [Twilio][1] API. Still in the first stages
of development. Expect things to change. The example code should remain
relatively stable, but there are no guarantees.

[1]: http://twilio.com/

# Status
-----------------------------
Currently all Sid based resources (all but AvailablePhoneNumbers/Sandbox) can be
accessed using the client. Resource Lists cannot be filtered, existing 
resources cannot be updated, and new resources cannot be added. 

# Example
-----------------------------
There are more complete examples in the examples directory, but the basic usage
is:

    //setup client
    $twilio = new Twilio_Client(ACCOUNT_SID, ACCOUNT_TOKEN);
    
    //get account information
    echo 'Account: ' . $twilio->accounts->account(ACCOUNT_SID)->friendlyName;
    
    //get call
    $call = $twilio->accounts->account()->calls->call(CALL_SID);


# License
-----------------------------
See [LICENSE](http://github.com/tjlytle/Twilio-ZendFramework/blob/master/LICENSE).
