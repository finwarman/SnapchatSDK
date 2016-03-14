<?php

use Snapchat\API\Response\Model\Friend;

require("../src/autoload.php");

$casper = new \Casper\Developer\CasperDeveloperAPI("api_key", "api_secret");
$snapchat = new \Snapchat\Snapchat($casper);

try {

    //Login
    $snapchat->login("username", "password");

    $friendRequests = $snapchat->getFriendRequests();
    foreach($friendRequests as $friendRequest){

        $friendType = $friendRequest->getType();

        //Your Privacy settings are Friends Only
        if($friendType == Friend::TYPE_PENDING){
            echo sprintf("%s wants to add you as a friend!\n", $friendRequest->getName());
        }

        //Your Privacy settings are Everyone
        if($friendType == Friend::TYPE_FOLLOWING){
            echo sprintf("%s is following you, but you haven't added them back\n", $friendRequest->getName());
        }

    }

} catch(Exception $e){
    //Something went wrong...
    echo $e->getMessage() . "\n";
}