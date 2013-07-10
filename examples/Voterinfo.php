<?php
require_once '../src/Client.php';

try {
    $client = new GoolgeCivic('YOUR API KEY');
    $result = $client->setAddr('300 West Adams, Chicago IL')
        ->getVoterInfo(4000,true);
} catch (Exception $e) {
    echo $e->getMessage();
}
print_r($result);