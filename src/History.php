<?php

namespace Hjem\FrontpointSecurity;

use SimpleHtmlDom\simple_html_dom as SimpleHtmlDom;

class History
{
	private $guzzle;

    public function __construct($guzzle) {
    	$this->guzzle = $guzzle;
    }

    public function arm() {

    }

    public function getRecent() {
        return $this->parsePage('/web/History/EventHistory.aspx');
    }

    private function parsePage($path) {
        $entries = [];

    	$response = $this->guzzle->get(Client::BASE_URL . $path);

    	$dom = new SimpleHtmlDom($response->getBody());
    	$rows = $dom->find('table[id=ctl00_phBody_acdgEventHistory] tr');

    	foreach ($rows as $row) {
    		$columns = $row->find('td');

    		if (count($columns) === 3) {
	    		$entries[] = $this->parseRow($columns);
	    	}
    	}

        return $entries;
    }

    private function parseRow($columns) {
        $historyEntry = new HistoryEntry();
        $historyEntry->setDevice(trim($columns[0]->plaintext));
        $historyEntry->setEvent(trim($columns[1]->plaintext));
        $historyEntry->setDatetime(trim($columns[2]->plaintext));

        return $historyEntry;
    }
}
