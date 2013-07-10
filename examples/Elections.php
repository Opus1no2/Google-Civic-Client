<?php
require_once '../src/Client.php';

try {
    $client = new GoolgeCivic('YOUR API KEY');
    $result = $client->getElections();
} catch (Exception $e) {
    echo $e->getMessage();
}
print_r($result);