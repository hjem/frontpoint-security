<?php

use Hjem\FrontpointSecurity\Client;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    public function testHistory() {
    	$client = new Client(getenv('FRONTPOINT_USERNAME'), getenv('FRONTPOINT_PASSWORD'));
    	$items = $client->getHistory();
    }
}
