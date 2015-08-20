<?php

namespace Hjem\FrontpointSecurity;

use SimpleHtmlDom\simple_html_dom as SimpleHtmlDom;
use GuzzleHttp\Client as GuzzleClient;

class Client
{
	const BASE_URL = 'https://www.myfrontpoint.com';
	const USER_AGENT = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.95 Safari/537.36';

	private $username;
	private $password;
	private $guzzle;
	private $isLoggedIn = false;

    public function __construct($username, $password) {
    	$this->username = $username;
    	$this->password = $password;
    	$this->guzzle = new GuzzleClient([
    		'cookies' => true,
    		'headers' => [
    			'User-Agent' => self::USER_AGENT
    		]
    	]);
    }

    public function arm() {

    }

    public function getHistory() {
    	$this->ensureLoggedIn();

    	$history = new History($this->guzzle);
    	return $history->getRecent();
    }

    private function ensureLoggedIn() {
    	if ($this->isLoggedIn) {
    		return;
    	}

    	$fields = $this->getLoginFields();

    	$response = $this->guzzle->post(self::BASE_URL . '/web/Default.aspx', [
		    'form_params' => $fields
		]);

		if (strpos($response->getBody(), 'Current System Status') !== FALSE) {
			$this->isLoggedIn = true;
		}
    }

    private function getLoginFields() {
    	$fields = [];

    	$response = $this->guzzle->get(self::BASE_URL);

    	$dom = new SimpleHtmlDom($response->getBody());
    	$form = $dom->find('form[id=loginForm]', 0);

    	foreach ($form->find('input') as $input) {
    		$fields[$input->name] = $input->value;
    	}

    	$fields['txtUserName'] = $this->username;
    	$fields['txtPassword'] = $this->password;

    	$fields['JavaScriptTest'] = 1;
    	$fields['cookieTest'] = 1;

    	return $fields;
    }

}
